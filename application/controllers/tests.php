<?php
class Tests extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function checkLogin() {
		if(UserHelper::loggedIn()->id == 0) {
			redirect('users/signup');
		}
	}
	
	public function checkTest() {
		$testId	=	$this->session->userdata('testMode');
		if(!empty($testId)) {
			redirect('tests/questions/'.$testId);
		}
	}
	
	public function showReport($id)
	{
		$this->checkLogin();
		$test		=	TestItem::factory($id);
		$pages		=	PageItem::factory()->getAll();
		$tests		=	TestItem::factory()->getAll();
		
		$userTests	=	UserTestItem::factory()->getByTestId($id);
		SeoHelper::setTitle('Отчет по Тесту - '. $test->name);
		
		$this->layout->view('tests/report', array(
												'userTests' => $userTests, 
												'test'  => $test, 
												'pages' => $pages, 	
												'tests' => $tests,
												'pageFlag' => true,
											));
	}
	
	public function show($id) {
		$this->checkLogin();
		$this->checkTest();
		$test		=	TestItem::factory($id);
		
		$pages		=	PageItem::factory()->getByThemeId($test->themeId);
		$tests		=	TestItem::factory()->getByThemeId($test->themeId);
		SeoHelper::setTitle('Тест - '. $test->name);
		$this->layout->view('tests/start', array(
												'pages' => $pages, 
												'tests' => $tests, 
												'test'  => $test, 
												'pageFlag' => true,
											));
	}
	
	public function start($id) {
		$this->checkLogin();
		$test		=	TestItem::factory($id);
		
		if($test->id > 0) {
			$userTest	=	UserTestItem::factory();
			$userTest->userId	=	UserHelper::loggedIn()->id;
			$userTest->testId	=	$test->id;
			$userTest->save();
			
			$this->session->set_userdata('testMode', $userTest->id);
			redirect('tests/questions/'. $userTest->id);
		} else {
			redirect('tests/show/'. $id);
		}
	}
	
	public function questions($userTestId, $questionId = 0) {
		$userTest	=	UserTestItem::factory($userTestId);
		$test		=	$userTest->getTest();
		if($userTest->completed == 0) {
			
			$questions	=	$test->getQuestions();
			if($questionId == 0) {
				$questionId	=	$questions[0]->id;
			}
			
			$question	=	QuestionItem::factory($questionId);
			$question->text	=	insertImage($question->text);
			$test		=	$userTest->getTest();
			
			$questions	=	$test->getQuestions();
			$questionsCount	=	count($questions);
			$questionNumber	=	1;
			foreach ($questions as $key=>$item){
				if($item->id == $question->id) {
					$questionNumber	=	$key+1;
					break;					
				}
			}
			
			$answers	=	$question->getAnswers();
			$userAnswer	=	UserAnswerItem::factory();
			$userAnswer->user_testId	=	$userTest->id;
			$userAnswer->questionId		=	$question->id;
			$userAnswer		=	$userAnswer->getByTestAndQuestion();
			SeoHelper::setTitle('Тест - '. $test->name);
			
			$this->layout->view('tests/question', array(
													'question'			=>	$question,
													'answers'			=>	$answers,
													'questions'			=>	$questions,
													'userTest'			=>	$userTest,
													'userAnswer'		=>	$userAnswer,
													'questionNumber'	=>	$questionNumber,
													'questionsCount'	=>	$questionsCount,
												));
		
		} else {
			redirect('tests/show/'. $test->id);
		}
	}
	
	public function saveAnswer() {
		if(!empty($_POST)) {
			$userAnswer	=	UserAnswerItem::factory();
			$userAnswer->apply($_POST);
			$userAnswer	=	$userAnswer->getByTestAndQuestion();
			$userAnswer->save();
			
			$question	=	QuestionItem::factory($userAnswer->questionId);
			$userTest	=	UserTestItem::factory($userAnswer->user_testId);
			$next		=	$question->getNext();
			if($next) {
				redirect('tests/questions/'.$userTest->id.'/'.$next->id);
			} else {
				$userTest->completed	=	1;
				$userTest->save();
				$this->session->unset_userdata('testMode');
				redirect('tests/finish/'.$userTest->id);
			}
		}
	}
	
	public function finish($userTestId = 0) {
		$userTest	=	UserTestItem::factory($userTestId);
		
		$result		=	$userTest->calculateResult();
		$test		=	$userTest->getTest();
		
		$questions	=	$test->getQuestions();
		
		$pages		=	PageItem::factory()->getAll();
		$tests		=	TestItem::factory()->getAll();
		SeoHelper::setTitle('Тест - '. $test->name .' закончен');
		$this->layout->view('tests/finish', array(
												'pages' => $pages, 
												'tests' => $tests, 
												'test'  => $test, 
												'pageFlag' => true,
												'result' => $result,
												'questions' => $questions,
												'userTest' => $userTest,
											));
	}
	
	public function create() {
		if(!empty($_POST)) {
			$test	=	TestItem::factory();
			$test->apply($_POST);
			$test->save();
			redirect('tests/edit/'. $test->id);
		}
		
		SeoHelper::setTitle('Создание Теста');
		$this->layout->view('tests/create');
	}
	
	public function edit($id) {
		$test		=	TestItem::factory($id);
		if(!empty($_POST)) {
			$test->apply($_POST);
			$test->save();
		}
		$questions	=	$test->getQuestions();
		
		SeoHelper::setTitle('Редактирование Теста - "'. $test->name .'"');
		$this->layout->view('tests/edit', array('test' => $test, 'questions' => $questions));
	}
	
	public function createquestion($testId = 0) {
		if(!empty($_POST)) {
			$question	=	QuestionItem::factory();
			$question->apply($_POST);
			$question->save();
			redirect('tests/editquestion/'. $question->id);
		}
		
		$test		=	TestItem::factory($testId);
		
		SeoHelper::setTitle('Создание Вопроса');
		$this->layout->view('tests/createquestion', array('test' => $test));
	}
	
	public function editquestion($id) {
		$question		=	QuestionItem::factory($id);
		if(!empty($_POST)) {
			$question->apply($_POST);
			$question->save();
		}
		
		$answers	=	$question->getAnswers();
		
		SeoHelper::setTitle('Редактирование вопроса "'. $question->text .'"');
		$this->layout->view('tests/editquestion', array('question' => $question, 'answers' => $answers));
	}
	
	public function createAnswer($questionId = 0) {
		if(!empty($_POST)) {
			$answer	=	AnswerItem::factory();
			$answer->apply($_POST);
			$answer->save();
			redirect('tests/createanswer/'. $answer->questionId);
		}
		
		$question		=	QuestionItem::factory($questionId);
		
		SeoHelper::setTitle('Создание ответа на вопрос - '. $question->text);
		$this->layout->view('tests/createanswer', array('question' => $question));
	}
	
	public function editanswer($id) {
		$answer		=	AnswerItem::factory($id);
		if(!empty($_POST)) {
			$answer->apply($_POST);
			$answer->save();
		}
		
		SeoHelper::setTitle('Редактирование ответа "'. $answer->answer .'"');
		$this->layout->view('tests/editanswer', array('answer' => $answer));
	}
}
?>
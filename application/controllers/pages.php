<?php
class Pages extends CI_Controller {
	
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
	
	public function show($id) {
		$page		=	PageItem::factory($id);
		if(!$page->showDemo) {
			$this->checkLogin();
		}
		$this->checkTest();
		
		
		$page->content	=	preg_replace("/\[::([^::]*)::\]/", "<img src=\"". base_url()."images/formules/\$1\" />", $page->content);
		$page->content	=	str_replace('[----]', 'onclick="javascript: slide(this)" style="cursor: pointer; text-decoration: underline;"', $page->content);
		$theme		=	ThemeItem::factory($page->themeId);
		$subject	=	SubjectItem::factory($theme->subjectId);
		$pages		=	PageItem::factory()->getByThemeId($theme->id);
		$tests		=	TestItem::factory()->getByThemeId($theme->id);
		SeoHelper::setTitle('Предмет - '. $subject->name. '. Тема - '. $theme->name .'. '. $page->name);
		$this->layout->view('pages/page', array(
												'theme' => $theme, 
												'page' => $page, 
												'pages' => $pages, 
												'tests' => $tests, 
												'pageFlag' => true,
											));
	}
	
	public function edit($id) {
		$page		=	PageItem::factory($id);
		if(!empty($_POST)) {
			$page->apply($_POST);
			$page->save();
		}
		SeoHelper::setTitle('Редактирование страницы - "'. $page->name .'"');
		$this->layout->view('pages/edit', array('page' => $page));
	}
}
?>
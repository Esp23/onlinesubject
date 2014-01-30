<?php
class User_test extends CI_Model {
	
	public $table	=	'tuser_tests';
	
	public function __construct() {
		parent::__construct();
	}
	
	public function getAll($object) {
		$result	=	$this->db
							->select()
							->from($this->table)
							->get()
							->result()
							;

		if(!empty($result)) {
			foreach ($result as $key=>$item) {
				$result[$key]	=	UserTestItem::factory()->apply($item);
			}
		} else {
			$result	=	array();
		}
		return $result;
	}
	
	public function getById($object, $id) {
		$result	=	$this->db
							->select()
							->from($this->table)
							->where('id', $id)
							->get()
							->row()
							;
							
		$object->apply($result);
		return $object;
	}
	
	public function getByTestId($object, $id) {
		$result	=	$this->db
							->select()
							->from($this->table)
							->where('testId', $id)
							->get()
							->result()
							;

		if(!empty($result)) {
			foreach ($result as $key=>$item) {
				$result[$key]	=	UserTestItem::factory()->apply($item);
			}
		} else {
			$result	=	array();
		}
		return $result;
	}
	
	public function save($object) {
		$data	=	get_object_vars($object);
		unset($data['id']);
		if($object->id == 0) {
			$data['started_date']	=	date('Y-m-d H:i:s', time());
			$this->db
					->insert($this->table, $data);
			$object->id	=	mysql_insert_id();
		} else {
			$data['completed_date']	=	date('Y-m-d H:i:s', time());
			$this->db
					->where('id', $object->id)
					->update($this->table, $data)
					;
		}
		
		return $object;
	}
	
	public function calculateResult($object) {
		$questions	=	$object->getQuestions();
		$result		=	0;
		foreach ($questions as $item) {
			$answer	=	UserAnswerItem::factory();
			$answer->user_testId	=	$object->id;
			$answer->questionId		=	$item->id;
			$answer					=	$answer->getByTestAndQuestion();
			if($item->answer == $answer->answer) {
				$result	++;
			}
		}
		
		return $result;
	}
	
}

class UserTestItem {
	public $id				=	0;
	public $userId			=	0;
	public $testId			=	0;
	public $completed		=	0;
	public $started_date	=	'';
	public $completed_date	=	'';
	
	public function __construct($id = 0) {
		$this->load($id);
	}
	public static function factory($id = 0) {
		return new UserTestItem($id);
	}
	
	public function load($id = 0) {
		if($id != 0) {
			return $this->getModel()->getById($this, $id);
		} else {
			return $this;
		}
		
	}
	
	public function apply($object)	{
         foreach ($object as $key => $value) {

                 if (property_exists($this, $key)) {
                         if ($key == 'id') {
                                 if ($this->$key === 0)
                                         $this->$key = $value;
                                 else 
                                         throw new Exception('������ �������� ������������� ����� ���� ��� �� ������� ��������. ����������������� ������ �� ����� apply');
                         } else {
                                 $this->$key = $value;
                         }
                 }
         }               
         return $this;
    }
    
    public function getCI() {
    	$ci =& get_instance();
        return $ci;
    }
    
	public function getModel() {
		return $this->getCI()->user_test;
	}
	
	public function save() {
		return $this->getModel()->save($this);
	}
	
	public function getAll() {
		return $this->getModel()->getAll($this);
	}
	
	public function getByTestId($id) {
		return $this->getModel()->getByTestId($this, $id);
	}
	
	public function getQuestions() {
		return QuestionItem::factory()->getByTest($this->testId);
	}
	
	public function getTest() {
		return TestItem::factory($this->testId);
	}
	
	public function getUser() {
		return UserItem::factory()->getById($this->userId);
	}
	
	public function calculateResult() {
		return $this->getModel()->calculateResult($this);
	}
}
?>
<?php
class Question extends CI_Model {
	
	public $table	=	'tquestions';
	
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
				$result[$key]	=	QuestionItem::factory()->apply($item);
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
	
	public function save($object) {
		$data	=	get_object_vars($object);
		unset($data['id']);
		if($object->id == 0) {
			$this->db
					->insert($this->table, $data);
			$object->id	=	mysql_insert_id();
		} else {
			$this->db
					->where('id', $object->id)
					->update($this->table, $data)
					;
		}
		
		return $object;
	}
	
	public function getByTestId($object, $id = 0) {
		$result		=	$this->db
								->select()
								->from($this->table)
								->where('testId', $id)
								->get()
								->result()
								;
								
		foreach ($result as $key=>$item) {
			$result[$key]	=	QuestionItem::factory()->apply($item);
		}
		
		return $result;
	}
	
	public function getNext($object) {
		$test		=	TestItem::factory($object->testId);
		$questions	=	$test->getQuestions();
		

		$next		=	false;
		foreach ($questions as $key=>$item) {
			if($item->id == $object->id && $key != (count($questions) -1) ) {
				$next	=	QuestionItem::factory($questions[$key+1]->id);
			}
		}
		
		return $next;
	}
	
	public function getPrevious($object) {
		$questions	=	$object->getAll();

		$prev		=	false;
		foreach ($questions as $key=>$item) {
			if($item->id == $object->id && $key != 0) {
				$prev	=	QuestionItem::factory($questions[$key-1]->id);
			}
		}
		
		return $prev;
	}
	
}

class QuestionItem {
	public $id				=	0;
	public $testId			=	0;
	public $text			=	'';
	public $type			=	1;
	public $answer			=	'';
	
	public function __construct($id = 0) {
		$this->load($id);
	}
	public static function factory($id = 0) {
		return new QuestionItem($id);
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
		return $this->getCI()->question;
	}
	
	public function save() {
		return $this->getModel()->save($this);
	}
	
	public function getAll() {
		return $this->getModel()->getAll($this);
	}
	
	public function getByTest($id = 0) {
		return $this->getModel()->getByTestId($this, $id);
	}
	
	public function getAnswers() {
		return AnswerItem::factory()->getByQuestion($this->id);
	}
	
	public function getNext() {
		return $this->getModel()->getNext($this);
	}
	
	public function getPrevious() {
		return $this->getModel()->getPrevious($this);
	}
}
?>
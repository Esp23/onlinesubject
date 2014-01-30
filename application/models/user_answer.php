<?php
class User_answer extends CI_Model {
	
	public $table	=	'tusers_answers';
	
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
				$result[$key]	=	$object->apply($item);
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
	
	public function getByTestAndQuestion($object) {
		$row	=	$this->db
							->select()
							->from($this->table)
							->where('user_testId', $object->user_testId)
							->where('questionId', $object->questionId)
							->get()
							->row()
							;
							
		$row	=	UserAnswerItem::factory()->apply($row);
		if($object->answer !== '') {
			$row->answer	=	$object->answer;
		}
		if($row->id > 0) {
			return $row;
		} else {
			return	$object;
		}
	}
	
}

class UserAnswerItem {
	public $id				=	0;
	public $user_testId		=	0;
	public $questionId		=	0;
	public $answer			=	'';
	
	public function __construct($id = 0) {
		$this->load($id);
	}
	public static function factory($id = 0) {
		return new UserAnswerItem($id);
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
		return $this->getCI()->user_answer;
	}
	
	public function save() {
		return $this->getModel()->save($this);
	}
	
	public function getAll() {
		return $this->getModel()->getAll($this);
	}
	
	public function getQuestion() {
		return QuestionItem::factory()->getById($this->questionId);
	}
	
	public function getTest() {
		return UserTestItem::factory()->getById($this->user_testId);
	}
	
	public function getByTestAndQuestion()
	{
		return $this->getModel()->getByTestAndQuestion($this);
	}
}
?>
<?php
class Test extends CI_Model {
	
	public $table	=	'ttests';
	
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
				$result[$key]	=	TestItem::factory()->apply($item);
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
	
	public function getByThemeId($test, $id) {
		$result	=	$this->db
							->select()
							->from($this->table)
							->where('themeId', $id)
							->order_by('id')
							->get()
							->result()
							;
							
		if(!empty($result)) {
			foreach ($result as $key=>$item) {
				$result[$key]	=	TestItem::factory()->apply($item);
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
	
}

class TestItem {
	public $id				=	0;
	public $name			=	'';
	public $description		=	'';
	public $themeId			=	0;
	
	public function __construct($id = 0) {
		$this->load($id);
	}
	public static function factory($id = 0) {
		return new TestItem($id);
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
		return $this->getCI()->test;
	}
	
	public function save() {
		return $this->getModel()->save($this);
	}
	
	public function getAll() {
		return $this->getModel()->getAll($this);
	}
	
	public function getByThemeId($theme) {
		return $this->getModel()->getByThemeId($this, $theme);
	}
	
	public function getQuestions() {
		return QuestionItem::factory()->getByTest($this->id);
	}
}
?>
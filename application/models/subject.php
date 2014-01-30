<?php
class Subject extends CI_Model {
	
	public $table	=	'tsubjects';
	
	public function __construct() {
		parent::__construct();
	}
	
	public function getAll($subject) {
		$result	=	$this->db
							->select('id')
							->select('name')
							->select('alias')
							->from($this->table)
							->get()
							->result()
							;

		if(!empty($result)) {
			foreach ($result as $key=>$item) {
				$result[$key]	=	$subject->apply($item);
			}
		} else {
			$result	=	array();
		}
		return $result;
	}
	
	public function getById($subject, $id) {
		$result	=	$this->db
							->select('id')
							->select('name')
							->select('alias')
							->from($this->table)
							->where('id', $id)
							->get()
							->row()
							;
							
		$subject->apply($result);
		return $subject;
	}
	
	public function save($subject) {
		$data	=	get_object_vars($subject);
		unset($data['id']);
		if($subject->id == 0) {
			$this->db
					->insert($this->table, $data);
			$subject->id	=	mysql_insert_id();
		} else {
			$this->db
					->where('id', $subject->id)
					->update($this->table, $data)
					;
		}
		
		return $subject;
	}
	
}

class SubjectItem {
	public $id				=	0;
	public $name			=	'';
	public $alias			=	'';
	
	public function __construct($id = 0) {
		$this->load($id);
	}
	public static function factory($id = 0) {
		return new SubjectItem($id);
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
                                         throw new Exception('Нельзя изменять идентификатор после того как он получил значение. Распространияется только на метод apply');
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
		return $this->getCI()->subject;
	}
	
	public function save() {
		return $this->getModel()->save($this);
	}
	
	public function getAll() {
		return $this->getModel()->getAll($this);
	}
}
?>
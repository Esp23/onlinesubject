<?php
class Theme extends CI_Model {
	
	public $table	=	'tthemes';
	
	public function __construct() {
		parent::__construct();
	}
	
	public function getAll($theme) {
		$result	=	$this->db
							->select()
							->from($this->table)
							->get()
							->result()
							;

		if(!empty($result)) {
			foreach ($result as $key=>$item) {
				$result[$key]	=	ThemeItem::factory()->apply($item);
			}
		} else {
			$result	=	array();
		}
		return $result;
	}
	
	public function getById($theme, $id) {
		$result	=	$this->db
							->select()
							->from($this->table)
							->where('id', $id)
							->get()
							->row()
							;
							
		$theme->apply($result);
		return $theme;
	}
	
	public function save($theme) {
		$data	=	get_object_vars($theme);
		unset($data['id']);
		if($theme->id == 0) {
			$this->db
					->insert($this->table, $data);
			$theme->id	=	mysql_insert_id();
		} else {
			$this->db
					->where('id', $theme->id)
					->update($this->table, $data)
					;
		}
		
		return $theme;
	}
	
}

class ThemeItem {
	public $id				=	0;
	public $name			=	'';
	public $alias			=	'';
	public $description		=	'';
	public $subjectId		=	0;
	
	public function __construct($id = 0) {
		$this->load($id);
	}
	public static function factory($id = 0) {
		return new ThemeItem($id);
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
		return $this->getCI()->theme;
	}
	
	public function save() {
		return $this->getModel()->save($this);
	}
	
	public function getAll() {
		return $this->getModel()->getAll($this);
	}
}
?>
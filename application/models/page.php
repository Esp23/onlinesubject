<?php
class Page extends CI_Model {
	
	public $table	=	'tpages';
	
	public function __construct() {
		parent::__construct();
	}
	
	public function getAll($page) {
		$result	=	$this->db
							->select()
							->from($this->table)
							->get()
							->result()
							;

		if(!empty($result)) {
			foreach ($result as $key=>$item) {
				$result[$key]	=	PageItem::factory()->apply($item);
			}
		} else {
			$result	=	array();
		}
		return $result;
	}
	
	public function getById($page, $id) {
		$result	=	$this->db
							->select()
							->from($this->table)
							->where('id', $id)
							->get()
							->row()
							;
							
		$page->apply($result);
		return $page;
	}
	
	public function save($page) {
		$data	=	get_object_vars($page);
		unset($data['id']);
		if($page->id == 0) {
			$this->db
					->insert($this->table, $data);
			$page->id	=	mysql_insert_id();
		} else {
			$this->db
					->where('id', $page->id)
					->update($this->table, $data)
					;
		}
		
		return $page;
	}
	
	public function getByThemeId($page, $id) {
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
				$result[$key]	=	PageItem::factory()->apply($item);
			}
		} else {
			$result	=	array();
		}
		return $result;
	}
	
}

class PageItem {
	public $id				=	0;
	public $name			=	'';
	public $alias			=	'';
	public $content		=	'';
	public $themeId		=	0;
	public $parent		=	0;
	public $showDemo		=	0;
	
	public function __construct($id = 0) {
		$this->load($id);
	}
	public static function factory($id = 0) {
		return new PageItem($id);
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
		return $this->getCI()->page;
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
}
?>
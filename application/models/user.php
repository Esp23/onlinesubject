<?php

class User extends CI_Model {
	
	public $table	=	'tusers';
	
	public function getById($user, $id) {
		$result	=	$this->db
							->select('id')
							->select('login')
							->select('firstName')
							->select('lastName')
							->select('city')
							->from($this->table)
							->where('id', $id)
							->get()
							->row()
							;
							
		$user->apply($result);
		return $user;
	}
	
	public function isExists($user) {
		$result	=	$this->db
							->select('COUNT(*) as cnt')
							->from($this->table)
							->where('login', $user->login)
							->get()
							->row()
							;
							
		if(empty($result->cnt)) {
			return false;
		} else {
			if($user->id == 0) {
				return true;
			} else {
				$result	=	$this->db
								->select('COUNT(*)')
								->from($this->table)
								->where('login', $user->login)
								->where('id', $user->id)
								->get()
								->row()
								;
				if(!empty($result)) {
					return false;
				} else {
					return true;
				}
			}
		}
	}
	
	public function save($user) {
		$data	=	get_object_vars($user);
		$data['password']	=	md5($data['password']);
		unset($data['confirmPassword']);
		unset($data['id']);
		if($user->id == 0) {
			$this->db
					->insert($this->table, $data);
			$user->id	=	mysql_insert_id();
		} else {
			$this->db
					->where('id', $user->id)
					->update($this->table, $data)
					;
		}
		
		return $user;
	}
	
	public function login($login, $password) {
		$result	=	$this->db
							->select('id')
							->select('login')
							->from($this->table)
							->where('login', $login)
							->where('password', md5($password))
							->get()
							->row()
							;
		if(!empty($result)) {
			$this->session->set_userdata('user', array('id' => $result->id, 'login' => $result->login));
			return true;
		} else {
			return false;
		}
	}
	
}

class UserItem {
	public $id					=	0;
	public $firstName			=	'';
	public $lastName			=	'';
	public $city				=	'';
	public $login				=	'';
	public $password			=	'';
	public $confirmPassword	=	'';
	
	public function __construct($id = 0) {
		$this->load($id);
	}
	public static function factory($id = 0) {
		return new UserItem($id);
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
    
    public function isExists() {
    	return $this->getModel()->isExists($this);
    }
	
	public function getModel() {
		return $this->getCI()->user;
	}
	
	public function save() {
		return $this->getModel()->save($this);
	}
}

?>
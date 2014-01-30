<?php
class Users extends CI_Controller  {
	
	
	public function __construct() {
		parent::__construct();
	}
	
	public function login() {
		if(UserHelper::loggedIn()->id > 0) {
			redirect('users/account');
		} else {
			$user	=	UserItem::factory();
			$errors	=	array();
			if(!empty($_POST)) {
				$login	=	$this->input->post('login');
				$password	=	$this->input->post('password');
				if(strlen($password) < 6) {
					$errors['password']	=	'Пароль короткий. Необходимо не менее 6 символов.';
				}
				if(strlen($login) < 3) {
					$errors['login']	=	'Логин короткий. Необходимо не менее 6 символов.';
				}
				if(!empty($errors)) {
					SeoHelper::setTitle('Login');
					$this->layout->view('users/login', array('errors' => $errors, 'user' => $user));
				} else {
					$result	=	$this->user->login($login, $password);
					if($result) {
						redirect('');
					} else {
						$errors['login']	=	'Пара логин-пароль не совпадает';
						SeoHelper::setTitle('Вход');
						$this->layout->view('users/login', array('errors' => $errors, 'user' => $user));
					}
				}
			} else {
				SeoHelper::setTitle('Вход');
				$this->layout->view('users/login', array('errors' => $errors, 'user' => $user));
			}
		}
	}
	
	public function signup() {
		if(UserHelper::loggedIn()->id > 0) {
			redirect('users/account');
		} else {
			$user	=	UserItem::factory();
			$errors	=	array();
			if(!empty($_POST)) {
				$user->apply($_POST);
				if(strlen($user->firstName) < 3) {
					$errors['firstName']	=	'Имя короткое. Необходимо не менее 3 символов';
				}
				if(strlen($user->lastName) < 3) {
					$errors['lastName']	=	'Фамилия короткая. Необходимо не менее 3 символов';
				}
				if(strlen($user->password) < 6) {
					$errors['password']	=	'Пароль короткий. Необходимо не менее 6 символов';
				}
				if($user->password != $user->confirmPassword) {
					$errors['confirmPassword']	=	'Пароль и подтверждение пароля не совпадают';
				}
				if(strlen($user->login) < 6) {
					$errors['login']	=	'Логин короткий. Необходимо не менее 6 символов';
				} elseif($user->isExists()) {
					$errors['login']	=	'Такой пользователь уже существует';
				}
				if(!empty($errors)) {
					SeoHelper::setTitle('Регистрация');
					$this->layout->view('users/signup', array('errors' => $errors, 'user' => $user));
				} else {
					$user->save();
					$this->session->set_userdata('user', array('id' => $user->id, 'login' => $user->login));
					redirect('');
				}
			} else {
				SeoHelper::setTitle('Регистрация');
				$this->layout->view('users/signup', array('errors' => $errors, 'user' => $user));
			}
		}
	}
	
	public function account() {
		if(UserHelper::loggedIn()->id > 0) {
			$user	=	UserHelper::loggedIn();
			SeoHelper::setTitle('Личный кабинет');
			$this->layout->view('users/account', array('user' => $user));
		} else {
			redirect('users/signup');
		}
	}
	
	public function logout() {
		if(UserHelper::loggedIn()->id > 0) {
			$this->session->unset_userdata('user');
		}
		redirect('');
	}
	
	public function editprofile() {
		$errors	=	array();
		$user	=	UserHelper::loggedIn();
		if(!empty($_POST)) {
				if(empty($_POST['changePassword'])) {
					unset($_POST['password']);
					unset($_POST['confirmPassword']);
					$user->confirmPassword	=	$user->password;
				}
				$user->apply($_POST);
				if(strlen($user->firstName) < 3) {
					$errors['firstName']	=	'Имя короткое. Необходимо не менее 3 символов';
				}
				if(strlen($user->lastName) < 3) {
					$errors['lastName']	=	'Фамилия короткая. Необходимо не менее 3 символов';
				}
				if(strlen($user->login) < 6) {
					$errors['login']	=	'Логин короткий. Необходимо не менее 6 символов';
				} elseif($user->isExists()) {
					$errors['login']	=	'Такой пользователь уже существует';
				}
				if(!empty($_POST['changePassword'])) {
					if(strlen($user->password) < 6) {
						$errors['password']	=	'Пароль короткий. Необходимо не менее 6 символов';
					}
					if($user->password != $user->confirmPassword) {
						$errors['confirmPassword']	=	'Пароль и подтверждение пароля не совпадают';
					}
				}
				if(!empty($errors)) {
					SeoHelper::setTitle('Редактирование данных');
					$this->layout->view('users/editprofile', array('errors' => $errors, 'user' => $user));
				} else {
					$user->save();
					$this->session->set_userdata('user', array('id' => $user->id, 'login' => $user->login));
					redirect('users/account');
				}
		} else {
			SeoHelper::setTitle('Редактирование данных');
			$this->layout->view('users/editprofile', array('errors' => $errors, 'user' => $user));
		}
	}
}
?>
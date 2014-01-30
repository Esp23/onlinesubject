<?php
class Subjects extends CI_Controller  {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function checkLogin() {
		if(UserHelper::loggedIn()->id == 0) {
			redirect('users/signup');
		}
	}
	
	public function show($id) {
		$this->checkLogin();
		
		$subject	=	SubjectItem::factory($id);
		$themes		=	ThemeItem::factory()->getAll();
		SeoHelper::setTitle('Предмет - '. $subject->name);
		$this->layout->view('subjects/show', array('subject'	=>	$subject, 'themes' => $themes));
	}
}
?>
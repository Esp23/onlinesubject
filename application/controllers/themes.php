<?php
class Themes extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function show($id) {
		$theme		=	ThemeItem::factory($id);
		$subject	=	SubjectItem::factory($theme->subjectId);
		$pages		=	PageItem::factory()->getAll();
		SeoHelper::setTitle('Subject - '. $subject->name. '. Theme - '. $theme->name);
		$this->layout->view('pages/show', array('subject'	=>	$subject, 'theme' => $theme, 'pages' => $pages));
	}
}
?>
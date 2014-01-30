<?php
class Home extends CI_Controller  {
	
	
	public function __construct() {
		parent::__construct();
		
	}
	
	public function index() {
		SeoHelper::setTitle('Домашняя');
		$themes		=	ThemeItem::factory()->getAll();
		if(!empty($themes)) {
			foreach ($themes as $theme) {
				$pages[$theme->id]		=	PageItem::factory()->getByThemeId($theme->id);
			}
		}
		$this->layout->view('home', array('pages'	=>	$pages, 'themes' => $themes, 'home' => 'true'));
	}
}
?>
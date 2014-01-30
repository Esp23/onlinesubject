<?php
class Layout 
{
	private $_CI;
	private $_layout 		= 'layouts/default.php';
	private $_initialPath 	= '';
	
	public function __construct()
	{
		$this->_CI = & get_instance();
	}
	
	/**
	 * @return CI
	 */
	private function getCI()
	{
		return $this->_CI;
	}
	
	public function setLayout($layout)
	{
		$this->_layout = $this->_initialPath . $layout;
	}
	
	public function getLayoutPath()
	{
		return $this->_layout;
	}
	
	public function setInitialPath($path)
	{
		$this->_initialPath = $path;
	}
	
	public function view($view, $params = false)
	{
		$data['content'] = $this->getCI()->load->view($this->_initialPath . $view, $params, true);
		$this->getCI()->load->view($this->_layout, $data);
	}
}
?>
<?php
class SeoHelper
{
	private static $_titlePrefix		= ' | OnlineSubjects';
	
	private static $_titletag 			= "OnlineSubjects";
	private static $_metakeyword 		= "OnlineSubjects";
	private static $_metadescription 	= "OnlineSubjects";
	
	public static function init($config) {
		$setTitle = self::$_titlePrefix;
		if(!empty($config)) {
			foreach ($config as $k=>$val) {
				$key = '_'.$k;
				if(isset(self::$$key)) {
					if($k == 'titletag')
						self::$$key = $val . $setTitle;
					else 
						self::$$key = $val;
				}
			}
		}				
	}
	
	public static function setTitle($title)
	{
		$setTitle = self::$_titlePrefix;
		if (trim($title))
			$setTitle = trim($title) . $setTitle;
			
		self::$_titletag = $setTitle;
	}
	
	public static function getTitle()
	{
		return self::$_titletag;
	}
	
	public static function getMeta() {
		return self::$_metadescription;
	}
	
	public static function setMeta($meta) {
		self::$_metadescription = trim($meta);
	}
	
	public static function getKeywords() {
		return self::$_metakeyword;
	}
	
	public static function setKeywords($keywords) {
		self::$_metakeyword = trim($keywords);
	}
	
	public static function getSeoHTML() {
		$html = '';
		$html .= '<meta content="'. self::$_titletag .'" name="title"/>';
		$html .= '<meta content="'. self::$_metakeyword .'" name="keywords"/>';
		$html .= '<meta content="'. self::$_metadescription .'" name="description"/>';
		return $html;
	}
}
?>
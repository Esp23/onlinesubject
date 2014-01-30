<?php

/**
 * static helper methods 
 *
 * @author kurijov
 */
class UserHelper 
{
	static protected $_loggedInUser;
	
	/**
	 * get logged in user
	 *
	 * @return UserItem
	 */
	public static function loggedIn()
	{
		if (self::$_loggedInUser == NULL || self::$_loggedInUser->id == 0) {
			$ci =& get_instance();
			$userSession = 	$ci->session->userdata('user');
			if (isset($userSession['id']) && !(empty($userSession['id']))) {
				self::$_loggedInUser = new UserItem($userSession['id']);
			}else {
				self::$_loggedInUser = new UserItem();
			}
		}
		return self::$_loggedInUser;
	}
	
}
?>
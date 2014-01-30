<?php
/**
 * 06.06.2007 kovalev
 *
 * $Id: sly_helper.php 228 2007-09-04 08:02:10Z sly $
 */

function print_flex ($data) {
	echo '<pre>';
	print_r($data);
	echo '</pre>';
}

function insertImage($text = '') {
	$text	=	preg_replace("/\[::([^::]*)::\]/", "<img src=\"". base_url()."images/pisunki/\$1\" />", $text);
	return $text;
}

function getCurrentController()
{
	$CI            = & get_instance();
	$controller    = $CI->uri->segment(1);
	if ($controller == '')
	$controller = 'home';

	return $controller;
}

function getCurrentMethod()
{
	$CI             = & get_instance();
	$method		    = $CI->uri->segment(2);
	if ($method == '')
	$method = '';

	return $method;
}

function _echo($string)
{
	$ci =& get_instance();
	$ci->load->view('common/output', array('output' => $string));
}

function isActivePage($url, $active = 'active')
{
	if (strpos($url, '/')) {
		$uriArray 	= explode('/', $url);
		$controller = $uriArray[0];
		$method		= $uriArray[1];
		if ($controller == getCurrentController() && $method == getCurrentMethod())
		return $active;
	} elseif ($url == getCurrentController())
	return $active;
	else
	return FALSE;
}

/**
 * return text from lang
 *
 * @param string $index
 * @return string
 */
function _lang ($index) {
	$CI 	= get_instance();
	$result = $CI->lang->line($index);
	if($result)
	return $result;
	else
	return $index;
}

function lang($index)
{
	echo _lang($index);
}

/**
 * checks if request is ajax
 *
 * @return bool
 */
function is_ajax()
{
	if (isset($_GET['_redirectinajax'])) {
		return TRUE;
	}

	return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
	strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');
}

function json_header()
{
	header('Content-type:application/json');
}

function ajax_params($url, $params = array())
{
	$toId = str_replace('/', '_', $url) . '_ajaxLink';

	$addClass = isset($params['class']) ? ' ' . $params['class'] : '';
	return 'href="' . site_url($url) . '#' . $url . '" class="ajax_link' . $addClass . '" id="' . $toId . '"';
}

function ajax_link($url, $title, $params = array())
{
	echo '<a ' . ajax_params($url, $params) . '>' . _lang($title) . '</a>';
}

function GetMonthString($n)
{
	$timestamp = mktime(0, 0, 0, $n, 1, 2011);
	return date("M", $timestamp);
}

function is_valid_timestring($time)
{
	if (strtotime($time) === FALSE) {
		return FALSE;
	}
	return TRUE;
}

/**
 * turns time into mysql format
 *
 * @param int|false $time
 * @return date
 */
function timeToMysqlDate($time = false)
{
	if (!$time)
	$time = time();
	else {
		if (!is_numeric($time))
		$time = strtotime($time);
	}

	$date = date('Y-m-d', $time);
	return $date;
}

/**
 * turns time into mysql format
 *
 * @param int|false $time
 * @return date
 */
function timeToMysqlDateTime($time = false)
{
	if (!$time)
	$time = time();
	else {
		if (!is_numeric($time))
		$time = strtotime($time);
	}

	$date = date('Y-m-d H:i:s', $time);
	return $date;
}

/**
 * generates date with frontend format
 * can be defined from config
 *
 * @param string|timestamp|false $time
 * @return string
 */
function frontEndDate($time = false)
{
	$ci 	=& get_instance();
	$format = $ci->config->item('fronend.dateTimeFormat');
	if ($time) {
		if (is_numeric($time))
		return date($format, $time);
		else {
			$time = strtotime($time);
			return date($format, $time);
		}
	} else
	return date($format);
}
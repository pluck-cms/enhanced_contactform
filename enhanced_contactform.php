<?php
//This is a module for pluck, an opensource content management system
//Website: http://www.pluck-cms.org

//LICENSE: MIT

//Make sure the file isn't accessed directly
defined('IN_PLUCK') or exit('Access denied!');

function enhanced_contactform_info() {
	global $lang;
	$module_info = array(
		'name'          => $lang['enhanced_contactform']['module_name'],
		'intro'         => $lang['enhanced_contactform']['module_intro'],
		'version'       => '0.1',
		'author'        => 'Bas Steelooper',
		'website'       => 'https://www.xobit.nl',
		'icon'          => 'images/contactform.png',
		'compatibility' => '4.7'
	);
	return $module_info;
}
?>
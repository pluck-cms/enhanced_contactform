<?php
/*
 * This file is part of pluck, the easy content management system
 * Copyright (c) pluck team
 * http://www.pluck-cms.org

 * Pluck is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * See docs/COPYING for the complete license.
*/

//Make sure the file isn't accessed directly.
defined('IN_PLUCK') or exit('Access denied!');

function enhanced_contactform_info() {
	global $lang;
	return array(
		'name'          => $lang['enhanced_contactform']['module_name'],
		'intro'         => $lang['enhanced_contactform']['module_intro'],
		'version'       => '0.1',
		'author'        => 'Bas Steelooper',
		'website'       => 'https://www.xobit.nl',
		'icon'          => 'images/contactform.png',
		'compatibility' => '4.7'
	);
}
?>
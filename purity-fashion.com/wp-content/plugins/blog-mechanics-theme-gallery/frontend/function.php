<?php
/*  
 * 2J Gallery			http://2joomla.net/wordpress-plugins/2j-gallery
 * Version:           	2.0.7 - 55767
 * Author:            	2J Team (c)
 * Author URI:        	http://2joomla.net
 * License:           	GPL-2.0+
 * License URI:       	http://www.gnu.org/licenses/gpl-2.0.txt
 * Date:              	Mon, 03 Apr 2017 16:27:39 GMT
 */


function twojg_array_get_by_path(array $array, $path = ''){
	
	$sections = empty($path) ? array() : explode('/', $path);
	$value = &$array;

	foreach ($sections as $section) {
		if (!isset($value[$section])) {
			return null;
		}
		$value = &$value[$section];
	}

	return $value;
}

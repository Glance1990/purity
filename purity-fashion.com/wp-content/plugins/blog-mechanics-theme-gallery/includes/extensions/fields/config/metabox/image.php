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

return array(
	'active' => true,
	'order' => 20,
	'settings' => array(
		'id' => 'twoj_gallery_field_images',
		'title' => '<span class="dashicons dashicons-format-gallery"></span> '.__('Images', 'blog-mechanics-theme-gallery'),
		'screen' => array(TWOJ_GALLERY_TYPE_POST),
		'context' => 'side',
		'priority' => 'high',
		'callback_args' => null,
	),
	'view' => 'default',
	'state' => 'open',
	'style' => null,
	'fields' => array(
		array(
			'type' => 'text',
			'view' => 'images',
			'is_lock' => false,
			'prefix' => null,
			'name' => 'images',
			'default' => '',
		),
		
	)
);

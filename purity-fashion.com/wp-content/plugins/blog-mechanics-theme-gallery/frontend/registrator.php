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

class twoJGalleryRegistrator{

	public function __construct(){
		add_action('init', array($this, 'init'));
	}

	public function init(){
		add_action('wp_enqueue_scripts', array($this, 'enqueueScripts'));
	}

	public function enqueueScripts(){
		wp_enqueue_script('jquery');
		
		wp_enqueue_script(
			twoJGallery::POST_TYPE . '_gallery-init-js',
			TWOJ_GALLERY_URI . 'assets/js/init.min.js',
			array('jquery'),
			TWOJ_GALLERY_VERSION,
			true
		);

		wp_localize_script(
			twoJGallery::POST_TYPE . '_gallery-init-js',
			'twoJGalleryJSConst',
			array(
				'moduleUri' => TWOJ_GALLERY_URI,
				'ajaxUrl' 	=> admin_url('admin-ajax.php'),
				'typePost' 	=> twoJGallery::POST_TYPE,
			)
		);
	}
}

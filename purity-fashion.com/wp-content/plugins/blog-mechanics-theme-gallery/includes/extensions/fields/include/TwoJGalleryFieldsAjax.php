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

class TwoJGalleryFieldsAjax{

	public function __construct(){
		$this->hook();
	}

	public function hook(){
		//delete_option( 'twoj_gallery_fields_voting1' );
		add_action('wp_ajax_twoj_gallery_fields_saveoption', array( $this, 'saveOption') );
	}

	public function saveOption(){
		delete_option( 'twoj_gallery_fields_voting1' );
		add_option( 'twoj_gallery_fields_voting1', '1' ); 
		echo 'ok';
		wp_die();
	}

}

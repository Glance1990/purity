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

if ( ! defined( 'ABSPATH' ) ) exit;

define("TWOJ_GALLERY_EVENT", 1); 
define("TWOJ_GALLERY_EVENT_DATE", '2017-03-23'); 
define("TWOJ_GALLERY_EVENT_HOUR", 20);

class TwoJGalleryHelper{

	static function checkEvent(){
		if( TWOJ_GALLERY_FULL_VERSION ) return false;

		if(  
			!defined('TWOJ_GALLERY_EVENT') ||
			!TWOJ_GALLERY_EVENT ||
			!defined('TWOJ_GALLERY_EVENT_DATE') ||
			!defined('TWOJ_GALLERY_EVENT_HOUR') 
		) return false;


		$eventDate = strtotime(TWOJ_GALLERY_EVENT_DATE);
		$eventHour = TWOJ_GALLERY_EVENT_HOUR * 60 * 60;
		if( 
			( time() - $eventDate < 0 ) ||  
			( time() - $eventDate > $eventHour ) 
		) return false;

		return true;
	}

}

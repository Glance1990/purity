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

class TwoJGalleryFieldsFieldSelectMultiple extends TwoJGalleryFieldsField{

	protected function normalize($values){
		if (!is_array($values)) {
			$values = array();
		}

		foreach ($values as $key => $value) {
			$values[$key] = parent::normalize($value);
		}
		
		return $values;
	}
}

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

class TwoJGalleryFieldsView{

	public function render($template, array $vars = array()){

		$templatePath = TWOJ_GALLERY_FILEDS_TEMPLATE . $template . '.tpl.php';

		if (!file_exists($templatePath)) {
			throw new Exception(__("Could not find template. Template: {$template}"));
		}
		extract($vars);
		require $templatePath;
	}

	public function content($template, array $vars = array()){
		ob_start();
		$this->render($template, $vars);
		$content = ob_get_contents();
		ob_clean();

		return $content;
	}
}

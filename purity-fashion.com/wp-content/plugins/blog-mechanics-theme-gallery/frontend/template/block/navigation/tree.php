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

 if ($navigationTree) : ?>
<div class="twoJGalleryCSSwrap">
	<?php foreach ($navigationTree as $item) :
		//$children = count( $treeBranch['children'] );
		$homeButton = 1;
		$treeBranch = $item;
		include TWOJ_GALLERY_TEMPLATE_DIR . 'block/navigation/treeItem.php';
		
		$homeButton = 0;
		if( count($item['children']) ){
			foreach ($item['children'] as $treeBranch){
				include TWOJ_GALLERY_TEMPLATE_DIR . 'block/navigation/treeItem.php';		
			}
		}
		
	endforeach; ?>
</div>
<?php endif; ?>

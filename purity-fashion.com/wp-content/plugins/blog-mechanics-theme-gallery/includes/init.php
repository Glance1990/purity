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

if(!function_exists('twoj_gallery_include')){
	function twoj_gallery_include( $filesForInclude, $path = '' ){
		$filesArray = array();
		
		if(empty($filesForInclude)) return;
		
		if(!$path) $path = TWOJ_GALLERY_INCLUDE_PATH;
		
		if( !is_array($filesForInclude) ) $filesArray[] = $filesForInclude;
			else $filesArray = $filesForInclude;

		for ($i=0; $i < count($filesArray); $i++) { 
			$item = $filesArray[$i];
			if( file_exists($path.$item) ) require_once $path.$item;
		}
	}
}

twoj_gallery_include( 'helper.php' );

define("TWOJ_GALLERY_PREMIUM_LINK", 'http://www.2joomla.net/products_info/goto.php?type=wpgallery&content=goPremium');

twoj_gallery_include(array( 'editor.wizard.php', 'widget.php') );

if(!function_exists('twoJGalleryIsEdit')){
    function twoJGalleryIsEdit($new_edit = null){
        global $pagenow;
        if (!is_admin()) return false;
        if($new_edit == "list")             return in_array( $pagenow, array( 'edit.php',  ) );
            elseif($new_edit == "edit")     return in_array( $pagenow, array( 'post.php' ) );
                elseif($new_edit == "new")  return in_array( $pagenow, array( 'post-new.php' ) );
                    else  return in_array( $pagenow, array( 'post.php', 'post-new.php' ) );
    }
}

if(!function_exists('twoJGalleryGetPostType')){
    function twoJGalleryGetPostType() {
        global $post, $typenow, $current_screen;
        if ( $post && $post->post_type )                         					return $post->post_type;
          elseif( $typenow )                                      					return $typenow;
          elseif( $current_screen && $current_screen->post_type ) 					return $current_screen->post_type;
          elseif( isset( $_REQUEST['post_type'] ) )               					return sanitize_key( $_REQUEST['post_type'] );
          elseif (isset( $_REQUEST['post'] ) && get_post_type($_REQUEST['post']))	return get_post_type($_REQUEST['post']);
        return null;
    }
}

function twoJGalleryCreatePostType() { 

	twoj_gallery_include('update.php');
	
	$update = new TwoJGalleryUpdate();

    register_post_type( TWOJ_GALLERY_TYPE_POST,
        array(
          'labels' => array(
            'name' => '2J Gallery',
            'singular_name' => _x( '2J Gallery', 'post type singular name', 'blog-mechanics-theme-gallery'),
            'all_items'     => __( 'Galleries List', 'blog-mechanics-theme-gallery'),
            'add_new'       => __( 'Add Gallery', 'blog-mechanics-theme-gallery'),
            'add_new_item'  => __( 'Add Gallery', 'blog-mechanics-theme-gallery'),
            'edit_item'     => __( 'Edit Gallery', 'blog-mechanics-theme-gallery'),
          ),

          'rewrite'         => array( 'slug' => '2jgallery', 'with_front' => true ),
          'public'      	=> true,
          'has_archive'   	=> false,
          'hierarchical'  	=> true,
          'supports'    	=> array( 'title', 'page-attributes', 'comments'),
          'menu_icon'     	=> 'dashicons-editor-kitchensink',
    ));

    if ( is_admin() && get_option( '2JGalleryCheckAfterInstall' ) == '1' ) {
        delete_option( '2JGalleryCheckAfterInstall' );
        global $wp_rewrite; 
        $wp_rewrite->flush_rules();
    }
}
add_action( 'init', 'twoJGalleryCreatePostType' );


if( twoJGalleryGetPostType() == TWOJ_GALLERY_TYPE_POST && twoJGalleryIsEdit('list') ){
    twoj_gallery_include('listing.php');
}

if( twoJGalleryGetPostType() == TWOJ_GALLERY_TYPE_POST && !TWOJ_GALLERY_FULL_VERSION  ){
    twoj_gallery_include('banner.php');
}

if( twoJGalleryGetPostType() == TWOJ_GALLERY_TYPE_POST && ( twoJGalleryIsEdit('new') || twoJGalleryIsEdit('edit') ) ){
	twoj_gallery_include('init.php', TWOJ_GALLERY_FILEDS_MODULE);
    twoj_gallery_include('edit.php');
}

twoj_gallery_include('include/TwoJGalleryFieldsAjax.php', TWOJ_GALLERY_FILEDS_MODULE);
$fieldAjax = new TwoJGalleryFieldsAjax();

if( is_admin() ){
	twoj_gallery_include(array('media.library.php', 'menu.php' ));
}

twoj_gallery_include( array('frontend.php') );

twoj_gallery_include( array('init.php'), TWOJ_GALLERY_FRONTEND_PATH);
<?php

/////////////////////////////////////
////// PAGINATION ///////////////////
/////////////////////////////////////

function gg_pagination() {
	if(isset($_POST['gg_type']) && $_POST['gg_type'] == 'gg_pagination') {
		include_once(GG_DIR . '/functions.php');
		include_once(GG_DIR . '/classes/gg_overlay_manager.php');
		
		if(!isset($_POST['gid']) || !filter_var($_POST['gid'], FILTER_VALIDATE_INT)) {die('Gallery ID is missing');}
		$gid = (int)$_POST['gid'];
		
		if(!isset($_POST['gg_page'])|| !filter_var($_POST['gg_page'], FILTER_VALIDATE_INT)) {die('wrong page number');}
		$page = (int)$_POST['gg_page'];
		
		// overlay
		if(!isset($_POST['gg_ol'])) {die('overlay is missing');}
		$overlay = $_POST['gg_ol'];
		
		// randomized images list trail
		if(!isset($_POST['gg_pag_vars']) || !is_array($_POST['gg_pag_vars'])) {die('missing gallery infos');}
		$per_page			= (int)$_POST['gg_pag_vars']['per_page']; if(!$per_page) {$per_page = 15;}
		$watermark 			= $_POST['gg_pag_vars']['watermark'];
		$randomized_order	= $_POST['gg_pag_vars']['random_trail']; if(!empty($randomized_order)) {$randomized_order = json_decode($randomized_order);}
		$wp_gall_hash		= $_POST['gg_pag_vars']['wp_gall_hash'];

		// get the gallery data
		$type 		= get_post_meta($gid, 'gg_type', true);
		$raw_layout = get_post_meta($gid, 'gg_layout', true);
		$thumb_q 	= get_option('gg_thumb_q', 90);

		// WP gall pagination fix
		if(!$type) {$type = 'wp_gall';}

		// layout options
		$layout = gg_check_default_val($gid, 'gg_layout', $raw_layout);
		if($layout == 'standard') {
			$thumb_w = gg_check_default_val($gid, 'gg_thumb_w', $raw_layout);
			$thumb_h = gg_check_default_val($gid, 'gg_thumb_h', $raw_layout);
		}
		elseif($layout == 'masonry') { 
			$cols = gg_check_default_val($gid, 'gg_masonry_cols', $raw_layout); 
			$default_w = (int)get_option('gg_masonry_basewidth', 960);
			$col_w = floor( $default_w / $cols );
		}
		else { $row_h = gg_check_default_val($gid, 'gg_photostring_h', $raw_layout); }
		
			
		//// prepare images
		// get them
		$images = gg_frontend_img_prepare($gid, $type, $wp_gall_hash);
		if(!is_array($images) || !count($images)) {$images = array();}
		$gall_img_count = count($images);

		// images array to be used (eventually watermarked)
		$start = ($page == 1) ? 0 : (($page - 1) * $per_page); 
		$selection = array($start, ($page * $per_page));  
		
		$images = gg_frontend_img_split($gid, $images, $type, $selection, $randomized_order, $watermark);	// PASS ALSO WATERMARK FLAG!!!!
		if(!is_array($images) || !count($images)) {$images = array();}
	
		// pagination limit
		if($gall_img_count > $per_page) {
			$tot_pages = ceil($gall_img_count / $per_page );	
		}
		
		// image overlay code 
		$ol_man = new gg_overlay_manager($overlay, false, 'gall');
			
		// create new block of gallery HTML
		$gallery = '';
		foreach($images as $img) {

			// image link codes
			if(isset($img['link']) && trim($img['link']) != '') {
				if($img['link_opt'] == 'page') {$thumb_link = get_permalink($img['link']);}
				else {$thumb_link = $img['link'];}
				
				$open_tag = '<div gg-link="'.$thumb_link.'"';
				$add_class = "gg_linked_img";
				$close_tag = '</div>';
			} else {
				$open_tag = '<div';
				$add_class = "";
				$close_tag = '</div>';
			}
			
			// SEO noscript part for full-res image
		  	$noscript = '<noscript><img src="'.$img['url'].'" alt="'.gg_sanitize_input($img['title']).'" /></noscript>';
			
			
			/////////////////////////
			// standard layout
			if($layout == 'standard') {	 
				
				$thumb = gg_thumb_src($img['path'], $thumb_w, $thumb_h, $thumb_q, $img['thumb']);
				$gallery .= '
				'.$open_tag.' gg-url="'.$img['url'].'" gg-title="'.gg_sanitize_input($img['title']).'" class="gg_img '.$add_class.'" gg-author="'.gg_sanitize_input($img['author']).'" gg-descr="'.gg_sanitize_input($img['descr']).'" rel="'.$gid.'">
				  <div class="gg_img_inner">';
					
					$gallery .= '
					<div class="gg_main_img_wrap">
						<img src="" gg-lazy-src="'.$thumb.'" alt="'.gg_sanitize_input($img['title']).'" class="gg_photo gg_main_thumb" />
						'.$noscript.'
					</div>';	
					
					$gallery .= '
					<div class="gg_overlays">'. $ol_man->get_img_ol($img['title'], $img['descr'], $img['url']) .'</div>';	
					
				$gallery .= '</div>' . $close_tag;
			}
			
			
			/////////////////////////
			// masonry layout
			else if($layout == 'masonry') {
				
				$thumb = gg_thumb_src($img['path'], ($col_w + 40), false, $thumb_q, $img['thumb']);	
				$gallery .= '
				'.$open_tag.' gg-url="'.$img['url'].'" class="gg_img '.$add_class.'" gg-title="'.gg_sanitize_input($img['title']).'" gg-author="'.gg_sanitize_input($img['author']).'" gg-descr="'.gg_sanitize_input($img['descr']).'" rel="'.$gid.'">
				  <div class="gg_img_inner">
					<div class="gg_main_img_wrap">
						<img src="" gg-lazy-src="'.$thumb.'" alt="'.gg_sanitize_input($img['title']).'" class="gg_photo gg_main_thumb" />	
						'.$noscript.'
					</div>
					<div class="gg_overlays">'. $ol_man->get_img_ol($img['title'], $img['descr'], $img['url']) .'</div>	
				</div>'.$close_tag;  
			}
			
			  
			/////////////////////////
			// photostring layout
			else {
	
				$thumb = gg_thumb_src($img['path'], false, $row_h, $thumb_q, $img['thumb']);
				$gallery .= '
				'.$open_tag.' gg-url="'.$img['url'].'" class="gg_img '.$add_class.'" gg-title="'.gg_sanitize_input($img['title']).'" gg-author="'.gg_sanitize_input($img['author']).'" gg-descr="'.gg_sanitize_input($img['descr']).'" rel="'.$gid.'">
				  <div class="gg_img_inner" style="height: '.$row_h.'px;">
					<div class="gg_main_img_wrap">
						<img src="" gg-lazy-src="'.$thumb.'" alt="'.gg_sanitize_input($img['title']).'" class="gg_photo gg_main_thumb" />	
						'.$noscript.'
					</div>
					<div class="gg_overlays">'. $ol_man->get_img_ol($img['title'], $img['descr'], $img['url']) .'</div>	
				</div>'.$close_tag;  
			}	
		}
		
		$pag = array(
			'html' => $gallery,
			'more' => ($gall_img_count > ($page * $per_page)) ? 1 : 0,
		);
		
		echo json_encode($pag);
		die();
	}
}
add_action('init', 'gg_pagination');



//////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////
////// LOAD GALLERY INSIDE A COLLECTION ////
////////////////////////////////////////////

function gg_load_coll_gallery() {
	if(isset($_POST['gg_type']) && $_POST['gg_type'] == 'gg_load_coll_gallery') {
		if(!isset($_POST['gdata'])) {die('data is missing');}
		$gdata = explode(';', addslashes($_POST['gdata']));
		
		$resp = '';
		if(get_option('gg_coll_show_gall_title')) {
			$resp .= '<h3 class="gg_coll_gall_title">'. get_the_title($gdata[0]) .'</h3>';
		}
		
		$resp .= do_shortcode('[g-gallery gid="'.$gdata[0].'" random="'.$gdata[1].'" watermark="'.$gdata[2].'"]');
		die($resp);
	}
}
add_action('init', 'gg_load_coll_gallery');


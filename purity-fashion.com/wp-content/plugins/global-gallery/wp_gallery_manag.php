<?php

///////////////////////////////////
// ADMIN IMPLEMENTATION


function gg_wp_gall_metabox() {
	// add a meta box for affected post types
	include_once(GG_DIR . '/functions.php');
	foreach(gg_affected_wp_gall_ct() as $type){
		add_meta_box('gg_wp_gall_settings', __('Global Gallery', 'gg_ml'), 'gg_wp_gall_settings', $type, 'normal', 'default');
	}  
}
add_action('admin_init', 'gg_wp_gall_metabox');


// create metabox
function gg_wp_gall_settings() {
	include_once(GG_DIR . '/functions.php');
	global $post;
	
	$use_it 		= get_post_meta($post->ID, 'gg_affect_wp_gall', true);
	$show_as 		= get_post_meta($post->ID, 'gg_layout', true); if(!$show_as) {$show_as = 'default';}
	
	$thumb_w 		= get_post_meta($post->ID, 'gg_thumb_w', true);
	$thumb_h 		= get_post_meta($post->ID, 'gg_thumb_h', true);	
	$masonry_cols 	= get_post_meta($post->ID, 'gg_masonry_cols', true);
	$ps_height 		= get_post_meta($post->ID, 'gg_photostring_h', true);
	$slider_autop 	= get_post_meta($post->ID, 'gg_slider_autoplay', true);
	
	$car_img_h		= get_post_meta($post->ID, 'gg_car_img_h', true);
	$car_cols		= get_post_meta($post->ID, 'gg_car_cols', true); if(!$car_cols) {$car_cols = 3;}
	$car_rows		= get_post_meta($post->ID, 'gg_car_rows', true); if(!$car_rows) {$car_rows = 1;}
	
	$paginate 		= get_post_meta($post->ID, 'gg_paginate', true); if(!$paginate) {$paginate = 'default';}
	$per_page 		= get_post_meta($post->ID, 'gg_per_page', true);
	$pag_system 	= get_post_meta($post->ID, 'gg_pag_system', true);
	$custom_ol 		= get_post_meta($post->ID, 'gg_custom_overlay', true);
	
	// retrocompatibility
	if(get_post_meta($post->ID, 'gg_use_slider', true)) {$show_as = 'slider';}
	
	// default values
	if($show_as == 'default') {
		$thumb_w = 		get_option('gg_thumb_w', 250);
		$thumb_h = 		get_option('gg_thumb_h', 200);
		$masonry_cols = get_option('gg_masonry_cols', 4);
		$ps_height = 	get_option('gg_photostring_h', 200);
	}
	
	if($paginate == 'default') {
		$per_page = get_option('gg_img_per_page', 10);	
	}
	
	// switches
	$hide = 'style="display: none;"';
	$standard_show =	($show_as != 'standard') 	? $hide : '';
	$masonry_show =		($show_as != 'masonry') 	? $hide : '';
	$ps_show = 			($show_as != 'string') 		? $hide : '';
	
	$slider_show = 		($show_as != 'slider') 		? $hide : '';
	$carousel_show = 	($show_as != 'carousel') 	? $hide : '';
	
	$pag_show =			($show_as == 'slider' || $show_as == 'carousel') ? $hide : '';
	$per_page_show = 	($paginate != '1') 			? $hide : '';
	$ggom_show =		($show_as == 'slider') 		? $hide : '';
	?>
    <div class="lcwp_mainbox_meta">
        <table class="widefat lcwp_table lcwp_metabox_table" style="margin-bottom: 10px;">
          <tr>
            <td class="lcwp_label_td"><?php _e("Use Global Gallery with wordpress galleries in this page?", 'gg_ml'); ?></td>
            <td class="lcwp_field_td">
                <select data-placeholder="<?php _e('Select an option', 'gg_ml') ?> .." name="gg_affect_wp_gall" id="gg_affect_wp_gall" class="lcweb-chosen" autocomplete="off">
                  <option value="default"><?php _e('As default', 'gg_ml') ?></option>
                  <option value="1" <?php selected($use_it, '1') ?>><?php _e('Yes', 'gg_ml') ?></option>
                  <option value="0" <?php selected($use_it, '0') ?>><?php _e('No', 'gg_ml') ?></option>
                </select>
            </td>    
          </tr>
			
          <tbody id="gg_wp_gall_opts" class="lcwp_form" <?php if($use_it == '0') {echo $hide;} ?>>
            <tr><td class="lcwp_field_td" colspan="2">
                <div>
                    <label><?php _e('Display as', 'gg_ml') ?></label>
                    
                    <select data-placeholder="<?php _e('Select a layout', 'gg_ml') ?> .." name="gg_layout" id="gg_show_as" class="lcweb-chosen" autocomplete="off">
                        <option value="default"><?php _e('Gallery', 'gg_ml') ?> - <?php _e('Default layout', 'gg_ml') ?></option>  
                        <option value="standard" <?php selected($show_as, 'standard') ?>><?php _e('Gallery', 'gg_ml') ?> - Standard layout</option>  
                        <option value="masonry" <?php selected($show_as, 'masonry') ?>><?php _e('Gallery', 'gg_ml') ?> -  Masonry layout</option>
                        <option value="string" <?php selected($show_as, 'string') ?>><?php _e('Gallery', 'gg_ml') ?> -  PhotoString layout</option>  
                        
                        <option value="slider" <?php selected($show_as, 'slider') ?>><?php _e('Slider', 'gg_ml') ?></option> 
                        <option value="carousel" <?php selected($show_as, 'carousel') ?>><?php _e('Carousel', 'gg_ml') ?></option>   
                    </select>
                </div>
                
                <div id="gg_tt_sizes" <?php echo $standard_show; ?>>
                    <label><?php _e('Images izes', 'gg_ml') ?></label>
                   
                    <input type="text" name="gg_thumb_w" value="<?php echo $thumb_w ?>" maxlength="4" style="width: 45px; margin-right: 3px; text-align: center;" /> x 
                    <input type="text" name="gg_thumb_h" value="<?php echo $thumb_h ?>" maxlength="4" style="width: 45px; margin-left: 3px; text-align: center;" /> px
                </div>     
                <div id="gg_masonry_cols" <?php echo $masonry_show; ?>>
                    <label><?php _e('Image Columns', 'gg_ml') ?></label>
                    
                    <div class="lcwp_slider" step="1" max="20" min="1"></div>
                    <input type="text" value="<?php echo (int)$masonry_cols ?>" name="gg_masonry_cols" class="lcwp_slider_input" />
                    <span></span>
                </div>
                <div id="gg_ps_height" <?php echo $ps_show; ?>>
                    <label><?php _e('Images height', 'gg_ml') ?></label>
                    
                    <div class="lcwp_slider" step="5" max="500" min="20"></div>
                    <input type="text" value="<?php echo (int)$ps_height ?>" name="gg_photostring_h" class="lcwp_slider_input" />
                    <span>px</span>
                </div>
                
                <div class="gg_slider_opts" <?php echo $slider_show; ?>>
                    <label><?php _e('Slider width', 'gg_ml') ?></label>
                    
                    <input type="text" name="gg_slider_w" value="<?php echo get_post_meta($post->ID, 'gg_slider_w', true) ?>" style="width: 50px; text-align: center;" maxlength="4" /> 
                    <select name="gg_slider_w_type" style="width: 50px; height: 28px; margin: -6px 0 0 -5px;" autocomplete="off">
                        <option value="%">%</option>
                        <option value="px" <?php if(get_post_meta($post->ID, 'gg_slider_w_type', true) == 'px') {echo 'selected="selected"';} ?>>px</option>
                    </select>
                </div>     
                <div class="gg_slider_opts" <?php echo $slider_show; ?>>
                    <label><?php _e('Slider height', 'gg_ml') ?></label>
                    
                    <input type="text" name="gg_slider_h" value="<?php echo get_post_meta($post->ID, 'gg_slider_h', true) ?>" style="width: 50px; text-align: center;" maxlength="4" /> 
                    <select name="gg_slider_h_type" style="width: 50px; height: 28px; margin: -6px 0 0 -5px;" autocomplete="off">
                        <option value="%">%</option>
                        <option value="px" <?php if(get_post_meta($post->ID, 'gg_slider_h_type', true) == 'px') {echo 'selected="selected"';} ?>>px</option>
                    </select>
                </div>
                <div class="gg_slider_opts" <?php echo $slider_show; ?>>
					<label><?php _e("Autoplay slideshow?", 'gg_ml'); ?></label> 
                    
                    <select data-placeholder="<?php _e('Select an option', 'gg_ml') ?> .." name="gg_slider_autoplay" class="lcweb-chosen" autocomplete="off">
                      <option value="auto"><?php _e('As default', 'gg_ml') ?></option>
                      <option value="1" <?php selected($slider_autop, '1') ?>><?php _e('Yes', 'gg_ml') ?></option>
                      <option value="0" <?php selected($slider_autop, '0') ?>><?php _e('No', 'gg_ml') ?></option>
                    </select>
                </div>
                
                <div class="gg_carousel_opts" <?php echo $carousel_show; ?>>
                    <label><?php _e('Images height', 'gg_ml') ?></label>
                    
                    <div class="lcwp_slider" step="5" max="500" min="20"></div>
                    <input type="text" value="<?php echo (int)$ps_height ?>" name="gg_car_img_h" class="lcwp_slider_input" />
                    <span>px</span>
                </div>
                <div class="gg_carousel_opts" <?php echo $carousel_show; ?>>
                    <label><?php _e('Images per time', 'gg_ml') ?></label>
                    
                    <div class="lcwp_slider" step="1" max="10" min="1"></div>
                    <input type="text" value="<?php echo (int)$car_cols ?>" name="gg_car_cols" class="lcwp_slider_input" />
                    <span></span>
                </div>
                <div class="gg_carousel_opts" <?php echo $carousel_show; ?>>
                    <label><?php _e('Rows', 'gg_ml') ?></label>
                    
                    <div class="lcwp_slider" step="1" max="4" min="1"></div>
                    <input type="text" value="<?php echo (int)$car_rows ?>" name="gg_car_rows" class="lcwp_slider_input" />
                    <span></span>
                </div>
                <div class="gg_carousel_opts" <?php echo $carousel_show; ?>>
					<label><?php _e("Use multiscroll?", 'gg_ml'); ?></label> 
                    <?php  $sel = (get_post_meta($post->ID, 'gg_car_multiscroll', true) == 1) ? 'checked="checked"' : ''; ?>
                    <input type="checkbox" value="1" name="gg_car_multiscroll" class="ip-checkbox" <?php echo $sel; ?> />
                </div>   
                <div class="gg_carousel_opts" <?php echo $carousel_show; ?>>
					<label><?php _e("Center mode?", 'gg_ml'); ?></label> 
                    <?php  $sel = (get_post_meta($post->ID, 'gg_car_centermode', true) == 1) ? 'checked="checked"' : ''; ?>
                    <input type="checkbox" value="1" name="gg_car_centermode" class="ip-checkbox" <?php echo $sel; ?> />
                </div>   
            </td>
            </tr>
            <tr id="gg_pagination"><td class="lcwp_field_td" colspan="2" <?php echo $pag_show ?>>
                <div>
                    <label><?php _e('Use pagination?', 'gg_ml') ?></label>
                    <select data-placeholder="<?php _e('Select an option', 'gg_ml') ?> .." name="gg_paginate" id="gg_paginate" autocomplete="off" class="lcweb-chosen">
                        <option value="default"><?php _e('As Default', 'gg_ml') ?></option>  
                        <option value="1" <?php selected($paginate, '1') ?>><?php _e('Yes', 'gg_ml') ?></option>  
                        <option value="0" <?php selected($paginate, '0') ?>><?php _e('No', 'gg_ml') ?></option>  
                    </select>
                </div>     
                <div id="gg_per_page" <?php echo $per_page_show; ?>>
                    <label><?php _e('Images per page', 'gg_ml') ?></label>
                    
                    <div class="lcwp_slider" step="1" max="100" min="2"></div>
                    <input type="text" value="<?php echo (int)$per_page ?>" name="gg_per_page" class="lcwp_slider_input" />
                    <span></span>
                </div>
            	<div>
                    <label><?php _e('Pagination System', 'gg_ml') ?></label>
                    <select data-placeholder="<?php _e('Select an option', 'gg_ml') ?> .." name="gg_pag_system" id="gg_pag_system" class="lcweb-chosen" autocomplete="off">
                        <option value=""><?php _e('auto - follow global settings', 'gg_ml') ?></option>
                        <option value="standard" <?php selected($pag_system, 'standard') ?>><?php _e('standard', 'gg_ml') ?></option>
                        <option value="inf_scroll" <?php selected($pag_system, 'inf_scroll') ?>><?php _e('infinite scroll', 'gg_ml') ?></option>
                    </select>
                </div>
            </td>
            </tr>

            <?php 
			///// OVERLAY MANAGER ADD-ON ///////////
			////////////////////////////////////////
			if(defined('GGOM_DIR')) : ?>
      		<tr id="gg_cust_ol" <?php echo $ggom_show ?>><td class="lcwp_field_td" colspan="2">
              <div>
              	<label><?php _e('Custom Overlay', 'gg_ml') ?></label>
            	<select data-placeholder="<?php _e('Select an overlay', 'gg_ml') ?> .." name="gg_custom_overlay" class="lcweb-chosen">
					<option value="">(<?php _e('default one', 'gg_ml') ?>)</option>				
					<?php
					$overlays = get_terms('ggom_overlays', 'hide_empty=0');
					foreach($overlays as $ol) {
						  $sel = ($ol->term_id == $custom_ol) ? 'selected="selected"' : '';
						  echo '<option value="'.$ol->term_id.'" '.$sel.'>'.$ol->name.'</option>'; 
					}
					?>
              	</select>
              </div>
            </td>
            </tr> 
            <?php endif; ?>
            
            <tr>
              <td colspan="2">
			  	<div>
					<label><?php _e("Use watermark?", 'gg_ml'); ?></label> 
                    <?php  $sel = (get_post_meta($post->ID, 'gg_watermark', true) == 1) ? 'checked="checked"' : ''; ?>
                    <input type="checkbox" value="1" name="gg_watermark" class="ip-checkbox" <?php echo $sel; ?> />
                </div>    
              </td>   
            </tr>
          </tbody>
        </table>  
        
        <input type="hidden" name="lcwp_nonce" value="<?php echo wp_create_nonce('lcwp') ?>" />
    </div>
    
    <?php // SCRIPTS ?>
    <script src="<?php echo GG_URL; ?>/js/functions.js" type="text/javascript"></script>
    <script src="<?php echo GG_URL; ?>/js/chosen/chosen.jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo GG_URL; ?>/js/lc-switch/lc_switch.min.js" type="text/javascript"></script>
    
    <script type="text/javascript">
	jQuery(document).ready(function($) {
		// settings toggle
		jQuery(document).delegate('#gg_affect_wp_gall', 'change', function() {
			var use_it = jQuery(this).val();
			
			if(use_it != '0') { jQuery('#gg_wp_gall_opts').slideDown(); }
			else { jQuery('#gg_wp_gall_opts').slideUp(); }		
		});
		
		jQuery(document).delegate('#gg_show_as', 'change', function() {
			var sa = jQuery(this).val();
			jQuery('#gg_tt_sizes, #gg_masonry_cols, #gg_ps_height, .gg_slider_opts, .gg_carousel_opts').hide();
			
			if(sa == 'standard') {
				jQuery('#gg_tt_sizes').show();
			}
			else if (sa == 'masonry') {
				jQuery('#gg_masonry_cols').show();
			}
			else if (sa == 'string') {
				jQuery('#gg_ps_height').show();
			}
			else if (sa == 'slider') {
				jQuery('.gg_slider_opts').show();
			}
			else if (sa == 'carousel') {
				jQuery('.gg_carousel_opts').show();
			}
			
			if (sa == 'slider' || sa == 'carousel') {
				jQuery('#gg_pagination').hide();
			} else {
				jQuery('#gg_pagination').show();	
			}
			
			if (sa == 'slider') {
				jQuery('#gg_cust_ol').hide();
			} else {
				jQuery('#gg_cust_ol').show();	
			}
		});
		
		jQuery(document).delegate('#gg_paginate', 'change', function() {
			var paginate = jQuery(this).val();
			
			if(paginate == '1') { jQuery('#gg_per_page').show(); }
			else { jQuery('#gg_per_page').hide(); }		
		});
	});
	</script>
    <?php
}


// save metabox
function gg_wp_gall_meta_save($post_id) {
	if(isset($_POST['gg_affect_wp_gall'])) {
		// authentication checks
		if (!wp_verify_nonce($_POST['lcwp_nonce'], 'lcwp')) return $post_id;

		include_once(GG_DIR.'/functions.php');
		include_once(GG_DIR.'/classes/simple_form_validator.php');
				
		$validator = new simple_fv;
		$indexes = array();
		
		$indexes[] = array('index'=>'gg_affect_wp_gall', 'label'=>'Affect WP galleries');
		
		$indexes[] = array('index'=>'gg_layout', 'label'=>'gallery Layout');
		$indexes[] = array('index'=>'gg_thumb_w', 'label'=>'Thumbs Width');
		$indexes[] = array('index'=>'gg_thumb_h', 'label'=>'Thumbs Height');
		$indexes[] = array('index'=>'gg_masonry_cols', 'label'=>'Masonry Columns');
		$indexes[] = array('index'=>'gg_photostring_h', 'label'=>'PhotoString Height');
		
		$indexes[] = array('index'=>'gg_paginate', 'label'=>'gallery pagination');
		$indexes[] = array('index'=>'gg_per_page', 'label'=>'images per page');
		$indexes[] = array('index'=>'gg_pag_system', 'label'=>'pagination system');
		
		$indexes[] = array('index'=>'gg_slider_w', 'label'=>'slider width');
		$indexes[] = array('index'=>'gg_slider_w_type', 'label'=>'slider width type');
		$indexes[] = array('index'=>'gg_slider_h', 'label'=>'slider height');
		$indexes[] = array('index'=>'gg_slider_h_type', 'label'=>'slider height type');
		$indexes[] = array('index'=>'gg_slider_autoplay', 'label'=>'autoplay slider');
		
		$indexes[] = array('index'=>'gg_car_img_h', 'label'=>'carousel image height');
		$indexes[] = array('index'=>'gg_car_cols', 'label'=>'carousel columns');
		$indexes[] = array('index'=>'gg_car_rows', 'label'=>'carousel rows');
		$indexes[] = array('index'=>'gg_car_multiscroll', 'label'=>'carousel multiscroll');
		$indexes[] = array('index'=>'gg_car_centermode', 'label'=>'carousel center mode');
		
		$indexes[] = array('index'=>'gg_watermark', 'label'=>'use watermark');
		$indexes[] = array('index'=>'gg_custom_overlay', 'label'=>'custom overlay');
		
		$validator->formHandle($indexes);
		$fdata = $validator->form_val;
		$error = $validator->getErrors();

		// clean data
		foreach($fdata as $key=>$val) {
			if(!is_array($val)) {
				$fdata[$key] = stripslashes($val);
			}
			else {
				$fdata[$key] = array();
				foreach($val as $arr_val) {$fdata[$key][] = stripslashes($arr_val);}
			}
		}

		// save data
		foreach($fdata as $key=>$val) {
			update_post_meta($post_id, $key, $fdata[$key]); 
		}
		
		// be sure old meta is deleted
		delete_post_meta($post_id, 'gg_use_slider');
	}

    return $post_id;
}
add_action('save_post','gg_wp_gall_meta_save');


/**************************************************************/


///////////////////////////////////
// FRONTEND IMPLEMENTATION

function gg_wp_gallery_manag_frontend($foo, $atts) {
	include_once(GG_DIR . '/functions.php');
	global $post;
	
	extract( shortcode_atts( array(
		'ids' => '',
		'orderby' => ''
	), $atts ) );
	
	$raw_use_it = get_post_meta($post->ID, 'gg_affect_wp_gall', true);
	$use_it = gg_check_default_val($post->ID, 'gg_affect_wp_gall', $raw_use_it);
	$random = ($orderby == 'rand') ? '1' : 0; 
	$wm = (get_post_meta($post->ID, 'gg_watermark', true)) ? '1' : '0';

	if($use_it && !empty($ids)) {
		gg_wp_gall_images($post->ID, $ids); // get and cache
		
		if(get_post_meta($post->ID, 'gg_layout', true) == 'slider' || get_post_meta($post->ID, 'gg_use_slider', true)) {
			$w = (int)get_post_meta($post->ID, 'gg_slider_w', true) . get_post_meta($post->ID, 'gg_slider_w_type', true);
			$h = (int)get_post_meta($post->ID, 'gg_slider_h', true) . get_post_meta($post->ID, 'gg_slider_h_type', true);
			$autop = get_post_meta($post->ID, 'gg_slider_autoplay', true);
			
			$code = do_shortcode('[g-slider gid="'.$post->ID.'" width="'.$w.'" height="'.$h.'" random="'.$random.'" autoplay="'.$autop.'" watermark="'.$wm.'" wp_gall_hash="'.'-'.md5($ids).'"]');	
		}
		else if(get_post_meta($post->ID, 'gg_layout', true) == 'carousel') {
			$h = get_post_meta($post->ID, 'gg_car_img_h', true);
			$cols = get_post_meta($post->ID, 'gg_car_cols', true);
			$rows = get_post_meta($post->ID, 'gg_car_rows', true);
			$ms = get_post_meta($post->ID, 'gg_car_multiscroll', true);
			$center = get_post_meta($post->ID, 'gg_car_centermode', true);

			$code = do_shortcode('[g-carousel gid="'.$post->ID.'" height="'.$h.'" per_time="'.$cols.'" rows="'.$rows.'" multiscroll="'.$ms.'" center="'.$center.'" random="'.$random.'" watermark="'.$wm.'" wp_gall_hash="'.'-'.md5($ids).'"]');	
		}
		else {
			$pag_system = get_post_meta($post->ID, 'gg_pag_system', true);
			$overlay = (defined('GGOM_DIR')) ? get_post_meta($post->ID, 'gg_custom_overlay', true) : '';
			
			$code = do_shortcode('[g-gallery gid="'.$post->ID.'" random="'.$random.'" watermark="'.$wm.'" pagination="'.$pag_system.'" overlay="'.$overlay.'" wp_gall_hash="'.'-'.md5($ids).'"]');
		}
		
		return $code;
	}
	else {return '';}
}
add_filter('post_gallery', 'gg_wp_gallery_manag_frontend', 999, 2);


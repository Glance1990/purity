<?php
// loader class in footer
function gg_loader_class() {
	?>
    <script type="text/javascript">
    if(	navigator.appVersion.indexOf("MSIE 8.") != -1 || navigator.appVersion.indexOf("MSIE 9.") != -1 ) {
		document.body.className += ' gg_old_loader';
	} else {
		document.body.className += ' gg_new_loader';
	}
	</script>
    <?php	
}
add_action('wp_footer', 'gg_loader_class', 1);




// TEMP LOADER, RIGHT CLICK, FLAGS - in head 
function gg_head_js_elements() {
    // linked images function ?>
	<script type="text/javascript">
	jQuery(document).delegate('.gg_linked_img', 'click', function() {
		var link = jQuery(this).attr('gg-link');
		window.open(link ,'<?php echo get_option('gg_link_target', '_top') ?>');
	});
	</script>
	
	<?php
	// if prevent right click
	if(get_option('gg_disable_rclick')) {
		?>
        <script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('body').delegate('.gg_gallery_wrap *, .gg_galleria_slider_wrap *, #lcl_wrapper *', "contextmenu", function(e) {
                e.preventDefault();
            });
		});
		</script>
        <?php	
	}
	
	// galleries / collections flags ?>
	<script type="text/javascript">
	gg_masonry_min_w = <?php echo (int)get_option('gg_masonry_min_width', 150) ?>;
	gg_phosostr_min_w = <?php echo get_option('gg_photostring_min_width', 120) ?>; 
	gg_coll_min_w = <?php echo (int)get_option('gg_coll_thumb_min_w', 200) ?>;
	
	gg_use_deeplink =  <?php echo (get_option('gg_disable_dl') == '1') ? 'false' : 'true'; ?>;
	gg_back_to_gall_scroll = <?php echo (get_option('gg_coll_back_to_scroll') == '1') ? 'true' : 'false'; ?>;
    </script>
	
	<?php
	$fx = get_option('gg_slider_fx', 'fadeslide');
	$fx_time = get_option('gg_slider_fx_time', 400);
	$crop = get_option('gg_slider_crop', 'true');
	$delayed_fx = (get_option('gg_delayed_fx')) ? 'false' : 'true';
	?>
	<script type="text/javascript">
	// global vars
	gg_galleria_toggle_info = <?php echo (get_option('gg_slider_tgl_info')) ? 'true' : 'false'; ?>;
	gg_galleria_fx = '<?php echo $fx ?>';
	gg_galleria_fx_time = <?php echo $fx_time ?>; 
	gg_galleria_img_crop = <?php echo ($crop=='true' || $crop=='false') ? $crop : '"'.$crop.'"' ?>;
	gg_galleria_autoplay = <?php echo (get_option('gg_slider_autoplay')) ? 'true' : 'false'; ?>;
	gg_galleria_interval = <?php echo get_option('gg_slider_interval', 3000) ?>;
	gg_delayed_fx = <?php echo $delayed_fx ?>;
	</script>
    <?php
}
add_action('wp_head', 'gg_head_js_elements', 999);


// SLIDER INIT and EDIT GALLERY HELPER - in footer 
function gg_footer_js_elements() {
	?>
	<script type="text/javascript">
	// Load Galleria's LCweb theme
	if(typeof(Galleria) != 'undefined') {
		Galleria.loadTheme('<?php echo GG_URL ?>/js/jquery.galleria/themes/ggallery/galleria.ggallery.js');
	}
	
	<?php
	// logged users helper - direct link to edit items
	if(current_user_can('edit_posts'))  : ?>
	jQuery(document).ready(function() {
		jQuery(document).delegate('.gg_galleria_slider_wrap, .gg_gallery_wrap:not(.gg_collection_wrap)', 'mouseenter', function() {  //==>> mouseenter mouseleave implementation
			var gid = jQuery(this).attr('rel');
			if(jQuery('#gg_quick_edit_btn.ggqeb_'+gid).length) {return false;}
			
			if(typeof(gg_remove_qeb) != 'undefined') {clearTimeout(gg_remove_qeb);}
			if(jQuery('#gg_quick_edit_btn').length) {jQuery('#gg_quick_edit_btn').remove();}
			
			var item_pos = jQuery(this).offset();
			var item_padding = parseInt( jQuery(this).css('padding-top'));
			var css_pos = 'style="top: '+ (item_pos.top + item_padding) +'px; left: '+ (item_pos.left + item_padding) +'px;"';
			
			var link = "<?php echo admin_url() ?>post.php?post="+ gid +"&action=edit";
			var icon = '<i class="fa fa-pencil" aria-hidden="true"></i>';
			
			jQuery('body').append('<a id="gg_quick_edit_btn" class="ggqeb_'+gid+'" href="'+ link +'" target="_blank" title="<?php _e('edit', 'mg_ml') ?>" '+css_pos+'>'+ icon +'</>');		
		});
		jQuery(document).delegate('.gg_galleria_slider_wrap, .gg_gallery_wrap', 'mouseleave', function() {
			if(typeof(gg_remove_qeb) != 'undefined') {clearTimeout(gg_remove_qeb);}
			gg_remove_qeb = setTimeout(function() {
				if(jQuery('#gg_quick_edit_btn').length) {jQuery('#gg_quick_edit_btn').remove();}
			}, 700);
		});
	});
	<?php endif; ?>
	</script>
	<?php
}
add_action('wp_footer', 'gg_footer_js_elements', 999);




// right click - CSS code for iphone in head
function gg_head_elements() {
	if(get_option('gg_disable_rclick')) {
		?>
        <style type="text/css">
		.gg_gallery_wrap *, .gg_galleria_slider_wrap *, #lcl_wrapper * {
			-webkit-touch-callout: none; 
			-webkit-user-select: none;
		}
		</style>
        <?php	
	}
}
add_action('wp_head', 'gg_head_elements', 999);

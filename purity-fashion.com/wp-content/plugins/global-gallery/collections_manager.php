<?php 
require_once(GG_DIR . '/functions.php');
?>

<style type="text/css">
#wpbody {overflow: hidden;}
</style>

<div class="wrap lcwp_form">  
	<div class="icon32"><img src="<?php echo GG_URL.'/img/gg_logo.png'; ?>" alt="globalgallery" /><br/></div>
    <?php echo '<h2 class="lcwp_page_title" style="border: none;">' . __('Collections Manager', 'gg_ml') . '</h2>'; ?>  

    <div id="poststuff" class="metabox-holder has-right-sidebar" style="overflow: hidden;">
    	
        <?php // SIDEBAR ?>
        <div id="side-info-column" class="inner-sidebar">
          <form class="form-wrap">	
           
            <div id="add_coll_box" class="postbox lcwp_sidebox_meta">
            	<h3 class="hndle"><?php _e('Add Collection', 'gg_ml') ?></h3> 
				<div class="inside">
                  <div class="misc-pub-section-last">
					<label><?php _e('Collection Name', 'gg_ml') ?></label>
                	<input type="text" name="gg_coll_name" value="" id="add_coll" maxlenght="100" style="width: 180px;" />
                    <input type="button" name="add_coll_btn" id="add_coll_btn" value="<?php _e('Add', 'gg_ml') ?>" class="button-primary" style="margin-left: 5px;" />
                  </div>  
                </div>
            </div>
            
            <div id="man_coll_box" class="postbox lcwp_sidebox_meta">
            	<h3 class="hndle"><?php _e('Collections List', 'gg_ml') ?></h3> 
				<div class="inside"></div>
            </div>
            
            <div id="save_coll_box" class="postbox lcwp_sidebox_meta" style="display: none; background: none; border: none; box-shadow: none;">
            	<input type="button" name="save-coll" value="<?php _e('Save Collection', 'gg_ml') ?>" class="button-primary" />
                <div style="width: 30px; padding: 0 0 0 7px; float: right;"></div>
            </div>
          </form>	
            
        </div>
    	
        <?php // PAGE CONTENT ?>
        <form class="form-wrap" id="coll_items_list">  
          <div id="post-body">
          <div id="post-body-content" class="gg_coll_content">
              <p><?php _e('Select a collection', 'gg_ml') ?> ..</p>
          </div>
          </div>
        </form>
        
        <br class="clear">
    </div>
    
</div>  

<?php // SCRIPTS ?>
<script src="<?php echo GG_URL; ?>/js/functions.js" type="text/javascript"></script>
<script src="<?php echo GG_URL; ?>/js/chosen/chosen.jquery.min.js" type="text/javascript"></script>
<script src="<?php echo GG_URL; ?>/js/lc-switch/lc_switch.min.js" type="text/javascript"></script>

<script type="text/javascript" charset="utf8" >
jQuery(document).ready(function($) {

	// selected coll var
	gg_sel_coll = 0;
	gg_coll_pag = 1;
	
	gg_load_colls();
	

	// galleries search
	jQuery('body').on('keyup', "#gg_coll_gall_search", function() {
		if(typeof(gg_cgs_acting) != 'undefined') {clearTimeout(gg_cgs_acting);}
		gg_cgs_acting = setTimeout(function() {
			
			var src_string = jQuery.trim( jQuery("#gg_coll_gall_search").val() );
			src_string = src_string.replace(',', '').replace('.', '').replace('?', ''); 
			
			if(src_string.length > 2) {
				jQuery('.gg_cgs_del').fadeIn(200);
				
				var src_arr = src_string.split(' ');
				var matching = jQuery.makeArray();

				// cyle and check eac searched term 
				jQuery('#gg_coll_gall_picker li').each(function(i, elem) {
					jQuery.each(src_arr, function(i, word) {						
						
						if( jQuery(elem).find('div').attr('title').indexOf(word) !== -1 ) {
							jQuery(elem).show();
						} else {
							jQuery(elem).hide();
						}
					});
				});
			}
			else {
				jQuery('.gg_cgs_del').fadeOut(200);
				jQuery('#gg_coll_gall_picker li').show();
			}
		}, 300);
	});
	
	jQuery('body').on('click', '.gg_cgs_mag', function() {
		jQuery("#gg_coll_gall_search").trigger('keyup');
	});
	
	jQuery('body').on('click', '.gg_cgs_del', function() {
		jQuery("#gg_coll_gall_search").val('').trigger('keyup');
	});
	
	
	// galleries picker - expand/compress
	jQuery('body').delegate('.gg_cgs_show_all', "click", function() {	
		if(jQuery(this).hasClass('shown')) {
			jQuery(this).removeClass('shown').text("(<?php _e('expand', 'gg_ml') ?>)");
			
			jQuery('#gg_coll_gall_picker').css('max-height', '113px');
		}
		else {
			jQuery(this).addClass('shown').text("(<?php _e('collapse', 'gg_ml') ?>)");
			jQuery('#gg_coll_gall_picker').css('max-height', 'none');	
		}
	});
	
	
	////////////////////////////////////////////////////////////
	
	
	// galleries cat choose
	jQuery('body').delegate('#gg_gall_cats', "change", function() {
		var item_cats = jQuery(this).val();	
		var data = {
			action: 'gg_cat_galleries_code',
			gallery_cat: item_cats
		};
		
		jQuery('.gg_dd_galls_preview').remove();
		jQuery('#gg_coll_gall_picker').html('<div style="height: 30px; width: 30px;" class="lcwp_loading"></div>');
		
		jQuery.post(ajaxurl, data, function(response) {
			if(jQuery.trim(response)) {
				jQuery('#gg_coll_gall_picker').html(response);
			}
			else {
				jQuery('#gg_coll_gall_picker').html('<span><?php echo gg_sanitize_input( __('No galleries found', 'gg_ml')) ?> ..</span>');
			}
		});	
	});
	
	
	// add gallery
	jQuery('body').delegate('#gg_coll_gall_picker li', "click", function() {
		var gall_id = jQuery(this).attr('rel');	
		var gall_title = jQuery(this).find('div').text();	
		var gall_cats = jQuery(this).attr('gg-cats');
		var gall_img = jQuery(this).attr('gg-img');
		
		// check for already existing galleries
		if(jQuery('#gg_coll_builder tr#gg_coll_'+gall_id).length) {
			gg_toast_message('error', gall_title +" - <?php echo gg_sanitize_input( __('gallery already in collection', 'gg_ml')) ?>");
		}
		else {
			if(!jQuery('#gg_coll_builder img').length) {jQuery('#gg_coll_builder tbody').empty();}
			
			jQuery('#gg_coll_builder > tbody').append('\
			<tr class="coll_component" id="gg_coll_'+gall_id+'">\
			  <td style="width: 160px;">\
			  	<img src="'+gall_img+'" />\
				<div class="gg_coll_manag_btn">\
					  <div><div class="lcwp_del_row gg_del_gall"></div></div>\
					  <div><div class="lcwp_move_row"></div></div>\
				  </div>\
			  </td>\
			  <td style="vertical-align: top;">\
				  <table class="gg_coll_inner_table">\
					<tr>\
					  </td>\
					  <td style="width: 250px;"><h2>\
					  	<a href="<?php echo get_admin_url() ?>post.php?post='+gall_id+'&action=edit" target="_blank" title="<?php echo gg_sanitize_input( __('edit gallery', 'gg_ml')) ?>">'+gall_title+'</a>\
					  </h2></td>\
					  <td style="width: 118px;" class="gg_use_random">\
						<p><?php echo gg_sanitize_input( __('Random display?', 'gg_ml')) ?></p>\
						<input type="checkbox" name="random" class="ip-checkbox" value="1" />\
					  </td>\
					  <td style="width: 125px;" class="gg_use_watermark">\
						<p><?php echo gg_sanitize_input( __('Use watermark?', 'gg_ml')) ?></p>\
						<input type="checkbox" name="watermark" class="ip-checkbox" value="1" />\
					  </td>\
					  <td><?php echo gg_sanitize_input( __('Categories', 'gg_ml')) ?>: <em>'+gall_cats+'</em></td>\
					 </tr>\
					 <tr>\
						<td colspan="2">\
							<p><?php echo gg_sanitize_input( __('Image link', 'gg_ml')) ?></p>\
							<select name="gg_linking_dd" class="gg_linking_dd">\
								<option value="none"><?php echo gg_sanitize_input( __('No link', 'gg_ml')) ?></option>\
								<option value="page"><?php echo gg_sanitize_input( __('To a page', 'gg_ml')) ?></option>\
								<option value="custom"><?php echo gg_sanitize_input( __('Custom link', 'gg_ml')) ?></option>\
							</select>\
							<div class="gg_link_wrap"><?php echo gg_link_field('none') ?></div>\
						</td>\
						<td colspan="2">\
							<p><?php echo gg_sanitize_input( __('Gallery description', 'gg_ml')) ?></p>\
							<textarea name="coll_descr" class="coll_descr"></textarea>\
						</td>\
					  </tr>\
					</table>\
				</td>\
			</tr>');
			
			gg_live_ip_checks();
		}
	});
	
	// linking management
	jQuery(document).delegate('.gg_coll_inner_table select.gg_linking_dd', 'change', function() {
		var link_opt = jQuery(this).val();
		
		if(link_opt == 'page') {
			var link_field = '<?php echo str_replace("'", "\'", gg_link_field('page')); ?>';
		}
		else if(link_opt == 'custom') {
			var link_field = '<?php echo gg_link_field('custom'); ?>';
		}
		else {
			var link_field = '<?php echo gg_link_field('none'); ?>';	
		}
		
		jQuery(this).parent().find('.gg_link_wrap').html(link_field);
	});

	
	// remove gallery
	jQuery('body').delegate('.gg_del_gall', "click", function() {
		if(confirm('Remove the gallery?')) {
			jQuery(this).parents('.coll_component').fadeOut(function() {
				jQuery(this).remove();
				if(jQuery('#gg_coll_builder img').size() == 0) {
					jQuery('#gg_coll_builder tbody').append('<tr><td colspan="5">No galleries selected ..</td></tr>');		
				}
			});
		}
	});
	
	
	// save the collection
	jQuery('body').delegate('#save_coll_box input', 'click', function() {
		var gall_list = jQuery.makeArray();
		var random_flag = jQuery.makeArray();
		var wmark_flag 	= jQuery.makeArray();
		var link_subj 	= jQuery.makeArray();
		var link_val 	= jQuery.makeArray();
		var coll_descr 	= jQuery.makeArray();
		
		// catch data
		jQuery('#gg_coll_builder tr.coll_component').each(function() {
			var gid = jQuery(this).attr('id').substr(8);
            gall_list.push(gid);
			
			var rand = (jQuery(this).find('.gg_use_random input').is(':checked')) ? 1 : 0; 
			random_flag.push(rand);
			
			var wmark = (jQuery(this).find('.gg_use_watermark input').is(':checked')) ? 1 : 0; 
			wmark_flag.push(wmark);
			
			link_subj.push( jQuery(this).find('.gg_linking_dd').val() );
			link_val.push( (jQuery(this).find('.gg_linking_dd').val() != 'none') ? jQuery(this).find('.gg_link_field').val() : '' );
			
			coll_descr.push( jQuery(this).find('.coll_descr').val() );
        });
		
		// ajax
		var data = {
			action: 		'gg_save_coll',
			coll_id: 		gg_sel_coll,
			gall_list: 		gall_list,
			random_flag: 	random_flag,
			wmark_flag:		wmark_flag,
			link_subj: 		link_subj,
			link_val:		link_val,
			coll_descr:		coll_descr
		};
		
		jQuery('#save_coll_box div').html('<div style="height: 30px;" class="lcwp_loading"></div>');
		
		jQuery.post(ajaxurl, data, function(response) {
			var resp = jQuery.trim(response); 			
			jQuery('#save_coll_box div').empty();
			
			if(resp == 'success') {
				gg_toast_message('success', "<?php echo gg_sanitize_input( __('Collection saved', 'gg_ml')) ?>");
			} else {
				gg_toast_message('error', resp);
			}
		});	
	});
	
	
	// select the collection
	jQuery('body').delegate('#man_coll_box input[type=radio]', 'click', function() {
		gg_sel_coll = parseInt(jQuery(this).val());
		var coll_title = jQuery(this).parent().siblings('.gg_coll_tit').text();

		jQuery('.gg_coll_content').html('<div style="height: 30px;" class="lcwp_loading"></div>');

		var data = {
			action: 'gg_coll_builder',
			coll_id: gg_sel_coll 
		};
		
		jQuery.post(ajaxurl, data, function(response) {
			jQuery('.gg_coll_content').html(response);
			
			// add the title
			jQuery('.gg_coll_content > h2').html(coll_title);
			
			// save coll box
			jQuery('#save_coll_box').fadeIn();
			
			gg_live_chosen();
			gg_live_ip_checks();
			gg_live_sort();
			
			// overflow fix
			jQuery('#poststuff').css('overflow', 'visible');
		});	
	});
	
	
	// add collection
	jQuery('#add_coll_btn').click(function() {
		var coll_name = jQuery('#add_coll').val();
		
		if( jQuery.trim(coll_name) != '' ) {
			var data = {
				action: 'gg_add_coll',
				coll_name: coll_name
			};
			
			jQuery.post(ajaxurl, data, function(response) {
				var resp = jQuery.trim(response); 
				
				if(resp == 'success') {
					gg_toast_message('success', "<?php echo gg_sanitize_input( __('Collection added', 'gg_ml')) ?>");
					jQuery('#add_coll').val('');
					
					gg_coll_pag = 1;
					gg_load_colls();
				}
				else {
					gg_toast_message('error', resp);
				}
			});	
		}
	});
	
	
	// manage colls pagination
	// prev
	jQuery('body').delegate('#gg_prev_colls', 'click', function() {
		gg_coll_pag = gg_coll_pag - 1;
		gg_load_colls();
	});
	// next
	jQuery('body').delegate('#gg_next_colls', 'click', function() {
		gg_coll_pag = gg_coll_pag + 1;
		gg_load_colls();
	});
	
	
	// load collection list
	function gg_load_colls() {
		jQuery('#man_coll_box .inside').html('<div style="height: 30px;" class="lcwp_loading"></div>');
		
		jQuery.ajax({
			type: "POST",
			url: ajaxurl,
			data: "action=gg_get_colls&coll_page="+gg_coll_pag,
			dataType: "json",
			success: function(response){	
				jQuery('#man_coll_box .inside').empty();
				
				// get elements
				gg_coll_pag = response.pag;
				var gg_coll_tot_pag = response.tot_pag;
				var gg_colls = response.colls;	

				var a = 0;
				jQuery.each(gg_colls, function(k, v) {	
					if( gg_sel_coll == v.id) {var sel = 'checked="checked"';}
					else {var sel = '';}
				
					jQuery('#man_coll_box .inside').append('<div class="misc-pub-section-last">\
						<span><input type="radio" name="gl" value="'+ v.id +'" '+ sel +' /></span>\
						<span class="gg_coll_tit" style="padding-left: 7px;" title="Collection #'+ v.id +'">'+ v.name +'</span>\
						<span class="gg_del_coll" id="gdel_'+ v.id +'"></span>\
					</div>');
					
					a = a + 1;
				});
				
				if(a == 0) {
					jQuery('#man_coll_box .inside').html('<p>No existing collections</p>');
					jQuery('#man_coll_box h3.hndle').html('Collections List');
				}
				else {
					// manage pagination elements
					jQuery('#man_coll_box h3.hndle').html('<?php echo gg_sanitize_input( __('Collections List', 'gg_ml')) ?> <small>(pag '+gg_coll_pag+' of '+gg_coll_tot_pag+')</small>'+
					'<span id="gg_next_colls">&raquo;</span><span id="gg_prev_colls">&laquo;</span>');
					
					
					// different cases
					if(gg_coll_pag <= 1) { jQuery('#gg_prev_colls').hide(); }
					if(gg_coll_pag >= gg_coll_tot_pag) {jQuery('#gg_next_colls').hide();}	
				}
			}
		});	
	}
	
	
	// delete collection
	jQuery('body').delegate('.gg_del_coll', 'click', function() {
		$target_coll_wrap = jQuery(this).parent(); 
		var coll_id  = jQuery(this).attr('id').substr(5);
		
		if(confirm('<?php echo gg_sanitize_input( __('Definitively delete collection?', 'gg_ml')) ?>')) {
			var data = {
				action: 'gg_del_coll',
				coll_id: coll_id
			};
			
			jQuery.post(ajaxurl, data, function(response) {
				var resp = jQuery.trim(response); 
				
				if(resp == 'success') {
					// if is this one opened
					if(gg_sel_coll == coll_id) {
						jQuery('.gg_coll_content').html('<p><?php echo gg_sanitize_input( __('Select a collection', 'gg_ml')) ?> ..</p>');
						gg_sel_coll = 0;
						
						// savecoll box
						jQuery('#save_coll_box').fadeOut();
					}
					
					$target_coll_wrap.slideUp(function() {
						jQuery(this).remove();
						
						if( jQuery('#man_coll_box .inside .misc-pub-section-last').size() == 0) {
							jQuery('#man_coll_box .inside').html('<p><?php echo gg_sanitize_input( __('No existing collections', 'gg_ml')) ?></p>');
						}
					});	
				}
				else {alert(resp);}
			});
		}
	});
	
	
	<!-- other -->
	
	// sort opt
	function gg_live_sort() {
		jQuery('#gg_coll_builder').children('tbody').sortable({ 
			handle: '.lcwp_move_row',
			items: "> tr",
			placeholder: "gg-coll-sort-placeholder"
		});
		jQuery('#gg_coll_builder').find('.lcwp_move_row').disableSelection();
	}
	
	// init chosen for live elements
	function gg_live_chosen() {
		jQuery('.lcweb-chosen').each(function() {
			var w = jQuery(this).css('width');
			jQuery(this).chosen({width: w}); 
		});
		jQuery(".lcweb-chosen-deselect").chosen({allow_single_deselect:true});
	}
	
	// dynamic lcweb switch
	function gg_live_ip_checks() {
		jQuery('.ip-checkbox').lc_switch('YES', 'NO');
	}
	
	
	// toast message for ajax operations
	gg_toast_message = function(type, text) {
		if(!jQuery('#lc_toast_mess').length) {
			jQuery('body').append('<div id="lc_toast_mess"></div>');
			
			jQuery('head').append(
			'<style type="text/css">' +
			'#lc_toast_mess,#lc_toast_mess *{-moz-box-sizing:border-box;box-sizing:border-box}#lc_toast_mess{background:rgba(20,20,20,.2);position:fixed;top:0;right:-9999px;width:100%;height:100%;margin:auto;z-index:99999;opacity:0;filter:alpha(opacity=0);-webkit-transition:opacity .15s ease-in-out .05s,right 0s linear .5s;-ms-transition:opacity .15s ease-in-out .05s,right 0s linear .5s;transition:opacity .15s ease-in-out .05s,right 0s linear .5s}#lc_toast_mess.lc_tm_shown{opacity:1;filter:alpha(opacity=100);right:0;-webkit-transition:opacity .3s ease-in-out 0s,right 0s linear 0s;-ms-transition:opacity .3s ease-in-out 0s,right 0s linear 0s;transition:opacity .3s ease-in-out 0s,right 0s linear 0s}#lc_toast_mess:before{content:"";display:inline-block;height:100%;vertical-align:middle}#lc_toast_mess>div{position:relative;padding:13px 16px!important;border-radius:2px;box-shadow:0 2px 17px rgba(20,20,20,.25);display:inline-block;width:310px;margin:0 0 0 50%!important;left:-155px;top:-13px;-webkit-transition:top .2s linear 0s;-ms-transition:top .2s linear 0s;transition:top .2s linear 0s}#lc_toast_mess.lc_tm_shown>div{top:0;-webkit-transition:top .15s linear .1s;-ms-transition:top .15s linear .1s;transition:top .15s linear .1s}#lc_toast_mess>div>span:after{font-family:dashicons;background:#fff;border-radius:50%;color:#d1d1d1;content:"";cursor:pointer;font-size:23px;height:15px;padding:5px 9px 7px 2px;position:absolute;right:-7px;top:-7px;width:15px}#lc_toast_mess>div:hover>span:after{color:#bbb}#lc_toast_mess .lc_error{background:#fff;border-left:4px solid #dd3d36}#lc_toast_mess .lc_success{background:#fff;border-left:4px solid #7ad03a}' +
			'</style>');	
			
			// close toast message
			jQuery(document.body).off('click tap', '#lc_toast_mess');
			jQuery(document.body).on('click tap', '#lc_toast_mess', function() {
				jQuery('#lc_toast_mess').removeClass('lc_tm_shown');
			});
		}
		
		// setup
		if(type == 'error') {
			jQuery('#lc_toast_mess').empty().html('<div class="lc_error"><p>'+ text +'</p><span></span></div>');	
		} else {
			jQuery('#lc_toast_mess').empty().html('<div class="lc_success"><p>'+ text +'</p><span></span></div>');	
			
			setTimeout(function() {
				jQuery('#lc_toast_mess.lc_tm_shown span').trigger('click');
			}, 2150);	
		}
		
		// use a micro delay to let CSS animations act
		setTimeout(function() {
			jQuery('#lc_toast_mess').addClass('lc_tm_shown');
		}, 30);	
	}
	
});
</script>
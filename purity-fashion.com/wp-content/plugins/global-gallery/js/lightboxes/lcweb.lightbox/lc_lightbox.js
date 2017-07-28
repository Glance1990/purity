/**
 * lc_lightbox.js - yet.. another lightbox
 * Version: 3.0 beta
 * Author: Luca Montanari aka LCweb
 * Website: http://www.lcweb.it
 * Commerciali license
 */

(function ($) {
	var lc_lightbox = function(element, lcl_settings) {
		
		var settings = $.extend({
			hook		: 'rel', // attribute to group the elements 
			url_src		: 'href', // attribute containing the title
			title_src	: 'title', // attribute containing the title
			author_src	: 'lcl-author', // attribute containing the author
			descr_src	: 'alt', // attribute containing the description
			
			animation_time	: 250, // animation timing in millisecods / 1000 = 1sec
			slideshow_time	: 6000, // slideshow interval time in milliseconds / 1000 = 1sec
			autoplay		: false, // autoplay slideshow - bool
			
			max_width	: '70%', // insert a percent value or an int for pixel value
			max_height	: '90%', // insert a percent value or an int for pixel value
			ol_opacity	: 0.70, // overlay opacity / value between 0 and 1
			ol_color	: '#000', // background color of the overlay
			ol_pattern	: 'oblique_dots', // overlay patterns - insert the pattern name or false
			border_w	: 5, // width of the lightbox border in pixels 
			border_col	: '#555', // color of the lightbox border   
			padding		: 4, // width of the lightbox padding in pixels
			radius		: 12, // corner radius of the lightbox in pixels (not for IE < 9) 
			
			style			: 'light', // light / dark / custom
			data_position	: 'over', // over / under / lside / rside
				
			show_title	: true, // bool
			show_descr	: true, // bool
			show_author	: true, // bool
			
			thumb_nav		: true, // enable the thumbnail navigation for image galleries
			thumbs_maker_url: false, // script baseurl to create thumbnails (use src=%URL% w=%W% h=%H%)
			thumb_w			: 120, // width of the thumbs for the standard lightbox
			thumb_h			: 85, // height of the thumbs for the standard lightbox
			
			fullscreen		: true, // Allow the user to expand a resized image. true/false
			fs_img_behaviour: 'smart', // resize mode of the fullscreen image - none/smart/fit/fill
			fs_only			: 'always', // open directly in fullscreen (only for image galleries) - none/mobile/always
			
			socials			: true, // bool
			fb_share_fix	: 'http://www.lcweb.it/lcis_fb_img_fix.php', // script to get rid of the facebook block on facebook CDN images
			download		: true, // bool / whether to add download button
			touchSwipe		: true, // bool / Allow touchSwipe interactions for mobile
			modal			: false, // enable modal mode (no closing on overlay click)

			open			: false, // open the lightbox immediately 
			from_index		: 0, // start index for automatic openings
			manual_hook		: false, // hook value for automatic openings
			
			slide_fx		: 'fadeslide',	// (string) sliding effect / none - slide - fade - fadeslide - zoom-in - zoom-out
			nav_arrows		: true,	// (bool) shows navigation arrows 
			nav_dots		: true,	// (bool) shows navigation dots
			slideshow_cmd	: true,	// (bool) shows slideshow commands (play/pause)
			carousel		: true,	// (bool) non-stop carousel
			touchswipe		: true,	// (bool) enable touch navigation (requires jquery.touchSwipe.js)
			autoplay		: false, // (bool) starts the slideshow
			animation_time	: 700, // (int) animation timing in millisecods / 1000 = 1sec
			slideshow_time	: 5000, // (int) interval time of the slideshow in milliseconds / 1000 = 1sec	
			pause_on_hover	: true,	// (bool) pause and restart the autoplay on box hover
			loader_code		: '<span class="lcl_loader"></span>', // loading animation code
			
			src				: {} // custom source - override elements
		}, lcl_settings);


		// global variables accessible only by the plugin
		var lcl_open, 			// is lightbox shown?
		lcl_fullscreen_open, 	// is fullscreen mode active?
		lcl_is_active = false, 	// true when lightbox systems are acting (disable triggers)
		lcl_slideshow, 			// lightbox slideshow object - setInterval
		lcl_txt_exists, 		// any text exists?
		lcl_managed_img_h, 		// has image been resized?
		lcl_html_style, 		// html tag style (for scrollbar hiding)
		lcl_body_style; 		// body tag style (for scrollbar hiding)

	
		// instance variables
		var vars = { 
			slides : [], 		// slides array -> object {content - img}
			shown_slide : 0,	// shown slide index
			cached_img: [],		// array containing cached images
			is_sliding : false,
			is_playing : false,
			paused_on_hover : false 
		};	
		
		
		// .data() system to avoid issues on multi instances
		var $lcl_wrap_obj = $(element);
		$lcl_wrap_obj.data('lcl_vars', vars);
		$lcl_wrap_obj.data('lcl_settings', settings);		
			
		/////////////////////////////////////////////////////////////////	


		/*** setup lightbox prepare elements array ***/
		var lb_setup = function($wrap_obj) {
			var vars = $wrap_obj.data('lcl_vars');
			var settings = $wrap_obj.data('lcl_settings');
			
			$wrap_obj.find('li').each(function(i, v) {
            	$(this).find('noscript').remove();
				var obj = {
					'content' 	: $(this).html(),
					'img'		: $(this).attr('lcl_img'),
					'classes'	: (typeof($(this).attr('class')) == 'undefined') ? '' : $(this).attr('class') 
				}; 
				vars.slides.push(obj);
            });
			
			// populate with first to show
			$wrap_obj.html('<div class="lcl_wrap"><div class="lcl_container"></div></div>');
			
			vars.shown_slide = 0;
			populate_slide($wrap_obj, 'init', 0);
			
			// populate with arrows
			if(settings.nav_arrows && vars.slides.length > 1) {
				$wrap_obj.find('.lcl_wrap').addClass('lcl_has_nav_arr').prepend('<div class="lcl_nav"><span class="lcl_prev"></span><span class="lcl_next"></span></div>');	
			}
			
			// populate with full nav dots
			if(settings.nav_dots && vars.slides.length > 1) {
				var code = '<div class="lcl_nav_dots">';
				for(a=0; a<vars.slides.length; a++) {code += '<span rel="'+a+'"></span>';}
				
				$wrap_obj.find('.lcl_wrap').addClass('lcl_has_nav_dots').prepend(code+'</div>');	
				$wrap_obj.find('.lcl_nav_dots span').first().addClass('lcl_sel_dot');
			}
			
			// populate with slideshow commands
			if(settings.slideshow_cmd && vars.slides.length > 1) {
				$wrap_obj.find('.lcl_wrap').addClass('lcl_has_ss_cmd').prepend('<div class="lcl_play"><span></span></div>');	
			}
			
			// autoplay
			if(settings.autoplay) {
				$wrap_obj.lcl_start_slideshow();
			}
			
			// hook after slider is ready and showing first element
			$wrap_obj.trigger('lcl_ready');
			
			// touchswipe
			$(document).ready(function(e) {
				if(typeof($.fn.swipe) == 'function') {
					touchswipe();
				}
			});
		};



		/* populate slide and append it in the slider
		 * type -> init - fade - prev - next
		 */
		var populate_slide = function($wrap_obj, type, slide_index) {
			var vars = $wrap_obj.data('lcl_vars');
			var settings = $wrap_obj.data('lcl_settings');
			
			var slide = vars.slides[ slide_index ];
			var preload_class = (slide.img) ? 'lcl_preload' : '';
			var loader_code = (slide.img) ? settings.loader_code : '';
			var fx_class;
			
			// showing fx class
			switch(type) {
				case 'init' : fx_class = 'lcl_active_slide'; break;
				case 'fade' : fx_class = 'lcl_fadein'; break;	
				case 'prev' : fx_class = 'lcl_before'; break;	
				case 'next' : fx_class = 'lcl_after'; break;	
			}
			
			// if using dots nav - set selected
			$wrap_obj.find('.lcl_nav_dots span').removeClass('lcl_sel_dot');
			$wrap_obj.find('.lcl_nav_dots span').eq(slide_index).addClass('lcl_sel_dot');
			
			// contents block
			var bg 			= (slide.img) ? '<div class="lcl_bg" style="background-image: url('+ slide.img +');"></div>' : '';
			var contents 	= ($.trim(slide.content)) ? '<div class="lcl_content">'+ slide.content +'</div>' : '';	
			var slide_code = '<div class="lcl_slide '+ fx_class +' '+ preload_class +'" rel="'+ slide_index +'"><div class="lcl_inner '+ slide.classes +'">'+ bg + contents +'</div>'+ loader_code +'</div>';
			
			// populate
			$wrap_obj.find('.lcl_container').append(slide_code);	
			
			// preload current element	
			if(slide.img) {
				if( $.inArray(slide.img, vars.cached_img) === -1 ) {
					$('<img/>').bind("load",function(){ 
						vars.cached_img.push( this.src );
						
						$('.lcl_slide[rel='+ slide_index +']').removeClass('lcl_preload');
						$('.lcl_slide[rel='+ slide_index +']').find('> *').not('.lcl_inner').fadeOut(300, function() {
							$(this).remove();	
						});
						
						// trigger custom action | args: slide index - slide object
						$wrap_obj.trigger('lcl_slide_shown', [slide_index, slide]);
						
						// action for first slide shown | args: slide index - slide object
						if($('.lcl_slide[rel='+ slide_index +']').hasClass('lcl_active_slide')) {
							$wrap_obj.trigger('lcl_initial_slide_shown', [slide_index, slide]);	
						}
					}).attr('src', slide.img);
				}
				else {
					$('.lcl_slide[rel='+ slide_index +']').removeClass('lcl_preload').addClass('lcl_cached');
					$('.lcl_slide[rel='+ slide_index +']').find('> *').not('.lcl_inner').remove();	
					
					// trigger custom action | args: slide index - slide object
					$wrap_obj.trigger('lcl_slide_shown', [slide_index, slide]);
				}
			}
			
			// smart preload - previous and next
			if(vars.slides.length > 1) {
				var next_load = (slide_index < (vars.slides.length - 1)) ? (slide_index + 1) : 0;
				
				if( $.inArray(vars.slides[ next_load ].img, vars.cached_img) === -1 ) {
					$('<img/>').bind("load",function(){ 
						vars.cached_img.push( this.src );
					}).attr('src', vars.slides[ next_load ].img);
				}
			}
			if(vars.slides.length > 2) {
				var prev_load = (!slide_index) ? (vars.slides.length - 1) : (slide_index - 1); 
				
				if( $.inArray(vars.slides[ prev_load ].img, vars.cached_img) === -1 ) {
					$('<img/>').bind("load",function(){ 
						vars.cached_img.push( this.src );
					}).attr('src', vars.slides[ prev_load ].img);
				}
			}	
		};
		
		
		
		/*** change element - direction could be next/prev or slide index ***/
		lcl_slide = function($wrap_obj, direction) {
			var vars = $wrap_obj.data('lcl_vars');
			var settings = $wrap_obj.data('lcl_settings');
			var at = settings.animation_time;
			var curr_index = vars.shown_slide;
			
			if(!settings.carousel && ((direction == 'prev' &&  !vars.shown_slide) || (direction == 'next' &&  vars.shown_slide == vars.slides.length - 1))) {return false;}
			if(vars.lcl_is_sliding || vars.slides.length == 1) {return false;}
			if(typeof(direction) == 'number' && (direction < 0 || direction > (vars.slides.length - 1))) {return false;}
			
			vars.lcl_is_sliding = true;
			
			// find the new index and populate
			if(direction == 'prev') {
				var new_index = (curr_index === 0) ? (vars.slides.length - 1) : (curr_index - 1); 
			} 
			else if (direction == 'next') {
				var new_index = (curr_index == (vars.slides.length - 1)) ? 0 : (curr_index + 1); 	
			}
			else {
				var new_index = direction; // direct slide jump	
				direction = (new_index > curr_index) ? 'next' : 'prev'; // normalize direction var
			}
			
			// add class to active slide
			$wrap_obj.find('.lcl_active_slide').addClass('lcl_prepare_for_'+direction);
			
			// populate
			var type = (settings.slide_fx == 'fade') ? 'fade' : direction;
			populate_slide($wrap_obj, type, new_index);
			vars.shown_slide = new_index;
			
			// trigger custom action | args: new slide index - new slide object - old slide index
			$wrap_obj.trigger('lcl_changing_slide', [new_index, vars.slides[new_index], curr_index]);
			
			// entrance effects
			if(settings.slide_fx == 'fade') {
				$wrap_obj.find('.lcl_active_slide').fadeOut(at);	
			}
			
			else if(settings.slide_fx == 'slide') {
				if(direction == 'prev') {
					$wrap_obj.find('.lcl_before').css('left', '-100%').animate({left : '0%'}, at);
					$wrap_obj.find('.lcl_active_slide').animate({left : '100%'}, at);	
				} else {
					$wrap_obj.find('.lcl_after').css('left', '100%').animate({left : '0%'}, at);
					$wrap_obj.find('.lcl_active_slide').animate({left : '-100%'}, at);	
				}
			}
			
			else if(settings.slide_fx == 'fadeslide') {
				if(direction == 'prev') {
					$wrap_obj.find('.lcl_before').fadeTo(0, 0).animate({left : '0%', opacity: 1}, at);
					$wrap_obj.find('.lcl_active_slide').animate({left : '100%', opacity: 0}, at);	
				} else {
					$wrap_obj.find('.lcl_after').fadeTo(0, 0).animate({left : '0%', opacity: 1}, at);
					$wrap_obj.find('.lcl_active_slide').animate({left : '-100%', opacity: 0}, at);	
				}
			}

			else if(settings.slide_fx == 'zoom-in') {
				$wrap_obj.find('.lcl_before, .lcl_after').fadeTo(0, 0).animate(
					{opacity: 1},
					{step: function(now, fx) {
						var val = 0.5 + (now / 2);
						$(this).css('-ms-transform','scale('+val+')').css('-webkit-transform','scale('+val+')').css('transform','scale('+val+')'); 
					},
					duration: at
				});
			}
			
			else if(settings.slide_fx == 'zoom-out') {
				$wrap_obj.find('.lcl_before, .lcl_after').fadeTo(0, 0).animate(
					{opacity: 1},
					{step: function(now, fx) {
						var val = 1.5 - (now / 2);
						$(this).css('-ms-transform','scale('+val+')').css('-webkit-transform','scale('+val+')').css('transform','scale('+val+')'); 
					},
					duration: at
				});
			}


			setTimeout(function() {
				$wrap_obj.find('.lcl_active_slide').remove();
				$wrap_obj.find('.lcl_slide').removeClass('lcl_fadein lcl_before lcl_after').addClass('lcl_active_slide');

				vars.lcl_is_sliding = false;
				
				// trigger custom action | args: new slide index - slide object
				$wrap_obj.trigger('lcl_new_active_slide', [new_index, vars.slides[new_index]]);
			}, at); 
		};


		////////////////////////////////////////////
		
		// play / pause button
		$('.lcl_prev').unbind('click');
		$lcl_wrap_obj.delegate('.lcl_play', 'click', function() {
			var $subj = $(this).parents('.lcl_wrap').parent();
			
			if(jQuery(this).hasClass('lcl_pause')) {
				$subj.lcl_stop_slideshow();	
			} else {
				$subj.lcl_start_slideshow();	
			}
		});
		
		// prev news - click event
		$('.lcl_prev').unbind('click');
		$lcl_wrap_obj.delegate('.lcl_prev:not(.lcl_disabled)', 'click', function() {
			var $subj = $(this).parents('.lcl_wrap').parent();
			if(typeof(lcl_one_click) != 'undefined') {clearTimeout(lcl_one_click);}
			
			lcl_one_click = setTimeout(function() {
				$subj.lcl_stop_slideshow();
				lcl_slide($subj, 'prev');	
			}, 5);
		});
		
		// next news - click event
		$('.lcl_next').unbind('click');
		$lcl_wrap_obj.delegate('.lcl_next:not(.lcl_disabled)', 'click', function() {
			var $subj = $(this).parents('.lcl_wrap').parent();
			if(typeof(lcl_one_click) != 'undefined') {clearTimeout(lcl_one_click);}
			
			lcl_one_click = setTimeout(function() {
				$subj.lcl_stop_slideshow();
				lcl_slide($subj, 'next');	
			}, 5);
		});
		
		// dots navigation - click event
		$('.lcl_next').unbind('click');
		$lcl_wrap_obj.delegate('.lcl_nav_dots span:not(.lcl_sel_dot)', 'click', function() {
			var $subj = $(this).parents('.lcl_wrap').parent();
			var new_index = parseInt(jQuery(this).attr('rel'));
			if(typeof(lcl_one_click) != 'undefined') {clearTimeout(lcl_one_click);}
			
			lcl_one_click = setTimeout(function() {
				$subj.lcl_stop_slideshow();
				lcl_slide($subj, new_index);	
			}, 5);
		});
		
		// touchswipe	
		var touchswipe = function() {
			$('.lcl_wrap').swipe({
				swipeRight: function() {
					var $subj = jQuery(this).parent();

					$subj.lcl_stop_slideshow();
					lcl_slide($subj, 'prev');		
				},
				swipeLeft: function() {
					var $subj = jQuery(this).parent();
				
					$subj.lcl_stop_slideshow();
					lcl_slide($subj, 'next');		
				},
				threshold: 40,
				allowPageScroll: 'vertical'
			});	
		};
		
		
		// pause on hover
		if(settings.pause_on_hover) {
			$lcl_wrap_obj.delegate('.lcl_wrap', 'mouseenter', function() {
				var $subj = $(this).parent();
				
				var vars = $subj.data('lcl_vars');
				var settings = $subj.data('lcl_settings');
				
				if(vars.is_playing) {
					$subj.lcl_stop_slideshow();
					vars.paused_on_hover = true; 
				}
			})
			.delegate('.lcl_wrap', 'mouseleave', function() {
				var $subj = $(this).parent();
				
				var vars = $subj.data('lcl_vars');
				var settings = $subj.data('lcl_settings');
				
				if(vars.paused_on_hover) {
					$subj.lcl_start_slideshow();
					vars.paused_on_hover = false;
				}
			});
		}
		
		////////////////////////////////////////////
		
		// execution
		lb_setup($lcl_wrap_obj);
		return this;
	};	
	
		
	////////////////////////////////////////////
	
	
	// init
	$.fn.lc_lightbox = function(lcl_settings) {

		// destruct
		$.fn.lcl_destroy = function() {
			var $elem = $(this);
			$elem.find('.lcl_wrap').remove();
			
			// clear interval
			var vars = $elem.data('lcl_vars');
			if(vars.is_playing) {clearInterval(vars.is_playing); }
			
			// undelegate events // TODO
			$elem.find('.lcl_next, .lcl_prev').undelegate('click');
			
			// remove stored data
			$elem.removeData('lcl_vars');
			$elem.removeData('lcl_settings');
			$elem.removeData('lc_micro_slider');
			
			return true;
		};	
		
		
		// pagination (next/prev/index)
		$.fn.lcl_paginate = function(direction) {
			var $elem = $(this);
			
			var vars = $elem.data('lcl_vars');	
			var settings = $elem.data('lcl_settings');
			
			$elem.lcl_stop_slideshow(); 
			
			lcl_slide($elem, direction);
			return true;
		};
		
		
		// start slideshow
		$.fn.lcl_start_slideshow = function() {
			var $elem = $(this);
			
			var vars = $elem.data('lcl_vars');	
			var settings = $elem.data('lcl_settings');	

			vars.is_playing = setInterval(function() {
				lcl_slide($elem, 'next');
			}, (settings.slideshow_time + settings.animation_time));	
			
			$elem.find('.lcl_play').addClass('lcl_pause');
			$elem.trigger('lcl_play_slideshow');
			return true;
		};
		
		
		// stop slideshow
		$.fn.lcl_stop_slideshow = function() {
			var $elem = $(this);

			var vars = $elem.data('lcl_vars');	
			var settings = $elem.data('lcl_settings');
			
			clearInterval(vars.is_playing);
			vars.is_playing = null;

			$elem.find('.lcl_play').removeClass('lcl_pause');
			$elem.trigger('lcl_stop_slideshow');
			return true;
		};


		// construct
		return this.each(function(){
            // Return early if this element already has a plugin instance
            if ( $(this).data('lc_lightbox') ) { return $(this).data('lc_lightbox'); }
			
            // Pass options to plugin constructor
            var lcl = new lc_lightbox(this, lcl_settings);
			
            // Store plugin object in this element's data
            $(this).data('lc_lightbox', lcl);
        });
	};			
	
})(jQuery);

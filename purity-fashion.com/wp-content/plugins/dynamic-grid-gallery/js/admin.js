(function($, undefined) {
	var settingsChanged = false, hasTitle = false, hasShortcode = false, editImage = false;
	
	$(document).ready(function() {
		// INIT
		init_image_boxes();
		init_tabs();
		init_yellow_fade();
		form_inline_validation();
		validate_form();
		form_interactivity();
		preview_tab_warning();
	});
	
	// Tabs
	function init_image_boxes() {
		$('.dg-admin-new-image').siblings('.dg-admin-image-wrap').each(function() {
			center_image($(this).find('img'));
		});
	}
	function init_tabs() {
		if ($('.ndd-tab-group').length == 0) return;
		$('.preload-active').removeClass('preload-active');
		
		var listItems = $('.ndd-tab-group > ul li');
		var tabs = $('.ndd-tab-group > .ndd-tab');
		
		var c = 0;
		listItems.each(function() {
			$(this).attr('id', 'ndd-tab-title-' + c);
			c++;
		});
		
		c = 0;
		tabs.each(function() {
			$(this).attr('id', 'ndd-tab-content-' + c);
			c++;
		});
		
		$('.ndd-tab-group > ul li').on('click', function() {
			listItems.removeClass('active');
			tabs.removeClass('active');
			
			$(this).addClass('active');
			var id = $(this).attr('id').replace('ndd-tab-title-', '');
			$('#ndd-tab-content-' + id).addClass('active');
		});
	}
	function init_yellow_fade() {
		$('.ndd-new-row').addClass('ndd-new-row-animate');
		setTimeout(function() {
			$('.ndd-new-row').removeClass('ndd-new-row-animate').removeClass('ndd-new-row');
		}, 2000);
	}
	
	function go_to_tab(tabWrap) {
		// Show tab
		$('.ndd-tab').not(tabWrap).removeClass('active');
		tabWrap.addClass('active');
		
		// Switch active states
		$('.ndd-tab-group ul li').removeClass('active');
		var id = tabWrap.attr('id').replace('ndd-tab-content-', '');
		$('#ndd-tab-title-' + id).addClass('active');
	}
	function show_error_for(field, message) {
		field.addClass('ndd-has-error');
		field.closest('tr').addClass('ndd-error-row');
		field.after('<div class="ndd-error-field">' + message + '</div>');
	}
	function remove_error_for(field) {
		if (!field.hasClass('ndd-has-error')) return;
		field.removeClass('ndd-has-error');
		field.closest('tr').removeClass('ndd-error-row');
		field.next().remove();
	}
	function form_inline_validation() {
		var title = /^[A-Za-z0-9_ ]{3,20}$/;
		var shortcode = /^[A-Za-z0-9_]{3,20}$/;
		
		$('#width, #height, #cols, #min_rows, #max_rows, #padding, #interval, #speed').on('change', function() {
			if (!isNumeric($(this).val())) {
				show_error_for($(this), 'You must enter a number!');
			} else {
				remove_error_for($(this));
			}

			settingsChanged = true;
		});
		
		$('#title').on('change', function() {
			if (!title.test($(this).val())) {
				show_error_for($(this), 'Please enter between 3 and 20 alphabets or numbers. Spaces are allowed. No special characters except underscore("_").');
			} else {
				remove_error_for($(this));
			}
			
			settingsChanged = true;
		});
		$('#shortcode').on('change', function() {			
			if (!shortcode.test($(this).val())) {
				show_error_for($(this), 'Please enter between 3 and 20 alphabets or numbers. No spaces. No special characters except underscore("_").');
			} else {
				remove_error_for($(this));
			}
			
			settingsChanged = true;
			
		});
	}
	function validate_form() {
		$('#save_options').on('click', function(e) {
			var success = true;
			
			process_layout_form();
			// e.preventDefault();
			// return false;

			if (!$('#shortcode').val()) {
				show_error_for($('#shortcode'), 'Please enter between 3 and 20 alphabets or numbers. Spaces are allowed. No special characters except underscore("_").');
				
				if (!$('#title').val()) {
					show_error_for($('#title'), 'Please enter between 3 and 20 alphabets or numbers. Spaces are allowed. No special characters except underscore("_").');
					e.preventDefault();
					success = false;
				} else {
					remove_error_for($(this));
				}
				
				e.preventDefault();
				success = false;
			} else {
				remove_error_for($(this));
			}
			
			if (!$('#title').val()) {
				show_error_for($('#title'), 'Please enter between 3 and 20 alphabets or numbers. Spaces are allowed. No special characters except underscore("_").');
				e.preventDefault();
				success = false;
			} else {
				remove_error_for($(this));
			}
			
			if ($('.ndd-has-error').length != 0) {
				go_to_tab($('.ndd-has-error').first().closest('.ndd-tab'));
				$('.as .updated').remove();
				$('.as header').append('<div class="error">There was an error validating the settings!</div>');
				
				e.preventDefault();
				success = false;
			}
			
			return success;
		});
	}
	function form_interactivity() {
		$('#auto_width').on('change', function() {
			if ($(this).attr('checked') == 'checked') {
				$('#width').attr('disabled', '');
			} else {
				$('#width').removeAttr('disabled');
			}
			
			settingsChanged = true;
		});
		
		// Images
		$('.dg-admin-new-image').on('click', function() {
			tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
			return false;
		});
		init_form_events();
	}
	function init_form_events() {
		$('input').on('change', function() {
			settingsChanged = true;
		});
		$('.dg-image-delete').on('click', function() {
			$(this).closest('.dg-admin-image-wrap').remove();
		});
		$('.dg-image-edit').on('click', function() {
			editImage = $(this).closest('.dg-admin-image-wrap').find('img');
			
			tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
			return false;
		});
	}
	function process_layout_form() {
		var result = new Array(), i = 0, root;
		
		$('.dg-admin-new-image').siblings('.dg-admin-image-wrap').each(function() {
			root = $(this);
			result[i] = {
				url : root.find('img').attr('src'),
				title : root.find('[name=img_title]').val(),
				description : root.find('[name=img_description]').val(),
				link : root.find('[name=img_link]').val(),
			};
			i++;
		});
		
		$('#result').html(JSON.stringify(result));
	}
	function preview_tab_warning() {
		$('.preview-tab').on('click', function() {
			if (settingsChanged) {
				$('.preview-tab-c').prepend('<div class="greetings">Oops! You need to save before the changes can take effect!</div>');
			}
		});
	}
	
	// Thickbox
	function add_new_image(url) {
		$('.dg-admin-new-image').before($('.dg-new-image-src').html());
		var img = $('.dg-admin-new-image').prev().find('img');
		img.attr('src', url);
		
		center_image(img);
	}
	function center_image(img) {
		if (img.width() < img.height()) {
			img.css({ "width" : '100%', "height" : 'auto' });
		} else {
			img.css({ "width" : 'auto', "height" : '100%' });
		}
	}
	window.send_to_editor = function(html) {
		imgurl = $('img', html).attr('src');
		if (editImage != false) {
			editImage.attr('src', imgurl);
			center_image(editImage);
			editImage = false;
		} else {
			add_new_image(imgurl);
			init_form_events();
		}
		tb_remove();
	}
	
	// Utility
	function isNumeric(num) {
	    return !isNaN(num);
	}
})(jQuery);
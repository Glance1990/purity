<?php

/*
Plugin Name: Dynamic Grid: Photo Gallery (shared on Ariyan.org )
Plugin URI: http://www.nikolaydyankovdesign.com/
Version: 1.1.2
Author: Nikolay Dyankov
Description: Next-gen WordPress photo gallery plugin.
*/

if (!class_exists('GridGallery')) {
	class GridGallery {
		function __construct() {
			$this->admin_options_name = 'grid-gallery-admin-options';
			$this->default_settings = array(
				'width' => '',
				'auto_width' => 1,
				'height' => 400,
				'min_rows' => 2,
				'max_rows' => 3,
				'random_heights' => 1,
				'padding' => 1,
				'interval' => 2000,
				'speed' => 800,
				'easing' => 'easeOutQuart',
				'cols' => '3',
				'center_images' => 1,
				'scale_images' => 1,
				'show_title_in_lightbox' => 1,
				'click_action' => 'link'
			);
			$this->pagename = 'grid_gallery';
			$this->newpagename = 'new_grid_gallery';
		}
		function get_admin_options() {
			// delete_option($this->admin_options_name);
			
			$admin_options = array(
				"general" => array(),
				"grids" => array()
			);
			
			$loaded_options = get_option($this->admin_options_name);

			if (!empty($loaded_options)) {
				foreach ($loaded_options as $key => $option) {
					$admin_options[$key] = $option;
				}
			}
			update_option($this->admin_options_name, $admin_options);
			return $admin_options;
		}
		function init_pages() {
			add_menu_page(
				"Dynamic Grid: Photo Gallery",
				"Dynamic Grid: Photo Gallery",
				"manage_options",
				$this->pagename,
				array($this, 'print_options_page')
			);
			
			add_submenu_page(
				$this->pagename,
				"Add New Gallery",
				"Add New",
				"manage_options",
				$this->newpagename,
				array($this, 'print_instance_options')
			);
		}
		
		function admin_includes() {
			wp_register_script('grid-js', plugins_url('/js/dynamic.grid.gallery.js', __FILE__), false, '1.0', true);
			wp_enqueue_script('grid-js');
			wp_register_style('grid-css', plugins_url('/css/dynamic.grid.css', __FILE__), false, '1.0', false);
			wp_enqueue_style('grid-css');
			
			wp_enqueue_script('grid-admin-js', plugins_url('/js/admin.js', __FILE__), false, '1.0', false);
			wp_enqueue_style('grid-admin-css', plugins_url('/css/admin.css', __FILE__), false, '1.0', false);
			
			wp_enqueue_style('thickbox');
			wp_enqueue_script('media-upload');
			wp_enqueue_script('thickbox');
			wp_enqueue_script('my-upload');
		}
		function user_includes() {
			wp_enqueue_script('jquery');
			wp_register_script('grid-js', plugins_url('/js/dynamic.grid.gallery.js', __FILE__), 'jquery', '1.0', true);
			wp_enqueue_script('grid-js');
			wp_register_style('grid-css', plugins_url('/css/dynamic.grid.css', __FILE__), false, '1.0', false);
			wp_enqueue_style('grid-css');
		}
		function call_plugins() {
			$options = $this->get_admin_options();
			?>
			
			<script>
				(function($, undefined) {
					$(document).ready(function() {
						
						<?php 
						
						if ($options['grids']) {
							foreach ($options['grids'] as $grid) {
								$height = $grid['settings']['height'];
								$cols = $grid['settings']['cols'];
								$min_rows = $grid['settings']['min_rows'];
								$max_rows = $grid['settings']['max_rows'];
								$padding = $grid['settings']['padding'];
								$interval = $grid['settings']['interval'];
								$speed = $grid['settings']['speed'];
								$easing = "'" . $grid['settings']['easing'] . "'";
								$click_action = "'" . $grid['settings']['click_action'] . "'";
							
								if ($grid['settings']['auto_width'] == 1) {
									$width = 'undefined';
								} else {
									$width = $grid['settings']['width'];
								}
							
								if ($grid['settings']['random_heights'] == 1) {
									$random_heights = 'true';
								} else {
									$random_heights = 'false';
								}
							
								if ($grid['settings']['scale_images'] == 1) {
									$scale_images = 'true';
								} else {
									$scale_images = 'false';
								}
							
								if ($grid['settings']['center_images'] == 1) {
									$center_images = 'true';
								} else {
									$center_images = 'false';
								}
							
								if ($grid['settings']['show_title_in_lightbox'] == 1) {
									$show_title_in_lightbox = 'true';
								} else {
									$show_title_in_lightbox = 'false';
								}

								?>
						
						
								$('#dynamic-grid-gallery-<?php echo $grid['id']; ?>').dynamicGallery({
									width : <?php echo $width; ?>,
									height : <?php echo $height; ?>,
									cols : <?php echo $cols; ?>,
									min_rows : <?php echo $min_rows; ?>,
									max_rows : <?php echo $max_rows; ?>,
									random_heights : <?php echo $random_heights; ?>,
									padding: <?php echo $padding; ?>,
									interval : <?php echo $interval; ?>,
									speed : <?php echo $speed; ?>,
									easing : <?php echo $easing; ?>,
									click_action : <?php echo $click_action; ?>,
									scale_images : <?php echo $scale_images; ?>,
									center_images : <?php echo $center_images; ?>,
									show_title_in_lightbox : <?php echo $show_title_in_lightbox; ?>,
									cb : function() {
										$('.preload-active').removeClass('preload-active');
									}
								});
						
							<?php } ?>
						<?php } ?>							
					});
				})(jQuery);
			</script>
			
			<?php
		}
		
		function print_options_page() {
			$options = $this->get_admin_options();
			
			if (isset($_GET['action'])) {
				if ($_GET['action'] == 'edit') {
					$this->print_instance_options();
				}
				if ($_GET['action'] == 'delete') {
					$this->delete_instance();
					$this->print_main_options();
				}
			} else {
				$this->print_main_options();
			}
		}
		function print_main_options() {
			$options = $this->get_admin_options();
			
			?>
			
			<div class="as">
				<header>
					<img src="<?php echo plugins_url('images/admin/thumb.png', __FILE__); ?>">
					<h2>Dynamic Grid:</h2>
					<h1>Photo Gallery</h1>
				</header>
				
				<div class="as-c">
					
					<?php if (count($options['grids']) == 0) { ?>
						<div class="greetings">Hey! Seems like you haven't created any grids yet. Start by clicking the big green button below!</div>
					<?php } else { ?>
					<table class="ndd-clean-table ndd-yellow-rows">
						<thead>
							<tr>
								<th class="ndd-column-name">Grid Name</th>
								<th class="ndd-column-shortcode">Shortcode</th>
								<th class="ndd-column-delete">Delete</th>
							</tr>
						</thead>
						<tbody>
							
							<?php 
								if ($options['grids']) {
									foreach ($options['grids'] as $grid) {
										$yellow_class = '';
										if ($grid['new']) {
											$yellow_class = 'ndd-new-row';
										}
										$options['grids'][$grid['id']]['new'] = false;
										update_option($this->admin_options_name, $options);
								?>
							
								<tr class="<?php echo $yellow_class; ?>">
									<td class="ndd-column-name"><a href="?page=<?php echo $this->pagename; ?>&id=<?php echo $grid['id']; ?>&action=edit"><?php echo $grid['title']; ?>&nbsp;</a></td>
									<td class="ndd-column-shortcode"><a href="?page=<?php echo $this->pagename; ?>&id=<?php echo $grid['id']; ?>&action=edit">[gridgallery name="<?php echo $grid['shortcode']; ?>"]</a></td>
									<td class="ndd-column-delete"><div class="ndd-delete-cell-wrap"><a href="?page=<?php echo $this->pagename; ?>&id=<?php echo $grid['id']; ?>&action=delete" class="ndd-delete-row"></a></div></td>
								</tr>
							
								<!-- END FOREACH -->
								<?php } ?>
							<?php } ?>
					
							
						</tbody>
					</table>
					
					<!-- END ELSE -->
					<?php } ?>
					
					<a href="?page=<?php echo $this->newpagename; ?>" class="ndd-button-green-regular"><span class="icon-plus"></span> New Gallery</a>
				</div>
				
				<footer>
					<p class="footer-copy">Thank you for purchasing my product. If you like what I do and you'd like to support my work, the best way to do it is by rating my items on CodeCanyon. You can do that by going at <a href="http://codecanyon.net/">CodeCanyon</a> and clicking on the Downloads tab. Find my product there and click on the stars to give it a rating. Thank you!</p>
					<ul>
						<li><span>Designed and developed by</span><a href="http://www.nikolaydyankovdesign.com"><img src="<?php echo plugins_url('images/admin/my-logo.png', __FILE__); ?>"></a></li>
						<li><span>Available exclusively at</span><a href="http://www.codecanyon.com/?ref=nickys"><img src="<?php echo plugins_url('images/admin/codecanyon-logo.png', __FILE__); ?>"></a></li>
						<li><span>Customer Support</span><a href="http://support.nikolaydyankovdesign.com"><img src="<?php echo plugins_url('images/admin/support.png', __FILE__); ?>"></a></li>
					</ul>
				</footer>
			</div>
			
			<?php
			
			
			$this->admin_includes();
		}
		function print_instance_options() {
			if (isset($_POST['save_options'])) {
				$this->save_options();
			}

			$options = $this->get_admin_options();
			
			// Change the title of the page if action is "New" or "Edit"
			
			if ($_GET['page'] == $this->newpagename) {
				$pagetitle = 'New Gallery';
				$submit_name = 'Create Gallery';
				$title = '';
				$shortcode = '';
				$id = rand(0, 10000);
				
				$settings = $this->default_settings;
			} else {
				$submit_name = 'Save Changes';
				$id = $_GET['id'];
				$grid = $options['grids'][$id];
				$pagetitle = 'Edit Gallery';
				$title = $grid['title'];
				$shortcode = $grid['shortcode'];
				
				$settings = $grid['settings'];
			}
			
			$uri = $_SERVER["REQUEST_URI"];
			$uri_ar = explode('?', $uri);

			$uri = $uri_ar[0] . '?page=' . $this->pagename . '&id=' . $id . '&action=edit';
						
			?>
			<form action="<?php echo $uri; ?>" method="post">
			<div class="as">
				
				<header class="ndd-subpage-header">
					<a href="?page=<?php echo $this->pagename; ?>" class="ndd-back-link">Back</a>
					<h1><?php echo $pagetitle; ?></h1>
					<div class="ndd-button-submit-wrap">
						
						<!-- OUTPUT FIELDS -->
						
						<textarea class="ndd-invisible" id="result" name="result"></textarea>
						
						<!--  -->
						
						<input class="ndd-button-submit" name="save_options" type="submit" class="button-primary" id="save_options" value="<?php echo $submit_name; ?>">
					</div>
					<?php if (isset($_POST['save_options'])) { ?>
						<div class="updated"><p><strong> <?php echo _e("Settings Updated!", "CommentWordFilter"); ?> </strong></p></div>
					<?php } ?>
				</header>
				
				
				
				<div class="as-c">
					
					<div class="ndd-tab-group">
						<ul>
							<li class="active">General</li>
							<li>Content</li>
							<li>Settings</li>
							<li class="preview-tab">Preview</li>
						</ul>
						
						<div class="ndd-tab active">
							<?php 
								if ($pagetitle == 'New Gallery') {
									echo '<div class="greetings">Start by filling in the title and shortcode, then head over to the Content and Settings tabs above to further setup your grid.</div>';
								}
							?>
							<table class="form-table ndd-yellow-rows">
								<tr>
									<td>
									<h2><label for="title">Title</label></h2>
									<input type="text" name="title" id="title" value="<?php echo $title; ?>" class="ndd-large-input">
									<div class="ndd-form-help">The title is used only for convenience in the admin panel. It will not be visible for the page visitor.</div>
									</td>
								</tr>
								<tr>
									<td>
									<h2><label for="shortcode">Shortcode</label></h2>
									<input type="text" name="shortcode" id="shortcode" value="<?php echo $shortcode; ?>" class="ndd-large-input">
									<div class="ndd-form-help">This is the shortcode that you will use to include this grid in a page or a template.</div>
									</td>
								</tr>
							</table>
						</div>
						<div class="ndd-tab">
							
							<?php 
								if ($pagetitle == 'New Gallery') {
									echo '<div class="greetings">From this tab you can add images to the gallery. For each image you can specify: <br /><br /><strong>Title</strong>: The title will show when the user hovers over the image. Leave blank if you don\'t need a title.<br /><br /><strong>Description</strong>: The description will show when the user hovers over the image. Leave blank if you don\'t need a description.<br /><br /><strong>Link</strong>: It will be active only when the "Click Action" setting from the Settings tab has been set to "Follow Image Link". Otherwise a Lightbox gallery will open.</div>';
								}
							?>
							
							<div class="dg-new-image-src">
								<div class="dg-admin-image-wrap">
									<div class="dg-admin-image admin-white-box">
										<div class="dg-admin-image-inner-wrap">
											<img src="">
											<div class="dg-admin-image-overlay">
												<div class="dg-image-delete dg-image-hover-button"><span class="icon-remove"></span></div>											
												<div class="dg-image-edit dg-image-hover-button"><span class="icon-edit"></span></div>
											</div>
										</div>

										<table class="form-table ndd-yellow-rows">
											<tr valign="top">
												<th scope="row"><label for="img_title">Title</label></th>
												<td><input type="text" class="regular-text" name="img_title" value="<?php echo ''; ?>"></td>
											</tr>
											<tr valign="top">
												<th scope="row"><label for="img_description">Description</label></th>
												<td><input type="text" class="regular-text" name="img_description" value="<?php echo ''; ?>"></td>
											</tr>
											<tr valign="top">
												<th scope="row"><label for="img_link">Link</label></th>
												<td><input type="text" class="regular-text" name="img_link" value="<?php echo ''; ?>"></td>
											</tr>
										</table>
									</div>
								</div>
							</div>
							
							<?php
								if ($grid['images']) {
									foreach ($grid['images'] as $image) {
										?>

										<div class="dg-admin-image-wrap">
											<div class="dg-admin-image admin-white-box">
												<div class="dg-admin-image-inner-wrap">
													<img src="<?php echo $image->url; ?>">
													<div class="dg-admin-image-overlay">
														<div class="dg-image-delete dg-image-hover-button"><span class="icon-remove"></span></div>											
														<div class="dg-image-edit dg-image-hover-button"><span class="icon-edit"></span></div>
													</div>
												</div>

												<table class="form-table ndd-yellow-rows">
													<tr valign="top">
														<th scope="row"><label for="img_title">Title</label></th>
														<td><input type="text" class="regular-text" name="img_title" value="<?php echo $image->title; ?>"></td>
													</tr>
													<tr valign="top">
														<th scope="row"><label for="img_description">Description</label></th>
														<td><input type="text" class="regular-text" name="img_description" value="<?php echo $image->description; ?>"></td>
													</tr>
													<tr valign="top">
														<th scope="row"><label for="img_link">Link</label></th>
														<td><input type="text" class="regular-text" name="img_link" value="<?php echo $image->link; ?>"></td>
													</tr>
												</table>
											</div>
										</div>

										<?php 
									}
								}
								
							?>
							
							<div class="dg-admin-new-image">
								<div class="dg-admin-image admin-white-box">
									<div><span class="icon-plus"></span> New Image</div>
								</div>
							</div>
							
							<div class="clear"></div>
						</div>
						<div class="ndd-tab">
							<table class="form-table ndd-yellow-rows">
								<tr class="cell-heading">
									<td><h2>General Options</h2></td>
								</tr>
								<tr valign="top">
									<th scope="row"><label for="scale_images">Scale Images</label></th>
									<td>
										<input type="checkbox" class="regular-text" name="scale_images" id="scale_images" <?php if ($settings['scale_images'] == 1) echo 'checked'; ?>>
										<div class="ndd-form-help">If the image is larger than it's parent cell in width or height, it will be scaled to fit.</div>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row"><label for="center_images">Center Images</label></th>
									<td>
										<input type="checkbox" class="regular-text" name="center_images" id="center_images" <?php if ($settings['center_images'] == 1) echo 'checked'; ?>>
										<div class="ndd-form-help">If the image is larger than it's parent cell it will get centered vertically and horizontally. Even if "Scale Images" has been checked, the image can still be larger than it's parent cell if it has different proportions.<br /><br />It's <strong>highly recommended</strong> that you leave this checked.</div>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row"><label for="click_action">Click Action</label></th>
									<td>
										<select name="click_action" id="click_action">
											<option value="link" <?php if ($settings['click_action'] == 'link') echo 'selected'; ?>>Open Link</option>
											<option value="lightbox" <?php if ($settings['click_action'] == 'lightbox') echo 'selected'; ?>>Show Lightbox</option>
										</select>
										<div class="ndd-form-help">Open Link: When the user clicks an image the link specified for the image will open.<br />Show Lightbox: When the user clicks any of the images, a lightbox gallery will open with all images.</div>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row"><label for="show_title_in_lightbox">Show Title in Lightbox</label></th>
									<td>
										<input type="checkbox" class="regular-text" name="show_title_in_lightbox" id="show_title_in_lightbox" <?php if ($settings['show_title_in_lightbox'] == 1) echo 'checked'; ?>>
										<div class="ndd-form-help">When Lightbox opens, the title of the image will be shown below the image.</div>
									</td>
								</tr>
								<tr class="cell-heading">
									<td><h2>Dimentions</h2></td>
								</tr>
								<tr valign="top">
									<th scope="row"><label for="width">Width</label></th>
									<td>
										<input type="text" class="regular-text" name="width" id="width" value="<?php echo $settings['width']; ?>" <?php if ($settings['auto_width'] == 1) echo 'disabled'; ?>>
										<input type="checkbox" class="regular-text" name="auto_width" id="auto_width" <?php if ($settings['auto_width'] == 1) echo 'checked'; ?> style="display: inline-block; width: auto;">
										<label for="auto_width">Fluid</label>
										<div class="ndd-form-help">The total width of the grid in pixels. Check "Fluid" for fluid width.</div>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row"><label for="height">Height</label></th>
									<td><input type="text" class="regular-text" name="height" id="height" value="<?php echo $settings['height']; ?>"><div class="ndd-form-help">The total height of the grid in pixels. This value cannot be fluid.</div></td>
								</tr>
								<tr class="cell-heading">
									<td><h2>Layout</h2></td>
								</tr>
								<tr valign="top">
									<th scope="row"><label for="cols">Columns</label></th>
									<td><input type="text" class="regular-text" name="cols" id="cols" value="<?php echo $settings['cols']; ?>"><div class="ndd-form-help">The total number of columns that the grid will have.</div></td>
								</tr>
								<tr valign="top">
									<th scope="row"><label for="min_rows">Minumum # of Rows</label></th>
									<td><input type="text" class="regular-text" name="min_rows" id="min_rows" value="<?php echo $settings['min_rows']; ?>"><div class="ndd-form-help">The minimum number of visible cells for each column. If you need to have a fixed number of rows, match this value with the "Maximum # of Rows" value.</div></td>
								</tr>
								<tr valign="top">
									<th scope="row"><label for="max_rows">Maximum # of Rows</label></th>
									<td><input type="text" class="regular-text" name="max_rows" id="max_rows" value="<?php echo $settings['max_rows']; ?>"><div class="ndd-form-help">The maximum number of visible cells for each column.</div></td>
								</tr>
								<tr valign="top">
									<th scope="row"><label for="random_heights">Random Heights</label></th>
									<td><input type="checkbox" class="regular-text" name="random_heights" id="random_heights" <?php if ($settings['random_heights']) echo 'checked'; ?>><div class="ndd-form-help">If checked, the cells in the grid will have random heights, but the cell count per column will be preserved.<br />Important: Turning it off may cause clipping of the text in the cells! I highly recommend that you leave this setting on, unless you absolutely need to have fixed heights.</div></td>
								</tr>
								<tr valign="top">
									<th scope="row"><label for="padding">Padding</label></th>
									<td><input type="text" class="regular-text" name="padding" id="padding" value="<?php echo $settings['padding']; ?>"><div class="ndd-form-help">The distance in pixels (padding) between the cells.</div></td>
								</tr>
								<tr class="cell-heading">
									<td><h2>Animation</h2></td>
								</tr>
								<tr valign="top">
									<th scope="row"><label for="interval">Interval</label></th>
									<td><input type="text" class="regular-text" name="interval" id="interval" value="<?php echo $settings['interval']; ?>"><div class="ndd-form-help">The delay between each sliding of a column (in milliseconds).</div></td>
								</tr>
								<tr valign="top">
									<th scope="row"><label for="speed">Speed</label></th>
									<td><input type="text" class="regular-text" name="speed" id="speed" value="<?php echo $settings['speed']; ?>"><div class="ndd-form-help">The time it takes a column to slide up or down (in milliseconds).</div></td>
								</tr>
								<tr valign="top">
									<th scope="row"><label for="easing">Easing Effect</label></th>
									<td>
										<select name="easing" id="easing">
											<option <?php if ($settings['easing'] == 'jswing') echo 'selected'; ?> value="jswing">jswing</option>
											<option <?php if ($settings['easing'] == 'def') echo 'selected'; ?> value="def">def</option>
											<option <?php if ($settings['easing'] == 'easeInQuad') echo 'selected'; ?> value="easeInQuad">easeInQuad</option>
											<option <?php if ($settings['easing'] == 'easeOutQuad') echo 'selected'; ?> value="easeOutQuad">easeOutQuad</option>
											<option <?php if ($settings['easing'] == 'easeInOutQuad') echo 'selected'; ?> value="easeInOutQuad">easeInOutQuad</option>
											<option <?php if ($settings['easing'] == 'easeInCubic') echo 'selected'; ?> value="easeInCubic">easeInCubic</option>
											<option <?php if ($settings['easing'] == 'easeOutCubic') echo 'selected'; ?> value="easeOutCubic">easeOutCubic</option>
											<option <?php if ($settings['easing'] == 'easeInOutCubic') echo 'selected'; ?> value="easeInOutCubic">easeInOutCubic</option>
											<option <?php if ($settings['easing'] == 'easeInQuart') echo 'selected'; ?> value="easeInQuart">easeInQuart</option>
											<option <?php if ($settings['easing'] == 'easeOutQuart') echo 'selected'; ?> value="easeOutQuart">easeOutQuart</option>
											<option <?php if ($settings['easing'] == 'easeInOutQuart') echo 'selected'; ?> value="easeInOutQuart">easeInOutQuart</option>
											<option <?php if ($settings['easing'] == 'easeInQuint') echo 'selected'; ?> value="easeInQuint">easeInQuint</option>
											<option <?php if ($settings['easing'] == 'easeOutQuint') echo 'selected'; ?> value="easeOutQuint">easeOutQuint</option>
											<option <?php if ($settings['easing'] == 'easeInOutQuint') echo 'selected'; ?> value="easeInOutQuint">easeInOutQuint</option>
											<option <?php if ($settings['easing'] == 'easeInSine') echo 'selected'; ?> value="easeInSine">easeInSine</option>
											<option <?php if ($settings['easing'] == 'easeOutSine') echo 'selected'; ?> value="easeOutSine">easeOutSine</option>
											<option <?php if ($settings['easing'] == 'easeInOutSine') echo 'selected'; ?> value="easeInOutSine">easeInOutSine</option>
											<option <?php if ($settings['easing'] == 'easeInExpo') echo 'selected'; ?> value="easeInExpo">easeInExpo</option>
											<option <?php if ($settings['easing'] == 'easeOutExpo') echo 'selected'; ?> value="easeOutExpo">easeOutExpo</option>
											<option <?php if ($settings['easing'] == 'easeInOutExpo') echo 'selected'; ?> value="easeInOutExpo">easeInOutExpo</option>
											<option <?php if ($settings['easing'] == 'easeInCirc') echo 'selected'; ?> value="easeInCirc">easeInCirc</option>
											<option <?php if ($settings['easing'] == 'easeOutCirc') echo 'selected'; ?> value="easeOutCirc">easeOutCirc</option>
											<option <?php if ($settings['easing'] == 'easeInOutCirc') echo 'selected'; ?> value="easeInOutCirc">easeInOutCirc</option>
											<option <?php if ($settings['easing'] == 'easeInElastic') echo 'selected'; ?> value="easeInElastic">easeInElastic</option>
											<option <?php if ($settings['easing'] == 'easeOutElastic') echo 'selected'; ?> value="easeOutElastic">easeOutElastic</option>
											<option <?php if ($settings['easing'] == 'easeInOutElastic') echo 'selected'; ?> value="easeInOutElastic">easeInOutElastic</option>
											<option <?php if ($settings['easing'] == 'easeInBack') echo 'selected'; ?> value="easeInBack">easeInBack</option>
											<option <?php if ($settings['easing'] == 'easeOutBack') echo 'selected'; ?> value="easeOutBack">easeOutBack</option>
											<option <?php if ($settings['easing'] == 'easeInOutBack') echo 'selected'; ?> value="easeInOutBack">easeInOutBack</option>
											<option <?php if ($settings['easing'] == 'easeInBounce') echo 'selected'; ?> value="easeInBounce">easeInBounce</option>
											<option <?php if ($settings['easing'] == 'easeOutBounce') echo 'selected'; ?> value="easeOutBounce">easeOutBounce</option>
											<option <?php if ($settings['easing'] == 'easeInOutBounce') echo 'selected'; ?> value="easeInOutBounce">easeInOutBounce</option>
										</select>
										<div class="ndd-form-help">This is sort of the "behavior" of the animation. Different effects produce very different results, the best way to find what you're looking for is to experiment!</div>
									</td>
								</tr>
							</table>
						</div>
						<div class="ndd-tab preload-active preview-tab-c">
							<?php do_shortcode('[gridgallery name=' . $grid['shortcode'] . ']'); ?>
						</div>
					</div>
					
				</div>
				
				<footer>
					<p class="footer-copy">Hey! Thank you for purchasing my product. If you like what I do and you'd like to support my work, the best way to do it is by rating my items on CodeCanyon. You can do that by going at <a href="http://codecanyon.net/">CodeCanyon</a> and clicking on the Downloads tab. Find my product there and click on the stars to give it a rating. Thank you!</p>
					<ul>
						<li><span>Designed and developed by</span><a href="http://www.nikolaydyankovdesign.com"><img src="<?php echo plugins_url('images/admin/my-logo.png', __FILE__); ?>"></a></li>
						<li><span>Available exclusively at</span><a href="http://www.codecanyon.com/?ref=nickys"><img src="<?php echo plugins_url('images/admin/codecanyon-logo.png', __FILE__); ?>"></a></li>
						<li><span>Customer Support</span><a href="http://support.nikolaydyankovdesign.com"><img src="<?php echo plugins_url('images/admin/support.png', __FILE__); ?>"></a></li>
					</ul>
				</footer>
			</div>
			
			<?php
			$this->admin_includes();
			$this->call_plugins();
		}

		function save_options() {
			$options = $this->get_admin_options();
			$id = $_GET['id'];

			if (!isset($_GET['id'])) {
				$id = str_replace(' ', '-', strtolower($_POST['title']));
				$grid = array();
			} else {
				$grid = $options['grids'][$id];
			}
			
			if (!isset($grid['id'])) {
				$grid['new'] = true;
			}
			
			// General			
			$grid['id'] = $id;
			$grid['title'] = $_POST['title'];
			$grid['shortcode'] = $_POST['shortcode'];
			
			// =========== Options
			if (isset($_POST['center_images'])) {
				$grid['settings']['center_images'] = 1;
			} else {
				$grid['settings']['center_images'] = 0;
			}
			if (isset($_POST['scale_images'])) {
				$grid['settings']['scale_images'] = 1;
			} else {
				$grid['settings']['scale_images'] = 0;
			}
			if (isset($_POST['click_action'])) {
				$grid['settings']['click_action'] = $_POST['click_action'];
			}
			if (isset($_POST['show_title_in_lightbox'])) {
				$grid['settings']['show_title_in_lightbox'] = 1;
			} else {
				$grid['settings']['show_title_in_lightbox'] = 0;
			}
			
			if (isset($_POST['width'])) {
				$grid['settings']['width'] = $_POST['width'];
			}
			if (isset($_POST['height'])) {
				$grid['settings']['height'] = $_POST['height'];
			}
			if (isset($_POST['cols'])) {
				$grid['settings']['cols'] = $_POST['cols'];
			}
			if (isset($_POST['min_rows'])) {
				$grid['settings']['min_rows'] = $_POST['min_rows'];
			}
			if (isset($_POST['max_rows'])) {
				$grid['settings']['max_rows'] = $_POST['max_rows'];
			}
			if (isset($_POST['padding'])) {
				$grid['settings']['padding'] = $_POST['padding'];
			}
			if (isset($_POST['interval'])) {
				$grid['settings']['interval'] = $_POST['interval'];
			}
			if (isset($_POST['speed'])) {
				$grid['settings']['speed'] = $_POST['speed'];
			}
			if (isset($_POST['easing'])) {
				$grid['settings']['easing'] = $_POST['easing'];
			}
			if (isset($_POST['auto_width'])) {
				$grid['settings']['auto_width'] = 1;
			} else {
				$grid['settings']['auto_width'] = 0;
			}
			if (isset($_POST['random_heights'])) {
				$grid['settings']['random_heights'] = 1;
			} else {
				$grid['settings']['random_heights'] = 0;
			}
			if (isset($_POST['show_overlay'])) {
				$grid['settings']['show_overlay'] = 1;
			} else {
				$grid['settings']['show_overlay'] = 0;
			}
			if (isset($_POST['result'])) {
				$grid['images'] = json_decode(stripslashes($_POST['result']));
			}			
			
			$options['grids'][$id] = $grid;
			
			update_option($this->admin_options_name, $options);
		}
		function delete_instance() {
			$options = $this->get_admin_options();
			unset($options['grids'][$_GET['id']]);
			update_option($this->admin_options_name, $options);
		}
	
		function shortcodes() {
			add_shortcode('gridgallery', array($this, 'print_shortcode'));
		}
		function print_shortcode($atts) {
			$options = $this->get_admin_options();
			$shortcode = $atts['name'];
			$result = '';
			
			if ($options['grids']) {
				foreach($options['grids'] as $grid) {
					if ($grid['shortcode'] == $shortcode) {
						$images = $grid['images'];
						$id = $grid['id'];
					}
				}
			
				$result = '<div id="dynamic-grid-gallery-' . $id . '">';
			
				if ($images) {
					foreach ($images as $image) {
						$result .= '<div class="dg-cell">';
						$result .= '	<div class="dg-cell-src">' . $image->url . '</div>';
						$result .= '	<div class="dg-cell-title">' . $image->title . '</div>';
						$result .= '	<div class="dg-cell-description">' . $image->description . '</div>';
						$result .= '	<div class="dg-cell-link">' . $image->link . '</div>';
						$result .= '</div>';
					}
				}
			
				$result .= '</div>';
			}

			if ($_GET['page'] == 'grid_gallery') {			
				echo $result;
			} else {
				return $result;
			}
		}
		function get_html_content_for($obj) {
			$content = '';
			
			return $content;
		}
		function update_data() {
			$options = $this->get_admin_options();
			
			if ($options['grids']) {
				foreach ($options['grids'] as $grid) {
					$id = $grid['id'];

					$grid['content'] = $this->get_html_content_for($grid);
				
					$options['grids'][$id] = $grid;
				}
			}
			
			update_option($this->admin_options_name, $options);
		}
	}
}

if (class_exists('GridGallery')) {
	$grid = new GridGallery();
}

add_action('init', array($grid, 'shortcodes'));
add_action('wp_footer', array($grid, 'call_plugins'));
add_action('wp_enqueue_scripts', array($grid, 'user_includes'));
add_action('admin_menu', array($grid, 'init_pages'));

add_filter('publish_post', array($grid, 'update_data'));
add_filter('trash_post', array($grid, 'update_data'));
add_filter('edit_post', array($grid, 'update_data'));
add_filter('edit_category', array($grid, 'update_data'));
add_filter('publish_post', array($grid, 'update_data'));
add_filter('private_to_publish', array($grid, 'update_data'));
add_filter('save_post', array($grid, 'update_data'));


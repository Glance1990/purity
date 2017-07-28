<?php
    function tg_p($gallery, $field, $default = NULL)
    {    
    	global $mikado_options;
    	
    	if($mikado_options && isset($mikado_options[$field])) {
    		print stripslashes($mikado_options[$field]);
    		return;
    	}
    	
        if($gallery == NULL || !isset($gallery->$field) || $gallery->$field === NULL) 
        {
            if($default === NULL)
            {
                print "";
            }
            else
            {
                print stripslashes($default);
            }
        } 
        else 
        {
            print stripslashes($gallery->$field);
        }
    }
    function tg_sel($gallery, $field, $value)
    {
    	global $mikado_options;

    	if($mikado_options && isset($mikado_options[$field]) && $mikado_options[$field] == $value) {
    		print "selected";
    		return;
    	}
    	
        if($gallery == NULL)
            print "";
        else
            if(isset($gallery->$field) && $gallery->$field == $value)
                print "selected";
    }

    global $mikado_parent_page;
    if(!isset($gallery))
        $gallery = new stdClass();
?>

			<?php if($mikado_parent_page != "dashboard") : ?>
            <tr>
            	<td>            	            	
            	<strong><?php _e('Gallery Name', 'Mikado'); ?>:</strong></td>
                <td>
                    <div class="text dark">
                        <input type="text" size="30" name="galleryName" value="<?php tg_p($gallery, "name")  ?>" />
                    </div>
                </td>
                <td><?php _e('This name is the internal name for the gallery.<br />Please avoid non-letter characters such as', 'Mikado'); ?> ', ", *, etc.</td>
            </tr>
            <tr>
            	<td><strong><?php _e('Gallery Description', 'Mikado'); ?>:</strong></td>
                <td>
                    <div class="text dark">
                        <input type="text" size="50" name="galleryDescription" value="<?php tg_p($gallery, "description")  ?>" />
                    </div>
                </td>
                <td><?php _e('This description is for internal use.', 'Mikado'); ?></td>
            </tr> 
            <?php endif ?>
            <tr>
                <td><strong><?php _e('Gallery width', 'Mikado'); ?>:</strong></td>
                <td>
                    <div class="text dark">
                        <input type="text" size="10" name="width" value="<?php tg_p($gallery, "width", "100%")  ?>" />
                    </div>
                </td>
                <td><?php _e('Width of the gallery in pixels or percentage.', 'Mikado'); ?></td>
            </tr>            
            <tr>
                <td><strong><?php _e('Gallery height', 'Mikado'); ?>:</strong></td>
                <td>
                    <div class="text dark">
                        <input type="text" size="10" name="height" value="<?php tg_p($gallery, "height", "500px")  ?>" />
                    </div>
                </td>
                <td><?php _e('Height of the gallery in pixels', 'Mikado'); ?></td>
            </tr>  
            <!--<tr>
                <td><strong><?php _e('Keep same area on resize', 'Mikado'); ?>:</strong></td>
                <td>
                    <div class="commutator off">
                      <div class="is on">On<div class="is off">Off</div></div>
                    </div>
                    <input type="hidden" name="keepArea" value="<?php tg_p($gallery, "keepArea", 'T') ?>" />
                </td>
                <td></td>
            </tr>-->
            <tr>
            	<td><strong><?php _e('Margin', 'Mikado'); ?>:</strong></td>
                <td>
                    <div class="text dark">
                        <input type="text" size="10" name="margin" value="<?php tg_p($gallery, "margin", "10")  ?>" />px
                    </div>
                </td>
                <td></td>
            </tr>
            <?php if($mikado_parent_page != "dashboard") : ?>
            <tr>
                <td><strong><?php _e('Filters', 'Mikado'); ?>:</strong></td>
                <td class="filters">
                    <div class="text dark">
                        
                    </div>
                    <a href="#" class="add button firm">+ Add filter</a>
                    <input type="hidden" name="filters" value="<?php tg_p($gallery, "filters")  ?>" />
                </td>
                <td></td>
            </tr>
            <?php endif ?>
            <tr>
                <td><strong><?php _e('Select the lightbox manager', 'Mikado'); ?>:</strong></td>
                <td>
                    <select name="lightbox">
                    	<optgroup label="Link">
		                    <option value="">No link</option>
	                        <option <?php tg_sel($gallery, "lightbox", "direct")  ?> value="direct">Direct link to image</option>
	                        <option <?php tg_sel($gallery, "lightbox", "attachment-page")  ?> value="attachment-page">Attachment page</option>
                    	</optgroup>
                    	<optgroup label="Lightboxes">                        
	                        <option <?php tg_sel($gallery, "lightbox", "magnific")  ?> value="magnific">Magnific popup</option>
	                        <option <?php tg_sel($gallery, "lightbox", "colorbox")  ?> value="colorbox">ColorBox</option>
	                        <option <?php tg_sel($gallery, "lightbox", "prettyphoto")  ?> value="prettyphoto">Pretty Photo</option>
	                        <option <?php tg_sel($gallery, "lightbox", "fancybox")  ?> value="fancybox">FancyBox</option>
	                        <option <?php tg_sel($gallery, "lightbox", "swipebox")  ?> value="swipebox">SwipeBox</option>
							<option <?php tg_sel($gallery, "lightbox", "lightbox2")  ?> value="lightbox2">LightBox</option>
                    	</optgroup>
                    </select></td>
                <td></td>
            </tr>
            <tr>
                <td><strong><?php _e('Open links in _blank', 'Mikado'); ?>:</strong></td>
                <td>
                    <div class="commutator off">
                      <div class="is on">On<div class="is off">Off</div></div>
                    </div>
                    <input type="hidden" name="blank" value="<?php tg_p($gallery, "blank", 'F') ?>" />
                </td>
                <td></td>
            </tr>
            <tr>
                <td><strong><?php _e('Include FontAwesome', 'Mikado'); ?>:</strong></td>
                <td>
                    <div class="commutator off">
                      <div class="is on">On<div class="is off">Off</div></div>
                    </div>
                    <input type="hidden" name="includeFontawesome" value="<?php tg_p($gallery, "includeFontawesome", 'T') ?>" />
                </td>
                <td></td>
            </tr>
            <tr>
	            <td><strong><?php _e('WordPress caption field', 'TilesGallery'); ?>:</strong></td>
	            <td>
		            <select name="wp_field_caption">
		            	<option value="">Don't use captions</option>
		            	<option <?php tg_sel($gallery, "wp_field_caption", "title")  ?>  value="title">Title</option>
		            	<option <?php tg_sel($gallery, "wp_field_caption", "caption")  ?> value="caption">Caption</option>
		            	<option <?php tg_sel($gallery, "wp_field_caption", "description")  ?> value="description">Description</option>
		            </select>
	            </td>
	            <td>Wordpress field to use as caption when importing images</td>
            </tr>
            <tr>
                <td><strong><?php _e('Caption icon', 'TilesGallery'); ?>:</strong></td>
                <td>
                    <select name="captionIcon">
                        <option value="">None</option>
                        <option <?php tg_sel($gallery, "captionIcon", "search")  ?> value="search">Lens</option>
                        <option <?php tg_sel($gallery, "captionIcon", "search-plus")  ?> value="search-plus">Lens (plus)</option>
                        <option <?php tg_sel($gallery, "captionIcon", "link")  ?> value="link">Link</option>
                        <option <?php tg_sel($gallery, "captionIcon", "heart")  ?> value="heart">Heart</option>
                        <option <?php tg_sel($gallery, "captionIcon", "heart-o")  ?> value="heart-o">Heart empty</option>
                        <option <?php tg_sel($gallery, "captionIcon", "camera")  ?> value="camera">Camera</option>
                        <option <?php tg_sel($gallery, "captionIcon", "camera-retro")  ?> value="camera-retro">Camera retro</option>
                        <option <?php tg_sel($gallery, "captionIcon", "picture-o")  ?> value="picture-o">Picture</option>
                        <option <?php tg_sel($gallery, "captionIcon", "star")  ?> value="star">Star</option>
                        <option <?php tg_sel($gallery, "captionIcon", "star-o")  ?> value="sun-o">Star empty</option>
                        <option <?php tg_sel($gallery, "captionIcon", "sun-o")  ?> value="sun-o">Sun</option>
                        <option <?php tg_sel($gallery, "captionIcon", "arrows-alt")  ?> value="arrows-alt">Arrows</option>
                        <option <?php tg_sel($gallery, "captionIcon", "hand-o-right")  ?> value="hand-o-right">Hand</option>
                    </select></td>
                <td></td>
            </tr>
            <tr>
                <!-- http://make.wordpress.org/core/2012/11/30/new-color-picker-in-wp-3-5/ -->
            	<td><strong><?php _e('Caption icon color', 'TilesGallery'); ?>:</strong></td>
                <td><input type="text" size="6" data-default-color="#ffffff" name="captionIconColor" value="<?php tg_p($gallery, "captionIconColor", "#ffffff")  ?>" class='pickColor' /></td>
                <td></td>
            </tr>
            <tr>
                <td><strong><?php _e('Caption effect', 'TilesGallery'); ?>:</strong></td>
                <td>
                    <select name="captionEffect">
                        <option <?php tg_sel($gallery, "captionEffect", "fade")  ?> value="fade">Fade</option>
                        <option <?php tg_sel($gallery, "captionEffect", "slide-top")  ?> value="slide-top">Slide from top</option>
                        <option <?php tg_sel($gallery, "captionEffect", "slide-bottom")  ?> value="slide-bottom">Slide from bottom</option>
                        <option <?php tg_sel($gallery, "captionEffect", "slide-left")  ?> value="slide-left">Slide from left</option>
                        <option <?php tg_sel($gallery, "captionEffect", "slide-right")  ?> value="slide-right">Slide from right</option>
                    </select>
                </td>
                <td></td>
            </tr>
            <tr>
                <td><strong><?php _e('Caption effect easing', 'Mikado'); ?>:</strong></td>
                <td>
                    <select name="captionEasing">
                    <?php foreach(array('swing', 'easeInQuad', 'easeOutQuad', 'easeInOutQuad', 'easeInCubic', 'easeOutCubic', 'easeInOutCubic', 'easeInQuart', 'easeOutQuart', 'easeInOutQuart', 'easeInQuint', 'easeOutQuint', 'easeInOutQuint', 'easeInSine', 'easeOutSine', 'easeInOutSine', 'easeInExpo', 'easeOutExpo', 'easeInOutExpo', 'easeInCirc', 'easeOutCirc', 'easeInOutCirc', 'easeInElastic', 'easeOutElastic', 'easeInOutElastic', 'easeInBack', 'easeOutBack', 'easeInOutBack', 'easeInBounce', 'easeOutBounce', 'easeInOutBounce') as $easing) : ?>
                        <option <?php tg_sel($gallery, "captionEasing", $easing)  ?> value="<?php print $easing ?>"><?php print $easing ?></option>
                    <?php endforeach ?>
                    </select>
                </td>
                <td></td>
            </tr>
            <tr>
                <!-- http://make.wordpress.org/core/2012/11/30/new-color-picker-in-wp-3-5/ -->
            	<td><strong><?php _e('Caption color', 'Mikado'); ?>:</strong></td>
                <td><input type="text" size="6" data-default-color="#FFFFFF" name="captionColor" value="<?php tg_p($gallery, "captionColor", "#FFFFFF")  ?>" class='pickColor' /></td>
                <td></td>
            </tr>
            <tr>
                <!-- http://make.wordpress.org/core/2012/11/30/new-color-picker-in-wp-3-5/ -->
            	<td><strong><?php _e('Caption background color', 'Mikado'); ?>:</strong></td>
                <td><input type="text" size="6" data-default-color="#000000" name="captionBackgroundColor" value="<?php tg_p($gallery, "captionBackgroundColor", "#000000")  ?>" class='pickColor' /></td>
                <td></td>
            </tr>
            <tr>
                <td><strong><?php _e('Caption effect duration', 'Mikado'); ?>:</strong></td>
                <td>
                    <div class="scrollbox js-scrollbox disk" data-step="50" data-max="1000" data-min="50">
                        <div class="hitbox"></div>
                        <div class="scale" style="width: 50%"></div>
                    </div> 
                    <span><?php tg_p($gallery, "captionEffectDuration", 250) ?></span> ms
                    <input type="hidden" value="<?php tg_p($gallery, "captionEffectDuration", 250) ?>" name="captionEffectDuration" />
                </td>
                <td></td>
            </tr>
            <tr>
                <td><strong><?php _e('Caption opacity', 'Mikado'); ?>:</strong></td>
                <td>
                    <div class="scrollbox js-scrollbox disk" data-step="1" data-max="100" data-min="10">
                        <div class="hitbox"></div>
                        <div class="scale" style="width: 50%"></div>
                    </div> 
                    <span><?php tg_p($gallery, "captionOpacity", 80) ?></span>%
                    <input type="hidden" value="<?php tg_p($gallery, "captionOpacity", 80) ?>" name="captionOpacity" />
                </td>
                <td></td>
            </tr>
            <!--<tr>
                <td><strong><?php _e('Effect on page scroll', 'Mikado'); ?>:</strong></td>
                <td>
                    <select name="scrollEffect">
                        <option <?php tg_sel($gallery, "scrollEffect", "slide")  ?> value="slide">Slide</option>
                        <option <?php tg_sel($gallery, "scrollEffect", "zoom")  ?> value="zoom">Zoom</option>
                    </select>
                </td>
                <td></td>
            </tr>-->
            <tr>
                <td><strong><?php _e('Shuffle images', 'Mikado'); ?>:</strong></td>
                <td>
                    <div class="commutator off">
                      <div class="is on">On<div class="is off">Off</div></div>
                    </div>
                    <input type="hidden" name="shuffle" value="<?php tg_p($gallery, "shuffle", 'F') ?>" />
                </td>
                <td><?php _e('Choose "Yes" if you want to shuffle the gallery at each page reload', 'Mikado'); ?></td>
            </tr>
            <tr>
                <td><strong><?php _e('Add Twitter icon', 'Mikado'); ?>:</strong></td>
                <td>
                    <div class="commutator off">
                      <div class="is on">On<div class="is off">Off</div></div>
                    </div>
                    <input type="hidden" name="enableTwitter" value="<?php tg_p($gallery, "enableTwitter", 'F') ?>" />
                </td>
                <td></td>
            </tr>
            <tr>
                <td><strong><?php _e('Add Facebook icon', 'Mikado'); ?>:</strong></td>
                <td>
                    <div class="commutator off">
                      <div class="is on">On<div class="is off">Off</div></div>
                    </div>
                    <input type="hidden" name="enableFacebook" value="<?php tg_p($gallery, "enableFacebook", 'F') ?>" />
                </td>
                <td></td>
            </tr>
            <tr>
                <td><strong><?php _e('Add Google Plus icon', 'Mikado'); ?>:</strong></td>
                <td>
                    <div class="commutator off">
                      <div class="is on">On<div class="is off">Off</div></div>
                    </div>
                    <input type="hidden" name="enableGplus" value="<?php tg_p($gallery, "enableGplus", 'F') ?>" />
                </td>
                <td></td>
            </tr>
            <tr>
                <td><strong><?php _e('Add Pinterest icon', 'Mikado'); ?>:</strong></td>
                <td>
                    <div class="commutator off">
                      <div class="is on">On<div class="is off">Off</div></div>
                    </div>
                    <input type="hidden" name="enablePinterest" value="<?php tg_p($gallery, "enablePinterest", 'F') ?>" />
                </td>
                <td></td>
            </tr>            
            <tr>
                <td><strong><?php _e('Border size', 'Mikado'); ?>:</strong></td>
                <td>
                    <div class="scrollbox js-scrollbox disk" data-step="1" data-max="10" data-min="0">
                        <div class="hitbox"></div>
                        <div class="scale" style="width: 50%"></div>
                    </div> 
                    <span><?php tg_p($gallery, "borderSize", 0) ?></span> px
                    <input type="hidden" value="<?php tg_p($gallery, "borderSize", 0) ?>" name="borderSize" />
                </td>
                <td></td>
            </tr>
            <tr>
                <td><strong><?php _e('Border radius', 'Mikado'); ?>:</strong></td>
                <td>
                    <div class="scrollbox js-scrollbox disk" data-step="1" data-max="100" data-min="0">
                        <div class="hitbox"></div>
                        <div class="scale" style="width: 50%"></div>
                    </div> 
                    <span><?php tg_p($gallery, "borderRadius", 0) ?></span> px
                    <input type="hidden" value="<?php tg_p($gallery, "borderRadius", 0) ?>" name="borderRadius" />
                </td>
                <td></td>
            </tr>
            <tr>
                <!-- http://make.wordpress.org/core/2012/11/30/new-color-picker-in-wp-3-5/ -->
                <td><strong><?php _e('Border color', 'Mikado'); ?>:</strong></td>
                <td><input type="text" size="6" data-default-color="#fff" name="borderColor" value="<?php tg_p($gallery, "borderColor", "#cccccc")  ?>" class='pickColor' /></td>
                <td></td>
            </tr>
            <tr>
                <td><strong><?php _e('Shadow size', 'Mikado'); ?>:</strong></td>
                <td>
                    <div class="scrollbox js-scrollbox disk" data-step="1" data-max="20" data-min="0">
                        <div class="hitbox"></div>
                        <div class="scale" style="width: 50%"></div>
                    </div> 
                    <span><?php tg_p($gallery, "shadowSize", 0) ?></span> px
                    <input type="hidden" value="<?php tg_p($gallery, "shadowSize", 0) ?>" name="shadowSize" />
                </td>
                <td></td>
            </tr>
            <tr>
                <!-- http://make.wordpress.org/core/2012/11/30/new-color-picker-in-wp-3-5/ -->
                <td><strong><?php _e('Shadow color', 'Mikado'); ?>:</strong></td>
                <td><input type="text" size="6" data-default-color="#000" name="shadowColor" value="<?php tg_p($gallery, "shadowColor", "#000000")  ?>" class='pickColor' /></td>
                <td></td>
            </tr>            
            <tr>
                <td><strong><?php _e('Custom CSS', 'Mikado'); ?>:</strong></td>
                <td>
                    <div class="text dark">
                        <textarea name="style"><?php tg_p($gallery, "style", "") ?></textarea>
                    </div>
                </td>
                <td class="instructions">
                    <strong>Write just the code without using the &lt;style&gt; tag.</strong>                   
                </td>
            </tr>
            <tr>
                <td><strong><?php _e('Custom Javascript', 'Mikado'); ?>:</strong></td>
                <td>
                    <div class="text dark">
                        <textarea name="script"><?php tg_p($gallery, "script", "") ?></textarea>
                    </div>
                </td>
                <td class="instructions">
                    This script will be called after the gallery initialization. Useful for custom lightboxes.
                    <br />
                    <br />
                    <strong>Write just the code without using the &lt;script&gt;&lt;/script&gt; tags</strong>
                </td>
            </tr>
            
            <script>
            jQuery("tr:even").addClass("alternate");
            var mikado_wp_caption_field = '<?php tg_p($gallery, "wp_field_caption")  ?>';
           </script>
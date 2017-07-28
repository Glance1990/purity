<?php
    if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

    if(isset($_POST['galleryId'])) 
    {
    	if(check_admin_referer('Mikado','Mikado')) {
    	  $this->MikadoDB->deleteGallery(intval($_POST['galleryId']));
    		  
    	  ?>  
    	  <div class="updated"><p><strong><?php _e('Gallery has been deleted.', 'Mikado'); ?></strong></p></div>  
    	  <?php	
    	}
    }

    $galleryResults = $this->MikadoDB->getGalleries();
	
	
    if (isset($_POST['defaultSettings'])) 
    {
    	if(check_admin_referer('Mikado','Mikado')) 
        {
    	  $temp_defaults = get_option('mikado_options');
    	  
    	  $fields = array('margin', 'defaultSize', 'width', 'height', 'lightbox',
    	  			        'captionIcon', 'captionIconColor', 'captionColor', 'captionBackgroundColor',
    	  			        'captionEffectDuration', 'captionEffect', 'captionEffectEasing',
    	  			        'captionOpacity', 'shuffle', 'enableTwitter', 'enableFacebook', 
    	  			        'enablePinterest', 'enableGplus', 'borderSize', 'borderRadius', 'borderColor',
    	  			        'shadowSize', 'shadowColor', 'style', 'script', 'wp_field_caption',
    	  			        'blank');
    	  			
    	  foreach($fields as $f)
    	  {
		      	$temp_defaults[$f] = $_POST[$f];
    	  }
    	  
    	  update_option('mikado_options', $temp_defaults);
    	  ?>  
    	  <div class="updated"><p><strong><?php _e('Gallery options have been updated.', 'Mikado'); ?></strong></p></div>  
    	  <?php
    	}
    }

    function list_thumbnail_sizes()
    {
    	global $_wp_additional_image_sizes;
        $sizes = array();
     	foreach( get_intermediate_image_sizes() as $s )
     	{
     		$sizes[ $s ] = array( 0, 0 );
     		if( in_array( $s, array( 'thumbnail', 'medium', 'large' ) ) )
     		{
     			$sizes[ $s ][0] = get_option( $s . '_size_w' );
     			$sizes[ $s ][1] = get_option( $s . '_size_h' );
     		}
     		else
     		{
     			if( isset( $_wp_additional_image_sizes ) &&  isset( $_wp_additional_image_sizes[ $s ] ) )
     				$sizes[ $s ] = array( $_wp_additional_image_sizes[ $s ]['width'], 	$_wp_additional_image_sizes[ $s ]['height'], );
     			}
     		}
     		
     		return $sizes; 		
     }

	global $mikado_options;
    $mikado_options = get_option('mikado_options');
    
?>
<div class='wrap'>

<?php include("adv.php") ?>

<h2>Mikado</h2>
<p><?php _e('This is a listing of all galleries', 'Mikado'); ?></p>
    <table class="widefat post fixed" id="galleryResults" cellspacing="0">
    	<thead>
        <tr>
        	<th><?php _e('Gallery Name', 'Mikado'); ?></th>
            <th><?php _e('Gallery Short Code', 'Mikado'); ?></th>
            <th><?php _e('Description', 'Mikado'); ?></th>
            <th width="136"></th>
        </tr>
        </thead>
        <tfoot>
        <tr>
        	<th><?php _e('Gallery Name', 'Mikado'); ?></th>
            <th><?php _e('Gallery Short Code', 'Mikado'); ?></th>
            <th><?php _e('Description', 'Mikado'); ?></th>
            <th></th>
        </tr>
        </tfoot>
        <tbody>
        	<?php foreach($galleryResults as $gallery) { ?>				
            <tr>
            	<td><?php _e($gallery->name); ?></td>
                <td>
                    <div class="text dark">
                        <input type="text" size="40" value="[Mikado id='<?php _e($gallery->Id); ?>']" />
                    </div>
                </td>
                <td><?php _e($gallery->description); ?></td>
                <td class="major-publishing-actions">
                <form name="delete_gallery_<?php _e($gallery->Id); ?>" method ="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
                	<?php wp_nonce_field('Mikado', 'Mikado'); ?>
                	<input type="hidden" name="galleryId" value="<?php _e($gallery->Id); ?>" />
                    <input type="submit" name="Submit" class="button action" value="<?php _e('Delete Gallery', 'Mikado'); ?>" />
                </form>
                </td>
            </tr>
			<?php } ?>
        </tbody>
     </table>
     <br />
     <h3><?php _e('Default Options', 'Mikado'); ?></h3>
     <form name="save_default_settings" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
     <?php wp_nonce_field('Mikado', 'Mikado'); ?>
     <table class="widefat post fixed" cellspacing="0">
     	<thead>
        	<th><?php _e('Attribute', 'Mikado'); ?></th>
            <th><?php _e('Default Value', 'Mikado'); ?></th>
            <th><?php _e('Description', 'Mikado'); ?></th>
        </thead>
        <tfoot>
        	<th><?php _e('Attribute', 'Mikado'); ?></th>
            <th><?php _e('Default Value', 'Mikado'); ?></th>
            <th><?php _e('Description', 'Mikado'); ?></th>
        </tfoot>
        <tbody>        	
            <tr>
                <td>Image size</td>
                <td>
                    <div class="text dark">
                        <select name="defaultSize">
                        <?php
                        foreach (list_thumbnail_sizes() as $size => $atts) 
						{ 
				 			print '<option '. ($mikado_options['defaultSize'] == $size ? "selected" : "") .' value="'. $size .'">' . $size . " (" . implode( 'x', $atts ) . ")</option>";
						}
                        ?>
                        </select>
                    </div>
                </td>
                <td></td>
            </tr>
            <?php 
            	global $mikado_parent_page;
            	$mikado_parent_page = "dashboard";
            ?>
            <?php include("include/edit-gallery.php") ?>
            <tr>
            	<td>                
                	<input type="hidden" name="defaultSettings" value="true" />
                    <input type="submit" name="Submit" class="button action" value="<?php _e('Save', 'Mikado'); ?>" />                
                </td>
                <td></td>
                <td>
            </tr>
        </tbody>
     </table>
     </form>
     
</div>
<?php
	if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }
	
	global $mikado_options;
	$mikado_options = get_option('Mikado_options');
	
?>
<div class='wrap'>
    <?php include("adv.php") ?>
<h2>Mikado - <?php _e('Add Gallery', 'Mikado'); ?></h2>

	
    <p><?php _e('This is where you can create new galleries. Once the new gallery has been added, a short code will be provided for use in posts.', 'Mikado'); ?></p>
    
    <form name="gallery_form" id="gallery_form" action="?" method="post">
    <?php wp_nonce_field('Mikado', 'Mikado'); ?>
    <input type="hidden" name="add_gallery" value="true" />
    <table class="widefat post fixed" cellspacing="0" id="settings">
    	<thead>
        <tr>
        	<th width="250"><?php _e('Attribute', 'Mikado'); ?></th>
            <th><?php _e('Value', 'Mikado'); ?></th>
            <th><?php _e('Description', 'Mikado'); ?></th>
        </tr>
        </thead>
        <tfoot>
        <tr>
        	<th><?php _e('Attribute', 'Mikado'); ?></th>
            <th><?php _e('Value', 'Mikado'); ?></th>
            <th><?php _e('Description', 'Mikado'); ?></th>
        </tr>
        </tfoot>
        <tbody>
        	<?php include("include/edit-gallery.php") ?>
            <tr>
            	<td class="major-publishing-actions">
                    <input id="add-gallery" type="submit" name="Submit" class="button-huge button action" value="<?php _e('Add Gallery', 'Mikado'); ?>" />
                </td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
	</table>
    </form>
</div>

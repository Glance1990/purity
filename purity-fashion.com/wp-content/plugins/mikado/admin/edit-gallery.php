<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

$galleryResults = $this->MikadoDB->getGalleries();
$mikado_options = get_option('Mikado_options');

$gallery = null;
//Select gallery
if(isset($_POST['select_gallery']) || isset($_POST['galleryId'])) {
	if(check_admin_referer('Mikado','Mikado')) {
	  $gid = (isset($_POST['select_gallery'])) ? intval(stripslashes($_POST['select_gallery'])) : intval(stripslashes($_POST['galleryId']));	
	  
	  $imageResults = $this->MikadoDB->getImagesByGalleryId($gid);
	  $gallery = $this->MikadoDB->getGalleryById($gid);      
	}
}

?>
<div class='wrap'>
    <?php include("adv.php") ?>

<h2>Mikado - <?php _e('Edit Galleries', 'Mikado'); ?></h2>
<?php if(!isset($_POST['select_gallery']) && !isset($_POST['galleryId'])) { ?>
    <p><?php _e('Select a gallery to edit its properties', 'Mikado'); ?></p>		
    <table class="widefat post fixed" id="galleryResults" cellspacing="0">
	<thead>
    	<tr>
          <th><?php _e('Gallery Name', 'Mikado'); ?></th>
          <th><?php _e('Description', 'Mikado'); ?></th>
          <th></th>
          <th></th>
        </tr>
    </thead>
    <tfoot>
    	<tr>
          <th><?php _e('Gallery Name', 'Mikado'); ?></th>
          <th><?php _e('Description', 'Mikado'); ?></th>
          <th></th>
          <th></th>
        </tr>
    </tfoot>
    <tbody>
    	<?php
			foreach($galleryResults as $gallery) {
				?>
                <tr>
                	<td><?php _e($gallery->name); ?></td>
                    <td><?php _e($gallery->description); ?></td>
                    <td></td>
                    <td>
                    	<form name="select_gallery_form" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" method="post">
                    	<?php wp_nonce_field('Mikado', 'Mikado'); ?>
                        <input type="hidden" name="galleryId" value="<?php _e($gallery->Id); ?>" />
                        <input type="hidden" name="galleryName" value="<?php _e($gallery->name); ?>" />
                        <input type="submit" name="Submit" class="button action" value="<?php _e('Select Gallery', 'Mikado'); ?>" />
                		</form>
                    </td>
                </tr>
		<?php } ?>
        <tr>
        </tr>
    </tbody>
</table>
    
    <?php } else if(isset($_POST['select_gallery']) || isset($_POST['galleryId'])) { ?>  

        <h3>Gallery: <?php _e($gallery->name); ?></h3>        
        
        <div class="mbl">
            <div class="header">
                <div class="wrapper">
                    <ul class="header-navigation" id="gallery-edit-nav">
                        <li class="current">
                            <a href="#settings">Settings</a>
                        </li>
                        <li>
                            <a href="#images">Images</a>                            
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="settings">
            <form name="gallery_form" id="gallery_form" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" method="post">
            <?php wp_nonce_field('Mikado', 'Mikado'); ?>
            <input type="hidden" name="ftg_gallery_edit" id="gallery-id" value="<?php _e($gid); ?>" />
            <table class="widefat post fixed" cellspacing="0">
            	<thead>
                <tr>
                	<th width="250"><?php _e('Attribute Name', 'Mikado'); ?></th>
                    <th><?php _e('Value', 'Mikado'); ?></th>
                    <th><?php _e('Description', 'Mikado'); ?></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                	<th><?php _e('Attribute Name', 'Mikado'); ?></th>
                    <th><?php _e('Value', 'Mikado'); ?></th>
                    <th><?php _e('Description', 'Mikado'); ?></th>
                </tr>
                </tfoot>
                <tbody>
                	<?php include("include/edit-gallery.php") ?>
                    <tr>
                    	<td class="major-publishing-actions"><input id="edit-gallery" type="submit" name="Submit" class="button button-huge action" value="<?php _e('Update Gallery', 'Mikado'); ?>" /></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
        	</table>
            </form>
        </div>

        <!-- images section -->
        <div id="images">
            
            <div class="actions">
                <a href="#" class="open-media-panel button action">Add images</a>
                <span class="tip">For multiple selections: Click+CTRL.</span>
                <span class="tip">Drag images to change order.</span>
            </div>
            <div class="bulk">
                <h4>Bulk Actions</h4>
                <div class="options">
                    <a href="#" data-action="select">Select all</a>
                    <a href="#" data-action="deselect">Deselect all</a>
                    <a href="#" data-action="toggle">Toggle selection</a>
                    <a href="#" data-action="remove">Remove</a>
                    <a href="#" data-action="filter">Assign filters</a>
                </div>
                <div class="panel">
                    <strong></strong>
                    <p class="text"></p>
                    <p class="buttons">
                        <a class="button mrm cancel" href="#">Cancel</a>
                        <a class="button mrm proceed firm" href="#">Proceed</a>
                    </p>
                </div>
            </div>
            <div id="image-list"></div>

            <!-- image panel -->
            <div id="image-panel-model" style="display:none">
                <a href="#" class="close" title="Close">X</a>
                <div class="clearfix">
                    <div class="left">
                        <div class="figure"></div>
                        <div class="field sizes"></div>                        
                    </div>
                    <div class="right">
                        <div class="field">
                            <label>Caption</label>
                            <div class="text dark">
                                <textarea name="description"></textarea>
                            </div>                            
                        </div>
                        <div class="field">
                        	<label for="alignment">Alignment</label>	                        
	                        <select name="halign">
		                        <option>left</option>
		                        <option selected>center</option>
		                        <option>right</option>		                        
	                        </select>
	                        <select name="valign">
		                        <option>top</option>
		                        <option selected>middle</option>
		                        <option>bottom</option>		                        
	                        </select>
                        </div>
                        <div class="field">
                            <label>Link</label>
							<div class="text dark">
                                <input type="text" size="20" value="" name="link" />
                                <select name="target">
                                	<option value="">Default target</option>
                                	<option value="_self">Open in same page</option>
                                	<option value="_blank">Open in _blank</option>                                      
                                </select>
                            </div>
                        </div>                    
                    </div>
                </div>
                <div class="field filters clearfix"></div>
                <div class="field buttons">
                    <a href="#" data-action="cancel" class="button action neutral">Cancel</a>
                    <a href="#" data-action="save" class="button action positive">Save</a>
                </div>
            </div>
        </div>
        <pre>

        </pre>
        <script>
            jQuery(function () {
                var $ = jQuery;
                $("#gallery-edit-nav a").click(function (e) {
                    e.preventDefault();
                    var target = $(this).attr("href");
                    $("#images, #settings").hide();
                    $(target).show();

                    $("#gallery-edit-nav li").removeClass("current");
                    $(this).parent().addClass("current");
                });
                TG.defaultImageSize = "<?php print $mikado_options['defaultSize'] ?>";
				TG.blank = <?php print $gallery->blank == 'T' ? "true" : "false" ?>;
                TG.load_images();
                TG.init_gallery();
            });
        </script>
    <?php } ?>  
</div>
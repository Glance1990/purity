<?php
/*  
 * 2J Gallery			http://2joomla.net/wordpress-plugins/2j-gallery
 * Version:           	2.0.7 - 55767
 * Author:            	2J Team (c)
 * Author URI:        	http://2joomla.net
 * License:           	GPL-2.0+
 * License URI:       	http://www.gnu.org/licenses/gpl-2.0.txt
 * Date:              	Mon, 03 Apr 2017 16:27:39 GMT
 */

if(!TWOJ_GALLERY_FULL_VERSION){
	function twoj_gallery_hide_attachment_fields() {
		echo "<style>"
			.".compat-attachment-fields tr.compat-field-".TWOJ_GALLERY."line{  }"	
			.".compat-attachment-fields tr.compat-field-".TWOJ_GALLERY."type_link,"
			.".compat-attachment-fields tr.compat-field-".TWOJ_GALLERY."link{  
				z-index: 1000; 
				opacity: 0.4; 
				pointer-events: none;
		}</style>";
	}
	add_action('admin_head', 'twoj_gallery_hide_attachment_fields');
}


function twoj_gallery_attachment_fields( $form_fields, $post ) {
	
	$form_fields[TWOJ_GALLERY.'line'] = array(
		'label' => '',
		'input' => 'html',
		'html' 	=> '<br/><h4>'.__('2J Gallery Premium options', 'blog-mechanics-theme-gallery').'</h4>'
	);

	if(!TWOJ_GALLERY_FULL_VERSION){
		$form_fields[TWOJ_GALLERY.'buy'] = array(
			'label' => '',
			'input' => 'html',
			'html' 	=> '<a class="button-primary twoj-gallery-option-premium" target="_blank" href="'.TWOJ_GALLERY_PREMIUM_LINK.'">'.__('BUY NOW', 'blog-mechanics-theme-gallery').'</a>'
		);
	}
		
	$form_fields[TWOJ_GALLERY.'link'] = array(
		'label' => __('Link'),
		'input' => 'text',
		'value' => get_post_meta( $post->ID, TWOJ_GALLERY.'link', true ),
	);

	$value = get_post_meta( $post->ID, TWOJ_GALLERY.'type_link', true );
	//$value = !$value?'blank':'';

	$selectBox = 
	"<select name='attachments[{$post->ID}][".TWOJ_GALLERY."type_link]' id='attachments[{$post->ID}][".TWOJ_GALLERY."type_link]'>
		<option value='self' "	.($value=='self'	?'selected':'').">".__( 'Self' )."</option>
		<option value='blank' "	.($value=='blank' 	?'selected':'').">".__( 'Blank' )."</option>
		<option value='video' "	.($value=='video' 	?'selected':'').">".__( 'Video' )."</option>
	</select>";

	$form_fields[TWOJ_GALLERY.'type_link'] = array(
		'label' 	=> __('Blank Link'),
		'input' 	=> 'html',
		'default' 	=> 'blank',
		'value' 	=> $value,
		'html' 		=> $selectBox 
	);

	return $form_fields;
}
add_filter( 'attachment_fields_to_edit', 'twoj_gallery_attachment_fields', 10, 2 );


function twoj_gallery_attachment_fields_save( $post, $attachment ) {
	
	if( isset( $attachment[TWOJ_GALLERY.'link'] ) )
		update_post_meta( $post['ID'], TWOJ_GALLERY.'link', 		esc_url( $attachment[TWOJ_GALLERY.'link'] ) );
	
	if( isset( $attachment[TWOJ_GALLERY.'type_link'] ) )
		update_post_meta( $post['ID'], TWOJ_GALLERY.'type_link',  	$attachment[TWOJ_GALLERY.'type_link'] );
	
	return $post;
}
add_filter( 'attachment_fields_to_save', 'twoj_gallery_attachment_fields_save', 10, 2 );
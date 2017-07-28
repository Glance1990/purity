<?php
/**
 * Plugin Name: DV Gallery
 * Plugin URI: http://codecanyon.net/item/dv-gallery-responsive-wordpress-gallery-plugin/9794784?ref=egemenerd
 * Description: Premium gallery plugin
 * Version: 1.6.1
 * Author: egemenerd
 * Author URI: http://codecanyon.net/user/egemenerd?ref=egemenerd
 * License: http://codecanyon.net/licenses?ref=egemenerd
 */

/* Language File */

add_action( 'init', 'dvgallerydomain' );

function dvgallerydomain() {
	load_plugin_textdomain( 'dvgallery', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

/*---------------------------------------------------
Register Scripts
----------------------------------------------------*/

function dvgallery_scripts(){
    wp_enqueue_style('dv_styles', plugin_dir_url( __FILE__ ) . 'css/style.css', true, '1.0');
    wp_enqueue_style('dv_lightgallery_style', plugin_dir_url( __FILE__ ) . 'css/lightgallery.css', true, '1.0');
    wp_enqueue_style('dv_owl_style', plugin_dir_url( __FILE__ ) . 'css/owl.css', true, '1.0');
    if (is_rtl()) {
        wp_enqueue_style('dv_styles_rtl', plugin_dir_url( __FILE__ ) . 'css/rtl.css', true, '1.0');
    }
    wp_enqueue_script("jquery");
    wp_register_script('dv_lightgallery',plugin_dir_url( __FILE__ ).'js/lightgallery.js','','',true);
    wp_register_script('dv_owl',plugin_dir_url( __FILE__ ).'js/owl.js','','',true);
    wp_register_script('dv_wookmark',plugin_dir_url( __FILE__ ).'js/wookmark.js','','',true);
    wp_register_script('dv_backstretch',plugin_dir_url( __FILE__ ).'js/backstretch.min.js','','',true);
    wp_enqueue_script('dv_lightgallery');
    wp_enqueue_script('dv_owl');
    wp_enqueue_script('dv_wookmark');
    wp_enqueue_script('dv_backstretch');
}
add_action('wp_enqueue_scripts','dvgallery_scripts');

function dvshc_css() {
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');
    wp_enqueue_style('dvshc-adminstyle', plugins_url('css/panel.css', __FILE__));
    wp_enqueue_style('dvshc-toggles', plugins_url('css/toggles.css', __FILE__));
    wp_enqueue_style('dvshc-select', plugins_url('css/select.css', __FILE__));  
    wp_enqueue_script('dv_panel_script', plugin_dir_url( __FILE__ ) . 'js/panel.js','','',true);
    wp_enqueue_script('dv_panel_toggles_script', plugin_dir_url( __FILE__ ) . 'js/toggles.js','','',true);
    wp_enqueue_script('dv_panel_select_script', plugin_dir_url( __FILE__ ) . 'js/select.js','','',true);
}

add_action('admin_enqueue_scripts', 'dvshc_css');

/*---------------------------------------------------
Custom Image Sizes
----------------------------------------------------*/

add_image_size( 'dv-post-thumbnail', 600, 400, true);
add_filter('image_size_names_choose', 'dv_image_sizes');

if ( ! function_exists( 'dv_image_sizes' ) ) {
function dv_image_sizes($dvsizes) {
    $dvaddsizes = array(
        "dv-post-thumbnail" => esc_attr__( 'DV Gallery Post Thumbnail', 'dvgallery')
    );
    $dvnewsizes = array_merge($dvsizes, $dvaddsizes);
    return $dvnewsizes;
}
}

/*---------------------------------------------------
Tinymce custom buttons
----------------------------------------------------*/

if ( ! function_exists( 'dvshortcodes_add_button' ) ) {
add_action('init', 'dvshortcodes_add_button');  
function dvshortcodes_add_button() {  
   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )  
   {  
     add_filter('mce_external_plugins', 'dv_add_plugin');  
     add_filter('mce_buttons_3', 'dv_register_button');  
   }  
} 
}

if ( ! function_exists( 'dv_register_button' ) ) {
function dv_register_button($buttons) {
    array_push($buttons, "dvgalleries");
    array_push($buttons, "dvcarousel");
    array_push($buttons, "dvgrid");
    array_push($buttons, "dvgridfilter");
    array_push($buttons, "dvsquare");
    return $buttons;  
}  
}

if ( ! function_exists( 'dv_add_plugin' ) ) {
function dv_add_plugin($plugin_array) {
    $plugin_array['dvgalleries'] = plugin_dir_url( __FILE__ ) . 'js/shortcodes.js';
    $plugin_array['dvcarousel'] = plugin_dir_url( __FILE__ ) . 'js/shortcodes.js';
    $plugin_array['dvgrid'] = plugin_dir_url( __FILE__ ) . 'js/shortcodes.js';
    $plugin_array['dvgridfilter'] = plugin_dir_url( __FILE__ ) . 'js/shortcodes.js';
    $plugin_array['dvsquare'] = plugin_dir_url( __FILE__ ) . 'js/shortcodes.js';
    return $plugin_array;  
}
}

/* ---------------------------------------------------------
Custom Metaboxes - https://github.com/WebDevStudios/CMB2
----------------------------------------------------------- */

// Check for  PHP version and use the correct dir
$dvgallerydir = ( version_compare( PHP_VERSION, '5.3.0' ) >= 0 ) ? __DIR__ : dirname( __FILE__ );

if ( file_exists(  $dvgallerydir . '/cmb2/init.php' ) ) {
	require_once  $dvgallerydir . '/cmb2/init.php';
} elseif ( file_exists(  $dvgallerydir . '/CMB2/init.php' ) ) {
	require_once  $dvgallerydir . '/CMB2/init.php';
}

/* ---------------------------------------------------------
Add Featured Image Support for DV Gallery Custom Post Type
----------------------------------------------------------- */

function DvgalleryAddFeatured() {

    global $_wp_theme_features;

    if( empty($_wp_theme_features['post-thumbnails']) )
    {
        $_wp_theme_features['post-thumbnails'] = array( array('dvgalleries') );
    }

    elseif( true === $_wp_theme_features['post-thumbnails'])
    {
        return;
    }

    elseif( is_array($_wp_theme_features['post-thumbnails'][0]) )
    {
        $_wp_theme_features['post-thumbnails'][0][] = 'dvgalleries';
    }
}
add_action( 'after_setup_theme', 'DvgalleryAddFeatured', 99 );

/*---------------------------------------------------
Hide dv-gallery custom post type post view and post preview links/buttons
----------------------------------------------------*/
function dv_posttype_admin_css() {
    global $post_type;
    $post_types = array(
        'dvgalleries'
    );
    if(in_array($post_type, $post_types)) { ?>
    <style type="text/css">#post-preview, #view-post-btn, .updated > p > a, #wp-admin-bar-view, #edit-slug-box{display: none !important;}</style>
    <?php }
}
add_action( 'admin_head-post-new.php', 'dv_posttype_admin_css' );
add_action( 'admin_head-post.php', 'dv_posttype_admin_css' );

function dv_row_actions( $actions )
{
    if(get_post_type() != 'dvgalleries') {
        return $actions;
    }
    else {
        unset( $actions['view'] );
        return $actions;
    }
}

add_filter( 'post_row_actions', 'dv_row_actions', 10, 1 );

/* ---------------------------------------------------------
Include required files
----------------------------------------------------------- */

include_once('gallery_cpt.php');
include_once('dv_shortcodes.php');
include_once('dv_widgets.php');

/* ----------------------------------------------------------
Register Styles
------------------------------------------------------------- */

add_action('wp_head', 'dv_styles');
function dv_styles() {
include('styles.php');
}

/* ----------------------------------------------------------
Declare vars
------------------------------------------------------------- */

$dvgallery = "dvgallery";

/* ---------------------------------------------------------
Declare plugin options
----------------------------------------------------------- */
 
$dvgallery_plugin_options = array (
 
array( "name" => $dvgallery." Options",
"type" => "title"),
    
/* ---------------------------------------------------------
General
----------------------------------------------------------- */
array( "name" => esc_attr__( 'General', 'dvgallery'),
"icon" => "dashicons-admin-generic",
"type" => "section"),
array( "type" => "open"),
    
array( "name" => esc_attr__( 'Custom CSS', 'dvgallery'),
"desc" => esc_attr__( 'You can use this field to add your own css codes', 'dvgallery'),
"id" => $dvgallery . "_customcode",
"type" => "textarea",
"std" => ""),
    
array( "name" => esc_attr__( 'Loading image (64x64 px)', 'dvgallery'),
"desc" => esc_attr__( 'Loading image (64x64 px)', 'dvgallery'),
"id" => $dvgallery . "_loadingimage",
"type" => "media",
"std" => plugin_dir_url( __FILE__ ) ."css/icons/loader.gif"),
    
array( "name" => esc_attr__( 'Remove loading image', 'dvgallery'),
"desc" => esc_attr__( 'If you dont want to use loading image, check this box.', 'dvgallery'),
"id" => $dvgallery . "_removeloader",
"type" => "checkbox",
"std" => ""),    
    
array( "name" => esc_attr__( 'Zoom Icon (32x32 px)', 'dvgallery'),
"desc" => esc_attr__( 'Zoom Icon (32x32 px)', 'dvgallery'),
"id" => $dvgallery . "_zoom",
"type" => "media",
"std" => plugin_dir_url( __FILE__ ) ."css/icons/zoom.png"),
    
array( "name" => esc_attr__( 'Video Icon (32x32 px)', 'dvgallery'),
"desc" => esc_attr__( 'Video Icon (32x32 px)', 'dvgallery'),
"id" => $dvgallery . "_video",
"type" => "media",
"std" => plugin_dir_url( __FILE__ ) ."css/icons/video.png"),
    
array( "name" => esc_attr__( 'Link Icon (32x32 px)', 'dvgallery'),
"desc" => esc_attr__( 'Link Icon (32x32 px)', 'dvgallery'),
"id" => $dvgallery . "_linkgal",
"type" => "media",
"std" => plugin_dir_url( __FILE__ ) ."css/icons/link.png"),    
    
array( "name" => esc_attr__( 'Carousel Right Arrow (24x24 px)', 'dvgallery'),
"desc" => esc_attr__( 'Carousel Right Arrow (24x24 px)', 'dvgallery'),
"id" => $dvgallery . "_rightarrow",
"type" => "media",
"std" => plugin_dir_url( __FILE__ ) ."css/icons/c-right.png"),
    
array( "name" => esc_attr__( 'Carousel Left Arrow (24x24 px)', 'dvgallery'),
"desc" => esc_attr__( 'Carousel Left Arrow (24x24 px)', 'dvgallery'),
"id" => $dvgallery . "_leftarrow",
"type" => "media",
"std" => plugin_dir_url( __FILE__ ) ."css/icons/c-left.png"),     
    
array( "type" => "close"),  
    
/* ---------------------------------------------------------
Fonts
----------------------------------------------------------- */  

array( "name" => esc_attr__( 'Fonts', 'dvgallery'),
"icon" => "dashicons-edit",      
"type" => "section"),
array( "type" => "open"),
    
array( "name" => esc_attr__( 'Blog Gallery Title', 'dvgallery'),
"desc" => esc_attr__( 'Blog Style Gallery Title Font Size (px)', 'dvgallery'),
"id" => $dvgallery . "_blogtitle",
"type" => "number",
"std" => "24"),

array( "name" => esc_attr__( 'Carousel Gallery Title', 'dvgallery'),
"desc" => esc_attr__( 'Carousel Title Font Size (px)', 'dvgallery'),
"id" => $dvgallery . "_carouseltitle",
"type" => "number",
"std" => "18"),

array( "name" => esc_attr__( 'Grid Gallery Title', 'dvgallery'),
"desc" => esc_attr__( 'Grid Style Gallery Title Font Size (px)', 'dvgallery'),
"id" => $dvgallery . "_gridtitle",
"type" => "number",
"std" => "18"),
    
array( "name" => esc_attr__( 'Lightbox Gallery Title', 'dvgallery'),
"desc" => esc_attr__( 'Lightbox Gallery Title Font Size (px)', 'dvgallery'),
"id" => $dvgallery . "_lightboxtitle",
"type" => "number",
"std" => "16"),    
    
array( "name" => esc_attr__( 'Gallery Info', 'dvgallery'),
"desc" => esc_attr__( 'Gallery Info Font Size (px)', 'dvgallery'),
"id" => $dvgallery . "_info",
"type" => "number",
"std" => "14"),
    
array( "name" => esc_attr__( 'Filter Menu', 'dvgallery'),
"desc" => esc_attr__( 'Filter menu item font size (px)', 'dvgallery'),
"id" => $dvgallery . "_filterfont",
"type" => "number",
"std" => "18"),     
    
array( "type" => "close"),
    
/* ---------------------------------------------------------
Galleries
----------------------------------------------------------- */
array( "name" => esc_attr__( 'Galleries', 'dvgallery'),
"icon" => "dashicons-format-gallery",      
"type" => "section"),
array( "type" => "open"),
    
array( "name" => __( 'Activate Zoom', 'dvgallery'),
"desc" => __( 'Activate Zoom', 'dvgallery'),
"id" => $dvgallery."_lgzoom",
"type" => "select",
"std" => array('true' => 'Yes','false' => 'No')),
    
array( "name" => __( 'Activate Fullscreen', 'dvgallery'),
"desc" => __( 'Activate Fullscreen', 'dvgallery'),
"id" => $dvgallery."_lgfullscreen",
"type" => "select",
"std" => array('true' => 'Yes','false' => 'No')),
    
array( "name" => __( 'Activate Thumbnails', 'dvgallery'),
"desc" => __( 'Activate Thumbnails', 'dvgallery'),
"id" => $dvgallery."_lgthumbnails",
"type" => "select",
"std" => array('true' => 'Yes','false' => 'No')),
    
array( "name" => __( 'Activate Download Link', 'dvgallery'),
"desc" => __( 'Activate Download Link', 'dvgallery'),
"id" => $dvgallery."_lgdownload",
"type" => "select",
"std" => array('true' => 'Yes','false' => 'No')),
    
array( "name" => __( 'Activate Counter', 'dvgallery'),
"desc" => __( 'Activate Counter', 'dvgallery'),
"id" => $dvgallery."_lgcounter",
"type" => "select",
"std" => array('true' => 'Yes','false' => 'No')),
    
array( "name" => esc_attr__( 'Hide Bars Delay', 'dvgallery'),
"desc" =>  esc_attr__( 'Delay for hiding gallery controls in second', 'dvgallery'),
"id" => $dvgallery."_lghide",
"type" => "number",
"std" => "6"),     
    
array( "type" => "close"),    
    
/* ---------------------------------------------------------
Blog Style
----------------------------------------------------------- */

array( "name" => esc_attr__( 'Blog Style', 'dvgallery'),
"icon" => "dashicons-exerpt-view",      
"type" => "section"),
array( "type" => "open"),
    
array( "name" => esc_attr__( 'Disable blog image animation', 'dvgallery'),
"desc" => esc_attr__( 'Disable blog style gallery image link animation.', 'dvgallery'),
"id" => $dvgallery . "_linkanimation",
"type" => "checkbox",
"std" => ""),    
    
array( "name" => esc_attr__( 'Outer Spacing', 'dvgallery'),
"desc" => esc_attr__( 'The distance between galleries (px)', 'dvgallery'),
"id" => $dvgallery . "_spaceblog",
"type" => "number",
"std" => "40"),
    
array( "name" => esc_attr__( 'Inner Spacing', 'dvgallery'),
"desc" => esc_attr__( 'The distance between content and main container (px)', 'dvgallery'),
"id" => $dvgallery . "_spaceinner",
"type" => "number",
"std" => "40"),    

array( "name" => esc_attr__( 'Image Width', 'dvgallery'),
"desc" => esc_attr__( 'Width of the image field (You can use numbers between 0 and 100)', 'dvgallery'),
"id" => $dvgallery . "_spaceimage",
"type" => "number",
"std" => "40"),
    
array( "name" => esc_attr__( 'Content Width', 'dvgallery'),
"desc" => esc_attr__( 'Width of the content field (You can use numbers between 10-20 and 100)', 'dvgallery'),
"id" => $dvgallery . "_spacecontent",
"type" => "number",
"std" => "60"),
    
array( "name" => esc_attr__( 'Vertical Gallery Image Height', 'dvgallery'),
"desc" => esc_attr__( 'Height of the vertical blog style gallery image (px)', 'dvgallery'),
"id" => $dvgallery . "_verticalheight",
"type" => "number",
"std" => "200"),
    
array( "name" => esc_attr__( 'Vertical Gallery Image Mobile Height', 'dvgallery'),
"desc" => esc_attr__( 'Height of the vertical blog style gallery image on small screens (px)', 'dvgallery'),
"id" => $dvgallery . "_verticalmobile",
"type" => "number",
"std" => "200"),     
    
array( "name" => esc_attr__( 'Title bottom spacing', 'dvgallery'),
"desc" => esc_attr__( 'The distance between title and gallery info (px)', 'dvgallery'),
"id" => $dvgallery . "_spacetitle",
"type" => "number",
"std" => "20"),
    
array( "name" => esc_attr__( 'Gallery info bottom spacing', 'dvgallery'),
"desc" => esc_attr__( 'The distance between gallery info (paragraphs) and view gallery button (px)', 'dvgallery'),
"id" => $dvgallery . "_spacep",
"type" => "number",
"std" => "35"),    
    
array( "type" => "close"),
    
/* ---------------------------------------------------------
Carousel and Grid
----------------------------------------------------------- */

array( "name" => esc_attr__( 'Carousel and Grid', 'dvgallery'),
"icon" => "dashicons-tagcloud",      
"type" => "section"),
array( "type" => "open"),
    
array( "name" => esc_attr__( 'Align', 'dvgallery'),
"desc" => esc_attr__( 'Thumbnail Alignment', 'dvgallery'),
"id" => $dvgallery . "_thumbnailalign",
"type" => "select",
"std" => array('left' => 'Left','center' => 'Center','right' => 'Right')),     
    
array( "name" => esc_attr__( 'Outer Spacing (Carousel)', 'dvgallery'),
"desc" => esc_attr__( 'The distance between galleries (px).', 'dvgallery'),
"id" => $dvgallery . "_spacecarousel",
"type" => "number",
"std" => "20"),
    
array( "name" => esc_attr__( 'Outer Spacing (Grid)', 'dvgallery'),
"desc" => esc_attr__( 'The distance between galleries (px).', 'dvgallery'),
"id" => $dvgallery . "_spaceoffset",
"type" => "number",
"std" => "20"),    
    
array( "name" => esc_attr__( 'Inner Spacing', 'dvgallery'),
"desc" => esc_attr__( 'The distance between content and main container (px)', 'dvgallery'),
"id" => $dvgallery . "_spaceinnergrid",
"type" => "number",
"std" => "25"),   
    
array( "name" => esc_attr__( 'Title bottom spacing', 'dvgallery'),
"desc" => esc_attr__( 'The distance between title and gallery info (px)', 'dvgallery'),
"id" => $dvgallery . "_spacetitlegrid",
"type" => "number",
"std" => "25"),
    
array( "name" => esc_attr__( 'Gallery info top and bottom spacing', 'dvgallery'),
"desc" => esc_attr__( 'Gallery info top and bottom spacing (px)', 'dvgallery'),
"id" => $dvgallery . "_spacepgrid",
"type" => "number",
"std" => "20"),    
    
array( "type" => "close"),
    
/* ---------------------------------------------------------
Grid Filter Menu
----------------------------------------------------------- */

array( "name" => esc_attr__( 'Grid Filter Menu', 'dvgallery'),
"icon" => "dashicons-archive",      
"type" => "section"),
array( "type" => "open"),   
    
array( "name" => esc_attr__( 'Outer Spacing', 'dvgallery'),
"desc" => esc_attr__( 'The distance between filter menu and galleries (px)', 'dvgallery'),
"id" => $dvgallery . "_filterbottom",
"type" => "number",
"std" => "20"),
    
array( "name" => esc_attr__( 'Menu Item Horizontal Spacing', 'dvgallery'),
"desc" => esc_attr__( 'Menu item right-left spacing (px)', 'dvgallery'),
"id" => $dvgallery . "_filterhorizontal",
"type" => "number",
"std" => "15"),
    
array( "name" => esc_attr__( 'Menu Item Vertical Spacing', 'dvgallery'),
"desc" => esc_attr__( 'Menu item top-bottom spacing (px)', 'dvgallery'),
"id" => $dvgallery . "_filtervertical",
"type" => "number",
"std" => "5"),    
    
array( "type" => "close"),    

/* ---------------------------------------------------------
Colors
----------------------------------------------------------- */

array( "name" => esc_attr__( 'Colors', 'dvgallery'),
"icon" => "dashicons-admin-appearance",      
"type" => "section"),
array( "type" => "open"),    

array( "name" => esc_attr__( 'Color 1', 'dvgallery'),
"desc" => esc_attr__( 'Default color is #66A7C5', 'dvgallery'),
"id" => $dvgallery . "_first_color",
"type" => "colorpicker",
"std" => "#66A7C5"),
    
array( "name" => esc_attr__( 'Color 2', 'dvgallery'),
"desc" => esc_attr__( 'Default color is #92bfdb', 'dvgallery'),
"id" => $dvgallery . "_second_color",
"type" => "colorpicker",
"std" => "#92bfdb"),

array( "name" => esc_attr__( 'Color 3', 'dvgallery'),
"desc" => esc_attr__( 'Default color is #313536', 'dvgallery'),
"id" => $dvgallery . "_third_color",
"type" => "colorpicker",
"std" => "#313536"),

array( "name" => esc_attr__( 'Color 4', 'dvgallery'),
"desc" => esc_attr__( 'Default color is #6C7476', 'dvgallery'),
"id" => $dvgallery . "_fourth_color",
"type" => "colorpicker",
"std" => "#6C7476"),
    
array( "name" => esc_attr__( 'Color 5', 'dvgallery'),
"desc" => esc_attr__( 'Default color is #f5f1f0', 'dvgallery'),
"id" => $dvgallery . "_fifth_color",
"type" => "colorpicker",
"std" => "#f5f1f0"), 
    
array( "name" => esc_attr__( 'Color 6', 'dvgallery'),
"desc" => esc_attr__( 'Default color is #fff', 'dvgallery'),
"id" => $dvgallery . "_sixth_color",
"type" => "colorpicker",
"std" => "#fff"),
    
array( "name" => esc_attr__( 'Color 7', 'dvgallery'),
"desc" => esc_attr__( 'Default color is #d9d5d4', 'dvgallery'),
"id" => $dvgallery . "_seventh_color",
"type" => "colorpicker",
"std" => "#d9d5d4"),
    
array( "name" => esc_attr__( 'Transparent Color', 'dvgallery'),
"desc" => esc_attr__( 'It is used on galleries', 'dvgallery'),
"id" => $dvgallery . "_transparent_color",
"type" => "rgbacolorpicker",
"std" => "rgba(217, 213, 212, 0.7)"),    
    
array( "type" => "close")
);    

/*---------------------------------------------------
Plugin Panel Output
----------------------------------------------------*/

if ( ! function_exists( 'dvgallery_add_settings_page' ) ) {
function dvgallery_add_settings_page() {
add_plugins_page( __( 'DV Gallery Settings', 'dvgallery'), __( 'DV Gallery Settings', 'dvgallery'), 'manage_options', 'dvgallerysettings', 'dvgallery_plugin_settings_page');
}
add_action( 'admin_menu', 'dvgallery_add_settings_page' );    
}

if ( ! function_exists( 'dvgallery_plugin_settings_page' ) ) {
function dvgallery_plugin_settings_page() {
if ( ! did_action( 'wp_enqueue_media' ) ){
    wp_enqueue_media();
}    
global $dvgallery,$dvgallery_plugin_options;
$i=0;
$message='';
if ( 'save' == @$_REQUEST['action'] ) {

foreach ($dvgallery_plugin_options as $value) {
update_option( @$value['id'], @$_REQUEST[ $value['id'] ] ); }
 
foreach ($dvgallery_plugin_options as $value) {
if( isset( $_REQUEST[ @$value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }
$message='saved';
}
else if( 'reset' == @$_REQUEST['action'] ) {
 
foreach ($dvgallery_plugin_options as $value) {
delete_option( @$value['id'] ); }
$message='reset';
}
 
if ( $message=='saved' ) {
?>
    <div id="dvgallery-message" class="updated"><p><strong><?php echo esc_attr__( 'Plugin settings saved', 'dvgallery'); ?></strong></p></div>
<?php
}
if ( $message=='reset' ) {
?>
    <div id="dvgallery-message" class="updated"><p><strong><?php echo esc_attr__( 'Plugin settings reset', 'dvgallery'); ?></strong></p></div>
<?php    
}
 
?>
<div id="dvgallery-panel-wrapper">
<div class="dvgallery_options_header">
<div class="dvgallery_options_header_left">
<?php
$dvgallery_plugin_data = get_plugin_data( __FILE__ );
$dvgallery_plugin_name = $dvgallery_plugin_data['Name'];    
$dvgallery_plugin_version = $dvgallery_plugin_data['Version'];
?>
<h1><?php echo esc_attr($dvgallery_plugin_name); ?> <small> - <?php echo esc_attr($dvgallery_plugin_version); ?></small></h1>   
</div>
<div class="dvgallery_options_header_right">    
<ul>
<li><a class="dvgallery-link" href="http://codecanyon.net/user/egemenerd?ref=egemenerd" target="_blank"><?php echo esc_attr( 'Support', 'dvgallery'); ?></a></li>  
<li><a class="dvgallery-link" href="http://help.wp4life.com/" target="_blank"><?php echo esc_attr( 'Knowledge Base', 'dvgallery'); ?></a></li>    
<li><a class="dvgallery-link primary" href="<?php echo plugin_dir_url( __FILE__ ); ?>documentation/index.html" target="_blank"><?php echo esc_attr( 'Help Documentation', 'dvgallery'); ?></a></li>
</ul>
</div>
</div>     
<div class="dvgallery_options_wrap"> 
<div>
<form method="post">
 
<?php foreach ($dvgallery_plugin_options as $value) {
 
switch ( $value['type'] ) {
 
case "open": ?>
<?php break;
 
case "close": ?>
</div>
</div>

<?php break;
 
case 'text': ?>
<div class="dvgallery_option_input">
    <div class="dvgallery-option-left">
        <label for="<?php echo esc_attr($value['id']); ?>"><?php echo esc_attr($value['name']); ?></label>
    </div>
    <div class="dvgallery-option-center">
        <input id="<?php echo esc_attr($value['id']); ?>" type="<?php echo esc_attr($value['type']); ?>" name="<?php echo esc_attr($value['id']); ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(esc_attr(get_option( $value['id']))); } else { echo esc_attr($value['std']); } ?>" />
    </div>
    <div class="dvgallery-option-right">
        <small><?php echo esc_attr($value['desc']); ?></small>
    </div>
    <div class="clearfix"></div>
</div>
<?php break;    
    
case 'select': ?>
<div class="dvgallery_option_input">
    <div class="dvgallery-option-left">
        <label for="<?php echo esc_attr($value['id']); ?>"><?php echo esc_attr($value['name']); ?></label>
    </div>
    <div class="dvgallery-option-center">
        <select class="dvgallery-select" name="<?php echo esc_attr($value['id']); ?>" id="<?php echo esc_attr($value['id']); ?>">
<?php foreach ($value['std'] as $key => $optiontext) { ?>
<option value="<?php echo esc_attr($key); ?>" <?php if (get_option( $value['id'] ) == $key) { echo esc_attr('selected="selected"'); } ?>><?php echo esc_attr($optiontext); ?></option>
<?php } ?>
        </select>
    </div>
    <div class="dvgallery-option-right">
        <small><?php echo esc_attr($value['desc']); ?></small>
    </div>
    <div class="clearfix"></div>
</div>
<?php break;    
    
case 'colorpicker': ?>
<div class="dvgallery_option_input">
    <div class="dvgallery-option-left">
        <label for="<?php echo esc_attr($value['id']); ?>"><?php echo esc_attr($value['name']); ?></label>
    </div>
    <div class="dvgallery-option-center">
        <input id="<?php echo esc_attr($value['id']); ?>" class="dvgallery-color" type="<?php echo esc_attr($value['type']); ?>" name="<?php echo esc_attr($value['id']); ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(esc_attr(get_option( $value['id']))); } else { echo esc_attr($value['std']); } ?>" />
    </div>
    <div class="dvgallery-option-right">
        <small><?php echo esc_attr($value['desc']); ?></small>
    </div>
    <div class="clearfix"></div>
</div>
<?php break;
    
case 'rgbacolorpicker': ?>
<div class="dvgallery_option_input">
    <div class="dvgallery-option-left">
        <label for="<?php echo esc_attr($value['id']); ?>"><?php echo esc_attr($value['name']); ?></label>
    </div>
    <div class="dvgallery-option-center">
        <input id="<?php echo esc_attr($value['id']); ?>" class="dvgallery-wp-color-picker" type="<?php echo esc_attr($value['type']); ?>" name="<?php echo esc_attr($value['id']); ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(esc_attr(get_option( $value['id']))); } else { echo esc_attr($value['std']); } ?>" />
    </div>
    <div class="dvgallery-option-right">
        <small><?php echo esc_attr($value['desc']); ?></small>
    </div>
    <div class="clearfix"></div>
</div>
<?php break;     
    
case 'number': ?>
<div class="dvgallery_option_input">
    <div class="dvgallery-option-left">
        <label for="<?php echo esc_attr($value['id']); ?>"><?php echo esc_attr($value['name']); ?></label>
    </div>
    <div class="dvgallery-option-center">
        <input id="<?php echo esc_attr($value['id']); ?>" type="<?php echo esc_attr($value['type']); ?>" onkeypress="return validate(event)" name="<?php echo esc_attr($value['id']); ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(esc_attr(get_option( $value['id']))); } else { echo esc_attr($value['std']); } ?>" />
    </div>
    <div class="dvgallery-option-right">
        <small><?php echo esc_attr($value['desc']); ?></small>
    </div>
    <div class="clearfix"></div>
</div>
<?php break;    
 
case 'textarea': ?>
<div class="dvgallery_option_input">
    <div class="dvgallery-option-left">
        <label for="<?php echo esc_attr($value['id']); ?>"><?php echo esc_attr($value['name']); ?></label>
    </div>
    <div class="dvgallery-option-center">
        <textarea name="<?php echo esc_attr($value['id']); ?>" rows="" cols=""><?php if ( get_option( $value['id'] ) != "") { echo stripslashes(esc_attr(get_option( $value['id']))); } else { echo esc_attr($value['std']); } ?></textarea>
    </div>
    <div class="dvgallery-option-right">
        <small><?php echo esc_attr($value['desc']); ?></small>
    </div>
    <div class="clearfix"></div>
</div>
<?php break;
    
case 'info': ?>
<div class="dvgallery_option_input">
<div class="dvgallery_info_box"><h4><i class="dvgallery-i-icon dashicons-info"></i>&nbsp;<?php echo esc_attr($value['name']); ?></h4></div>
<div class="clearfix"></div>
</div>
<?php break;
        
case 'info2': ?>
<div class="dvgallery_option_input noborder">
<div class="dvgallery_info_box"><h4><i class="dvgallery-i-icon dashicons-info"></i>&nbsp;<?php echo esc_attr($value['name']); ?></h4></div>
<div class="clearfix"></div>
</div>
<?php break;      
 
case 'editor': ?>
<div class="dvgallery_option_input">
<?php wp_editor( stripslashes(get_option( $value['id'])), $value['id'], array( 'wpautop' => false, 'editor_height' => 300 )); ?> 
<div class="clearfix"></div>
<div class="dvgallery-editor-desc"><?php echo esc_attr($value['desc']); ?></div>
<div class="clearfix"></div>
</div>
<?php break; 
    
case 'teenyeditor': ?>
<div class="dvgallery_option_input">
<?php wp_editor( stripslashes(get_option( $value['id'])), $value['id'], array( 'wpautop' => false, 'teeny' => true, 'editor_height' => 200 )); ?> 
<div class="clearfix"></div>
<div class="dvgallery-editor-desc"><?php echo esc_attr($value['desc']); ?></div>
<div class="clearfix"></div>
</div>
<?php break;     
    
case 'media': ?>
<div class="dvgallery_option_input">
    <div class="dvgallery-option-left">
        <label for="<?php echo esc_attr($value['id']); ?>"><?php echo esc_attr($value['name']); ?></label>
    </div>
    <div class="dvgallery-option-center">
        <input id="<?php echo esc_attr($value['id']); ?>_image" type="text" name="<?php echo esc_attr($value['id']); ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(esc_attr(get_option( $value['id']))); } else { echo esc_attr($value['std']); } ?>" />
        <div id="<?php echo esc_attr($value['id']); ?>_thumb" class="dvgallery-upload-thumb">
            <div id="<?php echo esc_attr($value['id']); ?>_close" class="dvgallery-thumb-close"><i class="dvgallery-i-icon dashicons-dismiss"></i></div>
            <img src="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(esc_attr(get_option( $value['id']))); } else { echo esc_attr($value['std']); } ?>" alt="" />
        </div>
    </div>
    <div class="dvgallery-option-right">
        <input id="<?php echo esc_js($value['id']); ?>_image_button" class="dvgallery-button uploadbutton" type="button" value="<?php echo esc_js( 'Upload', 'dvgallery') ?>" />
<script type="text/javascript">
    jQuery("#<?php echo esc_js($value['id']); ?>_image").change(function() { 
        if(jQuery.trim(jQuery("#<?php echo esc_attr($value['id']); ?>_image").val()).length > 0)
        {
            jQuery("#<?php echo esc_js($value['id']); ?>_thumb").show();
            jQuery("#<?php echo esc_js($value['id']); ?>_thumb img").attr('src', jQuery("#<?php echo esc_attr($value['id']); ?>_image").val());
            jQuery("#<?php echo esc_js($value['id']); ?>_thumb img").error(function(){jQuery(this).attr('src', '<?php echo plugin_dir_url( __FILE__ ); ?>css/error.png');});
        }
        else {
            jQuery("#<?php echo esc_js($value['id']); ?>_thumb").hide();
        }
    });
jQuery(document).ready(function($){ 
    var inp = $("#<?php echo esc_js($value['id']); ?>_image").val();
    if($.trim(inp).length > 0)
    {
        $("#<?php echo esc_js($value['id']); ?>_thumb").show();
    }
    else {
        $("#<?php echo esc_js($value['id']); ?>_thumb").hide();
    }
    var custom_uploader; 
    $('#<?php echo esc_js($value['id']); ?>_image_button').click(function(e) { 
        e.preventDefault();
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: '<?php echo esc_js( 'Choose Image', 'dvgallery') ?>',
            button: {
                text: '<?php echo esc_js( 'Choose Image', 'dvgallery') ?>'
            },
            multiple: false
        });
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#<?php echo esc_js($value['id']); ?>_image').val(attachment.url);
            $("#<?php echo esc_js($value['id']); ?>_thumb img").attr('src', attachment.url);
            $("#<?php echo esc_js($value['id']); ?>_thumb").show();
        });
        custom_uploader.open(); 
    }); 
    $('#<?php echo esc_js($value['id']); ?>_close').click(function(e) {
        $("#<?php echo esc_js($value['id']); ?>_thumb").hide();
        $("#<?php echo esc_js($value['id']); ?>_image").val('');
    });    
});    
</script>
    </div>
<div class="clearfix"></div>
</div>
<?php break;    
 
case "checkbox": ?>
<div class="dvgallery_option_input">
    <div class="dvgallery-option-left">
        <label for="<?php echo esc_attr($value['id']); ?>"><?php echo esc_attr($value['name']); ?></label>
    </div>
    <div class="dvgallery-option-center">
        <?php if(get_option($value['id'])){ $checked = 'checked="checked"'; } else { $checked = ""; } ?>
        <div id="<?php echo esc_attr($value['id']); ?>-toggle" class="dvgallery-toggle toggle-modern" data-toggle-on="<?php if(get_option($value['id'])){ echo get_option($value['id']); } else { echo esc_attr('false'); } ?>"></div>
        <input id="<?php echo esc_attr($value['id']); ?>" type="checkbox" class="dvgallery-checkbox" name="<?php echo esc_attr($value['id']); ?>" value="true" <?php echo esc_attr($checked); ?> />
    </div>
    <div class="dvgallery-option-right">
        <small><?php echo esc_attr($value['desc']); ?></small>
    </div>
    <div class="clearfix"></div>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('#<?php echo esc_attr($value['id']); ?>-toggle').toggles({
            checkbox: jQuery('#<?php echo esc_attr($value['id']); ?>'),
            text: {
                on: '<?php echo esc_attr( 'ON', 'dvgallery') ?>',
                off: '<?php echo esc_attr( 'OFF', 'dvgallery') ?>'
            },
            width: 70,
            height: 30,
            type: 'select'
        });
    });
</script>    
</div>
<?php break;
 
case "section":
$i++; ?>
<div class="dvgallery_input_section">
<div class="dvgallery_input_title">
 
<h3><i class="dvgallery-i-icon <?php echo esc_attr($value['icon']); ?>"></i>&nbsp;<?php echo esc_attr($value['name']); ?></h3>
<span class="submit"><input name="save<?php echo esc_attr($i); ?>" type="submit" value="<?php echo esc_attr( 'Save Changes', 'dvgallery') ?>" class="dvgallery-button" /></span>
<div class="clearfix"></div>
</div>
<div class="dvgallery_all_options">
<?php break;
 
}
}?>
<input type="hidden" name="action" value="save" />
</form>
</div>
<div class="dvgallery-footer">
    <div class="dvgallery-footer-left">
        <a href="http://codecanyon.net/user/egemenerd?ref=egemenerd" target="_blank" ><img class="dvgallery-logo" src="<?php echo plugin_dir_url( __FILE__ ) . 'css/logo.png' ?>" alt="egemenerd" /></a>
    </div>
    <div class="dvgallery-footer-right">
        <form method="post">
            <p class="submit">
                <input name="reset" type="submit" value="<?php echo esc_attr( 'Reset All Settings', 'dvgallery') ?>" onclick="return confirm('<?php echo esc_attr( 'Are you sure you want to reset all theme settings?', 'dvgallery') ?>')" class="dvgallery-link" />
                <input type="hidden" name="action" value="reset" />
            </p>
        </form>
    </div>
</div>
</div>
</div>
<?php
}
}
?>
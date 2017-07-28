<?php
/**
Plugin Name: Mikado Grid Gallery
Plugin URI: codecanyon.net/item/mikado-grid-gallery-for-wordpress/7028624?ref=GreenTreeLabs
Description: Wordpress Plugin for creating responsive image galleries. By: Green Tree Labs
Author: Green Tree Labs
Version: 1.1.15
Author URI: http://codecanyon.net/user/GreenTreeLabs
*/

function mikado_create_db_tables() {
	include_once (WP_PLUGIN_DIR . '/mikado/lib/install-db.php');			
	mikado_install_db();
}

if (!class_exists("Mikado")) {
	class Mikado {
		
		//Constructor
		public function __construct() 
		{
			$this->plugin_name = plugin_basename(__FILE__);		
			$this->define_constants();
			$this->define_db_tables();			
			$this->add_gallery_options();
			$this->MikadoDB = $this->create_db_conn();
						
			register_activation_hook( __FILE__, array($this, 'activation'));
						
			add_filter('widget_text', 'do_shortcode'); 
			add_filter("attachment_fields_to_edit", array($this, 'attachment_fields_to_edit'), null, 2);
			add_filter("attachment_fields_to_save", array($this, 'attachment_fields_to_save'), null, 2);
			
			add_action('init', array($this, 'create_textdomain'));	

			add_action('wp_enqueue_scripts', array($this, 'add_gallery_scripts'));
			
			add_action( 'admin_menu', array($this, 'add_gallery_admin_menu') );
			
			add_shortcode( 'Mikado', array($this, 'gallery_shortcode_handler') );	

			add_action('wp_ajax_mikado_save_gallery', array($this,'save_gallery'));
			add_action('wp_ajax_mikado_save_image', array($this,'save_image'));
			add_action('wp_ajax_mikado_add_image', array($this,'add_image'));
			add_action('wp_ajax_mikado_list_images', array($this,'list_images'));
			add_action('wp_ajax_mikado_sort_images', array($this,'sort_images'));
			add_action('wp_ajax_mikado_delete_image', array($this,'delete_image'));
			add_action('wp_ajax_mikado_assign_filters', array($this,'assign_filters'));			
		}
		
		//Define textdomain
		public function create_textdomain() 
		{
			$plugin_dir = basename(dirname(__FILE__));
			load_plugin_textdomain( 'Mikado', false, $plugin_dir.'/lib/languages' );
		}
		
		//Define constants
		public function define_constants() 
		{
			if ( ! defined( 'Mikado_PLUGIN_BASENAME' ) )
				define( 'Mikado_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
		
			if ( ! defined( 'Mikado_PLUGIN_NAME' ) )
				define( 'Mikado_PLUGIN_NAME', trim( dirname( Mikado_PLUGIN_BASENAME ), '/' ) );
			
			if ( ! defined( 'Mikado_PLUGIN_DIR' ) )
				define( 'Mikado_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . Mikado_PLUGIN_NAME );
		}
		
		//Define DB tables
		public function define_db_tables() 
		{
			global $wpdb;
			
			$wpdb->MikadoGalleries = $wpdb->prefix . 'mikado';
			$wpdb->MikadoGalleriesImages = $wpdb->prefix . 'mikado_images';
		}

		public function activation()
		{
			
		}
				
		
		public function create_db_conn() 
		{
			require('lib/db-class.php');
			$MikadoDB = MikadoDB::getInstance();
			return $MikadoDB;
		}
		
		public function attachment_fields_to_edit($form, $post)
		{
			$form["mikado_link"] = array(
				"label" => "Link <small>Mikado</small>",
				"input" => "text",
				"value" => get_post_meta($post->ID, "_mikado_link", true),
				"helps" => ""
			);
			$form["mikado_target"] = array(
				"label" => "_blank <small>Mikado</small>",
				"input" => "html",
				"html" =>
					"<input type='checkbox' name='attachments[{$post->ID}][mikado_target]' id='attachments[{$post->ID}][mikado_target]' value='_mblank' ".
					(get_post_meta($post->ID, "_mikado_target", true) == "_mblank" ? "checked" : "")
					." />"
			);
			return $form;
		}
		
		public function attachment_fields_to_save($post, $attachment)
		{
			if(isset($attachment['mikado_link']))
			{
				update_post_meta($post['ID'], '_mikado_link', $attachment['mikado_link']);
			}
			if(isset($attachment['mikado_target']))
			{
				update_post_meta($post['ID'], '_mikado_target', $attachment['mikado_target']);
			}
			return $post;		
		}
		
		//Add gallery options
		public function add_gallery_options() 
		{
			$gallery_options = array(
				'margin'  => '10',
				'defaultSize' => 'large',
				'width' => '100%',
				'height' => '500px',
				'lightbox' => 'lightbox',
				'captionIcon' => 'zoom',
				'captionIconColor' => '#ffffff',
				'captionColor' => '#ffffff',
				'captionBackgroundColor' => '#000000',
				'captionEffectDuration' => 250,
				'captionOpacity' => 80,
				'borderSize' => 0,
				'borderRadius' => 0,
				'shadowSize' => 0,
				'includeFontawesome' => 'T',
				//'wp_field_title' => 'title',
				'wp_field_caption' => 'description'
			);

			add_option('mikado_options', $gallery_options);
		}
		
		//Add gallery scripts
		public function add_gallery_scripts() 
		{
			wp_enqueue_script('jquery');
			wp_register_script('jquery-easing', WP_PLUGIN_URL.'/mikado/scripts/jquery.easing.js', array('jquery'));
			wp_enqueue_script('jquery-easing');
			
			wp_register_script('Mikado', WP_PLUGIN_URL.'/mikado/scripts/jquery.Mikado.js', array('jquery'));
			wp_enqueue_script('Mikado');
			
			
			wp_register_style('Mikado_stylesheet', WP_PLUGIN_URL.'/mikado/scripts/mikado.css');			
			wp_enqueue_style('Mikado_stylesheet');

			wp_register_script('magnific_script', WP_PLUGIN_URL.'/mikado/lightbox/magnific/script.js', array('jquery'));
			wp_register_script('prettyphoto_script', WP_PLUGIN_URL.'/mikado/lightbox/prettyphoto/script.js', array('jquery'));
			wp_register_script('colorbox_script', WP_PLUGIN_URL.'/mikado/lightbox/colorbox/script.js', array('jquery'));
			wp_register_script('fancybox_script', WP_PLUGIN_URL.'/mikado/lightbox/fancybox/script.js', array('jquery'));
			wp_register_script('swipebox_script', WP_PLUGIN_URL.'/mikado/lightbox/swipebox/script.js', array('jquery'));
			wp_register_script('lightbox2_script', WP_PLUGIN_URL.'/mikado/lightbox/lightbox2/js/script.js', array('jquery'));

			wp_register_style('magnific_stylesheet', WP_PLUGIN_URL.'/mikado/lightbox/magnific/style.css');
			wp_register_style('prettyphoto_stylesheet', WP_PLUGIN_URL.'/mikado/lightbox/prettyphoto/style.css');
			wp_register_style('colorbox_stylesheet', WP_PLUGIN_URL.'/mikado/lightbox/colorbox/style.css');
			wp_register_style('fancybox_stylesheet', WP_PLUGIN_URL.'/mikado/lightbox/fancybox/style.css');
			wp_register_style('swipebox_stylesheet', WP_PLUGIN_URL.'/mikado/lightbox/swipebox/style.css');
			wp_register_style('lightbox2_stylesheet', WP_PLUGIN_URL.'/mikado/lightbox/lightbox2/css/style.css');
            
            wp_register_style('fontawesome_stylesheet', '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css');            
		}
				
		//Admin Section - register scripts and styles
		public function gallery_admin_init() 
		{
			if(function_exists( 'wp_enqueue_media' ))
			{
				wp_enqueue_media();
			}
			//wp_enqueue_script( 'custom-header' );

			wp_enqueue_script('jquery');
			wp_enqueue_script('jquery-ui-dialog');
			wp_enqueue_script('jquery-ui-sortable');
            
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_style( 'wp-color-picker' );

			wp_enqueue_script('media-upload');
			wp_enqueue_script('thickbox');

			wp_register_script('futurico', WP_PLUGIN_URL.'/mikado/admin/scripts/SCF.ui.js', array('jquery'));
			wp_enqueue_script('futurico');

			wp_register_style('futurico', WP_PLUGIN_URL.'/mikado/admin/bundle.css', array('colors'));
			wp_enqueue_style('futurico');

			wp_register_script('mikado', WP_PLUGIN_URL.'/mikado/admin/scripts/mikado-admin.js', array('jquery','media-upload','thickbox'));
			wp_enqueue_script('mikado');
						
			wp_enqueue_style('thickbox');		

			$tg_db_version = '2.4';
			$installed_ver = get_option( "Mikado_db_version" );
			
			if($installed_ver != $tg_db_version )
			{
				mikado_create_db_tables();
				update_option( "Mikado_db_version", $tg_db_version );
			}			
		}
				
		public function Mikado_admin_style_load() 
		{
			wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/ui-darkness/jquery-ui.min.css'); 
		}
		
		//Create Admin Menu
		public function add_gallery_admin_menu() 
		{
			$overview = add_menu_page('Mikado', 'Mikado', 'edit_posts', 'Mikado-admin', array($this, 'add_overview'), WP_PLUGIN_URL.'/mikado/admin/icon.png');
			$tutorial = add_submenu_page('Mikado-admin', __('Mikado >> Tutorial','Mikado'), __('Tutorial','Mikado'), 'edit_posts', 'mikado-tutorial', array($this, 'tutorial'));
			$add_gallery = add_submenu_page('Mikado-admin', __('Mikado >> Add Gallery','Mikado'), __('Add Gallery','Mikado'), 'edit_posts', 'add-mikado', array($this, 'add_gallery'));
			$edit_gallery = add_submenu_page('Mikado-admin', __('Mikado >> Edit Gallery','Mikado'), __('Edit Gallery','Mikado'), 'edit_posts', 'edit-mikado', array($this, 'edit_gallery'));
			
			add_action('admin_print_styles-'.$add_gallery, array($this, 'Mikado_admin_style_load'));
			add_action('admin_print_styles-'.$edit_gallery, array($this, 'Mikado_admin_style_load'));

			add_action('load-'.$tutorial, array($this, 'gallery_admin_init'));
			add_action('load-'.$overview, array($this, 'gallery_admin_init'));
			add_action('load-'.$add_gallery, array($this, 'gallery_admin_init'));
			add_action('load-'.$edit_gallery, array($this, 'gallery_admin_init'));
		}
		
		//Create Admin Pages
		public function add_overview() 
		{			
			include("admin/overview.php");
		}
		
		public function tutorial() 
		{			
			include("admin/tutorial.php");
		}
		
		public function add_gallery() 
		{
			include("admin/add-gallery.php");	
		}

		public function delete_image()
		{
			if(check_admin_referer('Mikado','Mikado')) 
			{
				foreach (explode(",", $_POST["id"]) as $id) {
			  		$this->MikadoDB->deleteImage(intval($id));
				}				
			}
			die();
		}

		public function assign_filters()
		{
			if(check_admin_referer('Mikado','Mikado')) 
			{
				foreach (explode(",", $_POST["id"]) as $id) 
				{
			  		$result = $this->MikadoDB->editImage($id, array("filters" => $_POST["filters"]));
				}				
			}
			die();
		}

		public function add_image()
		{
			if(check_admin_referer('Mikado','Mikado')) 
			{							  
				$gid = intval($_POST['galleryId']);
				$enc_images = stripslashes($_POST["enc_images"]);
				$images = json_decode($enc_images);

				$result = $this->MikadoDB->addImages($gid, $images);
				
				header("Content-type: application/json");
				if($result === false) 
				{					
					print "{\"success\":false}";
				}
				else
				{
					print "{\"success\":true}";
				}
			}	
			die();
		}

		public function sort_images()
		{
			if(check_admin_referer('Mikado','Mikado')) 
			{							  
				$result = $this->MikadoDB->sortImages(explode(',', $_POST['ids']));
				
				header("Content-type: application/json");
				if($result === false) 
				{					
					print "{\"success\":false}";
				}
				else
				{
					print "{\"success\":true}";
				}
			}	
			die();
		}

		public function save_image()
		{
			if(check_admin_referer('Mikado','Mikado')) 
			{	
				$result = false;
				$type = $_POST['type'];			
				$imageUrl = stripslashes($_POST['img_url']);
				$imageCaption = stripslashes($_POST['description']);
				$filters = stripslashes($_POST['filters']);
				$target = $_POST['target'];
				$lightbox = $_POST['lightbox'];
				$link = isset($_POST['link']) ? stripslashes($_POST['link']) : null;
				$imageId = intval($_POST['img_id']);
		        $sortOrder = intval($_POST['sortOrder']);
		        $halign = $_POST['halign'];
		        $valign = $_POST['valign'];
				
		        if($zoom == "T")
		        	$link = null;

				$data = array("imagePath" => $imageUrl,
							  "target" => $target,
							  //"lightbox" => $lightbox,
							  "link" => $link,
							  "imageId" => $imageId,
							  "description" => $imageCaption,
							  "filters" => $filters,
							  "halign" => $halign,
							  "valign" => $valign,
							  "sortOrder" => $sortOrder);
				if(!empty($_POST["id"]))
				{
					$imageId = intval($_POST['id']);
					$result = $this->MikadoDB->editImage($imageId, $data);
				}
				else
				{
					$data["gid"] = intval($_POST['galleryId']);
					$result = $this->MikadoDB->addFullImage($data);
				}

				header("Content-type: application/json");

				if($result === false) 
				{					
					print "{\"success\":false}";
				}
				else
				{
					print "{\"success\":true}";
				}
			}
			die();
		}

		public function list_images()
		{
			if(check_admin_referer('Mikado','Mikado')) 
			{
				$gid = intval($_POST["gid"]);
				$imageResults = $this->MikadoDB->getImagesByGalleryId($gid);
				
				include('admin/include/image-list.php');
			}
			die();
		}

		public function save_gallery()
		{
			if(check_admin_referer('Mikado','Mikado')) 
			{
				$galleryName = stripslashes($_POST['galleryName']);
				$galleryDescription = stripslashes($_POST['galleryDescription']);	  
				$slug = strtolower(str_replace(" ", "", $galleryName));
				$margin = intval($_POST['margin']);
			    $shuffle = $_POST['shuffle'];
                $width = $_POST['width'];
                $height = $_POST['height'];
                $keepArea = $_POST['keepArea'];
			    $enableTwitter = $_POST['enableTwitter'];
			    $enableFacebook = $_POST['enableFacebook'];
			    $enableGplus = $_POST['enableGplus'];
			    $enablePinterest = $_POST['enablePinterest'];
                $captionIcon = $_POST['captionIcon'];
                $captionIconColor = $_POST['captionIconColor'];
			    $lightbox = $_POST['lightbox'];
			    $blank = $_POST['blank'];
			    $wp_field_caption = $_POST['wp_field_caption'];
			    $filters = $_POST['filters'];
                $scrollEffect = $_POST['scrollEffect'];                
			    $captionEffect = $_POST['captionEffect'];
			    $captionColor = $_POST['captionColor'];
			    $captionBackgroundColor = $_POST['captionBackgroundColor'];
			    $captionEasing = $_POST['captionEasing'];
			    $captionOpacity = intval($_POST['captionOpacity']);
			    $borderSize = intval($_POST['borderSize']);
			    $borderColor = $_POST['borderColor'];
			    $borderRadius = intval($_POST['borderRadius']);
			    $shadowColor = $_POST['shadowColor'];
			    $shadowSize = intval($_POST['shadowSize']);
			    $backgroundColor = $_POST['backgroundColor'];
			    $style = $_POST['style'];
			    $script = $_POST['script'];

			    $captionEffectDuration = intval($_POST['captionEffectDuration']);
				$id = isset($_POST['ftg_gallery_edit']) ? intval($_POST['ftg_gallery_edit']) : 0;

			    $data = array('name' => $galleryName, 
			    			  'slug' => $slug, 
			    			  'description' => $galleryDescription, 
			    			  'lightbox' => $lightbox,
			    			  'blank' => $blank,
			    			  'wp_field_caption' => $wp_field_caption,
			                  'margin' => $margin, 
			                  'shuffle' => $shuffle, 
                              'captionIcon' => $captionIcon,
                              'captionIconColor' => $captionIconColor,
			                  'enableTwitter' => $enableTwitter, 
			                  'enableFacebook' => $enableFacebook, 
			                  'enableGplus' => $enableGplus, 
			                  'enablePinterest' => $enablePinterest,
			                  'captionEffect' => $captionEffect, 
			                  'captionOpacity' => $captionOpacity, 
			                  'captionColor' => $captionColor, 
			                  'captionBackgroundColor' => $captionBackgroundColor, 
			                  'captionEffectDuration' => $captionEffectDuration, 
			                  'captionEasing' => $captionEasing, 
			                  'filters' => $filters, 
			                  'includeFontawesome' => $_POST['includeFontawesome'], 
			                  'borderSize' => $borderSize,
			                  'borderColor' => $borderColor, 
			                  'backgroundColor' => empty($backgroundColor) ? '#fff' : $backgroundColor, 
			                  'borderRadius' => $borderRadius, 
			                  'shadowSize' => $shadowSize, 
			                  'shadowColor' => $shadowColor, 
			                  'width' =>  $width,
                              'height' =>  $height,
                              //'keepArea' => $keepArea,
			                  'style' => $style, 
			                  'script' => $script, 
			                  'scrollEffect' => '' );
			    
			    header("Content-type: application/json");
			    if($id > 0)
			    {
					$result = $this->MikadoDB->editGallery($id, $data);	
				}
				else
				{
					$result = $this->MikadoDB->addGallery($data);					
					$id = $this->MikadoDB->getNewGalleryId();
				}

				if($result) 
					print "{\"success\":true,\"id\":" . $id ."}";
				else
					print "{\"success\":false}";
			}
			die();
		}

		public function edit_gallery() 
		{
			include("admin/edit-gallery.php");	
		}
		
		public function add_images() 
		{
			include("admin/add-images.php");
		}	
		
		public function gallery_shortcode_handler($atts) 
		{						
			require_once('lib/gallery-class.php');			
			global $Mikado;

			if (class_exists('MikadoFE')) {
				$Mikado = new MikadoFE($this->MikadoDB, get_option('mikado_options'));
				
				if(! empty($atts['id']))
					$Mikado->initByGalleryId($atts['id']);
					
				if(! empty($atts['ids']))	
					$Mikado->initByImageIds($atts['ids']);
					
				$settings = $Mikado->getGallery();
				
				if(
					(isset($settings->includeFontawesome) && $settings->includeFontawesome == 'T') ||
					! isset($settings->includeFontawesome)) {
					wp_enqueue_style('fontawesome_stylesheet');
				}

				switch($settings->lightbox)
				{
					default:
					case "magnific":						
						wp_enqueue_style('magnific_stylesheet');
						wp_enqueue_script('magnific_script');
						break;
					case "prettyphoto":
						wp_enqueue_style('prettyphoto_stylesheet');
						wp_enqueue_script('prettyphoto_script');
						break;
					case "fancybox":
						wp_enqueue_style('fancybox_stylesheet');
						wp_enqueue_script('fancybox_script');
						break;
					case "colorbox":
						wp_enqueue_style('colorbox_stylesheet');
						wp_enqueue_script('colorbox_script');
						break;
					case "swipebox":
						wp_enqueue_style('swipebox_stylesheet');
						wp_enqueue_script('swipebox_script');
						break;
					case "lightbox2":
						wp_enqueue_style('lightbox2_stylesheet');
						wp_enqueue_script('lightbox2_script');
						break;
				}				
				return $Mikado->render();
			}
			else {
				return "Gallery not found.";	
			}	
		}		
	}
}

if (class_exists("Mikado")) {
    global $ob_Mikado;
	$ob_Mikado = new Mikado();
}
?>
<?php

/**
 * Plugin Name: Justified Gallery
 * Plugin URI: https://wordpress.org/plugins/justified-gallery
 * Description: Display native WordPress galleries in a responsive justified image grid and a pretty lightbox.
 * Version: 1.2
 * Author: Damian Góra
 * Author URI: http://damiangora.com
 * Text Domain: justified-gallery
 * Domain Path: /languages/
 * 
 */
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'DGWT_JG_Core' ) ) {

	final class DGWT_JG_Core {

		private static $instance;
		private $tnow;
		public $settings;
		public $gallery;

		public static function get_instance() {
			if ( !isset( self::$instance ) && !( self::$instance instanceof DGWT_JG_Core ) ) {
				self::$instance		 = new DGWT_JG_Core;
				self::$instance->constants();
				self::$instance->includes();
				self::$instance->hooks();

				// Set up localisation
				self::$instance->load_textdomain();


				self::$instance->settings	 = new DGWT_JG_Settings;
				self::$instance->gallery	 = new DGWT_JG_Gallery;
			}
			self::$instance->tnow = time();

			return self::$instance;
		}

		/**
		 * Constructor Function
		 */
		private function __construct() {
			self::$instance = $this;
		}

		/**
		 * Setup plugin constants
		 */
		private function constants() {

			$this->define( 'DGWT_JG_VERSION', '1.2' );
			$this->define( 'DGWT_JG_NAME', 'Justified Gallery' );
			$this->define( 'DGWT_JG_FILE', __FILE__ );
			$this->define( 'DGWT_JG_DIR', plugin_dir_path( __FILE__ ) );
			$this->define( 'DGWT_JG_URL', plugin_dir_url( __FILE__ ) );
			$this->define( 'DGWT_JG_DOMAIN', 'justified-gallery' );

			$this->define( 'DGWT_JG_SETTINGS_KEY', 'dgwt_jg_settings' );

			$this->define( 'DGWT_JG_DEBUG', false );
		}

		/**
		 * Define constant if not already set
		 * @param  string $name
		 * @param  string|bool $value
		 */
		private function define( $name, $value ) {
			if ( !defined( $name ) ) {
				define( $name, $value );
			}
		}

		/**
		 * Include required core files.
		 */
		public function includes() {

			require_once DGWT_JG_DIR . 'includes/functions.php';

			require_once DGWT_JG_DIR . 'includes/install.php';

			require_once DGWT_JG_DIR . 'includes/admin/settings/class-settings-api.php';
			require_once DGWT_JG_DIR . 'includes/admin/settings/class-settings.php';

			require_once DGWT_JG_DIR . 'includes/register-scripts.php';

			require_once DGWT_JG_DIR . 'includes/admin/admin.php';

			require_once DGWT_JG_DIR . 'includes/class-gallery.php';
		}

		/**
		 * Actions and filters
		 */
		private function hooks() {

			add_action( 'admin_init', array( $this, 'admin_scripts' ) );
		}

		/*
		 * Enqueue admin sripts
		 */

		public function admin_scripts() {
			// Register CSS
			wp_register_style( 'dgwt-jg-admin-style', DGWT_JG_URL . 'assets/css/admin-style.css', array(), DGWT_JG_VERSION );



			// Enqueue CSS            
			wp_enqueue_style( array(
				'dgwt-jg-admin-style',
			//'wp-color-picker'
			) );


			//wp_enqueue_script( 'wp-color-picker' );
		}

		/*
		 * Register text domain
		 */

		private function load_textdomain() {
			$lang_dir = dirname( plugin_basename( DGWT_JG_FILE ) ) . '/languages/';
			load_plugin_textdomain( DGWT_JG_DOMAIN, false, $lang_dir );
		}

	}

}

// Init the plugin
function DGWT_JG() {
	return DGWT_JG_Core::get_instance();
}

DGWT_JG();

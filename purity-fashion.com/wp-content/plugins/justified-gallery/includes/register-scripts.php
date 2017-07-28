<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class DGWT_JG_Scripts {

	function __construct() {

		add_action( 'wp_enqueue_scripts', array( $this, 'js_scripts' ) );

		add_action( 'wp_print_styles', array( $this, 'css_style' ) );
	}

	/*
	 * Register scripts.
	 * Uses a WP hook wp_enqueue_scripts
	 */

	public function js_scripts() {

		if ( !is_admin() ) {

			if ( DGWT_JG()->settings->get_opt( 'lightbox' ) === 'yes' ) {
				wp_register_script( 'jquery-mousewheel', DGWT_JG_URL . 'assets/js/jquery.mousewheel.min.js', array( 'jquery' ), DGWT_JG_VERSION, true );

				if ( DGWT_JG_DEBUG === false ) {
					wp_register_script( 'dgwt-jg-photoswipe-ui', DGWT_JG_URL . 'assets/vendors/photoswipe/photoswipe-ui-default.min.js', array( 'jquery', 'jquery-mousewheel' ), DGWT_JG_VERSION, true );
					wp_register_script( 'dgwt-jg-photoswipe', DGWT_JG_URL . 'assets/vendors/photoswipe/photoswipe.min.js', array( 'dgwt-jg-photoswipe-ui' ), DGWT_JG_VERSION, true );
					wp_register_script( 'dgwt-jg-jquery-photoswipe', DGWT_JG_URL . 'assets/vendors/photoswipe/jquery.photoswipe.js', array( 'dgwt-jg-photoswipe' ), DGWT_JG_VERSION, true );
				} else {
					wp_register_script( 'dgwt-jg-photoswipe-ui', DGWT_JG_URL . 'assets/vendors/photoswipe/photoswipe-ui-default.js', array( 'jquery', 'jquery-mousewheel' ), DGWT_JG_VERSION, true );
					wp_register_script( 'dgwt-jg-photoswipe', DGWT_JG_URL . 'assets/vendors/photoswipe/photoswipe.js', array( 'dgwt-jg-photoswipe-ui' ), DGWT_JG_VERSION, true );
					wp_register_script( 'dgwt-jg-jquery-photoswipe', DGWT_JG_URL . 'assets/vendors/photoswipe/jquery.photoswipe.js', array( 'dgwt-jg-photoswipe' ), DGWT_JG_VERSION, true );
				}

				wp_enqueue_script( array(
					'dgwt-jg-photoswipe',
					'dgwt-jg-photoswipe-ui',
					'dgwt-jg-jquery-photoswipe'
				) );
			}

			if ( DGWT_JG_DEBUG === false ) {
				wp_register_script( 'dgwt-justified-gallery', DGWT_JG_URL . 'assets/js/jquery.justifiedGallery.min.js', array( 'jquery' ), DGWT_JG_VERSION, true );
			} else {
				wp_register_script( 'dgwt-justified-gallery', DGWT_JG_URL . 'assets/js/jquery.justifiedGallery.js', array( 'jquery' ), DGWT_JG_VERSION, true );
			}

			wp_enqueue_script( array(
				'dgwt-justified-gallery'
			) );
		}
	}

	/*
	 * Register and enqueue style
	 * Uses a WP hook wp_print_styles
	 */

	public function css_style() {

		if ( DGWT_JG()->settings->get_opt( 'lightbox' ) === 'yes' ) {
			wp_register_style( 'dgwt-jg-photoswipe', DGWT_JG_URL . 'assets/vendors/photoswipe/photoswipe.css', array(), DGWT_JG_VERSION );
			wp_register_style( 'dgwt-jg-photoswipe-skin', DGWT_JG_URL . 'assets/vendors/photoswipe/default-skin/default-skin.css', array(), DGWT_JG_VERSION );

			wp_enqueue_style( array(
				'dgwt-jg-photoswipe',
				'dgwt-jg-photoswipe-skin'
			) );
		}

		// Main CSS
		if ( DGWT_JG_DEBUG === false ) {
			wp_register_style( 'dgwt-jg-style', DGWT_JG_URL . 'assets/css/style.min.css', array(), DGWT_JG_VERSION );
		} else {
			wp_register_style( 'dgwt-jg-style', DGWT_JG_URL . 'assets/css/style.css', array(), DGWT_JG_VERSION );
		}

		wp_enqueue_style( array(
			'dgwt-jg-style'
		) );
	}

}

$attach_scripts = new DGWT_JG_Scripts;
?>
<?php

/**
 * Installation related functions and actions.
 *
 */
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class DGWT_JG_Install {

	/**
	 * Hook in tabs.
	 */
	public static function init() {

		add_action( 'admin_init', array( __CLASS__, 'check_version' ), 5 );
	}

	/**
	 * Install 
	 */
	public static function install() {


		if ( !defined( 'DGWT_JG_INSTALLING' ) ) {
			define( 'DGWT_JG_INSTALLING', true );
		}
		
		self::create_options();
		
		// Update plugin version
		update_option( 'dgwt_jg_version', DGWT_JG_VERSION );

	}
	
	/**
	 * Default options
	 */
	private static function create_options() {

		global $dgwt_jg_settings;

		$sections = DGWT_JG()->settings->settings_fields();

		$settings = array();

		if ( is_array( $sections ) && !empty( $sections ) ) {
			foreach ( $sections as $options ) {

				if ( is_array( $options ) && !empty( $options ) ) {

					foreach ( $options as $option ) {

						if ( isset( $option[ 'name' ] ) && !isset( $dgwt_jg_settings[ $option[ 'name' ] ] ) ) {

							$settings[ $option[ 'name' ] ] = isset( $option[ 'default' ] ) ? $option[ 'default' ] : '';
						}
					}
				}
			}
		}

		$update_options = array_merge( $settings, $dgwt_jg_settings );

		update_option( DGWT_JG_SETTINGS_KEY, $update_options );
	}
		
	
	/**
	 * Check version
	 */
	public static function check_version() {

		if ( !defined( 'IFRAME_REQUEST' ) ) {

			if ( get_option( 'dgwt_jg_version' ) != DGWT_JG_VERSION ) {
				self::install();
			}
		}
	}

}


DGWT_JG_Install::init();

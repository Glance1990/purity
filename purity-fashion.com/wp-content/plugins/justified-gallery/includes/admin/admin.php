<?php

/**
 * Submenu page
 */
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class DGWT_JG_Admin {

	public function __construct() {

		add_action( 'admin_menu', array( $this, 'add_menu' ), 20 );

		add_action( 'admin_head', array( $this, 'hide_gallery_setting' ), 20 );
	}

	/**
	 * Add meun items
	 */
	public function add_menu() {

		//add_menu_page( __( 'Justified Gallery', DGWT_JG_DOMAIN ), __( 'Justified Gallery', DGWT_JG_DOMAIN ), 'manage_options', 'dgwt_jg_settings', array( $this, 'settings_page' ), DGWT_JG_URL . 'assets/img/admin-icon.png', 56 );
	
		add_submenu_page( 'options-general.php', __( 'Justified Gallery', DGWT_JG_DOMAIN ), __( 'Justified Gallery', DGWT_JG_DOMAIN ), 'manage_options', 'dgwt_jg_settings', array( $this, 'settings_page' ) );
	}

	/**
	 * Settings page
	 */
	public function settings_page() {
		DGWT_JG_Settings::output();
	}

	public function hide_gallery_setting() {
		?>
		<style>
			.gallery-settings h2::after{
				display: block;
				clear: both;
				color: #EAAB0E;
				display: block;
				margin-top: 15px;
				content: "<?php _e( 'Gallery Settings are ignored because of Justified Gallery plugin. Just skip it.', DGWT_JG_DOMAIN ) ?>";
			}
		</style>
		<?php

	}

}

$dgwt_jg_admin = new DGWT_JG_Admin();


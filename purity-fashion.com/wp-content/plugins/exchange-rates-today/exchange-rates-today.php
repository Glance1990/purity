<?php
/**
 * @package Exchange Rates Today
 * @version 1.3
 */
/*
Plugin Name: Exchange Rates Today
Plugin URI: http://silver.od.ua
Description: A simple plugin for WooCommerce that allows you to change the price according to the exchange rate. For example, you set the price on the website in dollars and in-store price is displayed in local currency, you simply are asking today's exchange rate, but the plugin automatically changes all prices.
Author: Artyom Lagondyuk
Version: 1.3
Author URI: http://silver.od.ua
*/



add_action ('admin_menu', 'dynamic_price_button');
//Simple product
add_filter( 'woocommerce_get_price',                      'change_price', PHP_INT_MAX - 100, 2 );
add_filter( 'woocommerce_get_sale_price',                 'change_price', PHP_INT_MAX - 100, 2 );
add_filter( 'woocommerce_get_regular_price',              'change_price', PHP_INT_MAX - 100, 2 );
// Variations
add_filter( 'woocommerce_variation_prices_price',         'change_price', PHP_INT_MAX - 100, 2 );
add_filter( 'woocommerce_variation_prices_regular_price', 'change_price', PHP_INT_MAX - 100, 2 );
add_filter( 'woocommerce_variation_prices_sale_price',    'change_price', PHP_INT_MAX - 100, 2 );
add_action( 'admin_init', 'register_mysettings' );

function register_mysettings () {
	register_setting( 'baw-settings-group', 'kurs' );
	register_setting( 'baw-settings-group', 'valuta' );
}

function change_price ($this) {
	$int = $this;
	$kurs=get_option('kurs');
	if ($kurs!='') {
		return $int*$kurs;
	} else  return  $int;
}

function dynamic_price_button () {
	add_submenu_page ('woocommerce', 'Курс сегодня', 'Курс сегодня', 'manage_options', 'dynamic_price', 'setting_page');
}

function setting_page () {
?>
<div class="wrap">
<h2>Курс на сегодня</h2>
<form method="post" action="options.php">
    <?php settings_fields( 'baw-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Курс</th>
        <td><input type="text" name="kurs" value="<?php echo get_option('kurs'); ?>" /></td>
        </tr>               
    </table>
    
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>

</form>
</div>
<?php } ?>
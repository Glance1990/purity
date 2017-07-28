<?php
/**
 *
 * @package   Definitely_allow_mobile_zooming
 * @author    Martin Stehle <m.stehle@gmx.de>
 * @license   GPL-2.0+
 * @link      http://stehle-internet.de/
 * @copyright 2014 Martin Stehle
 *
 * @wordpress-plugin
 * Plugin Name:       Definitely allow mobile zooming
 * Plugin URI:        http://wordpress.org/plugins/definitely-allow-mobile-zooming/
 * Description:       This tiny plugin adds the viewport meta tag with zooming permission to give your users the ability to zoom in your website with mobile browsers.
 * Version:           1.0.7
 * Author:            Martin Stehle
 * Author URI:        http://stehle-internet.de/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
*/

function definitely_allow_mobile_zooming() {
	print '<meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1.0, minimum-scale=0.1, maximum-scale=10.0">';
	print "\n";
}
add_action( 'wp_head', 'definitely_allow_mobile_zooming', 9999999 );

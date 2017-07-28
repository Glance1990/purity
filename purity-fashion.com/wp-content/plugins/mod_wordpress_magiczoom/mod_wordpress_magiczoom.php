<?php
/*

Copyright 2008 MagicToolbox (email : support@magictoolbox.com)
Plugin Name: Magic Zoom
Plugin URI: http://www.magictoolbox.com/magiczoom/?utm_source=TrialVersion&utm_medium=WordPress&utm_content=plugins-page-plugin-url-link&utm_campaign=MagicZoom
Description: Zoom right into an image when hover it. A beautifully smooth effect to show very fine detail. Activate plugin then <a href="https://www.magictoolbox.com/magiczoom/modules/wordpress/#installation">Get Started</a>.
Version: 6.2.9
Author: Magic Toolbox
Author URI: http://www.magictoolbox.com/?utm_source=TrialVersion&utm_medium=WordPress&utm_content=plugins-page-author-url-link&utm_campaign=MagicZoom


*/

/*
    WARNING: DO NOT MODIFY THIS FILE!

    NOTE: If you want change Magic Zoom settings
            please go to plugin page
            and click 'Magic Zoom Configuration' link in top navigation sub-menu.
*/

if(!function_exists('magictoolbox_WordPress_MagicZoom_init')) {
    /* Include MagicToolbox plugins core funtions */
    require_once(dirname(__FILE__)."/magiczoom/plugin.php");
}

//MagicToolboxPluginInit_WordPress_MagicZoom ();
register_activation_hook( __FILE__, 'WordPress_MagicZoom_activate');

register_deactivation_hook( __FILE__, 'WordPress_MagicZoom_deactivate');

register_uninstall_hook(__FILE__, 'WordPress_MagicZoom_uninstall');

magictoolbox_WordPress_MagicZoom_init();
?>
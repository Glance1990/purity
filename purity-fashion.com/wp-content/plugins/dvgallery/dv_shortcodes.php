<?php

add_shortcode('dvgalleries', 'dvgalleries');
add_shortcode('dvgallery', 'dvgallery');
add_shortcode('dvcarousel', 'dvcarousel');
add_shortcode('dvgrid', 'dvgrid');
add_shortcode('dvgridfilter', 'dvgridfilter');
add_shortcode('dvsquare', 'dvsquare');

add_filter("the_content", "dvgallery_content_filter");
add_filter("widget_text", "dvgallery_content_filter", 9);

function dvgallery_content_filter($content) {
 
	// array of custom shortcodes requiring the fix 
	$block = join("|",array("dvgalleries","dvgallery","dvcarousel","dvgrid","dvgridfilter","dvsquare"));
 
	// opening tag
	$rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
		
	// closing tag
	$rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);
 
	return $rep;
 
}

// Galleries
function dvgalleries($atts) {
    extract(shortcode_atts(array(
		"max" => 'max',
        "categoryid" => 'categoryid',
        "vertical" => 'vertical'
	), $atts));
    ob_start();
    include('gallery.php');
    $content = ob_get_clean();
    return $content;
}

// Single Gallery
function dvgallery($atts) {
    extract(shortcode_atts(array(
		"id" => 'id',
        "vertical" => 'vertical'
	), $atts));
    ob_start();
    include('singlegallery.php');
    $content = ob_get_clean();
    return $content;
}

// Carousel
function dvcarousel($atts) {
    extract(shortcode_atts(array(
		"max" => 'max',
        "categoryid" => 'categoryid',
        "columns" => 'columns',
        "autoplay" => 'autoplay',
        "duration" => 'duration'
	), $atts));
    ob_start();
    include('gallery-carousel.php');
    $content = ob_get_clean();
    return $content;
}

// Grid
function dvgrid($atts) {
    extract(shortcode_atts(array(
		"max" => 'max',
        "categoryid" => 'categoryid',
        "itemwidth" => 'itemwidth'
	), $atts));
    ob_start();
    include('gallery-grid.php');
    $content = ob_get_clean();
    return $content;
}

// Grid with filter
function dvgridfilter($atts) {
    extract(shortcode_atts(array(
		"max" => 'max',
        "itemwidth" => 'itemwidth'
	), $atts));
    ob_start();
    include('gallery-grid-filter.php');
    $content = ob_get_clean();
    return $content;
}

// Square grid
function dvsquare($atts) {
    extract(shortcode_atts(array(
		"max" => 'max',
        "categoryid" => 'categoryid'
	), $atts));
    ob_start();
    include('gallery-square.php');
    $content = ob_get_clean();
    return $content;
}
?>
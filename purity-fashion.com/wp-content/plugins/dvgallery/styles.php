<?php
$customcode = esc_attr(get_option('dvgallery_customcode'));
$firstcolor = esc_attr(get_option('dvgallery_first_color'));
$secondcolor = esc_attr(get_option('dvgallery_second_color'));
$thirdcolor = esc_attr(get_option('dvgallery_third_color'));
$fourthcolor = esc_attr(get_option('dvgallery_fourth_color'));
$fifthcolor = esc_attr(get_option('dvgallery_fifth_color'));
$sixthcolor = esc_attr(get_option('dvgallery_sixth_color'));
$seventhcolor = esc_attr(get_option('dvgallery_seventh_color'));
$transparentcolor = esc_attr(get_option('dvgallery_transparent_color'));
$loader = esc_url(get_option('dvgallery_loadingimage'));
$blogtitle = esc_attr(get_option('dvgallery_blogtitle'));
$carouseltitle = esc_attr(get_option('dvgallery_carouseltitle'));
$gridtitle = esc_attr(get_option('dvgallery_gridtitle'));
$lightboxtitle = esc_attr(get_option('dvgallery_lightboxtitle'));
$info = esc_attr(get_option('dvgallery_info'));
$zoom = esc_url(get_option('dvgallery_zoom'));
$video = esc_url(get_option('dvgallery_video'));
$linkgal = esc_url(get_option('dvgallery_linkgal'));
$rightarrow = esc_url(get_option('dvgallery_rightarrow'));
$leftarrow = esc_url(get_option('dvgallery_leftarrow'));
$spaceblog = esc_attr(get_option('dvgallery_spaceblog'));
$spaceimage = esc_attr(get_option('dvgallery_spaceimage'));
$spacecontent = esc_attr(get_option('dvgallery_spacecontent'));
$spaceinner = esc_attr(get_option('dvgallery_spaceinner'));
$spacetitle = esc_attr(get_option('dvgallery_spacetitle'));
$spacep = esc_attr(get_option('dvgallery_spacep'));
$spaceinnergrid = esc_attr(get_option('dvgallery_spaceinnergrid'));
$spacetitlegrid = esc_attr(get_option('dvgallery_spacetitlegrid'));
$spacepgrid = esc_attr(get_option('dvgallery_spacepgrid'));
$linkanimation = esc_attr(get_option('dvgallery_linkanimation'));
$removeloader = esc_attr(get_option('dvgallery_removeloader'));
$filterfont = esc_attr(get_option('dvgallery_filterfont'));
$filterbottom = esc_attr(get_option('dvgallery_filterbottom'));
$filterhorizontal = esc_attr(get_option('dvgallery_filterhorizontal'));
$filtervertical = esc_attr(get_option('dvgallery_filtervertical'));
$verticalheight = esc_attr(get_option('dvgallery_verticalheight'));
$verticalmobile = esc_attr(get_option('dvgallery_verticalmobile'));
ob_start("dvgallerycompress");
  function dvgallerycompress($buffer) {
    /* remove comments */
    $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
    /* remove tabs, spaces, newlines, etc. */
    $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
    return $buffer;
  }
?>
<style type="text/css">
<?php if($linkanimation == "true") { ?>    
.dv-galleryimage a{display:none !important}.dv-galleryimage {cursor:inherit !important;}
<?php } ?>
.dv-galleryimage.vertical {height: <?php if ((!empty($verticalheight)) || ($verticalheight == '0')) { echo $verticalheight; } else { echo esc_attr("200"); } ?>px !important;}   
.dvfilters li {font-size: <?php if (!empty($filterfont)) { echo $filterfont; } else { echo esc_attr("18"); } ?>px;padding: <?php if ((!empty($filtervertical)) || ($filtervertical == '0')) { echo $filtervertical; } else { echo esc_attr("5"); } ?>px <?php if ((!empty($filterhorizontal)) || ($filterhorizontal == '0')) { echo $filterhorizontal; } else { echo esc_attr("15"); } ?>px;}    
.dvfilters-clear {height: <?php if ((!empty($filterbottom)) || ($filterbottom == '0')) { echo $filterbottom; } else { echo esc_attr("20"); } ?>px;}    
.latest-dvgalleries hr {margin-right: -<?php if ((!empty($spaceinnergrid)) || ($spaceinnergrid == '0')) { echo $spaceinnergrid; } else { echo esc_attr("25"); } ?>px;margin-left: -<?php if ((!empty($spaceinnergrid)) || ($spaceinnergrid == '0')) { echo $spaceinnergrid; } else { echo esc_attr("25"); } ?>px;margin-top: <?php if ((!empty($spacetitlegrid)) || ($spacetitlegrid == '0')) { echo $spacetitlegrid; } else { echo esc_attr("25"); } ?>px;margin-bottom: <?php if ((!empty($spacepgrid)) || ($spacepgrid == '0')) { echo $spacepgrid; } else { echo esc_attr("20"); } ?>px;}    
.latest-dvgalleries > figcaption > div {padding: <?php if ((!empty($spaceinnergrid)) || ($spaceinnergrid == '0')) { echo $spaceinnergrid; } else { echo esc_attr("25"); } ?>px; !important;}    
.latest-dvgalleries > figcaption > div > p {margin-bottom: <?php if ((!empty($spacepgrid)) || ($spacepgrid == '0')) { echo $spacepgrid; } else { echo esc_attr("20"); } ?>px !important;}   
.dv-gallerycontent-inner > .dvh4{margin-bottom: <?php if ((!empty($spacetitle)) || ($spacetitle == '0')) { echo $spacetitle; } else { echo esc_attr("20"); } ?>px !important;}
.dv-gallerycontent-inner > p {margin-bottom: <?php if ((!empty($spacep)) || ($spacep == '0')) { echo $spacep; } else { echo esc_attr("35"); } ?>px !important;}    
.dv-gallerycontent-inner {padding: <?php if ((!empty($spaceinner)) || ($spaceinner == '0')) { echo $spaceinner; } else { echo esc_attr("40"); } ?>px; !important;}    
.dv-gallerycontainer {margin-bottom: <?php if ((!empty($spaceblog)) || ($spaceblog == '0')) { echo $spaceblog; } else { echo esc_attr("40"); } ?>px; !important;}
.dv-gallerycontent {width: <?php if ((!empty($spacecontent))) { echo $spacecontent; } else { echo esc_attr("60"); } ?>%;}
.dv-galleryimage {width: <?php if ((!empty($spaceimage)) || ($spaceimage == '0')) { echo $spaceimage; } else { echo esc_attr("40"); } ?>%;}
<?php if($spaceimage == '0') { ?>
@media only screen and (max-width: 768px) {.dv-galleryimage {width: 0% !important;height: 0px !important;}}    
<?php } ?>  
.owl-theme .owl-controls .owl-nav .owl-prev {background-image: url('<?php if (!empty($leftarrow)) { echo $leftarrow; } else {echo esc_attr(plugin_dir_url( __FILE__ ) .'css/icons/c-left.png');} ?>');background-position: center center;background-repeat: no-repeat;}
.owl-theme .owl-controls .owl-nav .owl-next {background-image: url('<?php if (!empty($rightarrow)) { echo $rightarrow; } else {echo esc_attr(plugin_dir_url( __FILE__ ) .'css/icons/c-right.png');} ?>');background-position: center center;background-repeat: no-repeat;}    
.dv-galleryimage a,.dvsquare > a{background-position:center center;background-repeat:no-repeat;background-image:url('<?php if (!empty($zoom)) { echo $zoom; } else {echo esc_attr(plugin_dir_url( __FILE__ ) .'css/icons/zoom.png');} ?>');}
.dv-galleryimage a.videogal,.dvsquare > a.videogal {background-image:url('<?php if (!empty($video)) { echo $video; } else {echo esc_attr(plugin_dir_url( __FILE__ ) .'css/icons/video.png');} ?>');}
.dv-galleryimage a.linkgal,.dvsquare > a.linkgal {background-image:url('<?php if (!empty($linkgal)) { echo $linkgal; } else {echo esc_attr(plugin_dir_url( __FILE__ ) .'css/icons/link.png');} ?>');}      
.dv-gallerycontent-inner > .dvh4{font-size: <?php if (!empty($blogtitle)) { echo $blogtitle; } else { echo esc_attr("24"); } ?>px;}
.latest-dvgalleries  > figcaption > div > .dvh5 {font-size: <?php if (!empty($carouseltitle)) { echo $carouseltitle; } else { echo esc_attr("18"); } ?>px;}
.latest-dvgalleries > figcaption > div > p,.dv-gallerycontent-inner > p {font-size: <?php if (!empty($info)) { echo $info; } else { echo esc_attr("14"); } ?>px;}
<?php if($removeloader != "true") { ?>    
.dv-galleryimage,.lg-outer .lg-item {background:url('<?php if (!empty($loader)) { echo $loader; } else {echo esc_attr(plugin_dir_url( __FILE__ ) .'css/icons/loader.gif');} ?>') no-repeat scroll center center transparent;}
<?php } ?>
.dvsquare > a {background-color: <?php if (!empty($firstcolor)) { echo $firstcolor; } else { echo esc_attr('#66A7C5'); } ?>;}    
.dvfilters li {background-color: <?php if (!empty($fifthcolor)) { echo $fifthcolor; } else { echo esc_attr('#f5f1f0'); } ?>;}   
.dvfilters li:hover {background: <?php if (!empty($secondcolor)) { echo $secondcolor; } else { echo esc_attr('#92bfdb'); } ?>;color: <?php if (!empty($sixthcolor)) { echo $sixthcolor; } else { echo esc_attr('#fff'); } ?>;}
.dvfilters li.gridactive {background: <?php if (!empty($firstcolor)) { echo $firstcolor; } else { echo esc_attr('#66A7C5'); } ?>;color: <?php if (!empty($sixthcolor)) { echo $sixthcolor; } else { echo esc_attr('#fff'); } ?>;}    
.latest-dvgalleries > figcaption > div > p,.dv-gallerycontent-inner > p {color: <?php if (!empty($fourthcolor)) { echo $fourthcolor; } else { echo esc_attr('#6C7476'); } ?>}
.latest-dvgalleries  > figcaption > div > .dvh5,.dv-gallerycontent-inner > .dvh4 {color: <?php if (!empty($thirdcolor)) { echo $thirdcolor; } else { echo esc_attr('#313536'); } ?> !important}    
.dv-gallerycontainer {background-color: <?php if (!empty($fifthcolor)) { echo $fifthcolor; } else { echo esc_attr('#f5f1f0'); } ?>;}
.dv-galleryimage a{background-color: <?php if (!empty($firstcolor)) { echo $firstcolor; } else { echo esc_attr('#66A7C5'); } ?>;}
.dv-gallerycontent-inner > .dvh4 > a,.latest-dvgalleries  > figcaption > div > .dvh5 > a{color:<?php if (!empty($thirdcolor)) { echo $thirdcolor; } else { echo esc_attr('#313536'); } ?> !important;}
.dv-gallerycontent-inner > .dvh4 > a:hover,.latest-dvgalleries  > figcaption > div > .dvh5 > a:hover{color:<?php if (!empty($firstcolor)) { echo $firstcolor; } else { echo esc_attr('#66A7C5'); } ?> !important;}
.dv-readmore-button {color: <?php if (!empty($thirdcolor)) { echo $thirdcolor; } else { echo esc_attr('#313536'); } ?>  !important;}
.dv-readmore-button:hover {color: <?php if (!empty($sixthcolor)) { echo $sixthcolor; } else { echo esc_attr('#fff'); } ?> !important;background-color: <?php if (!empty($firstcolor)) { echo $firstcolor; } else { echo esc_attr('#66A7C5'); } ?>;}
.dv-previous a,.dv-next a {color: <?php if (!empty($sixthcolor)) { echo $sixthcolor; } else { echo esc_attr('#fff'); } ?> !important;background-color: <?php if (!empty($firstcolor)) { echo $firstcolor; } else { echo esc_attr('#66A7C5'); } ?>;}
.dv-next a:hover,.dv-previous a:hover {color: <?php if (!empty($sixthcolor)) { echo $sixthcolor; } else { echo esc_attr('#fff'); } ?> !important;background-color: <?php if (!empty($thirdcolor)) { echo $thirdcolor; } else { echo esc_attr('#313536'); } ?>;}
.latest-dvgalleries > a > img {border-bottom: 3px solid <?php if (!empty($seventhcolor)) { echo $seventhcolor; } else { echo esc_attr('#d9d5d4'); } ?> !important;}
.latest-dvgalleries > a > img:hover {border-bottom: 3px solid <?php if (!empty($firstcolor)) { echo $firstcolor; } else { echo esc_attr('#66A7C5'); } ?> !important;}
/* ================= LIGHTGALLERY ================== */
.lg-actions .lg-next, .lg-actions .lg-prev {
    background-color: <?php if (!empty($transparentcolor)) { echo $transparentcolor; } else { echo esc_attr('rgba(217, 213, 212, 0.9)'); } ?>;
    color: <?php if (!empty($fourthcolor)) { echo $fourthcolor; } else { echo esc_attr('#6C7476'); } ?>;
}
.lg-actions .lg-next:hover, .lg-actions .lg-prev:hover {
    color: <?php if (!empty($sixthcolor)) { echo $sixthcolor; } else { echo esc_attr('#fff'); } ?>;
}
.lg-toolbar {
    background-color: <?php if (!empty($transparentcolor)) { echo $transparentcolor; } else { echo esc_attr('rgba(217, 213, 212, 0.9)'); } ?>;
}
.lg-toolbar .lg-icon {
    color: <?php if (!empty($fourthcolor)) { echo $fourthcolor; } else { echo esc_attr('#6C7476'); } ?>;
}
.lg-toolbar .lg-icon:hover {
    color: <?php if (!empty($sixthcolor)) { echo $sixthcolor; } else { echo esc_attr('#fff'); } ?>;
}
.lg-sub-html {
    background-color: <?php if (!empty($transparentcolor)) { echo $transparentcolor; } else { echo esc_attr('rgba(217, 213, 212, 0.9)'); } ?>;
    color: <?php if (!empty($thirdcolor)) { echo $thirdcolor; } else { echo esc_attr('#313536'); } ?>;
}
#lg-counter {
    color: <?php if (!empty($fourthcolor)) { echo $fourthcolor; } else { echo esc_attr('#6C7476'); } ?>;
}
.lg-outer .lg-thumb-outer {
    background-color: <?php if (!empty($seventhcolor)) { echo $seventhcolor; } else { echo esc_attr('#d9d5d4'); } ?>;
}
.lg-outer .lg-toogle-thumb {
    background-color: <?php if (!empty($seventhcolor)) { echo $seventhcolor; } else { echo esc_attr('#d9d5d4'); } ?>;
    color: <?php if (!empty($fourthcolor)) { echo $fourthcolor; } else { echo esc_attr('#6C7476'); } ?>;
}
.lg-outer .lg-toogle-thumb:hover {
    color: <?php if (!empty($sixthcolor)) { echo $sixthcolor; } else { echo esc_attr('#fff'); } ?>;
}
.lg-progress-bar {
    background-color: <?php if (!empty($seventhcolor)) { echo $seventhcolor; } else { echo esc_attr('#d9d5d4'); } ?>;
}
.lg-progress-bar .lg-progress {
    background-color: <?php if (!empty($firstcolor)) { echo $firstcolor; } else { echo esc_attr('#66A7C5'); } ?>;
}
.lg-backdrop {
    background-color: <?php if (!empty($fifthcolor)) { echo $fifthcolor; } else { echo esc_attr('#f5f1f0'); } ?>;
}    
/* ================= OWL CAROUSEL  ================== */
.owl-theme .owl-controls .owl-nav {color: <?php if (!empty($sixthcolor)) { echo $sixthcolor; } else { echo esc_attr('#fff'); } ?>;background-color: <?php if (!empty($fifthcolor)) { echo $fifthcolor; } else { echo esc_attr('#f5f1f0'); } ?>;}
.latest-dvgalleries > figcaption {background-color: <?php if (!empty($fifthcolor)) { echo $fifthcolor; } else { echo esc_attr('#f5f1f0'); } ?>;}
.latest-dvgalleries > figcaption > div > hr {background-color: <?php if (!empty($sixthcolor)) { echo $sixthcolor; } else { echo esc_attr('#fff'); } ?> !important;}
.latest-dvgalleries .dvh5 a {color: <?php if (!empty($thirdcolor)) { echo $thirdcolor; } else { echo esc_attr('#313536'); } ?>;}
.latest-dvgalleries .dvh5 a:hover {color: <?php if (!empty($firstcolor)) { echo $firstcolor; } else { echo esc_attr('#66A7C5'); } ?>;}
@media only screen and (max-width: 768px) {.dv-galleryimage,.dv-galleryimage.vertical {height: <?php if ((!empty($verticalmobile)) || ($verticalmobile == '0')) { echo $verticalmobile; } else { echo esc_attr("200"); } ?>px !important;}}    
</style>
<?php ob_end_flush(); ?>
<?php if (!empty($customcode)) { ?>
<style type="text/css">
<?php echo $customcode; ?>    
</style>    
<?php } ?>
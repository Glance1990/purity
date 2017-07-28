<?php
if (empty($categoryid)) {
    $gallerycarargs = array(
        'post_type' => 'dvgalleries',
        'posts_per_page' => $max
    );
}
else {
    if ( function_exists('icl_object_id') ) {
        $carcatid_array = (int)$categoryid;
    }
    else {
        $carcatid_array = explode(',', $categoryid);
    }
    $gallerycarargs = array(
        'post_type' => 'dvgalleries',
        'posts_per_page' => $max,
        'tax_query' => array(
            array(
                'taxonomy' => 'dvgallerytaxonomy',
                'terms'    => $carcatid_array,
            ),
        )
    );
}
$gallerycar_query = new WP_Query( $gallerycarargs );
if (is_rtl()) { 
    $array_rev = array_reverse($gallerycar_query->posts);
    $gallerycar_query->posts = $array_rev;
}
$random = rand();
$spacecarousel = esc_attr(get_option('dvgallery_spacecarousel'));
$lgzoom = get_option('dvgallery_lgzoom');
$lgfullscreen = get_option('dvgallery_lgfullscreen');
$lgthumbnails = get_option('dvgallery_lgthumbnails');
$lgdownload = get_option('dvgallery_lgdownload');
$lgcounter = get_option('dvgallery_lgcounter');
$lghide = get_option('dvgallery_lghide');
?>
<div id="dv-latestgalleries<?php echo esc_attr($random); ?>" class="owl-carousel">
<?php while($gallerycar_query->have_posts()) : $gallerycar_query->the_post(); ?>
<?php $looprandom = rand(); ?>   
<?php $galleryid = get_the_id(); ?>
<?php $gallerytext = get_post_meta( get_the_id(), 'dvgallerytext', true ); ?>
<?php $gallerytype = get_post_meta( get_the_id(), 'dvgallerytype', true ); ?>
<?php $galleryimages = get_post_meta( get_the_id(), 'dvgalleryimages', true ); ?>
<?php $galleryvideos = get_post_meta( get_the_id(), 'dvgalleryvideos', true ); ?>
<?php $externallink = get_post_meta( get_the_id(), 'dvexternallink', true ); ?>
<?php $newindow = get_post_meta( get_the_id(), 'dvblank', true ); ?>
<?php $galleryautoplay = get_post_meta( get_the_id(), 'dvactivateauto', true ); ?>
<?php $galleryautoplayduration = get_post_meta( get_the_id(), 'dvautoplaypause', true ); ?>    
    <figure id="gallerycar<?php echo esc_attr($looprandom); ?><?php $galleryid; ?>" class="latest-dvgalleries">
        <?php if ( has_post_thumbnail() ) { ?>
        <?php 
$thumb_id = get_post_thumbnail_id();
$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'dv-post-thumbnail', true);
$thumb_url = $thumb_url_array[0];  
        ?>
        <a href="<?php if ($gallerytype == 'link') { echo esc_url($externallink); } else {echo esc_attr('#');} ?>" class="<?php if ($gallerytype != 'link') { echo esc_attr('openlightbox'); } ?>" <?php if ($newindow == 'on') { echo 'target="_blank"'; } ?>>
            <img src="<?php echo esc_url($thumb_url); ?>" alt="" />
        </a>
        <?php } ?>
        <figcaption>
            <div>
                <div class="dvh5"><a href="<?php if ($gallerytype == 'link') { echo esc_url($externallink); } else {echo esc_attr('#');} ?>" class="<?php if ($gallerytype != 'link') { echo esc_attr('openlightbox'); } ?>" <?php if ($newindow == 'on') { echo 'target="_blank"'; } ?>><?php the_title(); ?></a></div>
                <hr/>
                <?php if(!empty ($gallerytext)) { ?>
                <?php echo apply_filters('the_content',$gallerytext); ?>
                <a href="<?php if ($gallerytype == 'link') { echo esc_url($externallink); } else {echo esc_attr('#');} ?>" class="<?php if ($gallerytype != 'link') { echo esc_attr('openlightbox'); } ?> dv-readmore-button" <?php if ($newindow == 'on') { echo 'target="_blank"'; } ?>><?php esc_attr_e( 'View Gallery', 'dvgallery' ); ?></a>
                <?php } ?>
            </div>
            <?php if (($gallerytype != 'video') && (!empty($galleryimages))) { ?>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('#gallerycar<?php echo esc_js($looprandom); ?><?php $galleryid; ?> .openlightbox').click(function (e) {
            e.preventDefault();
            jQuery(this).lightGallery({
                dynamic: true,
                    preload: 2,
                    zoom: <?php if (!empty($lgzoom)) { echo esc_js($lgzoom); } else { echo esc_js('true'); } ?>,
                    fullScreen: <?php if (!empty($lgfullscreen)) { echo esc_js($lgfullscreen); } else { echo esc_js('true'); } ?>,
                    thumbnail: <?php if (!empty($lgthumbnails)) { echo esc_js($lgthumbnails); } else { echo esc_js('true'); } ?>,
                    download: <?php if (!empty($lgdownload)) { echo esc_js($lgdownload); } else { echo esc_js('true'); } ?>,
                    counter: <?php if (!empty($lgcounter)) { echo esc_js($lgcounter); } else { echo esc_js('true'); } ?>,
                    hideBarsDelay: <?php if (!empty($lghide)) { echo esc_js($lghide); } else { echo esc_js('6'); } ?>000,
                <?php if ($galleryautoplay == 'on') { ?>
                autoplay: true,
                pause: <?php if(!empty($galleryautoplayduration)) { echo esc_js($galleryautoplayduration); } else { echo esc_js('4'); } ?>000,
                <?php } ?>
                dynamicEl: [
                    <?php foreach ($galleryimages as $image => $link) { ?> 
                    <?php $fullimage = wp_get_attachment_image_src( $image, 'full' ); ?>
                    <?php $large = wp_get_attachment_image_src( $image, 'large' ); ?>
                    <?php $medium = wp_get_attachment_image_src( $image, 'medium' ); ?>
                    <?php $thumb = wp_get_attachment_image_src( $image, 'thumbnail' ); ?>
                    <?php $attachment = get_post($image); ?>
                    {
                        "src": "<?php echo esc_js($fullimage['0']); ?>",
                        "thumb": "<?php echo esc_js($thumb['0']); ?>",
                        "subHtml": "<?php echo esc_js($attachment->post_excerpt); ?>",
                        "responsive": "<?php echo $medium[0]; ?> 480, <?php echo $large[0]; ?> 1024"
                    },
                    <?php } ?>                    
                ]
            });
        })
    });
</script> 
        <?php } if (($gallerytype == 'video') && (!empty($galleryvideos))) { ?>
        <script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery('#gallerycar<?php echo esc_js($looprandom); ?><?php $galleryid; ?> .openlightbox').click(function (e) {
                e.preventDefault();
                jQuery(this).lightGallery({
                    dynamic: true,
                    zoom: false,
                    fullScreen: false,
                    autoplay: false,
                    autoplayControls: false,
                    thumbnail: false,
                    download: <?php if (!empty($lgdownload)) { echo esc_js($lgdownload); } else { echo esc_js('true'); } ?>,
                    counter: <?php if (!empty($lgcounter)) { echo esc_js($lgcounter); } else { echo esc_js('true'); } ?>,
                    hideBarsDelay: <?php if (!empty($lghide)) { echo esc_js($lghide); } else { echo esc_js('6'); } ?>000,
                    dynamicEl: [
                        <?php foreach ($galleryvideos as $video => $link) { ?> 
                        <?php if (isset($link['dvvideourl'])) { $videourl = esc_js($link['dvvideourl']); } ?>
                        <?php if (isset($link['dvvideotitle'])) { $videotitle = esc_js($link['dvvideotitle']); } ?>
                        {
                            "src": "<?php if (isset($link['dvvideourl'])) { echo esc_js($videourl); } ?>",
                            "subHtml": "<?php if (isset($link['dvvideotitle'])) { echo esc_js($videotitle); } ?>",
                        },
                        <?php } ?>
                    ]
                });
            })
        });
    </script>
        <?php } ?> 
        </figcaption>
    </figure>   
<?php endwhile; ?>    
</div>
<div class="clear"></div>
<script type="text/javascript">
    jQuery(window).load(function () {
        jQuery("body").find("#dv-latestgalleries<?php echo esc_js($random); ?>").fadeIn();
        jQuery("#dv-latestgalleries<?php echo esc_js($random); ?>").owlCarousel({
            items: 1,
            margin: <?php if ((!empty($spacecarousel)) || ($spacecarousel == '0')) { echo $spacecarousel; } else { echo esc_js("40"); } ?>,
            dots: false,
            <?php if (is_rtl()) { echo esc_js("rtl:true,"); } ?>
            autoplay: <?php echo esc_js($autoplay); ?>,
            autoplayTimeout: <?php echo esc_js($duration); ?>000,
            autoplayHoverPause: true,
            <?php if (($columns != '4') && ($columns != '3') && ($columns != '2')) { ?>
            autoHeight: true,
            <?php } ?>
            smartSpeed: 800,
            navText: [' ', ' '],
            nav: true,
            loop: true,
            <?php if ($columns == '4') { ?>
            responsive: {
                480: {
                    items: 1
                },
                640: {
                    items: 2
                },
                900: {
                    items: 4
                }
            }
            <?php } ?>
            <?php if ($columns == '3') { ?>
            responsive: {
                480: {
                    items: 1
                },
                640: {
                    items: 2
                },
                900: {
                    items: 3
                }
            }
            <?php } ?>
            <?php if ($columns == '2') { ?>
            responsive: {
                480: {
                    items: 1
                },
                640: {
                    items: 1
                },
                900: {
                    items: 2
                }
            }
            <?php } ?>                                                     
        });
    });
</script>
<?php wp_reset_postdata(); ?>
<?php
/*
Template Name: Страница Галереи
*/
?>

<?php get_header(); ?>
<section id="content" role="main" class="gal">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<header class="header">
<h1 class="entry-title"><?php the_title(); ?></h1> <?php edit_post_link(); ?>
</header>

<section class="entry-content">
	<div class="addinfo"><?php the_field('addheader'); ?></div>
	<div class="pageimg"><?php if ( has_post_thumbnail() ) { the_post_thumbnail(''); } ?></div>
	<div class="pagecont"><?php the_content(); ?></div>



<?php $images = get_field('gal');
if( $images ): ?>
<div class="gallery">
    <ul>
        <?php foreach( $images as $image ): 
            $content = '<li>';
                $content .= '<a class="gallery_image" href="'. $image['url'] .'">';
                     $content .= '<img src="'. $image['sizes']['thumbnail'] .'" alt="'. $image['alt'] .'" />';
                $content .= '</a>';
            $content .= '</li>';
            if ( function_exists('slb_activate') ){
    $content = slb_activate($content);
    }
    
echo $content;?>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

</section>

</article>

<?php endwhile; endif; ?>
</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
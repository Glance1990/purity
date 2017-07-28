<?php
/*
Template Name: Команда
*/
?>
<?php get_header(); ?>
<section id="content" role="main"  class="komanda">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<header class="header">
<h1 class="entry-title"><?php the_title(); ?></h1> <?php edit_post_link(); ?>
</header>

<section class="entry-content">
	<div class="pagecont" style="margin-top: 50px !important;">
	<span class="addinfo"><?php echo (get_post_meta($post->ID, 'additional', true)); ?></span>
						<div class="pageimg"><?php if ( has_post_thumbnail() ) { the_post_thumbnail(''); } ?></div>
	</div>
	<div class="pageseccont">
	<?php

	// check if the repeater field has rows of data
		if( have_rows('kom_logo') ):
			$eot = '';
			$eot .= '<div class="logo-boxs">';
			// loop through the rows of data
			while ( have_rows('kom_logo') ) : the_row();

				// display a sub field value
				$img = get_sub_field('image');
				
				$eot .= '<div class="logo-box">';
				$eot .= '<img src="'.$img['url'].'" alt="'.$img['alt'].'" />';
				$eot .= '</div>';
			endwhile;
			// no rows found
			$eot .= '</div>';
		endif;
		
		echo $eot;
	?>
<?php the_content(); ?>
	</div>
<div class="entry-links"><?php wp_link_pages(); ?></div>


</section>

</article>

<?php endwhile; endif; ?>
</section>
<?php get_sidebar('conc-area'); ?>
<?php get_footer(); ?>
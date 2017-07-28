<?php
/*
Template Name: Команда2
*/
?>
<?php get_header(); ?>
<section id="content" role="main"  class="komanda style pad">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<header class="header">
			<h1 class="entry-title"><?php the_title(); ?></h1> <?php edit_post_link(); ?>
		</header>

		<section class="entry-content komanda-two">
			<div class="pagecont">
				<span class="addinfo"><?php echo (get_post_meta($post->ID, 'additional', true)); ?></span>
			
					<?php if ( has_post_thumbnail() ) { the_post_thumbnail(''); } ?>
				
			</div>
			<div class="pageseccont">
				<?php the_content(); ?>
				<?php

				// check if the repeater field has rows of data
					if( have_rows('kom2_block') ):
						$eot = '';
						// loop through the rows of data
						while ( have_rows('kom2_block') ) : the_row();

							// display a sub field value
							$img = get_sub_field('kom_image');
							$title = get_sub_field('kom_title');
							$text = get_sub_field('kom_text');
							$eot .= '<div class="crow scrollme">';
							$eot .= '<div class="animateme" data-when="view" data-from="0.7" data-to="0" data-opacity="0" data-translatex="0" data-translatey="250">';
							$eot .= '<img src="'.$img['url'].'" style="width: 45%; float: left; margin: 0 15px 15px 0;" alt="'.$img['alt'].'" />';
							$eot .= '<h2>'.$title.'</h2>';
							$eot .= $text;
							$eot .= '</div>';							
							$eot .= '</div>';

						endwhile;
						// no rows found

					endif;
					
					echo $eot;
				?>
				<div class="clear:both;">
				<div style="float: left;"><?php the_field('kom2_text_fild'); ?></div>
			</div>
			<div class="entry-links"><?php wp_link_pages(); ?></div>
		</section>

	</article>

	<?php endwhile; endif; ?>
</section>
<?php get_sidebar('conc-area'); ?>
<?php get_footer(); ?>
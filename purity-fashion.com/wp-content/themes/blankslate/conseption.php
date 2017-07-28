<?php
/*
Template Name: Концепция Purity
*/
?>
<?php get_header(); ?>
<section id="content" role="main" class="concept">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<div class="pageimg"><?php if ( has_post_thumbnail() ) { the_post_thumbnail(''); } ?></div>
<div class="pad">
<h1 class="entry-title scrollme animateme" data-when="span" data-from="0.3" data-to="0" data-opacity="1" data-translatex="0" data-translatey="50" id="h-top"><?php the_title(); ?></h1> <?php edit_post_link(); ?><div style="clear: both"></div>
	<div class="pagecont scrollme animateme" data-when="span" data-from="0.3" data-to="0" data-opacity="0" data-translatex="0" data-translatey="100"><?php the_content(); ?></div>

<section class="entry-content">
<div class="crow scrollme">
	<div class="conceptimg animateme" data-when="view" data-from="0.7" data-to="0" data-opacity="0" data-translatex="0" data-translatey="250">
	<img src="<?php the_field('img_1'); ?>" /></div>
	<div class="conceptinfo animateme"  data-when="view" data-from="0.8" data-to="0" data-opacity="0" data-translatex="0" data-translatey="500"><?php the_field('text_1'); ?></div>
</div>
<div class="crow scrollme">
	<div class="conceptinfo animateme" data-when="view" data-from="1" data-to="0" data-opacity="0" data-translatex="0" data-translatey="500"><?php the_field('text_2'); ?></div>
	<div class="conceptimg animateme" data-when="view" data-from="0.7" data-to="0" data-opacity="0" data-translatex="0" data-translatey="250"><img src="<?php the_field('img_2'); ?>" /></div>
</div>
<div class="crow scrollme">
	<div class="conceptimg animateme" data-when="view" data-from="0.7" data-to="0" data-opacity="0" data-translatex="0" data-translatey="250"><img src="<?php the_field('img_3'); ?>" /></div>
	<div class="conceptinfo animateme" data-from="1" data-to="0" data-opacity="0" data-translatex="0" data-translatey="600"><?php the_field('text_3'); ?></div>
</div>
<div class="crow scrollme">
	<div class="conceptinfo animateme" data-from="1" data-to="0" data-opacity="0" data-translatex="0" data-translatey="700"><?php the_field('text_4'); ?></div>
	<div class="conceptimg animateme" data-when="view" data-from="0.7" data-to="0" data-opacity="0" data-translatex="0" data-translatey="250"><img src="<?php the_field('img_4'); ?>" /></div>
</div>
<div class="crowbot scrollme">
	<div class="conceptimg animateme" data-when="view" data-from="0.7" data-to="0" data-opacity="0" data-translatex="0" data-translatey="250"><img src="<?php the_field('img_5'); ?>" /></div>
	<div class="conceptinfo animateme" data-from="1" data-to="0" data-opacity="0" data-translatex="0" data-translatey="900"><?php the_field('text_5'); ?></div>
</div>
</section>
</div>

</article>

<?php endwhile; endif; ?>
</section>
<?php get_sidebar('conc-area'); ?>
<?php get_footer(); ?>

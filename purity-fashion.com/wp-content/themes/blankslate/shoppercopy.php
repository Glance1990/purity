
<?php get_header(); ?>
<section id="content" role="main" class="style">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<div class="pageimg"><?php if ( has_post_thumbnail() ) { the_post_thumbnail(''); } ?></div>
<div class="pad">
<h1 class="entry-title"><?php the_title(); ?></h1> <?php edit_post_link(); ?><div style="clear: both"></div>
	<div class="pagecont"><?php the_content(); ?></div>



<section class="entry-content">
<div class="crow scrollme">
	<div class="conceptinfo animateme" data-when="view" data-from="0.7" data-to="0" data-opacity="0" data-translatex="0" data-translatey="180">
	<h2><?php the_field('t-1'); ?></h2>
	<span><?php the_field('tt-1'); ?></span>
	</div>
	<div class="conceptprice animateme"  data-when="view" data-from="0.8" data-to="0" data-opacity="0" data-translatex="0" data-translatey="380"><?php the_field('pt-1'); ?></div>
	<div class="shoppimg animateme" data-when="view" data-from="0.7" data-to="0" data-opacity="0" data-translatex="0" data-translatey="250">
	<img src="<?php the_field('img_1'); ?>" /></div>
</div>
<div class="crow scrollme">
	<div class="conceptinfo animateme" data-when="view" data-from="0.7" data-to="0" data-opacity="0" data-translatex="0" data-translatey="180">
	<h2><?php the_field('t-2'); ?></h2>
	<span><?php the_field('tt-2'); ?></span>
	</div>
	<div class="conceptprice animateme"  data-when="view" data-from="0.8" data-to="0" data-opacity="0" data-translatex="0" data-translatey="380"><?php the_field('pt-2'); ?></div>
</div>

<div class="crow scrollme">
	<div class="conceptinfo animateme" data-when="view" data-from="0.7" data-to="0" data-opacity="0" data-translatex="0" data-translatey="180">
	<h2><?php the_field('t-3'); ?></h2>
	<span><?php the_field('tt-3'); ?></span>
	</div>
	<div class="conceptprice animateme"  data-when="view" data-from="0.8" data-to="0" data-opacity="0" data-translatex="0" data-translatey="380"><?php the_field('pt-3'); ?></div>
</div>

<div class="crow scrollme">
	<div class="conceptinfo animateme" data-when="view" data-from="0.7" data-to="0" data-opacity="0" data-translatex="0" data-translatey="180">
	<h2><?php the_field('t-4'); ?></h2>
	<span><?php the_field('tt-4'); ?></span>
	</div>
	<div class="conceptprice animateme"  data-when="view" data-from="0.8" data-to="0" data-opacity="0" data-translatex="0" data-translatey="380"><?php the_field('pt-4'); ?></div>
</div>

<div class="crow scrollme">
	<div class="conceptinfo animateme" data-when="view" data-from="0.7" data-to="0" data-opacity="0" data-translatex="0" data-translatey="180">
	<h2><?php the_field('t-5'); ?></h2>
	<span><?php the_field('tt-5'); ?></span>
	</div>
	<div class="conceptprice animateme"  data-when="view" data-from="0.8" data-to="0" data-opacity="0" data-translatex="0" data-translatey="380"><?php the_field('pt-5'); ?></div>
</div>
<div class="crow scrollme">
	<div class="conceptinfo animateme" data-when="view" data-from="0.7" data-to="0" data-opacity="0" data-translatex="0" data-translatey="180">
	<h2><?php the_field('t-6'); ?></h2>
	<span><?php the_field('tt-6'); ?></span>
	</div>
	<div class="conceptprice animateme"  data-when="view" data-from="0.8" data-to="0" data-opacity="0" data-translatex="0" data-translatey="380"><?php the_field('pt-6'); ?></div>
</div>

<div class="crow scrollme">
	<div class="conceptinfo animateme" data-when="view" data-from="0.7" data-to="0" data-opacity="0" data-translatex="0" data-translatey="180">
	<h2><?php the_field('t-7'); ?></h2>
	<span><?php the_field('tt-7'); ?></span>
	</div>
	<div class="conceptprice animateme"  data-when="view" data-from="0.8" data-to="0" data-opacity="0" data-translatex="0" data-translatey="380"><?php the_field('pt-7'); ?></div>
</div>

</article>

<?php endwhile; endif; ?>
</section>
<?php get_sidebar('conc-area'); ?>
<?php get_footer(); ?>

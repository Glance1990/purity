<?php get_header(); ?>
<section id="content" role="main">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<header class="header">
<h1 class="entry-title"><?php the_title(); ?></h1> <?php edit_post_link(); ?>
</header>

<section class="entry-content">
	<div class="pagecont">
	<span class="addinfo"><?php echo (get_post_meta($post->ID, 'additional', true)); ?></span>
	<?php the_content(); ?></div>
						<div class="pageimg"><?php the_field('someinfo'); ?><?php if ( has_post_thumbnail() ) { the_post_thumbnail(''); } ?><?php the_field('someinfo2'); ?></div>

<div class="entry-links"><?php wp_link_pages(); ?></div>


</section>

</article>

<?php endwhile; endif; ?>
</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
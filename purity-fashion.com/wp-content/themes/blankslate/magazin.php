<?php
/*
Template Name: Мага
*/
?>
<?php get_header(); ?>
<section id="content" role="main"  class="komanda mag">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<header class="header">
				<h1 class="entry-title"><?php the_title(); ?></h1> <?php edit_post_link(); ?>
				<div class="magazin-nav-top">
					<a class="btn-mobl mvt" >Категории</a>
					<?php wp_nav_menu( array( 'theme_location' => 'm-menu', 'menu_class' => 'm-menu' ) ); ?>
				</div>
			</header>

			<section class="entry-content" style="padding: 50px 0 0 0;">

									<div class="pageimg"><?php if ( has_post_thumbnail() ) { the_post_thumbnail(''); } ?></div>
				<div class="pageseccont">
			<?php the_content(); ?>
				</div>
			<div class="entry-links"><?php wp_link_pages(); ?></div>


			</section>

		</article>

	<?php endwhile; endif; ?>
</section>
<div class="rand-product-4">
	<?= do_shortcode('[recent_products per_page="4" columns="4" orderby="rand" order="rand"]'); ?>
</div>
<?php get_sidebar('conc-area'); ?>

<?php get_footer(); ?>
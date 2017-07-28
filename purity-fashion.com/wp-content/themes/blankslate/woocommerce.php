<?php get_header(); ?>
	<header class="header">
		<h1 class="entry-title">SHOP ONLINE</h1>
		<?php woocommerce_breadcrumb(); ?>
		<div class="magazin-nav-top">
			<a class="btn-mobl mvt" ><span><span></span></span>Категории</a>
			<?php wp_nav_menu( array( 'theme_location' => 'm-menu', 'menu_class' => 'm-menu' ) ); ?>
		</div>
	</header>
<section id="content" role="main">
<?php woocommerce_content(); ?>
<?php get_sidebar('conc-area'); ?>
</section>
<?php get_footer(); ?>
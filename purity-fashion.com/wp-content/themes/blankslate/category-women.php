<?php get_header(); ?>
<?php custom_breadcrumbs(); ?>

<section id="content" role="main">
<header class="header">
<h1 class="entry-title"><?php single_cat_title(); ?></h1>
<?php if ( '' != category_description() ) echo apply_filters( 'archive_meta', '<div class="archive-meta">' . category_description() . '</div>' ); ?>
</header>
<?php 
$cat = get_category( get_query_var( 'cat' ) );
$category = $cat->slug;
echo do_shortcode('[ajax_load_more posts_per_page="6" category="'.$category.'"]');
?>
</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>


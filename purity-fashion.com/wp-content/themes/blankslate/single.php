<?php get_header(); ?>
<section id="content" role="main">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<?php if ( in_category( '8' ) ) {
  get_template_part( 'entry', 'portfolio' );
  } elseif ( in_category( '9' ) ) {
  get_template_part( 'entry', 'portfolio' );
   } elseif ( in_category( '22' ) ) {
	 the_title('<h1>', '</h1>');
	the_content();

  } else {
  get_template_part( 'entry' );
  }
?>

<?php endwhile; endif; ?>
</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
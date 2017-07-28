<?php get_header(); ?>
<?php custom_breadcrumbs(); ?>

<section id="content" role="main">
<header class="header">
<h1 class="entry-title">!!!<?php single_cat_title(); ?></h1>
<?php if ( '' != category_description() ) echo apply_filters( 'archive_meta', '<div class="archive-meta">' . category_description() . '</div>' ); ?>
</header>


<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<article class="newsline" >

<div class="nimg"><?php if ( has_post_thumbnail() ) { the_post_thumbnail('thumb'); } ?></div>
<div class="nc"><span class="dt">	<?php the_time('m/d/y') ?></span>
<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark">
<h2 class="entry-title"><?php the_title(); ?></h2>
<span class="ncc"><a class="ncca" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_excerpt(); ?></a></span>
</div>

</article>

<?php endwhile; endif; ?>

</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>


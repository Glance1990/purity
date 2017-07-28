<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<a href="<?php echo get_permalink(get_adjacent_post(false,'',false)); ?>"><nav class="prpost"></nav></a>
<section class="postcont">
<header>
<h1 class="entry-title"><?php the_title(); ?></h1> <?php edit_post_link(); ?>
</header>
<?php get_template_part( 'entry', 'pcont' ); ?>
</section>
<a href="<?php echo get_permalink(get_adjacent_post(false,'',true)); ?>"><nav class="npost"></nav></a>
</article>
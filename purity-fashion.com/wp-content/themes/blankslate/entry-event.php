<?php custom_breadcrumbs(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="padding: 0 5% 0 8%!important;">
<header>

<h1 style="font-size: 2.2em;
    color: #4A4A4A;
    text-transform: uppercase;
    letter-spacing: 2px;
    border-bottom: 3px solid #B5B5B5;
    padding: 0 0 20px 0;
    margin: 0 0 20px 0;
    display: inline-block;
    text-align: left;
	    line-height: 140%;
	    white-space: normal;"><?php the_title(); ?></h1> <?php edit_post_link(); ?>
</header>
<?php the_content(); ?>
</article>
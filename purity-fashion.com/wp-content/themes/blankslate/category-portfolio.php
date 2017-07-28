<?php get_header(); ?>
<?php custom_breadcrumbs(); ?>

<section id="content" role="main" class="portf">

<header class="header">

<h1 class="entry-title"><?php single_cat_title(); ?></h1>
<?php if ( '' != category_description() ) echo apply_filters( 'archive_meta', '<div class="archive-meta">' . category_description() . '</div>' ); ?>
</header>

<?php
echo category_description();
if (count(get_categories('child_of='.$cat))): ?>
<ul class="portf">
<?php wp_list_categories('title_li=&orderby=order&optioncount=0&use_desc_for_title=1&child_of='.$cat); ?>
</ul>
<?php endif; ?>
</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>


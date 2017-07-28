<?php get_header(); ?>

<section id="content" role="main">
<h1 class="entry-title">Блог</h1>
			<?php
		if ( get_query_var('paged') ) { $paged = get_query_var('paged'); } else if ( get_query_var('page') ) {$paged = get_query_var('page'); } else {$paged = 1; }

		$args = array(
			'posts_per_page' => 12,
			'post_type' => 'post',
			'cat'=> 22,
			'paged' => $paged
		);

		$query = new WP_Query( $args );
		

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				?>
					<article class="newsline" >

						<div class="nimg"><?php if ( has_post_thumbnail() ) { the_post_thumbnail('thumb'); } ?></div>
						<div class="nc">
						
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark">
								<h2 class="entry-title"><?php the_title(); ?></h2>
								<span class="dt"><?php the_date('m/d/y') ?></span>
								<span class="ncc">
									<a class="ncca" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_excerpt(); ?></a>
								</span>
							</a>
						</div>

					</article>
				<?php
			}
		} else {
	
		}

		wp_reset_postdata();
	?>
</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
<?php 
/*
*Template name: Blog
*/
get_header(); ?>
<section id="content" role="main">
	<header class="header">
		<h1 class="entry-title"><?php 
			if ( is_day() ) { printf( __( 'Daily Archives: %s', 'blankslate' ), get_the_time( get_option( 'date_format' ) ) ); }
			
			elseif ( is_month() ) { printf( __( 'Monthly Archives: %s', 'blankslate' ), get_the_time( 'F Y' ) ); }
			
			elseif ( is_year() ) { printf( __( 'Yearly Archives: %s', 'blankslate' ), get_the_time( 'Y' ) ); }
			
			else { _e( 'Archives', 'blankslate' ); }
			?>
		</h1>
	</header>
	<?php
		$paged = ( get_query_var('page') ) ? get_query_var('page') : 1;
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
						<div class="nc"><span class="dt">	<?php the_time('m/d/y') ?></span>
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark">
								<h2 class="entry-title"><?php the_title(); ?></h2>
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
<?php kama_pagenavi(); ?>
</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
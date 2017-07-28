<?php
/**
  Template Name: New My Team
 * 
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
  
get_header(); ?>

<main class="page-in">  
	<div class="container">
	
		<div class="row">
			<div class="col-md-12">
				<div class="title-page-in"><?php echo get_the_title( $post_id ); ?></div>
				<div class="line-in"></div>
			</div>
		</div>
				
		<section class="box-info">
			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-12">
						<?php echo the_content($post_id ); ?>	
				</div>
			</div>	
		</section>
			
			
		<section class="text">
		
			<div class="row">
			
				<div class="col-sm-12 col-md-6 col-lg-6">
					<?php the_field('text_left_team'); ?>
				</div>
				
				<div class="col-sm-12 col-md-6 col-lg-6">
					<img class="img-iv-mk" src="<?php the_field('img_right_team'); ?>">
				</div>	
				
			</div>	
			
		</section>


		<section class="text">
		
			<div class="row">
				
				<div class="col-sm-12 col-md-6 col-lg-6">
					<img class="img-iv-mk" src="<?php the_field('img_left_team'); ?>">
				</div>	

				<div class="col-sm-12 col-md-6 col-lg-6">
					<?php the_field('text_right_team'); ?>
				</div>
				
			</div>	
			
		</section>			
			
		<section class="text">
		
			<div class="row">
			<?php if( have_rows('box_text_team') ): ?>
				<?php while( have_rows('box_text_team') ): the_row(); ?>	
							
				<div class="col-sm-12 col-md-4 col-lg-4">
						<?php the_sub_field('box_text_in_team'); ?>
				</div>	
				
				<?php endwhile; ?>
			<?php endif; ?>	
				
			</div>	
			
		</section>


	</div>
</main>
  
<?php get_sidebar('conc-area'); ?>
<?php get_footer(); ?>
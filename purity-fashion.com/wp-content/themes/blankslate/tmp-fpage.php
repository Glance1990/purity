<?php
/**
  Template Name: New 5 page
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
	
		
		<section class="img-fon" style="background-image:url('<?php the_field('img_fon'); ?>')">		
		</section>
		
<div class="container">	
			
		<section class="title-block">
			<div class="row">
				<div class="col-md-12">
					<div class="title-page-in"><?php echo get_the_title( $post_id ); ?></div>
					<div class="line-in"></div>
				</div>
			</div>
		</section>					
			
		<section class="text-after">		
			<div class="row">			
				<div class="col-md-12">
					<p class="text-justify">
						<?php echo the_content($post_id ); ?>
					</p>
				</div>
			</div>				
		</section>
			

		<?php if( have_rows('row_text') ): ?>
			<?php while( have_rows('row_text') ): the_row(); ?>


		<section class="text-row">
		
			<div class="row">
			
				<div class="col-sm-12 col-md-6 col-lg-6">
					<img src="<?php the_sub_field('img_left'); ?>"/>
				</div>
				
				<div class="col-sm-12 col-md-6 col-lg-6">
					<div class="title-block"><span><?php the_sub_field('title_left'); ?></span></div>
					<p class="text-justify"><?php the_sub_field('text_left'); ?><p>
				</div>	
				
			</div>	
			
		</section>

		<section class="text-row">
		
			<div class="row">
				
				<div class="col-sm-12 col-md-6 col-lg-6">
					<div class="title-block"><span><?php the_sub_field('title_right'); ?></span></div>
					<p class="text-justify"><?php the_sub_field('text_right'); ?><p>
				</div>	

				<div class="col-sm-12 col-md-6 col-lg-6">
					<img src="<?php the_sub_field('img_right'); ?>"/>
				</div>
				
			</div>	
			
		</section>
		
		
			<?php endwhile; ?>
		<?php endif; ?>			

	</div>
</main>
  
<?php get_sidebar('conc-area'); ?>
<?php get_footer(); ?>
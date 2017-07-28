<?php get_header(); ?>

<script>
/*
$(document).ready ( 

$('#toggle').toggle( 
    function() {
        $('#popout').animate({ left: 0 }, 'slow', function() {
            $('#toggle').html('<img src="http://purity-fashion.com/wp-content/themes/blankslate/img/men.png" alt="open" align="left" />МЕНЮ');
            $('#toggle').animate({ left: 260 }, 'fast');
        });
}));
*/
</script>

<section class="slider">
<div class="page_container">
<?php masterslider(1); ?>
</div></section>


<div id="site-description"><h1>КТО МЫ</h1><?php bloginfo( 'description' ); ?></div>



<section class="mainwhomob scrollme">
<?php query_posts('page_id=167'); if ( have_posts() ) : while ( have_posts() ) : the_post();?> 

<div class="sidepad"><h2><?php the_title(); ?></h2>   
<?php the_content(); ?> 
</div>


<div class="pimg" >

<span></span><?php if ( has_post_thumbnail() ) { the_post_thumbnail('full'); } ?></div>

<div class="plinks"><a class="dot" href="http://purity-fashion.com/komanda">КОМАНДА</a><a class="dot" href="http://purity-fashion.com/history">ИСТОРИЯ</a></div>
<?php endwhile; endif; wp_reset_query(); ?>    
</section>


<section class="mainwho scrollme">
<?php query_posts('page_id=167'); if ( have_posts() ) : while ( have_posts() ) : the_post();?> 
	<div class="pimg" >
		<img src="<?php echo get_bloginfo('template_directory')?>/img/figm.png" alt="logo">
	</div>
<div class="sidepad animateme" data-when="span" data-from="1" data-to="0" data-opacity="1" data-translatex="500" style="opacity: 1; transform: translate3d(81px, 0px, 0px) rotateX(0deg) rotateY(0deg) rotateZ(0deg) scale3d(1, 1, 1);"><h2><?php the_title(); ?></h2>   
<?php the_content(); ?> 
</div>

<div class="image-section">
	<div class="pimg animateme" data-when="span" data-from="0.65" data-to="0.1" data-translatex="0" data-translatey="-220" >
		<span></span>
		<?php if ( has_post_thumbnail() ) { the_post_thumbnail('full'); } ?>
	</div>

	<div class="plinks animateme" data-when="view" data-from="1" data-to="0" data-translatex="0" data-opacity="0.5" data-translatey="-1100">
		<a class="dot" href="http://purity-fashion.com/komanda">КОМАНДА</a>
		<a class="dot" href="http://purity-fashion.com/history">ИСТОРИЯ</a>
	</div>
</div>
<?php endwhile; endif; wp_reset_query(); ?>    
</section>

<section class="whowe scrollme animateme" data-when="span" data-from="1" data-to="0" data-opacity="0" data-translatey="-150">

<?php query_posts('page_id=146'); if ( have_posts() ) : while ( have_posts() ) : the_post();?>
<div class="pimg"><span></span><?php if ( has_post_thumbnail() ) { the_post_thumbnail('large'); } ?></div>
<div class="pc"><h2><?php the_title(); ?></h2>   
<?php the_content(); ?></div>  <?php endwhile; endif; wp_reset_query(); ?>    
</section>


<section class="squares scrollme animateme" data-when="span" data-from="0.55" data-to="0" data-opacity="0" data-translatex="0" data-translatey="-150"> 

	
	<ul class="sq" id="back-top">
		<li class="style">
<a href="http://purity-fashion.com/stylist/">Персональный стилист</a>
		<video loop autoplay class="vid" poster="http://purity-fashion.com/wp-content/themes/blankslate/img/picone.png">
		<source src="http://purity-fashion.com/wp-content/themes/blankslate/img/vtwo.mp4" type="video/mp4">
		<source src="http://purity-fashion.com/wp-content/themes/blankslate/img/vtwo.webm" type="video/webm">
		</video>
		</li>
		<li class="shop"><a href="http://purity-fashion.com/personalnyj-shoping/">Шоппинг сервис</a>
								<video loop autoplay class="vid" poster="http://purity-fashion.com/wp-content/themes/blankslate/img/pictwo.png">
		<source src="http://purity-fashion.com/wp-content/themes/blankslate/img/vfour.mp4" type="video/mp4">
		<source src="http://purity-fashion.com/wp-content/themes/blankslate/img/vfour.webm" type="video/webm">

		
		</li>
		<li class="atelje"><a href="http://purity-fashion.com/atele-masterskaya/">Мастерская-ателье</a>
						<video loop autoplay class="vid" poster="http://purity-fashion.com/wp-content/themes/blankslate/img/picthree.png">
		<source src="http://purity-fashion.com/wp-content/themes/blankslate/img/vtree.mp4" type="video/mp4">
		<source src="http://purity-fashion.com/wp-content/themes/blankslate/img/vtree.webm" type="video/webm">

		</li>
		<li class="garderob"><a href="http://purity-fashion.com/garderob/">Ревизия гардероба</a>
				<video loop autoplay class="vid" poster="http://purity-fashion.com/wp-content/themes/blankslate/img/picfour.png">
		<source src="http://purity-fashion.com/wp-content/themes/blankslate/img/vone.mp4" type="video/mp4">
		<source src="http://purity-fashion.com/wp-content/themes/blankslate/img/vone.webm" type="video/webm">

		</li>
	</ul>
</section>

<section class="about scrollme">
	<?php query_posts('page_id=183'); if ( have_posts() ) : while ( have_posts() ) : the_post();?> 
<div class="ableft animateme" data-when="exit" data-from="0.2" data-to="0" data-opacity="0" style="opacity: 1; transform: translate3d(0px, 0px, 0px) rotateX(0deg) rotateY(0deg) rotateZ(0deg) scale3d(1, 1, 1)"><h2><?php the_title(); ?></h2>   
<?php the_content(); ?>  </div>
<div class="abright animateme" data-when="enter" data-from="0.65" data-to="0.1" data-translatex="600" data-translatey="0"><span></span><?php if ( has_post_thumbnail() ) { the_post_thumbnail('large'); } ?></div>

<?php endwhile; endif; wp_reset_query(); ?>    


</section>

<section class="lookbook">
	<h2>От слов к делу</h2><br />
	<ul class="sq" id="back-top">
		<li class="portf"><a href="https://www.instagram.com/purity_fashion_studio/">Портфолио</a>
		</li>
		<li class="oshop"><a href="http://purity-fashion.com/shop/">On-line магазин</a>
		</li>

	</ul></section>
</div>


<?php get_sidebar(); ?>
<?php get_footer(); ?>
<?php
/*
Template Name: Персональный стилист и тд
*/
?>
<?php get_header(); ?>
<section id="content" role="main" class="style">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<div class="pageimg"><?php if ( has_post_thumbnail() ) { the_post_thumbnail(''); } ?></div>
<div class="pad">
<h1 class="entry-title"><?php the_title(); ?></h1> <?php edit_post_link(); ?><div style="clear: both"></div>
	<div class="pagecont"><?php the_content(); ?></div>


<section class="entry-content">

<div class="crow scrollme" style="margin: 0 0 120px 0;">
<div style="display: inline-block;" class="conceptimg animateme" data-when="view" data-from="0.7" data-to="0" data-opacity="0" data-translatex="0" data-translatey="250">
	<img src="<?php the_field('img_1'); ?>" />
</div>

<div class="conceptinfo animateme"  data-when="view" data-from="0.8" data-to="0" data-opacity="0" data-translatex="0" data-translatey="500">
			<h2><?php the_field('t-1'); ?></h2>
			<span><?php the_field('tt-1'); ?></span>
			
</div>
<span class="pric"><?php the_field('pt-1'); ?></span>
</div>


<div class="crow scrollme"  style="margin: 120px 0 120px 0;">
<div class="conceptinfo animateme" data-when="view" data-from="1" data-to="0" data-opacity="0" data-translatex="0" data-translatey="200">
	<h2><?php the_field('t-2'); ?></h2>
	<span><?php the_field('tt-2'); ?></span>
</div>
<div class="conceptimg animateme" data-when="view" data-from="0.7" data-to="0" data-opacity="0" data-translatex="0" data-translatey="450">
	<img src="<?php the_field('img_2'); ?>" />
</div>
		<span class="pric"><?php the_field('pt-2'); ?></span>
</div>
<div class="crow scrollme"  style="margin: 120px 0 120px 0;">
	<div class="conceptimg animateme" data-when="view" data-from="0.7" data-to="0" data-opacity="0" data-translatex="0" data-translatey="250"><img src="<?php the_field('img_3'); ?>" /></div>
	<div class="conceptinfo animateme" data-from="1" data-to="0" data-opacity="0" data-translatex="0" data-translatey="600"><h2><?php the_field('t-3'); ?></h2>
			<span><?php the_field('tt-3'); ?></span></div><span class="pric"><?php the_field('pt-3'); ?></span>
</div>
<div class="crow scrollme"  style="margin: 120px 0 120px 0;">
	<div class="conceptinfo animateme" data-from="1" data-to="0" data-opacity="0" data-translatex="0" data-translatey="700"><h2><?php the_field('t-4'); ?></h2>
			<span><?php the_field('tt-4'); ?></span>
	</div>
	<div class="conceptimg animateme" data-when="view" data-from="0.7" data-to="0" data-opacity="0" data-translatex="0" data-translatey="250"><img src="<?php the_field('img_4'); ?>" /></div>
	
	<!--span class="ots" style="margin-bottom: 20px;">2. МЫ подбираем все нужные материалы, привозим нужную колодку (используем только итальянские колодки), готовим макет, привозим фурнитуру. Вы согласовываете. На примерке макета также можно прорисовать в прямом смысле слова самые удачные линии кроя и вывести форму колодки практически в точности повторяющую Вашу стопу, что обеспечит абсолютное удобство и комфорт.</span>
	<br><br>
	<span class="ots" style="margin-bottom: 20px;">3. Последний этап - это примерка в коже или материале, чтобы досогласовать окончательные нюансы перед сдачей заказа. В результате вы получаете авторскую вещь, продуманную и подогнанную под Ваши потребности и стиль.</span-->
			
	
	<span class="pric"><?php the_field('pt-4'); ?></span>

</div>
<div class="crowbot scrollme"  style="margin: 120px 0 120px 0;">
	<div class="conceptimg animateme" data-when="view" data-from="0.7" data-to="0" data-opacity="0" data-translatex="0" data-translatey="250"><img src="<?php the_field('img_5'); ?>" /></div>
	<div class="conceptinfo animateme" data-from="1" data-to="0" data-opacity="0" data-translatex="0" data-translatey="900">	<h2><?php the_field('t-5'); ?></h2>
			<span><?php the_field('tt-5'); ?></span></div><span class="pric"><?php the_field('pt-5'); ?></span>
</div>
<div class="crow scrollme"  style="margin: 120px 0 120px 0;">
	<div class="conceptinfo animateme" data-from="1" data-to="0" data-opacity="0" data-translatex="0" data-translatey="700">	<h2><?php the_field('t-6'); ?></h2>
			<span><?php the_field('tt-6'); ?></span></div>
	<div class="conceptimg animateme" data-when="view" data-from="0.7" data-to="0" data-opacity="0" data-translatex="0" data-translatey="250"><img src="<?php the_field('img_6'); ?>" /></div><span class="pric"><?php the_field('pt-6'); ?></span>
</div>
<div class="crowbot scrollme"  style="margin: 120px 0 120px 0;">
	<div class="conceptimg animateme" data-when="view" data-from="0.7" data-to="0" data-opacity="0" data-translatex="0" data-translatey="250"><img src="<?php the_field('img_7'); ?>" /></div>
	<div class="conceptinfo animateme" data-from="1" data-to="0" data-opacity="0" data-translatex="0" data-translatey="900">	<h2><?php the_field('t-7'); ?></h2>
			<span><?php the_field('tt-7'); ?></span></div><span class="pric"><?php the_field('pt-7'); ?></span>
</div>
<div class="crow scrollme"   style="margin: 120px 0 120px 0;">
	<div class="conceptinfo animateme" data-from="1" data-to="0" data-opacity="0" data-translatex="0" data-translatey="700">	<h2><?php the_field('t-8'); ?></h2>
			<span><?php the_field('tt-8'); ?></span></div>
	<div class="conceptimg animateme" data-when="view" data-from="0.7" data-to="0" data-opacity="0" data-translatex="0" data-translatey="250"><img src="<?php the_field('img_8'); ?>" /></div><span class="pric"><?php the_field('pt-8'); ?></span>
</div>
<?php 	$tt_9 = get_field('tt-9'); 
		$pt_9 = get_field('pt-9'); 
		if($tt_9 && $pt_9):
?>
<div class="crowbot scrollme">
	<div class="conceptimg animateme" data-when="view" data-from="0.7" data-to="0" data-opacity="0" data-translatex="0" data-translatey="250"><img src="<?php the_field('img_9'); ?>" /></div>
	<div class="conceptinfo animateme" data-from="1" data-to="0" data-opacity="0" data-translatex="0" data-translatey="900">	<h2><?php the_field('t-9'); ?></h2>
			<span><?php the_field('tt-9'); ?></span></div><span class="pric"><?php the_field('pt-9'); ?></span>
</div>
<?php endif; ?>
<?php 	$tt_10 = get_field('tt-10'); 
		$pt_10 = get_field('pt-10'); 
		if($tt_10 && $pt_10):
?>
<div class="crow scrollme">
	<div class="conceptinfo animateme" data-from="1" data-to="0" data-opacity="0" data-translatex="0" data-translatey="700">	<h2><?php the_field('t-10'); ?></h2>
			<span><?php the_field('tt-10'); ?></span></div>
	<div class="conceptimg animateme" data-when="view" data-from="0.7" data-to="0" data-opacity="0" data-translatex="0" data-translatey="250"><img src="<?php the_field('img_10'); ?>" /></div><span class="pric"><?php the_field('pt-10'); ?></span>
</div>
<?php endif; ?>
<?php 	$tt_11 = get_field('tt-11'); 
		$pt_11 = get_field('pt-11'); 
		if($tt_11 && $pt_11):
?>
<div class="crowbot scrollme" >
	<div class="conceptimg animateme" data-when="view" data-from="0.7" data-to="0" data-opacity="0" data-translatex="0" data-translatey="250"><img src="<?php the_field('img_11'); ?>" /></div>
	<div class="conceptinfo animateme" data-from="1" data-to="0" data-opacity="0" data-translatex="0" data-translatey="900">	<h2><?php the_field('t-11'); ?></h2>
			<span><?php the_field('tt-11'); ?></span></div><span class="pric"><?php the_field('pt-11'); ?></span>
</div>
<?php endif; ?>



</section>

</div>

</article>

<?php endwhile; endif; ?>
</section>
<?php get_sidebar('conc-area'); ?>
<?php get_footer(); ?>
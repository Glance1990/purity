<section class="entry-content">
<div class="portimg"><?php if ( has_post_thumbnail() ) { the_post_thumbnail('bportf'); } ?><br />
<img src="<?php the_field('dopimg1'); ?>" class="di" /><img src="<?php the_field('dopimg2'); ?>" class="di" />
</div>
<div class="portcont"><?php the_content(); ?><div class="designerinfo">Дизайнер: <?php the_field('designer'); ?></div></div>

<div class="entry-links"><?php wp_link_pages(); ?></div>
</section>
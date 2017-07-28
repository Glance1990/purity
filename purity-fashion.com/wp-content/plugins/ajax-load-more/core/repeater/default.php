<?php
$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'portf' );
$urli = $thumb['0'];
?>
<li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">

<div id="th">
<h3><?php the_title(); ?></h3>
<div style="background:url(<?=$urli?>) center center no-repeat;">
</div>
</div>
</a>
</li>
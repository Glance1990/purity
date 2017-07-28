<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<meta name="format-detection" content="telephone=no">
<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri(); ?>" />
<link rel="stylesheet" type="text/css" href="http://purity-fashion.com/wp-content/themes/blankslate/key2017.css" />  

<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500&subset=latin,cyrillic' rel='stylesheet' type='text/css'></script>





<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-76441820-1', 'auto');
  ga('send', 'pageview');

</script>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="wrapper" class="hfeed wrapper">

<header id="header" role="banner">

<nav id="topnav" role="navigation">
	<a class="toplogo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<img src="<?php echo get_bloginfo('template_directory')?>/img/logomain.png" alt="logo">
	</a>
	<div id="togm">
		
		<?php if( is_front_page() ){ ?>
		<div id="popout">

	<?php } else { ?>
		 <div id="popout">
	<?php } ?>
	<div class="close-menu">
		<span></span>
		<span></span>
	</div>
	<img src="<?php echo get_bloginfo('template_directory')?>/img/figm.png" alt="logo">
	<?php wp_nav_menu( array( 'theme_location' => 'main-menu', 'menu_class' => 'nav-menu' ) ); ?>
	<?php wp_nav_menu( array( 'theme_location' => 'sub-menu', 'menu_class' => 'sub-menu' ) ); ?>
	</div>

		

	</div>
	<?php if( is_front_page() ){ ?>
		<div id="toggle" >
			<?php } else { ?>
		 <div id="toggle">
	<?php } ?>
		</div>
</nav>

<span class="phone">
	<span class="phone-number"> +38 066 00 44 066</span>
	<br />
	<div class="social-links">
		<?php 
			if(is_product() || is_realy_woocommerce_page() || is_page_template('magazin.php')):
				if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ):

				$count = WC()->cart->cart_contents_count;
				?><a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php 
				if ( $count > 0 ) {
					?>
					<span class="cart-contents-count"><?php echo esc_html( $count ); ?></span>
					<?php
				}
				?></a>
		 
			<?php endif; ?>
		<?php endif; ?>
		<a class="fb" href="https://www.facebook.com/PURITY-Fashion-Studio-370149113069285/?fref=ts"></a>
		<a class="insta" href="https://www.instagram.com/purity_fashion_studio/"></a>
		<a class="ytube" href="https://www.youtube.com/channel/UCVTLImOTCrlad07TufNaJYw"></a>
		<a class="pint" href="https://www.pinterest.com/purityfashionst/"></a>
	</div>
</span>
<div class="mobail-cart">
		<?php 
			if(is_product() || is_realy_woocommerce_page() || is_page_template('magazin.php')):
				if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ):

				$count = WC()->cart->cart_contents_count;
				?><a id="mobail-cart" class="mobail-cart cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php 
				if ( $count > 0 ) {
					?>
					<span class="cart-contents-count"><?php echo esc_html( $count ); ?></span>
					<?php
				}
				?></a>
		 
			<?php endif; ?>
		<?php endif; ?>
	</div>


</header>

<div id="container">
<?php if(is_product()){
		
		//woocommerce_breadcrumb();
}
?>
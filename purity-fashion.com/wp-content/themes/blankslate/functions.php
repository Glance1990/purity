<?php
/*
*
*	Send sms for customer after new order
*
*/
	add_action( 'woocommerce_new_order', 'sendSmsForClient', 10, 1 );

	function sendSmsForClient($order_id = '')
	{	
		$order_id = (int) $order_id;
		if ($order_id > 0)
		{

			$order = new WC_Order( $order_id );
			if (!empty($order) && isset($_POST['billing_phone']) && !empty($_POST['billing_phone']))
			{
				$phone = $_POST['billing_phone'];
				$str = 'Вы сделали заказ в Purity Fashion Shop - номер вашего заказа '.$order_id.'. Спасибо!';
				sendSms($phone, $str);
			}
		}
	}


	function sendSms($phone = '', $str = '')
	{
		if (!empty($phone) && !empty($str))
		{
			try {   
				if (strlen($phone) < 13)
				{
					$old_phone = $phone;
					$pos = strpos($phone, '+');
					if ($pos === false)
						$phone = '+'.$phone;

					$pos = strpos($phone, '+3');
					if ($pos === false)
						$phone = '+3'.$old_phone;

					$pos = strpos($phone, '+38');
					if ($pos === false)
						$phone = '+38'.$old_phone;
				}

			    $client = new SoapClient('http://turbosms.in.ua/api/wsdl.html');   
			    $auth = ['login' => 'PurityFashion', 'password' => '1234567890qwerty'];
			    $result = $client->Auth($auth);
			    $encoding_from = mb_detect_encoding($str);
			    $text = iconv($encoding_from, 'utf-8', $str);
			    $sms = [   
			        'sender' => 'Msg',   
			        'destination' => $phone,   
			        'text' => $text   
			    ];  
			    $result = $client->SendSMS($sms); ; 
				
			} catch(Exception $e) {  
			    echo 'Ошибка: ' . $e->getMessage() . PHP_EOL;  
			}  
		}
	}

/*
* end send SMS
*/





add_image_size( 'nav-product', 60, 90, true );

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
//remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
//add_action('woocommerce_single_product_summary', 'woocommerce_show_product_images', 3);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 28 );
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
//remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
//add_action ('woocommerce_single_product_summary' ,'woocommerce_show_product_thumbnails', 3);
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
   add_action( 'woocommerce_after_main_content', 'woocommerce_taxonomy_archive_description', 100 );

   add_action( 'woocommerce_after_shop_loop', 'woocommerce_taxonomy_archive_description', 100 );
   

add_filter ( 'woocommerce_product_thumbnails_columns', 'xx_thumb_cols' );
 function xx_thumb_cols() {
     return 5; // .last class applied to every 4th thumbnail
 }
 
 add_filter( 'woocommerce_get_order_item_totals', 'adjust_woocommerce_get_order_item_totals' );



function adjust_woocommerce_get_order_item_totals( $totals ) {
  unset($totals['cart_subtotal']  );
  return $totals;
}
add_filter( 'woocommerce_get_order_item_totals', 'custom_woocommerce_get_order_item_totals' );		
function custom_woocommerce_get_order_item_totals( $totals ) {	
		  unset( $totals['payment_method'] );		 
		   return $totals;		
		   }

add_filter('woocommerce_thankyou_order_received_text', 'woo_my_thankyou_order_received_text' );
function woo_my_thankyou_order_received_text() {
return "Спасибо за покупку!<br />Ожидайте звонка нашего менеджера";
}



add_filter( 'woocommerce_currencies', 'add_my_currency' );

function add_my_currency( $currencies ) {

     $currencies['UAH'] = __( 'Українська гривня', 'woocommerce' );

     return $currencies;

}

add_filter('woocommerce_currency_symbol', 'add_my_currency_symbol', 10, 2);

function add_my_currency_symbol( $currency_symbol, $currency ) {

     switch( $currency ) {

         case 'UAH': $currency_symbol = 'грн'; break;

     }

     return $currency_symbol;

}

add_filter( 'woocommerce_breadcrumb_defaults', 'jk_change_breadcrumb_home_text' );
function jk_change_breadcrumb_home_text( $defaults ) {
    // Change the breadcrumb home text from 'Home' to 'Apartment'
	$defaults['home'] = 'Online Shop';
	return $defaults;
}

add_filter( 'woocommerce_breadcrumb_home_url', 'woo_custom_breadrumb_home_url' );

function woo_custom_breadrumb_home_url() {
    return get_home_url( null, 'shop/', 'http' );
}
add_filter( 'woocommerce_breadcrumb_defaults', 'jk_woocommerce_breadcrumbs' );
function jk_woocommerce_breadcrumbs() {
    return array(
            'delimiter'   => '<span class="breadcrumb-delimiter">&#47;</span> ',
            'wrap_before' => '<nav class="woocommerce-breadcrumb" itemprop="breadcrumb">',
            'wrap_after'  => '</nav>',
            'before'      => '<span class="breadcrumb-name">',
            'after'       => '</span>',
            'home'        => _x( 'Online Shop', 'breadcrumb', 'woocommerce' ),
        );
}

function woocommerce_template_product_description() {
woocommerce_get_template( 'single-product/tabs/description.php' );
}
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_product_description', 7 );
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10); 
add_action( 'woocommerce_shop_loop_item_title', 'cs_woocommerce_template_loop_product_title', 10); 

function cs_woocommerce_template_loop_product_title(){
	$title = get_the_title();
	$len = strlen($title);
	if($len > 80){
		$string = strip_tags($title);
		$string = substr($string, 0, 80);
		//$string = mb_substr($string,0, 50,'UTF-8');
		mb_internal_encoding('UTF-8');
		$string = mb_substr($title, 0, 80, 'UTF-8');
		//$string = rtrim($string, "!,.-");
		$string = substr($string, 0, strrpos($string, ' '));
	//	echo '<h3>'.$title.'...</h3>';
	}else{
	//	echo '<h3>'.$title.'</h3>';
	}
	echo '<h3>'.$title.'</h3>';
	
}
add_action( 'woocommerce_before_shop_loop_item', 'product_link_open', 10 );
function product_link_open() {
    echo '<a href="' . get_the_permalink() . '" class="product-link">';
}

add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_shop_loop_item_title_div', 1 );
function woocommerce_shop_loop_item_title_div(){
	echo '<div class="info-box">';
}

add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_after_shop_loop_item_title_div', 15 );
function woocommerce_after_shop_loop_item_title_div(){
	echo '</div>';
}
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_after_shop_loop_item_title_btn', 20 );
function woocommerce_after_shop_loop_item_title_btn(){
	echo do_shortcode('[viewBuyButton]');
}
add_action('woocommerce_after_add_to_cart_button', 'woocommerce_after_add_to_cart');
function woocommerce_after_add_to_cart(){
	echo do_shortcode('[viewBuyButton]');
}
add_action('woocommerce_after_add_to_cart_button', 'woocommerce_after_add_to_cart_social', 20);
function woocommerce_after_add_to_cart_social(){
	echo do_shortcode('[easy-social-share]');
}
add_filter( 'woocommerce_return_to_shop_redirect', 'custom_woocommerce_return_to_shop_redirect' ,20 );
function custom_woocommerce_return_to_shop_redirect(){
  return site_url()."/shop/";
}
add_action('woocommerce_before_single_product_summary', 'add_title', 1);
function add_title(){
	echo '<h1 class="mobail-title-product">'.get_the_title().'</h1>';
}
add_action('wc-proceed-to-checkout', 'add_rand_products');
function add_rand_products(){

	echo '<div class="rand-product-4 ">'.do_shortcode('[recent_products per_page="4" columns="4" orderby="rand" order="rand"]').'</div>';
}
function my_theme_wrapper_start() {
  echo '<section id="content">';
}

function my_theme_wrapper_end() {
  echo '</section>';
}
function mw_do_sequential_post_nav() {
		if ( is_singular() ) { 
	
	$next_url_post = get_permalink(get_adjacent_post(false,'',false));
	$prev_url_post =  get_permalink(get_adjacent_post(false,'',true));
	
	$next_post_id = url_to_postid($next_url_post);
	$prev_post_id = url_to_postid($prev_url_post);
	
	$next_post_img = get_the_post_thumbnail($next_post_id, 'nav-product');
	$prev_post_img = get_the_post_thumbnail($prev_post_id, 'nav-product');
	?>
	<nav class="sequentialPostNav">
		<span>Товары рядом в каталоге</span>
		<a href="<?php echo $next_url_post; ?>"><span class="nav-next alignleft"><?php echo $next_post_img; ?></span></a>
		<a href="<?php echo $prev_url_post; ?>"><span class="nav-previous alignright"><?php echo $prev_post_img; ?></span></a>
		
	</nav>
	<?php
	}
	}
add_action('woocommerce_after_add_to_cart_button', 'mw_do_sequential_post_nav', 30 );
add_action('woocommerce_after_add_to_cart_button', 'text_after_add_to_cart_button', 25 );
function text_after_add_to_cart_button(){
	echo '<div class="sub-desck-product">Вещи, представленные в шоу руме PURITY являются авторскими и изготавливаются в единственном экземпляре.Но если вы не нашли нужного Вам цвета или размера в выбранной модели, Вы можете заказать похожую вещь в нашем ателье, и наша команда сделает ее по индивидуальным меркам с учетом пожеланий по цвету, крою или других требований. Если размер, выбранной вещи больше нужного, мы ушьем или доподгоним ее под Вашу фигуру. Возможен выезд в удобное для Вас место (по Киеву)</div>';
}

add_action( 'woocommerce_after_add_to_cart_button', 'add_content_after_addtocart_button_func' );

function add_content_after_addtocart_button_func() {
	
}

function woocommerce_output_related_products() {
woocommerce_related_products(4,4); // Показать 3 товара а 2 колонки
}

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_upsells', 15 );
function woocommerce_output_upsells() {
	woocommerce_upsell_display( 4 ); // Display 3 products in rows of 3
}

add_filter('loop_shop_columns', 'loop_columns');
if (!function_exists('loop_columns')) {
	function loop_columns() {
		return 3; // 3 products per row
	}
}

add_filter( 'woocommerce_show_page_title', '__return_false' );

add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}

add_action( 'after_setup_theme', 'blankslate_setup' );
function blankslate_setup()
{
load_theme_textdomain( 'blankslate', get_template_directory() . '/languages' );
add_theme_support( 'title-tag' );
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'post-thumbnails' );
add_image_size( 'catth', 350 ); 
add_image_size( 'portf', 280, 190, true ); 
add_image_size( 'bportf', 600 ); 


global $content_width;
if ( ! isset( $content_width ) ) $content_width = 640;
register_nav_menus(
array( 'main-menu' => __( 'Main Menu', 'blankslate' ) )
);
register_nav_menus(
array( 'sub-menu' => __( 'Dop Menu', 'blankslate' ) )
);
register_nav_menus(
array( 'm-menu' => __( 'M Menu', 'blankslate' ) )
);
}

add_action( 'wp_enqueue_scripts', 'blankslate_load_scripts' );
function blankslate_load_scripts(){
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'bootstrap-modalmanager', get_template_directory_uri() . '/js/bootstrap-modalmanager.js', array( 'jquery' ), '20161227', true );
	wp_enqueue_script( 'modal', get_template_directory_uri() . '/js/modal.js', array( 'jquery' ), '20161227', true );
	wp_enqueue_script( 'jquery.sticky', get_template_directory_uri() . '/js/jquery.sticky.js', array( 'jquery' ), '20161227', true );
	wp_enqueue_script( 'go-up', get_template_directory_uri() . '/js/go-up.js', array('jquery'), '20131010', true );
	wp_enqueue_script( 'wpb_slidepanel', get_template_directory_uri() . '/js/sm.js', array('jquery'), '20131010', true );
	
}
add_action( 'comment_form_before', 'blankslate_enqueue_comment_reply_script' );
function blankslate_enqueue_comment_reply_script()
{
if ( get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); }
}
add_filter( 'the_title', 'blankslate_title' );
function blankslate_title( $title ) {
if ( $title == '' ) {
return '&rarr;';
} else {
return $title;
}
}
add_filter( 'wp_title', 'blankslate_filter_wp_title' );
function blankslate_filter_wp_title( $title )
{
return $title . esc_attr( get_bloginfo( 'name' ) );
}
add_action( 'widgets_init', 'blankslate_widgets_init' );
function blankslate_widgets_init()
{
register_sidebar( array (
'name' => __( 'Sidebar Widget Area', 'blankslate' ),
'id' => 'primary-widget-area',
'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
'after_widget' => "</li>",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array (
'name' => __( 'Концепция Purity', 'blankslate' ),
'id' => 'conc-area',
'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
'after_widget' => "</li>",
) );
register_sidebar( array (
'name' => __( 'Магазин', 'blankslate' ),
'id' => 'shop-area',
'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
'after_widget' => "</li>",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
}
function blankslate_custom_pings( $comment )
{
$GLOBALS['comment'] = $comment;
?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo comment_author_link(); ?></li>

<?php 
}
add_filter( 'get_comments_number', 'blankslate_comments_number' );
function blankslate_comments_number( $count )
{
if ( !is_admin() ) {
global $id;
$comments_by_type = &separate_comments( get_comments( 'status=approve&post_id=' . $id ) );
return count( $comments_by_type['comment'] );
} else {
return $count;
}
}
//
/**
 * Add Cart icon and count to header if WC is active
 */
function my_wc_cart_count() {
 
    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
 
        $count = WC()->cart->cart_contents_count;
        ?><a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php
        if ( $count > 0 ) {
            ?>
            <span class="cart-contents-count"><?php echo esc_html( $count ); ?></span>
            <?php
        }
                ?></a><?php
    }
 
}
add_action( 'your_theme_header_top', 'my_wc_cart_count' );
/**
 * Ensure cart contents update when products are added to the cart via AJAX
 */
function my_header_add_to_cart_fragment( $fragments ) {
 
    ob_start();
    $count = WC()->cart->cart_contents_count;
    ?><a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php
    if ( $count > 0 ) {
        ?>
        <span class="cart-contents-count"><?php echo esc_html( $count ); ?></span>
        <?php            
    }
        ?></a><?php
 
    $fragments['a.cart-contents'] = ob_get_clean();
     
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'my_header_add_to_cart_fragment' );

function is_realy_woocommerce_page () {
        if(  function_exists ( "is_woocommerce" ) && is_woocommerce()){
                return true;
        }
        $woocommerce_keys   =   array ( "woocommerce_shop_page_id" ,
                                        "woocommerce_terms_page_id" ,
                                        "woocommerce_cart_page_id" ,
                                        "woocommerce_checkout_page_id" ,
                                        "woocommerce_pay_page_id" ,
                                        "woocommerce_thanks_page_id" ,
                                        "woocommerce_myaccount_page_id" ,
                                        "woocommerce_edit_address_page_id" ,
                                        "woocommerce_view_order_page_id" ,
                                        "woocommerce_change_password_page_id" ,
                                        "woocommerce_logout_page_id" ,
                                        "woocommerce_lost_password_page_id" ) ;
        foreach ( $woocommerce_keys as $wc_page_id ) {
                if ( get_the_ID () == get_option ( $wc_page_id , 0 ) ) {
                        return true ;
                }
        }
        return false;
}
function kama_pagenavi( $before = '', $after = '', $echo = true, $args = array(), $wp_query = null ) {
	if( ! $wp_query ){
		wp_reset_query();
		global $wp_query;
	}

	// параметры по умолчанию
	$default_args = array(
		'text_num_page'   => '', // Текст перед пагинацией. {current} - текущая; {last} - последняя (пр. 'Страница {current} из {last}' получим: "Страница 4 из 60" )
		'num_pages'       => 10, // сколько ссылок показывать
		'step_link'       => 10, // ссылки с шагом (значение - число, размер шага (пр. 1,2,3...10,20,30). Ставим 0, если такие ссылки не нужны.
		'dotright_text'   => '…', // промежуточный текст "до".
		'dotright_text2'  => '…', // промежуточный текст "после".
		'back_text'       => '« назад', // текст "перейти на предыдущую страницу". Ставим 0, если эта ссылка не нужна.
		'next_text'       => 'вперед »', // текст "перейти на следующую страницу". Ставим 0, если эта ссылка не нужна.
		'first_page_text' => '« к началу', // текст "к первой странице". Ставим 0, если вместо текста нужно показать номер страницы.
		'last_page_text'  => 'в конец »', // текст "к последней странице". Ставим 0, если вместо текста нужно показать номер страницы.
	);

	$default_args = apply_filters('kama_pagenavi_args', $default_args ); // чтобы можно было установить свои значения по умолчанию

	$args = array_merge( $default_args, $args );

	extract( $args );

	$posts_per_page = (int) $wp_query->query_vars['posts_per_page'];
	$paged          = (int) $wp_query->query_vars['paged'];
	$max_page       = $wp_query->max_num_pages;

	//проверка на надобность в навигации
	if( $max_page <= 1 )
		return false; 

	if( empty( $paged ) || $paged == 0 ) 
		$paged = 1;

	$pages_to_show = intval( $num_pages );
	$pages_to_show_minus_1 = $pages_to_show-1;

	$half_page_start = floor( $pages_to_show_minus_1/2 ); //сколько ссылок до текущей страницы
	$half_page_end = ceil( $pages_to_show_minus_1/2 ); //сколько ссылок после текущей страницы

	$start_page = $paged - $half_page_start; //первая страница
	$end_page = $paged + $half_page_end; //последняя страница (условно)

	if( $start_page <= 0 ) 
		$start_page = 1;
	if( ($end_page - $start_page) != $pages_to_show_minus_1 ) 
		$end_page = $start_page + $pages_to_show_minus_1;
	if( $end_page > $max_page ) {
		$start_page = $max_page - $pages_to_show_minus_1;
		$end_page = (int) $max_page;
	}

	if( $start_page <= 0 ) 
		$start_page = 1;

	//выводим навигацию
	$out = '';

	// создаем базу чтобы вызвать get_pagenum_link один раз
	$link_base = str_replace( 99999999, '___', get_pagenum_link( 99999999 ) );
	$first_url = get_pagenum_link( 1 );
	if( false === strpos( $first_url, '?') )
		$first_url = user_trailingslashit( $first_url );

	$out .= $before . "<div class='wp-pagenavi'>\n";

		if( $text_num_page ){
			$text_num_page = preg_replace( '!{current}|{last}!', '%s', $text_num_page );
			$out.= sprintf( "<span class='pages'>$text_num_page</span> ", $paged, $max_page );
		}
		// назад
		if ( $back_text && $paged != 1 ) 
			$out .= '<a class="prev" href="'. ( ($paged-1)==1 ? $first_url : str_replace( '___', ($paged-1), $link_base ) ) .'">'. $back_text .'</a> ';
		// в начало
		if ( $start_page >= 2 && $pages_to_show < $max_page ) {
			$out.= '<a class="first" href="'. $first_url .'">'. ( $first_page_text ? $first_page_text : 1 ) .'</a> ';
			if( $dotright_text && $start_page != 2 ) $out .= '<span class="extend">'. $dotright_text .'</span> ';
		}
		// пагинация
		for( $i = $start_page; $i <= $end_page; $i++ ) {
			if( $i == $paged )
				$out .= '<span class="current">'.$i.'</span> ';
			elseif( $i == 1 )
				$out .= '<a href="'. $first_url .'">1</a> ';
			else
				$out .= '<a href="'. str_replace( '___', $i, $link_base ) .'">'. $i .'</a> ';
		}

		//ссылки с шагом
		$dd = 0;
		if ( $step_link && $end_page < $max_page ){
			for( $i = $end_page+1; $i<=$max_page; $i++ ) {
				if( $i % $step_link == 0 && $i !== $num_pages ) {
					if ( ++$dd == 1 ) 
						$out.= '<span class="extend">'. $dotright_text2 .'</span> ';
					$out.= '<a href="'. str_replace( '___', $i, $link_base ) .'">'. $i .'</a> ';
				}
			}
		}
		// в конец
		if ( $end_page < $max_page ) {
			if( $dotright_text && $end_page != ($max_page-1) ) 
				$out.= '<span class="extend">'. $dotright_text2 .'</span> ';
			$out.= '<a class="last" href="'. str_replace( '___', $max_page, $link_base ) .'">'. ( $last_page_text ? $last_page_text : $max_page ) .'</a> ';
		}
		// вперед
		if ( $next_text && $paged != $end_page ) 
			$out.= '<a class="next" href="'. str_replace( '___', ($paged+1), $link_base ) .'">'. $next_text .'</a> ';

	$out .= "</div>". $after ."\n";

	$out = apply_filters('kama_pagenavi', $out );

	if( $echo )
		return print $out;

	return $out;
}
add_filter( 'upload_size_limit', 'PBP_increase_upload' );
 function PBP_increase_upload( $bytes )
 {
 return 10048576; // 1 megabyte
 }
 // Edit order items table template defaults
function sww_add_wc_order_email_images( $table, $order ) {
  
	ob_start();
	
	$template = $plain_text ? 'emails/plain/email-order-items.php' : 'emails/email-order-items.php';
	wc_get_template( $template, array(
		'order'                 => $order,
		'items'                 => $order->get_items(),
		'show_download_links'   => $show_download_links,
		'show_sku'              => $true,
		'show_purchase_note'    => $show_purchase_note,
		'show_image'            => true,
		'image_size'            => $image_size
	) );
   
	return ob_get_clean();
}
add_filter( 'woocommerce_email_order_items_table', 'sww_add_wc_order_email_images', 10, 2 );

function product_enquiry_tab_form() {
    global $product;
    //If you want to have product ID also
    $product_id = $product->id;
    $subject    =   "Enquire about ".$product->post->post_title;

    echo "<h3>".$subject."</h3>";
    echo do_shortcode('[contact-form-7 id="2983" title="Заказ"]'); 

    ?>

    <script>
    (function($){
        $(".product_name").val("<?php echo $subject; ?>");
    })(jQuery);
    </script>   
    <?php   
}



    ?>
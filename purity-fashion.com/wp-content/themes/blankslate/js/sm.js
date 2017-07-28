(function($) {
/*
$('#toggle').toggle(
    function() {
        $('#popout').animate({ left: 0 }, 'slow', function() {
           // $('#toggle').html('<img src="http://purity-fashion.com/wp-content/themes/blankslate/img/men.png" alt="open" align="left" />МЕНЮ');
           // $('#toggle').animate({ left: 260 }, 'fast');

        });
		console.log(1);
    },
    function() {
		
        $('#popout').animate({ left: -258 }, 'slow', function() {
            $('#toggle').html('<img src="http://purity-fashion.com/wp-content/themes/blankslate/img/men.png" alt="close" align="left" />МЕНЮ');
          	$('#toggle').animate({ left: 0 }, 'fast');
		
        });
		console.log(2);
    }
);
*/
/*
$('#header').stickMe();
$('#header').on('sticky-begin', function() { 
   $('#header').addClass('sticky');
});
 $('#header').on('top-reached', function() { 
   $('#header').removeClass('sticky');
})



*/
jQuery.goup();
$('.btn-buyoneclick').click(function(){
	var $this = $(this);
	$('#link-product').val('');
	if($this.hasClass('shop')){
		var $link = $this.parent('.product-link').attr('href');
		$('#link-product').val($link);
	}
});
$('.close').click(function(){
	
	
});
$('.close').live('click', 'body', function(){
	//console.log(1);
});
$('#buyoneclick').live('hidden', function () {
	var $link = $('#link-product').val();
	if($link.length != 0 && $('.wpcf7-form').hasClass('sent')){
		window.location.href = $link;
	}
});
jQuery(window).scroll(function() { 
	var scroll = $(this).scrollTop();

	if(scroll >= 120){
		$('#header').addClass('sticky');
	}else{
		$('#header').removeClass('sticky');

	}

});

function showMenu(item, child){
	if(!$(item).hasClass('open')){
		$(item).addClass('open');
		$(child).slideDown();
	}else{
		$(item).removeClass('open');
		$(child).slideUp();
	}
}
$('li.menu-item-has-children').click(function(){
	var item = $(this);
	var child = $(this).find('ul.sub-menu');
	showMenu(item, child);
});
$('.mvt').click(function(){
	var item = $(this);
	var child = $('#menu-menyu-magazina');
	showMenu(item, child);
});
$('#toggle').click(function(){
	$('html').addClass('open-nav');
	$('#popout').animate({ left: 0 }, 'slow', function() {});
	//$('#toggle').addClass('hidden');
});
$('.close-menu').click(function(){
	$('html').removeClass('open-nav');
	$('#popout').animate({ left: -400 }, 'slow', function() {});
	//$('#toggle').removeClass('hidden');
	
});

if(document.body.classList.contains('home')) {
	var click = new Event('click');

	document.getElementById('toggle').dispatchEvent(click);
};
})(jQuery);

(function($) {
$('#toggle').toggle( 
    function() {
        $('#popout').animate({ left: 0 }, 'slow', function() {
            $('#toggle').html('<img src="http://max.sv-ua.com/test/wp-content/themes/blankslate/img/men.png" alt="open" align="left" />МЕНЮ');
            $('#toggle').animate({ left: 260 }, 'fast');

        });
    }, 
    function() {
        $('#popout').animate({ left: -258 }, 'slow', function() {
            $('#toggle').html('<img src="http://max.sv-ua.com/test/wp-content/themes/blankslate/img/men.png" alt="close" align="left" />МЕНЮ');
                        $('#toggle').animate({ left: 0 }, 'fast');

        });
    }
);
})(jQuery);
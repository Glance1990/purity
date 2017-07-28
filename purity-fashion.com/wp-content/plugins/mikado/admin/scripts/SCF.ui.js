SCF = {};
(function() {
    function Commutator() { }

    var klass = Commutator.prototype;
    var self = Commutator;
    SCF.Commutator = Commutator;

    self.init = function() {
        self.bindEvents();
        self.update();
    };

    self.bindEvents = function() {
        jQuery(self.element).mousedown(function() {
            if (jQuery(this).hasClass("off")) {
                jQuery(this).removeClass("off").addClass("on").data("value", "T");
            } else {
                jQuery(this).addClass("off").removeClass("on").data("value", "F");
            }
            jQuery(this).siblings("input").val(jQuery(this).data("value"));
        });
    };

    self.update = function() {
        jQuery(self.element).each(function () {
            var value = jQuery(this).siblings("input").val();

            if(value == "T")
                jQuery(this).removeClass("off").addClass("on").data("value", "T");
            else
                jQuery(this).addClass("off").removeClass("on").data("value", "F");
        });        
    }

    // vars
    self.element = ".commutator";

}());

(function() {
    function Scrollbox() { }

    var klass = Scrollbox.prototype;
    var self = Scrollbox;
    SCF.Scrollbox = Scrollbox;

    self.init = function() {
        self.bindEvents();
    };

    self.bindEvents = function() {
        jQuery(self.element).each(function() {
            // Get a default value for all bars
            var _el = this;
            var scaleInitialWidth = jQuery(_el).find(self.scale).width();
            var scrollboxWidth = jQuery(_el).find(self.hitbox).width();
            var max = jQuery(this).data('max');
            var min = jQuery(this).data('min');
            var value = parseInt(jQuery(_el).siblings("span").text());
            // Slider mechanics
            
            jQuery(_el).find(self.hitbox).slider({
                slide: function(event, ui){
                    var scaleWidth = ui.value;

                    jQuery(this).next(self.scale).css({
                        'width': scaleWidth * scrollboxWidth / max
                    });

                    jQuery(_el).siblings("span").text(ui.value);
                    jQuery(_el).siblings("input").val(ui.value);
                },
                step: jQuery(this).data('step'),
                max: max,
                min: min,
                value: value
            });
            
            jQuery(_el).find(self.scale).css({
                'width': value * scrollboxWidth / max
            });
        });
    };

    // vars
    self.element = ".js-scrollbox";
    self.scale = ".scale";
    self.hitbox = ".hitbox";

}());



jQuery(function() {    
    jQuery('.pickColor').wpColorPicker({
        change: function(event, ui){},
        clear: function() {},
        hide: true,
        palettes: true
    });
    SCF.Commutator.init(); 
    SCF.Scrollbox.init();
});
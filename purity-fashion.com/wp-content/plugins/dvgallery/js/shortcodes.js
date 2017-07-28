// Blog style gallery shortcode button
(function () {
  "use strict";
    tinymce.create('tinymce.plugins.dvgalleries', {
        init : function(ed, url) {
            ed.addButton('dvgalleries', {
                title : 'Add DV-Galleries (Blog Style)',
                icon : 'icon dashicons-exerpt-view',
                onclick : function() {
                     ed.selection.setContent("[dvgalleries max='99' categoryid='' vertical='no']");

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('dvgalleries', tinymce.plugins.dvgalleries);
})();

// Carousel gallery shortcode button
(function () {
  "use strict";
    tinymce.create('tinymce.plugins.dvcarousel', {
        init : function(ed, url) {
            ed.addButton('dvcarousel', {
                title : 'Add DV-Carousel',
                icon : 'icon dashicons-image-flip-horizontal',
                onclick : function() {
                     ed.selection.setContent("[dvcarousel max='99' categoryid='' columns='3' autoplay='false' duration='4']");

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('dvcarousel', tinymce.plugins.dvcarousel);
})();

// Grid style gallery shortcode button
(function () {
  "use strict";
    tinymce.create('tinymce.plugins.dvgrid', {
        init : function(ed, url) {
            ed.addButton('dvgrid', {
                title : 'Add DV-Grid',
                icon : 'icon dashicons-tagcloud',
                onclick : function() {
                     ed.selection.setContent("[dvgrid max='99' categoryid='' itemwidth='300']");

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('dvgrid', tinymce.plugins.dvgrid);
})();

// Grid style gallery with filters shortcode button
(function () {
  "use strict";
    tinymce.create('tinymce.plugins.dvgridfilter', {
        init : function(ed, url) {
            ed.addButton('dvgridfilter', {
                title : 'Add DV-Grid with Filters',
                icon : 'icon dashicons-tag',
                onclick : function() {
                     ed.selection.setContent("[dvgridfilter max='99' itemwidth='300']");

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('dvgridfilter', tinymce.plugins.dvgridfilter);
})();

// Square grid gallery
(function () {
  "use strict";
    tinymce.create('tinymce.plugins.dvsquare', {
        init : function(ed, url) {
            ed.addButton('dvsquare', {
                title : 'Add DV-Square',
                icon : 'icon dashicons-grid-view',
                onclick : function() {
                     ed.selection.setContent("[dvsquare max='99' categoryid='']");

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('dvsquare', tinymce.plugins.dvsquare);
})();
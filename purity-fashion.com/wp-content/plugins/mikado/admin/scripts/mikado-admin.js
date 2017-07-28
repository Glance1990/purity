var TG = function ($) {
	var _loading = null;

	return {
		show_loading: function () {
			_loading = $("<div><p class='loading'></div>").dialog({
                modal: true,
                dialogClass: "noTitle"
            });
		},
		hide_loading: function () {
			if(_loading) {
				_loading.dialog("destroy");
				_loading = null;
			}
		},
		delete_image: function (id) {
			TG.show_loading();
			$.post(ajaxurl, {
                action: 'mikado_delete_image',                
                Mikado: $('#Mikado').val(),
                id: id
            }, function () {
                TG.load_images();
            });
		},
		load_images: function () {
			if(!_loading)
				TG.show_loading();

			$.post(ajaxurl, {
                action: 'mikado_list_images',
                Mikado: $('#Mikado').val(),
                gid: $("#gallery-id").val()
            }, function (html) {
                $("#image-list").empty().append(html).sortable({
                    update: function () {
                        TG.show_loading();
                        var ids = [];
                        $("#image-list .item").each(function () {
                            ids.push($(this).data("id"));
                        });
                        var data = {
                            action: 'mikado_sort_images',
                            Mikado: $('#Mikado').val(),
                            ids: ids.join(',')
                        };
                        $.post(ajaxurl, data, function () {
                            TG.hide_loading();
                        });
                    }
                });

                $("#image-list .remove").click(function (e) {
                    e.preventDefault();
                    e.stopPropagation();

                    var $item = $(this).parents(".item:first");
                    var id = $item.data("id");

                    var data = {
                        action: 'mikado_delete_image',
                        Mikado: $('#Mikado').val(),
                        id: id
                    };

                    TG.show_loading();
                    $.post(ajaxurl, data, function () {
                        $item.remove();
                        TG.hide_loading();                        
                    });
                });

                $("#image-list .checkbox").click(function () {
                    $(this).toggleClass("checked");
                    $(this).parents(".item:first").toggleClass("selected");
                });
                
                TG.hide_loading();
            });
		},
		edit_image: function(form) {
			var data = {};
            form.find("input[type=text], input:checked, textarea, input[type=hidden]").each(function() {
                data[$(this).attr("name")] = $(this).val();
            });
            data.action = 'mikado_save_image';
            data.type = 'edit';
            data.Mikado = $('#Mikado').val();

            TG.show_loading();
            $.ajax({
                url: ajaxurl,
                data: data,
                dataType: "json",
                type: "post",
                error: function(a,b,c) {
                    TG.hide_loading();
                },
                success: function(r) {                        
                    if(r.success) {
                        TG.load_images();
                    } else {
                    	TG.hide_loading();
                    }
                }
            });
		},
		add_image: function () {
			var data = {};
            $("#add_image_form input[type=text], #add_image_form input:checked, #add_image_form textarea, #add_image_form input[type=hidden]").each(function() {
                data[$(this).attr("name")] = $(this).val();
            });
            data.action = 'mikado_save_image';
            data.type = $(this).data("type");
            if(data.img_id == "") {
                var p = $("<div title='Attention'>Select an image to add</div>").dialog({
                    modal: true,
                    buttons: {
                        Close: function () {
                            p.dialog("destroy");
                        }
                    }
                });
                return false;
            }

            TG.show_loading();
            $.ajax({
                url: ajaxurl,
                data: data,
                dataType: "json",
                type: "post",
                error: function(a,b,c) {
                    TG.hide_loading();
                },
                success: function(r) {                        
                    if(r.success) {
                        TG.load_images();
                        $("#add_image_form .img img").remove();
                        $("[name=img_id],[name=img_url],[name=url],[name=image_caption]").val("");
                    }
                }
            });
		},
        update_filters: function() {
            var ff = [];
            $(".filters .f").each(function () {
                var val = $.trim($(this).val());
                if(val.length > 0 && $.inArray(val, ff) < 0) {
                    ff.push(val);
                }
            });
            $(".filters [name=filters]").val(ff.join('|'));
        },
        add_filter: function (value) {            
            var row = $("<p style='display:none'><a href='#' class='button alert del'>x</a> <input class='f' type='text' /></p>");
            if(value)
                row.find(".f").val(value);

            $(".filters .text").append(row);
            row.slideDown();
            row.find(".del").click(function (e) {
                e.preventDefault();
                row.slideUp(function () {
                    $(this).remove();
                });
                TG.update_filters();
            });
        },
        init_gallery: function () {
            var ff = $(".filters [name=filters]").val().split('|');
            
            if(ff.length == 0 || ff[0] == "") {
                TG.add_filter();
            } else {
                for(var i=0; i < ff.length; i++) {
                    if(ff[i].length > 0)
                        TG.add_filter(ff[i]);
                }
            }

        },
        save_gallery: function() {
            var data = {};
            data.action = 'mikado_save_gallery';
            TG.update_filters();
            $("#gallery_form").find("input[type=text], select, input:checked, input[type=hidden], textarea").each(function () {
                data[$(this).attr("name")] = $(this).val();
            });

            if(parseInt(data.gridCellSize) < 2)
                data.gridCellSize = 2;
            
            if(data.galleryName == "") {
                var p = $("<div title='Attention'>Insert a name for the gallery</div>").dialog({
                    modal: true,
                    buttons: {
                        Close: function () {
                            p.dialog("destroy");
                        }
                    }
                });
                return false;
            }

            TG.show_loading();

            $.ajax({
                url: ajaxurl,
                data: data,
                dataType: "json",
                type: "post",
                error: function(a,b,c) {
                    TG.hide_loading();
                },
                success: function (r) {
                    if(data.ftg_gallery_edit)
                        TG.hide_loading();
                    else
                        location.href = "?page=edit-mikado";                     
                }
            });
        },
		bind: function () {			
			$("#add-submit").click(function (e) {
                e.preventDefault();
                TG.add_image();
            });
            $("#add-gallery, #edit-gallery").click(function (e) {
                e.preventDefault();
                TG.save_gallery();
            });
            $(".filters a").click(function (e) {
                e.preventDefault();
                TG.add_filter();
            });
            $("#image-list").on("click", ".item .thumb", function () {
	            $(this).parents(".item").toggleClass("selected");
	            $(this).parents(".item").find(".checkbox").toggleClass("checked");
            });
            $("#image-list").on("click", ".edit", function (e) {
            	e.preventDefault();
                var $item = $(this).parents(".item");
                var panel = $("#image-panel-model").clone().attr("id", "image-panel");
                panel.css({
                    marginTop: $(window).scrollTop() - (246 / 2)
                });

	            $("[name=target]", panel).val($("[name=target]", $item).val());
	            $("[name=link]", panel).val($("[name=link]", $item).val());
                $(".figure", panel).append($("img", $item).clone());
                $(".sizes", panel).append($("select", $item).clone());
                $("textarea", panel).val($("pre", $item).html());
                $(".copy", $item).clone().appendTo(panel);

                var selFilters = $item.find("[name=filters]").val().split('|');
                var filters = $("[name=filters]").val().split('|');
                for(var i=0; i < filters.length; i++) {
                    if($.trim(filters[i]).length > 0) {
                        var ft = $("<div class='checkbox'>" + $.trim(filters[i]) + "</div>");
                        if($.inArray(filters[i], selFilters) > -1)
                            ft.addClass("checked");

                        $(".filters", panel).append(ft);
                    }
                }
                
                $(".filters .checkbox", panel).click(function() {
                    $(this).toggleClass("checked");
                });
                
                $("body").append("<div class='overlay' style='display:none' />");
                $(".overlay").fadeIn();
                panel.appendTo("body").fadeIn();

                var link = $item.find("[name=link]").val();
                
                $("[name=halign]", panel).val($("[name=halign]", $item).val());
                $("[name=valign]", panel).val($("[name=valign]", $item).val());

                $(".buttons a", panel).click(function (e) {
                    e.preventDefault();
                    
                    switch($(this).data("action")) {
                        case "save":
                            var data = {
                                action : 'mikado_save_image',
                                Mikado : $('#Mikado').val()
                            };
                            $("input[type=text], input[type=hidden], input[type=radio]:checked, input[type=checkbox]:checked, textarea, select", panel).each(function () {
                                if($(this).attr("name"))
                                    data[$(this).attr("name")] = $(this).val();
                            });

                            var savFilters = [];
                            $(".filters .checked", panel).each(function(i, o) {
                                savFilters.push($(o).text());
                            });
                            data.filters = savFilters.join("|");

                            $("#image-panel .close").trigger("click");
                            TG.show_loading();
                            $.ajax({
                                url: ajaxurl,
                                data: data,
                                dataType: "json",
                                type: "post",
                                error: function(a,b,c) {
                                	console.log(a,b,c);
                                    TG.hide_loading();
                                },
                                success: function(r) {    
                                	console.log("ok");                                
                                    TG.hide_loading();
                                    TG.load_images();
                                }
                            });                            
                            break;
                        case "cancel":
                            $("#image-panel .close").trigger("click");
                            break;
                    }
                });

                $("#image-panel .close, .overlay").click(function (e) {
                    e.preventDefault();
                    panel.fadeOut(function () {
                        $(this).remove();
                    });
                    $(".overlay").fadeOut(function () {
                        $(this).remove();
                    });
                });
            });
            $("body").on("click", "[name=click_action]", function () {
                if($(this).val() == "url") {
                    $(this).siblings("[name=url]").get(0).disabled = false;
                } else {
                    $(this).siblings("[name=url]").val("").get(0).disabled = true;
                }
            });

            $(".bulk a").click(function (e) {
                e.preventDefault();

                var $bulk = $(".bulk");

                switch($(this).data("action"))
                {
                    case "select":
                        $("#images .item").addClass("selected");
                        $("#images .item .checkbox").addClass("checked");
                        break;
                    case "deselect":
                        $("#images .item").removeClass("selected");
                        $("#images .item .checkbox").removeClass("checked");
                        break;
                    case "toggle":
                        $("#images .item").toggleClass("selected");
                        $("#images .item .checkbox").toggleClass("checked");
                        break;
                    case "filter":
                        var selected = [];
                        $("#images .item.selected").each(function (i, o) {
                            selected.push($(o).data("id"));
                        });
                        if(selected.length == 0) {
                            alert("No images selected");
                        } else {
                            $(".panel", $bulk).hide();
                            $(".panel strong", $bulk).text("Select filters");
                            $(".panel .text", $bulk).text("");
                            
                            var filters = $("[name=filters]").val().split('|');
                            for(var i=0; i < filters.length; i++) {
                                if($.trim(filters[i]).length > 0) {
                                    var ft = $("<div class='checkbox'>" + $.trim(filters[i]) + "</div>");
                                    $(".panel .text", $bulk).append(ft);
                                }
                            }
                            
                            $(".panel .checkbox", $bulk).click(function() {
                                $(this).toggleClass("checked");
                            });

                            $(".cancel", $bulk).unbind("click").click(function (e) {
                                e.preventDefault();
                                $(".panel", $bulk).slideUp();
                            });

                            $(".proceed", $bulk).unbind("click").click(function (e) {
                                e.preventDefault();

                                var filters = [];
                                $(".panel .checked", $bulk).each(function (i, o) {
                                    filters.push($(o).text());
                                });

                                $(".panel", $bulk).slideUp();

                                var data = {
                                    action: 'mikado_assign_filters',
                                    Mikado: $('#Mikado').val(),
                                    filters: filters.join("|"),
                                    id: selected.join(",")
                                };

                                TG.show_loading();
                                $.post(ajaxurl, data, function () {
                                    TG.hide_loading();                        
                                });
                            });

                            $(".panel", $bulk).slideDown();
                        }
                        break;
                    case "remove":
                        var selected = [];
                        $("#images .item.selected").each(function (i, o) {
                            selected.push($(o).data("id"));
                        });
                        if(selected.length == 0) {
                            alert("No images selected");
                        } else {
                            $(".panel", $bulk).hide();
                            $(".panel strong", $bulk).text("Confirm");
                            $(".panel .text", $bulk).text("You selected " + selected.length + " images to remove, proceed ?");

                            $(".cancel", $bulk).unbind("click").click(function (e) {
                                e.preventDefault();
                                $(".panel", $bulk).slideUp();
                            });

                            $(".proceed", $bulk).unbind("click").click(function (e) {
                                e.preventDefault();
                                $(".panel", $bulk).slideUp();

                                var data = {
                                    action: 'mikado_delete_image',
                                    Mikado: $('#Mikado').val(),
                                    id: selected.join(",")
                                };

                                TG.show_loading();
                                $.post(ajaxurl, data, function () {
                                    $("#images .item.selected").remove();
                                    TG.hide_loading();                        
                                });
                            });

                            $(".panel", $bulk).slideDown();
                        }
                        break;
                }
            });

            $(".open-media-panel").on("click", function() {
                tgm_media_frame = wp.media.frames.tgm_media_frame = wp.media({
                    multiple: true,
                    library: {
                        type: 'image'
                    }
                });

                tgm_media_frame.on('select', function() {
                    var selection = tgm_media_frame.state().get('selection');
                    var images = [];                    
                    selection.map( function( attachment ) {
                        attachment = attachment.toJSON();
                        
                        var obj = {                            
                            imageId: attachment.id
                        };
                        
                        if(mikado_wp_caption_field == 'title')
                        	obj.description = attachment.title;
                        if(mikado_wp_caption_field == 'description')
                        	obj.description = attachment.description;
                        if(mikado_wp_caption_field == 'caption')
                        	obj.description = attachment.caption;

                        if(attachment.sizes[TG.defaultImageSize])
                            obj.imagePath = attachment.sizes[TG.defaultImageSize].url
                        else
                            obj.imagePath = attachment.url;

                        if(attachment.sizes.full)
                            obj.altImagePath = attachment.sizes.full.url;

                        images.push(obj);
                    });

                    var data = {
                        action : 'mikado_add_image',
                        enc_images : JSON.stringify(images),
                        galleryId: $("#gallery-id").val(),
                        Mikado : $('#Mikado').val()
                    };

                    TG.show_loading();
                    $.ajax({
                        url: ajaxurl,
                        data: data,
                        dataType: "json",
                        type: "post",
                        error: function(a,b,c) {
                            TG.hide_loading();
                            alert("error adding images");
                        },
                        success: function(r) {                        
                            if(r.success) {
                                TG.hide_loading();
                                TG.load_images();
                            }
                        }
                    });
                });

                tgm_media_frame.open();
            });
		}
	}
}(jQuery);
jQuery(function () {
	TG.bind();

    if(jQuery("#wpbody").height() < jQuery("#wpwrap").height()) {
        jQuery("#wpbody").height(jQuery("#wpwrap").height());
    }
});
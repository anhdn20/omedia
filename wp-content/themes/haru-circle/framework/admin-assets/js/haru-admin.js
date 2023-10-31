/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
 */

(function($){
    "use strict";
    var HaruAdmin = {
        initialize: function() {
            HaruAdmin.meta_box_tab();
            HaruAdmin.process_post_format();
            HaruAdmin.widget_select2_process();
        },
        meta_box_tab: function() {
            if ( typeof meta_box_ids !== 'undefined' ) { // Check if RW metabox active
                var tabBoxes = $(meta_box_ids);
                $('#normal-sortables').append('<div class="haru-meta-tabs-wrap postbox">' +
                                                    '<div class="postbox-header">' +
                                                        '<h2 class="hndle ui-sortable-handle">Page Options</h2>' +
                                                        '<div class="handle-actions hide-if-no-js">' + 
                                                            '<button type="button" class="handlediv" aria-expanded="true">' + 
                                                                '<span class="screen-reader-text">Toggle panel: Page Options</span>' + 
                                                                '<span class="toggle-indicator" aria-hidden="true"></span>' + 
                                                            '</button>' +
                                                        '</div>' +
                                                    '</div>' +
                                                    '<div id="haru-tabbed-meta-boxes"></div>' +
                                                '</div>'
                                            );

                $(tabBoxes).appendTo('#haru-tabbed-meta-boxes');
                $(tabBoxes).hide().removeClass('hide-if-no-js');

                for ( var a = 0, b = tabBoxes.length; a < b; a++ ) {
                    var newClass = 'editor-tab' + a;
                    $(tabBoxes[a]).addClass(newClass);
                }

                var menu_html = '<ul id="haru-meta-box-tabs" class="clearfix">\n';
                var total_hidden = 0;
                for ( var i = 0, n = tabBoxes.length; i < n; i++ ) {
                    var target_id = $(tabBoxes[i]).attr('id');
                    var tab_name = $(tabBoxes[i]).find('.hndle').text();
                    var tab_class = "";

                    if ( $(tabBoxes[i]).hasClass('hide-if-js') ) {
                        total_hidden++;
                    }

                    menu_html = menu_html + '\n<li id="li-'+ target_id + '" class="' + tab_class + '"><a href="#" rel="editor-tab' + i + '">' + tab_name + '</a></li>';
                }
                menu_html = menu_html + '\n</ul>';

                $('#haru-tabbed-meta-boxes').before(menu_html);
                $('#haru-meta-box-tabs a:first').addClass('active');

                $('.editor-tab0').addClass('active').show();

                $('.haru-meta-tabs-wrap').on('click', '.handlediv', function() {
                    var metaBoxWrap = $(this).parents('.postbox');
                    if (metaBoxWrap.hasClass('closed')) {
                        metaBoxWrap.removeClass('closed');
                    } else {
                        metaBoxWrap.addClass('closed');
                    }
                });

                $('#haru-meta-box-tabs li').on('click', 'a', function() {
                    $(tabBoxes).removeClass('active').hide();
                    $('#haru-meta-box-tabs a').removeClass('active');

                    var target = $(this).attr('rel');

                    $(this).addClass('active');
                    $('.' + target).addClass('active').show();

                    return false;
                });
            }
        },
        process_post_format: function () {
            var prefix  = 'haru_';
            var $cbxPostFormats = $( 'input[name=post_format]', '#post-formats-select' );
            var $meta_boxes = $('[id^="'+ prefix +'meta_box_post_format_"]').hide();
            $cbxPostFormats.change(function(){
                $meta_boxes.hide();
                $('#' + prefix +  'meta_box_post_format_' + $( this ).val()).show();
            });

            $cbxPostFormats.filter( ':checked' ).trigger( 'change' );

            $( 'body' ).on( 'change', '.checkbox-toggle input', function() {
                var $this = $( this ),
                    $toggle = $this.closest( '.checkbox-toggle' ),
                    action;
                if ( !$toggle.hasClass( 'reverse' ) )
                    action = $this.is( ':checked' ) ? 'slideDown' : 'slideUp';
                else
                    action = $this.is( ':checked' ) ? 'slideUp' : 'slideDown';

                $toggle.next()[action]();
            } );
            $( '.checkbox-toggle input' ).trigger( 'change' );
        },
        widget_select2: function(event, widget) {
            if ( typeof (widget) == "undefined" ) {
                $('#widgets-right select.widget-select2:not(.select2-ready)').each(function(){
                    HaruAdmin.widget_select2_item(this);
                });
            } else {
                $('select.widget-select2:not(.select2-ready)', widget).each(function(){
                    HaruAdmin.widget_select2_item(this);
                });
            }
        },
        widget_select2_item: function(target){
            $(target).addClass('select2-ready'); // select2-ready 

            var data_value = $(target).attr('data-value');

            var choices = [];

            if ( data_value != '' ) {
                var arr_data_value = data_value.split('||');

                for ( var i = 0; i < arr_data_value.length; i++ ) {
                    var option = $('option[value='+ arr_data_value[i]  + ']', target);
                    choices[i] = { 'id':arr_data_value[i], 'text':option.text()};

                    $('option[value='+ arr_data_value[i]  + ']', target).prop("selected","selected");
                }

            }

            $(target).select2({
                'data': choices
            });

            $(target).on("select2:select", function(e) { // select2-selecting 
                var ids = $('input',$(this).parent()).val();
                if ( ids != "" ) {
                    ids +="||";
                }
                ids += e.params.data.id;
                $('input',$(this).parent()).val(ids);
            }).on("select2:unselect", function(e) { // select2-removed
                var ids = $('input',$(this).parent()).val();
                var arr_ids = ids.split("||");
                var newIds = "";
                for(var i = 0 ; i < arr_ids.length; i++) {
                    if (arr_ids[i] != e.params.data.id){
                        if (newIds != "") {
                            newIds += "||";
                        }
                        newIds += arr_ids[i];
                    }
                }
                $('input',$(this).parent()).val(newIds);
            });
        },
        widget_select2_process: function() {
            $(document).on('widget-added', HaruAdmin.widget_select2);
            $(document).on('widget-updated', HaruAdmin.widget_select2);
            HaruAdmin.widget_select2();
        }
    };

    $(document).ready(function(){
        HaruAdmin.initialize();
    });
    
})(jQuery);
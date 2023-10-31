/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

!function($) {
    $(document).ready(function() {
        "use strict";
        
        var add_sidebar_form = $('#haru-form-add-sidebar');

        if( add_sidebar_form.length > 0 ) {
            var add_sidebar_form_new = add_sidebar_form.clone();

            add_sidebar_form.remove();
            $('#widgets-right').append('<div style="clear:both;"></div>');
            add_sidebar_form = $('#widgets-right').append(add_sidebar_form_new);
            
            $('#haru-add-sidebar').bind('click', function(e) {
                e.preventDefault();
                var sidebar_name = $.trim( $(this).siblings('#sidebar_name').val() );
                if( sidebar_name != '' ) {
                    $(this).attr('disabled', true);
                    var data = {
                        action: 'haru_add_custom_sidebar',
                        sidebar_name: sidebar_name
                    };
                    
                    $.ajax({
                        type : 'POST',
                        url : ajaxurl,
                        data : data,
                        success : function(response) {
                            window.location.reload(true);
                        }
                    });
                }
            });
        }
        
        if( $('.sidebar-haru-custom-sidebar').length > 0 ) {
            var delete_button = '<span class="delete-sidebar fa fa-trash-o"></span>';
            $('.sidebar-haru-custom-sidebar .sidebar-name').prepend(delete_button);
            
            $('.sidebar-haru-custom-sidebar .delete-sidebar').bind('click', function() {
                var sidebar_name = $(this).parent().find('h2').text();
                var widget_block = $(this).parents('.widgets-holder-wrap');
                var ok = confirm('Do you want to delete this sidebar?');
                if( ok ) {
                    widget_block.hide();
                    var data = {
                        action: 'haru_delete_custom_sidebar',
                        sidebar_name: sidebar_name
                    };
                    
                    $.ajax({
                        type : 'POST',
                        url : ajaxurl,
                        data : data,
                        success : function(response) {
                            if( response != '' ) {
                                widget_block.remove();
                            }
                            else {
                                widget_block.show();
                                alert('Cant delete the sidebar. Please try again');
                            }
                        }
                    });
                }
            });
        }
    });
}(jQuery);
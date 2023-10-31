/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

(function($){
    "use strict";
    var AdminFramework = {
        initialize: function() {
            AdminFramework.process_post_format();
            AdminFramework.datetime_picker();
        },
        process_post_format: function () {
            var prefix  = 'haru_portfolio';
            var $cbxPostFormats = $( 'input[name=haru_portfolio_media_type]' );
            var $meta_boxes = $('[id^="'+ prefix +'meta_box_post_format_"]').hide();

            $cbxPostFormats.change(function() {
                $meta_boxes.hide();
                $('#' + prefix +  'meta_box_post_format_' + $( this ).val()).show();
            });

            $cbxPostFormats.filter( ':checked' ).trigger( 'change' );

            $( 'body' ).on( 'change', '.checkbox-toggle input', function()
            {
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
        datetime_picker: function() { // Countdown select time
            if( $('#datetimepicker').length != 0 ) {
                $('#datetimepicker').datetimepicker({
                    format:'Y/m/d H:i',
                    minDate: '0'
                });
            }
        }
    };
    $(document).ready(function() {
        AdminFramework.initialize();
    });
})(jQuery);
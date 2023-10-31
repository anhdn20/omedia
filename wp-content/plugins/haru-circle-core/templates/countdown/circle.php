<?php
/**
 * @package    HaruTheme/Haru Pharmacy
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/
extract( $atts );

$time_id = uniqid();
$diff    = strtotime($datetime) - time();
// Enqueue assets
// Red Countdown
wp_enqueue_script( 'countdown-knob', plugins_url() . '/haru-circle-core/includes/shortcodes/countdown/assets/js/redcountdown/jquery.knob.min.js', false, true );
wp_enqueue_script( 'countdown-debounce', plugins_url() . '/haru-circle-core/includes/shortcodes/countdown/assets/js/redcountdown/jquery.ba-throttle-debounce.min.js', false, true );
wp_enqueue_script( 'countdown-circle', plugins_url() . '/haru-circle-core/includes/shortcodes/countdown/assets/js/redcountdown/jquery.redcountdown.js', false, true );
?>
<div class="countdown-shortcode-wrapper <?php echo esc_attr( $layout_type . ' ' . $el_class); ?>">
	<div id="countdown-content-<?php echo $time_id;?>" class="countdown-content"></div>
</div>
<script type="text/javascript">
    !function($) {
        $(document).ready(function() {
        	$('#countdown-content-<?php echo $time_id;?>').redCountdown({
                end: $.now() + parseInt(<?php echo $diff; ?>),
                labels: true,
               	style: {
                    element: "",
                    textResponsive: .5,
                    daysElement: {
                        gauge: {
                            thickness: .03,
                            bgColor: "rgba(0,0,0,0.05)",
                            fgColor: "#000000"
                        },
                        textCSS: 'font-family:\'Open Sans\'; font-size:25px; font-weight:300; color:#000;'
                    },
                    hoursElement: {
                        gauge: {
                            thickness: .03,
                            bgColor: "rgba(0,0,0,0.05)",
                            fgColor: "#000000"
                        },
                        textCSS: 'font-family:\'Open Sans\'; font-size:25px; font-weight:300; color:#000;'
                    },
                    minutesElement: {
                        gauge: {
                            thickness: .03,
                            bgColor: "rgba(0,0,0,0.05)",
                            fgColor: "#000000"
                        },
                        textCSS: 'font-family:\'Open Sans\'; font-size:25px; font-weight:300; color:#000;'
                    },
                    secondsElement: {
                        gauge: {
                            thickness: .03,
                            bgColor: "rgba(0,0,0,0.05)",
                            fgColor: "#000000"
                        },
                        textCSS: 'font-family:\'Open Sans\'; font-size:25px; font-weight:300; color:#000;'
                    }
                    
                },
                onEndCallback: function() { console.log("Time out!"); }
            });
        });
    }(jQuery);
</script>
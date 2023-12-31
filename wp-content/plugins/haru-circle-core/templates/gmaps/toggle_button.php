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

$mapid = 'haru-gmaps-' . uniqid();
// Enqueue assets
wp_enqueue_script( 'gmaps', 'https://maps.google.com/maps/api/js?key=' . $api_key, false, true );
?>
<div class="gmaps-shortcode-wrap <?php echo esc_attr( $layout_type . ' ' . $el_class); ?>">
    <div class="gmaps-button-wrap">
        <div class="gmaps-toggle-button"></div>
    </div>
    <div class="frame-map">
        <div id="<?php echo esc_attr($mapid);?>" style="height: <?php echo esc_attr($height);?>"></div>
    </div>
</div>
<script type="text/javascript">
    var map;
    var gmap_height   = '<?php echo esc_js( $height );?>';
    var text_hide_map = '<?php echo esc_js( 'HIDE MAP', 'haru-circle'); ?>';
    var text_show_map = '<?php echo esc_js( 'SHOW MAP', 'haru-circle'); ?>';
    var layout_type   = '<?php echo esc_html($layout_type);?>';
    var mapid         = '<?php echo esc_js($mapid);?>';
    var info_window   =     '<div class="map-info">'+
                                '<div class="info-image">'+
                                    '<img src="<?php echo wp_get_attachment_url( $info_image );?>" alt="">'+
                                '</div>'+
                                '<div class="info-address">'+
                                    '<p>'+
                                        '<?php echo esc_js($info_title); ?>'+
                                    '</p>'+
                                '</div>'+
                            '</div>';
    var zoom            = parseInt('<?php echo esc_js($zoom);?>');
    var imageurl        = '<?php echo wp_get_attachment_url( $image );?>';

    function initMap() {
        var latlng = new google.maps.LatLng(<?php echo esc_js($lat." , ".$lng) ?>);
        map = new google.maps.Map(document.getElementById(mapid), {
            center: latlng,
            zoom: zoom,
            scrollwheel: false,
            styles: <?php echo $styles_map[$light_map];?>
        });
        var marker = new google.maps.Marker({
            position: latlng,
            map: map,
            title: '<?php echo esc_js($info_title); ?>',
            icon: imageurl
        });
        var infowindow = new google.maps.InfoWindow({
            content: info_window
        });

        // Set center infowindow
        setTimeout(function() {
            google.maps.event.trigger(marker, 'click')
        }, 2000);

        if ( info_window != '') {
            infowindow.open(map, marker);
            marker.addListener('click', function() {
                infowindow.open(map, marker);
                map.setCenter(marker.getPosition()); // Set center infowindow
            });
        }
        // Responsive
        google.maps.event.addDomListener(window, 'resize', function() {
            center = map.getCenter();
            google.maps.event.trigger(map, "resize");
            map.setCenter(center); 
        });
    }
    if ( layout_type == 'toggle_button' ) {
        jQuery(document).ready(function($) {
            $('.frame-map').css({'height': '0', 'overflow': 'hidden'});
            $('.gmaps-toggle-button').text( text_show_map );

            $('.gmaps-toggle-button').click(function(){
                $('.gmaps-toggle-button').toggleClass('active');

                if ( $('.gmaps-toggle-button').hasClass('active')) {
                    $('.gmaps-toggle-button').text( text_hide_map );
                    $('.frame-map').css({'height': gmap_height, 'transition':'all 0.3s'});
                } else {
                    $('.gmaps-toggle-button').text( text_show_map );
                    $('.frame-map').css({'height': '0', 'overflow': 'hidden', 'transition':'all 0.3s'});
                }
            });
        });
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?callback=initMap"></script>
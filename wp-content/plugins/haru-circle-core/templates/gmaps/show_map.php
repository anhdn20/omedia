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
// Reference: https://snazzymaps.com/
$styles_map = array(
    'basic'         => '[{"featureType":"landscape.natural","elementType":"geometry","stylers":[{"visibility":"simplified"}]}]',
    'light_green'   => '[{"stylers":[{"hue":"#baf4c4"},{"saturation":10}]},{"featureType":"water","stylers":[{"color":"#effefd"}]},{"featureType":"all","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"labels","stylers":[{"visibility":"on"}]},{"featureType":"road","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]}]',
    'shades_grey'   => '[{"featureType":"all","elementType":"geometry","stylers":[{"color":"#282727"}]},{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17}]}]',
    'ultra_light'   => '[{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}]',
);
$light_map_custom = htmlentities( rawurldecode( base64_decode( $light_map_custom ) ), ENT_COMPAT, 'UTF-8' );
// Enqueue assets
wp_enqueue_script( 'gmaps', 'https://maps.google.com/maps/api/js?key=' . $api_key, false, true );
?>
<div class="gmaps-shortcode-wrap <?php echo esc_attr( $layout_type . ' ' . $el_class); ?>">
    <div class="frame-map-show">
        <div id="<?php echo esc_attr($mapid);?>" class="haru-map" 
        data-api="<?php echo $api_key; ?>" 
        data-layout_type="<?php echo esc_attr($layout_type); ?>" 
        data-light_map="<?php echo ($light_map != 'custom') ? esc_attr($styles_map[$light_map]) : $light_map_custom; ?>" 
        data-info_title="<?php echo esc_attr($info_title); ?>" 
        data-info_image="<?php echo esc_url(wp_get_attachment_url( $info_image )); ?>" 
        data-lat="<?php echo esc_attr($lat); ?>" 
        data-lng="<?php echo esc_attr($lng); ?>" 
        data-zoom="<?php echo esc_attr($zoom); ?>" 
        data-image="<?php echo esc_url(wp_get_attachment_url( $image )); ?>"
        data-height="<?php echo esc_attr($height); ?>"
        style="height: <?php echo esc_attr($height); ?>">
            
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function($){
        $('.gmaps-shortcode-wrap .frame-map-show .haru-map').each(function (index, Element) {
            var map;
            var mapid       = $(this).attr('id');
            var api_key     = $(this).data('api');
            var layout_type = $(this).data('layout_type');
            var light_map   = $(this).data('light_map');
            var info_title  = $(this).data('info_title');
            var info_image  = $(this).data('info_image');
            var lat         = $(this).data('lat');
            var lng         = $(this).data('lng');
            var zoom        = $(this).data('zoom');
            var imageurl    = $(this).data('image');
            var height      = $(this).data('height');

            var $this = $(this);

            var latlng = new google.maps.LatLng(lat,lng);
            map = new google.maps.Map(document.getElementById(mapid), {
                center: latlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                zoom: zoom,
                scrollwheel: false,
                styles: light_map
            });

            // Map marker
            var marker = new google.maps.Marker({
                position: latlng,
                map: map,
                // animation:google.maps.Animation.DROP,
                icon: imageurl
            });

            // Infor Window
            var info_window =   '<div class="map-info">'+
                                    '<div class="info-image">'+
                                        '<img src="'+ info_image +'" alt="">'+
                                    '</div>'+
                                    '<div class="info-address">'+
                                        '<p>'+
                                            info_title +
                                        '</p>'+
                                    '</div>'+
                                '</div>';

            var infowindow = new google.maps.InfoWindow({
                content: info_window
            });

            // Set center infowindow and First load height of map
            if ( $(window).width() > 767 ) {
                setTimeout(function() {
                    google.maps.event.trigger(marker, 'click')
                }, 2000);
            } else {
                $this.height('500px');
            }
            
            if ( info_window != '') {
                infowindow.open(map, marker);
                marker.addListener('click', function() {
                    infowindow.open(map, marker);
                    map.setCenter(marker.getPosition()); // Set center infowindow
                });
            }

            // Responsive
            google.maps.event.addDomListener(window, 'resize', function() {
                var center = map.getCenter();
                google.maps.event.trigger(map, "resize");
                if ( $(window).width() < 767 ) {
                    $this.height('500px');
                    map.setCenter(center); 
                } else {
                    $this.height(height);
                    map.setCenter(center); 
                }
            });
        });
    });
</script>
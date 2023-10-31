<?php
/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

if ( ! defined( 'ABSPATH' ) ) die( '-1' );

if ( ! class_exists('Haru_Framework_Shortcode_Gmaps') ) {
    class Haru_Framework_Shortcode_Gmaps {
        function __construct() {
            add_shortcode( 'haru_gmaps', array($this, 'haru_gmaps_shortcode') );
            add_action( 'vc_before_init', array($this, 'haru_gmaps_vc_map') );
        }

        function haru_gmaps_shortcode($atts) {
            $atts = vc_map_get_attributes( 'haru_gmaps', $atts );
            $api_key = $layout_type = $info_title = $info_image = $height = $lat = $lng = $zoom
            = $image = $expand_map = $light_map = $light_map_custom = $el_class = $haru_animation = $css_animation = $duration = $delay = $styles_animation = '';
            extract(shortcode_atts(array(
                'api_key'          => 'AIzaSyBiZjBDjop9d8CDhkFORzUyZAiFcOaHe5M',
                'layout_type'      => 'show_map',
                'info_title'       => 'My address',
                'info_image'       => '',
                'height'           => '400px',
                'lat'              => '40.843292',
                'lng'              => '-73.864512',
                'zoom'             => '14',
                'image'            => '', // Maker
                'expand_map'       => 'false',
                'light_map'        => 'basic',
                'light_map_custom' => '',
                'el_class'         => '',
                'css_animation'    => '',
                'duration'         => '',
                'delay'            => '',
            ), $atts));
               
            $haru_animation   = HARU_CircleCore_Shortcodes::haru_get_css_animation($css_animation);
            $styles_animation = HARU_CircleCore_Shortcodes::haru_get_style_animation($duration, $delay);

            ob_start();

            ?>
            <?php if( ($lat != '') || ($lng != '') ) : ?>
            <div class="<?php echo esc_attr($haru_animation . ' ' . $styles_animation); ?>">
                <?php echo haru_get_template('gmaps/'. $layout_type . '.php', array('atts' => $atts), '', '' ); ?>
            </div>
            <?php else : ?>
                <div class="gmaps-not-select"><?php echo esc_html__( 'Please set GMaps!', 'haru-circle' ); ?></div>
            <?php endif; ?>
        <?php
            $content =  ob_get_clean();
            return $content;         
        }

        function haru_gmaps_vc_map() {
            vc_map(
                array(
                    'name'        => esc_html__( 'Haru Google Maps', 'haru-circle' ),
                    'base'        => 'haru_gmaps',
                    'icon'        => 'fa fa-map-marker haru-vc-icon',
                    'description' => esc_html__( 'Display Google Maps with information', 'haru-circle' ),
                    'category'    => HARU_CIRCLE_CORE_SHORTCODE_CATEGORY,
                    'params'      => array(
                        array(
                            'param_name'  => 'api_key',
                            'type'        => 'textfield',
                            'class'       => '',
                            'heading'     => esc_html__( 'API key', 'haru-circle' ),
                            'value'       => esc_html__( 'AIzaSyBiZjBDjop9d8CDhkFORzUyZAiFcOaHe5M', 'haru-circle' ),
                            'admin_label' => true,
                            'description' => esc_html__( 'Reference: https://developers.google.com/maps/documentation/javascript/get-api-key', 'haru-circle' )
                        ),
                        array(
                            'param_name' => 'layout_type',
                            'type'       => 'dropdown',
                            'class'      => '',
                            'heading'    => esc_html__( 'Choose style layout','haru-circle' ),
                            'value'      => array(
                                esc_html__( 'Show Map', 'haru-circle' )      => 'show_map',
                                // esc_html__( 'Toggle Button', 'haru-circle' ) => 'toggle_button'
                            )
                        ),
                        array(
                            'param_name'  => 'light_map',
                            'type'        => 'dropdown',
                            'class'       => '',
                            'heading'     => esc_html__( 'Choose style map','haru-circle' ),
                            'admin_label' => true,
                            'value'       => array(
                                esc_html__( 'Basic', 'haru-circle' )          => 'basic',
                                esc_html__( 'Light green', 'haru-circle' )    => 'light_green',
                                esc_html__( 'Shades of Grey', 'haru-circle' ) => 'shades_grey',
                                esc_html__( 'Ultra Light', 'haru-circle' )    => 'ultra_light',
                                esc_html__( 'Custom', 'haru-circle' )         => 'custom',
                            )
                        ),
                        array(
                            'param_name'  => 'light_map_custom',
                            'type'        => 'textarea_raw_html',
                            'class'       => '',
                            'heading'     => esc_html__( 'Style map custom', 'haru-circle' ),
                            'value'       => esc_html__( '', 'haru-circle' ),
                            'admin_label' => false,
                            'description' => esc_html__( 'Reference: https://snazzymaps.com/','haru-circle' ),
                            'dependency' => array(
                                'element' => 'light_map',
                                'value'   => array('custom')
                            ),
                        ),
                        array(
                            'param_name'  => 'info_title',
                            'type'        => 'textarea',
                            'class'       => '',
                            'heading'     => esc_html__( 'Info window title', 'haru-circle' ),
                            'value'       => esc_html__( 'My address', 'haru-circle' ),
                            'description' => ''
                        ),
                        array(
                            'param_name'  => 'info_image',
                            'type'        => 'attach_image',
                            'class'       => '',
                            'heading'     => esc_html__( 'Info window image', 'haru-circle' ),
                            'value'       => esc_html__( 'My address', 'haru-circle' ),
                            'description' => ''
                        ),
                        array(
                            'param_name'  => 'height',
                            'type'        => 'textfield',
                            'class'       => '',
                            'heading'     => esc_html__( 'Map height', 'haru-circle' ),
                            'value'       => esc_html__( '400px', 'haru-circle' ),
                            'description' => esc_html__( 'Example: 500px', 'haru-circle' )
                        ),
                        array(
                            'param_name'  => 'lat',
                            'type'        => 'textfield',
                            'class'       => '',
                            'heading'     => esc_html__( 'Latitude','haru-circle' ),
                            'value'       => esc_html__( '40.843292','haru-circle' ),
                            'description' => esc_html__( 'Get longtitude from here: https://www.google.com/maps', 'haru-circle' )
                        ),
                        array(
                            'param_name'  => 'lng',
                            'type'        => 'textfield',
                            'class'       => '',
                            'heading'     => esc_html__( 'Longitude', 'haru-circle' ),
                            'value'       => esc_html__( '-73.864512', 'haru-circle' ),
                            'description' => esc_html__( 'Get longtitude from here: https://www.google.com/maps', 'haru-circle' )
                        ),
                        array(
                            'param_name'  => 'zoom',
                            'type'        => 'textfield',
                            'class'       => '',
                            'heading'     => esc_html__( 'Zoom', 'haru-circle' ),
                            'value'       => esc_html__( '12', 'haru-circle' ),
                            'description' => esc_html__( 'Example : 20 for a close view, 5 for a far view', 'haru-circle' )
                        ),
                        array(
                            'param_name'  => 'image',
                            'type'        => 'attach_image',
                            'heading'     => esc_html__( 'Image to replace marker', 'haru-circle' ),
                            'value'       => '',
                            'description' => esc_html__( 'Select the image to replace the original map marker (optional).', 'haru-circle' )
                        ),
                        Haru_CircleCore_Shortcodes::add_css_animation(),
                        Haru_CircleCore_Shortcodes::add_duration_animation(),
                        Haru_CircleCore_Shortcodes::add_delay_animation(),
                        Haru_CircleCore_Shortcodes::add_el_class()
                    )
                )
            );
        }
    }

    new Haru_Framework_Shortcode_Gmaps();
}
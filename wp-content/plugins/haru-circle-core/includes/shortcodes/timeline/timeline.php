<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

if ( ! defined( 'ABSPATH' ) ) die( '-1' );

if ( ! class_exists('Haru_Framework_Shortcode_Timeline') ) {
    class Haru_Framework_Shortcode_Timeline {
        function __construct() {
            add_shortcode( 'haru_timeline', array( $this, 'haru_timeline_shortcode' ) );
            add_action( 'vc_before_init', array($this, 'haru_timeline_vc_map') );
        }

        function haru_timeline_shortcode( $atts ) {
            $atts        = vc_map_get_attributes( 'haru_timeline', $atts );
            $layout_type = $timeline = $css = $el_class = $haru_animation = $css_animation = $duration = $delay = $styles_animation = '';
            extract(shortcode_atts(array(
                'layout_type'   => 'style_1',
                'timeline'     => '',
                'css'           => '',
                'el_class'      => '',
                'css_animation' => '',
                'duration'      => '',
                'delay'         => '',
            ), $atts));

            $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), 'haru_timeline', $atts );

            $haru_animation   = HARU_CircleCore_Shortcodes::haru_get_css_animation($css_animation);
            $styles_animation = HARU_CircleCore_Shortcodes::haru_get_style_animation($duration, $delay);

            ob_start();
            
        ?>
        <?php if ( $timeline != '' ) : ?>
            <div class="<?php echo esc_attr($css_class . ' ' . $haru_animation . ' ' . $styles_animation); ?>">
                <?php echo haru_get_template('timeline/'. $layout_type . '.php', array('atts' => $atts), '', '' ); ?>
            </div>
        <?php else : ?>
            <div class="item-not-found"><?php echo esc_html__( 'Please insert Timeline!', 'haru-circle' ) ?></div>
        <?php endif; ?>
        <?php
            $content =  ob_get_clean();
            return $content;
        }

        function haru_timeline_vc_map() {
            vc_map(
                array(
                    'name'        => esc_html__('Haru Timeline', 'haru-circle'),
                    'base'        => 'haru_timeline',
                    'category'    => HARU_CIRCLE_CORE_SHORTCODE_CATEGORY,
                    'icon'        => 'fa fa-play-circle haru-vc-icon',
                    'description' => esc_html__( 'Display Timeline', 'haru-circle' ),
                    'params'      =>  array(
                        array(
                            'type'        => 'param_group',
                            'heading'     => esc_html__( 'Timeline', 'haru-circle' ),
                            'param_name'  => 'timeline',
                            'description' => esc_html__( 'Enter values for timeline - time, title and description.', 'haru-circle' ),
                            'value'       => urlencode( json_encode( array(
                                array(
                                    'title' => esc_html__( 'Themeforest', 'haru-circle' ),
                                    'time' => '',
                                    'description' => '',
                                    'link' => '',
                                ),
                                array(
                                    'title'  => esc_html__( 'Codecanyon', 'haru-circle' ),
                                    'time' => '',
                                    'description'  => '',
                                    'link' => '',
                                ),
                                array(
                                    'title'  => esc_html__( 'Photodune', 'haru-circle' ),
                                    'time' => '',
                                    'description'  => '',
                                    'link' => '',
                                ),
                            ) ) ),
                            'params' => array(
                                array(
                                    'type'        => 'textfield',
                                    'heading'     => esc_html__( 'Time', 'haru-circle' ),
                                    'param_name'  => 'time',
                                    'description' => esc_html__( 'Enter time of Timeline.', 'haru-circle' ),
                                    'admin_label' => true,
                                ),
                                array(
                                    'type'        => 'textfield',
                                    'heading'     => esc_html__( 'Title', 'haru-circle' ),
                                    'param_name'  => 'title',
                                    'description' => esc_html__( 'Enter Title of Timeline.', 'haru-circle' ),
                                    'admin_label' => true,
                                ),
                                array(
                                    'type'        => 'textarea',
                                    'heading'     => esc_html__( 'Description', 'haru-circle' ),
                                    'param_name'  => 'description',
                                    'description' => esc_html__( 'Enter Description of Timeline.', 'haru-circle' ),
                                    'admin_label' => false,
                                ),
                                array(
                                    'param_name'  => 'link',
                                    'type'        => 'vc_link',
                                    'heading'     => esc_html__( 'Link', 'haru-circle' ),
                                    'description' => esc_html__( 'Please insert client\' link.', 'haru-circle' ),
                                    'admin_label' => false,
                                ),
                            ),
                        ),
                        array(
                            'param_name'  => 'layout_type',
                            'heading'     => esc_html__( 'Style', 'haru-circle' ),
                            'description' => 'Select style for display Timeline.',
                            'type'        => 'dropdown',
                            'value'       => array(
                                esc_html__( 'Carousel', 'haru-circle' ) =>  'carousel',
                            ),
                            'admin_label' => true,
                        ),
                        array(
                            'param_name' => 'css',
                            'type'       => 'css_editor',
                            'heading'    => esc_html__( 'CSS box', 'haru-circle' ),
                            'group'      => esc_html__( 'Design Options', 'haru-circle' ),
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

    new Haru_Framework_Shortcode_Timeline();
}
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

if ( ! class_exists('Haru_Framework_Shortcode_Banner') ) {
    class Haru_Framework_Shortcode_Banner {
        function __construct() {
            add_shortcode( 'haru_banner', array($this, 'haru_banner_shortcode') );
            add_action( 'vc_before_init', array($this, 'haru_banner_vc_map') );
        }

        function haru_banner_shortcode($atts) {
            $atts        = vc_map_get_attributes( 'haru_banner', $atts );
            $layout_type = $title = $sub_title = $description = $link = $image = $css = $el_class = $haru_animation = $css_animation = $duration = $delay = $styles_animation = '';
            extract(shortcode_atts(array(
                'layout_type'   => 'style_1',
                'title'         => '',
                'sub_title'         => '',
                'description'   => '',
                'link'          => '',
                'image'         => '',
                'css'           => '',
                'el_class'      => '',
                'css_animation' => '',
                'duration'      => '',
                'delay'         => '',
            ), $atts)); 
            
            $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), 'haru_banner', $atts );

            $haru_animation   = HARU_CircleCore_Shortcodes::haru_get_css_animation($css_animation);
            $styles_animation = HARU_CircleCore_Shortcodes::haru_get_style_animation($duration, $delay);

            ob_start();

            ?>
            <?php if ( ($image != '') || ($layout_type == 'style_9') ) : ?>
            <div class="<?php echo esc_attr($css_class . ' ' . $haru_animation . ' ' . $styles_animation); ?>">
                <?php echo haru_get_template('banner/'. $layout_type . '.php', array('atts' => $atts), '', '' ); ?>
            </div>
            <?php else : ?>
                <div class="banner-not-select"><?php echo esc_html__( 'Please select image for banner!', 'haru-circle' ); ?></div>
            <?php endif; ?>
        <?php
            $content =  ob_get_clean();
            return $content;         
        }

        function haru_banner_vc_map() {
            vc_map(
                array(
                    'name'        => esc_html__( 'Haru Banner', 'haru-circle' ),
                    'base'        => 'haru_banner',
                    'icon'        => 'fa fa-windows haru-vc-icon',
                    'description' => esc_html__( 'Display banner', 'haru-circle' ),
                    'category'    => HARU_CIRCLE_CORE_SHORTCODE_CATEGORY,
                    'params'      => array(
                        array(
                            'type'       => 'dropdown',
                            'heading'    => esc_html__( 'Layout Style', 'haru-circle' ),
                            'param_name' => 'layout_type',
                            'value'      => array(
                                esc_html__( 'Style 1 (Border Effect)', 'haru-circle' )   => 'style_1',
                                esc_html__( 'Style 2 (Home 3)', 'haru-circle' )          => 'style_2',
                                esc_html__( 'Style 3 (Home 4 - Top)', 'haru-circle' )    => 'style_3',
                                esc_html__( 'Style 4 (Home 4 - Bottom)', 'haru-circle' ) => 'style_4',
                                esc_html__( 'Style 5 (About Me)', 'haru-circle' )        => 'style_5',
                                esc_html__( 'Style 6 (Ads Film Online)', 'haru-circle' ) => 'style_6',
                                esc_html__( 'Style 7 (Scale Image)', 'haru-circle' )     => 'style_7',
                                esc_html__( 'Style 8 (Content Bottom)', 'haru-circle' )  => 'style_8',
                                esc_html__( 'Style 9 (Text Banner)', 'haru-circle' )     => 'style_9',
                            ),
                        ),
                        array(
                            'type'        => 'textfield',
                            'heading'     => esc_html__( 'Title', 'haru-circle' ),
                            'param_name'  => 'title',
                            'admin_label' => true,
                        ),
                        array(
                            'type'        => 'textfield',
                            'heading'     => esc_html__( 'Sub Title', 'haru-circle' ),
                            'param_name'  => 'sub_title',
                            'admin_label' => true,
                            'dependency'  => array(
                                'element' => 'layout_type',
                                'value'   => array('style_8', 'style_9'),
                            ),
                        ),
                        array(
                            'type'        => 'textarea',
                            'heading'     => esc_html__( 'Description', 'haru-circle' ),
                            'param_name'  => 'description',
                            'admin_label' => false,
                            'dependency'  => array(
                                'element' => 'layout_type',
                                'value'   => array('style_2', 'style_5', 'style_8', 'style_9'),
                            ),
                        ),
                        array(
                            'type'             => 'vc_link',
                            'heading'          => esc_html__( 'Link', 'haru-circle' ),
                            'param_name'       => 'link',
                            'admin_label'      => true,
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                        ),
                        array(
                            'type'        => 'attach_image',
                            'heading'     => esc_html__( 'Banner\'s Image', 'haru-circle' ),
                            'param_name'  => 'image',
                            'admin_label' => true,
                        ),
                        array(
                            'type'       => 'css_editor',
                            'heading'    => esc_html__( 'CSS box', 'haru-circle' ),
                            'param_name' => 'css',
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

    new Haru_Framework_Shortcode_Banner();
}
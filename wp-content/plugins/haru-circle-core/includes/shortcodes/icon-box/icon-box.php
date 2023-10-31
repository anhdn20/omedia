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

if ( ! class_exists('Haru_Framework_Shortcode_Icon_Box') ) {
    class Haru_Framework_Shortcode_Icon_Box {
        function __construct() {
            add_shortcode( 'haru_icon_box', array($this, 'haru_icon_box_shortcode') );
            add_action( 'vc_before_init', array($this, 'haru_icon_box_vc_map') );
        }

        function haru_icon_box_shortcode($atts) {
            $atts = vc_map_get_attributes( 'haru_icon_box', $atts );
            $type = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons
                  = $color = $custom_color = $title = $link = $description = $layout_type = $icon_image = $el_class = $haru_animation = $css_animation = $duration = $delay = $styles_animation = '';
            extract(shortcode_atts(array(
                'type'             => '',
                'icon_fontawesome' => '',
                'icon_openiconic'  => '',
                'icon_typicons'    => '',
                'icon_entypo'      => '',
                'icon_linecons'    => '',
                'color'            => '',
                'custom_color'     => '', // End icon params
                'layout_type'      => 'style_1',
                'title'            => '',
                'link'             => '',
                'description'      => '',
                'icon_image'       => '',
                'el_class'         => '',
                'css_animation'    => '',
                'duration'         => '',
                'delay'            => '',
            ), $atts));

            $haru_animation   = HARU_CircleCore_Shortcodes::haru_get_css_animation($css_animation);
            $styles_animation = HARU_CircleCore_Shortcodes::haru_get_style_animation($duration, $delay);

            ob_start();

            ?>
            <div class="<?php echo esc_attr($haru_animation . ' ' . $styles_animation); ?>">
                <?php echo haru_get_template('icon-box/'. $layout_type . '.php', array('atts' => $atts), '', '' ); ?>
            </div>
        <?php
            $content =  ob_get_clean();
            return $content;         
        }

        function haru_icon_box_vc_map() {
            vc_map(
                array(
                    'name'        => esc_html__( 'Haru Icon Box', 'haru-circle' ),
                    'base'        => 'haru_icon_box',
                    'icon'        => 'fa fa-info haru-vc-icon',
                    'description' => esc_html__( 'Display Icon box from libraries', 'haru-circle' ),
                    'category'    => HARU_CIRCLE_CORE_SHORTCODE_CATEGORY,
                    'params'      => array(
                        array(
                            'type'       => 'dropdown',
                            'heading'    => esc_html__( 'Layout Style', 'haru-circle' ),
                            'param_name' => 'layout_type',
                            'value'      => array(
                                esc_html__( 'Style 1 (Image)', 'haru-circle' ) => 'style_1',
                                esc_html__( 'Style 2 (Icon)', 'haru-circle' )  => 'style_2',
                            ),
                        ),
                        array(
                            'type'        => 'attach_image',
                            'heading'     => esc_html__( 'Image', 'haru-circle' ),
                            'param_name'  => 'icon_image',
                            'description' => esc_html__( 'Please select icon box\' image.', 'haru-circle' ),
                            'admin_label' => true,
                            'dependency' => array(
                                'element' => 'layout_type',
                                'value'   => array('style_1')
                            ),
                        ),
                        array(
                            'type'    => 'dropdown',
                            'heading' => esc_html__( 'Icon library', 'haru-circle' ),
                            'value'   => array(
                                esc_html__( 'Font Awesome', 'haru-circle' ) => 'fontawesome',
                                esc_html__( 'Open Iconic', 'haru-circle' )  => 'openiconic',
                                esc_html__( 'Typicons', 'haru-circle' )     => 'typicons',
                                esc_html__( 'Entypo', 'haru-circle' )       => 'entypo',
                                esc_html__( 'Linecons', 'haru-circle' )     => 'linecons',
                            ),
                            'admin_label' => true,
                            'param_name'  => 'type',
                            'description' => esc_html__( 'Select icon library.', 'haru-circle' ),
                            'dependency' => array(
                                'element' => 'layout_type',
                                'value'   => array('style_2')
                            ),
                        ),
                        array(
                            'type'       => 'iconpicker',
                            'heading'    => esc_html__( 'Icon', 'haru-circle' ),
                            'param_name' => 'icon_fontawesome',
                            'value'      => 'fa fa-adjust', // default value to backend editor admin_label
                            'settings'   => array(
                                'emptyIcon'    => false,
                                // default true, display an "EMPTY" icon?
                                'iconsPerPage' => 4000,
                                // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                            ),
                            'dependency' => array(
                                'element' => 'type',
                                'value'   => 'fontawesome',
                            ),
                            'description' => esc_html__( 'Select icon from library.', 'haru-circle' ),
                        ),
                        array(
                            'type'       => 'iconpicker',
                            'heading'    => esc_html__( 'Icon', 'haru-circle' ),
                            'param_name' => 'icon_openiconic',
                            'value'      => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
                            'settings'   => array(
                                'emptyIcon'    => false, // default true, display an "EMPTY" icon?
                                'type'         => 'openiconic',
                                'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                            ),
                            'dependency' => array(
                                'element' => 'type',
                                'value'   => 'openiconic',
                            ),
                            'description' => esc_html__( 'Select icon from library.', 'haru-circle' ),
                        ),
                        array(
                            'type'       => 'iconpicker',
                            'heading'    => esc_html__( 'Icon', 'haru-circle' ),
                            'param_name' => 'icon_typicons',
                            'value'      => 'typcn typcn-adjust-brightness', // default value to backend editor admin_label
                            'settings'   => array(
                                'emptyIcon'    => false, // default true, display an "EMPTY" icon?
                                'type'         => 'typicons',
                                'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                            ),
                            'dependency' => array(
                                'element' => 'type',
                                'value'   => 'typicons',
                            ),
                            'description' => esc_html__( 'Select icon from library.', 'haru-circle' ),
                        ),
                        array(
                            'type'       => 'iconpicker',
                            'heading'    => esc_html__( 'Icon', 'haru-circle' ),
                            'param_name' => 'icon_entypo',
                            'value'      => 'entypo-icon entypo-icon-note', // default value to backend editor admin_label
                            'settings'   => array(
                                'emptyIcon'    => false, // default true, display an "EMPTY" icon?
                                'type'         => 'entypo',
                                'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                            ),
                            'dependency' => array(
                                'element' => 'type',
                                'value'   => 'entypo',
                            ),
                        ),
                        array(
                            'type'       => 'iconpicker',
                            'heading'    => esc_html__( 'Icon', 'haru-circle' ),
                            'param_name' => 'icon_linecons',
                            'value'      => 'vc_li vc_li-heart', // default value to backend editor admin_label
                            'settings'   => array(
                                'emptyIcon'    => false, // default true, display an "EMPTY" icon?
                                'type'         => 'linecons',
                                'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                            ),
                            'dependency' => array(
                                'element' => 'type',
                                'value'   => 'linecons',
                            ),
                            'description' => esc_html__( 'Select icon from library.', 'haru-circle' ),
                        ),
                        array(
                            'type'               => 'dropdown',
                            'heading'            => esc_html__( 'Icon color', 'haru-circle' ),
                            'param_name'         => 'color',
                            'value'              => array_merge( getVcShared( 'colors' ), array( esc_html__( 'Custom color', 'haru-circle' ) => 'custom' ) ),
                            'description'        => esc_html__( 'Select icon color.', 'haru-circle' ),
                            'param_holder_class' => 'vc_colored-dropdown',
                            'dependency' => array(
                                'element' => 'layout_type',
                                'value'   => array('style_2')
                            ),
                        ),
                        array(
                            'type'        => 'colorpicker',
                            'heading'     => esc_html__( 'Custom color', 'haru-circle' ),
                            'param_name'  => 'custom_color',
                            'description' => esc_html__( 'Select custom icon color.', 'haru-circle' ),
                            'dependency'  => array(
                                'element' => 'color',
                                'value'   => 'custom',
                                'dependency' => array(
                                    'element' => 'layout_type',
                                    'value'   => array('style_2')
                                ),
                            ),
                        ),
                        array(
                            'type'        => 'textfield',
                            'heading'     => esc_html__( 'Title', 'haru-circle' ),
                            'param_name'  => 'title',
                            'admin_label' => true
                        ),
                        array(
                            'type'        => 'textarea',
                            'heading'     => esc_html__( 'Description', 'haru-circle' ),
                            'param_name'  => 'description',
                            'admin_label' => true,
                        ),
                        array(
                            'type'        => 'vc_link',
                            'heading'     => esc_html__( 'Link', 'haru-circle' ),
                            'param_name'  => 'link',
                            'admin_label' => true
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

    new Haru_Framework_Shortcode_Icon_Box();
}
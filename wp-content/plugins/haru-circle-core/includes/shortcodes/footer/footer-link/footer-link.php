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

if ( ! class_exists('Haru_Framework_Shortcode_Footer_Link') ) {
    class Haru_Framework_Shortcode_Footer_Link {
        function __construct() {
            add_shortcode( 'haru_footer_link', array($this, 'haru_footer_link_shortcode') );
            add_action( 'vc_before_init', array($this, 'haru_footer_link_vc_map') );
        }

        function haru_footer_link_shortcode($atts) {
            $atts  = vc_map_get_attributes( 'haru_footer_link', $atts );
            $links = $layout_type = $css = $el_class = $haru_animation = $css_animation = $duration = $delay = $styles_animation = '';
            extract(shortcode_atts(array(
                'links'      => '',
                'layout_type'   => 'style_1',
                'css'           => '',
                'el_class'      => '',
                'css_animation' => '',
                'duration'      => '',
                'delay'         => '',
            ), $atts));
           
            $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), 'haru_footer_link', $atts );
            
            $haru_animation   .= HARU_CircleCore_Shortcodes::haru_get_css_animation($css_animation);
            $styles_animation .= HARU_CircleCore_Shortcodes::haru_get_style_animation($duration, $delay);

            ob_start();

            ?>
            <?php if ( $links != '' ) : ?>
            <div class="<?php echo esc_attr($css_class . ' ' . $haru_animation . ' ' . $styles_animation); ?>">
                <?php echo haru_get_template('footer/footer-link/'. $layout_type . '.php', array('atts' => $atts), '', '' ); // use echo because footer use echo in theme ?>
            </div>
            <?php else : ?>
                <div class="footer-not-select"><?php echo esc_html__( 'Please insert Footer Link information!', 'haru-circle' ); ?></div>
            <?php endif; ?>
        <?php
            $content =  ob_get_clean();
            return $content;         
        }

        function haru_footer_link_vc_map() {
            vc_map(
                array(
                    'name'        => esc_html__('Haru Footer Link', 'haru-circle'),
                    'base'        => 'haru_footer_link',
                    'category'    => HARU_CIRCLE_CORE_SHORTCODE_CATEGORY,
                    'icon'        => 'fa fa-link haru-vc-icon',
                    'description' => esc_html__( 'Display Footer Link', 'haru-circle' ),
                    'params'      =>  array(
                        array(
                            'param_name'  => 'links',
                            'type'        => 'param_group',
                            'heading'     => esc_html__( 'Footer Link List', 'haru-circle' ),
                            'description' => esc_html__( 'Insert information for Footer Link List.', 'haru-circle' ),
                            'value'       => urlencode( json_encode( array(
                                array(
                                    'title'       => esc_html__( 'Link text', 'haru-circle' ),
                                ),
                                array(
                                    'title'       => esc_html__( 'Link text', 'haru-circle' ),
                                ),
                                array(
                                    'title'       => esc_html__( 'Link text', 'haru-circle' ),
                                ),
                            ) ) ),
                            'params' => array(
                                // Link Information
                                array(
                                    'param_name'  => 'title',
                                    'type'        => 'textfield',
                                    'heading'     => esc_html__( 'Title', 'haru-circle' ),
                                    'description' => esc_html__( 'Enter title of footer link.', 'haru-circle' ),
                                    'admin_label' => true,
                                ),
                                array(
                                    'param_name'  => 'link',
                                    'type'        => 'vc_link',
                                    'heading'     => esc_html__( 'Link', 'haru-circle' ),
                                    'description' => esc_html__( 'Set link of footer link.', 'haru-circle' ),
                                    'admin_label' => false,
                                ),
                            ),
                        ),
                        array(
                            'param_name'  => 'layout_type',
                            'heading'     => esc_html__( 'Style', 'haru-circle' ),
                            'description' => 'Select style for display footer link.',
                            'type'        => 'dropdown',
                            'value'       => array(
                                esc_html__( 'Style 1 (Default Footer)', 'haru-circle' )  =>  'style_1',
                                esc_html__( 'Style 2 (Services Home 2)', 'haru-circle' ) =>  'style_2',
                                esc_html__( 'Style 3 (Footer Home 2)', 'haru-circle' )   =>  'style_3',
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

    new Haru_Framework_Shortcode_Footer_Link();
}
?>
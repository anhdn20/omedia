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

if ( ! class_exists('Haru_Framework_Shortcode_Introduce') ) {
    class Haru_Framework_Shortcode_Introduce {
        function __construct() {
            add_shortcode( 'haru_introduce', array($this, 'haru_introduce_shortcode') );
            add_action( 'vc_before_init', array($this, 'haru_introduce_vc_map') );
        }

        function haru_introduce_shortcode($atts, $content) {
            $atts  = vc_map_get_attributes( 'haru_introduce', $atts );
            $layout_type = $title = $title_first = $sub_title = $image = $css = $el_class = $haru_animation = $css_animation = $duration = $delay =  '';
            extract(shortcode_atts(array(
                'layout_type'   => 'style_1',
                'title'         => '',
                'title_first'   => '',
                'sub_title'     => '',
                'image'         => '',
                'css'           => '',
                'el_class'      => '',
                'css_animation' => '',
                'duration'      => '',
                'delay'         => '',
            ), $atts));

            $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), 'haru_introduce', $atts );

            $haru_animation   = HARU_CircleCore_Shortcodes::haru_get_css_animation($css_animation);
            $styles_animation = HARU_CircleCore_Shortcodes::haru_get_style_animation($duration, $delay);

            ob_start();

            ?>
            <?php if( $layout_type != '' ) : ?>
            <div class="<?php echo esc_attr($css_class . ' ' . $haru_animation . ' ' . $styles_animation); ?>">
                <?php echo haru_get_template('introduce/'. $layout_type . '.php', array('atts' => $atts, 'content' => $content), '', '' ); ?>
            </div>
            <?php else : ?>
                <div class="introduce-not-select"><?php echo esc_html__( 'Please select Layout Type!', 'haru-circle' ); ?></div>
            <?php endif; ?>
        <?php
            $content =  ob_get_clean();
            return $content;         
        }

        function haru_introduce_vc_map() {
            vc_map(
                array(
                    'name'        => esc_html__('Haru Introduce Header', 'haru-circle'),
                    'base'        => 'haru_introduce',
                    'category'    => HARU_CIRCLE_CORE_SHORTCODE_CATEGORY,
                    'icon'        => 'fa fa-header haru-vc-icon',
                    'description' => esc_html__( 'Display Videos Header', 'haru-circle' ),
                    'params'      =>  array(
                        array(
                            'param_name'  => 'layout_type',
                            'heading'     => esc_html__( 'Style', 'haru-circle' ),
                            'description' => 'Select style for display footer link.',
                            'type'        => 'dropdown',
                            'value'       => array(
                                esc_html__( 'Style 1 (Film Header)', 'haru-circle' )     =>  'style_1',
                                esc_html__( 'Style 2 (About Header)', 'haru-circle' )    =>  'style_2',
                                esc_html__( 'Style 3 (About Me Header)', 'haru-circle' ) =>  'style_3',
                            ),
                            'admin_label' => true,
                        ),
                        array(
                            'param_name'  => 'title',
                            'type'        => 'textfield',
                            'heading'     => esc_html__( 'Title', 'haru-circle' ),
                            'description' => esc_html__( 'Enter title of header.', 'haru-circle' ),
                            'admin_label' => true,
                        ),
                        array(
                            'param_name'  => 'title_first',
                            'type'        => 'textfield',
                            'heading'     => esc_html__( 'Title First Word', 'haru-circle' ),
                            'description' => esc_html__( 'Enter title first word.', 'haru-circle' ),
                            'admin_label' => true,
                            'dependency'  => array(
                                'element' => 'layout_type', 
                                'value'   => array('style_1', 'style_2')
                            )
                        ),
                        array(
                            'param_name'  => 'sub_title',
                            'type'        => 'textfield',
                            'heading'     => esc_html__( 'Sub Title', 'haru-circle' ),
                            'description' => esc_html__( 'Enter sub title.', 'haru-circle' ),
                            'admin_label' => true,
                            'dependency'  => array(
                                'element' => 'layout_type', 
                                'value'   => array('style_3')
                            )
                        ),
                        array(
                            'param_name'  => 'image',
                            'type'        => 'attach_image',
                            'heading'     => esc_html__( 'Image', 'haru-circle' ),
                            'description' => esc_html__( 'Please select image.', 'haru-circle' ),
                            'admin_label' => true,
                            'dependency'  => array(
                                'element' => 'layout_type', 
                                'value'   => array('style_3')
                            )
                        ),
                        array(
                            'param_name'  => 'content',
                            'type'        => 'textarea_html',
                            'heading'     => esc_html__( 'Description', 'haru-circle' ),
                            'description' => esc_html__( 'Enter description of header.', 'haru-circle' ),
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

    new Haru_Framework_Shortcode_Introduce();
}
?>
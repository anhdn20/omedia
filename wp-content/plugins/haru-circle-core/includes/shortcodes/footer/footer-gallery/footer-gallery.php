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

if ( ! class_exists('Haru_Framework_Shortcode_Footer_Gallery') ) {
    class Haru_Framework_Shortcode_Footer_Gallery {
        function __construct() {
            add_shortcode( 'haru_footer_gallery', array($this, 'haru_footer_gallery_shortcode') );
            add_action( 'vc_before_init', array($this, 'haru_footer_gallery_vc_map') );
        }

        function haru_footer_gallery_shortcode($atts) {
            $atts  = vc_map_get_attributes( 'haru_footer_gallery', $atts );
            $images = $layout_type = $columns = $css = $el_class = $haru_animation = $css_animation = $duration = $delay = $styles_animation = '';
            extract(shortcode_atts(array(
                'images'        => '',
                'layout_type'   => 'style_1',
                'columns'       => '2',
                'css'           => '',
                'el_class'      => '',
                'css_animation' => '',
                'duration'      => '',
                'delay'         => '',
            ), $atts));
           
            $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), 'haru_footer_gallery', $atts );
            
            $haru_animation   = HARU_CircleCore_Shortcodes::haru_get_css_animation($css_animation);
            $styles_animation = HARU_CircleCore_Shortcodes::haru_get_style_animation($duration, $delay);

            ob_start();

            ?>
            <?php if ( $images != '' ) : ?>
            <div class="<?php echo esc_attr($css_class . ' ' . $haru_animation . ' ' . $styles_animation); ?>">
                <?php echo haru_get_template('footer/footer-gallery/'. $layout_type . '.php', array('atts' => $atts), '', '' ); // use echo because footer use echo in theme ?>
            </div>
            <?php else : ?>
                <div class="footer-not-select"><?php echo esc_html__( 'Please insert Footer Gallery images!', 'haru-circle' ); ?></div>
            <?php endif; ?>
        <?php
            $content =  ob_get_clean();
            return $content;         
        }

        function haru_footer_gallery_vc_map() {
            vc_map(
                array(
                    'name'        => esc_html__('Haru Footer Gallery', 'haru-circle'),
                    'base'        => 'haru_footer_gallery',
                    'category'    => HARU_CIRCLE_CORE_SHORTCODE_CATEGORY,
                    'icon'        => 'fa fa-image haru-vc-icon',
                    'description' => esc_html__( 'Display Footer Gallery', 'haru-circle' ),
                    'params'      =>  array(
                        array(
                            'param_name'  => 'images',
                            'type'        => 'param_group',
                            'heading'     => esc_html__( 'Footer Gallery Images', 'haru-circle' ),
                            'description' => esc_html__( 'Insert images for Footer Gallery.', 'haru-circle' ),
                            'value'       => urlencode( json_encode( array(
                                array(
                                    'title'       => esc_html__( 'Image text', 'haru-circle' ),
                                ),
                                array(
                                    'title'       => esc_html__( 'Image text', 'haru-circle' ),
                                ),
                                array(
                                    'title'       => esc_html__( 'Image text', 'haru-circle' ),
                                ),
                            ) ) ),
                            'params' => array(
                                // Image Information
                                array(
                                    'param_name'  => 'title',
                                    'type'        => 'textfield',
                                    'heading'     => esc_html__( 'Title', 'haru-circle' ),
                                    'description' => esc_html__( 'Enter title of image.', 'haru-circle' ),
                                    'admin_label' => true,
                                ),
                                array(
                                    'param_name'  => 'image',
                                    'type'        => 'attach_image',
                                    'heading'     => esc_html__( 'Image', 'haru-circle' ),
                                    'description' => esc_html__( 'Please select image.', 'haru-circle' ),
                                    'admin_label' => true,
                                ),
                                array(
                                    'param_name'  => 'link',
                                    'type'        => 'vc_link',
                                    'heading'     => esc_html__( 'Link', 'haru-circle' ),
                                    'description' => esc_html__( 'Set link of image.', 'haru-circle' ),
                                    'admin_label' => false,
                                ),
                            ),
                        ),
                        array(
                            'param_name' => 'columns',
                            'type'       => 'dropdown',
                            'heading'    => esc_html__( 'Columns', 'haru-circle' ),
                            'description'=> esc_html__( 'Choose columns of gallery from drop down list', 'haru-circle'),
                            'value'      => array(
                                esc_html__( '2', 'haru-circle' ) => '2',
                                esc_html__( '3', 'haru-circle' ) => '3',
                                esc_html__( '4', 'haru-circle' ) => '4',
                                esc_html__( '5', 'haru-circle' ) => '5',
                            ),
                            'admin_label'      => true,
                        ),
                        array(
                            'param_name'  => 'layout_type',
                            'heading'     => esc_html__( 'Style', 'haru-circle' ),
                            'description' => 'Select style for display footer gallery.',
                            'type'        => 'dropdown',
                            'value'       => array(
                                esc_html__( 'Style 1 (Default)', 'haru-circle' ) =>  'style_1',
                            )
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

    new Haru_Framework_Shortcode_Footer_Gallery();
}
?>
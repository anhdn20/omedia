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

if ( ! class_exists('Haru_Framework_Shortcode_Images_Gallery') ) {
    class Haru_Framework_Shortcode_Images_Gallery {
        function __construct() {
            add_shortcode( 'haru_images_gallery', array($this, 'haru_images_gallery_shortcode') );
            add_action( 'vc_before_init', array($this, 'haru_images_gallery_vc_map') );
        }

        function haru_images_gallery_shortcode($atts) {
            $atts  = vc_map_get_attributes( 'haru_images_gallery', $atts );
            $images = $layout_type = $columns = $padding = $el_class = $haru_animation = $css_animation = $duration = $delay = $styles_animation = '';
            extract(shortcode_atts(array(
                'images'        => '',
                'layout_type'   => 'slick',
                'columns'       => '5',
                'padding'       => 'no-padding',
                'el_class'      => '',
                'css_animation' => '',
                'duration'      => '',
                'delay'         => '',
            ), $atts));
            
            $haru_animation   = HARU_CircleCore_Shortcodes::haru_get_css_animation($css_animation);
            $styles_animation = HARU_CircleCore_Shortcodes::haru_get_style_animation($duration, $delay);

            ob_start();

            ?>
            <?php if ( $images != '' ) : ?>
            <div class="<?php echo esc_attr($haru_animation . ' ' . $styles_animation); ?>">
                <?php echo haru_get_template('images-gallery/'. $layout_type . '.php', array('atts' => $atts), '', '' ); ?>
            </div>
            <?php else : ?>
                <div class="images-not-select"><?php echo esc_html__( 'Please select images!', 'haru-circle' ); ?></div>
            <?php endif; ?>
        <?php
            $content =  ob_get_clean();
            return $content;         
        }

        function haru_images_gallery_vc_map() {
            vc_map(
                array(
                    'name'        => esc_html__( 'Haru Images Gallery', 'haru-circle' ),
                    'base'        => 'haru_images_gallery',
                    'icon'        => 'fa fa-image haru-vc-icon',
                    'category'    => HARU_CIRCLE_CORE_SHORTCODE_CATEGORY,
                    'description' => esc_html__( 'Display images gallery', 'haru-circle' ),
                    'params'      => array(
                        array(
                            'param_name'  => 'images',
                            'type'        => 'param_group',
                            'heading'     => esc_html__( 'Images', 'haru-circle' ),
                            'description' => esc_html__( 'Enter values for images - title, image and url.', 'haru-circle' ),
                            'value'       => urlencode( json_encode( array(
                                array(
                                    'title' => esc_html__( 'Themeforest', 'haru-circle' ),
                                    'image' => '',
                                    'link'  => '',
                                ),
                                array(
                                    'title'  => esc_html__( 'Codecanyon', 'haru-circle' ),
                                    'image' => '',
                                    'link'   => '',
                                ),
                                array(
                                    'title'  => esc_html__( 'Photodune', 'haru-circle' ),
                                    'image' => '',
                                    'link'   => '',
                                ),
                            ) ) ),
                            'params' => array(
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
                                    'description' => esc_html__( 'Please insert image\' link.', 'haru-circle' ),
                                    'admin_label' => false,
                                ),
                            ),
                        ),
                        array(
                            'param_name'  => 'layout_type',
                            'heading'     => esc_html__( 'Choose layout', 'haru-circle' ),
                            'description' => '',
                            'type'        => 'dropdown',
                            'value'       => array(
                                esc_html__( 'Slick Slideshow', 'haru-circle' ) => 'slick',
                                esc_html__( 'Grid', 'haru-circle' )            => 'grid',
                                esc_html__( 'Slick 2 (Home 10)', 'haru-circle' )          => 'slick_2',
                            ),
                            'admin_label' => true,
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                        ),
                        array( 
                            'param_name'  => 'columns', 
                            'heading'     => esc_html__( 'Columns', 'haru-circle' ), 
                            'type'        => 'dropdown',
                            'value'       => array( 2, 3, 4, 5 ),
                            'admin_label' => true,
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                        ),
                        array(
                            'param_name'  => 'padding',
                            'heading'     => esc_html__( 'Padding', 'haru-circle' ),
                            'description' => '',
                            'type'        => 'dropdown',
                            'value'       => array(
                                esc_html__( 'No', 'haru-circle' )  => 'no-padding',
                                esc_html__( 'Yes', 'haru-circle' ) => 'padding-5',
                            ),
                            'admin_label' => true,
                        ),
                        Haru_CircleCore_Shortcodes::add_css_animation(),
                        Haru_CircleCore_Shortcodes::add_duration_animation(),
                        Haru_CircleCore_Shortcodes::add_delay_animation(),
                        Haru_CircleCore_Shortcodes::add_el_class()
                    ),
                )
            );
        }
    }

    new Haru_Framework_Shortcode_Images_Gallery();
}
?>
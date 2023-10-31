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

if ( ! class_exists('Haru_Framework_Shortcode_Clients') ) {
    class Haru_Framework_Shortcode_Clients {
        function __construct() {
            add_shortcode( 'haru_clients', array( $this, 'haru_clients_shortcode' ) );
            add_action( 'vc_before_init', array($this, 'haru_clients_vc_map') );
        }

        function haru_clients_shortcode($atts) {
            $atts    = vc_map_get_attributes( 'haru_clients', $atts );
            $clients = $autoplay = $slide_duration = $logo_per_slide = $layout_type = $el_class = $haru_animation = $css_animation = $duration = $delay = $styles_animation = '';
            extract(shortcode_atts(array(
                'clients'        => '',
                'autoplay'       => 'true',
                'slide_duration' => '6000',
                'layout_type'    => 'style_1',
                'logo_per_slide' => '5',
                'el_class'       => '',
                'css_animation'  => '',
                'duration'       => '',
                'delay'          => '',
            ), $atts));

            $haru_animation   = HARU_CircleCore_Shortcodes::haru_get_css_animation($css_animation);
            $styles_animation = HARU_CircleCore_Shortcodes::haru_get_style_animation($duration, $delay);

            ob_start();

            ?>
            <?php if ( $clients != '' ) : ?>
            <div class="<?php echo esc_attr($haru_animation . ' ' . $styles_animation); ?>">
                <?php echo haru_get_template('clients/'. $layout_type . '.php', array('atts' => $atts), '', '' ); ?>
            </div>
            <?php else : ?>
                <div class="clients-not-select"><?php echo esc_html__( 'Please select clients!', 'haru-circle' ); ?></div>
            <?php endif; ?>
        <?php
            $content =  ob_get_clean();
            return $content;         
        }

        function haru_clients_vc_map() {
            vc_map(
                array(
                    'name'        => esc_html__( 'Haru Clients', 'haru-circle' ),
                    'base'        => 'haru_clients',
                    'icon'        => 'fa fa-users haru-vc-icon',
                    'category'    => HARU_CIRCLE_CORE_SHORTCODE_CATEGORY,
                    'description' => esc_html__( 'Display client logos', 'haru-circle' ),
                    'params'      => array(
                        array(
                            'type'        => 'param_group',
                            'heading'     => esc_html__( 'Clients', 'haru-circle' ),
                            'param_name'  => 'clients',
                            'description' => esc_html__( 'Enter values for client - name, image and url.', 'haru-circle' ),
                            'value'       => urlencode( json_encode( array(
                                array(
                                    'name' => esc_html__( 'Themeforest', 'haru-circle' ),
                                    'logo' => '',
                                    'link' => '',
                                ),
                                array(
                                    'name'  => esc_html__( 'Codecanyon', 'haru-circle' ),
                                    'value' => '',
                                    'link'  => '',
                                ),
                                array(
                                    'name'  => esc_html__( 'Photodune', 'haru-circle' ),
                                    'value' => '',
                                    'link'  => '',
                                ),
                            ) ) ),
                            'params' => array(
                                array(
                                    'type'        => 'textfield',
                                    'heading'     => esc_html__( 'Name', 'haru-circle' ),
                                    'param_name'  => 'name',
                                    'description' => esc_html__( 'Enter name of client.', 'haru-circle' ),
                                    'admin_label' => true,
                                ),
                                array(
                                    'type'        => 'attach_image',
                                    'heading'     => esc_html__( 'Image', 'haru-circle' ),
                                    'param_name'  => 'logo',
                                    'description' => esc_html__( 'Please select client\' logo.', 'haru-circle' ),
                                    'admin_label' => true,
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
                            'type'       => 'dropdown',
                            'heading'    => esc_html__( 'AutoPlay', 'haru-circle' ),
                            'param_name' => 'autoplay',
                            'value'      => array(
                                esc_html__( 'Yes', 'haru-circle') => 'true', 
                                esc_html__( 'No', 'haru-circle')  => 'false'
                            ),
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                        ),
                        array(
                            'type'             => 'textfield',
                            'heading'          => esc_html__( 'Slide Duration (ms)', 'haru-circle' ),
                            'param_name'       => 'slide_duration',
                            'std'              => '6000',
                            'admin_label'      => true,
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                        ),
                        array(
                            'param_name'  => 'layout_type',
                            'heading'     => esc_html__( 'Choose layout', 'haru-circle' ),
                            'description' => '',
                            'type'        => 'dropdown',
                            'value'       => array(
                                esc_html__( 'Style 1 (Carousel)', 'haru-circle' ) => 'style_1',
                                esc_html__( 'Style 2', 'haru-circle' )            => 'style_2',
                            ),
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                        ),
                        array( 
                            'param_name'  => 'logo_per_slide', 
                            'heading'     => esc_html__( 'Logo per slide', 'haru-circle' ), 
                            'type'        => 'textfield',
                            'value'       => '5',
                            'admin_label' => true,
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
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

    new Haru_Framework_Shortcode_Clients();
}
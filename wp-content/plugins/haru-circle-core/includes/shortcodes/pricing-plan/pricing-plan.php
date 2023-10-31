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

if ( ! class_exists('Haru_Framework_Shortcode_Pricing_Plan') ) {
    class Haru_Framework_Shortcode_Pricing_Plan {
        function __construct() {
            add_shortcode( 'haru_pricing_plan', array($this, 'haru_pricing_plan_shortcode') );
            add_action( 'vc_before_init', array($this, 'haru_pricing_plan_vc_map') );
        }

        function haru_pricing_plan_shortcode($atts) {
            $atts        = vc_map_get_attributes( 'haru_pricing_plan', $atts );
            $layout_type = $time_unit = $currency = $plans = $columns = $css = $el_class = $haru_animation = $css_animation = $duration = $delay = $styles_animation = '';
            extract(shortcode_atts(array(
                'plans'            => '',
                'layout_type'       => 'style_1',
                'time_unit'       => 'day',
                'currency'       => '',
                'columns'           => '',
                'css'               => '',
                'el_class'          => '',
                'css_animation'     => '',
                'duration'          => '',
                'delay'             => '',
            ), $atts)); 

            $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), 'haru_pricing_plan', $atts );

            $haru_animation   = HARU_CircleCore_Shortcodes::haru_get_css_animation($css_animation);
            $styles_animation = HARU_CircleCore_Shortcodes::haru_get_style_animation($duration, $delay);

            ob_start();

            ?>
            <?php if ( $plans != '' ) : ?>
            <div class="<?php echo esc_attr($css_class . ' ' . $haru_animation . ' ' . $styles_animation); ?>">
                <?php echo haru_get_template('pricing-plan/'. $layout_type . '.php', array('atts' => $atts), '', '' ); ?>
            </div>
            <?php else : ?>
                <div class="plan-not-select"><?php echo esc_html__( 'Please set pricing plan!', 'haru-circle' ); ?></div>
            <?php endif; ?>
        <?php
            $content =  ob_get_clean();
            return $content;         
        }

        function haru_pricing_plan_vc_map() {
            vc_map(
                array(
                    'name'        => esc_html__( 'Haru Pricing Plan', 'haru-circle' ),
                    'base'        => 'haru_pricing_plan',
                    'icon'        => 'fa fa-windows haru-vc-icon',
                    'description' => esc_html__( 'Display pricing plan with creative layout', 'haru-circle' ),
                    'category'    => HARU_CIRCLE_CORE_SHORTCODE_CATEGORY,
                    'params'      => array(
                        array(
                            'param_name'  => 'plans',
                            'type'        => 'param_group',
                            'heading'     => esc_html__( 'Plans List', 'haru-circle' ),
                            'description' => esc_html__( 'Select image and insert information for Plans List.', 'haru-circle' ),
                            'value'       => urlencode( json_encode( array(
                                array(
                                    'title'       => esc_html__( 'Themeforest', 'haru-circle' ),
                                    'price' => '',
                                    'information'       => '',
                                    'image'        => '',
                                    'link'        => '',
                                ),
                                array(
                                    'title'       => esc_html__( 'Codecanyon', 'haru-circle' ),
                                    'price' => '',
                                    'information'       => '',
                                    'image'        => '',
                                    'link'        => '',
                                ),
                                array(
                                    'title'       => esc_html__( 'Photodune', 'haru-circle' ),
                                    'price' => '',
                                    'information'       => '',
                                    'image'        => '',
                                    'link'        => '',
                                ),
                            ) ) ),
                            'params' => array(
                                array(
                                    'param_name'  => 'title',
                                    'type'        => 'textfield',
                                    'heading'     => esc_html__( 'Title', 'haru-circle' ),
                                    'admin_label' => true,
                                ),
                                array(
                                    'param_name'  => 'price',
                                    'type'        => 'textfield',
                                    'heading'     => esc_html__( 'Price', 'haru-circle' ),
                                    'admin_label' => false,
                                    'description' => esc_html__( 'Set 0 for Free plan.', 'haru-circle' ),
                                ),
                                array(
                                    'param_name' => 'featured',
                                    'type'       => 'dropdown',
                                    'heading'    => esc_html__( 'Featured plan', 'haru-circle' ),
                                    'value'      => array(
                                        esc_html__( 'None', 'haru-circle' )    => '',
                                        esc_html__( 'Featured', 'haru-circle' ) => 'featured',
                                    ),
                                ),
                                array(
                                    'param_name'  => 'information',
                                    'type'        => 'param_group',
                                    'heading'     => esc_html__( 'Information', 'haru-circle' ),
                                    'description' => esc_html__( 'Set information details for plan.', 'haru-circle' ),
                                    'value'       => urlencode( json_encode( array(
                                        array(
                                            'info'       => esc_html__( 'Information 1', 'haru-circle' ),
                                        ),
                                        array(
                                            'info'       => esc_html__( 'Information 2', 'haru-circle' ),
                                        ),
                                        array(
                                            'info'       => esc_html__( 'Information 3', 'haru-circle' ),
                                        ),
                                    ) ) ),
                                    'params' => array(
                                        array(
                                            'param_name'  => 'info',
                                            'type'        => 'textfield',
                                            'heading'     => esc_html__( 'Information Detail', 'haru-circle' ),
                                            'admin_label' => true,
                                        ),
                                    ),
                                ),
                                array(
                                    'param_name'  => 'image',
                                    'type'        => 'attach_image',
                                    'heading'     => esc_html__( 'Image', 'haru-circle' ),
                                    'description' => esc_html__( 'Please select image.', 'haru-circle' ),
                                    'admin_label' => false,
                                ),
                                array(
                                    'param_name'  => 'link',
                                    'type'        => 'vc_link',
                                    'heading'     => esc_html__( 'Link', 'haru-circle' ),
                                    'description' => esc_html__( 'Set link of plan.', 'haru-circle' ),
                                    'admin_label' => false,
                                ),
                            ),
                        ),
                        array(
                            'param_name' => 'time_unit',
                            'type'       => 'textfield',
                            'heading'    => esc_html__( 'Time Unit', 'haru-circle' ),
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                        ),
                        array(
                            'param_name'  => 'currency',
                            'type'        => 'textfield',
                            'heading'     => esc_html__( 'Currency', 'haru-circle' ),
                            'admin_label' => false,
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                        ),
                        array(
                            'type'       => 'dropdown',
                            'heading'    => esc_html__( 'Layout Style', 'haru-circle' ),
                            'param_name' => 'layout_type',
                            'value'      => array(
                                esc_html__( 'Style 1 (Background Dark)', 'haru-circle' )   => 'style_1',
                                esc_html__( 'Style 2 (Background Light)', 'haru-circle' )   => 'style_2',
                            ),
                            'admin_label' => true,
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                        ),
                        array( 
                            'param_name'       => 'columns', 
                            'heading'          => esc_html__( 'Columns', 'haru-circle' ),
                            'type'             => 'dropdown',
                            'value'            => array( 2, 3, 4, 5, 6 ),
                            'admin_label'      => true,
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
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

    new Haru_Framework_Shortcode_Pricing_Plan();
}
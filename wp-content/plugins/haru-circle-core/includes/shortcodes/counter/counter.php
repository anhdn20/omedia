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

if ( ! class_exists('Haru_Framework_Shortcode_Counter') ) {
    class Haru_Framework_Shortcode_Counter {
        function __construct() {
            add_shortcode( 'haru_counter', array( $this, 'haru_counter_shortcode' ) );
            add_action( 'vc_before_init', array($this, 'haru_counter_vc_map') );
        }

        function haru_counter_shortcode( $atts ) {
            $atts        = vc_map_get_attributes( 'haru_counter', $atts );
            $layout_type = $title = $number = $el_class = $haru_animation = $css_animation = $duration = $delay = $styles_animation = '';
            extract(shortcode_atts(array(
                'layout_type'   => 'style_1',
                'title'         => 'This is title.',
                'number'        => '123',
                'el_class'      => '',
                'css_animation' => '',
                'duration'      => '',
                'delay'         => '',
            ), $atts));

            $haru_animation   = HARU_CircleCore_Shortcodes::haru_get_css_animation($css_animation);
            $styles_animation = HARU_CircleCore_Shortcodes::haru_get_style_animation($duration, $delay);

            ob_start();
            
        ?>
        <?php if( $number != '' ) : ?>
            <div class="<?php echo esc_attr($haru_animation . ' ' . $styles_animation); ?>">
                <?php echo haru_get_template('counter/'. $layout_type . '.php', array('atts' => $atts), '', '' ); ?>
            </div>
        <?php else : ?>
            <div class="item-not-found"><?php echo esc_html__( 'Please insert counter number!', 'haru-circle' ) ?></div>
        <?php endif; ?>
        <?php
            $content =  ob_get_clean();
            return $content;
        }

        function haru_counter_vc_map() {
            vc_map(
                array(
                    'name'        => esc_html__('Haru Counter', 'haru-circle'),
                    'base'        => 'haru_counter',
                    'category'    => HARU_CIRCLE_CORE_SHORTCODE_CATEGORY,
                    'icon'        => 'fa fa-tachometer haru-vc-icon',
                    'description' => esc_html__( 'Display Counter Statistical', 'haru-circle' ),
                    'params'      =>  array(
                        array(
                            'param_name'  => 'layout_type',
                            'heading'     => esc_html__( 'Style', 'haru-circle' ),
                            'description' => 'Select style for display statistical.',
                            'type'        => 'dropdown',
                            'admin_label' => true,
                            'value'       => array(
                                esc_html__( 'Style 1 (Actor Counter)', 'haru-circle' ) =>  'style_1',
                                esc_html__( 'Style 2 (About Counter)', 'haru-circle' ) =>  'style_2',
                            )
                        ),
                        array(
                            'type'        =>  'textarea',
                            'heading'     =>  esc_html__( 'Title', 'haru-circle' ),
                            'description' =>  'Enter text for counter title',
                            'param_name'  =>  'title',
                            'value'       =>  'This is title.',
                            'dependency'  => array(
                                'element' => 'layout_type', 
                                'value'   => array('style_1', 'style_2')
                            ),
                        ),
                        array(
                            'type'        =>  'textfield',
                            'heading'     =>  esc_html__( 'Number', 'haru-circle' ),
                            'description' => 'Enter number of statistical. Example 1466.',
                            'param_name'  =>  'number',
                            'value'       =>  '123',
                            'admin_label' => true,
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

    new Haru_Framework_Shortcode_Counter();
}
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

if ( ! class_exists('Haru_Framework_Shortcode_Single_Digitalasset') ) {
    class Haru_Framework_Shortcode_Single_Digitalasset {
        function __construct() {
            add_shortcode('haru_single_digitalasset', array($this, 'haru_single_digitalasset_shortcode' ));
            add_action( 'vc_before_init', array($this, 'haru_single_digitalasset_vc_map') );
        }

        function haru_single_digitalasset_shortcode($atts) {
            $atts        = vc_map_get_attributes( 'haru_single_digitalasset', $atts );
            $layout_type = $id = $title_left = $title_right = $el_class = $haru_animation = $css_animation = $duration = $delay = $styles_animation = '';
            extract(shortcode_atts(array(
                'layout_type'   => 'style_1',
                'id'            => '',
                'image'         => '',
                'title_left'    => '',
                'title_right'   => '',
                'el_class'      => '',
                'css_animation' => '',
                'duration'      => '',
                'delay'         => '',
            ), $atts));

            $haru_animation   = HARU_CircleCore_Shortcodes::haru_get_css_animation($css_animation);
            $styles_animation = HARU_CircleCore_Shortcodes::haru_get_style_animation($duration, $delay);

            ob_start();
        ?>  
        
        <div class="<?php echo esc_attr( $haru_animation . ' ' . $styles_animation ); ?>">
            <?php echo haru_get_template('posttypes/digitalasset/single/'. $layout_type . '.php', array('atts' => $atts), '', '' ); ?>
        </div>
        
        <?php
            wp_reset_query();
            $content =  ob_get_clean();
            return $content;
        }

        function haru_single_digitalasset_vc_map() {
            vc_map(
                array(
                    'name'        =>  esc_html__( 'Haru Single Digital Asset', 'haru-circle' ),
                    'base'        =>  'haru_single_digitalasseto',
                    'category'    =>  HARU_CIRCLE_CORE_SHORTCODE_CATEGORY,
                    'icon'        =>  'fa fa-play-circle-o haru-vc-icon',
                    'description' =>  esc_html__( 'Display single Digital Asset work', 'haru-circle' ),
                    'params'      =>  array(
                        array(
                            'param_name' => 'layout_type',
                            'type'       => 'dropdown',
                            'heading'    => esc_html__( 'Layout Style', 'haru-circle' ),
                            'description'=> esc_html__('Choose layout style from drop down list styles.', 'haru-circle'),
                            'value'      => array(
                                esc_html__( 'Style 1 (Digital Asset Background)', 'haru-circle' )        => 'style_1',
                                esc_html__( 'Style 2 (VC Background)', 'haru-circle' )           => 'style_2',
                                esc_html__( 'Style 3 (Select Image Background)', 'haru-circle' ) => 'style_3',
                            ),
                            'admin_label' => true,
                        ),
                        array(
                            'param_name'  => 'id',
                            'type'        => 'haru_digitalasset_list',
                            'admin_label' => true,
                            'heading'     => esc_html__( 'Select Digital Asset', 'haru-circle' ),
                            'description' => esc_html__( 'Choose single Digital Asset by search Digital Asset name.', 'haru-circle'),
                        ),
                        array(
                            'type'        => 'attach_image',
                            'heading'     => esc_html__( 'Banner\'s Image', 'haru-circle' ),
                            'param_name'  => 'image',
                            'admin_label' => true,
                            'dependency'  => array(
                                'element' => 'layout_type', 
                                'value'   => array('style_3')
                            )
                        ),
                        array(
                            'param_name'  => 'title_left',
                            'type'        => 'textfield',
                            'heading'     => esc_html__( 'Title Left Icon', 'haru-circle' ),
                            'description' => esc_html__( 'Enter left title of icon.', 'haru-circle' ),
                            'admin_label' => true,
                            'dependency'  => array(
                                'element' => 'layout_type', 
                                'value'   => array('style_2')
                            )
                        ),
                        array(
                            'param_name'  => 'title_right',
                            'type'        => 'textfield',
                            'heading'     => esc_html__( 'Title Right Icon', 'haru-circle' ),
                            'description' => esc_html__( 'Enter right title of icon.', 'haru-circle' ),
                            'admin_label' => true,
                            'dependency'  => array(
                                'element' => 'layout_type', 
                                'value'   => array('style_2')
                            )
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

    new Haru_Framework_Shortcode_Single_digitalasset();
}
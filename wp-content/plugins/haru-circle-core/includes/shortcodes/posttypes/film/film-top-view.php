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

if ( ! class_exists('Haru_Framework_Shortcode_Film_Top_View') ) {
    class Haru_Framework_Shortcode_Film_Top_View {
        function __construct() {
            add_shortcode('haru_film_top_view', array($this, 'haru_film_top_view_shortcode' ));
            add_action( 'vc_before_init', array($this, 'haru_film_top_view_vc_map') );
            $this->haru_includes();
        }

        private function haru_includes() {
            include_once( 'utils/functions.php' );
        }

        function haru_film_top_view_shortcode($atts) {
            $atts        = vc_map_get_attributes( 'haru_film_top_view', $atts );
            $title = $layout_type = $posts_per_page = $el_class = $haru_animation = $css_animation = $duration = $delay = $styles_animation = '';
            extract(shortcode_atts(array(
                'title'          => '',
                'layout_type'    => 'top-view',
                'posts_per_page' => '6',
                'el_class'       => '',
                'css_animation'  => '',
                'duration'       => '',
                'delay'          => '',
            ), $atts));

            $haru_animation   = HARU_CircleCore_Shortcodes::haru_get_css_animation($css_animation);
            $styles_animation = HARU_CircleCore_Shortcodes::haru_get_style_animation($duration, $delay);

            ob_start();
        ?>  
        
        <div class="<?php echo esc_attr( $haru_animation . ' ' . $styles_animation ); ?>">
            <?php echo haru_get_template('posttypes/film/'. $layout_type . '.php', array('atts' => $atts), '', '' ); ?>
        </div>  
        
        <?php
            wp_reset_query();
            $content =  ob_get_clean();
            return $content;
        }

        function haru_film_top_view_vc_map() {
            vc_map(
                array(
                    'base'        => 'haru_film_top_view',
                    'name'        => esc_html__( 'Haru Film Top View', 'haru-circle' ),
                    'icon'        => 'fa fa-user-secret haru-vc-icon',
                    'description' => esc_html__( 'Display our films top view', 'haru-circle' ),
                    'category'    => HARU_CIRCLE_CORE_SHORTCODE_CATEGORY,
                    'params'      => array(
                        array(
                            'type'        => 'textfield',
                            'heading'     => esc_html__( 'Title', 'haru-circle' ),
                            'param_name'  => 'title',
                            'admin_label' => true,
                        ),
                        array(
                            'param_name'       => 'layout_type',
                            'type'             => 'dropdown',
                            'heading'          => esc_html__( 'Layout Style', 'haru-circle' ),
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            'admin_label'      => true,
                            'value'            => array(
                                esc_html__( 'Top List', 'haru-circle' ) => 'top-view',
                            ),
                        ),
                        array( 
                            'param_name'  => 'posts_per_page', 
                            'heading'     => esc_html__( 'Posts per page', 'haru-circle' ), 
                            'type'        => 'textfield', 
                            'admin_label' => true,
                            'description' => esc_html__( 'Number of films to show', 'haru-circle' ),
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
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

    new Haru_Framework_Shortcode_Film_Top_View();
}
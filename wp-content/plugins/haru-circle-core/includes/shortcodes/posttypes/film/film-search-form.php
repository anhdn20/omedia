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

if ( ! class_exists('Haru_Framework_Shortcode_Film_Search_Form') ) {
    class Haru_Framework_Shortcode_Film_Search_Form {
        function __construct() {
            add_shortcode('haru_film_search_form', array($this, 'haru_film_shortcode' ));
            add_action( 'vc_before_init', array($this, 'haru_film_search_form_vc_map') );
            $this->haru_includes();
        }

        private function haru_includes() {
            include_once( 'utils/functions.php' );
        }

        function haru_film_shortcode($atts) {
            $atts        = vc_map_get_attributes( 'haru_film_search_form', $atts );
            $layout_type = $columns = $film_style = $posts_per_page = $paging_style = $el_class = $haru_animation = $css_animation = $duration = $delay = $styles_animation = '';
            extract(shortcode_atts(array(
                'layout_type'    => 'search-form-ajax',
                'columns'        => '2',
                'film_style'     => 'style_1',
                'posts_per_page' => '6',
                'paging_style'   => 'loadmore',
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

        function haru_film_search_form_vc_map() {
            vc_map(
                array(
                    'base'        => 'haru_film_search_form',
                    'name'        => esc_html__( 'Haru Film Search Form', 'haru-circle' ),
                    'icon'        => 'fa fa-user-secret haru-vc-icon',
                    'description' => esc_html__( 'Display our Film Search Form', 'haru-circle' ),
                    'category'    => HARU_CIRCLE_CORE_SHORTCODE_CATEGORY,
                    'params'      => array(
                        array(
                            'param_name'       => 'layout_type',
                            'type'             => 'dropdown',
                            'heading'          => esc_html__( 'Layout Style', 'haru-circle' ),
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            'admin_label'      => true,
                            'value'            => array(
                                esc_html__( 'Default', 'haru-circle' ) => 'search-form-ajax',
                            ),
                        ),
                        array(
                            'param_name'       => 'columns',
                            'type'             => 'dropdown',
                            'heading'          => esc_html__( 'Columns', 'haru-circle' ),
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            'value'            => array(
                                esc_html__( '2 Columns', 'haru-circle' ) => '2',
                                esc_html__( '3 Columns', 'haru-circle' ) => '3',
                                esc_html__( '4 Columns', 'haru-circle' ) => '4',
                                esc_html__( '5 Columns', 'haru-circle' ) => '5'
                            )
                        ),
                        array(
                            'param_name'       => 'film_style',
                            'type'             => 'dropdown',
                            'heading'          => esc_html__( 'Film Style', 'haru-circle' ),
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            'admin_label'      => true,
                            'value'            => array(
                                esc_html__( 'Style 1', 'haru-circle' ) => 'style_1',
                                esc_html__( 'Style 2', 'haru-circle' ) => 'style_2',
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

    new Haru_Framework_Shortcode_Film_Search_Form();
}
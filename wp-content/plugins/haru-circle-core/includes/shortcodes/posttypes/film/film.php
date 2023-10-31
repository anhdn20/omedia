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

if ( ! class_exists('Haru_Framework_Shortcode_Film') ) {
    class Haru_Framework_Shortcode_Film {
        function __construct() {
            add_shortcode('haru_film', array($this, 'haru_film_shortcode' ));
            add_action( 'vc_before_init', array($this, 'haru_film_vc_map') );
            $this->haru_includes();
        }

        private function haru_includes() {
            include_once( 'utils/functions.php' );
        }

        function haru_film_shortcode($atts) {
            $atts        = vc_map_get_attributes( 'haru_film', $atts );
            $data_source = $category = $film_ids = $layout_type = $columns = $film_style = $filter = $filter_style = $filter_align = $posts_per_page = $paging_style = $orderby = $order = $el_class = $haru_animation = $css_animation = $duration = $delay = $styles_animation = '';
            extract(shortcode_atts(array(
                'data_source'    => '',
                'category'       => '',
                'film_ids'       => '',
                'layout_type'    => 'grid',
                'columns'        => '2',
                'film_style'     => 'style_1',
                'filter'         => 'show',
                'filter_style'   => 'style_1',
                'filter_align'   => 'align_left',
                'posts_per_page' => '6',
                'paging_style'   => 'none',
                'orderby'        => 'date',
                'order'          => 'DESC',
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

        function haru_film_vc_map() {
            vc_map(
                array(
                    'base'        => 'haru_film',
                    'name'        => esc_html__( 'Haru Film', 'haru-circle' ),
                    'icon'        => 'fa fa-user-secret haru-vc-icon',
                    'description' => esc_html__( 'Display our films', 'haru-circle' ),
                    'category'    => HARU_CIRCLE_CORE_SHORTCODE_CATEGORY,
                    'params'      => array(
                        array(
                            'param_name'  => 'data_source',
                            'type'        => 'dropdown',
                            'heading'     => esc_html__( 'Source', 'haru-circle' ),
                            'admin_label' => true,
                            'value'       => array(
                                esc_html__( 'From Category', 'haru-circle' )   => '',
                                esc_html__( 'From Film IDs', 'haru-circle' ) => 'list_id'
                            )
                        ),
                        array(
                            'param_name'  => 'category',
                            'type'        => 'haru_film_categories',
                            'heading'     => esc_html__( 'Film Category', 'haru-circle' ),
                            'admin_label' => true,
                            'dependency'  => array(
                                'element' => 'data_source', 
                                'value'   => array('')
                            ),
                        ),
                        array(
                            'param_name' => 'film_ids',
                            'type'       => 'haru_film_list',
                            'heading'    => esc_html__( 'Select Film', 'haru-circle' ),
                            'dependency' => array(
                                'element' => 'data_source', 
                                'value'   => array('list_id')
                            )
                        ),
                        array(
                            'param_name'       => 'layout_type',
                            'type'             => 'dropdown',
                            'heading'          => esc_html__( 'Layout Style', 'haru-circle' ),
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            'admin_label'      => true,
                            'value'            => array(
                                esc_html__( 'Grid', 'haru-circle' )      => 'grid',
                                esc_html__( 'Masonry', 'haru-circle' )   => 'masonry',
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
                            ),
                            'dependency' => array(
                                'element' => 'layout_type', 
                                'value'   => array('grid','masonry', 'slideshow')
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
                            'param_name'       => 'filter',
                            'type'             => 'dropdown',
                            'heading'          => esc_html__( 'Filter Display', 'haru-circle' ),
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            'admin_label'      => true,
                            'value'            => array(
                                esc_html__( 'Show', 'haru-circle' ) => 'show',
                                esc_html__( 'Hide', 'haru-circle' ) => 'hide'
                            ),
                            'dependency' => array(
                                'element' => 'layout_type', 
                                'value'   => array('grid','masonry')
                            )
                        ),
                        array(
                            'param_name'       => 'filter_style',
                            'type'             => 'dropdown',
                            'heading'          => esc_html__( 'Filter Style', 'haru-circle' ),
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            'admin_label'      => true,
                            'value'            => array(
                                esc_html__( 'Style 1 (Background dark)', 'haru-circle' )  => 'style_1',
                                esc_html__( 'Style 2 (Background light)', 'haru-circle' ) => 'style_2'
                            ),
                            'dependency' => array(
                                'element' => 'filter', 
                                'value'   => array('show')
                            )
                        ),
                        array(
                            'param_name'       => 'filter_align',
                            'type'             => 'dropdown',
                            'heading'          => esc_html__( 'Filter Align', 'haru-circle' ),
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            'admin_label'      => true,
                            'value'            => array(
                                esc_html__( 'Left', 'haru-circle' )   => 'align_left',
                                esc_html__( 'Center', 'haru-circle' ) => 'align_center',
                                esc_html__( 'Right', 'haru-circle' )  => 'align_right'
                            ),
                            'dependency' => array(
                                'element' => 'filter', 
                                'value'   => array('show')
                            )
                        ),
                        array( 
                            'param_name'  => 'posts_per_page', 
                            'heading'     => esc_html__( 'Posts per page', 'haru-circle' ), 
                            'type'        => 'textfield', 
                            'admin_label' => true,
                            'description' => esc_html__( 'Number of films to show', 'haru-circle' ),
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                        ),
                        array(
                            'param_name' => 'paging_style',
                            'type'       => 'dropdown',
                            'heading'    => esc_html__( 'Pagination', 'haru-circle' ),
                            'value'      => array(
                                esc_html__( 'None', 'haru-circle' )               => 'none',
                                esc_html__( 'Page Number', 'haru-circle' )        => 'default',
                                esc_html__( 'Load More Button', 'haru-circle' )   => 'load-more',
                                esc_html__( 'Infinite Scrolling', 'haru-circle' ) => 'infinity-scroll',
                            ),
                            'description'      => esc_html__( 'Choose pagination type.', 'haru-circle' ),
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            'dependency' => array(
                                'element' => 'layout_type', 
                                'value'   => array('grid','masonry')
                            )
                        ),
                        array(
                            'param_name' => 'orderby',
                            'type'       => 'dropdown',
                            'heading'    => esc_html__( 'Order by', 'haru-circle' ),
                            'value'      => array(
                                esc_html__( 'Date', 'haru-circle' )                  => 'date',
                                esc_html__( 'Order by post ID', 'haru-circle' )      => 'ID',
                                esc_html__( 'Author', 'haru-circle' )                => 'author',
                                esc_html__( 'Title', 'haru-circle' )                 => 'title',
                                esc_html__( 'Last modified date', 'haru-circle' )    => 'modified',
                                esc_html__( 'Number of comments', 'haru-circle' )    => 'comment_count',
                                esc_html__( 'Random order', 'haru-circle' )          => 'rand',
                            ),
                            'description'        => esc_html__( 'Select order type.', 'haru-circle' ),
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                        ),
                        array(
                            'param_name' => 'order',
                            'type'       => 'dropdown',
                            'heading'    => esc_html__( 'Sort Order', 'haru-circle' ),
                            'value'      => array(
                                esc_html__( 'Descending', 'haru-circle' ) => 'DESC',
                                esc_html__( 'Ascending', 'haru-circle' )  => 'ASC',
                            ),
                            'description'        => esc_html__( 'Select sorting order.', 'haru-circle' ),
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

    new Haru_Framework_Shortcode_Film();
}
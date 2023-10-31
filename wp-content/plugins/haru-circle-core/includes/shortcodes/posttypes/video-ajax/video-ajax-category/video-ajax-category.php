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

if ( ! class_exists('Haru_Framework_Shortcode_Video_Ajax_Category') ) {
    class Haru_Framework_Shortcode_Video_Ajax_Category {
        function __construct() {
            add_shortcode('haru_video_ajax_category', array($this, 'haru_video_ajax_category_shortcode' ));
            add_action( 'vc_before_init', array($this, 'haru_video_ajax_category_vc_map') );
            $this->haru_includes();
        }

        private function haru_includes() {
            include_once( 'utils/ajax-action.php' );
        }

        function haru_video_ajax_category_shortcode($atts) {
            $atts        = vc_map_get_attributes( 'haru_video_ajax_category', $atts );
            $data_source = $categories = $layout_type = $columns = $video_style = $filter = $filter_style = $filter_align = $posts_per_page = $paging_style = $orderby = $order = $el_class = $haru_animation = $css_animation = $duration = $delay = $styles_animation = '';
            extract(shortcode_atts(array(
                'data_source'    => '',
                'categories'     => '',
                'layout_type'    => 'grid',
                'columns'        => '2',
                'video_style'    => 'style_1',
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
            <?php echo haru_get_template('posttypes/video-ajax/video-ajax-category/'. $layout_type . '.php', array('atts' => $atts), '', '' ); ?>
        </div>  

        <?php
            wp_reset_postdata();
            $content =  ob_get_clean();
            return $content;
        }

        function haru_video_ajax_category_vc_map() {
            vc_map(
                array(
                    'base'        => 'haru_video_ajax_category',
                    'name'        => esc_html__( 'Haru Videos Ajax Category', 'haru-circle' ),
                    'icon'        => 'fa fa-play-circle-o haru-vc-icon',
                    'description' => esc_html__( 'Display our videos work', 'haru-circle' ),
                    'category'    => HARU_CIRCLE_CORE_SHORTCODE_CATEGORY,
                    'params'      => array(
                        array(
                            'param_name'  => 'data_source',
                            'type'        => 'dropdown',
                            'heading'     => esc_html__( 'Source', 'haru-circle' ),
                            'admin_label' => true,
                            'value'       => array(
                                esc_html__( 'From Category', 'haru-circle' )   => '',
                            )
                        ),
                        array(
                            'param_name'  => 'categories',
                            'type'        => 'haru_video_categories',
                            'heading'     => esc_html__( 'Video Categories', 'haru-circle' ),
                            'admin_label' => true,
                            'dependency'  => array(
                                'element' => 'data_source', 
                                'value'   => array('')
                            ),
                        ),
                        array(
                            'param_name'       => 'layout_type',
                            'type'             => 'dropdown',
                            'heading'          => esc_html__( 'Layout Style', 'haru-circle' ),
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            'admin_label'      => true,
                            'value'            => array(
                                esc_html__( 'Grid', 'haru-circle' )         => 'grid',
                                // esc_html__( 'Masonry', 'haru-circle' )      => 'masonry',
                                // esc_html__( 'Special Grid', 'haru-circle' ) => 'grid_special'
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
                                'value'   => array('grid','masonry')
                            )
                        ),
                        array(
                            'param_name'       => 'video_style',
                            'type'             => 'dropdown',
                            'heading'          => esc_html__( 'Video Style', 'haru-circle' ),
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            'admin_label'      => true,
                            'value'            => array(
                                esc_html__( 'Style 1', 'haru-circle' ) => 'style_1',
                                esc_html__( 'Style 2', 'haru-circle' ) => 'style_2',
                                esc_html__( 'Style 3', 'haru-circle' ) => 'style_3',
                            ),
                        ),
                        array(
                            'param_name'       => 'filter_style',
                            'type'             => 'dropdown',
                            'heading'          => esc_html__( 'Filter Style', 'haru-circle' ),
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            'admin_label'      => true,
                            'value'            => array(
                                esc_html__( 'Style 1', 'haru-circle' ) => 'style_1',
                                esc_html__( 'Style 2', 'haru-circle' ) => 'style_2'
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
                            )
                        ),
                        array( 
                            'param_name'  => 'posts_per_page', 
                            'heading'     => esc_html__( 'Posts per page', 'haru-circle' ), 
                            'type'        => 'textfield', 
                            'admin_label' => true,
                            'description' => esc_html__( 'Number of videos to show', 'haru-circle' ),
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                        ),
                        array(
                            'param_name' => 'paging_style',
                            'type'       => 'dropdown',
                            'heading'    => esc_html__( 'Pagination', 'haru-circle' ),
                            'value'      => array(
                                esc_html__( 'None', 'haru-circle' )               => 'none',
                                esc_html__( 'Load More Button', 'haru-circle' )   => 'load-more',
                            ),
                            'description'      => esc_html__( 'Choose pagination type.', 'haru-circle' ),
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
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
                                esc_html__( 'Post/page parent ID', 'haru-circle' )   => 'parent',
                                esc_html__( 'Number of comments', 'haru-circle' )    => 'comment_count',
                                esc_html__( 'Random order', 'haru-circle' )          => 'rand',
                            ),
                            'description'      => esc_html__( 'Select order type.', 'haru-circle' ),
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

    new Haru_Framework_Shortcode_Video_Ajax_Category();
}
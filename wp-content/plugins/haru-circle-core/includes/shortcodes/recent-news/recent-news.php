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

if ( ! class_exists('Haru_Framework_Shortcode_Recent_News') ) {
    class Haru_Framework_Shortcode_Recent_News {
        function __construct() {
            add_shortcode( 'haru_recent_news', array( $this, 'haru_recent_news_shortcode' ));
            add_action( 'vc_before_init', array($this, 'haru_recent_news_vc_map') );
        }

        function haru_recent_news_shortcode($atts) {
            $atts        = vc_map_get_attributes( 'haru_recent_news', $atts );
            $layout_type = $data_source = $category = $post_ids = $columns = $autoplay = $slide_duration = $excerpt_length = $posts_per_page = $orderby = $order
             = $el_class = $haru_animation = $css_animation = $duration = $delay = $styles_animation = '';
            extract(shortcode_atts(array( 
                'layout_type'    => 'carousel',
                'data_source'    => '',
                'category'       => '',
                'post_ids'      => '',
                'columns'        => '1 ',
                'autoplay'       => 'true',
                'slide_duration' => '6000',
                'excerpt_length' => '20',
                'posts_per_page' => '',
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
        <div class="<?php echo esc_attr($haru_animation . ' ' . $styles_animation); ?>">
            <?php echo haru_get_template('recent-news/'. $layout_type . '.php', array('atts' => $atts), '', '' ); ?>
        </div>
        <?php
            wp_reset_query();
            $content =  ob_get_clean();

            return $content;
        }

        function haru_recent_news_vc_map() {
            vc_map(
                array(
                    'name'        => esc_html__( 'Haru Recent News', 'haru-circle' ),
                    'base'        => 'haru_recent_news',
                    'icon'        => 'fa fa-bookmark haru-vc-icon',
                    'description' => esc_html__( 'Display latest post or selected post', 'haru-circle' ),
                    'category'    => HARU_CIRCLE_CORE_SHORTCODE_CATEGORY,
                    'params'      => array(
                        array(
                            'param_name'  => 'layout_type',
                            'heading'     => esc_html__( 'Choose layout', 'haru-circle' ),
                            'description' => '',
                            'type'        => 'dropdown',
                            'value'       => array(
                                esc_html__( 'Carousel (Home 1)', 'haru-circle' ) => 'carousel',
                                esc_html__( 'Carousel (Home 2)', 'haru-circle' ) => 'carousel_2',
                                esc_html__( 'Carousel (Home 9, 10)', 'haru-circle' ) => 'carousel_3',
                            )
                        ),
                        array(
                            'type'        => 'dropdown',
                            'heading'     => esc_html__( 'Source', 'haru-circle' ),
                            'param_name'  => 'data_source',
                            'admin_label' => true,
                            'value'       => array(
                                esc_html__( 'From Category', 'haru-circle' ) => '',
                                esc_html__( 'From Post IDs', 'haru-circle' ) => 'list_id'
                            )
                        ),
                        array(
                            'type'        => 'haru_post_categories',
                            'heading'     => esc_html__( 'Select Categories', 'haru-circle' ),
                            'param_name'  => 'category',
                            'admin_label' => true,
                            'dependency'  => array(
                                'element' => 'data_source', 
                                'value'   => array('')
                            ),
                        ),
                        array(
                            'type'       => 'haru_post_list',
                            'heading'    => esc_html__( 'Select Post', 'haru-circle' ),
                            'param_name' => 'post_ids',
                            'dependency' => array(
                                'element' => 'data_source', 
                                'value'   => array('list_id')
                            )
                        ),
                        array(
                            'param_name'  => 'columns', 
                            'heading'     => esc_html__( 'Number of Columns', 'haru-circle' ), 
                            'type'        => 'dropdown', 
                            'admin_label' => true, 
                            'value'       => array(
                                esc_html__( '1', 'haru_circle' ) => '1',
                                esc_html__( '2', 'haru-circle' ) => '2',
                                esc_html__( '3', 'haru-circle' ) => '3', 
                                esc_html__( '4', 'haru-circle' ) => '4', 
                                esc_html__( '5', 'haru-circle' ) => '5', 
                            ), 
                            'dependency' => array(
                                'element'   => 'layout_type',
                                'value'     => array( 'carousel', 'carousel_2', 'carousel_3' )
                            )
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
                            'dependency'  => array(
                                'element'   => 'layout_type',
                                'value'     => array( 'carousel', 'carousel_2', 'carousel_3' )
                            )
                        ),
                        array(
                            'type'             => 'textfield',
                            'heading'          => esc_html__( 'Slide Duration (ms)', 'haru-circle' ),
                            'param_name'       => 'slide_duration',
                            'std'              => '6000',
                            'admin_label'      => true,
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            'dependency'  => array(
                                'element'   => 'layout_type',
                                'value'     => array( 'carousel', 'carousel_2', 'carousel_3' )
                            )
                        ),
                        array( 
                            'param_name'  => 'posts_per_page', 
                            'heading'     => esc_html__( 'Posts per page', 'haru-circle' ), 
                            'type'        => 'textfield',
                            'admin_label' => true,
                            'dependency'  => array(
                                'element'   => 'layout_type',
                                'value'     => array( 'carousel', 'carousel_2', 'carousel_3' )
                            )
                        ),
                        array(
                            'param_name'  => 'excerpt_length',
                            'heading'     => esc_html__( 'Excerpt Length', 'haru-circle' ),
                            'description' => esc_html__( 'Insert number of words to show in excerpt.', 'haru-circle' ),
                            'type'        => 'textfield',
                            'value'       => '',
                            'admin_label' => true,
                        ),
                        // Data settings  
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
                            'description'        => esc_html__( 'Select order type.', 'haru-circle' ),
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

    new Haru_Framework_Shortcode_Recent_News();
}
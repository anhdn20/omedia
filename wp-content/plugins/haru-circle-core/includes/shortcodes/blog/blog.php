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

if ( ! class_exists('Haru_Framework_Shortcode_Blog') ) {
    class Haru_Framework_Shortcode_Blog {
        function __construct() {
            add_shortcode( 'haru_blog', array( $this, 'haru_blog_shortcode' ) );
            add_action( 'vc_before_init', array($this, 'haru_blog_vc_map') );
            $this->haru_includes();
        }

        private function haru_includes() {
            include_once( 'utils/functions.php' );
        }

        function haru_blog_shortcode($atts) {
            $atts = vc_map_get_attributes( 'haru_blog', $atts );
            $layout_type = $columns = $category = $post_ids = $posts_per_page = $excerpt_length = $paging_style = $orderby = $order = $meta_key = $el_class = $haru_animation = $css_animation = $duration = $delay = $styles_animation = '';
            extract(shortcode_atts(array(
                'layout_type'    => 'grid',
                'columns'        => '2',
                'category'       => '',
                'post_ids'      => '',
                'posts_per_page' => '',
                'excerpt_length' => '15',
                'paging_style'   => 'default',
                'paging_align'   => 'left',
                'orderby'        => 'date',
                'order'          => 'DESC',
                'el_class'       => '',
                'css_animation'  => '',
                'duration'       => '',
                'delay'          => ''
            ), $atts));

            $haru_animation   = HARU_CircleCore_Shortcodes::haru_get_css_animation($css_animation);
            $styles_animation = HARU_CircleCore_Shortcodes::haru_get_style_animation($duration, $delay);

            ob_start();
            ?>
            <div class="<?php echo esc_attr($haru_animation . ' ' . $styles_animation); ?>">
                <?php echo haru_get_template('blog/'. $layout_type . '.php', array('atts' => $atts), '', '' ); ?>
            </div>
            <?php
            wp_reset_query();
            $content =  ob_get_clean();

            return $content;
        }

        function haru_blog_vc_map() {
            vc_map(
                array(
                    'name'        => esc_html__( 'Haru Blog', 'haru-circle' ),
                    'base'        => 'haru_blog',
                    'icon'        => 'fa fa-file-text haru-vc-icon',
                    'category'    => HARU_CIRCLE_CORE_SHORTCODE_CATEGORY,
                    'description' => esc_html__( 'Display post as grid', 'haru-circle' ),
                    'params'      => array(
                        array(
                            'param_name' => 'layout_type',
                            'type'       => 'dropdown',
                            'heading'    => esc_html__( 'Layout Style', 'haru-circle' ),
                            'description'=> esc_html__( 'Choose layout style from drop down list styles.', 'haru-circle' ),
                            'value'      => array(
                                esc_html__( 'Masonry', 'haru-circle' )                => 'masonry',
                            ),
                            'admin_label' => true,
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                        ),
                        array(
                            'param_name' => 'columns',
                            'type'       => 'dropdown',
                            'heading'    => esc_html__( 'Columns', 'haru-circle' ),
                            'value'      => array(
                                esc_html__( '2 columns', 'haru-circle' ) => '2',
                                esc_html__( '3 columns', 'haru-circle' ) => '3',
                                esc_html__( '4 columns', 'haru-circle' ) => '4',
                                esc_html__( '5 columns', 'haru-circle' ) => '5',
                            ),
                            'dependency'  => array(
                                'element' => 'type',
                                'value'   => array('grid', 'masonry')
                            ),
                            'admin_label' => true,
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                        ),
                        array(
                            'param_name' => 'category',
                            'type'       => 'haru_post_categories',
                            'heading'    => esc_html__( 'Select Categories', 'haru-circle' ),
                            'description'=> esc_html__( 'Select categories to display post on your page.', 'haru-circle' ),
                            'admin_label' => true,
                        ),
                        array(
                            'type'       => 'haru_post_list_single',
                            'heading'    => esc_html__( 'Featured Post', 'haru-circle' ),
                            'param_name' => 'post_id',
                            'admin_label' => true,
                        ),
                        array( 
                            'param_name'  => 'posts_per_page', 
                            'heading'     => esc_html__( 'Posts per page', 'haru-circle' ), 
                            'type'        => 'textfield',
                            'admin_label' => true
                        ),
                        array(
                            'param_name'  => 'excerpt_length',
                            'heading'     => esc_html__( 'Excerpt Length', 'haru-circle' ),
                            'description' => esc_html__( 'Insert number of words to show in excerpt.', 'haru-circle' ),
                            'type'        => 'textfield',
                            'value'       => '',
                            'admin_label' => true,
                        ),

                        array(
                            'param_name' => 'paging_style',
                            'type'       => 'dropdown',
                            'heading'    => esc_html__( 'Paging Style', 'haru-circle' ),
                            'value'      => array(
                                esc_html__( 'Default', 'haru-circle' )         => 'default',
                                esc_html__( 'Load More', 'haru-circle' )       => 'load-more',
                                esc_html__( 'Infinity Scroll', 'haru-circle' ) => 'infinity-scroll',
                            ),
                            'std'              => 'default'
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

    new Haru_Framework_Shortcode_Blog();
}
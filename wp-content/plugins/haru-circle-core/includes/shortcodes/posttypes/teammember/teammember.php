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

if ( ! class_exists('Haru_Framework_Shortcode_Teammember') ) {
    class Haru_Framework_Shortcode_Teammember {
        function __construct() {
            add_shortcode('haru_teammember', array($this, 'haru_teammember_shortcode' ));
            add_action( 'vc_before_init', array($this, 'haru_teammember_vc_map') );
        }

        function haru_teammember_shortcode($atts) {
            $atts        = vc_map_get_attributes( 'haru_teammember', $atts );
            $data_source = $category = $member_ids = $layout_type = $columns = $viewmore = $link = $title = $description = $posts_per_page = $orderby = $order = $el_class = $haru_animation = $css_animation = $duration = $delay = $styles_animation = '';
            extract(shortcode_atts(array(
                'data_source'    => '',
                'category'       => '',
                'member_ids'     => '',
                'layout_type'    => 'grid',
                'columns'        => '2',
                'viewmore'       => 'show',
                'link'           => '',
                'title'          => '',
                'description'    => '',
                'posts_per_page' => '5',
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
            <?php echo haru_get_template('posttypes/teammember/'. $layout_type . '.php', array('atts' => $atts), '', '' ); ?>
        </div>  

        <?php
            wp_reset_query();
            $content =  ob_get_clean();
            return $content;
        }

        function haru_teammember_vc_map() {
            vc_map(
                array(
                    'base'        => 'haru_teammember',
                    'name'        => esc_html__( 'Haru Team Member', 'haru-circle' ),
                    'icon'        => 'fa fa-users haru-vc-icon',
                    'description' => esc_html__( 'Display our team member', 'haru-circle' ),
                    'category'    => HARU_CIRCLE_CORE_SHORTCODE_CATEGORY,
                    'params'      => array(
                        array(
                            'param_name'  => 'data_source',
                            'type'        => 'dropdown',
                            'heading'     => esc_html__( 'Source', 'haru-circle' ),
                            'admin_label' => true,
                            'value'       => array(
                                esc_html__( 'From Category', 'haru-circle' )   => '',
                                esc_html__( 'From Member IDs', 'haru-circle' ) => 'list_id'
                            )
                        ),
                        array(
                            'param_name'  => 'category',
                            'type'        => 'haru_teammember_categories',
                            'heading'     => esc_html__( 'Teammember Category', 'haru-circle' ),
                            'admin_label' => true,
                            'dependency'  => array(
                                'element' => 'data_source', 
                                'value'   => array('')
                            ),
                        ),
                        array(
                            'param_name' => 'member_ids',
                            'type'       => 'haru_teammember_list',
                            'heading'    => esc_html__( 'Select Teammember', 'haru-circle' ),
                            'dependency' => array(
                                'element' => 'data_source', 
                                'value'   => array('list_id')
                            )
                        ),
                        array(
                            'param_name'       => 'layout_type',
                            'type'             => 'dropdown',
                            'heading'          => esc_html__( 'Layout Style', 'haru-circle' ),
                            'value'            => array(
                                esc_html__( 'Grid (4 Columns width Title)', 'haru-circle' ) => 'grid',
                                esc_html__( 'Grid (2 Columns)', 'haru-circle' )             => 'grid_2',
                                esc_html__( 'Grid (About Us)', 'haru-circle' )              => 'grid_3'
                            ),
                            'admin_label' => true,
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                        ),
                        array(
                            'param_name'  => 'columns',
                            'type'        => 'dropdown',
                            'heading'     => esc_html__( 'Columns', 'haru-circle' ),
                            'admin_label' => true,
                            'value'       => array(
                                '2 Columns' => '2',
                                '3 Columns' => '3',
                                '4 Columns' => '4',
                                '5 Columns' => '5',
                                '6 Columns' => '6',
                            ),
                            'description'      => esc_html__( 'Number of Columns', 'haru-circle' ),
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            'dependency'       => array(
                                'element' => 'layout_type', 
                                'value'   => array('grid_3')
                            )
                        ),
                        array(
                            'param_name' => 'viewmore',
                            'type'       => 'dropdown',
                            'heading'    => esc_html__( 'View More', 'haru-circle' ),
                            'value'      => array(
                                esc_html__( 'Show', 'haru-circle' ) => 'show',
                                esc_html__( 'Hide', 'haru-circle' ) => 'hide'
                            ),
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            'dependency'       => array(
                                'element' => 'layout_type', 
                                'value'   => array('grid')
                            )
                        ),
                        array(
                            'param_name'       => 'link',
                            'type'             => 'vc_link',
                            'heading'          => esc_html__( 'Link', 'haru-circle' ),
                            'description'      => esc_html__( 'Set link of viewmore button.', 'haru-circle' ),
                            'admin_label'      => false,
                            'dependency'       => array(
                                'element' => 'viewmore', 
                                'value'   => array('show')
                            )
                        ),
                        array(
                            'type'        => 'textfield',
                            'heading'     => esc_html__( 'Title', 'haru-circle' ),
                            'param_name'  => 'title',
                            'admin_label' => true,
                            'dependency'       => array(
                                'element' => 'layout_type', 
                                'value'   => array('grid')
                            )
                        ),
                        array(
                            'type'        => 'textarea',
                            'heading'     => esc_html__( 'Description', 'haru-circle' ),
                            'param_name'  => 'description',
                            'admin_label' => false,
                            'dependency'       => array(
                                'element' => 'layout_type', 
                                'value'   => array('grid')
                            )
                        ),
                        array( 
                            'param_name'  => 'posts_per_page', 
                            'heading'     => esc_html__( 'Posts per page', 'haru-circle' ), 
                            'type'        => 'textfield', 
                            'admin_label' => true,
                            'description' => esc_html__( 'Number of member to show', 'haru-circle' ),
                            'dependency'  => array(
                                'element' => 'layout_type', 
                                'value'   => array('grid','grid_2', 'grid_3')
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

    new Haru_Framework_Shortcode_Teammember();
}
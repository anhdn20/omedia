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

if ( ! class_exists('Haru_Framework_Shortcode_Portfolio') ) {
    class Haru_Framework_Shortcode_Portfolio {
        function __construct() {
            add_shortcode( 'haru_portfolio', array( $this, 'haru_portfolio_shortcode' ) );
            add_action( 'vc_before_init', array($this, 'haru_portfolio_vc_map') );

            $this->includes();
        }

        private function includes() {
            include_once( 'utils/ajax-action.php' );
            include_once( 'utils/image-resize.php' );
        }

        function haru_portfolio_shortcode($atts) {
            $atts        = vc_map_get_attributes( 'haru_portfolio', $atts );
            $portfolio_thumbnail = $portfolio_title = $hover_style = $overlay_effect = $column = $data_source = $category = $portfolio_ids = $portfolio_tag = $show_filter = $filter_by = $filter_style = $show_pagging = $item = $order = $padding = $image_size
              = $current_page = $el_class = $haru_animation = $css_animation = $duration = $delay = $styles_animation = '';
            extract(shortcode_atts(array(
                'portfolio_thumbnail' => 'default',
                'portfolio_title'     => '',
                'column'              => '4',
                'hover_style'       => 'icon',
                'overlay_effect'      => 'effect_1',
                'data_source'         => '',
                'category'            => '',
                'portfolio_ids'       => '',
                'portfolio_tag'       => '',
                'show_filter'         => '',
                'filter_by'           => 'tag',
                'filter_style'        => 'filter-isotope',
                'show_pagging'        => '',
                'item'                => '4',// number of item
                'order'               => 'DESC',
                'padding'             => '',
                'image_size'          => '',
                'el_class'            => '',
                'css_animation'       => '',
                'duration'            => '',
                'delay'               => '',               
                'current_page'        => '1'
            ), $atts));

            $haru_animation   = HARU_CircleCore_Shortcodes::haru_get_css_animation($css_animation);
            $styles_animation = HARU_CircleCore_Shortcodes::haru_get_style_animation($duration, $delay);

            ob_start();
            ?>

            <div class="<?php echo esc_attr( $haru_animation . ' ' . $styles_animation ); ?>">
                <?php echo haru_get_template('posttypes/portfolio/' . $portfolio_thumbnail . '.php', array('atts' => $atts), '', '' ); ?>
            </div>

            <?php
            wp_reset_query();
            $content =  ob_get_clean();

            return $content;
        }

        function haru_portfolio_vc_map() {
            vc_map(
                array(
                    'base'        => 'haru_portfolio',
                    'name'        => esc_html__( 'Haru Portfolio', 'haru-portfolio' ),
                    'icon'        => 'fa fa-th-large haru-vc-icon',
                    'description' => esc_html__( 'Display Portfolio projects', 'haru-portfolio' ),
                    'category'    => HARU_CIRCLE_CORE_SHORTCODE_CATEGORY,
                    'params'      => array(
                        array(
                            'param_name'  => 'portfolio_thumbnail',
                            'type'        => 'dropdown',
                            'heading'     => esc_html__( 'Thumbnail type', 'haru-portfolio' ),
                            'admin_label' => true,
                            'value'       => array(
                                esc_html__( 'Default (Original size)', 'haru-portfolio' )                      => 'default',
                                esc_html__( 'Masonry', 'haru-portfolio' )                                      => 'masonry',
                                esc_html__( 'Squared (1x1)', 'haru-portfolio' )                                => 'squared',
                                esc_html__( 'Landscape (2x1)', 'haru-portfolio' )                              => 'landscape',
                                esc_html__( 'Portrait (1x2)', 'haru-portfolio' )                               => 'portrait',
                                esc_html__( 'Packery (Thumbnail size set in item setting)', 'haru-portfolio' ) => 'packery'
                            ),
                            'std'              => 'default'                     
                        ),
                        array(
                            'param_name'  => 'portfolio_title',
                            'type'        => 'dropdown',
                            'heading'     => esc_html__( 'Portfolio Title', 'haru-portfolio' ),
                            'admin_label' => true,
                            'value'       => array(
                                esc_html__( 'None', 'haru-portfolio' )           => '',
                                esc_html__( 'Show in Top', 'haru-portfolio' )    => 'top',
                                esc_html__( 'Show in Bottom', 'haru-portfolio' ) => 'bottom'
                            ),
                            'std'              => ''
                        ),
                        array(
                            'param_name'  => 'hover_style',
                            'type'        => 'dropdown',
                            'heading'     => esc_html__( 'Hover Style', 'haru-portfolio' ),
                            'admin_label' => true,
                            'value'       => array(
                                esc_html__( 'Icon', 'haru-portfolio' )                                         => 'icon',
                                esc_html__( 'Icon and Title', 'haru-portfolio' )                               => 'icon-title',
                                esc_html__( 'Icon, Title and Category', 'haru-portfolio' )                     => 'icon-title-category',
                                esc_html__( 'Title and Category', 'haru-portfolio' )                           => 'title-category',
                                esc_html__( 'Title', 'haru-portfolio' )                                        => 'title',
                            ),
                            'edit_field_class' => 'vc_col-sm-6 vc_column',
                        ),
                        array(
                            'param_name' => 'column',
                            'type'       => 'dropdown',
                            'heading'    => esc_html__( 'Columns', 'haru-portfolio' ),
                            'value'      => array(
                                esc_html__( '2 columns', 'haru-portfolio' ) => '2',
                                esc_html__( '3 columns', 'haru-portfolio' ) => '3',
                                esc_html__( '4 columns', 'haru-portfolio' ) => '4',
                                esc_html__( '5 columns', 'haru-portfolio' ) => '5',
                                esc_html__( '6 columns', 'haru-portfolio' ) => '6',
                            ),
                            'std'              => '4',
                            'edit_field_class' => 'vc_col-sm-6 vc_column',
                        ),
                        array(
                            'param_name'  => 'data_source',
                            'type'        => 'dropdown',
                            'heading'     => esc_html__( 'Source', 'haru-portfolio' ),
                            'admin_label' => true,
                            'value'       => array(
                                esc_html__( 'From Category', 'haru-portfolio' )      => '',
                                esc_html__( 'From Tag', 'haru-portfolio' )           => 'tag',
                                esc_html__( 'From Portfolio IDs', 'haru-portfolio' ) => 'list_id'
                            ),
                            'std' => ''
                        ),
                        array(
                            'type'        => 'haru_portfolio_categories',
                            'heading'     => esc_html__( 'Portfolio Category', 'haru-portfolio' ),
                            'param_name'  => 'category',
                            'admin_label' => true,
                            'dependency'  => array(
                                'element' => 'data_source', 
                                'value'   => array('')
                            ),
                        ),
                        array(
                            'param_name' => 'portfolio_ids',
                            'type'       => 'haru_portfolio_list',
                            'heading'    => esc_html__( 'Select Portfolio', 'haru-portfolio' ),
                            'dependency' => array(
                                'element' => 'data_source', 
                                'value'   => array('list_id')
                            )
                        ),
                        
                        array(
                            'param_name'  => 'portfolio_tag',
                            'type'        => 'haru_portfolio_tags',
                            'heading'     => esc_html__( 'Portfolio Tags', 'haru-portfolio' ),
                            'admin_label' => true,
                            'dependency' => array(
                                'element' => 'data_source',
                                'value'   => array('tag')
                            )
                        ),
                        array(
                            'param_name'  => 'show_filter',
                            'type'        => 'dropdown',
                            'heading'     => esc_html__( 'Show Filter', 'haru-portfolio' ),
                            'admin_label' => true,
                            'value'       => array(
                                esc_html__( 'None', 'haru-portfolio' )           => '',
                                esc_html__( 'Show in left', 'haru-portfolio' )   => 'left',
                                esc_html__( 'Show in center', 'haru-portfolio' ) => 'center',
                                esc_html__( 'Show in right', 'haru-portfolio' )  => 'right'
                            ),
                            'std'         => '',
                            'edit_field_class' => 'vc_col-sm-6 vc_column',
                        ),
                        array(
                            'param_name'  => 'filter_by',
                            'type'        => 'dropdown',
                            'heading'     => esc_html__( 'Filter By (Filter at front-end)', 'haru-portfolio' ),
                            'admin_label' => true,
                            'value'       => array(
                                esc_html__( 'Tag', 'haru-portfolio' )      => 'tag',
                                esc_html__( 'Category', 'haru-portfolio' ) => 'category'
                            ),
                            'std'              => 'tag',
                            'edit_field_class' => 'vc_col-sm-6 vc_column',
                        ),
                        array(
                            'param_name'  => 'filter_style',
                            'type'        => 'dropdown',
                            'heading'     => esc_html__( 'Filter Style', 'haru-portfolio' ),
                            'admin_label' => true,
                            'value'       => array(
                                esc_html__( 'Isotope', 'haru-portfolio' )   => 'filter-isotope',
                                esc_html__( 'Ajax', 'haru-portfolio' )      => 'filter-ajax'
                            ),
                            'std'              => 'filter-isotope',
                            'edit_field_class' => 'vc_col-sm-6 vc_column',
                        ),
                        array(
                            'param_name' => 'show_pagging',
                            'type'       => 'dropdown',
                            'heading'    => esc_html__( 'Show Paging', 'haru-portfolio' ),
                            'value' => array(
                                esc_html__( 'None', 'haru-portfolio' )      => '', 
                                esc_html__( 'Load more', 'haru-portfolio' ) => '1'
                            ),
                            'std'              => '',
                            'edit_field_class' => 'vc_col-sm-6 vc_column',
                        ),
                        array(
                            'param_name' => 'item',
                            'type'       => 'textfield',
                            'heading'    => esc_html__( 'Number of item (or number of item per page if choose show paging)', 'haru-portfolio' ),
                            'value'      => '4',
                        ),
                        array(
                            'param_name' => 'order',
                            'type'       => 'dropdown',
                            'heading'    => esc_html__( 'Order Post Date By', 'haru-portfolio' ),
                            'value'      => array(
                                esc_html__('Descending', 'haru-portfolio') => 'DESC', 
                                esc_html__('Ascending', 'haru-portfolio')  => 'ASC'
                            ),
                            'edit_field_class' => 'vc_col-sm-6 vc_column',
                        ),
                        array(
                            'param_name' => 'padding',
                            'type'       => 'dropdown',
                            'heading'    => esc_html__( 'Padding', 'haru-portfolio' ),
                            'value'      => array(
                                esc_html__( 'No padding', 'haru-portfolio' ) => '', 
                                esc_html__( '5px', 'haru-portfolio' )       => 'col-padding-5', 
                                esc_html__( '10px', 'haru-portfolio' )      => 'col-padding-10', 
                                esc_html__( '15px', 'haru-portfolio' )      => 'col-padding-15',
                                esc_html__( '20px', 'haru-portfolio' )      => 'col-padding-20',
                            ),
                            'std' => '',
                            'edit_field_class' => 'vc_col-sm-6 vc_column',
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

    new Haru_Framework_Shortcode_Portfolio();
}
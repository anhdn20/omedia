<?php
/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

defined( 'ABSPATH' ) || exit;

class Haru_Film_Categories_Widget extends Haru_Widget {

    /**
     * Category ancestors.
     *
     * @var array
     */
    public $cat_ancestors;

    /**
     * Current Category.
     *
     * @var bool
     */
    public $current_cat;

    /**
     * Constructor.
     */

    public function __construct() {
        $this->widget_cssclass    = 'widget-film-categories';
        $this->widget_description = esc_html__( 'Widget display film categories.', 'haru-circle' );
        $this->widget_id          = 'haru_widget_film_categories';
        $this->widget_name        = esc_html__( 'Haru Film Categories', 'haru-circle' );
        $this->cached             = false;
        $this->settings = array(
            'title'         => array(
                'type'  => 'text',
                'std'   =>'',
                'label' => esc_html__( 'Title', 'haru-circle' )
            ),
            'style'         => array(
                'type'    => 'select',
                'std'     => 'default',
                'label'   => esc_html__( 'Style', 'haru-circle' ),
                'options' => array(
                    'default' => esc_html__( 'Default', 'haru-circle' ),
                )
            ),
            'orderby'       => array(
                'type'    => 'select',
                'std'     => 'title',
                'label'   => esc_html__( 'Order by', 'haru-circle' ),
                'options' => array(
                    'name'   => esc_html__( 'Name', 'haru-circle' ),
                )
            ),
            'count'         => array(
                'type'  => 'checkbox',
                'std'   => 0,
                'label' => esc_html__( 'Show film counts', 'haru-circle' )
            ),
            'hierarchical'      => array(
                'type'  => 'checkbox',
                'std'   => 0,
                'label' => esc_html__( 'Show hierarchy', 'haru-circle' )
            ),
            'show_children_only' => array(
                'type'  => 'checkbox',
                'std'   => 0,
                'label' => esc_html__( 'Only show children of the current category', 'haru-circle' ),
            ),
            'hide_empty'         => array(
                'type'  => 'checkbox',
                'std'   => 0,
                'label' => esc_html__( 'Hide empty categories', 'haru-circle' ),
            ),
            'max_depth'          => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__( 'Maximum depth', 'haru-circle' ),
            ),
        );

        parent::__construct();
    }
    
    public function widget( $args, $instance ) {
        global $wp_query;

        ob_start();
        extract( $args );

        $title          = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
        $style          = isset( $instance['style'] ) ? $instance['style'] : $this->settings['style']['std'];
        $orderby        = isset( $instance['orderby'] ) ? $instance['orderby'] : $this->settings['orderby']['std'];
        $count          = isset( $instance['count'] ) ? $instance['count'] : $this->settings['count']['std'];
        $hierarchical   = isset( $instance['hierarchical'] ) ? $instance['hierarchical'] : $this->settings['hierarchical']['std'];
        $show_children_only = isset( $instance['show_children_only'] ) ? $instance['show_children_only'] : $this->settings['show_children_only']['std'];
        $hide_empty         = isset( $instance['hide_empty'] ) ? $instance['hide_empty'] : $this->settings['hide_empty']['std'];

        $list_args          = array(
            'show_count'   => $count,
            'hierarchical' => $hierarchical,
            'taxonomy'     => 'film_category',
            'hide_empty'   => $hide_empty,
        );
        $max_depth          = absint( isset( $instance['max_depth'] ) ? $instance['max_depth'] : $this->settings['max_depth']['std'] );

        $list_args['menu_order'] = false;
        $list_args['depth']      = $max_depth;

        if ( 'order' === $orderby ) {
            $list_args['orderby']      = 'meta_value_num';
            $list_args['meta_key']     = 'order';
        }
        
        $this->current_cat   = false;
        $this->cat_ancestors = array();

        if ( is_tax( 'film_category' ) ) {
            $this->current_cat   = $wp_query->queried_object;
            $this->cat_ancestors = get_ancestors( $this->current_cat->term_id, 'film_category' );

        } elseif ( is_singular( 'haru_film' ) ) {
            $terms = get_terms(
                'film_category',
                array(
                    'orderby' => 'parent',
                    'order'   => 'DESC',
                )
            );

            if ( $terms ) {
                $main_term           = $terms[1]; // $terms[0]
                $this->current_cat   = $main_term;
                $this->cat_ancestors = get_ancestors( $main_term->term_id, 'film_category' );
            }
        }

        // Show Siblings and Children Only.
        if ( $show_children_only && $this->current_cat ) {
            if ( $hierarchical ) {
                $include = array_merge(
                    $this->cat_ancestors,
                    array( $this->current_cat->term_id ),
                    get_terms(
                        'film_category',
                        array(
                            'fields'       => 'ids',
                            'parent'       => 0,
                            'hierarchical' => true,
                            'hide_empty'   => false,
                        )
                    ),
                    get_terms(
                        'film_category',
                        array(
                            'fields'       => 'ids',
                            'parent'       => $this->current_cat->term_id,
                            'hierarchical' => true,
                            'hide_empty'   => false,
                        )
                    )
                );
                // Gather siblings of ancestors.
                if ( $this->cat_ancestors ) {
                    foreach ( $this->cat_ancestors as $ancestor ) {
                        $include = array_merge(
                            $include,
                            get_terms(
                                'film_category',
                                array(
                                    'fields'       => 'ids',
                                    'parent'       => $ancestor,
                                    'hierarchical' => false,
                                    'hide_empty'   => false,
                                )
                            )
                        );
                    }
                }
            } else {
                // Direct children.
                $include = get_terms(
                    'film_category',
                    array(
                        'fields'       => 'ids',
                        'parent'       => $this->current_cat->term_id,
                        'hierarchical' => true,
                        'hide_empty'   => false,
                    )
                );
            }

            $list_args['include']     = implode( ',', $include );

            if ( empty( $include ) ) {
                return;
            }
        } elseif ( $show_children_only ) {
            $list_args['depth']            = 1;
            $list_args['child_of']         = 0;
            $list_args['hierarchical']     = 1;
        }

        include_once PLUGIN_HARU_CIRCLE_CORE_DIR . '/includes/circle/class-film-cat-list-walker.php';

        $list_args['walker']                     = new Haru_Circle_Film_Cat_List_Walker();
        $list_args['title_li']                   = '';
        $list_args['pad_counts']                 = 1;
        $list_args['show_option_none']           = esc_html__( 'No film categories exist.', 'haru-circle' );
        $list_args['current_category']           = ( $this->current_cat ) ? $this->current_cat->term_id : '';
        $list_args['current_category_ancestors'] = $this->cat_ancestors;
        $list_args['max_depth']                  = $max_depth;

        echo $before_widget;

            if ( $title ) echo $before_title . $title . $after_title;

            echo '<ul class="film-categories ' . esc_attr( $style ) . '">';

            wp_list_categories( $list_args );

            echo '</ul>';

        echo $after_widget;

        $content = ob_get_clean();
        echo $content;
    }
    
}
if ( !function_exists('haru_register_widget_film_categories') ) {
    function haru_register_widget_film_categories() {
        register_widget( 'Haru_Film_Categories_Widget' );
    }
    add_action( 'widgets_init', 'haru_register_widget_film_categories' );
}
<?php
/**
 *  Widget: Color Filter List
 *
 *  Note: This is a modified version of the "WooCommerce Layered Nav" widget
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Haru_WC_Widget_Color_Filter extends Haru_Widget {

    /**
     * Constructor
     */
    public function __construct() {
        $this->widget_cssclass    = 'haru_widget haru_widget_color_filter woocommerce widget_layered_nav';
        $this->widget_description = esc_html__( 'Shows "color" attributes in a widget which lets you narrow down the list of products when viewing products. ', 'haru-circle' );
        $this->widget_id          = 'haru_woocommerce_color_filter';
        $this->widget_name        = esc_html__( 'Haru WooCommerce Color Filter', 'haru-circle' );

        parent::__construct();
    }

    /**
     * update function.
     *
     * @see WP_Widget->update
     * @access public
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        if ( empty( $new_instance['title'] ) ) {
            $new_instance['title'] = esc_html__( 'Color', 'haru-circle' );
        }

        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['columns'] = strip_tags( $new_instance['columns'] );
        $instance['attribute'] = stripslashes( $new_instance['attribute'] );
        $instance['query_type'] = stripslashes( $new_instance['query_type'] );
        $instance['colors'] = $new_instance['colors'];

        return $instance;
    }

    /**
     * form function.
     *
     * @see WP_Widget->form
     * @access public
     * @param array $instance
     * @return void
     */
    public function form( $instance ) {
        $color_attribute_slug = apply_filters( 'haru_color_filter_slug', 'color' );
        
        $defaults = array(
            'title'         => '',
            'columns'       => '1',
            'attribute'     => $color_attribute_slug,
            'query_type'    => 'and',
            'colors'        => ''
        );

        $instance = wp_parse_args( (array) $instance, $defaults ); ?>

        <p>
            <label>
                <?php echo esc_html__( 'Title', 'haru-circle' ); ?><br />
                <input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
            </label>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'columns' ) ); ?>"><?php echo esc_html__( 'Columns', 'haru-circle' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'columns' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'columns' ) ); ?>">
                <option value="1" <?php selected( $instance['columns'], '1' ); ?>><?php echo '1'; ?></option>
                <option value="2" <?php selected( $instance['columns'], '2' ); ?>><?php echo '2'; ?></option>
                <option value="small-2" <?php selected( $instance['columns'], 'small-2' ); ?>><?php echo '2 - On smaller browser sizes'; ?></option>
            </select>
        </p>

        <input type="hidden" id="<?php echo esc_attr( $this->get_field_id( 'attribute' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'attribute' ) ); ?>" value="<?php echo esc_attr( $color_attribute_slug ); ?>">
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'query_type' ) ); ?>"><?php echo esc_html__( 'Query type', 'woocommerce' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'query_type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'query_type' ) ); ?>">
                <option value="and" <?php selected( $instance['query_type'], 'and' ); ?>><?php echo esc_html__( 'AND', 'woocommerce' ); ?></option>
                <option value="or" <?php selected( $instance['query_type'], 'or' ); ?>><?php echo esc_html__( 'OR', 'woocommerce' ); ?></option>
            </select>
        </p>
        <div class="haru-widget-attributes-table">
            <?php
                $terms = get_terms( 'pa_' . $instance['attribute'], array( 'hide_empty' => '0' ) );
                            
                if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                    $id = 'widget-' . $this->id . '-';
                    $name = 'widget-' . $this->id_base . '[' . $this->number . ']';
                    $values = $instance['colors'];
                    
                    $output = sprintf( '<table><tr><th>%s</th><th>%s</th></tr>', esc_html__( 'Term', 'haru-circle' ), esc_html__( 'Color', 'haru-circle' ) );
                    
                    
                    foreach ( $terms as $term ) {
                        $id = $id . $term->term_id;
                        
                        $output .= '<tr>
                            <td><label for="' . esc_attr( $id ) . '">' . esc_attr( $term->name ) . ' </label></td>
                            <td><input type="text" id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '[colors][' . esc_attr( $term->term_id ) . ']" value="' . ( isset( $values[$term->term_id] ) ? esc_attr( $values[$term->term_id] ) : '' ) . '" size="3" class="haru-widget-color-picker" /></td>
                        </tr>';
                    }
        
                    $output .= '</table>';
                    $output .= '<input type="hidden" name="' . esc_attr( $name ) . '[labels]" value="" />';
                } else {
                    $output = '<span>No product attribute saved with the <strong>"' . $color_attribute_slug . '"</strong> slug yet. <br />Click <a href="http://docs.nordicmade.com/savoy/#shop-color-widget" target="_blank">here</a> for more info.</span>';
                }
            
                echo $output;
            ?>
        </div>

        <input type="hidden" name="widget_id" value="widget-<?php echo esc_attr( $this->id ); ?>-" />
        <input type="hidden" name="widget_name" value="widget-<?php echo esc_attr( $this->id_base ); ?>[<?php echo esc_attr( $this->number ); ?>]" />
        <?php
    }

    /**
     * widget function.
     *
     * @see WP_Widget
     * @access public
     * @param array $args
     * @param array $instance
     * @return void
     */
    public function widget( $args, $instance ) {
        if ( ! is_post_type_archive( 'product' ) && ! is_tax( get_object_taxonomies( 'product' ) ) ) {
            return;
        }

        extract( $args );

        $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
        $title              = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);
        $taxonomy           = isset( $instance['attribute'] ) ? wc_attribute_taxonomy_name( $instance['attribute'] ) : $this->settings['attribute']['std'];
        $query_type         = isset( $instance['query_type'] ) ? $instance['query_type'] : $this->settings['query_type']['std'];
        $haru_args['columns'] = ( isset( $instance['columns'] ) ) ? $instance['columns'] : '1';
        $haru_args['colors'] = $instance['colors'];
        
        if ( ! taxonomy_exists( $taxonomy ) ) {
            return;
        }

        $get_terms_args = array( 'hide_empty' => '1' );

        $orderby = wc_attribute_orderby( $taxonomy );

        switch ( $orderby ) {
            case 'name' :
                $get_terms_args['orderby']    = 'name';
                $get_terms_args['menu_order'] = false;
            break;
            case 'id' :
                $get_terms_args['orderby']    = 'id';
                $get_terms_args['order']      = 'ASC';
                $get_terms_args['menu_order'] = false;
            break;
            case 'menu_order' :
                $get_terms_args['menu_order'] = 'ASC';
            break;
        }

        $terms = get_terms( $taxonomy, $get_terms_args );

        if ( 0 === sizeof( $terms ) ) {
            return;
        }
        
        switch ( $orderby ) {
            case 'name_num' :
                usort( $terms, '_wc_get_product_terms_name_num_usort_callback' );
            break;
            case 'parent' :
                usort( $terms, '_wc_get_product_terms_parent_usort_callback' );
            break;
        }

        ob_start();

        echo $before_widget . $before_title . $title . $after_title;

        $found = $this->layered_nav_list( $terms, $taxonomy, $query_type, $haru_args );

        echo $after_widget;

        // Force found when option is selected - do not force found on taxonomy attributes
        if ( ! is_tax() && is_array( $_chosen_attributes ) && array_key_exists( $taxonomy, $_chosen_attributes ) ) {
            $found = true;
        }

        if ( ! $found ) {
            ob_end_clean();
        } else {
            echo ob_get_clean();
        }
    }
        
    /**
     * Return the currently viewed taxonomy name.
     * @return string
     */

    /**
     * Return the currently viewed term ID.
     * @return int
     */
    protected function get_current_term_id() {
        return absint( is_tax() ? get_queried_object()->term_id : 0 );
    }

    /**
     * Return the currently viewed term slug.
     * @return int
     */
    protected function get_current_term_slug() {
        return absint( is_tax() ? get_queried_object()->slug : 0 );
    }
    
    /**
     * Show dropdown layered nav.
     * @param  array $terms
     * @param  string $taxonomy
     * @param  string $query_type
     * @return bool Will nav display?
     */

    /**
     * Get current page URL for layered nav items.
     * @return string
     */
    protected function get_page_base_url( $taxonomy ) {
        if ( defined( 'SHOP_IS_ON_FRONT' ) ) {
            $link = home_url();
        } elseif ( is_post_type_archive( 'product' ) || is_page( wc_get_page_id( 'shop' ) ) ) {
            $link = get_post_type_archive_link( 'product' );
        } elseif ( is_product_category() ) {
            $link = get_term_link( get_query_var( 'product_cat' ), 'product_cat' );
        } elseif ( is_product_tag() ) {
            $link = get_term_link( get_query_var( 'product_tag' ), 'product_tag' );
        } else {
            $queried_object = get_queried_object();
            $link = get_term_link( $queried_object->slug, $queried_object->taxonomy );
        }

        // Min/Max
        if ( isset( $_GET['min_price'] ) ) {
            $link = add_query_arg( 'min_price', wc_clean( $_GET['min_price'] ), $link );
        }

        if ( isset( $_GET['max_price'] ) ) {
            $link = add_query_arg( 'max_price', wc_clean( $_GET['max_price'] ), $link );
        }

        // Orderby
        if ( isset( $_GET['orderby'] ) ) {
            $link = add_query_arg( 'orderby', wc_clean( $_GET['orderby'] ), $link );
        }

        /**
         * Search Arg.
         * To support quote characters, first they are decoded from &quot; entities, then URL encoded.
         */
        if ( get_search_query() ) {
            $link = add_query_arg( 's', rawurlencode( htmlspecialchars_decode( get_search_query() ) ), $link );
        }

        // Post Type Arg
        if ( isset( $_GET['post_type'] ) ) {
            $link = add_query_arg( 'post_type', wc_clean( $_GET['post_type'] ), $link );
        }

        // Min Rating Arg
        if ( isset( $_GET['min_rating'] ) ) {
            $link = add_query_arg( 'min_rating', wc_clean( $_GET['min_rating'] ), $link );
        }

        // All current filters
        if ( $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes() ) {
            foreach ( $_chosen_attributes as $name => $data ) {
                if ( $name === $taxonomy ) {
                    continue;
                }
                $filter_name = sanitize_title( str_replace( 'pa_', '', $name ) );
                if ( ! empty( $data['terms'] ) ) {
                    $link = add_query_arg( 'filter_' . $filter_name, implode( ',', $data['terms'] ), $link );
                }
                if ( 'or' == $data['query_type'] ) {
                    $link = add_query_arg( 'query_type_' . $filter_name, 'or', $link );
                }
            }
        }

        return $link;
    }

    /**
     * Count products within certain terms, taking the main WP query into consideration.
     * @param  array $term_ids
     * @param  string $taxonomy
     * @param  string $query_type
     * @return array
     */
    protected function get_filtered_term_product_counts( $term_ids, $taxonomy, $query_type ) {
        global $wpdb;

        $tax_query  = WC_Query::get_main_tax_query();
        $meta_query = WC_Query::get_main_meta_query();

        if ( 'or' === $query_type ) {
            foreach ( $tax_query as $key => $query ) {
                if ( is_array($query) && ($taxonomy === $query['taxonomy']) ) {
                    unset( $tax_query[ $key ] );
                }
            }
        }

        $meta_query      = new WP_Meta_Query( $meta_query );
        $tax_query       = new WP_Tax_Query( $tax_query );
        $meta_query_sql  = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
        $tax_query_sql   = $tax_query->get_sql( $wpdb->posts, 'ID' );

        // Generate query
        $query           = array();
        $query['select'] = "SELECT COUNT( DISTINCT {$wpdb->posts}.ID ) as term_count, terms.term_id as term_count_id";
        $query['from']   = "FROM {$wpdb->posts}";
        $query['join']   = "
            INNER JOIN {$wpdb->term_relationships} AS term_relationships ON {$wpdb->posts}.ID = term_relationships.object_id
            INNER JOIN {$wpdb->term_taxonomy} AS term_taxonomy USING( term_taxonomy_id )
            INNER JOIN {$wpdb->terms} AS terms USING( term_id )
            " . $tax_query_sql['join'] . $meta_query_sql['join'];

        $query['where']   = "
            WHERE {$wpdb->posts}.post_type IN ( 'product' )
            AND {$wpdb->posts}.post_status = 'publish'
            " . $tax_query_sql['where'] . $meta_query_sql['where'] . "
            AND terms.term_id IN (" . implode( ',', array_map( 'absint', $term_ids ) ) . ")
        ";

        if ( $search = WC_Query::get_main_search_query_sql() ) {
            $query['where'] .= ' AND ' . $search;
        }

        $query['group_by'] = "GROUP BY terms.term_id";
        $query             = apply_filters( 'woocommerce_get_filtered_term_product_counts_query', $query );
        $query             = implode( ' ', $query );
        $results           = $wpdb->get_results( $query );

        return wp_list_pluck( $results, 'term_count', 'term_count_id' );
    }

    /**
     * Show list based layered nav.
     * @param  array $terms
     * @param  string $taxonomy
     * @param  string $query_type
     * @return bool Will nav display?
     */
    protected function layered_nav_list( $terms, $taxonomy, $query_type, $haru_args ) {
        $columns_class = 'no-col';
        if ( $haru_args['columns'] !== '1' ) {
            $columns_class = ( $haru_args['columns'] === '2' ) ? 'small-block-grid-2 has-col' : 'small-block-grid-2 medium-block-grid-1 has-col';
        }
        echo '<ul class="' . $columns_class . '">';

        $term_counts        = $this->get_filtered_term_product_counts( wp_list_pluck( $terms, 'term_id' ), $taxonomy, $query_type );
        $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
        $found              = false;

        foreach ( $terms as $term ) {
            $current_values    = isset( $_chosen_attributes[ $taxonomy ]['terms'] ) ? $_chosen_attributes[ $taxonomy ]['terms'] : array();
            $option_is_set     = in_array( $term->slug, $current_values );
            $count             = isset( $term_counts[ $term->term_id ] ) ? $term_counts[ $term->term_id ] : 0;

            // skip the term for the current archive
            if ( $this->get_current_term_id() === $term->term_id ) {
                continue;
            }

            // Only show options with count > 0
            if ( 0 < $count ) {
                $found = true;
            } elseif ( 'and' === $query_type && 0 === $count && ! $option_is_set ) {
                continue;
            }

            $filter_name    = 'filter_' . sanitize_title( str_replace( 'pa_', '', $taxonomy ) );
            $current_filter = isset( $_GET[ $filter_name ] ) ? explode( ',', wc_clean( $_GET[ $filter_name ] ) ) : array();
            $current_filter = array_map( 'sanitize_title', $current_filter );

            if ( ! in_array( $term->slug, $current_filter ) ) {
                $current_filter[] = $term->slug;
            }

            $link = $this->get_page_base_url( $taxonomy );

            // Add current filters to URL.
            foreach ( $current_filter as $key => $value ) {
                // Exclude query arg for current term archive term
                if ( $value === $this->get_current_term_slug() ) {
                    unset( $current_filter[ $key ] );
                }

                // Exclude self so filter can be unset on click.
                if ( $option_is_set && $value === $term->slug ) {
                    unset( $current_filter[ $key ] );
                }
            }

            if ( ! empty( $current_filter ) ) {
                $link = add_query_arg( $filter_name, implode( ',', $current_filter ), $link );

                // Add Query type Arg to URL
                if ( $query_type === 'or' && ! ( 1 === sizeof( $current_filter ) && $option_is_set ) ) {
                    $link = add_query_arg( 'query_type_' . sanitize_title( str_replace( 'pa_', '', $taxonomy ) ), 'or', $link );
                }
            }

            echo '<li class="wc-layered-nav-term ' . ( $option_is_set ? 'chosen' : '' ) . '">';

            echo ( $count > 0 || $option_is_set ) ? '<a href="' . esc_url( apply_filters( 'woocommerce_layered_nav_link', $link ) ) . '">' : '<span>';
            
            $color_val = isset( $haru_args['colors'][$term->term_id] ) ? $haru_args['colors'][$term->term_id] : '#e0e0e0';

            echo '<i style="background-color:' . esc_attr( $color_val ) . ';" class="haru-filter-color haru-filter-color-' . esc_attr( strtolower( $term->slug ) ) . '"></i>';
            
            echo esc_html( $term->name );

            echo ( $count > 0 || $option_is_set ) ? '</a> ' : '</span> ';

            echo apply_filters( 'woocommerce_layered_nav_count', '<span class="count">(' . absint( $count ) . ')</span>', $count, $term );

            echo '</li>';
        }

        echo '</ul>';

        return $found;
    }
}
if ( ! function_exists('haru_register_product_color_filter') ) {
    function haru_register_product_color_filter() {
        register_widget('Haru_WC_Widget_Color_Filter');
    }

    add_action('widgets_init', 'haru_register_product_color_filter', 1);
}

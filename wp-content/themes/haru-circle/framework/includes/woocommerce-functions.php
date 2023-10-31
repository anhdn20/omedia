<?php 
/*
 * TABLE OF WOOCOMMERCE FUNCTIONS
 * 1. Products per page
 * 2. Add new meta (HOT- NEW) for product
 * 3. Single product filter
 * 4. Product action (compare, wishlist, quickview)
 * 6. Remove some default Woocommerce hooks
 *
*/ 
if ( class_exists( 'WooCommerce' ) ) {
    /* 1. Filter products per page */
    if ( !function_exists('haru_show_products_per_page') ) {
        function haru_show_products_per_page() {
            $product_per_page = haru_get_option('haru_product_per_page');
            // Set default
            if ( empty($product_per_page) ) {
                $product_per_page = 12;
            }
            $page_size = isset($_GET['page_size']) ? wc_clean($_GET['page_size']) : $product_per_page;

            return $page_size;
        }
        add_filter('loop_shop_per_page', 'haru_show_products_per_page');
    }

    /* 2. Add meta NEW - HOT for product */
    // 2.1. Display Fields
    if (!function_exists('haru_woocommerce_add_custom_general_fields')) {
        function haru_woocommerce_add_custom_general_fields() {
            echo '<div class="options_group">';
            woocommerce_wp_checkbox(
                array(
                    'id'    => 'haru_product_new',
                    'label' => esc_html__( 'Is New Product?', 'haru-circle' )
                )
            );
            woocommerce_wp_checkbox(
                array(
                    'id'    => 'haru_product_hot',
                    'label' => esc_html__( 'Is Hot Product?', 'haru-circle' )
                )
            );
            woocommerce_wp_text_input(
                array(
                    'id'    => 'haru_product_video_url',
                    'label' => esc_html__( 'Product Video Url', 'haru-circle' ),
                    'placeholder' => esc_html__( 'Youtube or Vimeo Url', 'haru-circle' )
                )
            );
            echo '</div>';
        }
        add_action('woocommerce_product_options_general_product_data', 'haru_woocommerce_add_custom_general_fields');
    }

    // 2.2. Save Fields
    if (!function_exists('haru_woocommerce_add_custom_general_fields_save')) {
        function haru_woocommerce_add_custom_general_fields_save($post_id) {
            $haru_product_new = isset($_POST['haru_product_new']) ? 'yes' : 'no';
            update_post_meta( $post_id, 'haru_product_new', $haru_product_new );

            $haru_product_hot = isset($_POST['haru_product_hot']) ? 'yes' : 'no';
            update_post_meta( $post_id, 'haru_product_hot', $haru_product_hot );

            $haru_product_video_url = isset($_POST['haru_product_video_url']) ? $_POST['haru_product_video_url'] : '';
            update_post_meta( $post_id, 'haru_product_video_url', $haru_product_video_url );
        }
        add_action('woocommerce_process_product_meta', 'haru_woocommerce_add_custom_general_fields_save');
    }

    // 2.3. Add custom column into Product Page
    if (!function_exists('haru_columns_into_product_list')) {
        function haru_columns_into_product_list($defaults) {
            $defaults['haru_product_new'] = esc_html__( 'New', 'haru-circle' );
            $defaults['haru_product_hot'] = esc_html__( 'Hot', 'haru-circle' );

            return $defaults;
        }
        add_filter('manage_edit-product_columns', 'haru_columns_into_product_list');
    }

    // 2.4. Add rows value into Product Page
    if (!function_exists('haru_column_into_product_list')) {
        function haru_column_into_product_list($column, $post_id) {
            switch ($column) {
                case 'haru_product_new':
                    echo get_post_meta($post_id, 'haru_product_new', true);
                    break;
                case 'haru_product_hot':
                    echo get_post_meta($post_id, 'haru_product_hot', true);
                    break;
            }
        }
        add_action('manage_product_posts_custom_column', 'haru_column_into_product_list', 10, 2);
    }

    // 2.5. Make these columns sortable
    if (!function_exists('haru_product_sortable_columns')) {
        function haru_product_sortable_columns() {
            return array(
                'haru_product_new' => 'haru_product_new',
                'haru_product_hot' => 'haru_product_hot'
            );
        }
        add_filter("manage_edit-product_sortable_columns", "haru_product_sortable_columns");
    }

    // 2.6. Order by column
    if (!function_exists('haru_event_column_orderby')) {
        function haru_event_column_orderby($query) {
            if ( !is_admin() ) return;
            $orderby = $query->get('orderby');
            if ('haru_product_new' == $orderby) {
                $query->set('meta_key', 'haru_product_new');
                $query->set('orderby', 'meta_value_num');
            }

            if ( 'haru_product_hot' == $orderby ) {
                $query->set('meta_key', 'haru_product_hot');
                $query->set('orderby', 'meta_value_num');
            }
        }
       add_action('pre_get_posts', 'haru_event_column_orderby');
    }

    /* 3. Single product filter */
    /* 3.1. Related single product filter */
    if (!function_exists('haru_related_products_args')) {
        function haru_related_products_args() {
            $related_product_count  = haru_get_option('haru_related_product_count');
            $args['posts_per_page'] = isset($related_product_count) ? haru_get_option('related_product_count') : 6;
            
            return $args;
        }
        add_filter('woocommerce_output_related_products_args', 'haru_related_products_args');
    }
    /* 3.2. Related single product by category */
    if (!function_exists('haru_woocommerce_product_related_posts_relate_by_category')) {
        function haru_woocommerce_product_related_posts_relate_by_category() {

            return true;
        }
        add_filter('woocommerce_product_related_posts_relate_by_category', 'haru_woocommerce_product_related_posts_relate_by_category');
    }
    /* 3.3. Related single product by tag */
    if (!function_exists('haru_woocommerce_product_related_posts_relate_by_tag')) {
        function haru_woocommerce_product_related_posts_relate_by_tag() {

            return true;
        }
        add_filter('woocommerce_product_related_posts_relate_by_tag', 'haru_woocommerce_product_related_posts_relate_by_tag');
    }

    /* 4. Product action (add to cart, compare, wishlist, quickview) */
    /* 4.0. Return function to remove some default filter */
    if ( !function_exists('haru_woocommerce_return') ) {
        function haru_woocommerce_return() {
            return;
        }
    }
    /* 4.1. Product Add To Cart */
    add_action('haru_woocommerce_product_actions','woocommerce_template_loop_add_to_cart', 20);
    /* 4.2. Product quick view */
    if ( !function_exists('haru_woocomerce_template_loop_quick_view') ) {
        function haru_woocomerce_template_loop_quick_view() {
            wc_get_template( 'loop/quick-view.php' );
        }
        add_action( 'haru_woocommerce_product_actions', 'haru_woocomerce_template_loop_quick_view', 25 );
    }

    /* 4.3. Product wishlist */
    if ( !function_exists('haru_woocomerce_template_loop_wishlist') ) {
        function haru_woocomerce_template_loop_wishlist() {
            wc_get_template( 'loop/wishlist.php' );
        }
        add_action( 'haru_woocommerce_product_actions', 'haru_woocomerce_template_loop_wishlist', 5 );
        // Add for single product
        add_action( 'woocommerce_after_add_to_cart_button', 'haru_woocomerce_template_loop_wishlist', 5 );
        // add_action( 'woocommerce_after_add_to_cart_button', 'haru_woocomerce_template_loop_wishlist', 5 );
    }
    // Remove wishlist single product
    add_filter( 'yith_wcwl_positions', 'haru_woocommerce_return' );

    /* 4.4. Product compare */
    if ( !function_exists('haru_woocomerce_template_loop_compare') ) {
        function haru_woocomerce_template_loop_compare() {
            wc_get_template( 'loop/compare.php' );
        }
        add_action( 'haru_woocommerce_product_actions', 'haru_woocomerce_template_loop_compare', 10 );
        // Add for single product
        add_action( 'woocommerce_after_add_to_cart_button', 'haru_woocomerce_template_loop_compare', 5 );
    }
    // Remove compare single product
    update_option('yith_woocompare_compare_button_in_product_page', 'no');

    /* 5. Sale Flash Mode */
    if ( ! function_exists('haru_woocommerce_sale_flash') ) {
        function haru_woocommerce_sale_flash( $sale_flash, $post, $product ) {
            $product_sale_flash_mode = haru_get_option('haru_product_sale_flash_mode');
            $product_sale_flash_mode = isset($product_sale_flash_mode) ? haru_get_option('haru_product_sale_flash_mode') : '' ;
            if ( $product_sale_flash_mode == 'percent' ) {
                $sale_percent = 0;
                if ( $product->is_on_sale() && $product->get_type() != 'grouped' ) {
                    if ( $product->get_type() == 'variable' ) {
                        $available_variations =  $product->get_available_variations();
                        for ( $i = 0; $i < count($available_variations); ++$i ) {
                            $variation_id      = $available_variations[$i]['variation_id'];
                            $variable_product1 = new WC_Product_Variation( $variation_id );
                            $regular_price     = $variable_product1->get_regular_price();
                            $sales_price       = $variable_product1->get_sale_price();
                            $price             = $variable_product1->get_price();
                            if ( $sales_price != $regular_price && $sales_price == $price ) {
                                $percentage= round((( ( $regular_price - $sales_price ) / $regular_price ) * 100),0) ;
                                if ($percentage > $sale_percent) {
                                    $sale_percent = $percentage;
                                }
                            }
                        }
                    } else {
                        $sale_percent = round((( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100),0) ;
                    }
                }
                if ($sale_percent > 0) {
                    return '<span class="onsale">-' . $sale_percent . '%</span>';
                } else {
                    return "";
                }
            }
            return $sale_flash;
        }
        add_filter('woocommerce_sale_flash', 'haru_woocommerce_sale_flash', 10, 3);
    }

    /* 6. Remove some default Woocommerce hooks */
    remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

    /* 7. Haru get search category dropdown */
    if ( !function_exists('haru_categories_binder') ) {
        function haru_categories_binder( $categories, $parent, $class= 'product-category-toggle', $is_anchor = false, $show_count = false ) {
            $index  = 0;
            $output = '';
            if ( empty($categories) || !array($categories) ) {
                return $output;
            }
            foreach ( $categories as $key => $term ) {
                if ( empty($term) || (!isset($term->parent)) ) {
                    continue;
                }
                if ( ((int)$term->parent !== (int)$parent) || ($parent === null) || ($term->parent === null) ) {
                    continue;
                }

                if ($index == 0) {
                    $output = '<ul>';
                    if ($parent == 0) {
                        $output = '<ul class="'. esc_attr($class) .'">';
                    }
                }

                $output .= '<li>';
                $output .= sprintf('%s%s%s',
                    $is_anchor ? '<a href="' .  esc_url( get_term_link((int)$term->term_id, 'product_cat') ) . '" title="' . esc_attr($term->name) . '">' : '<span data-catid="' . esc_attr($term->term_id) . '">',
                    $show_count ? esc_html($term->name.' (' . $term->count . ')') : esc_html($term->name),
                    $is_anchor ? '</a>' : '</span>'
                    );
                $output .= haru_categories_binder($categories, $term->term_id,$class, $is_anchor,$show_count);
                $output .= '</li>';
                $index++;
            }

            if (!empty($output)) {
                $output .= '</ul>';
            }

            return $output;
        }
    }

    /* 8. Haru product attribute variation */
    function haru_product_attribute_variation() {
        global $product;
        // Product attributes
        $product_attribute = haru_get_option('haru_product_attribute');
        if ( empty($product_attribute) ) {
            $product_attribute = 'color';
        }
        $default_attribute  = 'pa_' . $product_attribute;

        $attributes         = maybe_unserialize( get_post_meta( $product->get_id(), '_product_attributes', true ) );
        $product_attributes = $default_attribute;

        $variations = haru_product_get_variations( $product_attributes );
        if ( ! $attributes ) {
            return;
        }

        foreach ( $attributes as $attribute ) {
            if ( $product->get_type() == 'variable' ) {
                if ( ! $attribute['is_variation'] ) {
                    continue;
                }
            }

            if ( sanitize_title( $attribute['name'] ) == $product_attributes ) {
                echo '<div class="haru-variations-list '. $default_attribute .'">';

                if ( $attribute['is_taxonomy'] ) {
                    $post_terms = wp_get_post_terms( $product->get_id(), $attribute['name'] );
                    
                    $attribute_type = '';
                    $temp_attribute = haru_get_wc_attribute_taxonomy( $attribute['name'] );
                    if ( $temp_attribute ) {
                        $attribute_type = $temp_attribute->attribute_type;
                    }
                    $found = false;

                    foreach ( $post_terms as $term ) {
                        $css_class = '';
                        if ( is_wp_error( $term ) ) {
                            continue;
                        }
                        if ( $variations && isset( $variations[$term->slug] ) ) {
                            $attachment_id = $variations[$term->slug];
                            $attachment    = wp_get_attachment_image_src( $attachment_id, 'shop_catalog' );
                            $image_srcset = wp_get_attachment_image_srcset( $attachment_id, 'shop_catalog' );

                            if ( $attachment_id == get_post_thumbnail_id() && ! $found ) {
                                $css_class .= ' selected';
                                $found = true;
                            }

                            if ( $attachment ) {
                                $css_class .= ' haru-variation-image';
                                $img_src = $attachment[0];
                                echo haru_variation_html( $term, $attribute_type, $img_src, $css_class, $image_srcset );
                            }
                        }
                    }
                }
                
                echo '</div>';
                break;
            }
        }
    }
    add_action( 'haru_woocommerce_product_variations', 'haru_product_attribute_variation', 5 );

    /* 9. Haru product attribute variation render */
    function haru_variation_html( $term, $attribute_type, $img_src, $css_class, $image_srcset ) {

        $html = '';
        $name = $term->name;

        switch ( $attribute_type ) {
            case 'color':
                $color  = haru_get_term_meta( $term->term_id, 'product_attribute_color', TRUE );
                list( $r, $g, $b ) = sscanf( $color, "#%02x%02x%02x" );
                $html = sprintf(
                    '<span class="variation variation-color %s" data-src="%s" data-src-set="%s" title="%s"><span class="color-variation" style="background-color:%s;"></span> <span class="haru-tooltip button-tooltip">%s</span></span>',
                    esc_attr( $css_class ),
                    esc_url( $img_src ),
                    esc_attr( $image_srcset ),
                    esc_attr( $name ),
                    esc_attr( $color ),
                    esc_attr( $name )
                );
                break;

            case 'image':
                $image = get_term_meta( $term->term_id, 'image', true );
                if ( $image ) {
                    $image = wp_get_attachment_image_src( $image );
                    $image = $image ? $image[0] : WC()->plugin_url() . '/assets/images/placeholder.png';
                    $html  = sprintf(
                        '<span class="variation variation-image %s" data-src="%s" data-src-set="%s" title="%s"><img src="%s" alt="%s"></span>',
                        esc_attr( $css_class ),
                        esc_url( $img_src ),
                        esc_attr( $image_srcset ),
                        esc_attr( $name ),
                        esc_url( $image ),
                        esc_attr( $name )
                    );
                }

                break;

            default:
                $label = get_term_meta( $term->term_id, 'label', true );
                $label = $label ? $label : $name;
                $html  = sprintf(
                    '<span class="variation variation-label %s" data-src="%s" data-src-set="%s" title="%s"><span class="haru-tooltip button-tooltip">%s</span>%s</span>',
                    esc_attr( $css_class ),
                    esc_url( $img_src ),
                    esc_attr( $image_srcset ),
                    esc_attr( $name ),
                    esc_attr( $name ),
                    esc_html( $label )
                );
                break;


        }

        return $html;
    }

    // 10
    function haru_product_get_variations( $default_attribute ) {
        global $product;

        $variations = array();
        if ( $product->get_type() == 'variable' ) {
            $args = array(
                'post_parent' => $product->get_id(),
                'post_type'   => 'product_variation',
                'orderby'     => 'menu_order',
                'order'       => 'ASC',
                'fields'      => 'ids',
                'post_status' => 'publish',
                'numberposts' => - 1
            );

            if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
                $args['meta_query'][] = array(
                    'key'     => '_stock_status',
                    'value'   => 'instock',
                    'compare' => '=',
                );
            }

            $thumbnail_id = get_post_thumbnail_id();

            $posts = get_posts( $args );

            foreach ( $posts as $post_id ) {
                $attachment_id = get_post_thumbnail_id( $post_id );
                $attribute     = haru_get_variation_attributes( $post_id, 'attribute_' . $default_attribute );

                if ( ! $attachment_id ) {
                    $attachment_id = $thumbnail_id;
                }

                if ( $attribute ) {
                    $variations[$attribute[0]] = $attachment_id;
                }

            }

        }

        return $variations;
    }

    // 11
    function haru_get_variation_attributes( $child_id, $attribute ) {
        global $wpdb;

        $values = array_unique(
            $wpdb->get_col(
                $wpdb->prepare(
                    "SELECT meta_value FROM {$wpdb->postmeta} WHERE meta_key = %s AND post_id IN (" . $child_id . ")",
                    $attribute
                )
            )
        );

        return $values;
    }

    // 12. woocommerce_format_sale_price override
    if (!function_exists('haru_format_sale_price')) {
        function haru_format_sale_price( $price, $regular_price, $sale_price ) {
            $price = '<ins>' . ( is_numeric( $sale_price ) ? wc_price( $sale_price ) : $sale_price ) . '</ins>' . '<del>' . ( is_numeric( $regular_price ) ? wc_price( $regular_price ) : $regular_price ) . '</del>';
            return $price;
        }
        add_filter('woocommerce_format_sale_price', 'haru_format_sale_price', 100, 3);
    }

    // 13.
    function custom_woocommerce_tag_cloud_widget() {
        $args = array(
            'number' => 15,
            'smallest'  => 13, 
            'default'   => 18, 
            'largest'   => 24, 
            'unit'      => 'px',
            'taxonomy' => 'product_tag',
            'format'    => 'flat', 
            'separator' => ",", 
            'orderby'   => 'name', 
            'order'     => 'ASC',
            'exclude'   => '', 
            'include'   => '', 
            'link'      => 'view',
        );
        return $args;
    }
    add_filter( 'woocommerce_product_tag_cloud_widget_args', 'custom_woocommerce_tag_cloud_widget' );
}
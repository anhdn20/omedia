<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com        
*/

if ( class_exists( 'WooCommerce' ) ) {
    /*-----------------------------------
     * 1. ARCHIVE PRODUCT HEADING
     *-----------------------------------*/

    function haru_archive_product_heading() {
        get_template_part('templates/archive-product-heading');
    }
    add_action( 'haru_before_archive_product', 'haru_archive_product_heading', 5 );
    
    /*-----------------------------------
     * 2. AJAX PRODUCT ADD TO WISHLIST
     *-----------------------------------*/
    function haru_woocommerce_wishlist(){
        if( !(class_exists( 'WooCommerce' ) && class_exists('YITH_WCWL')) ){
            return;
        }
        
        ob_start();
        
        $wishlist_page_id = get_option( 'yith_wcwl_wishlist_page_id' );
        if( function_exists( 'icl_object_id' ) ){
            $wishlist_page_id = icl_object_id( $wishlist_page_id, 'page', true );
        }
        $wishlist_page = get_permalink( $wishlist_page_id );
        
        $count = yith_wcwl_count_products();
        
        ?>
        
        <a title="<?php echo esc_attr__( 'Wishlist','haru-circle' ); ?>" href="<?php echo esc_url($wishlist_page); ?>" class="haru-wishlist">
            <i class="header-icon ti-heart"></i>
            <?php echo '<span class="total">' . ($count > 0 ? $count : '0') . '</span>'; ?>
        </a>

        <?php
        $haru_wishlist = ob_get_clean();
        return $haru_wishlist;
    }

    function haru_update_woocommerce_wishlist() {
        die(haru_woocommerce_wishlist());
    }

    add_action( 'wp_ajax_update_woocommerce_wishlist', 'haru_update_woocommerce_wishlist' );
    add_action( 'wp_ajax_nopriv_update_woocommerce_wishlist', 'haru_update_woocommerce_wishlist' );

    /*-----------------------------------
     * 3. Add style attribute types on woocommerce taxonomy
     *-----------------------------------*/
    if ( is_admin() ) {
        if ( ! function_exists( 'haru_admin_style_attributes_types' ) ) :
            function haru_admin_style_attributes_types( $current ) {

                $current[ 'color' ] = esc_html__( 'Color', 'haru-circle' );
                $current[ 'image' ] = esc_html__( 'Image', 'haru-circle' );
                $current[ 'label' ] = esc_html__( 'Label', 'haru-circle' );

                return $current;
            }

            add_filter( 'product_attributes_type_selector', 'haru_admin_style_attributes_types' );
        endif;
    }

    /*-----------------------------------
     * 4. Get a Attribute taxonomy values
     *-----------------------------------*/
    if ( ! function_exists( 'haru_get_wc_attribute_taxonomy' ) ):

        function haru_get_wc_attribute_taxonomy( $attribute_name ) {
            global $wpdb;

            $attr_prefix        = 'pa_'; // @TODO: wc_attribute_taxonomy_name doesn't work now
            $attribute_name     = esc_sql( str_ireplace( $attr_prefix, '', $attribute_name ) );
            $attribute_taxonomy = $wpdb->get_row( "SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies WHERE attribute_name='{$attribute_name}'" );

            return $attribute_taxonomy;
        }
    endif;

    /*-----------------------------------
     * 5. Set style attribute on product admin page
     *-----------------------------------*/
    if ( is_admin() ) {
        if ( ! function_exists( 'haru_admin_style_attributes_values' ) ) :

            function haru_admin_style_attributes_values( $attribute_taxonomy, $i ) {

                global $post, $thepostid, $product_object;

                if ( in_array( $attribute_taxonomy->attribute_type, array( 'color', 'image', 'label' ) ) ) {
                    $taxonomy = wc_attribute_taxonomy_name( $attribute_taxonomy->attribute_name );
                    $product_id = $thepostid;
                
                    if ( is_null( $thepostid ) && isset( $_POST[ 'post_id' ] ) ) {
                        $product_id = absint( $_POST[ 'post_id' ] );
                    }
                    
                    $args = array(
                        'orderby'    => 'name',
                        'hide_empty' => 0,
                    );
                    ?>
                    <select multiple="multiple" data-placeholder="<?php echo esc_attr__( 'Select terms', 'haru-circle' ); ?>"
                            class="multiselect attribute_values wc-enhanced-select"
                            name="attribute_values[<?php echo esc_attr($i); ?>][]">
                        <?php
                            $all_terms = get_terms( $taxonomy, apply_filters( 'woocommerce_product_attribute_terms', $args ) );
                            if ( $all_terms ) {
                                foreach ( $all_terms as $term ) {
                                    echo '<option value="' . esc_attr( $term->term_id ) . '" ' . selected( has_term( absint( $term->term_id ), $taxonomy, $product_id ), true, false ) . '>' . esc_attr( apply_filters( 'woocommerce_product_attribute_term_name', $term->name, $term ) ) . '</option>';
                                }
                            }
                        ?>
                    </select>
                    <button class="button plus select_all_attributes"><?php echo esc_html__( 'Select all', 'haru-circle' ); ?></button>
                    <button class="button minus select_no_attributes"><?php echo esc_html__( 'Select none', 'haru-circle' ); ?></button>
                    <button class="button fr plus add_new_attribute"><?php echo esc_html__( 'Add new', 'haru-circle' ); ?></button>
                    <?php
                }
            }

            add_action( 'woocommerce_product_option_terms', 'haru_admin_style_attributes_values', 10, 2 );

        endif;
    }

    /*-----------------------------------
     * 6. Color Variation Attribute Options
     *-----------------------------------*/
    if ( ! function_exists( 'haru_wc_color_variation_attribute_options' ) ) :

        /**
         * Output a list of variation attributes for use in the cart forms.
         *
         * @param array $args
         *
         * @since 2.4.0
         */
        function haru_wc_color_variation_attribute_options( $args = array() ) {

            $args = wp_parse_args( $args, array(
                'options'          => FALSE,
                'attribute'        => FALSE,
                'product'          => FALSE,
                'selected'         => FALSE,
                'name'             => '',
                'id'               => '',
                'class'            => '',
                'show_option_none' => esc_html__( 'Choose an option', 'haru-circle' )
            ) );

            $options   = $args[ 'options' ];
            $product   = $args[ 'product' ];
            $attribute = $args[ 'attribute' ];
            $name      = $args[ 'name' ] ? $args[ 'name' ] : 'attribute_' . sanitize_title( $attribute );
            $id        = $args[ 'id' ] ? $args[ 'id' ] : sanitize_title( $attribute ) . $product->get_id();
            $class     = $args[ 'class' ];

            if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
                $attributes = $product->get_variation_attributes();
                $options    = $attributes[ $attribute ];
            }

            echo '<select ' . $id . ' class="' . esc_attr( $class ) . ' hide" name="' . esc_attr( $name ) . '" data-attribute_name="attribute_' . esc_attr( sanitize_title( $attribute ) ) . '">';

            if ( $args[ 'show_option_none' ] ) {
                echo '<option value="">' . esc_html( $args[ 'show_option_none' ] ) . '</option>';
            }

            if ( ! empty( $options ) ) {
                if ( $product && taxonomy_exists( $attribute ) ) {
                    // Get terms if this is a taxonomy - ordered. We need the names too.
                    $terms = wc_get_product_terms( $product->get_id(), $attribute, array( 'fields' => 'all' ) );

                    foreach ( $terms as $term ) {
                        if ( in_array( $term->slug, $options ) ) {
                            echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $args[ 'selected' ] ), $term->slug, FALSE ) . '>' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '</option>';
                        }
                    }
                }
            }
            echo '</select>';
            echo '<ul class="list-inline variable-items-wrapper color-variable-wrapper">';
            if ( ! empty( $options ) ) {
                if ( $product && taxonomy_exists( $attribute ) ) {
                    $terms = wc_get_product_terms( $product->get_id(), $attribute, array( 'fields' => 'all' ) );

                    foreach ( $terms as $term ) {
                        if ( in_array( $term->slug, $options ) ) {
                            $get_term_meta  = haru_get_term_meta( $term->term_id, 'product_attribute_color', TRUE );
                            $selected_class = ( sanitize_title( $args[ 'selected' ] ) == $term->slug ) ? 'selected' : '';
                            ?>
                            <li class="variable-item color-variable-item color-variable-item-<?php echo esc_attr($term->slug) ?> <?php echo esc_attr($selected_class) ?>"
                                style="background-color:<?php echo esc_attr( $get_term_meta ) ?>;"
                                data-value="<?php echo esc_attr( $term->slug ) ?>">
                                <span class="haru-tooltip button-tooltip"><?php echo esc_html( $term->name ) ?></span>
                            </li>
                            <?php
                        }
                    }
                }
            }
            echo '</ul>';
        }

    endif;

    /*-----------------------------------
     * 7. Image Variation Attribute Options
     *-----------------------------------*/
    if ( ! function_exists( 'haru_wc_image_variation_attribute_options' ) ) :

        /**
         * Output a list of variation attributes for use in the cart forms.
         *
         * @param array $args
         *
         * @since 2.4.0
         */
        function haru_wc_image_variation_attribute_options( $args = array() ) {

            $args = wp_parse_args( $args, array(
                'options'          => FALSE,
                'attribute'        => FALSE,
                'product'          => FALSE,
                'selected'         => FALSE,
                'name'             => '',
                'id'               => '',
                'class'            => '',
                'show_option_none' => esc_html__( 'Choose an option', 'haru-circle' )
            ) );

            $options   = $args[ 'options' ];
            $product   = $args[ 'product' ];
            $attribute = $args[ 'attribute' ];
            $name      = $args[ 'name' ] ? $args[ 'name' ] : 'attribute_' . sanitize_title( $attribute );
            $id        = $args[ 'id' ] ? $args[ 'id' ] : sanitize_title( $attribute ) . $product->get_id();
            $class     = $args[ 'class' ];

            if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
                $attributes = $product->get_variation_attributes();
                $options    = $attributes[ $attribute ];
            }

            echo '<select ' . $id . ' class="' . esc_attr( $class ) . ' hide" name="' . esc_attr( $name ) . '" data-attribute_name="attribute_' . esc_attr( sanitize_title( $attribute ) ) . '">';

            if ( $args[ 'show_option_none' ] ) {
                echo '<option value="">' . esc_html( $args[ 'show_option_none' ] ) . '</option>';
            }

            if ( ! empty( $options ) ) {
                if ( $product && taxonomy_exists( $attribute ) ) {
                    // Get terms if this is a taxonomy - ordered. We need the names too.
                    $terms = wc_get_product_terms( $product->get_id(), $attribute, array( 'fields' => 'all' ) );

                    foreach ( $terms as $term ) {
                        if ( in_array( $term->slug, $options ) ) {
                            echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $args[ 'selected' ] ), $term->slug, FALSE ) . '>' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '</option>';
                        }
                    }
                }
            }

            echo '</select>';

            echo '<ul class="list-inline variable-items-wrapper image-variable-wrapper">';
            if ( ! empty( $options ) ) {
                if ( $product && taxonomy_exists( $attribute ) ) {
                    $terms = wc_get_product_terms( $product->get_id(), $attribute, array( 'fields' => 'all' ) );

                    foreach ( $terms as $term ) {
                        if ( in_array( $term->slug, $options ) ) {
                            $get_term_meta  = haru_get_term_meta( $term->term_id, 'product_attribute_image', TRUE );
                            $image          = wp_get_attachment_image_src( $get_term_meta, 'full' );
                            $selected_class = ( sanitize_title( $args[ 'selected' ] ) == $term->slug ) ? 'selected' : '';
                            ?>
                            <li class="variable-item image-variable-item image-variable-item-<?php echo esc_attr($term->slug) ?> <?php echo esc_attr($selected_class) ?>"
                                title="<?php echo esc_attr( $term->name ) ?>"
                                data-value="<?php echo esc_attr( $term->slug ) ?>"><img
                                alt="<?php echo esc_attr( $term->name ) ?>"
                                src="<?php echo esc_url( $image[ 0 ] ) ?>">
                                <span class="haru-tooltip button-tooltip"><?php echo esc_html( $term->name ) ?></span>
                            </li>
                            <?php
                        }
                    }
                }
            }
            echo '</ul>';
        }
    endif;

    /*-----------------------------------
     * 8. Label Variation Attribute Options
     *-----------------------------------*/
    if ( ! function_exists( 'haru_wc_label_variation_attribute_options' ) ) :

        /**
         * Output a list of variation attributes for use in the cart forms.
         *
         * @param array $args
         *
         * @since 2.4.0
         */
        function haru_wc_label_variation_attribute_options( $args = array() ) {

            $args = wp_parse_args( $args, array(
                'options'          => FALSE,
                'attribute'        => FALSE,
                'product'          => FALSE,
                'selected'         => FALSE,
                'name'             => '',
                'id'               => '',
                'class'            => '',
                'show_option_none' => esc_html__( 'Choose an option', 'haru-circle' )
            ) );

            $options   = $args[ 'options' ];
            $product   = $args[ 'product' ];
            $attribute = $args[ 'attribute' ];
            $name      = $args[ 'name' ] ? $args[ 'name' ] : 'attribute_' . sanitize_title( $attribute );
            $id        = $args[ 'id' ] ? $args[ 'id' ] : sanitize_title( $attribute ) . $product->get_id();
            $class     = $args[ 'class' ];

            if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
                $attributes = $product->get_variation_attributes();
                $options    = $attributes[ $attribute ];
            }

            echo '<select ' . $id . ' class="' . esc_attr( $class ) . ' hide" name="' . esc_attr( $name ) . '" data-attribute_name="attribute_' . esc_attr( sanitize_title( $attribute ) ) . '">';

            if ( $args[ 'show_option_none' ] ) {
                echo '<option value="">' . esc_html( $args[ 'show_option_none' ] ) . '</option>';
            }

            if ( ! empty( $options ) ) {
                if ( $product && taxonomy_exists( $attribute ) ) {
                    // Get terms if this is a taxonomy - ordered. We need the names too.
                    $terms = wc_get_product_terms( $product->get_id(), $attribute, array( 'fields' => 'all' ) );

                    foreach ( $terms as $term ) {
                        if ( in_array( $term->slug, $options ) ) {
                            echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $args[ 'selected' ] ), $term->slug, FALSE ) . '>' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '</option>';
                        }
                    }
                }
            }

            echo '</select>';

            echo '<ul class="list-inline variable-items-wrapper label-variable-wrapper">';
            if ( ! empty( $options ) ) {
                if ( $product && taxonomy_exists( $attribute ) ) {
                    $terms = wc_get_product_terms( $product->get_id(), $attribute, array( 'fields' => 'all' ) );

                    foreach ( $terms as $term ) {
                        if ( in_array( $term->slug, $options ) ) {
                            $get_term_meta  = haru_get_term_meta( $term->term_id, 'product_attribute_label', TRUE );
                            $selected_class = ( sanitize_title( $args[ 'selected' ] ) == $term->slug ) ? 'selected' : '';
                            ?>
                            <li class="variable-item label-variable-item label-variable-item-<?php echo esc_attr($term->slug) ?> <?php echo esc_attr($selected_class) ?>"
                                title="<?php echo esc_attr( $term->name ) ?>"
                                data-value="<?php echo esc_attr( $term->slug ) ?>"><?php echo esc_html( $term->name ) ?>
                                <span class="haru-tooltip button-tooltip"><?php echo esc_html( $term->description ) ?></span>
                            </li>
                            <?php
                        }
                    }
                }
            }
            echo '</ul>';
        }

    endif;

    /*-----------------------------------
     * 9. OVERWRITE LOOP PRODUCT THUMBNAIL
     *-----------------------------------*/
    if ( ! function_exists('haru_woocommerce_template_loop_product_thumbnail')) {
        /**
         * Get the product thumbnail for the loop.
         *
         * @access public
         * @subpackage    Loop
         * @return void
         */
        function haru_woocommerce_template_loop_product_thumbnail() {
            global $product;
            $attachment_ids    = $product->get_gallery_image_ids();
            $secondary_image   = '';
            $class             = 'product-thumb-one';
            $post_thumbnail_id = '';
            if ( has_post_thumbnail() ) {
                $post_thumbnail_id = get_post_thumbnail_id();
            }

            $secondary_image_id = '';

            if ( $product->get_type() == 'variable' ) {
                $available_variations = $product->get_available_variations();
                if ( isset( $available_variations ) ) {
                    foreach ($available_variations as $available_variation){
                        $variation_id = $available_variation['variation_id'];
                        if (has_post_thumbnail($variation_id)) {
                            $variation_image_id = get_post_thumbnail_id($variation_id);
                            if ($variation_image_id != $post_thumbnail_id) {
                                $secondary_image_id = $variation_image_id;
                                break;
                            }
                        }
                    }
                }
            }

            if (($secondary_image_id == '') && isset($attachment_ids) && isset($attachment_ids['0'])) {
                $secondary_image_id = $attachment_ids['0'];
            }

	        if (!empty($secondary_image_id)) {
		        $secondary_image    = wp_get_attachment_image( $secondary_image_id, apply_filters( 'shop_catalog', 'shop_catalog' ) );
		        if ( ! empty( $secondary_image ) ) {
			        $class = 'product-thumb-primary';
		        }
	        }
            ?>
            <?php if ( has_post_thumbnail() ) : ?>
                <div class="<?php echo esc_attr( $class ); ?>">
                    <?php echo woocommerce_get_product_thumbnail(); ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($secondary_image_id)) : ?>
                <div class="product-thumb-secondary">
                    <?php echo wp_kses_post($secondary_image); ?>
                </div>
            <?php endif; ?>
        <?php
        }
    }

    /*-----------------------------------
     * 10. SINGLE PRODUCT
     *-----------------------------------*/
	if ( ! function_exists('haru_woocommerce_product_related_posts_relate_by_category') ) {
		function haru_woocommerce_product_related_posts_relate_by_category() {
            $related_product_condition = haru_get_option('related_product_condition');

			return $related_product_condition['category'] == 1 ? true : false;
		}
		add_filter('woocommerce_product_related_posts_relate_by_category','haru_woocommerce_product_related_posts_relate_by_category');
	}

	if ( ! function_exists('haru_woocommerce_product_related_posts_relate_by_tag') ) {
		function haru_woocommerce_product_related_posts_relate_by_tag() {
            $related_product_condition = haru_get_option('related_product_condition');
            
			return $related_product_condition['tag'] == 1 ? true : false;
		}
		add_filter('woocommerce_product_related_posts_relate_by_tag','haru_woocommerce_product_related_posts_relate_by_tag');
	}

    /*-----------------------------------
     * 11. SHOPPING CART
     *-----------------------------------*/
    if ( ! function_exists('haru_button_continue_shopping')) {
        function haru_button_continue_shopping () {
            $continue_shopping =  get_permalink( wc_get_page_id( 'shop' ) );
            ?>
            <a href="<?php echo esc_url($continue_shopping); ?>" class="continue-shopping button"><?php echo esc_html__( 'Continue shopping', 'haru-circle' ); ?></a>
            <?php
        }
    }

    /*-----------------------------------
     * 13. PRODUCT SIZE GUIDE
     *-----------------------------------*/
    if ( ! function_exists('haru_woocommerce_template_single_size_guide') ) {
        function haru_woocommerce_template_single_size_guide() {
            $haru_product_size_guide = get_post_meta( get_the_ID(), 'haru_single_product_size_guide', true );
            // var_dump($haru_product_size_guide);
            if ( !empty( $haru_product_size_guide ) ) {
                $size_guide_img_src = wp_get_attachment_url($haru_product_size_guide);
                echo '<div class="product-size-guide"><a href="'. esc_url( $size_guide_img_src ) .'" class="product-size-guide-link">'. esc_html__( 'Product Guide', 'haru-circle' ) .'</a></div>';
            }
        }
    }
    add_action( 'woocommerce_single_product_summary', 'haru_woocommerce_template_single_size_guide', 25 );

    /*-----------------------------------
     * 14. ADVANCED SEARCH CATEGORY
     *-----------------------------------*/
    if ( ! function_exists('haru_advanced_search_category_query') ) {
        function haru_advanced_search_category_query($query) {
            if ( $query->is_search() ) {
                // category terms search.
                if (isset($_GET['product_cat']) && !empty($_GET['product_cat'])) {
                    $query->set('tax_query', array(array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => array($_GET['product_cat']) )
                    ));
                }
                return $query;
            }
        }
        add_action('pre_get_posts', 'haru_advanced_search_category_query', 1000);
    }

    /*-----------------------------------
     * 15.SHARE
     *-----------------------------------*/
    add_action('woocommerce_share', 'haru_share', 10);

    if ( ! function_exists('haru_woocommerce_before_customer_login_form') ) {
        function haru_woocommerce_before_customer_login_form() {
            echo '<div class="customer_login_form_wrap">';
        }
        add_action('woocommerce_before_customer_login_form','haru_woocommerce_before_customer_login_form',10);
    }

    if ( ! function_exists('haru_woocommerce_after_customer_login_form') ) {
        function haru_woocommerce_after_customer_login_form() {
            echo '</div>';
        }
        add_action('woocommerce_after_customer_login_form','haru_woocommerce_after_customer_login_form',10);
    }

    /*-----------------------------------
     * 16. Paging Load More Product
     *-----------------------------------*/
    if ( ! function_exists('haru_paging_load_more_product') ) {
        function haru_paging_load_more_product($products) {
            // Don't print empty markup if there's only one page.
            if ( $products->max_num_pages < 2 ) {
                return;
            }
            $link = get_next_posts_page_link($products->max_num_pages);
            if (!empty($link)) :
                ?> 
                    <button data-href="<?php echo esc_url($link); ?>" type="button"  data-loading-text="<span class='fa fa-spinner fa-spin'></span> <?php echo esc_html__( 'Loading...','haru-circle' ); ?>" class="product-load-more">
                        <?php echo esc_html__( 'Load More', 'haru-circle' ); ?>
                    </button>
            <?php
            endif;
        }
    }

    /*-----------------------------------
     * 17. Paging Infinite Scroll Product
     *-----------------------------------*/
    if ( ! function_exists('haru_paging_infinitescroll_product') ) {
        function haru_paging_infinitescroll_product($products) {
            // Don't print empty markup if there's only one page.
            if ( $products->max_num_pages < 2 ) {
                return;
            }
            $link = get_next_posts_page_link($products->max_num_pages);
            if (!empty($link)) :
                ?>
                <nav id="infinite_scroll_button">
                    <a href="<?php echo esc_url($link); ?>"></a>
                </nav>
                <div id="infinite_scroll_loading" class="text-center infinite-scroll-loading"></div>
            <?php
            endif;
        }
    }

    /*-----------------------------------
     * 18. Paging Nav Product
     *-----------------------------------*/
    if ( ! function_exists( 'haru_paging_nav_product' ) ) {
        function haru_paging_nav_product($products) {
            global $wp_rewrite;
            // Don't print empty markup if there's only one page.
            if ( $products->max_num_pages < 2 ) {
                return;
            }

            $paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
            $pagenum_link = html_entity_decode( get_pagenum_link() );
            $query_args   = array();
            $url_parts    = explode( '?', $pagenum_link );

            if ( isset( $url_parts[1] ) ) {
                wp_parse_str( $url_parts[1], $query_args );
            }

            $pagenum_link = esc_url(remove_query_arg( array_keys( $query_args ), $pagenum_link ));
            $pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

            $format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
            $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

            // Set up paginated links.
            $page_links = paginate_links( array(
                'base'      => $pagenum_link,
                'format'    => $format,
                'total'     => $products->max_num_pages,
                'current'   => $paged,
                'mid_size'  => 1,
                'add_args'  => array_map( 'urlencode', $query_args ),
                'prev_text' => esc_html__( 'Prev', 'haru-circle'),
                'next_text' => esc_html__( 'Next', 'haru-circle'),
                'type'      => 'array'
            ) );

            if (count($page_links) == 0) return;

            $links = "<div class='woocommerce-pagination'>";
            $links .= "<ul class='page-numbers'>\n\t<li>";
            $links .= join("</li>\n\t<li>", $page_links);
            $links .= "</li>\n</ul>\n";
            $links .= "</div>";

            return $links;
        }
    }

    /*-----------------------------------
     * 19. Category menu: Output Archive product categories menu
     *-----------------------------------*/
    function haru_category_menu() {
        global $wp_query;

        $current_cat_id = ( is_tax( 'product_cat' ) ) ? $wp_query->queried_object->term_id : '';
        $is_category = ( strlen( $current_cat_id ) > 0 ) ? true : false;
        $hide_empty = true; // @TODO: can change to option
        
        // Should top-level categories be displayed?
        haru_category_menu_output( $is_category, $current_cat_id, $hide_empty );
    }

    /*-----------------------------------
     * 19.1. Product category menu: Output
     *-----------------------------------*/
    if ( ! function_exists( 'haru_category_menu_output' ) ) {
        function haru_category_menu_output( $is_category, $current_cat_id, $hide_empty ) {
            global $wp_query;

            $page_id = wc_get_page_id( 'shop' );
            $page_url = get_permalink( $page_id );
            $hide_sub = true;
            $current_top_cat_id = null;
            $all_categories_class = '';

            // Is this a category page?                                                             
            if ( $is_category ) {
                $hide_sub = false;
                
                // Get current category's top-parent id
                $current_cat_parents = get_ancestors( $current_cat_id, 'product_cat' );
                if ( ! empty( $current_cat_parents ) ) {
                    $current_top_cat_id = end( $current_cat_parents ); // Get last item from array
                }

                // Get current category's direct children
                $current_cat_direct_children = get_terms( 'product_cat',
                    array(
                        'fields'        => 'ids',
                        'parent'        => $current_cat_id,
                        'hierarchical'  => true,
                        'hide_empty'    => $hide_empty
                    )
                );
                $category_has_children = ( empty( $current_cat_direct_children ) ) ? false : true;
            } else {
                // No current category, set "All" as current (if not product tag archive or search)
                if ( ! is_product_tag() && ! isset( $_REQUEST['s'] ) ) {
                    $all_categories_class = ' class="current-cat"';
                }
            }

            $output_cat = '<li' . $all_categories_class . '><a href="' . esc_url ( $page_url ) . '">' . esc_html__( 'All', 'haru-circle' ) . '</a></li>';
            $output_sub_cat = '';
            $output_current_sub_cat = '';

            // Categories order
            $orderby = 'slug';
            $order = 'asc';

            $categories = get_categories( array(
                'type'          => 'post',
                'orderby'       => $orderby, // Note: 'name' sorts by product category "menu/sort order"
                'order'         => $order,
                'hide_empty'    => $hide_empty,
                'hierarchical'  => 1,
                'taxonomy'      => 'product_cat'
            ) );
            
            // Categories menu divider
            $categories_menu_divider = apply_filters( 'haru_shop_categories_divider', '<span>&frasl;</span>' );

            foreach( $categories as $category ) {
                // Is this a sub-category?
                if ( $category->parent != '0' ) {
                    // Should sub-categories be included?
                    if ( $hide_sub ) {
                        continue; // Skip to next loop item
                    } else {
                        if ( 
                            $category->parent == $current_cat_id || // Include current sub-category's children
                            ! $category_has_children && $category->parent == $wp_query->queried_object->parent // Include categories with the same parent (if current sub-category doesn't have children)
                        ) {
                            $output_sub_cat .= haru_category_menu_create_list( $category, $current_cat_id, $categories_menu_divider );
                        } else if ( 
                            $category->term_id == $current_cat_id // Include current sub-category (save in a separate variable so it can be appended to the start of the category list)
                        ) {
                            $output_current_sub_cat = haru_category_menu_create_list( $category, $current_cat_id, $categories_menu_divider );
                        }
                    }
                } else {
                    $output_cat .= haru_category_menu_create_list( $category, $current_cat_id, $categories_menu_divider, $current_top_cat_id );
                }
            }

            if ( strlen( $output_sub_cat ) > 0 ) {
                $output_sub_cat = '<ul class="haru-shop-sub-categories">' . $output_current_sub_cat . $output_sub_cat . '</ul>';
            }

            $output = $output_cat . $output_sub_cat;

            echo wp_kses_post($output); // do_shortcode
        }
    }

    /*-----------------------------------
     * 19.2. Category menu: Create single category list HTML 
     *-----------------------------------*/
    if ( ! function_exists( 'haru_category_menu_create_list' ) ) {
        function haru_category_menu_create_list( $category, $current_cat_id, $categories_menu_divider, $current_top_cat_id = null ) {
            $output = '<li class="cat-item-' . $category->term_id;
            
            // Is this the current category?
            if ( $current_cat_id == $category->term_id ) {
                $output .= ' current-cat';
            }
            // Is this the current top parent-category?
            else if ( $current_top_cat_id && $current_top_cat_id == $category->term_id ) {
                $output .= ' current-parent-cat';
            }

            $output .=  '">' . $categories_menu_divider . '<a href="' . esc_url( get_term_link( (int) $category->term_id, 'product_cat' ) ) . '">' . esc_attr( $category->name ) . '</a></li>';

            return $output;
        }
    }

    /*-----------------------------------
     * 19.3. Get active shop filters count
     *-----------------------------------*/
    function haru_get_active_filters_count() {
        $count = 0;

        // WooCommerce source: "../plugins/woocommerce/includes/widgets/class-wc-widget-layered-nav-filters.php" (line 50)
        $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
        $count += isset( $_GET['min_price'] ) ? 1 : 0;
        $count += isset( $_GET['min_rating'] ) ? 1 : 0;
        // Count active terms/filters
        foreach ( $_chosen_attributes as $attributes ) {
            $count += count( $attributes['terms'] );
        }

        return $count;
    }

    /*-----------------------------------
     * 19.4. Disable redirect to product page on search results page in woocommerce
     *-----------------------------------*/
    add_filter( 'woocommerce_redirect_single_search_result', '__return_false' );

    /*-----------------------------------
     * 20. SEARCH AJAX
     *-----------------------------------*/
    if ( ! function_exists('haru_popup_search_result_callback') ) {
        function haru_popup_search_result_callback() {
            $search_box_result_amount = haru_get_option('haru_search_box_result_amount');

            if ( empty($search_box_result_amount) ) {
                $search_box_result_amount = 3;
            }
            
            $posts_per_page = $search_box_result_amount;

            $search_post_type = array();
            $haru_search_box_post_type = haru_get_option('haru_search_box_post_type');
            foreach ( $haru_search_box_post_type as $key => $post_type  ) {
                if ( $post_type == '1' ) {
                    array_push($search_post_type, $key);
                }
            }

            $keyword = $_REQUEST['keyword'];

            if ( $keyword ) {
                $search_query = array(
                    's'              => $keyword,
                    'order'          => 'DESC',
                    'orderby'        => 'date',
                    'post_status'    => 'publish',
                    'post_type'      => $search_post_type,
                    'posts_per_page' => $posts_per_page + 1, // +1 to check have more item
                );
                $search = new WP_Query( $search_query );

                if ($search && count($search->post) > 0) :
                    $count = 0;
                ?>
                <ul class="items-list">
                    <?php
                        foreach ( $search->posts as $post ) :
                            if ($count == $posts_per_page) : 
                    ?>
                        <li class="view-more">
                            <a href="<?php echo esc_url( site_url() ) .'?s=' . $keyword . '&post_type=' . implode(',', $search_post_type); ?>"><?php echo esc_html__( 'View More', 'haru-circle' ); ?></a>
                        </li>
                    <?php
                        break; 
                        else :
                    ?>
                        <li class="item d-flex justify-content-start">
                            <div class="item-thumbnail align-self-center">
                                <?php echo wp_kses_post(get_the_post_thumbnail( $post->ID, 'thumbnail' )); ?>
                            </div>
                            <div class="item-meta align-self-center">
                                <a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>"><?php echo esc_html( $post->post_title ); ?></a>
                                <p class="publish-date"><?php echo esc_html( mysql2date( 'M d Y', $post->post_date ) ); ?></p>
                            </div>
                        </li>
                    <?php
                            endif;
                        $count++;
                        endforeach;
                    ?>
                </ul>
                <?php
                else :
                ?>
                    <p class="ajax-not-found"><?php echo esc_html__( 'No items were found matching your selection.', 'haru-circle' ); ?></p>
                <?php
                endif;
            }
            wp_reset_query();
            die;
        }
        add_action( 'wp_ajax_nopriv_popup_search_result', 'haru_popup_search_result_callback' );
        add_action( 'wp_ajax_popup_search_result', 'haru_popup_search_result_callback' );

    }

    if ( ! function_exists('haru_search_product_category_callback') ) {
        function haru_search_product_category_callback() {
            // ob_start();
            $posts_per_page = 8;
            $search_box_result_amount = 3;
            // Need to option
            if ( !empty($search_box_result_amount) ) {
                $posts_per_page = $search_box_result_amount;
            }

            $keyword = $_REQUEST['keyword'];
            $cat_id  = isset($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : '-1';

            if ( $keyword ) {
                $search_query = array(
                    's'              => $keyword,
                    'order'          => 'DESC',
                    'orderby'        => 'date',
                    'post_status'    => 'publish',
                    'post_type'      => array('product'),
                    'posts_per_page' => $posts_per_page + 1,
                );
                if ( isset($cat_id) && ($cat_id != -1) ) {
                    $search_query ['tax_query'] = array(
                        array(
                            'taxonomy'         => 'product_cat',
                            'terms'            => array($cat_id),
                            'include_children' => true,
                        )
                    );
                }

                $search = new WP_Query( $search_query );

                // $newdata = array();
                if ($search && count($search->post) > 0) :
                    $count = 0;
                ?>
                <ul class="items-list">
                    <?php
                        foreach ( $search->posts as $post ) :
                            if ($count == $posts_per_page) : 
                                $category = get_term_by('id', $cat_id, 'product_cat', 'ARRAY_A');
                                $cate_slug = isset($category['slug']) ? '&amp;product_cate=' . $category['slug'] : '';
                    ?>
                        <li class="view-more">
                            <a href="<?php echo esc_url( site_url() ) .'?s=' . $keyword . '&amp;post_type=product' . $cate_slug; ?>"><?php echo esc_html__( 'View More', 'haru-circle' ); ?></a>
                        </li>
                    <?php
                        break; 
                        else :
                    ?>
                        <li class="item d-flex justify-content-start">
                            <div class="item-thumbnail align-self-center">
                                <?php echo wp_kses_post(get_the_post_thumbnail( $post->ID, 'thumbnail' )); ?>
                            </div>
                            <div class="item-meta align-self-center">
                                <a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>"><?php echo esc_html( $post->post_title ); ?></a>
                                <p class="publish-date"><?php echo esc_html( mysql2date( 'M d Y', $post->post_date ) ); ?></p>
                            </div>
                        </li>
                    <?php
                            endif;
                        $count++;
                        endforeach;
                    ?>
                </ul>
                <?php
                else :
                ?>
                    <p class="ajax-not-found"><?php echo esc_html__( 'No products were found matching your selection.', 'haru-circle' ); ?></p>
                <?php
                endif;
            }
            wp_reset_postdata();
            die;
        }
        add_action( 'wp_ajax_nopriv_search_product_category', 'haru_search_product_category_callback' );
        add_action( 'wp_ajax_search_product_category', 'haru_search_product_category_callback' );
    }

    /*-----------------------------------
     * 21. Get products by category slug
     *-----------------------------------*/


     /*---------------------------------------------------
    /* 24. Product Quick View Template
    /*---------------------------------------------------*/
    add_action('wp_ajax_load_quickview_content', 'haru_load_quickview_content_callback' );
    add_action('wp_ajax_nopriv_load_quickview_content', 'haru_load_quickview_content_callback' );
    function haru_load_quickview_content_callback() {
        global $post, $product;

        $prod_id = absint($_GET['product_id']);
        $post    = get_post( $prod_id );
        $product = get_product( $prod_id );

        if( $prod_id <= 0 ){
            die('Invalid Products');
        }
        if( !isset($post->post_type) || strcmp($post->post_type,'product') != 0 ){
            die('Invalid Products');
        }
        
        $_wrapper_class = "popup-product-quick-view-wrapper product type-{$product->get_type()}";

        // Set default
        $single_product_style = 'horizontal';
        $single_product_thumbnail_position = 'thumbnail-left';

        ob_start(); 
        ?>      

        <div class="woocommerce">
            <div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class($_wrapper_class); ?>>
                <div class="woocomerce-quickview-info">
                    <div class="single-product-image-wrap <?php echo esc_attr($single_product_style . ' ' . $single_product_thumbnail_position); ?>">
                        <?php
                            /**
                             * woocommerce_before_single_product_summary hook.
                             *
                             * @hooked woocommerce_show_product_sale_flash - 10
                             * @hooked woocommerce_show_product_images - 20
                             */
                            do_action( 'woocommerce_before_single_product_summary' );
                        ?>
                    </div>

                    <div class="summary entry-summary">
                        <?php
                            /**
                             * woocommerce_single_product_summary hook.
                             *
                             * @hooked woocommerce_template_single_title - 5
                             * @hooked woocommerce_template_single_rating - 10
                             * @hooked woocommerce_template_single_price - 10
                             * @hooked woocommerce_template_single_excerpt - 20
                             * @hooked woocommerce_template_single_add_to_cart - 30
                             * @hooked woocommerce_template_single_meta - 40
                             * @hooked woocommerce_template_single_sharing - 50
                             */
                            do_action( 'woocommerce_single_product_summary' );
                        ?>

                    </div><!-- .summary -->
                </div>
                <meta itemprop="url" content="<?php the_permalink(); ?>" />

            </div><!-- #product-<?php the_ID(); ?> -->
        </div>
            
        <?php

        $return_html = ob_get_clean();
        wp_reset_postdata();
        die($return_html);
    }     

}
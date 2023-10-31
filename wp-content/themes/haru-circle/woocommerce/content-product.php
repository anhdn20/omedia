<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}
?>
<li <?php wc_product_class( '', $product ); ?>>
    <div class="product-inner">
        <?php
        /**
         * woocommerce_before_shop_loop_item hook.
         *
         * @hooked woocommerce_template_loop_product_link_open - 10 (removed in woocommerce-functions.php)
         */
        do_action( 'woocommerce_before_shop_loop_item' );
        ?>
        <div class="product-thumbnail">
            <?php
            /**
             * woocommerce_before_shop_loop_item_title hook.
             *
             * @hooked woocommerce_show_product_loop_sale_flash - 10
             * @hooked woocommerce_template_loop_product_thumbnail - 10
             */
            add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 5 );
            remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
            add_action( 'woocommerce_before_shop_loop_item_title', 'haru_woocommerce_template_loop_product_thumbnail', 10);
            add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 10 );
            add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 ); // Rating
            do_action( 'woocommerce_before_shop_loop_item_title' );
            ?>
            <div class="product-varations">
                <?php
                /**
                 * haru_woocommerce_product_variations hook
                 *
                 * @hooked haru_product_attribute_variation - 5
                 */
                do_action( 'haru_woocommerce_product_variations' );
                ?>
            </div>
            <div class="product-actions">
                <?php
                /**
                 * haru_woocommerce_product_actions hook
                 *
                 * @hooked haru_woocomerce_template_loop_compare - 5
                 * @hooked haru_woocomerce_template_loop_wishlist - 10
                 * @hooked woocommerce_template_loop_add_to_cart - 20
                 * @hooked haru_woocomerce_template_loop_quick_view - 25
                 */
                do_action( 'haru_woocommerce_product_actions' );
                ?>
            </div>
        </div>
        
        <div class="product-info">
            <?php
            /**
             * woocommerce_shop_loop_item_title hook.
             *
             * @hooked woocommerce_template_loop_product_title - 10
             */
            add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 5 );
            add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 15 );
            do_action( 'woocommerce_shop_loop_item_title' );
            /**
             * woocommerce_after_shop_loop_item_title hook.
             *
             * @hooked woocommerce_template_loop_rating - 5
             * @hooked woocommerce_template_loop_price - 10
             */

            remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
            do_action( 'woocommerce_after_shop_loop_item_title' );
            
            if ( is_shop() || is_product_category() || is_product_tag() ) {
                the_excerpt();
            }
        ?>


        </div>
        <?php
        /**
         * woocommerce_after_shop_loop_item hook.
         *
         * @hooked woocommerce_template_loop_product_link_close - 5 (removed in woocommerce-functions.php)
         * @hooked woocommerce_template_loop_add_to_cart - 10 (removed in woocommerce-functions.php)
         */
        do_action( 'woocommerce_after_shop_loop_item' );
        ?>
    </div>
</li>

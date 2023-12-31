<?php
/**
 * Single Product Sale Flash
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/sale-flash.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $post, $product;

$product_new = get_post_meta( get_the_ID(), 'haru_product_new', true );
$product_hot = get_post_meta( get_the_ID(), 'haru_product_hot', true );

?>
<div class="product-label">
<?php if ( $product->is_on_sale() ) : ?>

    <?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale!', 'haru-circle' ) . '</span>', $post, $product ); ?>

<?php endif; ?>

<?php if ( $product_new == 'yes' ) : ?>

    <span class="on-new product-flash"><?php echo esc_html__( 'New', 'haru-circle' ) ?></span>

<?php endif; ?>

<?php if ( $product_hot == 'yes' ) : ?>

    <span class="on-hot product-flash"><?php echo esc_html__( 'Hot', 'haru-circle' ) ?></span>

<?php endif; ?>

<?php if ( !$product->is_in_stock() ) : ?>

    <span class="on-sold product-flash"><?php echo esc_html__( 'Sold', 'haru-circle' ) ?></span>

<?php endif; ?>
</div>
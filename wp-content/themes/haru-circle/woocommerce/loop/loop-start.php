<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
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
 * @version     3.3.0
 */

$product_class                   = array();

// Process add columns class for shop page
if ( is_shop() || is_product_category() || is_product_tag() ) {
    $archive_product_display_columns = haru_get_option('haru_product_display_columns');
    // Set default
    if ( empty($archive_product_display_columns) ) {
        $archive_product_display_columns = '3';
    };
    $product_class[] = 'archive-product-columns-' . $archive_product_display_columns;
}
$product_classes = join(' ', $product_class);
?>
<ul class="products <?php echo esc_attr($product_classes); ?>" >
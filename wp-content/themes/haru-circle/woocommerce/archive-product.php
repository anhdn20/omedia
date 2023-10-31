<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Process display type and display columns and paging style
$archive_product_style           = haru_get_option('haru_archive_product_style') ? haru_get_option('haru_archive_product_style') : 'default';
// Set default
if ( empty($archive_product_style) ) {
    $archive_product_style = 'default';
}

if ( $archive_product_style == 'default' ) {
    wc_get_template_part( 'archive', 'product-default' );
} else {
    wc_get_template_part( 'archive', 'product-ajax' );
}
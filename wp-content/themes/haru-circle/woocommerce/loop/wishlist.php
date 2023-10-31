<?php
$product_add_wishlist = haru_get_option('haru_product_add_wishlist');
// Set default
if ( !isset($product_add_wishlist) && empty($product_add_wishlist) ) {
	$product_add_wishlist = 1;
}
if ($product_add_wishlist == 0) {
    return; // Don't show wishlist button
}

if ( class_exists( 'YITH_WCWL' ) ) {
    echo do_shortcode('[yith_wcwl_add_to_wishlist icon=""]');
}
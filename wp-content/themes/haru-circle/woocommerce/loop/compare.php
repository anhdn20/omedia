<?php
$product_add_to_compare = haru_get_option('haru_product_add_to_compare');
// Set default
if ( !isset($product_add_to_compare) && empty($product_add_to_compare) ) {
	$product_add_to_compare = 1;
}
if ( $product_add_to_compare == 0 ) {
    return; // Don't show compare button
}
?>
<?php if ( in_array('yith-woocommerce-compare/init.php', apply_filters('active_plugins', get_option('active_plugins'))) ) : ?>
   	<?php 
   		if( class_exists('YITH_Woocompare') ) {
			global $yith_woocompare;
			$is_ajax = ( defined( 'DOING_AJAX' ) && DOING_AJAX );
			if ( $yith_woocompare->is_frontend() || $is_ajax ) {
				if ( $is_ajax ) {
					// @TODO: update woocommerce cause this doesn't work: $yith_woocompare->obj = new YITH_Woocompare_Frontend();
					return;
				}
				if ( wp_is_mobile() ) {
					return;
				}
				global $yith_woocompare, $product;

				echo '<div class="button-in compare add_to_compare">';
				echo '<a class="compare" href="' . esc_url( $yith_woocompare->obj->add_product_url( $product->get_id() ) ) . '" data-product_id="'.$product->get_id().'">'.'<i class="ti-control-shuffle"></i><span class="haru-tooltip button-tooltip">'.get_option('yith_woocompare_button_text').'</span></a>';
				echo '</div>';
			}
		}
   	?>
<?php endif; ?>
<?php
$product_quick_view = haru_get_option('haru_product_quick_view');
// Set default
if ( !isset($product_quick_view) && empty($product_quick_view) ) {
	$product_quick_view = 1;
}
if ( $product_quick_view == 0 ) {
    return;
}

global $product;

$href = admin_url('admin-ajax.php', is_ssl()?'https':'http') . '?ajax=true&action=load_quickview_content&product_id=' . $product->get_id();
echo '<div class="button-in quickview">';
echo '<a class="quickview" href="'.esc_url($href).'"><i class="ion ion-md-search"></i><span class="haru-tooltip button-tooltip">' . esc_html__('Quick view', 'haru-circle').'</span></a>';
echo '</div>';
<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
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

// Process single product layout
$single_product_layout = isset($_GET['layout']) ? $_GET['layout'] : '';
if ( !in_array($single_product_layout, array('full', 'container')) ) {
    $single_product_layout = get_post_meta( get_the_ID(), 'haru_' . 'page_layout', true );
    if ( ($single_product_layout == '') || ($single_product_layout == '-1') ) {
        $single_product_layout = haru_get_option('haru_single_product_layout');
    }
}
// Set Default
if ( empty($single_product_layout) ) {
    $single_product_layout = 'container';
}

// Process single product sidebar
$single_product_sidebar = isset($_GET['sidebar']) ? $_GET['sidebar'] : '';
if ( !in_array($single_product_sidebar, array('none', 'left', 'right')) ) {
    $single_product_sidebar = get_post_meta( get_the_ID(), 'haru_' . 'page_sidebar', true );
    if ( ($single_product_sidebar == '') || ($single_product_sidebar == '-1') ) {
        $single_product_sidebar = haru_get_option('haru_single_product_sidebar');
    }
}
// Set Default
if ( empty($single_product_sidebar) ) {
    $single_product_sidebar = 'none';
}

$single_product_left_sidebar = get_post_meta( get_the_ID(), 'haru_' . 'page_left_sidebar', true );
if ( ($single_product_left_sidebar == '') || ($single_product_left_sidebar == '-1') ) {
    $single_product_left_sidebar = haru_get_option('haru_single_product_left_sidebar');
}
// Set Default
if ( empty($single_product_left_sidebar) ) {
    $single_product_left_sidebar = 'woocommerce';
}

$single_product_right_sidebar = get_post_meta( get_the_ID(), 'haru_'.'page_right_sidebar', true );
if ( ($single_product_right_sidebar == '') || ($single_product_right_sidebar == '-1') ) {
    $single_product_right_sidebar = haru_get_option('haru_single_product_right_sidebar');
}
// Set Default
if ( empty($single_product_right_sidebar) ) {
    $single_product_right_sidebar = 'woocommerce';
}

// Calculate sidebar column & content column
$single_product_content_columns = 12;
if( $single_product_sidebar != 'none' && (is_active_sidebar( $single_product_left_sidebar ) || is_active_sidebar( $single_product_right_sidebar )) ) {
    $single_product_content_columns = 9;
} else {
    $single_product_content_columns = 12;
}

get_header( 'shop' ); ?>

<?php
/**
 * @hooked - haru_page_heading - 5
 **/
do_action('haru_before_page');
?>
<div class="haru-single-product">

    <div class="<?php echo esc_attr($single_product_layout) ?> clearfix">

        <?php if ( ($single_product_content_columns != 12) || ($single_product_layout != 'full') ) : ?>
        <div class="row clearfix">
        <?php endif;?>

            <div class="single-product-content col-md-<?php echo esc_attr($single_product_content_columns); ?> <?php if( is_active_sidebar( $single_product_left_sidebar ) && ($single_product_sidebar == 'left') ) echo esc_attr('has-left-sidebar'); ?> col-sm-12 col-xs-12">
                <?php
                    /**
                     * woocommerce_before_main_content hook.
                     *
                     * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
                     * @hooked woocommerce_breadcrumb - 20
                     */
                    // Removed
                ?>
                <div class="single-product-inner">
                    <?php while ( have_posts() ) : the_post(); ?>

                        <?php wc_get_template_part( 'content', 'single-product' ); ?>

                    <?php endwhile; // end of the loop. ?>
                </div>
                <?php
                    /**
                     * woocommerce_after_main_content hook.
                     *
                     * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
                     */
                    // Removed
                ?>
            </div>
            <?php if (is_active_sidebar( $single_product_left_sidebar ) && ($single_product_sidebar == 'left') ) : ?>
                <div class="single-product-sidebar woocommerce-sidebar left-sidebar col-md-3 col-sm-12 col-xs-12">
                    <?php dynamic_sidebar( $single_product_left_sidebar ); ?>
                </div>
            <?php endif; ?>

            <?php if ( is_active_sidebar( $single_product_right_sidebar ) && ($single_product_sidebar == 'right') ) : ?>
                <div class="single-product-sidebar woocommerce-sidebar right-sidebar col-md-3 col-sm-12 col-xs-12">
                    <?php dynamic_sidebar( $single_product_right_sidebar ); ?>
                </div>
            <?php endif; ?>

        <?php if ( ($single_product_content_columns != 12) || ($single_product_layout != 'full') ) : ?>
        </div>
        <?php endif;?>

    </div>

</div>
<?php get_footer( 'shop' ); ?>
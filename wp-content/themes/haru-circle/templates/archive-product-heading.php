<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

$show_archive_product_title = haru_get_option('haru_show_archive_product_title');
$page_sub_title             = strip_tags(term_description());
// Set Default
if ( !isset($show_archive_product_title) && empty($show_archive_product_title) ) {
    $show_archive_product_title = 1;
}

// Archive product title layout
$section_page_title_class     = array('haru-page-title-section');
$archive_product_title_layout = haru_get_option('haru_archive_product_title_layout');
if ( in_array( $archive_product_title_layout, array('container') ) ) {
    $section_page_title_class[] = $archive_product_title_layout;
}

// Archive Product page title background image
$page_title_bg_image = $page_title_bg_image_url = '';
$cat                 = get_queried_object();
if ( $cat && property_exists( $cat, 'term_id' ) ) {
    $page_title_bg_image = get_tax_meta( $cat, 'haru_'.'page_title_background' ); // Category page title
}
if( !$page_title_bg_image || $page_title_bg_image === '' ) {
    $page_title_bg_image = haru_get_option('haru_archive_product_title_bg_image');
}
if ( isset($page_title_bg_image) && isset($page_title_bg_image['url']) ) {
    $page_title_bg_image_url = $page_title_bg_image['url'];
}
// Set default
if ( empty($page_title_bg_image_url) ) {
    $page_title_bg_image_url = '';
}

$page_title_wrap_class     = array();
$page_title_wrap_class[]   = 'haru-page-title-wrapper';

$custom_styles = array();

if ( $page_title_bg_image_url != '' ) {
    $page_title_wrap_class[] = 'page-title-wrap-bg';
    $custom_styles[]         = 'background-image: url(' . $page_title_bg_image_url . ');';
}

$custom_style = '';
if ($custom_styles) {
    $custom_style = 'style="'. join(';',$custom_styles).'"';
}

// Archive product page title parallax
$page_title_parallax = haru_get_option('haru_archive_product_title_parallax');
if ( !empty($page_title_bg_image_url) && ($page_title_parallax == '1') ) {
    $custom_style            .= ' data-stellar-background-ratio="0.5"';
    $page_title_wrap_class[] = 'page-title-parallax';
}

// Archive product page title breadcrumbs
$breadcrumbs_in_archive_product_title = haru_get_option('haru_breadcrumbs_in_archive_product_title');
$breadcrumb_class                     = array('haru-breadcrumb-wrapper breadcrumb-archive-product-wrap');

// Add class for style when not use breadcrumbs
if ( $breadcrumbs_in_archive_product_title != 1 ) {
    $page_title_wrap_class[] = 'no-breadcrumbs';
}
// Check if header is header sidebar
$haru_header_layout = haru_get_header_layout();
if( ( $haru_header_layout == 'header-8' ) || ( $haru_header_layout == 'header-9' ) || ( $haru_header_layout == 'header-10' ) ) {
    $title_layout = 'full';
} else {
    $title_layout = 'container';
}
?>
<?php if ( ($show_archive_product_title == 1) || ($breadcrumbs_in_archive_product_title == 1) ) : ?>
    <div class="<?php echo esc_attr( join(' ',$section_page_title_class) ); ?>" <?php echo wp_kses_post($custom_style); ?>>
    <?php if ( $show_archive_product_title == 1 ) : ?>
        <section class="<?php echo esc_attr( join(' ',$page_title_wrap_class) ); ?>">
            <div class="<?php echo esc_attr( $title_layout ); ?>">
                <div class="page-title-inner">
                    <div class="block-center-inner">
                        <h2><?php woocommerce_page_title(); ?></h2>
                        <?php if ( $page_sub_title != '' ) : ?>
                            <span class="page-sub-title"><?php echo esc_html($page_sub_title); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
    <?php if ($breadcrumbs_in_archive_product_title == 1) : ?>
        <div class="<?php echo esc_attr( join(' ', $breadcrumb_class) ); ?>">
            <div class="<?php echo esc_attr( $title_layout ); ?>">
                <?php get_template_part( 'templates/breadcrumb' ); ?>
            </div>
        </div>
    <?php endif; ?>
    </div>
<?php endif; ?>
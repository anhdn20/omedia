<?php
/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/
extract( $atts );

global $wp, $paged;
            
if ( is_front_page() ) {
    $paged   = get_query_var( 'page' ) ? intval( get_query_var( 'page' ) ) : 1;
} else {
    $paged   = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
}

if ( $item == '' ) {
    $posts_per_page = -1;
} else {
    $posts_per_page = $item;
}

// Portfolio source
$args = array(
    'orderby'        => 'post__in',
    'post__in'       => explode(',', $portfolio_ids),
    'posts_per_page' => $posts_per_page,
    'post_type'      => 'haru_portfolio',
    'paged'          => $paged,
    'order'          => $order,
    'post_status'    => 'publish'
);

// Source from category
if ($data_source == '') {
    $args = array(
        'posts_per_page'     => $posts_per_page,
        'orderby'            => 'post_date',
        'order'              => $order,
        'post_type'          => 'haru_portfolio',
        'paged'              => $paged,
        'post_status'        => 'publish'
    );
    $args['tax_query'] = array(
        'relation' => 'AND',
        array(
            'taxonomy' => 'portfolio_category',
            'field'    => 'slug',
            'terms'    => explode(',', $category),
        ),
    );
}
// Source from tag
if ($data_source == 'tag') {
    $args = array(
        'posts_per_page'     => $posts_per_page,
        'orderby'            => 'post_date',
        'order'              => $order,
        'post_type'          => 'haru_portfolio',
        'paged'              => $paged,
        'post_status'        => 'publish'
    );
    $args['tax_query'] = array(
        'relation' => 'AND',
        array(
            'taxonomy' => 'portfolio_tag',
            'field'    => 'slug',
            'terms'    => explode(',', $portfolio_tag),
        ),
    );
}

$portfolios = new WP_Query($args);
$col_class  = 'haru-col-' . $column;
$sc_id = uniqid();

// Equeue assets
wp_enqueue_style( 'ladda-css', plugins_url() . '/haru-circle-core/includes/shortcodes/posttypes/portfolio/assets/js/ladda/dist/ladda-themeless.min.css', array(), false );
wp_enqueue_style( 'magnific-popup', get_template_directory_uri() . '/assets/libraries/magnificPopup/magnific-popup.css', array() );
wp_enqueue_script( 'magnific-popup', get_template_directory_uri() . '/assets/libraries/magnificPopup/jquery.magnific-popup.min.js', array(), false, true);
wp_enqueue_script( 'isotope-packery-mode', plugins_url() . '/haru-circle-core/includes/shortcodes/posttypes/portfolio/assets/js/packery-mode.pkgd.min.js', false, true );
wp_enqueue_script( 'haru-ladda-spin', plugins_url() . '/haru-circle-core/includes/shortcodes/posttypes/portfolio/assets/js/ladda/dist/spin.min.js', false, true );
wp_enqueue_script( 'ladda', plugins_url() . '/haru-circle-core/includes/shortcodes/posttypes/portfolio/assets/js/ladda/dist/ladda.min.js', false, true );

wp_enqueue_script( 'haru-portfolio-ajax-action', plugins_url() . '/haru-circle-core/includes/shortcodes/posttypes/portfolio/assets/js/ajax-action.js', false, true );

?>
<div class="portfolio-shortcode-wrap <?php echo esc_attr( $portfolio_thumbnail . ' ' . $el_class ); ?>"
    data-filter-style="<?php echo esc_attr( $filter_style ); ?>"
    data-sc-id="<?php echo esc_attr( $sc_id ); ?>"
    >
    <div class="portfolio">
        <!-- Portfolio Filter -->
        <?php if ( $show_filter != '' ) : ?>
        <div class="portfolio-tabs clearfix <?php echo esc_attr( $filter_by ); ?>">
            <?php echo haru_get_template('posttypes/portfolio/filter/filter-'. $filter_by .'.php', array('atts' => $atts, 'sc_id' => $sc_id), '', '' ); ?>
        </div>
        <?php endif; ?>

        <!-- Portfolio Wrap -->
        <div class="portfolio-wrapper <?php echo sprintf('%s %s %s', $col_class, $padding, $portfolio_thumbnail) ?>" 
            id="portfolio-<?php echo esc_attr( $sc_id ); ?>"
            data-columns="<?php echo esc_attr($column); ?>">
            <?php while ($portfolios->have_posts()) : $portfolios->the_post(); ?>
                <?php echo haru_get_template('posttypes/portfolio/loop/'. $portfolio_thumbnail .'-item.php', array('atts' => $atts, 'sc_id' => $sc_id), '', '' ); ?>
            <?php endwhile; ?>
        </div>

        <!-- Pagination -->
        <?php if ( ( $portfolios->max_num_pages > 1 ) && ( $show_pagging == '1') ) : ?>
            <div class="portfolio-loadmore-wrap" id="portfolio-loadmore-<?php echo esc_attr( $sc_id ); ?>">
                <?php haru_paging_load_more_portfolio($portfolios); ?>
            </div>
        <?php endif; ?>
    </div>
</div>
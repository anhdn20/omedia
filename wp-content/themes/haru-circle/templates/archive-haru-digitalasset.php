<?php 
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

// Process Archive layout
$archive_layout = isset($_GET['layout']) ? $_GET['layout'] : '';
if ( !in_array($archive_layout, array('full','container')) ) {
    $archive_layout = haru_get_option('archive_digitalasset_layout');
}
// Set Default
if ( empty($archive_layout) ) {
    $archive_layout = 'container';
}

// Process sidebar
$archive_sidebar = isset($_GET['sidebar']) ? $_GET['sidebar'] : '';
if( !in_array($archive_sidebar, array('none','left','right')) ) {
    $archive_sidebar = haru_get_option('archive_digitalasset_sidebar');
}
// Set Default
if ( empty($archive_sidebar) ) {
    $archive_sidebar = 'left';
}

$archive_left_sidebar  = haru_get_option('archive_digitalasset_left_sidebar');
$archive_right_sidebar = haru_get_option('archive_digitalasset_right_sidebar');
// Set Default
if ( empty($archive_left_sidebar) ) {
    $archive_left_sidebar = 'sidebar-1';
}

if( $archive_sidebar != 'none' && (is_active_sidebar( $archive_left_sidebar ) || is_active_sidebar( $archive_right_sidebar )) ) {
    $archive_content_col = 9;
} else {
    $archive_content_col = 12;
}

// Process display type and display columns and paging style
$archive_display_type = haru_get_option('archive_digitalasset_display_type');
// Set Default
if ( empty($archive_display_type) ) {
    $archive_display_type = 'grid';
}

$archive_display_columns = isset($_GET['columns']) ? $_GET['columns'] : '';
if ( !in_array($archive_display_columns, array('2','3','4')) ) {
    $archive_display_columns = haru_get_option('archive_digitalasset_display_columns');
}

// Process paging
$archive_paging_style = isset($_GET['paging']) ? $_GET['paging'] : '';
if ( !in_array($archive_paging_style, array('default','load-more','infinity-scroll')) ) {
    $archive_paging_style = haru_get_option('archive_digitalasset_paging_style');
}
// Set Default
if ( empty($archive_paging_style) ) {
    $archive_paging_style = 'default';
}

// lấy danh sách danh mục
$digitalasset_categories = get_categories(array(
    'taxonomy' => 'digitalasset_category', // Thay thế bằng tên taxonomy của bạn
));

// xử lý filter và sort

$category_digitalasset = isset($_GET['digital-category']) ? sanitize_text_field($_GET['digital-category']) : '';
$sort_digitalasset = isset($_GET['digital-sort']) ? sanitize_text_field($_GET['digital-sort']) : '';

$args = array(
    'post_type' => 'haru_digitalasset',
    'posts_per_page' => -1,
    'orderby' => $sort,
);

if (!empty($category_digitalasset)) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'digitalasset_category', // Thay thế bằng tên taxonomy của bạn
            'field' => 'slug',
            'terms' => $category_digitalasset,
        )
    );
}

$query_posts = new WP_Query($args);


// echo '<pre>';
// var_dump($args);
// die;

?>
<?php 
    /*
    *   @hooked - haru_archive_heading - 5
    */
    do_action( 'haru_before_archive' );
?>
<div class="haru-archive-blog digitalasset">
    <?php if( $archive_layout != 'full' ) : ?>
        <div class="<?php echo esc_attr($archive_layout) ?> ">
    <?php endif; ?>
        <?php if( ($archive_content_col != 12) || ($archive_layout != 'full') ) : ?>
            <div class="row">
        <?php endif; ?>
                <!-- Archive content -->
                <div class="archive-content col-md-<?php echo esc_attr($archive_content_col); ?> <?php if( is_active_sidebar( $archive_left_sidebar ) && ($archive_sidebar == 'left') ) echo esc_attr('has-left-sidebar'); ?> col-sm-12 col-xs-12">
                    <div class="archive-content-layout layout-style-<?php echo esc_attr($archive_display_type); ?>">
                        <div class="digitalasset-filter-sort">
                            <form id="digital-filter-form" method="get">
                                <select name="digital-category" id="digital-category" onchange="submitFormFilterSortDigitalAsset()">
                                    <option value=""><?=__('All')?></option>
                                    <?php foreach($digitalasset_categories as $v): ?>
                                        <option value="<?=$v->slug?>" <?php if(isset($_GET['digital-category']) && $_GET['digital-category'] == $v->slug) echo 'selected'; ?>><?=$v->name?></option>
                                    <?php endforeach;?>
                                    <!-- <span class="dashicons dashicons-arrow-down-alt2"></span> -->
                                </select>
                                
                                <select name="digital-sort" id="digital-sort"  onchange="submitFormFilterSortDigitalAsset()">
                                    <option value=""><?php echo __('Sort by') ?></option>
                                    <option value="asc"><?php echo __('Price: Low to high') ?></option>
                                    <option value="desc"><?php echo __('Price: High to low') ?></option>
                                    <!-- <span class="dashicons dashicons-arrow-down-alt2"></span> -->
                                </select>
                                <input type="submit" value="Lọc" style="display: none;">
                            </form>
                        </div>
                        <div class="row">
                            <?php
                                if ( $query_posts->have_posts() ) :
                                    // Start the Loop.
                                    while ( $query_posts->have_posts() ) : $query_posts->the_post();
                                        /*
                                         * Include the post format-specific template for the content. If you want to
                                         * use this in a child theme, then include a file called called content-___.php
                                         * (where ___ is the post format) and that will be used instead.
                                         */
                                        get_template_part( 'templates/archive/content' , 'haru-digitalasset' );
                                    endwhile;
                                else :
                                    // If no content, include the "No posts found" template.
                                    get_template_part( 'templates/archive/content-none');
                                endif;
                            ?>
                        </div>
                        <?php
                            global $wp_query;
                            if ( $wp_query->max_num_pages > 1 ) :
                        ?>
                            <div class="archive-paging <?php echo esc_attr($archive_paging_style); ?>">
                                <?php
                                    switch($archive_paging_style) {
                                        case 'load-more':
                                            haru_paging_load_more();
                                            break;
                                        case 'infinity-scroll':
                                            haru_paging_infinitescroll();
                                            break;
                                        default:
                                            echo haru_paging_nav();
                                            break;
                                    }
                                ?>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            <?php if ( is_active_sidebar( $archive_left_sidebar ) && ( $archive_sidebar == 'left' ) ) : ?>
                <div class="archive-sidebar left-sidebar col-md-3 col-sm-12 col-xs-12">
                    <?php dynamic_sidebar( $archive_left_sidebar );?>
                </div>
            <?php endif; ?>
            <?php if ( is_active_sidebar( $archive_right_sidebar ) && ( $archive_sidebar == 'right' ) ) : ?>
                <div class="archive-sidebar right-sidebar col-md-3 col-sm-12 col-xs-12">
                    <?php dynamic_sidebar( $archive_right_sidebar );?>
                </div>
            <?php endif; ?>
        <?php if ( ($archive_content_col != 12) || ($archive_layout != 'full') ) : ?>
            </div>
        <?php endif; ?>
    <?php if ( $archive_layout != 'full' ) : ?>
        </div>
    <?php endif; ?>
</div>
<?php
/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

add_action( 'wp_ajax_nopriv_haruframework_portfolio_filter_ajax', 'haruframework_portfolio_filter_ajax' );
add_action( 'wp_ajax_haruframework_portfolio_filter_ajax', 'haruframework_portfolio_filter_ajax' );
function haruframework_portfolio_filter_ajax() {
    // var_dump($_REQUEST);die;

    $sc_id               = $_REQUEST['sc_id'];
    $portfolio_thumbnail = $_REQUEST['thumbnail'];
    $portfolio_title     = $_REQUEST['portfolio_title'];
    $hover_style         = $_REQUEST['hover_style'];
    $column              = $_REQUEST['columns'];
    $data_source         = $_REQUEST['data_source'];
    $category            = $_REQUEST['category'];
    $portfolio_ids       = $_REQUEST['portfolio_ids'];
    $portfolio_tag       = $_REQUEST['portfolio_tag'];
    $item                = $_REQUEST['item'];
    $current_page        = $_REQUEST['current_page'];
    $show_pagging        = $_REQUEST['show_paging'];
    $order               = $_REQUEST['order'];
    $padding             = $_REQUEST['padding'];

    if ( $item == '' ) {
        $offset         = 0;
        $posts_per_page = -1;
    } else {
        $offset         = 0;
        $posts_per_page = $item;
    }

    // Portfolio source
    $args = array(
        'orderby'        => 'post__in',
        'post__in'       => explode(',', $portfolio_ids),
        'posts_per_page' => $posts_per_page,
        'post_type'      => 'haru_portfolio',
        'offset'         => $offset,
        'order'          => $order,
        'post_status'    => 'publish'
    );

    // Source from category
    if ($data_source == '') {
        $args = array(
            'offset'             => $offset,
            'posts_per_page'     => $posts_per_page,
            'orderby'            => 'post_date',
            'order'              => $order,
            'post_type'          => 'haru_portfolio',
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
            'offset'             => $offset,
            'posts_per_page'     => $posts_per_page,
            'orderby'            => 'post_date',
            'order'              => $order,
            'post_type'          => 'haru_portfolio',
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
    // var_dump($data_source);
    // var_dump($portfolio_tag);

    $atts = compact('portfolio_thumbnail', 'portfolio_title','column', 'hover_style', 'data_source', 'category', 'portfolio_ids', 'portfolio_tag', 'show_filter', 'filter_by', 'filter_style', 'show_pagging', 'item', 'order');

    $portfolios = new WP_Query($args);
    $total_post  = $portfolios->found_posts;

    echo '<div class="portfolio-wrapper id="portfolio-' . esc_attr( $sc_id ) . '">';
    while ($portfolios->have_posts()) : $portfolios->the_post(); 
        echo haru_get_template('posttypes/portfolio/loop/'. $portfolio_thumbnail .'-item.php', array('atts' => $atts), '', '' );
    endwhile;
    echo '</div>';

    // var_dump($show_pagging);
    // var_dump($posts_per_page);
    // var_dump($total_post);

?>

<?php if ($show_pagging == '1' && $posts_per_page > 0 && ($total_post / $posts_per_page) > 1) : ?>
    <div style="clear: both"></div>
    <div class="portfolio-loadmore-wrap" id="portfolio-loadmore-<?php echo esc_attr( $sc_id ); ?>">
        <a href="javascript:;" class="haru-button ladda-button load-more-ajax"
            data-thumbnail       ="<?php echo esc_attr($portfolio_thumbnail); ?>"
            data-portfolio-title ="<?php echo esc_attr($portfolio_title); ?>"
            data-hover-style     ="<?php echo esc_attr($hover_style); ?>"
            data-column          ="<?php echo esc_attr($column); ?>"
            data-source          ="<?php echo esc_attr($data_source) ?>"
            data-category        ="<?php echo esc_attr($category) ?>"
            data-portfolio-ids   ="<?php echo esc_attr($portfolio_ids) ?>"
            data-tag             ="<?php echo esc_attr($portfolio_tag); ?>"
            data-item            ="<?php echo esc_attr($item); ?>"
            data-show-paging     ="<?php echo esc_attr($show_pagging); ?>"
            data-order           ="<?php echo esc_attr($order); ?>"
            data-padding         ="<?php echo esc_attr($padding); ?>"
            data-current-page    ="<?php echo esc_attr($current_page + 1); ?>"
            data-filter-by       ="<?php echo esc_attr($filter_by); ?>"
            data-style           ="zoom-in"
            data-spinner-color   ="#fff"
        >
            <?php echo esc_html__('Load more', 'haru-circle') ?>
        </a>
    </div>
<?php endif; ?>

<?php
    wp_reset_postdata();
    die(ob_get_clean());
}


add_action( 'wp_ajax_nopriv_haruframework_portfolio_filter_ajax_loadmore', 'haruframework_portfolio_filter_ajax_loadmore' );
add_action( 'wp_ajax_haruframework_portfolio_filter_ajax_loadmore', 'haruframework_portfolio_filter_ajax_loadmore' );
function haruframework_portfolio_filter_ajax_loadmore() {
    // var_dump($_REQUEST);die;
    $sc_id               = $_REQUEST['sc_id'];
    $portfolio_thumbnail = $_REQUEST['thumbnail'];
    $portfolio_title     = $_REQUEST['portfolio_title'];
    $hover_style         = $_REQUEST['hover_style'];
    $column              = $_REQUEST['columns'];
    $data_source         = $_REQUEST['data_source'];
    $category            = $_REQUEST['category'];
    $portfolio_ids       = $_REQUEST['portfolio_ids'];
    $portfolio_tag       = $_REQUEST['portfolio_tag'];
    $item                = $_REQUEST['item'];
    $current_page        = $_REQUEST['current_page'];
    $show_pagging        = $_REQUEST['show_paging'];
    $order               = $_REQUEST['order'];
    $padding             = $_REQUEST['padding'];

    if ( $item == '' ) {
        $offset        = 0;
        $posts_per_page = -1;
    } else {
        $posts_per_page = $item;
        $offset         = ($current_page - 1) * $item;
    }


    $args = array(
        'orderby'        => 'post__in',
        'post__in'       => explode(',', $portfolio_ids),
        'posts_per_page' => $posts_per_page,
        'post_type'      => 'haru_portfolio',
        'order'          => $order,
        'post_status'    => 'publish'
    );

    // Source from category
    if ($data_source == '') {
        $args = array(
            'offset'             => $offset,
            'posts_per_page'     => $posts_per_page,
            'orderby'            => 'post_date',
            'order'              => $order,
            'post_type'          => 'haru_portfolio',
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
            'offset'             => $offset,
            'posts_per_page'     => $posts_per_page,
            'orderby'            => 'post_date',
            'order'              => $order,
            'post_type'          => 'haru_portfolio',
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
    var_dump($data_source);
    var_dump($portfolio_tag);



    $atts = compact('portfolio_thumbnail', 'portfolio_title','column', 'hover_style', 'data_source', 'category', 'portfolio_ids', 'portfolio_tag', 'show_filter', 'filter_by', 'filter_style', 'show_pagging', 'item', 'order', 'show_pagging');

    $portfolios = new WP_Query($args);
    $total_post  = $portfolios->found_posts;

    echo '<div class="portfolio-wrapper id="portfolio-' . esc_attr( $sc_id ) . '">';
    while ($portfolios->have_posts()) : $portfolios->the_post(); 
        echo haru_get_template('posttypes/portfolio/loop/'. $portfolio_thumbnail .'-item.php', array('atts' => $atts), '', '' );
    endwhile;
    echo '</div>';

    // var_dump($show_pagging);
    // var_dump($offset);
    // var_dump($current_page);
    // var_dump($posts_per_page);
    // var_dump($total_post);

?>

<?php if ($show_pagging == '1' && $posts_per_page > 0 && ($total_post / $posts_per_page) > 1 && $total_post > ($posts_per_page * $current_page) ) : ?>
    <div style="clear: both"></div>
    <div class="portfolio-loadmore-wrap">
        <a href="javascript:;" class="haru-button ladda-button load-more-ajax"
            data-thumbnail       ="<?php echo esc_attr($portfolio_thumbnail); ?>"
            data-portfolio-title ="<?php echo esc_attr($portfolio_title); ?>"
            data-hover-style     ="<?php echo esc_attr($hover_style); ?>"
            data-column          ="<?php echo esc_attr($column); ?>"
            data-source          ="<?php echo esc_attr($data_source) ?>"
            data-category        ="<?php echo esc_attr($category) ?>"
            data-portfolio-ids   ="<?php echo esc_attr($portfolio_ids) ?>"
            data-tag             ="<?php echo esc_attr($portfolio_tag); ?>"
            data-item            ="<?php echo esc_attr($item); ?>"
            data-show-paging     ="<?php echo esc_attr($show_pagging); ?>"
            data-order           ="<?php echo esc_attr($order); ?>"
            data-padding         ="<?php echo esc_attr($padding); ?>"
            data-current-page    ="<?php echo esc_attr($current_page + 1) ?>"
            data-filter-by       ="<?php echo esc_attr($filter_by); ?>"
            data-style           ="zoom-out" 
            data-spinner-color   ="#fff"
        >
            <?php echo esc_html__('Load more', 'haru-circle') ?>
        </a>
    </div>
<?php endif; ?>

<?php
    wp_reset_postdata();
    die(ob_get_clean());
}


/*-----------------------------------
 * 4. Paging Load More Portfolio
 *-----------------------------------*/
if ( ! function_exists('haru_paging_load_more_portfolio') ) {
    function haru_paging_load_more_portfolio( $posts ) {
        // Don't print empty markup if there's only one page.
        if ( $posts->max_num_pages < 2 ) {
            return;
        }
        $link = get_next_posts_page_link($posts->max_num_pages);
        if (!empty($link)) :
            ?> 
                <a href="javascript:;"
                    data-href="<?php echo esc_url($link); ?>" 
                    class="haru-button ladda-button portfolio-load-more"
                    data-style           ="zoom-out" 
                    data-spinner-color   ="#fff"
                >
                    <?php echo esc_html__( 'Load More', 'haru-circle' ); ?>
                </a>
        <?php
        endif;
    }
}
<?php
/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

$index        = 0;
$column       = 4;
$image_size   = '600x400';
$show_pagging = '2';
$item         = 4;

$args = array(
    'post__not_in'           => array($post_id),
    'posts_per_page'         => -1,
    'orderby'                => 'rand',
    'post_type'              => 'haru_portfolio',
    'portfolio_category__in' => $arrCatId,
    'post_status'            => 'publish'
);
$posts_array         = new WP_Query( $args );
$total_post          = $posts_array->found_posts;
$data_plugin_options = $owl_carousel_class = '';
if ( $total_post / $item > 1 ) {
    $data_plugin_options = 'data-plugin-options=\'{ "items" : ' . $column . ',"pagination": false, "navigation": true, "autoPlay": false}\'';
    $owl_carousel_class  = 'owl-carousel owl-theme';
}

$overlay_style = 'icon';
$column        = 'circle-col-md-4';
if( NULL !== haru_get_option('portfolio-related-overlay') ) {
    $overlay_style = haru_get_option('portfolio-related-overlay');
}
if( NULL !== haru_get_option('portfolio-related-column') ) {
    $column = 'circle-col-md-'.haru_get_option('portfolio-related-column');
}

$layout = 'default';
if( NULL !== haru_get_option('portfolio_related_style') && haru_get_option('portfolio_related_style') != '' ) {
    $layout = haru_get_option('portfolio_related_style');
}

$overlay_effect = 'effect_1';
if( NULL !== haru_get_option('portfolio_related_effect') && haru_get_option('portfolio_related_effect') !='' ) {
    $overlay_effect = haru_get_option('portfolio_related_effect');
}

if ($overlay_style == 'left-title-excerpt-link') {
    $overlay_align = 'hover-align-left';
}
else {
    $overlay_align = 'hover-align-center';
}

?>

<div class="container">
    <div class="portfolio-related-wrap">
        <div class="heading-wrap border-primary-color">
            <nav class="post-navigation" role="navigation">
                <div class="nav-links">
                    <?php
                    previous_post_link('<div class="nav-previous">%link</div>', _x('<div class="post-navigation-left"><i class="post-navigation-icon fa fa-long-arrow-left"></i> </div> <div class="post-navigation-content"> <div class="post-navigation-title">%title </div> </div> ', 'Previous post link', 'haru-circle'));
                    echo '<i class="fa fa-th-large"></i>';
                    next_post_link('<div class="nav-next">%link</div>', _x('<div class="post-navigation-content"> <div class="post-navigation-title">%title</div></div> <div class="post-navigation-right"><i class="post-navigation-icon fa fa-long-arrow-right"></i> </div>', 'Next post link', 'haru-circle'));
                    ?>
                </div>
                <!-- .nav-links -->
            </nav><!-- .navigation -->
            <div class="heading">
                <?php echo esc_html__( 'Related Projects', 'haru-circle' ); ?>
                <div class="heading-icon">
                    <i class="fa fa-circle-o"></i>
                </div>
            </div>
        </div>
        <div class="portfolio-related portfolio-wrapper <?php echo sprintf('%s %s',$column, $owl_carousel_class) ?>" <?php echo wp_kses_post($data_plugin_options) ?>>
            <?php
            while ( $posts_array->have_posts() ) : $posts_array->the_post();
                $index++;
                $permalink   = get_permalink();
                $title_post  = get_the_title();
                $terms       = wp_get_post_terms( get_the_ID(), array( 'portfolio_category'));
                $filter_name = $filter_slug = '';
                foreach ( $terms as $term ) {
                    $filter_slug .= preg_replace('/\s+/', '', $term->name) . ' ';
                    $filter_name .= $term->name.', ';
                }
                $filter_name = rtrim($filter_name,', ');

                ?>
                <?php include(WP_PLUGIN_DIR.'/haru-circle-core/includes/shortcodes/posttypes/portfolio/templates/loop/' . $layout . '-item.php');
                ?>
            <?php
            endwhile;
            wp_reset_postdata();
            ?>
        </div>
    </div>
</div>
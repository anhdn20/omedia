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

global $paged;

$atts = compact('categories', 'layout_type','video_style', 'posts_per_page', 'columns', 'show_general_tab', 'orderby', 'order', 'paging_style');        

if ( $data_source == '' ) {
    $args = array(
        'posts_per_page' => $posts_per_page, // -1 is Unlimited video
        'orderby'        => $orderby,
        'order'          => $order,
        'post_type'      => 'haru_video',
        'paged'          => $paged,
        'post_status'    => 'publish',
        'tax_query'      => array(
            array(
                'taxonomy' => 'video_category',
                'field'    => 'slug',
                'terms'    => explode(',', $categories),
            )
        )
    );
}

$videos = new WP_Query($args);
// Enqueue assets
wp_enqueue_script( 'imagesloaded', get_template_directory_uri() . '/assets/libraries/imagesloaded/imagesloaded.min.js', false, true );
wp_enqueue_script( 'isotope', get_template_directory_uri() . '/assets/libraries/isotope/isotope.pkgd.min.js', false, true );
?>
<?php if( $videos->have_posts() ) : ?>
    <div class="video-shortcode-ajax <?php echo esc_attr( $layout_type . ' ' . $el_class); ?>" data-atts="<?php echo htmlentities( json_encode($atts) ); ?>">
        <div class="video-content">
            <?php
                $slugSelected = explode(',', $categories);
                $terms = get_terms(
                    array(
                        'taxonomy'  => 'video_category',
                        'slug'      => $slugSelected,
                        'orderby'   => 'slug__in',
                    )
                );
            ?>
            <ul class="video-filter <?php echo esc_attr( $filter_style . ' ' . $filter_align ); ?>">
                <li>
                    <a class="filter-item filter-all"
                        href="javascript:;"
                        data-category="*"
                    ><?php echo esc_html__( 'All', 'haru-circle' ); ?></a>
                </li>
                <?php foreach ($terms as $term) : ?>
                <li>
                    <a class="filter-item"
                        href="javascript:;" 
                        data-category ="<?php echo esc_attr($term->slug); ?>"
                    ><?php echo wp_kses_post( $term->name ); ?></a>
                </li>
                <?php endforeach; ?>
            </ul>

            <div class="video-list columns-<?php echo esc_attr( $columns . ' ' . $video_style ); ?>">
                <div class="videos"></div>
            </div>
        </div>
    </div>
<?php else : ?>
    <div class="item-not-found"><?php echo esc_html__( 'No item found', 'haru-circle' ) ?></div>
<?php endif; ?>
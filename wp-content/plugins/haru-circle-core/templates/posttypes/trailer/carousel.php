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

if ( is_front_page() ) {
    $paged   = get_query_var( 'page' ) ? intval( get_query_var( 'page' ) ) : 1;
} else {
    $paged   = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
}  

$args = array(
    'post__in'       => explode(",", $trailer_ids),
    'posts_per_page' => $posts_per_page, // -1 is Unlimited trailer
    'orderby'        => $orderby,
    'order'          => $order,
    'post_type'      => 'haru_trailer',
    'paged'          => $paged,
    'post_status'    => 'publish'
);

if ( $data_source == '' ) {
    $args = array(
        'posts_per_page' => $posts_per_page, // -1 is Unlimited trailer
        'orderby'        => $orderby,
        'order'          => $order,
        'post_type'      => 'haru_trailer',
        'paged'          => $paged,
        'post_status'    => 'publish',
        'tax_query'      => array(
            array(
                'taxonomy' => 'trailer_category',
                'field'    => 'slug',
                'terms'    => explode(',', $category),
            )
        )
    );
}
$trailers = new WP_Query($args);
// Enqueue assets
wp_enqueue_style( 'slick', get_template_directory_uri() . '/assets/libraries/slick/slick.css', array(), false );
wp_enqueue_script( 'slick', get_template_directory_uri() . '/assets/libraries/slick/slick.min.js', false, true );
?>
<?php if ( $trailers->have_posts() ) : ?>
    <div class="trailer-shortcode-wrapper <?php echo esc_attr( $layout_type . ' ' . $el_class); ?>">
        <div class="trailer-list slider-for">
            <?php while( $trailers->have_posts() ) : $trailers->the_post(); ?>
            <div class="trailer-item">
                <div class="trailer-image">
                    <?php the_post_thumbnail(); ?>
                    <div class="trailer-icon"><a href="javascript:;" class="view-trailer-button" data-id="<?php echo esc_attr( the_ID() ); ?>"></a></div>
                    <div class="trailer-meta">
                        <h3 class="trailer-title"><a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a></h3>
                        <div class="trailer-category"><?php echo get_the_term_list( get_the_ID(), 'trailer_category', '', ' / ' ); ?></div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <div class="trailer-nav slider-nav">
            <?php while( $trailers->have_posts() ) : $trailers->the_post(); ?>
                <div class="nav-item">
                    <div class="trailer-thumbnai">
                        <?php the_post_thumbnail(); ?>
                    </div>
                    <h3 class="trailer-title"><?php the_title(); ?></h3>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
<?php else : ?>
    <div class="item-not-found"><?php echo esc_html__( 'No item found', 'haru-circle' ) ?></div>
<?php endif; ?>
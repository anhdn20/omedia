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

$args = array(
    'post__in'       => explode(",", $film_ids),
    'posts_per_page' => $posts_per_page, // -1 is Unlimited film
    'orderby'        => $orderby,
    'order'          => $order,
    'post_type'      => 'haru_film',
    'post_status'    => 'publish'
);

if ( $data_source == '' ) {
    $args = array(
        'posts_per_page' => $posts_per_page, // -1 is Unlimited film
        'orderby'        => $orderby,
        'order'          => $order,
        'post_type'      => 'haru_film',
        'post_status'    => 'publish',
        'tax_query'      => array(
            array(
                'taxonomy' => 'film_category',
                'field'    => 'slug',
                'terms'    => explode(',', $category),
            )
        )
    );
}

$films = new WP_Query($args);
// Enqueue assets
wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/assets/libraries/owl-carousel/assets/owl.carousel.min.css', array(),false );
wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/assets/libraries/owl-carousel/owl.carousel.min.js', false, true );
?>
<?php if ( $films->have_posts() ) : ?>
    <div class="film-shortcode-wrapper slideshow <?php echo esc_attr( $layout_type . ' ' . $el_class); ?>">
        <div class="film-content">
            <div class="haru-carousel film-slideshow-container owl-carousel owl-theme"
                data-items="<?php echo esc_attr($columns); ?>"
                data-items-tablet="3"
                data-items-mobile="2"
                data-margin="30"
                data-autoplay="<?php echo esc_attr($autoplay); ?>"
                data-slide-duration="<?php echo esc_attr($slide_duration); ?>"
            >
                <?php while( $films->have_posts() ) : $films->the_post(); ?>
                    <?php echo haru_get_template('posttypes/film/film-style/'. $film_style .'.php', '', '', '' ); ?>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
<?php else : ?>
    <div class="item-not-found"><?php echo esc_html__( 'No item found', 'haru-circle' ) ?></div>
<?php endif; ?>
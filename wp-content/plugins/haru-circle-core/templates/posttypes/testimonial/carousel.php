<?php
/**
 * @package    HaruTheme/Haru Pharmacy
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

extract( $atts );

$args = array(
    'orderby'        => 'post__in',
    'post__in'       => explode(",", $testimonial_ids),
    'posts_per_page' => -1, // Unlimited testimonial
    'post_type'      => 'haru_testimonial',
    'post_status'    => 'publish');

if ($data_source == '') {
    $args = array(
        'posts_per_page'       => -1, // Unlimited testimonial
        'orderby'        => $orderby,
        'order'                => $order,
        'post_type'            => 'haru_testimonial',
        'post_status'          => 'publish',
        'tax_query'      => array(
            array(
                'taxonomy' => 'testimonial_category',
                'field'    => 'slug',
                'terms'    => explode(',', $category),
            )
        )
    );
}

$testimonials = new WP_Query($args);
// Enqueue assets
if ( $layout_type == 'carousel' || $layout_type == 'carousel_2' || $layout_type == 'carousel_3' ) {
    wp_enqueue_style( 'slick', get_template_directory_uri() . '/assets/libraries/slick/slick.css', array(), false );
    wp_enqueue_script( 'slick', get_template_directory_uri() . '/assets/libraries/slick/slick.min.js', false, true );
}

?>
<?php if( $testimonials->have_posts() ) : ?>
    <div class="testimonial-shortcode-wrapper <?php echo esc_attr( $layout_type . ' ' . $el_class ); ?>"
        data-autoplay="<?php echo esc_attr($autoplay); ?>"
        data-slide-duration="<?php echo esc_attr($slide_duration); ?>"
        >
        <div class="testimonial-list slider-for">
            <?php while( $testimonials->have_posts() ) : $testimonials->the_post(); ?>
            <div class="testimonial-item">
                <div class="quote-sign">“</div>
                <div class="testimonial-content"><?php echo wp_kses_post(get_the_content()); ?></div>
            </div>
            <?php endwhile; ?>
        </div>
        <div class="testimonial-nav slider-nav">
            <?php while( $testimonials->have_posts() ) : $testimonials->the_post(); ?>
                <div class="nav-item">
                    <?php the_post_thumbnail(); ?>
                    <h3 class="testimonial-title"><?php the_title(); ?></h3>
                    <?php if( !empty(haru_get_post_meta( get_the_ID(), 'haru_testimonial_position' )) ) : ?>
                    <p class="testimonial-position"><?php echo haru_get_post_meta( get_the_ID(), 'haru_testimonial_position' )['0']; ?></p>
                    <?php endif; ?>
                    <?php if( !empty(haru_get_post_meta( get_the_ID(), 'haru_testimonial_special' )) ) : ?>
                    <p class="testimonial-special"><?php echo haru_get_post_meta( get_the_ID(), 'haru_testimonial_special' )['0']; ?></p>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
<?php else : ?>
    <div class="item-not-found"><?php echo esc_html__( 'No item found', 'haru-circle' ) ?></div>
<?php endif; ?>
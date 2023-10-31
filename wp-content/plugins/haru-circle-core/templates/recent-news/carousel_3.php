<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

extract( $atts );

$args = array(
    'posts_per_page' => $posts_per_page,
    'orderby'        => $orderby,
    'order'          => $order,
    'category_name'  => strtolower($category),
    'post_status'    => 'publish'
);

// If data_source = list_id
if ( $data_source == 'list_id' ) {
     $args = array(
        'posts_per_page' => $posts_per_page,
        'orderby'        => $orderby,
        'order'          => $order,
        'post_status'    => 'publish',
        'post__in'       =>  explode( ',' , $post_ids )
    );
}
$recent_news = new WP_Query($args);
// Enqueue assets
if ( $layout_type == 'carousel' || $layout_type == 'carousel_2' ) {
    wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/assets/libraries/owl-carousel/assets/owl.carousel.min.css', array(),false );
    wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/assets/libraries/owl-carousel/owl.carousel.min.js', false, true );
}
?>
<?php if ( $recent_news->have_posts() ) : ?>
    <div class="recent-news-shortcode-wrapper <?php echo $layout_type . ' ' . $el_class ?>">
        <div class="haru-carousel recent-news-container owl-carousel owl-theme"
            data-items="<?php echo esc_attr($columns); ?>"
            data-items-mobile="1"
            data-margin="30"
            data-autoplay="<?php echo esc_attr($autoplay); ?>"
            data-slide-duration="<?php echo esc_attr($slide_duration); ?>"
        >
            <?php while( $recent_news->have_posts() ) : $recent_news->the_post(); ?>
            <?php $thumbnail_url = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) ); ?>
            <article class="recent-news-item">
                <div class="post-thumbnail">
                    <a class="post-thumbnail-link" href="<?php the_permalink() ?>"></a>
                    <div class="post-image">
                        <?php the_post_thumbnail(); ?>
                    </div>
                    <div class="overlay-bg">
                    </div>
                </div>
                <div class="post-content">
                    <div class="post-category">
                        <?php if ( has_category() ) : ?>
                            <?php echo get_the_category_list(', '); ?>
                        <?php endif; ?>
                    </div>
                    <h3 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
                    <p class="post-excerpt">
                        <?php 
                            if ( has_excerpt() ) {
                                echo wp_trim_words( get_the_excerpt(), $excerpt_length, '...' ); 
                            } else {
                                echo wp_trim_words( get_the_content(), $excerpt_length, '...' ); 
                            }
                        ?>
                    </p>
                </div>
            </article>
            <?php endwhile; ?>
        </div>
    </div>
<?php else : ?>
    <div class="item-not-found"><?php echo esc_html__( 'No item found', 'haru-circle' ) ?></div>
<?php endif; ?>
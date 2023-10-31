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
    'posts_per_page' => $posts_per_page, // -1 is Unlimited film
    'order'          => 'DESC',
    'meta_key'       => 'post_views_count',
    'orderby'        => 'meta_value_num', // or 'meta_value'
    'post_type'      => array( 'haru_actor', 'haru_director'),
    'paged'          => $paged,
    'post_status'    => 'publish',
);

$celebrities = new WP_Query($args);
?>
<?php if ( $celebrities->have_posts() ) : ?>
    <div class="celebrity-top-view-shortcode-wrapper <?php echo esc_attr( $layout_type . ' ' . $el_class); ?>">
        <div class="celebrity-content">
            <h3 class="top-title"><?php echo esc_html( $title ); ?></h3>
            <ul class="celebrity-list">
            <?php while( $celebrities->have_posts() ) : $celebrities->the_post(); ?>
                <li class="celebrity-item">
                    <div class="item-thumbnail"><?php the_post_thumbnail('celebrity-thumbnail'); ?></div>
                    <div class="item-content">
                        <a href="<?php the_permalink(); ?>"><?php the_title() ?></a>
                        <div class="view-count"><i class="ion-ios-eye"></i><?php echo get_post_meta( get_the_ID(), 'post_views_count', true ) . esc_html__( ' views', 'haru-circle' ); ?></div>
                        <?php if ( get_post_type() == 'haru_actor' ) : ?>
                            <p class="item-position"><?php echo esc_html__( 'Actor', 'haru-circle' ); ?></p>
                        <?php else : ?>
                            <p class="item-position"><?php echo esc_html__( 'Director', 'haru-circle' ); ?></p>
                        <?php endif; ?> 
                    </div>
                </li>
            <?php endwhile; ?>
            </ul>
        </div>
    </div>
<?php else : ?>
    <div class="item-not-found"><?php echo esc_html__( 'No item found', 'haru-circle' ) ?></div>
<?php endif; ?>
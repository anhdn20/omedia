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

$excerpt_length = 10;
$args = array(
    'orderby'        => 'post__in',
    'post__in'       => array($id),
    'posts_per_page' => -1, // Unlimited video
    'post_type'      => 'haru_video',
    'post_status'    => 'publish'
);
$videos = new WP_Query($args);
?>
<?php if ( $videos->have_posts() ) : ?>
    <div class="single-video-shortcode-wrapper <?php echo esc_attr( $layout_type . ' ' . $el_class); ?>">
        <div class="video-content">
            <?php while( $videos->have_posts() ) : $videos->the_post(); ?>
                <div class="video-image">
                    <?php haru_get_video_thumbnail(get_the_ID()); ?>
                    <?php
                        $player_type = haru_get_option('player_type');
                        $player_js = haru_get_option('player_js');
                        $video_server     = get_post_meta( get_the_ID(), 'haru_video' . '_server', true );
                        if ( $player_type == 'player_popup' ) :
                    ?>
                    <div class="video-icon"><a href="javascript:;" class="view-video-button" data-id="<?php echo esc_attr( the_ID() ); ?>" data-player="<?php echo esc_attr( $player_js ); ?>" data-server="<?php echo esc_attr( $video_server ); ?>"></a></div>
                    <?php else : ?>
                        <div class="video-icon"><a href="<?php echo esc_url( get_the_permalink() ); ?>" class="view-video-button-direct"></a></div>
                    <?php endif; ?>
                    <div class="video-meta">
                        <h5 class="video-title"><a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a></h5>
                        <p class="video-excerpt">
                            <?php 
                                if ( has_excerpt() ) {
                                    echo wp_trim_words( get_the_excerpt(), $excerpt_length, '...' ); 
                                } else {
                                    echo wp_trim_words( get_the_content(), $excerpt_length, '...' ); 
                                }
                            ?>
                        </p>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
<?php else : ?>
    <div class="item-not-found"><?php echo esc_html__( 'No item found', 'haru-circle' ) ?></div>
<?php endif; ?>
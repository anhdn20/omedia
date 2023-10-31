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
                    <div class="video-icon">
                        <span class="title-left"><?php echo esc_html( $title_left ); ?></span>
                        <?php
                            $player_type = haru_get_option('player_type');
                            $player_js = haru_get_option('player_js');
                            $video_server     = get_post_meta( get_the_ID(), 'haru_video' . '_server', true );
                            if ( $player_type == 'player_popup' ) :
                        ?>
                        <a href="javascript:;" class="view-video-button" data-id="<?php echo esc_attr( the_ID() ); ?>" data-player="<?php echo esc_attr( $player_js ); ?>" data-server="<?php echo esc_attr( $video_server ); ?>"></a>
                        <?php else : ?>
                            <a href="<?php echo esc_url( get_the_permalink() ); ?>" class="view-video-button-direct"></a>
                        <?php endif; ?>
                        <span class="title-right"><?php echo esc_html( $title_right ); ?></span>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
<?php else : ?>
    <div class="item-not-found"><?php echo esc_html__( 'No item found', 'haru-circle' ) ?></div>
<?php endif; ?>
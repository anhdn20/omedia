<?php
/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/


if ( !isset($_POST['video_id']) || empty( $_POST['video_id'] ) ) {
    die;
}
$video_id = $_POST['video_id'];

global $post;
$post = get_post($_POST['video_id']);
setup_postdata( $post );

$video_server     = get_post_meta( $video_id, 'haru_video' . '_server', true ); // true/false
$video_server_id  = get_post_meta( $video_id, 'haru_video' . '_id', true );
$video_server_url = get_post_meta( $video_id, 'haru_video' . '_url', true );
$video_autoplay = haru_get_option('haru_video_single_autoplay');

?>
<div class="video-popup" id="<?php echo esc_attr($video_id); ?>">
    <div class="popup-content">
        <div class="popup-header">
            <div class="popup-header-info">
                <div class="popup-title"><?php the_title(); ?></div>
                <div class="popup-video-category"><?php echo get_the_term_list( $video_id, 'video_category', '', ', ' ); ?></div>
            </div>
        </div>
        <div class="popup-body">
            <div class="player-wrapper">
                <div class="video-player">
                    <div class="media-wrapper ratio-169">
                        <?php if ( $video_server == 'youtube' ) : ?>
                            <iframe id="youtube-video" width="420" height="315" src="<?php echo is_ssl() ? 'https' : 'http' ?>://www.youtube.com/embed/<?php echo esc_attr( $video_server_id ); ?>?rel=0<?php echo esc_attr( ( $video_autoplay == '1' ) ? '&autoplay=1&mute=1' : '' ); ?>" frameborder="0" allowfullscreen></iframe>
                        <?php elseif ( $video_server == 'vimeo' ) : 
                            if ( str_contains( $video_server_id, '/' ) ) {
                                $video_server_id = explode( '/', $video_server_id );
                                $video_params = $video_server_id[0] . '?h=' . $video_server_id[1];
                            } else {
                                $video_params = $video_server_id;
                            }
                        ?>
                            <iframe id="vimeo-video" width="" height="" src="<?php echo is_ssl() ? 'https' : 'http' ?>://player.vimeo.com/video/<?php echo esc_attr( $video_params ); ?>?api=1&player_id=player<?php echo esc_attr( ( $video_autoplay == '1' ) ? '&autoplay=1&muted=1' : '' ); ?>" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                        <?php elseif ( $video_server == 'dailymotion' ) : ?>
                            <iframe id="dailymotion-video" width="480" height="270" src="<?php echo is_ssl() ? 'https' : 'http' ?>://www.dailymotion.com/embed/video/<?php echo esc_attr( $video_server_id ); ?>?controls=true<?php echo esc_attr( ( $video_autoplay == '1' ) ? '&autoplay=1' : '' ); ?>" frameborder="0" allowFullScreen></iframe>
                        <?php elseif ( $video_server == 'twitch' ) : ?>
                            <iframe id="twitch-video" src="https://player.twitch.tv/?video=v<?php echo esc_attr( $video_server_id ); ?>&parent=<?php echo parse_url( get_site_url() )['host']; ?><?php echo esc_attr( ( $video_autoplay == '1' ) ? '&autoplay=true' : '&autoplay=false' ); ?>" height="720" width="1280" frameborder="0" scrolling="no" allowfullscreen="true"></iframe>
                        <?php elseif ( $video_server == 'facebook' ) : ?>
                            <iframe id="facebook-video" width="500" height="280" src="https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2Ffacebook%2Fvideos%2F<?php echo esc_attr( $video_server_id ); ?>%2F&width=500&show_text=false&height=280&appId<?php echo esc_attr( ( $video_autoplay == '1' ) ? '&autoplay=true' : '&autoplay=false' ); ?>"  style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media" allowFullScreen="true"></iframe>
                        <?php elseif ( $video_server == 'url' ) : ?>
                            <?php if ( $video_autoplay == '1' ) : ?>
                                <div class="video-mediaelement-unmute"><i class="fa fa-volume-mute"></i><?php echo esc_html__( 'Tap to Unmute', 'haru-circle' ); ?></div>
                            <?php endif; ?>
                            <video id="video-player" width="640" height="360" style="max-width: 100%;" preload="none" controls playsinline webkit-playsinline <?php echo esc_attr( ( $video_autoplay == '1' ) ? 'autoplay muted' : '' ); ?>>
                                <source src="<?php echo esc_url( $video_server_url['mp4'] ); ?>" type="video/mp4">
                                <source src="<?php echo esc_url( $video_server_url['webm'] ); ?>" type="video/webm">
                            </video>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    wp_reset_postdata();
    die;

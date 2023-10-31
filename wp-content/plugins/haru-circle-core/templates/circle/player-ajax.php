<?php
/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/


if ( !isset($_POST['server']) || empty( $_POST['server'] ) ) {
    die;
}
$server = $_POST['server'];
$video_id = $_POST['video_id'];
$mp4_url = $_POST['mp4_url'];
$webm_url = $_POST['webm_url'];
$film_id = $_POST['film_id'];
$video_autoplay = haru_get_option('haru_video_single_autoplay');

?>
<div class="film-player">
    <div class="media-wrapper ratio-169">
        <?php if ( $server == 'youtube' ) : ?>
            <iframe id="youtube-video" width="420" height="315" src="<?php echo is_ssl() ? 'https' : 'http' ?>://www.youtube.com/embed/<?php echo esc_attr( $video_id ); ?>?rel=0<?php echo esc_attr( ( $video_autoplay == '1' ) ? '&autoplay=1&mute=1' : '' ); ?>" frameborder="0" allowfullscreen></iframe>
        <?php elseif ( $server == 'vimeo' ) : ?>
            <iframe id="vimeo-video" width="" height="" src="<?php echo is_ssl() ? 'https' : 'http' ?>://player.vimeo.com/video/<?php echo esc_attr( $video_id ); ?>?api=1&player_id=player<?php echo esc_attr( ( $video_autoplay == '1' ) ? '&autoplay=1&muted=1' : '' ); ?>" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
        <?php elseif ( $server == 'url' ) : ?>
            <video id="film-player-<?php echo esc_attr($film_id); ?>" width="640" height="360" style="max-width: 100%;" preload="none" controls playsinline webkit-playsinline <?php echo esc_attr( ( $video_autoplay == '1' ) ? 'autoplay muted' : '' ); ?>>
                <source src="<?php echo $mp4_url; ?>" type="video/mp4">
                <source src="<?php echo $webm_url; ?>" type="video/webm">
            </video>
        <?php elseif ( $server == 'dailymotion' ) : ?>
            <iframe id="dailymotion-video" width="480" height="270" src="<?php echo is_ssl() ? 'https' : 'http' ?>://www.dailymotion.com/embed/video/<?php echo esc_attr( $video_id ); ?>?controls=true<?php echo esc_attr( ( $video_autoplay == '1' ) ? '&autoplay=1' : '' ); ?>" frameborder="0" allowFullScreen></iframe>
        <?php elseif ( $server == 'twitch' ) : ?>
            <iframe id="twitch-video" src="https://player.twitch.tv/?video=v<?php echo esc_attr( $video_id ); ?>&parent=<?php echo parse_url( get_site_url() )['host']; ?><?php echo esc_attr( ( $video_autoplay == '1' ) ? '&autoplay=true' : '&autoplay=false' ); ?>" height="720" width="1280" frameborder="0" scrolling="no" allowfullscreen="true"></iframe>
        <?php elseif ( $server == 'facebook' ) : ?>
            <iframe id="facebook-video" width="500" height="280" src="https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2Ffacebook%2Fvideos%2F<?php echo esc_attr( $video_id ); ?>%2F&width=500&show_text=false&height=280&appId<?php echo esc_attr( ( $video_autoplay == '1' ) ? '&autoplay=true' : '&autoplay=false' ); ?>"  style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media" allowFullScreen="true"></iframe>  
        <?php endif;?>
    </div>
</div>
<?php
    wp_reset_postdata();
    die;

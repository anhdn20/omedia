<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/


$film_videos        = get_post_meta( get_the_ID(), 'haru_film' . '_videos', true ); // true/false
?>
<div id="film-videos-<?php echo esc_attr( $post->ID ); ?>" class="film-videos-wrapper">
    <div class="row">     
        <!-- START Display Video Player and First Episode. -->
        <?php $first_video = $film_videos[0]; ?>
        <div class="player-wrapper col-md-12 col-sm-12">
            <div class="film-player">
                <div class="media-wrapper ratio-169">
                    <?php if ( $first_video['link_server1'] != '' ) : ?>
                        <iframe id="youtube-video" width="420" height="315" src="<?php echo is_ssl() ? 'https' : 'http' ?>://www.youtube.com/embed/<?php echo esc_attr( $first_video['link_server1'] ); ?>?rel=0" frameborder="0" allowfullscreen></iframe>
                    <?php elseif ( $first_video['link_server2'] != '' ) : ?>
                        <iframe id="vimeo-video" width="" height="" src="<?php echo is_ssl() ? 'https' : 'http' ?>://player.vimeo.com/video/<?php echo esc_attr( $first_video['link_server2'] ); ?>?api=1&player_id=player" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                    <?php elseif ( ($first_video['link_server3_mp4'] != '') || ($first_video['link_server3_webm'] != '') ) : ?>
                        <video id="film-player-<?php echo esc_attr(get_the_ID()); ?>" width="640" height="360" style="max-width: 100%;" preload="none" controls playsinline webkit-playsinline>
                            <source src="<?php echo esc_url( $first_video['link_server3_mp4'] ); ?>" type="video/mp4">
                            <source src="<?php echo esc_url ($first_video['link_server3_webm'] ); ?>" type="video/webm">
                            <!-- <track srclang="en" kind="subtitles" src="mediaelement.vtt">
                            <track srclang="en" kind="chapters" src="chapters.vtt"> -->
                        </video>
                    <?php elseif ( $first_video['link_server4'] != '' ) : ?>
                        <iframe id="dailymotion-video" width="480" height="270" src="<?php echo is_ssl() ? 'https' : 'http' ?>://www.dailymotion.com/embed/video/<?php echo esc_attr( $first_video['link_server4'] ); ?>?controls=true" frameborder="0" allowFullScreen></iframe>
                    <?php elseif ( $first_video['link_server5'] != '' ) : ?>
                        <iframe id="twitch-video" src="https://player.twitch.tv/?video=v<?php echo esc_attr( $first_video['link_server5'] ); ?>&parent=<?php echo parse_url( get_site_url() )['host']; ?>&autoplay=false" height="720" width="1280" frameborder="0" scrolling="no" allowfullscreen="true"></iframe>
                    <?php elseif ( $first_video['link_server6'] != '' ) : ?>
                        <iframe id="facebook-video" width="500" height="280" src="https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2Ffacebook%2Fvideos%2F<?php echo esc_attr( $first_video['link_server6'] ); ?>%2F&width=500&show_text=false&height=280&appId"  style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media" allowFullScreen="true"></iframe>  
                    <?php endif;?>
                </div>
            </div>
        </div>
        <!-- END display video player -->

        <!-- Video Action List -->
        <div class="video-playlist col-md-12 col-sm-12">
            <ul class="video-episodes">
            <?php foreach( $film_videos as $key => $video ) : ?>
                <li>
                    <a href="javascript:;" class="film-server <?php if ( $key == 0 ) echo 'active'; ?>" data-episode="film-server-episode-<?php echo esc_attr($key+1); ?>">
                        <?php echo esc_html( $video['video_title'] ); ?>
                    </a>
                </li>
            <?php endforeach; ?>
            </ul>

            <?php foreach( $film_videos as $key => $video ) : ?>
                <div id="film-server-episode-<?php echo esc_attr($key+1); ?>" class="film-server-content">
                    <ul class="video-server">
                        <?php if ( $video['link_server1'] != '' ) : ?>
                        <li>
                            <a  href="javascript:;" 
                                data-server="youtube"
                                data-video-id="<?php echo esc_attr( $video['link_server1'] ); ?>"
                                class="server-youtube" 
                            >
                                <?php echo esc_html( $video['title_server1'] ); ?>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if ( $video['link_server2'] != '' ) : ?>
                        <li>
                            <a  href="javascript:;"
                                data-server="vimeo"
                                data-video-id="<?php echo esc_attr( $video['link_server2'] ); ?>"
                                class="server-vimeo" 
                            >
                                <?php echo esc_html( $video['title_server2'] ); ?>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if ( ($video['link_server3_mp4'] != '') || ($video['link_server3_webm'] != '') ) : ?>
                        <li>
                            <a  href="javascript:;"
                                data-server="url"
                                data-mp4-url="<?php echo esc_url( $video['link_server3_mp4'] ); ?>"
                                data-webm-url="<?php echo esc_url( $video['link_server3_webm'] ); ?>"
                                data-film-id="<?php echo get_the_ID(); ?>"
                                data-poster=""
                                data-tracks=""
                                class="server-local"
                            >
                                <?php echo esc_html( $video['title_server3'] ); ?>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if ( $video['link_server4'] != '' ) : ?>
                        <li>
                            <a  href="javascript:;"
                                data-server="dailymotion"
                                data-video-id="<?php echo esc_attr( $video['link_server4'] ); ?>"
                                class="server-dailymotion" 
                            >
                                <?php echo esc_html( $video['title_server4'] ); ?>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if ( $video['link_server5'] != '' ) : ?>
                        <li>
                            <a  href="javascript:;"
                                data-server="twitch"
                                data-video-id="<?php echo esc_attr( $video['link_server5'] ); ?>"
                                class="server-twitch" 
                            >
                                <?php echo esc_html( $video['title_server5'] ); ?>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if ( $video['link_server6'] != '' ) : ?>
                        <li>
                            <a  href="javascript:;"
                                data-server="facebook"
                                data-video-id="<?php echo esc_attr( $video['link_server6'] ); ?>"
                                class="server-facebook" 
                            >
                                <?php echo esc_html( $video['title_server6'] ); ?>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
        <!-- End Video Action List -->
    </div>
</div>

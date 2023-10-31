<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

// Process archive post class
$archive_display_columns = isset($_GET['columns']) ? $_GET['columns'] : '';
if ( !in_array($archive_display_columns, array('2','3','4')) ) {
    $archive_display_columns = haru_get_option('archive_video_display_columns');
} 
// Class archive blog
$archive_display_type = isset($_GET['style']) ? $_GET['style'] : '';
if ( $archive_display_type == '' ) {
    $archive_display_type = haru_get_option('archive_video_display_type');
}

$post_classes[] = haru_get_option('archive_video_display_type');
if ( in_array($archive_display_type, array('grid','masonry')) ) {
    if ( $archive_display_columns == '2' ) {
        $post_classes[] = 'col-md-6 col-sm-6 col-xs-12';
    } elseif ( $archive_display_columns == '3' ) {
        $post_classes[] = 'col-md-4 col-sm-6 col-xs-12';
    } elseif ( $archive_display_columns == '4' ) {
        $post_classes[] = 'col-md-3 col-sm-6 col-xs-12';
    }
} else {
    $post_classes[] = 'col-md-12 col-sm-12 col-xs-12';
}

$post_excerpt = haru_get_option('archive_video_number_exceprt');
if ( !empty($post_excerpt) ) {
    $post_excerpt = haru_get_option('archive_video_number_exceprt');
}
// Set Default
else {
    $post_excerpt = 30; // Need to change to other number to show all post_content
}

?>
<article id="post-<?php the_ID(); ?>" <?php post_class($post_classes); ?> >
    <div class="post-wrapper clearfix">
        <div class="video-item style_2" onclick="void(0)">
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
            </div>
            <div class="video-meta">
                <h3 class="video-title"><a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a></h3>
                <div class="video-category"><?php echo get_the_term_list( get_the_ID(), 'video_category', '', ', ' ); ?></div>
            </div>
        </div>
    </div>
</article>
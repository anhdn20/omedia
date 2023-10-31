<?php
/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/
$terms          = wp_get_post_terms(get_the_ID(), array('video_category'));
$filter_name = $filter_slug = '';
foreach ( $terms as $term ) {
    $filter_slug .= $term->slug . ' ';
    $filter_name .= $term->name . ' ';
}
?>
<div class="video-item style_3 <?php echo esc_attr( $filter_slug ); ?>" onclick="void(0)">
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
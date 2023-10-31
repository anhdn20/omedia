<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

$is_show_top_bar = get_post_meta( get_the_ID(), 'haru_' . 'top_bar', true ); // @TODO: need fix shop page
if ( ($is_show_top_bar == '') || ($is_show_top_bar == '-1') ) {
    $is_show_top_bar = haru_get_option('top_bar');
}

if ( !$is_show_top_bar ) {
    return; // DO NOT SHOW TOP BAR
}

$top_bar_layout_width = get_post_meta( get_the_ID(), 'haru_' . 'top_bar_layout_width', true );
if ( ($top_bar_layout_width == '') || ($top_bar_layout_width == '-1') ) {
    $top_bar_layout_width = haru_get_option('top_bar_layout_width');
}

$top_bar_layout = get_post_meta( get_the_ID(), 'haru_' . 'top_bar_layout', true );
if ( ($top_bar_layout == '') || ($top_bar_layout == '-1') ) {
    $top_bar_layout = haru_get_option('top_bar_layout');
}

// Left sidebar
$top_bar_left_sidebar = get_post_meta( get_the_ID(), 'haru_' . 'top_bar_left_sidebar', true );
if ( ($top_bar_left_sidebar == '') || ($top_bar_left_sidebar == '-1') ) {
    $top_bar_left_sidebar = haru_get_option('top_bar_left_sidebar');
}
// Right sidebar
$top_bar_right_sidebar = get_post_meta( get_the_ID(), 'haru_' . 'top_bar_right_sidebar', true );
if ( ($top_bar_right_sidebar == '') || ($top_bar_right_sidebar == '-1') ) {
    $top_bar_right_sidebar = haru_get_option('top_bar_right_sidebar');
}

$top_bar_class = array('haru-top-bar');
if ( haru_get_option('mobile_header_top_bar') == '0' ) {
    $top_bar_class[] = 'mobile-top-bar-hide';
}

$col_top_bar_left   = '';
$col_top_bar_right  = '';

if ( ($top_bar_layout == 'top-bar-1' ) && is_active_sidebar($top_bar_left_sidebar) && is_active_sidebar($top_bar_right_sidebar) ) {
    $col_top_bar_left  = 'col-md-6';
    $col_top_bar_right = 'col-md-6';
} elseif ( ($top_bar_layout == 'top-bar-2' ) && is_active_sidebar($top_bar_left_sidebar) ) {
    $col_top_bar_left  = 'col-md-12';
}

if (empty($col_top_bar_left)) {
    return; // DO NOT SHOW TOP BAR
}

?>
<div class="<?php echo esc_attr( join(' ', $top_bar_class) ); ?>">
    <div class="<?php echo esc_attr( $top_bar_layout_width ); ?>">
        <div class="row">
            <?php if ( is_active_sidebar($top_bar_left_sidebar) ) : ?>
                <div class="top-sidebar top-bar-left <?php echo esc_attr($col_top_bar_left) ?> col-sm-6 col-xs-12">
                    <?php dynamic_sidebar( $top_bar_left_sidebar );?>
                </div>
            <?php endif; ?>
            <?php if ( is_active_sidebar($top_bar_right_sidebar) && ($top_bar_layout != 'top-bar-2') ) : ?>
                <div class="top-sidebar top-bar-right <?php echo esc_attr($col_top_bar_right) ?> col-sm-6 col-xs-12">
                    <?php dynamic_sidebar( $top_bar_right_sidebar );?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
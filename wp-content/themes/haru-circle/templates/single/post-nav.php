<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

// Don't print empty markup if there's nowhere to navigate.
$previous = (is_attachment()) ? get_post(get_post()->post_parent) : get_adjacent_post(false, '', true);
$next     = get_adjacent_post(false, '', false);
if(!$next && !$previous) {
    return;
}

$show_post_navigation = haru_get_option('show_post_navigation');
if ( $show_post_navigation == '0' ) {
    return;
}
?>
<div class="single-post-navigation clearfix" role="navigation">
    <?php
        previous_post_link('<div class="nav-links nav-previous">%link</div>', _x('<div class="post-navigation-left"><i class="ion-ios-arrow-back"></i><span class="link-prev">'. esc_html__('Previous', 'haru-circle') . '</span></div><div class="post-navigation-content"><div class="post-navigation-title">%title</div></div> ', 'Previous post link', 'haru-circle'));
        next_post_link('<div class="nav-links nav-next">%link</div>', _x('<div class="post-navigation-right"><span class="link-next">'. esc_html__('Next', 'haru-circle') .'</span><i class="ion-ios-arrow-forward"></i> </div><div class="post-navigation-content"> <div class="post-navigation-title">%title</div></div>', 'Next post link', 'haru-circle'));
    ?>
</div><!-- .navigation -->
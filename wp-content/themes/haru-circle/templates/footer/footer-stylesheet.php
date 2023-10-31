<?php 
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

if ( post_type_exists('haru_footer') && get_posts('post_type=haru_footer') ) { // Use this only when have footer post type
    $footer_id = get_post_meta( get_the_ID(), 'haru_' . 'footer', true );
    if ( $footer_id == '' ) {
        $footer_id = haru_get_option('footer');
    }

    $content_post = get_post($footer_id);
    $content      = $content_post->post_content;

    if ( $footer_id && (get_the_ID() !== $footer_id) ) {
        $shortcodes_custom_css = get_post_meta( $footer_id, '_wpb_shortcodes_custom_css', true );
        if ( !empty( $shortcodes_custom_css ) ) {
            $shortcodes_custom_css = strip_tags( $shortcodes_custom_css );
            echo '<style type="text/css" data-type="vc_shortcodes-custom-css">';
            echo wp_kses_post( $shortcodes_custom_css );
            echo '</style>';
        }
    }
}
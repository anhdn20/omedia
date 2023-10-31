<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

$footer_id = get_post_meta( get_the_ID(), 'haru_'.'footer', true );
if ( $footer_id == '' ) {
    $footer_id = haru_get_option('footer');
}

$args = array(
    'orderby'        => 'post__in',
    'post__in'       => explode(",", $footer_id),
    'post_type'      => 'haru_footer',
    'post_status'    => 'publish'
);

$footer = new WP_Query($args);

if ( $footer->have_posts() ) :
	while( $footer->have_posts() ) : $footer->the_post();
		$content = get_the_content();
	endwhile;
endif;
wp_reset_query();
$content      = str_replace( ']]>', ']]&gt;', $content );

$footer_layout = get_post_meta( get_the_ID(), 'haru_'.'footer_layout', true );
if ( ($footer_layout == '') || ($footer_layout == '-1')  ) {
    $footer_layout = haru_get_option('footer_layout');
}

if ( $footer_layout != 'full' ) : ?>
    <div class="<?php echo esc_attr($footer_layout); ?> clearfix">
<?php endif; ?>
<?php echo do_shortcode($content); ?>
<?php if ( $footer_layout != 'full' ) : ?>
    </div>
<?php endif; ?>
<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

$header_customize_text = '';

$enable_header_customize = get_post_meta( get_the_ID(), 'haru_' . 'enable_header_customize_right', true );
if ($enable_header_customize == '1') {
    $header_customize_text = get_post_meta( get_the_ID(), 'haru_' . 'header_customize_right_text', true );
} else {
    if ( haru_get_option('option-header-customize-right') == '1' ) {
        $header_customize_text = haru_get_option('header_customize_right_text');
    } else {
        return;
    }
}

?>
<?php if ( !empty($header_customize_text) ) : ?>
    <div class="custom-text-wrapper header-customize-item">
        <?php echo wp_kses_post($header_customize_text); ?>
    </div>
<?php endif;?>
<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/
extract( $atts );
// Enqueue assets
wp_enqueue_script( 'appear', plugins_url() . '/haru-circle-core/includes/shortcodes/counter/assets/js/jquery.appear.js', false, true );
wp_enqueue_script( 'countto', plugins_url() . '/haru-circle-core/includes/shortcodes/counter/assets/js/jquery.countTo.js', false, true );

?>
<div class="counter-shortcode-wrapper <?php echo esc_attr( $layout_type . ' ' . $el_class); ?>">
    <div class="gr-counter gr-animated">
        <div class="content-inner">
            <div data-from="0" data-to="<?php echo esc_attr($number); ?>" class="gr-number-counter">
                <?php echo esc_html($number); ?>
            </div>
            <div class="gr-text-default"><?php echo wp_kses_post($title); ?></div>
        </div>
    </div>
</div>
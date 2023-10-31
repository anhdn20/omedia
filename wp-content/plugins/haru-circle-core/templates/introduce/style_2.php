<?php
/**
 * @package    HaruTheme/Haru Pharmacy
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/
extract( $atts );

?>
<div class="introduce-shortcode-wrapper <?php echo esc_attr( $layout_type . ' ' . $el_class); ?>">
	<div class="introduce-content">
        <div class="image-left"></div>
        <div class="introduce-main">
            <div class="intro-title"><span class="first-word"><?php echo esc_html( $title_first ) ?></span><?php echo esc_html( $title ); ?></div>
            <div class="intro-description"><?php echo wp_kses_post( $content ); ?></div>
        </div>
        <div class="image-right"></div>
    </div>
</div>
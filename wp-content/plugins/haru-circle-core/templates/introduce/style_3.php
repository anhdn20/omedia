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

$image_src = wp_get_attachment_url($image);

?>
<div class="introduce-shortcode-wrapper <?php echo esc_attr( $layout_type . ' ' . $el_class); ?>">
	<div class="introduce-content">
        <div class="image-left"></div>
        <div class="introduce-main">
            <div class="intro-description"><?php echo wp_kses_post( $content ); ?></div>
            <?php if ( $image_src != '' ) : ?>
            <div class="intro-image"><img src="<?php echo esc_url( $image_src ); ?>" alt="<?php echo esc_attr( $title ); ?>"></div>
            <?php endif; ?>
            <div class="intro-title"><?php echo esc_html( $title ); ?></div>
            <div class="intro-sub-title"><?php echo esc_html( $sub_title ); ?></div>
        </div>
        <div class="image-right"></div>
    </div>
</div>
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
$link      = vc_build_link( $link );

?>
<div class="banner-shortcode-wrapper <?php echo $layout_type . ' ' . $el_class; ?>">
    <div class="banner-content-wrapper">
        <?php if ( $link['url'] != '' ) : ?>
            <a href="<?php echo esc_url($link['url']); ?>" target="<?php echo esc_attr( ($link['target'] != '') ? $link['target'] : '_self' ); ?>">
        <?php endif; ?>
            <div class="banner-content-inner clearfix">
                <div class="banner-content">
                    <p class="banner-description"><?php echo esc_html( $description ); ?></p>
                    <?php if ( $title != '' ) : ?>
                        <h6 class="banner-title"><?php echo esc_html( $title ); ?></h6>
                    <?php endif; ?>
                    <?php if ( $sub_title != '' ) : ?>
                        <h6 class="sub-title"><?php echo esc_html( $sub_title ); ?></h6>
                    <?php endif; ?> 
                </div>
                <div class="banner-image">
                <?php if ( $image_src != '' ) : ?>
                    <img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr($title); ?>">
                <?php endif; ?>
                </div>
            </div>
        <?php if ( $link['url'] != '' ) : ?>
            </a>
        <?php endif; ?>
    </div>
</div>
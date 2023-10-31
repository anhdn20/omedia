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

$image_src = wp_get_attachment_url($icon_image);
$link      = vc_build_link( $link );
?>

<div class="icon-box-shortcode-wrapper <?php echo $layout_type . ' ' . $el_class; ?>">
    <div class="icon-box-content-wrapper">
    <?php if ( $link['url'] != '' ) : ?>
        <a href="<?php echo esc_attr( $link['url'] ); ?>" title="<?php echo esc_attr( $link['title'] ); ?>" target="<?php echo ( strlen( $link['target'] ) > 0 ? esc_attr( $link['target'] ) : '_self' ) ?>">
    <?php endif; ?>
        <div class="icon-wrap">
            <img src="<?php echo esc_url( $image_src ); ?>" alt="<?php echo esc_attr($title); ?>">
        </div>    
    <?php if ( $link['url'] != '' ) : ?>
        </a>
    <?php endif; ?>
        <div class="icon-content">
            <div class="icon-title">
                <?php if ( $link['url'] != '' ) : ?>
                    <a href="<?php echo esc_attr( $link['url'] ) ?>" title="<?php echo esc_attr( $link['title'] ); ?>" target="<?php echo ( strlen( $link['target'] ) > 0 ? esc_attr( $link['target'] ) : '_self' ) ?>">
                <?php endif; ?>
                <h5><?php echo esc_html( $title ); ?></h5>
                <?php if ( $link['url'] != '' ) : ?>
                    </a>
                <?php endif; ?>
            </div>
            <p class="icon-description"><?php echo wp_kses_post( $description ); ?></p>
            <div class="icon-readmore">
                <a href="<?php echo esc_attr( $link['url'] ) ?>" title="<?php echo esc_attr( $link['title'] ); ?>" target="<?php echo ( strlen( $link['target'] ) > 0 ? esc_attr( $link['target'] ) : '_self' ) ?>"><?php echo esc_html__( 'Read More', 'haru-circle' ); ?></a>
            </div>
        </div>
    </div>
</div>
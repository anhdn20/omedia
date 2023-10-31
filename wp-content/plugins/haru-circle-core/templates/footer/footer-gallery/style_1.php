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

$images_arr      = (array)vc_param_group_parse_atts( $images );

?>
<div class="footer-gallery-shortcode-wrapper <?php echo esc_attr( $layout_type . ' ' . $el_class); ?>">
    <div class="footer-gallery-content">
        <ul class="image-list columns-<?php echo esc_attr( $columns ); ?>">
            <?php
                foreach( $images_arr as $key => $image ) : 
                    $link = '';
                    if ( isset($image['link']) ) {
                        $link = vc_build_link( $image['link'] );
                    }
                    $image_src = wp_get_attachment_url($image['image']);
            ?>
                    <?php if ( $link != '' ) : ?>
                    <li>
                        <a href="<?php echo esc_url( $link['url'] ); ?>" target="<?php echo esc_attr( ($link['target'] != '') ? $link['target'] : '_self' ); ?>">
                            <img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_html($image['title']); ?>">
                        </a>
                    </li>
                    <?php else : ?>
                    <li>
                        <img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_html($image['title']); ?>">
                    </li>
                    <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
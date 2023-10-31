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

$images      = (array)vc_param_group_parse_atts( $images );
$image_class = 'image-col-' . $columns;
// Enqueue assets
if ( $layout_type == 'slick' ) {
    wp_enqueue_style( 'slick', get_template_directory_uri() . '/assets/libraries/slick/slick.css', array(), false );
    wp_enqueue_script( 'slick', get_template_directory_uri() . '/assets/libraries/slick/slick.min.js', false, true );
}

?>
<div class="images-gallery-shortcode-wrapper <?php echo $layout_type . ' ' . $el_class; ?>">
    <div class="images-list">
        <?php foreach( $images as $image ) : 
            $image_src = wp_get_attachment_url($image['image']);
            $link = '';
            if ( isset($image['link']) ) {
                $link = vc_build_link( $image['link'] );
            }
        ?>
        <div class="image-item <?php echo $image_class . ' ' . $padding; ?>">
            <div class="slide-item">
            <?php if ( $link != '' ) : ?>
                <a href="<?php echo esc_url($link['url']); ?>" target="<?php echo esc_attr( ($link['target'] != '') ? $link['target'] : '_self' ); ?>">
            <?php endif; ?>
                <img src="<?php echo esc_url($image_src); ?>" alt="<?php echo $image['title']; ?>">
                <div class="image-meta">
                    <i class="fa fa-instagram"></i>
                    <h5 class="image-title"><?php echo esc_html( $image['title'] ); ?></h5>
                </div>
            <?php if ( $link != '' ) : ?>
                </a>
            <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
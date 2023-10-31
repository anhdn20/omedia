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

$clients    = (array)vc_param_group_parse_atts( $clients );
// Enqueue assets
if ( ( $layout_type == 'style_1' ) || ( $layout_type == 'style_2' ) ) {
    wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/assets/libraries/owl-carousel/assets/owl.carousel.min.css', array(), false );
    wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/assets/libraries/owl-carousel/owl.carousel.min.js', false, true );
}

?>
<div class="clients-shortcode-wrapper <?php echo $layout_type . ' ' . $el_class; ?>">
    <div class="haru-carousel clients-list owl-carousel owl-theme"
        data-items="<?php echo esc_attr($logo_per_slide); ?>"
        data-items-tablet="3"
        data-items-mobile="2"
        data-margin="20"
        data-autoplay="<?php echo esc_attr($autoplay); ?>"
        data-slide-duration="<?php echo esc_attr($slide_duration); ?>"
    >
        <?php foreach( $clients as $client ) : 
            $image_src = wp_get_attachment_url($client['logo']);
            $link = '';
            if ( isset($client['link']) ) {
                $link = vc_build_link( $client['link'] );
            }
        ?>
    	<div class="client-item">
        <?php if ( $link != '' ) : ?>
        <a href="<?php echo esc_url($link['url']); ?>" target="<?php echo esc_attr( ($link['target'] != '') ? $link['target'] : '_self' ); ?>">
        <?php endif; ?>
            <img src="<?php echo esc_url($image_src); ?>" alt="<?php echo $client['name']; ?>">
        <?php if ( $link != '' ) : ?>
        </a>
        <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
</div>
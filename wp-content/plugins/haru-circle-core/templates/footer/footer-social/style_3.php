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

$socials_arr      = (array)vc_param_group_parse_atts( $socials );

?>
<div class="footer-social-shortcode-wrapper <?php echo esc_attr( $layout_type . ' ' . $el_class); ?>">
    <div class="footer-social-content">
        <ul class="social-list align-<?php echo esc_attr( $align ); ?>">
            <?php
                foreach( $socials_arr as $key => $social ) : 
                    $link = '';
                    if ( isset($social['link']) ) {
                        $link = vc_build_link( $social['link'] );
                    }
                    // Icon
                    vc_icon_element_fonts_enqueue( $social['icon_library'] );
                    $iconClass = isset( $social['icon_' . $social['icon_library']] ) ? esc_attr( $social['icon_' . $social['icon_library']] ) : 'fa fa-adjust';
            ?>
                    <?php if ( $link != '' ) : ?>
                    <li>
                        <a href="<?php echo esc_url( $link['url'] ); ?>" target="<?php echo esc_attr( ($link['target'] != '') ? $link['target'] : '_self' ); ?>"><i class="<?php echo esc_attr($iconClass); ?>"></i></a>
                    </li>
                    <?php else: ?>
                    <li>
                        <a href="#" target="_self"><?php echo esc_html__( 'Please insert link', 'haru-circle' ); ?></a>
                    </li>
                    <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
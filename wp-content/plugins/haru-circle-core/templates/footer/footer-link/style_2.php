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

$links_arr      = (array)vc_param_group_parse_atts( $links );

?>
<div class="footer-link-shortcode-wrapper <?php echo esc_attr( $layout_type . ' ' . $el_class); ?>">
    <div class="footer-link-content">
        <ul class="link-list">
            <?php
                foreach( $links_arr as $key => $link ) : 
                    $url = '';
                    if ( isset($link['link']) ) {
                        $url = vc_build_link( $link['link'] );
                    }
            ?>
                    <?php if ( $url != '' ) : ?>
                    <li>
                        <a href="<?php echo esc_url( $url['url'] ); ?>" target="<?php echo esc_attr( ($url['target'] != '') ? $url['target'] : '_self' ); ?>"><?php echo esc_html( $link['title'] ); ?></a>
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
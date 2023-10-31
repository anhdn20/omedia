<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

$header_class = array('haru-main-header', 'header-1', 'header-desktop-wrapper');
// Header Float
$header_layout_float = get_post_meta( get_the_ID(), 'haru_' . 'header_layout_float', true );
if ( ($header_layout_float == '') || ($header_layout_float == '-1') ) {
    $header_layout_float = haru_get_option('header_layout_float');
}
if ( $header_layout_float == '1' ) {
    $header_class[] = 'header-float';
}
// Maybe use Header under slideshow option
$header_layout_under_slideshow = get_post_meta( get_the_ID(), 'haru_' . 'header_layout_under_slideshow', true );
if ( ($header_layout_under_slideshow == '') || ($header_layout_under_slideshow == '-1') ) {
    $header_layout_under_slideshow = haru_get_option('header_layout_under_slideshow');
}
if ( $header_layout_under_slideshow == '1' ) {
    $header_class[] = 'header-under-slideshow';
}


$header_nav_wrapper = array('haru-header-nav-wrapper');
// Header Sticky
$header_sticky = get_post_meta( get_the_ID(), 'haru_' . 'header_sticky', true );
if ( ($header_sticky == '') || ($header_sticky == '-1') ) {
    $header_sticky = haru_get_option('header_sticky');
}
if ( $header_sticky == '1' ) {
    $header_nav_wrapper[] = 'header-sticky';
}
// Sticky Skin
$header_sticky_skin = get_post_meta( get_the_ID(), 'haru_' . 'header_sticky_skin', true );
if ( ($header_sticky_skin == '') || ($header_sticky_skin == '-1') ) {
    $header_sticky_skin = haru_get_option('header_sticky_skin');
}
$header_nav_wrapper[] = $header_sticky_skin;

// Header navigation layout
$header_nav_layout      = haru_get_option('header_nav_layout');
$header_nav_layout_page = get_post_meta( get_the_ID(), 'haru_' . 'header_nav_layout', true );
if ( isset($header_nav_layout) ) {
    $header_nav_layout = haru_get_option('header_nav_layout');
}
if ( $header_nav_layout_page != '' && $header_nav_layout_page != '-1' ){
    $header_nav_layout = $header_nav_layout_page;
}
// Set Default
if ( !isset($header_nav_layout) ) {
    $header_nav_layout = 'container';
}

?>
<header id="haru-header" class="<?php echo esc_attr( join(' ', $header_class) ); ?>">
    <div class="<?php echo esc_attr( join(' ', $header_nav_wrapper) ); ?>">
        <div class="<?php echo esc_attr($header_nav_layout); ?>">
            <div class="haru-header-wrapper">
                <div class="header-left">
                    <?php get_template_part('templates/header/header-logo'); ?>
                </div>
                <div class="header-right">
                    <?php if (has_nav_menu('primary')) : ?>
                        <div id="primary-menu" class="menu-wrapper">
                            <?php
                                $arg_menu = array(
                                    'menu_id'        => 'main-menu',
                                    'container'      => '',
                                    'theme_location' => 'primary',
                                    'menu_class'     => 'haru-main-menu nav-collapse navbar-nav',
                                    'fallback_cb'    => 'please_set_menu',
                                    'walker'         => new HARU_MegaMenu_Walker()
                                );
                                wp_nav_menu( $arg_menu );
                            ?>
                        </div>
                    <?php endif; ?>
                    <?php get_template_part('templates/header/header-customize-nav' ); ?>
                </div>
            </div>
        </div>
    </div>
</header>
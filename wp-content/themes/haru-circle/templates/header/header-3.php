<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

$header_class = array('haru-main-header', 'header-3', 'header-desktop-wrapper');
// Header Float
$header_layout_float = get_post_meta( get_the_ID(), 'haru_' . 'header_layout_float', true );
if ( ($header_layout_float == '') || ($header_layout_float == '-1') ) {
    $header_layout_float = haru_get_option('header_layout_float');
}
if ($header_layout_float == '1') {
    $header_class[] = 'header-float';
}

$header_nav_wrapper = array('haru-header-nav-wrapper');
// Header Sticky
$header_sticky = get_post_meta( get_the_ID(), 'haru_' . 'header_sticky', true );
if ( ($header_sticky == '') || ($header_sticky == '-1') ) {
    $header_sticky = haru_get_option('header_sticky');
}
if( $header_sticky == '1' ) {
    $header_nav_wrapper[] = 'header-sticky';
}

// Header navigation layout
$header_nav_layout = get_post_meta( get_the_ID(), 'haru_' . 'header_nav_layout', true );
if ( ($header_nav_layout == '') || ($header_nav_layout == '-1') ) {
    $header_nav_layout = haru_get_option('header_nav_layout');
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
    <div class="haru-header-under-wrapper">
        <div class="container">
            <div class="fl">
                <?php get_template_part('templates/header/header-customize','left' ); ?>
            </div>
            <div class="fr">
                <?php get_template_part('templates/header/header-customize','right' ); ?>
            </div>
        </div>
    </div>
</header>
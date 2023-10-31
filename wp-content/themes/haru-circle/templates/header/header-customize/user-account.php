<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

$login_url     = '';
$register_url  = '';
$account_url   = '';
if ( class_exists( 'WooCommerce' ) ) {
    global $woocommerce;
    $myaccount_page_id = wc_get_page_id('myaccount');
    if ( $myaccount_page_id > 0 ) {
        $login_url    = get_permalink( $myaccount_page_id );
        $register_url = get_permalink( $myaccount_page_id );
        $account_url  = get_permalink( $myaccount_page_id );
    }
    else {
        $login_url    = wp_login_url( get_permalink() );
        $register_url = wp_registration_url();
        $account_url  = get_edit_user_link();
    }
}
else {
    $login_url    = wp_login_url( get_permalink() );
    $register_url = wp_registration_url();
    $account_url  = get_edit_user_link();
}

?>
<div class="header-customize-item user-account-wrapper">
    <?php if ( !is_user_logged_in() ) : ?>
        <a href="<?php echo esc_url($login_url) ?>"><?php echo esc_html__( 'Login', 'haru-circle' ) ?></a>
        <a href="<?php echo esc_url($register_url); ?>"><?php echo esc_html__( 'Sign Up', 'haru-circle' ) ?></a>
    <?php else:
        global $current_user; 
    ?>  
        <div class="user-info">
            <div class="user-avatar">
                <?php echo get_avatar( $current_user->ID, 64 ); ?>
            </div>
            <div class="user-name">
                <p><?php echo esc_html__( 'Hello', 'haru-circle' ); ?></p>
                <p class="name"><?php echo esc_html( $current_user->display_name ); ?></p>
            </div>
        </div>
        <div class="user-link">
            <a href="<?php echo esc_url($account_url); ?>"><?php echo esc_html__( 'My Account', 'haru-circle' ); ?></a>
            <a href="<?php echo esc_url(wp_logout_url(is_home()? home_url('/') : get_permalink()) ); ?>"><?php echo esc_html__( 'Log Out', 'haru-circle' ) ?></a>
        </div>
    <?php endif; ?>
</div>
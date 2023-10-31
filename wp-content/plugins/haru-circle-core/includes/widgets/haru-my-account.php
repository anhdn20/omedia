<?php
/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

class Haru_Widget_MyAccount extends HARU_Widget {
	public function __construct() {
		$this->widget_cssclass    = 'widget-my-account';
		$this->widget_description = esc_html__( 'My Account Link Widget', 'haru-circle' );
		$this->widget_id          = 'haru-my-account';
		$this->widget_name        = esc_html__( 'Haru: My Account', 'haru-circle' );
		$this->settings           = array(
			'login_text' => array(
				'type'  => 'text',
				'std'   => 'Login',
				'label' => esc_html__( 'Login Text', 'haru-circle' )
			),
			'logout_text' => array(
				'type'  => 'text',
				'std'   => 'Logout',
				'label' => esc_html__( 'Logout Text', 'haru-circle' )
			),
			'register_text' => array(
				'type'  => 'text',
				'std'   => 'Register',
				'label' => esc_html__( 'Register Text', 'haru-circle' )
			),
			'account_text' => array(
				'type'  => 'text',
				'std'   => 'My Account',
				'label' => esc_html__( 'My Account (Profile) Text', 'haru-circle' )
			),
		);
		parent::__construct();
	}

	function widget( $args, $instance ) {
		if ( $this->get_cached_widget( $args ) )
			return;

		extract( $args, EXTR_SKIP );
		$login_text    = ( ! empty( $instance['login_text'] ) ) ? $instance['login_text'] : '';
		$logout_text   = ( ! empty( $instance['logout_text'] ) ) ? $instance['logout_text'] : '';
		$register_text = ( ! empty( $instance['register_text'] ) ) ? $instance['register_text'] : '';
		$account_text  = ( ! empty( $instance['account_text'] ) ) ? $instance['account_text'] : '';
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

		ob_start();
		echo wp_kses_post($args['before_widget']);
		?>
			<?php if ( !is_user_logged_in() ):?>
				<a href="<?php echo esc_url($login_url) ?>"><?php echo esc_html($login_text) ?></a> <?php echo esc_html__( 'or', 'haru-circle' ); ?>
				<a href="<?php echo esc_url($register_url); ?>"><?php echo esc_html($register_text) ?></a>
			<?php else: ?>
				<a href="<?php echo esc_url($account_url); ?>"><?php echo esc_html__($account_text); ?></a>
				<a href="<?php echo esc_url(wp_logout_url(is_home()? home_url('/') : get_permalink()) ); ?>"><?php echo esc_html($logout_text) ?></a>
			<?php endif; ?>
		<?php
		echo wp_kses_post($args['after_widget']);
		$content =  ob_get_clean();
		echo wp_kses_post($content);
		$this->cache_widget( $args, $content );
	}
}

if (!function_exists('haru_register_widget_my_account')) {
	function haru_register_widget_my_account() {
		register_widget('Haru_Widget_MyAccount');
	}
	add_action('widgets_init', 'haru_register_widget_my_account', 1);
}
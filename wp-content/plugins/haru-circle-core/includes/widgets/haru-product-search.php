<?php
/**
 *	Haru Widget: Haru Product Search
 *
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Haru_WC_Widget_Product_Search extends Haru_Widget {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_cssclass    	= 'haru_widget haru_widget_product_search woocommerce';
		$this->widget_description	= __( 'Display a product sorting list.', 'haru-circle' );
		$this->widget_id          	= 'haru_woocommerce_widget_product_search';
		$this->widget_name        	= __( 'Haru Product Search', 'haru-circle' );
		$this->settings           	= array(
			'type'  => array(
                'type'    => 'select',
                'std'     => '',
                'label'   => esc_html__( 'Type', 'haru-circle' ),
                'options' => array(
					'standard' => esc_html__( 'Standard Search', 'haru-circle' ),
					'ajax'     => esc_html__( 'Ajax Search', 'haru-circle' )
                )
            ),
		);
		
		parent::__construct();
	}

	/**
	 * Widget function
	 *
	 * @see WP_Widget
	 * @access public
	 * @param array $args
	 * @param array $instance
	 * @return void
	 */
	public function widget( $args, $instance ) {
		global $wp_query;
		
		extract( $args );
		
		$search_box_type   = 'standard';
		$search_box_submit = 'submit';
		$search_box_type              = ( ! empty( $instance['type'] ) ) ? $instance['type'] : '';
		if( $search_box_type == 'ajax' ) {
			$search_box_submit = 'button';
		}
		$output = '';

		$output .= 	'<div class="search-box-wrapper header-customize-item" data-hint-message="'.esc_html__( "Please type at least 3 characters to search", "haru-circle" ).'">
						<form method="get" action="'.esc_url(site_url()).'" class="search-type-'.esc_attr($search_box_type).' search-box">
							<input type="text" name="s" placeholder="'.esc_html__( 'Search', 'haru-circle' ).'"/>
							<button type="'.esc_attr($search_box_submit).'"><i class="wicon fa fa-search"></i></button>
						</form>
					</div>';

		echo $before_widget . $output . $after_widget;
	}
	
}
if ( ! function_exists('haru_register_product_search') ) {
	function haru_register_product_search() {
		register_widget('Haru_WC_Widget_Product_Search');
	}

	add_action('widgets_init', 'haru_register_product_search', 1);
}

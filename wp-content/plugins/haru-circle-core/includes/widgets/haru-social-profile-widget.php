<?php
/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

class Haru_Social_Profile extends Haru_Widget {
    public function __construct() {
        $this->widget_cssclass    = 'widget-social-profile';
        $this->widget_description = esc_html__( 'Social profile widget', 'haru-circle' );
        $this->widget_id          = 'haru-social-profile';
        $this->widget_name        = esc_html__( 'Haru: Social Profile', 'haru-circle' );
        $this->settings           = array(
            'label' => array(
				'type'  => 'text',
				'std'   => '',
				'label' => esc_html__( 'Label','haru-circle' )
            ),
	        'type'  => array(
                'type'    => 'select',
                'std'     => '',
                'label'   => esc_html__( 'Type', 'haru-circle' ),
                'options' => array(
                    'social-icon-no-border' => esc_html__( 'No Border', 'haru-circle' ),
                    'social-icon-bordered'  => esc_html__( 'Bordered', 'haru-circle' )
                )
            ),
            'icons' => array(
				'type'    => 'multi-select',
				'label'   => esc_html__( 'Select social profiles', 'haru-circle' ),
				'std'     => '',
				'options' => array(
					'twitter'    => esc_html__( 'Twitter', 'haru-circle' ),
					'facebook'   => esc_html__( 'Facebook', 'haru-circle' ),
					'dribbble'   => esc_html__( 'Dribbble', 'haru-circle' ),
					'vimeo'      => esc_html__( 'Vimeo', 'haru-circle' ),
					'tumblr'     => esc_html__( 'Tumblr', 'haru-circle' ),
					'skype'      => esc_html__( 'Skype', 'haru-circle' ),
					'linkedin'   => esc_html__( 'LinkedIn', 'haru-circle' ),
					'googleplus' => esc_html__( 'Google+', 'haru-circle' ),
					'flickr'     => esc_html__( 'Flickr', 'haru-circle' ),
					'youtube'    => esc_html__( 'YouTube', 'haru-circle' ),
					'pinterest'  => esc_html__( 'Pinterest', 'haru-circle' ),
					'foursquare' => esc_html__( 'Foursquare', 'haru-circle' ),
					'instagram'  => esc_html__( 'Instagram', 'haru-circle' ),
					'github'     => esc_html__( 'GitHub', 'haru-circle' ),
					'xing'       => esc_html__( 'Xing', 'haru-circle' ),
					'behance'    => esc_html__( 'Behance', 'haru-circle' ),
					'deviantart' => esc_html__( 'Deviantart', 'haru-circle' ),
					'soundcloud' => esc_html__( 'SoundCloud', 'haru-circle' ),
					'yelp'       => esc_html__( 'Yelp', 'haru-circle' ),
					'rss'        => esc_html__( 'RSS Feed', 'haru-circle' ),
					'email'      => esc_html__( 'Email address', 'haru-circle' ),
	            )
            )
        );
        parent::__construct();
    }

    function widget( $args, $instance ) {
        extract( $args, EXTR_SKIP );
		$label        = empty( $instance['label'] ) ? '' : apply_filters( 'widget_label', $instance['label'] );
		$type         = empty( $instance['type'] ) ? '' : apply_filters( 'widget_type', $instance['type'] );
		$icons        = empty( $instance['icons'] ) ? '' : apply_filters( 'widget_icons', $instance['icons'] );
		$widget_id    = $args['widget_id'];
		$social_icons = haru_get_social_icon($icons,'social-profile ' . $type );
	    echo wp_kses_post( $before_widget );
	    ?>
	    <?php if (!empty($label)) : ?>
		    <span><?php echo wp_kses_post($label); ?></span>
		<?php endif; ?>
		    <?php echo wp_kses_post( $social_icons ); ?>
	    <?php
	    echo wp_kses_post( $after_widget );
    }
}
if ( ! function_exists('haru_register_social_profile') ) {
    function haru_register_social_profile() {
        register_widget('Haru_Social_Profile');
    }

    add_action('widgets_init', 'haru_register_social_profile', 1);
}
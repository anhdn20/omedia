<?php
/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

if( ! class_exists( 'Haru_CircleCore_Posttypes' ) ) {
	class Haru_CircleCore_Posttypes {
		static $instance;

		public static function init() {
			if( !isset(self::$instance) ) {
				self::$instance = new Haru_CircleCore_Posttypes;
				add_action( 'init', array(self::$instance, 'includes'), 0 );
			}

			return self::$instance;
		}

		public function includes() {
			require_once( PLUGIN_HARU_CIRCLE_CORE_DIR . 'includes/posttypes/footer.php');
			require_once( PLUGIN_HARU_CIRCLE_CORE_DIR . 'includes/posttypes/teammember.php');
			require_once( PLUGIN_HARU_CIRCLE_CORE_DIR . 'includes/posttypes/testimonial.php');
			require_once( PLUGIN_HARU_CIRCLE_CORE_DIR . 'includes/posttypes/portfolio.php');

            // Circle
            require_once( PLUGIN_HARU_CIRCLE_CORE_DIR . 'includes/posttypes/actor.php');
            require_once( PLUGIN_HARU_CIRCLE_CORE_DIR . 'includes/posttypes/director.php');
            require_once( PLUGIN_HARU_CIRCLE_CORE_DIR . 'includes/posttypes/trailer.php');
            require_once( PLUGIN_HARU_CIRCLE_CORE_DIR . 'includes/posttypes/video.php');
            require_once( PLUGIN_HARU_CIRCLE_CORE_DIR . 'includes/posttypes/film.php');
			require_once( PLUGIN_HARU_CIRCLE_CORE_DIR . 'includes/posttypes/digitalasset.php');
		}
	}

	if ( ! function_exists('init_haru_circle_framework_posttypes') ) {
        function init_haru_circle_framework_posttypes() {
            return Haru_CircleCore_Posttypes::init();
        }

        init_haru_circle_framework_posttypes();
    }
}
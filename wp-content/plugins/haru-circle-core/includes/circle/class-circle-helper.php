<?php
/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

if ( ! class_exists( 'Haru_Circle_Helper' ) ) {
    class Haru_Circle_Helper {

        public function __construct() {
            // Ajax Video Modal
            add_action( 'wp_ajax_haru_video_modal', array($this, 'haru_video_modal' ));
            add_action( 'wp_ajax_nopriv_haru_video_modal', array($this, 'haru_video_modal' ));

            // Ajax Film Modal
            add_action( 'wp_ajax_haru_film_modal', array($this, 'haru_film_modal' ));
            add_action( 'wp_ajax_nopriv_haru_film_modal', array($this, 'haru_film_modal' ));

            // Get Player when change source
            add_action( 'wp_ajax_haru_get_player_ajax', array($this, 'haru_get_player_ajax' ));
            add_action( 'wp_ajax_nopriv_haru_get_player_ajax', array($this, 'haru_get_player_ajax' ));
            

            // Ajax Film Search
            add_action( 'wp_ajax_haru_film_shortcode_ajax_search', array($this, 'haru_film_shortcode_ajax_search' ));
            add_action( 'wp_ajax_nopriv_haru_film_shortcode_ajax_search', array($this, 'haru_film_shortcode_ajax_search' ));
            add_action( 'wp_ajax_haru_film_shortcode_ajax_search_loadmore', array($this, 'haru_film_shortcode_ajax_search_loadmore' ));
            add_action( 'wp_ajax_nopriv_haru_film_shortcode_ajax_search_loadmore', array($this, 'haru_film_shortcode_ajax_search_loadmore' ));

            // Ajax Trailer Modal
            add_action( 'wp_ajax_haru_trailer_modal', array($this, 'haru_trailer_modal' ));
            add_action( 'wp_ajax_nopriv_haru_trailer_modal', array($this, 'haru_trailer_modal' ));

            if ( is_admin() ) {
                // Do something
            }
        }

        public static function haru_video_modal() {
            echo haru_get_template('circle/video-modal.php', '', '', '' );
        }

        public static function haru_film_modal() {
            echo haru_get_template('circle/film-modal.php', '', '', '' );
        }

        public static function haru_get_player_ajax() {
            echo haru_get_template('circle/player-ajax.php', '', '', '' );
        }

        public static function haru_film_shortcode_ajax_search() {
            echo haru_get_template('circle/film-ajax-search.php', '', '', '' );
        }

        public static function haru_film_shortcode_ajax_search_loadmore() {
            echo haru_get_template('circle/film-ajax-search-loadmore.php', '', '', '' );
        }

        public static function haru_trailer_modal() {
            echo haru_get_template('circle/trailer-modal.php', '', '', '' );
        }
        
    }

    new Haru_Circle_Helper;
}
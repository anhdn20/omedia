<?php
/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

if( ! class_exists( 'Haru_Circle' ) ) {
    class Haru_Circle {
        static $instance;

        public function __construct() {
            $this->haru_circle_includes_files();
        }

        public function haru_circle_includes_files() {
            require_once( PLUGIN_HARU_CIRCLE_CORE_DIR . 'includes/circle/class-circle-helper.php');
        }
    }

    $haru_circle = new Haru_Circle;
}
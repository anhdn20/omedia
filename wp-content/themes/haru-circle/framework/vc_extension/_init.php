<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@HaruTheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://HaruTheme.com
*/

if( !function_exists('haru_include_vc_extension') ) {
    function haru_include_vc_extension() {
        require_once get_template_directory() . '/framework/vc_extension/functions.php';
        require_once get_template_directory() . '/framework/vc_extension/update_params.php';
    }

    haru_include_vc_extension();
}
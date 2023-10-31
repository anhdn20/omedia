<?php
/**
 *
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/
 
if( !function_exists( 'haru_core_files' ) ) {
    function haru_core_files() {
        // Include megamenu
        require_once get_template_directory() . '/framework/core/megamenu/megamenu.php';
        
    }
    
    haru_core_files();
}
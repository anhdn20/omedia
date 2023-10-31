<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, harutheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

$haru_header_layout = haru_get_header_layout();

// SHOW HEADER
$header_show_hide = '1'; // Always show header (can add option in metabox to hide header on special page)
$search_box_type  = haru_get_option('search_box_type');
?>
<?php if ( $header_show_hide == '1' ) : ?>
    <?php get_template_part( 'templates/header/header-mobile', 'template' ); ?>
    <?php get_template_part( 'templates/header/' . $haru_header_layout ); ?>
    <?php if ( isset($search_box_type) ) : ?>
        <?php get_template_part( 'templates/header/header-customize/search', 'popup' ); ?>
    <?php endif; ?>
<?php endif; ?>
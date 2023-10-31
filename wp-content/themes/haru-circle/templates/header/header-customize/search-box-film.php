<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

$data_search_type = 'standard';
if ( (haru_get_option('search_box_type') !='' ) && (haru_get_option('search_box_type') == 'ajax') ) {
    $data_search_type = 'ajax';
}
$search_box_type   = 'standard';
$search_box_submit = 'submit';
if ( haru_get_option('search_box_type') != '' ) {
    $search_box_type = haru_get_option('search_box_type');
}
if ( $search_box_type == 'ajax' ) {
    $search_box_submit = 'button';
}
?>
<div class="search-box-wrapper header-customize-item" data-hint-message="<?php echo esc_html__( 'Enter keyword to search', 'haru-circle' ); ?>">
    <form method="get" action="<?php echo esc_url(site_url()); ?>" class="search-type-<?php echo esc_attr($search_box_type) ?> search-box">
        <input type="text" name="s" placeholder="<?php echo esc_html__( 'Search for a Movie, Film...', 'haru-circle' ); ?>"/>
        <input type="hidden" name="post_type" value="haru_film" />
        <button type="<?php echo esc_attr($search_box_submit) ?>"><i class="wicon fa fa-search"></i><?php echo esc_html__( 'Search', 'haru-circle' ); ?></button>
    </form>
</div>
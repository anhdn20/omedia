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

$search_box_type = haru_get_option('search_box_type');
if ( isset($search_box_type)  && $search_box_type == 'ajax' ) {
    $data_search_type = 'ajax';
}
?>
<div class="search-button-wrapper header-customize-item">
    <a class="icon-search-menu" href="#" data-search-type="<?php echo esc_attr($data_search_type) ?>"><i class="wicon icon ion-ios-search"></i></a>
</div>
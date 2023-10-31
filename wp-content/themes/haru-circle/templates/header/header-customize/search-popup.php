<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

$search_box_type = haru_get_option('search_box_type');
$search_post_type = array();
$haru_search_box_post_type = haru_get_option('haru_search_box_post_type');
// Set default
if ( !isset($haru_search_box_post_type) || $haru_search_box_post_type == false ) {
    $haru_search_box_post_type = array();
}
foreach ( $haru_search_box_post_type as $key => $post_type  ) {
    if ( $post_type == '1' ) {
        array_push($search_post_type, $key);
    }
}
?>

<?php if ( isset($search_box_type)  && $search_box_type == 'ajax' ) : ?>
    <div id="haru-modal-search" tabindex="-1" role="dialog" aria-hidden="false" class="modal fade">
        <div class="modal-backdrop fade in"></div>
        <div class="haru-modal-dialog haru-modal-search fade in">
            <div data-dismiss="modal" class="haru-dismiss-modal"><i class="ion-ios-close"></i></div>
            <div class="haru-search-result">
                <div class="haru-search-wrapper">
                    <input id="search-ajax" type="search" placeholder="<?php echo esc_html__( 'Enter keyword to search', 'haru-circle' ) ?>">
                    <button><i class="ajax-search-icon ion-ios-search"></i></button>
                    <input type="hidden" name="post_type" value="<?php echo esc_attr( implode(',', $search_post_type) ); ?>">
                </div>
                <div class="ajax-search-result"></div>
            </div>
        </div>
    </div>
<?php else : ?>
    <div id="haru-modal-search" tabindex="-1" role="dialog" aria-hidden="false" class="modal fade">
        <div class="modal-backdrop fade in"></div>
        <div class="haru-modal-dialog haru-modal-search fade in">
            <div data-dismiss="modal" class="haru-dismiss-modal"><i class="ion-ios-close"></i></div>
            <div class="haru-search-result">
                <div class="haru-search-wrapper">
                    <form method="get" action="<?php echo esc_url(site_url()); ?>" class="search-popup-inner">
                        <input type="text" name="s" placeholder="<?php echo esc_html__( 'Search for...', 'haru-circle' ); ?>">
                        <button type="submit"><i class="ion-ios-search"></i></button>
                        <input type="hidden" name="post_type" value="<?php echo esc_attr( implode(',', $search_post_type) ); ?>">
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
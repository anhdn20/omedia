<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

$page_layout = get_post_meta( get_the_ID(), 'haru_' . 'page_layout', true );
if ( ($page_layout == '') || ($page_layout == '-1') ) {
    $page_layout = haru_get_option('page_layout');
}
// Set Default
if ( empty($page_layout) ) {
    $page_layout = 'container';
}

// Page sidebar
$page_sidebar = get_post_meta(  get_the_ID(), 'haru_' . 'page_sidebar', true );
if ( ($page_sidebar == '') || ($page_sidebar == '-1') ) {
    $page_sidebar = haru_get_option('page_sidebar');
}

$page_left_sidebar = get_post_meta( get_the_ID(), 'haru_' . 'page_left_sidebar', true );
if ( ($page_left_sidebar == '') || ($page_left_sidebar == '-1') ) {
    $page_left_sidebar = haru_get_option('page_left_sidebar');

}

$page_right_sidebar = get_post_meta( get_the_ID(), 'haru_' . 'page_right_sidebar', true );
if ( ($page_right_sidebar == '') || ($page_right_sidebar == '-1') ) {
    $page_right_sidebar = haru_get_option('page_right_sidebar');
}

// Calculate sidebar column & content column
$page_content_columns = 12;
if ( $page_sidebar != 'none' && (is_active_sidebar( $page_left_sidebar ) || is_active_sidebar( $page_right_sidebar )) ) {
    $page_content_columns = 9;
} else {
    $page_content_columns = 12;
}

$main_class = array('haru-page');

if ( $page_content_columns < 12 ) {
    $main_class[] = 'has-sidebar';
}
?>
<?php
/**
 * @hooked - haru_page_heading - 5
 **/
do_action('haru_before_page');
?>
<main class="<?php echo esc_attr( join(' ',$main_class) ); ?>">
    <?php if ( $page_layout != 'full' ) : ?>
    <div class="<?php echo esc_attr($page_layout); ?> clearfix">
    <?php endif; ?>
        <?php if ( ($page_content_columns != 12) || ($page_layout != 'full') ) : ?>
        <div class="row clearfix">
        <?php endif; ?>
            
            <div class="page-content col-md-<?php echo esc_attr($page_content_columns); ?> <?php if( is_active_sidebar( $page_left_sidebar ) && ($page_sidebar == 'left') ) echo esc_attr('has-left-sidebar'); ?> col-sm-12 col-xs-12">
                <div class="page-wrapper">
                    <div class="page-inner clearfix">
                        <?php
                        // Start the Loop.
                        while (have_posts()) : the_post();
                            // Include the page content template.
                            get_template_part('templates/page/content', 'page');

                            // If comments are open or we have at least one comment, load up the comment template.
                            if ( comments_open() || get_comments_number() ) {
                                comments_template();
                            }
                        endwhile;
                        ?>
                    </div>
                </div>
            </div>
            <?php if ( is_active_sidebar( $page_left_sidebar ) && ($page_sidebar == 'left') ) : ?>
                <div class="page-sidebar left-sidebar col-md-3 col-sm-12 col-xs-12">
                    <?php dynamic_sidebar( $page_left_sidebar ); ?>
                </div>
            <?php endif; ?>
            <?php if ( is_active_sidebar( $page_right_sidebar ) && ($page_sidebar == 'right') ) : ?>
                <div class="page-sidebar right-sidebar col-md-3 col-sm-12 col-xs-12">
                    <?php dynamic_sidebar( $page_right_sidebar ); ?>
                </div>
            <?php endif;?>
        <?php if ( ($page_content_columns != 12) || ($page_layout != 'full') ) : ?>
        </div>
        <?php endif;?>
    <?php if ( $page_layout != 'full' ) : ?>
    </div>
    <?php endif;?>
</main>
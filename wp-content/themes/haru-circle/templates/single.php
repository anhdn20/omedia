<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

// Process single blog layout
$single_blog_layout = isset($_GET['layout']) ? $_GET['layout'] : '';
if ( !in_array($single_blog_layout, array('full', 'container')) ) {
    $single_blog_layout = get_post_meta( get_the_ID(), 'haru_' . 'page_layout', true);
    if ( ($single_blog_layout == '') || ($single_blog_layout == '-1') ) {
       $single_blog_layout = haru_get_option('single_blog_layout');
    }
}
// Set Default
if ( empty($single_blog_layout) ) {
    $single_blog_layout = 'container';
}

// Process sidebar
$single_blog_sidebar = isset($_GET['sidebar']) ? $_GET['sidebar'] : '';
if( !in_array($single_blog_sidebar, array('none','left','right')) ) {
    $single_blog_sidebar = get_post_meta( get_the_ID(), 'haru_' . 'page_sidebar', true );
    if( ($single_blog_sidebar == '') || ($single_blog_sidebar == '-1') ) {
        $single_blog_sidebar = haru_get_option('single_blog_sidebar');
    }
}
// Set Default
if ( empty($single_blog_sidebar) ) {
    $single_blog_sidebar = 'right';
}

$single_blog_left_sidebar = get_post_meta( get_the_ID(), 'haru_' . 'page_left_sidebar', true );
if( ($single_blog_left_sidebar == '') || ($single_blog_left_sidebar == '-1') ) {
    $single_blog_left_sidebar = haru_get_option('single_blog_left_sidebar');
}
// Set Default
if ( empty($single_blog_left_sidebar) ) {
    $single_blog_left_sidebar = 'sidebar-1';
}

$single_blog_right_sidebar = get_post_meta( get_the_ID(), 'haru_' . 'page_right_sidebar', true );
if ( ($single_blog_right_sidebar == '') || ($single_blog_right_sidebar == '-1') ) {
    $single_blog_right_sidebar = haru_get_option('single_blog_right_sidebar');
}

if ( empty($single_blog_right_sidebar) ) {
    $single_blog_right_sidebar = 'sidebar-1';
}

// Calculate sidebar column & content column
$single_content_columns = 12;
if( $single_blog_sidebar != 'none' && (is_active_sidebar( $single_blog_left_sidebar ) || is_active_sidebar( $single_blog_right_sidebar )) ) {
    $single_content_columns = 9;
} else {
    $single_content_columns = 12;
}

?>
<?php
/**
 * @hooked - haru_page_heading - 5
 **/
do_action('haru_before_page');
?>
<div class="haru-single-blog">
    <?php if($single_blog_layout != 'full'): ?>
    <div class="<?php echo esc_attr($single_blog_layout); ?> clearfix">
    <?php endif;?>
        <?php if( ($single_content_columns != 12) || ($single_blog_layout != 'full') ): ?>
        <div class="row clearfix">
        <?php endif;?>
            <!-- Single content -->
            <div class="single-content col-md-<?php echo esc_attr($single_content_columns); ?> <?php if( is_active_sidebar( $single_blog_left_sidebar ) && ($single_blog_sidebar == 'left') ) echo esc_attr('has-left-sidebar'); ?> col-sm-12 col-xs-12">
                <div class="single-wrapper">
                    <?php
                    if( have_posts() ):
                        // Start the Loop.
                        while( have_posts() ) : the_post();
                            /*
                             * Include the post format-specific template for the content. If you want to
                             * use this in a child theme, then include a file called called content-___.php
                             * (where ___ is the post format) and that will be used instead.
                             */
                            get_template_part( 'templates/single/content' , get_post_format() );
                        endwhile;
                    else:
                        // If no content, include the "No posts found" template.
                        get_template_part( 'templates/archive/content-none');
                    endif;
                    ?>
                    <?php comments_template(); ?>
                </div>
            </div>
            <?php if( is_active_sidebar( $single_blog_left_sidebar ) && ($single_blog_sidebar == 'left') ): ?>
                <div class="single-sidebar left-sidebar col-md-3 col-sm-12 col-xs-12">
                    <?php dynamic_sidebar( $single_blog_left_sidebar ); ?>
                </div>
            <?php endif; ?>
            <?php if( is_active_sidebar( $single_blog_right_sidebar ) && (($single_blog_sidebar == 'right')) ): ?>
                <div class="single-sidebar right-sidebar col-md-3 col-sm-12 col-xs-12">
                    <?php dynamic_sidebar( $single_blog_right_sidebar ); ?>
                </div>
            <?php endif; ?>
        <?php if( ($single_content_columns != 12) || ($single_blog_layout != 'full') ): ?>
        </div>
        <?php endif;?>
    <?php if ($single_blog_layout != 'full'): ?>
    </div>
    <?php endif;?>
</div>
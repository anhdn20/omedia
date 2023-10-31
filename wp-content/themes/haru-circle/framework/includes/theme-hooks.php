<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

/* 
 * TABLE OF FUNCTIONS
 * 1. haru_before_page_main
 * 2. haru_after_page_main
 * 3. haru_archive_heading
 * 4. haru_after_single_post_content
 * 5. haru_after_single_post
 * 6. haru_before_page
 * 7. haru_footer_main
*/

/* 1. haru_before_page_main */
if( !function_exists( 'haru_site_preloader' ) ) {
    function haru_site_preloader() {
        get_template_part( 'templates/site-preloader' );
    }
}
add_action( 'haru_before_page_main', 'haru_site_preloader', 5 );

if( !function_exists( 'haru_newsletter_popup' ) ) {
    function haru_newsletter_popup() {
        get_template_part( 'templates/newsletter-popup' );
    }
}
add_action( 'haru_before_page_main', 'haru_newsletter_popup', 10 );

/* 2. haru_after_page_main */
/* 2.1. Back to Top */
if( !function_exists( 'haru_back_to_top' ) ) {
    function haru_back_to_top() {
        get_template_part( 'templates/back-to-top' );
    }
}
$back_to_top = haru_get_option('back_to_top');
if ( NULL !== $back_to_top && $back_to_top == true ) {
    add_action( 'haru_after_page_main', 'haru_back_to_top', 5 );
}

/* 2.2. Header canvas menu*/
add_action('haru_after_page_main','haru_add_canvas_menu_region', '10');
function haru_add_canvas_menu_region() {
    ?>
    <div class="haru-canvas-menu-wrapper dark">
        <a href="#" class="haru-canvas-menu-close"><i class="fa fa-close"></i></a>
        <div class="haru-canvas-menu-inner sidebar">
            <?php 
                if (is_active_sidebar('canvas-menu')) { 
                    dynamic_sidebar('canvas-menu'); 
                } 
            ?>
        </div>
    </div>
    <?php
}
/* 2.3. Ajax loading overflow (also can change loading effect similar page loading) */
add_action('haru_after_page_main','haru_ajax_loading', '10');
function haru_ajax_loading() {
    ?>
    <div class="haru-ajax-overflow">
        <div class="haru-ajax-loading">
            <div class="loading-wrapper">
                <div class="spinner" id="spinner_one"></div>
                <div class="spinner" id="spinner_two"></div>
                <div class="spinner" id="spinner_three"></div>
                <div class="spinner" id="spinner_four"></div>
                <div class="spinner" id="spinner_five"></div>
                <div class="spinner" id="spinner_six"></div>
                <div class="spinner" id="spinner_seven"></div>
                <div class="spinner" id="spinner_eight"></div>
            </div>
        </div>
    </div>
    <?php
}

/* 3. haru_archive_heading */
if (!function_exists('haru_archive_heading')) {
    function haru_archive_heading() {
        get_template_part( 'templates/archive/archive-heading' );
    }
}
add_action( 'haru_before_archive', 'haru_archive_heading', 5 );


/* 4. haru_after_single_post_content */
/* 4.1. Link pages */
if (!function_exists('haru_link_pages')) {
    function haru_link_pages() {
        wp_link_pages(array(
            'before'      => '<div class="haru-page-links"><span class="haru-page-links-title">' . esc_html__( 'Pages:', 'haru-circle' ) . '</span>',
            'after'       => '</div>',
            'link_before' => '<span class="haru-page-link">',
            'link_after'  => '</span>',
        ));
    }
    add_action('haru_after_single_post_content', 'haru_link_pages', 5);
}
/* 4.2. Post tags */
if (!function_exists('haru_post_tags')) {
    function haru_post_tags() {
        get_template_part('templates/single/post-tags');
    }
    add_action( 'haru_after_single_post_content', 'haru_post_tags', 10 );
}
/* 4.3. Share */
if (!function_exists('haru_share')) {
    function haru_share() {
        get_template_part('templates/single/social-share');
    }
    add_action( 'haru_after_single_post_content', 'haru_share', 15 );
}

/* 5. haru_after_single_post */
/* 5.1. Post navigation */
if (!function_exists('haru_post_nav')) {
    function haru_post_nav() {
        get_template_part( 'templates/single/post-nav' );
    }
    add_action( 'haru_after_single_post', 'haru_post_nav', 5 );
}

/* 5.2. Post Author */
if (!function_exists('haru_post_author')) {
    function haru_post_author() {
        get_template_part( 'templates/single/post-author' );
    }
    add_action( 'haru_after_single_post', 'haru_post_author', 10 );
}
/* 5.3. Post Related */
if (!function_exists('haru_post_related')) {
    function haru_post_related() {
        get_template_part( 'templates/single/post-related' );
    }
    add_action( 'haru_after_single_post', 'haru_post_related', 15 );
}

/* 6. haru_before_page */
/* 6.1. Page Heading */
if (!function_exists('haru_page_heading')) {
    function haru_page_heading() {
        get_template_part( 'templates/page-heading' );
    }
    add_action('haru_before_page','haru_page_heading', 5);
}

/* 7. haru_footer_main */
if ( !function_exists( 'haru_footer_block' ) ) {
    function haru_footer_block() {
        get_template_part( 'templates/footer/footer' );
    }
    add_action( 'haru_footer_main',  'haru_footer_block', 5 );
}

/* 8. HARU HEADER*/
/* 8.1 HARU Topbar */
if ( !function_exists('haru_page_top_bar') ) {
    function haru_page_top_bar() {
        get_template_part('templates/top-bar');
    }
    add_action( 'haru_before_page_wrapper_content', 'haru_page_top_bar', 5 );
}

/* 8.2. HARU Header */
if ( !function_exists('haru_page_header') ) {
    function haru_page_header() {
        get_template_part('templates/header', 'template' );
    }
    add_action( 'haru_before_page_wrapper_content', 'haru_page_header', 10 );
}

/* 9. Render Comments */
if ( !function_exists('haru_render_comments') ) {
    function haru_render_comments($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment; ?>
        <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
            <div id="comment-<?php comment_ID(); ?>" class="comment-body clearfix">
                <div class="author-avatar">
                    <?php echo get_avatar($comment, $args['avatar_size']); ?>
                </div>
                <div class="comment-text">
                    <div class="author">
                        <div class="author-name"><?php printf(esc_html__('%s', 'haru-circle'), get_comment_author_link()) ?></div>
                    </div>
                    <div class="text">
                        <?php comment_text(); ?>
                        <?php if ($comment->comment_approved == '0') : ?>
                            <em><?php echo esc_html__('Your comment is awaiting moderation.', 'haru-circle') ?></em>
                        <?php endif; ?>
                    </div>
                    <div class="comment-meta">
                        <div class="comment-meta-date">
                            <span class="time">
                                <?php echo get_comment_date(); ?>
                            </span>
                        </div>
                        <div class="comment-meta-action">
                            <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
                            <?php edit_comment_link(esc_html__('Edit', 'haru-circle'), '', '') ?>
                        </div>
                    </div>
                </div>
            </div>
    <?php
    }
}

/* 13. Comments Form */
if ( !function_exists('haru_comment_form') ) {
    function haru_comment_form( $args = array(), $post_id = null ) {
        global $id;
        $user = wp_get_current_user();
        $user_identity = $user->exists() ? $user->display_name : '';

        if ( null === $post_id ) {
            $post_id = $id;
        }
        else {
            $id = $post_id;
        }

        if ( comments_open( $post_id ) ) :
        ?>
        <div id="respond-wrapper">
            <?php
                $commenter = wp_get_current_commenter();
                $req       = get_option( 'require_name_email' );
                $aria_req  = ( $req ? " aria-required='true'" : '' );
                $fields    =  array(
                    'author'        => '<div class="row"><p class="comment-form-author col-sm-6 col-xs-12"><input id="author" name="author" type="text" placeholder="' . esc_html__( 'Enter Your Name*', 'haru-circle' ) . '" class="form-control" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
                    'email'         => '<p class="comment-form-email col-sm-6 col-xs-12"><input id="email" name="email" type="text" placeholder="' . esc_html__( 'Enter Your Email*', 'haru-circle' ) . '" class="form-control" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>comment</div>',
                    'comment_field' => '<div class="row"><div class="col-sm-12"><p class="comment-form-comment"><textarea class="form-control" placeholder="' . esc_html__( 'Enter Your Comment', 'haru-circle' ) . '" id="comment" name="comment" cols="40" rows="6" aria-required="true"></textarea></p></div></div>'
                );
                $comments_args = array(
                        'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
                        'logged_in_as'         => '<p class="logged-in-as">' .
                        sprintf(
                        __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'haru-circle' ),
                          admin_url( 'profile.php' ),
                          $user_identity,
                          wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
                        ) . '</p>',
                        'title_reply'          => esc_html__( 'Leave us a comment', 'haru-circle' ),
                        'title_reply_to'       => esc_html__( 'Leave a reply to %s', 'haru-circle' ),
                        'cancel_reply_link'    => esc_html__( 'Click here to cancel the reply', 'haru-circle' ),
                        'comment_notes_before' => '',
                        'comment_notes_after'  => '',
                        'label_submit'         => esc_html__( 'Post Comment', 'haru-circle' ),
                        'comment_field'        => '',
                        'must_log_in'          => ''
                );
                if ( is_user_logged_in() ) {
                    $comments_args['comment_field'] = '<p class="comment-form-comment"><textarea class="form-control" placeholder="' . esc_html__( 'Enter Your Comment', 'haru-circle' ) . '" id="comment" name="comment" cols="40" rows="6" aria-required="true"></textarea></p>';
                }
                comment_form($comments_args);
            ?>
        </div>

        <?php
        endif;
    }
}

/* 14. Comments Time */
if (!function_exists('haru_relative_time')) {
    function haru_relative_time( $a = '' ) {
       return human_time_diff($a, current_time( 'timestamp' ));
    }
}

/* 15. Set Archive Search Custom Post type */
if ( !function_exists( 'haru_template_archive_search' ) ) {
    function haru_template_archive_search( $template ) {
        global $wp_query;

        $post_type = get_query_var('post_type');
        if( $wp_query->is_search && $post_type == 'haru_film' ) {
            return locate_template('search-archive.php'); //  redirect to search-archive.php
        }   
        return $template;
    }
    add_filter( 'template_include', 'haru_template_archive_search' );
}
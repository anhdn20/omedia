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

/* 
 * TABLE OF FUNCTIONS
 * 1. Add/Delete Custom Sidebar 
 * 2. Get current page url
 * 3. Get sidebar list
 * 4. Get option by option name
 * 5. Adds custom classes to the array of body classes
 * 6. Archive blog paging
 * 7. Post thumbnail
 * 8. Get post meta
 * 9. Breadcrumb
 * 10. Add post classes
 * 11. Footer Stylesheet
 * 12. Generate less to css
*/

/* 
 * 1. Add/Delete Custom Sidebar functions 
*/
function haru_custom_sidebar_form() {
?>
    <form action="<?php echo admin_url( 'widgets.php' ); ?>" method="post" id="haru-form-add-sidebar">
        <input type="text" name="sidebar_name" id="sidebar_name" placeholder="<?php echo esc_html__( 'Enter Custom Sidebar Name', 'haru-circle' ); ?>" />
        <button class="button-primary" id="haru-add-sidebar"><?php echo esc_html__( 'Add Sidebar', 'haru-circle' ); ?></button>
    </form>
<?php
}

add_action( 'sidebar_admin_page', 'haru_custom_sidebar_form' );

function haru_get_custom_sidebars() {
    $option_name = 'haru_custom_sidebars';

    return get_option($option_name);
}

function haru_add_custom_sidebar() {
    if( isset($_POST['sidebar_name']) ) {
        $option_name = 'haru_custom_sidebars';
        if( !get_option($option_name) || get_option($option_name) == '' ) {
            delete_option($option_name);
        }
        
        $sidebar_name = $_POST['sidebar_name'];
        
        if( get_option($option_name) ) {
            $custom_sidebars = haru_get_custom_sidebars();
            if( !in_array($sidebar_name, $custom_sidebars) ) {
                $custom_sidebars[] = $sidebar_name;
            }
            $result1 = update_option($option_name, $custom_sidebars);
        }
        else {
            $custom_sidebars[] = $sidebar_name;
            $result2 = add_option($option_name, $custom_sidebars);
        }
        
        if( $result1 ) {
            die('Updated');
        }
        elseif( $result2 ) {
            die('Added');
        }
        else {
            die('Error');
        }
    }

    die('');
}

add_action('wp_ajax_haru_add_custom_sidebar', 'haru_add_custom_sidebar');

function haru_delete_custom_sidebar() {
    if( isset($_POST['sidebar_name']) ) {
        $option_name = 'haru_custom_sidebars';
        $del_sidebar = trim($_POST['sidebar_name']);
        $custom_sidebars = haru_get_custom_sidebars();
        foreach( $custom_sidebars as $key => $value ) {
            if( $value == $del_sidebar ) {
                unset($custom_sidebars[$key]);
                break;
            }
        }
        $custom_sidebars = array_values($custom_sidebars);
        update_option($option_name, $custom_sidebars);
        die('Deleted');
    }
    die('');
}

add_action('wp_ajax_haru_delete_custom_sidebar', 'haru_delete_custom_sidebar');
/* End Add/Delete Custom Sidebar functions */

/* 
 * 3. Get sidebar list
*/
if ( !function_exists( 'haru_get_sidebar_list' ) ) {
    function haru_get_sidebar_list() {

        if ( !is_admin() ) {
            return array();
        }

        $sidebar_list = array();

        foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) {
            $sidebar_list[ $sidebar['id'] ] = ucwords( $sidebar['name'] );
        }

        return $sidebar_list;
    }
}

/**
 * 4. Get option by option name
 * @param $haru_circle_options
 * @return string
 */
function haru_get_option( $option_name = '' ) {
    
    if ( !class_exists('ReduxFramework') ) return false;

    global $haru_circle_options;
    if ( isset($haru_circle_options[$option_name]) ) {
        $option_name =  $haru_circle_options[$option_name];
    } else {
        $option_name = NULL;
    }
    return $option_name;
}

/**
 * 5. Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function haru_body_classes( $classes ) {
    // $classes[] = 'woocommerce';
    // Adds layout style class to body
    $layout_style = get_post_meta( get_the_ID(), 'haru_' . 'layout_style', true );
    if ( $layout_style == '-1' || $layout_style == '' ) {
        $layout_style = haru_get_option('layout_style');
    }

    // Adds a class of group-blog to blogs with more than 1 published author.
    if ( is_multi_author() ) {
        $classes[] = 'group-blog';
    }
    if( isset($layout_style) && $layout_style == 'boxed' ) {
        $classes[] = 'layout-boxed';
    }
    if( isset($layout_style) && $layout_style == 'wide' ) {
        $classes[] = 'layout-wide';
    }
    if( isset($layout_style) && $layout_style == 'float' ) {
        $classes[] = 'layout-float';
    }
    // Adds a class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }
    // Adds a class site preload to body
    $home_preloader = haru_get_option('home_preloader');
    if( isset($home_preloader) && $home_preloader != '' ) {
        $classes[] = 'haru-site-preloader';
    }

    // Adds popup class to body
    $show_popup =  haru_get_option('show_popup');
    if ( $show_popup != false ) {
        $classes[] = 'open-popup';
    }

    // Adds a class to page
    $page_extra_class = get_post_meta( get_the_ID(), 'haru_'.'page_extra_class', true );
    if ( $page_extra_class != '' ) {
        $classes[] = $page_extra_class;
    }

    // Adds header layout float
    $header_layout_float = get_post_meta( get_the_ID(), 'haru_' . 'header_layout_float', true );
    if ( ($header_layout_float == '') || ($header_layout_float == '-1') ) {
        $header_layout_float = haru_get_option('header_layout_float');
    }
    if ( $header_layout_float == '1' ) {
        $classes[] = 'header-float';
    }
    $haru_header_layout = haru_get_header_layout();
    if( ( $haru_header_layout == 'header-4' ) || ( $haru_header_layout == 'header-5' ) ) {
        $classes[] = 'header-sidebar';
    }

    return $classes;
}

add_filter( 'body_class', 'haru_body_classes' );

/* 6. HARU Header Layout */
if ( !function_exists('haru_get_header_layout') ) {
    function haru_get_header_layout() {
        $haru_header_layout = 'header-1';
        
        $get_header_layout_page  = get_post_meta( get_the_ID(), 'haru_' . 'header_layout', true );

        $header_layout = haru_get_option('header_layout');
        if ( $header_layout != '' ) {
            $haru_header_layout = $header_layout;
        }

        if ( $get_header_layout_page ) {
            $haru_header_layout = $get_header_layout_page;
        }

        return $haru_header_layout;
    }
}

/* 7. Archive blog paging */
/* 7.1. Paging Load More */
if (!function_exists('haru_paging_load_more')) {
    function haru_paging_load_more() {
        global $wp_query;
        // Don't print empty markup if there's only one page.
        if ( $wp_query->max_num_pages < 2 ) {
            return;
        }
        $link = get_next_posts_page_link($wp_query->max_num_pages);
        if (!empty($link)) :
            ?>
            <button data-href="<?php echo esc_url($link); ?>" type="button"  data-loading-text="<span class='fa fa-spinner fa-spin'></span> <?php echo esc_html__("Loading...",'haru-circle'); ?>" class="blog-load-more">
                <?php echo esc_html__("Load More",'haru-circle'); ?>
            </button>
        <?php
        endif;
    }
}

/* 7.2. Paging Infinite Scroll */
if (!function_exists('haru_paging_infinitescroll')) {
    function haru_paging_infinitescroll(){
        global $wp_query;
        // Don't print empty markup if there's only one page.
        if ( $wp_query->max_num_pages < 2 ) {
            return;
        }
        $link = get_next_posts_page_link($wp_query->max_num_pages);
        if (!empty($link)) :
            ?>
            <nav id="infinite_scroll_button">
                <a href="<?php echo esc_url($link); ?>"></a>
            </nav>
            <div id="infinite_scroll_loading" class="text-center infinite-scroll-loading"></div>
        <?php
        endif;
    }
}

/* 7.3. Paging Nav */
if ( ! function_exists( 'haru_paging_nav' ) ) {
    function haru_paging_nav() {
        global $wp_query, $wp_rewrite;
        // Don't print empty markup if there's only one page.
        if ( $wp_query->max_num_pages < 2 ) {
            return;
        }

        if ( is_front_page() ) {
            $paged   = get_query_var( 'page' ) ? intval( get_query_var( 'page' ) ) : 1;
        } else {
            $paged   = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
        }

        $pagenum_link = html_entity_decode( get_pagenum_link() );
        $query_args   = array();
        $url_parts    = explode( '?', $pagenum_link );

        if ( isset( $url_parts[1] ) ) {
            wp_parse_str( $url_parts[1], $query_args );
        }

        $pagenum_link = esc_url(remove_query_arg( array_keys( $query_args ), $pagenum_link ));
        $pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

        $format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
        $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

        // Set up paginated links.
        $page_links = paginate_links( array(
            'base'      => $pagenum_link,
            'format'    => $format,
            'total'     => $wp_query->max_num_pages,
            'current'   => $paged,
            'mid_size'  => 1,
            'add_args'  => array_map( 'urlencode', $query_args ),
            'prev_text' => esc_html__( 'Prev', 'haru-circle' ),
            'next_text' => esc_html__( 'Next', 'haru-circle' ),
            'type'      => 'array'
        ) );

        if (count($page_links) == 0) return;

        $links = "<ul class='page-numbers'>\n\t<li>";
        $links .= join("</li>\n\t<li>", $page_links);
        $links .= "</li>\n</ul>\n";

        return $links;
    }
}

/* 8. Get post thumbnail */
/* 8.1. Get post thumbnail */
if (!function_exists('haru_post_thumbnail')) {
    function haru_post_thumbnail() {
        $html   = '';


        if( 'image' == get_post_format() ) {
            $args = array(
                'meta_key' => 'haru_'.'post_format_image'
            );
            $image = haru_get_image($args);
            if (!$image) return;
            $html = haru_get_image_hover($image, get_permalink(), the_title_attribute('echo=0'),get_the_ID());
        } 
        elseif ( 'gallery' == get_post_format() ) {
            $images = haru_get_post_meta(get_the_ID(), 'haru_'.'post_format_gallery');
            if (count($images) > 0) {
                $html = "<div class='owl-carousel owl-theme post-gallery'>";
                foreach ($images as $image) {
                    $image_src_arr = wp_get_attachment_image_src( $image, 'full' );
                    if ($image_src_arr) {
                        $image_src = $image_src_arr[0];
                    }

                    if (!empty($image_src)) {
                        $html .= haru_get_image_hover( $image_src, get_permalink(), the_title_attribute('echo=0'), get_the_ID(), 1 );
                    }
                }
                $html .= '</div>';
            }
        } 
        elseif ( 'video' == get_post_format() ) {
            $video = haru_get_post_meta(get_the_ID(), 'haru_'.'post_format_video');
            if (!is_single()) {
                $args = array(
                    'meta_key' => ''
                );
                $image = haru_get_image($args);
                if (!$image) {
                    if (count($video) > 0) {
                        $html .= '<div class="embed-responsive embed-responsive-16by9 embed-responsive">';
                        $video = $video[0];
                        // If URL: show oEmbed HTML
                        if (filter_var($video, FILTER_VALIDATE_URL)) {
                            $args = array(
                                'wmode' => 'transparent'
                            );
                            $html .= wp_oembed_get($video, $args);
                        } // If embed code: just display
                        else {
                            $html .= $video;
                        }
                        $html .= '</div>';
                    }
                } else {
                    $video = $video[0];
                    if (filter_var($video, FILTER_VALIDATE_URL)) {
                        $html .= haru_get_video_hover($image, get_permalink(), the_title_attribute('echo=0'), $video);
                    } else {
                        $html .= '<div class="embed-responsive embed-responsive-16by9 embed-responsive">';
                        $html .= $video;
                        $html .= '</div>';
                    }
                }
            } else {
                if (count($video) > 0) {
                    $html .= '<div class="embed-responsive embed-responsive-16by9 embed-responsive">';
                    $video = $video[0];
                    // If URL: show oEmbed HTML
                    if (filter_var($video, FILTER_VALIDATE_URL)) {
                        $args = array(
                            'wmode' => 'transparent'
                        );
                        $html .= wp_oembed_get($video, $args);
                    } // If embed code: just display
                    else {
                        $html .= $video;
                    }
                    $html .= '</div>';
                }
            }
        } 
        elseif ( 'audio' == get_post_format() ) {
            $audio = haru_get_post_meta(get_the_ID(), 'haru_'.'post_format_audio');
            if (count($audio) > 0) {
                // @TODO: update image hover audio
                $audio = $audio[0];
                if (filter_var($audio, FILTER_VALIDATE_URL)) {
                    $html .= wp_oembed_get($audio);
                    $title = esc_attr(get_the_title());
                    $audio = esc_url($audio);
                    if (empty($html)) {
                        $id   = uniqid();
                        $html .= "<div data-player='$id' class='jp-jplayer' data-audio='$audio' data-title='$title'></div>";
                        $html .= haru_jplayer($id);
                    }
                } else {
                    $html .= $audio;
                }
                $html .= '<div style="clear:both;"></div>';
            }
        }
        elseif ( 'link' == get_post_format() ) {
            $link_url = haru_get_post_meta(get_the_ID(), 'haru_'.'post_format_link_url');
            $link_text = haru_get_post_meta(get_the_ID(), 'haru_'.'post_format_link_text');
            if ( count($link_url) > 0 && count($link_text) > 0) {
                $link_url = $link_url[0];
                $link_text = $link_text[0];
                $html .= '<div class="post_format_text_link">';
                $html .= '<a href="'.esc_url($link_url).'" title="'.$link_text.'">'.$link_text.'</a>';
                $html .= '</div>';
            }
        }
        elseif ( 'quote' == get_post_format() ) {
            $quote = haru_get_post_meta(get_the_ID(), 'haru_'.'post_format_quote');
            $quote_author = haru_get_post_meta(get_the_ID(), 'haru_'.'post_format_quote_author');
            $quote_author_url = haru_get_post_meta(get_the_ID(), 'haru_'.'post_format_quote_author_url');
            if (count($quote) > 0) {
                $html .= '<blockquote><div class="post_quote">';
                $html .= $quote[0];
                $html .= '</div></blockquote>';
            } 
        }
        else {
            $args = array(
                'meta_key' => ''
            );
            $image = haru_get_image($args);
            if (!$image) return;
            $html = haru_get_image_hover( $image, get_permalink(), the_title_attribute('echo=0'),get_the_ID() );
        }

        return $html;
    }
}

/* 8.2 Get post image */ 
if (!function_exists('haru_get_image')) {
    function haru_get_image($args) {
        $default = apply_filters(
            'haru_get_image_default_args',
            array(
                'post_id'  => get_the_ID(),
                'attr'     => '',
                'meta_key' => '',
                'scan'     => false,
                'default'  => ''
            )
        );

        $args   = wp_parse_args( $args, $default );

        if ( ! $args['post_id'] ) {
            $args['post_id'] = get_the_ID();
        }
        $image_src = '';

        // Get post thumbnail
        if (has_post_thumbnail($args['post_id'])) {
            $post_thumbnail_id   = get_post_thumbnail_id($args['post_id']);
            $image_src_arr = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
            if ($image_src_arr) {
                $image_src = $image_src_arr[0];
            }
        }

        // Get the first image in the custom field
        if ((!isset($image_src) || empty($image_src))  && $args['meta_key']) {
            $post_thumbnail_id = haru_get_post_meta( $args['post_id'], $args['meta_key'], true );
            if ( $post_thumbnail_id ) {
                $image_src_arr = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
                if ($image_src_arr) {
                    $image_src = $image_src_arr[0];
                }
            }
        }

        // Get the first image in the post content
        if ((!isset($image_src) || empty($image_src)) && ($args['scan'])) {
            preg_match( '|<img.*?src=[\'"](.*?)[\'"].*?>|i', get_post_field( 'post_content', $args['post_id'] ), $matches );
            if ( ! empty( $matches ) ){
                $image_src  = $matches[1];
            }
        }

        // Use default when nothing found
        if ( (!isset($image_src) || empty($image_src)) && ! empty( $args['default'] ) ){
            if ( is_array( $args['default'] ) ){
                $image_src  = $args['src'];
            } else {
                $image_src = $args['default'];
            }
        }

        if (!isset($image_src) || empty($image_src)) {
            return false;
        }

        return $image_src;
    }
}

/* 8.3 Get image hover */ 
if ( !function_exists('haru_get_image_hover') ) {
    function haru_get_image_hover( $image, $url, $title, $post_id, $gallery = 0 ) {
        $attachment_id  = haru_get_attachment_id_from_url($image);
        $image_full_arr = wp_get_attachment_image_src($attachment_id,'full');
        $image_full     = $image;
        if (isset($image_full_arr)) {
            $image_full = $image_full_arr[0];
        }

        $prettyPhoto = 'prettyPhoto';
        if ($gallery == 1) {
            $prettyPhoto='prettyPhoto[blog_'.$post_id.']';
        }

        if ( !is_single() ) { 
            return sprintf('<div class="post-thumbnail">
                                <a href="%1$s" class="post-thumbnail-overlay">
                                    <img class="img-responsive" src="%3$s" alt="%2$s"/>
                                </a>
                                <a data-rel="%5$s" href="%4$s" class="prettyPhoto"><i class="fa fa-expand"></i></a>
                            </div>',
                $url,
                $title,
                $image,
                $image_full,
                $prettyPhoto
            );
        } else { 
            return sprintf('<div class="post-thumbnail">
                                <img class="img-responsive" src="%2$s" alt="%1$s"/>
                                <a data-rel="%4$s" href="%3$s" class="prettyPhoto"><i class="fa fa-expand"></i></a>
                            </div>',
                $title,
                $image,
                $image_full,
                $prettyPhoto
            );
        }

    }
}

/* 8.4 Get video hover */ 
if (!function_exists('haru_get_video_hover')) {
    function haru_get_video_hover($image, $url, $title, $video_url) {
        return sprintf('<div class="post-thumbnail">
                            <a class="post-thumbnail-overlay" href="%1$s" title="%2$s">
                                <img class="img-responsive" src="%3$s" alt="%2$s"/>
                            </a>
                            <a data-rel="prettyPhoto" href="%4$s" class="prettyPhoto"><i class="fa fa-play-circle-o"></i></a>
                        </div>',
            $url,
            $title,
            $image,
            $video_url
        );
    }
}

/* 8.5 Get attachment ID form URL */ 
if (!function_exists('haru_get_attachment_id_from_url')) {
    function haru_get_attachment_id_from_url($attachment_url = '') {
        global $wpdb;
        $attachment_id = false;

        // If there is no url, return.
        if ( '' == $attachment_url )
            return;

        // Get the upload directory paths
        $upload_dir_paths = wp_upload_dir();

        // Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
        if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {

            // If this is the URL of an auto-generated thumbnail, get the URL of the original image
            $attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );

            // Remove the upload path base directory from the attachment URL
            $attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );

            // Finally, run a custom database query to get the attachment ID from the modified attachment URL
            $attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );

        }
        return $attachment_id;
    }
}

/* 8.6 Get JPlayer */ 
if (!function_exists('haru_jplayer')) {
    function haru_jplayer($id = 'jp_container_1') {
        ob_start();
        ?>
        <div id="<?php echo esc_attr($id); ?>" class="jp-audio">
            <div class="jp-type-playlist">
                <div class="jp-gui jp-interface">
                    <ul class="jp-controls jp-play-pause">
                        <li><a href="javascript:;" class="jp-play" tabindex="1"><i class="fa fa-play-circle-o"></i> <?php echo esc_html__('play', 'haru-circle'); ?></a></li>
                        <li><a href="javascript:;" class="jp-pause" tabindex="1"><i class="fa fa-pause"></i> <?php echo esc_html__('pause', 'haru-circle'); ?></a></li>
                    </ul>

                    <div class="jp-progress">
                        <div class="jp-seek-bar">
                            <div class="jp-play-bar"></div>
                        </div>
                    </div>

                    <ul class="jp-controls jp-volume">
                        <li>
                            <a href="javascript:;" class="jp-mute" tabindex="1" title="mute"><i class="fa fa-volume-up"></i> <?php echo esc_html__('mute', 'haru-circle'); ?></a>
                        </li>
                        <li>
                            <a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute"><i class="fa fa-volume-off"></i><?php echo esc_html__('unmute', 'haru-circle'); ?></a>
                        </li>
                        <li>
                            <div class="jp-volume-bar">
                                <div class="jp-volume-bar-value"></div>
                            </div>
                        </li>
                    </ul>

                    <div class="jp-time-holder">
                        <div class="jp-current-time"></div>
                        <div class="jp-duration"></div>
                    </div>
                    <ul class="jp-toggles">
                        <li>
                            <a href="javascript:;" class="jp-shuffle" tabindex="1" title="shuffle"><?php echo esc_html__('shuffle', 'haru-circle'); ?></a>
                        </li>
                        <li>
                            <a href="javascript:;" class="jp-shuffle-off" tabindex="1" title="shuffle off"><?php echo esc_html__('shuffle off', 'haru-circle'); ?></a>
                        </li>
                        <li>
                            <a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat"><?php echo esc_html__('repeat', 'haru-circle'); ?></a>
                        </li>
                        <li>
                            <a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off"><?php echo esc_html__('repeat off', 'haru-circle'); ?></a>
                        </li>
                    </ul>
                </div>

                <div class="jp-no-solution">
                    <?php printf(esc_html__('<span>Update Required</span> To play the media you will need to either update your browser to a recent version or update your <a href="%s" target="_blank">Flash plugin</a>.', 'haru-circle'), 'http://get.adobe.com/flashplayer/'); ?>
                </div>
            </div>
        </div>
        <?php
        $content = ob_get_clean();

        return $content;
    }
}

/* 
 * 9. Get post meta 
*/
if ( !function_exists( 'haru_get_post_meta' ) ) {
    function haru_get_post_meta( $id, $key = "", $single = false ) {
        $GLOBALS['haru_post_meta'] = isset( $GLOBALS['haru_post_meta'] ) ? $GLOBALS['haru_post_meta'] : array();
        if ( ! isset( $id ) ) {
            return;
        }

        if ( ! is_array( $id ) ) {
            if ( ! isset( $GLOBALS['haru_post_meta'][ $id ] ) ) {
                $GLOBALS['haru_post_meta'][ $id ] = get_post_meta( $id );
            }

            if ( ! empty( $key ) && isset( $GLOBALS['haru_post_meta'][ $id ][ $key ] ) && ! empty( $GLOBALS['haru_post_meta'][ $id ][ $key ] ) ) {
                if ( $single ) {
                    return maybe_unserialize( $GLOBALS['haru_post_meta'][ $id ][ $key ][0] );
                } else {
                    return array_map( 'maybe_unserialize', $GLOBALS['haru_post_meta'][ $id ][ $key ] );
                }
            }

            if ( $single ) {
                return '';
            } else {
                return array();
            }

        }

        return get_post_meta( $id, $key, $single );
    }
}


/* 
 * 10. Breadcrumb
*/
if (!function_exists('haru_get_breadcrumb')) {
    function haru_get_breadcrumb() {
        $items       = haru_get_breadcrumb_items();
        $breadcrumbs = '<ul class="breadcrumbs">';
        $breadcrumbs .= join("", $items);
        $breadcrumbs .= '</ul>';

        echo wp_kses_post($breadcrumbs);
    }
}

/* 10.1. Get breadcrumb items */
if (!function_exists('haru_get_breadcrumb_items')) {
    function haru_get_breadcrumb_items() {
        global $wp_query;

        $on_front = get_option('show_on_front');

        $item = array();
        /* Front page. */
        if (is_front_page()) {
            $item['last'] = esc_html__( 'Home', 'haru-circle' );
        }

        /* Link to front page. */
        if (!is_front_page()) {
            $item[] = '<li typeof="v:Breadcrumb"><a property="v:url" property="v:title" href="' . esc_url(home_url('/')) . '" class="home">' . esc_html__( 'Home', 'haru-circle' ) . '</a></li>';
        }

        /* If bbPress is installed and we're on a bbPress page. */
        if (function_exists('is_bbpress') && is_bbpress()) {
            $item = array_merge($item, haru_breadcrumb_get_bbpress_items());
        } elseif (function_exists('is_woocommerce') && is_woocommerce()) {
            $item = array_merge($item, haru_filter_breadcrumb_items());
        } /* If viewing a home/post page. */
        elseif (is_home()) {
            $home_page    = get_post($wp_query->get_queried_object_id());
            $item         = array_merge($item, haru_breadcrumb_get_parents($home_page->post_parent));
            $item['last'] = get_the_title($home_page->ID);
        } /* If viewing a singular post. */
        elseif (is_singular()) {
            $post             = $wp_query->get_queried_object();
            $post_id          = (int)$wp_query->get_queried_object_id();
            $post_type        = $post->post_type;
            $post_type_object = get_post_type_object($post_type);

            if ('post' === $wp_query->post->post_type) {
                
                $categories = get_the_category($post_id);
                $item       = array_merge($item, haru_breadcrumb_get_term_parents($categories[0]->term_id, $categories[0]->taxonomy));
            }

            if ('page' !== $wp_query->post->post_type) {

                /* If there's an archive page, add it. */

                if (function_exists('get_post_type_archive_link') && !empty($post_type_object->has_archive))
                    $item[] = '<li typeof="v:Breadcrumb"><a property="v:url" property="v:title" href="' . esc_url( get_post_type_archive_link($post_type) ) . '" title="' . esc_attr($post_type_object->labels->name) . '">' . $post_type_object->labels->name . '</a></li>';

                if (isset($args["singular_{$wp_query->post->post_type}_taxonomy"]) && is_taxonomy_hierarchical($args["singular_{$wp_query->post->post_type}_taxonomy"])) {
                    $terms = wp_get_object_terms($post_id, $args["singular_{$wp_query->post->post_type}_taxonomy"]);
                    $item = array_merge($item, haru_breadcrumb_get_term_parents($terms[0], $args["singular_{$wp_query->post->post_type}_taxonomy"]));
                } elseif (isset($args["singular_{$wp_query->post->post_type}_taxonomy"]))
                    $item[] = get_the_term_list($post_id, $args["singular_{$wp_query->post->post_type}_taxonomy"], '', ', ', '');
            }

            if ((is_post_type_hierarchical($wp_query->post->post_type) || 'attachment' === $wp_query->post->post_type) && $parents = haru_breadcrumb_get_parents($wp_query->post->post_parent)) {
                $item = array_merge($item, $parents);
            }

            $item['last'] = get_the_title();
        } /* If viewing any type of archive. */
        else if (is_archive()) {

            if (is_category() || is_tag() || is_tax()) {

                $term = $wp_query->get_queried_object();

                if ((is_taxonomy_hierarchical($term->taxonomy) && $term->parent) && $parents = haru_breadcrumb_get_term_parents($term->parent, $term->taxonomy))
                    $item = array_merge($item, $parents);

                $item['last'] = $term->name;
            } else if (function_exists('is_post_type_archive') && is_post_type_archive()) {
                $post_type_object = get_post_type_object(get_query_var('post_type'));
                $item['last'] = $post_type_object->labels->name;
            } else if (is_date()) {

                if (is_day())
                    $item['last'] = esc_html__('Archives for ', 'haru-circle' ) . get_the_time('F j, Y');

                elseif (is_month())
                    $item['last'] = esc_html__('Archives for ', 'haru-circle' ) . single_month_title(' ', false);

                elseif (is_year())
                    $item['last'] = esc_html__('Archives for ', 'haru-circle' ) . get_the_time('Y');
            } else if (is_author())
                $item['last'] = esc_html__('Archives by: ', 'haru-circle' ) . get_the_author_meta('display_name', $wp_query->post->post_author);

        } /* If viewing search results. */
        else if (is_search())
            $item['last'] = esc_html__('Search results for "', 'haru-circle' ) . stripslashes(strip_tags(get_search_query())) . '"';

        /* If viewing a 404 error page. */
        else if (is_404())
            $item['last'] = esc_html__('Page Not Found', 'haru-circle' );

        if (isset($item['last'])) {
            $item['last'] = sprintf('<li><span>%s</span></li>', $item['last']);
        }

        return apply_filters('haru_framework_filter_breadcrumb_items', $item);
    }
}

/* 10.2. Filter breadcrumb items */
if (!function_exists('haru_filter_breadcrumb_items')) {
    function haru_filter_breadcrumb_items() {
        $item         = array();
        $shop_page_id = wc_get_page_id('shop');

        if (get_option('page_on_front') != $shop_page_id) {
            $shop_name = $shop_page_id ? get_the_title($shop_page_id) : '';
            if (!is_shop()) {
                $item[] = '<li typeof="v:Breadcrumb"><a property="v:url" property="v:title" href="' . esc_url( get_permalink($shop_page_id) ) . '">' . $shop_name . '</a></li>';
            } else {
                $item['last'] = $shop_name;
            }
        }

        if (is_tax('product_cat') || is_tax('product_tag')) {
            $current_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));

        } elseif (is_product()) {
            global $post;
            $terms = wc_get_product_terms($post->ID, 'product_cat', array('orderby' => 'parent', 'order' => 'DESC'));
            if ($terms) {
                $current_term = $terms[0];
            }
        }

        if (!empty($current_term)) {
            if (is_taxonomy_hierarchical($current_term->taxonomy)) {
                $item = array_merge($item, haru_breadcrumb_get_term_parents($current_term->parent, $current_term->taxonomy));
            }

            if (is_tax('product_cat') || is_tax('product_tag')) {
                $item['last'] = $current_term->name;
            } else {
                $item[] = '<li typeof="v:Breadcrumb"><a property="v:url" property="v:title" href="' . esc_url( get_term_link($current_term->term_id, $current_term->taxonomy) ) . '">' . $current_term->name . '</a></li>';
            }
        }

        if (is_product()) {
            $item['last'] = get_the_title();
        }

        return apply_filters('haru_filter_breadcrumb_items', $item);
    }
}

/* 10.3. Get bbpress breadcrumb items */
if (!function_exists('haru_breadcrumb_get_bbpress_items')) {
    function haru_breadcrumb_get_bbpress_items() {
        $item         = array();
        $shop_page_id = wc_get_page_id('shop');

        if (get_option('page_on_front') != $shop_page_id) {
            $shop_name = $shop_page_id ? get_the_title($shop_page_id) : '';
            if (!is_shop()) {
                $item[] = '<li typeof="v:Breadcrumb"><a property="v:url" property="v:title" href="' . esc_url( get_permalink($shop_page_id) ) . '">' . $shop_name . '</a></li>';
            } else {
                $item['last'] = $shop_name;
            }
        }

        if (is_tax('product_cat') || is_tax('product_tag')) {
            $current_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));

        } elseif (is_product()) {
            global $post;
            $terms = wc_get_product_terms($post->ID, 'product_cat', array('orderby' => 'parent', 'order' => 'DESC'));
            if ($terms) {
                $current_term = $terms[0];
            }

        }

        if (!empty($current_term)) {
            if (is_taxonomy_hierarchical($current_term->taxonomy)) {
                $item = array_merge($item, haru_breadcrumb_get_term_parents($current_term->parent, $current_term->taxonomy));
            }

            if (is_tax('product_cat') || is_tax('product_tag')) {
                $item['last'] = $current_term->name;
            } else {
                $item[] = '<li typeof="v:Breadcrumb"><a property="v:url" property="v:title" href="' . esc_url( get_term_link($current_term->term_id, $current_term->taxonomy) ) . '">' . $current_term->name . '</a></li>';
            }
        }

        if (is_product()) {
            $item['last'] = get_the_title();
        }

        return apply_filters('haru_filter_breadcrumb_items', $item);
    }
}

/* 10.4. Get breadcrumb parents */
if (!function_exists('haru_breadcrumb_get_parents')) {
    function haru_breadcrumb_get_parents($post_id = '', $separator = '/') {
        $parents = array();

        if ($post_id == 0) {
            return $parents;
        }

        while ($post_id) {
            $page      = get_post($post_id);
            $parents[] = '<li typeof="v:Breadcrumb"><a property="v:url" property="v:title" href="' . esc_url( get_permalink($post_id) ) . '" title="' . esc_attr(get_the_title($post_id)) . '">' . get_the_title($post_id) . '</a></li>';
            $post_id   = $page->post_parent;
        }

        if ($parents) {
            $parents = array_reverse($parents);
        }

        return $parents;
    }
}

/* 10.5. Get breadcrumb term parents */
if (!function_exists('haru_breadcrumb_get_term_parents')) {
    function haru_breadcrumb_get_term_parents($parent_id = '', $taxonomy = '', $separator = '/') {
        $parents = array();

        if (empty($parent_id) || empty($taxonomy)) {
            return $parents;
        }

        while ($parent_id) {
            $parent = get_term($parent_id, $taxonomy);
            $parents[] = '<li typeof="v:Breadcrumb"><a property="v:url" property="v:title" href="' . esc_url( get_term_link($parent, $taxonomy) ) . '" title="' . esc_attr($parent->name) . '">' . $parent->name . '</a></li>';
            $parent_id = $parent->parent;
        }

        if ($parents) {
            $parents = array_reverse($parents);
        }

        return $parents;
    }
}

/* 10.6. Get post views @TODO: need check IP, session, ajax */
if (!function_exists('haru_count_post_views')) {
    function haru_count_post_views( $post_ID ) {
     
        // Set the name of the Posts Custom Field.
        $count_key = 'post_views_count'; 
         
        // Returns values of the custom field with the specified key from the specified post.
        $count = get_post_meta($post_ID, $count_key, true);
         
        // If the the Post Custom Field value is empty. 
        if ( $count == '' ) {
            $count = 0; // set the counter to zero.
             
            // Delete all custom fields with the specified key from the specified post. 
            delete_post_meta($post_ID, $count_key);
             
            // Add a custom (meta) field (Name/value)to the specified post.
            add_post_meta($post_ID, $count_key, '0');
            return $count . esc_html__(' View', 'haru-circle');
         
        // If the the Post Custom Field value is NOT empty.
        } else {
            // Only update when is single page
            if ( is_single() ) {
                $count++; //increment the counter by 1.
                // Update the value of an existing meta key (custom field) for the specified post.
                update_post_meta($post_ID, $count_key, $count);
            }
            
            // If statement, is just to have the singular form 'View' for the value '1'
            if ( $count == '1') {
                return $count . esc_html__(' View', 'haru-circle');
            }
            // In all other cases return (count) Views
            else {
                return $count . esc_html__(' Views', 'haru-circle');
            }
        }
    }
}

/* 11. Add post classes */
function haru_post_classes( $classes ) {
    $classes[] = 'clearfix';

    return $classes;
}
add_filter( 'post_class', 'haru_post_classes' );

/* 12. Footer Stylesheet */ 
if ( !function_exists('haru_footer_stylesheet') ) {
    function haru_footer_stylesheet() {
        get_template_part( 'templates/footer/footer-stylesheet' );
    }
    add_action( 'wp_head', 'haru_footer_stylesheet', 10 );
}

/* 13. Tag cloud size: https://codex.wordpress.org/Plugin_API/Filter_Reference/widget_tag_cloud_args */ 
add_filter( 'widget_tag_cloud_args', 'haru_set_tag_cloud_sizes' );
function haru_set_tag_cloud_sizes( $args ) {
    $args = array(
        'smallest'  => 14, 
        'default'   => 18, 
        'largest'   => 22, 
        'unit'      => 'px',
        'format'    => 'flat', 
        'separator' => ", ", 
        'orderby'   => 'name', 
        'order'     => 'ASC',
        'exclude'   => '', 
        'include'   => '', 
        'link'      => 'view',
        'post_type' => '', 
        'echo'      => false
    );
    return $args;
}

/* 14. Add span for count list category and archive */ 
add_filter( 'wp_list_categories', 'haru_cat_count_span' );
function haru_cat_count_span($links) {
    $links = str_replace('</a> (', '</a> <span class="list-count">(', $links);
    $links = str_replace(')', ')</span>', $links);

    return $links;
}
/* This code filters the Archive widget to include the post count inside the link */
add_filter( 'get_archives_link', 'haru_archive_count_span' );
function haru_archive_count_span($links) {
    $links = str_replace('</a>&nbsp;(', '</a> <span class="archive-count">(', $links);
    $links = str_replace(')', ')</span>', $links);

    return $links;
}

/* 15. Add function fixed load style custom */ 
function haru_ssl_upload_url( $uploads ) {
    if ( is_ssl() )
        $uploads['url'] = str_replace( 'http://', 'https://', $uploads['url'] );

    return $uploads;
}
add_filter( 'upload_dir', 'haru_ssl_upload_url' );

/* 
 * TABLE OF CIRCLE FUNCTIONS
 * 1. 
*/

/* 15. Paging Load More Archive Film */ 
if ( ! function_exists('haru_paging_load_more_archive_film') ) {
    function haru_paging_load_more_archive_film( $posts ) {
        // Don't print empty markup if there's only one page.
        if ( $posts->max_num_pages < 2 ) {
            return;
        }
        $link = get_next_posts_page_link($posts->max_num_pages);
        if (!empty($link)) :
            ?> 
                <button data-href="<?php echo esc_url($link); ?>" type="button"  data-loading-text="<span class='fa fa-spinner fa-spin'></span> <?php echo esc_html__( 'Loading...','haru-circle' ); ?>" class="blog-load-more">
                    <?php echo esc_html__( 'View More', 'haru-circle' ); ?>
                </button>
        <?php
        endif;
    }
}

/* 16. Paging Infinite Scroll Archive Film */ 
if ( ! function_exists('haru_paging_infinitescroll_archive_film') ) {
    function haru_paging_infinitescroll_archive_film( $posts ) {
        // Don't print empty markup if there's only one page.
        if ( $posts->max_num_pages < 2 ) {
            return;
        }
        $link = get_next_posts_page_link($posts->max_num_pages);
        if (!empty($link)) :
            ?>
            <nav id="infinite_scroll_button">
                <a href="<?php echo esc_url($link); ?>"></a>
            </nav>
            <div id="infinite_scroll_loading" class="text-center infinite-scroll-loading"></div>
        <?php
        endif;
    }
}

/*-----------------------------------
 * 18. Paging Nav Film
 *-----------------------------------*/
if ( ! function_exists( 'haru_paging_nav_archive_film' ) ) {
    function haru_paging_nav_archive_film($posts) {
        global $wp_rewrite;
        // Don't print empty markup if there's only one page.
        if ( $posts->max_num_pages < 2 ) {
            return;
        }

        $paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
        $pagenum_link = html_entity_decode( get_pagenum_link() );
        $query_args   = array();
        $url_parts    = explode( '?', $pagenum_link );

        if ( isset( $url_parts[1] ) ) {
            wp_parse_str( $url_parts[1], $query_args );
        }

        $pagenum_link = esc_url(remove_query_arg( array_keys( $query_args ), $pagenum_link ));
        $pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

        $format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
        $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

        // Set up paginated links.
        $page_links = paginate_links( array(
            'base'      => $pagenum_link,
            'format'    => $format,
            'total'     => $posts->max_num_pages,
            'current'   => $paged,
            'mid_size'  => 1,
            'add_args'  => array_map( 'urlencode', $query_args ),
            'prev_text' => esc_html__( 'Prev', 'haru-circle' ),
            'next_text' => esc_html__( 'Next', 'haru-circle' ),
            'type'      => 'array'
        ) );

        if (count($page_links) == 0) return;

        $links = "<div class='film-pagination'>";
        $links .= "<ul class='page-numbers'>\n\t<li>";
        $links .= join("</li>\n\t<li>", $page_links);
        $links .= "</li>\n</ul>\n";
        $links .= "</div>";

        return $links;
    }
}

/* 19. Add function get video thumbnail */ 
if ( !function_exists('haru_get_video_thumbnail') ) {
    function haru_get_video_thumbnail( $video_id ) {
        $thumbnail_style = get_post_meta( $video_id, 'haru_video' . '_thumbnail_style', true );

        if ( !isset( $thumbnail_style ) ) {
            $thumbnail_style = 'default';
        }

        if ( $thumbnail_style == 'slideshow' ) {
            $thumbnail_images =  get_post_meta( $video_id, 'haru_video' . '_thumbnail_images', false );
            $thumbnail_count = count($thumbnail_images);
        ?>
        <div class="video-thumbnail-slideshow" data-speed="1000">
            <img src="<?php echo esc_url( get_the_post_thumbnail_url( $video_id, 'full' ) ); ?>" alt="<?php echo esc_attr( get_the_title( $video_id ) ); ?>">
            <?php
            if ( isset($thumbnail_images) && !empty($thumbnail_images) ) :
                $i = 1;
                foreach( $thumbnail_images as $key => $thumbnail ) :
                    if ( $i <= $thumbnail_count ) :
            ?>
            <img src="<?php echo wp_get_attachment_image_src( $thumbnail, 'full' )[0]; ?>" alt="<?php echo esc_attr( get_the_title( $video_id ) ); ?>">
            <?php 
                    endif;
                    $i++;
                endforeach;
            endif;
            ?>
        </div>
        <?php
        } else if ( $thumbnail_style == 'video' ) {
        ?>
        <div class="video-thumbnail-video">
            <?php the_post_thumbnail(); ?>
            <video src="<?php echo esc_url( get_post_meta( $video_id, 'haru_video' . '_thumbnail_video', true ) ); ?>"></video>
        </div>
        <?php
        } else {
            the_post_thumbnail();
        }
    }
}


if ( ! function_exists('haru_popup_search_result_callback') ) {
    function haru_popup_search_result_callback() {
        $search_box_result_amount = haru_get_option('haru_search_box_result_amount');

        if ( empty($search_box_result_amount) ) {
            $search_box_result_amount = 3;
        }
        
        $posts_per_page = $search_box_result_amount;

        $search_post_type = array();
        $haru_search_box_post_type = haru_get_option('haru_search_box_post_type');
        foreach ( $haru_search_box_post_type as $key => $post_type  ) {
            if ( $post_type == '1' ) {
                array_push($search_post_type, $key);
            }
        }

        $keyword = $_REQUEST['keyword'];

        if ( $keyword ) {
            $search_query = array(
                's'              => $keyword,
                'order'          => 'DESC',
                'orderby'        => 'date',
                'post_status'    => 'publish',
                'post_type'      => $search_post_type,
                'posts_per_page' => $posts_per_page + 1, // +1 to check have more item
            );
            $search = new WP_Query( $search_query );

            if ($search && count($search->post) > 0) :
                $count = 0;
            ?>
            <ul class="items-list">
                <?php
                    foreach ( $search->posts as $post ) :
                        if ($count == $posts_per_page) : 
                ?>
                    <li class="view-more">
                        <a href="<?php echo esc_url( site_url() ) .'?s=' . $keyword . '&post_type=' . implode(',', $search_post_type); ?>"><?php echo esc_html__( 'View More', 'haru-circle' ); ?></a>
                    </li>
                <?php
                    break; 
                    else :
                ?>
                    <li class="item d-flex justify-content-start">
                        <div class="item-thumbnail align-self-center">
                            <?php echo wp_kses_post(get_the_post_thumbnail( $post->ID, 'thumbnail' )); ?>
                        </div>
                        <div class="item-meta align-self-center">
                            <a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>"><?php echo esc_html( $post->post_title ); ?></a>
                            <p class="publish-date"><?php echo esc_html( mysql2date( 'M d Y', $post->post_date ) ); ?></p>
                        </div>
                    </li>
                <?php
                        endif;
                    $count++;
                    endforeach;
                ?>
            </ul>
            <?php
            else :
            ?>
                <p class="ajax-not-found"><?php echo esc_html__( 'No items were found matching your selection.', 'haru-circle' ); ?></p>
            <?php
            endif;
        }
        wp_reset_query();
        die;
    }
    add_action( 'wp_ajax_nopriv_popup_search_result', 'haru_popup_search_result_callback' );
    add_action( 'wp_ajax_popup_search_result', 'haru_popup_search_result_callback' );

}

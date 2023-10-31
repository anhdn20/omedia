<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com     
*/

/**
 * Register meta boxes
 * https://metabox.io/docs/registering-meta-boxes/
 * https://metabox.io/docs/filters/
 * https://metabox.io/docs/meta-box-conditional-logic/#section-the-example
 */
function haru_register_meta_boxes() {

    /* PAGE SIDEBARS */
    $sidebar_list = array();
    if ( function_exists( 'haru_get_sidebar_list' ) ) {
        $sidebar_list = haru_get_sidebar_list();
    }

    // Director metabox
    $meta_boxes[] = array(
        'id'         => 'haru_director' . '_metabox',
        'title'      => esc_html__( 'Director Metaboxes', 'haru-circle' ),
        'post_types' => array( 'haru_director' ),
        'fields'     => array(
            array(
                'id'      => 'haru_director' . '_info',
                'name'    => esc_html__( 'Information', 'haru-circle' ),
                'type'    => 'text_list',
                'clone' => true,
                // Options: array of Placeholder => Label for text boxes
                // Number of options are not limited
                'options' => array(
                    'Born'          => esc_html__( 'Label', 'haru-circle' ),
                    'July, 3, 1962' => esc_html__( 'Value', 'haru-circle' ),
                ),
            ),
            array(
                'id'                 => 'haru_director'.  '_award',
                'name'               => esc_html__( 'Awards', 'haru-circle' ),
                'desc'               => esc_html__( 'Director Awards Information.', 'haru-circle' ),
                'type'               => 'timeline',
                'datetime_holder'    => esc_html__( 'Datetime', 'haru-circle' ),
                'information_holder' => esc_html__( 'Information', 'haru-circle' ),
                'clone'              => true,
                // 'max_clone'       => 4,
                'sort_clone'         => true,
                'std'                => '',
            ),
            array(
                'id'             => 'haru_director'.  '_social',
                'name'           => esc_html__( 'Social', 'haru-circle' ),
                'desc'           => esc_html__( 'Director Social Network Information. Max number of social networks set is 4.', 'haru-circle' ),
                'type'           => 'social',
                'network_holder' => esc_html__( 'Title (Ex: Facebook)', 'haru-circle' ),
                'url_holder'     => esc_html__( 'Url', 'haru-circle' ),
                'icon_holder'    => esc_html__( 'Icon class (Ex: fa fa-facebook)', 'haru-circle' ),
                'clone'          => true,
                'max_clone'      => 4,
                'sort_clone'     => true,
                'std'            => '',
            ),
            // HEADING GALLERY
            array(
                'type' => 'heading',
                'name' => esc_html__( 'Gallery', 'haru-circle' ),
                'desc' => esc_html__( 'Director Gallery Information', 'haru-circle' ),
            ),
            array(
                'id'   => 'haru_director' . '_gallery_title',
                'name' => esc_html__( 'Title', 'haru-circle' ),
                'type' => 'text',
            ),
            array(
                'name' => esc_html__( 'Sub Title', 'haru-circle' ),
                'id'   => 'haru_director' . '_gallery_sub_title',
                'type' => 'text',
            ),
            array(
                'id'               => 'haru_director'.  '_gallery_images',
                'name'             => esc_html__( 'Images Gallery', 'haru-circle' ),
                'desc'             => esc_html__( 'Insert images for gallery.', 'haru-circle' ),
                'type'             => 'image_advanced',
            ),
            array(
                'id'                 => 'haru_director'.  '_film',
                'name'               => esc_html__( 'Filmography', 'haru-circle' ),
                'desc'               => esc_html__( 'Director Filmography.', 'haru-circle' ),
                'type'               => 'timeline',
                'datetime_holder'    => esc_html__( 'Datetime', 'haru-circle' ),
                'information_holder' => esc_html__( 'Name Of Film', 'haru-circle' ),
                'clone'              => true,
                // 'max_clone'       => 4,
                'sort_clone'         => true,
                'std'                => '',
            ),
            array(
                'id'          => 'haru_director' . '_video',
                'name'        => esc_html__( 'Featured Video', 'haru-circle' ),
                'desc'        => esc_html__( 'My Featured Video.', 'haru-circle' ),
                'type'        => 'post',
                // Post type
                'post_type'   => array('haru_video'), // Can add film
                // Field type, either 'select' or 'select_advanced' (default)
                'field_type'  => 'select_advanced',
                'placeholder' => esc_html__( 'Select Video', 'haru-circle' ),
                // Query arguments (optional). No settings means get all published posts
                'multiple'    => true,
                'query_args'  => array(
                    'post_status'    => 'publish',
                    'posts_per_page' => - 1,
                ),
            ),
        )
    );

    // Actor metabox
    $meta_boxes[] = array(
        'id'         => 'haru_actor' . '_metabox',
        'title'      => esc_html__( 'Actor Metaboxes', 'haru-circle' ),
        'post_types' => array( 'haru_actor' ),
        'fields'     => array(
            array(
                'id'      => 'haru_actor' . '_info',
                'name'    => esc_html__( 'Information', 'haru-circle' ),
                'type'    => 'text_list',
                'clone' => true,
                // Options: array of Placeholder => Label for text boxes
                // Number of options are not limited
                'options' => array(
                    'Born'          => esc_html__( 'Label', 'haru-circle' ),
                    'July, 3, 1962' => esc_html__( 'Value', 'haru-circle' ),
                ),
            ),
            array(
                'id'                 => 'haru_actor'.  '_award',
                'name'               => esc_html__( 'Awards', 'haru-circle' ),
                'desc'               => esc_html__( 'Actor Awards Information.', 'haru-circle' ),
                'type'               => 'timeline',
                'datetime_holder'    => esc_html__( 'Datetime', 'haru-circle' ),
                'information_holder' => esc_html__( 'Information', 'haru-circle' ),
                'clone'              => true,
                // 'max_clone'       => 4,
                'sort_clone'         => true,
                'std'                => '',
            ),
            array(
                'id'             => 'haru_actor'.  '_social',
                'name'           => esc_html__( 'Social', 'haru-circle' ),
                'desc'           => esc_html__( 'Actor Social Network Information. Max number of social networks set is 4.', 'haru-circle' ),
                'type'           => 'social',
                'network_holder' => esc_html__( 'Title (Ex: Facebook)', 'haru-circle' ),
                'url_holder'     => esc_html__( 'Url', 'haru-circle' ),
                'icon_holder'    => esc_html__( 'Icon class (Ex: fa fa-facebook)', 'haru-circle' ),
                'clone'          => true,
                'max_clone'      => 4,
                'sort_clone'     => true,
                'std'            => '',
            ),
            // HEADING GALLERY
            array(
                'type' => 'heading',
                'name' => esc_html__( 'Gallery', 'haru-circle' ),
                'desc' => esc_html__( 'Actor Gallery Information', 'haru-circle' ),
            ),
            array(
                'id'   => 'haru_actor' . '_gallery_title',
                'name' => esc_html__( 'Title', 'haru-circle' ),
                'type' => 'text',
            ),
            array(
                'name' => esc_html__( 'Sub Title', 'haru-circle' ),
                'id'   => 'haru_actor' . '_gallery_sub_title',
                'type' => 'text',
            ),
            array(
                'id'               => 'haru_actor'.  '_gallery_images',
                'name'             => esc_html__( 'Images Gallery', 'haru-circle' ),
                'desc'             => esc_html__( 'Insert images for gallery.', 'haru-circle' ),
                'type'             => 'image_advanced',
            ),
            array(
                'id'                 => 'haru_actor'.  '_film',
                'name'               => esc_html__( 'Filmography', 'haru-circle' ),
                'desc'               => esc_html__( 'Actor Filmography.', 'haru-circle' ),
                'type'               => 'timeline',
                'datetime_holder'    => esc_html__( 'Datetime', 'haru-circle' ),
                'information_holder' => esc_html__( 'Name Of Film', 'haru-circle' ),
                'clone'              => true,
                // 'max_clone'       => 4,
                'sort_clone'         => true,
                'std'                => '',
            ),
            array(
                'id'          => 'haru_actor' . '_video',
                'name'        => esc_html__( 'Featured Video', 'haru-circle' ),
                'desc'        => esc_html__( 'My Featured Video.', 'haru-circle' ),
                'type'        => 'post',
                // Post type
                'post_type'   => array('haru_video'), // Can add film
                // Field type, either 'select' or 'select_advanced' (default)
                'field_type'  => 'select_advanced',
                'placeholder' => esc_html__( 'Select Video', 'haru-circle' ),
                // Query arguments (optional). No settings means get all published posts
                'multiple'    => true,
                'query_args'  => array(
                    'post_status'    => 'publish',
                    'posts_per_page' => - 1,
                ),
            ),
        )
    );

    // Video metabox
    $meta_boxes[] = array(
        'id'         => 'haru_video' . '_metabox',
        'title'      => esc_html__( 'Video Metaboxes', 'haru-circle' ),
        'post_types' => array( 'haru_video' ),
        'fields'     => array(
            array(
                'name'    => esc_html__( 'Source Server', 'haru-circle' ),
                'id'      => 'haru_video' . '_server',
                'type'    => 'button_set',
                'options' => array(
                    'youtube'       => esc_html__( 'Youtube','haru-circle' ),
                    'vimeo'         => esc_html__( 'Vimeo','haru-circle' ),
                    'dailymotion'   => esc_html__( 'Dailymotion','haru-circle' ),
                    'twitch'        => esc_html__( 'Twitch','haru-circle' ),
                    'facebook'      => esc_html__( 'Facebook','haru-circle' ),
                    'url'           => esc_html__( 'Url','haru-circle' ),
                ),
                'std'      => 'youtube',
                'multiple' => false,
            ),
            array(
                'id'      => 'haru_video' . '_id',
                'name'    => esc_html__( 'Video ID', 'haru-circle' ),
                'desc'    => esc_html__( 'Insert Video ID from Youtube, Dailymotion, Twitch, Facebook or Vimeo server.', 'haru-circle' ),
                'type'    => 'text',
                'std'     => '',
                'visible' => array( 'haru_video' . '_server', '!=', 'url' )
            ),
            array(
                'id'          => 'haru_video'.  '_url',
                'name'        => esc_html__( 'Video Url', 'haru-circle' ),
                'desc'        => esc_html__( 'Insert Video Url from other server (mp4 and webm).', 'haru-circle' ),
                'mp4_holder'  => esc_html__( 'Mp4 Url', 'haru-circle' ),
                'webm_holder' => esc_html__( 'WebM Url', 'haru-circle' ),
                'type'        => 'video_url',
                'std'         => '',
                'visible'     => array( 'haru_video' . '_server', '=', 'url' )
            ),
            // THUMBNAIL INFORMATION
            array(
                'type' => 'heading',
                'name' => esc_html__( 'Thumbnail', 'haru-circle' ),
                'desc' => esc_html__( 'Set thumbnail style for Archive video', 'haru-circle' ),
            ),
            array(
                'id'   => 'haru_video'.  '_thumbnail_style',
                'name' => esc_html__( 'Thumbnail Style', 'haru-circle' ),
                'type' => 'select',
                'options' => array(
                    ''              => esc_html__( 'Default','haru-circle' ),
                    'slideshow'     => esc_html__( 'Slideshow','haru-circle' ),
                    'video'         => esc_html__( 'Video','haru-circle' ),
                ),
                'std'      => '',
            ),
            array(
                'name'  => esc_html__( 'Thumbnail Images', 'haru-circle' ),
                'id'    => 'haru_video' . '_thumbnail_images',
                'type'  => 'image_advanced',
                'desc'  => esc_html__( 'Select images for video\'s thumbnail', 'haru-circle' ),
                'hidden' => array( 'haru_video' . '_thumbnail_style', 'not in', array('slideshow') )
            ),
            array(
                'name'  => esc_html__( 'Thumbnail Video', 'haru-circle' ),
                'id'    => 'haru_video' . '_thumbnail_video',
                'type'  => 'file_input',
                'desc'  => esc_html__( 'Set video URL for video\'s thumbnail (MP4)', 'haru-circle' ),
                'hidden' => array( 'haru_video' . '_thumbnail_style', 'not in', array('video') )
            ),
            // HEADING INFORMATION
            array(
                'type' => 'heading',
                'name' => esc_html__( 'Information', 'haru-circle' ),
                'desc' => esc_html__( 'Information of video as actor, director, client, producer,...', 'haru-circle' ),
            ),
            array(
                'id'          => 'haru_video' . '_director',
                'name'        => esc_html__( 'Director', 'haru-circle' ),
                'desc'        => esc_html__( 'Director of Video.', 'haru-circle' ),
                'type'        => 'post',
                // Post type
                'post_type'   => 'haru_director',
                // Field type, either 'select' or 'select_advanced' (default)
                'field_type'  => 'select_advanced',
                'placeholder' => esc_html__( 'Select Director', 'haru-circle' ),
                // Query arguments (optional). No settings means get all published posts
                'multiple'    => true,
                'query_args'  => array(
                    'post_status'    => 'publish',
                    'posts_per_page' => - 1,
                ),
            ),
            array(
                'id'          => 'haru_video' . '_actor',
                'name'        => esc_html__( 'Actor', 'haru-circle' ),
                'desc'        => esc_html__( 'Actor of Video.', 'haru-circle' ),
                'type'        => 'post',
                // Post type
                'post_type'   => 'haru_actor',
                // Field type, either 'select' or 'select_advanced' (default)
                'field_type'  => 'select_advanced',
                'placeholder' => esc_html__( 'Select Actors', 'haru-circle' ),
                // Query arguments (optional). No settings means get all published posts
                'multiple'    => true,
                'query_args'  => array(
                    'post_status'    => 'publish',
                    'posts_per_page' => - 1,
                ),
            ),
            array(
                'id'      => 'haru_video' . '_more_info',
                'name'    => esc_html__( 'More Information', 'haru-circle' ),
                'type'    => 'text_list',
                'clone' => true,
                // Options: array of Placeholder => Label for text boxes
                // Number of options are not limited
                'options' => array(
                    'Client'        => esc_html__( 'Label', 'haru-circle' ),
                    'Academy Films' => esc_html__( 'Value', 'haru-circle' ),
                ),
            ),
            array(
                'id'      => 'haru_video' . '_award',
                'name'    => esc_html__( 'Awards', 'haru-circle' ),
                'type'    => 'text',
                'clone' => true,
            ),
            // HEADING PARTNER/ SPONSOR
            array(
                'type' => 'heading',
                'name' => esc_html__( 'Partners/Sponsor', 'haru-circle' ),
                'desc' => esc_html__( 'Information of partner/sponsor', 'haru-circle' ),
            ),
            array(
                'id'   => 'haru_video' . '_partner_title',
                'name' => esc_html__( 'Title', 'haru-circle' ),
                'type' => 'text',
            ),
            array(
                'name' => esc_html__( 'Sub Title', 'haru-circle' ),
                'id'   => 'haru_video' . '_partner_sub_title',
                'type' => 'text',
            ),
            array(
                'name' => esc_html__( 'Images', 'haru-circle' ),
                'id'   => 'haru_video' . '_partner_images',
                'type' => 'image_advanced',
                'desc' => esc_html__( 'Select images for partner','haru-circle' )
            ),
            // HEADING GALLERY
            array(
                'type' => 'heading',
                'name' => esc_html__( 'Gallery', 'haru-circle' ),
                'desc' => esc_html__( 'Video Gallery Information', 'haru-circle' ),
            ),
            array(
                'id'   => 'haru_video' . '_gallery_title',
                'name' => esc_html__( 'Title', 'haru-circle' ),
                'type' => 'text',
            ),
            array(
                'name' => esc_html__( 'Sub Title', 'haru-circle' ),
                'id'   => 'haru_video' . '_gallery_sub_title',
                'type' => 'text',
            ),
            array(
                'name' => esc_html__( 'Images', 'haru-circle' ),
                'id'   => 'haru_video' . '_gallery_images',
                'type' => 'image_advanced',
                'desc' => esc_html__( 'Select images gallery for parter','haru-circle' )
            ),
            // HEADING OTHER LINK
            array(
                'type' => 'heading',
                'name' => esc_html__( 'Links', 'haru-circle' ),
                'desc' => esc_html__( 'Links to pages', 'haru-circle' ),
            ),
            array(
                'name'        => esc_html__( 'Crew Link', 'haru-circle' ),
                'id'          => 'haru_video' . '_crew_link',
                'type'        => 'post',
                'desc'        => esc_html__( 'Link of Crew button. Leave empty if you don\'t want to show.','haru-circle' ),
                'post_type'   => array( 'post', 'page' ),
                'std'         => 1,
                'field_type'  => 'select_advanced',
                'placeholder' => esc_html__( 'Select a Page or Post', 'haru-circle' ),
                'query_args'  => array(
                    'post_status'    => 'publish',
                    'posts_per_page' => - 1,
                ),
            ),
            array(
                'name'        => esc_html__( 'Hire Us Link', 'haru-circle' ),
                'id'          => 'haru_video' . '_hire_link',
                'type'        => 'post',
                'desc'        => esc_html__( 'Link of Hire Us button. Leave empty if you don\'t want to show.','haru-circle' ),
                'post_type'   => array( 'post', 'page' ),
                'std'         => 1,
                'field_type'  => 'select_advanced',
                'placeholder' => esc_html__( 'Select a Page or Post', 'haru-circle' ),
                'query_args'  => array(
                    'post_status'    => 'publish',
                    'posts_per_page' => - 1,
                ),
            ),
        )
    );

    // Digital Assets metabox
    $meta_boxes[] = array(
        'id'         => 'haru_digitalasset' . '_metabox',
        'title'      => esc_html__( 'Video Metaboxes', 'haru-circle' ),
        'post_types' => array( 'haru_digitalasset' ),
        'fields'     => array(
            // THUMBNAIL INFORMATION
            array(
                'type' => 'heading',
                'name' => esc_html__( 'Thumbnail', 'haru-circle' ),
                'desc' => esc_html__( 'Set thumbnail style for Digital Assets', 'haru-circle' ),
            ),
            
            array(
                'name'  => esc_html__( 'Thumbnail Video', 'haru-circle' ),
                'id'    => 'haru_digitalasset' . '_thumbnail_video',
                'type'  => 'file_input',
                'desc'  => esc_html__( 'Set video URL for video\'s thumbnail (MP4)', 'haru-circle' )
            ),
            array(
                'name' => esc_html__( 'Thumbnail Images', 'haru-circle' ),
                'id'   => 'haru_digitalasset' . '_thumbnail_images',
                'type' => 'image_advanced',
                'desc' => esc_html__( 'Select images for partner','haru-circle' )
            ),
            // HEADING PARTNER/ SPONSOR
            array(
                'type' => 'heading',
                'name' => esc_html__( 'Partners/Sponsor', 'haru-circle' ),
                'desc' => esc_html__( 'Information of partner/sponsor', 'haru-circle' ),
            ),
            array(
                'id'   => 'haru_digitalasset' . '_price',
                'name' => esc_html__( 'Price', 'haru-circle' ),
                'type' => 'text',
            ),
            array(
                'name' => esc_html__( 'OPV', 'haru-circle' ),
                'id'   => 'haru_digitalasset' . '_opv',
                'type' => 'text',
            ),
            array(
                'name' => esc_html__( 'Link Find Out More', 'haru-circle' ),
                'id'   => 'haru_digitalasset' . '_url_find_out_more',
                'type' => 'text'
            )
        )
    );

    // Film metabox
    $meta_boxes[] = array(
        'id'         => 'haru_film' . '_metabox',
        'title'      => esc_html__( 'Film Metaboxes', 'haru-circle' ),
        'post_types' => array( 'haru_film' ),
        'fields'     => array(
            array(
                'id'      => 'haru_film' . '_short_description',
                'name'    => esc_html__( 'Short Description', 'haru-circle' ),
                'type'    => 'textarea',
                'std'     => '',
            ),
            array(
                'id'          => 'haru_film' . '_director',
                'name'        => esc_html__( 'Director', 'haru-circle' ),
                'desc'        => esc_html__( 'Director of Film.', 'haru-circle' ),
                'type'        => 'post',
                // Post type
                'post_type'   => 'haru_director',
                // Field type, either 'select' or 'select_advanced' (default)
                'field_type'  => 'select_advanced',
                'placeholder' => esc_html__( 'Select Director', 'haru-circle' ),
                // Query arguments (optional). No settings means get all published posts
                'multiple'    => false,
                'query_args'  => array(
                    'post_status'    => 'publish',
                    'posts_per_page' => - 1,
                ),
            ),
            array(
                'id'          => 'haru_film' . '_actor',
                'name'        => esc_html__( 'Actor', 'haru-circle' ),
                'desc'        => esc_html__( 'Actor of Film.', 'haru-circle' ),
                'type'        => 'post',
                // Post type
                'post_type'   => 'haru_actor',
                // Field type, either 'select' or 'select_advanced' (default)
                'field_type'  => 'select_advanced',
                'placeholder' => esc_html__( 'Select Actors', 'haru-circle' ),
                // Query arguments (optional). No settings means get all published posts
                'multiple'    => true,
                'query_args'  => array(
                    'post_status'    => 'publish',
                    'posts_per_page' => - 1,
                ),
            ),
            array(
                'name'    => esc_html__( 'Film Type', 'haru-circle' ),
                'id'      => 'haru_film' . '_type',
                'type'    => 'button_set',
                'options' => array(
                    'short'  => esc_html__( 'Short','haru-circle' ),
                    'series' => esc_html__( 'Series','haru-circle' ),
                ),
                'std'      => 'short',
                'multiple' => false,
            ),
            array(
                'id'      => 'haru_film' . '_episode_number',
                'name'    => esc_html__( 'Episodes Number', 'haru-circle' ),
                'desc'    => esc_html__( 'Number of Film\'s episodes.', 'haru-circle' ),
                'type'    => 'number',
                'std'     => '10',
                'visible' => array( 'haru_film' . '_type', '=', 'series' )
            ),
            array(
                'id'   => 'haru_film' .  '_duration',
                'name' => esc_html__( 'Film duration', 'haru-circle' ),
                'desc' => esc_html__( 'Duration of one Film\'s episodes (minutes).', 'haru-circle' ),
                'type' => 'number',
                'std'  => '90',
                'step' => 'any', // Add this line
            ),
            array(
                'id'   => 'haru_film' . '_trailer',
                'name'        => esc_html__( 'Film trailer', 'haru-circle' ),
                'desc'        => esc_html__( 'Trailer of Film.', 'haru-circle' ),
                'type'        => 'post',
                // Post type
                'post_type'   => 'haru_trailer',
                // Field type, either 'select' or 'select_advanced' (default)
                'field_type'  => 'select_advanced',
                'placeholder' => esc_html__( 'Select Trailer', 'haru-circle' ),
                // Query arguments (optional). No settings means get all published posts
                'multiple'    => false,
                'query_args'  => array(
                    'post_status'    => 'publish',
                    'posts_per_page' => - 1,
                ),
            ),
            array(
                'name'    => esc_html__( 'Film Label', 'haru-circle' ),
                'id'      => 'haru_film' . '_label',
                'type'    => 'button_set',
                'options' => array(
                    ''         => esc_html__( 'None','haru-circle' ),
                    'new'      => esc_html__( 'New','haru-circle' ),
                    'hot'      => esc_html__( 'Hot','haru-circle' ),
                    'trending' => esc_html__( 'Trending','haru-circle' ),
                ),
                'std'      => '',
                'multiple' => false,
            ),
            array(
                'id'          => 'haru_film' .  '_rating',
                'name'        => esc_html__( 'Film Rating', 'haru-circle' ),
                'desc'        => esc_html__( 'Rating of Film.', 'haru-circle' ),
                'type'        => 'number',
                'step'        => 'any',
                'min'         => 0,
                'max'         => 10,
                'placeholder' => esc_html__( 'From 0 to 10', 'haru-circle' ),
            ),
        )
    );

    $meta_boxes[] = array(
        'id'         => 'haru_film' . '_metabox_videos',
        'title'      => esc_html__( 'Film Videos', 'haru-circle' ),
        'post_types' => array( 'haru_film' ),
        'fields'     => array(
            array(
                'id'                => 'haru_film' . '_videos',
                'name'              => esc_html__( 'Videos', 'haru-circle' ),
                'desc'              => esc_html__( 'Set videos of Film.', 'haru-circle' ),
                'type'              => 'videos',
                'title_holder'      => esc_html__( 'Video Name', 'haru-circle' ),
                'youtube_holder'    => esc_html__( 'Youtube Server', 'haru-circle' ),
                'vimeo_holder'      => esc_html__( 'Vimeo Server', 'haru-circle' ),
                'local_holder'      => esc_html__( 'Local Server', 'haru-circle' ),
                'dailymotion_holder'=> esc_html__( 'Dailymotion Server', 'haru-circle' ),
                'twitch_holder'     => esc_html__( 'Twitch Server', 'haru-circle' ),
                'facebook_holder'   => esc_html__( 'Facebook Server', 'haru-circle' ),
                'youtube_id_holder' => esc_html__( 'Youtube ID', 'haru-circle' ),
                'vimeo_id_holder'   => esc_html__( 'Vimeo ID', 'haru-circle' ),
                'mp4_holder'        => esc_html__( 'Mp4 Url', 'haru-circle' ),
                'webm_holder'       => esc_html__( 'WebM Url', 'haru-circle' ),
                'dailymotion_id_holder'   => esc_html__( 'Dailymotion ID', 'haru-circle' ),
                'twitch_id_holder'   => esc_html__( 'Twitch ID', 'haru-circle' ),
                'facebook_id_holder'   => esc_html__( 'Facebook ID', 'haru-circle' ),
                'clone'             => true,
                // 'max_clone'      => 4,
                'sort_clone'        => true,
            ),
        )
    );

    // Trailer metabox
    $meta_boxes[] = array(
        'id'         => 'haru_trailer' . '_metabox',
        'title'      => esc_html__( 'Trailer Metaboxes', 'haru-circle' ),
        'post_types' => array( 'haru_trailer' ),
        'fields'     => array(
            array(
                'name'    => esc_html__( 'Source Server', 'haru-circle' ),
                'id'      => 'haru_trailer' . '_server',
                'type'    => 'button_set',
                'options' => array(
                    'youtube'       => esc_html__( 'Youtube','haru-circle' ),
                    'vimeo'         => esc_html__( 'Vimeo','haru-circle' ),
                    'dailymotion'   => esc_html__( 'Dailymotion','haru-circle' ),
                    'twitch'        => esc_html__( 'Twitch','haru-circle' ),
                    'facebook'      => esc_html__( 'Facebook','haru-circle' ),
                    'url'           => esc_html__( 'Url','haru-circle' ),
                ),
                'std'      => 'youtube',
                'multiple' => false,
            ),
            array(
                'id'      => 'haru_trailer' . '_id',
                'name'    => esc_html__( 'Video ID', 'haru-circle' ),
                'desc'    => esc_html__( 'Insert Video ID from Youtube, Dailymotion... or Vimeo server.', 'haru-circle' ),
                'type'    => 'text',
                'std'     => '',
                'visible' => array( 'haru_trailer' . '_server', '!=', 'url' )
            ),
            array(
                'id'          => 'haru_trailer'.  '_url',
                'name'        => esc_html__( 'Video Url', 'haru-circle' ),
                'desc'        => esc_html__( 'Insert Video Url from other server (mp4 and webm).', 'haru-circle' ),
                'mp4_holder'  => esc_html__( 'Mp4 Url', 'haru-circle' ),
                'webm_holder' => esc_html__( 'WebM Url', 'haru-circle' ),
                'type'        => 'video_url',
                'std'         => '',
                'visible'     => array( 'haru_trailer' . '_server', '=', 'url' )
            ),
        )
    );

    // Product special metabox
    $meta_boxes[] = array(
        'id'         => 'haru_product' . '_metabox',
        'title'      => esc_html__( 'Product Metaboxes', 'haru-circle' ),
        'post_types' => array( 'product' ),
        'fields'     => array(
            array(
                'name'             => esc_html__('Product Guide', 'haru-circle'),
                'id'               => 'haru_' . 'single_product_size_guide',
                'type'             => 'image_advanced',
                'max_file_uploads' => 1,
                'desc'             => esc_html__( 'Select an image for Product Guide', 'haru-circle' )
            ),
            array(
                'id'   => 'haru_'.  'single_product_style',
                'name' => esc_html__( 'Single Product Style', 'haru-circle' ),
                'type' => 'select',
                'options' => array(
                    '-1'    => esc_html__( 'Default','haru-circle' ),
                    'horizontal' => esc_html__( 'Horizontal','haru-circle' ),
                    'vertical'  => esc_html__( 'Vertical','haru-circle' ),
                    'vertical_gallery'  => esc_html__( 'Vertical Gallery','haru-circle' )
                ),
                'std'      => '-1',
            ),
            array(
                'id'   => 'haru_'.  'single_product_thumbnail_columns',
                'name' => esc_html__( 'Product Thumbnail Columns', 'haru-circle' ),
                'type' => 'select',
                'options' => array(
                    '-1'    => esc_html__( 'Default','haru-circle' ),
                    '2'     => '2',
                    '3'     => '3',
                    '4'     => '4',
                    '5'     => '5'
                ),
                'std'      => '-1',
                'hidden' => array( 'haru_' . 'single_product_style', 'not in', array('-1','horizontal', 'vertical') )
            ),
            array(
                'id'   => 'haru_'.  'single_product_thumbnail_position',
                'name' => esc_html__( 'Product Thumbnail Position', 'haru-circle' ),
                'type' => 'button_set',
                'options' => array(
                    '-1'    => esc_html__( 'Default','haru-circle' ),
                    'thumbnail-left'        => 'Left',
                    'thumbnail-right'       => 'Right',
                ),
                'std'      => '-1',
                'hidden' => array( 'haru_' . 'single_product_style', '!=', 'vertical' )
            ),
        )
    );

    // Portfolio
    $meta_boxes[] = array(
        'id'          => 'haru_portfolio_meta_box_media_type',
        'title'       => esc_html__( 'Portfolio Type', 'haru-circle' ),
        'context'     => 'side',
        'post_types'  => array('haru_portfolio'),
        'priority'    => 'high',
        'description' => esc_html__( 'Choose the media type for this Portfolio Item.', 'haru-circle' ),
        'fields'      => array(
            array(
                'id'    => 'haru_portfolio_media_type',
                'type'  => 'radio',
                'std'   => 'image',
                'class' => 'haru-portfolio-post-type',
                'options' => array(
                    'image'   => esc_html__( 'Image', 'haru-circle' ),
                    'link'    => esc_html__( 'Link', 'haru-circle' ),
                    'gallery' => esc_html__( 'Gallery', 'haru-circle' ),
                    'video'   => esc_html__( 'Video', 'haru-circle' ),
                ),
            ),
            array(
                'name'    => esc_html__( 'Thumbnail size', 'haru-circle' ),
                'id'      => 'haru_portfolio_thumbnail_size',
                'type'    => 'select',
                'class'   => 'haru-portfolio-thumbnail-size',
                'options' => array(
                    ''              => esc_html__( 'Default', 'haru-circle' ),
                    'small_squared' => esc_html__( 'Small Squared', 'haru-circle' ),
                    'big_squared'   => esc_html__( 'Big Squared', 'haru-circle' ),
                    'landscape'     => esc_html__( 'Landscape', 'haru-circle' ),
                    'portrait'      => esc_html__( 'Portrait', 'haru-circle' ),
                ),
                'multiple' => false,
                'std'      => '',
            ),
            array(
                'name'    => esc_html__( 'Single Style', 'haru-circle' ),
                'id'      => 'portfolio_single_style',
                'type'    => 'select',
                'class'   => 'haru-portfolio-view-single',
                'options' => array(
                    'none'      => esc_html__( 'Inherit from theme options','haru-circle' ),
                    'single-01' => esc_html__( 'Fullwidth slide', 'haru-circle' ),
                    'single-02' => esc_html__( 'Vertical images', 'haru-circle' ),
                    'single-03' => esc_html__( 'Fullwidth slide 2', 'haru-circle' ),
                ),
                'multiple'    => false,
                'std'         => 'none',
            )
        ),
    );

    $meta_boxes[] = array(
        'title'      => esc_html__( 'Project Information', 'haru-circle' ),
        'id'         => 'haru_portfolio' . 'meta_box_info',
        'post_types' => array('haru_portfolio'),
        'fields'     => array(
            array(
                'name' => esc_html__( 'Images Gallery', 'haru-circle' ),
                'id'   => 'haru_portfolio' . '_data_format_gallery',
                'type' => 'image_advanced',
                'desc' => esc_html__( 'Select images gallery for post','haru-circle' ),
                'visible' => array( 'haru_portfolio' . '_media_type', '=', 'gallery' )
            ),
            array(
                'name' => esc_html__( 'Video URL or Embeded Code', 'haru-circle' ),
                'id'   => 'haru_portfolio' . '_data_format_video',
                'type' => 'textarea',
                'visible' => array( 'haru_portfolio' . '_media_type', '=', 'video' )
            ),
            array(
                'name' => esc_html__( 'Url', 'haru-circle' ),
                'id'   => 'haru_portfolio' . '_data_format_link_url',
                'type' => 'url',
                'visible' => array( 'haru_portfolio' . '_media_type', '=', 'link' )
            ),
            array(
                'name' => esc_html__( 'Text', 'haru-circle' ),
                'id'   => 'haru_portfolio' . '_data_format_link_text',
                'type' => 'text',
                'visible' => array( 'haru_portfolio' . '_media_type', '=', 'link' )
            ),
            array(
                'name' => esc_html__( 'Client', 'haru-circle' ),
                'id'   => 'haru_portfolio' . '_client',
                'type' => 'text',
            ),
            array(
                'name' => esc_html__( 'Team Member', 'haru-circle' ),
                'id'   => 'haru_portfolio' . '_team_member',
                'type' => 'text',
                'clone' => true,
            ),
        ),
    );


    // WordPress Post
    // POST FORMAT: Image
    //--------------------------------------------------
    $meta_boxes[] = array(
        'title'      => esc_html__( 'Post Format: Image', 'haru-circle' ),
        'id'         => 'haru_' .'meta_box_post_format_image',
        'post_types' => array('post'),
        'fields'     => array(
            array(
                'name'             => esc_html__('Image', 'haru-circle'),
                'id'               => 'haru_' . 'post_format_image',
                'type'             => 'image_advanced',
                'max_file_uploads' => 1,
                'desc'             => esc_html__( 'Select a image for post','haru-circle' )
            ),
        ),
    );

    // POST FORMAT: Gallery
    //--------------------------------------------------
    $meta_boxes[] = array(
        'title'      => esc_html__( 'Post Format: Gallery', 'haru-circle' ),
        'id'         => 'haru_' . 'meta_box_post_format_gallery',
        'post_types' => array('post'),
        'fields'     => array(
            array(
                'name' => esc_html__( 'Images', 'haru-circle' ),
                'id'   => 'haru_' . 'post_format_gallery',
                'type' => 'image_advanced',
                'desc' => esc_html__( 'Select images gallery for post','haru-circle' )
            ),
        ),
    );

    // POST FORMAT: Video
    //--------------------------------------------------
    $meta_boxes[] = array(
        'title'      => esc_html__( 'Post Format: Video', 'haru-circle' ),
        'id'         => 'haru_' . 'meta_box_post_format_video',
        'post_types' => array('post'),
        'fields'     => array(
            array(
                'name' => esc_html__( 'Video URL or Embeded Code', 'haru-circle' ),
                'id'   => 'haru_' . 'post_format_video',
                'type' => 'textarea',
            ),
        ),
    );

    // POST FORMAT: Audio
    //--------------------------------------------------
    $meta_boxes[] = array(
        'title'      => esc_html__( 'Post Format: Audio', 'haru-circle' ),
        'id'         => 'haru_' . 'meta_box_post_format_audio',
        'post_types' => array('post'),
        'fields'     => array(
            array(
                'name' => esc_html__( 'Audio URL or Embeded Code', 'haru-circle' ),
                'id'   => 'haru_' . 'post_format_audio',
                'type' => 'textarea',
            ),
        ),
    );

    // POST FORMAT: QUOTE
    //--------------------------------------------------
    $meta_boxes[] = array(
        'title'      => esc_html__( 'Post Format: Quote', 'haru-circle' ),
        'id'         => 'haru_' . 'meta_box_post_format_quote',
        'post_types' => array('post'),
        'fields'     => array(
            array(
                'name' => esc_html__( 'Quote', 'haru-circle' ),
                'id'   => 'haru_' . 'post_format_quote',
                'type' => 'textarea',
            ),
            array(
                'name' => esc_html__( 'Author', 'haru-circle' ),
                'id'   => 'haru_' . 'post_format_quote_author',
                'type' => 'text',
            ),
            array(
                'name' => esc_html__( 'Author Url', 'haru-circle' ),
                'id'   => 'haru_' . 'post_format_quote_author_url',
                'type' => 'url',
            ),
        ),
    );
    // POST FORMAT: LINK
    //--------------------------------------------------
    $meta_boxes[] = array(
        'title'      => esc_html__( 'Post Format: Link', 'haru-circle' ),
        'id'         => 'haru_' . 'meta_box_post_format_link',
        'post_types' => array('post'),
        'fields'     => array(
            array(
                'name' => esc_html__( 'Url', 'haru-circle' ),
                'id'   => 'haru_' . 'post_format_link_url',
                'type' => 'url',
            ),
            array(
                'name' => esc_html__( 'Text', 'haru-circle' ),
                'id'   => 'haru_' . 'post_format_link_text',
                'type' => 'text',
            ),
        ),
    );

    // PAGE LAYOUT
    $meta_boxes[] = array(
        'id'         => 'haru_' . 'page_layout_meta_box',
        'title'      => esc_html__( 'Layout', 'haru-circle' ),
        'post_types' => array('post', 'page',  'haru_portfolio','product'),
        'tab'        => true,
        'fields'     => array(
            array(
                'name'    => esc_html__( 'Layout Style', 'haru-circle' ),
                'id'      => 'haru_' . 'layout_style',
                'type'    => 'button_set',
                'options' => array(
                    '-1'    => esc_html__( 'Default','haru-circle' ),
                    'boxed' => esc_html__( 'Boxed','haru-circle' ),
                    'wide'  => esc_html__( 'Wide','haru-circle' ),
                    'float' => esc_html__( 'Float','haru-circle' )
                ),
                'std'      => '-1',
                'multiple' => false,
            ),

            array(
                'name'    => esc_html__( 'Page Layout', 'haru-circle' ),
                'id'      => 'haru_' . 'page_layout',
                'type'    => 'button_set',
                'options' => array(
                    '-1'              => esc_html__( 'Default','haru-circle' ),
                    'full'            => esc_html__( 'Full Width','haru-circle' ),
                    'container'       => esc_html__( 'Container','haru-circle' ),
                ),
                'std'      => '-1',
                'multiple' => false,
            ),

            array(
                'name'       => esc_html__( 'Page Sidebar', 'haru-circle' ),
                'id'         => 'haru_' . 'page_sidebar',
                'type'       => 'image_set',
                'allowClear' => true,
                'options'    => array(
                    'none'    => get_template_directory_uri().'/framework/admin-assets/images/theme-options/sidebar-none.png',
                    'left'    => get_template_directory_uri().'/framework/admin-assets/images/theme-options/sidebar-left.png',
                    'right'   => get_template_directory_uri().'/framework/admin-assets/images/theme-options/sidebar-right.png',
                ),
                'std'      => '',
                'multiple' => false,
            ),

            array(
                'name'           => esc_html__( 'Left Sidebar', 'haru-circle' ),
                'id'             => 'haru_' . 'page_left_sidebar',
                'type'           => 'select',
                'options'        => $sidebar_list,
                'placeholder'    => esc_html__( 'Select Sidebar','haru-circle' ),
                'std'            => '',
                'hidden' => array( 'haru_' . 'page_sidebar', 'not in', array('','left') )
            ),

            array(
                'name'           => esc_html__( 'Right Sidebar', 'haru-circle' ),
                'id'             => 'haru_' . 'page_right_sidebar',
                'type'           => 'select',
                'options'        => $sidebar_list,
                'placeholder'    => esc_html__( 'Select Sidebar','haru-circle' ),
                'std'            => '',
                'hidden' => array( 'haru_' . 'page_sidebar', 'not in', array('','right') )
            ),

            array(
                'name'  => esc_html__( 'Page Extra Class', 'haru-circle' ),
                'id'    => 'haru_' . 'page_extra_class',
                'type'  => 'text',
                'std'   => ''
            ),
        )
    );

    // PAGE TOP
    $meta_boxes[] = array(
        'id'         => 'haru_' . 'site_top_meta_box',
        'title'      => esc_html__( 'Top Bar', 'haru-circle' ),
        'post_types' => array('post', 'page',  'haru_portfolio','product'),
        'tab'        => true,
        'fields'     => array(
            array(
                'name'    => esc_html__( 'Show/Hide Top Bar', 'haru-circle' ),
                'id'      => 'haru_' . 'top_bar',
                'type'    => 'button_set',
                'std'     => '-1',
                'options' => array(
                    '-1' => esc_html__( 'Default','haru-circle' ),
                    '1'  => esc_html__( 'Show','haru-circle' ),
                    '0'  => esc_html__( 'Hide','haru-circle' )
                ),
            ),
            array(
                'id'      => 'haru_' . 'top_bar_layout_width',
                'name'    => esc_html__( 'Top bar layout width', 'haru-circle' ),
                'type'    => 'button_set',
                'std'     => '-1',
                'options' => array(
                    '-1'           => esc_html__( 'Default', 'haru-circle' ),
                    'container'    => esc_html__( 'Container', 'haru-circle' ),
                    'topbar-fullwith' => esc_html__( 'Full width', 'haru-circle' ),
                ),
                'visible' => array( 'haru_' . 'top_bar', '!=', '0' )
            ),
            array(
                'name'       => esc_html__( 'Top Bar Layout', 'haru-circle' ),
                'id'         => 'haru_' . 'top_bar_layout',
                'desc'       => esc_html__( 'If layout 1 column, it will display left sidebar.', 'haru-circle' ),
                'type'       => 'image_set',
                'allowClear' => true,
                'width'      => '80px',
                'std'        => '',
                'options'    => array(
                    'top-bar-1' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/top-bar-layout-1.jpg',
                    'top-bar-2' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/top-bar-layout-2.jpg',
                ),
                'visible' => array( 'haru_' . 'top_bar', '!=', '0' )
            ),

            array(
                'name'           => esc_html__( 'Top Left Sidebar', 'haru-circle' ),
                'id'             => 'haru_' . 'top_bar_left_sidebar',
                'type'           => 'select',
                'options'        => $sidebar_list,
                'std'            => '',
                'placeholder'    => esc_html__( 'Select Sidebar', 'haru-circle' ),
                'multiple'       => false,
                'hidden' => array( 'haru_' . 'top_bar_layout', 'not in', array('top-bar-1','top-bar-2') )
            ),

            array(
                'name'           => esc_html__( 'Top Right Sidebar', 'haru-circle' ),
                'id'             => 'haru_' . 'top_bar_right_sidebar',
                'type'           => 'select',
                'options'        => $sidebar_list,
                'std'            => '',
                'placeholder'    => esc_html__( 'Select Sidebar','haru-circle' ),
                'hidden' => array( 'haru_' . 'top_bar_layout', 'not in', array('top-bar-1') )
            ),

        )
    );

    // PAGE LOGO
    //--------------------------------------------------
    $meta_boxes[] = array(
        'id'         => 'haru_' . 'page_logo_meta_box',
        'title'      => esc_html__( 'Logo', 'haru-circle' ),
        'post_types' => array('post', 'page',  'haru_portfolio','product', 'haru_video', 'haru_film'),
        'tab'        => true,
        'fields'     => array(
            array(
                'id'               => 'haru_'.  'logo',
                'name'             => esc_html__( 'Logo Image', 'haru-circle' ),
                'desc'             => esc_html__( 'Logo Image for page.', 'haru-circle' ),
                'type'             => 'image_advanced',
                'max_file_uploads' => 1,
            ),
            array(
                'id'               => 'haru_'.  'logo_retina',
                'name'             => esc_html__( 'Logo Retina Image', 'haru-circle' ),
                'desc'             => esc_html__( 'Logo Retina Image for page.', 'haru-circle' ),
                'type'             => 'image_advanced',
                'max_file_uploads' => 1,
            ),
            array(
                'id'               => 'haru_'.  'sticky_logo',
                'name'             => esc_html__( 'Sticky Logo Image', 'haru-circle' ),
                'desc'             => esc_html__( 'Logo Sticky Image for page.', 'haru-circle' ),
                'type'             => 'image_advanced',
                'max_file_uploads' => 1,
            ),
            array(
                'id'               => 'haru_'.  'logo_max_height',
                'name'             => esc_html__( 'Logo Max Height', 'haru-circle' ),
                'desc'             => esc_html__( 'Set max height for Logo by pixel (Insert number only)', 'haru-circle' ),
                'type'             => 'number',
                'min'              => 0,
            ),
            array(
                'id'               => 'haru_'.  'logo_sticky_max_height',
                'name'             => esc_html__( 'Logo Sticky Max Height', 'haru-circle' ),
                'desc'             => esc_html__( 'Set max height for Logo Sticky by pixel (Insert number only)', 'haru-circle' ),
                'type'             => 'number',
                'min'              => 0,
            ),
        )
    );

    // PAGE HEADER
    //--------------------------------------------------
    $meta_boxes[] = array(
        'id'         => 'haru_' . 'page_header_meta_box',
        'title'      => esc_html__( 'Header', 'haru-circle' ),
        'post_types' => array('post', 'page',  'haru_portfolio','product', 'haru_video', 'haru_film'),
        'tab'        => true,
        'fields'     => array(
            array(
                'name'       => esc_html__( 'Header Layout', 'haru-circle' ),
                'id'         => 'haru_' . 'header_layout',
                'type'       => 'image_set',
                'allowClear' => true,
                'std'        => '',
                'options'    => array(
                    'header-1'       => get_template_directory_uri().'/framework/admin-assets/images/theme-options/header_1.jpg',
                    'header-2'       => get_template_directory_uri().'/framework/admin-assets/images/theme-options/header_2.jpg',
                    'header-6'       => get_template_directory_uri().'/framework/admin-assets/images/theme-options/header_6.jpg', // Film online
                    'header-4'       => get_template_directory_uri().'/framework/admin-assets/images/theme-options/header_4.jpg',
                    'header-5'       => get_template_directory_uri().'/framework/admin-assets/images/theme-options/header_5.jpg',
                ),
            ),

            array(
                'id'      => 'haru_' . 'header_nav_layout',
                'name'    => esc_html__( 'Header navigation layout', 'haru-circle' ),
                'type'    => 'button_set',
                'std'     => '-1',
                'options' => array(
                    '-1'           => esc_html__( 'Default', 'haru-circle' ),
                    'container'    => esc_html__( 'Container', 'haru-circle' ),
                    'nav-fullwith' => esc_html__( 'Full width', 'haru-circle' ),
                ),
            ),

            array(
                'name'    => esc_html__( 'Header On Slideshow', 'haru-circle' ),
                'id'      => 'haru_' . 'header_layout_float',
                'type'    => 'button_set',
                'std'     => '-1',
                'options' => array(
                    '-1' => esc_html__( 'Default','haru-circle' ),
                    '1'  => esc_html__( 'Enable','haru-circle' ),
                    '0'  => esc_html__( 'Disable','haru-circle' )
                ),
                'desc' => esc_html__( 'Enable/disable header on slideshow.', 'haru-circle' ),
            ),

            array(
                'name'    => esc_html__( 'Header Under Slideshow', 'haru-circle' ),
                'id'      => 'haru_' . 'header_layout_under_slideshow',
                'type'    => 'button_set',
                'std'     => '-1',
                'options' => array(
                    '-1' => esc_html__( 'Default','haru-circle' ),
                    '1'  => esc_html__( 'Enable','haru-circle' ),
                    '0'  => esc_html__( 'Disable','haru-circle' )
                ),
                'desc' => esc_html__( 'This option will override Header On Slideshow option.', 'haru-circle' ),
            ),

            array(
                'name'    => esc_html__( 'Header Sticky', 'haru-circle' ),
                'id'      => 'haru_' . 'header_sticky',
                'type'    => 'button_set',
                'std'     => '-1',
                'options' => array(
                    '-1' => esc_html__( 'Default', 'haru-circle' ),
                    '1'  => esc_html__( 'Enable', 'haru-circle' ),
                    '0'  => esc_html__( 'Disable', 'haru-circle' ),
                ),
            ),

            array(
                'id'      => 'haru_' . 'header_sticky_skin',
                'name'    => esc_html__( 'Header Sticky Skin', 'haru-circle' ),
                'type'    => 'button_set',
                'std'     => '-1',
                'options' => array(
                    '-1'           => esc_html__( 'Default', 'haru-circle' ),
                    'sticky_dark'  => esc_html__( 'Dark', 'haru-circle' ),
                    'sticky_light' => esc_html__( 'Light', 'haru-circle' ),
                ),
            ),
        )
    );

    // HEADER CUSTOMIZE
    $meta_boxes[] = array(
        'id'         => 'haru_' . 'page_header_customize_meta_box',
        'title'      => esc_html__( 'Header Customize', 'haru-circle' ),
        'post_types' => array('post', 'page',  'haru_portfolio','product', 'haru_video', 'haru_film'),
        'tab'        => true,
        'fields'     => array(
            array(
                'name'  => esc_html__( 'Set header customize navigation?', 'haru-circle' ),
                'id'    => 'haru_' . 'enable_header_customize_nav',
                'type'  => 'checkbox_advanced',
                'std'   => 0,
            ),

            // Header custom navigation
            array(
                'name'    => esc_html__( 'Header Customize Navigation', 'haru-circle' ),
                'id'      => 'haru_' . 'header_customize_nav',
                'type'    => 'sorter',
                'std'     => '',
                'desc'    => esc_html__( 'Select element for header customize navigation. Drag to change element order', 'haru-circle' ),
                'options' => array(
                    'search-button'   => esc_html__( 'Search Button', 'haru-circle' ),
                    'search-box'      => esc_html__( 'Search Box', 'haru-circle' ),
                    'social-profile'  => esc_html__( 'Social Profile', 'haru-circle'),
                    'custom-text'     => esc_html__( 'Custom Text', 'haru-circle' ),
                    'canvas-menu'     => esc_html__( 'Canvas Menu', 'haru-circle' ),
                    'search-box-film' => esc_html__( 'Search Box Film', 'haru-circle' ),
                    'user-account'    => esc_html__( 'User Account', 'haru-circle' ),
                    'film-category'   => esc_html__( 'Film Category', 'haru-circle' ),
                ),
                'hidden' => array( 'haru_' . 'enable_header_customize_nav', '!=', '1' )
            ),

            array(
                'name'        => esc_html__( 'Custom social profiles', 'haru-circle' ),
                'id'          => 'haru_' . 'header_customize_nav_social_profile',
                'type'        => 'select_advanced',
                'placeholder' => esc_html__( 'Select social profiles', 'haru-circle' ),
                'std'         => '',
                'multiple'    => true,
                'options'     => array(
                    'twitter'    => esc_html__( 'Twitter', 'haru-circle' ),
                    'facebook'   => esc_html__( 'Facebook', 'haru-circle' ),
                    'vimeo'      => esc_html__( 'Vimeo', 'haru-circle' ),
                    'linkedin'   => esc_html__( 'LinkedIn', 'haru-circle' ),
                    'googleplus' => esc_html__( 'Google+', 'haru-circle' ),
                    'flickr'     => esc_html__( 'Flickr', 'haru-circle' ),
                    'youtube'    => esc_html__( 'YouTube', 'haru-circle' ),
                    'pinterest'  => esc_html__( 'Pinterest', 'haru-circle' ),
                    'instagram'  => esc_html__( 'Instagram', 'haru-circle' ),
                    'behance'    => esc_html__( 'Behance', 'haru-circle' ),
                ),
            ),

            array(
                'name'           => esc_html__( 'Custom text content', 'haru-circle' ),
                'id'             => 'haru_' . 'header_customize_nav_text',
                'type'           => 'textarea',
                'std'            => '',
                'required-field' => array('haru_' . 'enable_header_customize_nav','=','1'),
            ),

            // Header custom left
            array(
                'name'  => esc_html__( 'Set header customize left?', 'haru-circle' ),
                'id'    => 'haru_' . 'enable_header_customize_left',
                'type'  => 'checkbox_advanced',
                'std'   => 0,
            ),
            array(
                'name'    => esc_html__( 'Header Customize Left', 'haru-circle' ),
                'id'      => 'haru_' . 'header_customize_left',
                'type'    => 'sorter',
                'std'     => '',
                'desc'    => esc_html__( 'Select element for header customize left. Drag to change element order', 'haru-circle' ),
                'options' => array(
                    'search-button'   => esc_html__( 'Search Button', 'haru-circle' ),
                    'search-box'      => esc_html__( 'Search Box', 'haru-circle' ),
                    'social-profile'  => esc_html__( 'Social Profile', 'haru-circle' ),
                    'custom-text'     => esc_html__( 'Custom Text', 'haru-circle' ),
                    'canvas-menu'     => esc_html__( 'Canvas Menu', 'haru-circle' ),
                    'search-box-film' => esc_html__( 'Search Box Film', 'haru-circle' ),
                    'user-account'    => esc_html__( 'User Account', 'haru-circle' ),
                    'film-category'   => esc_html__( 'Film Category', 'haru-circle' ),
                ),
                'hidden' => array( 'haru_' . 'enable_header_customize_left', '!=', '1' )
            ),

            array(
                'name'        => esc_html__( 'Custom social profiles left', 'haru-circle' ),
                'id'          => 'haru_' . 'header_customize_left_social_profile',
                'type'        => 'select_advanced',
                'placeholder' => esc_html__( 'Select social profiles','haru-circle' ),
                'std'         => '',
                'multiple'    => true,
                'options'     => array(
                    'twitter'    => esc_html__( 'Twitter', 'haru-circle' ),
                    'facebook'   => esc_html__( 'Facebook', 'haru-circle' ),
                    'vimeo'      => esc_html__( 'Vimeo', 'haru-circle' ),
                    'linkedin'   => esc_html__( 'LinkedIn', 'haru-circle' ),
                    'googleplus' => esc_html__( 'Google+', 'haru-circle' ),
                    'flickr'     => esc_html__( 'Flickr', 'haru-circle' ),
                    'youtube'    => esc_html__( 'YouTube', 'haru-circle' ),
                    'pinterest'  => esc_html__( 'Pinterest', 'haru-circle' ),
                    'instagram'  => esc_html__( 'Instagram', 'haru-circle' ),
                    'behance'    => esc_html__( 'Behance', 'haru-circle' ),
                ),
            ),

            array(
                'name'           => esc_html__( 'Custom text content left', 'haru-circle' ),
                'id'             => 'haru_' . 'header_customize_left_text',
                'type'           => 'textarea',
                'std'            => '',
            ),

            // Header custom right
            array(
                'name'  => esc_html__( 'Set header customize right?', 'haru-circle' ),
                'id'    => 'haru_' . 'enable_header_customize_right',
                'type'  => 'checkbox_advanced',
                'std'   => 0,
            ),

            array(
                'name'    => esc_html__( 'Header Customize Right', 'haru-circle' ),
                'id'      => 'haru_' . 'header_customize_right',
                'type'    => 'sorter',
                'std'     => '',
                'desc'    => esc_html__( 'Select element for header customize right. Drag to change element order', 'haru-circle' ),
                'options' => array(
                    'search-button'   => esc_html__( 'Search Button', 'haru-circle' ),
                    'search-box'      => esc_html__( 'Search Box', 'haru-circle' ),
                    'social-profile'  => esc_html__( 'Social Profile', 'haru-circle' ),
                    'custom-text'     => esc_html__( 'Custom Text', 'haru-circle' ),
                    'canvas-menu'     => esc_html__( 'Canvas Menu', 'haru-circle' ),
                    'search-box-film' => esc_html__( 'Search Box Film', 'haru-circle' ),
                    'user-account'    => esc_html__( 'User Account', 'haru-circle' ),
                    'film-category'   => esc_html__( 'Film Category', 'haru-circle' ),
                ),
                'hidden' => array( 'haru_' . 'enable_header_customize_right', '!=', '1' )
            ),

            array(
                'name'        => esc_html__( 'Custom social profiles right', 'haru-circle' ),
                'id'          => 'haru_' . 'header_customize_right_social_profile',
                'type'        => 'select_advanced',
                'placeholder' => esc_html__( 'Select social profiles', 'haru-circle' ),
                'std'         => '',
                'multiple'    => true,
                'options'     => array(
                    'twitter'    => esc_html__( 'Twitter', 'haru-circle' ),
                    'facebook'   => esc_html__( 'Facebook', 'haru-circle' ),
                    'vimeo'      => esc_html__( 'Vimeo', 'haru-circle' ),
                    'linkedin'   => esc_html__( 'LinkedIn', 'haru-circle' ),
                    'googleplus' => esc_html__( 'Google+', 'haru-circle' ),
                    'flickr'     => esc_html__( 'Flickr', 'haru-circle' ),
                    'youtube'    => esc_html__( 'YouTube', 'haru-circle' ),
                    'pinterest'  => esc_html__( 'Pinterest', 'haru-circle' ),
                    'instagram'  => esc_html__( 'Instagram', 'haru-circle' ),
                    'behance'    => esc_html__( 'Behance', 'haru-circle' ),
                ),
            ),

            array(
                'name'           => esc_html__( 'Custom text content right', 'haru-circle' ),
                'id'             => 'haru_' . 'header_customize_right_text',
                'type'           => 'textarea',
                'std'            => '',
            ),
        )
    );

    // HEADER MOBILE
    $meta_boxes[] = array(
        'id'         => 'haru_' . 'page_header_mobile_meta_box',
        'title'      => esc_html__( 'Header Mobile', 'haru-circle' ),
        'post_types' => array('post', 'page',  'haru_portfolio','product', 'haru_video', 'haru_film'),
        'tab'        => true,
        'fields'     => array(
            array(
                'name'       => esc_html__( 'Header Mobile Layout', 'haru-circle' ),
                'id'         => 'haru_' . 'mobile_header_layout',
                'type'       => 'image_set',
                'allowClear' => true,
                'std'        => '',
                'options'    => array(
                    'header-mobile-1'       => get_template_directory_uri().'/framework/admin-assets/images/theme-options/header-mobile-layout-1.jpg',
                    'header-mobile-2'       => get_template_directory_uri().'/framework/admin-assets/images/theme-options/header-mobile-layout-2.jpg',
                    'header-mobile-3'       => get_template_directory_uri().'/framework/admin-assets/images/theme-options/header-mobile-layout-3.jpg',
                )
            ),

            array(
                'id'      => 'haru_' . 'mobile_header_menu_drop',
                'name'    => esc_html__( 'Menu Drop Type', 'haru-circle' ),
                'type'    => 'button_set',
                'std'     => '-1',
                'options' => array(
                    '-1'        => esc_html__( 'Default', 'haru-circle' ),
                    'dropdown'  => esc_html__( 'Dropdown Menu', 'haru-circle' ),
                    'fly'       => esc_html__( 'Fly Menu', 'haru-circle' ),
                )
            ),

            array(
                'name'    => esc_html__( 'Header mobile sticky', 'haru-circle' ),
                'id'      => 'haru_' . 'mobile_header_stick',
                'type'    => 'button_set',
                'std'     => '-1',
                'options' => array(
                    '-1' => esc_html__( 'Default', 'haru-circle' ),
                    '1'  => esc_html__( 'Enable', 'haru-circle' ),
                    '0'  => esc_html__( 'Disable', 'haru-circle' ),
                ),
            ),
        )
    );

    // PAGE TITLE
    //--------------------------------------------------
    $meta_boxes[] = array(
        'id'         => 'haru_' . 'page_title_meta_box',
        'title'      => esc_html__( 'Page Title', 'haru-circle' ),
        'post_types' => array('post', 'page',  'haru_portfolio','product', 'haru_video', 'haru_film'),
        'tab'        => true,
        'fields'     => array(
            array(
                'name'    => esc_html__( 'Show/Hide Page Title?', 'haru-circle' ),
                'id'      => 'haru_' . 'show_page_title',
                'type'    => 'button_set',
                'std'     => '-1',
                'options' => array(
                    '-1' => esc_html__( 'Default', 'haru-circle' ),
                    '1'  => esc_html__( 'Show', 'haru-circle' ),
                    '0'  => esc_html__( 'Hide', 'haru-circle' ),
                )

            ),

            array(
                'name'    => esc_html__( 'Page Title Layout', 'haru-circle' ),
                'id'      => 'haru_' . 'page_title_layout',
                'type'    => 'button_set',
                'options' => array(
                    '-1'              => esc_html__( 'Default', 'haru-circle' ),
                    'full'            => esc_html__( 'Full Width', 'haru-circle' ),
                    'container'       => esc_html__( 'Container', 'haru-circle' ),
                ),
                'std'            => '-1',
                'multiple'       => false,
                'hidden' => array( 'haru_' . 'show_page_title', '=', '0' )
            ),

            // PAGE TITLE LINE 1
            array(
                'name'           => esc_html__( 'Custom Page Title', 'haru-circle' ),
                'id'             => 'haru_' . 'page_title_custom',
                'desc'           => esc_html__( "Enter a custom page title if you'd like.", 'haru-circle' ),
                'type'           => 'text',
                'std'            => '',
                'hidden' => array( 'haru_' . 'show_page_title', '=', '0' )
            ),

            // PAGE TITLE LINE 2
            array(
                'name'           => esc_html__( 'Custom Page Subtitle', 'haru-circle' ),
                'id'             => 'haru_' . 'page_subtitle_custom',
                'desc'           => esc_html__( "Enter a custom page title if you'd like.", 'haru-circle' ),
                'type'           => 'text',
                'std'            => '',
                'hidden' => array( 'haru_' . 'show_page_title', '=', '0' )
            ),

            // BACKGROUND IMAGE
            array(
                'id'               => 'haru_'.  'page_title_bg_image',
                'name'             => esc_html__( 'Background Image', 'haru-circle' ),
                'desc'             => esc_html__( 'Background Image for page title.', 'haru-circle' ),
                'type'             => 'image_advanced',
                'max_file_uploads' => 1,
                'hidden' => array('haru_' . 'show_page_title','=','0'),
            ),

            array(
                'name'    => esc_html__( 'Page Title Parallax', 'haru-circle' ),
                'id'      => 'haru_' . 'page_title_parallax',
                'desc'    => esc_html__( "Enable Page Title Parallax", 'haru-circle' ),
                'type'    => 'button_set',
                'options' => array(
                    '-1' => esc_html__( 'Default', 'haru-circle' ),
                    '1'  => esc_html__( 'Enable','haru-circle' ),
                    '0'  => esc_html__( 'Disable','haru-circle' ),
                ),
                'std'            => '-1',
                'hidden' => array( 'haru_' . 'show_page_title', '=', '0' )
            ),

            // Breadcrumbs in Page Title
            array(
                'name'    => esc_html__( 'Breadcrumbs', 'haru-circle' ),
                'id'      => 'haru_' . 'breadcrumbs_in_page_title',
                'desc'    => esc_html__( "Show/Hide Breadcrumbs", 'haru-circle' ),
                'type'    => 'button_set',
                'options' => array(
                    '-1' => esc_html__( 'Default', 'haru-circle' ),
                    '1'  => esc_html__( 'Show', 'haru-circle' ),
                    '0'  => esc_html__( 'Hide', 'haru-circle' ),
                ),
                'std' => '-1',
            ),
        )
    );

    // PAGE FOOTER
    //--------------------------------------------------
    $meta_boxes[] = array(
        'id'         => 'haru_' . 'page_footer_meta_box',
        'title'      => esc_html__( 'Footer', 'haru-circle' ),
        'post_types' => array('post', 'page',  'haru_portfolio','product'),
        'tab'        => true,
        'fields'     => array(
            array(
                'name'    => esc_html__( 'Footer Layout', 'haru-circle' ),
                'id'      => 'haru_' . 'footer_layout',
                'type'    => 'button_set',
                'options' => array(
                    '-1'              => esc_html__( 'Default', 'haru-circle' ),
                    'full'            => esc_html__( 'Full Width', 'haru-circle' ),
                    'container'       => esc_html__( 'Container', 'haru-circle' ),
                ),
                'std'      => '-1',
                'multiple' => false,
            ),
            array(
                'name' => esc_html__( 'Select Footer', 'haru-circle' ),
                'id'   => 'haru_' . 'footer',
                'type' => 'footer',
                'desc' => esc_html__( 'Select footer to override footer selected in Theme Options', 'haru-circle' ),
            ),
        )
    );

    $meta_boxes[] = array(
        'id'         => 'haru_circle_video' . '_metabox',
        'title'      => esc_html__( 'Video Metaboxes', 'haru-circle' ),
        'post_types' => array( 'haru_circle_video' ),
        'tab'        => true,
        'fields'     => array(
            array(
                'name'    => esc_html__( 'Source Server', 'haru-circle' ),
                'id'      => 'haru_circle_video' . 'video_server',
                'type'    => 'button_set',
                'options' => array(
                    'youtube' => esc_html__( 'Youtube','haru-circle' ),
                    'vimeo'   => esc_html__( 'Vimeo','haru-circle' ),
                    'url'     => esc_html__( 'Url','haru-circle' ),
                ),
                'std'      => 'youtube',
                'multiple' => false,
            ),
            array(
                'id'      => 'haru_circle_video' . '_id',
                'name'    => esc_html__( 'Video ID', 'haru-circle' ),
                'desc'    => esc_html__( 'Insert Video ID from Youtube or Vimeo server.', 'haru-circle' ),
                'type'    => 'text',
                'std'     => '',
                'visible' => array( 'haru_circle_video' . 'video_server', '!=', 'url' )
            ),
            array(
                'id'          => 'haru_circle_video'.  '_url',
                'name'        => esc_html__( 'Video Url', 'haru-circle' ),
                'desc'        => esc_html__( 'Insert Video Url from other server (mp4 and webm).', 'haru-circle' ),
                'mp4_holder'  => esc_html__( 'Mp4 Url', 'haru-circle' ),
                'webm_holder' => esc_html__( 'WebM Url', 'haru-circle' ),
                'type'        => 'video_url',
                'std'         => '',
                'visible'     => array( 'haru_circle_video' . 'video_server', '=', 'url' )
            ),
        )
    );

    
    return $meta_boxes;
}

// Add new field type to RW Metabox. More details: https://metabox.io/docs/create-field-type/
add_action( 'admin_init', 'haru_load_rw_custom_fields', 1 ); // Use this for back-end
add_action( 'rwmb_meta_boxes', 'haru_load_rw_custom_fields', 1 ); // Use this for front-end @TODO: do not know now

function haru_load_rw_custom_fields() {
    if ( file_exists( WP_PLUGIN_DIR.'/haru-circle-core/includes/metabox-extensions/custom-fields/footer.php') ) {
        require_once WP_PLUGIN_DIR.'/haru-circle-core/includes/metabox-extensions/custom-fields/footer.php';
    }
    if ( file_exists( WP_PLUGIN_DIR.'/haru-circle-core/includes/metabox-extensions/custom-fields/button-set.php') ) {
        require_once WP_PLUGIN_DIR.'/haru-circle-core/includes/metabox-extensions/custom-fields/button-set.php';
    }
    if ( file_exists( WP_PLUGIN_DIR.'/haru-circle-core/includes/metabox-extensions/custom-fields/image-set.php') ) {
        require_once WP_PLUGIN_DIR.'/haru-circle-core/includes/metabox-extensions/custom-fields/image-set.php';
    }
    if ( file_exists( WP_PLUGIN_DIR.'/haru-circle-core/includes/metabox-extensions/custom-fields/checkbox-advanced.php') ) {
        require_once WP_PLUGIN_DIR.'/haru-circle-core/includes/metabox-extensions/custom-fields/checkbox-advanced.php';
    }
    if ( file_exists( WP_PLUGIN_DIR.'/haru-circle-core/includes/metabox-extensions/custom-fields/sorter.php') ) {
        require_once WP_PLUGIN_DIR.'/haru-circle-core/includes/metabox-extensions/custom-fields/sorter.php';
    }
    // Circle
    if ( file_exists( WP_PLUGIN_DIR.'/haru-circle-core/includes/metabox-extensions/custom-fields/timeline.php') ) {
        require_once WP_PLUGIN_DIR.'/haru-circle-core/includes/metabox-extensions/custom-fields/timeline.php';
    }
    if ( file_exists( WP_PLUGIN_DIR.'/haru-circle-core/includes/metabox-extensions/custom-fields/social.php') ) {
        require_once WP_PLUGIN_DIR.'/haru-circle-core/includes/metabox-extensions/custom-fields/social.php';
    }
    if ( file_exists( WP_PLUGIN_DIR.'/haru-circle-core/includes/metabox-extensions/custom-fields/videos.php') ) {
        require_once WP_PLUGIN_DIR.'/haru-circle-core/includes/metabox-extensions/custom-fields/videos.php';
    }
    if ( file_exists( WP_PLUGIN_DIR.'/haru-circle-core/includes/metabox-extensions/custom-fields/video-url.php') ) {
        require_once WP_PLUGIN_DIR.'/haru-circle-core/includes/metabox-extensions/custom-fields/video-url.php';
    }
}

// Hook to 'rwmb_meta_boxes' to make sure the meta box class is loaded before
// (in case using the meta box class in another plugin)
// This is also helpful for some conditionals like checking page template, categories, etc.
add_filter( 'rwmb_meta_boxes', 'haru_register_meta_boxes' ); // From version 4.8.0
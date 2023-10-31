<?php
/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

if ( !defined('ABSPATH') ) die('-1');

if ( ! class_exists( 'Haru_Portfolio_Post_Type' ) ) {
    class Haru_Portfolio_Post_Type {

        protected $prefix;

        public function __construct() {
            $this->prefix = 'haru_portfolio';

            add_action( 'init', array($this,'haru_portfolio') ); // Must hook register post type and taxonomies with hight piority go make get_term() working
            // add_action( 'admin_init', array($this, 'haru_register_meta_boxes') );

            if ( is_admin() ) {
                // include_once( plugin_dir_path(__FILE__) . 'metaboxes/spec.php' ); // Add new metabox

                add_action( 'do_meta_boxes', array( $this, 'remove_plugin_metaboxes' ) );
                // Add custom columns reference: http://code.tumilolus.com/articles/add-a-custom-column-in-posts-and-custom-post-types-admin-screen--wp-24934
                add_filter( 'manage_haru_portfolio_posts_columns', array( $this, 'add_columns' ) );
                add_action( 'manage_haru_portfolio_posts_custom_column', array( $this, 'set_columns_value'), 10, 2);
            }
        }

        function remove_plugin_metaboxes() {
            remove_meta_box( 'mymetabox_revslider_0', 'haru_portfolio', 'normal' );
            remove_meta_box( 'handlediv', 'haru_portfolio', 'normal' );
            remove_meta_box( 'commentsdiv', 'haru_portfolio', 'normal' );
        }

        function haru_portfolio() {
            $prefix = $this->prefix;

            $labels = array(
                'menu_name'          => esc_html__( 'Portfolio', 'haru-circle' ),
                'singular_name'      => esc_html__( 'Single Portfolio', 'haru-circle' ),
                'name'               => esc_html__( 'Portfolio', 'haru-circle' ),
                'add_new'            => esc_html__( 'Add New', 'haru-circle' ) ,
                'add_new_item'       => esc_html__( 'Add New Portfolio', 'haru-circle' ) ,
                'edit_item'          => esc_html__( 'Edit Portfolio', 'haru-circle' ) ,
                'new_item'           => esc_html__( 'Add New Portfolio', 'haru-circle' ) ,
                'view_item'          => esc_html__( 'View Portfolio', 'haru-circle' ) ,
                'search_items'       => esc_html__( 'Search Portfolio', 'haru-circle' ) ,
                'not_found'          => esc_html__( 'No Portfolio items found', 'haru-circle' ) ,
                'not_found_in_trash' => esc_html__( 'No Portfolio items found in trash', 'haru-circle' ) ,
                'parent_item_colon'  => ''
            );

            $args = array(
                'labels'                => $labels,
                'description'           => esc_html__( 'Display portfolio', 'haru-circle' ),
                'hierarchical'          => false,
                'public'                => true,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'menu_icon'             => 'dashicons-screenoptions',
                'menu_position'         => 5,
                'show_in_admin_bar'     => true,
                'show_in_nav_menus'     => true,
                'can_export'            => true,
                'has_archive'           => false,
                'exclude_from_search'   => false,
                'publicly_queryable'    => true,
                'capability_type'       => 'post',
                'supports'              => array( 'title', 'editor', 'thumbnail' ),
                'rewrite'           => array(
                    'slug'          => 'portfolio',
                    'with_front'    => false
                ) ,
            );
            register_post_type( 'haru_portfolio', $args );

            // Register a taxonomy for Project Categories.
            $category_labels = array(
                'name'                          => esc_html__( 'Portfolio Categories', 'haru-circle' ) ,
                'singular_name'                 => esc_html__( 'Portfolio Category', 'haru-circle' ) ,
                'menu_name'                     => esc_html__( 'Categories', 'haru-circle' ) ,
                'all_items'                     => esc_html__( 'All Portfolio Categories', 'haru-circle' ) ,
                'edit_item'                     => esc_html__( 'Edit Portfolio Category', 'haru-circle' ) ,
                'view_item'                     => esc_html__( 'View Portfolio Category', 'haru-circle' ) ,
                'update_item'                   => esc_html__( 'Update Portfolio Category', 'haru-circle' ) ,
                'add_new_item'                  => esc_html__( 'Add New Portfolio Category', 'haru-circle' ) ,
                'new_item_name'                 => esc_html__( 'New Portfolio Category Name', 'haru-circle' ) ,
                'parent_item'                   => esc_html__( 'Parent Portfolio Category', 'haru-circle' ) ,
                'parent_item_colon'             => esc_html__( 'Parent Portfolio Category:', 'haru-circle' ) ,
                'search_items'                  => esc_html__( 'Search Portfolio Categories', 'haru-circle' ) ,
                'popular_items'                 => esc_html__( 'Popular Portfolio Categories', 'haru-circle' ) ,
                'separate_items_with_commas'    => esc_html__( 'Separate Portfolio Categories with commas', 'haru-circle' ) ,
                'add_or_remove_items'           => esc_html__( 'Add or remove Portfolio Categories', 'haru-circle' ) ,
                'choose_from_most_used'         => esc_html__( 'Choose from the most used Portfolio Categories', 'haru-circle' ) ,
                'not_found'                     => esc_html__( 'No Portfolio Categories found', 'haru-circle' ) ,
            );

            $category_args = array(
                'labels'            => $category_labels,
                'public'            => false,
                'show_ui'           => true,
                'show_in_nav_menus' => false,
                'show_tagcloud'     => false,
                'show_admin_column' => false,
                'hierarchical'      => true,
                'query_var'         => true,
                'rewrite'           => array(
                    'slug'          => 'portfolio-category',
                    'with_front'    => false
                ) ,
            );

            register_taxonomy('portfolio_category', array(
                'haru_portfolio'
            ) , $category_args);

             // Register a taxonomy for Project Tags.
            $tag_labels = array(
                'name'              => esc_html__( 'Portfolio Tags', 'taxonomy general name', 'haru-circle' ),
                'singular_name'     => esc_html__( 'Tag', 'taxonomy singular name', 'haru-circle' ),
                'menu_name'         => esc_html__( 'Tags', 'haru-circle' ) ,
                'search_items'      => esc_html__( 'Search Types', 'haru-circle' ),
                'all_items'         => esc_html__( 'All Tags', 'haru-circle' ),
                'parent_item'       => esc_html__( 'Parent Tag', 'haru-circle' ),
                'parent_item_colon' => esc_html__( 'Parent Tag:', 'haru-circle' ),
                'edit_item'         => esc_html__( 'Edit Tags', 'haru-circle' ),
                'update_item'       => esc_html__( 'Update Tag', 'haru-circle' ),
                'add_new_item'      => esc_html__( 'Add New Portfolio Tag', 'haru-circle' ),
                'new_item_name'     => esc_html__( 'New Tag Name', 'haru-circle' ),
            );

            $tag_args = array(
                'labels'       => $tag_labels,
                'public'       => true,
                'hierarchical' => false,
                'show_ui'      => true,
                'query_var'    => true,
                'rewrite'      => array( 
                    'slug'       => 'portfolio-tag',
                    'with_front' => false
                ),
            );

            // Custom taxonomy for Project Tags
            register_taxonomy('portfolio_tag', array(
                'haru_portfolio'
            ), $tag_args);
        }

        // Add columns to Project
        function add_columns($columns) {
            unset(
                $columns['cb'],
                $columns['post-format'],
                $columns['title'],
                $columns['date']
            );
            $cols = array_merge(array('cb' => ('')), $columns);
            $cols = array_merge($cols, array('title' => esc_html__( 'Title', 'haru-circle' )));
            $cols = array_merge($cols, array('category' => esc_html__( 'Category', 'haru-circle' )));
            $cols = array_merge($cols, array('media_type' => esc_html__( 'Media Type', 'haru-circle' )));
            $cols = array_merge($cols, array('thumbnail' => esc_html__( 'Thumbnail', 'haru-circle' )));
            $cols = array_merge($cols, array('date' => esc_html__( 'Date', 'haru-circle' )));

            return $cols;
        }

        // Set values for columns
        function set_columns_value($column, $post_id) {
            $prefix = $this->prefix;

            switch ($column) {
                case 'id': {
                    echo wp_kses_post($post_id);
                    break;
                }
                case 'media_type': {
                    $media_type = get_post_meta($post_id, "{$prefix}_media_type", true);
                    switch( $media_type ) {
                        case 'image':
                            echo '<label for="post-format-image" class="post-format-icon post-format-image"></label>';
                            break; 
                        case 'video':
                            echo '<label for="post-format-video" class="post-format-icon post-format-video"></label>';
                            break;
                        case 'link':
                            echo '<label for="post-format-link" class="post-format-icon post-format-link"></label>';
                            break;
                        case 'gallery':
                            echo '<label for="post-format-gallery" class="post-format-icon post-format-gallery"></label>';
                            break;
                        default:

                            break;
                    }
                    break;
                }
                case 'thumbnail': {
                    echo get_the_post_thumbnail($post_id, 'thumbnail');
                    break;
                }
                case 'category': {
                    $terms = get_the_terms( $post_id, 'portfolio_category' ); 
                    foreach($terms as $term) {
                        echo $term->name;
                    }
                    break;
                }

            }
        }

        // Register metaboxies
        function haru_register_meta_boxes() {
            $prefix = $this->prefix;

            // $meta_boxes   = array();
            // $meta_boxes[] = array(
            //     'id'          => "{$prefix}_meta_box_media_type",
            //     'title'       => esc_html__( 'Portfolio Type', 'haru-circle' ),
            //     'context'     => 'side',
            //     'post_types'  => array('haru_portfolio'),
            //     'priority'    => 'high',
            //     'description' => esc_html__( 'Choose the media type for this Portfolio Item.', 'haru-circle' ),
            //     'fields'      => array(
            //         array(
            //             'id'    => "{$prefix}_media_type",
            //             'type'  => 'radio',
            //             'std'   => 'image',
            //             'class' => 'haru-portfolio-post-type',
            //             'options' => array(
            //                 'image'   => esc_html__( 'Image', 'haru-circle' ),
            //                 'link'    => esc_html__( 'Link', 'haru-circle' ),
            //                 'gallery' => esc_html__( 'Gallery', 'haru-circle' ),
            //                 'video'   => esc_html__( 'Video', 'haru-circle' ),
            //             ),
            //         ),
            //         array(
            //             'name'    => esc_html__( 'Thumbnail size', 'haru-circle' ),
            //             'id'      => "{$prefix}_thumbnail_size",
            //             'type'    => 'select',
            //             'class'   => 'haru-portfolio-thumbnail-size',
            //             'options' => array(
            //                 ''              => esc_html__( 'Default', 'haru-circle' ),
            //                 'small_squared' => esc_html__( 'Small Squared', 'haru-circle' ),
            //                 'big_squared'   => esc_html__( 'Big Squared', 'haru-circle' ),
            //                 'landscape'     => esc_html__( 'Landscape', 'haru-circle' ),
            //                 'portrait'      => esc_html__( 'Portrait', 'haru-circle' ),
            //             ),
            //             'multiple' => false,
            //             'std'      => '',
            //         ),
            //         array(
            //             'name'    => esc_html__( 'Single Style', 'haru-circle' ),
            //             'id'      => 'portfolio_single_style',
            //             'type'    => 'select',
            //             'class'   => 'haru-portfolio-view-single',
            //             'options' => array(
            //                 'none'      => esc_html__( 'Inherit from theme options','haru-circle' ),
            //                 'single-01' => esc_html__( 'Fullwidth slide', 'haru-circle' ),
            //                 'single-02' => esc_html__( 'Vertical images', 'haru-circle' ),
            //                 'single-03' => esc_html__( 'Small slide', 'haru-circle' ),
            //                 'single-04' => esc_html__( 'Grid images 2 Columns', 'haru-circle' ),
            //                 'single-05' => esc_html__( 'Grid images 1 Columns', 'haru-circle' )
            //             ),
            //             'multiple'    => false,
            //             'std'         => 'none',
            //         )
            //     ),
            // );

            // PORTFOLIO FORMAT: Gallery
            //--------------------------------------------------
            // $meta_boxes[] = array(
            //     'title'      => esc_html__( 'Post Format: Gallery', 'haru-circle' ),
            //     'id'         => $prefix . 'meta_box_post_format_gallery',
            //     'post_types' => array('haru_portfolio'),
            //     'fields'     => array(
            //         array(
            //             'name' => esc_html__( 'Images', 'haru-circle' ),
            //             'id'   => $prefix . '_data_format_gallery',
            //             'type' => 'image_advanced',
            //             'desc' => esc_html__( 'Select images gallery for post','haru-circle' ),

            //         ),
            //     ),
            // );

            // PORTFOLIO FORMAT: Video
            //--------------------------------------------------
            // $meta_boxes[] = array(
            //     'title'      => esc_html__( 'Post Format: Video', 'haru-circle' ),
            //     'id'         => $prefix . 'meta_box_post_format_video',
            //     'post_types' => array('haru_portfolio'),
            //     'fields'     => array(
            //         array(
            //             'name' => esc_html__( 'Video URL or Embeded Code', 'haru-circle' ),
            //             'id'   => $prefix . '_data_format_video',
            //             'type' => 'textarea',
            //         ),
            //     ),
            // );


            // POST FORMAT: LINK
            //--------------------------------------------------
            // $meta_boxes[] = array(
            //     'title'      => esc_html__( 'Post Format: Link', 'haru-circle' ),
            //     'id'         => $prefix . 'meta_box_post_format_link',
            //     'post_types' => array('haru_portfolio'),
            //     'fields'     => array(
            //         array(
            //             'name' => esc_html__( 'Url', 'haru-circle' ),
            //             'id'   => $prefix . '_data_format_link_url',
            //             'type' => 'url',
            //         ),
            //         array(
            //             'name' => esc_html__( 'Text', 'haru-circle' ),
            //             'id'   => $prefix . '_data_format_link_text',
            //             'type' => 'text',
            //         ),
            //     ),
            // );

            // OTHER INFO
            //--------------------------------------------------
            // $meta_boxes[] = array(
            //     'title'      => esc_html__( 'Other Information', 'haru-circle' ),
            //     'id'         => $prefix . 'meta_box_post_other_info',
            //     'post_types' => array('haru_portfolio'),
            //     'fields'     => array(
            //         array(
            //             'name' => esc_html__( 'Client', 'haru-circle' ),
            //             'id'   => $prefix . '_client',
            //             'type' => 'text',
            //         ),
            //         array(
            //             'name' => esc_html__( 'Team Member', 'haru-circle' ),
            //             'id'   => $prefix . '_team_member',
            //             'type' => 'text',
            //             'clone' => true,
            //         ),
            //     ),
            // );

            // Use RW Metaboxies fields
            // if ( class_exists('RW_Meta_Box') ) {
            //     foreach ($meta_boxes as $meta_box) {
            //         new RW_Meta_Box($meta_box);
            //     }
            // }
        }
    }

    new Haru_Portfolio_Post_Type;
}
<?php
/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

class Haru_Circle_Videos_Widget extends Haru_Widget {

    public function __construct() {
        $this->widget_cssclass    = 'widget-circle-videos';
        $this->widget_description = esc_html__( 'Widget display videos.', 'haru-circle' );
        $this->widget_id          = 'haru_widget_circle_videos';
        $this->widget_name        = esc_html__( 'Haru Circle Videos', 'haru-circle' );
        $this->cached             = false;

        add_action( 'init', array( $this, 'haru_get_videos_categories' ) ); // Use this to make get_terms() working

        $this->settings = array(
            'title'  => array(
                'type'  => 'text',
                'std'   =>'',
                'label' => esc_html__( 'Title', 'haru-circle' )
            ),
            'style' => array(
                'type'    => 'select',
                'std'     => array(),
                'label'   => esc_html__( 'Style', 'haru-circle' ),
                'options' => array(
                    'list_style_1' => esc_html__( 'List Videos 1', 'haru-circle' ),
                    'list_style_2' => esc_html__( 'List Videos 2', 'haru-circle' ),
                    'carousel_1'   => esc_html__( 'Carousel Slideshow 1', 'haru-circle' ),
                    'carousel_2'   => esc_html__( 'Carousel Slideshow 2', 'haru-circle' ),
                )
            ),
            'posts_per_page' => array(
                'type'  => 'number',
                'step'  => 1,
                'min'   => 1,
                'max'   => '',
                'std'   => 5,
                'label' => esc_html__( 'Number of videos to show', 'haru-circle' )
            ),
            'orderby' => array(
                'type'    => 'select',
                'std'     => 'date',
                'label'   => esc_html__( 'Order by', 'haru-circle' ),
                'options' => array(
                    'latest'  => esc_html__( 'Latest', 'haru-circle' ),
                    'popular' => esc_html__( 'Popular', 'haru-circle' ),
                    'comment' => esc_html__( 'Most Commented', 'haru-circle' ),
                )
            ),
        );

        parent::__construct();
    }

    function haru_get_videos_categories() {
        $videos_categories = array();
        $videos_categories = get_terms([
            'taxonomy'   => 'video_category',
            'hide_empty' => false,
            'orderby'    => 'NAME',
            'order'      => 'ASC'
        ]);
        $categories_options = array();
        foreach ( $videos_categories as $category ) {
            $categories_options[$category->term_id] = $category->name;
        }

        $this->settings['categories'] = array(
                'type'     => 'select',
                'std'      => array(),
                'multiple' => '1',
                'label'    =>esc_html__( 'Categories', 'haru-circle' ),
                'desc'     => esc_html__( 'Select a category or leave blank for all', 'haru-circle' ),
                'options'  => $categories_options,
            );

        return $videos_categories;
    }
    
    public function widget($args, $instance) {
        ob_start();
        extract( $args );
        $title          = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
        $posts_per_page = absint( $instance['posts_per_page'] );
        $orderby        = sanitize_title( $instance['orderby'] );
        $categories     = $instance['categories'];
        $style          = $instance['style'];
        $query_args     = array(
            'post_type'           => 'haru_video',
            'posts_per_page'      => $posts_per_page,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => 1,
            'orderby'             => 'date',
            'meta_key'            => '_thumbnail_id',
            'order'               => 'DESC',
        );
        if ( $orderby == 'comment' ) {
            $query_args['orderby'] = 'comment_count';
        }
        if ( $orderby == 'popular' ) {
            $query_args['orderby'] = 'meta_value_num';
        }
        if ( !empty($categories) ) {
            $query_args['tax_query'] = array(
                                            array(
                                                'taxonomy' => 'video_category',
                                                'field'    => 'term_id',
                                                'terms'    => $categories,
                                            )
                                        );
        }
        $videos = new WP_Query($query_args);

        if ( $videos->have_posts() ):
            echo $before_widget;

            if ( $title )
                echo $before_title . $title . $after_title;
                if ( ( $style == 'list_style_1' ) || ( $style == 'list_style_2' ) ) {
                    echo '<ul class="videos-list ' . $style . '">';
                } else {
                    $columns = 3;
                    $autoplay = false;
                    $slide_duration = 5000;

                    echo '<ul class="videos-list haru-carousel owl-carousel owl-theme ' . $style . '"
                            data-items="' . esc_attr($columns) .'"
                            data-margin="20"
                            data-autoplay="' . esc_attr($autoplay) . '"
                            data-slide-duration="' . esc_attr($slide_duration) . '">';
                }
                while ( $videos->have_posts() ) : 
                    $videos->the_post();
                    global $post;

                    if ( ( $style == 'list_style_1' ) || ( $style == 'list_style_2' ) ) {
                        echo '<li class="clearfix">';
                            echo '<div class="video-image">';
                            echo    '<a href="' . esc_url(get_the_permalink()) .'">' . get_the_post_thumbnail( null, 'thumbnail', array( 'title' => strip_tags( get_the_title() ) ) ) . '</a>';
                            echo '</div>';
                            echo '<div class="video-content">';
                            echo    '<h6 class="video-title"><a href="' . esc_url(get_the_permalink()) . '" title="' . esc_attr(get_the_title()) .'">' . get_the_title() . '</a></h6>';
                                echo '<div class="video-meta">';
                                    echo '<span class="author vcard"><i class="ion-ios-person"></i>' . '<a href="'. esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) .'">'. esc_html( get_the_author() ) .'</a>' . '</span>';
                                    echo '<span class="datetime"><i class="ion-ios-calendar"></i>' . date_i18n( 'd M, Y', strtotime(get_the_date('Y-m-d')) ) . '</span>';
                                    // Comment
                                    $output = '';
                                    $number = get_comments_number( $post->ID );
                                    if ( $number > 1 ) {
                                        $output = str_replace( '%', number_format_i18n( $number ), ( false === false ) ? esc_html__( '%', 'haru-circle' ) : false );
                                    } elseif ( $number == 0 ) {
                                        $output = ( false === false ) ? esc_html__( '0', 'haru-circle' ) : false;
                                    } else { // must be one
                                        $output = ( false === false ) ? esc_html__( '1', 'haru-circle' ) : false;
                                    }
                                    echo '<span class="comment-count"><i class="ion-ios-chatboxes"></i><a href="' . esc_url( get_comments_link() ) . '">' . $output . '</a></span>';
                                echo '</div>';
                            echo '</div>';
                        echo '</li>';
                    } else {
                        echo '<li class="clearfix">';
                            echo '<div class="video-image">';
                            echo    '<a href="' . esc_url(get_the_permalink()) .'">' . get_the_post_thumbnail( null, 'full', array( 'title' => strip_tags( get_the_title() ) ) ) . '</a>';
                            echo '</div>';
                            echo '<div class="video-content">';
                            echo    '<h6 class="video-title"><a href="' . esc_url(get_the_permalink()) . '" title="' . esc_attr(get_the_title()) .'">' . get_the_title() . '</a></h6>';
                                echo '<div class="video-meta">';
                                    echo '<span class="author vcard"><i class="ion-ios-person"></i>' . '<a href="'. esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) .'">'. esc_html( get_the_author() ) .'</a>' . '</span>';
                                    echo '<span class="datetime"><i class="ion-ios-calendar"></i>' . date_i18n( 'd M, Y', strtotime(get_the_date('Y-m-d')) ) . '</span>';
                                echo '</div>';
                            echo '</div>';
                        echo '</li>';
                    }
                endwhile;
                echo  '</ul>';

            echo $after_widget;
        endif;

        $content = ob_get_clean();
        wp_reset_postdata();
        echo $content;
    }
    
}
if (!function_exists('haru_register_widget_circle_videos')) {
    function haru_register_widget_circle_videos() {
        register_widget('Haru_Circle_Videos_Widget');
    }
    add_action('widgets_init', 'haru_register_widget_circle_videos');
}
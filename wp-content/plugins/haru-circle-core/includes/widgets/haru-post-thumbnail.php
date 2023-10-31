<?php
/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

class Haru_Post_Thumbnail_Widget extends Haru_Widget {

	public function __construct() {
		$this->widget_cssclass    = 'widget-post-thumbnail';
		$this->widget_description = esc_html__( 'Widget post with thumbnail.', 'haru-circle' );
		$this->widget_id          = 'haru_widget_post_thumbnail';
		$this->widget_name        = esc_html__( 'Haru Post Thumbnail', 'haru-circle' );
		$this->cached             = false;
		$categories               = array();
		$categories               = get_categories( array(
										'orderby' => 'NAME',
										'order'   => 'ASC'
									));
		$categories_options = array();
		foreach ( $categories as $category ) {
			$categories_options[$category->term_id] = $category->name;
		}
		$this->settings = array(
			'title'  => array(
				'type'  => 'text',
				'std'	=>'',
				'label' => esc_html__( 'Title', 'haru-circle' )
			),
			'style' => array(
				'type'    => 'select',
				'std'     => '',
				'label'   => esc_html__( 'Style', 'haru-circle' ),
				'options' => array(
                    'thumb_left' => esc_html__( 'Thumbnail Left', 'haru-circle' ),
                    'thumb_full' => esc_html__( 'Thumbnail Full-width', 'haru-circle' ),
                    'date'       => esc_html__( 'Date Label', 'haru-circle' )
				)
			),
			'posts_per_page' => array(
				'type'  => 'number',
				'step'  => 1,
				'min'   => 1,
				'max'   => '',
				'std'   => 5,
				'label' => esc_html__( 'Number of posts to show', 'haru-circle' )
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
			'categories' => array(
				'type'     => 'select',
				'std'      => array(),
				'multiple' => '1',
				'label'    =>esc_html__( 'Categories', 'haru-circle' ),
				'desc'     => esc_html__( 'Select a category or leave blank for all', 'haru-circle' ),
				'options'  => $categories_options,
			),
			'hide_author' => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => esc_html__( 'Hide author in post meta info', 'haru-circle' )
			),
			'hide_date' => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => esc_html__( 'Hide date in post meta info', 'haru-circle' )
			),
			'hide_comment' => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => esc_html__( 'Hide comment in post meta info', 'haru-circle' )
				),
		);
		parent::__construct();
	}
	
	public function widget($args, $instance) {
		ob_start();
		extract( $args );
		$title          = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$posts_per_page = absint( $instance['posts_per_page'] );
		$orderby        = sanitize_title( $instance['orderby'] );
		$hide_date      = isset($instance['hide_date']) && $instance['hide_date'] === '1' ? true : false;
		$hide_author    = isset($instance['hide_author']) && $instance['hide_author'] === '1' ? true : false;
		$hide_comment   = isset($instance['hide_comment']) && $instance['hide_comment'] === '1' ? true : false;
		$categories     = $instance['categories'];
		$style          = $instance['style'];
		$query_args     = array(
			'posts_per_page'      => $posts_per_page,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'orderby'             => 'date',
			"meta_key"            => "_thumbnail_id",
			'order'               => 'DESC',
		);
		if ( $orderby == 'comment' ) {
			$query_args['orderby'] = 'comment_count';
		}
		if ( $orderby == 'popular' ) {
			$query_args['orderby'] = 'meta_value_num';
		}
		if ( !empty($categories) ) {
			$query_args['cat'] = $categories;
		}
		$r = new WP_Query($query_args);
		if ( $r->have_posts() ):
			echo $before_widget;
			if ( $title )
				echo $before_title . $title . $after_title;
				echo '<ul class="posts-thumbnail-list '.$style.'">';
				while ($r->have_posts()): 
					$r->the_post();
					global $post;
					$time = get_the_date('d F');
					$time = explode(' ', $time);
					echo '<li class="clearfix">';
					if ( $style == 'date' ) :
                        echo '<div class="posts-date">';
                        echo    '<div class="datetime">';
                        echo        '<span>' . date_i18n( 'd', strtotime(get_the_date('Y-m-d')) ) . '</span>';
                        echo        '<span>' . date_i18n( 'M', strtotime(get_the_date('Y-m-d')) ) . '</span>';
                        echo    '</div>'; 
                        echo '</div>';
                        else:
                        echo '<div class="posts-thumbnail-image">';
                        echo '<a href="' . esc_url(get_the_permalink()) .'">' . get_the_post_thumbnail( null, 'thumbnail', array( 'title' => strip_tags( get_the_title() ) ) ) . '</a>';
                        echo '</div>';
                    endif;
					echo '<div class="posts-thumbnail-content">';
                        echo '<div class="posts-thumbnail-meta">';
                        if ( !$hide_author )
                            echo '<span class="author vcard">' . get_the_author() . '</span>';
                        if ( !$hide_date )
                            echo '<span class="datetime">' . date_i18n( 'd M, Y', strtotime(get_the_date('Y-m-d')) ) . '</span>';
                        
                        if ( !$hide_date && !$hide_comment )
                            echo ' ';

                        if ( !$hide_comment ) {
                            $output = '';
                            $number = get_comments_number( $post->ID );
                            if ( $number > 1 ) {
                                $output = str_replace( '%', number_format_i18n( $number ), ( false === false ) ? esc_html__( '%', 'haru-circle' ) : false );
                            } elseif ( $number == 0 ) {
                                $output = ( false === false ) ? esc_html__( '0', 'haru-circle' ) : false;
                            } else { // must be one
                                $output = ( false === false ) ? esc_html__( '1', 'haru-circle' ) : false;
                            }
                            echo '<span class="comment-count"><i class="fa fa-comments-o"></i><a href="'.esc_url(get_comments_link()) . '">' . $output . '</a></span>';   
                        }
                        echo '</div>';
                        echo '<h4><a href="' . esc_url(get_the_permalink()) . '" title="' . esc_attr(get_the_title()) .'">' . get_the_title() . '</a></h4>';
                    echo '</div>';
					echo '</li>';
				endwhile;
				echo  '</ul>';
			echo $after_widget;
		endif;
		$content = ob_get_clean();
		wp_reset_postdata();
		echo $content;
	}
	
}
if ( !function_exists('haru_register_widget_post_thumbnail') ) {
	function haru_register_widget_post_thumbnail() {
		register_widget( 'Haru_Post_Thumbnail_Widget' );
	}
	add_action( 'widgets_init', 'haru_register_widget_post_thumbnail' );
}
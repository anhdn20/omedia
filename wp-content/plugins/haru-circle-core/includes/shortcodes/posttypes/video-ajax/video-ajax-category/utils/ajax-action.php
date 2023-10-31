<?php
/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

add_action( 'wp_ajax_haru_get_video_ajax', 'haru_get_video_ajax' );
add_action( 'wp_ajax_nopriv_haru_get_video_ajax', 'haru_get_video_ajax' );
add_action( 'wp_ajax_haru_video_ajax_loadmore', 'haru_video_ajax_loadmore' );
add_action( 'wp_ajax_nopriv_haru_video_ajax_loadmore', 'haru_video_ajax_loadmore' );


if( !function_exists('haru_get_video_ajax') ) {
	function haru_get_video_ajax( $atts ) {
		if( empty($_POST['atts']) || empty($_POST['category']) ) {
			die('0');
		}
		$atts        	= $_POST['atts'];
		$category 		= $_POST['category'];
		$is_filter_all  = (isset($_POST['is_filter_all']) && $_POST['is_filter_all']) ? true : false;

		ob_start();
		extract($atts);

		$args = array(
	        'posts_per_page' => $posts_per_page, // -1 is Unlimited video
	        'orderby'        => $orderby,
	        'order'          => $order,
	        'post_type'      => 'haru_video',
	        // 'paged'          => $paged,
	        'post_status'    => 'publish',
	        'tax_query'      => array(
	            array(
	                'taxonomy' => 'video_category',
	                'field'    => 'slug',
	                'terms'    => explode(',', $category),
	            )
	        )
	    );

	    if ( $is_filter_all == true ) {
	    	$args['tax_query'] = array(
	            array(
	                'taxonomy' => 'video_category',
	                'field'    => 'slug',
	                'terms'    => explode(',', $categories),
	            )
	        );
	    }
		
		$videos = new WP_Query( $args );

		// Add class if layout_type is carousel
		// $slider_class = '';
		// if ( $atts['layout_type'] == 'slider' ) {
		// 	$slider_class = ' owl-carousel owl-theme';
		// }

		// echo '<ul class="videos columns-'. $atts['columns'] . $slider_class .' clearfix ">';
		echo '<div class="videos">';

		if ( $videos->have_posts() ) {	
			while( $videos->have_posts() ) { 
				$videos->the_post();
          		echo haru_get_template('posttypes/video-ajax/video-style/'. $video_style .'.php', '', '', '' );
			}
		}

		echo '</div>';

    if ( ( $videos->max_num_pages > 1 ) && ( $paging_style != 'none' ) ) : ?>
      <div class="videos-ajax-paging <?php echo esc_attr( $paging_style ); ?>">
        <button
        	data-current_page="1"
	      	data-category="<?php echo ($is_filter_all == true) ? $categories : $category; ?>"
	      	data-atts="<?php echo htmlentities( json_encode($atts) ); ?>"
        	type="button"
        	data-loading-text="<span class='fa fa-spinner fa-spin'></span> <?php esc_html_e( 'Loading...','haru-circle' ); ?>" 
        	class="video-ajax-load-more"
      	>
          <?php echo esc_html__( 'View More', 'haru-circle' ); ?>
        </button>
      </div>
    <?php endif;

		wp_reset_postdata();
		
		die(ob_get_clean());
	}
}

// Load More
if( !function_exists('haru_video_ajax_loadmore') ) {
	function haru_video_ajax_loadmore( $atts ) {
		if( empty($_POST['atts']) || empty($_POST['category']) ) {
			die('0');
		}
		$atts        	= $_POST['atts'];
		$category 		= $_POST['category'];
		$current_page 	= $_POST['current_page'];
		$is_filter_all  = (isset($_POST['category']) && $_POST['category'] == '*') ? true : false;

		if ( is_front_page() ) {
            $paged   = get_query_var( 'page' ) ? intval( get_query_var( 'page' ) ) : 1;
        } else {
            $paged   = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
        } 

		ob_start();

		extract($atts);

		$offset = $current_page * $posts_per_page;

		$args = array(
	        'posts_per_page' => $posts_per_page, // -1 is Unlimited video
	        'orderby'        => $orderby,
	        'order'          => $order,
	        'post_type'      => 'haru_video',
	        'offset'         => $offset,
	        'paged'          => $paged,
	        'post_status'    => 'publish',
	        'tax_query'      => array(
	            array(
	                'taxonomy' => 'video_category',
	                'field'    => 'slug',
	                'terms'    => explode(',', $category),
	            )
	        )
	    );

	    if ( $is_filter_all == true ) {
	    	$args['tax_query'] = array(
	            array(
	                'taxonomy' => 'video_category',
	                'field'    => 'slug',
	                'terms'    => explode(',', $categories),
	            )
	        );
	    }
		
		$videos = new WP_Query( $args );

		echo '<div class="videos">';

		if ( $videos->have_posts() ) {	
			while( $videos->have_posts() ) { 
				$videos->the_post();
         		echo haru_get_template('posttypes/video-ajax/video-style/'. $video_style .'.php', '', '', '' );
			}
		}

		// Element must be inside div to make .find() work
		if ( ( $videos->max_num_pages > 1 ) && ($videos->max_num_pages > ($current_page + 1) ) && ( $paging_style != 'none' ) ) : ?>
	      	<div class="videos-ajax-paging <?php echo esc_attr( $paging_style ); ?>">
		        <button
		        	data-current_page="<?php echo esc_attr( $current_page + 1 ); ?>"
			      	data-category="<?php echo ($is_filter_all == true) ? $categories : $category; ?>"
			      	data-atts="<?php echo htmlentities( json_encode($atts) ); ?>"
		        	type="button"
		        	class="video-ajax-load-more"
		      	>
	          		<?php echo esc_html__( 'View More', 'haru-circle' ); ?>
	        	</button>
	      	</div>
	    <?php endif;

		echo '</div>';

		wp_reset_postdata();
		
		die(ob_get_clean());
	}
}
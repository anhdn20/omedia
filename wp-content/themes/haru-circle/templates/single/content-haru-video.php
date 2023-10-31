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
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="post-wrapper">
        <?php 
            // Docs: https://metabox.io/docs/get-meta-value/
            $video_more_info         = get_post_meta( get_the_ID(), 'haru_video' . '_more_info', true );
            $video_award             = get_post_meta( get_the_ID(), 'haru_video' . '_award', true );
            $video_director_ids      = get_post_meta( get_the_ID(), 'haru_video' . '_director', false ); // Array
            
            $video_actor_ids         = get_post_meta( get_the_ID(), 'haru_video' . '_actor', false ); // Array
            
            $video_partner_title     = get_post_meta( get_the_ID(), 'haru_video' . '_partner_title', true );
            $video_partner_sub_title = get_post_meta( get_the_ID(), 'haru_video' . '_partner_sub_title', true );
            $video_partner_images    = get_post_meta( get_the_ID(), 'haru_video' . '_partner_images', false ); // Array
            
            $video_gallery_title     = get_post_meta( get_the_ID(), 'haru_video' . '_gallery_title', true );
            $video_gallery_sub_title = get_post_meta( get_the_ID(), 'haru_video' . '_gallery_sub_title', true );
            $video_gallery_images    = get_post_meta( get_the_ID(), 'haru_video' . '_gallery_images', false ); // Array
            
            $video_crew_link         = get_post_meta( get_the_ID(), 'haru_video' . '_crew_link', true );
            $video_hire_link         = get_post_meta( get_the_ID(), 'haru_video' . '_hire_link', true );

        ?>
        <!-- Single Video Top -->
        <div class="single-video-top">
            <div class="container">
                <div class="video-meta">
                    <span class="video-views"><i class="ion-ios-eye"></i><?php echo haru_count_post_views( get_the_ID() ); ?></span>
                    <?php if ( comments_open() ) : ?>
                        <span class="meta-comment">
                            <i class="ion-ios-chatbubbles"></i>
                            <?php 
                                $num_comments = get_comments_number();
                                if ( $num_comments == 0 ) {
                                    $comments = esc_html__( 'No Comments', 'haru-circle' );
                                } elseif ( $num_comments > 1 ) {
                                    $comments = $num_comments . esc_html__( ' Comments', 'haru-circle' );
                                } else {
                                    $comments = esc_html__( '1 Comment', 'haru-circle' );
                                }
                                printf('<a href="%1$s">%2$s</a>', esc_url( get_comments_link() ), $comments ); ?>
                        </span>
                    <?php endif; ?>
                    <span class="video-category"><i class="ion-ios-folder"></i><?php echo get_the_term_list( get_the_ID(), 'video_category', '', ', ' ); ?></span>
                </div>
                <div class="video-navigation">
                    <?php
                        previous_post_link('<div class="nav-links nav-previous">%link</div>', _x('<div class="post-navigation-left"><span class="link-prev">Previous</span></div> <div class="post-navigation-content"><i class="ion-ios-arrow-back"></i> <div class="post-navigation-title">%title </div> </div> ', 'Previous post link', 'haru-circle'));
                        next_post_link('<div class="nav-links nav-next">%link</div>', _x('<div class="post-navigation-right"><span class="link-next">Next</span> </div><div class="post-navigation-content"><div class="post-navigation-title">%title</div> <i class="ion-ios-arrow-forward"></i></div>', 'Next post link', 'haru-circle'));
                    ?>
                </div>
            </div>
        </div>
        <!-- Single Video Main Content -->
        <div class="single-video-main">
            <div class="container">
                <?php
                    $player_type = haru_get_option('player_type');
                    $player_js = haru_get_option('player_js');
                    $video_server     = get_post_meta( get_the_ID(), 'haru_video' . '_server', true );
                    if ( $player_type == 'player_popup' ) :
                ?>
                <div class="video-image">
                    <?php the_post_thumbnail(); ?>
                    <div class="video-icon"><a href="javascript:;" class="view-video-button" data-id="<?php echo esc_attr( the_ID() ); ?>" data-player="<?php echo esc_attr( $player_js ); ?>" data-server="<?php echo esc_attr( $video_server ); ?>"></a></div>
                </div>
                <?php else : ?>
                <div class="video-image player-direct">
                    <?php the_post_thumbnail(); ?>
                    <div class="video-icon"><a href="javascript:;" class="video-player-direct" data-id="<?php echo esc_attr( the_ID() ); ?>" data-player="<?php echo esc_attr( $player_js ); ?>" data-server="<?php echo esc_attr( $video_server ); ?>"></a></div>
                    <?php get_template_part('templates/single/video-player-direct'); ?>
                </div>
                <?php endif; ?>

                <div class="video-content">
                    <div class="row">
                        <div class="col-md-12">
                            <?php get_template_part('templates/single/social-share'); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <div class="video-information">
                                <?php if ( $video_more_info ) : ?>
                                <?php foreach( $video_more_info as $more_info ) : ?>
                                <div class="more-info">
                                    <h6 class="info-label"><?php echo esc_html( $more_info['0'] ); ?></h6>
                                    <div class="info-value"><?php echo wp_kses_post( $more_info['1'] ); ?></div>
                                </div>
                                <?php endforeach; ?>
                                <?php endif; ?>

                                <?php if ( isset($video_director_ids) && !empty($video_director_ids) ) : ?>
                                <div class="video-director">
                                    <h6><?php echo esc_html__( 'Director', 'haru-circle' ); ?></h6>
                                    <div class="director-list">
                                        <?php foreach( $video_director_ids as $video_director_id) : // Can change to false get_post_meta for shorter code
                                            $video_director      = get_post( $video_director_id );
                                            $video_director_link = get_post_permalink( $video_director_id );
                                        ?>
                                        <a href="<?php echo esc_url($video_director_link); ?>"><?php echo esc_html($video_director->post_title); ?></a>
                                        <?php if ( $video_director_id != end( $video_director_ids ) ) : ?>
                                        <span>,</span>
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if ( isset($video_actor_ids) && !empty($video_actor_ids) ) : ?>
                                <div class="video-actor">
                                    <h6><?php echo esc_html__( 'Actor', 'haru-circle' ); ?></h6>
                                    <div class="actor-list">
                                        <?php foreach( $video_actor_ids as $video_actor_id) : // Can change to false get_post_meta for shorter code
                                            $video_actor      = get_post( $video_actor_id );
                                            $video_actor_link = get_post_permalink( $video_actor_id );
                                        ?>
                                        <a href="<?php echo esc_url($video_actor_link); ?>"><?php echo esc_html($video_actor->post_title); ?></a>
                                        <?php if ( $video_actor_id != end( $video_actor_ids ) ) : ?>
                                        <span>,</span>
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-8 col-sm-8 video-description">
                            <div class="description-detail">
                                <div class="video-story">
                                    <h3 class="description-title"><?php echo esc_html__( 'Film Story', 'haru-circle' ); ?></h3>
                                    <?php the_content(); ?>
                                </div>
                                <?php if ( isset($video_award) && !empty($video_award) ) : ?>
                                <div class="video-award">
                                    <h3 class="description-title"><?php echo esc_html__( 'Award', 'haru-circle' ); ?></h3>
                                    <ul class="award-list">
                                        <?php foreach( $video_award as $award ) : ?>
                                        <li><?php echo esc_html( $award ); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- SINGLE VIDEO BOTTOM -->
        <div class="single-video-bottom">
            <?php if ( isset($video_partner_images) && !empty($video_partner_images) ) : ?>
            <div class="container">
                <div class="video-partner">
                    <div class="partner-heading">
                        <h3 class="partner-title"><?php echo esc_html( $video_partner_title ); ?></h3>
                        <div class="partner-sub-title"><?php echo esc_html( $video_partner_sub_title ); ?></div>
                        <div class="haru-carousel partner-list owl-carousel owl-theme"
                            data-items="6"
                            data-margin="20"
                            data-autoplay="false"
                            data-slide-duration="5000"
                        >
                            <?php foreach( $video_partner_images as $video_partner_image ) : 
                                $image_src = wp_get_attachment_url( $video_partner_image );
                            ?>
                            <div class="partner-item">
                                <img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr( $video_partner_title ); ?>">
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php if ( isset($video_gallery_images) && !empty($video_gallery_images) ) : ?>
            <div class="container">
                <div class="gallery-heading">
                    <h3 class="gallery-title"><?php echo esc_html( $video_gallery_title ); ?></h3>
                    <div class="gallery-sub-title"><?php echo esc_html( $video_gallery_sub_title ); ?></div>
                </div>
            </div>
            <div class="video-gallery">
                <div class="container">
                    <div class="video-images clearfix">
                        <?php foreach( $video_gallery_images as $video_gallery_image ) : 
                            $image_src = wp_get_attachment_url( $video_gallery_image );
                        ?>
                        <div class="image-item">
                            <img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr( $video_gallery_title ); ?>">
                            <a class="single-gallery-popup" href="<?php echo esc_url($image_src); ?>"><i class="ion-ios-add"></i><?php echo esc_html__( 'View More', 'haru-circle' ); ?></a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="link-to-pages">
                        <?php if ( $video_crew_link != '' ) : ?>
                        <a class="crew-link" href="<?php echo esc_url( get_permalink( $video_crew_link ) ); ?>" target="_self"><?php echo esc_html__( 'View Crew', 'haru-circle' ); ?></a>
                        <?php endif; ?>
                        <?php if ( $video_hire_link != '' ) : ?>
                        <a class="hire-link" href="<?php echo esc_url( get_permalink( $video_hire_link ) ); ?>" target="_self"><?php echo esc_html__( 'Hire Us Now', 'haru-circle' ); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="single-video-comment">
            <div class="container">
            <?php comments_template(); ?>
            </div>
        </div>
        
        <?php 
            // Get video related by category
            $custom_taxterms = wp_get_object_terms( get_the_ID(), 'video_category', array('fields' => 'ids') );

            $args = array(
                'post__not_in'       => array( get_the_ID() ),
                'posts_per_page'     => 3,
                'orderby'            => 'rand',
                'post_type'          => 'haru_video',
                'post_status'        => 'publish',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'video_category',
                        'field' => 'id',
                        'terms' => $custom_taxterms
                    )
                ),

            );
            $related_videos         = new WP_Query( $args );
        ?>
        <?php if ( $related_videos->have_posts() ) : ?>
        <div class="single-video-related">
            <div class="container">
                <h3 class="realated-title"><?php echo esc_html__( 'You may also like this', 'haru-circle' ); ?></h3>
                <div class="haru-carousel related-list owl-carousel owl-theme"
                    data-items="3"
                    data-margin="20"
                    data-autoplay="false"
                    data-slide-duration="5000"
                >
                    <?php while ( $related_videos->have_posts() ) : $related_videos->the_post(); ?>
                        <div class="video-related">
                            <div class="video-image">
                                <?php the_post_thumbnail(); ?>
                            </div>
                            <div class="video-meta">
                                <h5 class="video-title"><a href="<?php echo esc_url( get_the_permalink() ); ?>" target="_self"><?php the_title(); ?></a></h5>
                                <?php echo get_the_term_list( get_the_ID(), 'video_category', '', ', ' ); ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
        <?php
            endif;
            wp_reset_query();
        ?>
    </div>
</article>
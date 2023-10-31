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
            $actor_info              = get_post_meta( get_the_ID(), 'haru_actor' . '_info', true );
            $actor_award             = get_post_meta( get_the_ID(), 'haru_actor' . '_award', true );
            $actor_social            = get_post_meta( get_the_ID(), 'haru_actor' . '_social', true );
            $actor_film              = get_post_meta( get_the_ID(), 'haru_actor' . '_film', true );
            $actor_video             = get_post_meta( get_the_ID(), 'haru_actor' . '_video', false );
            
            $actor_gallery_title     = get_post_meta( get_the_ID(), 'haru_actor' . '_gallery_title', true );
            $actor_gallery_sub_title = get_post_meta( get_the_ID(), 'haru_actor' . '_gallery_sub_title', true );
            $actor_gallery_images    = get_post_meta( get_the_ID(), 'haru_actor' . '_gallery_images', false ); // Array
            
            $actor_crew_link         = get_post_meta( get_the_ID(), 'haru_actor' . '_crew_link', true );
            $actor_hire_link         = get_post_meta( get_the_ID(), 'haru_actor' . '_hire_link', true );

        ?>
        <!-- Single Actor Top -->
        <div class="single-actor-top">
            <div class="container">
                <div class="actor-meta">
                    <span class="actor-views"><i class="ion-ios-eye"></i><?php echo haru_count_post_views( get_the_ID() ); ?></span>
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
                    <span class="actor-category"><i class="ion-ios-folder"></i><?php echo get_the_term_list( get_the_ID(), 'actor_category', '', ', ' ); ?></span>
                </div>
                <div class="actor-navigation">
                    <?php
                        previous_post_link('<div class="nav-links nav-previous">%link</div>', _x('<div class="post-navigation-left"><span class="link-prev">Previous</span></div> <div class="post-navigation-content"><i class="ion-ios-arrow-back"></i> <div class="post-navigation-title">%title </div> </div> ', 'Previous post link', 'haru-circle'));
                        next_post_link('<div class="nav-links nav-next">%link</div>', _x('<div class="post-navigation-right"><span class="link-next">Next</span> </div><div class="post-navigation-content"><div class="post-navigation-title">%title</div> <i class="ion-ios-arrow-forward"></i></div>', 'Next post link', 'haru-circle'));
                    ?>
                </div>
            </div>
        </div>
        <!-- Single Actor Main Content -->
        <div class="single-actor-main">
            <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <div class="actor-image">
                                <?php the_post_thumbnail(); ?>
                            </div>
                        </div>
                        <div class="col-md-8 col-sm-8">
                            <div class="actor-heading">
                                <h3 class="actor-title"><?php the_title(); ?></h3>
                            </div>
                            <?php if ( isset($actor_info) && !empty($actor_info) ) : ?>
                            <div class="actor-information">
                                <?php foreach( $actor_info as $info ) : ?>
                                <div class="actor-info">
                                    <h6 class="info-label"><?php echo esc_html( $info['0'] ); ?></h6>
                                    <div class="info-value"><?php echo wp_kses_post( $info['1'] ); ?></div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                            <ul class="actor-social">
                                <?php foreach( $actor_social as $social ) : ?>
                                    <?php if ( $social['url'] != '' ) : ?>
                                    <li><a href="<?php echo esc_url( $social['url'] ); ?>" target="_blank" title="<?php echo esc_attr( $social['network'] ); ?>"><i class="<?php echo esc_attr( $social['icon'] ); ?>"></i></a></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <div class="actor-content">
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <div class="actor-award">
                                <h3 class="award-title"><?php echo esc_html__( 'Award', 'haru-circle' ); ?></h3>
                                <?php if ( isset($actor_award) && !empty($actor_award) ) : ?>
                                <ul class="award-list">
                                    <?php foreach( $actor_award as $award ) : ?>
                                    <li><span class="award-label"><?php echo esc_html( $award['date'] ); ?></span><?php echo wp_kses_post( $award['information'] ); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <?php endif; ?>
                            </div>
                            <div class="actor-film">
                                <h3 class="film-title"><?php echo esc_html__( 'Filmography', 'haru-circle' ); ?></h3>
                                <ul class="film-list">
                                    <?php foreach( $actor_film as $film ) : ?>
                                    <li><span class="film-year"><?php echo esc_html( $film['date'] ); ?></span><?php echo wp_kses_post( $film['information'] ); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-8 col-sm-8 actor-description">
                            <div class="description-detail">
                                <div class="actor-story">
                                    <h3 class="description-title"><?php echo esc_html( 'Actor Story', 'haru-circle' ); ?></h3>
                                    <?php the_content(); ?>
                                </div>
                            </div>
                            <div class="actor-share">
                                <?php get_template_part('templates/single/social-share'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- SINGLE ACTOR BOTTOM -->
        <?php if ( isset($actor_gallery_images) && !empty($actor_gallery_images) ) : ?>
        <div class="single-actor-bottom">
            <div class="container">
                <div class="gallery-heading">
                    <h3 class="gallery-title"><?php echo esc_html( $actor_gallery_title ); ?></h3>
                    <div class="gallery-sub-title"><?php echo esc_html( $actor_gallery_sub_title ); ?></div>
                </div>
            </div>
            <div class="actor-gallery">
                <div class="container">
                    <div class="actor-images clearfix">
                        <?php 
                        foreach( $actor_gallery_images as $actor_gallery_image ) : 
                            $image_src = wp_get_attachment_url( $actor_gallery_image );
                        ?>
                        <div class="image-item">
                            <img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr( $actor_gallery_title ); ?>">
                            <a class="single-gallery-popup" href="<?php echo esc_url($image_src); ?>"><i class="ion-ios-add"></i><?php echo esc_html__( 'View More', 'haru-circle' ); ?></a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
            </div>
        </div>
        <?php endif; ?>
        <div class="single-actor-comment">
            <div class="container">
            <?php comments_template(); ?>
            </div>
        </div>
    
        <?php 
            $args = array(
                'post__in'       => $actor_video,
                'posts_per_page' => -1,
                'orderby'        => 'rand',
                'post_type'      => 'haru_video',
                'post_status'    => 'publish',
            );
            $related_actors         = new WP_Query( $args );
        ?>
        <?php if ( isset($actor_video) && !empty($actor_video) ) : ?>
        <div class="single-actor-video">
            <div class="container">
                <h3 class="my-video-title"><?php echo esc_html__( 'My Featured Videos', 'haru-circle' ); ?></h3>
                <div class="haru-carousel video-list owl-carousel owl-theme"
                    data-items="3"
                    data-margin="20"
                    data-autoplay="false"
                    data-slide-duration="5000"
                >
                    <?php 
                        if ( $related_actors->have_posts() ) :
                            while ( $related_actors->have_posts() ) : $related_actors->the_post();
                    ?>
                        <div class="video-featured">
                            <div class="video-image">
                                <?php the_post_thumbnail(); ?>
                            </div>
                            <div class="video-meta">
                                <h5 class="video-title"><a href="<?php echo esc_url( get_the_permalink() ); ?>" target="_self"><?php the_title(); ?></a></h5>
                                <div class="video-category">
                                    <?php echo get_the_term_list( get_the_ID(), 'video_category', '', ', ' ); ?>
                                </div>
                            </div>
                        </div>
                    <?php 
                            endwhile;
                        endif;
                        wp_reset_query();
                    ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</article>
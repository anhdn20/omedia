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
            $digitalasset_thumbnail_video   = get_post_meta( get_the_ID(), 'haru_digitalasset' . '_thumbnail_video', true );
            // $digitalasset_thumbnail_image   = get_post_meta( get_the_ID(), 'haru_digitalasset' . '_thumbnail_images', true );
            $digitalasset_price             = get_post_meta( get_the_ID(), 'haru_digitalasset' . '_price', true );
            $digitalasset_opv               = get_post_meta( get_the_ID(), 'haru_digitalasset' . '_opv', true );
            $digitalasset_url_find_out_more = get_post_meta( get_the_ID(), 'haru_digitalasset' . '_url_find_out_more', true );
            // $digitalasset_director_isd      = get_post_meta( get_the_ID(), 'haru_digitalasset' . '_director', false ); // Array
        ?>
        <!-- Single Video Top -->
        <!-- <div class="single-digitalasset-top">
            <div class="container">
                <div class="digitalasset-meta">
                    <span class="digitalasset-views"><i class="ion-ios-eye"></i><?php echo haru_count_post_views( get_the_ID() ); ?></span>
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
                    <span class="digitalasset-category"><i class="ion-ios-folder"></i><?php echo get_the_term_list( get_the_ID(), 'digitalasset_category', '', ', ' ); ?></span>
                </div>
                <div class="digitalasset-navigation">
                    <?php
                        previous_post_link('<div class="nav-links nav-previous">%link</div>', _x('<div class="post-navigation-left"><span class="link-prev">Previous</span></div> <div class="post-navigation-content"><i class="ion-ios-arrow-back"></i> <div class="post-navigation-title">%title </div> </div> ', 'Previous post link', 'haru-circle'));
                        next_post_link('<div class="nav-links nav-next">%link</div>', _x('<div class="post-navigation-right"><span class="link-next">Next</span> </div><div class="post-navigation-content"><div class="post-navigation-title">%title</div> <i class="ion-ios-arrow-forward"></i></div>', 'Next post link', 'haru-circle'));
                    ?>
                </div>
            </div>
        </div> -->
        <!-- Single Video Main Content -->
        <div class="single-digitalasset-main">
            <div class="container">
                <div class="digitalasset-content">
                    <div class="row">
                        <div class="col-md-12">
                            <?php get_template_part('templates/single/social-share'); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 dgtass-item">
                            <div class="dgtass-thumbnail">
                                <?php if($digitalasset_thumbnail_video == '') : ?>
                                    <div class="dgtass-thumbnail-image">
                                        <picture>
                                            <?php
                                                $digitalasset_thumbnail_image = get_post_meta( get_the_ID(), 'haru_digitalasset' . '_thumbnail_images', true );
                                            ?>
                                            <source media="(min-width: 900px)" srcset="<?=$digitalasset_thumbnail_image?>">
                                            <source media="(max-width: 480px)" srcset="<?=$digitalasset_thumbnail_image?>">
                                            <img src="<?=$digitalasset_thumbnail_image?>" alt="<?php echo esc_attr( get_the_title( get_the_ID() ) ); ?>">
                                        </picture>
                                    </div>
                                <?php else: ?>
                                    <div class="dgtass-thumbnail-video">
                                        <video src="<?php echo $digitalasset_thumbnail_video;?>" title="<?php echo esc_attr( get_the_title( get_the_ID() ) ); ?>" muted="muted">
                                            <source src="<?php echo $digitalasset_thumbnail_video;?>" type="video/mp4">
                                        </video>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 digitalasset-description">
                            <div class="digitalasset-detail">
                                <h3 class="digitalasset-title"><?php the_title(); ?></h3>
                                <div class="digitalasset-author">
                                    <h5>By <?php echo get_the_author(); ?></h5>
                                </div>
                                <?php if($digitalasset_price != '' && $digitalasset_price != null): ?>
                                    <div class="digitalasset-price">
                                        <p><?=__('Price')?></p>
                                        <span><?php echo $digitalasset_price ?></span>
                                        <?php if($digitalasset_opv != '' && $digitalasset_opv != null): ?>
                                            <span> | </span>
                                            <span><?=$digitalasset_opv?></span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                <div class="digitalasset-des">
                                    <?php the_content(); ?>
                                </div>
                                <div class="digitalasset-find-more">
                                    <a href="<?=$digitalasset_url_find_out_more?>" target="blank"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- SINGLE VIDEO BOTTOM -->
        <!-- <div class="single-video-bottom">
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
        </div> -->
        
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
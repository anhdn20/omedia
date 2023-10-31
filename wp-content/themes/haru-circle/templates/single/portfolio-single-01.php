<?php
/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

global $post;
 
$meta_values = get_post_meta( get_the_ID(), 'haru_portfolio_data_format_gallery', false );
$imgThumbs   = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'full');
$team_member = get_post_meta(get_the_ID(), 'haru_portfolio_team_member', true);

$categories  = get_the_terms(get_the_ID(), 'portfolio_category');  
$cat         = '';
if( $categories ) {
    foreach( $categories as $category ) {
        $cat .= $category->name.' / ';
    }
    $cat = rtrim($cat, ' / ');
}

// Get portfolio single tags
$tags     = wp_get_object_terms(get_the_ID(), 'portfolio_tag');
$tag      = '';
if ( $tags ) {
    foreach( $tags as $t ) {
        $tag .= $t->name.' / ';
    }
    $tag = rtrim($tag, ' / ');
}

$portfolio_type = get_post_meta(get_the_ID(), 'haru_portfolio_media_type', true);
// Assets
wp_enqueue_style( 'slick', get_template_directory_uri() . '/assets/libraries/slick/slick.css', array(), false );
wp_enqueue_script( 'slick', get_template_directory_uri() . '/assets/libraries/slick/slick.min.js', false, true );
?>
<div class="portfolio-single detail-01">
    <div class="container">
        <div class="single-top">
            <div class="portfolio-tag"><?php echo wp_kses_post($tag); ?></div>
            <h2 class="portfolio-title"><?php the_title() ?></h2>
            <div class="portfolio-meta">
                <span class="portfolio-views"><i class="ion-ios-eye"></i><?php echo haru_count_post_views( get_the_ID() ); ?></span>
                <span class="portfolio-category"><i class="ion-ios-folder"></i><?php echo wp_kses_post($cat); ?></span>
            </div>
        </div>
    </div>
    <div class="fullwidth portfolio-full">
        <?php if ( $portfolio_type == 'gallery' ) : ?>
            <div class="single-portfolio-slideshow">
                <?php if( count($imgThumbs) > 0 ) : ?>
                    <div class="slide-item">
                        <img alt="<?php the_title(); ?>" src="<?php echo esc_url($imgThumbs[0]); ?>" />
                    </div>
                <?php endif; ?>
                <?php if( count($meta_values) > 0 ) :
                    $index = 0;
                    foreach($meta_values as $image) :
                        $urls = wp_get_attachment_image_src($image,'full');
                ?>
                <div class="slide-item">
                    <img alt="<?php the_title(); ?>" src="<?php echo esc_url($urls[0]) ?>" />
                </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php else : ?>
            <div class="container">
                <div class="row portfolio-thumbnail">
                    <div class="col-md-12">
                        <!-- VIDEO TYPE -->
                        <?php if( $portfolio_type == 'video' ) : ?>
                            <?php 
                                $video = get_post_meta( get_the_ID(), 'haru_portfolio_data_format_video', true );
                                $html ='';

                                if ( $video ) {
                                    $html .= '<div class="embed-responsive embed-responsive-16by9 embed-responsive-' . '' . '">';
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
                                echo do_shortcode($html);
                            ?>
                        <?php endif; ?>

                        <!-- IMAGE TYPE -->
                        <?php if( $portfolio_type == 'image' ) : ?>
                            <?php the_post_thumbnail(); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="container">
            <div class="row portfolio-info">
                <div class="col-md-3">
                    <div class="portfolio-info-box">
                        <p class="info-title"><?php echo esc_html__( 'Client','haru-circle' ); ?> </p>
                        <p class="info-value"><?php echo esc_html( get_post_meta(get_the_ID(), 'haru_portfolio_client', true) ); ?></p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="portfolio-info-box">
                        <p class="info-title"><?php echo esc_html__( 'Date','haru-circle' ); ?> </p>
                        <p class="info-value"><?php echo date( get_option('date_format'),strtotime( get_the_date('Y-m-d') ) ) ?></p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="portfolio-info-box">
                        <p class="info-title"><?php echo esc_html__( 'My Team','haru-circle' ); ?> </p>
                        <?php foreach( $team_member as $member ) : ?>
                        <p class="info-value"><?php echo esc_html( $member ); ?></p>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="portfolio-info-box">
                        <p class="info-title"><?php echo esc_html__( 'Category','haru-circle' ); ?> </p>
                        <p class="info-value"><?php echo wp_kses_post($cat); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row portfolio-content">
            <div class="col-md-6">
                <p class="section-title"><?php echo esc_html__( 'About Project', 'haru-circle' ); ?></p>
            </div>
            <div class="col-md-6">
                <div class="portfolio-info">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
        <?php if( (NULL !== haru_get_option('portfolio_social_share')) && haru_get_option('portfolio_social_share') == '1' ) : ?>
        <div class="row portfolio-share-wrap">
            <div class="col-md-6">
                <p class="section-title"><?php echo esc_html__( 'Share Project', 'haru-circle' ); ?></p>
            </div>
            <div class="col-md-6">
                <div class="portfolio-share">
                    <?php get_template_part('templates/single/social-share'); ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <?php if( (NULL !== haru_get_option('show_portfolio_related')) && haru_get_option('show_portfolio_related') == '1' ) : ?>
    <div class="container">
        <?php get_template_part( 'templates/single/portfolio' , 'related' ); ?>
    </div>
    <?php endif; ?>
</div>
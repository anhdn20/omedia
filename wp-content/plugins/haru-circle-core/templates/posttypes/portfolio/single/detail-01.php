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

do_action('haru_before_page');

$categories  = get_the_terms(get_the_ID(), 'portfolio_category');   
$meta_values = get_post_meta( get_the_ID(), 'haru_portfolio_data_format_gallery', true );
$imgThumbs   = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'full');
$team_member = get_post_meta(get_the_ID(), 'haru_portfolio_team_member', true);

$cat         = '';
$arrCatId    = array();
if( $categories ) {
    foreach( $categories as $category ) {
        $cat                        .= '<span>'.$category->name.'</span>, ';
        $arrCatId[count($arrCatId)] = $category->term_id;
    }
    $cat = trim($cat, ', ');
}

// Get portfolio single tags
$tags     = get_the_terms(get_the_ID(), 'portfolio_tag');
$tag      = '';
$arrTagId = array();
if ( $tags ) {
    foreach( $tags as $t ) {
        $tag                        .= '<span>'.$t->name.'</span> ';
        $arrTagId[count($arrTagId)] = $t->term_id;
    }
    $tag = trim($tag, ', ');
}

$data_section_id = uniqid();
$portfolio_type = get_post_meta(get_the_ID(), 'haru_portfolio_media_type', true);

?>
<div class="portfolio-full detail-01" id="content">
    <div class="fullwidth">
        <div class="container">
            <div class="row portfolio-top">
                <div class="col-md-12">
                    <!-- VIDEO TYPE -->
                    <?php if( $portfolio_type == 'video' ) : ?>
                        <?php 
                            $video = get_post_meta( get_the_ID(), 'haru_portfolio_data_format_video', true );
                            $html ='';

                            if (count($video) > 0) {
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
                            echo($html);
                        ?>
                    <?php endif; ?>

                    <!-- IMAGE TYPE -->
                    <?php if( $portfolio_type == 'image' ) : ?>
                        <?php the_post_thumbnail(); ?>
                    <?php endif; ?>

                     <!-- GALLERY TYPE -->
                    <?php if( $portfolio_type == 'gallery' ) : ?>
                    <div class="post-slideshow" id="post_slideshow_<?php echo esc_attr($data_section_id); ?>">
                        <?php if( count($meta_values) > 0 ) :
                            $index = 0;
                            foreach($meta_values as $image) :
                                $urls = wp_get_attachment_image_src($image,'full');
                                $img  = '';
                                if(count($urls)>0) {
                                    $resize = matthewruddy_image_resize($urls[0],1080,768);
                                    if( $resize != null && is_array($resize) )
                                        $img = $resize['url'];
                                }

                        ?>
                        <div class="item">
                            <a class="nav-post-slideshow" href="javascript:;" data-section-id="<?php echo esc_attr($data_section_id) ?>" data-index="<?php echo esc_attr($index++) ?>">
                                <img alt="portfolio" src="<?php echo esc_url($img) ?>" />
                            </a>
                        </div>
                            <?php endforeach; ?>
                        <?php else : if( count($imgThumbs) > 0 ) : ?>
                            <div class="item"><img alt="portfolio" src="<?php echo esc_url($imgThumbs[0]); ?>" /></div>
                        <?php       endif;
                        endif;
                        ?>
                    </div>
                    <?php endif; ?>

                   
                </div>
            </div>
        </div>

        <?php if( $portfolio_type == 'gallery' ) : ?>
        <div class="paging-wrap">
            <div class="container">
                <div class="row">
                    <div class="slideshow-paging" data-current-index="0" data-total-items="<?php echo esc_attr(count($meta_values)) ?>" id="slideshow_paging_<?php echo esc_attr($data_section_id) ?>">
                        <?php if(count($meta_values) > 0){
                            $index = 0;
                            foreach($meta_values as $image){
                                $urls = wp_get_attachment_image_src($image,'full');
                                $img = '';
                                if(count($urls)>0){
                                    $resize = matthewruddy_image_resize($urls[0],180,130);
                                    if($resize!=null && is_array($resize) )
                                        $img = $resize['url'];
                                }
                                ?>
                                <div class="item">
                                    <a href="javascript:;" class="nav-slideshow" data-section-id="<?php echo esc_attr($data_section_id) ?>" data-index="<?php echo esc_attr($index++) ?>" >
                                        <img alt="portfolio" src="<?php echo esc_url($img) ?>" />
                                    </a>
                                </div>
                            <?php }
                        }else { if(count($imgThumbs)>0) {?>
                            <div class="item">
                                <img alt="portfolio" src="<?php echo esc_url($imgThumbs[0])?>" />
                            </div>
                        <?php }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="container">
            <div class="row portfolio-content-wrap">
                <div class="col-md-8">
                    <div class="portfolio-title-wrap">
                        <h5 class="portfolio-title p-font"><?php the_title() ?></h5>
                    </div>
                    <div class="portfolio-info">
                        <?php the_content(); ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="portfolio-info spec">
                        <div class="portfolio-info-box">
                            <h6 class="p-color p-font"><?php echo esc_html__( 'Client','haru-circle' ); ?> </h6>
                            <div class="portfolio-term-client"><?php echo esc_html( get_post_meta(get_the_ID(), 'haru_portfolio_client', true) ); ?></div>
                        </div>
                        <div class="portfolio-info-box">
                            <h6 class="p-color p-font"><?php echo esc_html__( 'My Team','haru-circle' ); ?> </h6>
                            <?php foreach( $team_member as $member ) : ?>
                            <div class="portfolio-term-team"><?php echo esc_html( $member ); ?></div>
                            <?php endforeach; ?>
                        </div>
                        <div class="portfolio-info-box">
                            <h6 class="p-color p-font"><?php echo esc_html__( 'Date','haru-circle' ); ?> </h6>
                            <div class="portfolio-term-date"><?php echo date(get_option('date_format'),strtotime($post->post_date)) ?></div>
                        </div>
                        <div class="portfolio-info-box">
                            <h6 class="p-color p-font"><?php echo esc_html__( 'Category','haru-circle' ); ?> </h6>
                            <div class="portfolio-term-cat"><?php echo wp_kses_post($cat); ?></div>
                        </div>
                        <div class="portfolio-info-box">
                            <h6 class="p-color p-font"><?php echo esc_html__( 'Tags','haru-circle' ); ?> </h6>
                            <div class="portfolio-term-tag"><?php echo wp_kses_post($tag); ?></div>
                        </div>
                        <?php if ( NULL !== haru_get_option('portfolio_social_profile') ) : ?>
                        <div class="portfolio-info-box">
                            <h6 class="p-color p-font"><?php echo esc_html__( 'Follow Us','haru-circle' ); ?> </h6>
                            <?php 
                            if( NULL !== haru_get_option('portfolio_social_profile') )
                                include_once(plugin_dir_path( __FILE__ ).'/social.php');
                            ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    (function($) {
        "use strict";
        $(document).ready(function(){
            var sync1    = $(".post-slideshow","#content");
            var sync2    = $(".slideshow-paging","#content");
            var flag     = false;
            var duration = 500;

            sync1
                .owlCarousel({
                    items: 1,
                    margin: 0,
                    nav: true,
                    navText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
                    dots: true
                })
                .on('changed.owl.carousel', function (e) {
                    if (!flag) {
                        flag = true;
                        sync2.trigger('to.owl.carousel', [e.item.index, duration, true]);
                        flag = false;
                    }

                    // Add class synced to current slide
                    var current = e.item.index;
                    $(".slideshow-paging")
                        .find(".owl-item")
                        .removeClass("synced")
                        .eq(current)
                        .addClass("synced");
                });

            sync2
                .owlCarousel({
                    margin: 0,
                    items: 6,
                    nav: true,
                    navText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
                    center: false,
                    dots: true,
                    responsive: {
                        0: {
                            items: 3
                        },
                        500: {
                            items: 3
                        },
                        991: {
                            items: 3
                        },
                        1200: {
                            items: 5
                        },
                        1300: {
                            items: 6
                        }
                    },
                    onInitialized : function(){
                        sync2.find(".owl-item").eq(0).addClass("synced");
                    }
                })
                .on('click', '.owl-item', function () {
                    sync1.trigger('to.owl.carousel', [$(this).index(), duration, true]);
                })
                .on('changed.owl.carousel', function (e) {
                    if (!flag) {
                        flag = true;        
                        sync1.trigger('to.owl.carousel', [e.item.index, duration, true]);
                        flag = false;
                    }
                });

        })

    })(jQuery);
</script>

<?php wp_reset_query(); ?>
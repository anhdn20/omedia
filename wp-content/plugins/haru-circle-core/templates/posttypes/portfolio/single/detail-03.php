<?php
/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

do_action('haru_before_page');
$data_section_id = uniqid();
$portfolio_type = get_post_meta(get_the_ID(), 'haru_portfolio_media_type', true);

?>
<div class="portfolio-full detail-03" id="content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
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
                    <?php 
                        the_post_thumbnail( get_the_ID(), 'full' );
                    ?>
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

            </div>

            <div class="col-md-4">
                <div class="portfolio-info portfolio-content">
                    <h5 class="portfolio-title p-font"><?php the_title() ?></h5>
                    <?php the_content(); ?>
                </div>
                <div class="portfolio-info">
                    <?php
                    $meta = get_post_meta(get_the_ID(), 'portfolio_custom_fields', TRUE);
                    if(isset($meta) && is_array($meta) && count($meta['portfolio_custom_fields'])>0){
                        for($i=0; $i<count($meta['portfolio_custom_fields']);$i++){
                            ?>
                            <div class="portfolio-info-box">
                                <h6 class="p-color p-font"><?php echo wp_kses_post($meta['portfolio_custom_fields'][$i]['custom-field-title']) ?>: </h6>
                                <div class="portfolio-term-custom"><?php echo wp_kses_post($meta['portfolio_custom_fields'][$i]['custom-field-description']) ?></div>
                            </div>
                        <?php }
                    }
                    ?>

                    <div class="portfolio-info-box">
                        <h6 class="p-color p-font"><?php echo esc_html__( 'Category','haru-circle' ); ?> </h6>
                        <div class="portfolio-term-cat"><?php echo wp_kses_post($cat); ?></div>
                    </div>
                    <div class="portfolio-info-box">
                        <h6 class="p-color p-font"><?php echo esc_html__( 'Date','haru-circle' ); ?> </h6>
                        <div class="portfolio-term-date"><?php echo date(get_option('date_format'),strtotime($post->post_date)) ?></div>
                    </div>
                    <div class="portfolio-info-box">
                        <h6 class="p-color p-font"><?php echo esc_html__( 'Tags','haru-circle' ); ?> </h6>
                        <div class="portfolio-term-tag"><?php echo wp_kses_post($tag); ?></div>
                    </div>
                    <?php if( NULL !== haru_get_option('portfolio_social_profile') ) : ?>
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

<script type="text/javascript">
    (function($) {
        "use strict";
        $(window).load(function(){
            $(".post-slideshow",'#content').owlCarousel({
                items: 1,
                singleItem: true,
                navigation : true,
                slideSpeed: 600,
                navigationText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
                pagination: false,
                afterInit:function(){
                    $(".post-slideshow",'#content').css('opacity','1');
                },
                afterMove:function(){
                    var index = this.owl.currentItem;
                    moveNavSlide(index);
                }
            });

            $(".slideshow-paging",'#content').owlCarousel({
                items: 6,
                itemsDesktop : [1024,5],
                itemsDesktopSmall : [767,3],
                itemsTablet: [600,3],
                itemsMobile: false,
                singleItem: false,
                navigation : false,
                pagination: false,
                afterInit:function(){
                    $(".slideshow-paging",'#content').css('opacity','1');

                    $('a.nav-slideshow', '#content .slideshow-paging').click(function(){
                        var index = $(this).attr('data-index');
                        var currentIndex = $(".slideshow-paging",'#content').attr('data-current-index');
                        var totalItems = $(".slideshow-paging",'#content').attr('data-total-items');

                        index = parseInt(index);
                        movePostSlide(index);

                        var owl_nav = $(".slideshow-paging",'#content').data('owlCarousel');
                        if(index <= currentIndex){
                            owl_nav.goTo(index-1);
                        }

                    })
                }
            });
            function moveNavSlide(index){
                var owl_nav = $(".slideshow-paging",'#content').data('owlCarousel');
                owl_nav.goTo(index);
                $(".slideshow-paging",'#content').attr('data-current-index', index);

            }
            function movePostSlide(index){
                if(index!='undefined'){
                    var owl_post = $(".post-slideshow",'#content').data('owlCarousel');
                    owl_post.goTo(index);
                    $(".slideshow-paging",'#content').attr('data-current-index', index);
                }
            }
        })

    })(jQuery);
</script>
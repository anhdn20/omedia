<?php 
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

// Load the HARU theme framework, all functions for theme will in includes folder in framework folder
require get_template_directory()  . '/framework/haru-framework.php';

// Remove plugin flag from redux. Get rid of redirect
add_action( 'redux/construct', 'haru_remove_as_plugin_flag' );

function haru_remove_as_plugin_flag() {
    ReduxFramework::$_as_plugin = false;
}


// Disable revslider notice.
if ( function_exists( 'rev_slider_shortcode' ) ) {
    add_action( 'admin_init', 'haru_disable_revslider_notice' );
}

function haru_disable_revslider_notice() {
    update_option( 'revslider-valid-notice', 'false' );
}

add_action('wp_footer', 'digital_css',1);
function digital_css(){
    ?>
    <style>
        :root{
            --fifth-text-color: #aaa;
            --secondary-text-color: #8c8c8c;
        }
        .digitalasset-shortcode-wrapper.grid .digitalasset-content .digitalasset-filter.align_left, .digitalasset-shortcode-wrapper.masonry .digitalasset-content .digitalasset-filter.align_left, .digitalasset-shortcode-wrapper.grid_special .digitalasset-content .digitalasset-filter.align_left, .digitalasset-shortcode-ajax.grid .digitalasset-content .digitalasset-filter.align_left, .digitalasset-shortcode-ajax.masonry .digitalasset-content .digitalasset-filter.align_left, .digitalasset-shortcode-ajax.grid_special .digitalasset-content .digitalasset-filter.align_left{
            text-align: left;
        }
        .digitalasset-shortcode-wrapper.grid .digitalasset-content .digitalasset-filter, .digitalasset-shortcode-ajax.grid .digitalasset-content .digitalasset-filter, .digitalasset-shortcode-wrapper.masonry .digitalasset-content .digitalasset-filter, .digitalasset-shortcode-ajax.masonry .digitalasset-content .digitalasset-filter, .digitalasset-shortcode-wrapper.grid_special .digitalasset-content .digitalasset-filter, .digitalasset-shortcode-ajax.grid_special .digitalasset-content .digitalasset-filter{
            list-style: none;
            list-style-type: none;
            padding: 0;
        }
        .digitalasset-shortcode-wrapper.grid .digitalasset-content .digitalasset-filter.style_1 li, .digitalasset-shortcode-ajax.grid .digitalasset-content .digitalasset-filter.style_1 li, .digitalasset-shortcode-wrapper.masonry .digitalasset-content .digitalasset-filter.style_1 li, .digitalasset-shortcode-ajax.masonry .digitalasset-content .digitalasset-filter.style_1 li, .digitalasset-shortcode-wrapper.grid_special .digitalasset-content .digitalasset-filter.style_1 li, .digitalasset-shortcode-ajax.grid_special .digitalasset-content .digitalasset-filter.style_1 li{
            display: inline-block;
            padding: 0 5px;
            margin-bottom: 10px;
        }
        .digitalasset-shortcode-wrapper.grid .digitalasset-content .digitalasset-filter.style_1 li a:hover, .digitalasset-shortcode-wrapper.grid .digitalasset-content .digitalasset-filter.style_1 li a.selected, .digitalasset-shortcode-wrapper.masonry .digitalasset-content .digitalasset-filter.style_1 li a:hover, .digitalasset-shortcode-wrapper.masonry .digitalasset-content .digitalasset-filter.style_1 li a.selected, .digitalasset-shortcode-wrapper.grid_special .digitalasset-content .digitalasset-filter.style_1 li a:hover, .digitalasset-shortcode-wrapper.grid_special .digitalasset-content .digitalasset-filter.style_1 li a.selected, .digitalasset-shortcode-ajax.grid .digitalasset-content .digitalasset-filter.style_1 li a:hover, .digitalasset-shortcode-ajax.grid .digitalasset-content .digitalasset-filter.style_1 li a.selected, .digitalasset-shortcode-ajax.masonry .digitalasset-content .digitalasset-filter.style_1 li a:hover, .digitalasset-shortcode-ajax.masonry .digitalasset-content .digitalasset-filter.style_1 li a.selected, .digitalasset-shortcode-ajax.grid_special .digitalasset-content .digitalasset-filter.style_1 li a:hover, .digitalasset-shortcode-ajax.grid_special .digitalasset-content .digitalasset-filter.style_1 li a.selected{
            background-color: #fd6500;
            border-color: #fd6500;
            color: #fff;
            -webkit-transition: all 0.3s;
            -o-transition: all 0.3s;
            transition: all 0.3s;
        }
        .digitalasset-shortcode-wrapper.grid .digitalasset-content .digitalasset-filter.style_1 li a, .digitalasset-shortcode-wrapper.masonry .digitalasset-content .digitalasset-filter.style_1 li a, .digitalasset-shortcode-wrapper.grid_special .digitalasset-content .digitalasset-filter.style_1 li a, .digitalasset-shortcode-ajax.grid .digitalasset-content .digitalasset-filter.style_1 li a, .digitalasset-shortcode-ajax.masonry .digitalasset-content .digitalasset-filter.style_1 li a, .digitalasset-shortcode-ajax.grid_special .digitalasset-content .digitalasset-filter.style_1 li a{
            border: 2px solid #e0e0e0;
            display: inline-block;
            font-size: 13px;
            padding: 6px 25px;
            text-transform: uppercase;
            -webkit-border-radius: 20px;
            -moz-border-radius: 20px;
            border-radius: 20px;
            -webkit-transition: all 0.3s;
            -o-transition: all 0.3s;
            transition: all 0.3s;
        }

        .digitalasset-list.columns-2{
            display: flex;
            justify-content: space-between;
            gap: 35px;
            flex-wrap: wrap;
        }
        .digitalasset-list.columns-2 > .digitalasset-item{
            width: calc(50% - 17.5px);
            border-radius: 15px;
            /* border: 1px solid #ccc; */
            overflow: hidden;
        }

        .digitalasset-list.columns-3{
            display: flex;
            justify-content: flex-start;
            gap: 56px;
            flex-wrap: wrap;
        }
        .digitalasset-list.columns-3 > .digitalasset-item{
            width: calc(33.333% - 40px);
            border-radius: 15px;
            /* border: 1px solid #ccc; */
            overflow: hidden;
        }
        
        .digitalasset-list.columns-4{
            display: flex;
            justify-content: flex-start;
            gap: 50px;
            flex-wrap: wrap;
        }
        .digitalasset-list.columns-4 > .digitalasset-item{
            width: calc(25% - 40px);
            border-radius: 15px;
            /* border: 1px solid #ccc; */
            overflow: hidden;
        }
        
        .digitalasset-list.columns-5{
            display: flex;
            justify-content: space-between;
            gap: 25px;
            flex-wrap: wrap;
        }
        .digitalasset-list.columns-5 > .digitalasset-item{
            width: calc(25% - 80px);
            border-radius: 15px;
            /* border: 1px solid #ccc; */
            overflow: hidden;
        }

        .dgtass-name {
            display: grid;
            grid-row-gap: 0.3rem;
            width: 90%;
        }
        .dgtass-info{
            display: grid;
            grid-row-gap: 0.5rem;
            text-align: right;
        }
        .dgtass-title{
            margin-top: 0px;
            margin-bottom: 0px;
            font-size: 1.3rem;
            font-weight: 500;
            color: var(--fifth-text-color);
        }

        .dgtass-meta{
            padding: 15px 20px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            background-color: #1e1e23;
        }

        .dgtass-name .dgtass-title{
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            padding-right: 0.5rem;
        }
        .dgtass-name .dgtass-title a,
        .dgtass-price{
            color: var(--fifth-text-color);
            font-size: 1.2em;
        }
        .dgtass-category {
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 13px;
            -webkit-line-clamp: 1;
            height: 24px;
            line-height: 26px;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            max-width: 70px;
        }
        .dgtass-category a, .dgtass-author{
            color: var(--secondary-text-color);
            font-size: 1.1em;
        }
        .archive-content .dgtass-item,
        .digitalasset-list .dgtass-item{
            background-color: #1e1e23;
            border-radius: 15px;
            overflow: hidden;
        }

        .dgtass-item .dgtass-available{
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--secondary-text-color);
            font-size: 1.2em;
        }

        .dgtass-item .dgtass-thumbnail .dgtass-thumbnail-image,
        .dgtass-item .dgtass-thumbnail .dgtass-thumbnail-video{
            position: relative;
            display: block;
            width: 100%;
            padding-top: 100%;
            height: inherit;
            border-radius: 0;
            overflow: hidden;
        }
        
        .dgtass-item .dgtass-thumbnail .dgtass-thumbnail-image picture,
        .dgtass-item .dgtass-thumbnail .dgtass-thumbnail-video video{
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .dgtass-item .dgtass-thumbnail .dgtass-thumbnail-image picture img,
        .dgtass-item .dgtass-thumbnail .dgtass-thumbnail-video picture video{
            min-height: 100%;
            min-width: 100%;
            position: relative;
            display: inherit;
            object-fit: cover;
            width: 100%;
            height: 100%;
        }
        .haru-single-digitalasset .single-content .single-wrapper article .post-wrapper .single-digitalasset-main .digitalasset-content .post-social-share {
            text-align: center;
            margin-bottom: 65px;
        }
                
        .haru-single-digitalasset .single-content .single-wrapper article .post-wrapper .single-digitalasset-main .digitalasset-content .post-social-share .social-share-wrapper .social-share {
            list-style: none;
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .haru-single-digitalasset .single-content .single-wrapper article .post-wrapper .single-digitalasset-main .digitalasset-content .post-social-share .social-share-wrapper .social-share li {
            display: inline-block;
            margin-left: 15px;
        }

        .haru-single-digitalasset .single-content .single-wrapper article .post-wrapper .single-digitalasset-main .digitalasset-content .post-social-share .social-share-wrapper .social-share li.social-label {
            display: none;
        }

        .haru-single-digitalasset .single-content .single-wrapper article .post-wrapper .single-digitalasset-main .digitalasset-content .post-social-share .social-share-wrapper .social-share li a {
            color: #fd6500;
            display: inline-block;
            font-family: "Playfair Display";
            font-weight: 700;
            font-size: 16px;
            text-transform: uppercase;
            text-align: center;
            width: 45px;
            height: 45px;
            line-height: 40px;
            border: 2px solid rgba(224, 224, 224, 0.3);
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
            border-radius: 50%;
            -webkit-transition: all 0.3s;
            -o-transition: all 0.3s;
            transition: all 0.3s;
        }

        .haru-single-digitalasset .single-content .single-wrapper article .post-wrapper .single-digitalasset-main .digitalasset-content .post-social-share .social-share-wrapper .social-share li a:hover {
            background-color: #fd6500;
            border: 2px solid #fd6500;
            color: #fff;
            -webkit-transition: all 0.3s;
            -o-transition: all 0.3s;
            transition: all 0.3s;
        }
        #haru-content-main{
            background-color: #000;
        }
        .single-digitalasset-main .digitalasset-detail .digitalasset-title{
            margin-top: 0;
            font-size: 2.3em;
            color: #fff;
        }
        .single-digitalasset-main .digitalasset-detail .digitalasset-author h5{
            font-size: 1.2em;
            color: #aaa;
            margin-bottom: 40px;
        }
        .single-digitalasset-main .digitalasset-detail .digitalasset-price{
            margin-bottom: 30px;
        }
        .single-digitalasset-main .digitalasset-detail .digitalasset-price p{
            font-size: 1em;
            color: #828282;
            margin-bottom: 10px;
        }
        .single-digitalasset-main .digitalasset-detail .digitalasset-price span{
            font-size: 1.5em;
            color: #fff;
        }
        .single-digitalasset-main .digitalasset-detail .digitalasset-price span.syn{
            color: #828282;
        }
        .single-digitalasset-main .digitalasset-detail .digitalasset-available{
            margin-bottom: 20px;
        }
        .single-digitalasset-main .digitalasset-detail .digitalasset-des p.des_lable{
            font-size: 1em;
            font-weight: bold;
        }
        .single-digitalasset-main .digitalasset-detail .digitalasset-des > *{
            color: #aaa;
        }

        .single-digitalasset-main .digitalasset-detail .digitalasset-find-more{
            margin-top: 30px;
        }

        @media(max-width: 1200px){
            .digitalasset-list.columns-4{
                gap: 40px;
            }
            .digitalasset-list.columns-5{
                gap: 15px;
            }
            .digitalasset-list.columns-5 > .digitalasset-item{
                width: calc(25% - 60px);
            }
        }
        @media(max-width: 1000px){
            .digitalasset-list.columns-4{
                gap: 40px;
            }
            .digitalasset-list.columns-4 > .digitalasset-item{
                width: calc(33.333% - 30px);
            }
            .digitalasset-list.columns-3{
                gap: 40px;
            }
            .digitalasset-list.columns-3 > .digitalasset-item{
                width: calc(33.333% - 30px);
            }

            .digitalasset-list.columns-5{
                gap: 40px;
                justify-content: center;
            }
            .digitalasset-list.columns-5 > .digitalasset-item{
                width: calc(33.333% - 30px);
            }
        }
        @media(max-width: 768px){
            .single-digitalasset-main .digitalasset-description{
                margin-top: 30px;
            }
            .haru-single-digitalasset .single-content .single-wrapper article .post-wrapper .single-digitalasset-main .digitalasset-content .post-social-share {
                margin-bottom: 35px;
            }
            .haru-single-digitalasset .single-content .single-wrapper article .post-wrapper .single-digitalasset-main .digitalasset-content .post-social-share .social-share-wrapper .social-share li a {
                font-size: 14px;
                width: 35px;
                height: 35px;
                line-height: 32px;
            }

            .digitalasset-list.columns-3{
                gap: 35px;
            }
            .digitalasset-list.columns-3 > .digitalasset-item{
                width: calc(50% - 17.5px);
            }
            .digitalasset-list.columns-4{
                gap: 35px;
            }
            .digitalasset-list.columns-4 > .digitalasset-item{
                width: calc(50% - 17.5px);
            }
            .digitalasset-list.columns-5{
                gap: 35px;
                justify-content: flex-start;
            }
            .digitalasset-list.columns-5 > .digitalasset-item{
                width: calc(50% - 17.5px);
            }
            .dgtass-meta{
                padding: 10px;
            }
            .dgtass-title{
                font-size: 1.2rem;
            }
            .dgtass-author{
                font-size: 1.2rem;   
            }
            .dgtass-price{
                font-size: 1.2rem;
            }
            .dgtass-category{
                height: 23px;
            }
        }
        @media(max-width: 480px){
            .digitalasset-list.columns-2{
                gap: 20px;
            }
            .digitalasset-list.columns-2 > .digitalasset-item{
                width: 100%;
            }
            .digitalasset-list.columns-3{
                column-gap: 0px;
                row-gap: 20px;
            }
            .digitalasset-list.columns-3 > .digitalasset-item{
                width: 100%;
            }
            .digitalasset-list.columns-4{
                column-gap: 0px;
                row-gap: 20px;
            }
            .digitalasset-list.columns-4 > .digitalasset-item{
                width: 100%;
            }
            .digitalasset-list.columns-5{
                column-gap: 0px;
                row-gap: 20px;
            }
            .digitalasset-list.columns-5 > .digitalasset-item{
                width: 100%;
            }
            .dgtass-name{
                width: 50%;
            }
            .dgtass-category{
                max-width: unset;
            }
        }
    </style>
    <?php
}

add_action('wp_footer','digital_js');
function digital_js(){
    ?>
    <script>
        const videos = document.querySelectorAll('.dgtass-thumbnail-video video');

        videos.forEach(video => {
            video.addEventListener('mouseenter', () => {
                video.play();
            });
        
            video.addEventListener('mouseleave', () => {
                video.pause();
                video.currentTime = 0;
            });
        });
    </script>
    <?php
}
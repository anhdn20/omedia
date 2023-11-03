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
            --secondary-text-color: #797980;
        }
        .digitalasset-list.columns-4{
            display: flex;
            justify-content: space-between;
            column-gap: 70px;
        }
        .digitalasset-list.columns-4 > .digitalasset-item{
            width: 25%;
            border-radius: 15px;
            border: 1px solid #ccc;
            overflow: hidden;
        }
        .dgtass-name {
            display: grid;
            grid-row-gap: 0.5rem;
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
        }
        .dgtass-category {
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 13px;
            -webkit-line-clamp: 1;
            height: 24px;
            line-height: 21px;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            max-width: 70px;
        }
        .dgtass-category a, .dgtass-author{
            color: var(--secondary-text-color);
        }

        .digitalasset-shortcode-wrapper .digitalasset-content .digitalasset-list .dgtass-item .dgtass-thumbnail .dgtass-thumbnail-image,
        .digitalasset-shortcode-wrapper .digitalasset-content .digitalasset-list .dgtass-item .dgtass-thumbnail .dgtass-thumbnail-video{
            position: relative;
            display: block;
            width: 100%;
            padding-top: 100%;
            height: inherit;
            border-radius: 0;
            overflow: hidden;
        }
        
        .digitalasset-shortcode-wrapper .digitalasset-content .digitalasset-list .dgtass-item .dgtass-thumbnail .dgtass-thumbnail-image picture,
        .digitalasset-shortcode-wrapper .digitalasset-content .digitalasset-list .dgtass-item .dgtass-thumbnail .dgtass-thumbnail-video video{
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
        .digitalasset-shortcode-wrapper .digitalasset-content .digitalasset-list .dgtass-item .dgtass-thumbnail .dgtass-thumbnail-image picture img,
        .digitalasset-shortcode-wrapper .digitalasset-content .digitalasset-list .dgtass-item .dgtass-thumbnail .dgtass-thumbnail-video picture video{
            min-height: 100%;
            min-width: 100%;
            position: relative;
            display: inherit;
            object-fit: cover;
            width: 100%;
            height: 100%;
        }
        @media(max-width: 1200px){
            .digitalasset-list.columns-4{
                column-gap: 40px;
            }
        }
        @media(max-width: 1000px){
            .digitalasset-list.columns-4{
                column-gap: 40px;
            }
        }
        @media(max-width: 768px){
            .digitalasset-list.columns-4{
                column-gap: 20px;
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
            .digitalasset-list.columns-4{
                flex-wrap: wrap;
                column-gap: 0px;
                row-gap: 20px;
            }
            .digitalasset-list.columns-4 > .digitalasset-item{
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
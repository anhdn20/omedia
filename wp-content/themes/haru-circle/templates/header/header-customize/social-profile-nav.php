<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

$enable_header_customize = get_post_meta( get_the_ID(), 'haru_' . 'enable_header_customize_nav', true );
$header_social_profile = array();
if ($enable_header_customize == '1') {
    $header_social_profile = get_post_meta( get_the_ID(), 'haru_' . 'header_customize_nav_social_profile', false );
} else {
    if ( haru_get_option('option-header-customize-nav') == '1' ) {
        $header_social_profile = haru_get_option('header_customize_nav_social_profile');
    } else {
        return;
    }
}

$twitter = '';
$twitter_url = haru_get_option('twitter_url');
if ( isset($twitter_url) ) {
    $twitter = $twitter_url;
}

$facebook = '';
$facebook_url = haru_get_option('facebook_url');
if ( isset($facebook_url) ) {
    $facebook = $facebook_url;
}

$vimeo = '';
$vimeo_url = haru_get_option('vimeo_url');
if ( isset($vimeo_url) ) {
    $vimeo = $vimeo_url;
}

$linkedin = '';
$linkedin_url = haru_get_option('linkedin_url');
if ( isset($linkedin_url) ) {
    $linkedin = $linkedin_url;
}

$googleplus = '';
$googleplus_url = haru_get_option('googleplus_url');
if ( isset($googleplus_url) ) {
    $googleplus = $googleplus_url;
}

$flickr = '';
$flickr_url = haru_get_option('flickr_url');
if ( isset($flickr_url) ) {
    $flickr = $flickr_url;
}

$youtube = '';
$youtube_url = haru_get_option('youtube_url');
if ( isset($youtube_url) ) {
    $youtube = $youtube_url;
}

$pinterest = '';
$pinterest_url = haru_get_option('pinterest_url');
if ( isset($pinterest_url) ) {
    $pinterest = $pinterest_url;
}

$instagram = '';
$instagram_url = haru_get_option('instagram_url');
if ( isset($instagram_url) ) {
    $instagram = $instagram_url;
}

$behance = '';
$behance_url = haru_get_option('behance_url');
if ( isset($behance_url) ) {
    $behance = $behance_url;
}

$social_icons = '';

if ( ($header_social_profile == array()) || (empty( $header_social_profile )) ) {
    if ( $twitter ) {
        $social_icons .= '<li><a href="' . esc_url( $twitter ) . '" target="_blank"><i class="fa fa-twitter"></i></a></li>' . "\n";
    }
    if ( $facebook ) {
        $social_icons .= '<li><a href="' . esc_url( $facebook ) . '" target="_blank"><i class="fa fa-facebook"></i></a></li>' . "\n";
    }
    if ( $youtube ) {
        $social_icons .= '<li><a href="' . esc_url( $youtube ) . '" target="_blank"><i class="fa fa-youtube"></i></a></li>' . "\n";
    }
    if ( $vimeo ) {
        $social_icons .= '<li><a href="' . esc_url( $vimeo ) . '" target="_blank"><i class="fa fa-vimeo-square"></i></a></li>' . "\n";
    }
    if ( $linkedin ) {
        $social_icons .= '<li><a href="' . esc_url( $linkedin ) . '" target="_blank"><i class="fa fa-linkedin"></i></a></li>' . "\n";
    }
    if ( $googleplus ) {
        $social_icons .= '<li><a href="' . esc_url( $googleplus ) . '" target="_blank"><i class="fa fa-google-plus"></i></a></li>' . "\n";
    }
    if ( $flickr ) {
        $social_icons .= '<li><a href="' . esc_url( $flickr ) . '" target="_blank"><i class="fa fa-flickr"></i></a></li>' . "\n";
    }
    if ( $pinterest ) {
        $social_icons .= '<li><a href="' . esc_url( $pinterest ) . '" target="_blank"><i class="fa fa-pinterest"></i></a></li>' . "\n";
    }
    if ( $instagram ) {
        $social_icons .= '<li><a href="' . esc_url( $instagram ) . '" target="_blank"><i class="fa fa-instagram"></i></a></li>' . "\n";
    }
    if ( $behance ) {
        $social_icons .= '<li><a href="' . esc_url( $behance ) . '" target="_blank"><i class="fa fa-behance"></i></a></li>' . "\n";
    }
} else {
    if (empty($twitter)) { $twitter = '#'; }
    if (empty($facebook)) { $facebook = '#'; }
    if (empty($youtube)) { $youtube = '#'; }
    if (empty($vimeo)) { $vimeo = '#'; }
    if (empty($linkedin)) { $linkedin = '#'; }
    if (empty($googleplus)) { $googleplus = '#'; }
    if (empty($flickr)) { $flickr = '#'; }
    if (empty($pinterest)) { $pinterest = '#'; }
    if (empty($instagram)) { $instagram = '#'; }
    if (empty($behance)) { $behance = '#'; }

    foreach ( $header_social_profile as $id ) {
        if ( ( $id == 'twitter' ) && $twitter ) {
            $social_icons .= '<li><a href="' . esc_url( $twitter ) . '" target="_blank"><i class="fa fa-twitter"></i></a></li>' . "\n";
        }
        if ( ( $id == 'facebook' ) && $facebook ) {
            $social_icons .= '<li><a href="' . esc_url( $facebook ) . '" target="_blank"><i class="fa fa-facebook"></i></a></li>' . "\n";
        }
        if ( ( $id == 'youtube' ) && $youtube ) {
            $social_icons .= '<li><a href="' . esc_url( $youtube ) . '" target="_blank"><i class="fa fa-youtube"></i></a></li>' . "\n";
        }
        if ( ( $id == 'vimeo' ) && $vimeo ) {
            $social_icons .= '<li><a href="' . esc_url( $vimeo ) . '" target="_blank"><i class="fa fa-vimeo-square"></i></a></li>' . "\n";
        }
        if ( ( $id == 'linkedin' ) && $linkedin ) {
            $social_icons .= '<li><a href="' . esc_url( $linkedin ) . '" target="_blank"><i class="fa fa-linkedin"></i></a></li>' . "\n";
        }
        if ( ( $id == 'googleplus' ) && $googleplus ) {
            $social_icons .= '<li><a href="' . esc_url( $googleplus ) . '" target="_blank"><i class="fa fa-google-plus"></i></a></li>' . "\n";
        }
        if ( ( $id == 'flickr' ) && $flickr ) {
            $social_icons .= '<li><a href="' . esc_url( $flickr ) . '" target="_blank"><i class="fa fa-flickr"></i></a></li>' . "\n";
        }
        if ( ( $id == 'pinterest' ) && $pinterest ) {
            $social_icons .= '<li><a href="' . esc_url( $pinterest ) . '" target="_blank"><i class="fa fa-pinterest"></i></a></li>' . "\n";
        }
        if ( ( $id == 'instagram' ) && $instagram ) {
            $social_icons .= '<li><a href="' . esc_url( $instagram ) . '" target="_blank"><i class="fa fa-instagram"></i></a></li>' . "\n";
        }
        if ( ( $id == 'behance' ) && $behance ) {
            $social_icons .= '<li><a href="' . esc_url( $behance ) . '" target="_blank"><i class="fa fa-behance"></i></a></li>' . "\n";
        }
    }
}
if ( empty($social_icons) ) {
    return;
}
?>
<ul class="header-customize-item header-social-profile-wrapper">
    <?php echo wp_kses_post( $social_icons ); ?>
</ul>
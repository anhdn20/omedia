<?php
/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

// Widget helper
include_once( PLUGIN_HARU_CIRCLE_CORE_DIR . 'includes/widgets/widget-custom-class.php' );
// Widgets
include_once( PLUGIN_HARU_CIRCLE_CORE_DIR . 'includes/widgets/haru-widget.php' );
include_once( PLUGIN_HARU_CIRCLE_CORE_DIR . 'includes/widgets/haru-acf-widget.php' );
include_once( PLUGIN_HARU_CIRCLE_CORE_DIR . 'includes/widgets/haru-post-thumbnail.php' );
include_once( PLUGIN_HARU_CIRCLE_CORE_DIR . 'includes/widgets/haru-social-profile-widget.php' );
include_once( PLUGIN_HARU_CIRCLE_CORE_DIR . 'includes/widgets/haru-my-account.php' );
// include_once( PLUGIN_HARU_CIRCLE_CORE_DIR . 'includes/widgets/haru-vertical-menu.php' );
include_once( PLUGIN_HARU_CIRCLE_CORE_DIR . 'includes/widgets/haru-video-categories.php' );
include_once( PLUGIN_HARU_CIRCLE_CORE_DIR . 'includes/widgets/haru-film-categories.php' );
include_once( PLUGIN_HARU_CIRCLE_CORE_DIR . 'includes/widgets/haru-widget-product-sorting.php' );
include_once( PLUGIN_HARU_CIRCLE_CORE_DIR . 'includes/widgets/haru-widget-price-filter.php' );
include_once( PLUGIN_HARU_CIRCLE_CORE_DIR . 'includes/widgets/haru-widget-color-filter.php' );
include_once( PLUGIN_HARU_CIRCLE_CORE_DIR . 'includes/widgets/haru-widget-circle-videos.php' );
include_once( PLUGIN_HARU_CIRCLE_CORE_DIR . 'includes/widgets/haru-widget-circle-top-film.php' );
include_once( PLUGIN_HARU_CIRCLE_CORE_DIR . 'includes/widgets/haru-widget-circle-film-tag.php' );
// include_once( PLUGIN_HARU_CIRCLE_CORE_DIR . 'includes/widgets/haru-product-search.php' );
// include_once( PLUGIN_HARU_CIRCLE_CORE_DIR . 'includes/widgets/twitter.php' );

// Functions display social icon
if ( !function_exists('haru_get_social_icon') ) {
	function haru_get_social_icon( $icons, $class = '' ) {
		$twitter = '';
		if ( NULL !== haru_get_option('twitter_url') ) {
			$twitter = haru_get_option('twitter_url');
		}

		$facebook = '';
		if ( NULL !== haru_get_option('facebook_url') ) {
			$facebook = haru_get_option('facebook_url');
		}

		$dribbble = '';
		if ( NULL !== haru_get_option('dribbble_url') ) {
			$dribbble = haru_get_option('dribbble_url');
		}

		$vimeo = '';
		if ( NULL !== haru_get_option('vimeo_url') ) {
			$vimeo = haru_get_option('vimeo_url');
		}

		$tumblr = '';
		if ( NULL !== haru_get_option('tumblr_url') ) {
			$tumblr = haru_get_option('tumblr_url');
		}

		$skype = haru_get_option('skype_username');
		if ( NULL !== haru_get_option('skype_username') ) {
			$skype = haru_get_option('skype_username');
		}

		$linkedin = '';
		if ( NULL !== haru_get_option('linkedin_url') ) {
			$linkedin = haru_get_option('linkedin_url');
		}

		$googleplus = '';
		if ( NULL !== haru_get_option('googleplus_url') ) {
			$googleplus = haru_get_option('googleplus_url');
		}

		$flickr = '';
		if ( NULL !== haru_get_option('flickr_url') ) {
			$flickr = haru_get_option('flickr_url');
		}

		$youtube = '';
		if ( NULL !== haru_get_option('youtube_url') ) {
			$youtube = haru_get_option('youtube_url');
		}

		$pinterest = '';
		if ( NULL !== haru_get_option('pinterest_url') ) {
			$pinterest = haru_get_option('pinterest_url');
		}

		$foursquare = haru_get_option('foursquare_url');
		if ( NULL !== haru_get_option('foursquare_url') ) {
			$foursquare = haru_get_option('foursquare_url');
		}

		$instagram = '';
		if ( NULL !== haru_get_option('instagram_url') ) {
			$instagram = haru_get_option('instagram_url');
		}

		$github = '';
		if ( NULL !== haru_get_option('github_url') ) {
			$github = haru_get_option('github_url');
		}

		$xing = haru_get_option('xing_url');
		if ( NULL !== haru_get_option('xing_url') ) {
			$xing = haru_get_option('xing_url');
		}

		$rss = '';
		if ( NULL !== haru_get_option('rss_url') ) {
			$rss = haru_get_option('rss_url');
		}

		$behance = '';
		if ( NULL !== haru_get_option('behance_url') ) {
			$behance = haru_get_option('behance_url');
		}

		$soundcloud = '';
		if ( NULL !== haru_get_option('soundcloud_url') ) {
			$soundcloud = haru_get_option('soundcloud_url');
		}

		$deviantart = '';
		if ( NULL !== haru_get_option('deviantart_url') ) {
			$deviantart = haru_get_option('deviantart_url');
		}

		$yelp = "";
		if ( NULL !== haru_get_option('yelp_url') ) {
			$yelp = haru_get_option('yelp_url');
		}

		$email = "";
		if ( NULL !== haru_get_option('email_address') ) {
			$email = haru_get_option('email_address');
		}

		$social_icons = '<ul class="'. $class .'">';

		if ( empty( $icons ) ) {
			if ( $twitter ) {
				$social_icons .= '<li><a title="'. esc_html__('Twitter','haru-circle') .'" href="' . esc_url( $twitter ) . '" target="_blank"><i class="fa fa-twitter"></i>'. esc_html__('Twitter','haru-circle') .'</a></li>' . "\n";
			}
			if ( $facebook ) {
				$social_icons .= '<li><a title="'. esc_html__('Facebook','haru-circle') .'" href="' . esc_url( $facebook ) . '" target="_blank"><i class="fa fa-facebook"></i>'. esc_html__('Facebook','haru-circle') .'</a></li>' . "\n";
			}
			if ( $dribbble ) {
				$social_icons .= '<li><a title="'. esc_html__('Dribbble','haru-circle') .'" href="' . esc_url( $dribbble ) . '" target="_blank"><i class="fa fa-dribbble"></i>'. esc_html__('Dribbble','haru-circle') .'</a></li>' . "\n";
			}
			if ( $youtube ) {
				$social_icons .= '<li><a title="'. esc_html__('Youtube','haru-circle') .'" href="' . esc_url( $youtube ) . '" target="_blank"><i class="fa fa-youtube"></i>'. esc_html__('Youtube','haru-circle') .'</a></li>' . "\n";
			}
			if ( $vimeo ) {
				$social_icons .= '<li><a title="'. esc_html__('Vimeo','haru-circle') .'" href="' . esc_url( $vimeo ) . '" target="_blank"><i class="fa fa-vimeo-square"></i>'. esc_html__('Vimeo','haru-circle') .'</a></li>' . "\n";
			}
			if ( $tumblr ) {
				$social_icons .= '<li><a title="'. esc_html__('Tumblr','haru-circle') .'" href="' . esc_url( $tumblr ) . '" target="_blank"><i class="fa fa-tumblr"></i>'. esc_html__('Tumblr','haru-circle') .'</a></li>' . "\n";
			}
			if ( $skype ) {
				$social_icons .= '<li><a title="'. esc_html__('Skype','haru-circle') .'" href="skype:' . esc_attr( $skype ) . '" target="_blank"><i class="fa fa-skype"></i>'. esc_html__('Skype','haru-circle') .'</a></li>' . "\n";
			}
			if ( $linkedin ) {
				$social_icons .= '<li><a title="'. esc_html__('Linkedin','haru-circle') .'" href="' . esc_url( $linkedin ) . '" target="_blank"><i class="fa fa-linkedin"></i>'. esc_html__('Linkedin','haru-circle') .'</a></li>' . "\n";
			}
			if ( $googleplus ) {
				$social_icons .= '<li><a title="'. esc_html__('GooglePlus','haru-circle') .'" href="' . esc_url( $googleplus ) . '" target="_blank"><i class="fa fa-google-plus"></i>'. esc_html__('GooglePlus','haru-circle') .'</a></li>' . "\n";
			}
			if ( $flickr ) {
				$social_icons .= '<li><a title="'. esc_html__('Flickr','haru-circle') .'" href="' . esc_url( $flickr ) . '" target="_blank"><i class="fa fa-flickr"></i>'. esc_html__('Flickr','haru-circle') .'</a></li>' . "\n";
			}
			if ( $pinterest ) {
				$social_icons .= '<li><a title="'. esc_html__('Pinterest','haru-circle') .'" href="' . esc_url( $pinterest ) . '" target="_blank"><i class="fa fa-pinterest"></i>'. esc_html__('Pinterest','haru-circle') .'</a></li>' . "\n";
			}
			if ( $foursquare ) {
				$social_icons .= '<li><a title="'. esc_html__('Foursquare','haru-circle') .'" href="' . esc_url( $foursquare ) . '" target="_blank"><i class="fa fa-foursquare"></i>'. esc_html__('Foursquare','haru-circle') .'</a></li>' . "\n";
			}
			if ( $instagram ) {
				$social_icons .= '<li><a title="'. esc_html__('Instagram','haru-circle') .'" href="' . esc_url( $instagram ) . '" target="_blank"><i class="fa fa-instagram"></i>'. esc_html__('Instagram','haru-circle') .'</a></li>' . "\n";
			}
			if ( $github ) {
				$social_icons .= '<li><a title="'. esc_html__('GitHub','haru-circle') .'" href="' . esc_url( $github ) . '" target="_blank"><i class="fa fa-github"></i>'. esc_html__('GitHub','haru-circle') .'</a></li>' . "\n";
			}
			if ( $xing ) {
				$social_icons .= '<li><a title="'. esc_html__('Xing','haru-circle') .'" href="' . esc_url( $xing ) . '" target="_blank"><i class="fa fa-xing"></i>'. esc_html__('Xing','haru-circle') .'</a></li>' . "\n";
			}
			if ( $behance ) {
				$social_icons .= '<li><a title="'. esc_html__('Behance','haru-circle') .'" href="' . esc_url( $behance ) . '" target="_blank"><i class="fa fa-behance"></i>'. esc_html__('Behance','haru-circle') .'</a></li>' . "\n";
			}
			if ( $deviantart ) {
				$social_icons .= '<li><a title="'. esc_html__('Deviantart','haru-circle') .'" href="' . esc_url( $deviantart ) . '" target="_blank"><i class="fa fa-deviantart"></i>'. esc_html__('Deviantart','haru-circle') .'</a></li>' . "\n";
			}
			if ( $soundcloud ) {
				$social_icons .= '<li><a title="'. esc_html__('SoundCloud','haru-circle') .'" href="' . esc_url( $soundcloud ) . '" target="_blank"><i class="fa fa-soundcloud"></i>'. esc_html__('SoundCloud','haru-circle') .'</a></li>' . "\n";
			}
			if ( $yelp ) {
				$social_icons .= '<li><a title="'. esc_html__('Yelp','haru-circle') .'" href="' . esc_url( $yelp ) . '" target="_blank"><i class="fa fa-yelp"></i>'. esc_html__('Yelp','haru-circle') .'</a></li>' . "\n";
			}
			if ( $rss ) {
				$social_icons .= '<li><a title="'. esc_html__('rss','haru-circle') .'" href="' . esc_url( $rss ) . '" target="_blank"><i class="fa fa-rss"></i>'. esc_html__('rss','haru-circle') .'</a></li>' . "\n";
			}
			if ( $email ) {
				$social_icons .= '<li><a title="'. esc_html__('Email','haru-circle') .'" href="mailto:' . esc_attr( $email ) . '" target="_blank"><i class="fa fa-vk"></i>'. esc_html__('Email','haru-circle') .'</a></li>' . "\n";
			}
		} else {

			$social_type = explode( '||', $icons );
			if (empty($twitter)) { $twitter = '#'; }
			if (empty($facebook)) { $facebook = '#'; }
			if (empty($dribbble)) { $dribbble = '#'; }
			if (empty($youtube)) { $youtube = '#'; }
			if (empty($vimeo)) { $vimeo = '#'; }
			if (empty($tumblr)) { $tumblr = '#'; }
			if (empty($skype)) { $skype = '#'; }
			if (empty($linkedin)) { $linkedin = '#'; }
			if (empty($googleplus)) { $googleplus = '#'; }
			if (empty($flickr)) { $flickr = '#'; }
			if (empty($pinterest)) { $pinterest = '#'; }
			if (empty($foursquare)) { $foursquare = '#'; }
			if (empty($instagram)) { $instagram = '#'; }
			if (empty($github)) { $github = '#'; }
			if (empty($xing)) { $xing = '#'; }
			if (empty($behance)) { $behance = '#'; }
			if (empty($deviantart)) { $deviantart = '#'; }
			if (empty($soundcloud)) { $soundcloud = '#'; }
			if (empty($yelp)) { $yelp = '#'; }
			if (empty($rss)) { $rss = '#'; }
			if (empty($email)) { $email = '#'; }

			foreach ( $social_type as $id ) {
				if ( ( $id == 'twitter' ) && $twitter ) {
					$social_icons .= '<li><a title="'. esc_html__('Twitter','haru-circle') .'" href="' . esc_url( $twitter ) . '" target="_blank"><i class="fa fa-twitter"></i>'. esc_html__('Twitter','haru-circle') .'</a></li>' . "\n";
				}
				if ( ( $id == 'facebook' ) && $facebook ) {
					$social_icons .= '<li><a title="'. esc_html__('Facebook','haru-circle') .'" href="' . esc_url( $facebook ) . '" target="_blank"><i class="fa fa-facebook"></i>'. esc_html__('Facebook','haru-circle') .'</a></li>' . "\n";
				}
				if ( ( $id == 'dribbble' ) && $dribbble ) {
					$social_icons .= '<li><a title="'. esc_html__('Dribbble','haru-circle') .'" href="' . esc_url( $dribbble ) . '" target="_blank"><i class="fa fa-dribbble"></i>'. esc_html__('Dribbble','haru-circle') .'</a></li>' . "\n";
				}
				if ( ( $id == 'youtube' ) && $youtube ) {
					$social_icons .= '<li><a title="'. esc_html__('Youtube','haru-circle') .'" href="' . esc_url( $youtube ) . '" target="_blank"><i class="fa fa-youtube"></i>'. esc_html__('Youtube','haru-circle') .'</a></li>' . "\n";
				}
				if ( ( $id == 'vimeo' ) && $vimeo ) {
					$social_icons .= '<li><a title="'. esc_html__('Vimeo','haru-circle') .'" href="' . esc_url( $vimeo ) . '" target="_blank"><i class="fa fa-vimeo-square"></i>'. esc_html__('Vimeo','haru-circle') .'</a></li>' . "\n";
				}
				if ( ( $id == 'tumblr' ) && $tumblr ) {
					$social_icons .= '<li><a title="'. esc_html__('Tumblr','haru-circle') .'" href="' . esc_url( $tumblr ) . '" target="_blank"><i class="fa fa-tumblr"></i>'. esc_html__('Tumblr','haru-circle') .'</a></li>' . "\n";
				}
				if ( ( $id == 'skype' ) && $skype ) {
					$social_icons .= '<li><a title="'. esc_html__('Skype','haru-circle') .'" href="skype:' . esc_attr( $skype ) . '" target="_blank"><i class="fa fa-skype"></i>'. esc_html__('Skype','haru-circle') .'</a></li>' . "\n";
				}
				if ( ( $id == 'linkedin' ) && $linkedin ) {
					$social_icons .= '<li><a title="'. esc_html__('Linkedin','haru-circle') .'" href="' . esc_url( $linkedin ) . '" target="_blank"><i class="fa fa-linkedin"></i>'. esc_html__('Linkedin','haru-circle') .'</a></li>' . "\n";
				}
				if ( ( $id == 'googleplus' ) && $googleplus ) {
					$social_icons .= '<li><a title="'. esc_html__('GooglePlus','haru-circle') .'" href="' . esc_url( $googleplus ) . '" target="_blank"><i class="fa fa-google-plus"></i>'. esc_html__('GooglePlus','haru-circle') .'</a></li>' . "\n";
				}
				if ( ( $id == 'flickr' ) && $flickr ) {
					$social_icons .= '<li><a title="'. esc_html__('Flickr','haru-circle') .'" href="' . esc_url( $flickr ) . '" target="_blank"><i class="fa fa-flickr"></i>'. esc_html__('Flickr','haru-circle') .'</a></li>' . "\n";
				}
				if ( ( $id == 'pinterest' ) && $pinterest ) {
					$social_icons .= '<li><a title="'. esc_html__('Pinterest','haru-circle') .'" href="' . esc_url( $pinterest ) . '" target="_blank"><i class="fa fa-pinterest"></i>'. esc_html__('Pinterest','haru-circle') .'</a></li>' . "\n";
				}
				if ( ( $id == 'foursquare' ) && $foursquare ) {
					$social_icons .= '<li><a title="'. esc_html__('Foursquare','haru-circle') .'" href="' . esc_url( $foursquare ) . '" target="_blank"><i class="fa fa-foursquare"></i>'. esc_html__('Foursquare','haru-circle') .'</a></li>' . "\n";
				}
				if ( ( $id == 'instagram' ) && $instagram ) {
					$social_icons .= '<li><a title="'. esc_html__('Instagram','haru-circle') .'" href="' . esc_url( $instagram ) . '" target="_blank"><i class="fa fa-instagram"></i>'. esc_html__('Instagram','haru-circle') .'</a></li>' . "\n";
				}
				if ( ( $id == 'github' ) && $github ) {
					$social_icons .= '<li><a title="'. esc_html__('GitHub','haru-circle') .'" href="' . esc_url( $github ) . '" target="_blank"><i class="fa fa-github"></i>'. esc_html__('GitHub','haru-circle') .'</a></li>' . "\n";
				}
				if ( ( $id == 'xing' ) && $xing ) {
					$social_icons .= '<li><a title="'. esc_html__('Xing','haru-circle') .'" href="' . esc_url( $xing ) . '" target="_blank"><i class="fa fa-xing"></i>'. esc_html__('Xing','haru-circle') .'</a></li>' . "\n";
				}
				if ( ( $id == 'behance' ) && $behance ) {
					$social_icons .= '<li><a title="'. esc_html__('Behance','haru-circle') .'" href="' . esc_url( $behance ) . '" target="_blank"><i class="fa fa-behance"></i>'. esc_html__('Behance','haru-circle') .'</a></li>' . "\n";
				}
				if ( ( $id == 'deviantart' ) && $deviantart ) {
					$social_icons .= '<li><a title="'. esc_html__('Deviantart','haru-circle') .'" href="' . esc_url( $deviantart ) . '" target="_blank"><i class="fa fa-deviantart"></i>'. esc_html__('Deviantart','haru-circle') .'</a></li>' . "\n";
				}
				if ( ( $id == 'soundcloud' ) && $soundcloud ) {
					$social_icons .= '<li><a title="'. esc_html__('SoundCloud','haru-circle') .'" href="' . esc_url( $soundcloud ) . '" target="_blank"><i class="fa fa-soundcloud"></i>'. esc_html__('SoundCloud','haru-circle') .'</a></li>' . "\n";
				}
				if ( ( $id == 'yelp' ) && $yelp ) {
					$social_icons .= '<li><a title="'. esc_html__('Yelp','haru-circle') .'" href="' . esc_url( $yelp ) . '" target="_blank"><i class="fa fa-yelp"></i>'. esc_html__('Yelp','haru-circle') .'</a></li>' . "\n";
				}
				if ( ( $id == 'rss' ) && $rss ) {
					$social_icons .= '<li><a title="'. esc_html__('Rss','haru-circle') .'" href="' . esc_url( $rss ) . '" target="_blank"><i class="fa fa-rss"></i>'. esc_html__('Rss','haru-circle') .'</a></li>' . "\n";
				}
				if ( ( $id == 'email' ) && $email ) {
					$social_icons .= '<li><a title="'. esc_html__('Email','haru-circle') .'" href="mailto:' . esc_attr( $email ) . '" target="_blank"><i class="fa fa-vk"></i>'. esc_html__('Email','haru-circle') .'</a></li>' . "\n";
				}
			}
		}

		$social_icons .= '</ul>';

		return $social_icons;
	}
}

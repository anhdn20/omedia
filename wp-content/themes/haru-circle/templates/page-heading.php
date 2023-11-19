<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

$show_page_title =  get_post_meta( get_the_ID(), 'haru_'.'show_page_title', true );
if ( ($show_page_title == -1) || ($show_page_title === '') ) {
    $show_page_title = haru_get_option('show_page_title');

    if ( is_singular('product') ) {
        $show_page_title = haru_get_option('haru_show_single_product_title');
    }

    elseif ( is_singular('haru_portfolio') ) {
        $show_page_title = haru_get_option('show_portfolio_title');
    }

    elseif ( is_singular('haru_video') ) {
        $show_page_title = haru_get_option('haru_show_single_video_title');
    }

    elseif ( is_singular('haru_digitalasset') ) {
        $show_page_title = haru_get_option('haru_show_single_digitalasset_title');
    }

    elseif ( is_singular('haru_film') ) {
        $show_page_title = haru_get_option('haru_show_single_film_title');
    }

    elseif ( is_singular('post') ) {
        $show_page_title = haru_get_option('show_single_blog_title');
    }
}
// Set Default
if ( $show_page_title || ($show_page_title === false) && is_page() ) {
    $show_page_title = 1;
} else {
    $show_page_title = $show_page_title;
}

// Custom page title and sub page title
$page_title = get_post_meta( get_the_ID(), 'haru_' . 'page_title_custom', true );
if ( $page_title == '' ) {
    $page_title = get_the_title();
}
if ( is_404() ) {
    $page_title = haru_get_option('page_title_404');
}
$page_sub_title = get_post_meta( get_the_ID(), 'haru_' . 'page_subtitle_custom', true );
if ( is_404() ) {
    $page_sub_title = haru_get_option('sub_page_title_404');
}

// Process page title background
$page_title_bg_images = get_post_meta( get_the_ID(), 'haru_'.'page_title_bg_image', true );
if ( $page_title_bg_images ) {
    $page_title_bg_image_url = wp_get_attachment_url( $page_title_bg_images );
} else {
    $page_title_bg_image = haru_get_option('page_title_bg_image');
    if ( is_singular('product') ) {
        $page_title_bg_image = haru_get_option('haru_single_product_title_bg_image');
    } elseif ( is_singular('haru_portfolio') ) {
        $page_title_bg_image = haru_get_option('portfolio_title_bg_image');
    } elseif ( is_singular('haru_video') ) {
        $page_title_bg_image = haru_get_option('haru_single_video_title_bg_image');
    } elseif ( is_singular('haru_digitalasset') ) {
        $page_title_bg_image = haru_get_option('haru_single_digitalasset_title_bg_image');
        
        $nearest_category = get_nearest_category_by_product_id(get_the_ID());
        if ($nearest_category) {
            $category_id = $nearest_category->term_id;
            $image = get_term_meta($category_id, 'digitalasset_category_image', true);
            if($image != null && $image != ''){
                $page_title_bg_image = [
                    'url' => $image,
                    'id' => '',
                    'height' => '',
                    'width' => '',
                    'thumbnail' => ''
                ];
                $custom_style_img_taxo = 'background-size: contain;background-repeat: no-repeat;';
            }
        }
    } elseif ( is_singular('haru_film') ) {
        $page_title_bg_image = haru_get_option('haru_single_film_title_bg_image');
    } elseif ( is_singular('post') ) {
        $page_title_bg_image = haru_get_option('single_blog_title_bg_image');
    }

    if ( is_404() ) {
        $page_title_bg_image = haru_get_option('page_404_bg_image');
    }

    if ( isset($page_title_bg_image) && isset($page_title_bg_image['url']) ) {
        $page_title_bg_image_url = $page_title_bg_image['url'];
    }
    // Set default
    if ( empty($page_title_bg_image_url) ) {
        $page_title_bg_image_url = get_template_directory_uri() . '/framework/admin-assets/images/theme-options/bg-page-title.jpg';
    }
}

// Process breadcrumb
$breadcrumbs_in_page_title = get_post_meta( get_the_ID(), 'haru_' . 'breadcrumbs_in_page_title', true );
if ( ($breadcrumbs_in_page_title == -1) || ($breadcrumbs_in_page_title === '') ) {
    $breadcrumbs_in_page_title = haru_get_option('breadcrumbs_in_page_title');

    if ( is_singular('product') ) {
        $breadcrumbs_in_page_title = haru_get_option('haru_breadcrumbs_in_single_product_title');
    } elseif ( is_singular('haru_portfolio') ) {
        $breadcrumbs_in_page_title = haru_get_option('breadcrumbs_in_portfolio_title');
    } elseif ( is_singular('haru_video') ) {
        $breadcrumbs_in_page_title = haru_get_option('haru_breadcrumbs_in_single_video_title');
    } elseif ( is_singular('haru_digitalasset') ) {
        $breadcrumbs_in_page_title = haru_get_option('haru_breadcrumbs_in_single_digitalasset_title');
    } elseif ( is_singular('haru_film') ) {
        $breadcrumbs_in_page_title = haru_get_option('haru_breadcrumbs_in_single_film_title');
    } elseif ( is_singular('post') ) {
        $breadcrumbs_in_page_title = haru_get_option('breadcrumbs_in_single_blog_title');
    }
}

if ( is_404() ) {
    $breadcrumbs_in_page_title = 0;
}

// Process page title class
$page_title_wrap_class    = array('haru-page-title-wrapper');
$section_page_title_class = array('haru-page-title-section');

$breadcrumb_class         = array('haru-breadcrumb-wrapper');
$custom_styles            = array();

if ( isset($page_title_bg_image_url) ) {
    $page_title_wrap_class[] = 'page-title-wrapper-bg';
    $custom_styles[]         = 'background-image: url(' . $page_title_bg_image_url . ')';
    isset($custom_style_img_taxo) ? $custom_styles[] = $custom_style_img_taxo : null;
}

$custom_style = '';
if ( $custom_styles ) {
    $custom_style = 'style="'. join(';',$custom_styles).'"';
}

// Process page title parallax
$page_title_parallax = get_post_meta( get_the_ID(), 'haru_' . 'page_title_parallax', true );
if ( !isset($page_title_parallax) || ($page_title_parallax == '') || ($page_title_parallax == '-1') ) {
    $page_title_parallax = haru_get_option('page_title_parallax');

    if ( is_singular('product') ) {
        $page_title_parallax = haru_get_option('haru_single_product_title_parallax');
    } elseif ( is_singular('haru_portfolio') ) {
        $page_title_parallax = haru_get_option('portfolio_title_parallax');
    } elseif ( is_singular('haru_video') ) {
        $page_title_parallax = haru_get_option('haru_single_video_title_parallax');
    } elseif ( is_singular('haru_digitalasset') ) {
        $page_title_parallax = haru_get_option('haru_single_digitalasset_title_parallax');
    } elseif ( is_singular('haru_film') ) {
        $page_title_parallax = haru_get_option('haru_single_film_title_parallax');
    } else if ( is_singular('post') ) {
        $page_title_parallax = haru_get_option('single_blog_title_parallax');
    }
}

if ( !empty($page_title_bg_image_url) && ($page_title_parallax == '1') ) {
    $custom_style            .= ' data-stellar-background-ratio="0.5"';
    $page_title_wrap_class[] = 'page-title-parallax';
}

// Process page title layout
$page_title_layout = get_post_meta( get_the_ID(), 'haru_' . 'page_title_layout', true );
if ( !isset($page_title_layout) || ($page_title_layout == '') || ($page_title_layout == '-1') ) {
    $page_title_layout = haru_get_option('page_title_layout');

    if ( is_singular('product') ) {
        $page_title_layout = haru_get_option('haru_single_product_title_layout');
    }
    elseif ( is_singular('haru_portfolio') ) {
        $page_title_layout = haru_get_option('portfolio_title_layout');
    }
    elseif ( is_singular('haru_video') ) {
        $page_title_layout = haru_get_option('haru_single_video_title_layout');
    }
    elseif ( is_singular('haru_digitalasset') ) {
        $page_title_layout = haru_get_option('haru_single_digitalasset_title_layout');
    }
    elseif ( is_singular('haru_film') ) {
        $page_title_layout = haru_get_option('haru_single_film_title_layout');
    }
    elseif ( is_singular('post') ) {
        $page_title_layout = haru_get_option('single_blog_title_layout');
    }

}

if ( in_array($page_title_layout, array('container')) ) {
    $section_page_title_class[] = $page_title_layout;
}

// Add class for style when not use breadcrumbs
if ( $breadcrumbs_in_page_title != 1 ) {
    $page_title_wrap_class[] = 'no-breadcrumbs';
}
// Check if header is header sidebar
$haru_header_layout = haru_get_header_layout();
if( ( $haru_header_layout == 'header-4' ) || ( $haru_header_layout == 'header-5' ) ) {
    $title_layout = 'full';
} else {
    $title_layout = 'container';
}
?>

<?php if ( ($show_page_title == 1) || ($breadcrumbs_in_page_title == 1) ) : ?>
    <div class="<?php echo esc_attr( join(' ',$section_page_title_class) ); ?>" <?php echo wp_kses_post($custom_style); ?>>
    <?php if ($show_page_title == 1) : ?>
        <section  class="<?php echo esc_attr( join(' ', $page_title_wrap_class) ); ?>" >
            <div class="<?php echo esc_attr( $title_layout ); ?>">
                <div class="page-title-inner">
                    <div class="block-center-inner">
                        <h2><?php echo esc_html($page_title); ?></h2>
                        <?php if ( $page_sub_title != '' ) : ?>
                            <span class="page-sub-title"><?php echo esc_html($page_sub_title) ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
    <?php if ( $breadcrumbs_in_page_title == 1 ) : ?>
        <div class="<?php echo esc_attr( join(' ',$breadcrumb_class) ); ?>">
            <div class="<?php echo esc_attr( $title_layout ); ?>">
                <?php get_template_part( 'templates/breadcrumb' ); ?>
            </div>
        </div>
    <?php endif; ?>
    </div>
<?php endif; ?>
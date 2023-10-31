<?php
/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

extract( $atts );

if ( $filter_by == 'category' ) {
    $terms = wp_get_post_terms( get_the_ID(), array('portfolio_category') );
} else {
    $terms = wp_get_post_terms( get_the_ID(), array('portfolio_tag') );
}

$cat = '';
foreach ( $terms as $term ) {
    $cat .= $term->name.', ';
}
$cat = rtrim($cat,', ');

$post_thumbnail_id = get_post_thumbnail_id( get_the_ID() );
$arrImages         = wp_get_attachment_image_src($post_thumbnail_id, 'full');
$thumbnail_url     = '';
// Process image size
if (count($arrImages) > 0) {
    switch ($portfolio_thumbnail) {
        case 'squared':
            $resize = haru_image_resize($arrImages[0], 500, 500);
            if ($resize != null && is_array($resize)) {
                $thumbnail_url = $resize['url'];
            }
            break;
        case 'landscape':
            $resize = haru_image_resize($arrImages[0], 1000, 500);
            if ($resize != null && is_array($resize)) {
                $thumbnail_url = $resize['url'];
            }
            break;
        case 'portrait':
            $resize = haru_image_resize($arrImages[0], 500, 1000);
            if ($resize != null && is_array($resize)) {
                $thumbnail_url = $resize['url'];
            }
            break;
        case 'packery':
            $portfolio_thumbnail_size = get_post_meta(get_the_ID(), 'haru_portfolio_thumbnail_size', true);
            if( $portfolio_thumbnail_size == 'small_squared' ) {
                $resize = haru_image_resize($arrImages[0], 500, 500);
            } elseif( $portfolio_thumbnail_size == 'big_squared' ) {
                $resize = haru_image_resize($arrImages[0], 1000, 1000);
            } elseif( $portfolio_thumbnail_size == 'landscape' ) {
                $resize = haru_image_resize($arrImages[0], 1000, 500);
            } elseif( $portfolio_thumbnail_size == 'portrait' ) {
                $resize = haru_image_resize($arrImages[0], 500, 1000);
            } elseif( $portfolio_thumbnail_size == '' ) {
                $resize = haru_image_resize($arrImages[0], 500, 500);
            }
            if ($resize != null && is_array($resize)) {
                $thumbnail_url = $resize['url'];
            }
            break;
        default:
            $thumbnail_url = $arrImages[0];
            break;
    }
}

// Lightbox render
$url_origin     = $arrImages[0];
$portfolio_type = get_post_meta(get_the_ID(), 'haru_portfolio_media_type', true);
switch ($portfolio_type) {
    case 'image':
        $data_rel = $url_origin;
        break;
    case 'gallery':
        $data_rel = $url_origin;
        break;
    case 'link':
        $data_rel = get_post_meta(get_the_ID(), 'haru_portfolio_data_format_link_url', true);
        break;
    case 'video':
        $data_rel = get_post_meta(get_the_ID(), 'haru_portfolio_data_format_video', true);
        break;
    default:
        $data_rel = $url_origin;
        break;
}

?>
<div class="portfolio-thumbnail title">
    <img src="<?php echo esc_url($thumbnail_url) ?>" alt="<?php echo get_the_title() ?>"/>
    <div class="portfolio-thumbnail-hover">
        <div class="portfolio-thumbnail-bottom">
            <a href="<?php echo get_permalink(get_the_ID()); ?>" class="hover-title"><?php the_title(); ?></a>
        </div>
    </div>
</div>
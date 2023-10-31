<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.3.2
 */

defined( 'ABSPATH' ) || exit;

global $post, $product;

// Product style
$single_product_style = get_post_meta( get_the_ID(), 'haru_' . 'single_product_style', true );
if ( !in_array($single_product_style, array('horizontal', 'vertical', 'vertical_gallery')) ) {
    $single_product_style = haru_get_option('haru_single_product_style');
}
// Set default
if ( empty($single_product_style) ) {
    $single_product_style = 'horizontal';
}

$index          = 0;
$product_images = array();
$image_ids      = array();

// Thumbnail image
if ( has_post_thumbnail() ) {
    $product_images[$index] = array(
        'image_id' => get_post_thumbnail_id()
    );
    $image_ids[$index] = get_post_thumbnail_id();
    $index++;
}

// Gallery images
$attachment_ids = $product->get_gallery_image_ids();
if ($attachment_ids) {
    foreach ( $attachment_ids as $attachment_id ) {
        if ( in_array($attachment_id,$image_ids) ) continue;
        $product_images[$index] = array(
            'image_id' => $attachment_id
        );
        $image_ids[$index] = $attachment_id;
        $index++;
    }
}

// Product variable images
if ( $product->is_type( 'variable' ) ) {
    $available_variations = $product->get_available_variations();
    if ( isset($available_variations) ) {
        foreach ( $available_variations as $available_variation ) {
            $variation_id = $available_variation['variation_id'];
            if (has_post_thumbnail($variation_id)) {
                $variation_image_id = get_post_thumbnail_id($variation_id);

                if (in_array($variation_image_id,$image_ids)) {
                    $index_of = array_search($variation_image_id, $image_ids);
                    if (isset($product_images[$index_of]['variation_id'])) {
                        $product_images[$index_of]['variation_id'] .= $variation_id . '|';
                    } else {
                        $product_images[$index_of]['variation_id'] = '|' . $variation_id . '|';
                    }
                    continue;
                }

                $product_images[$index] = array(
                    'image_id'     => $variation_image_id,
                    'variation_id' => '|' . $variation_id . '|'
                );
                $image_ids[$index] = $variation_image_id;
                $index++;
            }
        }
    }
}
$attachment_count = count($attachment_ids);
if ( $attachment_count > 0 ) {
    $gallery = '[product-gallery]';
} else {
    $gallery = '';
}

// Process options

$single_product_thumbnail_columns = get_post_meta( get_the_ID(), 'haru_' . 'single_product_thumbnail_columns', true );
if ( !in_array($single_product_thumbnail_columns, array('2', '3', '4', '5')) ) {
    $single_product_thumbnail_columns = haru_get_option('haru_single_product_thumbnail_columns');
}
// Set default
if ( empty($single_product_thumbnail_columns) ) {
    $single_product_thumbnail_columns = '4';
}

$single_product_thumbnail_position = get_post_meta( get_the_ID(), 'haru_' . 'single_product_thumbnail_position', true );
if ( !in_array($single_product_thumbnail_position, array('thumbnail-left', 'thumbnail-right')) ) {
    $single_product_thumbnail_position = haru_get_option('haru_single_product_thumbnail_position');
}
// Set default
if ( empty($single_product_thumbnail_position) ) {
    $single_product_thumbnail_position = 'thumbnail-left';
}

wp_enqueue_script( 'one-page-nav', get_template_directory_uri() . '/assets/libraries/one-page-nav/jquery.nav.js', array( 'jquery' ), '', true );
wp_enqueue_script( 'sticky-kit', get_template_directory_uri() . '/assets/libraries/sticky-kit/jquery.sticky-kit.min.js', array( 'jquery' ), '', true );
?>

<div class="single-product-image-inner">
    <div id="product-images">
        <?php
            foreach($product_images as $key => $value) {
                $index         = $key;
                $image_id      = $value['image_id'];
                $variation_id  = isset($value['variation_id']) ? $value['variation_id'] : '' ;
                $image_title   = esc_attr( get_the_title( $image_id ) );
                $image_caption = '';
                $image_obj     = get_post( $image_id );
                if ( isset($image_obj) && isset($image_obj->post_excerpt) ) {
                    $image_caption  = $image_obj->post_excerpt;
                }
                
                $image_link     = wp_get_attachment_url( $image_id );
                $image          = wp_get_attachment_image( $image_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
                    'title' => $image_title,
                    'alt'   => $image_title
                ) );

                echo sprintf( '<div id="product-image-%s" class="woocommerce-image-zoom">', $image_id );
                if ( !empty($variation_id) ) {
                    echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image" title="%s" data-rel="prettyPhoto' . $gallery . '" data-variation_id="%s" data-index="%s"><i class="ion-ios-search"></i></a>%s', $image_link, $image_caption, $variation_id, $index, $image ), $post->ID );
                } else {
                    echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image" title="%s" data-rel="prettyPhoto' . $gallery . '" data-index="%s"><i class="ion-ios-search"></i></a>%s', $image_link, $image_caption, $index, $image ), $post->ID );
                }
                echo '</div>';
            }
        ?>
    </div>
    <?php
        $haru_product_video_url = get_post_meta( get_the_ID(), 'haru_product_video_url', true );
        if (filter_var($haru_product_video_url, FILTER_VALIDATE_URL) == TRUE) :
    ?>
        <p class="product-video"><a href="<?php echo esc_url($haru_product_video_url); ?>" class="product-video-link" title="<?php echo esc_attr__( 'View Video', 'haru-circle' ); ?>" ><i class="ion ion-ios-play"></i><?php echo esc_html__( 'Video', 'haru-circle' ); ?></a></p>
    <?php endif; ?>
    <div id="product-thumbnails">
        <?php
            foreach($product_images as $key => $value) {
                $index         = $key;
                $image_id      = $value['image_id'];
                $variation_id  = isset($value['variation_id']) ? $value['variation_id'] : '' ;
                $image_title   = esc_attr( get_the_title( $image_id ) );
                $image_caption = '';
                $image_obj     = get_post( $image_id );
                if (isset($image_obj) && isset($image_obj->post_excerpt)) {
                    $image_caption  = $image_obj->post_excerpt;
                }

                $image_link     = wp_get_attachment_url( $image_id );
                $image          = wp_get_attachment_image( $image_id,  apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ), array(
                    'title' => $image_title,
                    'alt'   => $image_title
                ) );
                echo '<div class="thumbnail-image">';
                if ( !empty($variation_id) ) {
                    echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<a href="#product-image-%s" itemprop="image" class="woocommerce-thumbnail-image" title="%s" data-variation_id="%s" data-index="%s">%s</a>',$image_id, $image_caption,$variation_id,$index,  $image ), $post->ID );
                } else {
                    echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<a href="#product-image-%s" itemprop="image" class="woocommerce-thumbnail-image" title="%s" data-index="%s">%s</a>',$image_id, $image_caption,$index , $image), $post->ID );
                }
                echo '</div>';
            }
        ?>
    </div>
</div>
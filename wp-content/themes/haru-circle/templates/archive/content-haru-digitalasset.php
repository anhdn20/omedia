<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

// Process archive post class
$archive_display_columns = isset($_GET['columns']) ? $_GET['columns'] : '';
if ( !in_array($archive_display_columns, array('2','3','4')) ) {
    $archive_display_columns = haru_get_option('archive_digitalasset_display_columns');
} 
// Class archive blog
$archive_display_type = isset($_GET['style']) ? $_GET['style'] : '';
if ( $archive_display_type == '' ) {
    $archive_display_type = haru_get_option('archive_digitalasset_display_type');
}

$post_classes[] = haru_get_option('archive_digitalasset_display_type');
if ( in_array($archive_display_type, array('grid','masonry')) ) {
    if ( $archive_display_columns == '2' ) {
        $post_classes[] = 'col-md-6 col-sm-6 col-xs-12';
    } elseif ( $archive_display_columns == '3' ) {
        $post_classes[] = 'col-md-4 col-sm-6 col-xs-12';
    } elseif ( $archive_display_columns == '4' ) {
        $post_classes[] = 'col-md-3 col-sm-6 col-xs-12';
    }
} else {
    $post_classes[] = 'col-md-12 col-sm-12 col-xs-12';
}

$post_excerpt = haru_get_option('archive_digitalasset_number_exceprt');
if ( !empty($post_excerpt) ) {
    $post_excerpt = haru_get_option('archive_digitalasset_number_exceprt');
}
// Set Default
else {
    $post_excerpt = 30; // Need to change to other number to show all post_content
}

$digitalasset_id = get_the_ID();
$thumbnail_video = get_post_meta( $digitalasset_id, 'haru_digitalasset' . '_thumbnail_video', true );
$available = get_post_meta( $digitalasset_id, 'haru_digitalasset' . '_available', true );

?>
<article id="post-<?php the_ID(); ?>" <?php post_class($post_classes); ?> >
    <div class="post-wrapper clearfix">
        <div class="dgtass-item style_1" onclick="void(0)">
            <div class="dgtass-available">
                <?php echo esc_html($available); ?>
            </div>
            <div class="dgtass-thumbnail">
                <a href="<?php echo esc_url( get_the_permalink() ); ?>">
                    <?php if($thumbnail_video == '') : ?>
                        <div class="dgtass-thumbnail-image">
                            <picture>
                                <?php
                                    $thumbnail_image = get_post_meta( $digitalasset_id, 'haru_digitalasset' . '_thumbnail_images', true );
                                ?>
                                <source media="(min-width: 900px)" srcset="<?=$thumbnail_image?>">
                                <source media="(max-width: 480px)" srcset="<?=$thumbnail_image?>">
                                <img src="<?=$thumbnail_image?>" alt="<?php echo esc_attr( get_the_title( $digitalasset_id ) ); ?>">
                            </picture>
                        </div>
                    <?php else: ?>
                        <div class="dgtass-thumbnail-video">
                            <video src="<?php echo $thumbnail_video;?>" title="<?php echo esc_attr( get_the_title( $digitalasset_id ) ); ?>" muted="muted">
                                <source src="<?php echo $thumbnail_video;?>" type="video/mp4">
                            </video>
                        </div>
                    <?php endif; ?>
                </a>
            </div>
            <div class="dgtass-meta">
                    <div class="dgtass-name">
                        <div class="dgtass-title"><a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a></div>
                        <span class="dgtass-author">by <?php echo get_the_author(); ?></span>
                    </div>
                    <div class="dgtass-info">
                        <div class="dgtass-category"><?php echo explode(',',get_the_term_list( get_the_ID(), 'digitalasset_category','', ','))[0] ?? ''; ?></div>
                        <div class="dgtass-price">
                            <?php
                                $price = get_post_meta( $digitalasset_id, 'haru_digitalasset' . '_price', true );
                                echo $price;
                            ?>
                        </div>
                    </div>
            </div>
    </div>
</article>
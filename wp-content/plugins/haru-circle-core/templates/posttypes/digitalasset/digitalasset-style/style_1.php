<?php
/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

$digitalasset_id = get_the_ID();
$thumbnail_video = get_post_meta( $digitalasset_id, 'haru_digitalasset' . '_thumbnail_video', true );

$terms          = wp_get_post_terms(get_the_ID(), array('digitalasset_category'));
$filter_name = $filter_slug = '';
foreach ( $terms as $term ) {
    $filter_slug .= $term->slug . ' ';
    $filter_name .= $term->name . ' ';
}

?>
<div class="dgtass-item style_1 <?php echo esc_attr( $filter_slug ); ?>" onclick="void(0)">
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
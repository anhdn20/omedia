<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

?>
<div class="post-related clearfix">
    <h6 class="related-title"><?php echo esc_html__( 'You may also like this', 'haru-circle' ); ?></h6>
    <div class="haru-carousel related-list owl-carousel owl-theme"
        data-items="2"
        data-margin="30"
        data-autoplay="false"
        data-slide-duration="5000"
    >
        <?php 
            $args = array(
                'post__not_in'       => array( get_the_ID() ),
                'posts_per_page'     => 2, // 2+1?
                'orderby'            => array( 'type', 'rand' ),
                'post_type'          => 'post',
                'post_status'        => 'publish'
            );
            $related_posts         = new WP_Query( $args );
        ?>
        <?php 
            if ( $related_posts->have_posts() ) :
                while ( $related_posts->have_posts() ) : $related_posts->the_post();
        ?>
            <div class="related-item">
                <div class="post-image">
                    <?php the_post_thumbnail(); ?>
                </div>
                <div class="post-meta">
                    <?php echo get_the_term_list( get_the_ID(), 'category', '', ', ' ); ?>
                    <h5 class="post-title"><a href="<?php echo esc_url( get_the_permalink() ); ?>" target="_self"><?php the_title(); ?></a></h5>
                </div>
            </div>
        <?php 
                endwhile;
            endif;
            wp_reset_query();
        ?>
    </div>
    <div class="clear"></div>
</div>
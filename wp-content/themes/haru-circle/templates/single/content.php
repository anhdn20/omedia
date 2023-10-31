<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="post-wrapper">
        <div class="post-meta-wrapper">
            <?php get_template_part( 'templates/single/post-meta' ); ?>
        </div>
        <?php
            $thumbnail = haru_post_thumbnail();
            if ( !empty($thumbnail) ) : 
        ?>
            <div class="post-thumbnail-wrapper">
                <?php echo wp_kses_post( $thumbnail ); ?>
            </div>
        <?php endif; ?>
        <div class="post-content-wrapper">
            <div class="post-content">
                <?php the_content(); ?>
            </div>
            
            <div class="post-other-meta">
                <?php
                /**
                 * @hooked - haru_link_pages - 5
                 * @hooked - haru_post_tags - 10
                 * @hooked - haru_share - 15
                 *
                 **/
                do_action('haru_after_single_post_content');
                ?>
            </div>
        </div>
    </div>
</article>
<?php 
/**
 * @hooked - haru_post_nav - 5
 * @hooked - haru_post_author - 10
 * @hooked - haru_post_related - 15
 *
 **/
do_action('haru_after_single_post');
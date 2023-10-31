<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

extract( $atts );

global $paged;

if (is_front_page()) {
    $paged   = get_query_var( 'page' ) ? intval( get_query_var( 'page' ) ) : 1;
} else {
    $paged   = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
}

$args = array(
    'post_type'      => 'post',
    'posts_per_page' => $posts_per_page,
    'orderby'        => $orderby,
    'order'          => $order,
    'paged'          => $paged,
    'category_name'  => strtolower($category),
    'post_status'    => 'publish'
);

$posts = new WP_Query($args);

$featured_args = array(
    'p'           => $post_id,
    'post_type'   => 'post',
    'post_status' => 'publish'
);

$featured_post = new WP_Query($featured_args);

// Enqueue assets
wp_enqueue_script( 'imagesloaded', get_template_directory_uri() . '/assets/libraries/imagesloaded/imagesloaded.min.js', false, true );
wp_enqueue_script( 'isotope', get_template_directory_uri() . '/assets/libraries/isotope/isotope.pkgd.min.js', false, true );
wp_enqueue_script( 'isotope-packery-mode', plugins_url() . '/haru-circle-core/includes/shortcodes/blog/assets/packery-mode.pkgd.min.js', false, true );
?>
<?php if ( $posts->have_posts() ) : ?>
    <div class="blog-shortcode-wrapper <?php echo $layout_type . ' ' . $el_class ?>">
        <div class="blog-list columns-<?php echo esc_attr( $columns ); ?>">
        <?php if( $featured_post ) : ?>
            <?php while( $featured_post->have_posts() ) : $featured_post->the_post(); ?>
                <article class="blog-item featured-post">
                    <div class="post-thumbnail">
                        <div class="post-image">
                            <?php echo get_the_post_thumbnail( $post_id ); ?>
                        </div>
                    </div>
                    <div class="post-content">
                        <div class="post-category">
                            <?php if ( has_category() ) : ?>
                                <?php echo get_the_category_list(', ', $post_id); ?>
                            <?php endif; ?>
                        </div>
                        <h3 class="post-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
                        <p class="post-excerpt">
                            <?php 
                                if ( has_excerpt() ) {
                                    echo wp_trim_words( get_the_excerpt(), $excerpt_length + 10, '...' ); 
                                } else {
                                    echo wp_trim_words( get_the_content(), $excerpt_length + 10, '...' ); 
                                }
                            ?>
                        </p>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php endif; ?>        
        <?php while( $posts->have_posts() ) : $posts->the_post(); ?>
            <article class="blog-item">
                <div class="post-thumbnail">
                    <div class="post-image">
                        <?php the_post_thumbnail(); ?>
                    </div>
                </div>
                <div class="post-content">
                    <div class="post-category">
                        <?php if ( has_category() ) : ?>
                            <?php echo get_the_category_list(', '); ?>
                        <?php endif; ?>
                    </div>
                    <h3 class="post-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
                    <p class="post-excerpt">
                        <?php 
                            if ( has_excerpt() ) {
                                echo wp_trim_words( get_the_excerpt(), $excerpt_length, '...' ); 
                            } else {
                                echo wp_trim_words( get_the_content(), $excerpt_length, '...' ); 
                            }
                        ?>
                    </p>
                </div>
            </article>
        <?php endwhile; ?>
        </div>

        <?php if ( $posts->max_num_pages > 1 ) : ?>
            <div class="blog-shortcode-paging <?php echo esc_attr($paging_style); ?>">
                <?php
                    switch($paging_style) {
                        case 'load-more':
                            haru_paging_load_more_blog($posts);
                            break;
                        case 'infinity-scroll':
                            haru_paging_infinitescroll_blog($posts);
                            break;
                        default:
                            echo haru_paging_nav_blog($posts);
                            break;
                    }
                ?>
            </div>
        <?php endif;?>
    </div>
<?php else : ?>
    <div class="item-not-found"><?php echo esc_html__( 'No item found', 'haru-circle' ) ?></div>
<?php endif; ?>
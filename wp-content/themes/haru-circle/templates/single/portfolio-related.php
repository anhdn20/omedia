<?php
/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

$column       = 4;
if( NULL !== haru_get_option('portfolio_related_column') ) {
    $column = haru_get_option('portfolio_related_column');
}
?>

<?php 
    // Get portfolio related by category
    $custom_taxterms = wp_get_object_terms( get_the_ID(), 'portfolio_category', array('fields' => 'ids') );

    $args = array(
        'post__not_in'       => array( get_the_ID() ),
        'posts_per_page'     => 6,
        'orderby'            => 'rand',
        'post_type'          => 'haru_portfolio',
        'post_status'        => 'publish',
        'tax_query' => array(
            array(
                'taxonomy' => 'portfolio_category',
                'field' => 'id',
                'terms' => $custom_taxterms
            )
        ),

    );
    $related_portfolios         = new WP_Query( $args );
?>
<?php if ( $related_portfolios->have_posts() ) : ?>
<div class="single-portfolio-related">
    <p class="related-title"><?php echo esc_html__( 'Related Projects', 'haru-circle' ); ?></p>
    <div class="haru-carousel related-list owl-carousel owl-theme"
        data-items="<?php echo esc_attr( $column ); ?>"
        data-margin="30"
        data-autoplay="false"
        data-slide-duration="5000"
    >
        <?php while ( $related_portfolios->have_posts() ) : $related_portfolios->the_post(); ?>
            <div class="portfolio-related">
                <div class="portfolio-image">
                    <?php
                        $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(),'full');
                        $img  = '';
                        if( $thumbnail_url ) {
                            $resize = haru_image_resize($thumbnail_url,600,400);
                            if( $resize != null && is_array($resize) )
                                $img = $resize['url'];
                        }
                    ?>
                    <img src="<?php echo esc_url( $img ); ?>" alt="<?php the_title(); ?>">
                </div>
                <div class="portfolio-meta">
                    <h5 class="portfolio-title"><a href="<?php echo esc_url( get_the_permalink() ); ?>" target="_self"><?php the_title(); ?></a></h5>
                    <div class="portfolio-category">
                        <p>
                            <?php
                                $terms = wp_get_object_terms(get_the_ID(), 'portfolio_category');
                                $cat = '';
                                foreach ( $terms as $term ) {
                                    $cat .= $term->name.', ';
                                }
                                $cat = rtrim($cat,', ');
                                echo wp_kses_post($cat);
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>
<?php
    endif;
    wp_reset_query();
?>
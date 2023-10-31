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

global $paged;

if ( is_front_page() ) {
    $paged   = get_query_var( 'page' ) ? intval( get_query_var( 'page' ) ) : 1;
} else {
    $paged   = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
}

$films_paging_class   = array('film-shortcode-paging-wrapper');
$films_paging_class[] = 'paging-' . $paging_style;        

$args = array(
    'post__in'       => explode(",", $film_ids),
    'posts_per_page' => $posts_per_page, // -1 is Unlimited film
    'orderby'        => $orderby,
    'order'          => $order,
    'post_type'      => 'haru_film',
    'paged'          => $paged,
    'post_status'    => 'publish'
);

if ( $data_source == '' ) {
    $args = array(
        'posts_per_page' => $posts_per_page, // -1 is Unlimited film
        'orderby'        => $orderby,
        'order'          => $order,
        'post_type'      => 'haru_film',
        'paged'          => $paged,
        'post_status'    => 'publish',
        'tax_query'      => array(
            array(
                'taxonomy' => 'film_category',
                'field'    => 'slug',
                'terms'    => explode(',', $category),
            )
        )
    );
}

$films = new WP_Query($args);

// Enqueue assets
wp_enqueue_script( 'imagesloaded', get_template_directory_uri() . '/assets/libraries/imagesloaded/imagesloaded.min.js', false, true );
wp_enqueue_script( 'isotope', get_template_directory_uri() . '/assets/libraries/isotope/isotope.pkgd.min.js', false, true );
?>
<?php if ( $films->have_posts() ) : ?>
    <div class="film-shortcode-wrapper <?php echo esc_attr( $layout_type . ' ' . $el_class); ?>">
        <div class="film-content">
            <?php
                $slugSelected = explode(',', $category);
                $terms = get_terms(
                    array(
                        'taxonomy'  => 'film_category',
                        'slug'      => $slugSelected,
                        'orderby'   => 'slug__in',
                    )
                );
            ?>
            <ul data-option-key="filter" class="film-filter <?php echo esc_attr( $filter . ' ' . $filter_style . ' ' . $filter_align ); ?>">
                <li>
                    <a class=""
                        href="javascript:;" 
                        data-option-value="*"
                    ><?php echo esc_html__( 'All', 'haru-circle' ); ?></a>
                </li>
                <?php foreach ($terms as $term) : ?>
                <li>
                    <a class=""
                        href="javascript:;" 
                        data-option-value =".<?php echo esc_attr($term->slug); ?>"
                    ><?php echo wp_kses_post( $term->name ); ?></a>
                </li>
                <?php endforeach; ?>
            </ul>

            <div class="film-list columns-<?php echo esc_attr( $columns ); ?>">
                <?php while( $films->have_posts() ) : $films->the_post(); ?>
                    <?php echo haru_get_template('posttypes/film/film-style/'. $film_style .'.php', '', '', '' ); ?>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
    <?php if ( ( $films->max_num_pages > 1 ) && ( $paging_style != 'none' ) ) : ?>
        <div class="<?php echo join(' ', $films_paging_class); ?>">
            <?php
                switch ( $paging_style ) {
                    case 'load-more':
                        haru_paging_load_more_film($films);
                        break;
                    case 'infinity-scroll':
                        haru_paging_infinitescroll_film($films);
                        break;
                    default:
                        echo haru_paging_nav_film($films);
                        break;
                }
            ?>
        </div>
    <?php endif; ?>
<?php else : ?>
    <div class="item-not-found"><?php echo esc_html__( 'No item found', 'haru-circle' ) ?></div>
<?php endif; ?>
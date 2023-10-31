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
// Need change to config
$paging_style = 'loadmore';

global $wp, $paged;
            
if ( is_front_page() ) {
    $paged   = get_query_var( 'page' ) ? intval( get_query_var( 'page' ) ) : 1;
} else {
    $paged   = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
}  

$args = array(
    'posts_per_page' => $posts_per_page, // -1 is Unlimited film
    'orderby'        => 'date',
    'order'          => 'DESC',
    'post_type'      => 'haru_film',
    'paged'          => $paged,
    'post_status'    => 'publish'
);
$films = new WP_Query($args);
// Enqueue assets
wp_enqueue_script( 'imagesloaded', get_template_directory_uri() . '/assets/libraries/imagesloaded/imagesloaded.min.js', false, true );
wp_enqueue_script( 'isotope', get_template_directory_uri() . '/assets/libraries/isotope/isotope.pkgd.min.js', false, true );
?>
<?php if ( $films->have_posts() ) : ?>
    <div class="film-search-form-shortcode-wrapper <?php echo esc_attr( $layout_type . ' ' . $el_class); ?>">
        <!-- FILM SEARCH FORM -->
        <form role="search" method="get" id="film-searchform" class="film-searchform" action="<?php echo esc_url(site_url()); ?>">
            <div class="data-search" 
                data-current_page="<?php echo esc_url( home_url(add_query_arg(array(),$wp->request)) ); ?>" 
                data-columns="<?php echo esc_attr( $columns ); ?>" 
                data-film_style="<?php echo esc_attr( $film_style ); ?>"
                data-paging_style="<?php echo esc_attr( $paging_style ); ?>"
                data-per_page="<?php echo esc_attr( $posts_per_page ); ?>">

                <input type="text" value="" name="s" id="s" placeholder="<?php echo esc_html__( 'Search for a Movie, Film...', 'haru-circle' ); ?>" />
                
                <select name="category" id="category">
                    <option value=""><?php echo esc_html__( 'Category', 'haru-circle' ); ?></option>
                    <?php 
                        $terms = get_terms( array(
                            'taxonomy' => 'film_category',
                            'hide_empty' => false,
                        ) );
                    ?>
                    <?php foreach ( $terms as $term ) : ?>
                    <option value="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_attr( $term->name ); ?></option>
                    <?php endforeach; ?>
                </select>

                <select name="country" id="country">
                    <option value=""><?php echo esc_html__( 'Country', 'haru-circle' ); ?></option>
                    <?php 
                        $terms = get_terms( array(
                            'taxonomy' => 'film_country',
                            'hide_empty' => false,
                        ) );
                    ?>
                    <?php foreach ( $terms as $term ) : ?>
                    <option value="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_attr( $term->name ); ?></option>
                    <?php endforeach; ?>
                </select>

                <select name="year" id="year">
                    <option value=""><?php echo esc_html__( 'Year', 'haru-circle' ); ?></option>
                    <?php 
                        $terms = get_terms( array(
                            'taxonomy' => 'film_year',
                            'hide_empty' => false,
                        ) );
                    ?>
                    <?php foreach ( $terms as $term ) : ?>
                    <option value="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_attr( $term->name ); ?></option>
                    <?php endforeach; ?>
                </select>

                <select name="sort" id="sort">
                    <option value=""><?php echo esc_html__( 'Sort By', 'haru-circle' ); ?></option>
                    <option value="date-desc"><?php echo esc_html__( 'Newest', 'haru-circle' ); ?></option>
                    <option value="date-asc"><?php echo esc_html__( 'Oldest', 'haru-circle' ); ?></option>
                    <option value="title-desc"><?php echo esc_html__( 'Title (A->Z)', 'haru-circle' ); ?></option>
                    <option value="title-asc"><?php echo esc_html__( 'Title (Z->A)', 'haru-circle' ); ?></option>
                    <option value="rand"><?php echo esc_html__( 'Random', 'haru-circle' ); ?></option>
                </select>

                <input type="hidden" name="post_type" value="haru_film" />
                <input type="submit" id="searchsubmit" value="<?php echo esc_html__( 'Find Movies', 'haru-circle' ); ?>" class="search-film"/>
            </div>
        </form>
        <!-- END FILM SEARCH FORM -->
        <div class="film-content">
            <div class="film-list columns-<?php echo esc_attr( $columns ); ?>">
                <?php while( $films->have_posts() ) : $films->the_post(); ?>
                    <?php echo haru_get_template('posttypes/film/film-style/'. $film_style .'.php', '', '', '' ); ?>
                <?php endwhile; ?>
            </div>
            <!-- Pagination -->
            <?php if ( ( $films->max_num_pages > 1 ) ) : ?>
                <div class="film-search-form-shortcode-paging-wrapper paging-load-more">
                    <?php
                        haru_paging_load_more_film_search($films);
                    ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php else : ?>
    <div class="item-not-found"><?php echo esc_html__( 'No item found', 'haru-circle' ) ?></div>
<?php endif; ?>
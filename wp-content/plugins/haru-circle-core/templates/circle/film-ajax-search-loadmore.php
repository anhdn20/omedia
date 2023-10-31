<?php
/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/


$_s            = $_POST['input'];
$_category     = $_POST['category'];
$_country      = $_POST['country'];
$_year         = $_POST['year'];
$_sort         = $_POST['sort'];
$_columns      = $_POST['columns'];
$_film_style   = $_POST['film_style'];
$_paging_style = $_POST['paging_style'];
$_per_page     = $_POST['per_page'];
$_current_page = $_POST['current_page'];
$_offset       = $_POST['offset'];

if ( is_front_page() ) {
    $paged   = get_query_var( 'page' ) ? intval( get_query_var( 'page' ) ) : 1;
} else {
    $paged   = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
} 

// Sort
if ( $_sort == '' ) {
    $orderby = 'date';
    $order = 'DESC';
} elseif ( $_sort == 'date-desc' ) {
    $orderby = 'date';
    $order = 'DESC';
} elseif ( $_sort == 'date-asc' ) {
    $orderby = 'date';
    $order = 'ASC';
} elseif ( $_sort == 'title-desc' ) {
    $orderby = 'title';
    $order = 'DESC';
} elseif ( $_sort == 'title-asc' ) {
    $orderby = 'title';
    $order = 'ASC';
} elseif ( $_sort == 'rand' ) {
    $orderby = 'rand';
    $order = 'DESC';
} else {
    $orderby = 'date';
    $order = 'DESC';
}

$args = array(
    'posts_per_page' => $_per_page, // -1 is Unlimited film
    's'              => $_s,
    'order'          => $order,
    'orderby'        => $orderby, // or 'meta_value'
    'post_type'      => 'haru_film',
    'offset'         => $_offset,
    'paged'          => $paged,
    'post_status'    => 'publish',
    'tax_query'      => array(),
    'meta_query'     => array()
);

// Check Search Form Fields
if ( $_category != '' ) {
    $args['tax_query'][] = array(
        'taxonomy' => 'film_category',
        'field'    => 'slug',
        'terms'    => explode(',', $_category),
    );
}

if ( $_country != '' ) {
    $args['tax_query'][] = array(
        'taxonomy' => 'film_country',
        'field'    => 'slug',
        'terms'    => explode(',', $_country),
    );
}

if ( $_year != '' ) {
    $args['tax_query'][] = array(
        'taxonomy' => 'film_year',
        'field'    => 'slug',
        'terms'    => explode(',', $_year),
    );
}

$filmSearchQuery = new WP_Query( $args );

?>

<div class="list-item">
<?php if ( $filmSearchQuery->have_posts() ) :
        // Start the Loop.
        while ( $filmSearchQuery->have_posts() ) : $filmSearchQuery->the_post();
        $film_label = get_post_meta( get_the_ID(), 'haru_film_label', true );
        $film_rating = get_post_meta( get_the_ID(), 'haru_film_rating', true );
        ?>
        <!-- Also use this layout for archive -->
        <div class="film-item <?php echo esc_attr( $_film_style ); ?>">
            <div class="film-image">
                <?php the_post_thumbnail(); ?>
                <?php if ( $film_label != '' ) : ?>
                    <div class="film-label <?php echo esc_attr( $film_label ); ?>">
                        <?php 
                            if ( $film_label == 'new' ) {
                                echo esc_html__( 'New', 'haru-circle' );
                            }
                            if ( $film_label == 'hot' ) {
                                echo esc_html__( 'Hot', 'haru-circle' );
                            } 
                            if ( $film_label == 'trending' ) {
                                echo esc_html__( 'Trending', 'haru-circle' );
                            }
                        ?>
                    </div>
                <?php endif; ?>
                <div class="film-icon"><a href="javascript:;" class="view-film-button" data-id="<?php echo esc_attr( get_the_ID() ); ?>" alt=""></a></div>
            </div>
            <div class="film-meta">
                <div class="film-rating"><span class="point"><?php echo esc_html( $film_rating ); ?></span><span class="total"><?php echo esc_html__( '/10', 'haru-circle' ); ?></span></div>
                <h3 class="film-title"><a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a></h3>
                <div class="film-category"><?php echo get_the_term_list( get_the_ID(), 'film_category', '', ' / ' ); ?></div>
            </div>
        </div>
        <?php
    endwhile;

else :
    // If no content, include the "No posts found" template. Need to check if $filmSearchQuery items < perpage to fix load more click hide
?>
    <div class="no-more-item"><?php echo esc_html__( 'It seems we can’t find what you’re looking for. Please try other search', 'haru-circle' ); ?></div>
<?php
endif;
?>
</div>
<?php
wp_reset_postdata();
die;

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
    $archive_display_columns = haru_get_option('archive_film_display_columns');
} 
// Class archive blog
$archive_display_type = isset($_GET['style']) ? $_GET['style'] : '';
if ( $archive_display_type == '' ) {
    $archive_display_type = haru_get_option('archive_film_display_type');
}

$post_classes[] = haru_get_option('archive_film_display_type');
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

$post_excerpt = haru_get_option('archive_film_number_exceprt');
if ( !empty($post_excerpt) ) {
    $post_excerpt = haru_get_option('archive_film_number_exceprt');
}
// Set Default
else {
    $post_excerpt = 30; // Need to change to other number to show all post_content
}

$film_label = get_post_meta( get_the_ID(), 'haru_film_label', true );
$film_rating = get_post_meta( get_the_ID(), 'haru_film_rating', true );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($post_classes); ?> >
    <div class="film-detail">
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
                            echo esc_html__( 'Trend', 'haru-circle' );
                        }
                    ?>
                </div>
            <?php endif; ?>
            <?php
                $player_type = haru_get_option('player_type');
                if ( $player_type == 'player_popup' ) :
            ?>
            <div class="film-icon"><a href="javascript:;" class="view-film-button" data-id="<?php echo esc_attr( get_the_ID() ); ?>"></a></div>
            <?php else : ?>
                <div class="film-icon"><a href="<?php echo esc_url( get_the_permalink() ); ?>" class="view-film-button-direct"></a></div>
            <?php endif; ?>
        </div>
        <div class="film-meta">
            <div class="film-rating"><span class="point"><?php echo esc_html( $film_rating ); ?></span><span class="total"><?php echo esc_html__( '/10', 'haru-circle' ); ?></span></div>
            <h3 class="film-title"><a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a></h3>
            <div class="film-category"><?php echo get_the_term_list( get_the_ID(), 'film_category', '', ' / ' ); ?></div>
        </div>
    </div>
</article>
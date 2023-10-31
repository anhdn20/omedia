<?php
/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/
$terms          = wp_get_post_terms(get_the_ID(), array('film_category'));
$filter_name = $filter_slug = '';
foreach ( $terms as $term ) {
    $filter_slug .= $term->slug . ' ';
    $filter_name .= $term->name . ' ';
}
$film_label = get_post_meta( get_the_ID(), 'haru_film_label', true );
$film_rating = get_post_meta( get_the_ID(), 'haru_film_rating', true );
?>
<div class="film-item style_2 <?php echo esc_attr( $filter_slug ); ?>" onclick="void(0)">
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
            $player_js = haru_get_option('player_js');
            if ( $player_type == 'player_popup' ) :
        ?>
        <div class="film-icon">
            <a href="javascript:;" class="view-film-button" data-id="<?php echo esc_attr( get_the_ID() ); ?>" data-player="<?php echo esc_attr( $player_js ); ?>" data-server=""></a>
        </div>
        <?php else : ?>
            <div class="film-icon">
                <a href="<?php echo esc_url( get_the_permalink() ); ?>" class="view-film-button-direct"></a>
            </div>
        <?php endif; ?>
        <div class="film-rating"><span class="point"><?php echo esc_html( $film_rating ); ?></span><span class="total"><?php echo esc_html__( '/10', 'haru-circle' ); ?></span></div>
    </div>
    <div class="film-meta">
        <h3 class="film-title"><a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a></h3>
    </div>
</div>
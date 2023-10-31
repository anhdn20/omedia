<?php
/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/
$terms          = wp_get_post_terms(get_the_ID(), array('trailer_category'));
$filter_name = $filter_slug = '';
foreach ( $terms as $term ) {
    $filter_slug .= $term->slug . ' ';
    $filter_name .= $term->name . ' ';
}

?>
<div class="trailer-item style_2 <?php echo esc_attr( $filter_slug ); ?>" onclick="void(0)">
    <div class="trailer-image">
        <?php the_post_thumbnail(); ?>
        <div class="trailer-label hot"><?php echo esc_html__( 'Hot', 'haru-circle' ); ?></div>
        <?php
            $player_js = haru_get_option('player_js');
        ?>
        <div class="trailer-icon">
            <a href="javascript:;" class="view-trailer-button" data-id="<?php echo esc_attr( get_the_ID() ); ?>" data-player="<?php echo esc_attr( $player_js ); ?>" data-server=""></a>
        </div>
        <div class="trailer-rating"><span class="point"><?php echo esc_html__( '7.8', 'haru-circle' ); ?></span><span class="total"><?php echo esc_html__( '/10', 'haru-circle' ); ?></span></div>
    </div>
    <div class="trailer-meta">
        <h3 class="trailer-title"><a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a></h3>
    </div>
</div>
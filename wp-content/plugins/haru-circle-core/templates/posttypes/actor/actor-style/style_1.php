<?php
/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/
$terms          = wp_get_post_terms(get_the_ID(), array('actor_category'));
$filter_name = $filter_slug = '';
foreach ( $terms as $term ) {
    $filter_slug .= $term->slug . ' ';
    $filter_name .= $term->name . ' ';
}

$actor_social            = get_post_meta( get_the_ID(), 'haru_actor' . '_social', true );
?>
<div class="actor-item style_1 <?php echo esc_attr( $filter_slug ); ?>" onclick="void(0)">
    <div class="actor-image">
        <?php the_post_thumbnail(); ?>
        <ul class="actor-social">
            <?php foreach( $actor_social as $social ) : ?>
            <li><a href="<?php echo esc_url( $social['url'] ); ?>" target="_self"><i class="<?php echo esc_attr( $social['icon'] ); ?>"></i><?php echo esc_html( $social['network'] ); ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="actor-meta">
        <h3 class="actor-title"><a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a></h3>
        <div class="actor-category"><?php echo get_the_term_list( get_the_ID(), 'actor_category', '', ', ' ); ?></div>
    </div>
</div>
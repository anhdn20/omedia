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
$excerpt_length = 20;
?>
<div class="actor-item style_2 <?php echo esc_attr( $filter_slug ); ?>" onclick="void(0)">
    <div class="actor-image">
        <?php the_post_thumbnail(); ?>
        <div class="actor-meta">
            <h3 class="actor-title"><a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a></h3>
            <div class="actor-category"><?php echo get_the_term_list( get_the_ID(), 'actor_category', '', ', ' ); ?></div>
            <p class="actor-excerpt">
                <?php 
                    if ( has_excerpt() ) {
                        echo wp_trim_words( get_the_excerpt(), $excerpt_length, '...' ); 
                    } else {
                        echo wp_trim_words( get_the_content(), $excerpt_length, '...' ); 
                    }
                ?>
            </p>
            <ul class="actor-social">
                <?php foreach( $actor_social as $social ) : ?>
                <li><a href="<?php echo esc_url( $social['url'] ); ?>" target="_self" title="<?php echo esc_attr( $social['network'] ); ?>"><i class="<?php echo esc_attr( $social['icon'] ); ?>"></i></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
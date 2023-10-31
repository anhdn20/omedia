<?php
/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/
$terms          = wp_get_post_terms(get_the_ID(), array('director_category'));
$filter_name = $filter_slug = '';
foreach ( $terms as $term ) {
    $filter_slug .= $term->slug . ' ';
    $filter_name .= $term->name . ' ';
}

$director_social            = get_post_meta( get_the_ID(), 'haru_director' . '_social', true );
?>
<div class="director-item style_1 <?php echo esc_attr( $filter_slug ); ?>" onclick="void(0)">
    <div class="director-image">
        <?php the_post_thumbnail(); ?>
        <ul class="director-social">
            <?php foreach( $director_social as $social ) : ?>
            <li><a href="<?php echo esc_url( $social['url'] ); ?>" target="_self"><i class="<?php echo esc_attr( $social['icon'] ); ?>"></i><?php echo esc_html( $social['network'] ); ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="director-meta">
        <h3 class="director-title"><a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a></h3>
        <div class="director-category"><?php echo get_the_term_list( get_the_ID(), 'director_category', '', ', ' ); ?></div>
    </div>
</div>
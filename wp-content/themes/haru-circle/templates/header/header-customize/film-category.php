<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

$terms = get_terms( array(
    'taxonomy' => 'film_category',
    'hide_empty' => false,
) );

?>
<div class="header-customize-item film-category-wrapper">
    <div class="film-category-label"><span class="category-icon"></span><?php echo esc_html__( 'Categories', 'haru-circle' ); ?></div>
    <?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) : ?>
        <ul class="film-category">
            <?php foreach ( $terms as $term ) : 
                $film_category_icon = get_tax_meta( $term, 'haru_'.'category_icon' ); // Category Icon
            ?>
            <li>
                <a href="<?php echo esc_url( get_term_link( $term ) ); ?>"><img src="<?php echo esc_url( $film_category_icon['url'] ); ?>" class="category-icon" alt="<?php echo esc_html( $term->name ); ?>"><?php echo esc_html( $term->name ); ?></a>
            </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
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

// Get tag or category for title
$cat          = '';
$p_categories = get_the_terms( get_the_ID(), 'portfolio_category' );
$arrCatId     = array();
if ( $p_categories ) {
    foreach( $p_categories as $p_category ) {
        $cat .= '<span>' . $p_category->name . '</span>, ';
        $arrCatId[count($arrCatId)] = $p_category->term_id;
    }
    $cat = trim($cat, ', ');
}

// Get portfolio single tags
$tag      = '';
$p_tags   = get_the_terms(get_the_ID(), 'portfolio_tag');
$arrTagId = array();
if ( $p_tags ) {
    foreach( $p_tags as $t ) {
        $tag .= '<span>' . $t->name . '</span>, ';
        $arrTagId[count($arrTagId)] = $t->term_id;
    }
    $tag = trim($tag, ', ');
}

// Get filter class
$filter_name = $filter_slug = '';
if ( $filter_by == 'category' ) {
    $terms = wp_get_post_terms( get_the_ID(), array('portfolio_category') );
} else {
    $terms = wp_get_post_terms( get_the_ID(), array('portfolio_tag') );
}
foreach ($terms as $term) {
    $filter_slug .= $term->slug . ' ';
    $filter_name .= $term->name . ', ';
}
$filter_name = rtrim($filter_name, ', ');
?>

<div class="portfolio-item <?php echo esc_attr( $filter_slug ) ?>" onclick="void(0)">
    <!-- Title top -->
    <?php if ( isset($portfolio_title) && $portfolio_title == 'top' ) : ?>
    <div class="portfolio-title-wrap <?php echo $portfolio_title; ?>">
        <a href="<?php echo esc_url( get_permalink(get_the_ID()) ); ?>" class="portfolio-title"><?php the_title(); ?></a>
        <div class="portfolio-tag"><?php echo wp_kses_post( $tag ); ?></div>
    </div>
    <?php endif; ?>

    <?php echo haru_get_template('posttypes/portfolio/loop/hover/'. $hover_style .'.php', array('atts' => $atts), '', '' ); ?>

    <!-- Title bottom -->
    <?php if( isset($portfolio_title) && $portfolio_title == 'bottom' ) : ?>
    <div class="portfolio-title-wrap <?php echo $portfolio_title; ?>">
        <a href="<?php echo get_permalink(get_the_ID()); ?>" class="portfolio-title"><?php the_title(); ?></a>
        <div class="portfolio-tag"><?php echo wp_kses_post($tag); ?></div>
    </div>
    <?php endif; ?>

    <!-- @TODO: process media type -->
    <?php echo haru_get_template('posttypes/portfolio/loop/gallery.php', array('atts' => $atts), '', '' ); ?>
</div>

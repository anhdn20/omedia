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

if ( $item == '' ) {
    $offset        = 0;
    $post_per_page = -1;
} else {
    $offset        = 0;
    $post_per_page = $item;
}

$slugSelected = explode(',', $category);
$terms = get_terms(
    array(
        'taxonomy'  => 'portfolio_category',
        'slug'      => $slugSelected,
        'orderby'   => 'slug__in',
    )
);

if (count($terms) > 0) {
    $index = 1;
    ?>
    <div class="tab-wrapper <?php echo esc_attr($show_filter) ?>">
        <ul>
            <li class="active">
                <a href ="javascript:;" 
                    class                ="haru-button ladda-button active"
                    data-sc-id           ="<?php echo esc_attr($sc_id); ?>"
                    data-filter          ="*"
                    data-thumbnail       ="<?php echo esc_attr($portfolio_thumbnail); ?>"
                    data-portfolio-title ="<?php echo esc_attr($portfolio_title); ?>"
                    data-hover-style     ="<?php echo esc_attr($hover_style); ?>"
                    data-column          ="<?php echo esc_attr($column); ?>"
                    data-source          ="<?php echo esc_attr($data_source); ?>"
                    data-category        ="<?php echo esc_attr($category);?>"
                    data-portfolio-ids   ="<?php echo esc_attr($portfolio_ids); ?>"
                    data-tag             ="<?php echo esc_attr($portfolio_tag); ?>"
                    data-item            ="<?php echo esc_attr($item); ?>"
                    data-current-page    ="1"
                    data-order           ="<?php echo esc_attr($order); ?>"
                    data-show-paging     ="<?php echo esc_attr($show_pagging); ?>"
                    data-padding         ="<?php echo esc_attr($padding); ?>"
                    data-style           ="zoom-in"
                    data-spinner-color   ="#fff"
                >
                    <?php echo esc_html__('All', 'haru-circle'); ?>
                </a>
            </li>
            <?php foreach ( $terms as $term ) : ?>
            <li class="<?php if ($index == count($terms)) { echo esc_attr('last'); } ?>">
                <a href="javascript:;"
                    class                ="haru-button ladda-button"
                    data-sc-id           ="<?php echo esc_attr($sc_id); ?>"
                    data-filter          =".<?php echo esc_attr($term->slug); ?>"
                    data-thumbnail       ="<?php echo esc_attr($portfolio_thumbnail); ?>"
                    data-portfolio-title ="<?php echo esc_attr($portfolio_thumbnail); ?>"
                    data-hover-style     ="<?php echo esc_attr($hover_style); ?>"
                    data-column          ="<?php echo esc_attr($column); ?>"
                    data-source          ="<?php echo esc_attr($data_source); ?>"
                    data-category        ="<?php echo esc_attr($term->slug); ?>"
                    data-portfolio-ids   ="<?php echo esc_attr($portfolio_ids); ?>"
                    data-tag             ="<?php echo esc_attr($portfolio_tag); ?>"
                    data-item            ="<?php echo esc_attr($item); ?>"
                    data-current-page    ="1"
                    data-order           ="<?php echo esc_attr($order); ?>"
                    data-show-paging     ="<?php echo esc_attr($show_pagging); ?>"
                    data-padding         ="<?php echo esc_attr($padding); ?>"
                    data-style           ="zoom-in"
                    data-spinner-color   ="#fff"
                >
                    <?php echo wp_kses_post($term->name); ?>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php
}

?>
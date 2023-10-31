<?php
/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

class Haru_Circle_Top_Film_Widget extends Haru_Widget {

    public function __construct() {
        $this->widget_cssclass    = 'widget-circle-top-film';
        $this->widget_description = esc_html__( 'Widget display top film.', 'haru-circle' );
        $this->widget_id          = 'haru_widget_circle_top_film';
        $this->widget_name        = esc_html__( 'Haru Circle Top Film', 'haru-circle' );
        $this->cached             = false;

        add_action( 'init', array( $this, 'haru_get_film_categories' ), 5 ); // Use this to make get_terms() working

        $this->settings = array(
            'title'  => array(
                'type'  => 'text',
                'std'   =>'',
                'label' => esc_html__( 'Title', 'haru-circle' )
            ),
            'style' => array(
                'type'    => 'select',
                'std'     => array(),
                'label'   => esc_html__( 'Style', 'haru-circle' ),
                'options' => array(
                    'top-view'  => esc_html__( 'Top View', 'haru-circle' ),
                    'top-rated' => esc_html__( 'Top Rated', 'haru-circle' ),
                )
            ),
            'posts_per_page' => array(
                'type'  => 'number',
                'step'  => 1,
                'min'   => 1,
                'max'   => '',
                'std'   => 5,
                'label' => esc_html__( 'Number of film to show', 'haru-circle' )
            ),
        );

        parent::__construct();
    }

    function haru_get_film_categories() {
        $film_categories = array();
        $film_categories = get_terms([
            'taxonomy'   => 'film_category',
            'hide_empty' => false,
            'orderby'    => 'NAME',
            'order'      => 'ASC'
        ]);
        $categories_options = array();
        foreach ( $film_categories as $category ) {
            $categories_options[$category->term_id] = $category->name;
        }

        $this->settings['categories'] = array(
                'type'     => 'select',
                'std'      => array(),
                'multiple' => '1',
                'label'    =>esc_html__( 'Categories', 'haru-circle' ),
                'desc'     => esc_html__( 'Select a category or leave blank for all', 'haru-circle' ),
                'options'  => $categories_options,
            );

        return $film_categories;
    }
    
    public function widget($args, $instance) {
        ob_start();
        extract( $args );
        $title          = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
        $posts_per_page = absint( $instance['posts_per_page'] );
        $categories     = $instance['categories'];
        $style          = $instance['style'];
        $query_args     = array(
            'post_type'           => 'haru_film',
            'posts_per_page'      => $posts_per_page,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => 1,
            'orderby'             => 'date',
            'order'               => 'DESC',
            'meta_query'          => array(),
        );
        if ( $style == 'top-view' ) {
            $query_args['meta_key'] = 'post_views_count';
            $query_args['orderby'] = 'meta_value_num';
        } else {
            $query_args['meta_key'] = 'haru_film_rating';
            $query_args['orderby'] = 'meta_value_num';
        }

        
        if ( !empty($categories) ) {
            $query_args['tax_query'] = array(
                                            array(
                                                'taxonomy' => 'film_category',
                                                'field'    => 'term_id',
                                                'terms'    => $categories,
                                            )
                                        );
        }

        $films = new WP_Query($query_args);

        if ( $films->have_posts() ):
            echo $before_widget;

                if ( $title )
                echo $before_title . $title . $after_title;
                    echo '<ul class="film-list ' . $style . '">';
                $i = 1; 
                while ( $films->have_posts() ) : 
                    $films->the_post();
                    global $post;
                ?>
                    <?php if ( $style == 'top-view' ) : ?>
                    <li class="film-item">
                        <div class="top-number"><?php ?><?php echo ($i < 10) ? '0' . $i : $i; ?></div>
                        <div class="item-content">
                            <a href="<?php the_permalink(); ?>"><?php the_title() ?></a>
                            <div class="view-count"><i class="ion-ios-eye"></i><?php echo get_post_meta( get_the_ID(), 'post_views_count', true ) . esc_html__( ' views', 'haru-circle' ); ?></div>
                        </div>
                    </li>
                    <?php else : ?>
                    <li class="film-item clearfix">
                        <div class="item-thumbnail"><?php the_post_thumbnail(); ?></div>
                        <div class="item-content">
                            <div class="film-title"><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></div>
                            <div class="film-category"><?php echo get_the_term_list( get_the_ID(), 'film_category', '', ' / ' ); ?></div>
                            <div class="item-rating">
                                <span class="point"><?php echo get_post_meta( get_the_ID(), 'haru_film_rating', true ); ?></span>
                                <span class="total"><?php echo esc_html__( '/10', 'haru-circle' ); ?></span>
                            </div>
                            </div>
                        </li>
                    </li>
                    <?php endif; ?>
                <?php
                $i++;
                endwhile;
                echo  '</ul>';

            echo $after_widget;
        endif;

        $content = ob_get_clean();
        wp_reset_postdata();
        echo $content;
    }
    
}
if (!function_exists('haru_register_widget_circle_top_film')) {
    function haru_register_widget_circle_top_film() {
        register_widget('Haru_Circle_Top_Film_Widget');
    }
    add_action('widgets_init', 'haru_register_widget_circle_top_film');
}
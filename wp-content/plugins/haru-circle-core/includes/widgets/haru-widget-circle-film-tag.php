<?php
/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

class Haru_Circle_Film_Tag_Widget extends Haru_Widget {

    public function __construct() {
        $this->widget_cssclass    = 'widget-circle-film-tag';
        $this->widget_description = esc_html__( 'Widget display film tags.', 'haru-circle' );
        $this->widget_id          = 'haru_widget_circle_film_tag';
        $this->widget_name        = esc_html__( 'Haru Circle Film Tags', 'haru-circle' );
        $this->cached             = false;

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
                    'default'  => esc_html__( 'Default', 'haru-circle' ),
                )
            ),
        );

        parent::__construct();
    }
    
    public function widget($args, $instance) {
        ob_start();
        extract( $args );
        $title          = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
        $style          = $instance['style'];

        $tag_args = array(
           'taxonomy' => array( 'film_tag' )
        );

            echo $before_widget;

                if ( $title )
                echo $before_title . $title . $after_title;
                    echo '<div class="film-tag-list ' . $style . '">';
        
                    $this->haru_custom_wp_tag_cloud( $tag_args );
                ?>

                <?php
                echo  '</div>';

            echo $after_widget;

        $content = ob_get_clean();
        wp_reset_postdata();
        echo $content;
    }

    public function haru_custom_wp_tag_cloud( $args = '' ) {
        $defaults = array(
            'smallest'  => 14, 
            'default'   => 18, 
            'largest'   => 22, 
            'unit'      => 'px', 
            'number'    => 45,
            'format'    => 'flat',
            'separator' => ", ", 
            'orderby'   => 'name', 
            'order'     => 'ASC',
            'exclude'   => '', 
            'include'   => '', 
            'link'      => 'view', 
            'taxonomy'  => 'film_tag', 
            'echo'      => true
        );
        $args = wp_parse_args( $args, $defaults );

        $tags = get_terms( $args['taxonomy'], array_merge( $args, array( 'orderby' => 'count', 'order' => 'DESC' ) ) ); // Always query top tags

        if ( empty( $tags ) )
            return;

        foreach ( $tags as $key => $tag ) {
            if ( 'edit' == $args['link'] )
                $link = get_edit_tag_link( $tag->term_id, $tag->taxonomy );
            else
                $link = get_term_link( intval($tag->term_id), $tag->taxonomy );
            if ( is_wp_error( $link ) )
                return false;

            $tags[ $key ]->link = $link;
            $tags[ $key ]->id = $tag->term_id;
        }

        $return = wp_generate_tag_cloud( $tags, $args ); // Here's where those top tags get sorted according to $args

        $return = apply_filters( 'wp_tag_cloud', $return, $args );

        if ( 'array' == $args['format'] || empty($args['echo']) )
            return $return;

        echo $return;
    }
    
}
if (!function_exists('haru_register_widget_circle_film_tag')) {
    function haru_register_widget_circle_film_tag() {
        register_widget('Haru_Circle_Film_Tag_Widget');
    }
    add_action('widgets_init', 'haru_register_widget_circle_film_tag');
}
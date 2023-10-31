<?php
/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
 *
 * 1. Autocomplete ProductID functions
 * 2. Add shortcode param
 * 2.1. Add shortcode param datetimepicker
*/

/*
* 0. Get template for shortcode @See: http://jeroensormani.com/how-to-add-template-files-in-your-plugin/
*/
function haru_locate_template( $template_name, $template_path = '', $default_path = '' ) {
    // Set variable to search in haru-circle-core folder of theme.
    if ( ! $template_path ) :
        $template_path = 'haru-circle-core/';
    endif;
    // Set default plugin templates path.
    if ( ! $default_path ) :
        $default_path = PLUGIN_HARU_CIRCLE_CORE_DIR . 'templates/'; // Path to the template folder
    endif;
    // Search template file in theme folder.
    $template = locate_template( array(
        $template_path . $template_name,
        $template_name
    ) );
    // Get plugins template file.
    if ( ! $template ) :
        $template = $default_path . $template_name;
    endif;

    return apply_filters( 'haru_locate_template', $template, $template_name, $template_path, $default_path );
}

function haru_get_template( $template_name, $args = array(), $tempate_path = '', $default_path = '' ) {
    if ( is_array( $args ) && isset( $args ) ) :
        extract( $args );
    endif;
    $template_file = haru_locate_template( $template_name, $tempate_path, $default_path );

    if ( ! file_exists( $template_file ) ) :
        _doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $template_file ), '1.0.0' );
        return;
    endif;
    include $template_file;
}

/*
* 1. Autocomplete ProductID functions
*/


/* 2. Add shortcode param 
* More details here: https://wpbakery.atlassian.net/wiki/display/VC/Create+New+Param+Type
*/
/* 2.1. Add shortcode param datetime picker */
if ( ! function_exists( 'haru_shortcode_param_datetime' ) ) :
    function haru_shortcode_param_datetime( $settings, $value ) {
        // Load datetimepicker library from admin
        $html[] = '<div class="haru_datetime_param">';
        $html[] = '     <input name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput ' . esc_attr( $settings['param_name'] ) . ' ' . esc_attr( $settings['type'] ) . '_field" type="text" value="' . esc_attr( $value ) . '" id="datetimepicker"/>';
        $html[] = '</div>';

        return implode( "\n", $html );
    }

    vc_add_shortcode_param( 'haru_datetime', 'haru_shortcode_param_datetime', plugins_url() . '/haru-circle-core/admin/assets/js/admin.js' );
endif;

if ( ! function_exists( 'haru_number_settings_field' ) ) :
    function haru_number_settings_field( $settings, $value ) {
        $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
        $type       = isset($settings['type']) ? $settings['type'] : '';
        $min        = isset($settings['min']) ? $settings['min'] : '';
        $max        = isset($settings['max']) ? $settings['max'] : '';
        $suffix     = isset($settings['suffix']) ? $settings['suffix'] : '';
        $class      = isset($settings['class']) ? $settings['class'] : '';
        $output     = '<input type="number" min="' . esc_attr($min) . '" max="' . esc_attr($max) . '" class="wpb_vc_param_value ' . esc_attr($param_name) . ' ' . esc_attr($type) . ' ' . esc_attr($class) . '" name="' . esc_attr($param_name) . '" value="' . esc_attr($value) . '" style="max-width:100px; margin-right: 10px;" />' . esc_attr($suffix);
        
        return $output;
    }

    vc_add_shortcode_param('number', 'haru_number_settings_field');
endif;  

if ( ! function_exists( 'haru_icon_text_settings_field' ) ) :
    function haru_icon_text_settings_field( $settings, $value ) {
        return '<div class="vc-text-icon">'
        . '<input  name="' . $settings['param_name'] . '" style="width:80%;" class="wpb_vc_param_value wpb-textinput widefat input-icon ' . esc_attr($settings['param_name']) . ' ' . esc_attr($settings['type']) . '_field" type="text" value="' . esc_attr($value) . '"/>'
        . '<input title="' . esc_html__('Click to browse icon', 'haru-circle') . '" style="width:20%; height:34px;" class="browse-icon button-secondary" type="button" value="' . esc_html__('Browse Icon', 'haru-circle') . '" >'
        . '<span class="icon-preview"><i class="' . esc_attr($value) . '"></i></span>'
        . '</div>';
    }

    vc_add_shortcode_param('icon_text', 'haru_icon_text_settings_field');
endif; 

if ( ! function_exists( 'haru_multi_select_settings_field_shortcode_param' ) ) :
    function haru_multi_select_settings_field_shortcode_param( $settings, $value, $taxonomies = 'category', $post_type = '', $is_category = true ) {
        $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
        $param_option = array();
        // New
        if ( $is_category ) {
            $categories = get_terms($taxonomies);
            if (is_array($categories)) {
                foreach ($categories as $cat) {
                    $param_option[$cat->name] = $cat->slug;
                }
            }
        } else {
            $args = array(
                'posts_per_page' => -1,
                'post_type'      => $post_type,
                'post_status'    => 'publish'
            );
            $post_array   = get_posts($args);
            foreach ($post_array as $post) : setup_postdata($post);
                $param_option[$post->post_title] = $post->ID;
            endforeach;
        }
        // 
        $output = '<div class="haru-multi-select">';
        $output .= '<input type="hidden" name="' . $param_name . '" id="' . $param_name . '" class="wpb_vc_param_value ' . $param_name . '" value="' . $value . '"/>';
        $output .= '<select multiple id="' . $param_name . '_select2" name="' . $param_name . '_select2" class="multi-select">';
        if ($param_option != '' && is_array($param_option)) {
            foreach ($param_option as $text_val => $val) {
                if (is_numeric($text_val) && (is_string($val) || is_numeric($val))) {
                    $text_val = $val;
                }
                $output .= '<option id="' . $val . '" value="' . $val . '">' . htmlspecialchars($text_val) . '</option>';
            }
        }

        $output .= '</select><div class="select-all"><input type="checkbox" id="' . $param_name . '_select_all" >' . esc_html__( 'Select All', 'haru-circle' ) . '</div>';
        $output .= '<script type="text/javascript">
                    jQuery(document).ready(function($){

                        $("#' . $param_name . '_select2").select2();

                        var order = $("#' . $param_name . '").val();
                        if (order != "") {
                            order = order.split(",");
                            // NEW
                            for (var i = 0; i < order.length; i++ ) {
                                $("#' . $param_name . '_select2 option[value="+ order[i] + "]").prop("selected","selected");
                            } 
                            $("#' . $param_name . '_select2").trigger("change");
                        }

                        $("#' . $param_name . '_select2").on("select2:select", function(e) { // select2-selecting to select2:selecting
                            var ids = $("#' . $param_name . '").val();
                            if (ids != "") {
                                ids +=",";
                            }
                            ids += e.params.data.id; // e.val to e.params.data.id
                            $("#' . $param_name . '").val(ids);

                            var id = e.params.data.id;
                            var option = $(e.target).children("[value="+ id + "]");
                            option.detach();
                            $(e.target).append(option).change();
                        }).on("select2:unselect", function(e) { // select2-removed to select2:unselect
                              var ids = $("#' . $param_name . '").val();
                              var arr_ids = ids.split(",");
                              var newIds = "";
                              for(var i = 0 ; i < arr_ids.length; i++) {
                                if (arr_ids[i] != e.params.data.id){
                                    if (newIds != "") {
                                        newIds +=",";
                                    }
                                    newIds += arr_ids[i];
                                }
                              }
                              $("#' . $param_name . '").val(newIds);
                              $("#' . $param_name . '_select_all").attr("checked", false);
                         });

                        $("#' . $param_name . '_select_all").click(function(){
                            if($("#' . $param_name . '_select_all").is(":checked") ){
                                $("#' . $param_name . '_select2 > option").prop("selected","selected");
                                $("#' . $param_name . '_select2").trigger("change");
                                var arr_ids =  $("#' . $param_name . '_select2").select2("val");
                                var ids = "";
                                for (var i = 0; i < arr_ids.length; i++ ) {
                                    if (ids != "") {
                                        ids +=",";
                                    }
                                    ids += arr_ids[i];
                                }
                                $("#' . $param_name . '").val(ids);

                            }else{
                                $("#' . $param_name . '_select2 > option").removeAttr("selected");
                                $("#' . $param_name . '_select2").trigger("change");
                                $("#' . $param_name . '").val("");
                            }
                        });
                    });
                    </script>
                    <style>
                        .select2 {
                            width: 100%!important;
                        }
                        .select2-drop,
                        .select2-container--open {
                            z-index: 100000;
                        }
                    </style>';
        $output .= '</div>';

        return $output;
    }
endif;

// Add new shortcode param
vc_add_shortcode_param('haru_post_categories', 'haru_register_vc_field_post_categories');
vc_add_shortcode_param('haru_post_list', 'haru_register_vc_field_post_list');
vc_add_shortcode_param('haru_testimonial_categories', 'haru_register_vc_field_testimonial_categories');
vc_add_shortcode_param('haru_testimonial_list', 'haru_register_vc_field_testimonial_list');
vc_add_shortcode_param('haru_portfolio_categories', 'haru_register_vc_field_portfolio_categories');
vc_add_shortcode_param('haru_portfolio_tags', 'haru_register_vc_field_portfolio_tags');
vc_add_shortcode_param('haru_portfolio_list', 'haru_register_vc_field_portfolio_list');
vc_add_shortcode_param('haru_teammember_categories', 'haru_register_vc_field_teammember_categories');
vc_add_shortcode_param('haru_teammember_list', 'haru_register_vc_field_teammember_list');
vc_add_shortcode_param('haru_video_categories', 'haru_register_vc_field_video_categories');
vc_add_shortcode_param('haru_video_list', 'haru_register_vc_field_video_list');
vc_add_shortcode_param('haru_actor_categories', 'haru_register_vc_field_actor_categories');
vc_add_shortcode_param('haru_actor_list', 'haru_register_vc_field_actor_list');
vc_add_shortcode_param('haru_director_categories', 'haru_register_vc_field_director_categories');
vc_add_shortcode_param('haru_director_list', 'haru_register_vc_field_director_list');
vc_add_shortcode_param('haru_film_categories', 'haru_register_vc_field_film_categories');
vc_add_shortcode_param('haru_film_list', 'haru_register_vc_field_film_list');
vc_add_shortcode_param('haru_trailer_categories', 'haru_register_vc_field_trailer_categories');
vc_add_shortcode_param('haru_trailer_list', 'haru_register_vc_field_trailer_list');

function haru_register_vc_field_post_categories($settings, $value) {
    return haru_multi_select_settings_field_shortcode_param($settings, $value, 'category', 'post', true);
}
function haru_register_vc_field_post_list($settings, $value) {
    return haru_multi_select_settings_field_shortcode_param($settings, $value, 'category', 'post', false);
}

function haru_register_vc_field_testimonial_categories($settings, $value) {
    return haru_multi_select_settings_field_shortcode_param($settings, $value, 'testimonial_category', 'haru_testimonial', true);
}
function haru_register_vc_field_testimonial_list($settings, $value) {
    return haru_multi_select_settings_field_shortcode_param($settings, $value, 'testimonial_category', 'haru_testimonial', false);
}

function haru_register_vc_field_portfolio_categories($settings, $value) {
    return haru_multi_select_settings_field_shortcode_param($settings, $value, 'portfolio_category', 'haru_portfolio', true);
}
function haru_register_vc_field_portfolio_tags($settings, $value) {
    return haru_multi_select_settings_field_shortcode_param($settings, $value, 'portfolio_tag', 'haru_portfolio', true);
}
function haru_register_vc_field_portfolio_list($settings, $value) {
    return haru_multi_select_settings_field_shortcode_param($settings, $value, 'portfolio_category', 'haru_portfolio', false);
}

function haru_register_vc_field_teammember_categories($settings, $value) {
    return haru_multi_select_settings_field_shortcode_param($settings, $value, 'team_category', 'haru_teammember', true);
}
function haru_register_vc_field_teammember_list($settings, $value) {
    return haru_multi_select_settings_field_shortcode_param($settings, $value, 'team_category', 'haru_teammember', false);
}

function haru_register_vc_field_video_categories($settings, $value) {
    return haru_multi_select_settings_field_shortcode_param($settings, $value, 'video_category', 'haru_video', true);
}
function haru_register_vc_field_video_list($settings, $value) {
    return haru_multi_select_settings_field_shortcode_param($settings, $value, 'video_category', 'haru_video', false);
}

function haru_register_vc_field_actor_categories($settings, $value) {
    return haru_multi_select_settings_field_shortcode_param($settings, $value, 'actor_category', 'haru_actor', true);
}
function haru_register_vc_field_actor_list($settings, $value) {
    return haru_multi_select_settings_field_shortcode_param($settings, $value, 'actor_category', 'haru_actor', false);
}

function haru_register_vc_field_director_categories($settings, $value) {
    return haru_multi_select_settings_field_shortcode_param($settings, $value, 'director_category', 'haru_director', true);
}
function haru_register_vc_field_director_list($settings, $value) {
    return haru_multi_select_settings_field_shortcode_param($settings, $value, 'director_category', 'haru_director', false);
}

function haru_register_vc_field_film_categories($settings, $value) {
    return haru_multi_select_settings_field_shortcode_param($settings, $value, 'film_category', 'haru_film', true);
}
function haru_register_vc_field_film_list($settings, $value) {
    return haru_multi_select_settings_field_shortcode_param($settings, $value, 'film_category', 'haru_film', false);
}

function haru_register_vc_field_trailer_categories($settings, $value) {
    return haru_multi_select_settings_field_shortcode_param($settings, $value, 'trailer_category', 'haru_trailer', true);
}
function haru_register_vc_field_trailer_list($settings, $value) {
    return haru_multi_select_settings_field_shortcode_param($settings, $value, 'trailer_category', 'haru_trailer', false);
}



if ( ! function_exists( 'haru_single_select_settings_field_shortcode_param' ) ) :
    function haru_single_select_settings_field_shortcode_param( $settings, $value, $post_type = '' ) {
        $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
        $param_option = array();

        $args = array(
            'posts_per_page' => -1,
            'post_type'      => $post_type,
            'post_status'    => 'publish'
        );
        
        $post_array   = get_posts($args);
        foreach ($post_array as $post) : setup_postdata($post);
            $param_option[$post->post_title] = $post->ID;
        endforeach;

        $output = '<div class="haru-single-select">';
        $output .= '<input type="hidden" name="' . $param_name . '" id="' . $param_name . '" class="wpb_vc_param_value ' . $param_name . '" value="' . $value . '"/>';
        $output .= '<select id="' . $param_name . '_select2" name="' . $param_name . '_select2" class="single-select">';
        if ($param_option != '' && is_array($param_option)) {
            $output .= '<option value="">'. esc_html__('Select an item', 'haru-circle') .'</option>';
            foreach ($param_option as $text_val => $val) {
                if (is_numeric($text_val) && (is_string($val) || is_numeric($val))) {
                    $text_val = $val;
                }
                if( $val == $value ) {
                    $selected = 'selected';
                } else {
                    $selected = '';
                }
                $output .= '<option id="' . $val . '" value="' . $val . '"'. $selected . '>' . htmlspecialchars($text_val) . '</option>';
            }
        }

        $args = array(
            'posts_per_page' => -1,
            'post_type'      => $post_type,
            'post_status'    => 'publish'
        );
        
        $post_array   = get_posts($args);
        foreach ($post_array as $post) : setup_postdata($post);
            $param_option[$post->post_title] = $post->ID;
        endforeach;

        $output .= '</select>';
        $output .= '<script type="text/javascript">
                    jQuery(document).ready(function($){
                        $("#' . $param_name . '_select2").select2({
                            multiple: false,
                            allowClear: false
                        });

                        var order = $("#' . $param_name . '").val();

                        if (order != "") {
                            order = order.split(",");
                            // NEW
                            for (var i = 0; i < order.length; i++ ) {
                                $("#' . $param_name . '_select2 option[value="+ order[i] + "]").prop("selected","selected");
                            } 
                            $("#' . $param_name . '_select2").trigger("change");
                        }

                        $("#' . $param_name . '_select2").on("select2:select", function(e) { // select2-selecting to select2:selecting
                            var old_id = $("#' . $param_name . '").val();
                            var new_id = e.params.data.id; // e.val to e.params.data.id
                            $("#' . $param_name . '").val(new_id);

                            var option = $(e.target).children("[value="+ new_id + "]");
                            option.detach();
                            $(e.target).append(option).change();
                        }).on("select2:unselect", function(e) { // select2-removed to select2:unselect
                            var old_id = $("#' . $param_name . '").val();
                            var new_id = "";
                            $("#' . $param_name . '").val(new_id);
                        });
                    });
                    </script>
                    <style>
                        .single-select {
                          width: 100%;
                        }
                        .select2-drop {
                            z-index: 100000;
                        }
                    </style>';
        $output .= '</div>';

        return $output;
    }

    vc_add_shortcode_param('single-select', 'haru_single_select_settings_field_shortcode_param');
endif;

// Add new shortcode param
vc_add_shortcode_param('haru_post_list_single', 'haru_register_vc_field_post_list_single');

function haru_register_vc_field_post_list_single($settings, $value) {
    return haru_single_select_settings_field_shortcode_param($settings, $value, 'post' );
}



if ( ! function_exists( 'haru_tags_settings_field_shortcode_param' ) ) :
    function haru_tags_settings_field_shortcode_param( $settings, $value ) {
        $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
        $output     =   '<input  name="' . $settings['param_name']
                        . '" class="wpb_vc_param_value wpb-textinput '
                        . $settings['param_name'] . ' ' . $settings['type']
                        . '" type="hidden" value="' . $value . '"/>';
        $output     .= '<input type="text" name="' . $param_name . '_tagsinput" id="' . $param_name . '_tagsinput" value="' . $value . '" data-role="tagsinput"/>';
        $output     .= '<script type="text/javascript">
                            jQuery(document).ready(function($){
                                $("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput();

                                $("#' . $param_name . '_tagsinput").on("itemAdded", function(event) {
                                     $("input[name=' . $param_name . ']").val($(this).val());
                                });

                                $("#' . $param_name . '_tagsinput").on("itemRemoved", function(event) {
                                     $("input[name=' . $param_name . ']").val($(this).val());
                                });
                            });
                        </script>';
        return $output;
    }

    vc_add_shortcode_param('tags', 'haru_tags_settings_field_shortcode_param');
endif;
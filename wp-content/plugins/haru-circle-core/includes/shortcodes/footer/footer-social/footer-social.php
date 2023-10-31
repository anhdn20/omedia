<?php
/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

if ( ! defined( 'ABSPATH' ) ) die( '-1' );

if ( ! class_exists('Haru_Framework_Shortcode_Footer_Social') ) {
    class Haru_Framework_Shortcode_Footer_Social {
        function __construct() {
            add_shortcode( 'haru_footer_social', array($this, 'haru_footer_social_shortcode') );
            add_action( 'vc_before_init', array($this, 'haru_footer_social_vc_map') );
        }

        function haru_footer_social_shortcode($atts) {
            $atts  = vc_map_get_attributes( 'haru_footer_social', $atts );
            $socials = $layout_type = $align = $css = $el_class = $haru_animation = $css_animation = $duration = $delay = $styles_animation = '';
            extract(shortcode_atts(array(
                'socials'       => '',
                'layout_type'   => 'style_1',
                'align'         => 'center',
                'css'           => '',
                'el_class'      => '',
                'css_animation' => '',
                'duration'      => '',
                'delay'         => '',
            ), $atts));
           
            $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), 'haru_footer_social', $atts );
            
            $haru_animation   = HARU_CircleCore_Shortcodes::haru_get_css_animation($css_animation);
            $styles_animation = HARU_CircleCore_Shortcodes::haru_get_style_animation($duration, $delay);

            ob_start();

            ?>
            <?php if ( $socials != '' ) : ?>
            <div class="<?php echo esc_attr($css_class . ' ' . $haru_animation . ' ' . $styles_animation); ?>">
                <?php echo haru_get_template('footer/footer-social/'. $layout_type . '.php', array('atts' => $atts), '', '' ); // use echo because footer use echo in theme ?>
            </div>
            <?php else : ?>
                <div class="footer-not-select"><?php echo esc_html__( 'Please insert Footer Social information!', 'haru-circle' ); ?></div>
            <?php endif; ?>
        <?php
            $content =  ob_get_clean();
            return $content;         
        }

        function haru_footer_social_vc_map() {
            vc_map(
                array(
                    'name'        => esc_html__('Haru Footer Social', 'haru-circle'),
                    'base'        => 'haru_footer_social',
                    'category'    => HARU_CIRCLE_CORE_SHORTCODE_CATEGORY,
                    'icon'        => 'fa fa-twitter haru-vc-icon',
                    'description' => esc_html__( 'Display Footer Social', 'haru-circle' ),
                    'params'      =>  array(
                        array(
                            'param_name'  => 'socials',
                            'type'        => 'param_group',
                            'heading'     => esc_html__( 'Social network list', 'haru-circle' ),
                            'description' => esc_html__( 'Insert information for Social Network List.', 'haru-circle' ),
                            'value'       => urlencode( json_encode( array(
                                array(
                                    'title'       => esc_html__( 'Facebook', 'haru-circle' ),
                                ),
                                array(
                                    'title'       => esc_html__( 'Twitter', 'haru-circle' ),
                                ),
                                array(
                                    'title'       => esc_html__( 'Instagram', 'haru-circle' ),
                                ),
                            ) ) ),
                            'params' => array(
                                // Social Network Information
                                array(
                                    'param_name'  => 'title',
                                    'type'        => 'textfield',
                                    'heading'     => esc_html__( 'Title', 'haru-circle' ),
                                    'description' => esc_html__( 'Enter title of social network.', 'haru-circle' ),
                                    'admin_label' => true,
                                ),
                                array(
                                    'param_name'  => 'link',
                                    'type'        => 'vc_link',
                                    'heading'     => esc_html__( 'Link', 'haru-circle' ),
                                    'description' => esc_html__( 'Set link of social network.', 'haru-circle' ),
                                    'admin_label' => false,
                                ),
                                // Social Network Icon
                                array(
                                    'param_name' => 'icon_library',
                                    'type'       => 'dropdown',
                                    'heading'    => esc_html__( 'Icon library', 'haru-circle' ),
                                    'value'      => array(
                                        esc_html__( 'Font Awesome', 'haru-circle' )   => 'fontawesome',
                                        esc_html__( 'Open Iconic', 'haru-circle' )    => 'openiconic',
                                        esc_html__( 'Typicons', 'haru-circle' )       => 'typicons',
                                        esc_html__( 'Entypo', 'haru-circle' )         => 'entypo',
                                        esc_html__( 'Linecons', 'haru-circle' )       => 'linecons',
                                    ),
                                    'admin_label' => false,
                                    'description' => esc_html__( 'Select icon library.', 'haru-circle' ),
                                ),
                                array(
                                    'type'       => 'iconpicker',
                                    'heading'    => esc_html__( 'Icon', 'haru-circle' ),
                                    'param_name' => 'icon_fontawesome',
                                    'value'      => 'fa fa-adjust', // default value to backend editor admin_label
                                    'settings'   => array(
                                        'emptyIcon'    => false,
                                        // default true, display an "EMPTY" icon?
                                        'iconsPerPage' => 4000,
                                        // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                                    ),
                                    'dependency' => array(
                                        'element' => 'icon_library',
                                        'value'   => 'fontawesome',
                                    ),
                                    'description' => esc_html__( 'Select icon from library.', 'haru-circle' ),
                                ),
                                array(
                                    'type'       => 'iconpicker',
                                    'heading'    => esc_html__( 'Icon', 'haru-circle' ),
                                    'param_name' => 'icon_openiconic',
                                    'value'      => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
                                    'settings'   => array(
                                        'emptyIcon'    => false, // default true, display an "EMPTY" icon?
                                        'type'         => 'openiconic',
                                        'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                                    ),
                                    'dependency' => array(
                                        'element' => 'icon_library',
                                        'value'   => 'openiconic',
                                    ),
                                    'description' => esc_html__( 'Select icon from library.', 'haru-circle' ),
                                ),
                                array(
                                    'type'       => 'iconpicker',
                                    'heading'    => esc_html__( 'Icon', 'haru-circle' ),
                                    'param_name' => 'icon_typicons',
                                    'value'      => 'typcn typcn-adjust-brightness', // default value to backend editor admin_label
                                    'settings'   => array(
                                        'emptyIcon'    => false, // default true, display an "EMPTY" icon?
                                        'type'         => 'typicons',
                                        'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                                    ),
                                    'dependency' => array(
                                        'element' => 'icon_library',
                                        'value'   => 'typicons',
                                    ),
                                    'description' => esc_html__( 'Select icon from library.', 'haru-circle' ),
                                ),
                                array(
                                    'type'       => 'iconpicker',
                                    'heading'    => esc_html__( 'Icon', 'haru-circle' ),
                                    'param_name' => 'icon_entypo',
                                    'value'      => 'entypo-icon entypo-icon-note', // default value to backend editor admin_label
                                    'settings'   => array(
                                        'emptyIcon'    => false, // default true, display an "EMPTY" icon?
                                        'type'         => 'entypo',
                                        'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                                    ),
                                    'dependency' => array(
                                        'element' => 'icon_library',
                                        'value'   => 'entypo',
                                    ),
                                ),
                                array(
                                    'type'       => 'iconpicker',
                                    'heading'    => esc_html__( 'Icon', 'haru-circle' ),
                                    'param_name' => 'icon_linecons',
                                    'value'      => 'vc_li vc_li-heart', // default value to backend editor admin_label
                                    'settings'   => array(
                                        'emptyIcon'    => false, // default true, display an "EMPTY" icon?
                                        'type'         => 'linecons',
                                        'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                                    ),
                                    'dependency' => array(
                                        'element' => 'icon_library',
                                        'value'   => 'linecons',
                                    ),
                                    'description' => esc_html__( 'Select icon from library.', 'haru-circle' ),
                                ),
                            ),
                        ),
                        array(
                            'param_name'  => 'layout_type',
                            'heading'     => esc_html__( 'Style', 'haru-circle' ),
                            'description' => 'Select style for display footer social.',
                            'type'        => 'dropdown',
                            'value'       => array(
                                esc_html__( 'Style 1 (Default)', 'haru-circle' )     =>  'style_1',
                                esc_html__( 'Style 2 (Icon Home 2)', 'haru-circle' ) =>  'style_2',
                                esc_html__( 'Style 2 (Icon Home 3)', 'haru-circle' ) =>  'style_3',
                            ),
                            'admin_label' => true,
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                        ),
                        array(
                            'param_name'  => 'align',
                            'heading'     => esc_html__( 'Align', 'haru-circle' ),
                            'description' => 'Select align for display footer social.',
                            'type'        => 'dropdown',
                            'value'       => array(
                                esc_html__( 'Center', 'haru-circle' ) =>  'center',
                                esc_html__( 'Left', 'haru-circle' )   =>  'left',
                                esc_html__( 'Right', 'haru-circle' )  =>  'right',
                            ),
                            'admin_label' => true,
                            'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                        ),
                        array(
                            'type'       => 'css_editor',
                            'heading'    => esc_html__( 'CSS box', 'haru-circle' ),
                            'param_name' => 'css',
                            'group'      => esc_html__( 'Design Options', 'haru-circle' ),
                        ),
                        Haru_CircleCore_Shortcodes::add_css_animation(),
                        Haru_CircleCore_Shortcodes::add_duration_animation(),
                        Haru_CircleCore_Shortcodes::add_delay_animation(),
                        Haru_CircleCore_Shortcodes::add_el_class()
                    )
                )
            );
        }
    }

    new Haru_Framework_Shortcode_Footer_Social();
}
?>
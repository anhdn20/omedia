<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
 ** 
 * Add param to exits shortcode
 * 1. vc_row
 * 2. vc_row_inner
 * 3. vc_column
 */

function haru_add_vc_param() {
    if (function_exists('vc_add_param')) {
        $add_css_animation = array(
            'type'        => 'dropdown',
            'heading'     => esc_html__( 'CSS Animation', 'haru-circle' ),
            'param_name'  => 'css_animation',
            'value'       => array(
                esc_html__( 'No', 'haru-circle' )                   => '', 
                esc_html__( 'Fade In', 'haru-circle')               => 'wpb_fadeIn', 
                esc_html__( 'Fade Top to Bottom', 'haru-circle' )   => 'wpb_fadeInDown', 
                esc_html__( 'Fade Bottom to Top', 'haru-circle' )   => 'wpb_fadeInUp', 
                esc_html__( 'Fade Left to Right', 'haru-circle' )   => 'wpb_fadeInLeft', 
                esc_html__( 'Fade Right to Left', 'haru-circle' )   => 'wpb_fadeInRight', 
                esc_html__( 'Bounce In', 'haru-circle')             => 'wpb_bounceIn', 
                esc_html__( 'Bounce Top to Bottom', 'haru-circle' ) => 'wpb_bounceInDown', 
                esc_html__( 'Bounce Bottom to Top', 'haru-circle' ) => 'wpb_bounceInUp', 
                esc_html__( 'Bounce Left to Right', 'haru-circle' ) => 'wpb_bounceInLeft', 
                esc_html__( 'Bounce Right to Left', 'haru-circle' ) => 'wpb_bounceInRight', 
                esc_html__( 'Zoom In', 'haru-circle' )              => 'wpb_zoomIn', 
                esc_html__( 'Flip Vertical', 'haru-circle' )        => 'wpb_flipInX', 
                esc_html__( 'Flip Horizontal', 'haru-circle' )      => 'wpb_flipInY', 
                esc_html__( 'Bounce', 'haru-circle' )               => 'wpb_bounce', 
                esc_html__( 'Flash', 'haru-circle' )                => 'wpb_flash', 
                esc_html__( 'Shake', 'haru-circle' )                => 'wpb_shake', 
                esc_html__('Pulse', 'haru-circle' )                 => 'wpb_pulse', 
                esc_html__( 'Swing', 'haru-circle')                 => 'wpb_swing', 
                esc_html__( 'Rubber band', 'haru-circle' )          => 'wpb_rubberBand', 
                esc_html__( 'Wobble', 'haru-circle' )               => 'wpb_wobble', 
                esc_html__( 'Tada', 'haru-circle' )                 => 'wpb_tada'
            ),
            'description' => esc_html__( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'haru-circle' ),
            'group'       => esc_html__( 'Haru Options', 'haru-circle' )
        );

        $add_duration_animation = array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Animation Duration', 'haru-circle' ),
            'param_name'  => 'duration',
            'value'       => '',
            'description' => esc_html__( 'Duration in seconds. You can use decimal points in the value. Use this field to specify the amount of time the animation plays. <em>The default value depends on the animation, leave blank to use the default.</em>', 'haru-circle' ),
            'dependency'  => array(
                'element' => 'css_animation', 
                'value'   => array(
                    'wpb_fadeIn', 
                    'wpb_fadeInDown', 
                    'wpb_fadeInUp', 
                    'wpb_fadeInLeft', 
                    'wpb_fadeInRight', 
                    'wpb_bounceIn', 
                    'wpb_bounceInDown', 
                    'wpb_bounceInUp', 
                    'wpb_bounceInLeft', 
                    'wpb_bounceInRight', 
                    'wpb_zoomIn', 
                    'wpb_flipInX', 
                    'wpb_flipInY', 
                    'wpb_bounce', 
                    'wpb_flash', 
                    'wpb_shake', 
                    'wpb_pulse', 
                    'wpb_swing', 
                    'wpb_rubberBand',
                    'wpb_wobble', 
                    'wpb_tada'
                )
            ),
            'group'       => esc_html__( 'Haru Options', 'haru-circle' )
        );

        $add_delay_animation = array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Animation Delay', 'haru-circle' ),
            'param_name'  => 'delay',
            'value'       => '',
            'description' => esc_html__( 'Delay in seconds. You can use decimal points in the value. Use this field to delay the animation for a few seconds, this is helpful if you want to chain different effects one after another above the fold.', 'haru-circle' ),
            'dependency'  => array(
                'element' => 'css_animation', 
                'value'   => array(
                    'wpb_fadeIn', 
                    'wpb_fadeInDown', 
                    'wpb_fadeInUp',
                    'wpb_fadeInLeft',
                    'wpb_fadeInRight', 
                    'wpb_bounceIn', 
                    'wpb_bounceInDown', 
                    'wpb_bounceInUp', 
                    'wpb_bounceInLeft', 
                    'wpb_bounceInRight', 
                    'wpb_zoomIn', 
                    'wpb_flipInX', 
                    'wpb_flipInY', 
                    'wpb_bounce', 
                    'wpb_flash', 
                    'wpb_shake', 
                    'wpb_pulse', 
                    'wpb_swing', 
                    'wpb_rubberBand', 
                    'wpb_wobble', 
                    'wpb_tada'
                )
            ),
            'group'       => esc_html__( 'Haru Options', 'haru-circle' )
        );

        $add_params_row = array(
            array(
                'type'        => 'dropdown',
                'heading'     => esc_html__( 'Row background overlay', 'haru-circle' ),
                'param_name'  => 'overlay_set',
                'description' => esc_html__( 'Hide or Show overlay on row background image.', 'haru-circle' ),
                'value'       => array(
                    esc_html__( 'Hide', 'haru-circle' )               => 'hide_overlay',
                    esc_html__( 'Show Overlay Color', 'haru-circle' ) => 'show_overlay_color',
                ),
                'group'       => esc_html__( 'Haru Options', 'haru-circle' )
            ),
            array(
                'type'        => 'colorpicker',
                'heading'     => esc_html__( 'Overlay color', 'haru-circle' ),
                'param_name'  => 'overlay_color',
                'description' => esc_html__( 'Select color for background overlay.', 'haru-circle' ),
                'value'       => '',
                'dependency'  => array(
                    'element' => 'overlay_set', 
                    'value'   => array('show_overlay_color')
                ),
                'group'       => esc_html__( 'Haru Options', 'haru-circle' )
            ),
            array(
                'type'        => 'number',
                'class'       => '',
                'heading'     => esc_html__( 'Overlay opacity', 'haru-circle' ),
                'param_name'  => 'overlay_opacity',
                'value'       => '50',
                'min'         => '1',
                'max'         => '100',
                'suffix'      => '%',
                'description' => esc_html__( 'Select opacity for overlay.', 'haru-circle' ),
                'dependency'  => array(
                    'element' => 'overlay_set', 
                    'value'   => array( 'show_overlay_color', 'show_overlay_image' )
                ),
                'group'       => esc_html__( 'Haru Options', 'haru-circle' )
            ),
            $add_css_animation,
            $add_duration_animation,
            $add_delay_animation,
        );

        $add_params_row_inner = array(
            $add_css_animation,
            $add_duration_animation,
            $add_delay_animation,
        );

        $add_params_column = array(
            $add_css_animation,
            $add_duration_animation,
            $add_delay_animation,
        );

        $add_params_heading = array(
            array(
                'type'        => 'dropdown',
                'heading'     => esc_html__( 'Heading Style', 'haru-circle' ),
                'param_name'  => 'heading_style',
                'description' => esc_html__( 'Choose Pre-made Heading style.', 'haru-circle' ),
                'value'       => array(
                    esc_html__( 'Default', 'haru-circle' )                                     => 'default',
                    esc_html__( 'Heading Style 1 (Primary font)', 'haru-circle' )              => 'heading_style_1',
                    esc_html__( 'Heading Style 2 (Secondary font)', 'haru-circle' )            => 'heading_style_2',
                    esc_html__( 'Heading Style 3 (Primary font Italic)', 'haru-circle' )       => 'heading_style_3',
                    esc_html__( 'Heading Style 4 (Secondary font Italic)', 'haru-circle' )     => 'heading_style_4',
                    esc_html__( 'Heading Style 5 (Secondary font Slash Sign)', 'haru-circle' ) => 'heading_style_5',
                    esc_html__( 'Sub Heading Style 1', 'haru-circle' )                         => 'sub_heading_style_1',
                    esc_html__( 'Sub Heading Style 2', 'haru-circle' )                         => 'sub_heading_style_2',
                    esc_html__( 'Footer Heading 1 (Slash Sign)', 'haru-circle' )               => 'footer_style_1',
                ),
                'weight' => 1, //  default 0 - unsorted and appended to bottom, 1 - appended to top
            ),
        );

        $add_params_button = array(
            array(
                'type'        => 'dropdown',
                'heading'     => esc_html__( 'Button Style', 'haru-circle' ),
                'param_name'  => 'button_style',
                'description' => esc_html__( 'Choose Pre-made Button style.', 'haru-circle' ),
                'value'       => array(
                    esc_html__( 'Default', 'haru-circle' )                          => 'default',
                    esc_html__( 'Button Style 1', 'haru-circle' )                   => 'button_style_1',
                    esc_html__( 'Button Style 2', 'haru-circle' )                   => 'button_style_2',
                    esc_html__( 'Button Style 1 (Background Dark)', 'haru-circle' ) => 'button_style_3',
                    esc_html__( 'Button Style 2 (Background Dark)', 'haru-circle' ) => 'button_style_4',
                    esc_html__( 'Button Style 3 (Text Icon Play)', 'haru-circle' )  => 'button_style_5',
                    esc_html__( 'Button Style 4 (Home 9)', 'haru-circle' )          => 'button_style_6',
                ),
                'weight' => 1, //  default 0 - unsorted and appended to bottom, 1 - appended to top
            ),
        );

        // 1. Add new parameters for row
        foreach( $add_params_row as $param_row ) {
            vc_add_param( 'vc_row', $param_row );
        }
        // 2. Add new parameters for row_inner
        foreach( $add_params_row_inner as $param_row_inner ) {
            vc_add_param( 'vc_row_inner', $param_row_inner );
        }

        // 3. Add new parameters for column
        foreach( $add_params_column as $param_column ) {
            vc_add_param( 'vc_column', $param_column );
        }
        
        // 4. Add new parameters for custom heading
        foreach( $add_params_heading as $param_heading ) {
            vc_add_param( 'vc_custom_heading', $param_heading );
        }

        // 5. Add new parameters for button
        foreach( $add_params_button as $param_button ) {
            vc_add_param( 'vc_btn', $param_button );
        }
    }
}

haru_add_vc_param();
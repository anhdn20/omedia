<?php

/**
 * ReduxFramework Sample Config File
 * For full documentation, please visit: http://docs.reduxframework.com/
 */

if ( ! class_exists( 'Redux_Framework_theme_options' ) ) {

    class Redux_Framework_theme_options {

        public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {
            if ( ! class_exists( 'HaruReduxFramework' ) ) {
                return;
            }

            $this->initSettings();
        }

        public function initSettings() {
            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            // If Redux is running as a plugin, this will remove the demo notice and links
            add_action( 'init', array( $this, 'remove_demo' ) );

            if ( ! isset( $this->args['opt_name'] ) ) { // No errors please
                return;
            }

            $this->ReduxFramework = new HaruReduxFramework( $this->sections, $this->args );
        }

        /**
         * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
         * */
        function change_arguments( $args ) {
            $args['dev_mode'] = false;

            return $args;
        }

        /**
         * Filter hook for filtering the default value of any given field. Very useful in development mode.
         * */
        function change_defaults( $defaults ) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {
            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }

        public function setSections() {
            // General Setting
            $this->sections[] = array(
                'title'  => esc_html__( 'General Setting', 'haru-circle' ),
                'desc'   => esc_html__( 'Welcome to Haru Circle theme options panel! You can easy to customize the theme for your purpose!', 'haru-circle' ),
                'icon'   => 'el el-cog',
                'fields' => array(
                    array(
                        'id'       => 'layout_style',
                        'type'     => 'image_select',
                        'title'    => esc_html__( 'Layout Style', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Select the layout style', 'haru-circle' ),
                        'desc'     => '',
                        'options'  => array(
                            'boxed' => array('title' => 'Boxed', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/layout-boxed.png'),
                            'wide'  => array('title' => 'Wide', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/layout-wide.png'),
                            'float' => array('title' => 'Float', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/layout-float.png')
                        ),
                        'default'  => 'wide'
                    ),

                    array(
                        'id'       => 'layout_site_max_width',
                        'type'     => 'slider',
                        'title'    => esc_html__( 'Site Max Width (px)', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Set the site max width of body', 'haru-circle' ),
                        'default'  => '1200',
                        "min"      => 980,
                        "step"     => 10,
                        "max"      => 1600,
                        'required' => array('layout_style','=','boxed'),
                    ),

                    array(
                        'id'       => 'body_background_mode',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Body Background Mode', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Chose Background Mode', 'haru-circle' ),
                        'desc'     => '',
                        'options'  => array(
                            'background' => 'Background',
                            'pattern'    => 'Pattern'
                        ),
                        'default'  => 'background',
                        'required' => array('layout_style','=','boxed'),
                    ),

                    array(
                        'id'       => 'body_background',
                        'type'     => 'background',
                        'output'   => array( 'body' ),
                        'title'    => esc_html__( 'Body Background', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Body background (Apply for Boxed layout style).', 'haru-circle' ),
                        'default'  => array(
                            'background-color'      => '',
                            'background-repeat'     => 'no-repeat',
                            'background-position'   => 'center center',
                            'background-attachment' => 'fixed',
                            'background-size'       => 'cover'
                        ),
                        'required'  => array(
                            array('body_background_mode', '=', array('background'))
                        ),
                    ),

                    array(
                        'id'       => 'body_background_pattern',
                        'type'     => 'image_select',
                        'title'    => esc_html__( 'Background Pattern', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Body background pattern(Apply for Boxed layout style)', 'haru-circle' ),
                        'desc'     => '',
                        'height'   => '40px',
                        'options'  => array(
                            'pattern-1.png' => array('title' => '', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/pattern-1.png'),
                            'pattern-2.png' => array('title' => '', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/pattern-2.png'),
                            'pattern-3.png' => array('title' => '', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/pattern-3.png'),
                            'pattern-4.png' => array('title' => '', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/pattern-4.png'),
                            'pattern-5.png' => array('title' => '', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/pattern-5.png'),
                            'pattern-6.png' => array('title' => '', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/pattern-6.png'),
                            'pattern-7.png' => array('title' => '', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/pattern-7.png'),
                            'pattern-8.png' => array('title' => '', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/pattern-8.png'),
                            'pattern-9.png' => array('title' => '', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/pattern-9.png'),
                            'pattern-10.png' => array('title' => '', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/pattern-10.png'),
                        ),
                        'default'  => 'pattern-1.png',
                        'required' => array(
                            array('body_background_mode', '=', array('pattern'))
                        ) ,
                    ),
                    
                    array(
                        'id'       => 'home_preloader',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Page Preloader', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Select Page Preloader. Leave empty if you don\'t want to use this.', 'haru-circle' ),
                        'desc'     => '',
                        'options'  => array(
                            'square-1'   => 'Square 01',
                            'square-2'   => 'Square 02',
                            'square-3'   => 'Square 03',
                            'square-4'   => 'Square 04',
                            'square-5'   => 'Square 05',
                            'square-6'   => 'Square 06',
                            'square-7'   => 'Square 07',
                            'square-8'   => 'Square 08',
                            'square-9'   => 'Square 09',
                            'round-1'    => 'Round 01',
                            'round-2'    => 'Round 02',
                            'round-3'    => 'Round 03',
                            'round-4'    => 'Round 04',
                            'round-5'    => 'Round 05',
                            'round-6'    => 'Round 06',
                            'round-7'    => 'Round 07',
                            'round-8'    => 'Round 08',
                            'round-9'    => 'Round 09',
                        ),
                        'default' => ''
                    ),

                    array(
                        'id'       => 'home_preloader_bg_color',
                        'type'     => 'color_rgba',
                        'title'    => esc_html__( 'Preloader background color', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Set Preloader background color.', 'haru-circle' ),
                        'default'  => array(),
                        'mode'     => 'background',
                        'validate' => 'colorrgba',
                        'required' => array('home_preloader', 'not_empty_and', array('none')),
                    ),

                    array(
                        'id'       => 'home_preloader_spinner_color',
                        'type'     => 'color',
                        'title'    => esc_html__( 'Preloader spinner color', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Pick a preloader spinner color', 'haru-circle' ),
                        'default'  => '#e8e8e8',
                        'validate' => 'color',
                        'required' => array( 'home_preloader', 'not_empty_and', array('none') ),
                    ),

                    array(
                        'id'       => 'back_to_top',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Back To Top', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Enable/Disable Back to top button', 'haru-circle' ),
                        'default'  => true
                    ),

                    // Custom CSS & Script
                    array(
                        'id'       => 'custom_css',
                        'type'     => 'ace_editor',
                        'mode'     => 'css',
                        'theme'    => 'monokai',
                        'title'    => esc_html__('Custom CSS', 'haru-circle'),
                        'subtitle' => esc_html__('Paste your CSS code here. Do not place any <style> tags in these areas as they are already added for your convenience', 'haru-circle'),
                        'desc'     => '',
                        'default'  => '',
                        'options'  => array('minLines'=> 10, 'maxLines' => 60)
                    ),
                    array(
                        'id'       => 'custom_js',
                        'type'     => 'ace_editor',
                        'mode'     => 'javascript',
                        'theme'    => 'chrome',
                        'title'    => esc_html__('Custom JS', 'haru-circle'),
                        'subtitle' => esc_html__('Paste your Javscript code here. You can add your Google Analytics Code here. Do not place any <script> tags in these areas as they are already added for your convenience.', 'haru-circle'),
                        'desc'     => '',
                        'default'  => '',
                        'options'  => array('minLines'=> 10, 'maxLines' => 60)
                    ),

                )
            );
            
            // Circle
            $this->sections[] = array(
                'title'  => esc_html__( 'Circle Settings', 'haru-circle' ),
                'desc'   => esc_html__( 'Let\'s choose Sub section of Section and customize', 'haru-circle'),
                'icon'   => 'el el-play-circle',
                'fields' => array(

                )
            );

            // Actor
            $this->sections[] = array(
                'title'      => esc_html__( 'Actor', 'haru-circle' ),
                'desc'       => '',
                'subsection' => true,
                'icon'       => 'el el-user',
                'fields'     => array(
                    array(
                        'id'       => 'archive_actor_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Layout', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Select Archive Layout', 'haru-circle' ),
                        'desc'     => '',
                        'options'  => array(
                            'full'            => esc_html__( 'Full Width', 'haru-circle' ),
                            'container'       => esc_html__( 'Container', 'haru-circle' ),
                            ),
                        'default'  => 'container'
                    ),

                    array(
                        'id'       => 'archive_actor_sidebar',
                        'type'     => 'image_select',
                        'title'    => esc_html__( 'Sidebar', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Set Sidebar Style', 'haru-circle' ),
                        'desc'     => '',
                        'options'  => array(
                            'none'     => array('title' => '', 'img' => get_template_directory_uri() . '/framework/admin-assets/images/theme-options/sidebar-none.png'),
                            'left'     => array('title' => '', 'img' => get_template_directory_uri() . '/framework/admin-assets/images/theme-options/sidebar-left.png'),
                            'right'    => array('title' => '', 'img' => get_template_directory_uri() . '/framework/admin-assets/images/theme-options/sidebar-right.png'),
                        ),
                        'default'  => 'left'
                    ),

                    array(
                        'id'       => 'archive_actor_left_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Left Sidebar', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Choose the default left sidebar', 'haru-circle' ),
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'sidebar-1',
                        'required' => array('archive_actor_sidebar', '=', array('left','both')),
                    ),

                    array(
                        'id'       => 'archive_actor_right_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Right Sidebar', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Choose the default right sidebar', 'haru-circle' ),
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'sidebar-2',
                        'required' => array('archive_actor_sidebar', '=', array('right','both')),
                    ),

                    array(
                        'id'       => 'archive_actor_display_type',
                        'type'     => 'select',
                        'title'    => esc_html__('Archive Display Type', 'haru-circle'),
                        'subtitle' => esc_html__('Select archive display type', 'haru-circle'),
                        'desc'     => '',
                        'options'  => array(
                            'grid'         => esc_html__('Grid','haru-circle'),
                            'masonry'      => esc_html__('Masonry','haru-circle'),
                        ),
                        'default'  => 'grid'
                    ),

                    array(
                        'id'       => 'archive_actor_paging_style',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Paging Style', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Select archive paging style', 'haru-circle' ),
                        'desc'     => '',
                        'options'  => array(
                            'default'         => esc_html__( 'Default', 'haru-circle' ),
                            'load-more'       => esc_html__( 'Load More', 'haru-circle' ),
                            'infinity-scroll' => esc_html__( 'Infinity Scroll', 'haru-circle' )
                        ),
                        'default'  => 'default'
                    ),

                    array(
                        'id'       => 'archive_actor_display_columns',
                        'type'     => 'select',
                        'title'    => esc_html__('Archive Display Columns', 'haru-circle'),
                        'subtitle' => esc_html__('Choose the number of columns to display on archive pages.','haru-circle'),
                        'options'  => array(
                            '2'     => '2',
                            '3'     => '3',
                            '4'     => '4',
                        ),
                        'desc'     => '',
                        'default'  => '2',
                        'required' => array('archive_actor_display_type','=',array('grid','masonry')),
                    ),

                    array(
                        'id'        => 'archive_actor_number_exceprt',
                        'type'      => 'text',
                        'title'     => esc_html__( 'Length of excerpt','haru-circle' ),
                        'value'     => '30'    
                    ),

                    array(
                        'id'     => 'section-archive-actor-title-setting-start',
                        'type'   => 'section',
                        'title'  => esc_html__('Archive Title Setting', 'haru-circle'),
                        'indent' => true
                    ),

                    array(
                        'id'       => 'show_archive_actor_title',
                        'type'     => 'switch',
                        'title'    => esc_html__('Show Archive Title', 'haru-circle'),
                        'subtitle' => esc_html__('Enable/Disable Archive Title', 'haru-circle'),
                        'default'  => true
                    ),

                    array(
                        'id'       => 'archive_actor_title_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Archive Title Layout', 'haru-circle'),
                        'subtitle' => esc_html__('Select Archive Title Layout', 'haru-circle'),
                        'desc'     => '',
                        'options'  => array('full' => 'Full Width','container' => 'Container'),
                        'default'  => 'container',
                        'required' => array('show_archive_actor_title','=',array('1')),
                    ),

                    array(
                        'id'       => 'archive_actor_title_bg_image',
                        'type'     => 'media',
                        'url'      => true,
                        'title'    => esc_html__('Archive Title Background', 'haru-circle'),
                        'subtitle' => esc_html__('Upload archive title background.', 'haru-circle'),
                        'desc'     => '',
                        'default'  =>  array(
                            'url' => get_template_directory_uri() . '/framework/admin-assets/images/theme-options/bg-page-title.jpg'
                        ),
                        'required' => array('show_archive_actor_title','=',array('1')),
                    ),

                    array(
                        'id'       => 'archive_actor_title_parallax',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Archive Title Parallax', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Enable Archive Title Parallax', 'haru-circle' ),
                        'default'  => false,
                        'required' => array('show_archive_actor_title','=',array('1')),
                    ),

                    array(
                        'id'       => 'breadcrumbs_in_archive_actor_title',
                        'type'     => 'switch',
                        'title'    => esc_html__('Breadcrumbs', 'haru-circle'),
                        'subtitle' => esc_html__('Enable/Disable Breadcrumbs In Archive', 'haru-circle'),
                        'default'  => true
                    ),
                )
            );

            // Director
            $this->sections[] = array(
                'title'      => esc_html__( 'Director', 'haru-circle' ),
                'desc'       => '',
                'subsection' => true,
                'icon'       => 'el el-torso',
                'fields'     => array(
                    array(
                        'id'       => 'archive_director_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Layout', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Select Archive Layout', 'haru-circle' ),
                        'desc'     => '',
                        'options'  => array(
                            'full'            => esc_html__( 'Full Width', 'haru-circle' ),
                            'container'       => esc_html__( 'Container', 'haru-circle' ),
                            ),
                        'default'  => 'container'
                    ),

                    array(
                        'id'       => 'archive_director_sidebar',
                        'type'     => 'image_select',
                        'title'    => esc_html__( 'Sidebar', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Set Sidebar Style', 'haru-circle' ),
                        'desc'     => '',
                        'options'  => array(
                            'none'     => array('title' => '', 'img' => get_template_directory_uri() . '/framework/admin-assets/images/theme-options/sidebar-none.png'),
                            'left'     => array('title' => '', 'img' => get_template_directory_uri() . '/framework/admin-assets/images/theme-options/sidebar-left.png'),
                            'right'    => array('title' => '', 'img' => get_template_directory_uri() . '/framework/admin-assets/images/theme-options/sidebar-right.png'),
                        ),
                        'default'  => 'left'
                    ),

                    array(
                        'id'       => 'archive_director_left_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Left Sidebar', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Choose the default left sidebar', 'haru-circle' ),
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'sidebar-1',
                        'required' => array('archive_director_sidebar', '=', array('left','both')),
                    ),

                    array(
                        'id'       => 'archive_director_right_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Right Sidebar', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Choose the default right sidebar', 'haru-circle' ),
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'sidebar-2',
                        'required' => array('archive_director_sidebar', '=', array('right','both')),
                    ),

                    array(
                        'id'       => 'archive_director_display_type',
                        'type'     => 'select',
                        'title'    => esc_html__('Archive Display Type', 'haru-circle'),
                        'subtitle' => esc_html__('Select archive display type', 'haru-circle'),
                        'desc'     => '',
                        'options'  => array(
                            'grid'         => esc_html__('Grid','haru-circle'),
                            'masonry'      => esc_html__('Masonry','haru-circle'),
                        ),
                        'default'  => 'grid'
                    ),

                    array(
                        'id'       => 'archive_director_paging_style',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Paging Style', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Select archive paging style', 'haru-circle' ),
                        'desc'     => '',
                        'options'  => array(
                            'default'         => esc_html__( 'Default', 'haru-circle' ),
                            'load-more'       => esc_html__( 'Load More', 'haru-circle' ),
                            'infinity-scroll' => esc_html__( 'Infinity Scroll', 'haru-circle' )
                        ),
                        'default'  => 'default'
                    ),

                    array(
                        'id'       => 'archive_director_display_columns',
                        'type'     => 'select',
                        'title'    => esc_html__('Archive Display Columns', 'haru-circle'),
                        'subtitle' => esc_html__('Choose the number of columns to display on archive pages.','haru-circle'),
                        'options'  => array(
                            '2'     => '2',
                            '3'     => '3',
                            '4'     => '4',
                        ),
                        'desc'     => '',
                        'default'  => '2',
                        'required' => array('archive_director_display_type','=',array('grid','masonry')),
                    ),

                    array(
                        'id'        => 'archive_director_number_exceprt',
                        'type'      => 'text',
                        'title'     => esc_html__( 'Length of excerpt','haru-circle' ),
                        'value'     => '30'    
                    ),

                    array(
                        'id'     => 'section-archive-director-title-setting-start',
                        'type'   => 'section',
                        'title'  => esc_html__('Archive Title Setting', 'haru-circle'),
                        'indent' => true
                    ),

                    array(
                        'id'       => 'show_archive_director_title',
                        'type'     => 'switch',
                        'title'    => esc_html__('Show Archive Title', 'haru-circle'),
                        'subtitle' => esc_html__('Enable/Disable Archive Title', 'haru-circle'),
                        'default'  => true
                    ),

                    array(
                        'id'       => 'archive_director_title_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Archive Title Layout', 'haru-circle'),
                        'subtitle' => esc_html__('Select Archive Title Layout', 'haru-circle'),
                        'desc'     => '',
                        'options'  => array('full' => 'Full Width','container' => 'Container'),
                        'default'  => 'container',
                        'required' => array('show_archive_director_title','=',array('1')),
                    ),

                    array(
                        'id'       => 'archive_director_title_bg_image',
                        'type'     => 'media',
                        'url'      => true,
                        'title'    => esc_html__('Archive Title Background', 'haru-circle'),
                        'subtitle' => esc_html__('Upload archive title background.', 'haru-circle'),
                        'desc'     => '',
                        'default'  =>  array(
                            'url' => get_template_directory_uri() . '/framework/admin-assets/images/theme-options/bg-page-title.jpg'
                        ),
                        'required' => array('show_archive_director_title','=',array('1')),
                    ),

                    array(
                        'id'       => 'archive_director_title_parallax',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Archive Title Parallax', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Enable Archive Title Parallax', 'haru-circle' ),
                        'default'  => false,
                        'required' => array('show_archive_director_title','=',array('1')),
                    ),

                    array(
                        'id'       => 'breadcrumbs_in_archive_director_title',
                        'type'     => 'switch',
                        'title'    => esc_html__('Breadcrumbs', 'haru-circle'),
                        'subtitle' => esc_html__('Enable/Disable Breadcrumbs In Archive', 'haru-circle'),
                        'default'  => true
                    ),
                )
            );

            // Video
            $this->sections[] = array(
                'title'      => esc_html__( 'Archive Video', 'haru-circle' ),
                'desc'       => '',
                'subsection' => true,
                'icon'       => 'el el-facetime-video',
                'fields'     => array(
                    array(
                        'id'       => 'archive_video_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Layout', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Select Archive Layout', 'haru-circle' ),
                        'desc'     => '',
                        'options'  => array(
                            'full'            => esc_html__( 'Full Width', 'haru-circle' ),
                            'container'       => esc_html__( 'Container', 'haru-circle' ),
                            ),
                        'default'  => 'container'
                    ),

                    array(
                        'id'       => 'archive_video_sidebar',
                        'type'     => 'image_select',
                        'title'    => esc_html__( 'Sidebar', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Set Sidebar Style', 'haru-circle' ),
                        'desc'     => '',
                        'options'  => array(
                            'none'     => array('title' => '', 'img' => get_template_directory_uri() . '/framework/admin-assets/images/theme-options/sidebar-none.png'),
                            'left'     => array('title' => '', 'img' => get_template_directory_uri() . '/framework/admin-assets/images/theme-options/sidebar-left.png'),
                            'right'    => array('title' => '', 'img' => get_template_directory_uri() . '/framework/admin-assets/images/theme-options/sidebar-right.png'),
                        ),
                        'default'  => 'left'
                    ),

                    array(
                        'id'       => 'archive_video_left_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Left Sidebar', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Choose the default left sidebar', 'haru-circle' ),
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'sidebar-1',
                        'required' => array('archive_video_sidebar', '=', array('left','both')),
                    ),

                    array(
                        'id'       => 'archive_video_right_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Right Sidebar', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Choose the default right sidebar', 'haru-circle' ),
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'sidebar-2',
                        'required' => array('archive_video_sidebar', '=', array('right','both')),
                    ),

                    array(
                        'id'       => 'archive_video_display_type',
                        'type'     => 'select',
                        'title'    => esc_html__('Archive Display Type', 'haru-circle'),
                        'subtitle' => esc_html__('Select archive display type', 'haru-circle'),
                        'desc'     => '',
                        'options'  => array(
                            'grid'         => esc_html__('Grid','haru-circle'),
                            'masonry'      => esc_html__('Masonry','haru-circle'),
                        ),
                        'default'  => 'grid'
                    ),

                    array(
                        'id'       => 'archive_video_paging_style',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Paging Style', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Select archive paging style', 'haru-circle' ),
                        'desc'     => '',
                        'options'  => array(
                            'default'         => esc_html__( 'Default', 'haru-circle' ),
                            'load-more'       => esc_html__( 'Load More', 'haru-circle' ),
                            'infinity-scroll' => esc_html__( 'Infinity Scroll', 'haru-circle' )
                        ),
                        'default'  => 'default'
                    ),

                    array(
                        'id'       => 'archive_video_display_columns',
                        'type'     => 'select',
                        'title'    => esc_html__('Archive Display Columns', 'haru-circle'),
                        'subtitle' => esc_html__('Choose the number of columns to display on archive pages.','haru-circle'),
                        'options'  => array(
                            '2'     => '2',
                            '3'     => '3',
                            '4'     => '4',
                        ),
                        'desc'     => '',
                        'default'  => '2',
                        'required' => array('archive_video_display_type','=',array('grid','masonry')),
                    ),

                    array(
                        'id'        => 'archive_video_number_exceprt',
                        'type'      => 'text',
                        'title'     => esc_html__( 'Length of excerpt','haru-circle' ),
                        'value'     => '30'    
                    ),

                    array(
                        'id'     => 'section-archive-video-title-setting-start',
                        'type'   => 'section',
                        'title'  => esc_html__('Archive Title Setting', 'haru-circle'),
                        'indent' => true
                    ),

                    array(
                        'id'       => 'show_archive_video_title',
                        'type'     => 'switch',
                        'title'    => esc_html__('Show Archive Title', 'haru-circle'),
                        'subtitle' => esc_html__('Enable/Disable Archive Title', 'haru-circle'),
                        'default'  => true
                    ),

                    array(
                        'id'       => 'archive_video_title_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Archive Title Layout', 'haru-circle'),
                        'subtitle' => esc_html__('Select Archive Title Layout', 'haru-circle'),
                        'desc'     => '',
                        'options'  => array('full' => 'Full Width','container' => 'Container'),
                        'default'  => 'container',
                        'required' => array('show_archive_video_title','=',array('1')),
                    ),

                    array(
                        'id'       => 'archive_video_title_bg_image',
                        'type'     => 'media',
                        'url'      => true,
                        'title'    => esc_html__('Archive Title Background', 'haru-circle'),
                        'subtitle' => esc_html__('Upload archive title background.', 'haru-circle'),
                        'desc'     => '',
                        'default'  =>  array(
                            'url' => get_template_directory_uri() . '/framework/admin-assets/images/theme-options/bg-page-title.jpg'
                        ),
                        'required' => array('show_archive_video_title','=',array('1')),
                    ),

                    array(
                        'id'       => 'archive_video_title_parallax',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Archive Title Parallax', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Enable Archive Title Parallax', 'haru-circle' ),
                        'default'  => false,
                        'required' => array('show_archive_video_title','=',array('1')),
                    ),

                    array(
                        'id'       => 'breadcrumbs_in_archive_video_title',
                        'type'     => 'switch',
                        'title'    => esc_html__('Breadcrumbs', 'haru-circle'),
                        'subtitle' => esc_html__('Enable/Disable Breadcrumbs In Archive', 'haru-circle'),
                        'default'  => true
                    ),
                )
            );

            // Single Video
            $this->sections[] = array(
                'title'      => esc_html__( 'Single Video', 'haru-circle' ),
                'desc'       => '',
                'icon'       => 'el el-file',
                'subsection' => true,
                'fields'     => array(
                    array(
                        'id'       => 'haru_video_single_style',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Single Style', 'haru-circle' ),
                        'subtitle' => '',
                        'desc'     => '',
                        'options'  => array(
                            'style_1'     => esc_html__( 'Default', 'haru-circle' ),
                        ),
                        'default'  => 'style_1',
                    ),

                    array(
                        'id'     => 'haru-section-single-video-title-setting-start',
                        'type'   => 'section',
                        'title'  => esc_html__( 'Single Video Title Setting', 'haru-circle' ),
                        'indent' => true
                    ),

                    array(
                        'id'       => 'haru_show_single_video_title',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Single Video Title', 'haru-circle' ),
                        'subtitle' => '',
                        'default'  => true
                    ),

                    array(
                        'id'       => 'haru_single_video_title_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Single Video Title Layout', 'haru-circle' ),
                        'subtitle' => '',
                        'desc'     => '',
                        'options'  => array(
                            'full'            => esc_html__( 'Full Width', 'haru-circle' ),
                            'container'       => esc_html__( 'Container', 'haru-circle' ),
                        ),
                        'default'  => 'full',
                        'required' => array('haru_show_single_video_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'haru_single_video_title_bg_image',
                        'type'     => 'media',
                        'url'      => true,
                        'title'    => esc_html__( 'Single Video Title Background', 'haru-circle' ),
                        'subtitle' => '',
                        'desc'     => '',
                        'default'  =>  array(
                            'url' => get_template_directory_uri() . '/framework/admin-assets/images/theme-options/bg-page-title.jpg'
                        ),
                        'required'  => array('haru_show_single_video_title', '=', array('1'))
                    ),

                    array(
                        'id'       => 'haru_single_video_title_parallax',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Single Video Title Parallax', 'haru-circle' ),
                        'subtitle' => '',
                        'default'  => false,
                        'required' => array('haru_show_single_video_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'haru_breadcrumbs_in_single_video_title',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Breadcrumbs', 'haru-circle' ),
                        'subtitle' => '',
                        'default'  => true
                    ),
                )
            );

            // Film
            $this->sections[] = array(
                'title'      => esc_html__( 'Archive Film', 'haru-circle' ),
                'desc'       => '',
                'subsection' => true,
                'icon'       => 'el el-film',
                'fields'     => array(
                    array(
                        'id'       => 'archive_film_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Layout', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Select Archive Layout', 'haru-circle' ),
                        'desc'     => '',
                        'options'  => array(
                            'full'            => esc_html__( 'Full Width', 'haru-circle' ),
                            'container'       => esc_html__( 'Container', 'haru-circle' ),
                            ),
                        'default'  => 'container'
                    ),

                    array(
                        'id'       => 'archive_film_sidebar',
                        'type'     => 'image_select',
                        'title'    => esc_html__( 'Sidebar', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Set Sidebar Style', 'haru-circle' ),
                        'desc'     => '',
                        'options'  => array(
                            'none'     => array('title' => '', 'img' => get_template_directory_uri() . '/framework/admin-assets/images/theme-options/sidebar-none.png'),
                            'left'     => array('title' => '', 'img' => get_template_directory_uri() . '/framework/admin-assets/images/theme-options/sidebar-left.png'),
                            'right'    => array('title' => '', 'img' => get_template_directory_uri() . '/framework/admin-assets/images/theme-options/sidebar-right.png'),
                        ),
                        'default'  => 'left'
                    ),

                    array(
                        'id'       => 'archive_film_left_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Left Sidebar', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Choose the default left sidebar', 'haru-circle' ),
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'sidebar-1',
                        'required' => array('archive_film_sidebar', '=', array('left','both')),
                    ),

                    array(
                        'id'       => 'archive_film_right_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Right Sidebar', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Choose the default right sidebar', 'haru-circle' ),
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'sidebar-2',
                        'required' => array('archive_film_sidebar', '=', array('right','both')),
                    ),

                    array(
                        'id'       => 'archive_film_display_type',
                        'type'     => 'select',
                        'title'    => esc_html__('Archive Display Type', 'haru-circle'),
                        'subtitle' => esc_html__('Select archive display type', 'haru-circle'),
                        'desc'     => '',
                        'options'  => array(
                            'grid'         => esc_html__('Grid','haru-circle'),
                            'masonry'      => esc_html__('Masonry','haru-circle'),
                        ),
                        'default'  => 'grid'
                    ),

                    array(
                        'id'       => 'archive_film_paging_style',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Paging Style', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Select archive paging style', 'haru-circle' ),
                        'desc'     => '',
                        'options'  => array(
                            'default'         => esc_html__( 'Default', 'haru-circle' ),
                            'load-more'       => esc_html__( 'Load More', 'haru-circle' ),
                            'infinity-scroll' => esc_html__( 'Infinity Scroll', 'haru-circle' )
                        ),
                        'default'  => 'default'
                    ),

                    array(
                        'id'       => 'archive_film_display_columns',
                        'type'     => 'select',
                        'title'    => esc_html__('Archive Display Columns', 'haru-circle'),
                        'subtitle' => esc_html__('Choose the number of columns to display on archive pages.','haru-circle'),
                        'options'  => array(
                            '2'     => '2',
                            '3'     => '3',
                            '4'     => '4',
                        ),
                        'desc'     => '',
                        'default'  => '2',
                        'required' => array('archive_film_display_type','=',array('grid','masonry')),
                    ),

                    array(
                        'id'        => 'archive_film_number_exceprt',
                        'type'      => 'text',
                        'title'     => esc_html__( 'Length of excerpt','haru-circle' ),
                        'value'     => '30'    
                    ),

                    array(
                        'id'     => 'section-archive-film-title-setting-start',
                        'type'   => 'section',
                        'title'  => esc_html__('Archive Title Setting', 'haru-circle'),
                        'indent' => true
                    ),

                    array(
                        'id'       => 'show_archive_film_title',
                        'type'     => 'switch',
                        'title'    => esc_html__('Show Archive Title', 'haru-circle'),
                        'subtitle' => esc_html__('Enable/Disable Archive Title', 'haru-circle'),
                        'default'  => true
                    ),

                    array(
                        'id'       => 'archive_film_title_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Archive Title Layout', 'haru-circle'),
                        'subtitle' => esc_html__('Select Archive Title Layout', 'haru-circle'),
                        'desc'     => '',
                        'options'  => array('full' => 'Full Width','container' => 'Container'),
                        'default'  => 'container',
                        'required' => array('show_archive_film_title','=',array('1')),
                    ),

                    array(
                        'id'       => 'archive_film_title_bg_image',
                        'type'     => 'media',
                        'url'      => true,
                        'title'    => esc_html__('Archive Title Background', 'haru-circle'),
                        'subtitle' => esc_html__('Upload archive title background.', 'haru-circle'),
                        'desc'     => '',
                        'default'  =>  array(
                            'url' => get_template_directory_uri() . '/framework/admin-assets/images/theme-options/bg-page-title.jpg'
                        ),
                        'required' => array('show_archive_film_title','=',array('1')),
                    ),

                    array(
                        'id'       => 'archive_film_title_parallax',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Archive Title Parallax', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Enable Archive Title Parallax', 'haru-circle' ),
                        'default'  => false,
                        'required' => array('show_archive_film_title','=',array('1')),
                    ),

                    array(
                        'id'       => 'breadcrumbs_in_archive_film_title',
                        'type'     => 'switch',
                        'title'    => esc_html__('Breadcrumbs', 'haru-circle'),
                        'subtitle' => esc_html__('Enable/Disable Breadcrumbs In Archive', 'haru-circle'),
                        'default'  => true
                    ),
                )
            );

            // Single Film
            $this->sections[] = array(
                'title'      => esc_html__( 'Single Film', 'haru-circle' ),
                'desc'       => '',
                'icon'       => 'el el-file',
                'subsection' => true,
                'fields'     => array(
                    array(
                        'id'       => 'haru_film_single_style',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Single Style', 'haru-circle' ),
                        'subtitle' => '',
                        'desc'     => '',
                        'options'  => array(
                            'style_1'     => esc_html__( 'Default', 'haru-circle' ),
                        ),
                        'default'  => 'style_1',
                    ),

                    array(
                        'id'     => 'haru-section-single-film-title-setting-start',
                        'type'   => 'section',
                        'title'  => esc_html__( 'Single Film Title Setting', 'haru-circle' ),
                        'indent' => true
                    ),

                    array(
                        'id'       => 'haru_show_single_film_title',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Single Film Title', 'haru-circle' ),
                        'subtitle' => '',
                        'default'  => true
                    ),

                    array(
                        'id'       => 'haru_single_film_title_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Single Film Title Layout', 'haru-circle' ),
                        'subtitle' => '',
                        'desc'     => '',
                        'options'  => array(
                            'full'            => esc_html__( 'Full Width', 'haru-circle' ),
                            'container'       => esc_html__( 'Container', 'haru-circle' ),
                        ),
                        'default'  => 'full',
                        'required' => array('haru_show_single_film_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'haru_single_film_title_bg_image',
                        'type'     => 'media',
                        'url'      => true,
                        'title'    => esc_html__( 'Single Film Title Background', 'haru-circle' ),
                        'subtitle' => '',
                        'desc'     => '',
                        'default'  =>  array(
                            'url' => get_template_directory_uri() . '/framework/admin-assets/images/theme-options/bg-page-title.jpg'
                        ),
                        'required'  => array('haru_show_single_film_title', '=', array('1'))
                    ),

                    array(
                        'id'       => 'haru_single_film_title_parallax',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Single Film Title Parallax', 'haru-circle' ),
                        'subtitle' => '',
                        'default'  => false,
                        'required' => array('haru_show_single_film_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'haru_breadcrumbs_in_single_film_title',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Breadcrumbs', 'haru-circle' ),
                        'subtitle' => '',
                        'default'  => true
                    ),
                )
            );
            
            // Player settings
            $this->sections[] = array(
                'title'      => esc_html__( 'Player', 'haru-circle' ),
                'desc'       => '',
                'subsection' => true,
                'icon'       => 'el el-film',
                'fields'     => array(
                    array(
                        'id'       => 'player_type',
                        'type'     => 'select',
                        'title'    => esc_html__('Player type', 'haru-circle'),
                        'subtitle' => esc_html__('Choose player type as Direct or Popup.','haru-circle'),
                        'options'  => array(
                            'player_popup'     => 'Player Popup',
                            'player_direct'     => 'Player Direct',
                            
                        ),
                        'desc'     => '',
                        'default'  => 'player_popup',
                    ),
                    array(
                        'id'       => 'haru_video_single_autoplay',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Single Video Autoplay', 'haru-circle' ),
                        'subtitle' => '',
                        'desc'     => esc_html__( 'Single Video Autoplay Direct or Popup. Please note Autoplay video must be muted.', 'haru-circle' ),
                        'default'  => false,
                    ),
                    array(
                        'id'       => 'player_js',
                        'type'     => 'select',
                        'title'    => esc_html__('Player JS', 'haru-circle'),
                        'subtitle' => esc_html__('Choose player JS from list.','haru-circle'),
                        'options'  => array(
                            'none'     => 'None',
                            
                        ),
                        'desc'     => '',
                        'default'  => 'none',
                    ),
                )
            );

            // Portfolio Settings
            $this->sections[] = array(
                'title'      => esc_html__( 'Portfolio', 'haru-circle' ),
                'desc'       => '',
                'icon'       => 'el el-th-large',
                'subsection' => true,
                'fields'     => array(
                    array(
                        'id'     => 'section-portfolio-single-setting-start',
                        'type'   => 'section',
                        'title'  => esc_html__( 'Portfolio Single Settings', 'haru-circle' ),
                        'indent' => true
                    ),
                    array(
                        'id'       => 'portfolio_single_style',
                        'type'     => 'image_select',
                        'title'    => esc_html__( 'Single Portfolio Layout', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Select Single Portfolio Layout', 'haru-circle' ),
                        'desc'     => '',
                        'options'  => array(
                            'single-01' => array('title' => '', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/portfolio-single-01.jpg'),
                            'single-02' => array('title' => '', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/portfolio-single-02.jpg'),
                            'single-03' => array('title' => '', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/portfolio-single-03.jpg'),
                        ),
                        'default' => 'single-01'
                    ),
                    array(
                        'id'       => 'show_portfolio_related',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Show/Hide Related', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Show or hide related in single portfolio', 'haru-circle' ),
                        'desc'     => '',
                        'options'  => array( 
                            '1' => 'Show', 
                            '0' => 'Hide' 
                        ),
                        'default'  => '1',
                    ),
                    array(
                        'id'       => 'portfolio_related_column',
                        'type'     => 'image_select',
                        'title'    => esc_html__( 'Portfolio Related Column', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Select Portfolio Related Column.', 'haru-circle' ),
                        'desc'     => '',
                        'options'  => array(
                            '2' => array('title' => 'Two Column', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/portfolio-related-2.jpg'),
                            '3' => array('title' => 'Three Column', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/portfolio-related-3.jpg'),
                            '4' => array('title' => 'Four Column', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/portfolio-related-4.jpg'),
                        ),
                        'default'  => '4',
                        'required' => array('show_portfolio_related', '=', array('1'))
                    ),
                    array(
                        'id'       => 'portfolio_social_share',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Show/Hide Share', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Show or hide Social share in single portfolio', 'haru-circle' ),
                        'desc'     => '',
                        'options'  => array( 
                            '1' => 'Show', 
                            '0' => 'Hide' 
                        ),
                        'default'  => '1',
                    ),
                    array(
                        'id'     => 'section-portfolio-title-start',
                        'type'   => 'section',
                        'title'  => esc_html__( 'Portfolio Page Title Settings', 'haru-circle' ),
                        'indent' => true
                    ),
                    array(
                        'id'       => 'show_portfolio_title',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Show Portfolio Title', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Enable/Disable Portfolio Title', 'haru-circle' ),
                        'default'  => true
                    ),
                    array(
                        'id'       => 'portfolio_title_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Portfolio Title Layout', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Select Portfolio Title Layout', 'haru-circle' ),
                        'desc'     => '',
                        'options'  => array(
                            'full'            => 'Full Width',
                            'container'       => 'Container',
                        ),
                        'default'  => 'full',
                        'required' => array('show_portfolio_title', '=', array('1')),
                    ),
                    array(
                        'id'       => 'portfolio_title_parallax',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Portfolio Title Parallax', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Enable Portfolio Title Parallax', 'haru-circle' ),
                        'desc'     => '',
                        'options'  => array( 
                            '1' => 'Enable', 
                            '0' => 'Disable' 
                        ),
                        'default'  => '0',
                        'required' => array('show_portfolio_title', '=', array('1')),
                    ),
                    array(
                        'id'       => 'portfolio_title_bg_image',
                        'type'     => 'media',
                        'url'      => true,
                        'title'    => esc_html__( 'Portfolio Title Background', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Upload portfolio title background.', 'haru-circle' ),
                        'desc'     => '',
                        'default'  => array(
                            'url' => get_template_directory_uri() . '/framework/admin-assets/images/theme-options/bg-page-title.jpg'
                        ),
                        'required'  => array('show_portfolio_title', '=', array('1')),
                    ),
                    array(
                        'id'       => 'breadcrumbs_in_portfolio_title',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Breadcrumbs in Portfolio', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Enable/Disable Breadcrumbs in Portfolio', 'haru-circle' ),
                        'default'  => true
                    ),
                )
            );

            // Header
            $this->sections[] = array(
                'title'  => esc_html__( 'Header', 'haru-circle' ),
                'desc'   => '',
                'icon'   => 'el el-credit-card',
                'fields' => array(
                    array(
                        'id'       => 'header_layout',
                        'type'     => 'image_select',
                        'title'    => esc_html__( 'Header Layout', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Select a header layout option from the examples.', 'haru-circle' ),
                        'desc'     => '',
                        'options'  => array(
                            'header-1'       => array('title' => '', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/header_1.jpg'),
                            'header-2'       => array('title' => '', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/header_2.jpg'),
                            'header-6'       => array('title' => '', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/header_6.jpg'),
                            'header-4'       => array('title' => '', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/header_4.jpg'),
                            'header-5'       => array('title' => '', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/header_5.jpg'),

                        ),
                        'default' => 'header-1'
                    ),

                    array(
                        'id'     => 'section-header-nav',
                        'type'   => 'section',
                        'title'  => esc_html__( 'Header Navigation', 'haru-circle' ),
                        'indent' => true
                    ),
                    array(
                        'id'       => 'menu_animation',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Mega Menu Animation', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Select animation for mega menu', 'haru-circle' ),
                        'desc'     => '',
                        'options'  => array(
                            'menu_fadeIn'            => 'fadeIn',
                            'menu_fadeInDown'        => 'fadeInDown',
                            'menu_fadeInUp'          => 'fadeInUp',
                            'menu_bounceIn'          => 'bounceIn',
                            'menu_flipInX'           => 'flipInX',
                            'menu_bounceInRight'     => 'bounceInRight',
                            'menu_fadeInRight'       => 'fadeInRight',
                        ),
                        'default' => 'menu_fadeIn'
                    ),
                    array(
                        'id'      => 'header_nav_layout',
                        'type'    => 'button_set',
                        'title'   => esc_html__( 'Header navigation layout', 'haru-circle' ),
                        'options' => array(
                            'container'    => esc_html__( 'Container','haru-circle' ),
                            'nav-fullwith' => esc_html__( 'Full width','haru-circle' ),
                        ),
                        'default'  => 'container'
                    ),

                    array(
                        'id'       => 'header_nav_layout_padding',
                        'type'     => 'slider',
                        'title'    => esc_html__( 'Header navigation padding left/right (px)', 'haru-circle' ),
                        'default'  => '100',
                        'min'      => 0,
                        'step'     => 1,
                        'max'      => 200,
                        'required' => array('header_nav_layout','=','nav-fullwith'),
                    ),
                    array(
                        'id'       => 'header_layout_float',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Header On Slideshow', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Menu Over Slideshow. Usually set to false and should use this only for Homepage in Page Options.', 'haru-circle' ),
                        'default'  => false,
                    ),
                    array(
                        'id'       => 'header_layout_under_slideshow',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Header Under Slideshow', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Use this when set Revolution Slider layout is Full-Screen and this will override Header On Slideshow option. Should use only in Page Options', 'haru-circle' ),
                        'default'  => false,
                    ),
                    array(
                        'id'       => 'header_sticky',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Show/Hide Header Sticky', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Show Hide header Sticky.', 'haru-circle' ),
                        'default'  => true
                    ),
                    array(
                        'id'       => 'header_sticky_skin',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Header Sticky Skin', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Select Header Sticky Skin.', 'haru-circle' ),
                        'options'  => array(
                            'sticky_dark'  => esc_html__( 'Dark','haru-circle' ),
                            'sticky_light' => esc_html__( 'Light','haru-circle' ),
                        ),
                        'default'  => 'sticky_dark'
                    ),
                    array(
                        'id'     => 'section-header-search',
                        'type'   => 'section',
                        'title'  => esc_html__( 'Header Search Settings', 'haru-circle' ),
                        'indent' => true
                    ),
                    array(
                        'id'       => 'search_box_type',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Search Box Type', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Set search box and search button type.', 'haru-circle' ),
                        'desc'     => esc_html__( 'Please note Search Box Type Ajax now doesn\'t support. We\'ll try to update it asap.', 'haru-circle' ),
                        'options'  => array(
                            'standard' => esc_html__( 'Standard', 'haru-circle' ),
                            // 'ajax'     => esc_html__( 'Ajax Search', 'haru-circle' )
                        ),
                        'default'  => 'standard'
                    ),
                    array(
                        'id'        => 'haru_search_box_post_type',
                        'type'      => 'checkbox',
                        'title'     => esc_html__('Ajax Search Post Type', 'haru-circle'),
                        'subtitle'  => esc_html__('Select post type for ajax search', 'haru-circle'),
                        'data'      => 'post_types',
                    ),
                    array(
                        'id'        => 'haru_search_box_result_amount',
                        'type'      => 'text',
                        'title'     => esc_html__( 'Search Result Amount', 'haru-circle'),
                        'desc'      => esc_html__( 'Set amount of Search Result', 'haru-circle'),
                        'validate'  => 'numeric',
                        'default'   => '3',
                        'required' => array('search_box_type', '=', 'ajax'),
                    ),
                )
            );
            
            // Top Bar
            $this->sections[] = array(
                'title'      => esc_html__( 'Top Bar', 'haru-circle' ),
                'desc'       => '',
                'subsection' => true,
                'icon'       => '',
                'fields'     => array(
                    array(
                        'id'       => 'top_bar',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Show/Hide Top Bar', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Show Hide Top Bar.', 'haru-circle' ),
                        'default'  => false
                    ),

                    array(
                        'id'      => 'top_bar_layout_width',
                        'type'    => 'button_set',
                        'title'   => esc_html__( 'Top bar layout width', 'haru-circle' ),
                        'options' => array(
                            'container'       => esc_html__( 'Container','haru-circle' ),
                            'topbar-fullwith' => esc_html__( 'Full width','haru-circle' ),
                        ),
                        'default'  => 'container',
                        'required' => array('top_bar','=','1'),
                    ),

                    array(
                        'id'       => 'top_bar_layout_padding',
                        'type'     => 'slider',
                        'title'    => esc_html__( 'Top bar padding left/right (px)', 'haru-circle' ),
                        'default'  => '100',
                        'min'      => 0,
                        'step'     => 1,
                        'max'      => 200,
                        'required' => array('top_bar_layout_width','=','topbar-fullwith'),
                    ),

                    array(
                        'id'       => 'top_bar_layout',
                        'type'     => 'image_select',
                        'title'    => esc_html__( 'Top bar Layout', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Select the top bar column layout. If layout 1 column, it will display left sidebar.', 'haru-circle' ),
                        'desc'     => '',
                        'options'  => array(
                            'top-bar-1' => array('title' => '', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/top-bar-layout-1.jpg'),
                            'top-bar-2' => array('title' => '', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/top-bar-layout-2.jpg'),
                        ),
                        'default'  => 'top-bar-1',
                        'required' => array('top_bar','=','1'),
                    ),

                    array(
                        'id'       => 'top_bar_left_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Top Left Sidebar', 'haru-circle' ),
                        'subtitle' => 'Choose the default top left sidebar',
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'top_bar_left',
                        'required' => array('top_bar','=','1'),
                    ),

                    array(
                        'id'       => 'top_bar_right_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Top Right Sidebar', 'haru-circle' ),
                        'subtitle' => 'Choose the default top right sidebar',
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'top_bar_right',
                        'required' => array('top_bar','=','1'),
                    ),
                )
            );

            // Mobile Header
            $this->sections[] = array(
                'title'      => esc_html__( 'Mobile Header', 'haru-circle' ),
                'desc'       => '',
                'subsection' => true,
                'icon'       => '',
                'fields'     => array(
                    array(
                        'id'       => 'mobile_header_layout',
                        'type'     => 'image_select',
                        'title'    => esc_html__( 'Header Layout', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Select header mobile layout', 'haru-circle' ),
                        'desc'     => '',
                        'options'  => array(
                            'header-mobile-1' => array('title' => '', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/header-mobile-layout-1.jpg'),
                            'header-mobile-2' => array('title' => '', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/header-mobile-layout-2.jpg'),
                            'header-mobile-3' => array('title' => '', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/header-mobile-layout-3.jpg'),
                        ),
                        'default' => 'header-mobile-2'
                    ),

                    array(
                        'id'       => 'mobile_header_menu_drop',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Menu Drop Type', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Set menu drop type for mobile header', 'haru-circle' ),
                        'desc'     => '',
                        'options'  => array(
                            'dropdown' => esc_html__( 'Dropdown Menu', 'haru-circle' ),
                            'fly'      => esc_html__( 'Fly Menu', 'haru-circle' )
                        ),
                        'default'  => 'fly'
                    ),

                    array(
                        'id'       => 'mobile_header_search',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Header Search', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Show/Hide header Search.', 'haru-circle' ),
                        'default'  => false
                    ),
                    array(
                        'id'       => 'mobile_header_cart',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Header Cart', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Show Hide header Cart.', 'haru-circle' ),
                        'default'  => true
                    ),
                    array(
                        'id'       => 'mobile_header_top_bar',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Top Bar', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Enable Top bar.', 'haru-circle' ),
                        'default'  => false
                    ),
                    array(
                        'id'       => 'mobile_header_stick',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Stick Mobile Header', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Enable Stick Mobile Header.', 'haru-circle' ),
                        'default'  => true
                    ),
                )
            );

            // Header Customize
            $this->sections[] = array(
                'title'      => esc_html__( 'Header Customize', 'haru-circle' ),
                'desc'       => '',
                'icon'       => '',
                'subsection' => true,
                'fields'     => array(
                    // Option header nav ON/OFF
                    array(
                        'id'       => 'option-header-customize-nav',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Show/Hide Head Customize Nav', 'haru-circle' ),
                        'default'  => false,
                    ),
                    array(
                        'id'      => 'header_customize_nav',
                        'type'    => 'sorter',
                        'title'   => 'Header customize navigation',
                        'desc'    => 'Organize how you want the layout to appear on the header navigation',
                        'options' => array(
                            'enabled'  => array(
                                'social-profile' => esc_html__( 'Social Profile', 'haru-circle' ),
                                'search-box'     => esc_html__( 'Search Box', 'haru-circle' ),
                            ),
                            'disabled' => array(
                                'search-button'   => esc_html__( 'Search Button', 'haru-circle' ),
                                'custom-text'     => esc_html__( 'Custom Text', 'haru-circle' ),
                                'canvas-menu'     => esc_html__( 'Canvas Menu','haru-circle' ),
                                'search-box-film' => esc_html__( 'Search Box Film', 'haru-circle' ),
                                'user-account'    => esc_html__( 'User Account', 'haru-circle' ),
                                'film-category'   => esc_html__( 'Film Category', 'haru-circle' ),
                            )
                        ), 
                        'required' => array('option-header-customize-nav','=',array('1')),
                    ),
                    array(
                        'id'       => 'header_customize_nav_social_profile',
                        'type'     => 'select',
                        'multi'    => true,
                        'width'    => '100%',
                        'title'    => esc_html__( 'Custom social profiles', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Select social profile for custom text', 'haru-circle' ),
                        'options'  => array(
                            'twitter'    => esc_html__( 'Twitter', 'haru-circle' ),
                            'facebook'   => esc_html__( 'Facebook', 'haru-circle' ),
                            'vimeo'      => esc_html__( 'Vimeo', 'haru-circle' ),
                            'linkedin'   => esc_html__( 'LinkedIn', 'haru-circle' ),
                            'googleplus' => esc_html__( 'Google+', 'haru-circle' ),
                            'flickr'     => esc_html__( 'Flickr', 'haru-circle' ),
                            'youtube'    => esc_html__( 'YouTube', 'haru-circle' ),
                            'pinterest'  => esc_html__( 'Pinterest', 'haru-circle' ),
                            'instagram'  => esc_html__( 'Instagram', 'haru-circle' ),
                            'behance'    => esc_html__( 'Behance', 'haru-circle' ),
                        ),
                        'desc'    => '',
                        'default' => '', 
                        'required' => array('option-header-customize-nav','=',array('1')),
                    ),
                    array(
                        'id'       => 'header_customize_nav_text',
                        'type'     => 'ace_editor',
                        'mode'     => 'html',
                        'theme'    => 'monokai',
                        'title'    => esc_html__( 'Custom Text Content', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Add Content for Custom Text', 'haru-circle' ),
                        'desc'     => '',
                        'default'  => '',
                        'options'  => array('minLines'=> 5, 'maxLines' => 60),
                        'required' => array('option-header-customize-nav','=',array('1')),
                    ),
                    // Option header Custommize-left
                    array(
                        'id'       => 'option-header-customize-left',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Show/Hide Head Customize Left', 'haru-circle' ),
                        'default'  => false,
                    ),
                    array(
                        'id'      => 'header_customize_left',
                        'type'    => 'sorter',
                        'title'   => 'Header customize left',
                        'desc'    => 'Organize how you want the layout to appear on the header left',
                        'options' => array(
                            'enabled'  => array(
                            ),
                            'disabled' => array(
                                'search-box'      => esc_html__( 'Search Box', 'haru-circle' ),
                                'search-button'   => esc_html__( 'Search Button', 'haru-circle' ),
                                'social-profile'  => esc_html__( 'Social Profile', 'haru-circle' ),
                                'custom-text'     => esc_html__( 'Custom Text', 'haru-circle' ),
                                'canvas-menu'     => esc_html__( 'Canvas Menu','haru-circle' ),
                                'search-box-film' => esc_html__( 'Search Box Film', 'haru-circle' ),
                                'user-account'    => esc_html__( 'User Account', 'haru-circle' ),
                                'film-category'   => esc_html__( 'Film Category', 'haru-circle' ),
                            )
                        ), 
                        'required'  => array('option-header-customize-left','=', array('1'))
                    
                    ),
                    array(
                        'id'       => 'header_customize_left_social_profile',
                        'type'     => 'select',
                        'multi'    => true,
                        'width'    => '100%',
                        'title'    => esc_html__( 'Custom social profiles', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Select social profile for custom text', 'haru-circle' ),
                        'options'  => array(
                            'twitter'    => esc_html__( 'Twitter', 'haru-circle' ),
                            'facebook'   => esc_html__( 'Facebook', 'haru-circle' ),
                            'vimeo'      => esc_html__( 'Vimeo', 'haru-circle' ),
                            'linkedin'   => esc_html__( 'LinkedIn', 'haru-circle' ),
                            'googleplus' => esc_html__( 'Google+', 'haru-circle' ),
                            'flickr'     => esc_html__( 'Flickr', 'haru-circle' ),
                            'youtube'    => esc_html__( 'YouTube', 'haru-circle' ),
                            'pinterest'  => esc_html__( 'Pinterest', 'haru-circle' ),
                            'instagram'  => esc_html__( 'Instagram', 'haru-circle' ),
                            'behance'    => esc_html__( 'Behance', 'haru-circle' ),
                        ),
                        'desc'     => '',
                        'default'  => '',  
                        'required' => array('option-header-customize-left','=', array('1'))
                    ),
                    array(
                        'id'       => 'header_customize_left_text',
                        'type'     => 'ace_editor',
                        'mode'     => 'html',
                        'theme'    => 'monokai',
                        'title'    => esc_html__( 'Custom Text Content', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Add Content for Custom Text', 'haru-circle' ),
                        'desc'     => '',
                        'default'  => '',
                        'options'  => array('minLines'=> 5, 'maxLines' => 60), 
                        'required' => array('option-header-customize-left','=', array('1'))
                    ),
                    // Option header customize right
                    array(
                        'id'     => 'option-header-customize-right',
                        'type'   => 'switch',
                        'title'  => esc_html__( 'Show/Hide Header Customize Right', 'haru-circle' ),
                        'default' => false
                    ),
                    array(
                        'id'      => 'header_customize_right',
                        'type'    => 'sorter',
                        'title'   => 'Header customize right',
                        'desc'    => 'Organize how you want the layout to appear on the header right',
                        'options' => array(
                            'enabled'  => array(
                            ),
                            'disabled' => array(
                                'search-box'      => esc_html__( 'Search Box', 'haru-circle' ),
                                'search-button'   => esc_html__( 'Search Button', 'haru-circle' ),
                                'social-profile'  => esc_html__( 'Social Profile', 'haru-circle' ),
                                'custom-text'     => esc_html__( 'Custom Text', 'haru-circle' ),
                                'canvas-menu'     => esc_html__( 'Canvas Menu','haru-circle' ),
                                'search-box-film' => esc_html__( 'Search Box Film', 'haru-circle' ),
                                'user-account'    => esc_html__( 'User Account', 'haru-circle' ),
                                'film-category'   => esc_html__( 'Film Category', 'haru-circle' ),
                            )
                        ),  
                        'required'  => array('option-header-customize-right','=', array('1'))
                    ),
                    array(
                        'id'       => 'header_customize_right_social_profile',
                        'type'     => 'select',
                        'multi'    => true,
                        'width'    => '100%',
                        'title'    => esc_html__( 'Custom social profiles', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Select social profile for custom text', 'haru-circle' ),
                        'options'  => array(
                            'twitter'    => esc_html__( 'Twitter', 'haru-circle' ),
                            'facebook'   => esc_html__( 'Facebook', 'haru-circle' ),
                            'vimeo'      => esc_html__( 'Vimeo', 'haru-circle' ),
                            'linkedin'   => esc_html__( 'LinkedIn', 'haru-circle' ),
                            'googleplus' => esc_html__( 'Google+', 'haru-circle' ),
                            'flickr'     => esc_html__( 'Flickr', 'haru-circle' ),
                            'youtube'    => esc_html__( 'YouTube', 'haru-circle' ),
                            'pinterest'  => esc_html__( 'Pinterest', 'haru-circle' ),
                            'instagram'  => esc_html__( 'Instagram', 'haru-circle' ),
                            'behance'    => esc_html__( 'Behance', 'haru-circle' ),
                        ),
                        'desc'    => '',
                        'default' => '', 
                        'required'  => array('option-header-customize-right','=', array('1'))
                    ),
                    array(
                        'id'       => 'header_customize_right_text',
                        'type'     => 'ace_editor',
                        'mode'     => 'html',
                        'theme'    => 'monokai',
                        'title'    => esc_html__( 'Custom Text Content', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Add Content for Custom Text', 'haru-circle' ),
                        'desc'     => '',
                        'default'  => '',
                        'options'  => array('minLines'=> 5, 'maxLines' => 60), 
                        'required'  => array('option-header-customize-right','=', array('1'))
                    ),
                )
            );

            // Footer
            $this->sections[] = array(
                'title'  => esc_html__( 'Footer', 'haru-circle' ),
                'desc'   => '',
                'icon'   => 'el el-lines',
                'fields' => array(
                    array(
                        'id'       => 'footer_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Layout', 'haru-circle'),
                        'subtitle' => esc_html__('Select Footer Layout', 'haru-circle'),
                        'desc'     => '',
                        'options'  => array(
                            'full'            => esc_html__( 'Full Width', 'haru-circle' ),
                            'container'       => esc_html__( 'Container', 'haru-circle' ),
                        ),
                        'default'  => 'container'
                    ),
                    array(
                        'id'       => 'footer',
                        'type'     => 'footer',
                        'title'    => esc_html__('Select Footer Block', 'haru-circle'),
                        'subtitle' => esc_html__('Set Footer Block', 'haru-circle'),
                    ),

                )
            );

            // Logo
            $this->sections[] = array(
                'title'  => esc_html__( 'Logo & Favicon', 'haru-circle' ),
                'desc'   => '',
                'icon'   => 'el el-picture',
                'fields' => array(
                    array(
                        'id'       => 'logo',
                        'type'     => 'media',
                        'url'      => true,
                        'title'    => esc_html__( 'Logo', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Upload your logo here.', 'haru-circle' ),
                        'desc'     => '',
                        'default'  => array(
                            'url' => get_template_directory_uri() . '/framework/admin-assets/images/theme-options/logo.png'
                        )
                    ),
                    array(
                        'id'       => 'logo_retina',
                        'type'     => 'media',
                        'url'      => true,
                        'title'    => esc_html__( 'Retina Logo', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Upload your logo here.', 'haru-circle' ),
                        'desc'     => '',
                        'default'  => array(
                            'url' => get_template_directory_uri() . '/framework/admin-assets/images/theme-options/logo.png'
                        )
                    ),
                    array(
                            'id'       => 'sticky_logo',
                            'type'     => 'media',
                            'url'      => true,
                            'title'    => esc_html__( 'Sticky Logo', 'haru-circle' ),
                            'subtitle' => esc_html__( 'Upload a sticky version of your logo here', 'haru-circle' ),
                            'desc'     => '',
                            'default'  => array(
                            'url'      => get_template_directory_uri() . '/framework/admin-assets/images/theme-options/logo.png'
                        )
                    ),

                    array(
                        'id'       => 'mobile_header_logo',
                        'type'     => 'media',
                        'url'      => true,
                        'title'    => esc_html__( 'Mobile Logo', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Upload your logo here.', 'haru-circle' ),
                        'desc'     => '',
                        'default'  => array(
                            'url' => get_template_directory_uri() . '/framework/admin-assets/images/theme-options/logo.png'
                        )
                    ),
                    array(
                        'id'       => 'haru_logo_max_height',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Logo Max Height', 'haru-circle' ),
                        'desc'     => esc_html__( 'Set max height for Logo by pixel (Insert number only).', 'haru-circle' ),
                        'validate' => 'numeric',
                        'default'  => 40
                    ),
                    array(
                        'id'       => 'haru_logo_sticky_max_height',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Logo Sticky Max Height', 'haru-circle' ),
                        'desc'     => esc_html__( 'Set max height for Logo Sticky by pixel (Insert number only).', 'haru-circle' ),
                        'validate' => 'numeric',
                        'default'  => 40
                    ),
                    array(
                        'id'       => 'custom_favicon',
                        'type'     => 'media',
                        'url'      => true,
                        'title'    => esc_html__( 'Custom favicon', 'haru-circle'),
                        'subtitle' => esc_html__( 'Upload a 16px x 16px Png/Gif/ico image that will represent your website favicon', 'haru-circle' ),
                        'desc'     => ''
                    ),
                )
            );

            // Styling Options
            $this->sections[] = array(
                'title'  => esc_html__( 'Styling Options', 'haru-circle' ),
                'desc'   => esc_html__( 'To make color change work you need enable SCSS Compiler.', 'haru-circle' ),
                'icon'   => 'el el-magic',
                'fields' => array(
                    array(
                        'id'       => 'primary_color',
                        'type'     => 'color',
                        'title'    => esc_html__( 'Primary Color', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Set Primary Color', 'haru-circle' ),
                        'compiler' => true,
                        'default'  => '#fd6500',
                        'validate' => 'color',
                    ),

                    array(
                        'id'       => 'secondary_color',
                        'type'     => 'color',
                        'title'    => esc_html__( 'Secondary Color', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Set Secondary Color', 'haru-circle' ),
                        'compiler' => true,
                        'default'  => '#fd6500',
                        'validate' => 'color',
                    ),

                    array(
                        'id'       => 'text_color',
                        'type'     => 'color',
                        'title'    => esc_html__( 'Text Color', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Set Text Color.', 'haru-circle' ),
                        'compiler' => true,
                        'default'  => '#696969',
                        'validate' => 'color',
                    ),

                    array(
                        'id'       => 'heading_color',
                        'type'     => 'color',
                        'title'    => esc_html__( 'Heading Color', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Set Heading Color.', 'haru-circle' ),
                        'default'  => '#262626',
                        'compiler' => true,
                        'validate' => 'color',
                    ),

                    array(
                        'id'       => 'link_color',
                        'type'     => 'link_color',
                        'title'    => esc_html__( 'Link Color', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Set Link Color.', 'haru-circle' ),
                        'compiler' => true,
                        'default'  => array(
                            'regular'  => '#696969',
                            'hover'    => '#fd6500',
                            'active'   => '#fd6500',
                        ),
                    ),
                )
            );

            // Typography
            $this->sections[] = array(
                'icon'   => 'el el-font',
                'title'  => esc_html__('Typograhpy', 'haru-circle'),
                'desc'   => esc_html__( 'To make Typograhpy change work you need enable SCSS Compiler.', 'haru-circle' ),
                'fields' => array(
                    array(
                        'id'     => 'section-body_font',
                        'type'   => 'section',
                        'title'  => esc_html__('Body Font', 'haru-circle'),
                        'indent' => true
                    ),

                    array(
                        'id'             => 'body_font',
                        'type'           => 'typography',
                        'title'          => esc_html__( 'Body Font', 'haru-circle' ),
                        'subtitle'       => esc_html__( 'Specify the body font properties.', 'haru-circle' ),
                        'google'         => true,
                        'line-height'    => false,
                        'color'          => false,
                        'letter-spacing' => false,
                        'text-align'     => false,
                        'all_styles'     => true, // Enable all Google Font style/weight variations to be added to the page
                        'output'         => array('body'), // An array of CSS selectors to apply this font style to dynamically
                        'compiler'       => array('body'), // An array of CSS selectors to apply this font style to dynamically
                        'units'          => 'px', // Defaults to px
                        'default'        => array(
                            'font-size'   => '14px',
                            'font-family' => 'Nunito Sans',
                            'font-weight' => '400',
                            'google'      => true,
                        ),
                    ),

                    array(
                        'id'             => 'secondary_font',
                        'type'           => 'typography',
                        'title'          => esc_html__( 'Secondary Font', 'haru-circle' ),
                        'subtitle'       => esc_html__( 'Specify the secondary font properties.', 'haru-circle' ),
                        'google'         => true,
                        'line-height'    => false,
                        'color'          => false,
                        'letter-spacing' => false,
                        'text-align'     => false,
                        'all_styles'     => true, // Enable all Google Font style/weight variations to be added to the page
                        'output'         => array(), // An array of CSS selectors to apply this font style to dynamically
                        'compiler'       => array(), // An array of CSS selectors to apply this font style to dynamically
                        'units'          => 'px', // Defaults to px
                        'default'        => array(
                            'font-size'   => '14px',
                            'font-family' => 'Playfair Display',
                            'font-weight' => '400',
                            'google'      => true,
                        ),
                    ),
                    
                    array(
                        'id'     => 'section-heading-font',
                        'type'   => 'section',
                        'title'  => esc_html__('Heading Font', 'haru-circle'),
                        'indent' => true
                    ),

                    array(
                        'id'             =>'h1_font',
                        'type'           => 'typography',
                        'title'          => esc_html__('H1 Font', 'haru-circle'),
                        'subtitle'       => esc_html__('Specify the H1 font properties.', 'haru-circle'),
                        'google'         => true,
                        'letter-spacing' => false,
                        'color'          => false,
                        'line-height'    => false,
                        'text-align'     => false,
                        'all_styles'     => true, // Enable all Google Font style/weight variations to be added to the page
                        'output'         => array('h1'), // An array of CSS selectors to apply this font style to dynamically
                        'compiler'       => array('h1'), // An array of CSS selectors to apply this font style to dynamically
                        'units'          =>'px', // Defaults to px
                        'default'        => array(
                            'font-size'   => '36px',
                            'font-family' => 'Playfair Display',
                            'font-weight' => '700',
                        ),
                    ),

                    array(
                        'id'             =>'h2_font',
                        'type'           => 'typography',
                        'title'          => esc_html__('H2 Font', 'haru-circle'),
                        'subtitle'       => esc_html__('Specify the H2 font properties.', 'haru-circle'),
                        'google'         => true,
                        'letter-spacing' => false,
                        'color'          => false,
                        'line-height'    => false,
                        'text-align'     => false,
                        'all_styles'     => true, // Enable all Google Font style/weight variations to be added to the page
                        'output'         => array('h2'), // An array of CSS selectors to apply this font style to dynamically
                        'compiler'       => array('h2'), // An array of CSS selectors to apply this font style to dynamically
                        'units'          =>'px', // Defaults to px
                        'default'        => array(
                            'font-size'   => '28px',
                            'font-family' => 'Playfair Display',
                            'font-weight' => '700',
                        ),
                    ),

                    array(
                        'id'             =>'h3_font',
                        'type'           => 'typography',
                        'title'          => esc_html__('H3 Font', 'haru-circle'),
                        'subtitle'       => esc_html__('Specify the H3 font properties.', 'haru-circle'),
                        'google'         => true,
                        'color'          => false,
                        'line-height'    => false,
                        'letter-spacing' => false,
                        'text-align'     => false,
                        'all_styles'     => true, // Enable all Google Font style/weight variations to be added to the page
                        'output'         => array('h3'), // An array of CSS selectors to apply this font style to dynamically
                        'compiler'       => array('h3'), // An array of CSS selectors to apply this font style to dynamically
                        'units'          =>'px', // Defaults to px
                        'default'        => array(
                            'font-size'   => '24px',
                            'font-family' => 'Playfair Display',
                            'font-weight' => '700',
                        ),
                    ),

                    array(
                        'id'             =>'h4_font',
                        'type'           => 'typography',
                        'title'          => esc_html__('H4 Font', 'haru-circle'),
                        'subtitle'       => esc_html__('Specify the H4 font properties.', 'haru-circle'),
                        'google'         => true,
                        'color'          => false,
                        'line-height'    => false,
                        'letter-spacing' => false,
                        'text-align'     => false,
                        'all_styles'     => true, // Enable all Google Font style/weight variations to be added to the page
                        'output'         => array('h4'), // An array of CSS selectors to apply this font style to dynamically
                        'compiler'       => array('h4'), // An array of CSS selectors to apply this font style to dynamically
                        'units'          =>'px', // Defaults to px
                        'default'        => array(
                            'font-size'   => '21px',
                            'font-family' => 'Playfair Display',
                            'font-weight' => '700',
                        ),
                    ),

                    array(
                        'id'             =>'h5_font',
                        'type'           => 'typography',
                        'title'          => esc_html__('H5 Font', 'haru-circle'),
                        'subtitle'       => esc_html__('Specify the H5 font properties.', 'haru-circle'),
                        'google'         => true,
                        'line-height'    => false,
                        'color'          => false,
                        'letter-spacing' => false,
                        'text-align'     => false,
                        'all_styles'     => true, // Enable all Google Font style/weight variations to be added to the page
                        'output'         => array('h5'), // An array of CSS selectors to apply this font style to dynamically
                        'compiler'       => array('h5'), // An array of CSS selectors to apply this font style to dynamically
                        'units'          =>'px', // Defaults to px
                        'default'        => array(
                            'font-size'   => '18px',
                            'font-family' => 'Playfair Display',
                            'font-weight' => '700',
                        ),
                    ),

                    array(
                        'id'             =>'h6_font',
                        'type'           => 'typography',
                        'title'          => esc_html__('H6 Font', 'haru-circle'),
                        'subtitle'       => esc_html__('Specify the H6 font properties.', 'haru-circle'),
                        'google'         => true,
                        'color'          => false,
                        'line-height'    => false,
                        'letter-spacing' => false,
                        'text-align'     => false,
                        'all_styles'     => true, // Enable all Google Font style/weight variations to be added to the page
                        'output'         => array('h6'), // An array of CSS selectors to apply this font style to dynamically
                        'compiler'       => array('h6'), // An array of CSS selectors to apply this font style to dynamically
                        'units'          =>'px', // Defaults to px
                        'default'        => array(
                            'font-size'   => '14px',
                            'font-family' => 'Playfair Display',
                            'font-weight' => '700',
                        ),
                    ),

                    array(
                        'id'     => 'section-menu-font',
                        'type'   => 'section',
                        'title'  => esc_html__('Menu Font', 'haru-circle'),
                        'indent' => true
                    ),

                    array(
                        'id'             => 'menu_font',
                        'type'           => 'typography',
                        'title'          => esc_html__('Menu Font', 'haru-circle'),
                        'subtitle'       => esc_html__('Specify the Menu font properties.', 'haru-circle'),
                        'google'         => true,
                        'all_styles'     => false, // Enable all Google Font style/weight variations to be added to the page
                        'color'          => false,
                        'line-height'    => false,
                        'text-align'     => false,
                        'font-style'     => false,
                        'subsets'        => true,
                        'text-transform' => false,
                        'output'         => array(''), // An array of CSS selectors to apply this font style to dynamically
                        'compiler'       => array(''), // An array of CSS selectors to apply this font style to dynamically
                        'units'          => 'px', // Defaults to px
                        'default'        => array(
                            'font-family'    => 'Nunito Sans',
                            'font-size'      => '14px',
                            'font-weight'    => '700',
                        ),
                    ),

                    array(
                        'id'     => 'section-page-title-font',
                        'type'   => 'section',
                        'title'  => esc_html__('Page Title Font', 'haru-circle'),
                        'indent' => true
                    ),

                    array(
                        'id'             => 'page_title_font',
                        'type'           => 'typography',
                        'title'          => esc_html__('Page Title Font', 'haru-circle'),
                        'subtitle'       => esc_html__('Specify the page title font properties.', 'haru-circle'),
                        'google'         => true,
                        'all_styles'     => true, // Enable all Google Font style/weight variations to be added to the page
                        'line-height'    => false,
                        'color'          => false,
                        'text-align'     => false,
                        'font-style'     => true,
                        'subsets'        => true,
                        'font-size'      => true,
                        'font-weight'    => true,
                        'text-transform' => false,
                        'output'         => array('.page-title-inner h1'), // An array of CSS selectors to apply this font style to dynamically
                        'compiler'       => array(), // An array of CSS selectors to apply this font style to dynamically
                        'units'          => 'px', // Defaults to px
                        'default'        => array(
                            'font-family'    => 'Playfair Display',
                            'font-size'      => '36px',
                            'font-weight'    => '400',
                        ),
                    ),

                    array(
                        'id'             => 'page_sub_title_font',
                        'type'           => 'typography',
                        'title'          => esc_html__('Page Sub Title Font', 'haru-circle'),
                        'subtitle'       => esc_html__('Specify the page sub title font properties.', 'haru-circle'),
                        'google'         => true,
                        'all_styles'     => true, // Enable all Google Font style/weight variations to be added to the page
                        'line-height'    => false,
                        'color'          => false,
                        'font-style'     => true,
                        'text-align'     => false,
                        'subsets'        => true,
                        'font-size'      => true,
                        'font-weight'    => true,
                        'text-transform' => false,
                        'output'         => array('.page-title-inner .page-sub-title'), // An array of CSS selectors to apply this font style to dynamically
                        'compiler'       => array(), // An array of CSS selectors to apply this font style to dynamically
                        'units'          => 'px', // Defaults to px
                        'default'        => array(
                            'font-family'    => 'Playfair Display',
                            'font-size'      => '14px',
                            'font-weight'    => '400italic',
                        ),
                    ),

                ),
            );

            // SCSS Compile
            $this->sections[] = array(
                'title'  => esc_html__( 'SCSS Compiler', 'haru-circle' ),
                'desc'   => esc_html__( 'If you want to custom Color, Typograhpy or CSS you must enable this option.', 'haru-circle' ),
                'icon'   => 'el el-edit',
                'fields' => array(
                    array(
                        'id'       => 'scss_compiler',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'SCSS Compiler', 'haru-circle' ),
                        'subtitle' => esc_html__( 'To make this option work you need install plugin Less & scss PHP Compilers.', 'haru-circle' ),
                        'default'  => false
                    ),

                )
            );

            // Pages Setting
            $this->sections[] = array(
                'title'  => esc_html__( 'Pages Setting', 'haru-circle' ),
                'desc'   => '',
                'icon'   => 'el el-website',
                'fields' => array(
                    array(
                        'id'       => 'page_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Layout', 'haru-circle'),
                        'subtitle' => esc_html__('Select Page Layout', 'haru-circle'),
                        'desc'     => '',
                        'options'  => array(
                            'full'            => esc_html__( 'Full Width', 'haru-circle' ),
                            'container'       => esc_html__( 'Container', 'haru-circle' ),
                        ),
                        'default'  => 'container'
                    ),

                    array(
                        'id'       => 'page_sidebar',
                        'type'     => 'image_select',
                        'title'    => esc_html__('Sidebar', 'haru-circle'),
                        'subtitle' => esc_html__('Set Sidebar Style', 'haru-circle'),
                        'options'  => array(
                            'none'  => array('title' => '', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/sidebar-none.png'),
                            'left'  => array('title' => '', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/sidebar-left.png'),
                            'right' => array('title' => '', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/sidebar-right.png'),
                        ),
                        'default' => 'none'
                    ),

                    array(
                        'id'       => 'page_left_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__('Left Sidebar', 'haru-circle'),
                        'subtitle' => "Choose the default left sidebar",
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'sidebar-1',
                        'required' => array('page_sidebar', '=', array('left','both')),
                    ),

                    array(
                        'id'       => 'page_right_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__('Right Sidebar', 'haru-circle'),
                        'subtitle' => "Choose the default right sidebar",
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'sidebar-2',
                        'required' => array('page_sidebar', '=', array('right','both')),
                    ),

                    array(
                        'id'     => 'section-page-title-setting-start',
                        'type'   => 'section',
                        'title'  => esc_html__('Page Title Setting', 'haru-circle'),
                        'indent' => true
                    ),

                    array(
                        'id'       => 'show_page_title',
                        'type'     => 'switch',
                        'title'    => esc_html__('Show Page Title', 'haru-circle'),
                        'subtitle' => esc_html__('Show/Hide Page Title', 'haru-circle'),
                        'default'  => false
                    ),

                    array(
                        'id'       => 'page_title_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Page Title Layout', 'haru-circle'),
                        'subtitle' => esc_html__('Select Page Title Layout', 'haru-circle'),
                        'desc'     => '',
                        'options'  => array(
                            'full'            => 'Full Width',
                            'container'       => 'Container',
                        ),
                        'default'  => 'container',
                        'required' => array('show_page_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'page_title_bg_image',
                        'type'     => 'media',
                        'url'      => true,
                        'title'    => esc_html__('Page Title Background', 'haru-circle'),
                        'subtitle' => esc_html__('Upload page title background.', 'haru-circle'),
                        'desc'     => '',
                        'default'  => array(
                            'url' => get_template_directory_uri() . '/framework/admin-assets/images/theme-options/bg-page-title.jpg'
                        ),
                        'required'  => array('show_page_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'page_title_parallax',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Page Title Parallax', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Enable Page Title Parallax', 'haru-circle' ),
                        'default'  => false,
                        'required' => array('show_page_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'breadcrumbs_in_page_title',
                        'type'     => 'switch',
                        'title'    => esc_html__('Breadcrumbs', 'haru-circle'),
                        'subtitle' => esc_html__('Enable/Disable Breadcrumbs In Pages', 'haru-circle'),
                        'default'  => true
                    ),
                )
            );

            // Archive Setting
            $this->sections[] = array(
                'title'      => esc_html__( 'Archive Setting', 'haru-circle' ),
                'desc'       => '',
                'subsection' => false,
                'icon'       => 'el el-folder-close',
                'fields'     => array(
                    array(
                        'id'       => 'archive_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Layout', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Select Archive Layout', 'haru-circle' ),
                        'desc'     => '',
                        'options'  => array(
                            'full'            => esc_html__( 'Full Width', 'haru-circle' ),
                            'container'       => esc_html__( 'Container', 'haru-circle' ),
                            ),
                        'default'  => 'container'
                    ),

                    array(
                        'id'       => 'archive_sidebar',
                        'type'     => 'image_select',
                        'title'    => esc_html__( 'Sidebar', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Set Sidebar Style', 'haru-circle' ),
                        'desc'     => '',
                        'options'  => array(
                            'none'     => array('title' => '', 'img' => get_template_directory_uri() . '/framework/admin-assets/images/theme-options/sidebar-none.png'),
                            'left'     => array('title' => '', 'img' => get_template_directory_uri() . '/framework/admin-assets/images/theme-options/sidebar-left.png'),
                            'right'    => array('title' => '', 'img' => get_template_directory_uri() . '/framework/admin-assets/images/theme-options/sidebar-right.png'),
                        ),
                        'default'  => 'left'
                    ),

                    array(
                        'id'       => 'archive_left_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Left Sidebar', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Choose the default left sidebar', 'haru-circle' ),
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'sidebar-1',
                        'required' => array('archive_sidebar', '=', array('left','both')),
                    ),

                    array(
                        'id'       => 'archive_right_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Right Sidebar', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Choose the default right sidebar', 'haru-circle' ),
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'sidebar-2',
                        'required' => array('archive_sidebar', '=', array('right','both')),
                    ),

                    array(
                        'id'       => 'archive_display_type',
                        'type'     => 'select',
                        'title'    => esc_html__('Archive Display Type', 'haru-circle'),
                        'subtitle' => esc_html__('Select archive display type', 'haru-circle'),
                        'desc'     => '',
                        'options'  => array(
                            'large-image'  => esc_html__('Large Image','haru-circle'),
                            'medium-image' => esc_html__('Medium Image','haru-circle'),
                            'grid'         => esc_html__('Grid','haru-circle'),
                            'masonry'      => esc_html__('Masonry','haru-circle'),
                        ),
                        'default'  => 'medium-image'
                    ),

                    array(
                        'id'       => 'archive_paging_style',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Paging Style', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Select archive paging style', 'haru-circle' ),
                        'desc'     => '',
                        'options'  => array(
                            'default'         => esc_html__( 'Default', 'haru-circle' ),
                            'load-more'       => esc_html__( 'Load More', 'haru-circle' ),
                            'infinity-scroll' => esc_html__( 'Infinity Scroll', 'haru-circle' )
                        ),
                        'default'  => 'default'
                    ),

                    array(
                        'id'       => 'archive_display_columns',
                        'type'     => 'select',
                        'title'    => esc_html__('Archive Display Columns', 'haru-circle'),
                        'subtitle' => esc_html__('Choose the number of columns to display on archive pages.','haru-circle'),
                        'options'  => array(
                            '2'     => '2',
                            '3'     => '3',
                            '4'     => '4',
                        ),
                        'desc'     => '',
                        'default'  => '2',
                        'required' => array('archive_display_type','=',array('grid','masonry')),
                    ),

                    array(
                        'id'        => 'archive_number_exceprt',
                        'type'      => 'text',
                        'title'     => esc_html__( 'Length of excerpt','haru-circle' ),
                        'value'     => '30'    
                    ),

                    array(
                        'id'     => 'section-archive-title-setting-start',
                        'type'   => 'section',
                        'title'  => esc_html__('Archive Title Setting', 'haru-circle'),
                        'indent' => true
                    ),

                    array(
                        'id'       => 'show_archive_title',
                        'type'     => 'switch',
                        'title'    => esc_html__('Show Archive Title', 'haru-circle'),
                        'subtitle' => esc_html__('Enable/Disable Archive Title', 'haru-circle'),
                        'default'  => true
                    ),

                    array(
                        'id'       => 'archive_title_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Archive Title Layout', 'haru-circle'),
                        'subtitle' => esc_html__('Select Archive Title Layout', 'haru-circle'),
                        'desc'     => '',
                        'options'  => array('full' => 'Full Width','container' => 'Container'),
                        'default'  => 'container',
                        'required' => array('show_archive_title','=',array('1')),
                    ),

                    array(
                        'id'       => 'archive_title_bg_image',
                        'type'     => 'media',
                        'url'      => true,
                        'title'    => esc_html__('Archive Title Background', 'haru-circle'),
                        'subtitle' => esc_html__('Upload archive title background.', 'haru-circle'),
                        'desc'     => '',
                        'default'  =>  array(
                            'url' => get_template_directory_uri() . '/framework/admin-assets/images/theme-options/bg-page-title.jpg'
                        ),
                        'required' => array('show_archive_title','=',array('1')),
                    ),

                    array(
                        'id'       => 'archive_title_parallax',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Archive Title Parallax', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Enable Archive Title Parallax', 'haru-circle' ),
                        'default'  => false,
                        'required' => array('show_archive_title','=',array('1')),
                    ),

                    array(
                        'id'       => 'breadcrumbs_in_archive_title',
                        'type'     => 'switch',
                        'title'    => esc_html__('Breadcrumbs', 'haru-circle'),
                        'subtitle' => esc_html__('Enable/Disable Breadcrumbs In Archive', 'haru-circle'),
                        'default'  => true
                    ),
                )
            );

            // Single Page
            $this->sections[] = array(
                'title'      => esc_html__( 'Single Setting', 'haru-circle' ),
                'desc'       => '',
                'icon'       => 'el el-file',
                'subsection' => false,
                'fields'     => array(
                    array(
                        'id'       => 'single_blog_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Layout', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Select Single Blog Layout', 'haru-circle' ),
                        'desc'     => '',
                        'options'  => array(
                            'full'            => 'Full Width',
                            'container'       => 'Container',
                        ),
                        'default'  => 'container'
                    ),

                    array(
                        'id'       => 'single_blog_sidebar',
                        'type'     => 'image_select',
                        'title'    => esc_html__( 'Sidebar', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Set Sidebar Style', 'haru-circle' ),
                        'desc'     => '',
                        'options'  => array(
                            'none'  => array('title' => '', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/sidebar-none.png'),
                            'left'  => array('title' => '', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/sidebar-left.png'),
                            'right' => array('title' => '', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/sidebar-right.png'),
                        ),
                        'default'  => 'left'
                    ),

                    array(
                        'id'       => 'single_blog_left_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Left Sidebar', 'haru-circle' ),
                        'subtitle' => 'Choose the default left sidebar',
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'sidebar-1',
                        'required' => array('single_blog_sidebar', '=', array('left','both')),
                    ),

                    array(
                        'id'       => 'single_blog_right_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Right Sidebar', 'haru-circle' ),
                        'subtitle' => 'Choose the default right sidebar',
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'sidebar-2',
                        'required' => array('single_blog_sidebar', '=', array('right','both')),
                    ),

                    array(
                        'id'       => 'show_post_navigation',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Show Post Navigation', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Enable/Disable Post Navigation', 'haru-circle' ),
                        'default'  => true
                    ),

                    array(
                        'id'       => 'show_author_info',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Show Author Info', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Enable/Disable Author Info', 'haru-circle' ),
                        'default'  => true
                    ),

                    array(
                        'id'     => 'section-single-blog-title-setting-start',
                        'type'   => 'section',
                        'title'  => esc_html__( 'Single Blog Title Setting', 'haru-circle' ),
                        'indent' => true
                    ),

                    array(
                        'id'       => 'show_single_blog_title',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Show Single Blog Title', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Enable/Disable Single Blog Title', 'haru-circle' ),
                        'default'  => true
                    ),

                    array(
                        'id'       => 'single_blog_title_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Single Blog Title Layout', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Select Single Blog Title Layout', 'haru-circle' ),
                        'desc'     => '',
                        'options'  => array(
                            'full'            => 'Full Width',
                            'container'       => 'Container',
                        ),
                        'default'  => 'container',
                        'required' => array('show_single_blog_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'single_blog_title_bg_image',
                        'type'     => 'media',
                        'url'      => true,
                        'title'    => esc_html__( 'Single Blog Title Background', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Upload single blog title background.', 'haru-circle' ),
                        'desc'     => '',
                        'default'  =>  array(
                            'url' => get_template_directory_uri() . '/framework/admin-assets/images/theme-options/bg-page-title.jpg'
                        ),
                        'required'  => array('show_single_blog_title', '=', array('1'))
                    ),

                    array(
                        'id'       => 'single_blog_title_parallax',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Single Blog Title Parallax', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Enable Single Blog Title Parallax', 'haru-circle' ),
                        'default'  => false,
                        'required' => array('show_single_blog_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'breadcrumbs_in_single_blog_title',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Breadcrumbs', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Enable/Disable Breadcrumbs In Single Blog', 'haru-circle' ),
                        'default'  => true
                    ),
                )
            );

            // Social options
            $this->sections[] = array(
                'title'  => esc_html__( 'Social Settings', 'haru-circle' ),
                'desc'   => '',
                'icon'   => 'el el-facebook',
                'fields' => array(
                    array(
                        'title'    => esc_html__('Social Share', 'haru-circle'),
                        'id'       => 'social_sharing',
                        'type'     => 'checkbox',
                        'subtitle' => esc_html__('Show the social sharing in blog posts', 'haru-circle'),
                        // Must provide key => value pairs for multi checkbox options
                        'options'  => array(
                            'facebook'  => 'Facebook',
                            'twitter'   => 'Twitter',
                            'google'    => 'Google',
                            'linkedin'  => 'Linkedin',
                            'tumblr'    => 'Tumblr',
                            'pinterest' => 'Pinterest'
                        ),

                        // See how default has changed? you also don't need to specify opts that are 0.
                        'default' => array(
                            'facebook'  => '1',
                            'twitter'   => '1',
                            'google'    => '1',
                            'linkedin'  => '1',
                            'tumblr'    => '1',
                            'pinterest' => '1'
                        )
                    ),
                    array(
                        'id'       => 'twitter_url',
                        'type'     => 'text',
                        'title'    => esc_html__('Twitter URL', 'haru-circle'),
                        'subtitle' => "Please insert your Twitter URL.",
                        'desc'     => '',
                        'default'  => ''
                    ),
                    array(
                        'id'       => 'facebook_url',
                        'type'     => 'text',
                        'title'    => esc_html__('Facebook URL', 'haru-circle'),
                        'subtitle' => "Please insert your Facebook URL",
                        'desc'     => '',
                        'default'  => ''
                    ),
                    array(
                        'id'       => 'youtube_url',
                        'type'     => 'text',
                        'title'    => esc_html__('YouTube URL', 'haru-circle'),
                        'subtitle' => "Please insert your Youtube URL.",
                        'desc'     => '',
                        'default'  => ''
                    ),
                    array(
                        'id'       => 'pinterest_url',
                        'type'     => 'text',
                        'title'    => esc_html__('Pinterest URL', 'haru-circle'),
                        'subtitle' => "Please insert your Pinterest URL.",
                        'desc'     => '',
                        'default'  => ''
                    ),
                    array(
                        'id'       => 'instagram_url',
                        'type'     => 'text',
                        'title'    => esc_html__('Instagram URL', 'haru-circle'),
                        'subtitle' => "Please insert your Instagram URL",
                        'desc'     => '',
                        'default'  => ''
                    ),
                    array(
                        'id'       => 'vimeo_url',
                        'type'     => 'text',
                        'title'    => esc_html__('Vimeo URL', 'haru-circle'),
                        'subtitle' => "Please insert your Vimeo URL.",
                        'desc'     => '',
                        'default'  => ''
                    ),
                    array(
                        'id'       => 'linkedin_url',
                        'type'     => 'text',
                        'title'    => esc_html__('LinkedIn URL', 'haru-circle'),
                        'subtitle' => "Please insert your Linkedin URL.",
                        'desc'     => '',
                        'default'  => ''
                    ),
                    array(
                        'id'       => 'googleplus_url',
                        'type'     => 'text',
                        'title'    => esc_html__('Google+ URL', 'haru-circle'),
                        'subtitle' => "Please insert your Google+ URL.",
                        'desc'     => '',
                        'default'  => ''
                    ),
                    array(
                        'id'       => 'flickr_url',
                        'type'     => 'text',
                        'title'    => esc_html__('Flickr URL', 'haru-circle'),
                        'subtitle' => "Please insert your Flickr URL.",
                        'desc'     => '',
                        'default'  => ''
                    ),
                    array(
                        'id'       => 'behance_url',
                        'type'     => 'text',
                        'title'    => esc_html__('Behance URL', 'haru-circle'),
                        'subtitle' => "Please insert your Behance URL",
                        'desc'     => '',
                        'default'  => ''
                    )
                )
            );

            // Popup Configs
            $this->sections[] = array(
                'title'  => esc_html__( 'Newsletter Popup', 'haru-circle' ),
                'desc'   => '',
                'icon'   => 'el el-photo',
                'fields' => array(
                    array(
                        'id'       => 'show_popup',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Show Popup', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Show/Hide Popup when user go to your site', 'haru-circle' ),
                        'default'  => false
                    ),
                    array(
                        'id'       => 'popup_width',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Popup Width', 'haru-circle' ),
                        'subtitle' => 'Please set with of popup (number only in px)',
                        'validate' => 'numeric',
                        'desc'     => '',
                        'default'  => '750'
                    ),
                    array(
                        'id'       => 'popup_height',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Popup Height', 'haru-circle' ),
                        'subtitle' => 'Please set height of popup (number only in px)',
                        'validate' => 'numeric',
                        'desc'     => '',
                        'default'  => '450'
                    ),
                    array(
                        'id'       => 'popup_effect',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Popup Effect', 'haru-circle' ),
                        'subtitle' => esc_html__( 'Choose popup effect.','haru-circle' ),
                        'options'  => array(
                            'mfp-zoom-in'         => esc_html__( 'ZoomIn', 'haru-circle' ),
                            'mfp-newspaper'       => esc_html__( 'Newspaper', 'haru-circle' ),
                            'mfp-move-horizontal' => esc_html__( 'Move Horizontal', 'haru-circle' ),
                            'mfp-move-from-top'   => esc_html__( 'Move From Top', 'haru-circle' ),
                            'mfp-3d-unfold'       => esc_html__( '3D Unfold', 'haru-circle' ),
                            'mfp-zoom-out'        => esc_html__( 'ZoomOut', 'haru-circle' ),
                            'hinge'               => esc_html__( 'Hinge', 'haru-circle' )
                        ),
                        'desc'     => '',
                        'default'  => 'mfp-zoom-in'
                    ),
                    array(
                        'id'       => 'popup_delay',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Popup Delay', 'haru-circle' ),
                        'subtitle' => 'Please set delay of popup (caculate by miliseconds)',
                        'validate' => 'numeric',
                        'desc'     => '',
                        'default'  => '5000'
                    ),
                    array(
                        'id'       => 'popup_content',
                        'type'     => 'editor',
                        'title'    => esc_html__( 'Popup Content', 'haru-circle' ),
                        'subtitle' => "Please set content of popup",
                        'desc'     => '',
                        'default'  => ''
                    ),
                    array(
                        'id'       => 'popup_background',
                        'type'     => 'media',
                        'title'    => esc_html__( 'Popup Background', 'haru-circle' ),
                        'url'      => true,
                        'subtitle' => '',
                        'desc'     => '',
                        'default'  => array(
                            'url'  =>  ''
                        ),
                    ),

                )
            );

            
            if ( true == haru_check_woocommerce_status() ) {
                // Woocommerce
                $this->sections[] = array(
                    'title'  => esc_html__( 'Woocommerce', 'haru-circle' ),
                    'desc'   => '',
                    'icon'   => 'el el-shopping-cart-sign',
                    'fields' => array(
                        array(
                            'id'       => 'haru_product_sale_flash_mode',
                            'type'     => 'button_set',
                            'title'    => esc_html__( 'Sale Badge Mode', 'haru-circle' ),
                            'subtitle' => esc_html__( 'Choose Sale Badge Mode', 'haru-circle' ),
                            'desc'     => '',
                            'options'  => array(
                                'text'    => esc_html__( 'Text', 'haru-circle' ),
                                'percent' => esc_html__( 'Percent', 'haru-circle' )
                            ),
                            'default'  => 'percent'
                        ),
                        array(
                            'id'       => 'haru_product_attribute',
                            'type'     => 'product_attribute',
                            'title'    => esc_html__( 'Product Attribute', 'haru-circle' ),
                            'subtitle' => esc_html__( 'Show Product Attribute (Apply for Color, Image & Label attribute type in Products -> Attributes)', 'haru-circle' ),
                        ),
                        array(
                            'id'       => 'haru_product_quick_view',
                            'type'     => 'switch',
                            'title'    => esc_html__( 'Quick View Button', 'haru-circle' ),
                            'subtitle' => esc_html__( 'Enable/Disable Quick View', 'haru-circle' ),
                            'default'  => true
                        ),
                        array(
                            'id'       => 'haru_product_add_wishlist',
                            'type'     => 'switch',
                            'title'    => esc_html__( 'Add To Wishlist Button', 'haru-circle' ),
                            'subtitle' => esc_html__( 'Enable/Disable Add To Wishlist Button', 'haru-circle' ),
                            'default'  => true
                        ),
                        array(
                            'id'       => 'haru_product_add_to_compare',
                            'type'     => 'switch',
                            'title'    => esc_html__( 'Add To Compare Button', 'haru-circle' ),
                            'subtitle' => esc_html__( 'Enable/Disable Add To Compare Button', 'haru-circle' ),
                            'default'  => true
                        ),
                    )
                );

                // Archive Product
                $this->sections[] = array(
                    'title'      => esc_html__( 'Archive Product', 'haru-circle' ),
                    'desc'       => '',
                    'icon'       => 'el el-book',
                    'subsection' => true,
                    'fields'     => array(
                        array(
                            'id'       => 'haru_product_per_page',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Products Per Page', 'haru-circle' ),
                            'desc'     => esc_html__( 'This must be numeric or empty (default 12).', 'haru-circle' ),
                            'subtitle' => '',
                            'validate' => 'numeric',
                            'default'  => '12',
                        ),

                        array(
                            'id'       => 'haru_product_display_columns',
                            'type'     => 'select',
                            'title'    => esc_html__( 'Products Display Columns', 'haru-circle' ),
                            'subtitle' => esc_html__( 'Choose the number of columns to display on shop/category pages.','haru-circle' ),
                            'options'  => array(
                                '2'     => '2',
                                '3'     => '3',
                                '4'     => '4',
                                '5'     => '5'
                            ),
                            'desc'    => '',
                            'default' => '3',
                            'select2' => array('allowClear' =>  false) ,
                        ),
                        array(
                            'id'     => 'haru-section-archive-product-layout-start',
                            'type'   => 'section',
                            'title'  => esc_html__( 'Layout Options', 'haru-circle' ),
                            'indent' => true
                        ),
                        array(
                            'id'       => 'haru_archive_product_layout',
                            'type'     => 'button_set',
                            'title'    => esc_html__( 'Archive Product Layout', 'haru-circle' ),
                            'subtitle' => '',
                            'desc'     => '',
                            'options'  => array(
                                'full'            => esc_html__( 'Full Width', 'haru-circle' ),
                                'container'       => esc_html__( 'Container', 'haru-circle' ), 
                            ),
                            'default'  => 'full'
                        ),
                        array(
                            'id'       => 'haru_archive_product_style',
                            'type'     => 'button_set',
                            'title'    => esc_html__( 'Archive Product Style', 'haru-circle' ),
                            'subtitle' => esc_html__( 'Set shop page or product category style.', 'haru-circle' ),
                            'options'  => array(
                                'default' => esc_html__( 'Default', 'haru-circle' ), // style_1
                                'ajax'    => esc_html__( 'Ajax', 'haru-circle' ), // style_2
                            ),
                            'default'  => 'default'
                        ),
                        array(
                            'id'       => 'haru_ajax_show_categories',
                            'type'     => 'switch',
                            'title'    => esc_html__( 'Show Categories', 'haru-circle' ),
                            'subtitle' => esc_html__( 'Show/Hide categories in filter sidebar.', 'haru-circle' ),
                            'default'  => true,
                            'required' => array('haru_archive_product_style', '=', array('ajax')),
                        ),
                        array(
                            'id'       => 'haru_ajax_show_filters',
                            'type'     => 'switch',
                            'title'    => esc_html__( 'Show Filters', 'haru-circle' ),
                            'subtitle' => esc_html__( 'Show/Hide filters in filter sidebar.', 'haru-circle' ),
                            'default'  => true,
                            'required' => array('haru_archive_product_style', '=', array('ajax')),
                        ),
                        array(
                            'id'       => 'haru_ajax_show_search',
                            'type'     => 'switch',
                            'title'    => esc_html__( 'Show Search', 'haru-circle' ),
                            'subtitle' => esc_html__( 'Show/Hide search in filter sidebar.', 'haru-circle' ),
                            'default'  => true,
                            'required' => array('haru_archive_product_style', '=', array('ajax')),
                        ),
                        array(
                            'id'       => 'haru_archive_product_sidebar',
                            'type'     => 'image_select',
                            'title'    => esc_html__( 'Archive Product Sidebar', 'haru-circle' ),
                            'subtitle' => esc_html__( 'None, Left or Right Sidebar', 'haru-circle' ),
                            'desc'     => '',
                            'options'  => array(
                                'none'  => array('title' => '', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/sidebar-none.png'),
                                'left'  => array('title' => '', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/sidebar-left.png'),
                                'right' => array('title' => '', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/sidebar-right.png')
                            ),
                            'default'  => 'right',
                            'required' => array('haru_archive_product_style', '=', array('default'))
                        ),

                        array(
                            'id'       => 'haru_archive_product_left_sidebar',
                            'type'     => 'select',
                            'title'    => esc_html__( 'Archive Product Left Sidebar', 'haru-circle' ),
                            'subtitle' => '',
                            'data'     => 'sidebars',
                            'desc'     => '',
                            'default'  => 'woocommerce',
                            'required' => array('haru_archive_product_sidebar', '=', array('left')),
                        ),
                        array(
                            'id'       => 'haru_archive_product_right_sidebar',
                            'type'     => 'select',
                            'title'    => esc_html__( 'Archive Product Right Sidebar', 'haru-circle' ),
                            'subtitle' => '',
                            'data'     => 'sidebars',
                            'desc'     => '',
                            'default'  => 'woocommerce',
                            'required' => array('haru_archive_product_sidebar', '=', array('right')),
                        ),
                        array(
                            'id'     => 'haru-section-archive-product-layout-end',
                            'type'   => 'section',
                            'indent' => false
                        ),
                        array(
                            'id'     => 'haru-section-archive-product-title-start',
                            'type'   => 'section',
                            'title'  => esc_html__( 'Page Title Options', 'haru-circle' ),
                            'indent' => true
                        ),
                        array(
                            'id'       => 'haru_show_archive_product_title',
                            'type'     => 'switch',
                            'title'    => esc_html__( 'Archive Title', 'haru-circle' ),
                            'subtitle' => '',
                            'default'  => true
                        ),

                        array(
                            'id'       => 'haru_archive_product_title_layout',
                            'type'     => 'button_set',
                            'title'    => esc_html__( 'Archive Product Title Layout', 'haru-circle' ),
                            'subtitle' => '',
                            'desc'     => '',
                            'options'  => array(
                                'full'            => esc_html__( 'Full Width', 'haru-circle' ),
                                'container'       => esc_html__( 'Container', 'haru-circle' ),
                            ),
                            'default'  => 'full',
                            'required' => array('haru_show_archive_product_title', '=', array('1')),
                        ),

                        array(
                            'id'       => 'haru_archive_product_title_bg_image',
                            'type'     => 'media',
                            'url'      => true,
                            'title'    => esc_html__( 'Archive Product Title Background', 'haru-circle' ),
                            'subtitle' => '',
                            'desc'     => '',
                            'default'  => array(
                                'url' => get_template_directory_uri() . '/framework/admin-assets/images/theme-options/bg-page-title.jpg'
                            ),
                            'required'  => array('haru_show_archive_product_title', '=', array('1')),
                        ),

                        array(
                            'id'       => 'haru_archive_product_title_parallax',
                            'type'     => 'switch',
                            'title'    => esc_html__( 'Archive Product Title Parallax', 'haru-circle' ),
                            'subtitle' => '',
                            'default'  => false,
                            'required' => array('haru_show_archive_product_title', '=', array('1')),
                        ),

                        array(
                            'id'       => 'haru_breadcrumbs_in_archive_product_title',
                            'type'     => 'switch',
                            'title'    => esc_html__( 'Breadcrumbs in Archive Product', 'haru-circle' ),
                            'subtitle' => '',
                            'default'  => true
                        ),

                    )
                );

                // Single Product
                $this->sections[] = array(
                    'title'      => esc_html__( 'Single Product', 'haru-circle' ),
                    'desc'       => '',
                    'icon'       => 'el el-laptop',
                    'subsection' => true,
                    'fields'     => array(
                        array(
                            'id'     => 'haru-section-single-product-layout-start',
                            'type'   => 'section',
                            'title'  => esc_html__( 'Layout Options', 'haru-circle' ),
                            'indent' => true
                        ),

                        array(
                            'id'       => 'haru_single_product_layout',
                            'type'     => 'button_set',
                            'title'    => esc_html__( 'Single Product Layout', 'haru-circle' ),
                            'subtitle' => '',
                            'desc'     => '',
                            'options'  => array(
                                'full'            => esc_html__( 'Full Width', 'haru-circle' ),
                                'container'       => esc_html__( 'Container', 'haru-circle' ),
                            ),
                            'default'  => 'container'
                        ),

                        array(
                            'id'       => 'haru_single_product_style',
                            'type'     => 'select',
                            'title'    => esc_html__( 'Single Product Style', 'haru-circle' ),
                            'subtitle' => '',
                            'desc'     => '',
                            'options'  => array(
                                'horizontal'     => esc_html__( 'Horizontal Slide','haru-circle' ),
                                'vertical'       => esc_html__( 'Vertical Slide','haru-circle' ),
                                'vertical_gallery'       => esc_html__( 'Vertical Gallery','haru-circle' ),
                            ),
                            'default'  => 'horizontal'
                        ),

                        array(
                            'id'       => 'haru_single_product_thumbnail_columns',
                            'type'     => 'select',
                            'title'    => esc_html__( 'Product Thumbnail Columns', 'haru-circle' ),
                            'subtitle' => esc_html__( 'Choose the number of columns to display thumbnails.','haru-circle' ),
                            'options'  => array(
                                '2'     => '2',
                                '3'     => '3',
                                '4'     => '4',
                                '5'     => '5'
                            ),
                            'desc'    => '',
                            'default' => '2',
                            'required'  => array('haru_single_product_style', '=', array('horizontal', 'vertical')),
                        ),

                        array(
                            'id'       => 'haru_single_product_thumbnail_position',
                            'type'     => 'button_set',
                            'title'    => esc_html__( 'Product Thumbnails Position', 'haru-circle' ),
                            'subtitle' => '',
                            'desc'     => '',
                            'options'  => array(
                                'thumbnail-left'        => esc_html__( 'Left', 'haru-circle' ),
                                'thumbnail-right'       => esc_html__( 'Right', 'haru-circle' ),
                            ),
                            'default'  => 'thumbnail-left',
                            'required'  => array('haru_single_product_style', '=', array('vertical')),
                        ),

                        array(
                            'id'       => 'haru_single_product_sidebar',
                            'type'     => 'image_select',
                            'title'    => esc_html__( 'Single Product Sidebar', 'haru-circle' ),
                            'subtitle' => esc_html__( 'None, Left or Right Sidebar', 'haru-circle' ),
                            'desc'     => '',
                            'options'  => array(
                                'none'  => array('title' => '', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/sidebar-none.png'),
                                'left'  => array('title' => '', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/sidebar-left.png'),
                                'right' => array('title' => '', 'img' => get_template_directory_uri().'/framework/admin-assets/images/theme-options/sidebar-right.png'),
                            ),
                            'default' => 'none'
                        ),

                        array(
                            'id'       => 'haru_single_product_left_sidebar',
                            'type'     => 'select',
                            'title'    => esc_html__( 'Single Product Left Sidebar', 'haru-circle' ),
                            'subtitle' => '',
                            'data'     => 'sidebars',
                            'desc'     => '',
                            'default'  => 'woocommerce',
                            'required' => array('haru_single_product_sidebar', '=', array('left','both')),
                        ),

                        array(
                            'id'       => 'haru_single_product_right_sidebar',
                            'type'     => 'select',
                            'title'    => esc_html__( 'Single Product Right Sidebar', 'haru-circle' ),
                            'subtitle' => '',
                            'data'     => 'sidebars',
                            'desc'     => '',
                            'default'  => 'woocommerce',
                            'required' => array('haru_single_product_sidebar', '=', array('right','both')),
                        ),

                        array(
                            'id'     => 'haru-section-single-product-layout-end',
                            'type'   => 'section',
                            'indent' => false
                        ),

                        array(
                            'id'     => 'haru-section-single-product-title-start',
                            'type'   => 'section',
                            'title'  => esc_html__( 'Page Title Options', 'haru-circle' ),
                            'indent' => true
                        ),

                        array(
                            'id'       => 'haru_show_single_product_title',
                            'type'     => 'switch',
                            'title'    => esc_html__( 'Single Title', 'haru-circle' ),
                            'subtitle' => '',
                            'default'  => true
                        ),

                        array(
                            'id'       => 'haru_single_product_title_layout',
                            'type'     => 'button_set',
                            'title'    => esc_html__( 'Single Product Title Layout', 'haru-circle' ),
                            'subtitle' => '',
                            'desc'     => '',
                            'options'  => array(
                                'full'            => esc_html__( 'Full Width', 'haru-circle' ),
                                'container'       => esc_html__( 'Container', 'haru-circle' ),
                            ),
                            'default'  => 'full',
                            'required' => array('haru_show_single_product_title', '=', array('1')),
                        ),

                        array(
                            'id'       => 'haru_single_product_title_bg_image',
                            'type'     => 'media',
                            'url'      => true,
                            'title'    => esc_html__( 'Single Product Title Background', 'haru-circle' ),
                            'subtitle' => '',
                            'desc'     => '',
                            'default'  => array(
                                'url' => get_template_directory_uri() . '/framework/admin-assets/images/theme-options/bg-page-title.jpg'
                            ),
                            'required'  => array('haru_show_single_product_title', '=', array('1')),
                        ),

                        array(
                            'id'       => 'haru_single_product_title_parallax',
                            'type'     => 'switch',
                            'title'    => esc_html__( 'Single Product Title Parallax', 'haru-circle' ),
                            'subtitle' => '',
                            'default'  => false,
                            'required' => array('haru_show_single_product_title', '=', array('1')),
                        ),

                        array(
                            'id'       => 'haru_breadcrumbs_in_single_product_title',
                            'type'     => 'switch',
                            'title'    => esc_html__( 'Breadcrumbs in Single Product', 'haru-circle' ),
                            'subtitle' => '',
                            'default'  => true
                        ),

                        array(
                            'id'     => 'haru-section-single-product-title-end',
                            'type'   => 'section',
                            'indent' => false
                        ),

                        array(
                            'id'     => 'haru-section-single-product-related-start',
                            'type'   => 'section',
                            'title'  => esc_html__( 'Related Product Options', 'haru-circle' ),
                            'indent' => true
                        ),

                        array(
                            'id'       => 'haru_related_product_count',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Related Products Number', 'haru-circle' ),
                            'subtitle' => '',
                            'validate' => 'number',
                            'default'  => '6',
                        ),

                        array(
                            'id'       => 'haru_related_product_display_columns',
                            'type'     => 'select',
                            'title'    => esc_html__( 'Related Product Display Columns', 'haru-circle' ),
                            'subtitle' => '',
                            'options'  => array(
                                '3'     => esc_html__( '3', 'haru-circle' ),
                                '4'     => esc_html__( '4', 'haru-circle' ),
                            ),
                            'desc'    => '',
                            'default' => '4'
                        ),

                        array(
                            'id'     => 'haru-section-single-product-related-end',
                            'type'   => 'section',
                            'indent' => false
                        ),

                    )
                );
            }

        }

        public function setHelpTabs() {
        }

        /**
         * All the possible arguments for Redux.
         * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'           => 'haru_circle_options',
                // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'       => $theme->get( 'Name' ),
                // Name that appears at the top of your panel
                'display_version'    => $theme->get( 'Version' ),
                // Version that appears at the top of your panel
                'menu_type'          => 'menu', // or submenu under Appearence
                //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'     => true,
                // Show the sections below the admin menu item or not
                'menu_title'         => esc_html__( 'Theme Options', 'haru-circle' ),
                'page_title'         => esc_html__( 'Theme Options', 'haru-circle' ),
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key'     => '',
                // Must be defined to add google fonts to the typography module

                'async_typography'   => false,
                // Use a asynchronous font on the front end or font string
                'admin_bar'          => true,
                // Show the panel pages on the admin bar
                'global_variable'    => '',
                // Set a different name for your global variable other than the opt_name
                'dev_mode'           => false,
                // Show the time the page took to load, etc
                'forced_dev_mode_off' => true,
                // To forcefully disable the dev mode
                'templates_path'     => get_template_directory().'/framework/core/templates/panel',
                // Path to the templates file for various Redux elements
                'customizer'         => true,
                // Enable basic customizer support

                // OPTIONAL -> Give you extra features
                'page_priority'      => null,
                // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent'        => 'themes.php',
                // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_theme_page#Parameters
                'page_permissions'   => 'manage_options',
                // Permissions needed to access the options panel.
                'menu_icon'          => '',
                // Specify a custom URL to an icon
                'last_tab'           => '',
                // Force your panel to always open to a specific tab (by id)
                'page_icon'          => 'icon-themes',
                // Icon displayed in the admin panel next to your menu_title
                'page_slug'          => '_options',
                // Page slug used to denote the panel
                'save_defaults'      => true,
                // On load save the defaults to DB before user clicks save or not
                'default_show'       => false,
                // If true, shows the default value next to each field that is not the default value.
                'default_mark'       => '',
                // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => true,
                // Shows the Import/Export panel when not used as a field.

                // CAREFUL -> These options are for advanced use only
                'transient_time'     => 60 * MINUTE_IN_SECONDS,
                'output'             => true,
                // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'         => true,
                // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head

                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database'           => '',
                // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info'        => false,
                // REMOVE

                // HINTS
                'hints'              => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'   => 'light',
                        'shadow'  => true,
                        'rounded' => false,
                        'style'   => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show' => array(
                            'effect'   => 'slide',
                            'duration' => '500',
                            'event'    => 'mouseover',
                        ),
                        'hide' => array(
                            'effect'   => 'slide',
                            'duration' => '500',
                            'event'    => 'click mouseleave',
                        ),
                    ),
                )
            );

            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            $args['share_icons'][] = array(
                'url'   => 'https://github.com/ReduxFramework/ReduxFramework',
                'title' => 'Visit us on GitHub',
                'icon'  => 'el el-github'
            );
            $args['share_icons'][] = array(
                'url'   => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
                'title' => 'Like us on Facebook',
                'icon'  => 'el el-facebook'
            );
            $args['share_icons'][] = array(
                'url'   => 'http://twitter.com/reduxframework',
                'title' => 'Follow us on Twitter',
                'icon'  => 'el el-twitter'
            );
            $args['share_icons'][] = array(
                'url'   => 'http://www.linkedin.com/company/redux-framework',
                'title' => 'Find us on LinkedIn',
                'icon'  => 'el el-linkedin'
            );

        }

    }

    // global $reduxConfig;
    $reduxConfig = new Redux_Framework_theme_options();
}
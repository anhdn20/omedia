<?php
/**
 * Plugin Name: Haru Circle Core
 * Plugin URI: http://harutheme.com
 * Description: The Haru Circle Core plugin.
 * Version: 2.6.5
 * Author: HaruTheme
 * Author URI: http://harutheme.com
 *
 * Text Domain: haru-circle
 * Domain Path: /languages/
 *
 * @package Haru Circle Core
 * @category Core Plugin
 * @author HaruTheme
 *
 **/

if (!defined('ABSPATH')) {
    exit; // Exit if access directly
}

if ( ! class_exists( 'Haru_CircleCore' ) ) {
    class Haru_CircleCore {
        protected $loader;

        protected $prefix;

        protected $version;

        function __construct() {
            $this->version = '2.6.5';
            $this->prefix = 'haru-circle-core';
            $this->define_constants();
            $this->include_files();
            $this->load_plugin_textdomain();
            $this->init(); // Load script
        }

        function init() {
            add_action( 'plugins_loaded', array($this, 'load_plugin_textdomain' ));
            add_action( 'admin_init', array($this, 'haru_admin_script' ));
            add_action( 'wp_enqueue_scripts', array($this, 'haru_frontend_script' ), 1);
            // Apply filter do_shortcode
            add_filter( 'widget_text', 'do_shortcode' );
            add_filter( 'widget_content', 'do_shortcode' );
        }

        function define_constants() {
            if( !defined( 'PLUGIN_HARU_CIRCLE_CORE_DIR' ) ) {
                define( 'PLUGIN_HARU_CIRCLE_CORE_DIR', plugin_dir_path(__FILE__) );
            }
            if( !defined( 'PLUGIN_HARU_CIRCLE_CORE_URL' ) ) {
                define( 'PLUGIN_HARU_CIRCLE_CORE_URL', plugin_dir_url( __FILE__ ) );
            }
            if( !defined( 'PLUGIN_HARU_CIRCLE_CORE_FILE' ) ) {
                define( 'PLUGIN_HARU_CIRCLE_CORE_FILE', __FILE__ );
            }
            if( !defined( 'PLUGIN_HARU_CIRCLE_CORE_NAME' ) ) {
                define( 'PLUGIN_HARU_CIRCLE_CORE_NAME', 'haru-circle-core' );
            }
            if( !defined( 'HARU_CIRCLE_CORE_SHORTCODE_CATEGORY' ) ) {
                define( 'HARU_CIRCLE_CORE_SHORTCODE_CATEGORY', esc_html__( 'Circle Shortcodes', 'haru-circle' ) );
            }
        }

        function include_files() {
            require_once( 'includes/maintenance/_init.php' );
            require_once( 'includes/posttypes/_init.php' );
            require_once( 'includes/circle/_init.php' ); // Circle
            require_once( 'includes/shortcodes/shortcodes.php' );
            require_once( 'includes/widgets/widgets.php' );
            require_once( 'includes/term-meta/index.php' ); // Add term meta to product attributes
        }

        public function load_plugin_textdomain() {
            load_plugin_textdomain( 'haru-circle', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/'  );
        }

        // Load script admin
        public function haru_admin_script() {
            // CSS
            // $pages = isset($_GET['page']) ? $_GET['page'] : '';
            // if ($pages == '_options') return;

            wp_enqueue_style( $this->prefix.'-admin', plugins_url( PLUGIN_HARU_CIRCLE_CORE_NAME.'/admin/assets/css/admin.css'), array(), $this->version, 'all' );
            // wp_enqueue_style( $this->prefix.'-select2', plugins_url( PLUGIN_HARU_CIRCLE_CORE_NAME.'/admin/assets/plugins/jquery.select2/select2.min.css'), array(), $this->version, 'all' );
            wp_enqueue_style( $this->prefix.'-datetimepicker', plugins_url( PLUGIN_HARU_CIRCLE_CORE_NAME.'/admin/assets/plugins/datetimepicker/jquery.datetimepicker.css'), array(), $this->version, 'all' );

            // JS
            wp_enqueue_script( $this->prefix .'-admin', plugins_url( PLUGIN_HARU_CIRCLE_CORE_NAME.'/admin/assets/js/admin.js'), array( 'jquery' ), $this->version, false );

            $screen = get_current_screen(); // @TODO: Doesn't need now
            // if ( !empty($screen) && ($screen->post_type != 'product') ) {
                // wp_enqueue_script( $this->prefix .'-select2', plugins_url( PLUGIN_HARU_CIRCLE_CORE_NAME.'/admin/assets/plugins/jquery.select2/select2.full.min.js'), array( 'jquery' ), $this->version, false );
            // }
            
            wp_enqueue_script( $this->prefix .'-datetimepicker', plugins_url( PLUGIN_HARU_CIRCLE_CORE_NAME.'/admin/assets/plugins/datetimepicker/jquery.datetimepicker.js'), array( 'jquery' ), $this->version, false );

            wp_localize_script( $this->prefix .'admin' , 'haru_core_meta' , array(
                'ajax_url' => admin_url( 'admin-ajax.php?activate-multi=true' )
            ) );
        }

        // Load script front-end
        public function haru_frontend_script() {
            // CSS
            // Mediaelement
            if ( !is_admin() ) {
                wp_deregister_style('mediaelement');
                wp_enqueue_style( 'mediaelement', get_template_directory_uri() . '/assets/libraries/mediaelement/mediaelementplayer.css', array() );
            }
            // JS
            /* Mediaelement move to plugin to fix theme check */
            if ( !is_admin() ) {
                wp_deregister_script('mediaelement');
                wp_enqueue_script( 'mediaelement', get_template_directory_uri() . '/assets/libraries/mediaelement/mediaelement-and-player.js', array(), false, true);
                wp_enqueue_script( 'mediaelement-vimeo', get_template_directory_uri() . '/assets/libraries/mediaelement/renderers/vimeo.js', array(), false, true);
            }
        }
    }

    // Run Haru_CircleCore
    if( !function_exists( 'init_haru_circle_core' ) ) {
        function init_haru_circle_core() {
            $haruCircleFramework = new Haru_CircleCore();
        }
    }

    init_haru_circle_core();
}

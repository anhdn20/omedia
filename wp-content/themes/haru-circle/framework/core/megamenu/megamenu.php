<?php
/*
Plugin Name: MegaMenu - The Ultimate WordPress Mega Menu
Plugin URI: http://www.harutheme.com
Description: Easily create beautiful, flexible, responsive mega menus
Author: HaruTheme
Author URI: http://www.harutheme.com
Version: 1.0.0
*/

// See the tutorial from here: http://www.wpexplorer.com/adding-custom-attributes-to-wordpress-menus/
class Haru_Mega_Menu {
    /**
     * Initializes the plugin by setting localization, filters, and administration functions.
     */
    function __construct() {

        // Load enqueue script Haru Mega Menu (move to enqueute-frontend.php)
        
        // add custom menu fields to menu
        add_filter( 'wp_setup_nav_menu_item', array( $this, 'haru_mega_memu_setup_item' ) );

        // save menu custom fields
        add_action( 'wp_update_nav_menu_item', array( $this, 'haru_mega_menu_save_fields' ), 10, 3 );

        // Edit menu walker to show form
        add_filter( 'wp_edit_nav_menu_walker', array( $this, 'haru_mega_menu_edit_walker' ), 10, 2 );

        // Edit menu argument (process menu mobile)
        add_filter( 'wp_nav_menu_args', array($this, 'replace_walker_to_haru_mega_menu') );

    }

    /**
     * Add custom fields to $item nav object
     * in order to be used in custom Walker
     *
     * @access      public
     * @since       1.0
     * @return      void
    */

    public function haru_mega_memu_setup_item( $menu_item ) {
        // Set item mega menu
        $menu_item->megamenu                  = get_post_meta( $menu_item->ID, '_menu_item_megamenu', true );
        
        // Set item style
        $menu_item->megamenu_style            = get_post_meta( $menu_item->ID, '_menu_item_megamenu_style', true );
        
        // Set item width
        $menu_item->megamenu_width            = get_post_meta( $menu_item->ID, '_menu_item_megamenu_width', true );
        
        // Set item columns
        $menu_item->megamenu_col              = get_post_meta( $menu_item->ID, '_menu_item_megamenu_col', true );

        // Set item columns
        $menu_item->megamenu_col_tab          = get_post_meta( $menu_item->ID, '_menu_item_megamenu_col_tab', true );
        
        // Set item sublabel (as HOT, NEW)
        $menu_item->megamenu_sublabel         = get_post_meta( $menu_item->ID, '_menu_item_megamenu_sublabel', true );
        
        // Set item sublabel color
        $menu_item->megamenu_sublabel_color   = get_post_meta( $menu_item->ID, '_menu_item_megamenu_sublabel_color', true );
        
        // Set item background image
        $menu_item->megamenu_background_image = get_post_meta( $menu_item->ID, '_menu_item_megamenu_background_image', true );
        
        // Set item hedding
        $menu_item->megamenu_heading          = get_post_meta( $menu_item->ID, '_menu_item_megamenu_heading', true );
        
        // Set item icon
        $menu_item->megamenu_icon             = get_post_meta( $menu_item->ID, '_menu_item_megamenu_icon', true );
        
        // Set item icon color
        $menu_item->megamenu_icon_color       = get_post_meta( $menu_item->ID, '_menu_item_megamenu_icon_color', true );
        
        // Set item icon size
        $menu_item->megamenu_icon_size        = get_post_meta( $menu_item->ID, '_menu_item_megamenu_icon_size', true );
        
        // Set item icon alignment
        $menu_item->megamenu_icon_alignment   = get_post_meta( $menu_item->ID, '_menu_item_megamenu_icon_alignment', true );
        
        // Set item widget
        $menu_item->megamenu_widgetarea       = get_post_meta( $menu_item->ID, '_menu_item_megamenu_widgetarea', true );
        
        return $menu_item;

    } 

    /**
     * Save menu custom fields
     *
     * @access      public
     * @since       1.0 
     * @return      void
    */
    public function haru_mega_menu_save_fields( $menu_id, $menu_item_db_id, $args ) {
        // Process Enable megamenu
        if(isset($_REQUEST['menu-item-megamenu'][$menu_item_db_id]) && $_REQUEST['menu-item-megamenu'][$menu_item_db_id] !== '') {
            $megamenu_value = $_REQUEST['menu-item-megamenu'][$menu_item_db_id];
            update_post_meta( $menu_item_db_id, '_menu_item_megamenu', $megamenu_value  );
        } else {
            delete_post_meta ( $menu_item_db_id, '_menu_item_megamenu'  );
        }

        // Process megamenu style
        if(isset($_REQUEST['menu-item-megamenu_style'][$menu_item_db_id]) && $_REQUEST['menu-item-megamenu_style'][$menu_item_db_id] !== '') {
            $megamenu_style_value = $_REQUEST['menu-item-megamenu_style'][$menu_item_db_id];
            update_post_meta( $menu_item_db_id, '_menu_item_megamenu_style', $megamenu_style_value  );
        } else {
            delete_post_meta ( $menu_item_db_id, '_menu_item_megamenu_style' );
        }

        // Process megamenu width
        if ( isset($_REQUEST['menu-item-megamenu_width']) && is_array( $_REQUEST['menu-item-megamenu_width']) && isset($_REQUEST['menu-item-megamenu_width'][$menu_item_db_id]) ) {
            $megamenu_width_value = $_REQUEST['menu-item-megamenu_width'][$menu_item_db_id];
            update_post_meta( $menu_item_db_id, '_menu_item_megamenu_width', $megamenu_width_value );
        } else {
            delete_post_meta ( $menu_item_db_id, '_menu_item_megamenu_width' );
        }

        // Process megamenu columns
        if ( isset($_REQUEST['menu-item-megamenu_columns']) && is_array( $_REQUEST['menu-item-megamenu_columns']) ) {
            $megamenu_col_value = $_REQUEST['menu-item-megamenu_columns'][$menu_item_db_id];
            update_post_meta( $menu_item_db_id, '_menu_item_megamenu_col', $megamenu_col_value );
        } else {
            delete_post_meta ( $menu_item_db_id, '_menu_item_megamenu_col' );
        }

        // Process megamenu columns for tabs
        if ( isset($_REQUEST['menu-item-megamenu_columns_tab']) && is_array( $_REQUEST['menu-item-megamenu_columns_tab']) ) {
            $megamenu_col_tab_value = $_REQUEST['menu-item-megamenu_columns_tab'][$menu_item_db_id];
            update_post_meta( $menu_item_db_id, '_menu_item_megamenu_col_tab', $megamenu_col_tab_value );
        } else {
            delete_post_meta ( $menu_item_db_id, '_menu_item_megamenu_col_tab' );
        }

        // Process megamenu sublabel
        if ( isset($_REQUEST['menu-item-megamenu_sublabel']) && is_array( $_REQUEST['menu-item-megamenu_sublabel']) ) {
            $megamenu_sublabel_value = $_REQUEST['menu-item-megamenu_sublabel'][$menu_item_db_id];
            update_post_meta( $menu_item_db_id, '_menu_item_megamenu_sublabel', $megamenu_sublabel_value );
        } else {
            delete_post_meta ( $menu_item_db_id, '_menu_item_megamenu_sublabel' );
        }

        // Process megamenu sublabel color
        if ( isset($_REQUEST['menu-item-megamenu_sublabel_color']) && is_array( $_REQUEST['menu-item-megamenu_sublabel_color']) ) {
            $megamenu_sublabel_color_value = $_REQUEST['menu-item-megamenu_sublabel_color'][$menu_item_db_id];
            update_post_meta( $menu_item_db_id, '_menu_item_megamenu_sublabel_color', $megamenu_sublabel_color_value );
        } else {
            delete_post_meta ( $menu_item_db_id, '_menu_item_megamenu_sublabel_color' );
        }

        // Process megamenu background image
        if ( isset($_REQUEST['menu-item-megamenu_background_image']) && is_array( $_REQUEST['menu-item-megamenu_background_image']) ) {
            $megamenu_background_image_value = $_REQUEST['menu-item-megamenu_background_image'][$menu_item_db_id];
            update_post_meta( $menu_item_db_id, '_menu_item_megamenu_background_image', $megamenu_background_image_value );
        } else {
            delete_post_meta ( $menu_item_db_id, '_menu_item_megamenu_background_image' );
        }

        // Process Hide Mega menu heading
        if ( isset($_REQUEST['menu-item-megamenu_heading']) && is_array( $_REQUEST['menu-item-megamenu_heading']) ) {
            $megamenu_heading_value = $_REQUEST['menu-item-megamenu_heading'][$menu_item_db_id];
            update_post_meta( $menu_item_db_id, '_menu_item_megamenu_heading', $megamenu_heading_value );
        } else {
            delete_post_meta ( $menu_item_db_id, '_menu_item_megamenu_heading' );
        }

        // Process Hide Mega menu icon
        if ( isset($_REQUEST['menu-item-megamenu_icon']) && is_array( $_REQUEST['menu-item-megamenu_icon']) ) {
            $megamenu_icon_value = $_REQUEST['menu-item-megamenu_icon'][$menu_item_db_id];
            update_post_meta( $menu_item_db_id, '_menu_item_megamenu_icon', $megamenu_icon_value );
        } else {
            delete_post_meta ( $menu_item_db_id, '_menu_item_megamenu_icon'  );
        }

        // Process Hide Mega menu icon color
        if ( isset($_REQUEST['menu-item-megamenu_icon_color']) && is_array( $_REQUEST['menu-item-megamenu_icon_color']) ) {
            $megamenu_icon_color_value = $_REQUEST['menu-item-megamenu_icon_color'][$menu_item_db_id];
            update_post_meta( $menu_item_db_id, '_menu_item_megamenu_icon_color', $megamenu_icon_color_value );
        } else {
            delete_post_meta ( $menu_item_db_id, '_menu_item_megamenu_icon_color'  );
        }

        // Process Hide Mega menu icon size
        if ( isset($_REQUEST['menu-item-megamenu_icon_size']) && is_array( $_REQUEST['menu-item-megamenu_icon_size']) ) {
            $megamenu_icon_size_value = $_REQUEST['menu-item-megamenu_icon_size'][$menu_item_db_id];
            update_post_meta( $menu_item_db_id, '_menu_item_megamenu_icon_size', $megamenu_icon_size_value );
        } else {
            delete_post_meta ( $menu_item_db_id, '_menu_item_megamenu_icon_color'  );
        }

        // Process Hide Mega menu icon alignment
        if ( isset($_REQUEST['menu-item-megamenu_icon_alignment']) && is_array( $_REQUEST['menu-item-megamenu_icon_alignment']) ) {
            $megamenu_icon_alignment_value = $_REQUEST['menu-item-megamenu_icon_alignment'][$menu_item_db_id];
            update_post_meta( $menu_item_db_id, '_menu_item_megamenu_icon_alignment', $megamenu_icon_alignment_value );
        } else {
            delete_post_meta ( $menu_item_db_id, '_menu_item_megamenu_icon_alignment'  );
        }

        // Process Mega Menu Widget Area
        if ( isset($_REQUEST['menu-item-megamenu_widgetarea']) && is_array( $_REQUEST['menu-item-megamenu_widgetarea']) ) {
            $megamenu_widgetarea_value = $_REQUEST['menu-item-megamenu_widgetarea'][$menu_item_db_id];
            update_post_meta( $menu_item_db_id, '_menu_item_megamenu_widgetarea', $megamenu_widgetarea_value );
        } else {
            delete_post_meta ( $menu_item_db_id, '_menu_item_megamenu_widgetarea'  );
        }

    }
    
    /**
     * Define new Walker edit
     *
     * @access      public
     * @since       1.0 
     * @return      void
    */
    function haru_mega_menu_edit_walker($walker,$menu_id) {
        return 'Walker_Nav_Menu_Edit_Custom';
    }

    /**
     * Reaplace walker args to haru_mega_menu
     *
     * @access      public
     * @since       1.0 
     * @return      void
    */
    public function replace_walker_to_haru_mega_menu($args) {
        if( $args['menu_class'] == 'haru-nav-mobile-menu' ) {
            $args['is_mobile_menu'] = true;
        }

        return $args;
    }

}

// instantiate plugin's class
$GLOBALS['haru_mega_memu'] = new Haru_Mega_Menu();

function please_set_menu(){
    $sentence = '<ul><li><a href="">'.  esc_html__( 'No menu assigned', 'haru-circle' ).'</a></li></ul>';
    
    echo !empty( $sentence ) ? $sentence : '';  
}

require_once get_template_directory() . '/framework/core/megamenu/edit_custom_walker.php';
require_once get_template_directory() . '/framework/core/megamenu/custom_walker.php';
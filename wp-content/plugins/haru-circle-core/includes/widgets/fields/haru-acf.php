<?php
/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

if (!defined('ABSPATH')) {
    exit;
}
if (!class_exists('Haru_acf_widget_fields')) {
    class Haru_acf_widget_fields {
        
        function __construct($widget, $value) {
            $this->widget = $widget;
            $this->id     = $this->widget->settings['id'];
            $this->field  = array_key_exists('fields', $this->widget->settings) ? $this->widget->settings['fields'] : '';
            $this->extra  = array_key_exists('extra', $this->widget->settings) ? $this->widget->settings['extra'] : '';
            $this->value  = $value;
            $this->enqueue();
        }

        public function render() {
            $data_section_wrap = uniqid();
            $fields            = $this->field;
            $extras            = $this->extra;
            $field_values      = is_array($this->value) && array_key_exists('fields', $this->value) ? $this->value['fields'] : '';
            $extra_values      = is_array($this->value) && array_key_exists('extra', $this->value) ? $this->value['extra'] : '';
            $x                 = 0;
            $plugin_path       = untrailingslashit(plugin_dir_path(__FILE__));
            $is_edit_mode      = (isset($field_values) && is_array($field_values) && count($field_values) > 0) || (isset($extra_values) && is_array($extra_values) && count($extra_values) > 0);
            if ( $is_edit_mode ) {
                include($plugin_path . '/templates/edit.php');
            } else {
                include($plugin_path . '/templates/new.php');
            }
        }

        public function enqueue() {
            wp_enqueue_style('haru-widget-rows-css', plugins_url() . '/haru-circle-core/includes/widgets/fields/assets/style.css', array(), false);
            wp_enqueue_script('haru-widget-rows-js', plugins_url() . '/haru-circle-core/includes/widgets/fields/assets/main.min.js', false, true);
        }
    }
}
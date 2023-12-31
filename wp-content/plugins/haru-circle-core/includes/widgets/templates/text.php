<?php
/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/
?>
<div class="textbox-wrap element"  data-require-element="<?php if(isset($require_element)){ echo esc_attr($require_element);} ?>"
     data-require-element-id="<?php if(isset($require_element_id)){ echo esc_attr($require_element_id);} ?>"
     data-require-compare="<?php if(isset($require_compare)){ echo esc_attr($require_compare);} ?>"
     data-require-values="<?php if(isset($require_values)){ echo esc_attr($require_values);} ?>">
    <label
        for="<?php echo esc_attr($field_output_name); ?>"><?php echo esc_html($field_title); ?>:</label>
    <input class="widefat" data-section-id="<?php echo esc_attr($section_id) ?>"
           data-title="<?php echo esc_attr($is_title_block) ?>"
           id="<?php echo esc_attr($field_output_id); ?>"
           name="<?php echo esc_attr($field_output_name); ?>"
           type="text" value="<?php if(isset($field_value)){ echo esc_attr($field_value) ;}else{echo '';}  ?>"/>
</div>
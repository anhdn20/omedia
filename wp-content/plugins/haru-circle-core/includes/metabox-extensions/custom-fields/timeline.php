<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'RWMB_Timeline_Field' ) )
{
	class RWMB_Timeline_Field extends RWMB_Field
	{
		static function admin_enqueue_scripts()
		{
			wp_enqueue_style( 'rwmb-timeline', PLUGIN_HARU_CIRCLE_CORE_URL . '/includes/metabox-extensions/custom-fields/assets/css/timeline.css', array() );
			wp_enqueue_script( 'rwmb-timeline', PLUGIN_HARU_CIRCLE_CORE_URL . '/includes/metabox-extensions/custom-fields/assets/js/timeline.js', array() );
		}
		/**
		 * Get field HTML
		 *
		 * @param mixed $meta
		 * @param array $field
		 *
		 * @return string
		 */
		static function html( $meta, $field )
		{
			$html = sprintf('<div class="rwmb-timeline">');
			$html .= sprintf(
				'<input type="text" placeholder="' . $field['datetime_holder'] . '" class="rwmb-timeline-text" name="%s[date]" value="%s" />',
				$field['field_name'],
				isset($meta['date']) ? $meta['date'] : ''
			);
			$html .= sprintf(
				'<textarea cols="60" rows="3" placeholder="' . $field['information_holder'] . '" class="rwmb-timeline-textarea" name="%s[information]">%s</textarea>',
				// '<input type="text" class="rwmb-text" name="%s[information]" value="%s" />',
				$field['field_name'],
				isset($meta['information']) ? $meta['information'] : ''
			);

			$html .= '</div>';
			return $html;
		}

	}
}

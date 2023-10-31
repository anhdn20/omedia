<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'RWMB_Video_Url_Field' ) )
{
	class RWMB_Video_Url_Field extends RWMB_Field
	{
		static function admin_enqueue_scripts()
		{
			wp_enqueue_style( 'rwmb-video-url', PLUGIN_HARU_CIRCLE_CORE_URL . '/includes/metabox-extensions/custom-fields/assets/css/video-url.css', array() );
			wp_enqueue_script( 'rwmb-video-url', PLUGIN_HARU_CIRCLE_CORE_URL . '/includes/metabox-extensions/custom-fields/assets/js/video-url.js', array() );
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
			$html = sprintf('<div class="rwmb-video-url">');
			$html .= sprintf(
				'<input type="text" placeholder="' . $field['mp4_holder'] . '" class="rwmb-video-url-text" name="%s[mp4]" value="%s" />',
				$field['field_name'],
				isset($meta['mp4']) ? $meta['mp4'] : ''
			);
			$html .= sprintf(
				'<input type="text" placeholder="' . $field['webm_holder'] . '" class="rwmb-video-url-text" name="%s[webm]" value="%s" />',
				$field['field_name'],
				isset($meta['webm']) ? $meta['webm'] : ''
			);

			$html .= '</div>';
			return $html;
		}

	}
}

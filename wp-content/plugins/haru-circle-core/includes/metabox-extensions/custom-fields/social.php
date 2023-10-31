<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'RWMB_Social_Field' ) )
{
	class RWMB_Social_Field extends RWMB_Field
	{
		static function admin_enqueue_scripts()
		{
			wp_enqueue_style( 'rwmb-social', PLUGIN_HARU_CIRCLE_CORE_URL . '/includes/metabox-extensions/custom-fields/assets/css/social.css', array() );
			wp_enqueue_script( 'rwmb-social', PLUGIN_HARU_CIRCLE_CORE_URL . '/includes/metabox-extensions/custom-fields/assets/js/social.js', array() );
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

			$html = sprintf('<div class="rwmb-social">');
			$html .= sprintf(
				'<input type="text" placeholder="' . $field['network_holder'] . '" class="rwmb-social-text" name="%s[network]" value="%s" />',
				$field['field_name'],
				isset($meta['network']) ? $meta['network'] : ''
			);
			$html .= sprintf(
				'<input type="text" placeholder="' . $field['url_holder'] . '" class="rwmb-social-text" name="%s[url]" value="%s" />',
				$field['field_name'],
				isset($meta['url']) ? $meta['url'] : ''
			);
			$html .= sprintf(
				'<input type="text" placeholder="' . $field['icon_holder'] . '" class="rwmb-social-text" name="%s[icon]" value="%s" />',
				$field['field_name'],
				isset($meta['icon']) ? $meta['icon'] : ''
			);

			$html .= '</div>';
			return $html;
		}

	}
}

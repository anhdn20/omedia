<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'RWMB_Videos_Field' ) )
{
	class RWMB_Videos_Field extends RWMB_Field
	{
		static function admin_enqueue_scripts()
		{
			wp_enqueue_style( 'rwmb-videos', PLUGIN_HARU_CIRCLE_CORE_URL . '/includes/metabox-extensions/custom-fields/assets/css/videos.css', array() );
			wp_enqueue_script( 'rwmb-select', RWMB_JS_URL . 'select.js', array( 'jquery' ), RWMB_VER, true );
			wp_enqueue_script( 'rwmb-videos', PLUGIN_HARU_CIRCLE_CORE_URL . '/includes/metabox-extensions/custom-fields/assets/js/videos.js', array() );
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

			$html = sprintf('<div class="rwmb-videos">');
			$html .= sprintf(
				'<input type="text" placeholder="' . $field['title_holder'] . '" class="rwmb-videos-text episode-title" name="%s[video_title]" value="%s" />',
				$field['field_name'],
				isset($meta['video_title']) ? $meta['video_title'] : ''
			);
			$html .= sprintf(
				'<div class="video-server"><input type="text" placeholder="' . $field['youtube_holder'] . '" class="rwmb-videos-text video-title" name="%s[title_server1]" value="%s" />',
				$field['field_name'],
				isset($meta['title_server1']) ? $meta['title_server1'] : ''
			);

			$html .= sprintf(
                '<input type="text" placeholder="' . $field['youtube_id_holder'] . '" class="rwmb-videos-text video-link" name="%s[link_server1]" value="%s" /></div>',
				$field['field_name'],
				isset($meta['link_server1']) ? $meta['link_server1'] : ''
				);

			// Server 2
			$html .= sprintf(
				'<div class="video-server"><input type="text" placeholder="' . $field['vimeo_holder'] . '" class="rwmb-videos-text video-title" name="%s[title_server2]" value="%s" />',
				$field['field_name'],
				isset($meta['title_server2']) ? $meta['title_server2'] : ''
			);

			$html .= sprintf(
                '<input type="text" placeholder="' . $field['vimeo_id_holder'] . '" class="rwmb-videos-text video-link" name="%s[link_server2]" value="%s" /></div>',
                $field['field_name'],
                isset($meta['link_server2']) ? $meta['link_server2'] : ''
                );

			// Server 3
			$html .= sprintf(
				'<div class="video-server"><input type="text" placeholder="' . $field['local_holder'] . '" class="rwmb-videos-text video-title" name="%s[title_server3]" value="%s" />',
				$field['field_name'],
				isset($meta['title_server3']) ? $meta['title_server3'] : ''
			);

			$html .= sprintf(
                '<input type="text" placeholder="' . $field['mp4_holder'] . '" class="rwmb-videos-text video-link" name="%s[link_server3_mp4]" value="%s" />',
                $field['field_name'],
                isset($meta['link_server3_mp4']) ? $meta['link_server3_mp4'] : ''
                );

            $html .= sprintf(
                '<input type="text" placeholder="' . $field['webm_holder'] . '" class="rwmb-videos-text video-link" name="%s[link_server3_webm]" value="%s" /></div>',
                $field['field_name'],
                isset($meta['link_server3_webm']) ? $meta['link_server3_webm'] : ''
                );

      		// Server 4
			$html .= sprintf(
				'<div class="video-server"><input type="text" placeholder="' . $field['dailymotion_holder'] . '" class="rwmb-videos-text video-title" name="%s[title_server4]" value="%s" />',
				$field['field_name'],
				isset($meta['title_server4']) ? $meta['title_server4'] : ''
			);

			$html .= sprintf(
                '<input type="text" placeholder="' . $field['dailymotion_id_holder'] . '" class="rwmb-videos-text video-link" name="%s[link_server4]" value="%s" /></div>',
                $field['field_name'],
                isset($meta['link_server4']) ? $meta['link_server4'] : ''
                );

			// Server 5
			$html .= sprintf(
				'<div class="video-server"><input type="text" placeholder="' . $field['twitch_holder'] . '" class="rwmb-videos-text video-title" name="%s[title_server5]" value="%s" />',
				$field['field_name'],
				isset($meta['title_server5']) ? $meta['title_server5'] : ''
			);

			$html .= sprintf(
                '<input type="text" placeholder="' . $field['twitch_id_holder'] . '" class="rwmb-videos-text video-link" name="%s[link_server5]" value="%s" /></div>',
                $field['field_name'],
                isset($meta['link_server5']) ? $meta['link_server5'] : ''
                );

			// Server 6
			$html .= sprintf(
				'<div class="video-server"><input type="text" placeholder="' . $field['facebook_holder'] . '" class="rwmb-videos-text video-title" name="%s[title_server6]" value="%s" />',
				$field['field_name'],
				isset($meta['title_server6']) ? $meta['title_server6'] : ''
			);

			$html .= sprintf(
                '<input type="text" placeholder="' . $field['facebook_id_holder'] . '" class="rwmb-videos-text video-link" name="%s[link_server6]" value="%s" /></div>',
                $field['field_name'],
                isset($meta['link_server6']) ? $meta['link_server6'] : ''
                );

			$html .= '</div>';
			return $html;
		}

		/**
		 * Creates html for options
		 *
		 * @param array $field
		 * @param mixed $meta
		 *
		 * @return array
		 */
		static function options_html( $field, $meta, $current_server )
		{	
			$field['options'] = self::get_video_posts();

			$html = '';
			$html .= '<option value="">'. esc_html__( 'Select Video', 'haru-circle' ) .'</option>';
			$option = '<option value="%s" %s>%s</option>';

			foreach ( $field['options'] as $value => $label ) {
				$html .= sprintf(
					$option,
					$value,
					selected( ( $value == (int)$current_server ), true, false ),
					$label
				);
			}

			return $html;
		}

		// Get Videos to render
		static function get_video_posts() {
			$video = array();
            $args = array(
                'posts_per_page'   => -1,
                'post_type'        => 'haru_video',
                'post_status'      => 'publish',
            );
            $posts_array = get_posts( $args );
            foreach ( $posts_array as $k => $v ) {
                $video[$v->ID] = $v->post_title;
            }

            return $video;
		}

	}
}

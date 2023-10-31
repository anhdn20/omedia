<?php

	if (!defined('ABSPATH')) {
		exit; // Exit if access directly
	}

	if ( ! function_exists( 'haru_variation_styling' ) ):

		function haru_variation_styling() {

			$fields = array();

			$fields[ 'color' ] = array(
				array(
					'label' => esc_html__( 'Color', 'haru-circle' ), // <label>
					'desc'  => esc_html__( 'Choose a color', 'haru-circle' ), // description
					'id'    => 'product_attribute_color', // name of field
					'type'  => 'color'
				)
			);

			$fields[ 'image' ] = array(
				array(
					'label' => esc_html__( 'Image', 'haru-circle' ), // <label>
					'desc'  => esc_html__( 'Choose a Image', 'haru-circle' ), // description
					'id'    => 'product_attribute_image', // name of field
					'type'  => 'image'
				)
			);
			$fields[ 'label' ] = array(
				array(
					'label' => esc_html__( 'Label', 'haru-circle' ), // <label>
					'desc'  => esc_html__( 'The text of label (should be same as name)', 'haru-circle' ), // description
					'id'    => 'product_attribute_label', // name of field
					'type'  => 'text'
				)
			);

			if ( function_exists( 'wc_get_attribute_taxonomies' ) ):

				$attribute_taxonomies = wc_get_attribute_taxonomies();
				if ( $attribute_taxonomies ) :
					foreach ( $attribute_taxonomies as $tax ) :
						$product_attr      = wc_attribute_taxonomy_name( $tax->attribute_name );
						$product_attr_type = $tax->attribute_type;
						if ( in_array( $product_attr_type, array( 'color', 'image', 'label' ) ) ) :
							new Haru_Term_Meta( $product_attr, 'product', $fields[ $product_attr_type ] );
						endif; //  in_array( $product_attr_type, array( 'color', 'image' ) )
					endforeach; // $attribute_taxonomies
				endif; // $attribute_taxonomies
			endif; // function_exists( 'wc_get_attribute_taxonomies' )

		}

		add_action( 'admin_init', 'haru_variation_styling' );

	endif;

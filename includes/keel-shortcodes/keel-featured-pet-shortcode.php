<?php

	/**
	 * Add a shortcode for svg icons
	 */
	
	class Featured_Pet {
	
		private static $options;
		
		private $type;

		function keel_featured_pet_shortcode( $atts ) {

			$atts = shortcode_atts( array(
			'type' => 'small'
				), $atts );
			$this->type = $atts['type'];

			$featured_pets = get_option( 'keel_featured_pet_selections', '');

			if(isset($featured_pets['featured_pet_details']['name']) && $featured_pets['featured_pet_details']['name'] != ''):
				return $this->generate_pet($featured_pets['featured_pet_details'], $featured_pets['featured_pet_post_id']);
			elseif(isset($featured_pets['featured_pet_details']['name']) && $featured_pets['featured_pet_details']['name'] != ''):
				return $this->generate_pet($featured_pets['featured_pet_backup_details'], $featured_pets['featured_pet_backup_post_id']);
			endif;
			
			//TODO Show oldest pet listing
			return "Nothing to see here, folks.";

		}
		
		private function generate_pet($pet, $pet_post_id) {
		
			$return = '<article class="container">';

			$return .= '<h2 class="featured-pet-name">' . '<a class="keel-featured-pet" href="'.get_post_permalink($pet_post_id).'">' .
									$pet['name'] . '</a></h2>';
									
			if ($this->type == "full"):
				$img = get_post_meta( $pet_post_id, 'keel_pet_listings_pet_imgs', true ); // All Images for this pet
			else:
				$img = get_post_meta( $pet_post_id, 'keel_pet_listings_single_img', true ); // Single Image
			endif;
			
			// Pet image
			if ( !empty( $img ) ) {
				if ($this->type == "full"):
					$return .= $img;
				else:
					$return .= '<a class="keel-featured-pet" href="'.get_post_permalink($pet[$pet_post_id]).'">'.$img.'</a>';
				endif;
			}

			// Key pet info
			$return .= '<ul class="list-unstyled">' .
			'<li><strong>' . __( 'Size', 'keel' ) . '</strong> ' . esc_attr( $pet['size'] ) .'</li>' .
			'<li><strong>' . __( 'Age', 'keel' ) . '</strong> ' . esc_attr( $pet['age'] ) .'</li>' .
			'<li><strong>' . __( 'Gender', 'keel' ) . '</strong> ' . esc_attr( $pet['gender'] ) .'</li>' .
			'<li><strong>' . __( 'Breeds', 'keel' ) . '</strong> ' . esc_attr( $pet['breeds'] ) .'</li>';
			if(!empty( $pet['options']['multi'] ))
				$return .= '<li><em>' . esc_attr( $pet['options']['multi'] ) . '</em></li>';
			if (!empty( $pet['options']['special_needs'] ))
				$return .= '<li><em>' . esc_attr( $pet['options']['special_needs'] ) . '</em></li>' .
			$return .= '</ul>';

			// The page or post content
			$return .= $pet['description'];

			$return .= '</article>';
			
			return $return;
				
		}
		
		// Changing excerpt more
    function featured_pet_excerpt_more($more) {
    	global $post;
    	return '… <a href="'. get_permalink($post->ID) . '">' . 'learn more &raquo;' . '</a>';
    }
    
    
		function title_filter( $where, &$wp_query )
			{
					global $wpdb;
					if ( $search_term = $wp_query->get( 'search_pet_title' ) ) {
							$where .= ' AND ' . $wpdb->posts . '.post_title = \'' . esc_sql( $this->featured_pet ) . '\'';
					}
					return $where;
			}
		
	} // End Featured_Pet object
	
	$featured_pet = new Featured_Pet();
	add_shortcode( 'featured-pet', array($featured_pet,'keel_featured_pet_shortcode') );
	add_filter('excerpt_more', array($featured_pet, 'featured_pet_excerpt_more'));
	
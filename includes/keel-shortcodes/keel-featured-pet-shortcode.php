<?php

	/**
	 * Add a shortcode for svg icons
	 */
	
	class Featured_Pet {
	
		private static $options;
		private $featured_pet;
		private $featured_pet_backup;

		function keel_featured_pet_shortcode( $atts ) {

			$atts = shortcode_atts( array(
			'type' => 'small'
				), $atts );
		$type = $atts['type'];

			global $wp_query, $post;
			
			$featured_pets = get_option( 'keel_featured_pet_selections' );
			
			$this->featured_pet = $featured_pets['featured_pet'];
			$this->featured_pet_backup = $featured_pets['featured_pet_backup'];

			$args = array(
					'posts_per_page' => 1,
					'search_pet_title' => $this->featured_pet,
					'post_status' => 'publish',
					'orderby'     => 'title',
					'order'       => 'ASC',
					'post_type' => 'keel-pets'
			);

			add_filter( 'posts_where', array($this, 'title_filter'), 10, 2 );
			$my_query = new WP_Query($args);
			if ($my_query->have_posts() == true) {
				while ($my_query->have_posts()) : $my_query->the_post();
					setup_postdata($post);
					$fpw_queried_id = get_the_ID();
				endwhile;
			} else {
				$args['search_pet_title'] = $this->featured_pet_backup;
				$this->featured_pet = $instance['featured_pet_backup'];
				$my_query = new WP_Query($args);
				while ($my_query->have_posts()) : $my_query->the_post();
					setup_postdata($post);
					$fpw_queried_id = get_the_ID();
				endwhile;
			}
			if ($my_query->have_posts() == false) {
				unset($args['search_pet_title']);
				$my_query = new WP_Query($args);
				while ($my_query->have_posts()) : $my_query->the_post();
					setup_postdata($post);
					$fpw_queried_id = get_the_ID();
				endwhile;
			}
			remove_filter( 'posts_where', array($this, 'title_filter'), 10, 2 );

			wp_reset_postdata();

				$fpw_args = array(
					'posts_per_page' => 1,
					'p' => $fpw_queried_id,
					'post_type' => 'keel-pets',
					'order' => 'ASC'
				);

			/* Generate Featured Pet Display */

			$fpw_posts = new WP_Query($fpw_args);

			while ($fpw_posts->have_posts()) :

				$fpw_posts->the_post();

				setup_postdata($post);

		// Variables
		$options = keel_pet_listings_get_theme_options(); // Pet Listings options
		$details = get_post_meta( $post->ID, 'keel_pet_listings_pet_details', true ); // Details for this pet
		
		if ($type == "full"):
			$img = get_post_meta( $post->ID, 'keel_pet_listings_pet_imgs', true ); // All Images for this pet
		else:
			$img = get_post_meta( $post->ID, 'keel_pet_listings_single_img', true ); // Single Image
		endif;
		
		$return = '<article class="container">';

		$return .= '<h2 class="featured-pet-name">' . '<a class="keel-featured-pet" href="'.get_the_permalink().'">' .
								get_the_title() . '</a></h2>';

				// Pet image
				if ( !empty( $img ) ) {
					if ($type == "full"):
						$return .= $img;
					else:
						$return .= '<a class="keel-featured-pet" href="'.get_the_permalink().'">'.$img.'</a>';
					endif;
				}
		
				// Key pet info
			$return .= '<ul class="list-unstyled">' .
				'<li><strong>' . __( 'Size', 'keel' ) . '</strong> ' . esc_attr( $details['size'] ) .'</li>' .
				'<li><strong>' . __( 'Age', 'keel' ) . '</strong> ' . esc_attr( $details['age'] ) .'</li>' .
				'<li><strong>' . __( 'Gender', 'keel' ) . '</strong> ' . esc_attr( $details['gender'] ) .'</li>' .
				'<li><strong>' . __( 'Breeds', 'keel' ) . '</strong> ' . esc_attr( $details['breeds'] ) .'</li>';
				if(!empty( $details['options']['multi'] ))
					$return .= '<li><em>' . esc_attr( $details['options']['multi'] ) . '</em></li>';
				if (!empty( $details['options']['special_needs'] ))
					$return .= '<li><em>' . esc_attr( $details['options']['special_needs'] ) . '</em></li>' .
			$return .= '</ul>';

				// The page or post content
				$return .= get_the_excerpt();

				$return .= '</article>';

			endwhile;
			
			// Restore original Post Data
			wp_reset_postdata();
						
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
	
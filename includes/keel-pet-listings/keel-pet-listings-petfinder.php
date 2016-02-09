<?php

/**
 * Get Pets from Petfinder API
 * @link https://www.petfinder.com/developers/api-docs
 */


	// Load required files
	require_once( dirname( __FILE__) . '/fastimage.php' );



	// Default settings
	function keel_petfinder_api_get_settings() {
		return array(

			// Lists & Checkboxes
			'class_prefix' => 'pf-',
			'toggle_all' => 'Select/Unselect All',

			// Pet photos
			'no_image' => '',

			// Animal Text
			'animal_unknown' => '',

			// Breeds Text
			'breed_delimiter' => ', ',

			// Size Text
			'size_unknown' => 'Not Known',
			'size_s' => 'Small',
			'size_m' => 'Medium',
			'size_l' => 'Large',
			'size_xl' => 'Extra Large',

			// Age Text
			'age_unknown' => 'Not Known',
			'age_baby' => 'Baby',
			'age_young' => 'Young',
			'age_adult' => 'Adult',
			'age_senior' => 'Senior',

			// Gender Text
			'sex_unknown' => 'Not Known',
			'sex_m' => 'Male',
			'sex_f' => 'Female',

			// Options Text
			'options_specialNeeds' => 'Special Needs',
			'options_noDogs' => 'No Dogs',
			'options_noCats' => 'No Cats',
			'options_noKids' => 'No Kids',
			'options_noClaws' => 'No Claws',
			'options_hasShots' => 'Has Shots',
			'options_housetrained' => 'Housebroken',
			'options_altered' => 'Spayed/Neutered',

			// Multi-Option Text
			'options_no_dogs_cats_kids' => 'No Dogs/Cats/Kids',
			'options_no_dogs_cats' => 'No Dogs/Cats',
			'options_no_dogs_kids' => 'No Dogs/Kids',
			'options_no_cats_kids' => 'No Cats/Kids',

			// Contact Info Missing Text
			'contact_name' => '',
			'contact_email' => '',
			'contact_phone' => '',
			'contact_address1' => '',
			'contact_address2' => '',
			'contact_city' => '',
			'contact_state' => '',
			'contact_zip' => '',
			'contact_fax' => '',
		);
	}



	/**
	 * Get dimensions of remote images
	 * @param  String $url The image URL
	 * @return Array       Image height and width
	 * @link http://stackoverflow.com/a/4635991
	 */
	function keel_petfinder_api_get_image_dimensions( $url = null ) {

		if ( empty($url) ) return;

		// Get image dimensions
		$image = new FastImage( $url );
		list($width, $height) = $image->getSize();

		return array(
			'height' => $height,
			'width' => $width,
		);

	}



	/**
	 * Get pet options
	 * @param  Array  $pet     The pet data
	 * @param  String $option  The option you want the value of
	 * @param  String $value   The default value
	 * @return String          The option value
	 */
	function keel_petfinder_api_get_pet_option( $pet, $option, $value ) {
		if ( !array_key_exists( 'options', $pet ) || !array_key_exists( 'option', $pet['options'] ) || empty( $pet['options']['option'] ) ) return;
		foreach ( $pet['options']['option'] as $opt ) {
			if ( is_array( $opt ) ) {
				$opt = $opt['$t'];
			}
			if ( $opt === $option && !empty($opt) ) {
				return $value;
			}
		}
	}



	/**
	 * Get pet attribute
	 * @param  Array  $pet   The pet data
	 * @param  String $type  The attribute type
	 * @param  String $start Default attribute value
	 * @return String        The attribute
	 */
	function keel_petfinder_api_get_pet_attribute( $pet, $type, $start = '' ) {

		$settings = keel_petfinder_api_get_settings();

		// Set default value
		$attribute = $start;

		// Sanitize description and add links
		if ( $type === 'description' ) {
			$attribute = keel_petfinder_api_sanitize_description( $pet['description']['$t'] );
			$attribute = keel_petfinder_api_linkify( $attribute );
		}

		// Generate string of breeds, separated by a delimiter
		elseif ( $type === 'breeds' ) {
			if ( !is_array( $pet['breeds']['breed'] ) ) {
				$attribute = $pet['breeds']['breed']['$t'];
			} else {
				$first = true;
				foreach ( $pet['breeds']['breed'] as $breed ) {
					$attribute .= $first ? '' : $settings['breed_delimiter'];
					$attribute .= is_array( $breed ) && array_key_exists( '$t', $breed ) ? $breed['$t'] : $breed;
					$first = false;
				}
			}
		}

		// Generate an array of all options
		elseif ( $type === 'options' ) {
			if ( array_key_exists( 'option', $pet['options'] ) ) {
				$attribute = array();
				foreach ( $pet['options']['option'] as $opt ) {
					$attribute[] .= is_array( $opt ) && array_key_exists( '$t', $opt ) && !empty( $opt['$t'] ) ? keel_petfinder_api_get_pet_option( $pet, $opt['$t'], $settings['options_' . $opt['$t']]) : keel_petfinder_api_get_pet_option( $pet, $opt, $settings['options_' . $opt]);
				}
			}
		}

		// Translate pet size, age, and gender into human-readable format
		elseif ( in_array( $type, array( 'size', 'age', 'sex' ) ) && array_key_exists( $type, $pet ) ) {
			$attribute =  array_key_exists( '$t', $pet[$type] ) ? $settings[$type . '_' . strtolower($pet[$type]['$t'])] : $pet[$type];
		}

		// Translate animals into human-readable form
		// @todo translate animal names
		elseif ( $type === 'animal' ) {
			$attribute = $pet['animal']['$t'] === 'unknown' ? $settings['animal_unknown'] : $pet['animal']['$t'];
		}

		// Generate a string of options
		elseif ( $type === 'multi_options' ) {

			// Sanity check
			if ( !array_key_exists( 'options', $pet ) || !array_key_exists( 'option', $pet['options'] ) || empty( $pet['options']['option'] ) ) return;

			// Get options
			$no_cats = false;
			$no_dogs = false;
			$no_kids = false;
			foreach ( $pet['options']['option'] as $opt ) {
				if ( is_array( $opt ) ) {
					$opt = $opt['$t'];
				}
				if ( $opt === 'noCats' ) { $no_cats = true; }
				elseif ( $opt === 'noDogs' ) { $no_dogs = true; }
				elseif ( $opt === 'noKids' ) { $no_kids = true; }
			}

			// Create content for pet options section
			if ( $no_cats && $no_dogs && $no_kids ) { $attribute = $settings['options_no_dogs_cats_kids']; }
			elseif ( $no_cats && $no_dogs ) { $attribute = $settings['options_no_dogs_cats']; }
			elseif ( $no_dogs && $no_kids ) { $attribute = $settings['options_no_dogs_kids']; }
			elseif ( $no_cats && $no_kids ) { $attribute = $settings['options_no_cats_kids']; }
			elseif ( $no_dogs ) { $attribute = $settings['options_noDogs']; }
			elseif ( $no_cats ) { $attribute = $settings['options_noCats']; }
			elseif ( $no_kids ) { $attribute = $settings['options_noKids']; }
		}

		// Convert all other codes into human readable format
		else {
			$attribute = keel_petfinder_api_get_pet_option( $pet, $type, $settings['options_' . $type] );
		}

		return $attribute;

	}



	/**
	 * Get pet photo URLs
	 * @param  Array  $pet   The pet data
	 * @param  String  $size The image size to retrieve
	 * @param  Integer $num  The image number to return (1 - 3)
	 * @return String        The image URL
	 */
	function keel_petfinder_api_get_pet_photo( $pet, $size = 'medium', $num = 1 ) {

		$settings = keel_petfinder_api_get_settings();

		// If pet has no photos, end method
		if ( count( $pet['media']['photos']['photo'] ) === 0 ) return $settings['no_image'];

		// Variables
		$image = $settings['no_image'];
		if ( $size === 'large' ) { $quality = 'x'; }
		if ( $size === 'medium' ) { $quality = 'pn'; }
		if ( $size === 'thumb_small' ) { $quality = 't'; }
		if ( $size === 'thumb_medium' ) { $quality = 'pnt'; }
		if ( $size === 'thumb_large' ) { $quality = 'fpm'; }

		// Loop through available photos until finding a match
		$image = $pet['media']['photos']['photo'][0]['$t'];
		foreach ( $pet['media']['photos']['photo'] as $photo ) {
			if ( $photo['@size'] === $quality && intval( $photo['@id'] ) === intval( $num ) ) {
				$image = $photo['$t'];
				break;
			}
		}

		return $image;

	}



	/**
	 * Get pet contact info
	 * @param  Array  $pet   The pet data
	 * @param  String $type  Type of contact info to get
	 * @return String        The contact info
	 */
	function keel_petfinder_api_get_pet_contact( $pet, $type ) {
		$settings = keel_petfinder_api_get_settings();
		$info = array_key_exists( $type, $pet['contact'] ) && array_key_exists( '$t', $pet['contact'][$type] ) ? $pet['contact'][$type]['$t'] : $settings['contact_' . $type];
		return $info;
	};



	/**
	 * Add links to pet description
	 * @param  String $value      The description
	 * @param  Array  $protocols  Protocols to look for
	 * @param  Array  $attributes
	 * @return String             Linkified description
	 * @link   https://gist.github.com/jasny/2000705
	 */
	function keel_petfinder_api_linkify( $value, $protocols = array('http', 'https', 'mail'), array $attributes = array() ) {

		// Link attributes
		$attr = '';
		foreach ($attributes as $key => $val) {
			$attr = ' ' . $key . '="' . htmlentities($val) . '"';
		}
		$links = array();

		// Extract existing links and tags
		$value = preg_replace_callback( '~(<a .*?>.*?</a>|<.*?>)~i', function ($match) use (&$links) { return '<' . array_push($links, $match[1]) . '>'; }, $value );

		// Extract text links for each protocol
		foreach ( (array)$protocols as $protocol ) {
			switch ( $protocol ) {
				case 'http':
				case 'https':   $value = preg_replace_callback('~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) { if ($match[1]) $protocol = $match[1]; $link = $match[2] ?: $match[3]; return '<' . array_push($links, "<a $attr href=\"$protocol://$link\">$link</a>") . '>'; }, $value); break;
				case 'mail':    $value = preg_replace_callback('~([^\s<]+?@[^\s<]+?\.[^\s<]+)(?<![\.,:])~', function ($match) use (&$links, $attr) { return '<' . array_push($links, "<a $attr href=\"mailto:{$match[1]}\">{$match[1]}</a>") . '>'; }, $value); break;
				case 'twitter': $value = preg_replace_callback('~(?<!\w)[@#](\w++)~', function ($match) use (&$links, $attr) { return '<' . array_push($links, "<a $attr href=\"https://twitter.com/" . ($match[0][0] == '@' ? '' : 'search/%23') . $match[1]  . "\">{$match[0]}</a>") . '>'; }, $value); break;
				default:        $value = preg_replace_callback('~' . preg_quote($protocol, '~') . '://([^\s<]+?)(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) { return '<' . array_push($links, "<a $attr href=\"$protocol://{$match[1]}\">{$match[1]}</a>") . '>'; }, $value); break;
			}
		}

		// Insert all link
		return preg_replace_callback('/<(\d+)>/', function ($match) use (&$links) { return $links[$match[1] - 1]; }, $value);

	}



	/**
	 * Remove unwanted characters from the pet description
	 * @param  String $text Description to sanitize
	 * @return String       Sanitized description
	 */
	function keel_petfinder_api_sanitize_description( $text ) {
		if ( !$text || empty( $text ) ) return;

		// Things to look for
		$patterns = array(
			'/<p><\/p>/',
			'/<p> <\/p>/',
			'/<p>&nbsp;<\/p>/',
			'/&nbsp;/',
			'/<span>/',
			'/<\/span>/',
			'/<font>/',
			'/<\/font>/',
		);

		// Things to replace them with
		$replacements = array(
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
		);

		// Sanitize text
		return preg_replace( $patterns, $replacements, $text );

	}



	/**
	 * Remove whitespace from a string
	 * @param  String         $text    String to condense
	 * @param  Boolean|String $prefix  If string, use as a prefix on the output
	 * @return String                  Condensed string
	 */
	function keel_petfinder_api_condense_string( $text, $prefix = false ) {

		$settings = keel_petfinder_api_get_settings();

		if ( !$text || empty( $text ) ) return;

		// If prefix is true, add it
		if ( $prefix ) $text = $settings['class_prefix'] . $text;

		// Things to look for
		$patterns = array(
			'/\(/',
			'/\)/',
			'/\&/',
			'/\//',
			'/ /',
		);

		// Things to replace them with
		$replacements = array(
			'',
			'',
			'',
			'',
			'',
		);

		// Condense text
		return preg_replace( $patterns, $replacements, $text );

	}



	/**
	 * Remove whitespace from all values in an array
	 * @param  Array          $arr     The array
	 * @param  Boolean|String $prefix  If a string, use as a prefix on the output
	 * @return String                  Condensed values
	 */
	function keel_petfinder_api_condense_array( $arr, $prefix = false ) {
		$text = '';
		foreach ( $arr as $value ) {
			$text .= ' ' . keel_petfinder_api_condense_string( is_array( $value ) && array_key_exists( '$t', $value ) ? $value['$t'] : $value, $prefix );
		}
		return $text;
	};



	/**
	 * Get the breeds of a pet
	 * @param  Array          $pet     The pet data
	 * @param  Boolean|String $prefix  If a string, use as a prefix on the output
	 * @return Array                   An array of breeds
	 */
	function get_breeds( $pet, $prefix = false ) {
		$breeds = array();
		if ( !is_array( $pet['breeds']['breed'] ) ) {
			$breeds[] = $pet['breeds']['breed']['$t'];
		} else {
			foreach ( $pet['breeds']['breed'] as $breed ) {
				$breeds[] = is_array( $breed ) && array_key_exists( '$t', $breed ) ? $breed['$t'] : $breed;
			}
		}
		return $breeds;
	}



	/**
	 * Create a string of classes for a pet
	 * @param  Array  $pet  The pet data
	 * @return String       The classes
	 */
	function keel_petfinder_api_get_pet_classes( $pet ) {
		$settings = keel_petfinder_api_get_settings();

		$classes = array(
			$settings['class_prefix'] . 'pet',
			keel_petfinder_api_condense_string( keel_petfinder_api_get_pet_attribute( $pet, 'age', $settings['age_unknown'] ), true ),
			keel_petfinder_api_condense_string( $pet['animal']['$t'], true ),
			keel_petfinder_api_condense_array( get_breeds( $pet, true ), true ),
			keel_petfinder_api_condense_string( keel_petfinder_api_get_pet_attribute( $pet, 'specialNeeds', '' ), true ),
			keel_petfinder_api_condense_string( keel_petfinder_api_get_pet_attribute( $pet, 'noDogs', '' ), true ),
			keel_petfinder_api_condense_string( keel_petfinder_api_get_pet_attribute( $pet, 'noCats', '' ), true ),
			keel_petfinder_api_condense_string( keel_petfinder_api_get_pet_attribute( $pet, 'noKids', '' ), true ),
			keel_petfinder_api_condense_string( keel_petfinder_api_get_pet_attribute( $pet, 'noClaws', '' ), true ),
			keel_petfinder_api_condense_string( keel_petfinder_api_get_pet_attribute( $pet, 'hasShots', '' ), true ),
			keel_petfinder_api_condense_string( keel_petfinder_api_get_pet_attribute( $pet, 'housetrained', '' ), true ),
			keel_petfinder_api_condense_string( keel_petfinder_api_get_pet_attribute( $pet, 'altered', '' ), true ),
			keel_petfinder_api_condense_string( keel_petfinder_api_get_pet_attribute( $pet, 'sex', $settings['sex_unknown'] ), true ),
			keel_petfinder_api_condense_string( keel_petfinder_api_get_pet_attribute( $pet, 'size', $settings['size_unknown'] ), true )
		);

		return implode( ' ', $classes );
	}



	/**
	 * Create an array of existing attributes for pets
	 * @param  Array  $pets   The pet data
	 * @param  String $type   Attribute to create a list for
	 * @param  String $start  Default value
	 * @return Array          Pet attributes
	 */
	function keel_petfinder_api_create_list( $pets, $type, $start = '' ) {

		$settings = keel_petfinder_api_get_settings();

		// Variables
		$list = array();
		$listTemp = array();

		// Loop through pet attributes and push unique attributes to an array
		foreach ( $pets as $pet ) {

			// Get attribute in human-readable form
			$attribute = $type === 'breeds' ? get_breeds( $pet ) : keel_petfinder_api_get_pet_attribute( $pet, $type, $start );

			// If list type is breeds or options
			if ( in_array( $type, array( 'breeds', 'options' ) ) ) {
				if ( is_array( $attribute ) ) {
					foreach ( $attribute as $att ) {
						if ( !in_array( $att, $list ) ) {
							$list[] = $att;
						}
					}
				}
			}

			// Otherwise, add to array if not already there
			elseif ( !in_array( $attribute, $list ) ) {
				$list[] = $attribute;
			}
		}

		// Sort list alphabetically
		sort( $list );

		// If creating list of sizes, sort smallest to largest
		if ( $type === 'size' ) {
			if ( in_array( $settings['size_s'], $list ) ) $listTemp[] = $settings['size_s'];
			if ( in_array( $settings['size_m'], $list ) ) $listTemp[] = $settings['size_m'];
			if ( in_array( $settings['size_l'], $list ) ) $listTemp[] = $settings['size_l'];
			if ( in_array( $settings['size_xl'], $list ) ) $listTemp[] = $settings['size_xl'];
			$list = $listTemp;
		}

		// If creating a list of ages, sort youngest to oldest
		if ( $type === 'age' ) {
			if ( in_array( $settings['age_baby'], $list ) ) $listTemp[] = $settings['age_baby'];
			if ( in_array( $settings['age_young'], $list ) ) $listTemp[] = $settings['age_young'];
			if ( in_array( $settings['age_adult'], $list ) ) $listTemp[] = $settings['age_adult'];
			if ( in_array( $settings['age_senior'], $list ) ) $listTemp[] = $settings['age_senior'];
			$list = $listTemp;
		}

		return $list;
	}



	/**
	 * Create a set of list items for all pets
	 * @param  Array  $pets  The pet data
	 * @param  String $type  The attribute to create the list for
	 * @param  String $start The default value
	 * @return String        The list items
	 */
	function keel_petfinder_api_create_list_items( $pets, $type, $start = '' ) {

		// Variables
		$markup = '';
		$list_items = keel_petfinder_api_create_list( $pets, $type, $start );

		// Create a list item for each attribute
		if ( !is_array( $list_items ) ) return $markup;
		foreach ( $list_items as $item ) {
			if ( empty( $item ) ) continue;
			$markup .= '<li>' . $item . '</li>';
		}

		return $markup;
	}



	/**
	 * Create checkboxes for all pets
	 * @param  Array  $pets    The pet data
	 * @param  String  $type   The type of attribute to create checkboxes for
	 * @param  String  $start  The default value
	 * @param  Boolean $toggle If true, add a "toggle all" checkbox
	 * @return String          The checkboxes
	 */
	function keel_petfinder_api_create_checkboxes( $pets, $type, $start = '', $toggle = false ) {

		$settings = keel_petfinder_api_get_settings();

		// Variables
		$markup = '';
		$toggle_all = '';
		$sort = $type === 'breeds' ? 'breeds' : 'attributes';
		$list_items = keel_petfinder_api_create_list( $pets, $type, $start );

		// For each attribute, create a checkbox
		if ( !is_array( $list_items ) ) return $markup;
		foreach ( $list_items as $item ) {
			$target = keel_petfinder_api_condense_string( $item, true );
			$markup .=
				'<label>' .
					'<input type="checkbox" data-petfinder-sort="' . $sort . '" data-petfinder-sort-type="' . $type . '" data-petfinder-sort-target=".' . $target . '" checked> ' .
					$item .
				'</label>';
		}

		// Add select/unselect all toggle if enabled
		if ( $toggle ) {
			$toggle_all =
				'<label>' .
					'<input type="checkbox" data-petfinder-sort="toggle" data-petfinder-sort-target="[data-petfinder-sort-type=' . $type . ']" checked> ' .
					$settings['toggle_all'] .
				'</label>';
		}

		return $toggle_all . $markup;

	}



	/**
	 * Create markup for a pet
	 * @param  Array $details Details for the pet
	 * @return String         The markup
	 */
	function keel_petfinder_api_create_pet_img_markup( $details ) {

		$photo_sizes = array(
			keel_petfinder_api_get_image_dimensions( $details['photos']['large'][0] ),
			keel_petfinder_api_get_image_dimensions( $details['photos']['large'][1] ),
			keel_petfinder_api_get_image_dimensions( $details['photos']['large'][2] ),
		);
		$imgs =
			'<div data-photoswipe data-pswp-uid="0" class="row row-start-xsmall text-center margin-bottom-small">' .
				'<a class="grid-third" data-size="' . $photo_sizes[0]['width'] . 'x' . $photo_sizes[0]['height'] . '" href="' . $details['photos']['large'][0] . '" >' .
					'<img class="img-photo img-limit-height" alt="A photo of ' . $details['name'] . '" src="' . $details['photos']['large'][0] . '">' .
				'</a>' .
				'<a class="grid-third" data-size="' . $photo_sizes[1]['width'] . 'x' . $photo_sizes[1]['height'] . '" href="' . $details['photos']['large'][1] . '">' .
					'<img class="img-photo img-limit-height" alt="A photo of ' . $details['name'] . '" src="' . $details['photos']['large'][1] . '">' .
				'</a>' .
				'<a class="grid-third" data-size="' . $photo_sizes[2]['width'] . 'x' . $photo_sizes[2]['height'] . '" href="' . $details['photos']['large'][2] . '">' .
					'<img class="img-photo img-limit-height" alt="A photo of ' . $details['name'] . '" src="' . $details['photos']['large'][2] . '">' .
				'</a>' .
			'</div>' .
			'<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">' .
				'<div class="pswp__bg"></div>' .
				'<div class="pswp__scroll-wrap">' .
					'<div class="pswp__container">' .
						'<div class="pswp__item"></div>' .
						'<div class="pswp__item"></div>' .
						'<div class="pswp__item"></div>' .
					'</div>' .
					'<div class="pswp__ui pswp__ui--hidden">' .
						'<div class="pswp__top-bar">' .
							'<div class="pswp__counter"></div>' .
							'<button class="pswp__button pswp__button--close" title="Close (Esc)"></button>' .
							'<button class="pswp__button pswp__button--share" title="Share"></button>' .
							'<button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>' .
							'<button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>' .
							'<div class="pswp__preloader">' .
								'<div class="pswp__preloader__icn">' .
								'<div class="pswp__preloader__cut">' .
									'<div class="pswp__preloader__donut"></div>' .
								'</div>' .
								'</div>' .
							'</div>' .
						'</div>' .
						'<div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">' .
							'<div class="pswp__share-tooltip"></div>' .
						'</div>' .
						'<button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>' .
						'<button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>' .
						'<div class="pswp__caption">' .
							'<div class="pswp__caption__center"></div>' .
						'</div>' .
					'</div>' .
				'</div>' .
			'</div>';

		return $imgs;

	}



	/**
	 * An array with all of the details
	 * @param  Array  $pets     The pet data
	 * @param  Boolean $single  If true, this is a single pet
	 * @return Array            The details
	 */
	function keel_petfinder_api_get_pet_details( $pets, $single = false ) {

		$settings = keel_petfinder_api_get_settings();
		$options = keel_pet_listings_get_theme_options();

		// Return individual pet details
		if ( $single ) {
			return array(
				'name' => $pets['name']['$t'],
				// 'id' => $pets['id']['$t'],
				'animal' => $pets['animal']['$t'],
				'age' => keel_petfinder_api_get_pet_attribute( $pets, 'age', $settings['age_unknown'] ),
				'gender' => keel_petfinder_api_get_pet_attribute( $pets, 'sex', $settings['sex_unknown'] ),
				'size' => keel_petfinder_api_get_pet_attribute( $pets, 'size', $settings['size_unknown'] ),
				'breeds' => keel_petfinder_api_get_pet_attribute( $pets, 'breeds' ),
				'description' => keel_petfinder_api_get_pet_attribute( $pets, 'description' ),
				'photos' => array(
					'large' => array(
						keel_petfinder_api_get_pet_photo( $pets, 'large', 1 ),
						keel_petfinder_api_get_pet_photo( $pets, 'large', 2 ),
						keel_petfinder_api_get_pet_photo( $pets, 'large', 3 ),
					),
					'medium' => array(
						keel_petfinder_api_get_pet_photo( $pets, 'medium', 1 ),
						keel_petfinder_api_get_pet_photo( $pets, 'medium', 2 ),
						keel_petfinder_api_get_pet_photo( $pets, 'medium', 3 ),
					),
					// 'thumbnail_small' => array(
					// 	keel_petfinder_api_get_pet_photo( $pets, 'thumb_small', 1 ),
					// 	keel_petfinder_api_get_pet_photo( $pets, 'thumb_small', 2 ),
					// 	keel_petfinder_api_get_pet_photo( $pets, 'thumb_small', 3 ),
					// ),
					// 'thumbnail_medium' => array(
					// 	keel_petfinder_api_get_pet_photo( $pets, 'thumb_medium', 1 ),
					// 	keel_petfinder_api_get_pet_photo( $pets, 'thumb_medium', 2 ),
					// 	keel_petfinder_api_get_pet_photo( $pets, 'thumb_medium', 3 ),
					// ),
					// 'thumbnail_large' => array(
					// 	keel_petfinder_api_get_pet_photo( $pets, 'thumb_large', 1 ),
					// 	keel_petfinder_api_get_pet_photo( $pets, 'thumb_large', 2 ),
					// 	keel_petfinder_api_get_pet_photo( $pets, 'thumb_large', 3 ),
					// ),
				),
				'options' => array(
					'multi' => keel_petfinder_api_get_pet_attribute( $pets, 'multi_options' ),
					'special_needs' => keel_petfinder_api_get_pet_attribute( $pets, 'specialNeeds' ),
					// 'no_dogs' => keel_petfinder_api_get_pet_attribute( $pets, 'noDogs' ),
					// 'no_cats' => keel_petfinder_api_get_pet_attribute( $pets, 'noCats' ),
					// 'no_kids' => keel_petfinder_api_get_pet_attribute( $pets, 'noKids' ),
					// 'no_claws' => keel_petfinder_api_get_pet_attribute( $pets, 'noClaaws' ),
					// 'housetrained' => keel_petfinder_api_get_pet_attribute( $pets, 'housetrained' ),
					// 'altered' => keel_petfinder_api_get_pet_attribute( $pets, 'altered' ),
				),
				// 'contact' => array(
				// 	'name' => keel_petfinder_api_get_pet_contact( $pets, 'name' ),
				// 	'email' => keel_petfinder_api_get_pet_contact( $pets, 'email' ),
				// 	'phone' => keel_petfinder_api_get_pet_contact( $pets, 'phone' ),
				// 	'address1' => keel_petfinder_api_get_pet_contact( $pets, 'address1' ),
				// 	'address2' => keel_petfinder_api_get_pet_contact( $pets, 'address2' ),
				// 	'city' => keel_petfinder_api_get_pet_contact( $pets, 'city' ),
				// 	'state' => keel_petfinder_api_get_pet_contact( $pets, 'state' ),
				// 	'zip' => keel_petfinder_api_get_pet_contact( $pets, 'zip' ),
				// 	'fax' => keel_petfinder_api_get_pet_contact( $pets, 'fax' ),
				// ),
				// 'petfinder_url' => 'https://www.petfinder.com/petdetail/' . $pets['id']['$t'],
				'classes' => keel_petfinder_api_get_pet_classes( $pets ),
			);
		}

		// Return all pet details
		return array(
			// 'lists' => array(
			// 	'ages' => keel_petfinder_api_create_list_items( $pets, 'age', $settings['age_unknown'] ),
			// 	'animals' => keel_petfinder_api_create_list_items( $pets, 'animal', $settings['animal_unknown'] ),
			// 	'breeds' => keel_petfinder_api_create_list_items( $pets, 'breeds', '', 'breed' ),
			// 	'options' => keel_petfinder_api_create_list_items( $pets, 'options', '', 'options' ),
			// 	'genders' => keel_petfinder_api_create_list_items( $pets, 'sex', $settings['sex_unknown'] ),
			// 	'sizes' => keel_petfinder_api_create_list_items( $pets, 'age', $settings['age_unknown'] ),
			// ),
			'checkboxes' => array(
				'animals' => $options['filters_animal'] === 'on' ? keel_petfinder_api_create_checkboxes( $pets, 'animal', $settings['animal_unknown'] ) : '',
				'breeds' => $options['filters_breed'] === 'on' ? keel_petfinder_api_create_checkboxes( $pets, 'breeds', '', true ) : '',
				'ages' => $options['filters_age'] === 'on' ? keel_petfinder_api_create_checkboxes( $pets, 'age', $settings['age_unknown'] ) : '',
				'sizes' => $options['filters_size'] === 'on' ? keel_petfinder_api_create_checkboxes( $pets, 'size', $settings['size_unknown'] ): '',
				'genders' => $options['filters_gender'] === 'on' ? keel_petfinder_api_create_checkboxes( $pets, 'sex', $settings['sex_unknown'] ) : '',
				'options' => $options['filters_other'] === 'on' ? keel_petfinder_api_create_checkboxes( $pets, 'options' ) : '',
			),
		);

	}



	/**
	 * Retrieve pet data from Petfinder
	 * @return Array  Pet data
	 */
	function keel_petfinder_api_get_pet_data() {

		// Get settings
		$settings = keel_petfinder_api_get_settings();
		$options = keel_pet_listings_get_theme_options();
		if ( empty( $options['developer_key'] ) || empty( $options['shelter_id'] ) ) return;

		// Variables
		$base_url = 'http://api.petfinder.com/shelter.getPets?';
		$params = http_build_query(
			array(
				'format' => 'json',
				'key' => $options['developer_key'],
				'id' => $options['shelter_id'],
				'count' => $options['count'],
				'status' => 'A',
				'output' => 'full',
			)
		);

		// Get API data
		$request = wp_remote_get( $base_url . $params );
		$response = wp_remote_retrieve_body( $request );
		$data = json_decode( $response, true );

		// If there was an error, return null
		if ( empty( $data ) || intval( $data['petfinder']['header']['status']['code']['$t'] ) !== 100 ) return null;

		// Return the pet data
		return $data['petfinder']['pets']['pet'];

	}



	/**
	 * Extract pet data from API return
	 * @return Array  The pet data
	 */
	function keel_petfinder_api_get_pets() {

		// Get pet data
		$pets = keel_petfinder_api_get_pet_data();

		// If there was an error, log it and fallback to existing data
		if ( empty( $pets ) ) {
			set_transient( 'keel_petfinder_api_get_pets_error', __( 'The Petfinder API returned an error the last time it was called. Data from the last successful API call is being used instead so that pets are still displayed on your site. If you just provided your developer key or shelter ID for the first time, please check that they are correct (ignore this sentence if the API was previously working for you&mdash;petfinder is probably just having some issues).', 'keel' ) );
			return;
		}
		delete_transient( 'keel_petfinder_api_get_pets_error' );

		set_transient( 'keel_petfinder_api_get_pets_timestamp', current_time( 'timestamp' ) );

		// Compare cached data to new data. If they're the same, do nothing.
		$pets_stringified = json_encode ( $pets );
		$pets_cache = get_transient( 'keel_petfinder_api_pets' );
		if ( strcmp( $pets_stringified, $pets_cache ) === 0 ) return;

		// Update cached pet data
		set_transient( 'keel_petfinder_api_pets', $pets_stringified );

		// Create filters and store them for use in the theme
		$filters = keel_petfinder_api_get_pet_details( $pets );
		set_transient( 'keel_petfinder_api_filters', $filters );

		// Get existing pets
		$current_pets = get_posts(array(
			'post_type' => 'keel-pets',
			'showposts' => -1,
		));

		// Delete existing pets
		foreach ($current_pets as $pet) {
			wp_delete_post( $pet->ID, true );
		}

		// Create new pet entries
		foreach ( $pets as $pet ) {

			// Get pet properties
			$details = keel_petfinder_api_get_pet_details( $pet, true );

			// Create post content
			$imgs = keel_petfinder_api_create_pet_img_markup( $details );

			// Create post
			$post = wp_insert_post(array(
				'post_content'   => $details['description'], // The full text of the post
				'post_title'     => $details['name'], // The title of the post
				'post_status'    => 'publish', // Default 'draft'
				'post_type'      => 'keel-pets', // Default 'post'
			));

			// Save extra info to post meta
			if ( $post === 0 ) continue;
			update_post_meta( $post, 'keel_pet_listings_pet_details', $details );
			update_post_meta( $post, 'keel_pet_listings_pet_imgs', $imgs );

		}

	}



	// Schedule API data fetches
	function keel_petfinder_api_schedule_get_pets() {
		if ( !wp_next_scheduled( 'keel_petfinder_api_do_get_pets' ) ) {
			keel_petfinder_api_get_pets();
			wp_schedule_event( time(), 'hourly', 'keel_petfinder_api_do_get_pets' );
		}
	}
	// add_action( 'after_switch_theme', 'keel_petfinder_api_schedule_get_pets' );
	add_action( 'init', 'keel_petfinder_api_schedule_get_pets' );
	// register_activation_hook( __FILE__, 'keel_petfinder_api_schedule_get_pets' );
	add_action( 'keel_petfinder_api_do_get_pets', 'keel_petfinder_api_get_pets' );



	// Unschedule API data fetches
	function keel_petfinder_api_unschedule_get_pets() {
		wp_clear_scheduled_hook( 'keel_petfinder_api_do_get_pets' );
	}
	add_action( 'switch_theme', 'keel_petfinder_api_unschedule_get_pets' );
	// register_deactivation_hook(__FILE__, 'keel_petfinder_api_unschedule_get_pets');



	// Refresh API data fetch schedules
	function keel_petfinder_api_refresh_get_pets( $option ) {
		if ( $option === 'keel_pet_listings_theme_options' ) {
			// flush_rewrite_rules();
			// keel_petfinder_api_get_pets();
			keel_petfinder_api_unschedule_get_pets();
			keel_petfinder_api_schedule_get_pets();
		}
	}
	// add_action( 'updated_option', 'keel_petfinder_api_refresh_get_pets', 10, 1 );



	// Update pet data URL
	function keel_petfinder_api_refresh_pet_slug() {
		if ( isset( $_POST['keel_pet_listings_update_options_process'] ) ) {
			if ( wp_verify_nonce( $_POST['keel_pet_listings_update_options_process'], 'keel_pet_listings_update_options_nonce' ) ) {
				flush_rewrite_rules();
				delete_transient( 'keel_petfinder_api_pets' );
				delete_transient( 'keel_petfinder_api_filters' );
				keel_petfinder_api_unschedule_get_pets();
				keel_petfinder_api_schedule_get_pets();
			}
		}
	}
	add_action( 'init', 'keel_petfinder_api_refresh_pet_slug' );
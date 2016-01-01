<?php

/**
 * nav-social.php
 * Template for social media account navigation.
 */

?>

<?php

	$options = keel_get_theme_options();
	$has_facebook = !empty( $options['facebook'] );
	$has_twitter = !empty( $options['twitter'] );
	$has_youtube = !empty( $options['youtube'] );
	$has_google = !empty( $options['google'] );
	$has_instagram = !empty( $options['instagram'] );
	$has_pinterest = !empty( $options['pinterest'] );
	$has_flickr = !empty( $options['flickr'] );

?>

<?php if ( $has_facebook || $has_twitter || $has_youtube || $has_google || $has_instagram || $has_pinterest || $has_flickr ) : ?>
	<div class="grid-half grid-flip text-right-large">
		<ul class="list-inline">
			<?php if ( $has_facebook ) : ?>
				<li>
					<a class="link-icon" href="<?php echo $options['facebook']; ?>">
						<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-large icon-facebook icon-link" viewBox="0 0 16 16"><path d="M10.5 1.5C9.12 1.5 8 2.62 8 4v1.5H6v2h2v7h2v-7h2.25l.5-2H10V4c0-.276.224-.5.5-.5H13v-2h-2.5z"/></svg>
						<span class="icon-fallback-text">Facebook</span>
					</a>
				</li>
			<?php endif; ?>
			<?php if ( $has_twitter ) : ?>
				<li>
					<a class="link-icon" href="http://twitter.com/<?php echo $options['twitter']; ?>">
						<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-large icon-twitter icon-link" viewBox="0 0 16 16"><path d="M16 3.038c-.59.26-1.22.438-1.885.517.678-.406 1.198-1.05 1.443-1.816-.634.375-1.337.648-2.085.796-.6-.638-1.452-1.037-2.396-1.037-1.813 0-3.283 1.47-3.283 3.28 0 .258.03.51.085.75C5.15 5.39 2.73 4.084 1.112 2.1.83 2.583.67 3.147.67 3.75c0 1.138.578 2.143 1.46 2.73-.54-.016-1.045-.164-1.488-.41v.04c0 1.59 1.132 2.918 2.633 3.22-.275.075-.565.115-.865.115-.212 0-.417-.02-.618-.06.418 1.305 1.63 2.254 3.066 2.28-1.123.88-2.54 1.406-4.077 1.406-.264 0-.525-.015-.782-.045 1.453.93 3.178 1.475 5.032 1.475 6.038 0 9.34-5.002 9.34-9.34 0-.142-.003-.284-.01-.425.642-.463 1.198-1.04 1.638-1.7z"/></svg>
						<span class="icon-fallback-text">Twitter</span>
					</a>
				</li>
			<?php endif; ?>
			<?php if ( $has_youtube ) : ?>
				<li>
					<a class="link-icon" href="<?php echo $options['youtube']; ?>">
						<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-large icon-youtube icon-link" viewBox="0 0 16 16"><path d="M4.58 0L3.5 2.144 2.42 0H1.04l1.95 3.396L3 3.39V6h1V3.39l.01.006L5.96 0zM7.5 2c.27 0 .5.23.5.5v2c0 .27-.23.5-.5.5S7 4.77 7 4.5v-2c0-.27.23-.5.5-.5zm0-1C6.675 1 6 1.675 6 2.5v2C6 5.325 6.675 6 7.5 6S9 5.325 9 4.5v-2C9 1.675 8.325 1 7.5 1zM12 1v3.937c-.436.364-1 .583-1-.713V1h-1v3.427h.002c.015.827.19 2.315 1.998 1.105V6h1V1h-1zM13.5 11c-.276 0-.5.224-.5.5v.5h1v-.5c0-.276-.224-.5-.5-.5zM9 11.5v2.625c.34.34 1 .375 1-.125v-2.344S9.5 11 9 11.5z"/><path d="M15.918 9.087c-.044-.576-.25-1.046-.622-1.41s-.845-.562-1.423-.595C12.783 7.028 10.288 7 8.096 7s-4.864.027-5.954.082c-.578.033-1.052.23-1.423.595s-.58.834-.623 1.41C.032 10.26 0 10.687 0 11.273s.032 1.467.097 2.64c.044.577.25 1.047.622 1.41s.844.563 1.422.596c1.09.053 3.763.08 5.954.08s4.686-.027 5.777-.08c.578-.034 1.052-.232 1.423-.596s.578-.834.622-1.41c.055-.978.082-1.858.082-2.64s-.027-1.21-.082-2.187zM3 15H2v-5H1V9h3v1H3v5zm4 0H6v-.468c-1.9 1.067-1.983.034-1.998-.792H4V11h1v2.756c0 .604.564.546 1 .182V11h1v4zm4-1.014c0 1.045-1.07 1.35-2 .537V15H8V9h1v1.625c1-1 2-.625 2 .375v2.986zM15 12v.5h-2v1c0 .276.224.5.5.5s.5-.224.5-.5V13h1v.5c0 .827-.673 1.5-1.5 1.5s-1.5-.673-1.5-1.5v-2c0-.827.673-1.5 1.5-1.5s1.5.673 1.5 1.5v.5z"/></svg>
						<span class="icon-fallback-text">YouTube</span>
					</a>
				</li>
			<?php endif; ?>
			<?php if ( $has_google ) : ?>
				<li>
					<a class="link-icon" href="<?php echo $options['google']; ?>">
						<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-large icon-google icon-link" viewBox="0 0 16 16"><path d="M8.735 1H4.548C2.67 1 .905 2.422.905 4.07c0 1.682 1.28 3.04 3.19 3.04.132 0 .26-.002.387-.01-.124.236-.213.504-.213.78 0 .47.25.848.57 1.158-.24 0-.474.007-.727.007C1.788 9.045 0 10.525 0 12.06c0 1.513 1.96 2.46 4.285 2.46 2.65 0 4.114-1.505 4.114-3.017 0-1.213-.36-1.94-1.465-2.72-.378-.27-1.102-.92-1.102-1.303 0-.45.128-.67.804-1.198.692-.54 1.182-1.302 1.182-2.186 0-1.053-.47-2.08-1.35-2.418h1.326L8.733 1zM7.273 11.242c.033.14.05.284.05.432 0 1.222-.786 2.177-3.045 2.177-1.607 0-2.767-1.016-2.767-2.238 0-1.198 1.44-2.194 3.047-2.177.375.004.724.064 1.042.167.87.607 1.497.95 1.674 1.64zM4.7 6.684C3.62 6.652 2.596 5.477 2.41 4.06s.537-2.5 1.615-2.468c1.078.032 2.104 1.17 2.29 2.585S5.778 6.715 4.7 6.683zM13 4V1h-1v3H9v1h3v3h1V5h3V4z"/></svg>
						<span class="icon-fallback-text">Google+</span>
					</a>
				</li>
			<?php endif; ?>
			<?php if ( $has_instagram ) : ?>
				<li>
					<a class="link-icon" href="http://instagram.com/<?php echo $options['instagram']; ?>">
						<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-large icon-instagram icon-link" viewBox="0 0 16 16"><path d="M13.344 0H2.656C1.196 0 0 1.195 0 2.656v10.688C0 14.804 1.195 16 2.656 16h10.688C14.804 16 16 14.805 16 13.344V2.656C16 1.196 14.805 0 13.344 0zM5.122 7h5.756c.11.313.17.65.17 1 0 1.68-1.368 3.047-3.048 3.047S4.953 9.68 4.953 8c0-.35.06-.687.17-1zM14 7v6c0 .55-.45 1-1 1H3c-.55 0-1-.45-1-1V7h1.564c-.073.322-.11.657-.11 1 0 2.507 2.04 4.547 4.546 4.547s4.547-2.04 4.547-4.547c0-.343-.04-.678-.11-1H14zm0-3.5c0 .275-.225.5-.5.5h-1c-.275 0-.5-.225-.5-.5v-1c0-.275.225-.5.5-.5h1c.275 0 .5.225.5.5v1z"/></svg>
						<span class="icon-fallback-text">Instagram</span>
					</a>
				</li>
			<?php endif; ?>
			<?php if ( $has_pinterest ) : ?>
				<li>
					<a class="link-icon" href="http://pinterst.com/<?php echo $options['pinterest']; ?>">
						<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-large icon-pinterest icon-link" viewBox="0 0 16 16"><path d="M8 0C3.582 0 0 3.582 0 8c0 3.39 2.11 6.284 5.085 7.45-.07-.633-.133-1.604.028-2.295.145-.624.938-3.977.938-3.977s-.238-.48-.238-1.188c0-1.112.645-1.943 1.448-1.943.683 0 1.012.512 1.012 1.127 0 .686-.437 1.713-.663 2.663-.19.796.398 1.446 1.184 1.446 1.422 0 2.515-1.5 2.515-3.664 0-1.916-1.377-3.256-3.343-3.256-2.276 0-3.612 1.707-3.612 3.472 0 .688.265 1.425.595 1.826.065.08.075.15.055.23-.06.252-.196.795-.222.906-.035.146-.116.177-.268.107-1-.465-1.624-1.926-1.624-3.1 0-2.523 1.835-4.84 5.287-4.84 2.775 0 4.932 1.978 4.932 4.62 0 2.757-1.74 4.976-4.152 4.976-.81 0-1.573-.42-1.834-.918l-.498 1.902c-.18.695-.668 1.566-.994 2.097.75.233 1.544.358 2.37.358 4.417 0 8-3.582 8-8s-3.583-8-8-8z"/></svg>
						<span class="icon-fallback-text">Pinterest</span>
					</a>
				</li>
			<?php endif; ?>
			<?php if ( $has_flickr ) : ?>
				<li>
					<a class="link-icon" href="http://flickr.com/<?php echo $options['flickr']; ?>">
						<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-large icon-flickr icon-link" viewBox="0 0 16 16"><path d="M0 8.5C0 6.567 1.567 5 3.5 5S7 6.567 7 8.5 5.433 12 3.5 12 0 10.433 0 8.5zm9 0C9 6.567 10.567 5 12.5 5S16 6.567 16 8.5 14.433 12 12.5 12 9 10.433 9 8.5z"/></svg>
						<span class="icon-fallback-text">Flickr</span>
					</a>
				</li>
			<?php endif; ?>
		</ul>
	</div>
<?php endif; ?>

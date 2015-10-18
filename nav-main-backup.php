<?php

/**
 * nav-main-backup.php
 * Template for backup navigation for submenu pages.
 */

?>

<?php if ( has_nav_menu( 'primary' ) || wp_get_nav_menu_object( 'Primary' ) ) : ?>
	<nav class="bg-muted nav-backup <?php if ( keel_has_hero() ) { echo 'has-hero'; } ?>">
		<div class="container container-large">
			<?php
				wp_nav_menu( array(
					'menu'           => 'Primary',
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'list-inline no-margin-bottom padding-top-small padding-bottom-small',
					'sub_menu'       => true,
				) );
			?>
		</div>
	</nav>
<?php endif; ?>
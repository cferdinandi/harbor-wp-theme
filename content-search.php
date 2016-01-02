<?php

/**
 * content-search.php
 * Template for search results
 */

?>

<!-- <li>
	<a href="<?php the_permalink(); ?>">
		<?php the_title(); ?>
	</a> <em><?php echo ( ucwords( get_post_type() ) ); ?></em>
</li> -->

<em><?php echo ( ucwords( get_post_type() ) ); ?></em>
<h2 class="h3 no-padding-top">
	<a href="<?php the_permalink(); ?>">
		<?php the_title(); ?>
	</a>
</h2>
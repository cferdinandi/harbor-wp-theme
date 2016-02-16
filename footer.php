<?php

/**
 * footer.php
 * Template for footer content.
 */

?>

				</div><!-- /.container -->
			</main><!-- /#main -->
		</div><!-- /[data-sticky-wrap] -->

		<footer class="padding-top-large padding-bottom bg-dark" data-sticky-footer>

			<?php
				$options = keel_get_theme_options();
			?>

			<div class="container container-large text-center" >

				<?php get_template_part( 'nav', 'secondary' ); ?>

				<div class="row">
					<?php get_template_part( 'nav', 'social' ); ?>
					<div class="grid-half text-left-large">
						<?php get_search_form(); ?>
					</div>
				</div>

				<div class="row">
					<div class="grid-half text-left-large">
						<?php
							if ( !empty( $options['footer1'] ) ) {
								echo do_shortcode( wpautop( stripslashes( $options['footer1'] ) ) );
							}
						?>
					</div>
					<div class="grid-half text-right-large">
						<?php
							if ( !empty( $options['footer2'] ) ) {
								echo do_shortcode( wpautop( stripslashes( $options['footer2'] ) ) );
							}
						?>
					</div>
				</div>

				<p class="text-small text-left-large"><a target="_blank" href="http://gomakethings.com">Harbor for WordPress Theme by Go Make Things</a></p>

			</div>

		</footer>


		<?php wp_footer(); ?>

	</body>
</html>
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
				// Get theme options
				$options = keel_get_theme_options();
			?>

			<div class="container container-large text-center" >

				<?php
					// Secondary navigation
					get_template_part( 'nav', 'secondary' );
				?>

				<?php
					// Social nav and search
					get_template_part( 'nav', 'social' );
				?>

				<?php if ( !empty( $options['footer1'] ) && !empty( $options['footer2'] ) ) : ?>
					<div class="row">
						<div class="grid-half text-left-large">
							<?php echo do_shortcode( wpautop( stripslashes( $options['footer1'] ) ) ); ?>
						</div>
						<div class="grid-half text-right-large">
							<?php echo do_shortcode( wpautop( stripslashes( $options['footer2'] ) ) ); ?>
						</div>
					</div>
				<?php elseif ( !empty( $options['footer1'] ) || !empty( $options['footer2'] ) ) : ?>
					<div class="row">
						<div class="grid-two-thirds float-center">
							<?php echo do_shortcode( wpautop( stripslashes( $options['footer1'] ) ) ); ?>
							<?php echo do_shortcode( wpautop( stripslashes( $options['footer2'] ) ) ); ?>
						</div>
					</div>
				<?php endif; ?>

				<p class="text-small text-left-large"><a target="_blank" href="http://gomakethings.com">Harbor for WordPress Theme by Go Make Things</a></p>

			</div>

		</footer>


		<?php wp_footer(); ?>

	</body>
</html>
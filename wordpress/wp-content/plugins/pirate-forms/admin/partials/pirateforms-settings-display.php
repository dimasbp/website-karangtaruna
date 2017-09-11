<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

		<div class="wrap">
			<div id="pirate-forms-main">
				<h3><?php esc_html_e( 'Pirate Forms', 'pirate-forms' ); ?></h3>

				<div class="pirate-options">
					<ul class="pirate-forms-nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#0" aria-controls="how_to_use" role="tab"
																  data-toggle="tab"><?php esc_html_e( 'How to use', 'pirate-forms' ); ?></a>
						</li>
						<li role="presentation"><a href="#1" aria-controls="options" role="tab"
												   data-toggle="tab"><?php esc_html_e( 'Options', 'pirate-forms' ); ?></a>
						</li>
						<li role="presentation"><a href="#2" aria-controls="fields" role="tab"
												   data-toggle="tab"><?php esc_html_e( 'Fields Settings', 'pirate-forms' ); ?></a>
						</li>
						<li role="presentation"><a href="#3" aria-controls="labels" role="tab"
												   data-toggle="tab"><?php esc_html_e( 'Fields Labels', 'pirate-forms' ); ?></a>
						</li>
						<li role="presentation"><a href="#4" aria-controls="messages" role="tab"
												   data-toggle="tab"><?php esc_html_e( 'Alert Messages', 'pirate-forms' ); ?></a>
						</li>
						<li role="presentation"><a href="#5" aria-controls="smtp" role="tab"
												   data-toggle="tab"><?php esc_html_e( 'SMTP', 'pirate-forms' ); ?></a></li>
					</ul>

					<div class="pirate-forms-tab-content">

						<div id="0" class="pirate-forms-tab-pane active">

							<h3 class="pirate_forms_welcome_text"><?php esc_html_e( 'Welcome to Pirate Forms!', 'pirate-forms' ); ?></h3>
							<p class="pirate_forms_subheading"><?php esc_html_e( 'To get started, just ', 'pirate-forms' ); ?>
								<b><?php esc_html_e( 'configure all the options ', 'pirate-forms' ); ?></b><?php esc_html_e( 'you need, hit save and start using the created form.', 'pirate-forms' ); ?>
							</p>

							<hr>

							<p><?php esc_html_e( 'There are 3 ways of using the newly created form:', 'pirate-forms' ); ?></p>
							<ol>
								<li><?php esc_html_e( 'Add a ', 'pirate-forms' ); ?><strong><a
												href="<?php echo admin_url( 'widgets.php' ); ?>"><?php esc_html_e( 'widget', 'pirate-forms' ); ?></a></strong>
								</li>
								<li><?php esc_html_e( 'Use the shortcode ', 'pirate-forms' ); ?>
									<strong><code>[pirate_forms]</code></strong><?php esc_html_e( ' in any page or post.', 'pirate-forms' ); ?>
								</li>
								<li><?php esc_html_e( 'Use the shortcode ', 'pirate-forms' ); ?><strong><code>&lt;?php echo
											do_shortcode( '[pirate_forms]' )
											?&gt;</code></strong><?php esc_html_e( ' in the theme\'s files.', 'pirate-forms' ); ?>
								</li>
							</ol>

							<hr>

							<div class="rate_plugin_invite">

								<h4><?php esc_html_e( 'Are you enjoying Pirate Forms?', 'pirate-forms' ); ?></h4>

								<p class="review-link">
									<?php
									/* translators: link to WordPress.org repo for PirateForms */
									echo sprintf( esc_html__( 'Rate our plugin on %1$s WordPress.org %2$s. We\'d really appreciate it!', 'pirate-forms' ), '<a href="https://wordpress.org/support/view/plugin-reviews/pirate-forms" target="_blank" rel="nofollow"> ', '</a>' );
									?>
								</p>

								<p><span class="dashicons dashicons-star-filled"></span><span
											class="dashicons dashicons-star-filled"></span><span
											class="dashicons dashicons-star-filled"></span><span
											class="dashicons dashicons-star-filled"></span><span
											class="dashicons dashicons-star-filled"></span></p>

								<p>
									<small>
										<?php
										/* translators: link to blog article about contact form plugins */
										echo sprintf( esc_html__( 'If you want a more complex Contact Form Plugin please check %1$s this link %2$s.', 'pirate-forms' ), '<a href="http://www.codeinwp.com/blog/best-contact-form-plugins-wordpress/" target="_blank" >', '</a>' );
										?>
									</small>
								</p>
							</div>

						</div>

						<?php
						$html_helper        = new PirateForms_HTML();
						$tab_index          = 1;
						foreach ( $plugin_options as $tab => $array ) {
						?>
						<div id="<?php echo $tab_index++; ?>" class="pirate-forms-tab-pane <?php echo $tab; ?>">
							<form method="post" class="pirate_forms_contact_settings">
						<?php
							$html_helper->add(
								array(
									'type'      => 'h3',
									'class'     => 'title',
									'hr'        => true,
									'value'     => $array['heading'],
								)
							);

						foreach ( $array['controls'] as $control ) {
							$html_helper->add( $control );
						}

							$html_helper->add(
								array(
									'type'      => 'submit',
									'class'     => 'button-primary pirate-forms-save-button',
									'id'        => 'save',
									'value'     => __( 'Save changes', 'pirate-forms' ),
								)
							);

							$html_helper->add(
								array(
									'type'      => 'hidden',
									'id'        => 'action',
									'value'     => 'save',
								)
							);

							$html_helper->add(
								array(
									'type'      => 'hidden',
									'id'        => 'proper_nonce',
									'value'     => wp_create_nonce( $current_user->user_email ),
								)
							);
						?>

												 </form><!-- .pirate_forms_contact_settings -->
						<div class="ajaxAnimation"></div>
					</div><!-- .pirate-forms-tab-pane -->
					<?php
						} // End foreach().
					?>

				</div><!-- .pirate-forms-tab-content -->
			</div><!-- .pirate-options -->
				<div id="pirate-forms-sidebar">
					<?php do_action( 'pirate_forms_load_sidebar' ); ?>
				</div>
				<div class="clear"></div>
		</div><!-- .pirate-options -->



		</div><!-- .wrap -->

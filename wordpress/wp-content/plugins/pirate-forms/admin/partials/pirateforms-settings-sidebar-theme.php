<?php
			/* Upgrade to Hestia notification box */
			$pirate_current_theme = '';

			$theme = wp_get_theme();

if ( ! empty( $theme ) ) {
	if ( is_child_theme() ) {
		$pirate_current_theme = $theme->parent()->get( 'Name' );
	} else {
		$pirate_current_theme = $theme->get( 'Name' );
	}
}

if ( ( $pirate_current_theme != 'Hestia' ) && ( $pirate_current_theme != 'Hestia Pro' ) ) {

	$pirate_upgrade_hestia_box_text = 'Check-out our latest FREE multi-purpose theme: <strong>Hestia</strong>';

	if ( $pirate_current_theme == 'Zerif Lite' ) {
		$pirate_upgrade_hestia_box_text = 'Check-out our latest FREE multi-purpose theme: <strong>Hestia</strong>, your Zerif Lite content will be imported automatically! ';
	}
	?>
	<div class="pirate-upgrade-hestia postbox card">
		<div class="pirate-forms-upgrade-hestia-content">
			<?php echo wp_kses_post( $pirate_upgrade_hestia_box_text ); ?><br>
			<?php
			$pirate_upgrade_hestia_url = add_query_arg(
				array(
					'theme' => 'hestia',
				), admin_url( 'theme-install.php' )
			);
			?>
			<a href="<?php echo $pirate_upgrade_hestia_url; ?>" target="_blank">Preview Hestia</a>
					</div>
				</div>
				<?php
}
			?>

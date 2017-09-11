<?php

/**
 * Builds the form
 *
 * @since    1.0.0
 */
class PirateForms_PhpFormBuilder {

	/**
	 * Build the HTML for the form based on the input queue
	 *
	 * @param array $elements The array of HTML elements.
	 *
	 * @return string
	 */
	function build_form( $elements ) {
		$pirateformsopt_attachment_field = PirateForms_Util::get_option( 'pirateformsopt_attachment_field' );
		if ( 'yes' === $pirateformsopt_attachment_field ) {
			$pirate_forms_enctype = 'multipart/form-data';
		} else {
			$pirate_forms_enctype = 'application/x-www-form-urlencoded';
		}

		$form_start = '<form method="post" enctype="' . $pirate_forms_enctype . '" action="" class="pirate_forms">';
		$this->set_element( 'form_start', $form_start );

		$html_helper        = new PirateForms_HTML();
		$form_end           = '';
		foreach ( $elements as $val ) {
			$element    = $html_helper->add( $val, false );
			if ( 'form_honeypot' === $val['id'] || in_array( $val['type'], array( 'hidden', 'div' ) ) ) {
				$form_end .= $element;
			}
			$this->set_element( $val['id'], $element );
		}

		$form_end .= '</form>';
		$this->set_element( 'form_end', $form_end );

		$output = $this->load_theme();
		return $output;
	}

	/**
	 * Sets the element as a variable that can be used in the templates
	 *
	 * @since    1.2.6
	 */
	public function set_element( $element_name, &$output ) {
		$name           = str_replace( array( 'pirate-forms-', '-' ), array( '', '_' ), $element_name );
		$this->$name    = $output;
		$output         = '';
	}

	/**
	 * Load the correct template
	 *
	 * @since    1.2.6
	 */
	private function load_theme() {
		$default    = PIRATEFORMS_DIR . 'public/partials/pirateforms-form.php';
		$custom     = trailingslashit( get_template_directory() ) . 'pirate-forms/form.php';
		$file       = $default;
		if ( is_readable( $custom ) ) {
			$file   = $custom;
		} elseif ( file_exists( $custom ) ) {
			do_action( 'themeisle_log_event', PIRATEFORMS_NAME, sprintf( 'cannot access theme = %s', $custom ), 'error', __FILE__, __LINE__ );
		}
		ob_start();
		include $file;
		$output = ob_get_clean();
		return $output;
	}

}

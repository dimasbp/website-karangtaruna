<?php

/**
 * HTML elements helper
 *
 * @since    1.2.6
 */
class PirateForms_HTML {

	/**
	 * Add the HTML element - the single entry point for this class
	 *
	 * @throws Exception If method is not defined.
	 * @since    1.2.6
	 */
	public function add( $args, $echo = true ) {
		$type       = $args['type'];
		$html       = '';
		if ( method_exists( $this, $type ) ) {
			if ( isset( $args['id'] ) && ! isset( $args['name'] ) ) {
				$args['name']   = $args['id'];
			}
			if ( isset( $args['class'] ) && is_array( $args['class'] ) ) {
				$args['class']   = implode( ' ', $args['class'] );
			}
			$html   = $this->$type( $args );
		} else {
			throw new Exception( "Method for $type not defined" );
		}
		if ( ! $echo ) {
			return $html;
		}
		echo $html;
	}

	/**
	 * Add the wrapper around the HTML element
	 *
	 * @since    1.2.6
	 */
	private function get_wrap( $args, $inside ) {

		$html       = '';
		if ( isset( $args['wrap'] ) ) {
			$html   .= '<' . $args['wrap']['type'];
			if ( isset( $args['wrap']['class'] ) ) {
				$html   .= ' class="' . esc_attr( $args['wrap']['class'] ) . '"';
			}
			if ( isset( $args['wrap']['style'] ) ) {
				$html   .= ' style="' . $args['wrap']['style'] . '"';
			}
			$html   .= '>';
		}
		$html       .= $inside;

		if ( isset( $args['wrap'] ) ) {
			$html   .= '</' . $args['wrap']['type'] . '>';
		}

		return $html;
	}

	/**
	 * Add the label etc. for the HTML element
	 *
	 * @since    1.2.6
	 */
	private function get_label( $args ) {
		$html       = '';
		if ( isset( $args['label'] ) ) {
			$html   .= '<label for="' . esc_attr( $args['id'] ) . '">';
			if ( isset( $args['label']['value'] ) ) {
				$html   .= esc_html( $args['label']['value'] );
			}
			if ( isset( $args['label']['html'] ) ) {
				$html   .= $args['label']['html'];
			}
			if ( isset( $args['label']['desc'] ) ) {
				$html   .= '<div';
				if ( isset( $args['label']['desc']['class'] ) ) {
					$html   .= ' class="' . esc_attr( $args['label']['desc']['class'] ) . '"';
				}
				$html   .= '>' . esc_html( $args['label']['desc']['value'] ) . '</div>';
			}
			$html   .= '</label>';
		}
		return $html;
	}

	/**
	 * Add the common attribtes for the HTML element
	 *
	 * @since    1.2.6
	 */
	private function get_common( $args, $additional = array() ) {
		$html       = 'id="' . esc_attr( $args['id'] ) . '" name="' . esc_attr( $args['name'] ) . '" class="' . ( isset( $args['class'] ) ? esc_attr( $args['class'] ) : '' ) . '" placeholder="' . ( isset( $args['placeholder'] ) ? esc_attr( $args['placeholder'] ) : '' ) . '" ' . ( isset( $args['required'] ) && $args['required'] ? 'required' : '' );

		if ( isset( $args['required'] ) && $args['required'] && isset( $args['required_msg'] ) ) {
			$html   .= ' oninvalid="this.setCustomValidity(\'' . esc_attr( $args['required_msg'] ) . '\')" onchange="this.setCustomValidity(\'\')"';
		}

		if ( in_array( 'value', $additional ) ) {
			$html       .= ' value="' . ( isset( $args['value'] ) ? esc_attr( $args['value'] ) : '' ) . '"';
		}

		return $html;
	}

	/**
	 * The H3 element
	 *
	 * @since    1.2.6
	 */
	private function h3( $args ) {
		$html       = '<h3';

		if ( isset( $args['class'] ) ) {
			$html   .= ' class="' . esc_attr( $args['class'] ) . '"';
		}
		$html       .= '>' . esc_html( $args['value'] ) . '</h3>';
		if ( isset( $args['hr'] ) && $args['hr'] ) {
			$html   .= '<hr />';
		}
		return $html;
	}

	/**
	 * The DIV element
	 *
	 * @since    1.2.6
	 */
	private function div( $args ) {
		$html       = '<div';

		if ( isset( $args['id'] ) ) {
			$html   .= ' id="' . esc_attr( $args['id'] ) . '"';
		}

		if ( isset( $args['class'] ) ) {
			$html   .= ' class="' . esc_attr( $args['class'] ) . '"';
		}

		if ( isset( $args['custom'] ) ) {
			foreach ( $args['custom'] as $key => $val ) {
				$html   .= ' ' . $key . '="' . esc_attr( $val ) . '"';
			}
		}

		$html       .= '>';

		if ( isset( $args['value'] ) ) {
			$html   .= esc_html( $args['value'] );
		}

		$html       .= '</div>';
		return $html;
	}

	/**
	 * The input type="file" element
	 *
	 * @since    1.2.6
	 */
	private function file( $args ) {
		$html       = $this->get_label( $args );
		$html       .= '<input type="file" ' . $this->get_common( $args, array( 'value' ) ) . '>';

		return $this->get_wrap( $args, $html );
	}

	/**
	 * The input type="email" element
	 *
	 * @since    1.2.6
	 */
	private function email( $args ) {
		$html       = $this->get_label( $args );
		$html       .= '<input type="email" ' . $this->get_common( $args, array( 'value' ) ) . '>';

		return $this->get_wrap( $args, $html );
	}

	/**
	 * The input type="text" element
	 *
	 * @since    1.2.6
	 */
	private function text( $args ) {
		$html       = $this->get_label( $args );
		$html       .= '<input type="text" ' . $this->get_common( $args, array( 'value' ) ) . '>';

		return $this->get_wrap( $args, $html );
	}

	/**
	 * The input type="hidden" element
	 *
	 * @since    1.2.6
	 */
	private function hidden( $args ) {
		$html       = '<input type="hidden" ' . $this->get_common( $args, array( 'value' ) ) . '>';

		return $html;
	}

	/**
	 * The input type="password" element
	 *
	 * @since    1.2.6
	 */
	private function password( $args ) {
		$html       = $this->get_label( $args );
		$html       .= '<input type="password" ' . $this->get_common( $args, array( 'value' ) ) . '>';

		return $this->get_wrap( $args, $html );
	}

	/**
	 * The textarea element
	 *
	 * @since    1.2.6
	 */
	private function textarea( $args ) {
		$html       = $this->get_label( $args );

		$rows       = isset( $args['rows'] ) ? $args['rows'] : 5;
		$cols       = isset( $args['cols'] ) ? $args['cols'] : 30;
		$html       .= '<textarea rows=' . $rows . ' cols=' . $cols . ' ' . $this->get_common( $args ) . '>' . ( isset( $args['value'] ) ? esc_attr( $args['value'] ) : '' ) . '</textarea>';

		return $this->get_wrap( $args, $html );
	}

	/**
	 * The dropdown element
	 *
	 * @since    1.2.6
	 */
	private function select( $args ) {
		$html       = $this->get_label( $args );

		$html       .= '<select id="' . esc_attr( $args['id'] ) . '" name="' . esc_attr( $args['name'] ) . '" class="' . ( isset( $args['class'] ) ? esc_attr( $args['class'] ) : '' ) . '"';
		if ( isset( $args['options'] ) && is_array( $args['options'] ) ) {
			foreach ( $args['options'] as $key => $val ) {
				$extra  = $key == $args['value'] ? 'selected' : '';
				$html   .= '<option value="' . esc_attr( $key ) . '" ' . $extra . '>' . esc_html( $val ) . '</option>';
			}
		}
		$html       .= '</select>';

		return $this->get_wrap( $args, $html );
	}

	/**
	 * The input type="radio" element
	 *
	 * @since    1.2.6
	 */
	private function radio( $args ) {
		$html       = $this->get_label( $args );

		if ( isset( $args['options'] ) && is_array( $args['options'] ) ) {
			$index_radio  = 0;
			foreach ( $args['options'] as $key => $val ) {
				$extra  = $key == $args['value'] ? 'checked' : '';
				if ( $index_radio++ == 0 ) {
					$extra  = 'checked';
				}
				$html   .= '<input type="radio" value="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] . $key ) . '" name="' . esc_attr( $args['id'] ) . '" class="' . ( isset( $args['class'] ) ? esc_attr( $args['class'] ) : '' ) . '" ' . $extra . '>' . $val;
			}
		}

		return $this->get_wrap( $args, $html );
	}

	/**
	 * The input type="checkbox" element
	 *
	 * @since    1.2.6
	 */
	private function checkbox( $args ) {
		$html       = $this->get_label( $args );

		if ( isset( $args['options'] ) && is_array( $args['options'] ) ) {
			$name       = esc_attr( $args['id'] );
			if ( count( $args['options'] ) > 1 ) {
				$name   .= '[]';
			}
			foreach ( $args['options'] as $key => $val ) {
				$extra  = $key == $args['value'] ? 'checked' : '';
				$html   .= '<input type="checkbox" value="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] . $key ) . '" name="' . $name . '" class="' . ( isset( $args['class'] ) ? esc_attr( $args['class'] ) : '' ) . '" ' . $extra . '>' . $val;
			}
		}

		return $this->get_wrap( $args, $html );
	}

	/**
	 * The input type="submit" element
	 *
	 * @since    1.2.6
	 */
	private function submit( $args ) {
		$html       = '<input type="submit" ' . $this->get_common( $args, array( 'value' ) ) . '>';

		return $this->get_wrap( $args, $html );
	}

	/**
	 * The button element
	 *
	 * @since    1.2.6
	 */
	private function button( $args ) {
		$html       = '<button type="submit" ' . $this->get_common( $args ) . '>' . ( isset( $args['value'] ) ? $args['value'] : '' ) . '</button>';

		return $this->get_wrap( $args, $html );
	}

}

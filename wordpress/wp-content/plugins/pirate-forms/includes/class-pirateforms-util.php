<?php

/**
 * Utility functions
 *
 * @since    1.0.0
 */
class PirateForms_Util {

	/**
	 * Returns if the domain is localhost
	 *
	 * @since     1.0.0
	 */
	public static function is_localhost() {
		$server_name = strtolower( $_SERVER['SERVER_NAME'] );
		return in_array( $server_name, array( 'localhost', '127.0.0.1' ) );
	}

	/**
	 * Gets the from email
	 *
	 * @since     1.0.0
	 */
	public static function get_from_email() {
		$admin_email = get_option( 'admin_email' );
		$sitename    = strtolower( $_SERVER['SERVER_NAME'] );
		if ( PirateForms_Util::is_localhost() ) {
			return $admin_email;
		}
		if ( substr( $sitename, 0, 4 ) == 'www.' ) {
			$sitename = substr( $sitename, 4 );
		}
		if ( strpbrk( $admin_email, '@' ) == '@' . $sitename ) {
			return $admin_email;
		}

		return 'wordpress@' . $sitename;
	}

	/**
	 * Get the settings key
	 *
	 * @since     1.0.0
	 */
	public static function get_option( $id = null ) {
		$pirate_forms_options = get_option( 'pirate_forms_settings_array' );
		if ( is_null( $id ) ) {
			return $pirate_forms_options;
		}
		return isset( $pirate_forms_options[ $id ] ) ? $pirate_forms_options[ $id ] : '';
	}

	/**
	 * Set all the settings
	 *
	 * @since     1.0.0
	 */
	public static function set_option( $data ) {
		update_option( 'pirate_forms_settings_array', $data );
	}

	/**
	 * Update a key in the settings
	 *
	 * @since     1.0.0
	 */
	public static function update_option( $id, $value ) {
		$pirate_forms_options = get_option( 'pirate_forms_settings_array' );
		if ( is_null( $id ) ) {
			return false;
		}
		$pirate_forms_options[ $id ] = $value;
		self::set_option( $pirate_forms_options );
		return true;
	}

}

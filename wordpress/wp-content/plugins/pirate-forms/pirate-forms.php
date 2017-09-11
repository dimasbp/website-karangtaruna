<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.2.6
 * @package           PirateForms
 *
 * @wordpress-plugin
 * Plugin Name:       Free & Simple Contact Form Plugin - Pirateforms
 * Plugin URI: http://themeisle.com/plugins/pirate-forms/
 * Description: Easily creates a nice looking, simple contact form on your WP site.
 * Version: 2.0.1
 * Author: Themeisle
 * Author URI: http://themeisle.com
 * Text Domain: pirate-forms
 * Domain Path: /languages
 * License: GPLv2
 * WordPress Available:  yes
 * Requires License:    no
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'PIRATEFORMS_NAME', 'Pirate Forms' );
define( 'PIRATEFORMS_SLUG', 'pirate-forms' );
define( 'PIRATE_FORMS_VERSION', '2.0.1' );
define( 'PIRATEFORMS_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'PIRATEFORMS_URL', plugin_dir_url( __FILE__ ) );
define( 'PIRATEFORMS_BASENAME', plugin_basename( __FILE__ ) );
define( 'PIRATEFORMS_BASEFILE', __FILE__ );
define( 'PIRATEFORMS_ROOT', trailingslashit( plugins_url( '', __FILE__ ) ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_pirate_forms() {
	PirateForms_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_pirate_forms() {
	PirateForms_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_pirate_forms' );
register_deactivation_hook( __FILE__, 'deactivate_pirate_forms' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 *
 * @param string $class The class name to load.
 *
 * @return bool Either was loaded or not.
 * @since    3.0.0
 */
function pirate_forms_autoload( $class ) {
	$namespaces = array( 'PirateForms' );
	$class1     = str_replace( '_', '-', strtolower( 'class-' . $class ) );
	foreach ( $namespaces as $namespace ) {
		if ( substr( $class, 0, strlen( $namespace ) ) == $namespace ) {
			$filename = PIRATEFORMS_DIR . 'includes/' . $class1 . '.php';
			if ( is_readable( $filename ) ) {
				require_once $filename;

				return true;
			}
			$filename = PIRATEFORMS_DIR . 'admin/' . $class1 . '.php';
			if ( is_readable( $filename ) ) {
				require_once $filename;

				return true;
			}
			$filename = PIRATEFORMS_DIR . 'admin/partials/' . $class1 . '.php';
			if ( is_readable( $filename ) ) {
				require_once $filename;

				return true;
			}
			$filename = PIRATEFORMS_DIR . 'public/' . $class1 . '.php';
			if ( is_readable( $filename ) ) {
				require_once $filename;

				return true;
			}

			$filename = PIRATEFORMS_DIR . 'public/partials/' . $class1 . '.php';
			if ( is_readable( $filename ) ) {
				require_once $filename;

				return true;
			}
		}

		$filename = PIRATEFORMS_DIR . 'includes/class-pirateforms-widget.php';
		if ( is_readable( $filename ) ) {
			require_once $filename;

			return true;
		}
	}// End foreach().

	return false;
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_pirate_forms() {

	$plugin = new PirateForms();
	$plugin->run();

	$vendor_file = PIRATEFORMS_DIR . '/vendor/autoload_52.php';
	if ( is_readable( $vendor_file ) ) {
		require_once $vendor_file;
	}
	add_filter(
		'themeisle_sdk_products', function ( $products ) {
			$products[] = PIRATEFORMS_BASEFILE;
			return $products;
		}
	);
	add_filter(
		'pirate_parrot_log', function ( $plugins ) {
			$plugins[] = PIRATEFORMS_NAME;
			return $plugins;
		}
	);
}
spl_autoload_register( 'pirate_forms_autoload' );
run_pirate_forms();

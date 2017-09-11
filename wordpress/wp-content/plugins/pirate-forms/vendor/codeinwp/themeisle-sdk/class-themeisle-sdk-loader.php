<?php
/**
 * The main loader class for ThemeIsle SDK
 *
 * @package     ThemeIsleSDK
 * @subpackage  Loader
 * @copyright   Copyright (c) 2017, Marius Cristea
 * @license     http://opensource.org/licenses/gpl-3.0.php GNU Public License
 * @since       1.0.0
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'ThemeIsle_SDK_Loader' ) ) :
	/**
	 * Singleton loader for ThemeIsle SDK.
	 */
	final class ThemeIsle_SDK_Loader {
		/**
		 * @var ThemeIsle_SDK_Loader instance The singleton instance
		 */
		private static $instance;
		/**
		 * @var string $version The class version.
		 */
		private static $version = '1.0.0';
		/**
		 * @var array The products which use the SDK.
		 */
		private static $products;

		/**
		 * Register product into SDK.
		 *
		 * @param string $basefile The product basefile.
		 *
		 * @return ThemeIsle_SDK_Loader The singleton object.
		 */
		public static function init_product( $basefile ) {

			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof ThemeIsle_SDK_Loader ) ) {
				self::$instance = new ThemeIsle_SDK_Loader;

			}
			$product_object                                = new ThemeIsle_SDK_Product( $basefile );
			self::$products[ $product_object->get_slug() ] = $product_object;

			$notifications = array();
			// Based on the Wordpress Available file header we enable the logger or not.
			if ( ! $product_object->is_wordpress_available() ) {
				$licenser = new ThemeIsle_SDK_Licenser( $product_object );
				$licenser->enable();
			}

			$logger = new ThemeIsle_SDK_Logger( $product_object );
			if ( $product_object->is_logger_active() ) {
				$logger->enable();
			} else {
				$notifications[] = $logger;
			}

			$feedback = new ThemeIsle_SDK_Feedback_Factory( $product_object, $product_object->get_feedback_types() );

			$instances = $feedback->get_instances();
			if ( array_key_exists( 'review', $instances ) ) {
				$notifications[] = $instances['review'];
			}
			new ThemeIsle_SDK_Notification_Manager( $product_object, $notifications );
			if ( ! $product_object->is_external_author() ) {
				new ThemeIsle_SDK_Widgets_Factory( $product_object, $product_object->get_widget_types() );
			}

			return self::$instance;
		}

		/**
		 * Get all products using the SDK.
		 *
		 * @return array Products available.
		 */
		public static function get_products() {
			return self::$products;
		}


	}
endif;

<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    PirateForms
 * @subpackage PirateForms/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    PirateForms
 * @subpackage PirateForms/admin
 * @author     Your Name <email@example.com>
 */
class PirateForms_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles_and_scripts() {
		global $pagenow;
		if ( ! empty( $pagenow ) && ( $pagenow == 'options-general.php' || $pagenow == 'admin.php' )
			 && isset( $_GET['page'] ) && $_GET['page'] == 'pirateforms-admin'
		) {
			wp_enqueue_style( 'pirateforms_admin_styles', PIRATEFORMS_URL . 'admin/css/wp-admin.css', array(), $this->version );
			wp_enqueue_script( 'pirateforms_scripts_admin', PIRATEFORMS_URL . 'admin/js/scripts-admin.js', array( 'jquery' ), $this->version );
			wp_localize_script(
				'pirateforms_scripts_admin', 'cwp_top_ajaxload', array(
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
				)
			);
		}
	}


	/**
	 * Loads the sidebar
	 *
	 * @since    1.0.0
	 */
	public function load_sidebar() {
		ob_start();
		do_action( 'pirate_forms_load_sidebar_theme' );
		do_action( 'pirate_forms_load_sidebar_subscribe' );
		echo ob_get_clean();
	}

	/**
	 * Loads the theme-specific sidebar box
	 *
	 * @since    1.0.0
	 */
	public function load_sidebar_theme() {
		include_once PIRATEFORMS_DIR . 'admin/partials/pirateforms-settings-sidebar-theme.php';
	}

	/**
	 * Loads the sidebar subscription box
	 *
	 * @since    1.0.0
	 */
	public function load_sidebar_subscribe() {
		include_once PIRATEFORMS_DIR . 'admin/partials/pirateforms-settings-sidebar-subscribe.php';
	}

	/**
	 * Add the settings link in the plugin page
	 *
	 * @since    1.0.0
	 */
	public function add_settings_link( $links ) {
		$settings_link = '<a href="options-general.php?page=pirateforms-admin">' . __( 'Settings', 'pirate-forms' ) . '</a>';
		if ( function_exists( 'array_unshift' ) ) :
			array_unshift( $links, $settings_link );
		else :
			array_push( $links, $settings_link );
		endif;

		return $links;
	}

	/**
	 *
	 *  Add page to the dashbord menu
	 *
	 *  @since 1.0.0
	 */
	public function add_to_admin() {
		add_menu_page( PIRATEFORMS_NAME, PIRATEFORMS_NAME, 'manage_options', 'pirateforms-admin', array( $this, 'pirate_forms_admin' ), 'dashicons-feedback' );
		add_submenu_page( 'pirateforms-admin', PIRATEFORMS_NAME, __( 'Settings', 'pirate-forms' ), 'manage_options', 'pirateforms-admin', array( $this, 'pirate_forms_admin' ) );
	}


	/**
	 *  Admin area setting page for the plugin
	 *
	 * @since 1.0.0
	 */
	function pirate_forms_admin() {
		global $current_user;
		$pirate_forms_options = PirateForms_Util::get_option();
		$plugin_options       = $this->pirate_forms_plugin_options();
		include_once PIRATEFORMS_DIR . 'admin/partials/pirateforms-settings-display.php';
	}
	/**
	 * ******** Save default options if none exist ***********/
	public function settings_init() {
		if ( ! PirateForms_Util::get_option() ) {
			$new_opt = array();
			foreach ( $this->pirate_forms_plugin_options() as $tab => $array ) {
				foreach ( $array['controls'] as $controls ) {
					$new_opt[ $controls['id'] ] = isset( $controls['default'] ) ? $controls['default'] : '';
				}
			}
			PirateForms_Util::set_option( $new_opt );
		}
	}

	/**
	 * Get the list of all pages
	 *
	 * @since    1.0.0
	 */
	function pirate_forms_get_pages_array( $type = 'page' ) {
		$content = array(
			'' => __( 'None', 'pirate-forms' ),
		);
		$items   = get_posts(
			array(
				'post_type'   => $type,
				'numberposts' => - 1,
			)
		);
		if ( ! empty( $items ) ) :
			foreach ( $items as $item ) :
				$content[ $item->ID ] = $item->post_title;
			endforeach;
		endif;

		return $content;

	}

	/**
	 *
	 * OPTIONS
	 *
	 * @since 1.0.0
	 * name; id; desc; type; default; options
	 */
	function pirate_forms_plugin_options() {
		/**
		 **********  Default values from Zerif Lite */
		$zerif_contactus_sitekey = get_theme_mod( 'zerif_contactus_sitekey' );
		if ( ! empty( $zerif_contactus_sitekey ) ) :
			$pirate_forms_contactus_sitekey = $zerif_contactus_sitekey;
		else :
			$pirate_forms_contactus_sitekey = '';
		endif;
		$zerif_contactus_secretkey = get_theme_mod( 'zerif_contactus_secretkey' );
		if ( ! empty( $zerif_contactus_secretkey ) ) :
			$pirate_forms_contactus_secretkey = $zerif_contactus_secretkey;
		else :
			$pirate_forms_contactus_secretkey = '';
		endif;
		$zerif_contactus_recaptcha_show = get_theme_mod( 'zerif_contactus_recaptcha_show' );
		if ( isset( $zerif_contactus_recaptcha_show ) && ( $zerif_contactus_recaptcha_show == '1' ) ) :
			$pirate_forms_contactus_recaptcha_show = '';
		else :
			$pirate_forms_contactus_recaptcha_show = 'yes';
		endif;
		$zerif_contactus_button_label = get_theme_mod( 'zerif_contactus_button_label', __( 'Send Message', 'pirate-forms' ) );
		if ( ! empty( $zerif_contactus_button_label ) ) :
			$pirate_forms_contactus_button_label = $zerif_contactus_button_label;
		else :
			$pirate_forms_contactus_button_label = __( 'Send Message', 'pirate-forms' );
		endif;
		$zerif_contactus_email        = get_theme_mod( 'zerif_contactus_email' );
		$zerif_email                  = get_theme_mod( 'zerif_email' );
		$pirate_forms_contactus_email = '';
		if ( ! empty( $zerif_contactus_email ) ) :
			$pirate_forms_contactus_email = $zerif_contactus_email;
		elseif ( ! empty( $zerif_email ) ) :
			$pirate_forms_contactus_email = $zerif_email;
		else :
			$pirate_forms_contactus_email = get_bloginfo( 'admin_email' );
		endif;

		// the key(s) will be added to the div as class names
		// to enable tooltip popup add 'pirate_dashicons'
		return apply_filters(
			'pirate_forms_admin_controls', array(
				'pirate_options pirate_dashicons' => array(
					'heading'   => __( 'Form processing options', 'pirate-forms' ),
					'controls'  => apply_filters(
						'pirate_forms_admin_controls_for_options', array(
							array(
								'id'        => 'pirateformsopt_email',
								'type'      => 'text',
								'label'     => array(
									'value' => __( 'Contact notification sender email', 'pirate-forms' ),
									'html'  => '<span class="dashicons dashicons-editor-help"></span>',
									'desc'      => array(
										'value' => '<strong>' . __( "Insert [email] to use the contact form submitter's email.", 'pirate-forms' ) . '</strong><br>' . __( "Email to use for the sender of the contact form emails both to the recipients below and the contact form submitter (if this is activated below). The domain for this email address should match your site's domain.", 'pirate-forms' ),
										'class' => 'pirate_forms_option_description',
									),
								),
								'default'   => PirateForms_Util::get_from_email(),
								'value'     => PirateForms_Util::get_option( 'pirateformsopt_email' ),
								'wrap'      => array(
									'type'  => 'div',
									'class' => 'pirate-forms-grouped',
								),
								'class'     => 'widefat',
							),
							array(
								'id'        => 'pirateformsopt_email_recipients',
								'type'      => 'text',
								'label'     => array(
									'value' => __( 'Contact submission recipients', 'pirate-forms' ),
									'html'  => '<span class="dashicons dashicons-editor-help"></span>',
									'desc'      => array(
										'value' => __( 'Email address(es) to receive contact submission notifications. You can separate multiple emails with a comma.', 'pirate-forms' ),
										'class' => 'pirate_forms_option_description',
									),
								),
								'default'   => $pirate_forms_contactus_email,
								'value'     => PirateForms_Util::get_option( 'pirateformsopt_email_recipients' ),
								'wrap'      => array(
									'type'  => 'div',
									'class' => 'pirate-forms-grouped',
								),
								'class'     => 'widefat',
							),
							array(
								'id'        => 'pirateformsopt_store',
								'type'      => 'checkbox',
								'label'     => array(
									'value' => __( 'Store submissions in the database', 'pirate-forms' ),
									'html'  => '<span class="dashicons dashicons-editor-help"></span>',
									'desc'      => array(
										'value' => __( 'Should the submissions be stored in the admin area? If chosen, contact form submissions will be saved in Contacts on the left (appears after this option is activated).', 'pirate-forms' ),
										'class' => 'pirate_forms_option_description',
									),
								),
								'default'   => 'yes',
								'value'     => PirateForms_Util::get_option( 'pirateformsopt_store' ),
								'wrap'      => array(
									'type'  => 'div',
									'class' => 'pirate-forms-grouped',
								),
								'options'   => array( 'yes' => __( 'Yes', 'pirate-forms' ) ),
							),
							array(
								'id'        => 'pirateformsopt_nonce',
								'type'      => 'checkbox',
								'label'     => array(
									'value' => __( 'Add a nonce to the contact form:', 'pirate-forms' ),
									'html'  => '<span class="dashicons dashicons-editor-help"></span>',
									'desc'      => array(
										'value' => __( 'Should the form use a WordPress nonce? This helps reduce spam by ensuring that the form submittor is on the site when submitting the form rather than submitting remotely. This could, however, cause problems with sites using a page caching plugin. Turn this off if you are getting complaints about forms not being able to be submitted with an error of "Nonce failed!"', 'pirate-forms' ),
										'class' => 'pirate_forms_option_description',
									),
								),
								'default'   => 'yes',
								'value'     => PirateForms_Util::get_option( 'pirateformsopt_nonce' ),
								'wrap'      => array(
									'type'  => 'div',
									'class' => 'pirate-forms-grouped',
								),
								'options'   => array( 'yes' => __( 'Yes', 'pirate-forms' ) ),
							),
							array(
								'id'        => 'pirateformsopt_confirm_email',
								'type'      => 'textarea',
								'label'     => array(
									'value' => __( 'Send email confirmation to form submitter', 'pirate-forms' ),
									'html'  => '<span class="dashicons dashicons-editor-help"></span>',
									'desc'      => array(
										'value' => __( 'Adding text here will send an email to the form submitter. The email uses the "Successful form submission text" field from the "Alert Messages" tab as the subject line. Plain text only here, no HTML.', 'pirate-forms' ),
										'class' => 'pirate_forms_option_description',
									),
								),
								'value'     => PirateForms_Util::get_option( 'pirateformsopt_confirm_email' ),
								'wrap'      => array(
									'type'  => 'div',
									'class' => 'pirate-forms-grouped',
								),
								'class'     => 'widefat',
								'cols'      => 30,
								'rows'      => 5,
							),
							array(
								'id'        => 'pirateformsopt_thank_you_url',
								'type'      => 'select',
								'label'     => array(
									'value' => __( '"Thank You" URL', 'pirate-forms' ),
									'html'  => '<span class="dashicons dashicons-editor-help"></span>',
									'desc'      => array(
										'value' => __( 'Select the post-submit page for all forms submitted', 'pirate-forms' ),
										'class' => 'pirate_forms_option_description',
									),
								),
								'value'     => PirateForms_Util::get_option( 'pirateformsopt_thank_you_url' ),
								'wrap'      => array(
									'type'  => 'div',
									'class' => 'pirate-forms-grouped',
								),
								'options'   => $this->pirate_forms_get_pages_array(),
							),
						)
					),
				),
				'pirate_fields pirate_dashicons'  => array(
					'heading'   => __( 'Fields Settings', 'pirate-forms' ),
					'controls'  => apply_filters(
						'pirate_forms_admin_controls_for_fields', array(
							/* Name */
							array(
								'id'        => 'pirateformsopt_name_field',
								'type'      => 'select',
								'label'     => array(
									'value' => __( 'Name', 'pirate-forms' ),
									'html'  => '<span class="dashicons dashicons-editor-help"></span>',
									'desc'      => array(
										'value' => __( 'Do you want the name field to be displayed?', 'pirate-forms' ),
										'class' => 'pirate_forms_option_description',
									),
								),
								'default'   => 'req',
								'value'     => PirateForms_Util::get_option( 'pirateformsopt_name_field' ),
								'wrap'      => array(
									'type'  => 'div',
									'class' => 'pirate-forms-grouped',
								),
								'options'   => array(
									''    => __( 'None', 'pirate-forms' ),
									'yes' => __( 'Yes but not required', 'pirate-forms' ),
									'req' => __( 'Required', 'pirate-forms' ),
								),
							),
							/* Email */
							array(
								'id'        => 'pirateformsopt_email_field',
								'type'      => 'select',
								'label'     => array(
									'value' => __( 'Email address', 'pirate-forms' ),
									'html'  => '<span class="dashicons dashicons-editor-help"></span>',
									'desc'      => array(
										'value' => __( 'Do you want the email address field be displayed?', 'pirate-forms' ),
										'class' => 'pirate_forms_option_description',
									),
								),
								'default'   => 'req',
								'value'     => PirateForms_Util::get_option( 'pirateformsopt_email_field' ),
								'wrap'      => array(
									'type'  => 'div',
									'class' => 'pirate-forms-grouped',
								),
								'options'   => array(
									''    => __( 'None', 'pirate-forms' ),
									'yes' => __( 'Yes but not required', 'pirate-forms' ),
									'req' => __( 'Required', 'pirate-forms' ),
								),
							),
							/* Subject */
							array(
								'id'        => 'pirateformsopt_subject_field',
								'type'      => 'select',
								'label'     => array(
									'value' => __( 'Subject', 'pirate-forms' ),
									'html'  => '<span class="dashicons dashicons-editor-help"></span>',
									'desc'      => array(
										'value' => __( 'Do you want the subject field be displayed?', 'pirate-forms' ),
										'class' => 'pirate_forms_option_description',
									),
								),
								'default'   => 'req',
								'value'     => PirateForms_Util::get_option( 'pirateformsopt_subject_field' ),
								'wrap'      => array(
									'type'  => 'div',
									'class' => 'pirate-forms-grouped',
								),
								'options'   => array(
									''    => __( 'None', 'pirate-forms' ),
									'yes' => __( 'Yes but not required', 'pirate-forms' ),
									'req' => __( 'Required', 'pirate-forms' ),
								),
							),
							/* Message */
							array(
								'id'        => 'pirateformsopt_message_field',
								'type'      => 'select',
								'label'     => array(
									'value' => __( 'Message', 'pirate-forms' ),
								),
								'default'   => 'req',
								'value'     => PirateForms_Util::get_option( 'pirateformsopt_message_field' ),
								'wrap'      => array(
									'type'  => 'div',
									'class' => 'pirate-forms-grouped',
								),
								'options'   => array(
									''    => __( 'None', 'pirate-forms' ),
									'yes' => __( 'Yes but not required', 'pirate-forms' ),
									'req' => __( 'Required', 'pirate-forms' ),
								),
							),
							/* Attachment */
							array(
								'id'        => 'pirateformsopt_attachment_field',
								'type'      => 'select',
								'label'     => array(
									'value' => __( 'Attachment', 'pirate-forms' ),
								),
								'value'     => PirateForms_Util::get_option( 'pirateformsopt_attachment_field' ),
								'wrap'      => array(
									'type'  => 'div',
									'class' => 'pirate-forms-grouped',
								),
								'options'   => array(
									''    => __( 'None', 'pirate-forms' ),
									'no' => __( 'No', 'pirate-forms' ),
									'yes' => __( 'Yes but not required', 'pirate-forms' ),
									'req' => __( 'Required', 'pirate-forms' ),
								),
							),
							/* Recaptcha */
							array(
								'id'        => 'pirateformsopt_recaptcha_field',
								'type'      => 'checkbox',
								'label'     => array(
									'value' => __( 'Add a reCAPTCHA', 'pirate-forms' ),
								),
								'default'   => $pirate_forms_contactus_recaptcha_show,
								'value'     => PirateForms_Util::get_option( 'pirateformsopt_recaptcha_field' ),
								'wrap'      => array(
									'type'  => 'div',
									'class' => 'pirate-forms-grouped',
								),
								'options'   => array(
									'yes' => __( 'Yes', 'pirate-forms' ),
								),
							),
							/* Site key */
							array(
								'id'        => 'pirateformsopt_recaptcha_sitekey',
								'type'      => 'text',
								'label'     => array(
									'value' => __( 'Site key', 'pirate-forms' ),
									'html'  => '<span class="dashicons dashicons-editor-help"></span>',
									'desc'      => array(
										'value' => '<a href="https://www.google.com/recaptcha/admin#list" target="_blank">' . __( 'Create an account here ', 'pirate-forms' ) . '</a>' . __( 'to get the Site key and the Secret key for the reCaptcha.', 'pirate-forms' ),
										'class' => 'pirate_forms_option_description',
									),
								),
								'default'   => $pirate_forms_contactus_sitekey,
								'value'     => PirateForms_Util::get_option( 'pirateformsopt_recaptcha_sitekey' ),
								'wrap'      => array(
									'type'  => 'div',
									'class' => 'pirate-forms-grouped',
								),
							),
							/* Secret key */
							array(
								'id'        => 'pirateformsopt_recaptcha_secretkey',
								'type'      => 'password',
								'label'     => array(
									'value' => __( 'Secret key', 'pirate-forms' ),
								),
								'default'   => $pirate_forms_contactus_secretkey,
								'value'     => PirateForms_Util::get_option( 'pirateformsopt_recaptcha_secretkey' ),
								'wrap'      => array(
									'type'  => 'div',
									'class' => 'pirate-forms-grouped',
								),
							),
						)
					),
				),
				'pirate_labels' => array(
					'heading'   => __( 'Fields Labels', 'pirate-forms' ),
					'controls'  => apply_filters(
						'pirate_forms_admin_controls_for_field_labels', array(
							array(
								'id'        => 'pirateformsopt_label_name',
								'type'      => 'text',
								'label'     => array(
									'value' => __( 'Name', 'pirate-forms' ),
								),
								'default'   => __( 'Your Name', 'pirate-forms' ),
								'value'     => PirateForms_Util::get_option( 'pirateformsopt_label_name' ),
								'wrap'      => array(
									'type'  => 'div',
									'class' => 'pirate-forms-grouped',
								),
							),
							array(
								'id'        => 'pirateformsopt_label_email',
								'type'      => 'text',
								'label'     => array(
									'value' => __( 'Email', 'pirate-forms' ),
								),
								'default'   => __( 'Your Email', 'pirate-forms' ),
								'value'     => PirateForms_Util::get_option( 'pirateformsopt_label_email' ),
								'wrap'      => array(
									'type'  => 'div',
									'class' => 'pirate-forms-grouped',
								),
							),
							array(
								'id'        => 'pirateformsopt_label_subject',
								'type'      => 'text',
								'label'     => array(
									'value' => __( 'Subject', 'pirate-forms' ),
								),
								'default'   => __( 'Subject', 'pirate-forms' ),
								'value'     => PirateForms_Util::get_option( 'pirateformsopt_label_subject' ),
								'wrap'      => array(
									'type'  => 'div',
									'class' => 'pirate-forms-grouped',
								),
							),
							array(
								'id'        => 'pirateformsopt_label_message',
								'type'      => 'text',
								'label'     => array(
									'value' => __( 'Message', 'pirate-forms' ),
								),
								'default'   => __( 'Your message', 'pirate-forms' ),
								'value'     => PirateForms_Util::get_option( 'pirateformsopt_label_message' ),
								'wrap'      => array(
									'type'  => 'div',
									'class' => 'pirate-forms-grouped',
								),
							),
							array(
								'id'        => 'pirateformsopt_label_submit_btn',
								'type'      => 'text',
								'label'     => array(
									'value' => __( 'Submit button', 'pirate-forms' ),
								),
								'default'   => $pirate_forms_contactus_button_label,
								'value'     => PirateForms_Util::get_option( 'pirateformsopt_label_submit_btn' ),
								'wrap'      => array(
									'type'  => 'div',
									'class' => 'pirate-forms-grouped',
								),
							),
						)
					),
				),
				'pirate_alerts pirate_dashicons'  => array(
					'heading'   => __( 'Alert Messages', 'pirate-forms' ),
					'controls'  => apply_filters(
						'pirate_forms_admin_controls_for_alerts', array(
							array(
								'id'        => 'pirateformsopt_label_err_name',
								'type'      => 'text',
								'label'     => array(
									'value' => __( 'Name required and missing', 'pirate-forms' ),
								),
								'default'   => __( 'Enter your name', 'pirate-forms' ),
								'value'     => PirateForms_Util::get_option( 'pirateformsopt_label_err_name' ),
								'wrap'      => array(
									'type'  => 'div',
									'class' => 'pirate-forms-grouped',
								),
							),
							array(
								'id'        => 'pirateformsopt_label_err_email',
								'type'      => 'text',
								'label'     => array(
									'value' => __( 'E-mail required and missing', 'pirate-forms' ),
								),
								'default'   => __( 'Enter valid email', 'pirate-forms' ),
								'value'     => PirateForms_Util::get_option( 'pirateformsopt_label_err_email' ),
								'wrap'      => array(
									'type'  => 'div',
									'class' => 'pirate-forms-grouped',
								),
							),
							array(
								'id'        => 'pirateformsopt_label_err_subject',
								'type'      => 'text',
								'label'     => array(
									'value' => __( 'Subject required and missing', 'pirate-forms' ),
								),
								'default'   => __( 'Please enter a subject', 'pirate-forms' ),
								'value'     => PirateForms_Util::get_option( 'pirateformsopt_label_err_subject' ),
								'wrap'      => array(
									'type'  => 'div',
									'class' => 'pirate-forms-grouped',
								),
							),
							array(
								'id'        => 'pirateformsopt_label_err_no_content',
								'type'      => 'text',
								'label'     => array(
									'value' => __( 'Question/comment is missing', 'pirate-forms' ),
								),
								'default'   => __( 'Enter your question or comment', 'pirate-forms' ),
								'value'     => PirateForms_Util::get_option( 'pirateformsopt_label_err_no_content' ),
								'wrap'      => array(
									'type'  => 'div',
									'class' => 'pirate-forms-grouped',
								),
							),
							array(
								'id'        => 'pirateformsopt_label_err_no_attachment',
								'type'      => 'text',
								'label'     => array(
									'value' => __( 'Attachment is missing', 'pirate-forms' ),
								),
								'default'   => __( 'Please add an attachment', 'pirate-forms' ),
								'value'     => PirateForms_Util::get_option( 'pirateformsopt_label_err_no_attachment' ),
								'wrap'      => array(
									'type'  => 'div',
									'class' => 'pirate-forms-grouped',
								),
							),
							array(
								'id'        => 'pirateformsopt_label_submit',
								'type'      => 'text',
								'label'     => array(
									'value' => __( 'Successful form submission text', 'pirate-forms' ),
									'html'  => '<span class="dashicons dashicons-editor-help"></span>',
									'desc'      => array(
										'value' => __( 'This text is used on the page if no "Thank You" URL is set above. This is also used as the confirmation email title, if one is set to send out.', 'pirate-forms' ),
										'class' => 'pirate_forms_option_description',
									),
								),
								'default'   => __( 'Thanks, your email was sent successfully!', 'pirate-forms' ),
								'value'     => PirateForms_Util::get_option( 'pirateformsopt_label_submit' ),
								'wrap'      => array(
									'type'  => 'div',
									'class' => 'pirate-forms-grouped',
								),
							),
						)
					),
				),
				'pirate_smtp pirate_dashicons'  => array(
					'heading'   => __( 'SMTP Options', 'pirate-forms' ),
					'controls'  => apply_filters(
						'pirate_forms_admin_controls_for_smtp', array(
							array(
								'id'        => 'pirateformsopt_use_smtp',
								'type'      => 'checkbox',
								'label'     => array(
									'value' => __( 'Use SMTP to send emails?', 'pirate-forms' ),
									'html'  => '<span class="dashicons dashicons-editor-help"></span>',
									'desc'      => array(
										'value' => __( 'Instead of PHP mail function', 'pirate-forms' ),
										'class' => 'pirate_forms_option_description',
									),
								),
								'value'     => PirateForms_Util::get_option( 'pirateformsopt_use_smtp' ),
								'wrap'      => array(
									'type'  => 'div',
									'class' => 'pirate-forms-grouped',
								),
								'options'   => array( 'yes' => __( 'Yes', 'pirate-forms' ) ),
							),
							array(
								'id'        => 'pirateformsopt_smtp_host',
								'type'      => 'text',
								'label'     => array(
									'value' => __( 'SMTP Host', 'pirate-forms' ),
								),
								'value'     => PirateForms_Util::get_option( 'pirateformsopt_smtp_host' ),
								'wrap'      => array(
									'type'  => 'div',
									'class' => 'pirate-forms-grouped',
								),
							),
							array(
								'id'        => 'pirateformsopt_smtp_port',
								'type'      => 'text',
								'label'     => array(
									'value' => __( 'SMTP Port', 'pirate-forms' ),
								),
								'value'     => PirateForms_Util::get_option( 'pirateformsopt_smtp_port' ),
								'wrap'      => array(
									'type'  => 'div',
									'class' => 'pirate-forms-grouped',
								),
							),
							array(
								'id'        => 'pirateformsopt_use_smtp_authentication',
								'type'      => 'checkbox',
								'label'     => array(
									'value' => __( 'Use SMTP Authentication?', 'pirate-forms' ),
									'html'  => '<span class="dashicons dashicons-editor-help"></span>',
									'desc'      => array(
										'value' => __( 'If you check this box, make sure the SMTP Username and SMTP Password are completed.', 'pirate-forms' ),
										'class' => 'pirate_forms_option_description',
									),
								),
								'default'   => 'yes',
								'value'     => PirateForms_Util::get_option( 'pirateformsopt_use_smtp_authentication' ),
								'wrap'      => array(
									'type'  => 'div',
									'class' => 'pirate-forms-grouped',
								),
								'options'   => array( 'yes' => __( 'Yes', 'pirate-forms' ) ),
							),
							array(
								'id'        => 'pirateformsopt_use_secure',
								'type'      => 'radio',
								'label'     => array(
									'value' => __( 'Security?', 'pirate-forms' ),
									'html'  => '<span class="dashicons dashicons-editor-help"></span>',
									'desc'      => array(
										'value' => __( 'If you check this box, make sure the SMTP Username and SMTP Password are completed.', 'pirate-forms' ),
										'class' => 'pirate_forms_option_description',
									),
								),
								'value'     => PirateForms_Util::get_option( 'pirateformsopt_use_secure' ),
								'wrap'      => array(
									'type'  => 'div',
									'class' => 'pirate-forms-grouped',
								),
								'options'   => array(
									''      => __( 'No', 'pirate-forms' ),
									'ssl'   => __( 'SSL', 'pirate-forms' ),
									'tls'   => __( 'TLS', 'pirate-forms' ),
								),
							),
							array(
								'id'        => 'pirateformsopt_smtp_username',
								'type'      => 'text',
								'label'     => array(
									'value' => __( 'SMTP Username', 'pirate-forms' ),
								),
								'value'     => PirateForms_Util::get_option( 'pirateformsopt_smtp_username' ),
								'wrap'      => array(
									'type'  => 'div',
									'class' => 'pirate-forms-grouped',
								),
							),
							array(
								'id'        => 'pirateformsopt_smtp_password',
								'type'      => 'password',
								'label'     => array(
									'value' => __( 'SMTP Password', 'pirate-forms' ),
								),
								'value'     => PirateForms_Util::get_option( 'pirateformsopt_smtp_password' ),
								'wrap'      => array(
									'type'  => 'div',
									'class' => 'pirate-forms-grouped',
								),
							),
						)
					),
				),
			)
		);
	}

	/**
	 * Save the data
	 *
	 * @since    1.0.0
	 */
	public function save_callback() {
		if ( isset( $_POST['dataSent'] ) ) :
			$dataSent = $_POST['dataSent'];
			$params   = array();
			if ( ! empty( $dataSent ) ) :
				parse_str( $dataSent, $params );
			endif;
			if ( ! empty( $params ) ) :
				/**
				 ****** Important fix for saving inputs of type checkbox */
				if ( ! isset( $params['pirateformsopt_store'] ) ) {
					$params['pirateformsopt_store'] = '';
				}
				if ( ! isset( $params['pirateformsopt_recaptcha_field'] ) ) {
					$params['pirateformsopt_recaptcha_field'] = '';
				}
				if ( ! isset( $params['pirateformsopt_nonce'] ) ) {
					$params['pirateformsopt_nonce'] = '';
				}
				if ( ! isset( $params['pirateformsopt_attachment_field'] ) ) {
					$params['pirateformsopt_attachment_field'] = '';
				}
				if ( ! isset( $params['pirateformsopt_use_smtp'] ) ) {
					$params['pirateformsopt_use_smtp'] = '';
				}
				if ( ! isset( $params['pirateformsopt_use_smtp_authentication'] ) ) {
					$params['pirateformsopt_use_smtp_authentication'] = '';
				}
				PirateForms_Util::set_option( $params );
				$pirate_forms_zerif_lite_mods = get_option( 'theme_mods_zerif-lite' );
				if ( empty( $pirate_forms_zerif_lite_mods ) ) :
					$pirate_forms_zerif_lite_mods = array();
				endif;
				if ( isset( $params['pirateformsopt_label_submit_btn'] ) ) :
					$pirate_forms_zerif_lite_mods['zerif_contactus_button_label'] = $params['pirateformsopt_label_submit_btn'];
				endif;
				if ( isset( $params['pirateformsopt_email'] ) ) :
					$pirate_forms_zerif_lite_mods['zerif_contactus_email'] = $params['pirateformsopt_email'];
				endif;
				if ( isset( $params['pirateformsopt_email_recipients'] ) ) :
					$pirate_forms_zerif_lite_mods['zerif_contactus_email'] = $params['pirateformsopt_email_recipients'];
				endif;
				if ( isset( $params['pirateformsopt_recaptcha_field'] ) && ( $params['pirateformsopt_recaptcha_field'] == 'yes' ) ) :
					$pirate_forms_zerif_lite_mods['zerif_contactus_recaptcha_show'] = 0;
				else :
					$pirate_forms_zerif_lite_mods['zerif_contactus_recaptcha_show'] = 1;
				endif;
				if ( isset( $params['pirateformsopt_recaptcha_sitekey'] ) ) :
					$pirate_forms_zerif_lite_mods['zerif_contactus_sitekey'] = $params['pirateformsopt_recaptcha_sitekey'];
				endif;
				if ( isset( $params['pirateformsopt_recaptcha_secretkey'] ) ) :
					$pirate_forms_zerif_lite_mods['zerif_contactus_secretkey'] = $params['pirateformsopt_recaptcha_secretkey'];
				endif;
				update_option( 'theme_mods_zerif-lite', $pirate_forms_zerif_lite_mods );
			endif;
		endif;
		die();

	}
}

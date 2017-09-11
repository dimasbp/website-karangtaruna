<?php

/**
 * Provide a public-facing view for the form
 *
 * This file provide a public-facing view for the form
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    PirateForms
 * @subpackage PirateForms/public/partials
 */
?>

<?php
if ( ! empty( $this->thank_you_message ) ) :
	?>
	<div class="col-sm-12 col-lg-12 pirate_forms_thankyou_wrap">
		<p><?php echo $this->thank_you_message; ?></p>
	</div>
<?php endif; ?>

<div class="pirate_forms_wrap">
	<?php
	$output = '';
	if ( ! empty( $this->errors ) ) :
		$output .= '<div class="col-sm-12 col-lg-12 pirate_forms_error_box">';
		$output .= '<p>' . __( 'Sorry, an error occured.', 'pirate-forms' ) . '</p>';
		$output .= '</div>';
		foreach ( $this->errors as $err ) :
			$output .= '<div class="col-sm-12 col-lg-12 pirate_forms_error_box">';
			$output .= "<p>$err</p>";
			$output .= '</div>';
		endforeach;

	endif;

	echo $output;
	?>

	<?php echo $this->form_start; ?>

	<div class="pirate_forms_three_inputs_wrap">
		<?php echo $this->contact_name; ?>

		<?php echo $this->contact_email; ?>

		<?php echo $this->contact_subject; ?>
	</div>

		<?php echo $this->contact_message; ?>


	<?php if ( isset( $this->attachment ) ) { ?>
		<div class="col-sm-12 col-lg-12 form_field_wrap contact_attachment_wrap  ">
			<?php echo $this->attachment; ?>
		</div>
	<?php } ?>

	<?php if ( isset( $this->captcha ) ) { ?>
		<div class="col-xs-12 col-sm-6 col-lg-6 form_field_wrap form_captcha_wrap">
			<?php echo $this->captcha; ?>
		</div>
	<?php } ?>

		<?php echo $this->contact_submit; ?>


	<?php echo $this->form_end; ?>
	<div class="pirate_forms_clearfix"></div>
</div>

<?php

/**
 * Handles updating and calculating calculated fields
 *
 * @since 1.6.0
 *
 */
class AF_Pro_Core_Calculated {

  function __construct() {
    add_filter( 'af/form/valid_form', array( $this, 'valid_form' ), 10, 1 );
    add_filter( 'af/form/from_post', array( $this, 'form_from_post' ), 10, 2 );
    add_filter( 'af/form/to_post', array( $this, 'form_to_post' ), 10, 2 );

    add_action( 'wp_ajax_af_calculated_field', array( $this, 'ajax_update_field' ), 10, 0 );
    add_action( 'wp_ajax_nopriv_af_calculated_field', array( $this, 'ajax_update_field' ), 10, 0 );
  }

  function valid_form( $form ) {
    $form['calculated'] = array();

    return $form;
  }

  function form_from_post( $form, $post ) {
    $calculated_fields = get_field( 'field_form_calculated_fields', $post->ID );

    if ( $calculated_fields && ! empty( $calculated_fields ) ) {
      $form['calculated'] = $calculated_fields;
    }

    return $form;
  }

  function form_to_post( $form, $post ) {
    update_field( 'field_form_calculated_fields', $form['calculated'], $post->ID );
  }

  /**
   * AJAX handler called to update a calculated field.
   * Outputs the calculated contents of the field.
   *
   * @since 1.6.0
   *
   */
  function ajax_update_field() {
    // Create a submission object from the submitted data (no validation though)
    $submission = AF()->classes['core_forms_submissions']->create_submission();

    // Set global submission object to make af_get_field work as expected
    AF()->submission = $submission;

    $calculated_settings = $submission['form']['calculated'];

	// Get all the calculated fields that need to be calculated
	$field_keys = explode( ',', $_POST['calculated_fields'] );

	// Sort $field_keys according to $calculated_settings.
	$field_keys_sorted = [];
	foreach ( $calculated_settings as $key => $value ) {
		  if( in_array( $key, $field_keys ) ) {
			  $field_keys_sorted[] = $key;
		  }
	}

	$values = array();

	  // Calculate the value for each calculated field in the form
	foreach ( $field_keys_sorted as $field_key ) {
		$field = get_field_object( $field_key );

		$value = '';
		if ( isset( $calculated_settings[ $field_key ] ) ) {
			// Calculate the field contents
			$calculated_definition = $calculated_settings[ $field_key ];
			$value = af_resolve_merge_tags( $calculated_definition );
		}

		// Allow filtering of the calculated value before returning
		$value = apply_filters( 'af/field/calculate_value', $value, $field, $submission['form'], $submission['args'] );
		$value = apply_filters( 'af/field/calculate_value/name=' . $field['name'], $value, $field, $submission['form'], $submission['args'] );
		$value = apply_filters( 'af/field/calculate_value/key=' . $field['key'], $value, $field, $submission['form'], $submission['args'] );

		// Update the submission object with the calculated value. This allows calculated fields to use other calculated
		// fields within their calculations (aggregate field support).
		foreach ( $submission['fields'] as $index => $submission_field ) {
			if ( $submission_field['key'] == $field_key ) {
				AF()->submission['fields'][ $index ]['value'] = $value;
				break;
			}
		}

		$values[ $field_key ] = $value;
	}

	echo json_encode( $values );
	wp_die();
  }
}

new AF_Pro_Core_Calculated();
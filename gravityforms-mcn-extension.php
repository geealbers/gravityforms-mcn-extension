<?php
/**
 * Plugin Name: Gravity Forms MCN Extension
 * Description: Functions customizing the Gravity Forms plugin
 * Author: Greg Albers
 * Version: 0.1
 *
 * Specifically, this adds count mechanisms to the form built for crowdsourcing
 * the 50th aniversary video, produced in the fall of 2016.
 *
 */

add_action( 'wp_enqueue_scripts', 'register_plugin_styles' );

function register_plugin_styles() {
	wp_register_style( 'gravityforms-mcn-extension', plugins_url( 'gravityforms-mcn-extension/styles/gravityforms-mcn-extension.css' ) );
	wp_enqueue_style( 'gravityforms-mcn-extension' );
};

 add_filter( 'gform_field_choice_markup_pre_render_1', function ( $choice_markup, $choice, $field, $value ) {
    if ( $field->get_input_type() == 'radio' ) {
        $search_criteria['field_filters'][] = array( 'key' => '1', 'value' => $choice['text'] );
        $entry_counts = GFAPI::count_entries( 1, $search_criteria );
        $tally = str_repeat(" &#9733;",$entry_counts);
        $new_string = sprintf( '>%s %s<', $choice['text'], $tally );
        return str_replace( ">{$choice['text']}<", $new_string, $choice_markup );
    }

    return $choice_markup;
 }, 10, 4 );

?>

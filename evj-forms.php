<?php
/*
Plugin Name: EVJ Forms
Description: Quickly and easily create forms for evj events
Version: 1.0.0
Author URI: https://sp-universe.com
Author: SP Universe
Text Domain: evj-forms
*/

/*
	Copyright 2021 EvJ Forms

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
*/

function html_form_code() {
	include("form.html");
}

function deliver_mail() {

	// if the submit button is clicked, send the email
	if ( isset( $_POST['cf-submitted'] ) ) {

		// sanitize form values
		$name    = sanitize_text_field( $_POST["cf-name"] );
		$email   = sanitize_email( $_POST["cf-email"] );
		$subject = sanitize_text_field( $_POST["cf-subject"] );
		$message = esc_textarea( $_POST["cf-message"] );

		// get the blog administrator's email address
		$to = get_option( 'admin_email' );

		$headers = "From: $name <$email>" . "\r\n";

		// If email has been process for sending, display a success message
		if ( wp_mail( $to, $subject, $message, $headers ) ) {
			echo '<div>';
			echo '<p>Thanks for contacting me, expect a response soon.</p>';
			echo '</div>';
		} else {
			echo 'An unexpected error occurred';
		}
	}
}

function evjf_shortcode() {
	ob_start();
	deliver_mail();
	html_form_code();

	return ob_get_clean();
}

add_shortcode( 'evj_form', 'evjf_shortcode' );

function my_styles() {
	wp_register_style( 'evj_form', '/evj_form_styles.css' );
	wp_enqueue_style( 'evj_form' );
}
add_action('wp_enqueue_scripts', 'my_styles');


add_action('init', 'register_script');
function register_script() {
    wp_register_style( 'evj_form', plugins_url('/css/evj_form_styles.css', __FILE__), false, '1.0.0', 'all');
	wp_enqueue_script( 'evj_agecheck', plugins_url('/js/checks.js', __FILE__));
}

// use the registered jquery and style above
add_action('wp_enqueue_scripts', 'enqueue_style');
 
function enqueue_style(){
	wp_enqueue_style( 'evj_form' );
}

?>
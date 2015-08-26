<?php
/**
 * @package Intoto
 * @version 1.0
 */
/*
Plugin Name: Intoto Form Submitter
Description: Send every contact form submission to into.to CRM system to open new customer lead entry
Author: Roi Kedem
Version: 1.0
Author URI: http://into.to
*/

//wpcf7_before_send_mail

function wpcf7_send_to_intoto ($WPCF7_ContactForm) {
	file_put_contents("/tmp/wpcf8.debug", "debug:\n", FILE_APPEND);
	$submission = WPCF7_Submission::get_instance();
	$data = $submission->get_posted_data();
	#file_put_contents("/tmp/wpcf8.debug", print_r($data, true),  FILE_APPEND);
	#Remarks/message
	#Email/email
	#MobilePhone / phone
	#FirstName / name
#	$url = 'https://ormil_staging.into.to/react/contact_us_form';
	$url = 'https://ormil.into.to/react/contact_us_form';

	// use key 'http' even if you send the request to https://...
	$options = array(
		'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'POST',
			'content' => http_build_query($data),
		),
	);
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);

//	var_dump($result);	
	return $WPCF7_ContactForm;
}

add_action("wpcf7_before_send_mail", "wpcf7_send_to_intoto");
?>

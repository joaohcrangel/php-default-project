<?php

require_once('../../../include/phpmailer/PHPMailerAutoload.php');

$toemails = array();

$toemails[] = array(
				'email' => 'username@website.com', // Your Email Address
				'name' => 'Your Name' // Your Name
			);

// Form Processing Messages
$message_success = 'We have <strong>successfully</strong> received your Appointment Request and will get Back with a Confirmation as soon as possible.';

// Add this only if you use reCaptcha with your Contact Forms
$recaptcha_secret = ''; // Your reCaptcha Secret

$mail = new PHPMailer();

// If you intend you use SMTP, add your SMTP Code after this Line


if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

	$name = $_POST['template-medical-name'];
	$phone = $_POST['template-medical-phone'];
	$email = $_POST['template-medical-email'];
	$dob = $_POST['template-medical-dob'];
	$date = $_POST['template-medical-appoint-date'];
	$second_booking = $_POST['template-medical-second-booking'];
	$message = $_POST['template-medical-message'];

	$subject = 'New Appointment';

	$botcheck = $_POST['template-medical-botcheck'];

	if( $botcheck == '' ) {

		$mail->SetFrom( $email , $name );
		$mail->AddReplyTo( $email , $name );
		foreach( $toemails as $toemail ) {
			$mail->AddAddress( $toemail['email'] , $toemail['name'] );
		}
		$mail->Subject = $subject;

		$name = isset($name) ? "Name: $name<br><br>" : '';
		$phone = isset($phone) ? "Phone: $phone<br><br>" : '';
		$email = isset($email) ? "Email: $email<br><br>" : '';
		$dob = isset($dob) ? "Date of Birth: $dob<br><br>" : '';
		$date = isset($date) ? "Appointment Date: $date<br><br>" : '';
		$second_booking = isset($second_booking) ? "Second Booking: $second_booking<br><br>" : '';
		$message = isset($message) ? "Message: $message<br><br>" : '';

		$referrer = $_SERVER['HTTP_REFERER'] ? '<br><br><br>This Form was submitted from: ' . $_SERVER['HTTP_REFERER'] : '';

		$body = "$name $phone $email $dob $date $second_booking $message $referrer";

		// Runs only when reCaptcha is present in the Contact Form
		if( isset( $_POST['g-recaptcha-response'] ) ) {
			$recaptcha_response = $_POST['g-recaptcha-response'];
			$response = file_get_contents( "https://www.google.com/recaptcha/api/siteverify?secret=" . $recaptcha_secret . "&response=" . $recaptcha_response );

			$g_response = json_decode( $response );

			if ( $g_response->success !== true ) {
				echo '{ "alert": "error", "message": "Captcha not Validated! Please Try Again." }';
				die;
			}
		}

		// Uncomment the following Lines of Code if you want to Force reCaptcha Validation

		// if( !isset( $_POST['g-recaptcha-response'] ) ) {
		// 	echo '{ "alert": "error", "message": "Captcha not Submitted! Please Try Again." }';
		// 	die;
		// }

		$mail->MsgHTML( $body );
		$sendEmail = $mail->Send();

		if( $sendEmail == true ):
			echo '{ "alert": "success", "message": "' . $message_success . '" }';
		else:
			echo '{ "alert": "error", "message": "Email <strong>could not</strong> be sent due to some Unexpected Error. Please Try Again later.<br /><br /><strong>Reason:</strong><br />' . $mail->ErrorInfo . '" }';
		endif;
	} else {
		echo '{ "alert": "error", "message": "Bot <strong>Detected</strong>.! Clean yourself Botster.!" }';
	}
} else {
	echo '{ "alert": "error", "message": "An <strong>unexpected error</strong> occured. Please Try Again later." }';
}

?>
<?php
// PHP 4.1

// read the post from PayPal system and add 'cmd'
$req = '_type=notification-history-request';

foreach ($_POST as $key => $value) {
$value = urlencode(stripslashes($value));
$req .= "&$key=$value";
}

// post back to PayPal system to validate
$header .= "POST /checkout/api/checkout/v2/checkoutForm/Merchant/733583139382759 HTTP/1.1\r\n";
$header .= "Host: sandbox.google.com\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('ssl://sandbox.google.com', 443, $errno, $errstr, 30);

// assign posted variables to local variables

require_once 'lib/general.php';



if (!$fp) {
// HTTP ERROR
} else {
fputs ($fp, $header . $req);
while (!feof($fp)) {
$res = fgets ($fp, 1024);
}

$mail = new PHPMailer();
		$mail->IsSendmail();
		
		$body = "<pre>".print_r($_POST, 1)."</pre>";
		$body .= "<pre>".print_r($res, 1)."</pre>";
		$body .= "<pre>".print_r($req, 1)."</pre>";
		$body .= "<pre>".print_r($header, 1)."</pre>";
		
		$mail->AddReplyTo("julian.lannigan@gmail.com", "Julian Lannigan");
		$mail->SetFrom('noreply@litmotors.com', '[Google] IPN Debug information');
		$mail->AddAddress("julian.lannigan@gmail.com", "Julian Lannigan");
		
		$mail->Subject = "[LitMotors] [Google] IPN Debug information";
		$mail->MsgHTML($body);
		
		$mail->Send();
fclose ($fp);
}
<?php
// PHP 4.1

// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
$value = urlencode(stripslashes($value));
$req .= "&$key=$value";
}

// post back to PayPal system to validate
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);

// assign posted variables to local variables
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];

require_once 'lib/general.php';



if (!$fp) {
// HTTP ERROR
} else {
fputs ($fp, $header . $req);
while (!feof($fp)) {
$res = fgets ($fp, 1024);
if (strcmp ($res, "VERIFIED") == 0) {
// check the payment_status is Completed
// check that txn_id has not been previously processed
// check that receiver_email is your Primary PayPal email
// check that payment_amount/payment_currency are correct
// process payment
var_dump($_POST, $res);
}
else if (strcmp ($res, "INVALID") == 0) {
// log for manual investigation
var_dump($_POST, $res);
}
}

$mail = new PHPMailer();
		$mail->IsSendmail();
		
		$body = "<pre>".print_r($_POST, 1)."</pre>";
		$body .= "<pre>".print_r($res, 1)."</pre>";
		$body .= "<pre>".print_r($req, 1)."</pre>";
		$body .= "<pre>".print_r($header, 1)."</pre>";
		
		$mail->AddReplyTo("julian.lannigan@gmail.com", "Julian Lannigan");
		$mail->SetFrom('noreply@litmotors.com', 'IPN Debug information');
		$mail->AddAddress("julian.lannigan@gmail.com", "Julian Lannigan");
		
		$mail->Subject = "[LitMotors] IPN Debug information";
		$mail->MsgHTML($body);
		
		$mail->Send();
fclose ($fp);
}
<?php

function getRealIpAddr(){
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
      //check ip from share internet
	  $ip=$_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	  //to check ip is pass from proxy
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}


$apiKey = 'e6b723155138e6081e4deaa43e616ebc-us4';
$listID = '18de925803'; //the unique id for Lit's Newsletter list

$email = $_REQUEST['email'];
//error_log($email);

$double_optin=false;
$update_existing=false;
$replace_interests=true;
$send_welcome=false;
$email_type = 'html';

$ip = getRealIpAddr();


$merges = array(
	'OPTINIP'=>$ip
	
);

$dataToSend = array(
	'email_address' => $email,
	'apikey' => $apiKey,
	'merge_vars' => $merges,
	'id' => $listID,
	'double_optin' => $double_optin,
	'update_existing' => $update_existing,
	'replace_interests' => $replace_interests,
	'send_welcome' => $send_welcome,
	'email_type' => $email_type
);
$payload = json_encode($dataToSend);
 
//replace us2 with your actual datacenter
$submit_url = "http://us4.api.mailchimp.com/1.3/?method=listSubscribe";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $submit_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, urlencode($payload));
 
$result = curl_exec($ch);
curl_close ($ch);

$dataB = json_decode($result);
echo json_encode($dataB);


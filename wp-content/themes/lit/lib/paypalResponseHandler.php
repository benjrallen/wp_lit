<?php
/*
  define('RESPONSE_HANDLER_ERROR_LOG_FILE', 'googleerror.log');
  define('RESPONSE_HANDLER_LOG_FILE', 'googlemessage.log');

  //set merchant id
  $merchant_id = GW_SANDBOX ? "458313186045229" : "704111282563175";  // Your Merchant ID
  $merchant_key = GW_SANDBOX ? "3uKsybve1yjRYeHRZANfPA" : "chqag_0OYwwmPdGquUQCaw";  // Your Merchant Key
  //set server info
  $server_type = GW_SANDBOX ? "sandbox" : "prod";
  $currency = "USD";

  $Gresponse = new GoogleResponse($merchant_id, $merchant_key);

  $Grequest = new GoogleRequest($merchant_id, $merchant_key, $server_type, $currency);

  //Setup the log file
  $Gresponse->SetLogFiles(RESPONSE_HANDLER_ERROR_LOG_FILE, 
                                        RESPONSE_HANDLER_LOG_FILE, L_ALL);
*/

/**
 *  PHP-PayPal-IPN Example
 *
 *  This shows a basic example of how to use the IpnListener() PHP class to 
 *  implement a PayPal Instant Payment Notification (IPN) listener script.
 *
 *  For a more in depth tutorial, see my blog post:
 *  http://www.micahcarrick.com/paypal-ipn-with-php.html
 *
 *  This code is available at github:
 *  https://github.com/Quixotix/PHP-PayPal-IPN
 *
 *  @package    PHP-PayPal-IPN
 *  @author     Micah Carrick
 *  @copyright  (c) 2011 - Micah Carrick
 *  @license    http://opensource.org/licenses/gpl-3.0.html
 */
 
 
/*
Since this script is executed on the back end between the PayPal server and this
script, you will want to log errors to a file or email. Do not try to use echo
or print--it will not work! 

Here I am turning on PHP error logging to a file called "ipn_errors.log". Make
sure your web server has permissions to write to that file. In a production 
environment it is better to have that log file outside of the web root.
*/
ini_set('log_errors', true);
ini_set('error_log', dirname(__FILE__).'/ipn_errors.log');


// instantiate the IpnListener class
include('ipnlistener.php');
$listener = new IpnListener();


/*
When you are testing your IPN script you should be using a PayPal "Sandbox"
account: https://developer.paypal.com
When you are ready to go live change use_sandbox to false.
*/
$listener->use_sandbox = GW_SANDBOX ? true : false;

/*
By default the IpnListener object is going  going to post the data back to PayPal
using cURL over a secure SSL connection. This is the recommended way to post
the data back, however, some people may have connections problems using this
method. 

To post over standard HTTP connection, use:
$listener->use_ssl = false;

To post using the fsockopen() function rather than cURL, use:
$listener->use_curl = false;
*/

/*
The processIpn() method will encode the POST variables sent by PayPal and then
POST them back to the PayPal server. An exception will be thrown if there is 
a fatal error (cannot connect, your server is not configured properly, etc.).
Use a try/catch block to catch these fatal errors and log to the ipn_errors.log
file we setup at the top of this file.

The processIpn() method will send the raw data on 'php://input' to PayPal. You
can optionally pass the data to processIpn() yourself:
$verified = $listener->processIpn($my_post_data);
*/
try {
    $listener->requirePostMethod();
    $verified = $listener->processIpn();
} catch (Exception $e) {
    error_log($e->getMessage());
    exit(0);
}


/*
The processIpn() method returned true if the IPN was "VERIFIED" and false if it
was "INVALID".
*/
if ($verified) {
    /*
    Once you have a verified IPN you need to do a few more checks on the POST
    fields--typically against data you stored in your database during when the
    end user made a purchase (such as in the "success" page on a web payments
    standard button). The fields PayPal recommends checking are:
    
        1. Check the $_POST['payment_status'] is "Completed"
	    2. Check that $_POST['txn_id'] has not been previously processed 
	    3. Check that $_POST['receiver_email'] is your Primary PayPal email 
	    4. Check that $_POST['payment_amount'] and $_POST['payment_currency'] 
	       are correct
    
    Since implementations on this varies, I will leave these checks out of this
    example and just send an email using the getTextReport() method to get all
    of the details about the IPN.  
    */

    //error_log( 'VERIFIED:' );    
    //error_log( print_r( $_POST, true) );


    function Paypal2UnixGMT ($date){
      // PAYPAL DATE FORMAT IS HH:mm:ss Jan DD, YYYY PST
      // We want to convert that to Unixtime stamp, then do the timeshift from PST to EST 

      $hours = substr($date, 0,2);
      $mins = substr($date, 3,2);
      $secs = substr($date, 6,2);
      $monthword = strtoupper(substr($date, 9,3));
      $monthnames = 
        array(
          'JAN' => '01',
          'FEB' => '02',
          'MAR' => '03',
          'APR' => '04',
          'MAY' => '05',
          'JUN' => '06',
          'JUL' => '07',
          'AUG' => '08',
          'SEP' => '09',
          'OCT' => '10',
          'NOV' => '11',
          'DEC' => '12'
        );
      $monthnum = $monthnames[$monthword];

      $day = substr($date, 13,2);
      $year = substr($date, 17,4);

      $phpdate = mktime($hours,$mins,$secs,$monthnum,$day,$year);

      // PAYPAL TIMESTAMPS ARE IN PST (or PDT). SO, THE PHPDATE WE JUST CALCULATED IS OFF BY SEVERAL HOURS.
      // TO FIND THE TIME IN EST(or EDT), WE RECALC THE DATE BY 
      // 1. ADDING THE UNIX TIMESTAME TO THE EPOCH START
      // 2.TAKE 5 HOURS OFF FOR GMT
      // 3. THEN ADD 3 FOR PST-&gt;EST &lt;&lt;&lt;&lt; Change THIS part for your timezone
    
      //EDIT - BA - subtract 8 hours to get GMT
    
      $phpdate = strtotime ("1 Jan 1970 + $phpdate seconds -8 hours");
      return $phpdate;

    }

    
  	//Everything is valid with the form.
  	$db = new dbconnect(DB_HOST, DB_USER, DB_PASS, DB_NAME, __FILE__, __LINE__);

  	//Sanitize the post
  	foreach ($_POST as $k=>$v) {
  		$_POST[$k] = mysql_real_escape_string($v);
  	}
		
		$payment_status = $_POST['payment_status'];
		$token =          $_POST['custom']; //this value is the same as the token
		//$ipn_track_id =   $_POST['ipn_track_id'];
		$ipn_track_id =   $_POST['invoice'];
		$txn_id =         $_POST['txn_id'];
		
		$order_total =    intval( $_POST['mc_gross'], 10 );
		
		/*
		//for use later
		$first_name =     $_POST['first_name'];
		$last_name =      $_POST['last_name'];
		$address_street = $_POST['address_street'];
		$address_state =  $_POST['address_state'];
		$address_country= $_POST['address_country'];
		$address_zip =    $_POST['address_zip'];
		$address_country= $_POST['address_country'];
		$address_country= $_POST['address_country'];
		$address_country= $_POST['address_country'];
		$payment_fee =    $_POST['payment_fee'];
		*/
		
		$payment_date =   $_POST['payment_date'];
    $payment_date =   date('Y-m-d H:i:s', strtotime($payment_date));

    //Get the entry from the database
  	$theQuery = $db->query("SELECT * FROM `lit_orders` WHERE token='{$token}'", __FILE__, __LINE__);

  	if (!$theQuery->num_rows()) {
  	  error_log( 'SELECT FAILED: '.$token );
  		die;
  	}

  	$order = $theQuery->fetch_array();
  	
  	//DO CHECKS FOR POSTERITY
  	if( intval( $order['order_total'], 10 ) != $order_total ){
  	  error_log('Order values don\'t match: db='.print_r(intval( $order['order_total'], 10 ), true).', from request='.print_r($order_total, true) );
  	  die;
		}
		
  	//Save it to the db.
    $updateQuery = "UPDATE `lit_orders` SET ".
                      "status='{$payment_status}'".
                      ", gateway_ref_id='{$ipn_track_id}'".
                      ", gateway_ipn_info='{$txn_id}'".
                      ", date_ordered='{$payment_date}'".
                      ", date_updated=NOW()".
                      "  WHERE token='{$token}'";

    if( $db->query_bool(	$updateQuery ) ){
        //error_log("'It worked... SEND AN EMAIL!: '".$updateQuery);
        //SEND AN EMAIL
        $email_address = $order['email'];
        
        send_lit_order_email( "'It worked... SEND AN EMAIL!: '".$updateQuery );
        
      } else {
        error_log("'UPDATE QUERY FAILED: '".$updateQuery);
      }

    //mail('YOUR EMAIL ADDRESS', 'Verified IPN', $listener->getTextReport());

} else {
    /*
    An Invalid IPN *may* be caused by a fraudulent transaction attempt. It's
    a good idea to have a developer or sys admin manually investigate any 
    invalid IPN.
    */
    //mail('YOUR EMAIL ADDRESS', 'Invalid IPN', $listener->getTextReport());

    error_log( 'NOT VERIFIED:' );
    error_log( print_r( $_POST, true) );
    
}


die;

?>

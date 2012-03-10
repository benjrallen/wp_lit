<?php

/**
 * Copyright (C) 2007 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

 /* This is the response handler code that will be invoked every time
  * a notification or request is sent by the Google Server
  *
  * To allow this code to receive responses, the url for this file
  * must be set on the seller page under Settings->Integration as the
  * "API Callback URL'
  * Order processing commands can be sent automatically by placing these
  * commands appropriately
  *
  * To use this code for merchant-calculated feedback, this url must be
  * set also as the merchant-calculations-url when the cart is posted
  * Depending on your calculations for shipping, taxes, coupons and gift
  * certificates update parts of the code as required
  *
  */

  require_once('gcheckout/googleresponse.php');
  require_once('gcheckout/googlemerchantcalculations.php');
  require_once('gcheckout/googlerequest.php');
  require_once('gcheckout/googlenotificationhistory.php');


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


  //Retrieve the XML sent in the HTTP POST request to the ResponseHandler
  $xml_response = isset($HTTP_RAW_POST_DATA)?
                    $HTTP_RAW_POST_DATA:file_get_contents("php://input");

  //If serial-number-notification pull serial number and request xml
  if(strpos($xml_response, "xml") == FALSE){
    //Find serial-number ack notification
    $serial_array = array();
    parse_str($xml_response, $serial_array);
    $serial_number = $serial_array["serial-number"];

    //Request XML notification
    $Grequest = new GoogleNotificationHistoryRequest($merchant_id, $merchant_key, $server_type);
    $raw_xml_array = $Grequest->SendNotificationHistoryRequest($serial_number);
    if ($raw_xml_array[0] != 200){
      //Add code here to retry with exponential backoff
    } else {
      $raw_xml = $raw_xml_array[1];
    }
    $Gresponse->SendAck($serial_number, false);
  }
  else{
    //Else assume pre 2.5 XML notification
    //Check Basic Authentication
    $Gresponse->SetMerchantAuthentication($merchant_id, $merchant_key);
    $status = $Gresponse->HttpAuthentication();
    if(! $status) {
      die('authentication failed');
    }
    $raw_xml = $xml_response;
    $Gresponse->SendAck(null, false);
  }

  if (get_magic_quotes_gpc()) {
    $raw_xml = stripslashes($raw_xml);
  }

  //Parse XML to array
  list($root, $data) = $Gresponse->GetParsedXML($raw_xml);
  
  /* Commands to send the various order processing APIs
   * Send charge order : $Grequest->SendChargeOrder($data[$root]
   *    ['google-order-number']['VALUE'], <amount>);
   * Send process order : $Grequest->SendProcessOrder($data[$root]
   *    ['google-order-number']['VALUE']);
   * Send deliver order: $Grequest->SendDeliverOrder($data[$root]
   *    ['google-order-number']['VALUE'], <carrier>, <tracking-number>,
   *    <send_mail>);
   * Send archive order: $Grequest->SendArchiveOrder($data[$root]
   *    ['google-order-number']['VALUE']);
   *
   */
   
 //error_log( print_r($root, true) ) ;
 //error_log( print_r($data, true) ) ;

  //order and token come in both new order notification and authorization amount notification 
  //$billing = $data[$root]['buyer-billing-address'];
  $order = $data[$root]['order-summary'];
  $token = $order['shopping-cart']['items']['item']['merchant-private-item-data']['token']['VALUE'];
  $order_number = $data[$root]['google-order-number'];
  $timestamp = $data[$root]['timestamp']['VALUE'];
  $purchase_date = $data[$root]['order-summary']['purchase-date']['VALUE'];
  $order_status = 'awaiting authorization';
  
  $processMe = false;
  
  switch($root){
    case "new-order-notification": {
        //$address = $data[$root]['buyer-billing-address']; //array()
        $processMe = true;
      break;
    }
    case "risk-information-notification": {
      break;
    }
    case "charge-amount-notification": {
      break;
    }
    case "authorization-amount-notification": {
      //$google_order_number = $data[$root]['google-order-number']['VALUE'];
      //$tracking_data = array("Z12345" => "UPS", "Y12345" => "Fedex");
      //$GChargeRequest = new GoogleRequest($merchant_id, $merchant_key, $server_type);
      //$GChargeRequest->SendChargeAndShipOrder($google_order_number, $tracking_data);

      $order_status = 'authorized';
      $processMe = true;
      
      break;
    }
    case "refund-amount-notification": {
      break;
    }
    case "chargeback-amount-notification": {
      break;
    }
    case "order-numbers": {
      break;
    }
    case "invalid-order-numbers": {
      break;
    }
    case "order-state-change-notification": {
      break;
    }
    default: {
      break;
    }
  }

  if( $processMe ){
    
  	//Everything is valid with the form.
  	$db = new dbconnect(DB_HOST, DB_USER, DB_PASS, DB_NAME, __FILE__, __LINE__);
		
  	//Save it to the db.
    $updateQuery = "UPDATE `lit_orders` SET ".
                      "status='{$order_status}'".
                      ", gateway_ref_id='{$order_number}'".
                      ", gateway_ipn_info='{$serial_number}'".
                      ", date_ordered='{$purchase_date}'".
                      ", date_updated='{$timestamp}'".
                      "  WHERE token='{$token}'";

    if( $db->query_bool(	$updateQuery ) ){
      error_log("'Supposedly it worked: '".$updateQuery);
      die;
    } else {
      error_log("'UPDATE QUERY FAILED: '".$updateQuery);
      die;
    }

  }

  /* In case the XML API contains multiple open tags
     with the same value, then invoke this function and
     perform a foreach on the resultant array.
     This takes care of cases when there is only one unique tag
     or multiple tags.
     Examples of this are "anonymous-address", "merchant-code-string"
     from the merchant-calculations-callback API
  */
  function get_arr_result($child_node) {
    $result = array();
    if(isset($child_node)) {
      if(is_associative_array($child_node)) {
        $result[] = $child_node;
      }
      else {
        foreach($child_node as $curr_node){
          $result[] = $curr_node;
        }
      }
    }
    return $result;
  }

  /* Returns true if a given variable represents an associative array */
  function is_associative_array( $var ) {
    return is_array( $var ) && !is_numeric( implode( '', array_keys( $var ) ) );
  }
?>

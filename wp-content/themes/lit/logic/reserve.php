<?php

/* STEP 0 */
/* LOOK TO SEE IF IT IS A NOTIFICATION */
$action = ( isset($_POST['action']) ? $_POST['action'] : false );

error_log( 'What is my action?  '.$action );

/* STEP 1 */
if (isset($_POST["firstname"])) {
	$fields = array("firstname", "lastname", "address", "city", "state", "zip", "country", "email", "phone", "salutation", "deposit");

	foreach ($fields as $field) {
		if (!isset($_POST[$field])) {
			$_POST[$field] = "";
		}
		$valid = true;
		if ($field == "deposit") {
			$depo = (float) $_POST["deposit"];
			if ($depo < 50) $valid = false;
		} else if ($field == "salutation") {
			if ($_POST["salutation"] != "") {
				switch ($_POST["salutation"]) {
					case "0": $_POST["salutation"] = ""; break;
					
					case "mr":
					case "ms":
					case "mrs":
						$valid = true;
						break;
					default: 
						$valid = false;
				}
			}
		} else {
			if ($field == "email" && !validEmail($_POST["email"])) {
				$valid = false;
			}
			if ($_POST[$field] == "") {
				$valid = false;
			}
		}
		
		if (!$valid) {
			header("Content-Type: application/json");
			echo json_encode(array("status" => "error", "message" => "Invalid field entry: {$field}", "focus" => $field, "proceed" => false));
			die;
		}
	}

	//Everything is valid with the form.
	$db = new dbconnect(DB_HOST, DB_USER, DB_PASS, DB_NAME, __FILE__, __LINE__);
	
	//Sanitize the post
	foreach ($_POST as $k=>$v) {
		$_POST[$k] = mysql_real_escape_string($v);
	}
	
	//Save it to the db.
	$insertQuery = "INSERT INTO `lit_orders` (`orderid`, `status`, `firstname`, `lastname`, `address`, `city`, `state`, `zip`, `country`, `email`, `phone`, `salutation`, `position`, `date_ordered`, `email_log`, `order_total`, `amount_paid`, `order_products`, `gateway_ref_id`, `gateway_used`, `gateway_ipn_info`, `date_created`, `token`) 
	VALUES (NULL, 'awaiting gateway choice', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', NULL, '', '', '%s', '0', '', NULL, NULL, NULL, NOW(), '%s');";
	
	$token = md5($_POST["firstname"].$_POST["lastname"].$_POST["address"].$_POST["city"].$_POST["state"].$_POST["zip"].$_POST["country"].$_POST["email"].mt_rand().mt_rand().mt_rand());
	
	$insertQuery = sprintf($insertQuery,
		$_POST["firstname"]
		,$_POST["lastname"]
		,$_POST["address"]
		,$_POST["city"]
		,$_POST["state"]
		,$_POST["zip"]
		,$_POST["country"]
		,$_POST["email"]
		,$_POST["phone"]
		,$_POST["salutation"]
		//,"250"
		,$_POST["deposit"]
		,$token
	);
	
	if ($db->query_bool($insertQuery, __FILE__, __LINE__)) {
		$orderid = $db->insert_id();
		
		header("Content-Type: application/json");
		echo json_encode(array("status" => "ok", "message" => "ok", "proceed" => true, "token" => $token));
		die;
	}
}
/* END STEP 1 */

/* STEP 2 */
if (isset($_POST["token"]) && isset($_POST["gateway"])) {
  //set the home path and the current page for the form( private or reserve );
  $lit_base = $_POST["base_url"];
  $lit_form = $_POST["current_url"];
  $lit_template = $_POST["template_url"];

	$db = new dbconnect(DB_HOST, DB_USER, DB_PASS, DB_NAME, __FILE__, __LINE__);
	foreach ($_POST as $k=>$v) {
		$_POST[$k] = mysql_real_escape_string($v);
	}
	
	if (strlen($_POST["token"]) <> 32) {
		header("Content-Type: application/json");
		echo json_encode(array("status" => "error", "message" => "Invalid token", "proceed" => false));
		die;
	}
	
	if (!($_POST["gateway"] == "paypal" || $_POST["gateway"] == "google")) {
		header("Content-Type: application/json");
		echo json_encode(array("status" => "error", "message" => "Invalid payment gateway", "proceed" => false));
		die;
	}
	
	$gateway = $_POST["gateway"];
	
	$theQuery = $db->query("SELECT * FROM `lit_orders` WHERE token='{$_POST["token"]}'", __FILE__, __LINE__);
	
	if (!$theQuery->num_rows()) {
		header("Content-Type: application/json");
		echo json_encode(array("status" => "error", "message" => "Invalid token given", "proceed" => false));
		die;
	}
	
	$order = $theQuery->fetch_array();
	
	$db->query("UPDATE `lit_orders` SET status='at gateway', gateway_used='{$gateway}' WHERE token='{$order["token"]}'", __FILE__, __LINE__);
	
	if ($_POST["gateway"] == "paypal") {
		$buildLink = "https://www%s.paypal.com/cgi-bin/webscr";
		$buildLink = sprintf($buildLink, GW_SANDBOX ? ".sandbox" : "");
		//set the business as real or to the sandbox account
		$business = ( GW_SANDBOX ? 'benjra_1329781889_biz@gmail.com' : 'dan@litmotors.com');
		
		//documentation:  https://www.paypal.com/cgi-bin/webscr?cmd=p/pdn/howto_checkout-outside
		//pdf docs:  https://cms.paypal.com/cms_content/US/en_US/files/developer/PP_WebsitePaymentsStandard_IntegrationGuide.pdf
		$params = array(
			"cmd" => "_xclick",
			"invoice" => $order["orderid"],
			//"amount" => 250,
			"amount" => $order["order_total"],
			"first_name" => $order["firstname"],
			"last_name" => $order["lastname"],
			"address1" => $order["address"],
			"city" => $order["city"],
			"state" => $order["state"],
			"zip" => $order["zip"],
			"email" => $order["email"],
			//"address_override" => 1,
			"country" => $order["country"],
			"currency_code" => "USD", //added by BA cause the docs say it is required.
		  //"notify_url" => site_url("/reserve/?action=confirm&token=".$order["token"]),//Only used with IPN. An internet URL where IPN form posts will be sent
		  "notify_url" => $lit_template."/reserve.php?action=notify&token=".$order["token"],//Only used with IPN. An internet URL where IPN form posts will be sent
			//"return" => site_url("/reserve/?action=return&token=".$order["token"]),
		  //"return" => site_url("/home/"),
  		"return" => $lit_form."?action=return",
  		//"cancel_return" => site_url("/reserve/?action=return"),//An internet URL where your customer will be returned after cancelling payment
			"cancel_return" => $lit_form."?action=cancel",//An internet URL where your customer will be returned after cancelling payment
      "custom" => $order["token"],
			"item_name" => "C-1 Reservation",
			"item_number" => "C1-001",
			"image_url" => $lit_template."/images/paypal-lit-logo.png",
			//"business" => "dan@litmotors.com",
			"business" => $business,
			"hosted_button_id" => "ZHBKSR5KM42AL" //this means this transaction is a saved button in the dan@litmotors.com paypal account
		);
		
		$buildLink .= "?".http_build_query($params);
		
	} elseif ($_POST["gateway"] == "google") {	
		require_once(ABSPATH.'/lib/gcheckout/googlecart.php');
		require_once(ABSPATH.'/lib/gcheckout/googleitem.php');
		require_once(ABSPATH.'/lib/gcheckout/googleshipping.php');
		require_once(ABSPATH.'/lib/gcheckout/googletax.php');
		
    // $merchant_id = GW_SANDBOX ? "733583139382759" : "704111282563175";  // Your Merchant ID
    // $merchant_key = GW_SANDBOX ? "lgFj5GaFwVmf7_xyI2BeGw" : "chqag_0OYwwmPdGquUQCaw";  // Your Merchant Key
		$merchant_id = GW_SANDBOX ? "458313186045229" : "704111282563175";  // Your Merchant ID
		$merchant_key = GW_SANDBOX ? "3uKsybve1yjRYeHRZANfPA" : "chqag_0OYwwmPdGquUQCaw";  // Your Merchant Key
		
		$sandbox = "https://sandbox.google.com/checkout/api/checkout/v2/checkoutForm/Merchant/%s";
		$production = "https://checkout.google.com/api/checkout/v2/checkoutForm/Merchant/%s";
		$buildLink = sprintf(GW_SANDBOX ? $sandbox : $production, $merchant_id);
		
		
	      $server_type = GW_SANDBOX ? "sandbox" : "prod";
	      $currency = "USD";
	      $cart = new GoogleCart($merchant_id, $merchant_key, $server_type, $currency);
	      
	      $item_1 = new GoogleItem("C-1 Reservation",      // Item name
	                               "C-1 Motorcycle Reservation", // Item      description
	                               1, // Quantity
	                               //250); // Unit price
	                               $order['order_total']); // Unit price
	      $cart->AddItem($item_1);
	      
	      // Specify "Return to xyz" link
	      //$cart->SetContinueShoppingUrl("https://litmotors.com/reserve/?action=return");
	      //$cart->SetContinueShoppingUrl("http://litmotors.com/reserve/?action=return");
	      $cart->SetContinueShoppingUrl( $lit_form."?action=return");
	      
	      // Request buyer's phone number
	      $cart->SetRequestBuyerPhone(true);
		
		    //set merchant private data to get token back from google
		    $cart->SetMerchantPrivateItemData(
                    new MerchantPrivateItemData(
                      array("token" => $order["token"])
                    )
        );
		
		$params = array(
			"cart" => base64_encode($cart->GetXML()),
			"signature" => base64_encode($cart->CalcHmacSha1($cart->GetXML())),
		);
		
		$buildLink = $cart->checkout_url;
		$buildLink .= "?".http_build_query($params);
			
	}
	
	header("Content-Type: application/json");
	echo json_encode(array("status" => "ok", "message" => "ok", "proceed" => true, "token" => $_POST["token"], "link" => $buildLink, "method" => $_POST["gateway"] == "google" ? "post" : "get"));
	die;
}

if (isset($_POST["action"])) {
	//var_dump($_POST);die;
}
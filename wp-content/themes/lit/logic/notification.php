<?php

  //error_log('i am notification.php');
  
  //log out the request
  //$request = $_REQUEST;
  
  //error_log( print_r($_REQUEST, true) );

  /*
  if ( $_REQUEST['send-test'] == 'email' ){
    
    send_lit_order_email('testing that function', 'totally testing');
    
    echo( 'ok' );
  }
  */
  
  if( isset($_REQUEST['serial-number'])){
    error_log('i have a serial number and it is: '.$_REQUEST['serial-number']);
    
    require_once('lib/googleResponseHandler.php');
    
    // header('HTTP/1.1 200 OK');
    // $acknowledgement = 'serial-number='.$_REQUEST['serial-number'];
    // die( $acknowledgement );
  } else if ( isset($_REQUEST['token'] ) ) {
    //assume it is paypal
    
    require_once('lib/paypalResponseHandler.php');
    
  }
  
  
die;
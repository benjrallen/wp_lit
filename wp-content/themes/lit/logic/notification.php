<?php

  //error_log('i am notification.php');
  
  //log out the request
  //$request = $_REQUEST;
  
  //error_log( print_r($_REQUEST, true) );

  //used in both paths
  function lit_build_order_text( $order ){
    $fields = array(
      'Order Status' =>     'status',
      'Salutation' =>       'salutation',
      'First Name' =>       'firstname',
      'Last Name' =>        'lastname',
      'Address' =>          'address',
      'City' =>             'city',
      'State' =>            'state',
      'Zip' =>              'zip',
      'Country' =>          'country',
      'Email' =>            'email',
      'Phone' =>            'phone',
      'Order Total' =>      'order_total',
      'Payment Gateway' =>  'gateway_used',
      'Order ID' =>         'orderid'
    );
    
    $message = '';
    
    if( !empty($order) ){
      foreach( $fields as $nice => $f ){
          $message .= $nice . ':    '.$order[$f] . "\r\n";
      }
    }
    
    $message .= "\r\n";
    
    return $message;
  }

  //send email function used in both pathways
  function  send_lit_order_email( $subject, $message ){
    
    $toArray =  ( GW_SANDBOX ? 
                  array( 'benjrallen@gmail.com') :
                  array( 'benjrallen@gmail.com', 'nakedincorners@gmail.com')
                );
    
    $from = ( GW_SANDBOX ? 'no-reply@dev.benjrallen.com' : 'info@litmotors.com' );
    
    $fromName = ( GW_SANDBOX ? 'Dev Server' : 'Lit Orders');
    
    $headers = 'From: '.$fromName.'<'. $from . '>' . "\r\n" .
        'Reply-To: '.$fromName.'Lit Orders<'. $from . '>' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();    
    
    $to = '';
    
    for( $i = 0, $j = count($toArray); $i < $j; $i++ ){
      $to .= $i == 0 ? '' : ',';
      $to .= $toArray[$i];
    }
    
    //error_log( $to );
    //error_log( $headers );
    
    mail( $to, $subject, $message, $headers );
    
  }

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
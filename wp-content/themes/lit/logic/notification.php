<?php
  
  if( isset($_REQUEST['serial-number'])){
    //assume it is google
    
    require_once('lib/googleResponseHandler.php');
    
  } else if ( isset($_REQUEST['token'] ) ) {
    //assume it is paypal
    
    require_once('lib/paypalResponseHandler.php');
  }
  
  
die;
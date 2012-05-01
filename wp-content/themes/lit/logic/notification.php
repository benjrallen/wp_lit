<?php
    
  //require the php-ga classes
  //require_once 'lib/google_analytics/autoloader.php';
  //use UnitedPrototype\GoogleAnalytics;
  
  if( isset($_REQUEST['serial-number'])){
    //assume it is google
    
    require_once('lib/googleResponseHandler.php');
    
  } else if ( isset($_REQUEST['token'] ) ) {
    //assume it is paypal
    
    require_once('lib/paypalResponseHandler.php');
  }
  
  
die;
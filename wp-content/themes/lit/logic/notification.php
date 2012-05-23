<?php
  
  
  //require the php-ga classes for google analytics
  require_once('lib/google_analytics/autoload.php');
  use UnitedPrototype\GoogleAnalytics;
  
  //set up the tracker
  $tracker = new GoogleAnalytics\Tracker( GA_UA, GA_URL );
  $visitor = new GoogleAnalytics\Visitor();
  $visitor->setIpAddress($_SERVER['REMOTE_ADDR']);
  $visitor->setUserAgent($_SERVER['HTTP_USER_AGENT']);
  $session = new GoogleAnalytics\Session();
  $page = new GoogleAnalytics\Page('/server_payment_notification');
  
  //set up the event
  $event = new GoogleAnalytics\Event();
  $event->setCategory('Reserve');
  $event->setNoninteraction('true');
  
  error_log('testing');
  
  if( isset($_REQUEST['serial-number'])){
    //assume it is google
    
    require_once('lib/googleResponseHandler.php');
    
  } else if ( isset($_REQUEST['token'] ) ) {
    //assume it is paypal
    
    require_once('lib/paypalResponseHandler.php');
  }
  
  
die;
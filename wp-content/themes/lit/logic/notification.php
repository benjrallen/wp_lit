<?php

  //error_log('i am notification.php');
  
  //log out the request
  $request = $_REQUEST;
  
  error_log( print_r($request, true) );
  
die;
<?php

require_once 'phpmailer/class.phpmailer.php';
require_once 'dbconnect.php';

function buildSiteUrl() {
	/* Build current url */
	$liveURL = 'http';
	if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
		$liveURL .= "s";
	}
	$liveURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$liveURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
	} else {
		$liveURL .= $_SERVER["SERVER_NAME"];
	}
	$docRoot = dirname(dirname($_SERVER['SCRIPT_FILENAME']).$_SERVER["SCRIPT_NAME"]);
	$docRoot = str_replace("\\", "/", substr($docRoot, strlen(ABSPATH) + strpos($docRoot, ABSPATH)));
	$thePath = $liveURL.$docRoot;
	
	return $thePath;
}

function getRouteUrl() {
	$siteUrl = site_url();
	$sitePath = parse_url($siteUrl, PHP_URL_PATH);
	$theRequest = $_SERVER["REQUEST_URI"];
	$one = 1;
	if ($sitePath != "/") {
		$theRequest = str_ireplace($sitePath, "", $theRequest, $one);
	}
	
	if (strlen($theRequest) > 1 && substr($theRequest, -1) == "/") {
		$theRequest = substr($theRequest, 0, strlen($theRequest)-1);
	}
	
	return $theRequest;
}

function site_url($path = "") {
	return buildSiteUrl().$path;
}

function isSplashPage() {
	return getRouteUrl() == "/splash" || getRouteUrl() == "/";
}

function validEmail($email)
{
   $isValid = true;
   $atIndex = strrpos($email, "@");
   if (is_bool($atIndex) && !$atIndex)
   {
      $isValid = false;
   }
   else
   {
      $domain = substr($email, $atIndex+1);
      $local = substr($email, 0, $atIndex);
      $localLen = strlen($local);
      $domainLen = strlen($domain);
      if ($localLen < 1 || $localLen > 64)
      {
         // local part length exceeded
         $isValid = false;
      }
      else if ($domainLen < 1 || $domainLen > 255)
      {
         // domain part length exceeded
         $isValid = false;
      }
      else if ($local[0] == '.' || $local[$localLen-1] == '.')
      {
         // local part starts or ends with '.'
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $local))
      {
         // local part has two consecutive dots
         $isValid = false;
      }
      else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
      {
         // character not valid in domain part
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $domain))
      {
         // domain part has two consecutive dots
         $isValid = false;
      }
      else if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local)))
      {
         // character not valid in local part unless 
         // local part is quoted
         if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local)))
         {
            $isValid = false;
         }
      }
      if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A")))
      {
         // domain not found in DNS
         $isValid = false;
      }
   }
   return $isValid;
}
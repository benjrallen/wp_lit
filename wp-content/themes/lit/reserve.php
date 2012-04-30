<?php

define("ABSPATH", dirname(__FILE__));

require_once 'lib/general.php';
require_once 'lib/google_analytics/autoloader.php';
//require_once 'lib/seo.php';

//var_dump($_SERVER);die;
if (strpos($_SERVER["SERVER_NAME"], "localhost") !== false || strpos($_SERVER["SERVER_NAME"], "dev.benjrallen.com") !== false) {
	define("DB_HOST", "localhost");
	define("DB_NAME", "litmotors");
	define("DB_USER", "root");
	define("DB_PASS", "bones");
	define("GW_SANDBOX", true);
	define("GA_UA", "UA-31286635-1");
} else {
	define("DB_HOST", "dannykim8379.db.5219707.hostedresource.com");
	define("DB_NAME", "dannykim8379");
	define("DB_USER", "dannykim8379");
	define("DB_PASS", "wxvubP79");
	define("GW_SANDBOX", false);
	define("GA_UA", "UA-31250869-1");
}

$private = false;

include 'logic/reserve.php';

<?php
/*
Plugin Name: Ease Surveys
Plugin URI: This tool is halfway finished, and requires the WP-MVC plugin to be installed and activated.
Description: A surveying tool originally made for Lit Motors
Author: Benjamin Allen
Version: 0.5
Author URI: http://benjrallen.com
*/

register_activation_hook(__FILE__, 'ease_surveys_activate');
register_deactivation_hook(__FILE__, 'ease_surveys_deactivate');

function ease_surveys_activate() {
	require_once dirname(__FILE__).'/ease_surveys_loader.php';
	$loader = new EaseSurveysLoader();
	$loader->activate();
}

function ease_surveys_deactivate() {
	require_once dirname(__FILE__).'/ease_surveys_loader.php';
	$loader = new EaseSurveysLoader();
	$loader->deactivate();
}

?>
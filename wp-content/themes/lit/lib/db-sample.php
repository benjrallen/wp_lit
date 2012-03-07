<?php
/*
This is a lightweight library to perform basic DB functions and provides at least a thin layer of abstration from the database-specific functions.  Currently uses MySQL.

Author: David Orr (david@hostelz.com)
*/

global $mydb;

$mydb = @mysql_connect("mysql_server", "username", 'password');

if(!$mydb || !mysql_select_db("MYSQL_DB", $mydb))
	die("The website is currently offline for maintenance. It should be online again shortly.");

mysql_set_charset('utf8');

function dbFetchQuery($q, $unbuffered=false) {
	$ret = $unbuffered?mysql_unbuffered_query($q):mysql_query($q);
	if(mysql_error()) triggerError(mysql_error()." - $_SERVER[REQUEST_URI] - $q");
	return $ret;
}

function dbFetchNumRows($r) { return mysql_num_rows($r); } // n/a if unbuffered

function dbFetchRow($r,$type=MYSQL_ASSOC) { return mysql_fetch_array($r,$type); }

function dbFetchFree($r) { return mysql_free_result($r); }

function dbQuery($q) {
	$ret = (mysql_query($q)?true:false);
	if(mysql_error()) triggerError(mysql_error()." - $_SERVER[REQUEST_URI] - $q");
	return $ret;
}

function dbError() { return mysql_error(); }

function dbQuote($s) { return "'".mysql_real_escape_string($s)."'"; }

function dbEscape($s) { return mysql_real_escape_string($s); }

function dbLastID() { return mysql_insert_id(); }

function dbGetOne($q) {
	$a = dbGetRow($q);
	if($a == false) return false;
	return current($a);
}

function dbGetRow($q) {
	$r = mysql_query($q);
	if(mysql_error()) triggerError(mysql_error()." - $_SERVER[REQUEST_URI] - $q");
	if(!$r) return false;
	return mysql_fetch_assoc($r);
}

function dbGetCol($q) {
	$r = mysql_query($q);
	if(mysql_error()) triggerError(mysql_error()." - $_SERVER[REQUEST_URI] - $q");
	if(!$r) return false;
	if($r === true) return true; // special situation, happens for sql like DELETE, UPDATE.
	$result = array();
	while(($row = mysql_fetch_array($r,MYSQL_NUM)) !== false) $result[] = $row[0];
	return $result;
}

function dbGetAll($q) {
	$r = mysql_query($q);
	if(mysql_error()) triggerError(mysql_error()." - $_SERVER[REQUEST_URI] - $q");
	if(!$r) return false;
	if($r === true) return true; // special situation, happens for sql like DELETE, UPDATE.
	$result = array();
	global $isAdmin;
	while(($result[] = mysql_fetch_assoc($r)) !== false) ;
	end($result); unset($result[key($result)]); reset($result); // delete last 'false'
	return $result;
}

function dbGetKeyValuePairs($q) {
	$r = mysql_query($q);
	if(mysql_error()) triggerError(mysql_error()." - $_SERVER[REQUEST_URI] - $q");
	if(!$r) return false;
	if($r === true) return true; // special situation, happens for sql like DELETE, UPDATE.
	$result = array();
	while(($temp = mysql_fetch_array($r,MYSQL_NUM)) !== false) $result[$temp[0]] = $temp[1];
	return $result;
}

/* Calls trigger_error() after adding trace information. */
function triggerError($error) {
	$e = new Exception();
	$trace = $e->getTraceAsString();
	trigger_error("$error $_SERVER[REMOTE_ADDR] $_SERVER[REQUEST_URI] Trace: $trace");
}
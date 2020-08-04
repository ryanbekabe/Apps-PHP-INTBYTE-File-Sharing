<?php
/**
 * ========== About ==========
 * Author     : Afid Arifin
 * Name       : INTBYTE File Sharing (IFS)
 * Version    : v1.0
 * Created On : 09 October 2019
 */

/**
 * ========== WARNING BEFORE USING ==========
 * About            : see /documents/about.txt
 * Contact          : see /documents/contact.txt
 * Disclaimer       : see /documents/disclaimer.txt
 * Privacy Policy   : see/documents/privacy-policy.txt
 * License Software : see /documents/license.txt
 */

// To Debugging, You can change the number zero to number one to display the message
ini_set('display_errors', 0);
ob_start();
session_start();

// Check PHP version
if(version_compare(phpversion(), '7', '<=')) {
  die('<b>Warning:</b> Your PHP version '.phpversion().' is deprecated. Please use PHP version or up!');
}

// Configuration database
$MySQL_Host = 'localhost';
$MySQL_User = 'root';
$MySQL_Pass = '';
$MySQL_Name = 'intbyte';

// Connection To Database
$intbyte = new mysqli($MySQL_Host, $MySQL_User, $MySQL_Pass, $MySQL_Name);
if($intbyte->connect_errno) {
  die('<b>Error:</b> Connection to database is failed!');
}

// Global URL Or Base Url
// If You Using SSL, Please change http:// to https:// format protocol
function base_url() {
  return 'http://'.$_SERVER['HTTP_HOST'].'';
}

// Set Charset And Names
$intbyte->query('SET CHARSET UTF8');
$intbyte->Query('SET NAMES UTF8');
?>
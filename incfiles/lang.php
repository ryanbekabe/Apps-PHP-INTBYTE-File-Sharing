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

if(isset($_SERVER['PHP_SELF']) && isset($_GET['lang'])) {

  // Session
  $_SESSION['lang'] = $_GET['lang'];
  setcookie('lang', $_GET['lang'], time() + 60 * 60 * 24 * 365);

  if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != NULL) {
    header('location: '.$_SERVER['HTTP_REFERER'].'');
  } else {
    header('location: /?'.SID);
  }
} elseif(isset($_SESSION['lang'])) {
  $_GET['lang'] = $_SESSION['lang'];
} elseif(isset($_COOKIE['lang'])) {
  $_GET['lang'] = $_COOKIE['lang'];
} else {

  // Default language is English
  $_GET['lang'] = 'id';
}

switch($_GET['lang']) {

  case 'en':

    // English
    $local = 'en';
    $comlang = 'en_US';
  break;

  case 'id':

    // Indonesian
    $local = 'id';
    $comlang = 'id_ID';
  break;

  default:

    // Default
    $local = 'en';
    $comlang = 'en_US';
  break;
}

require_once 'lang/'.$local.'.php';
?>
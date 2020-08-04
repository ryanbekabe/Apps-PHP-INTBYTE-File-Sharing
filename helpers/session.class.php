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

/**
 * This is a helpers for core of user session.
 * Do not remove this helpers.
 * you can add more helpers in here
 */

class Session {

  // Property of session
  private $user_id;
  private $user_rights;
  private $user_logged;

  // Initializing
  public function init() {

    global $user_id;
    global $user_rights;
    global $user_logged;

    if(isset($_SESSION['user_id']) && isset($_SESSION['user_rights']) && isset($_SESSION['user_logged'])) {
      $user_id = $_SESSION['user_id'];
      $user_rights = $_SESSION['user_rights'];
      $user_logged = $_SESSION['user_logged'];
    }
  }

  // User login
  public function is_login() {

    $this->init();
    $user_id = $_SESSION['user_id'];

    // Return value of user login
    return $user_id;
  }

  // User rights
  public function is_rights() {

    $this->init();
    $user_rights = $_SESSION['user_rights'];

    // Return value  of user rights
    return $user_rights;
  }

  // User logged
  public function is_logged() {

    $this->init();
    $user_logged = $_SESSION['user_logged'];

    // Return value of user logged
    return $user_logged;
  }
}

$session = new Session();
?>
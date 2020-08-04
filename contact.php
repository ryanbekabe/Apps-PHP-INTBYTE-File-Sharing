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

// Helpers
require_once 'incfiles/connect.php';
require_once 'helpers/session.class.php';
require_once 'helpers/coreFunc.class.php';
require_once 'helpers/paging.class.php';
require_once 'helpers/time.class.php';
require_once 'incfiles/lang.php';

$act = isset($_GET['via']) ? trim($_GET['via']) : '';
switch($act) {

  // Contact via email
  case 'email':

    // Headers
    $title = 'Via Email';
    require_once 'incfiles/header.php';

    // Section contact via email
    echo '<section class="section">';

    echo '<div class="section-header">
      <h1 class="section-title">
        Via Email
      </h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">
          <a href="'.base_url().'/">
            Dashboard
          </a>
        </div>
        <div class="breadcrumb-item">
          Via Email
        </div>
      </div>
    </div>';

    echo '<div class="row">';

    // HTML form
    echo '<div class="page-error">
      <div class="page-inner">
        <div class="page-description">
          <img src="'.base_url().'/images/icon/email.jpg" alt="thumbnail" style="box-shadow: 5px 5px 5px 0px #333333;" width="560" height="180"/>
        </div>
        <div class="page-search">
          <div class="mt-3">
            <div class="row">
              <div class="col-12 col-md-6 col-lg-12">
                <p class="text-muted">
                  '.$lang['contact_EMAIL'].'
                </p>
              </div>
            </div>
            <div class="row">
              <div class="col-12 offset-md-3 col-md-6 col-lg-6">
                <a href="javascript: void(0);" class="btn btn-warning">
                  <i class="fas fa-envelope"></i>
                  afid.official@gmail.com
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>';

    echo '</div>';
    echo '</section>';
    require_once 'incfiles/footer.php';
  break;

  // Contact via messenger
  case 'messenger':

    // Headers
    $title = 'Via Messenger';
    require_once 'incfiles/header.php';

    // Section contact via email
    echo '<section class="section">';

    echo '<div class="section-header">
      <h1 class="section-title">
        Via Messenger
      </h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">
          <a href="'.base_url().'/">
            Dashboard
          </a>
        </div>
        <div class="breadcrumb-item">
          Via Messenger
        </div>
      </div>
    </div>';

    echo '<div class="row">';

    // Please change facebook username afid.official to your facebook username
    echo '<div class="col-12 offset-md-3 col-md-6 col-lg-6">
      <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fafid.official&tabs=timeline&width=500&height=180&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="500" height="180" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
    </div>';

    echo '</div>';
    echo '</section>';
    require_once 'incfiles/footer.php';
  break;

  default:

    // Illegal Access
    // If there is access to this page then the system will direct to the main page User
    $core->redirect(base_url().'/');
  break;
}
?>
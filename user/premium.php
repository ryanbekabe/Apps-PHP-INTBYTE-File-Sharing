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
require_once '../incfiles/connect.php';
require_once '../helpers/session.class.php';
require_once '../helpers/coreFunc.class.php';
require_once '../helpers/time.class.php';
require_once '../incfiles/lang.php';

// Headers
$title = $lang['user_UPGRADE_ACCOUNT'];
require_once '../incfiles/header.php';

// If not an User, the system will be redirect to the index page or home page
if(!$session->is_login()) {
  $core->redirect(base_url().'/');
}

// The user informations
$q = $intbyte->query("SELECT * FROM users WHERE id = '".$session->is_login()."'");
$info = $q->fetch_assoc();

$act = isset($_GET['act']) ? trim($_GET['act']) : '';

switch($act) {

  case 'confirmation':

    // Confirmation
    if(isset($_GET['trx']) && !empty($_GET['trx'])) {

      // Execute
      $trx = strip_tags(base64_decode($_GET['trx']));
      $id = $core->insert_data('notifications');
      $i = $intbyte->query("INSERT INTO notifications (`id`, `title`, `content`, `time`, `status`, `type`, `user_id`, `notification_for`) VALUES('".$id."', '".$lang['user_UPGRADE_PROOF'].": ".$trx."', '<b>TRX:</b> ".$trx." <br/> <b>From: </b> ".$core->username($info['id'])."', '".time()."', 'Unread', 'fas fa-info-circle', '".$info['id']."', 'Admin')");
      if($i) {

        // Successfully confirmation
        $core->redirect(base_url().'/user/premium/?s=1');
      } else {

        // Failed confirmation
        $core->redirect(base_url().'/user/premium/?s=2');
      }
    } else {

      // Illegal Access
      $core->redirect(base_url().'/user/premium/?s=3');
    }
  break;

  default:

    // Section upgrade account
    echo '<section class="section">';

    echo '<div class="section-header">
      <h1 class="section-title">
        '.$lang['user_UPGRADE_ACCOUNT'].'
      </h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">
          <a href="'.base_url().'/user/">
            Dashboard
          </a>
        </div>
        <div class="breadcrumb-item">
          '.$lang['user_UPGRADE_ACCOUNT'].'
        </div>
      </div>
    </div>';

    echo '<div class="row">';

    // Status
    if(isset($_GET['s'])) {

      $type = intval($_GET['s']);
      if($type == 1) {

        // Successfully status
        echo "<script>
          $(document).ready(function() {
            swal('".$lang['user_UPGRADE_CS']."', {
              icon: 'success',
              buttons: false,
              timer: 3000,
            }).then(function() {
              window.location = '".base_url()."/user/';
            });
          });
        </script>";
      } elseif($type == 2) {

        // Failed status
        echo "<script>
          $(document).ready(function() {
            swal('".$lang['user_UPGRADE_CF']."', {
              icon: 'warning',
              buttons: false,
              timer: 3000,
            }).then(function() {
              window.location = '".base_url()."/user/';
            });
          });
        </script>";
      } elseif($type == 3) {

        // Illegal access status
        echo "<script>
          $(document).ready(function() {
            swal('".$lang['user_UPGRADE_CI']."', {
              icon: 'warning',
              buttons: false,
              timer: 3000,
            }).then(function() {
              window.location = '".base_url()."/user/';
            });
          });
        </script>";
      }
    }

    // HTML form
    echo '<div class="page-error">
      <div class="page-inner">
        <div class="page-description">
          <img src="'.base_url().'/images/icon/upgrade.png" alt="thumbnail" width="360"/>
          <p class="text-muted">
            '.$lang['user_UPGRADE_I'].'
          </p>
          <p class="text-muted text-left">
            '.$lang['user_UPGRADE_BENEFITS'].'
          </p>
        </div>
        <div class="page-search">
          <div class="mt-3">
            <div class="row">
              <div class="col-12 col-md-6 col-lg-6">
                '.$core->set('paypal').'
              </div>
              <div class="col-12 col-md-6 col-lg-6">
                '.$core->set('bank').'
              </div>
            </div>
            <div class="row">
              <div class="col-12 offset-md-3 col-md-6 col-lg-6">
                '.$core->set('others').'
              </div>
            </div>
            <div class="row">
              <div class="col-12 offset-md-3 col-md-6 col-lg-6">
                <a id="confirmation" href="javascript: void(0);" class="btn btn-warning">
                  <i class="fas fa-clock"></i>
                  '.$lang['user_UPGRADE_CONFIRM'].'
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>';

    // Confirmation
    echo "<script>
      $(document).ready(function() {
        $('#confirmation').on('click', function() {
          swal({
            title: '".$lang['user_UPGRADE_CONFIRM']."',
            content: {
              element: 'input',
              attributes: {
                placeholder: '".$lang['user_UPGRADE_CONFIRM2']."',
                type: 'text',
                value: '".$lang['user_UPGRADE_CONFIRM2']."',
              },
            },
          }).then((data) => {
            if(data) {
              swal('".$lang['user_UPGRADE_CS']."', {
                icon: 'success',
                buttons: false,
                timer: 3000,
              }).then(function() {
                var enc = btoa(data);
                window.location = '".base_url()."/user/premium/?act=confirmation&trx=' + enc;
              });
            }
          });
        });
      });
    </script>";

    echo '</div>';
    echo '</section>';
    require_once '../incfiles/footer.php';
  break;
}
?>
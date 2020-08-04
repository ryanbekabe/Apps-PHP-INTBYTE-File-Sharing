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
require_once '../incfiles/lang.php';
require_once '../helpers/session.class.php';
require_once '../helpers/coreFunc.class.php';

// If not an User, the system will be redirect to the index page or home page
if(!$session->is_login()) {
  $core->redirect(base_url().'/');
}

// The user informations
$q = $intbyte->query("SELECT * FROM users WHERE id = '".$session->is_login()."'");
$info = $q->fetch_assoc();

// Start delete account page
echo '<!DOCTYPE html>
  <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
      <title>
        '.$lang['user_DELETE'].' | '.$core->set('title').'
      </title>';

// Meta tags seo
echo '<meta name="description" content="Delete my account.">
  <meta name="keywords" content="'.$core->set('keywords').'">';

// Meta facebook opengraph
echo '<meta property="og:title" content="'.$lang['user_DELETE'].' | '.$core->set('title').'">
  <meta property="og:url" content="'.base_url().'/login/">
  <meta property="og:image" content="'.base_url().'/assets/img/logo2.png">
  <meta property="og:site_name" content="'.$core->set('title').'">
  <meta property="description" content="Delete my account.">';

// General CSS files
echo '<link rel="stylesheet" href="'.base_url().'/assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="'.base_url().'/assets/modules/fontawesome/css/all.min.css">';

// CSS libraries
echo '<link rel="stylesheet" href="'.base_url().'/assets/modules/bootstrap-social/bootstrap-social.css">';

// Template CSS
echo '<link rel="stylesheet" href="'.base_url().'/assets/css/style.css">
  <link rel="stylesheet" href="'.base_url().'/assets/css/components.css">';

// Module sweetalert
echo '<script src="'.base_url().'/assets/modules/jquery.min.js"></script>
  <script src="'.base_url().'/assets/modules/sweetalert/sweetalert.min.js"></script>';

echo '</head>';
echo '<body>';

if($info['rights'] > 0) {

  // Unblocked user
  if(isset($_POST['delete'])) {

    // The user delete data
    $password = strip_tags(trim($core->filter_input($_POST['password'])));

    if(empty($password)) {

      // Empty data
      echo "<script>
        $(document).ready(function() {
          swal(
            'WARNING!',
            '".$lang['user_DELETE_EMPTY']."',
            'warning'
          );
        });
      </script>";
    } elseif(!password_verify($password, $info['password'])) {

      // If the password is not valid
      echo "<script>
        $(document).ready(function() {
          swal(
            'WARNING!',
            '".$lang['user_DELETE_IPASS']."',
            'warning'
          );
        });
      </script>";
    } elseif($info['id'] == 1) {

      // If the main admin will delete account
      echo "<script>
        $(document).ready(function() {
          swal(
            'WARNING!',
            '".$lang['user_DELETE_MA']."',
            'warning'
          );
        });
      </script>";
    } else {

      // Execute
      $q = $intbyte->query("SELECT * FROM users WHERE id = '".$info['id']."'");
      if($q->num_rows > 0) {

        // Delete: Remove path, user ads, all files, and user folders
        $core->remove_path('../data/'.$core->username($info['id']).'/');
        if(rmdir('../data/'.$core->username($info['id']).'/')) {

          // The user data
          $a = $intbyte->query("DELETE FROM ads WHERE user_id = ".$info['id']."");
          $s = $intbyte->query("DELETE FROM files WHERE user_id = ".$info['id']."");
          $u = $intbyte->query("DELETE FROM folders WHERE user_id = ".$info['id']."");
          $s = $intbyte->query("DELETE FROM users WHERE id = ".$info['id']."");
          if($a && $s && $u && $s) {

            // Successfully deleted the user
            echo "<script>
              $(document).ready(function() {
                swal(
                  '".$lang['user_DELETE_SS']."', {
                    title: 'SUCCESS!',
                    icon: 'success',
                    buttons: false,
                    timer: 3000,
                }).then((willDelete) => {
                  if(willDelete) {
                    window.location = '".base_url()."/logout/';
                  } else {
                    window.location = '".base_url()."/logout/';
                  }
                });
              });
            </script>";
          } else {

            // Failed deleted the user
            echo "<script>
              $(document).ready(function() {
                swal(
                  '".$lang['user_DELETE_FS']."', {
                    title: 'ERROR!',
                    icon: 'error',
                    buttons: false,
                    timer: 3000,
                }).then((willDelete) => {
                  if(willDelete) {
                    window.location = '".base_url()."/user/';
                  } else {
                    window.location = '".base_url()."/user/';
                  }
                });
              });
            </script>";
          }
        } else {
          
          // Failed deleted the user directory
          echo "<script>
            $(document).ready(function() {
              swal(
                '".$lang['user_DELETE_DS']."', {
                  title: 'ERROR!',
                  icon: 'error',
                  buttons: false,
                  timer: 3000,
              }).then((willDelete) => {
                if(willDelete) {
                  window.location = '".base_url()."/user/';
                } else {
                  window.location = '".base_url()."/user/';
                }
              });
            });
          </script>";
        }
      } else {

        // Data not available
        echo "<script>
          $(document).ready(function() {
            swal(
              'WARNING!',
              '".$lang['user_DELETE_DNA']."',
              'warning'
            );
          });
        </script>";
      }
    }
  }

  // HTML form
  echo '<div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3">
            <div class="login-brand">
              <img src="'.base_url().'/assets/img/logo2.png" alt="logo" width="250" class="shadow-light" style="border: 1px solid #DDDDDD;box-shadow: 5px 5px 5px 0px #333333;">
            </div>
            <div class="card card-primary">
              <div class="card-header">
                <h4>
                  '.$lang['user_DELETE'].'
                </h4>
              </div>
              <div class="card-body">
                <form method="POST" class="needs-validation" novalidate="">
                  <span class="text-muted">
                    '.$lang['user_DELETE_TEXT'].'
                  </span>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="fas fa-key"></i>
                        </div>
                      </div>
                      <input id="password" type="password" value="" class="form-control" name="password" tabindex="1" required="" autofocus>
                      <div class="invalid-feedback">
                        '.$lang['user_DELETE_IFB'].'
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="agree" class="custom-control-input" tabindex="2" id="remember-me" required="">
                      <label class="custom-control-label" for="remember-me">
                        '.$lang['user_DELETE_AGREE'].'
                      </label>
                    </div>
                  </div>
                  <div class="form-group text-center">
                    <button type="submit" name="delete" tabindex="3" class="btn btn-lg btn-block btn-primary">
                      '.$lang['user_DELETE_BTN'].'
                    </button>
                  </div>
                  <div class="form-group text-center">
                    <a href="javascript: history.back(-1);" tabindex="4" class="btn btn-sm btn-round btn-warning">
                      <i class="fas fa-arrow-left"></i>
                      '.$lang['user_DELETE_BACK'].'
                    </a>
                  </div>
                </form>
              </div>
            </div>
            <div class="simple-footer">
              Copyright &copy; '.$core->set('title').' 2019 - '.date('Y').'
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>';
} else {

  // Blocked user
  // HTML form
  echo '<div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3">
            <div class="login-brand">
              <img src="'.base_url().'/assets/img/logo2.png" alt="logo" width="250" class="shadow-light" style="border: 1px solid #DDDDDD;box-shadow: 5px 5px 5px 0px #333333;">
            </div>
            <div class="card card-primary">
              <div class="card-header">
                <h4>
                  '.$lang['user_DELETE'].'
                </h4>
              </div>
              <div class="card-body">
                <form method="POST" class="needs-validation" novalidate="">
                  <span class="text-muted">
                    '.$lang['user_DELETE_TEXT'].'
                  </span>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="fas fa-key"></i>
                        </div>
                      </div>
                      <input id="password" type="password" value="" class="form-control" name="password" tabindex="1" required="" autofocus>
                      <div class="invalid-feedback">
                        '.$lang['user_DELETE_IFB'].'
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="agree" class="custom-control-input" tabindex="2" id="remember-me" required="">
                      <label class="custom-control-label" for="remember-me">
                        '.$lang['user_DELETE_AGREE'].'
                      </label>
                    </div>
                  </div>
                  <div class="form-group text-center">
                    <button type="submit" name="delete" tabindex="3" class="btn btn-lg btn-block btn-primary">
                      '.$lang['user_DELETE_BTN'].'
                    </button>
                  </div>
                  <div class="form-group text-center">
                    <a href="javascript: history.back(-1);" tabindex="4" class="btn btn-sm btn-round btn-warning">
                      <i class="fas fa-arrow-left"></i>
                      '.$lang['user_DELETE_BACK'].'
                    </a>
                  </div>
                </form>
              </div>
            </div>
            <div class="simple-footer">
              Copyright &copy; '.$core->set('title').' 2019 - '.date('Y').'
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>';

  // Redirect to logout after 3 seconds
  echo "<script>
    $(document).ready(function() {
      swal('".$lang['user_BANNED']."', {
        title: 'ERROR!',
        icon: 'error',
        buttons: false,
        timer: 3000,
      }).then((willBanned) => {
        if(willBanned) {
          window.location = '".base_url()."/logout/';
        } else {
          window.location = '".base_url()."/logout/';
        }
      });
    });
  </script>";
}

// General JS scripts
echo '<script src="'.base_url().'/assets/modules/popper.js"></script>
  <script src="'.base_url().'/assets/modules/tooltip.js"></script>
  <script src="'.base_url().'/assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="'.base_url().'/assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="'.base_url().'/assets/modules/moment.min.js"></script>
  <script src="'.base_url().'/assets/js/stisla.js"></script>';
  
// Template JS files
echo '<script src="'.base_url().'/assets/js/scripts.js"></script>
  <script src="'.base_url().'/assets/js/custom.js"></script>';

echo '</body>
</html>';
?>
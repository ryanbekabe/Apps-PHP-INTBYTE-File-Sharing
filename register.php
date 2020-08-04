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
require_once 'incfiles/lang.php';
require_once 'helpers/session.class.php';
require_once 'helpers/coreFunc.class.php';

// Start the register page
echo '<!DOCTYPE html>
  <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
      <title>
        '.(
            (trim($_GET['act']) == 'verify') ? $lang['register_PAGE_VERIFY'] : 
              ((trim($_GET['act']) == 'status') ? $lang['register_PAGE_STATUS'] : 
              $lang['register_PAGE'])
          ).'
        | 
        '.$core->set('title').'
      </title>';

// Meta tags SEO
echo '<meta name="description" content="Create an account for start your activity in our service.">
  <meta name="keywords" content="Register, Account, INTBYTE, File Sharing">';

// Meta facebook opengraph
echo '<meta property="og:title" content="Register | '.$core->set('title').'">
  <meta property="og:url" content="'.base_url().'/login/">
  <meta property="og:image" content="'.base_url().'/assets/img/logo2.png">
  <meta property="og:site_name" content="'.$core->set('title').'">
  <meta property="description" content="Create an account for start your activity in our service.">';

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

$act = isset($_GET['act']) ? trim($_GET['act']) : '';
switch($act) {

  case 'verify':

    // The user verification
    if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['token']) && !empty($_GET['token'])) {

      // The user verification data
      $email = $core->filter_input($core->escapeToDB($_GET['email']));
      $token = $core->filter_input($core->escapeToDB($_GET['token']));

      if(!$core->is_email($email)) {

        // If the email is not valid
        echo "<script>
          $(document).ready(function() {
            swal('".$lang['register_INVALID_EMAIL']."', {
              title: 'WARNING!',
              icon: 'warning',
              buttons: false,
              timer: 3000,
            });
          });
        </script>";
      } else {

        // Check the email and token
        $q = $intbyte->query("SELECT * FROM users WHERE email = '".$email."' AND token = '".$token."' AND status = '0'");
        if($q->num_rows > 0) {

          // Execute
          $u = $intbyte->query("UPDATE users SET token = '".$core->genChar(15, TRUE)."', status = '1' WHERE email = '".$email."' AND status = '0'");
          if($u) {

            // Successfully updated the user verification
            echo "<script>
              $(document).ready(function() {
                swal('".$lang['register_VERIFY_SUCCESS']."', {
                  title: 'SUCCESS!',
                  icon: 'success',
                  buttons: false,
                  timer: 3000,
                }).then(function() {
                  window.location = '".base_url()."/login/';
                });
              });
            </script>";
          } else {

            // Failed updated the user verification
            echo "<script>
              $(document).ready(function() {
                swal('".$lang['register_VERIFY_FAILED']."', {
                  title: 'WARNING!',
                  icon: 'warning',
                  buttons: false,
                  timer: 3000,
                }).then(function() {
                  window.location = '".base_url()."/login/';
                });
              });
            </script>";
          }
        } else {

          // Data not available
          echo "<script>
            $(document).ready(function() {
              swal('".$lang['register_VERIFY_NFD']."', {
                title: 'WARNING!',
                icon: 'warning',
                buttons: false,
                timer: 3000,
              }).then(function() {
                window.location = '".base_url()."/login/';
              });
            });
          </script>";
        }
      }
    } else { 

      // Illegal access
      echo "<script>
        $(document).ready(function() {
          swal('".$lang['register_VERIFY_I']."', {
            title: 'WARNING!',
            icon: 'warning',
            buttons: false,
            timer: 3000,
          }).then(function() {
            window.location = '".base_url()."/login/';
          });
        });
      </script>";
    }
  break;

  default:

    // The registration status
    if($core->set('registration_status') == 'Close') {

      // Close the registration
      echo "<script>
        $(document).ready(function() {
          swal('".$lang['register_CLOSE']."', {
            title: 'WARNING!',
            icon: 'warning',
            buttons: false,
            timer: 3000,
          }).then(function() {
            window.location = '".base_url()."/login/';
          });
        });
      </script>";
    } else {

      // Open the registration
      if(isset($_POST['register'])) {

        // The register data
        $username = strip_tags($core->filter_input($_POST['username']));
        $email = strip_tags($core->filter_input($_POST['email']));
        $password = strip_tags(trim($core->filter_input($_POST['password'])));
        $password_confirm = strip_tags(trim($core->filter_input($_POST['password_confirm'])));
        $token = $core->genChar(15, TRUE);
  
        if(empty($username) || empty($email) || empty($password) || empty($password_confirm)) {
  
          // Empty data
          echo "<script>
            $(document).ready(function() {
              swal('".$lang['register_ALL_REQUIRED']."', {
                title: 'WARNING!',
                icon: 'warning',
                buttons: false,
                timer: 3000,
              });
            });
          </script>";
        } elseif(!$core->is_username($username)) {
  
          // If the username is not valid
          echo "<script>
            $(document).ready(function() {
              swal('".$lang['register_INVALID_USERNAME']."', {
                title: 'WARNING!',
                icon: 'warning',
                buttons: false,
                timer: 3000,
              });
            });
          </script>";
        } elseif(strlen($username) < 4 || strlen($username) > 30) {
  
          // Check the length of username
          echo "<script>
            $(document).ready(function() {
              swal('".$lang['register_LEN_USERNAME']."', {
                title: 'WARNING!',
                icon: 'warning',
                buttons: false,
                timer: 3000,
              });
            });
          </script>";
        } elseif($intbyte->query("SELECT * FROM users WHERE username = '".$username."'")->num_rows > 0) {

          // Check the username is exists
          echo "<script>
            $(document).ready(function() {
              swal('".$lang['register_USERNAME_EXISTS']."', {
                title: 'WARNING!',
                icon: 'warning',
                buttons: false,
                timer: 3000,
              });
            });
          </script>";
        } elseif(!$core->is_email($email)) {
  
          // If the email is not valid
          echo "<script>
            $(document).ready(function() {
              swal('".$lang['register_INVALID_EMAIL']."', {
                title: 'WARNING!',
                icon: 'warning',
                buttons: false,
                timer: 3000,
              });
            });
          </script>";
        } elseif(strlen($email) < 4 || strlen($email) > 30) {
  
          // Check the length of email
          echo "<script>
            $(document).ready(function() {
              swal('".$lang['register_LEN_EMAIL']."', {
                title: 'WARNING!',
                icon: 'warning',
                buttons: false,
                timer: 3000,
              });
            });
          </script>";
        } elseif($intbyte->query("SELECT * FROM users WHERE email = '".$email."'")->num_rows > 0) {

          // Check the email is exists
          echo "<script>
            $(document).ready(function() {
              swal('".$lang['register_EMAIL_EXISTS']."', {
                title: 'WARNING!',
                icon: 'warning',
                buttons: false,
                timer: 3000,
              });
            });
          </script>";
        } elseif(strlen($password) < 8) {
  
          // Check the length of password
          echo "<script>
            $(document).ready(function() {
              swal('".$lang['register_LEN_PASSWORD']."', {
                title: 'WARNING!',
                icon: 'warning',
                buttons: false,
                timer: 3000,
              });
            });
          </script>";
        } elseif($password != $password_confirm) {
  
          // If the password is not valid
          echo "<script>
            $(document).ready(function() {
              swal('".$lang['register_INVALID_PASSWORD']."', {
                title: 'WARNING!',
                icon: 'warning',
                buttons: false,
                timer: 3000,
              });
            });
          </script>";
        } else {
          
          // The register verification status
          if($core->set('verify_status') == 'Verify') {

            // The register with verification steps
            $id = $core->insert_data('users');
            @mkdir('data/'.$username.'');
            @file_put_contents('data/'.$username.'/index.php', 'Access Denied!');
            $i = $intbyte->query("INSERT INTO users (`id`, `username`, `fullname`, `description`, `email`, `password`, `type`, `rights`, `files`, `storage`, `time`, `status`, `token`) VALUES ('".$id."', '".$username."', '".$username."', '', '".$email."', '".password_hash($password, PASSWORD_DEFAULT)."', '2', '2', '0', '0', '".time()."', '0', '".$token."')");
            $f = $intbyte->query("INSERT INTO folders (`name`, `user_id`) VALUES ('{ROOT}', '".$id."')");
            if($i && $f) {
              
              // The system will be sending the link verification to the user email
              $to = $email;
              $subject = 'Welcome To '.$core->set('title').'';
              $message = 'Hi '.$username.',
                
                Thanks to register in our service.
                Please confirmation your account for start activity in our service.

                Please click the link bellow to verification your account:
            
                <a href="'.base_url().'/register/?act=verify&email='.$email.'&token='.$token.'">
                  '.base_url().'/register/?act=verify&email='.$email.'&token='.$token.'
                </a>

                Thanks You!

                <hr/>
                Best regards, <b> '.ucfirst($core->set('title')).'</b>
            
                <center>
                &copy; 2019 - '.date('Y').' by '.ucfirst($core->set('title')).' Co, Ltd. All Rights Reserved.
                </center>';
            
              $message = nl2br($message);
            
              //Headers
              $headers = "MIME-Version: 1.0\r\n";
              $headers = "From: ".ucfirst($core->set("title"))." < ".strtolower($core->set("title"))."@no-reply.com >\r\n"."Reply-To: ".ucfirst($core->set("title"))." < ".strtolower($core->set("title"))."@no-reply.com >\n"."X-Mailer: PHP/".phpversion();
              $headers .= "Reply-To: ".ucfirst($core->set("title"))." < ".strtolower($core->set("title"))."@no-reply.com >"."\r\n";
              $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

              mail($to, $subject, $message, $headers);
              if(@mail) {

                // Successfully register the user
                echo "<script>
                  $(document).ready(function() {
                    swal('".$lang['register_SUCCESS_VERIFY']."', {
                      title: 'SUCCESS!',
                      icon: 'success',
                      buttons: false,
                      timer: 3000,
                    }).then(function() {
                      window.location = '".base_url()."/login/';
                    });
                  });
                </script>";
              } else {

                // Failed register the user
                echo "<script>
                  $(document).ready(function() {
                    swal('".$lang['register_FAILED_VERIFY']."', {
                      title: 'WARNING!',
                      icon: 'warning',
                      buttons: false,
                      timer: 3000,
                    }).then(function() {
                      window.location = '".base_url()."/login/';
                    });
                  });
                </script>";
              }
            } else {

              // Failed register the user
              echo "<script>
                $(document).ready(function() {
                  swal('".$lang['register_FAILED_VERIFY']."', {
                    title: 'WARNING!',
                    icon: 'warning',
                    buttons: false,
                    timer: 3000,
                  }).then(function() {
                    window.location = '".base_url()."/login/';
                  });
                });
              </script>";
            }
          } else {

            // The register without verification steps
            $id = $core->insert_data('users');
            @mkdir('data/'.$username.'');
            @file_put_contents('data/'.$username.'/index.php', 'Access Denied!');
            $i = $intbyte->query("INSERT INTO users (`id`, `username`, `fullname`, `description`, `email`, `password`, `type`, `rights`, `files`, `storage`, `time`, `status`, `token`) VALUES ('".$id."', '".$username."', '".$username."', '', '".$email."', '".password_hash($password, PASSWORD_DEFAULT)."', '2', '2', '0', '0', '".time()."', '1', '".$token."')");
            $f = $intbyte->query("INSERT INTO folders (`name`, `user_id`) VALUES ('{ROOT}', '".$id."')");
            if($i && $f) {

              // The system will be sending the email
              $to = $email;
              $subject = 'Welcome To '.$core->set('title').'';
              $message = 'Hi '.$username.',
                
                Thanks to register in our service.
                Please save your login data bellow on the place that safety.

                <b>Username:</b> '.$username.'
                <b>Email:</b> '.$email.'
                <b>Password:</b> ********
                <b>Token:</b> '.$token.'

                Thanks You!

                <hr/>
                Best regards, <b> '.ucfirst($core->set('title')).'</b>
            
                <center>
                &copy; 2019 - '.date('Y').' by '.ucfirst($core->set('title')).' Co, Ltd. All Rights Reserved.
                </center>';
            
              $message = nl2br($message);
            
              //Headers
              $headers = "MIME-Version: 1.0\r\n";
              $headers = "From: ".ucfirst($core->set("title"))." < ".strtolower($core->set("title"))."@no-reply.com >\r\n"."Reply-To: ".ucfirst($core->set("title"))." < ".strtolower($core->set("title"))."@no-reply.com >\n"."X-Mailer: PHP/".phpversion();
              $headers .= "Reply-To: ".ucfirst($core->set("title"))." < ".strtolower($core->set("title"))."@no-reply.com >"."\r\n";
              $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

              mail($to, $subject, $message, $headers);
              if(@mail) {

                // Successfully register the user
                echo "<script>
                  $(document).ready(function() {
                    swal('".$lang['register_SUCCESS_WV']."', {
                      title: 'SUCCESS!',
                      icon: 'success',
                      buttons: false,
                      timer: 3000,
                    }).then(function() {
                      window.location = '".base_url()."/login/';
                    });
                  });
                </script>";
              } else {

                // Failed register the user
                echo "<script>
                  $(document).ready(function() {
                    swal('".$lang['register_FAILED_WV']."', {
                      title: 'WARNING!',
                      icon: 'warning',
                      buttons: false,
                      timer: 3000,
                    }).then(function() {
                      window.location = '".base_url()."/login/';
                    });
                  });
                </script>";
              }
            } else {

              // Failed register the user
              echo "<script>
                $(document).ready(function() {
                  swal('".$lang['register_FAILED_WV']."', {
                    title: 'WARNING!',
                    icon: 'warning',
                    buttons: false,
                    timer: 3000,
                  }).then(function() {
                    window.location = '".base_url()."/login/';
                  });
                });
              </script>";
            }
          }
        }
      } else {

        // If the user logged access this page
        if($session->is_login()) {
          $core->redirect(base_url().'/');
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
                      '.$lang['register_PAGE'].'
                    </h4>
                  </div>
                  <div class="card-body">
                    <form method="POST" class="needs-validation" novalidate="">
                      <span class="text-muted">
                        '.$lang['register_PAGE_WELCOME'].'
                      </span>
                      <div class="form-group">
                        <label for="email">
                          '.$lang['register_PAGE_USERNAME'].'
                        </label>
                        <input id="username" type="text" class="form-control" name="username" required autofocus>
                        <div class="invalid-feedback">
                          '.$lang['register_PAGE_UFB'].'
                        </div>
                      </div>
                      <div class="row">
                      <div class="form-group col-6">
                        <label for="password" class="d-block">
                          '.$lang['register_PAGE_PASSWORD'].'
                        </label>
                        <input id="password" type="password" class="form-control pwstrength" data-indicator="pwindicator" name="password" required>
                        <div class="invalid-feedback">
                          '.$lang['register_PAGE_PFB'].'
                        </div>
                        <div id="pwindicator" class="pwindicator">
                          <div class="bar"></div>
                          <div class="label"></div>
                        </div>
                      </div>
                      <div class="form-group col-6">
                        <label for="password2" class="d-block">
                          '.$lang['register_PAGE_PASSWORD_CONFIRM'].'
                        </label>
                        <input id="password2" type="password" class="form-control" name="password_confirm" required>
                        <div class="invalid-feedback">
                          '.$lang['register_PAGE_PCFB'].'
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="email">
                        Email
                      </label>
                      <input id="email" type="email" class="form-control" name="email" required>
                      <div class="invalid-feedback">
                        '.$lang['register_PAGE_EFB'].'
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="agree" class="custom-control-input" id="agree" required>
                        <label class="custom-control-label" for="agree">
                          '.$lang['register_PAGE_AGREE'].'
                        </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <button type="submit" name="register" class="btn btn-primary btn-lg btn-block">
                        '.$lang['register_PAGE_BTN'].'
                      </button>
                    </div>
                    </form>
                  </div>
                </div>
                <div class="mt-5 text-muted text-center">
                  '.$lang['register_PAGE_DHA'].'
                  <a href="'.base_url().'/login/">
                    '.$lang['login_PAGE_BTN'].'
                  </a>
                </div>
                <div class="simple-footer">
                  Copyright &copy; '.$core->set('title').' 2019 - '.date('Y').'
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>';
    }
  break;
}

// General JS scripts
echo '<script src="'.base_url().'/assets/modules/popper.js"></script>
  <script src="'.base_url().'/assets/modules/tooltip.js"></script>
  <script src="'.base_url().'/assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="'.base_url().'/assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="'.base_url().'/assets/modules/moment.min.js"></script>
  <script src="'.base_url().'/assets/js/stisla.js"></script>';

// Page spesific JS files
echo '<script src="'.base_url().'/assets/modules/jquery-pwstrength/jquery.pwstrength.min.js"></script>
  <script src="'.base_url().'/assets/js/page/auth-register.js"></script>';

// Template JS files
echo '<script src="'.base_url().'/assets/js/scripts.js"></script>
  <script src="'.base_url().'/assets/js/custom.js"></script>';

echo '</body>
</html>';
?>
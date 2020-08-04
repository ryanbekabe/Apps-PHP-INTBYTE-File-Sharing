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

// Start the login page
echo '<!DOCTYPE html>
  <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
      <title>
        '.(
            (trim($_GET['act']) == 'lost_password') ? $lang['login_LOST_PASSWORD'] : 
              ((trim($_GET['act']) == 'reset') ? $lang['login_RESET_PASSWORD'] : 
              $lang['login_PAGE'])
          ).'
        | 
        '.$core->set('title').'
      </title>';

// Meta tags SEO
echo '<meta name="description" content="Login account for start your activity in our service.">
  <meta name="keywords" content="'.$core->set('keywords').'">';

// Meta facebook opengraph
echo '<meta property="og:title" content="'.$lang['login_PAGE'].' | '.$core->set('title').'">
  <meta property="og:url" content="'.base_url().'/login/">
  <meta property="og:image" content="'.base_url().'/assets/img/logo2.png">
  <meta property="og:site_name" content="'.$core->set('title').'">
  <meta property="description" content="Login account for start your activity in our service.">';

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

  case 'lost_password':

    // The lost password
    if(isset($_POST['lost_password'])) {

      // The user data
      $email = strip_tags($core->escapeToDB($core->filter_input($_POST['email'])));

      if(empty($email)) {

        // Empty data
        echo "<script>
          $(document).ready(function() {
            swal('".$lang['login_ALL_REQUIRED']."', {
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
            swal('".$lang['login_INVALID_EMAIL']."', {
              title: 'WARNING!',
              icon: 'warning',
              buttons: false,
              timer: 3000,
            });
          });
        </script>";
      } else {

        // Check the email exists
        $q = $intbyte->query("SELECT * FROM users WHERE email = '".$email."'");
        if($q->num_rows > 0) {

          $info = $q->fetch_assoc();
          if($info['rights'] == 0) {

            // Check the user status
            // 0, (Banned), 1 (Admin), 2 (User)
            echo "<script>
              $(document).ready(function() {
                swal('".$lang['login_USER_BANNED']."', {
                  title: 'WARNING!',
                  icon: 'warning',
                  buttons: false,
                  timer: 3000,
                });
              });
            </script>";
          } elseif($info['status'] == 0) {

            // Check the user verification status
            echo "<script>
              $(document).ready(function() {
                swal('".$lang['login_USER_STATUS']."', {
                  title: 'WARNING!',
                  icon: 'warning',
                  buttons: false,
                  timer: 3000,
                });
              });
            </script>";
          } else {

            //Send the link reset new password
            $to = $info['email'];
					  $subject = 'Request New Password Account '.$core->set('title').'';
            $message = 'Hi '.$core->username($info['id']).',
              
              You got this email because you just requested your new password.
					    Please click the link bellow to reset your password.
					
              <a href="'.base_url().'/login/?act=reset&email='.$info['email'].'&token='.$info['token'].'">
                '.base_url().'/login/?act=reset&email='.$info['email'].'&token='.$info['token'].'
              </a>
					
				    	Please use this token bellow to reset new password.
					
					    <center>
					      <hr style="width:70%;"/>
					      <hr style="width:60%;"/>
					      <hr style="width:50%;"/>
                <span style="font-size:50px;">
                  '.$info['token'].'
                </span>
					      <hr style="width:50%;"/>
					      <hr style="width:60%;"/>
					      <hr style="width:70%;"/>
					    </center>
					
				    	<b>ON:</b> <i>'.date('l, d F Y (H:i)').'</i>
					    <b>IP:</b> <i>'.$_SERVER['REMOTE_ADDR'].'</i>
				    	<b>DEVICE:</b> <i>'.$_SERVER['HTTP_USER_AGENT'].'</i>
					
					    If you did not make changes, please change your password immediately above.
					
					    <b>NOTE : </b> <i>Please don&#39;t reply to this message because this message was automatically sent to our system! </i>
					
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

              // Successfully sending the link
              echo "<script>
                $(document).ready(function() {
                  swal('".$lang['login_LOST_PASSWORD_SUCCESS']."', {
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

              // Failed sending the link
              echo "<script>
                $(document).ready(function() {
                  swal('".$lang['login_LOST_PASSWORD_FAILED']."', {
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

          // Data not available
          echo "<script>
            $(document).ready(function() {
              swal('".$lang['login_NF_EMAIL']."', {
                title: 'WARNING!',
                icon: 'warning',
                buttons: false,
                timer: 3000,
              });
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
                    '.$lang['login_LOST_PASSWORD'].'
                  </h4>
                </div>
                <div class="card-body">
                  <form method="POST" class="needs-validation" novalidate="">
                    <p class="text-muted">
                      '.$lang['login_LOST_PASSWORD_SEND'].'
                    </p>
                    <div class="form-group">
                      <label for="email">
                        Email
                      </label>
                      <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
                      <div class="invalid-feedback">
                          '.$lang['login_PAGE_EFB'].'
                      </div>
                    </div>
                    <div class="form-group">
                      <button type="submit" name="lost_password" class="btn btn-primary btn-lg btn-block" tabindex="4">
                        '.$lang['login_LOST_PASSWORD_REQUEST'].'
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
              <div class="mt-5 text-muted text-center">
                '.$lang['login_PAGE_DHA'].'
                <a href="'.base_url().'/register/">
                  '.$lang['login_PAGE_CO'].'
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
  break;

  case 'reset':

    // The reset
    if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['token']) && !empty($_GET['token'])) {

      // The new password data
      $email = strip_tags($core->filter_input($_GET['email']));
      $token = strip_tags($core->filter_input($_GET['token']));

      // Check the email and token
      $q = $intbyte->query("SELECT * FROM users WHERE email = '".$email."' AND token = '".$token."'");
      if($q->num_rows > 0) {

        $info = $q->fetch_assoc();
			  if(isset($_POST['reset'])) {

          // The new password data
				  $new_password = strip_tags(trim($core->filter_input($_POST['new_password'])));
				  $confirm_password = strip_tags(trim($core->filter_input($_POST['confirm_password'])));
          $_TOKEN = strip_tags($core->filter_input($_POST['TOKEN']));

          if(empty($new_password) || empty($confirm_password) || empty($_TOKEN)) {

            // Empty data
            echo "<script>
              $(document).ready(function() {
                swal('".$lang['login_ALL_REQUIRED']."', {
                  title: 'WARNING!',
                  icon: 'warning',
                  buttons: false,
                  timer: 3000,
                });
              });
            </script>";
          } elseif(strlen($new_password) < 8) {

            // Check the length of new password
            echo "<script>
              $(document).ready(function() {
                swal('".$lang['login_MIN_PASSWORD']."', {
                  title: 'WARNING!',
                  icon: 'warning',
                  buttons: false,
                  timer: 3000,
                });
              });
            </script>";
          } elseif($new_password != $confirm_password) {

            // If the new password is not valid
            echo "<script>
              $(document).ready(function() {
                swal('".$lang['login_INVALID_PASSWORD2']."', {
                  title: 'WARNING!',
                  icon: 'warning',
                  buttons: false,
                  timer: 3000,
                });
              });
            </script>";
          } elseif(password_verify($new_password, $info['password'])) {

            // If the new password is same
            echo "<script>
              $(document).ready(function() {
                swal('".$lang['login_PASSWORD_SAME']."', {
                  title: 'WARNING!',
                  icon: 'warning',
                  buttons: false,
                  timer: 3000,
                });
              });
            </script>";
          } elseif($_TOKEN != $info['token']) {

            // If the token is not valid
            echo "<script>
              $(document).ready(function() {
                swal('".$lang['login_INVALID_TOKEN']."', {
                  title: 'WARNING!',
                  icon: 'warning',
                  buttons: false,
                  timer: 3000,
                });
              });
            </script>";
          } else {

            // Execute
					  $update = $intbyte->query("UPDATE users SET password = '".password_hash($new_password, PASSWORD_DEFAULT)."', token = '".$core->genChar(15, TRUE)."' WHERE email = '".$core->escapeToDB($email)."' AND token = '".$core->escapeToDB($token)."' AND status = '1'");
					  if($update) {

              // Successfully to updated the password
              echo "<script>
                $(document).ready(function() {
                  swal('".$lang['login_RESET_PASSWORD_SUCCESS']."', {
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

              // Failed to updated the password
              echo "<script>
                $(document).ready(function() {
                  swal('".$lang['login_RESET_PASSWORD_FAILED']."', {
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

          if($info['rights'] == 0) {

            // Check the user status
            // 0, (Banned), 1 (Admin), 2 (User)
            echo "<script>
              $(document).ready(function() {
                swal('".$lang['login_STATUS_BANNED']."', {
                  title: 'WARNING!',
                  icon: 'warning',
                  buttons: false,
                  timer: 3000,
                });
              });
            </script>";
          } elseif($info['status'] == 0) {

            // Check the user verification status
            echo "<script>
              $(document).ready(function() {
                swal('".$lang['login_STATUS_UNCONFIRMED']."', {
                  title: 'WARNING!',
                  icon: 'warning',
                  buttons: false,
                  timer: 3000,
                });
              });
            </script>";
          }
        }
      } else {

        // Data not available
        echo "<script>
          $(document).ready(function() {
            swal('".$lang['login_NF_ET']."', {
              title: 'WARNING!',
              icon: 'warning',
              buttons: false,
              timer: 3000,
            });
          });
        </script>";
      }
    } else {

      // Illegal access
      echo "<script>
        $(document).ready(function() {
          swal('".$lang['login_WARNING']."', {
            title: 'WARNING!',
            icon: 'warning',
            buttons: false,
            timer: 3000,
          });
        });
      </script>";
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
                    '.$lang['login_RESET_PASSWORD'].'
                  </h4>
                </div>
                <div class="card-body">
                  <form method="POST" class="needs-validation" novalidate="">
                    <div class="form-group">
                      <label for="token">
                        Token
                      </label>
                      <input id="clicked" type="text" class="form-control" name="TOKEN" tabindex="1" value="'.$token.'" readonly>
                      <div class="invalid-feedback">
                          '.$lang['login_RESET_TFB'].'
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="d-block">
                        <label for="new_password" class="control-label">
                          '.$lang['login_RESET_PASSWORD_NEW'].'
                        </label>
                      </div>
                      <input id="password" type="password" class="form-control" name="new_password" tabindex="2" required autofocus>
                      <div class="invalid-feedback">
                        '.$lang['login_RESET_NPFB'].'
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="d-block">
                        <label for="confirm_password" class="control-label">
                          '.$lang['login_RESET_PASSWORD_CONFIRM'].'
                        </label>
                      </div>
                      <input id="password" type="password" class="form-control" name="confirm_password" tabindex="3" required>
                      <div class="invalid-feedback">
                        '.$lang['login_RESET_CPFB'].'
                      </div>
                    </div>
                    <div class="form-group">
                      <button type="submit" name="reset" class="btn btn-primary btn-lg btn-block" tabindex="5">
                        '.$lang['login_RESET_BTN'].'
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
              <div class="mt-5 text-muted text-center">
                '.$lang['login_PAGE_DHA'].'
                <a href="'.base_url().'/register/">
                  '.$lang['login_PAGE_CO'].'
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

    // The token
    echo "<script>
      $(document).ready(function() {
        $('#clicked').on('click', function() {
          swal('".$lang['login_TOKEN_CLICKED']."', {
            title: 'WARNING!',
            icon: 'warning',
            buttons: false,
            timer: 3000,
          });
        });
      });
    </script>";
  break;

  default:

    // The login page
    if(isset($_POST['login'])) {

      // The user data
      $email = strip_tags($core->escapeToDB($core->filter_input($_POST['email'])));
      $password = strip_tags($core->escapeToDB(trim($core->filter_input($_POST['password']))));

      if(empty($email) || empty($password)) {

        // Empty data
        echo "<script>
          $(document).ready(function() {
            swal('".$lang['login_ALL_REQUIRED']."', {
              title: 'WARNING!',
              icon: 'warning',
              buttons: false,
              timer: 3000,
            });
          });
        </script>";
      } elseif(!$core->is_email($email)) {

        // If the email is invalid
        echo "<script>
          $(document).ready(function() {
            swal('".$lang['login_INAVLID_EMAIL']."', {
              title: 'WARNING!',
              icon: 'warning',
              buttons: false,
              timer: 3000,
            });
          });
        </script>";
      } else {

        // Check the email and password
        $q = $intbyte->query("SELECT * FROM users WHERE email = '".$email."'");
        if($q->num_rows > 0) {

          $info = $q->fetch_assoc();
          if($info['rights'] == 0) {

            // Check the user status
            // 0, (Banned), 1 (Admin), 2 (User)
            echo "<script>
              $(document).ready(function() {
                swal('".$lang['login_USER_BANNED']."', {
                  title: 'WARNING!',
                  icon: 'warning',
                  buttons: false,
                  timer: 3000,
                });
              });
            </script>";
          } elseif($info['status'] == 0) {

            // Check the user verification status
            echo "<script>
              $(document).ready(function() {
                swal('".$lang['login_USER_STATUS']."', {
                  title: 'WARNING!',
                  icon: 'warning',
                  buttons: false,
                  timer: 3000,
                });
              });
            </script>";
          } else {

            // Check the password
            if(password_verify($password, $info['password'])) {

              // Successfully logged in

              // The session
              $_SESSION['user_id'] = $info['id'];
              $_SESSION['user_rights'] = $info['rights'];
              $_SESSION['user_logged'] = time();

              if($info['rights'] == 1) {
                
                // If the Admin, the system will be redirect to Administrator
                echo "<script>
                  $(document).ready(function() {
                    swal('".$lang['login_SUCCESS']."', {
                      title: 'SUCCESS!',
                      icon: 'success',
                      buttons: false,
                      timer: 3000,
                    }).then(function() {
                      window.location = '".base_url()."/admin/';
                    });
                  });
                </script>";
              } else {

                // The user will be redirect to INTBYTE panel
                echo "<script>
                  $(document).ready(function() {
                    swal('".$lang['login_SUCCESS']."', {
                      title: 'SUCCESS!',
                      icon: 'success',
                      buttons: false,
                      timer: 3000,
                    }).then(function() {
                      window.location = '".base_url()."/user/';
                    });
                  });
                </script>";
              }
            } else {

              // If the password is not valid
              echo "<script>
                $(document).ready(function() {
                  swal('".$lang['login_INVALID_PASSWORD']."', {
                    title: 'WARNING!',
                    icon: 'warning',
                    buttons: false,
                    timer: 3000,
                  });
                });
              </script>";
            }
          }
        } else {

          // Data not available
          echo "<script>
            $(document).ready(function() {
              swal('".$lang['login_NF_EMAIL']."', {
                title: 'WARNING!',
                icon: 'warning',
                buttons: false,
                timer: 3000,
              });
            });
          </script>";
        }
      }
    } else {

      // If the user logged access this login page
      if($session->is_login()) {
        session_destroy();
        echo "<script>
          $(document).ready(function() {
            swal('".$lang['login_SECURITY_SESSION']."', {
              title: 'WARNING!',
              icon: 'warning',
              buttons: false,
              timer: 3000,
            });
          });
        </script>";
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
                    '.$lang['login_PAGE'].'
                  </h4>
                </div>
                <div class="card-body">
                  <form method="POST" class="needs-validation" novalidate="">
                    <div class="form-group">
                      <label for="email">
                        Email
                      </label>
                      <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
                      <div class="invalid-feedback">
                          '.$lang['login_PAGE_EFB'].'
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="d-block">
                        <label for="password" class="control-label">
                          '.$lang['login_PAGE_PASSWORD'].'
                        </label>
                        <div class="float-right">
                          <a href="'.base_url().'/login/?act=lost_password" class="text-small">
                            '.$lang['login_LOST_PASSWORD'].'?
                            </a>
                        </div>
                      </div>
                      <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                      <div class="invalid-feedback">
                        '.$lang['login_PAGE_PFB'].'
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                        <label class="custom-control-label" for="remember-me">
                          '.$lang['login_PAGE_RM'].'
                        </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <button type="submit" name="login" class="btn btn-primary btn-lg btn-block" tabindex="4">
                        '.$lang['login_PAGE_BTN'].'
                      </button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="mt-5 text-muted text-center">
                '.$lang['login_PAGE_DHA'].'
                <a href="'.base_url().'/register/">
                  '.$lang['login_PAGE_CO'].'
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
  break;
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
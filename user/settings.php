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
require_once '../helpers/paging.class.php';
require_once '../helpers/time.class.php';
require_once '../incfiles/lang.php';

// If not an User, the system will be redirect to the index page or home page
if(!$session->is_login()) {
  $core->redirect(base_url().'/');
}

// The user informations
$q = $intbyte->query("SELECT * FROM users WHERE id = '".$session->is_login()."'");
$info = $q->fetch_assoc();

$act = isset($_GET['view']) ? trim($_GET['view']) : '';
switch($act) {

  case 'settings':

    // Types of settings
    if(isset($_GET['type'])) {
      if(urlencode($_GET['type']) == 'profile') {

        // The profile settings
        // Headers
        $title = $lang['userSettings_PROFILE'];
        require_once '../incfiles/header.php';

        // If not an User, the system will be redirect to the index page or home page
        if(!$session->is_login()) {
          $core->redirect(base_url().'/');
        }

        // Section the profile settings
        echo '<section class="section">';

        echo '<div class="section-header">
          <h1 class="section-title">
            '.$lang['userSettings_PROFILE'].'
          </h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="'.base_url().'/user/">
                Dashboard
              </a>
            </div>
            <div class="breadcrumb-item">
              '.$lang['userSettings_PROFILE'].'
            </div>
          </div>
        </div>';

        echo '<div class="row">';

        if($info['rights'] > 0) {

          // Unblocked user
          if(isset($_POST['submit'])) {

            // The profile settings data
            $username = strip_tags($core->filter_input($_POST['username']));
            $fullname = strip_tags($core->filter_input($_POST['fullname']));
            $email = strip_tags($core->filter_input($_POST['email']));
            $description = $core->filter_input($_POST['description']);

            if(empty($username) || empty($fullname) || empty($email)) {

              // Empty data
              echo "<script>
                $(document).ready(function() {
                  swal('".$lang['userSettings_PROFILE_ED']."', {
                    title: 'WARNING!',
                    icon: 'warning',
                    buttons: false,
                    timer: 3000,
                  });
                });
              </script>";
            } elseif(strlen($fullname) < 3 || strlen($fullname) > 30) {

              // Check the length of full name
              echo "<script>
                $(document).ready(function() {
                  swal('".$lang['userSettings_PROFILE_LOFN']."', {
                    title: 'WARNING!',
                    icon: 'warning',
                    buttons: false,
                    timer: 3000,
                  });
                });
              </script>";
            } elseif(!preg_match('/^[a-zA-Z0-9 ]*$/', $fullname)) {

              // The full name is not valid
              echo "<script>
                $(document).ready(function() {
                  swal('".$lang['userSettings_PROFILE_IFN']."', {
                    title: 'WARNING!',
                    icon: 'warning',
                    buttons: false,
                    timer: 3000,
                  });
                });
              </script>";
            } elseif(strlen($email) < 8 || strlen($email) > 30) {

              // Check the length of email
              echo "<script>
                $(document).ready(function() {
                  swal('".$lang['userSettings_PROFILE_LOE']."', {
                    title: 'WARNING!',
                    icon: 'warning',
                    buttons: false,
                    timer: 3000,
                  });
                });
              </script>";
            } elseif(!$core->is_email($email)) {

              // The email is not valid
              echo "<script>
                $(document).ready(function() {
                  swal('".$lang['userSettings_PROFILE_EINV']."', {
                    title: 'WARNING!',
                    icon: 'warning',
                    buttons: false,
                    timer: 3000,
                  });
                });
              </script>";
            } elseif(strlen($description) > 2048) {

              // Check the length of description
              echo "<script>
                $(document).ready(function() {
                  swal('".$lang['userSettings_PROFILE_LOD']."', {
                    title: 'WARNING!',
                    icon: 'warning',
                    buttons: false,
                    timer: 3000,
                  });
                });
              </script>";
            } else {

              // Execute
              $u = $intbyte->query("UPDATE users SET username = '".$username."', fullname = '".$fullname."', email = '".$email."', description = '".$description."' WHERE id = '".$info['id']."'");
              if($u) {

                // Successfully updated the profile settings
                echo "<script>
                  $(document).ready(function() {
                    swal('".$lang['userSettings_PROFILE_S']."', {
                      title: 'SUCCESS!',
                      icon: 'success',
                      buttons: false,
                      timer: 3000,
                    }).then(function() {
                      window.location = '".base_url()."/user/settings/?view=settings&type=profile';
                    });
                  });
                </script>";
              } else {

                // Failed updated the profile settings
                echo "<script>
                  $(document).ready(function() {
                    swal('".$lang['userSettings_PROFILE_F']."', {
                      title: 'WARNING!',
                      icon: 'warning',
                      buttons: false,
                      timer: 3000,
                    }).then(function() {
                      window.location = '".base_url()."/user/settings/?view=settings&type=profile';
                    });
                  });
                </script>";
              }
            }
          }

          // HTML form
          echo '<div class="col-12 col-md-6 col-lg-12">
            <div class="card card-primary">
              <form method="POST" class="needs-validation" novalidate="">
                <div class="card-header">
                  <h4>
                    '.$lang['userSettings_PROFILE'].'
                  </h4>
                </div>
                <div class="card-body">
                  <p class="text-muted">
                    '.$lang['userSettings_PROFILE_TEXT'].'
                  </p>
                  <div class="form-group row align-items-center">
                    <label for="username" class="form-control-label col-sm-3 text-md-right">
                      '.$lang['userSettings_PROFILE_USERNAME'].'
                    </label>
                    <div class="col-sm-6 col-md-9">
                      <input id="username" type="text" class="form-control" name="username" value="'.$core->username($info['id']).'" readonly>
                    </div>
                  </div>
                  <div class="form-group row align-items-center">
                    <label for="fullname" class="form-control-label col-sm-3 text-md-right">
                      '.$lang['userSettings_PROFILE_FULLNAME'].'
                    </label>
                    <div class="col-sm-6 col-md-9">
                      <input type="text" class="form-control" name="fullname" value="'.$info['fullname'].'" required="">
                      <div class="invalid-feedback">
                        '.$lang['userSettings_PROFILE_FULLNAME_IFB'].'
                      </div>
                    </div>
                  </div>
                  <div class="form-group row align-items-center">
                    <label for="email" class="form-control-label col-sm-3 text-md-right">
                      '.$lang['userSettings_PROFILE_EMAIL'].'
                    </label>
                    <div class="col-sm-6 col-md-9">
                      <input type="email" class="form-control" name="email" value="'.$info['email'].'" required="">
                      <div class="invalid-feedback">
                        '.$lang['userSettings_PROFILE_EMAIL_IFB'].'
                      </div>
                    </div>
                  </div>
                  <div class="form-group mb-0">
                    <lable>
                      '.$lang['userSettings_PROFILE_DESCRIPTION'].'
                    </lable>
                    <textarea name="description" class="form-control summernote-simple">'.$core->filter_output($info['description'], FALSE).'</textarea>
                    <div class="invalid-feedback">
                      '.$lang['userSettings_PROFILE_DESCRIPTION_IFB'].'
                    </div>
                  </div>
                </div>
                <div class="card-footer text-right">
                  <button type="reset" name="description" class="btn btn-defautlt">
                    '.$lang['userSettings_PROFILE_CLEAR'].'
                  </button>
                  <button type="submit" name="submit" class="btn btn-primary">
                    '.$lang['userSettings_PROFILE_SAVE'].'
                  </button>
                </div>
              </form>
            </div>
          </div>';

          // If the user clicked the username form
          echo "<script>
            $(document).ready(function() {
              $('#username').on('click', function() {
                swal('".$lang['userSettings_PROFILE_NATCU']."', {
                  title: 'WARNING!',
                  icon: 'warning',
                  buttons: false,
                  timer: 3000,
                });
              });
            });
          </script>";
        } else {

          // Blocked user
          $core->redirect(base_url().'/user/settings/');
        }

        echo '</div>';
        echo '</section>';
        require_once '../incfiles/footer.php';
      } elseif(urlencode($_GET['type']) == 'password') {

        // The password settings
        // Headers
        $title = $lang['userSettings_PASSWORD'];
        require_once '../incfiles/header.php';

        // If not an User, the system will be redirect to the index page or home page
        if(!$session->is_login()) {
          $core->redirect(base_url().'/');
        }

        // Section the password settings
        echo '<section class="section">';

        echo '<div class="section-header">
          <h1 class="section-title">
            '.$lang['userSettings_PASSWORD'].'
          </h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="'.base_url().'/user/">
                Dashboard
              </a>
            </div>
            <div class="breadcrumb-item">
              '.$lang['userSettings_PASSWORD'].'
            </div>
          </div>
        </div>';

        echo '<div class="row">';

        if($info['rights'] > 0) {

          // Unblocked user
          if(isset($_POST['submit'])) {

            // The password settings data
            $new_password = strip_tags(trim($core->filter_input($_POST['new_password'])));
            $confirm_password = strip_tags(trim($core->filter_input($_POST['confirm_password'])));
            
            if(empty($new_password) || empty($confirm_password)) {

              // Empty data
              echo "<script>
                $(document).ready(function() {
                  swal('".$lang['userSettings_PASSWORD_EMPTY']."', {
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
                  swal('".$lang['userSettings_PASSWORD_LENGTH']."', {
                    title: 'WARNING!',
                    icon: 'warning',
                    buttons: false,
                    timer: 3000,
                  });
                });
              </script>";
            } elseif($new_password != $confirm_password) {

              // If the new password and confirm password is not match
              echo "<script>
                $(document).ready(function() {
                  swal('".$lang['userSettings_PASSWORD_INVALID']."', {
                    title: 'WARNING!',
                    icon: 'warning',
                    buttons: false,
                    timer: 3000,
                  });
                });
              </script>";
            } elseif(password_verify($new_password, $info['password'])) {

              // If the password exists
              echo "<script>
                $(document).ready(function() {
                  swal('".$lang['userSettings_PASSWORD_EXIST']."', {
                    title: 'WARNING!',
                    icon: 'warning',
                    buttons: false,
                    timer: 3000,
                  });
                });
              </script>";
            } else {

              // Execute
              $u = $intbyte->query("UPDATE users SET password = '".password_hash($new_password, PASSWORD_DEFAULT)."' WHERE id = '".$info['id']."'");
              if($u) {

                // Successfully updated the password settings
                echo "<script>
                  $(document).ready(function() {
                    swal('".$lang['userSettings_PASSWORD_SUCCESS']."', {
                      title: 'SUCCESS!',
                      icon: 'success',
                      buttons: false,
                      timer: 3000,
                    }).then(function() {
                      window.location = '".base_url()."/logout/';
                    });
                  });
                </script>";
              } else {

                // Failed updated the password settings
                echo "<script>
                  $(document).ready(function() {
                    swal('".$lang['userSettings_PASSWORD_FAILED']."', {
                      title: 'WARNING!',
                      icon: 'warning',
                      buttons: false,
                      timer: 3000,
                    }).then(function() {
                      window.location = '".base_url()."/logout/';
                    });
                  });
                </script>";
              }
            }
          }

          // HTML form
          echo '<div class="col-12 col-md-6 col-lg-12">
            <div class="card card-primary">
              <form method="POST" class="needs-validation" novalidate="">
                <div class="card-header">
                  <h4>
                    '.$lang['userSettings_PASSWORD'].'
                  </h4>
                </div>
                <div class="card-body">
                  <p class="text-muted">
                    '.$lang['userSettings_PASSWORD_TEXT'].'
                  </p>
                  <div class="form-group row align-items-center">
                    <label for="new-password" class="form-control-label col-sm-3 text-md-right">
                      '.$lang['userSettings_NEW_PASSWORD'].'
                    </label>
                    <div class="col-sm-6 col-md-9">
                      <input id="password" type="password" value="" class="form-control pwstrength" data-indicator="pwindicator" name="new_password" required="">
                      <div class="invalid-feedback">
                        '.$lang['userSettings_NEW_PASS_IFB'].'
                      </div>
                      <div id="pwindicator" class="pwindicator">
                        <div class="bar"></div>
                        <div class="label"></div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row align-items-center">
                    <label for="confirm-password" class="form-control-label col-sm-3 text-md-right">
                      '.$lang['userSettings_CONFIRM_PASSWORD'].'
                    </label>
                    <div class="col-sm-6 col-md-9">
                      <input id="password2" type="password" value="" class="form-control" name="confirm_password" required="">
                      <div class="invalid-feedback">
                        '.$lang['userSettings_CONFIRM_PASS_IFB'].'
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer text-right">
                  <button type="reset" name="description" class="btn btn-defautlt">
                    '.$lang['userSettings_PASSWORD_CLEAR'].'
                  </button>
                  <button type="submit" name="submit" class="btn btn-primary">
                    '.$lang['userSettings_PASSWORD_CHANGE'].'
                  </button>
                </div>
              </form>
            </div>
          </div>';
        } else {

          // Blocked user
          $core->redirect(base_url().'/user/settings/');
        }

        echo '</div>';
        echo '</section>';
        require_once '../incfiles/footer.php';
      } elseif(urlencode($_GET['type']) == 'avatar') {

        // The avatar settings
        // Headers
        $title = $lang['userSettings_AVATAR'];
        require_once '../incfiles/header.php';

        // If not an User, the system will be redirect to the index page or home page
        if(!$session->is_login()) {
          $core->redirect(base_url().'/');
        }

        // Section the avatar settings
        echo '<section class="section">';

        echo '<div class="section-header">
          <h1 class="section-title">
            '.$lang['userSettings_AVATAR'].'
          </h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="'.base_url().'/user/">
                Dashboard
              </a>
            </div>
            <div class="breadcrumb-item">
              '.$lang['userSettings_AVATAR'].'
            </div>
          </div>
        </div>';

        echo '<div class="row">';

        if($info['rights'] > 0) {

          // Unblocked user
          if(isset($_POST['submit'])) {

            // The avatar settings data
            $directory = '../images/avatar';
            $file_name = $_FILES['avatar']['name'];
            $file_extension = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
            $file_name = str_replace($file_name, $info['id'].'.'.$file_extension, $file_name);
            $file_size = $_FILES['avatar']['size'];
            $allowed = 'jpg, png';

            if(!$file_name) {

              // Empty data
              echo "<script>
                $(document).ready(function() {
                  swal('".$lang['userSettings_AVATAR_ED']."', {
                    title: 'WARNING!',
                    icon: 'warning',
                    buttons: false,
                    timer: 3000,
                  });
                });
              </script>";
            } elseif($file_size > (1024 * 1024) * 2) {

              // Check the size of avatar
              echo "<script>
                $(document).ready(function() {
                  swal('".$lang['userSettings_AVATAR_BS']."', {
                    title: 'WARNING!',
                    icon: 'warning',
                    buttons: false,
                    timer: 3000,
                  });
                });
              </script>";
            } elseif(!in_array(strtolower($file_extension), explode(',', strtolower(str_replace(' ', '', $allowed))))) {

              // If the extension is not valid
              echo "<script>
                $(document).ready(function() {
                  swal('".$lang['userSettings_AVATAR_IE']."', {
                    title: 'WARNING!',
                    icon: 'warning',
                    buttons: false,
                    timer: 3000,
                  });
                });
              </script>";
            } else {

              // Execute
              if(file_exists($directory.'/'.$info['id'].'.jpg')) {

                // Delete the JPG files
                unlink($directory.'/'.$info['id'].'.jpg');
              } elseif(file_exists($directory.'/'.$info['id'].'.png')) {

                // Delete the PNG files
                unlink($directory.'/'.$info['id'].'.png');
              }

              // Moved the files
              $move = move_uploaded_file($_FILES['avatar']['tmp_name'], $directory.'/'.$file_name);
              if($move) {

                // Successfuly updated the avatar
                echo "<script>
                  $(document).ready(function() {
                    swal('".$lang['userSettings_AVATAR_SUCCESS']."', {
                      title: 'SUCCESS!',
                      icon: 'success',
                      buttons: false,
                      timer: 3000,
                    }).then(function() {
                      window.location = '".base_url()."/user/settings/?view=settings&type=avatar';
                    });
                  });
                </script>";
              } else {

                // Failed updated the avatar
                echo "<script>
                  $(document).ready(function() {
                    swal('".$lang['userSettings_AVATAR_FAILED']."', {
                      title: 'WARNING!',
                      icon: 'warning',
                      buttons: false,
                      timer: 3000,
                    }).then(function() {
                      window.location = '".base_url()."/user/settings/?view=settings&type=avatar';
                    });
                  });
                </script>";
              }
            }
          }

          // HTML form
          echo '<div class="col-12 col-md-6 col-lg-12">
            <div class="card card-primary">
              <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate="">
                <div class="card-header">
                  <h4>
                    '.$lang['userSettings_AVATAR'].'
                  </h4>
                </div>
                <div class="card-body">
                  <p class="text-muted">
                    '.$lang['userSettings_AVATAR_TEXT'].'
                  </p>
                  <div class="form-group row align-items-center">
                    <label class="form-control-label col-sm-3 text-md-right">
                      '.$lang['userSettings_AVATAR_S'].'
                    </label>
                    <div class="col-sm-6 col-md-6">
                      <div class="custom-file">
                        <input type="file" name="avatar" class="custom-file-input">
                        <label class="custom-file-label">
                          '.$lang['userSettings_AVATAR_CF'].'
                        </label>
                      </div>
                      <div class="form-text text-muted">
                        '.$lang['userSettings_AVATAR_MS'].'
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer text-center">
                  <button type="reset" name="avatar" class="btn btn-defautlt">
                    '.$lang['userSettings_AVATAR_CLEAR'].'
                  </button>
                  <button type="submit" name="submit" class="btn btn-primary">
                    '.$lang['userSettings_AVATAR_CHANGE'].'
                  </button>
                </div>
              </form>
            </div>
          </div>';
        } else {

          // Blocked user
          $core->redirect(base_url().'/user/settings/');
        }

        echo '</div>';
        echo '</section>';
        require_once '../incfiles/footer.php';
      } else {

        // Illegal access
        $core->redirect(base_url().'/user/settings/');
      }
    } else {

      // Illegal access
      $core->redirect(base_url().'/user/settings/');
    }
  break;

  default:

    // Illegal Access
    // If there is access to this page then the system will direct to the main page User
    $core->redirect(base_url().'/user/');
  break;
}
?>
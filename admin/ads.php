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
$title = 'Admin Advertisement';
require_once '../incfiles/header.php';

// If not an Administrator, the system will be redirect to the index page or home page
if(!$session->is_login() || $session->is_rights() > 1) {
  $core->redirect(base_url().'/');
}

// If not the main Administrator
if($session->is_login() != 1) {
  echo "<script>
    $(document).ready(function() {
      swal('".$lang['ads_NHP']."', {
        title: 'ACCESS DENIED!',
        icon: 'error',
        buttons: false,
        timer: 3000,
      }).then((will) => {
        if(will) {
          window.location = '".base_url()."/admin/';
        } else {
          window.location = '".base_url()."/admin/';
        }
      });
    });
  </script>";
}

// Section admin advertisement
echo '<section class="section">';

echo '<div class="section-header">
  <h1 class="section-title">
    Admin Advertisement
  </h1>
  <div class="section-header-breadcrumb">
    <div class="breadcrumb-item active">
      <a href="'.base_url().'/admin/">
        Dashboard
      </a>
    </div>
    <div class="breadcrumb-item">
      Admin Advertisement
    </div>
  </div>
</div>';

echo '<div class="row">';

if(isset($_POST['post'])) {

  // Admin advertisement data
  $ads = $core->filter_input($_POST['ads']);
  $type = array(
    '<?php',
    'alert',
    'display: none;',
    'background-image',
    '<style>',
    '</style>'
  );
  
  if(empty($ads)) {

    // Empty ads unit
    echo "<script>
      $(document).ready(function() {
        swal('".$lang['ads_EAU']."', {
          title: 'WARNING!',
          icon: 'error',
          buttons: false,
          timer: 3000,
        });
      });
    </script>";
  } elseif(in_array($ads, $type)) {
    
    // Types of ads unit that is not allow
    echo "<script>
      $(document).ready(function() {
        swal('".$lang['ads_NATA']."', {
          title: 'WARNING!',
          icon: 'error',
          buttons: false,
          timer: 3000,
        });
      });
    </script>";
  } else {

    // Update ads unit
    if($core->update_set('admin_ads', $core->escapeToDB($ads))) {

      // Sucessfully updated Admin advertisement
      echo "<script>
        $(document).ready(function() {
          swal('".$lang['ads_STU']."', {
            title: 'SUCCESS!',
            icon: 'success',
            buttons: false,
            timer: 3000,
          }).then(function() {
            window.location = '".base_url()."/admin/advertisement/';
          });
        });
      </script>";
    } else {

      // Failed updated Admin Advertisement
      echo "<script>
        $(document).ready(function() {
          swal('".$lang['ads_FTU']."', {
            title: 'WARNING!',
            icon: 'warning',
            buttons: false,
            timer: 3000,
          }).then(function() {
            window.location = '".base_url()."/admin/advertisement/';
          });
        });
      </script>";
    }
  }
}

// HTML form
$_ADS = $intbyte->query("SELECT * FROM settings WHERE name = 'admin_ads'")->fetch_assoc();
echo '<div class="col-12 col-md-6 col-lg-6">
  <div class="card card-primary">
    <form method="POST" class="needs-validation" novalidate="">
      <div class="card-header">
        <h4>
          Admin Advertisement
        </h4>
      </div>
      <div class="card-body">
        <div class="form-group mb-0">
          <label>
            '.$lang['ads_YAU'].'
          </label>
          <textarea name="ads" class="form-control" required="">'.(empty($core->set('admin_ads')) ? $lang['ads_YHNAU'] : $core->filter_output($core->set('admin_ads'), FALSE)).'</textarea>
          <div class="invalid-feedback">
            '.$lang['ads_PFIYAU'].'
          </div>
        </div>
      </div>
      <div class="card-footer text-right">
        <button type="reset" name="ads" class="btn btn-defautlt">
          '.$lang['ads_CLEAR'].'
        </button>
        <button type="submit" name="post" class="btn btn-primary">
          '.$lang['ads_PUBLISH'].'
        </button>
      </div>
    </form>
  </div>
</div>';

// Preview Admin advertisement
$_TIME = $intbyte->query("SELECT * FROM settings WHERE name = 'admin_ads'")->fetch_assoc();
echo '<div class="col-12 col-md-6 col-lg-6">
  <div class="card card-primary">
    <div class="card-header">
      <h4>
        '.$lang['ads_PREVIEW'].'
      </h4>
    </div>
    <div class="card-body">
      '.(empty($core->set('admin_ads')) ? $lang['ads_YHNAU'] : $core->filter_output($core->set('admin_ads'), TRUE)).'
    </div>
    <div class="card-footer text-right">
      '.$lang['ads_LAST_UPDATE'].': '.$time->timeAgo($_TIME['time']).'
    </div>
  </div>
</div>';

echo '</div>';
echo '</section>';
require_once '../incfiles/footer.php';
?>
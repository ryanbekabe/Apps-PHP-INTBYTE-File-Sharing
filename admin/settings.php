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

// If not an Administrator, the system will be redirect to the index page or home page
if(!$session->is_login() || $session->is_rights() > 1) {
  $core->redirect(base_url().'/');
}

$act = isset($_GET['view']) ? trim($_GET['view']) : '';
switch($act) {

  case 'settings':

    // Types of settings
    if(isset($_GET['type'])) {
      if(urlencode($_GET['type']) == 'seo') {

        // SEO settings
        // Headers
        $title = $lang['settings_SEO'];
        require_once '../incfiles/header.php';
    
        // If not an Administrator, the system will be redirect to the index page or home page
        if(!$session->is_login() || $session-> is_rights() > 1) {
          $core->redirect(base_url().'/');
        } 

        // Section SEO settings
        echo '<section class="section">';

        echo '<div class="section-header">
          <h1 class="section-title">
            '.$lang['settings_SEO'].'
          </h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="'.base_url().'/admin/">
                Dashboard
              </a>
            </div>
            <div class="breadcrumb-item">
              '.$lang['settings_SEO'].'
            </div>
          </div>
        </div>';

        echo '<div class="row">';

        if(isset($_POST['submit'])) {

          // SEO settings data
          $site_description = strip_tags($core->filter_input($_POST['site_description']));
          $site_keywords = strip_tags($core->filter_input($_POST['site_keywords']));
          $robots = strip_tags($core->filter_input($_POST['robots']));
          $google_verify = $core->filter_input($_POST['google_verify']);

          if(empty($site_description) || empty($site_keywords) || empty($robots) || empty($google_verify)) {

            // Empty data
            echo "<script>
              $(document).ready(function() {
                swal('".$lang['settings_SEO_IDST']."', {
                  title: 'WARNING!',
                  icon: 'warning',
                  buttons: false,
                  timer: 3000,
                });
              });
            </script>";
          } elseif(strlen($site_description) > 150) {

            // Check the length of the site description
            echo "<script>
              $(document).ready(function() {
                swal('".$lang['settings_SEO_ISDT']."', {
                  title: 'WARNING!',
                  icon: 'warning',
                  buttons: false,
                  timer: 3000,
                });
              });
            </script>";
          } elseif(str_word_count($site_keywords) > 150) {

            // Check the length of the site keywords
            echo "<script>
              $(document).ready(function() {
                swal('".$lang['settings_SEO_ISKT']."', {
                  title: 'WARNING!',
                  icon: 'warning',
                  buttons: false,
                  timer: 3000,
                });
              });
            </script>";
          } elseif(strlen($robots) > 200) {

            // Check the length of the robots.txt
            echo "<script>
              $(document).ready(function() {
                swal('".$lang['settings_SEO_IRTT']."', {
                  title: 'WARNING!',
                  icon: 'warning',
                  buttons: false,
                  timer: 3000,
                });
              });
            </script>";
          } elseif(strlen($google_verify) > 100) {

            // Check the length of the Google Verificaction
            echo "<script>
              $(document).ready(function() {
                swal('".$lang['settings_SEO_IGVT']."', {
                  title: 'WARNING!',
                  icon: 'warning',
                  buttons: false,
                  timer: 3000,
                });
              });
            </script>";
          } else {

            // Execute
            $a = $core->update_set('site_description', $core->escapeToDB($site_description));
            $i = $core->update_set('site_keywords', $core->escapeToDB($site_keywords));
            $n = $core->update_set('robots', $core->escapeToDB($robots));
            $g = $core->update_set('google_verify', $core->escapeToDB($google_verify));
            if($a || $i || $n || $g) {

              // Successfully updated SEO settings
              @file_put_contents('../robots.txt', $robots);
              echo "<script>
                $(document).ready(function() {
                  swal('".$lang['settings_SEO_SUCCESS']."', {
                    title: 'SUCCESS!',
                    icon: 'success',
                    buttons: false,
                    timer: 3000,
                  }).then(function() {
                    window.location = '".base_url()."/admin/settings/?view=settings&type=seo';
                  });
                });
              </script>";
            } else {

              // Failed updated SEO settings
              echo "<script>
                $(document).ready(function() {
                  swal('".$lang['settings_SEO_FAILED']."', {
                    title: 'WARNING!',
                    icon: 'warning',
                    buttons: false,
                    timer: 3000,
                  }).then(function() {
                    window.location = '".base_url()."/admin/settings/?view=settings&type=seo';
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
                  '.$lang['settings_SEO'].'
                </h4>
              </div>
              <div class="card-body">
                <p class="text-muted">
                  '.$lang['settings_SEO_TEXT'].'
                </p>
                <div class="form-group row align-items-center">
                  <label for="site-description" class="form-control-label col-sm-3 text-md-right">
                    '.$lang['settings_SEO_SD'].'
                  </label>
                  <div class="col-sm-6 col-md-9">
                    <textarea class="form-control" name="site_description" required="">'.$core->set('site_description').'</textarea>
                    <div class="invalid-feedback">
                      '.$lang['settings_SEO_IFSD'].'
                    </div>
                  </div>
                </div>
                <div class="form-group row align-items-center">
                  <label for="site-keywords" class="form-control-label col-sm-3 text-md-right">
                    '.$lang['settings_SEO_SK'].'
                  </label>
                  <div class="col-sm-6 col-md-9">
                    <textarea class="form-control" name="site_keywords" required="">'.$core->set('site_keywords').'</textarea>
                    <div class="invalid-feedback">
                      '.$lang['settings_SEO_IFSK'].'
                    </div>
                  </div>
                </div>
                <div class="form-group row align-items-center">
                  <label for="robots" class="form-control-label col-sm-3 text-md-right">
                    '.$lang['settings_SEO_RT'].'
                  </label>
                  <div class="col-sm-6 col-md-9">
                    <textarea class="form-control" name="robots" required="">'.$core->set('robots').'</textarea>
                    <div class="invalid-feedback">
                      '.$lang['settings_SEO_IFRT'].'
                    </div>
                  </div>
                </div>
                <div class="form-group row align-items-center">
                  <label for="google-verify" class="form-control-label col-sm-3 text-md-right">
                    '.$lang['settings_SEO_GV'].'
                  </label>
                  <div class="col-sm-6 col-md-9">
                    <textarea class="form-control" name="google_verify" required="">'.$core->set('google_verify').'</textarea>
                    <div class="invalid-feedback">
                      '.$lang['settings_SEO_IFGV'].'
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer text-right">
                <button type="submit" name="submit" class="btn btn-primary">
                  '.$lang['settings_SEO_SAVE'].'
                </button>
              </div>
            </form>
          </div>
        </div>';

        echo '</div>';
        echo '</section>';
        require_once '../incfiles/footer.php';
      } elseif(urlencode($_GET['type']) == 'site') {

        // Site settings
        // Headers
        $title = $lang['settings_SITE'];
        require_once '../incfiles/header.php';
    
        // If not an Administrator, the system will be redirect to the index page or home page
        if(!$session->is_login() || $session-> is_rights() > 1) {
          $core->redirect(base_url().'/');
        } 

        // Section site settings
        echo '<section class="section">';

        echo '<div class="section-header">
          <h1 class="section-title">
            '.$lang['settings_SITE'].'
          </h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="'.base_url().'/admin/">
                Dashboard
              </a>
            </div>
            <div class="breadcrumb-item">
              '.$lang['settings_SITE'].'
            </div>
          </div>
        </div>';

        echo '<div class="row">';

        if(isset($_POST['submit'])) {

          // Site settings data
          $site_title = strip_tags($core->filter_input($_POST['site_title']));
          $registration_status = strip_tags($core->filter_input($_POST['site_registration']));
          $verify_status = strip_tags($core->filter_input($_POST['site_verify']));
          $time_zone = strip_tags($core->filter_input($_POST['timezone']));
          $maintenance_mode = strip_tags($core->filter_input($_POST['site_maintenance']));
          $default_language = strip_tags($core->filter_input($_POST['site_language']));
          $paging = strip_tags($core->filter_input($_POST['site_paging']));
          $currency = strip_tags($core->filter_input($_POST['site_currency']));
          $paypal = $core->filter_input($_POST['site_paypal']);
          $bank = strip_tags($core->filter_input($_POST['site_bank']));
          $others = strip_tags($core->filter_input($_POST['site_others']));

          if(empty($site_title) || empty($time_zone) || empty($paypal) || empty($bank) || empty($others)) {

            // Empty data
            echo "<script>
              $(document).ready(function() {
                swal('".$lang['settings_SITE_IDST']."', {
                  title: 'WARNING!',
                  icon: 'warning',
                  buttons: false,
                  timer: 3000,
                });
              });
            </script>";
          } elseif($registration_status == 'NULL') {

            // Registration status is not selected
            echo "<script>
              $(document).ready(function() {
                swal('".$lang['settings_SITE_RSN']."', {
                  title: 'WARNING!',
                  icon: 'warning',
                  buttons: false,
                  timer: 3000,
                });
              });
            </script>";
          } elseif($verify_status == 'NULL') {

            // Verify status is not selected
            echo "<script>
              $(document).ready(function() {
                swal('".$lang['settings_SITE_VSN']."', {
                  title: 'WARNING!',
                  icon: 'warning',
                  buttons: false,
                  timer: 3000,
                });
              });
            </script>";
          } elseif($maintenance_mode == 'NULL') {

            // Maintenance mode is not selected
            echo "<script>
              $(document).ready(function() {
                swal('".$lang['settings_SITE_MMN']."', {
                  title: 'WARNING!',
                  icon: 'warning',
                  buttons: false,
                  timer: 3000,
                });
              });
            </script>";
          } elseif($default_language == 'NULL') {

            // Default language is not selected
            echo "<script>
              $(document).ready(function() {
                swal('".$lang['settings_SITE_DLN']."', {
                  title: 'WARNING!',
                  icon: 'warning',
                  buttons: false,
                  timer: 3000,
                });
              });
            </script>";
          } elseif($paging == 'NULL') {

            // Paging is not selected
            echo "<script>
              $(document).ready(function() {
                swal('".$lang['settings_SITE_PAGINGN']."', {
                  title: 'WARNING!',
                  icon: 'warning',
                  buttons: false,
                  timer: 3000,
                });
              });
            </script>";
          } elseif(!preg_match('/^[0-9]*$/', $currency)) {

            // Currency is not number
            echo "<script>
              $(document).ready(function() {
                swal('".$lang['settings_SITE_CURRENCYN']."', {
                  title: 'WARNING!',
                  icon: 'warning',
                  buttons: false,
                  timer: 3000,
                });
              });
            </script>";
          } else {
            
            // Execute
            $b = $core->update_set('title', $core->escapeToDB($site_title));
            $o = $core->update_set('registration_status', $core->escapeToDB($registration_status));
            $s = $core->update_set('maintenance_mode', $core->escapeToDB($maintenance_mode));
            $a = $core->update_set('time_zone', $core->escapeToDB($time_zone));
            $n = $core->update_set('language', $core->escapeToDB($default_language));

            $a = $core->update_set('paging', $core->escapeToDB($paging));
            $n = $core->update_set('currency', $core->escapeToDB($currency));
            $j = $core->update_set('paypal', $core->escapeToDB($paypal));
            $a = $core->update_set('bank', $core->escapeToDB($bank));
            $y = $core->update_set('others', $core->escapeToDB($others));

            $p = $core->update_set('verify_status', $core->escapeToDB($verify_status));

            if($b || $o || $s || $a || $n || $a || $n || $j || $a || $y || $p) {

              // Successfully updated site settings
              echo "<script>
                $(document).ready(function() {
                  swal('".$lang['settings_SITE_SUCCESS']."', {
                    title: 'SUCCESS!',
                    icon: 'success',
                    buttons: false,
                    timer: 3000,
                  }).then(function() {
                    window.location = '".base_url()."/admin/settings/?view=settings&type=site';
                  });
                });
              </script>";
            } else {

              // Failed updated site settings
              echo "<script>
                $(document).ready(function() {
                  swal('".$lang['settings_SITE_FAILED']."', {
                    title: 'WARNING!',
                    icon: 'warning',
                    buttons: false,
                    timer: 3000,
                  }).then(function() {
                    window.location = '".base_url()."/admin/settings/?view=settings&type=site';
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
                  '.$lang['settings_SITE'].'
                </h4>
              </div>
              <div class="card-body">
                <p class="text-muted">
                  '.$lang['settings_SITE_TEXT'].'
                </p>
                <div class="form-group row align-items-center">
                  <label for="site-title" class="form-control-label col-sm-3 text-md-right">
                    '.$lang['settings_SITE_TITLE'].'
                  </label>
                  <div class="col-sm-6 col-md-9">
                    <textarea class="form-control" name="site_title" required="">'.$core->set('title').'</textarea>
                    <div class="invalid-feedback">
                      '.$lang['settings_SITE_IFT'].'
                    </div>
                  </div>
                </div>
                <div class="form-group row align-items-center">
                  <label for="site-registration" class="form-control-label col-sm-3 text-md-right">
                    '.$lang['settings_SITE_REG'].'
                  </label>
                  <div class="col-sm-6 col-md-3">
                    <select name="site_registration" class="form-control">
                      <option value="NULL">
                        '.$lang['settings_SITE_REGSS'].'
                      </option>
                      '.($core->set('registration_status') == 'Open' ? '<option value="Open" selected>
                        &check; '.$lang['settings_SITE_REGOR'].'
                      </option>
                      <option value="Close">
                        &times; '.$lang['settings_SITE_REGCR'].'
                      </option>' : '<option value="Close" selected>
                        &check; '.$lang['settings_SITE_REGCR'].'
                      </option>
                      <option value="Open">
                        &times; '.$lang['settings_SITE_REGOR'].'
                      </option>').'
                    </select>
                    <div class="invalid-feedback">
                      '.$lang['settings_SITE_IFR'].'
                    </div>
                  </div>
                </div>
                <div class="form-group row align-items-center">
                  <label for="site-registration" class="form-control-label col-sm-3 text-md-right">
                    '.$lang['settings_SITE_VS'].'
                  </label>
                  <div class="col-sm-6 col-md-3">
                    <select name="site_verify" class="form-control">
                      <option value="NULL">
                        '.$lang['settings_SITE_VSSS'].'
                      </option>
                      '.($core->set('verify_status') == 'Verify' ? '<option value="Verify" selected>
                        &check; '.$lang['settings_SITE_VSA'].'
                      </option>
                      <option value="Unverify">
                        &times; '.$lang['settings_SITE_VSNA'].'
                      </option>' : '<option value="Unverify" selected>
                        &check; '.$lang['settings_SITE_VSNA'].'
                      </option>
                      <option value="Verify">
                        &times; '.$lang['settings_SITE_VSA'].'
                      </option>').'
                    </select>
                    <div class="invalid-feedback">
                      '.$lang['settings_SITE_IFV'].'
                    </div>
                  </div>
                </div>
                <div class="form-group row align-items-center">
                  <label for="site-timezone" class="form-control-label col-sm-3 text-md-right">
                    '.$lang['settings_SITE_TZ'].'
                  </label>
                  <div class="col-sm-6 col-md-9">
                    <textarea class="form-control" name="timezone" required="">'.$core->set('time_zone').'</textarea>
                    <div class="invalid-feedback">
                      '.$lang['settings_SITE_IFTZ'].'
                    </div>
                  </div>
                </div>
                <div class="form-group row align-items-center">
                  <label for="site-maintenance" class="form-control-label col-sm-3 text-md-right">
                    '.$lang['settings_SITE_MTC'].'
                  </label>
                  <div class="col-sm-6 col-md-3">
                    <select name="site_maintenance" class="form-control">
                      <option value="NULL">
                        '.$lang['settings_SITE_MTCSM'].'
                      </option>
                      '.($core->set('maintenance_mode') == 'Open' ? '<option value="Open" selected>
                        &check; '.$lang['settings_SITE_MTCOM'].'
                      </option>
                      <option value="Close">
                        &times; '.$lang['settings_SITE_MTCCM'].'
                      </option>' : '<option value="Close" selected>
                        &check; '.$lang['settings_SITE_MTCCM'].'
                      </option>
                      <option value="Open">
                        &times; '.$lang['settings_SITE_MTCOM'].'
                      </option>').'
                    </select>
                    <div class="invalid-feedback">
                      '.$lang['settings_SITE_IFM'].'
                    </div>
                  </div>
                </div>
                <div class="form-group row align-items-center">
                  <label for="site-maintenance" class="form-control-label col-sm-3 text-md-right">
                    '.$lang['settings_SITE_LANG'].'
                  </label>
                  <div class="col-sm-6 col-md-3">
                    <select name="site_language" class="form-control">
                      <option value="NULL">
                        '.$lang['settings_SITE_LANGSL'].'
                      </option>
                      '.($core->set('language') == 'id' ? '<option value="id" selected>
                        &check; Bahasa Indonesia
                      </option>
                      <option value="en">
                        &times; English
                      </option>' : '<option value="en" selected>
                        &check; English
                      </option>
                      <option value="id">
                        &times; Bahasa Indonesia
                      </option>').'
                    </select>
                    <div class="invalid-feedback">
                      '.$lang['settings_SITE_IFL'].'
                    </div>
                  </div>
                </div>
                <div class="form-group row align-items-center">
                  <label for="site-paging" class="form-control-label col-sm-3 text-md-right">
                    '.$lang['settings_SITE_PAGING'].'
                  </label>
                  <div class="col-sm-6 col-md-3">
                    <select name="site_paging" class="form-control">
                      <option value="NULL">
                        '.$lang['settings_SITE_PAGING2'].'
                      </option>
                      '.($core->set('paging') == 10 ? '<option value="10" selected>
                        &check; 10 '.$lang['settings_SITE_PAGING3'].'
                      </option>
                      <option value="20">
                        &times; 20 '.$lang['settings_SITE_PAGING3'].'
                      </option>' : '<option value="20" selected>
                        &check; 20 '.$lang['settings_SITE_PAGING3'].'
                      </option>
                      <option value="10">
                        &times; 10 '.$lang['settings_SITE_PAGING3'].'
                      </option>').'
                    </select>
                    <div class="invalid-feedback">
                      '.$lang['settings_SITE_IFP'].'
                    </div>
                  </div>
                </div>
                <div class="form-group row align-items-center">
                  <label for="site-currency" class="form-control-label col-sm-3 text-md-right">
                    '.$lang['settings_SITE_CURRENCY'].'
                  </label>
                  <div class="col-sm-6 col-md-9">
                    <textarea class="form-control" name="site_currency" style="width: 31%;" required="">'.$core->set('currency').'</textarea>
                    <div class="invalid-feedback">
                      '.$lang['settings_SITE_IFC'].'
                    </div>
                  </div>
                </div>
                <div class="form-group row align-items-center">
                  <label for="site-paypal" class="form-control-label col-sm-3 text-md-right">
                    '.$lang['settings_SITE_PAYPAL'].'
                  </label>
                  <div class="col-sm-6 col-md-9">
                    <textarea class="form-control" name="site_paypal" required="">'.$core->set('paypal').'</textarea>
                    <div class="invalid-feedback">
                      '.$lang['settings_SITE_IFPP'].'
                    </div>
                  </div>
                </div>
                <div class="form-group row align-items-center">
                  <label for="site-bank" class="form-control-label col-sm-3 text-md-right">
                    '.$lang['settings_SITE_BANK'].'
                  </label>
                  <div class="col-sm-6 col-md-9">
                    <textarea class="form-control" name="site_bank" required="">'.$core->set('bank').'</textarea>
                    <div class="invalid-feedback">
                      '.$lang['settings_SITE_IFBK'].'
                    </div>
                  </div>
                </div>
                <div class="form-group row align-items-center">
                  <label for="site-others" class="form-control-label col-sm-3 text-md-right">
                    '.$lang['settings_SITE_OTHERS'].'
                  </label>
                  <div class="col-sm-6 col-md-9">
                    <textarea class="form-control" name="site_others" required="">'.$core->set('others').'</textarea>
                    <div class="invalid-feedback">
                      '.$lang['settings_SITE_IFBO'].'
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer text-right">
                <button type="submit" name="submit" class="btn btn-primary">
                  '.$lang['settings_SITE_SAVE'].'
                </button>
              </div>
            </form>
          </div>
        </div>';

        echo '</div>';
        echo '</section>';
        require_once '../incfiles/footer.php';
      } elseif(urlencode($_GET['type']) == 'storage') {

        // Storage settings
        // Heaaders
        $title = $lang['settings_STORAGE'];
        require_once '../incfiles/header.php';
    
        // If not an Administrator, the system will be redirect to the index page or home page
        if(!$session->is_login() || $session-> is_rights() > 1) {
          $core->redirect(base_url().'/');
        } 

        // Section storage settings
        echo '<section class="section">';

        echo '<div class="section-header">
          <h1 class="section-title">
            '.$lang['settings_STORAGE'].'
          </h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="'.base_url().'/admin/">
                Dashboard
              </a>
            </div>
            <div class="breadcrumb-item">
              '.$lang['settings_STORAGE'].'
            </div>
          </div>
        </div>';

        echo '<div class="row">';

        if(isset($_POST['submit'])) {

          // Storage settings data
          $per_user = strip_tags($core->filter_input($_POST['site_storage']));
          $per_upload = strip_tags($core->filter_input($_POST['site_upload']));
          $extension = strip_tags($core->filter_input($_POST['extensions']));

          if(empty($per_user) || empty($per_upload) || empty($extension)) {

            // Empty data
            echo "<script>
              $(document).ready(function() {
                swal('".$lang['settings_STORAGE_IDST']."', {
                  title: 'WARNING!',
                  icon: 'warning',
                  buttons: false,
                  timer: 3000,
                });
              });
            </script>";
          } elseif(!preg_match('/^[0-9]*$/', $per_user) || !preg_match('/^[0-9]*$/', $per_upload)) {

            // Invalid input storage and upload
            echo "<script>
              $(document).ready(function() {
                swal('".$lang['settings_STORAGE_IISU']."', {
                  title: 'WARNING!',
                  icon: 'warning',
                  buttons: false,
                  timer: 3000,
                });
              });
            </script>";
          } elseif(!preg_match('/^[a-zA-Z0-9, ]*$/', $extension)) {

            // Invalid input extension with separated comma
            echo "<script>
              $(document).ready(function() {
                swal('".$lang['settings_STORAGE_IE']."', {
                  title: 'WARNING!',
                  icon: 'warning',
                  buttons: false,
                  timer: 3000,
                });
              });
            </script>";
          } else {

            // Execute
            $a = $core->update_set('upload_max_size', $core->escapeToDB((1024 * 1024) * $per_user));
            $j = $core->update_set('file_max_size', $core->escapeToDB((1024 * 1024) * $per_upload));
            $g = $core->update_set('not_allowed_extension', $core->escapeToDB($extension));

            if($a || $j || $g) {

              // Successfully updated storage settings
              echo "<script>
                $(document).ready(function() {
                  swal('".$lang['settings_STORAGE_SUCCESS']."', {
                    title: 'SUCCESS!',
                    icon: 'success',
                    buttons: false,
                    timer: 3000,
                  }).then(function() {
                    window.location = '".base_url()."/admin/settings/?view=settings&type=storage';
                  });
                });
              </script>";
            } else {

              // Failed updated storage settings
              echo "<script>
                $(document).ready(function() {
                  swal('".$lang['settings_STORAGE_FAILED']."', {
                    title: 'WARNING!',
                    icon: 'warning',
                    buttons: false,
                    timer: 3000,
                  }).then(function() {
                    window.location = '".base_url()."/admin/settings/?view=settings&type=storage';
                  });
                });
              </script>";
            }
          }
        }

        $storage = $intbyte->query("SELECT SUM(storage) FROM users")->fetch_assoc();
        echo '<div class="col-12 col-md-6 col-lg-12">
          <div class="card card-primary">
            <form method="POST" class="needs-validation" novalidate="">
              <div class="card-header">
                <h4>
                  '.$lang['settings_STORAGE'].'
                </h4>
              </div>
              <div class="card-body">
                <p class="text-muted">
                  '.$lang['settings_STORAGE_TEXT'].'
                </p>
                <div class="form-group row align-items-center">
                  <label for="site-storage_per_user" class="form-control-label col-sm-3 text-md-right">
                    '.$lang['settings_STORAGE_SPU'].'
                  </label>
                  <div class="col-sm-6 col-md-9">
                    <textarea class="form-control" name="site_storage" placeholder="'.$lang['settings_STORAGE_PHS'].'" required="">'.($core->set('upload_max_size') / (1024 * 1024)).' MB</textarea>
                    <div class="invalid-feedback">
                      '.$lang['settings_STORAGE_IFSPU'].'
                    </div>
                  </div>
                </div>
                <div class="form-group row align-items-center">
                  <label for="site-storage_upload_per_file" class="form-control-label col-sm-3 text-md-right">
                    '.$lang['settings_STORAGE_UPF'].'
                  </label>
                  <div class="col-sm-6 col-md-9">
                    <textarea class="form-control" name="site_upload" placeholder="'.$lang['settings_STORAGE_PHS'].'" required="">'.($core->set('file_max_size') / (1024 * 1024)).' MB</textarea>
                    <div class="invalid-feedback">
                      '.$lang['settings_STORAGE_IFUPF'].'
                    </div>
                  </div>
                </div>
                <div class="form-group row align-items-center">
                  <label for="extension" class="form-control-label col-sm-3 text-md-right">
                    '.$lang['settings_STORAGE_NAE'].'
                  </label>
                  <div class="col-sm-6 col-md-9">
                    <textarea class="form-control" name="extensions" placeholder="'.$lang['settings_STORAGE_PHE'].'" required="">'.$core->set('not_allowed_extension').'</textarea>
                    <div class="invalid-feedback">
                      '.$lang['settings_STORAGE_IFNAE'].'
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer text-right">
                <span class="badge badge-default">
                  <b>'.$lang['settings_STORAGE_USED'].':</b> '.$core->size($storage['SUM(storage)']).'
                </span>
                <button type="submit" name="submit" class="btn btn-primary">
                  '.$lang['settings_SITE_SAVE'].'
                </button>
              </div>
            </form>
          </div>
        </div>';

        echo '</div>';
        echo '</section>';
        require_once '../incfiles/footer.php';
      } else {

        // Illegal access
        $core->redirect(base_url().'/admin/settings/');
      }
    } else {

      // Illegal access
      $core->redirect(base_url().'/admin/settings/');
    }
  break;

  default:

  // Illegal Access
  // If there is access to this page then the system will direct to the main page Administrator
  $core->redirect(base_url().'/admin/');
  break;
}
?>
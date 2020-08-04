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
$title = ''.$core->set('title').' '.$lang['user_PANEL'].'';
require_once '../incfiles/header.php';

// If not an User, the system will be redirect to the index page or home page
if(!$session->is_login()) {
  $core->redirect(base_url().'/');
}

// The user informations
$q = $intbyte->query("SELECT * FROM users WHERE id = '".$session->is_login()."'");
$info = $q->fetch_assoc();

// Section user
echo '<section class="section">';

echo '<div class="section-header">
  <h1 class="section-title">
    '.$core->set('title').' '.$lang['user_PANEL'].'
  </h1>
  <div class="section-header-breadcrumb">
    <div class="breadcrumb-item active">
      <a href="'.base_url().'/user/">
        Dashboard
      </a>
    </div>
    <div class="breadcrumb-item">
      '.$core->set('title').' '.$lang['user_PANEL'].'
    </div>
  </div>
</div>
<div class="section-body">
  <h2 class="section-title">
    Hi, '.$info['fullname'].'!
  </h2>
  <p class="section-lead">
    '.$lang['user_WELCOME'].'
  </p>';

if($info['rights'] > 0) {

  // Unblocked user

  echo '<div class="row">';

  // The user storage
  echo '<div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-primary card-statistic-1" style="box-shadow: 3px 3px 5px 0px #BFBFBF;">
      <div class="card-icon bg-primary">
        <i class="fas fa-server"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>
            '.$lang['user_STORAGE_USED'].'
          </h4>
        </div>
        <div class="card-body" style="font-size: 13px;">
          '.$core->size($info['storage']).' / '.($info['type'] == 1 ? $core->size($core->set('upload_max_size')) : ($core->size($core->set('upload_max_size') / 2))).'
          <center>
            '.(number_format(($info['storage'] / ($info['type'] == 1 ? $core->set('upload_max_size') : ($core->set('upload_max_size') / 2)) * 100), 2, ',', '.')).'%
          </center>
        </div>
      </div>
    </div>
  </div>';

  // The user files
  echo '<div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-danger card-statistic-1" style="box-shadow: 3px 3px 5px 0px #BFBFBF;">
      <div class="card-icon bg-danger">
        <i class="fas fa-file"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>
            '.$lang['user_TOTAL_FILES'].'
          </h4>
        </div>
        <div class="card-body">
          '.number_format(($info['files']), 0, ',', '.').'
        </div>
      </div>
    </div>
  </div>';

  // The user files downloaded
  $downloaded = $intbyte->query("SELECT SUM(downloaded) FROM files WHERE user_id = '".$info['id']."'")->fetch_array();
  echo '<div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-danger card-statistic-1" style="box-shadow: 3px 3px 5px 0px #BFBFBF;">
      <div class="card-icon bg-danger">
        <i class="fas fa-download"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>
            '.$lang['user_TOTAL_FILES_DOWNLOADED'].'
          </h4>
        </div>
        <div class="card-body">
          '.number_format(($downloaded['SUM(downloaded)']), 0, ',', '.').'
        </div>
      </div>
    </div>
  </div>';

  // The user ads
  echo '<div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-primary card-statistic-1" style="box-shadow: 3px 3px 5px 0px #BFBFBF;">
      <div class="card-icon bg-primary">
        <i class="fas fa-tags"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>
            '.$lang['user_TOTAL_ADS'].'
          </h4>
        </div>
        <div class="card-body">
          '.number_format(($intbyte->query("SELECT * FROM ads WHERE user_id = '".$info['id']."'")->num_rows), 0, ',', '.').'
        </div>
      </div>
    </div>
  </div>';
  
  // The user profile
  echo '<div class="col-12 col-md-12 col-lg-12">
    <div class="card profile-widget card-primary">
      <div class="profile-widget-header">
        <img alt="image" src="'.base_url().'/'.$core->show_avatar($info['id']).'" class="rounded-circle profile-widget-picture">
        <div class="profile-widget-items">
          <div class="profile-widget-item">
            <div class="profile-widget-item-label">
              '.$lang['user_REGISTERED'].'
            </div>
            <div class="profile-widget-item-value">
              '.$time->timeAgo($info['time']).'
            </div>
          </div>
          <div class="profile-widget-item">
            <div class="profile-widget-item-label">
              '.$lang['user_LAST_LOGGED'].'
            </div>
            <div class="profile-widget-item-value">
              '.$time->timeAgo($session->is_logged()).'
            </div>
          </div>
          <div class="profile-widget-item">
            <div class="profile-widget-item-label">
              '.$lang['user_ACCOUNT'].'
            </div>
            <div class="profile-widget-item-value">
              '.($info['type'] == 1 ? '<a href="javascript: void(0);" class="badge badge-primary">Premium Account</a>' : '<a href="javascript: void(0);" class="badge badge-warning">Free Account</a>').'
            </div>
          </div>
        </div>
      </div>
      <div class="profile-widget-description">
        <div class="profile-widget-name">
          Hi, '.$info['fullname'].'!
        </div>
        '.(!empty($info['description']) ? $core->filter_output($info['description'], TRUE) : $lang['user_EMPTY_DESCRIPTION']).'
      </div>
    </div>
  </div>';

  echo '</div>';
} else {

  // Blocked user
  echo '<div class="page-error">
    <div class="page-inner">
      <h2>
        Account Has Been Banned!
      </h2>
      <div class="page-description">
        <i class="text-muted">
          '.$lang['user_BANNED'].'
        </i>
      </div>
      <div class="page-search">
        <div class="mt-3">
          <a href="javascript: history.back(-1);" data-toggle="tooltip" title="'.$lang['search_NF_BTH'].'" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i>
            '.$lang['search_NF_BTHB'].'
          </a>
        </div>
      </div>
    </div>
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

echo '</div>';
echo '</section>';
require_once '../incfiles/footer.php';
?>
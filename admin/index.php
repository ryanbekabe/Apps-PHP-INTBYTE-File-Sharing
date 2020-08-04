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
$title = 'Administrator';
require_once '../incfiles/header.php';

// If not an Administrator, the system will be redirect to the index page or home page
if(!$session->is_login() || $session->is_rights() > 1) {
  $core->redirect(base_url().'/');
}

// Section Administrator
echo '<section class="section">';

echo '<div class="section-header">
  <h1 class="section-title">
    Administrator '.ucfirst($core->set('title')).'
  </h1>
  <div class="section-header-breadcrumb">
    <div class="breadcrumb-item active">
      <a href="'.base_url().'/admin/">
        Dashboard
      </a>
    </div>
    <div class="breadcrumb-item">
      Administrator
    </div>
  </div>
</div>';

echo '<div class="row">';

// Storage used
$q = $intbyte->query("SELECT SUM(storage) FROM users");
$storage = $q->fetch_array();
echo '<div class="col-lg-3 col-md-6 col-sm-6 col-12">
  <div class="card card-primary card-statistic-1">
    <div class="card-icon bg-primary">
      <i class="fas fa-server"></i>
    </div>
    <div class="card-wrap">
      <div class="card-header">
        <h4>
          '.$lang['admin_STORAGE_USED'].'
        </h4>
      </div>
      <div class="card-body">
        '.$core->size($storage['SUM(storage)']).'
      </div>
    </div>
  </div>
</div>';

// Total users
echo '<div class="col-lg-3 col-md-6 col-sm-6 col-12">
  <div class="card card-danger card-statistic-1">
    <div class="card-icon bg-danger">
      <i class="fas fa-users"></i>
    </div>
    <div class="card-wrap">
      <div class="card-header">
        <h4>
          '.$lang['admin_USERS'].'
        </h4>
      </div>
      <div class="card-body">
        '.number_format(($intbyte->query("SELECT * FROM users")->num_rows), 0, ',', '.').'
      </div>
    </div>
  </div>
</div>';

// Total admin
echo '<div class="col-lg-3 col-md-6 col-sm-6 col-12">
  <div class="card card-warning card-statistic-1">
    <div class="card-icon bg-warning">
      <i class="far fa-user"></i>
    </div>
    <div class="card-wrap">
      <div class="card-header">
        <h4>
          '.$lang['admin_TOTAL_ADMIN'].'
        </h4>
      </div>
      <div class="card-body">
        '.number_format(($intbyte->query("SELECT * FROM users WHERE rights = '1'")->num_rows), 0, ',', '.').'
      </div>
    </div>
  </div>
</div>';

// Total files
echo '<div class="col-lg-3 col-md-6 col-sm-6 col-12">
  <div class="card card-primary card-statistic-1">
    <div class="card-icon bg-primary">
      <i class="fas fa-file"></i>
    </div>
    <div class="card-wrap">
      <div class="card-header">
        <h4>
          '.$lang['admin_TOTAL_FILES'].'
        </h4>
      </div>
      <div class="card-body">
        '.number_format(($intbyte->query("SELECT * FROM files")->num_rows), 0, ',', '.').'
      </div>
    </div>
  </div>
</div>';

echo '</div>';

echo '<div class="row">';

// List Admin
echo '<div class="col-lg-6 col-md-12 col-12 col-sm-12">
<div class="card card-primary">
  <div class="card-header">
    <h4>
      ADMIN
    </h4>
  </div>
  <div class="card-body">
    <div class="row pb-2">';

    $q = $intbyte->query("SELECT * FROM users WHERE rights = '1' LIMIT 4");
    if($q->num_rows > 0) {
      while($admin = $q->fetch_assoc()) {

        // List of administrator
        echo '<div class="col-6 col-sm-3 col-lg-3 mb-4 mb-md-0">
          <div class="avatar-item mb-0">
            <img alt="image" src="'.base_url().'/'.$core->show_avatar($admin['id']).'" class="img-fluid" data-toggle="tooltip" title="'.$core->_e($admin['fullname']).'">
            <div class="avatar-badge" title="Profile" data-toggle="tooltip">
              <a href="'.base_url().'/user/'.$core->_e(strtolower($admin['username'])).'/">
                <i class="fas fa-eye"></i>
              </a>
            </div>
          </div>
        </div>';

        // Do not remove this line because it is important
        $admin++;
      }
    }

echo '</div>
  </div>
</div>
</div>';

// List users
echo '<div class="col-lg-6 col-md-12 col-12 col-sm-12">
<div class="card card-primary">
  <div class="card-header">
    <h4>
      USERS
    </h4>
  </div>
  <div class="card-body">
    <div class="row pb-2">';

    $q = $intbyte->query("SELECT * FROM users ORDER BY `id` DESC LIMIT 4");
    if($q->num_rows > 0) {
      while($user = $q->fetch_assoc()) {

        // List of users
        echo '<div class="col-6 col-sm-3 col-lg-3 mb-4 mb-md-0">
          <div class="avatar-item mb-0">
            <img alt="image" src="'.base_url().'/'.$core->show_avatar($user['id']).'" class="img-fluid" data-toggle="tooltip" title="'.$core->_e($user['fullname']).'">
            <div class="avatar-badge" title="Profile" data-toggle="tooltip">
              <a href="'.base_url().'/user/'.strtolower($user['username']).'">
                <i class="fas fa-eye"></i>
              </a>
            </div>
          </div>
        </div>';

        // Do not remove this line because it is important
        $user++;
      }
    } else {

      // Data not available
      echo '<div class="card-body">
        <div class="col text-center">
          The users not available not.
        </div>
      </div>';
    }

echo '</div>
  </div>
</div>
</div>';

echo '</div>';
echo '</section>';
require_once '../incfiles/footer.php';
?>
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

// If not an Administrator, the system will be redirect to the index page or home page
if(!$session->is_login() || $session->is_rights() > 1) {
  $core->redirect(base_url().'/');
}

$act = isset($_GET['view']) ? trim($_GET['view']) : '';
switch($act) {

  case 'blocked':

    // Block users
    if(isset($_GET['id']) && !empty($_GET['id'])) {

      $id = intval($_GET['id']);
      $q = $intbyte->query("SELECT * FROM users WHERE id = ".$id."");
      if($q->num_rows > 0) {

        // Update
        if($intbyte->query("UPDATE users SET rights = '0' WHERE id = ".$id."")) {

          // Successfully updated the users
          $core->redirect(base_url().'/admin/manage-users/?view=users&type=blocked');
        } else {

          // Failed updated the users
          $core->redirect(base_url().'/admin/manage-users/?view=users&type=new');
        }
      } else {

        // Data not available
        $core->redirect(base_url().'/admin/manage-users/?view=users&type=new');
      }
    } else {

      // Illegal access
      $core->redirect(base_url().'/admin/manage-users/');
    }
  break;

  case 'unblocked':

    // Unblocked users
    if(isset($_GET['id']) && !empty($_GET['id'])) {

      $id = intval($_GET['id']);
      $q = $intbyte->query("SELECT * FROM users WHERE id = ".$id."");
      if($q->num_rows > 0) {

        // Update
        if($intbyte->query("UPDATE users SET rights = '2' WHERE id = ".$id."")) {

          // Successfully updated the users
          $core->redirect(base_url().'/admin/manage-users/?view=users&type=blocked');
        } else {

          // Failed updated the users
          $core->redirect(base_url().'/admin/manage-users/?view=users&type=blocked');
        }
      } else {

        // Data not available
        $core->redirect(base_url().'/admin/manage-users/?view=users&type=blocked');
      }
    } else {

      // Illegal access
      $core->redirect(base_url().'/admin/manage-users/');
    }
  break;

  case 'deleted':

    // Delete Users
    if(isset($_GET['id']) && !empty($_GET['id'])) {

      $id = intval($_GET['id']);
      $q = $intbyte->query("SELECT * FROM users WHERE id = ".$id."");
      if($q->num_rows > 0) {
        
        // Delete: Remove path, user ads, all files, and user folders
        $core->remove_path('../data/'.$core->username($id).'/');
        if(rmdir('../data/'.$core->username($id).'/')) {
          
          // User Data
          $a = $intbyte->query("DELETE FROM ads WHERE user_id = ".$id."");
          $s = $intbyte->query("DELETE FROM files WHERE user_id = ".$id."");
          $u = $intbyte->query("DELETE FROM folders WHERE user_id = ".$id."");
          $s = $intbyte->query("DELETE FROM users WHERE id = ".$id."");
          if($a && $s && $u && $s) {

            // Successfully updated the users
            $core->redirect(base_url().'/admin/manage-users/?view=users&type=new');
          } else {

            // Failed updated the users
            $core->redirect(base_url().'/admin/manage-users/?view=users&type=new');
          }
        } else {

          // Data not available
          $core->redirect(base_url().'/admin/manage-users/?view=users&type=new');
        }
      } else {

        // Data not available
        $core->redirect(base_url().'/admin/manage-users/?view=users&type=new');
      }
    } else {

      // Illegal access
      $core->redirect(base_url().'/admin/manage-users/');
    }
  break;

  case 'users':

    // Manage Users: List new users, blocked users, unconfirmed users
    if(isset($_GET['type'])) {
      if(urlencode($_GET['type']) == 'new') {

        // New users
        // Headers
        $title = $lang['user_LIST'];
        require_once '../incfiles/header.php';
    
        // If not an Administrator, the system will be redirect to the index page or home page
        if(!$session->is_login() || $session-> is_rights() > 1) {
          $core->redirect(base_url().'/');
        }

        // Section new users
        echo '<section class="section">';

        echo '<div class="section-header">
          <h1 class="section-title">
            '.$lang['user_LIST'].'
          </h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="'.base_url().'/admin/">
                Dashboard
              </a>
            </div>
            <div class="breadcrumb-item">
              '.$lang['user_LIST'].'
            </div>
          </div>
        </div>';

        echo '<div class="row">';

        echo '<div class="col-12">
          <div class="card card-primary">
            <div class="card-header">
              <h4>
                '.$lang['user_LIST'].'
              </h4>
            </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover table-md">
                <tr>
                  <th class="align-middle">
                    <center>
                      ID
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['user_LIST_USERNAME'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['user_LIST_EMAIL'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['user_LIST_REGISTERED'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['user_LIST_LEVEL'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['user_LIST_STATUS'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['user_LIST_ACTION'].'
                    </center>
                  </th>
                </tr>';
          
        $q = $intbyte->query("SELECT * FROM users WHERE rights >= '0' AND rights != '1' ORDER BY `id` DESC LIMIT ".$start.", ".$core->set('paging')."");
        $all = $intbyte->query("SELECT * FROM users WHERE rights >= '0' AND rights != '1'")->num_rows;
        if($q->num_rows > 0) {

          $no = 1;
          while($user = $q->fetch_assoc()) {

            // List of users
            echo '<tr>
              <td class="align-middle">
                <center>
                  '.$no.'
                </center>
              </td>
              <td class="align-middle">
                <img alt="image" src="'.base_url().'/'.$core->show_avatar($user['id']).'" class="rounded-circle" width="35" data-toggle="tooltip" title="'.$user['fullname'].'">
                '.$user['username'].'
              </td>
              <td class="align-middle">
                '.$user['email'].'
              </td>
              <td>
                '.$time->timeAgo($user['time']).'
              </td>
              <td class="align-middle">
                '.$core->level($user['rights']).'
              </td>
              <td class="align-middle">
                '.$core->status($user['status']).'
              </td>
              <td class="align-middle">
                <center>
                  <a id="block-'.$user['id'].'" class="btn btn-warning btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['user_LIST_BDWN_BLOCK'].'" href="javascript: void(0);">
                    <i class="fas fa-times"></i>
                  </a>
                  <a id="delete-'.$user['id'].'" class="btn btn-danger btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['user_LIST_BDWN_DELETE'].'" href="javascript: void(0);">
                    <i class="fas fa-trash"></i>
                  </a>
                  <a id="see_profile-'.$user['id'].'" class="btn btn-default btn-sm btn-icon icon-center" style="background: #BFBFBF;color: #FFFFFF;" data-toggle="tooltip" title="'.$lang['user_LIST_BDWN_SEE'].'" href="javascript: void(0);">
                    <i class="fas fa-eye"></i>
                  </a>
                  <a id="upgrade-'.$user['id'].'" class="btn btn-primary btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['user_LIST_BDWN_UPA'].'" href="javascript: void(0);">
                    <i class="fas fa-arrow-up"></i>
                  </a>
                </center>
              </td>
            </tr>';

            // Manage Users: Block, delete, see profile, upgrade premium account
            echo "<script>
              $(document).ready(function() {

                // Block users
                $('#block-".$user['id']."').on('click', function() {
                  swal({
                    title: '".$lang['user_LIST_CONFIRM_AYS']."',
                    text: '".$lang['user_LIST_CONBLOCK_TEXT']."',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                  }).then((willBlock) => {
                    if(willBlock) {
                      swal('".$lang['user_LIST_CONBLOCK_SUCCESS']."', {
                        title: 'SUCCESS!',
                        icon: 'success',
                        buttons: false,
                        timer: 3000,
                      }).then(function() {
                        window.location = '".base_url()."/admin/manage-users/?view=blocked&id=".$user['id']."';
                      });
                    } else {
                      swal('".$lang['user_LIST_CONBLOCK_CANCEL']."',                       {
                        buttons: false,
                        timer: 3000,
                      });
                    }
                  });
                });

                // Delete users
                $('#delete-".$user['id']."').on('click', function() {
                  swal({
                    title: '".$lang['user_LIST_CONFIRM_AYS']."',
                    text: '".$lang['user_LIST_CONDELETE_TEXT']."',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                  }).then((willDelete) => {
                    if(willDelete) {
                      swal('".$lang['user_LIST_CONDELETE_SUCCESS']."', {
                        title: 'SUCCESS!',
                        icon: 'success',
                        buttons: false,
                        timer: 3000,
                      }).then(function() {
                        window.location = '".base_url()."/admin/manage-users/?view=deleted&id=".$user['id']."';
                      });
                    } else {
                      swal('".$lang['user_LIST_CONDELETE_CANCEL']."',                       {
                        buttons: false,
                        timer: 3000,
                      });
                    }
                  });
                });

                // See profile
                $('#see_profile-".$user['id']."').on('click', function() {
                  window.location = '".base_url()."/user/".$core->username($user['id'])."/';
                });

                // Upgrade premium account
                $('#upgrade-".$user['id']."').on('click', function() {
                  window.location = '".base_url()."/admin/upgrade-users/?act=upgrade&package=premium_account&id=".$user['id']."';
                });

              });
            </script>";

            // Do not remove this line because it is important
            $user++;
            $no++;
          }

          // Pagination
          echo '</table>
              </div>
            </div>
            <div class="card-footer text-right">
              '.$paging->showPage($all, $page, $core->set('paging'), base_url().'/admin/manage-users/?view=users&type=new&').'
            </div>
          </div>
          </div>';
        } else {

          // Data not available
          echo '<td colspan="9" class="align-middle">
                  <marquee scrollamount="2" scrolldelay="2">
                    '.$lang['nf'].'
                  </marquee>
                </td>
                </table>
                </div>
              </div>
            </div>
          </div>';
        }

        echo '</div>';
        echo '</section>';
        require_once '../incfiles/footer.php';
      } elseif(urlencode($_GET['type']) == 'blocked') {

        // Blocked users
        // Headers
        $title = $lang['user_LIST_BLOCK'];
        require_once '../incfiles/header.php';
    
        // If not an Administrator, the system will be redirect to the index page or home page
        if(!$session->is_login() || $session-> is_rights() > 1) {
          $core->redirect(base_url().'/');
        }

        // Section blocked users
        echo '<section class="section">';

        echo '<div class="section-header">
          <h1 class="section-title">
            '.$lang['user_LIST_BLOCK'].'
          </h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="'.base_url().'/admin/">
                Dashboard
              </a>
            </div>
            <div class="breadcrumb-item">
              '.$lang['user_LIST_BLOCK'].'
            </div>
          </div>
        </div>';

        echo '<div class="row">';

        echo '<div class="col-12">
          <div class="card card-primary">
            <div class="card-header">
              <h4>
                '.$lang['user_LIST_BLOCK'].'
              </h4>
            </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover table-md">
                <tr>
                  <th class="align-middle">
                    <center>
                      ID
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['user_LIST_USERNAME'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['user_LIST_EMAIL'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['user_LIST_REGISTERED'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['user_LIST_LEVEL'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['user_LIST_STATUS'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['user_LIST_ACTION'].'
                    </center>
                  </th>
                </tr>';
          
        $q = $intbyte->query("SELECT * FROM users WHERE rights = '0' AND rights != '1' ORDER BY `id` DESC LIMIT ".$start.", ".$core->set('paging')."");
        $all = $intbyte->query("SELECT * FROM users WHERE rights = '0' AND rights != '1'")->num_rows;
        if($q->num_rows > 0) {

          $no = 1;
          while($user = $q->fetch_assoc()) {

            // List of users
            echo '<tr>
              <td class="align-middle">
                <center>
                  '.$no.'
                </center>
              </td>
              <td class="align-middle">
                <img alt="image" src="'.base_url().'/'.$core->show_avatar($user['id']).'" class="rounded-circle" width="35" data-toggle="tooltip" title="'.$user['fullname'].'">
                '.$user['username'].'
              </td>
              <td class="align-middle">
                '.$user['email'].'
              </td>
              <td>
                '.$time->timeAgo($user['time']).'
              </td>
              <td class="align-middle">
                '.$core->level($user['rights']).'
              </td>
              <td class="align-middle">
                '.$core->status($user['status']).'
              </td>
              <td class="align-middle">
                <center>
                  <a id="block-'.$user['id'].'" class="btn btn-warning btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['user_LIST_BDWN_UNBLOCK'].'" href="javascript: void(0);">
                    <i class="fas fa-times"></i>
                  </a>
                  <a id="delete-'.$user['id'].'" class="btn btn-danger btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['user_LIST_BDWN_DELETE'].'" href="javascript: void(0);">
                    <i class="fas fa-trash"></i>
                  </a>
                  <a id="see_profile-'.$user['id'].'" class="btn btn-default btn-sm btn-icon icon-center" style="background: #BFBFBF;color: #FFFFFF;" data-toggle="tooltip" title="'.$lang['user_LIST_BDWN_SEE'].'" href="javascript: void(0);">
                    <i class="fas fa-eye"></i>
                  </a>
                  <a id="upgrade-'.$user['id'].'" class="btn btn-primary btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['user_LIST_BDWN_UPA'].'" href="javascript: void(0);">
                    <i class="fas fa-arrow-up"></i>
                  </a>
                </center>
              </td>
            </tr>';

            // Manage Users: Block, delete, see profile, upgrade premium account
            echo "<script>
              $(document).ready(function() {

                // Block users
                $('#block-".$user['id']."').on('click', function() {
                  swal({
                    title: '".$lang['user_LIST_CONFIRM_AYS']."',
                    text: '".$lang['user_LIST_CONUNBLOCK_TEXT']."',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                  }).then((willBlock) => {
                    if(willBlock) {
                      swal('".$lang['user_LIST_CONUBLOCK_SUCCESS']."', {
                        title: 'SUCCESS!',
                        icon: 'success',
                        buttons: false,
                        timer: 3000,
                      }).then(function() {
                        window.location = '".base_url()."/admin/manage-users/?view=unblocked&id=".$user['id']."';
                      });
                    } else {
                      swal('".$lang['user_LIST_CONUNBLOCK_CANCEL']."', {
                        buttons: false,
                        timer: 3000,
                      });
                    }
                  });
                });

                // Delete users
                $('#delete-".$user['id']."').on('click', function() {
                  swal({
                    title: '".$lang['user_LIST_CONFIRM_AYS']."',
                    text: '".$lang['user_LIST_CONDELETE_TEXT']."',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                  }).then((willDelete) => {
                    if(willDelete) {
                      swal('".$lang['user_LIST_CONDELETE_SUCCESS']."', {
                        title: 'SUCCESS!',
                        icon: 'success',
                        buttons: false,
                        timer: 3000,
                      }).then(function() {
                        window.location = '".base_url()."/admin/manage-users/?view=deleted&id=".$user['id']."';
                      });
                    } else {
                      swal('".$lang['user_LIST_CONDELETE_CANCEL']."', {
                        buttons: false,
                        timer: 3000,
                      });
                    }
                  });
                });

                // See profile
                $('#see_profile-".$user['id']."').on('click', function() {
                  window.location = '".base_url()."/user/".$core->username($user['id'])."/';
                });

                // Upgrade premium account
                $('#upgrade-".$user['id']."').on('click', function() {
                  window.location = '".base_url()."/admin/upgrade-users/?act=upgrade&package=premium_account&id=".$user['id']."';
                });

              });
            </script>";

            // Do not remove this line because it is important
            $user++;
            $no++;
          }

          // Pagination
          echo '</table>
              </div>
            </div>
            <div class="card-footer text-right">
              '.$paging->showPage($all, $page, $core->set('paging'), base_url().'/admin/manage-users/?view=users&type=blocked&').'
            </div>
          </div>
          </div>';
        } else {

          // Data not available
          echo '<td colspan="9" class="align-middle">
                  <marquee scrollamount="2" scrolldelay="2">
                    '.$lang['nf'].'
                  </marquee>
                </td>
                </table>
                </div>
              </div>
            </div>
          </div>';
        }

        echo '</div>';
        echo '</section>';
        require_once '../incfiles/footer.php';
      } elseif(urlencode($_GET['type']) == 'unconfirmed') {

        // Unconfirmed users
        // Headers
        $title = $lang['user_LIST_UNCONFIRM'];
        require_once '../incfiles/header.php';
    
        // If not an Administrator, the system will be redirect to the index page or home page
        if(!$session->is_login() || $session-> is_rights() > 1) {
          $core->redirect(base_url().'/');
        }

        // Section unconfirmed users
        echo '<section class="section">';

        echo '<div class="section-header">
          <h1 class="section-title">
            '.$lang['user_LIST_UNCONFIRM'].'
          </h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="'.base_url().'/admin/">
                Dashboard
              </a>
            </div>
            <div class="breadcrumb-item">
              '.$lang['user_LIST_UNCONFIRM'].'
            </div>
          </div>
        </div>';

        echo '<div class="row">';

        echo '<div class="col-12">
          <div class="card card-primary">
            <div class="card-header">
              <h4>
                '.$lang['user_LIST_UNCONFIRM'].'
              </h4>
            </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover table-md">
                <tr>
                  <th class="align-middle">
                    <center>
                      ID
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['user_LIST_USERNAME'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['user_LIST_EMAIL'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['user_LIST_REGISTERED'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['user_LIST_LEVEL'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['user_LIST_STATUS'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['user_LIST_ACTION'].'
                    </center>
                  </th>
                </tr>';
          
        $q = $intbyte->query("SELECT * FROM users WHERE rights >= '0' AND rights != '1' AND status = '0' ORDER BY `id` DESC LIMIT ".$start.", ".$core->set('paging')."");
        $all = $intbyte->query("SELECT * FROM users WHERE rights >= '0' AND rights != '1' AND status = '0'")->num_rows;
        if($q->num_rows > 0) {

          $no = 1;
          while($user = $q->fetch_assoc()) {

            // List of users
            echo '<tr>
              <td class="align-middle">
                <center>
                  '.$no.'
                </center>
              </td>
              <td class="align-middle">
                <img alt="image" src="'.base_url().'/'.$core->show_avatar($user['id']).'" class="rounded-circle" width="35" data-toggle="tooltip" title="'.$user['fullname'].'">
                '.$user['username'].'
              </td>
              <td class="align-middle">
                '.$user['email'].'
              </td>
              <td>
                '.$time->timeAgo($user['time']).'
              </td>
              <td class="align-middle">
                '.$core->level($user['rights']).'
              </td>
              <td class="align-middle">
                '.$core->status($user['status']).'
              </td>
              <td class="align-middle">
                <center>
                  <a id="block-'.$user['id'].'" class="btn btn-warning btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['user_LIST_BDWN_BLOCK'].'" href="javascript: void(0);">
                    <i class="fas fa-times"></i>
                  </a>
                  <a id="delete-'.$user['id'].'" class="btn btn-danger btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['user_LIST_BDWN_DELETE'].'" href="javascript: void(0);">
                    <i class="fas fa-trash"></i>
                  </a>
                  <a id="see_profile-'.$user['id'].'" class="btn btn-default btn-sm btn-icon icon-center" style="background: #BFBFBF;color: #FFFFFF;" data-toggle="tooltip" title="'.$lang['user_LIST_BDWN_SEE'].'" href="javascript: void(0);">
                    <i class="fas fa-eye"></i>
                  </a>
                  <a id="upgrade-'.$user['id'].'" class="btn btn-primary btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['user_LIST_BDWN_UPA'].'" href="javascript: void(0);">
                    <i class="fas fa-arrow-up"></i>
                  </a>
                </center>
              </td>
            </tr>';

            // Manage Users: Block, delete, see profile, upgrade premium account
            echo "<script>
              $(document).ready(function() {

                // Block users
                $('#block-".$user['id']."').on('click', function() {
                  swal({
                    title: '".$lang['user_LIST_CONFIRM_AYS']."',
                    text: '".$lang['user_LIST_CONBLOCK_TEXT']."',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                  }).then((willBlock) => {
                    if(willBlock) {
                      swal('".$lang['user_LIST_CONBLOCK_SUCCESS']."', {
                        title: 'SUCCESS!',
                        icon: 'success',
                        buttons: false,
                        timer: 3000,
                      }).then(function() {
                        window.location = '".base_url()."/admin/manage-users/?view=blocked&id=".$user['id']."';
                      });
                    } else {
                      swal('".$lang['user_LIST_CONBLOCK_CANCEL']."', {
                        buttons: false,
                        timer: 3000,
                      });
                    }
                  });
                });

                // Delete users
                $('#delete-".$user['id']."').on('click', function() {
                  swal({
                    title: '".$lang['user_LIST_CONFIRM_AYS']."',
                    text: '".$lang['user_LIST_CONDELETE_TEXT']."',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                  }).then((willDelete) => {
                    if(willDelete) {
                      swal('".$lang['user_LIST_CONDELETE_SUCCESS']."', {
                        title: 'SUCCESS!',
                        icon: 'success',
                        buttons: false,
                        timer: 3000,
                      }).then(function() {
                        window.location = '".base_url()."/admin/manage-users/?view=deleted&id=".$user['id']."';
                      });
                    } else {
                      swal('".$lang['user_LIST_CONDELETE_CANCEL']."', {
                        buttons: false,
                        timer: 3000,
                      });
                    }
                  });
                });

                // See profile
                $('#see_profile-".$user['id']."').on('click', function() {
                  window.location = '".base_url()."/user/".$core->username($user['id'])."/';
                });

                // Upgrade premium account
                $('#upgrade-".$user['id']."').on('click', function() {
                  window.location = '".base_url()."/admin/upgrade-users/?act=upgrade&package=premium_account&id=".$user['id']."';
                });

              });
            </script>";

            // Do not remove this line because it is important
            $user++;
            $no++;
          }

          // Pagination
          echo '</table>
              </div>
            </div>
            <div class="card-footer text-right">
              '.$paging->showPage($all, $page, $core->set('paging'), base_url().'/admin/manage-users/?view=users&type=unconfirmed&').'
            </div>
          </div>
          </div>';
        } else {

          // Data not available
          echo '<td colspan="9" class="align-middle">
                  <marquee scrollamount="2" scrolldelay="2">
                    '.$lang['nf'].'
                  </marquee>
                </td>
                </table>
                </div>
              </div>
            </div>
          </div>';
        }

        echo '</div>';
        echo '</section>';
        require_once '../incfiles/footer.php';
      } elseif(urlencode($_GET['type']) == 'confirmed') {

        // Confirmed users
        // Headers
        $title = $lang['user_LIST_CONFIRMED'];
        require_once '../incfiles/header.php';
    
        // If not an Administrator, the system will be redirect to the index page or home page
        if(!$session->is_login() || $session-> is_rights() > 1) {
          $core->redirect(base_url().'/');
        }

        // Section confirmed users
        echo '<section class="section">';

        echo '<div class="section-header">
          <h1 class="section-title">
            '.$lang['user_LIST_CONFIRMED'].'
          </h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="'.base_url().'/admin/">
                Dashboard
              </a>
            </div>
            <div class="breadcrumb-item">
              '.$lang['user_LIST_CONFIRMED'].'
            </div>
          </div>
        </div>';

        echo '<div class="row">';

        echo '<div class="col-12">
          <div class="card card-primary">
            <div class="card-header">
              <h4>
                '.$lang['user_LIST_CONFIRMED'].'
              </h4>
            </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover table-md">
                <tr>
                  <th class="align-middle">
                    <center>
                      ID
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['user_LIST_USERNAME'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['user_LIST_EMAIL'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['user_LIST_REGISTERED'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['user_LIST_LEVEL'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['user_LIST_STATUS'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['user_LIST_ACTION'].'
                    </center>
                  </th>
                </tr>';
          
        $q = $intbyte->query("SELECT * FROM users WHERE rights >= '0' AND rights != '1' AND status = '1' ORDER BY `id` DESC LIMIT ".$start.", ".$core->set('paging')."");
        $all = $intbyte->query("SELECT * FROM users WHERE rights >= '0' AND rights != '1' AND status = '1'")->num_rows;
        if($q->num_rows > 0) {

          $no = 1;
          while($user = $q->fetch_assoc()) {

            // List of users
            echo '<tr>
              <td class="align-middle">
                '.$no.'
              </td>
              <td class="align-middle">
                <img alt="image" src="'.base_url().'/'.$core->show_avatar($user['id']).'" class="rounded-circle" width="35" data-toggle="tooltip" title="'.$user['fullname'].'">
                '.$user['username'].'
              </td>
              <td class="align-middle">
                '.$user['email'].'
              </td>
              <td>
                '.$time->timeAgo($user['time']).'
              </td>
              <td class="align-middle">
                '.$core->level($user['rights']).'
              </td>
              <td class="align-middle">
                '.$core->status($user['status']).'
              </td>
              <td class="align-middle">
                <center>
                  <a id="block-'.$user['id'].'" class="btn btn-warning btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['user_LIST_BDWN_BLOCK'].'" href="javascript: void(0);">
                    <i class="fas fa-times"></i>
                  </a>
                  <a id="delete-'.$user['id'].'" class="btn btn-danger btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['user_LIST_BDWN_DELETE'].'" href="javascript: void(0);">
                    <i class="fas fa-trash"></i>
                  </a>
                  <a id="see_profile-'.$user['id'].'" class="btn btn-default btn-sm btn-icon icon-center" style="background: #BFBFBF;color: #FFFFFF;" data-toggle="tooltip" title="'.$lang['user_LIST_BDWN_SEE'].'" href="javascript: void(0);">
                    <i class="fas fa-eye"></i>
                  </a>
                  <a id="upgrade-'.$user['id'].'" class="btn btn-primary btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['user_LIST_BDWN_UPA'].'" href="javascript: void(0);">
                    <i class="fas fa-arrow-up"></i>
                  </a>
                </center>
              </td>
            </tr>';

            // Manage Users: Block, delete, see profile, upgrade premium account
            echo "<script>
              $(document).ready(function() {

                // Block users
                $('#block-".$user['id']."').on('click', function() {
                  swal({
                    title: '".$lang['user_LIST_CONFIRM_AYS']."',
                    text: '".$lang['user_LIST_CONBLOCK_TEXT']."',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                  }).then((willBlock) => {
                    if(willBlock) {
                      swal('".$lang['user_LIST_CONBLOCK_SUCCESS']."', {
                        title: 'SUCCESS!',
                        icon: 'success',
                        buttons: false,
                        timer: 3000,
                      }).then(function() {
                        window.location = '".base_url()."/admin/manage-users/?view=blocked&id=".$user['id']."';
                      });
                    } else {
                      swal('".$lang['user_LIST_CONBLOCK_CANCEL']."', {
                        buttons: false,
                        timer: 3000,
                      });
                    }
                  });
                });

                // Delete users
                $('#delete-".$user['id']."').on('click', function() {
                  swal({
                    title: '".$lang['user_LIST_CONFIRM_AYS']."',
                    text: '".$lang['user_LIST_CONDELETE_TEXT']."',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                  }).then((willDelete) => {
                    if(willDelete) {
                      swal('".$lang['user_LIST_CONDELETE_SUCCESS']."', {
                        title: 'SUCCESS!',
                        icon: 'success',
                        buttons: false,
                        timer: 3000,
                      }).then(function() {
                        window.location = '".base_url()."/admin/manage-users/?view=deleted&id=".$user['id']."';
                      });
                    } else {
                      swal('".$lang['user_LIST_CONDELETE_CANCEL']."', {
                        buttons: false,
                        timer: 3000,
                      });
                    }
                  });
                });

                // See profile
                $('#see_profile-".$user['id']."').on('click', function() {
                  window.location = '".base_url()."/user/".$core->username($user['id'])."/';
                });

                // Upgrade premium account
                $('#upgrade-".$user['id']."').on('click', function() {
                  window.location = '".base_url()."/admin/upgrade-users/?act=upgrade&package=premium_account&id=".$user['id']."';
                });

              });
            </script>";

            // Do not remove this line because it is important
            $user++;
            $no++;
          }

          // Pagination
          echo '</table>
              </div>
            </div>
            <div class="card-footer text-right">
              '.$paging->showPage($all, $page, $core->set('paging'), base_url().'/admin/manage-users/?view=users&type=confirmed&').'
            </div>
          </div>
          </div>';
        } else {

          // Data not available
          echo '<td colspan="9" class="align-middle">
                  <marquee scrollamount="2" scrolldelay="2">
                    '.$lang['nf'].'
                  </marquee>
                </td>
                </table>
                </div>
              </div>
            </div>
          </div>';
        }

        echo '</div>';
        echo '</section>';
        require_once '../incfiles/footer.php';
      } elseif(urlencode($_GET['type']) == 'premium_account') {

        // Premium account
        // Headers
        $title = $lang['user_LIST_PA'];
        require_once '../incfiles/header.php';
    
        // If not an Administrator, the system will be redirect to the index page or home page
        if(!$session->is_login() || $session-> is_rights() > 1) {
          $core->redirect(base_url().'/');
        }

        // Section premium account
        echo '<section class="section">';

        echo '<div class="section-header">
          <h1 class="section-title">
            '.$lang['user_LIST_PA'].'
          </h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="'.base_url().'/admin/">
                Dashboard
              </a>
            </div>
            <div class="breadcrumb-item">
              '.$lang['user_LIST_PA'].'
            </div>
          </div>
        </div>';

        echo '<div class="row">';

        echo '<div class="col-12">
          <div class="card card-primary">
            <div class="card-header">
              <h4>
                '.$lang['user_LIST_PA'].'
              </h4>
            </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover table-md">
                <tr>
                  <th class="align-middle">
                    <center>
                      ID
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['user_LIST_USERNAME'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['user_LIST_EMAIL'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['user_LIST_REGISTERED'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['user_LIST_LEVEL'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['user_LIST_STATUS'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['user_LIST_ACTION'].'
                    </center>
                  </th>
                </tr>';
          
        $q = $intbyte->query("SELECT * FROM users WHERE rights >= '0' AND rights != '1' AND type = '1' ORDER BY `id` DESC LIMIT ".$start.", ".$core->set('paging')."");
        $all = $intbyte->query("SELECT * FROM users WHERE rights >= '0' AND rights != '1' AND type = '1'")->num_rows;
        if($q->num_rows > 0) {

          $no = 1;
          while($user = $q->fetch_assoc()) {

            // List of users
            echo '<tr>
              <td class="align-middle">
                <center>
                  '.$no.'
                </center>
              </td>
              <td class="align-middle">
                <img alt="image" src="'.base_url().'/'.$core->show_avatar($user['id']).'" class="rounded-circle" width="35" data-toggle="tooltip" title="'.$user['fullname'].'">
                '.$user['username'].'
              </td>
              <td class="align-middle">
                '.$user['email'].'
              </td>
              <td>
                '.$time->timeAgo($user['time']).'
              </td>
              <td class="align-middle">
                '.$core->level($user['rights']).'
              </td>
              <td class="align-middle">
                '.$core->status($user['status']).'
              </td>
              <td class="align-middle">
                <center>
                  <a id="block-'.$user['id'].'" class="btn btn-warning btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['user_LIST_BDWN_BLOCK'].'" href="javascript: void(0);">
                    <i class="fas fa-times"></i>
                  </a>
                  <a id="delete-'.$user['id'].'" class="btn btn-danger btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['user_LIST_BDWN_DELETE'].'" href="javascript: void(0);">
                    <i class="fas fa-trash"></i>
                  </a>
                  <a id="see_profile-'.$user['id'].'" class="btn btn-default btn-sm btn-icon icon-center" style="background: #BFBFBF;color: #FFFFFF;" data-toggle="tooltip" title="'.$lang['user_LIST_BDWN_SEE'].'" href="javascript: void(0);">
                    <i class="fas fa-eye"></i>
                  </a>
                  <a id="upgrade-'.$user['id'].'" class="btn btn-primary btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['user_LIST_BDWN_DPA'].'" href="javascript: void(0);">
                    <i class="fas fa-arrow-down"></i>
                  </a>
                </center>
              </td>
            </tr>';

            // Manage Users: Block, delete, see profile, upgrade premium account
            echo "<script>
              $(document).ready(function() {

                // Block users
                $('#block-".$user['id']."').on('click', function() {
                  swal({
                    title: '".$lang['user_LIST_CONFIRM_AYS']."',
                    text: '".$lang['user_LIST_CONBLOCK_TEXT']."',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                  }).then((willBlock) => {
                    if(willBlock) {
                      swal('".$lang['user_LIST_CONBLOCK_SUCCESS']."', {
                        title: 'SUCCESS!',
                        icon: 'success',
                        buttons: false,
                        timer: 3000,
                      }).then(function() {
                        window.location = '".base_url()."/admin/manage-users/?view=blocked&id=".$user['id']."';
                      });
                    } else {
                      swal('".$lang['user_LIST_CONBLOCK_CANCEL']."', {
                        buttons: false,
                        timer: 3000,
                      });
                    }
                  });
                });

                // Delete users
                $('#delete-".$user['id']."').on('click', function() {
                  swal({
                    title: '".$lang['user_LIST_CONFIRM_AYS']."',
                    text: '".$lang['user_LIST_CONDELETE_TEXT']."',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                  }).then((willDelete) => {
                    if(willDelete) {
                      swal('".$lang['user_LIST_CONDELETE_SUCCESS']."', {
                        title: 'SUCCESS!',
                        icon: 'success',
                        buttons: false,
                        timer: 3000,
                      }).then(function() {
                        window.location = '".base_url()."/admin/manage-users/?view=deleted&id=".$user['id']."';
                      });
                    } else {
                      swal('".$lang['user_LIST_CONDELETE_CANCEL']."', {
                        buttons: false,
                        timer: 3000,
                      });
                    }
                  });
                });

                // See profile
                $('#see_profile-".$user['id']."').on('click', function() {
                  window.location = '".base_url()."/user/".$core->username($user['id'])."/';
                });

                // Upgrade premium account
                $('#upgrade-".$user['id']."').on('click', function() {
                  window.location = '".base_url()."/admin/upgrade-users/?act=downgrade&package=premium_account&id=".$user['id']."';
                });

              });
            </script>";

            // Do not remove this line because it is important
            $user++;
            $no++;
          }

          // Pagination
          echo '</table>
              </div>
            </div>
            <div class="card-footer text-right">
              '.$paging->showPage($all, $page, $core->set('paging'), base_url().'/admin/manage-users/?view=users&type=premium_account&').'
            </div>
          </div>
          </div>';
        } else {

          // Data not available
          echo '<td colspan="9" class="align-middle">
                  <marquee scrollamount="2" scrolldelay="2">
                    '.$lang['nf'].'
                  </marquee>
                </td>
                </table>
                </div>
              </div>
            </div>
          </div>';
        }

        echo '</div>';
        echo '</section>';
        require_once '../incfiles/footer.php';
      } else {

        // Illegal access
        $core->redirect(base_url().'/admin/manage-users/');
      }
    } else {

      // Illegal access
      $core->redirect(base_url().'/admin/manage-users/');
    }
  break;

  default:

    // Illegal Access
    // If there is access to this page then the system will direct to the main page Administrator
    $core->redirect(base_url().'/admin/');
  break;
}
?>
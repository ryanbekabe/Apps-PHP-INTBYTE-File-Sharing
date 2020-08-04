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

// Headers
$title = $lang['admin_LT'];
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

// Section administrator
echo '<section class="section">';

echo '<div class="section-header">
  <h1 class="section-title">
    '.$lang['admin_LT'].'
  </h1>
  <div class="section-header-breadcrumb">
    <div class="breadcrumb-item active">
      <a href="'.base_url().'/admin/">
        Dashboard
      </a>
    </div>
    <div class="breadcrumb-item">
      '.$lang['admin_LT'].'
    </div>
  </div>
</div>';
    
echo '<div class="row">';

$act = isset($_GET['act']) ? trim($_GET['act']) : '';
switch($act) {

  case 'delete':

    // Remove other Administrator
    if(isset($_GET['id']) && !empty($_GET['id'])) {

      $id = intval($_GET['id']);
      $q = $intbyte->query("SELECT * FROM users WHERE id = ".$id."");
      if($q->num_rows > 0) {

        if($intbyte->query("UPDATE users SET rights = '2' WHERE id = ".$id."")) {

          // Successfully updated the Administrator
          $core->redirect(base_url().'/admin/manage-administrator/');
        } else {

          // Failed updated the Administrator
          $core->redirect(base_url().'/admin/manage-administrator/');
        }
      } else {

        // Illegal access
        $core->redirect(base_url().'/admin/manage-administrator/');
      }
    }
  break;

  default:

    // List of Administrator
    echo '<div class="col-12">
      <div class="card card-primary">
        <div class="card-header">
          <h4>
            '.$lang['admin_AL'].'
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
                  '.$lang['admin_USERNAME'].'
                </center>
              </th>
              <th class="align-middle">
                <center>
                  '.$lang['admin_EMAIL'].'
                </center>
              </th>
              <th class="align-middle">
                <center>
                  '.$lang['admin_REGISTERED'].'
                </center>
              </th>
              <th class="align-middle">
                <center>
                  '.$lang['admin_LEVEL'].'
                </center>
              </th>
              <th class="align-middle">
                <center>
                  '.$lang['admin_STATUS'].'
                </center>
              </th>
              <th class="align-middle">
                <center>
                  '.$lang['admin_ACTION'].'
                </center>
              </th>
            </tr>';

    $q = $intbyte->query("SELECT * FROM users WHERE rights = '1' AND status = '1' ORDER BY `id` DESC LIMIT ".$start.", ".$core->set('paging')."");
    $all = $intbyte->query("SELECT * FROM users WHERE rights = '1' AND status = '1'")->num_rows;
    if($q->num_rows > 0) {

      $no = 1;
      while($admin = $q->fetch_assoc()) {

        // List of Administrator
        echo '<tr>
          <td class="align-middle">
            <center>
              '.$no.'
            </center>
          </td>
          <td class="align-middle">
            <img alt="image" src="'.base_url().'/'.$core->show_avatar($admin['id']).'" data-toggle="tooltip" title="'.$admin['fullname'].'" class="rounded-circle" width="35">
            '.$admin['username'].'
          </td>
          <td class="align-middle">
            '.$admin['email'].'
          </td>
          <td>
            '.$time->timeAgo($admin['time']).'
          </td>
          <td class="align-middle">
            '.$core->level($admin['rights']).'
          </td>
          <td class="align-middle">
            '.$core->status($admin['status']).'
          </td>
          <td class="align-middle">
            <center>
              <a id="trash-'.$admin['id'].'" class="btn btn-danger btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['admin_BDWN_DELETE'].'" href="javascript: void(0);">
                <i class="fas fa-trash"></i>
              </a>
              <a id="see_profile-'.$admin['id'].'" class="btn btn-primary btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['admin_BDWN_SEE'].'" href="javascript: void(0);">
                <i class="fas fa-eye"></i>
              </a>
            </center>
          </td>
        </tr>';

        // Trash or Delete
        echo "<script>
          $(document).ready(function() {

            // Delete admin
            $('#trash-".$admin['id']."').on('click', function() {
              swal({
                title: '".$lang['admin_AYS']."',
                text: '".$lang['admin_AYS_CONFIRM']." ".$core->username($admin['id'])."?',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
              }).then((willDelete) => {
                if(willDelete) {
                  swal('".$lang['admin_AYS_SUCCESS']."', {
                    title: 'SUCCESS!',
                    icon: 'success',
                    buttons: false,
                    timer: 3000,
                  }).then(function() {
                    window.location = '".base_url()."/admin/manage-administrator/?act=delete&id=".$admin['id']."';
                  });
                } else {
                  swal('".$lang['admin_AYS_CANCEL']."');
                }
              });
            });

            // See profile
            $('#see_profile-".$admin['id']."').on('click', function() {
              swal('Loading...', {
                icon: 'success',
                buttons: false,
                timer: 3000,
              }).then(function() {
                window.location = '".base_url()."/user/".$core->username($admin['id'])."/';
              });
            });

            // Main admin
            $('#trash-1').on('click', function() {
              swal('".$lang['admin_CNTD1']."', {
                title: 'ACCESS DENIED!',
                icon: 'error',
                buttons: false,
                timer: 3000,
              });
            });

          });
        </script>";

        // Do not remove this line because it is important
        $admin++;
        $no++;
      }

      // Pagination
      echo '</table>
          </div>
        </div>
        <div class="card-footer text-right">
          '.$paging->showPage($all, $page, $core->set('paging'), base_url().'/admin/manage-administrator/?').'
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
      </div>';
    }
  break;
}

echo '</div>';
echo '</section>';
require_once '../incfiles/footer.php';
?>
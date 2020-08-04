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

  case 'approved':

    // Action to approve
    if(isset($_GET['id']) && !empty($_GET['id'])) {

      $id = intval($_GET['id']);
      if($intbyte->query("UPDATE ads SET status = 'A' WHERE id = ".$id."")) {

        // Successfully updated the user ads
        $core->redirect(base_url().'/admin/manage-ads/?view=ads&type=approved');
      } else {

        // Failed updated the user ads
        $core->redirect(base_url().'/admin/manage-ads/');
      }
    } else {

      // Illegal access
      $core->redirect(base_url().'/admin/manage-ads/');
    }
  break;

  case 'rejected':

    // Action to reject
    if(isset($_GET['id']) && !empty($_GET['id'])) {

      $id = intval($_GET['id']);
      if($intbyte->query("UPDATE ads SET status = 'R' WHERE id = ".$id."")) {

        // Successfully updated the user ads
        $core->redirect(base_url().'/admin/manage-ads/?view=ads&type=rejected');
      } else {

        // Failed updated the user ads
        $core->redirect(base_url().'/admin/manage-ads/');
      }
    } else {

      // Illegal access
      $core->redirect(base_url().'/admin/manage-ads/');
    }
  break;

  case 'blocked':

    // Action to block
    if(isset($_GET['id']) && !empty($_GET['id'])) {

      $id = intval($_GET['id']);
      if($intbyte->query("UPDATE ads SET status = 'B' WHERE id = ".$id."")) {

        // Successfully updated the user ads
        $core->redirect(base_url().'/admin/manage-ads/?view=ads&type=blocked');
      } else {

        // Failed updated the user ads
        $core->redirect(base_url().'/admin/manage-ads/');
      }
    } else {

      // Illegal access
      $core->redirect(base_url().'/admin/manage-ads/');
    }
  break;

  case 'deleted':

    // Action to delete
    if(isset($_GET['id']) && !empty($_GET['id'])) {

      $id = intval($_GET['id']);
      if($intbyte->query("UPDATE ads SET status = 'D' WHERE id = ".$id."")) {

        // Successfully updated the user ads
        $core->redirect(base_url().'/admin/manage-ads/?view=ads&type=deleted');
      } else {

        // Failed updated the user ads
        $core->redirect(base_url().'/admin/manage-ads/');
      }
    } else {

      // Illegal access
      $core->redirect(base_url().'/admin/manage-ads/');
    }
  break;

  case 'drop':

    // Drop all the user ads
    if(isset($_GET['do']) && !empty($_GET['do'])) {
      if(urlencode($_GET['do']) == 'action') {

        $q = $intbyte->query("SELECT * FROM ads WHERE status = 'D'");
        if($q->num_rows > 0) {

          // Execute
          $d = $intbyte->query("DELETE FROM ads WHERE status = 'D'");
          if($d) {

            // Successfully updated the user ads
            $core->redirect(base_url().'/admin/manage-ads/?view=ads&type=deleted');
          } else {

            // Failed updated the user ads
            $core->redirect(base_url().'/admin/manage-ads/?view=ads&type=deleted');
          }
        } else {

          // Data not available
          $core->redirect(base_url().'/admin/manage-ads/?view=ads&type=deleted');
        }
      } else {

        // Illegal access
        $core->redirect(base_url().'/admin/manage-ads/?view=ads&type=deleted');
      }
    } else {

      // Illegal access
      $core->redirect(base_url().'/admin/manage-ads/?view=ads&type=deleted');
    }
  break;

  case 'ads':

    // Manage User Ads: Approved, rejected, blocked, deleted and wait to aprove
    if(isset($_GET['type'])) {
      if(urlencode($_GET['type']) == 'approved') {

        // Approved Ads
        // Headers
        $title = $lang['userAds_APPROVE'];
        require_once '../incfiles/header.php';
    
        // If not an Administrator, the system will be redirect to the index page or home page
        if(!$session->is_login() || $session-> is_rights() > 1) {
          $core->redirect(base_url().'/');
        }

        // Section approved ads
        echo '<section class="section">';

        echo '<div class="section-header">
          <h1 class="section-title">
            '.$lang['userAds_APPROVE'].'
          </h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="'.base_url().'/admin/">
                Dashboard
              </a>
            </div>
            <div class="breadcrumb-item">
              '.$lang['userAds_APPROVE'].'
            </div>
          </div>
        </div>';

        echo '<div class="row">';

        echo '<div class="col-12">
          <div class="card card-primary">
            <div class="card-header">
              <h4>
                '.$lang['userAds_APPROVE'].'
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
                      '.$lang['userAds_CONTENT'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['userAds_ON_DATE'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['userAds_ADS_BY'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['userAds_STATUS'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['userAds_ACTION'].'
                    </center>
                  </th>
                </tr>';
        
        $q = $intbyte->query("SELECT * FROM ads WHERE status = 'A' ORDER BY `id` DESC LIMIT ".$start.", ".$core->set('paging')."");
        $all = $intbyte->query("SELECT * FROM ads WHERE status = 'A'")->num_rows;
        if($q->num_rows > 0) {

          $no = 1;
          while($user_ads = $q->fetch_assoc()) {

            // List of ads
            echo '<tr>
              <td class="align-middle">
                <center>
                  '.$no.'
                </center>
              </td>
              <td class="align-middle">
                '.(strlen($core->filter_output($user_ads['content'], FALSE)) > 50 ? substr($core->filter_output($user_ads['content'], FALSE), 0, 50).'...' : $core->filter_output($user_ads['content'], FALSE)).'
              </td>
              <td class="align-middle">
                '.$time->timeAgo($user_ads['time']).'
              </td>
              <td class="align-middle">
                <img alt="image" src="'.base_url().'/'.$core->show_avatar($user_ads['user_id']).'" class="rounded-circle" width="35">
                '.$core->username($user_ads['user_id']).'
              </td>
              <td class="align-middle">
                '.$core->status_ads($user_ads['status']).'
              </td>
              <td class="align-middle">
                <center>
                  <a id="block-'.$user_ads['id'].'" class="btn btn-warning btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['userAds_BDWN_BLOCK'].'" href="javascript: void(0);">
                    <i class="fas fa-times"></i>
                  </a>
                  <a id="delete-'.$user_ads['id'].'" class="btn btn-danger btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['userAds_BDWN_DELETE'].'" href="javascript: void(0);">
                    <i class="fas fa-trash"></i>
                  </a>
                  <a id="preview-'.$user_ads['id'].'" class="btn btn-primary btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['userAds_BDWN_PREVIEW'].'" href="javascript: void(0);">
                    <i class="fas fa-eye"></i>
                  </a>
                </center>
              </td>
            </tr>';

            // Block, delete, preview
            echo "<script>
              $(document).ready(function() {

                // Block ads
                $('#block-".$user_ads['id']."').on('click', function() {
                  swal({
                    title: '".$lang['userAds_CONFIRM_AYS']."',
                    text: '".$lang['userAds_CONBLOCK_TEXT']."',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                  }).then((willBlock) => {
                    if(willBlock) {
                      swal('".$lang['userAds_CONBLOCK_SUCCESS']."', {
                        title: 'SUCCESS!',
                        icon: 'success',
                        buttons: false,
                        timer: 3000,
                      }).then(function() {
                        window.location = '".base_url()."/admin/manage-ads/?view=blocked&id=".$user_ads['id']."';
                      });
                    } else {
                      swal('".$lang['userAds_CONBLOCK_CANCEL']."', {
                        buttons: false,
                        timer: 3000,
                      });
                    }
                  });
                });

                // Delete ads
                $('#delete-".$user_ads['id']."').on('click', function() {
                  swal({
                    title: '".$lang['userAds_CONFIRM_AYS']."',
                    text: '".$lang['userAds_CONDELETE_TEXT']."',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                  }).then((willDelete) => {
                    if(willDelete) {
                      swal('".$lang['userAds_CONDELETE_SUCCESS']."', {
                        title: 'SUCCESS!',
                        icon: 'success',
                        buttons: false,
                        timer: 3000,
                      }).then(function() {
                        window.location = '".base_url()."/admin/manage-ads/?view=deleted&id=".$user_ads['id']."';
                      });
                    } else {
                      swal('".$lang['userAds_CONDELETE_CANCEL']."', {
                        buttons: false,
                        timer: 3000,
                      });
                    }
                  });
                });

                // Preview ads
                $('#preview-".$user_ads['id']."').on('click', function() {
                  $('#preview-".$user_ads['id']."').fireModal({
                    title: '".$lang['userAds_BDWN_PREVIEW']."',
                    body: '".$core->filter_output($user_ads['content'], TRUE)."',
                    footerClass: 'bg-whitesmoke',
                    buttons: [
                      {
                        text: '".$lang['notify_DONE_BTN']."',
                        class: 'btn btn-danger btn-shadow',
                        handler: function(modal) {
                          if(modal) {
                            window.location = '".base_url()."/admin/manage-ads/?view=ads&type=approved';
                          }
                        }
                      }
                    ],
                    center: true
                  });
                });

              });
            </script>";

            // Do not remove this line because it is important
            $user_ads++;
            $no++;
          }

          // Pagination
          echo '</table>
              </div>
            </div>
            <div class="card-footer text-right">
              '.$paging->showPage($all, $page, $core->set('paging'), base_url().'/admin/manage-ads/?view=ads&type=approved&').'
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
      } elseif(urlencode($_GET['type']) == 'rejected') {

        // Rejected ads
        // Headers
        $title = $lang['userAds_REJECT'];
        require_once '../incfiles/header.php';
    
        // If not an Administrator, the system will be redirect to the index page or home page
        if(!$session->is_login() || $session-> is_rights() > 1) {
          $core->redirect(base_url().'/');
        }

        // Section rejected ads
        echo '<section class="section">';
        
        echo '<div class="section-header">
          <h1 class="section-title">
            '.$lang['userAds_REJECT'].'
          </h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="'.base_url().'/admin/">
                Dashboard
              </a>
            </div>
            <div class="breadcrumb-item">
              '.$lang['userAds_REJECT'].'
            </div>
          </div>
        </div>';
      
        echo '<div class="row">';

        echo '<div class="col-12">
          <div class="card card-primary">
            <div class="card-header">
              <h4>
                '.$lang['userAds_REJECT'].'
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
                      '.$lang['userAds_CONTENT'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['userAds_ON_DATE'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['userAds_ADS_BY'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['userAds_STATUS'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['userAds_ACTION'].'
                    </center>
                  </th>
                </tr>';
        
        $q = $intbyte->query("SELECT * FROM ads WHERE status = 'R' ORDER BY `id` DESC LIMIT ".$start.", ".$core->set('paging')."");
        $all = $intbyte->query("SELECT * FROM ads WHERE status = 'R'")->num_rows;
        if($q->num_rows > 0) {

          $no = 1;
          while($user_ads = $q->fetch_assoc()) {

            // List of ads
            echo '<tr>
              <td class="align-middle">
                <center>
                  '.$no.'
                </center>
              </td>
              <td class="align-middle">
                '.(strlen($core->filter_output($user_ads['content'], FALSE)) > 50 ? substr($core->filter_output($user_ads['content'], FALSE), 0, 50).'...' : $core->filter_output($user_ads['content'], FALSE)).'
              </td>
              <td class="align-middle">
                '.$time->timeAgo($user_ads['time']).'
              </td>
              <td class="align-middle">
                <img alt="image" src="'.base_url().'/'.$core->show_avatar($user_ads['user_id']).'" class="rounded-circle" width="35">
                '.$core->username($user_ads['user_id']).'
              </td>
              <td class="align-middle">
                '.$core->status_ads($user_ads['status']).'
              </td>
              <td class="align-middle">
                <center>
                  <a id="approve-'.$user_ads['id'].'" class="btn btn-success btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['userAds_BDWN_APPROVE'].'" href="javascript: void(0);">
                    <i class="fas fa-check"></i>
                  </a>
                  <a id="block-'.$user_ads['id'].'" class="btn btn-warning btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['userAds_BDWN_BLOCK'].'" href="javascript: void(0);">
                    <i class="fas fa-times"></i>
                  </a>
                  <a id="delete-'.$user_ads['id'].'" class="btn btn-danger btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['userAds_BDWN_DELETE'].'" href="javascript: void(0);">
                    <i class="fas fa-trash"></i>
                  </a>
                  <a id="preview-'.$user_ads['id'].'" class="btn btn-primary btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['userAds_BDWN_PREVIEW'].'" href="javascript: void(0);">
                    <i class="fas fa-eye"></i>
                  </a>
                </center>
              </td>
            </tr>';

            // Approve, block, delete, preview
            echo "<script>
              $(document).ready(function() {

                // Approve ads
                $('#approve-".$user_ads['id']."').on('click', function() {
                  swal({
                    title: '".$lang['userAds_CONFIRM_AYS']."',
                    text: '".$lang['userAds_CONAPPROVE_TEXT']."',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                  }).then((willApprove) => {
                    if(willApprove) {
                      swal('".$lang['userAds_CONAPPROVE_SUCCESS']."', {
                        title: 'SUCCESS!',
                        icon: 'success',
                        buttons: false,
                        timer: 3000,
                      }).then(function() {
                        window.location = '".base_url()."/admin/manage-ads/?view=approved&id=".$user_ads['id']."';
                      });
                    } else {
                      swal('".$lang['userAds_CONAPPROVE_CANCEL']."', {
                        buttons: false,
                        timer: 3000,
                      });
                    }
                  });
                });

                // Block ads
                $('#block-".$user_ads['id']."').on('click', function() {
                  swal({
                    title: '".$lang['userAds_CONFIRM_AYS']."',
                    text: '".$lang['userAds_CONBLOCK_TEXT']."',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                  }).then((willBlock) => {
                    if(willBlock) {
                      swal('".$lang['userAds_CONBLOCK_SUCCESS']."', {
                        title: 'SUCCESS!',
                        icon: 'success',
                        buttons: false,
                        timer: 3000,
                      }).then(function() {
                        window.location = '".base_url()."/admin/manage-ads/?view=blocked&id=".$user_ads['id']."';
                      });
                    } else {
                      swal('".$lang['userAds_CONBLOCK_CANCEL']."', {
                        buttons: false,
                        timer: 3000,
                      });
                    }
                  });
                });

                // Delete ads
                $('#delete-".$user_ads['id']."').on('click', function() {
                  swal({
                    title: '".$lang['userAds_CONFIRM_AYS']."',
                    text: '".$lang['userAds_CONDELETE_TEXT']."',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                  }).then((willDelete) => {
                    if(willDelete) {
                      swal('".$lang['userAds_CONDELETE_SUCCESS']."', {
                        title: 'SUCCESS!',
                        icon: 'success',
                        buttons: false,
                        timer: 3000,
                      }).then(function() {
                        window.location = '".base_url()."/admin/manage-ads/?view=deleted&id=".$user_ads['id']."';
                      });
                    } else {
                      swal('".$lang['userAds_CONDELETE_CANCEL']."', {
                        buttons: false,
                        timer: 3000,
                      });
                    }
                  });
                });

                // Preview ads
                $('#preview-".$user_ads['id']."').on('click', function() {
                  $('#preview-".$user_ads['id']."').fireModal({
                    title: '".$lang['userAds_BDWN_PREVIEW']."',
                    body: '".$core->filter_output($user_ads['content'], TRUE)."',
                    footerClass: 'bg-whitesmoke',
                    buttons: [
                      {
                        text: '".$lang['notify_DONE_BTN']."',
                        class: 'btn btn-danger btn-shadow',
                        handler: function(modal) {
                          if(modal) {
                            window.location = '".base_url()."/admin/manage-ads/?view=ads&type=rejected';
                          }
                        }
                      }
                    ],
                    center: true
                  });
                });

              });
            </script>";

            // Do not remove this line because it is important
            $user_ads++;
            $no++;
          }

          // Pagination
          echo '</table>
              </div>
            </div>
            <div class="card-footer text-right">
              '.$paging->showPage($all, $page, $core->set('paging'), base_url().'/admin/manage-ads/?view=ads&type=rejected&').'
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

        // Blocked ads
        // Headers
        $title = $lang['userAds_BLOCK'];
        require_once '../incfiles/header.php';
    
        // If not an Administrator, the system will be redirect to the index page or home page
        if(!$session->is_login() || $session-> is_rights() > 1) {
          $core->redirect(base_url());
        }

        // Section blocked ads
        echo '<section class="section">';
        
        echo '<div class="section-header">
          <h1 class="section-title">
            '.$lang['userAds_BLOCK'].'
          </h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="'.base_url().'/admin/">
                Dashboard
              </a>
            </div>
            <div class="breadcrumb-item">
              '.$lang['userAds_BLOCK'].'
            </div>
          </div>
        </div>';
      
        echo '<div class="row">';

        echo '<div class="col-12">
          <div class="card card-primary">
            <div class="card-header">
              <h4>
                '.$lang['userAds_BLOCK'].'
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
                      '.$lang['userAds_CONTENT'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['userAds_ON_DATE'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['userAds_ADS_BY'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['userAds_STATUS'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['userAds_ACTION'].'
                    </center>
                  </th>
                </tr>';
        
        $q = $intbyte->query("SELECT * FROM ads WHERE status = 'B' ORDER BY `id` DESC LIMIT ".$start.", ".$core->set('paging')."");
        $all = $intbyte->query("SELECT * FROM ads WHERE status = 'B'")->num_rows;
        if($q->num_rows > 0) {

          $no = 1;
          while($user_ads = $q->fetch_assoc()) {

            // List of ads
            echo '<tr>
              <td class="align-middle">
                <center>
                  '.$no.'
                </center>
              </td>
              <td class="align-middle">
                '.(strlen($core->filter_output($user_ads['content'], FALSE)) > 50 ? substr($core->filter_output($user_ads['content'], FALSE), 0, 50).'...' : $core->filter_output($user_ads['content'], FALSE)).'
              </td>
              <td class="align-middle">
                '.$time->timeAgo($user_ads['time']).'
              </td>
              <td class="align-middle">
                <img alt="image" src="'.base_url().'/'.$core->show_avatar($user_ads['user_id']).'" class="rounded-circle" width="35">
                '.$core->username($user_ads['user_id']).'
              </td>
              <td class="align-middle">
                '.$core->status_ads($user_ads['status']).'
              </td>
              <td class="align-middle">
                <center>
                  <a id="approve-'.$user_ads['id'].'" class="btn btn-success btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['userAds_BDWN_APPROVE'].'" href="javascript: void(0);">
                    <i class="fas fa-check"></i>
                  </a>
                  <a id="delete-'.$user_ads['id'].'" class="btn btn-danger btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['userAds_BDWN_DELETE'].'" href="javascript: void(0);">
                    <i class="fas fa-trash"></i>
                  </a>
                  <a id="preview-'.$user_ads['id'].'" class="btn btn-primary btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['userAds_BDWN_PREVIEW'].'" href="javascript: void(0);">
                    <i class="fas fa-eye"></i>
                  </a>
                </center>
              </td>
            </tr>';

            // Approve, block, delete, preview
            echo "<script>
              $(document).ready(function() {

                // Approve ads
                $('#approve-".$user_ads['id']."').on('click', function() {
                  swal({
                    title: '".$lang['userAds_CONFIRM_AYS']."',
                    text: '".$lang['userAds_CONAPPROVE_TEXT']."',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                  }).then((willApprove) => {
                    if(willApprove) {
                      swal('".$lang['userAds_CONAPPROVE_SUCCESS']."', {
                        title: 'SUCCESS!',
                        icon: 'success',
                        buttons: false,
                        timer: 3000,
                      }).then(function() {
                        window.location = '".base_url()."/admin/manage-ads/?view=approved&id=".$user_ads['id']."';
                      });
                    } else {
                      swal('".$lang['userAds_CONAPPROVE_CANCEL']."', {
                        buttons: false,
                        timer: 3000,
                      });
                    }
                  });
                });

                // Delete ads
                $('#delete-".$user_ads['id']."').on('click', function() {
                  swal({
                    title: '".$lang['userAds_CONFIRM_AYS']."',
                    text: '".$lang['userAds_CONDELETE_TEXT']."',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                  }).then((willDelete) => {
                    if(willDelete) {
                      swal('".$lang['userAds_CONDELETE_SUCCESS']."', {
                        title: 'SUCCESS!',
                        icon: 'success',
                        buttons: false,
                        timer: 3000,
                      }).then(function() {
                        window.location = '".base_url()."/admin/manage-ads/?view=deleted&id=".$user_ads['id']."';
                      });
                    } else {
                      swal('".$lang['userAds_CONDELETE_CANCEL']."', {
                        buttons: false,
                        timer: 3000,
                      });
                    }
                  });
                });

                // Preview ads
                $('#preview-".$user_ads['id']."').on('click', function() {
                  $('#preview-".$user_ads['id']."').fireModal({
                    title: '".$lang['userAds_BDWN_PREVIEW']."',
                    body: '".$core->filter_output($user_ads['content'], TRUE)."',
                    footerClass: 'bg-whitesmoke',
                    buttons: [
                      {
                        text: '".$lang['notify_DONE_BTN']."',
                        class: 'btn btn-danger btn-shadow',
                        handler: function(modal) {
                          if(modal) {
                            window.location = '".base_url()."/admin/manage-ads/?view=ads&type=blocked';
                          }
                        }
                      }
                    ],
                    center: true
                  });
                });

              });
            </script>";

            // Do not remove this line because it is important
            $user_ads++;
            $no++;
          }

          // Pagination
          echo '</table>
              </div>
            </div>
            <div class="card-footer text-right">
              '.$paging->showPage($all, $page, $core->set('paging'), base_url().'/admin/manage-ads/?view=ads&type=blocked&').'
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
      } elseif(urlencode($_GET['type']) == 'deleted') {

        // Deleted ads
        // Headers
        $title = $lang['userAds_DELETE'];
        require_once '../incfiles/header.php';
    
        // If not an Administrator, the system will be redirect to the index page or home page
        if(!$session->is_login() || $session-> is_rights() > 1) {
          $core->redirect(base_url().'/');
        }

        // Section deleted ads
        echo '<section class="section">';
        
        echo '<div class="section-header">
          <h1 class="section-title">
            '.$lang['userAds_DELETE'].'
          </h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="'.base_url().'/admin/">
                Dashboard
              </a>
            </div>
            <div class="breadcrumb-item">
            '.$lang['userAds_DELETE'].'
            </div>
          </div>
        </div>';
      
        echo '<div class="row">';

        echo '<div class="col-12">
          <div class="card card-primary">
            <div class="card-header">
              <h4>
                '.$lang['userAds_DELETE'].'
              </h4>
              <div class="card-header-action">
                <a id="drop" href="javascript: void(0);" class="btn btn-primary btn-icon icon-right" data-toggle="tooltip" title="'.$lang['notify_DROP_ALL'].'">
                  <i class="fas fa-trash"></i>
                  '.$lang['notify_DROP_ALL'].'
                </a>
              </div>
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
                      '.$lang['userAds_CONTENT'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['userAds_ON_DATE'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['userAds_ADS_BY'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['userAds_STATUS'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['userAds_ACTION'].'
                    </center>
                  </th>
                </tr>';
        
        $q = $intbyte->query("SELECT * FROM ads WHERE status = 'D' ORDER BY `id` DESC LIMIT ".$start.", ".$core->set('paging')."");
        $all = $intbyte->query("SELECT * FROM ads WHERE status = 'D'")->num_rows;
        if($q->num_rows > 0) {

          $no = 1;
          while($user_ads = $q->fetch_assoc()) {

            // List of ads
            echo '<tr>
              <td class="align-middle">
                <center>
                  '.$no.'
                </center>
              </td>
              <td class="align-middle">
                '.(strlen($core->filter_output($user_ads['content'], FALSE)) > 50 ? substr($core->filter_output($user_ads['content'], FALSE), 0, 50).'...' : $core->filter_output($user_ads['content'], FALSE)).'
              </td>
              <td class="align-middle">
                '.$time->timeAgo($user_ads['time']).'
              </td>
              <td class="align-middle">
                <img alt="image" src="'.base_url().'/'.$core->show_avatar($user_ads['user_id']).'" class="rounded-circle" width="35">
                '.$core->username($user_ads['user_id']).'
              </td>
              <td class="align-middle">
                '.$core->status_ads($user_ads['status']).'
              </td>
              <td class="align-middle">
                <center>
                  <a id="preview-'.$user_ads['id'].'" class="btn btn-primary btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['userAds_BDWN_PREVIEW'].'" href="javascript: void(0);">
                    <i class="fas fa-eye"></i>
                  </a>
                </center>
              </td>
            </tr>';

            // Approve, block, delete, preview
            echo "<script>
              $(document).ready(function() {

                // Preview ads
                $('#preview-".$user_ads['id']."').on('click', function() {
                  $('#preview-".$user_ads['id']."').fireModal({
                    title: '".$lang['userAds_BDWN_PREVIEW']."',
                    body: '".$core->filter_output($user_ads['content'], TRUE)."',
                    footerClass: 'bg-whitesmoke',
                    buttons: [
                      {
                        text: '".$lang['notify_DONE_BTN']."',
                        class: 'btn btn-danger btn-shadow',
                        handler: function(modal) {
                          if(modal) {
                            window.location = '".base_url()."/admin/manage-ads/?view=ads&type=deleted';
                          }
                        }
                      }
                    ],
                    center: true
                  });
                });

                // Drop all
                $('#drop').on('click', function() {
                  swal({
                    title: '".$lang['notify_NEW_CONFIRM_AYS']."',
                    text: '".$lang['userAds_CONDROP_TEXT']."',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                  }).then((willDrop) => {
                    if(willDrop) {
                      swal('".$lang['userAds_CONDROP_SUCCESS']."', {
                        title: 'SUCCESS!',
                        icon: 'success',
                        buttons: false,
                        timer: 3000,
                      }).then(function() {
                        window.location = '".base_url()."/admin/manage-ads/?view=drop&do=action';
                      });
                    } else {
                      swal('".$lang['userAds_CONDROP_CANCEL']."', {
                        buttons: false,
                        timer: 3000,
                      });
                    }
                  });
                });

              });
            </script>";

            // Do not remove this line because it is important
            $user_ads++;
            $no++;
          }

          // Pagination
          echo '</table>
              </div>
            </div>
            <div class="card-footer text-right">
              '.$paging->showPage($all, $page, $core->set('paging'), base_url().'/admin/manage-ads/?view=ads&type=deleted&').'
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
      } elseif(urlencode($_GET['type']) == 'wait_to_approve') {

        // Wait to approve
        // Headers
        $title = $lang['userAds_WTA'];
        require_once '../incfiles/header.php';
    
        // If not an Administrator, the system will be redirect to the index page or home page
        if(!$session->is_login() || $session-> is_rights() > 1) {
          $core->redirect(base_url().'/');
        }

        // Section wait to approve
        echo '<section class="section">';
        
        echo '<div class="section-header">
          <h1 class="section-title">
            '.$lang['userAds_WTA'].'
          </h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="'.base_url().'/admin/">
                Dashboard
              </a>
            </div>
            <div class="breadcrumb-item">
              '.$lang['userAds_WTA'].'
            </div>
          </div>
        </div>';
      
        echo '<div class="row">';

        echo '<div class="col-12">
          <div class="card card-primary">
            <div class="card-header">
              <h4>
                '.$lang['userAds_WTA'].'
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
                      '.$lang['userAds_CONTENT'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['userAds_ON_DATE'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['userAds_ADS_BY'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['userAds_STATUS'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['userAds_ACTION'].'
                    </center>
                  </th>
                </tr>';
        
        $q = $intbyte->query("SELECT * FROM ads WHERE status = 'W' ORDER BY `id` DESC LIMIT ".$start.", ".$core->set('paging')."");
        $all = $intbyte->query("SELECT * FROM ads WHERE status = 'W'")->num_rows;
        if($q->num_rows > 0) {

          $no = 1;
          while($user_ads = $q->fetch_assoc()) {

            // List of ads
            echo '<tr>
              <td class="align-middle">
                <center>
                  '.$no.'
                </center>
              </td>
              <td class="align-middle">
                '.(strlen($core->filter_output($user_ads['content'], FALSE)) > 50 ? substr($core->filter_output($user_ads['content'], FALSE), 0, 50).'...' : $core->filter_output($user_ads['content'], FALSE)).'
              </td>
              <td class="align-middle">
                '.$time->timeAgo($user_ads['time']).'
              </td>
              <td class="align-middle">
                <img alt="image" src="'.base_url().'/'.$core->show_avatar($user_ads['user_id']).'" class="rounded-circle" width="35">
                '.$core->username($user_ads['user_id']).'
              </td>
              <td class="align-middle">
                '.$core->status_ads($user_ads['status']).'
              </td>
              <td class="align-middle">
                <center>
                  <a id="approve-'.$user_ads['id'].'" class="btn btn-success btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['userAds_BDWN_APPROVE'].'" href="javascript: void(0);">
                    <i class="fas fa-check"></i>
                  </a>
                  <a id="block-'.$user_ads['id'].'" class="btn btn-warning btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['userAds_BDWN_BLOCK'].'" href="javascript: void(0);">
                    <i class="fas fa-times"></i>
                  </a>
                  <a id="reject-'.$user_ads['id'].'" class="btn btn-default btn-sm btn-icon icon-center" style="background: #BFBFBF;color: #FFFFFF;" data-toggle="tooltip" title="'.$lang['userAds_BDWN_REJECT'].'" href="javascript: void(0);">
                    <i class="fas fa-eye-slash"></i>
                  </a>
                  <a id="delete-'.$user_ads['id'].'" class="btn btn-danger btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['userAds_BDWN_DELETE'].'" href="javascript: void(0);">
                    <i class="fas fa-trash"></i>
                  </a>
                  <a id="preview-'.$user_ads['id'].'" class="btn btn-primary btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['userAds_BDWN_PREVIEW'].'" href="javascript: void(0);">
                    <i class="fas fa-eye"></i>
                  </a>
                </center>
              </td>
            </tr>';

            // Approve, block, delete, preview
            echo "<script>
              $(document).ready(function() {

                // Approve ads
                $('#approve-".$user_ads['id']."').on('click', function() {
                  swal({
                    title: '".$lang['userAds_CONFIRM_AYS']."',
                    text: '".$lang['userAds_CONAPPROVE_TEXT']."',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                  }).then((willApprove) => {
                    if(willApprove) {
                      swal('".$lang['userAds_CONAPPROVE_SUCCESS']."', {
                        title: 'SUCCESS!',
                        icon: 'success',
                        buttons: false,
                        timer: 3000,
                      }).then(function() {
                        window.location = '".base_url()."/admin/manage-ads/?view=approved&id=".$user_ads['id']."';
                      });
                    } else {
                      swal('".$lang['userAds_CONAPPROVE_CANCEL']."', {
                        buttons: false,
                        timer: 3000,
                      });
                    }
                  });
                });

                // Block ads
                $('#block-".$user_ads['id']."').on('click', function() {
                  swal({
                    title: '".$lang['userAds_CONFIRM_AYS']."',
                    text: '".$lang['userAds_CONBLOCK_TEXT']."',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                  }).then((willBlock) => {
                    if(willBlock) {
                      swal('".$lang['userAds_CONBLOCK_SUCCESS']."', {
                        title: 'SUCCESS!',
                        icon: 'success',
                        buttons: false,
                        timer: 3000,
                      }).then(function() {
                        window.location = '".base_url()."/admin/manage-ads/?view=blocked&id=".$user_ads['id']."';
                      });
                    } else {
                      swal('".$lang['userAds_CONBLOCK_CANCEL']."', {
                        buttons: false,
                        timer: 3000,
                      });
                    }
                  });
                });

                // Reject ads
                $('#reject-".$user_ads['id']."').on('click', function() {
                  swal({
                    title: '".$lang['userAds_CONFIRM_AYS']."',
                    text: '".$lang['userAds_CONREJECT_TEXT']."',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                  }).then((willReject) => {
                    if(willReject) {
                      swal('".$lang['userAds_CONREJECT_SUCCESS']."', {
                        title: 'SUCCESS!',
                        icon: 'success',
                        buttons: false,
                        timer: 3000,
                      }).then(function() {
                        window.location = '".base_url()."/admin/manage-ads/?view=rejected&id=".$user_ads['id']."';
                      });
                    } else {
                      swal('".$lang['userAds_CONREJECT_CANCEL']."', {
                        buttons: false,
                        timer: 3000,
                      });
                    }
                  });
                });

                // Delete ads
                $('#delete-".$user_ads['id']."').on('click', function() {
                  swal({
                    title: '".$lang['userAds_CONDELETE_AYS']."',
                    text: '".$lang['userAds_CONDELETE_TEXT']."',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                  }).then((willDelete) => {
                    if(willDelete) {
                      swal('".$lang['userAds_CONDELETE_SUCCESS']."', {
                        title: 'SUCCESS!',
                        icon: 'success',
                        buttons: false,
                        timer: 3000,
                      }).then(function() {
                        window.location = '".base_url()."/admin/manage-ads/?view=deleted&id=".$user_ads['id']."';
                      });
                    } else {
                      swal('".$lang['userAds_CONDELETE_CANCEL']."', {
                        buttons: false,
                        timer: 3000,
                      });
                    }
                  });
                });

                // Preview ads
                $('#preview-".$user_ads['id']."').on('click', function() {
                  $('#preview-".$user_ads['id']."').fireModal({
                    title: '".$lang['userAds_BDWN_PREVIEW']."',
                    body: '".$core->filter_output($user_ads['content'], TRUE)."',
                    footerClass: 'bg-whitesmoke',
                    buttons: [
                      {
                        text: '".$lang['notify_DONE_BTN']."',
                        class: 'btn btn-danger btn-shadow',
                        handler: function(modal) {
                          if(modal) {
                            window.location = '".base_url()."/admin/manage-ads/?view=ads&type=wait_to_approve';
                          }
                        }
                      }
                    ],
                    center: true
                  });
                });
                
              });
            </script>";

            // Do not remove this line because it is important
            $user_ads++;
            $no++;
          }

          // Pagination
          echo '</table>
              </div>
            </div>
            <div class="card-footer text-right">
              '.$paging->showPage($all, $page, $core->set('paging'), base_url().'/admin/manage-ads/?view=ads&type=wait_to_approve&').'
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
        $core->redirect(base_url().'/admin/manage-ads/');
      }
    } else {

      // Illegal access
      $core->redirect(base_url().'/admin/manage-ads/');
    }
  break;

  default:
  
    // Illegal Access
    // If there is access to this page then the system will direct to the main page Administrator
    $core->redirect(base_url().'/admin/');
  break;
}
?>
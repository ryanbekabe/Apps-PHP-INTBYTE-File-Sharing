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

  case 'delete':

    // Action to delete
    if(isset($_GET['id']) && !empty($_GET['id'])) {

      $id = intval($_GET['id']);
      $q = $intbyte->query("SELECT * FROM files WHERE id = ".$id."");
      if($q->num_rows > 0) {

        // Execute
        $delete = $q->fetch_assoc();
        $fileSize = $delete['size'];

        // Check the file in the /data/username/
        if(unlink('../data/'.$core->username($delete['user_id']).'/'.$delete['name'].'')) {

          // Update storage and files
          $u = $intbyte->query("UPDATE users SET storage = storage-".$fileSize.", files = files-1 WHERE id = ".$delete['user_id']."");
          $d = $intbyte->query("DELETE FROM files WHERE id = ".$id."");

          if($u || $d) {

            // Successfully deleted the files
            $core->redirect(base_url().'/admin/manage-files/?view=files&type=latest');
          } else {

            // Failed deleted the files
            $core->redirect(base_url().'/admin/manage-files/?view=files&type=latest');
          }
        } else {

          // Data not available
          $core->redirect(base_url().'/admin/manage-files/');
        }
      } else {

        // Data not available
        $core->redirect(base_url().'/admin/manage-files/?view=files&type=latest');
      }
    } else {

      // Illegal access
      $core->redirect(base_url().'/admin/manage-files/');
    }
  break;

  case 'files':

    // Manage Files: Latest upload, popular download, reported files
    if(isset($_GET['type'])) {
      if(urlencode($_GET['type']) == 'latest') {

        // Latest upload
        // Headers
        $title = $lang['userFile_LATEST_UPLOAD'];
        require_once '../incfiles/header.php';

        // If not an Administrator, the system will be redirect to the index page or home page
        if(!$session->is_login() || $session-> is_rights() > 1) {
          $core->redirect(base_url().'/');
        }

        // Section latest upload
        echo '<section class="section">';

        echo '<div class="section-header">
          <h1 class="section-title">
            '.$lang['userFile_LATEST_UPLOAD'].'
          </h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="'.base_url().'/admin/">
                Dashboard
              </a>
            </div>
            <div class="breadcrumb-item">
              '.$lang['userFile_LATEST_UPLOAD'].'
            </div>
          </div>
        </div>';

        echo '<div class="row">';

        echo '<div class="col-12">
          <div class="card card-primary">
            <div class="card-header">
              <h4>
                '.$lang['userFile_LATEST_UPLOAD'].'
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
                      '.$lang['userFile_NAME'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['userFile_FOLDER'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['userFile_SIZE'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['userFile_TIME'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['userFile_DOWNLOADED'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['userFile_UPLOADED_BY'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['userFile_ACTION'].'
                    </center>
                  </th>
                </tr>';
        
        $q = $intbyte->query("SELECT * FROM files ORDER BY `id` DESC LIMIT ".$start.", ".$core->set('paging')."");
        $all = $intbyte->query("SELECT * FROM files")->num_rows;
        if($q->num_rows > 0) {

          $no = 1;
          while($file = $q->fetch_assoc()) {

            // List of files
            echo '<tr>
              <td class="align-middle">
                <center>
                  '.$no.'
                </center>
              </td>
              <td class="align-middle">
                '.(strlen($core->filter_output($file['name'], FALSE)) > 50 ? substr($core->filter_output($file['name'], FALSE), 0, 50).'...' : $core->filter_output($file['name'], FALSE)).'
              </td>
              <td class="align-middle">
                <div class="badge badge-danger" data-toggle="tooltip" title="'.$lang['userFile_FOLDER_T'].' '.$core->getFolder($file['folder']).'.">
                  '.$core->getFolder($file['folder']).'
                </div>
              </td>
              <td class="align-middle">
                '.$core->size($file['size']).'
              </td>
              <td class="align-middle">
                '.$time->timeAgo($file['time']).'
              </td>
              <td class="align-middle">
                '.number_format($file['downloaded'], 0, ',', '.').'x
              </td>
              <td class="align-middle">
                <img alt="image" src="'.base_url().'/'.$core->show_avatar($file['user_id']).'" data-toggle="tooltip" title="'.$core->username($file['user_id']).'" class="rounded-circle" width="35">
                '.$core->username($file['user_id']).'
              </td>
              <td class="align-middle">
                <center>
                  <a id="delete-'.$file['id'].'" class="btn btn-danger btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['userFile_BDWN_DELETE'].'" href="javascript: void(0);">
                    <i class="fas fa-trash"></i>
                  </a>
                  <a id="see_file-'.$file['id'].'" class="btn btn-primary btn-sm btn-icon icon-center" data-toggle="tooltip" title="                  '.$lang['userFile_BDWN_SEE'].'" href="javascript: void(0);">
                    <i class="fas fa-eye"></i>
                  </a>
                </center>
              </td>
            </tr>';

            // Delete files, see files
            echo "<script>
              $(document).ready(function() {

                // Delete files
                $('#delete-".$file['id']."').on('click', function() {
                  swal({
                    title: '".$lang['userFile_CONFIRM_AYS']."',
                    text: '".$lang['userFile_CONDELETE_TEXT']."',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                  }).then((willDelete) => {
                    if(willDelete) {
                      swal('".$lang['userFile_CONDELETE_SUCCESS']."', {
                        icon: 'success',
                        buttons: false,
                        timer: 3000,
                      }).then(function() {
                        window.location = '".base_url()."/admin/manage-files/?view=delete&id=".$file['id']."';
                      });
                    } else {
                      swal('".$lang['userFile_CONDELETE_CANCEL']."', {
                        buttons: false,
                        timer: 3000,
                      });
                    }
                  });
                });

                // See file
                $('#see_file-".$file['id']."').on('click', function() {
                  swal('Loading...', {
                    icon: 'success',
                    buttons: false,
                    timer: 3000,
                  }).then(function() {
                    window.location = '".base_url()."/".$file['token'].".html';
                  });
                });

              });
            </script>";

            // Do not remove this line because it is important
            $file++;
            $no++;
          }

          // Pagination
          echo '</table>
              </div>
            </div>
            <div class="card-footer text-right">
              '.$paging->showPage($all, $page, $core->set('paging'), base_url().'/admin/manage-files/?view=files&type=latest&').'
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
      } elseif(urlencode($_GET['type']) == 'popular') {

        // Popular download
        // Headers
        $title = $lang['userFile_POPULAR_DOWNLOAD'];
        require_once '../incfiles/header.php';
    
        // If not an Administrator, the system will be redirect to the index page or home page
        if(!$session->is_login() || $session-> is_rights() > 1) {
          $core->redirect(base_url().'/');
        }

        // Section popular download
        echo '<section class="section">';

        echo '<div class="section-header">
          <h1 class="section-title">
            '.$lang['userFile_POPULAR_DOWNLOAD'].'
          </h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="'.base_url().'/admin/">
                Dashboard
              </a>
            </div>
            <div class="breadcrumb-item">
              '.$lang['userFile_POPULAR_DOWNLOAD'].'
            </div>
          </div>
        </div>';

        echo '<div class="row">';

        echo '<div class="col-12">
          <div class="card card-primary">
            <div class="card-header">
              <h4>
                '.$lang['userFile_POPULAR_DOWNLOAD'].'
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
                      '.$lang['userFile_NAME'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['userFile_FOLDER'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['userFile_SIZE'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['userFile_TIME'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['userFile_DOWNLOADED'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['userFile_UPLOADED_BY'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['userFile_ACTION'].'
                    </center>
                  </th>
                </tr>';
        
        $q = $intbyte->query("SELECT * FROM files WHERE downloaded >= '1' ORDER BY `id` DESC LIMIT ".$start.", ".$core->set('paging')."");
        $all = $intbyte->query("SELECT * FROM files WHERE downloaded >= '1'")->num_rows;
        if($q->num_rows > 0) {

          $no = 1;
          while($file = $q->fetch_assoc()) {

            // List of files
            echo '<tr>
              <td class="align-middle">
                <center>
                  '.$no.'
                </center>
              </td>
              <td class="align-middle">
                '.(strlen($core->filter_output($file['name'], FALSE)) > 50 ? substr($core->filter_output($file['name'], FALSE), 0, 50).'...' : $core->filter_output($file['name'], FALSE)).'
              </td>
              <td class="align-middle">
                <div class="badge badge-danger" data-toggle="tooltip" title="'.$lang['userFile_FOLDER_T'].' '.$core->getFolder($file['folder']).'.">
                  '.$core->getFolder($file['folder']).'
                </div>
              </td>
              <td class="align-middle">
                '.$core->size($file['size']).'
              </td>
              <td class="align-middle">
                '.$time->timeAgo($file['time']).'
              </td>
              <td class="align-middle">
                '.number_format($file['downloaded'], 0, ',', '.').'x
              </td>
              <td class="align-middle">
                <img alt="image" src="'.base_url().'/'.$core->show_avatar($file['user_id']).'" data-toggle="tooltip" title="'.$core->username($file['user_id']).'" class="rounded-circle" width="35">
                '.$core->username($file['user_id']).'
              </td>
              <td class="align-middle">
                <center>
                  <a id="delete-'.$file['id'].'" class="btn btn-danger btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['userFile_BDWN_DELETE'].'" href="javascript: void(0);">
                    <i class="fas fa-trash"></i>
                  </a>
                  <a id="see_file-'.$file['id'].'" class="btn btn-primary btn-sm btn-icon icon-center" data-toggle="tooltip" title="                  '.$lang['userFile_BDWN_SEE'].'" href="javascript: void(0);">
                    <i class="fas fa-eye"></i>
                  </a>
                </center>
              </td>
            </tr>';

            // Delete files, see files
            echo "<script>
              $(document).ready(function() {

                // Delete files
                $('#delete-".$file['id']."').on('click', function() {
                  swal({
                    title: '".$lang['userFile_CONFIRM_AYS']."',
                    text: '".$lang['userFile_CONDELETE_TEXT']."',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                  }).then((willDelete) => {
                    if(willDelete) {
                      swal('".$lang['userFile_CONDELETE_SUCCESS']."', {
                        icon: 'success',
                        buttons: false,
                        timer: 3000,
                      }).then(function() {
                        window.location = '".base_url()."/admin/manage-files/?view=delete&id=".$file['id']."';
                      });
                    } else {
                      swal('".$lang['userFile_CONDELETE_CANCEL']."', {
                        buttons: false,
                        timer: 3000,
                      });
                    }
                  });
                });

                // See files
                $('#see_file-".$file['id']."').on('click', function() {
                  swal('Loading...', {
                    icon: 'success',
                    buttons: false,
                    timer: 3000,
                  }).then(function() {
                    window.location = '".base_url()."/".$file['token'].".html';
                  });
                });

              });
            </script>";

            // Do not remove this line because it is important
            $file++;
            $no++;
          }

          // Pagination
          echo '</table>
              </div>
            </div>
            <div class="card-footer text-right">
              '.$paging->showPage($all, $page, $core->set('paging'), base_url().'/admin/manage-files/?view=files&type=popular&').'
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
      } elseif(urlencode($_GET['type']) == 'reported') {

        // Reported files
        // Headers
        $title = $lang['userFile_REPORTED'];
        require_once '../incfiles/header.php';
    
        // If not an Administrator, the system will be redirect to the index page or home page
        if(!$session->is_login() || $session-> is_rights() > 1) {
          $core->redirect(base_url().'/');
        }

        // Section reported files
        echo '<section class="section">';

        echo '<div class="section-header">
          <h1 class="section-title">
            '.$lang['userFile_REPORTED'].'
          </h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="'.base_url().'/admin/">
                Dashboard
              </a>
            </div>
            <div class="breadcrumb-item">
              '.$lang['userFile_REPORTED'].'
            </div>
          </div>
        </div>';

        echo '<div class="row">';

        echo '<div class="col-12">
          <div class="card card-primary">
            <div class="card-header">
              <h4>
                '.$lang['userFile_REPORTED'].'
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
                      '.$lang['userFile_NAME'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['userFile_FOLDER'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['userFile_SIZE'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['userFile_TIME'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['userFile_DOWNLOADED'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['userFile_REPORT'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['userFile_UPLOADED_BY'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['userFile_ACTION'].'
                    </center>
                  </th>
                </tr>';
        
        $q = $intbyte->query("SELECT * FROM files WHERE report >= '1' ORDER BY `report` DESC LIMIT ".$start.", ".$core->set('paging')."");
        $all = $intbyte->query("SELECT * FROM files WHERE report >= '1'")->num_rows;
        if($q->num_rows > 0) {

          $no = 1;
          while($file = $q->fetch_assoc()) {

            // List of files
            echo '<tr>
              <td class="align-middle">
                <center>
                  '.$no.'
                </center>
              </td>
              <td class="align-middle">
                '.(strlen($core->filter_output($file['name'], FALSE)) > 50 ? substr($core->filter_output($file['name'], FALSE), 0, 50).'...' : $core->filter_output($file['name'], FALSE)).'
              </td>
              <td class="align-middle">
                <div class="badge badge-danger" data-toggle="tooltip" title="'.$lang['userFile_FOLDER_T'].' '.$core->getFolder($file['folder']).'.">
                  '.$core->getFolder($file['folder']).'
                </div>
              </td>
              <td class="align-middle">
                '.$core->size($file['size']).'
              </td>
              <td class="align-middle">
                '.$time->timeAgo($file['time']).'
              </td>
              <td class="align-middle">
                '.number_format($file['downloaded'], 0, ',', '.').'x
              </td>
              <td class="align-middle">
                '.number_format($file['report'], 0, ',', '.').'x
              </td>
              <td class="align-middle">
                <img alt="image" src="'.base_url().'/'.$core->show_avatar($file['user_id']).'" data-toggle="tooltip" title="'.$core->username($file['user_id']).'" class="rounded-circle" width="35">
                '.$core->username($file['user_id']).'
              </td>
              <td class="align-middle">
                <center>
                  <a id="delete-'.$file['id'].'" class="btn btn-danger btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['userFile_BDWN_DELETE'].'" href="javascript: void(0);">
                    <i class="fas fa-trash"></i>
                  </a>
                  <a id="see_file-'.$file['id'].'" class="btn btn-primary btn-sm btn-icon icon-center" data-toggle="tooltip" title="                  '.$lang['userFile_BDWN_SEE'].'" href="javascript: void(0);">
                    <i class="fas fa-eye"></i>
                  </a>
                </center>
              </td>
            </tr>';

            // Delete files, see files
            echo "<script>
              $(document).ready(function() {

                // Delete files
                $('#delete-".$file['id']."').on('click', function() {
                  swal({
                    title: '".$lang['userFile_CONFIRM_AYS']."',
                    text: '".$lang['userFile_CONDELETE_TEXT']."',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                  }).then((willDelete) => {
                    if(willDelete) {
                      swal('".$lang['userFile_CONDELETE_SUCCESS']."', {
                        icon: 'success',
                        buttons: false,
                        timer: 3000,
                      }).then(function() {
                        window.location = '".base_url()."/admin/manage-files/?view=delete&id=".$file['id']."';
                      });
                    } else {
                      swal('".$lang['userFile_CONDELETE_CANCEL']."', {
                        buttons: false,
                        timer: 3000,
                      });
                    }
                  });
                });

                // See files
                $('#see_file-".$file['id']."').on('click', function() {
                  swal('Loading...', {
                    icon: 'success',
                    buttons: false,
                    timer: 3000,
                  }).then(function() {
                    window.location = '".base_url()."/".$file['token'].".html';
                  });
                });

              });
            </script>";

            // Do not remove this line because it is important
            $file++;
            $no++;
          }

          // Pagination
          echo '</table>
              </div>
            </div>
            <div class="card-footer text-right">
              '.$paging->showPage($all, $page, $core->set('paging'), base_url().'/admin/manage-files/?view=files&type=reported&').'
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
        $core->redirect(base_url().'/admin/manage-files/');
      }
    } else {

      // Illegal access
      $core->redirect(base_url().'/admin/manage-files/');
    }
  break;

  default:

    // Illegal Access
    // If there is access to this page then the system will direct to the main page Administrator
    $core->redirect(base_url().'/admin/');
  break;
}
?>
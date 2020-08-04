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

  case 'delete':

    // Action to delete
    if(isset($_GET['id']) && !empty($_GET['id'])) {

      $id = intval($_GET['id']);
      $q = $intbyte->query("SELECT * FROM files WHERE user_id = '".$info['id']."' AND id = ".$id."");
      if($q->num_rows > 0) {

        // Execute
        $delete = $q->fetch_assoc();
        $fileSize = $delete['size'];

        // Check the files on path /data/username/
        if(unlink('../data/'.$core->username($delete['user_id']).'/'.$delete['name'].'')) {

          // Update storage, files
          $u = $intbyte->query("UPDATE users SET storage = storage-".$fileSize.", files = files-1 WHERE id = ".$delete['user_id']."");
          $d = $intbyte->query("DELETE FROM files WHERE user_id = '".$info['id']."' AND id = '".$id."'");

          if($u || $d) {

            // Successfully deleted the files
            $core->redirect(base_url().'/user/my-files/?view=files&type=latest');
          } else {

            // Failed deleted the files
            $core->redirect(base_url().'/user/my-files/?view=files&type=latest');
          }
        } else {

          // Failed deleted the files
          $core->redirect(base_url().'/user/my-files/?view=files&type=latest');
        }
      } else {

        // Data not available
        $core->redirect(base_url().'/user/my-files/?view=files&type=latest');
      }
    } else {

      // Illegal access
      $core->redirect(base_url().'/user/my-files/');
    }
  break;

  case 'edit_file':

    // Edit the files
    if(isset($_GET['id']) && !empty($_GET['id'])) {
      
      $id = intval($_GET['id']);
      $q = $intbyte->query("SELECT * FROM files WHERE id = '".$id."' AND user_id = '".$info['id']."'");
      if($q->num_rows > 0) {

        $file = $q->fetch_assoc();

        // Headers
        $title = $lang['folder_EDIT_FILE'].' '.$file['name'];
        require_once '../incfiles/header.php';
        
        // If not an User, the system will be redirect to the index page or home page
        if(!$session->is_login()) {
          $core->redirect(base_url().'/');
        }

        // Section edit the files
        echo '<section class="section">';

        echo '<div class="section-header">
          <h1 class="section-title">
            '.$lang['folder_EDIT_FILE'].'
          </h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="'.base_url().'/user/">
                Dashboard
              </a>
            </div>
            <div class="breadcrumb-item">
              '.$lang['folder_EDIT_FILE'].'
            </div>
          </div>
        </div>';

        echo '<div class="row">';

        if($info['rights'] > 0) {

          // Unblocked users
          if(isset($_POST['submit'])) {

            // The files edit data
            $file_description = $core->filter_input($_POST['description']);
            $file_password = strip_tags($core->filter_input($_POST['password']));
            $file_name = $core->filter_input($_POST['name']);

            if(strlen($file_description) > 5000) {

              // Checking the length of files description
              echo "<script>
                $(document).ready(function() {
                  swal('".$lang['upload_FILE_FD']."', {
                    title: 'WARNING!',
                    icon: 'warning',
                    buttons: false,
                    timer: 3000,
                  });
                });
              </script>";
            } else {

              // Execute rename the files and update the files
              $u = $intbyte->query("UPDATE files SET name = '".$file_name."', description = '".$file_description."', password = '".(!empty($file_password) ? password_hash($file_password, PASSWORD_DEFAULT) : $file['password'])."' WHERE id = '".$file['id']."' AND user_id = '".$info['id']."'");
              if(rename('../data/'.$core->username($info['id']).'/'.$file['name'].'', '../data/'.$core->username($info['id']).'/'.$file_name.'')) {
                if($u) {
                
                  // Successfully edited the files
                  echo "<script>
                    $(document).ready(function() {
                      swal('".$lang['folder_EDIT_FILE_SS']."', {
                        title: 'SUCCESS!',
                        icon: 'success',
                        buttons: false,
                        timer: 3000,
                      }).then(function() {
                        window.location = '".base_url()."/user/folder/?view=edit_file&id=".$file['id']."';
                      });
                    });
                  </script>";
                } else {
  
                  // Failed edited the files
                  echo "<script>
                    $(document).ready(function() {
                      swal('".$lang['folder_EDIT_FILE_F']."', {
                        title: 'WARNING!',
                        icon: 'warning',
                        buttons: false,
                        timer: 3000,
                      }).then(function() {
                        window.location = '".base_url()."/user/folder/?view=edit_file&id=".$file['id']."';
                      });
                    });
                  </script>";
                }
              }
            }
          }

          // HTML form
          echo '<div class="col-md-12">
            <form method="POST" class="needs-validation" novalidate="">
              <div class="card card-primary">
                <div class="card-header">
                  <h4>
                    '.$lang['folder_EDIT_FILE'].'
                  </h4>
                </div>
                <div class="card-body">
                  <p class="text-muted">
                    '.$lang['folder_EDIT_FILE_TEXT'].'
                  </p>
                  <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                      <div class="form-group mb-0">
                        <label>
                          '.$lang['folder_EDIT_FILE_NAME'].'
                        </label>
                        <div class="col-sm-6 col-md-12">
                          <input type="text" name="name" value="'.$file['name'].'" class="form-control" required="">
                          <div class="invalid-feedback">
                            '.$lang['folder_EDIT_FILE_IF'].'
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                      <div class="form-group mb-0">
                        <label>
                          '.$lang['folder_EDIT_FILE_PASSWORD'].'
                        </label>
                        <div class="col-sm-6 col-md-12">
                          <input type="password" name="password" value="" class="form-control">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 col-md-6 col-lg-12">
                      <div class="form-group mb-0">
                        <label>
                          '.$lang['folder_EDIT_FILE_DESCRIPTION'].'
                        </label>
                        <textarea name="description" class="form-control summernote-simple">'.$file['description'].'</textarea>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer text-right">
                  <button type="reset" name="description" class="btn default">
                    '.$lang['folder_EDIT_FILE_BTNC'].'
                  </button>
                  <button type="submit" name="submit" class="btn btn-primary">
                    '.$lang['folder_EDIT_FILE_BTN'].'
                  </button>
                </div>
              </div>
            </form>
          </div>';
        } else {

          // Blocked user
          $core->redirect(base_url().'/user/');
        }

        echo '</div>';
        echo '</section>';
        require_once '../incfiles/footer.php';
      } else {

        // Data not available
        $core->redirect(base_url().'/user/my-files/?view=files&type=latest');
      }
    } else {

      // Illegal access
      $core->redirect(base_url().'/user/my-files/');
    }
  break;

  case 'move':

    // Action to move
    if(isset($_GET['id']) && !empty($_GET['id'])) {

      $id = intval($_GET['id']);
      $q = $intbyte->query("SELECT * FROM files WHERE id = '".$id."' AND user_id = '".$info['id']."'");
      if($q->num_rows > 0) {

        $file = $q->fetch_assoc();

        // Headers
        $title = $lang['folder_MOVE_FILE'].' '.$file['name'];
        require_once '../incfiles/header.php';

        // If not an User, the system will be redirect to the index page or home page
        if(!$session->is_login()) {
          $core->redirect(base_url().'/');
        }

        // Section move the files
        echo '<section class="section">';

        echo '<div class="section-header">
          <h1 class="section-title">
            '.$lang['folder_MOVE_FILE'].'
          </h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="'.base_url().'/user/">
                Dashboard
              </a>
            </div>
            <div class="breadcrumb-item">
              '.$lang['folder_MOVE_FILE'].'
            </div>
          </div>
        </div>';

        echo '<div class="row">';

        if($info['rights'] > 0) {

          // Unblocked user
          if(isset($_POST['submit'])) {

            // The files move data
            $from_folder = strip_tags($core->filter_input($_POST['from_folder']));
            $to_folder = strip_tags($core->filter_input($_POST['to_folder']));

            if($core->getFolder($from_folder) == $core->getFolder($to_folder)) {

              // If the folder is same
              echo "<script>
                $(document).ready(function() {
                  swal('".$lang['folder_MOVE_SAME']."', {
                    title: 'WARNING!',
                    icon: 'warning',
                    buttons: false,
                    timer: 3000,
                  });
                });
              </script>";
            } else {

              // Execute
              $m = $intbyte->query("UPDATE files SET folder = '".$to_folder."' WHERE id = '".$id."'");
              if($m) {

                // Successfully moved the files
                echo "<script>
                  $(document).ready(function() {
                    swal('".$lang['folder_MOVE_FILE_SS']." ".$core->getFolder($to_folder).".', {
                      title: 'SUCCESS!',
                      icon: 'success',
                      buttons: false,
                      timer: 3000,
                    }).then(function() {
                      window.location = '".base_url()."/user/my-files/?view=move&id=".$file['id']."';
                    });
                  });
                </script>";
              } else {

                // Failed moved dthe files
                echo "<script>
                  $(document).ready(function() {
                    swal('".$lang['folder_MOVE_FILE_F']." ".$core->getFolder($to_folder).".', {
                      title: 'WARNING!',
                      icon: 'warning',
                      buttons: false,
                      timer: 3000,
                    }).then(function() {
                      window.location = '".base_url()."/user/my-files/?view=move&id=".$file['id']."';
                    });
                  });
                </script>";
              }
            }
          }

          // HTML form
          echo '<div class="col-md-12">
            <form method="POST" class="needs-validation" novalidate="">
              <div class="card card-primary">
                <div class="card-header">
                  <h4>
                    '.$lang['folder_EDIT_FILE'].'
                  </h4>
                </div>
                <div class="card-body">
                  <p class="text-muted">
                    '.$lang['folder_MOVE_FILE_TEXT'].' '.number_format($intbyte->query("SELECT * FROM files WHERE folder = '".$file['folder']."' AND user_id = '".$info['id']."'")->num_rows, 0, ',', '.').'.
                  </p>
                  <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                      <div class="form-group mb-0">
                        <label>
                          '.$lang['folder_MOVE_FROM'].'
                        </label>
                        <div class="col-sm-6 col-md-12">
                          <select name="from_folder" class="form-control" required="">
                            <option value="'.$file['folder'].'">
                              '.$core->getFolder($file['folder']).'
                            </option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                      <div class="form-group mb-0">
                        <label>
                          '.$lang['folder_MOVE_TO'].'
                        </label>
                        <div class="col-sm-6 col-md-12">
                          <select name="to_folder" class="form-control select2" required="">';

                          $q = $intbyte->query("SELECT * FROM folders WHERE user_id = '".$info['id']."' ORDER BY `id` DESC");
                          if($q->num_rows > 0) {
                            while($folder = $q->fetch_assoc()) {
    
                              // List of folders
                              echo '<option value="'.$folder['id'].'">
                                '.ucfirst($core->getFolder($folder['id'])).'
                              </option>';

                              // Do not remove this line because it is important
                              $folder++;
                            }
                          }

                          echo '</select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer text-right">
                  <button type="submit" name="submit" class="btn btn-primary">
                    '.$lang['folder_EDIT_FILE_BTN'].'
                  </button>
                </div>
              </div>
            </form>
          </div>';
        } else {

          // Blocked user
          $core->redirect(base_url().'/user/');
        }

        echo '</div>';
        echo '</section>';
        require_once '../incfiles/footer.php';
      } else {

        // Data not available
        $core->redirect(base_url().'/user/my-files/?view=files&type=latest');
      }
    } else {

      // Illegal access
      $core->redirect(base_url().'/user/my-files/');
    }
  break;

  case 'files':

    // Types of my files
    if(isset($_GET['type'])) {
      if(urlencode($_GET['type']) == 'latest') {

        // Latest upload
        // Headers
        $title = $lang['myfile_LATEST'];
        require_once '../incfiles/header.php';

        // Section latest upload
        echo '<section class="section">';

        echo '<div class="section-header">
          <h1 class="section-title">
            '.$lang['myfile_LATEST'].'
          </h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="'.base_url().'/user/">
                Dashboard
              </a>
            </div>
            <div class="breadcrumb-item">
              '.$lang['myfile_LATEST'].'
            </div>
          </div>
        </div>';

        echo '<div class="row">';

        if($info['rights'] > 0) {

          // Unblocked user
          echo '<div class="col-12">
            <div class="card card-primary">
              <div class="card-header">
                <h4>
                  '.$lang['myfile_LATEST'].'
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
                        '.$lang['myfile_NAME'].'
                      </center>
                    </th>
                    <th class="align-middle">
                      <center>
                        '.$lang['myfile_FOLDER'].'
                      </center>
                    </th>
                    <th class="align-middle">
                      <center>
                        '.$lang['myfile_SIZE'].'
                      </center>
                    </th>
                    <th class="align-middle">
                      <center>
                        '.$lang['myfile_TIME'].'
                      </center>
                    </th>
                    <th class="align-middle">
                      <center>
                        '.$lang['myfile_DOWNLOADED'].'
                      </center>
                    </th>
                    <th class="align-middle">
                      <center>
                        '.$lang['myfile_UPLOADED_BY'].'
                      </center>
                    </th>
                    <th class="align-middle">
                      <center>
                        '.$lang['myfile_ACTION'].'
                      </center>
                    </th>
                  </tr>';
          
          $q = $intbyte->query("SELECT * FROM files WHERE user_id = '".$info['id']."' ORDER BY `id` DESC LIMIT ".$start.", ".$core->set('paging')."");
          $all = $intbyte->query("SELECT * FROM files WHERE user_id = '".$info['id']."'")->num_rows;
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
                  <div class="badge badge-danger" data-toggle="tooltip" title="'.$lang['userFile_FOLDER_T'].' '.ucfirst($core->getFolder($file['folder'])).'.">
                    '.ucfirst($core->getFolder($file['folder'])).'
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
                  <img alt="image" src="'.base_url().'/'.$core->show_avatar($file['user_id']).'" data-toggle="tooltip" title="'.$info['fullname'].'" class="rounded-circle" width="35">
                  '.$core->username($file['user_id']).'
                </td>
                <td class="align-middle">
                  <center>
                    <a id="delete-'.$file['id'].'" class="btn btn-danger btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['myfile_BDWN_DELETE'].'" href="javascript: void(0);">
                      <i class="fas fa-trash"></i>
                    </a>
                    <a id="see_file-'.$file['id'].'" class="btn btn-default btn-sm btn-icon icon-center" style="background: #BFBFBF;color: #FFFFFF;" data-toggle="tooltip" title="'.$lang['myfile_BDWN_SEE'].'" href="javascript: void(0);">
                      <i class="fas fa-eye"></i>
                    </a>
                    <a id="move-'.$file['id'].'" class="btn btn-warning btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['myfile_BDWN_MOVE'].'" href="javascript: void(0);">
                      <i class="fas fa-reply"></i>
                    </a>
                    <a id="edit_'.$file['id'].'" class="btn btn-primary btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['myfile_BDWN_EDIT'].'" href="javascript: void(0);">
                      <i class="fas fa-edit"></i>
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
                      text: '".$lang['myfile_CONDELETE_TEXT']."',
                      icon: 'warning',
                      buttons: true,
                      dangerMode: true,
                    }).then((willDelete) => {
                      if(willDelete) {
                        swal('".$lang['myfile_CONDELETE_SUCCESS']."', {
                          title: 'SUCCESS!',
                          icon: 'success',
                          buttons: false,
                          timer: 3000,
                        }).then(function() {
                          window.location = '".base_url()."/user/my-files/?view=delete&id=".$file['id']."';
                        });
                      } else {
                        swal('".$lang['myfile_CONDELETE_CANCEL']."', {
                          buttons: false,
                          timer: 3000,
                        });
                      }
                    });
                  });

                  // See files
                  $('#see_file-".$file['id']."').on('click', function() {
                    swal({
                      title: '".$lang['userFile_CONFIRM_AYS']."',
                      text: '".$lang['myfile_CONSEE_TEXT']."',
                      icon: 'warning',
                      buttons: true,
                      dangerMode: true,
                    }).then((willSee) => {
                      if(willSee) {
                        swal('Loading...', {
                          icon: 'success',
                          buttons: false,
                          timer: 3000,
                        }).then(function() {
                          window.location = '".base_url()."/".$file['token'].".html';
                        });
                      } else {
                        swal('".$lang['myfile_CONSEE_CANCEL']."', {
                          buttons: false,
                          timer: 3000,
                        });
                      }
                    });
                  });

                  // Move files
                  $('#move-".$file['id']."').on('click', function() {
                    swal({
                      title: '".$lang['notify_NEW_CONFIRM_AYS']."',
                      text: '".$lang['folder_CONMOVE_TEXT']."',
                      icon: 'warning',
                      buttons: true,
                      dangerMode: true,
                    }).then((willMove) => {
                      if(willMove) {
                        swal('Loading...', {
                          icon: 'success',
                          buttons: false,
                          timer: 3000,
                        }).then(function() {
                          window.location = '".base_url()."/user/my-files/?view=move&id=".$file['id']."';
                        });
                      } else {
                        swal('".$lang['folder_CONMOVE_CANCEL']."', {
                          buttons: false,
                          timer: 3000,
                        });
                      }
                    });
                  });

                  // Edit files
                  $('#edit_".$file['id']."').on('click', function() {
                    swal({
                      title: '".$lang['userFile_CONFIRM_AYS']."',
                      text: '".$lang['myfile_CONEDIT_TEXT']."',
                      icon: 'warning',
                      buttons: true,
                      dangerMode: true,
                    }).then((willEdit) => {
                      if(willEdit) {
                        swal('Loading...', {
                          icon: 'success',
                          buttons: false,
                          timer: 3000,
                        }).then(function() {
                          window.location = '".base_url()."/user/my-files/?view=edit_file&id=".$file['id']."';
                        });
                      } else {
                        swal('".$lang['myfile_CONEDIT_CANCEL']."', {
                          buttons: false,
                          timer: 3000,
                        });
                      }
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
                '.$paging->showPage($all, $page, $core->set('paging'), base_url().'/user/my-files/?view=files&type=latest&').'
              </div>
            </div>';
          } else {

            // Data not available
            echo '<td colspan="8" class="align-middle">
                    <marquee scrollamount="2" scrolldelay="2">
                      '.$lang['nf'].'
                    </marquee>
                  </td>
                  </table>
                </div>
              </div>
            </div>';
          }
        } else {

          // Blocked user
          $core->redirect(base_url().'/user/');
        }

        echo '</div>';
        echo '</section>';
        require_once '../incfiles/footer.php';
      } elseif(urlencode($_GET['type']) == 'reported') {

        // Reported files
        // Headers
        $title = $lang['myfile_REPORTED'];
        require_once '../incfiles/header.php';

        // Section reported files
        echo '<section class="section">';

        echo '<div class="section-header">
          <h1 class="section-title">
            '.$lang['myfile_REPORTED'].'
          </h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="'.base_url().'/user/">
                Dashboard
              </a>
            </div>
            <div class="breadcrumb-item">
              '.$lang['myfile_REPORTED'].'
            </div>
          </div>
        </div>';

        echo '<div class="row">';

        if($info['rights'] > 0) {

          // Unblocked user
          echo '<div class="col-12">
            <div class="card card-primary">
              <div class="card-header">
                <h4>
                  '.$lang['myfile_REPORTED'].'
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
                        '.$lang['myfile_NAME'].'
                      </center>
                    </th>
                    <th class="align-middle">
                      <center>
                        '.$lang['myfile_FOLDER'].'
                      </center>
                    </th>
                    <th class="align-middle">
                      <center>
                        '.$lang['myfile_SIZE'].'
                      </center>
                    </th>
                    <th class="align-middle">
                      <center>
                        '.$lang['myfile_TIME'].'
                      </center>
                    </th>
                    <th class="align-middle">
                      <center>
                        '.$lang['myfile_DOWNLOADED'].'
                      </center>
                    </th>
                    <th class="align-middle">
                      <center>
                        '.$lang['myfile_REPORTED'].'
                      </center>
                    </th>
                    <th class="align-middle">
                      <center>
                        '.$lang['myfile_UPLOADED_BY'].'
                      </center>
                    </th>
                    <th class="align-middle">
                      <center>
                        '.$lang['myfile_ACTION'].'
                      </center>
                    </th>
                  </tr>';
          
          $q = $intbyte->query("SELECT * FROM files WHERE user_id = '".$info['id']."' AND report >= '1' ORDER BY `report` DESC LIMIT ".$start.", ".$core->set('paging')."");
          $all = $intbyte->query("SELECT * FROM files WHERE user_id = '".$info['id']."' AND report >= '1'")->num_rows;
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
                  <div class="badge badge-danger" data-toggle="tooltip" title="'.$lang['userFile_FOLDER_T'].' '.ucfirst($core->getFolder($file['folder'])).'.">
                    '.ucfirst($core->getFolder($file['folder'])).'
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
                  <img alt="image" src="'.base_url().'/'.$core->show_avatar($file['user_id']).'" data-toggle="tooltip" title="'.$info['fullname'].'" class="rounded-circle" width="35">
                  '.$core->username($file['user_id']).'
                </td>
                <td class="align-middle">
                  <center>
                    <a id="delete-'.$file['id'].'" class="btn btn-danger btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['myfile_BDWN_DELETE'].'" href="javascript: void(0);">
                      <i class="fas fa-trash"></i>
                    </a>
                    <a id="see_file-'.$file['id'].'" class="btn btn-default btn-sm btn-icon icon-center" style="background: #BFBFBF;color: #FFFFFF;" data-toggle="tooltip" title="'.$lang['myfile_BDWN_SEE'].'" href="javascript: void(0);">
                      <i class="fas fa-eye"></i>
                    </a>
                    <a id="move-'.$file['id'].'" class="btn btn-warning btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['myfile_BDWN_MOVE'].'" href="javascript: void(0);">
                      <i class="fas fa-reply"></i>
                    </a>
                    <a id="edit_'.$file['id'].'" class="btn btn-primary btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['myfile_BDWN_EDIT'].'" href="javascript: void(0);">
                      <i class="fas fa-edit"></i>
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
                      text: '".$lang['myfile_CONDELETE_TEXT']."',
                      icon: 'warning',
                      buttons: true,
                      dangerMode: true,
                    }).then((willDelete) => {
                      if(willDelete) {
                        swal('".$lang['myfile_CONDELETE_SUCCESS']."', {
                          title: 'SUCCESS!',
                          icon: 'success',
                          buttons: false,
                          timer: 3000,
                        }).then(function() {
                          window.location = '".base_url()."/user/my-files/?view=delete&id=".$file['id']."';
                        });
                      } else {
                        swal('".$lang['myfile_CONDELETE_CANCEL']."', {
                          buttons: false,
                          timer: 3000,
                        });
                      }
                    });
                  });

                  // See files
                  $('#see_file-".$file['id']."').on('click', function() {
                    swal({
                      title: '".$lang['userFile_CONFIRM_AYS']."',
                      text: '".$lang['myfile_CONSEE_TEXT']."',
                      icon: 'warning',
                      buttons: true,
                      dangerMode: true,
                    }).then((willSee) => {
                      if(willSee) {
                        swal('Loading...', {
                          icon: 'success',
                          buttons: false,
                          timer: 3000,
                        }).then(function() {
                          window.location = '".base_url()."/".$file['token'].".html';
                        });
                      } else {
                        swal('".$lang['myfile_CONSEE_CANCEL']."', {
                          buttons: false,
                          timer: 3000,
                        });
                      }
                    });
                  });

                  // Move files
                  $('#move-".$file['id']."').on('click', function() {
                    swal({
                      title: '".$lang['notify_NEW_CONFIRM_AYS']."',
                      text: '".$lang['folder_CONMOVE_TEXT']."',
                      icon: 'warning',
                      buttons: true,
                      dangerMode: true,
                    }).then((willMove) => {
                      if(willMove) {
                        swal('Loading...', {
                          icon: 'success',
                          buttons: false,
                          timer: 3000,
                        }).then(function() {
                          window.location = '".base_url()."/user/my-files/?view=move&id=".$file['id']."';
                        });
                      } else {
                        swal('".$lang['folder_CONMOVE_CANCEL']."', {
                          buttons: false,
                          timer: 3000,
                        });
                      }
                    });
                  });

                  // Edit files
                  $('#edit_".$file['id']."').on('click', function() {
                    swal({
                      title: '".$lang['userFile_CONFIRM_AYS']."',
                      text: '".$lang['myfile_CONEDIT_TEXT']."',
                      icon: 'warning',
                      buttons: true,
                      dangerMode: true,
                    }).then((willEdit) => {
                      if(willEdit) {
                        swal('Loading...', {
                          icon: 'success',
                          buttons: false,
                          timer: 3000,
                        }).then(function() {
                          window.location = '".base_url()."/user/my-files/?view=edit_file&id=".$file['id']."';
                        });
                      } else {
                        swal('".$lang['myfile_CONEDIT_CANCEL']."', {
                          buttons: false,
                          timer: 3000,
                        });
                      }
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
                '.$paging->showPage($all, $page, $core->set('paging'), base_url().'/user/my-files/?view=files&type=reported&').'
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
        } else {

          // Blocked user
          $core->redirect(base_url().'/user/');
        }

        echo '</div>';
        echo '</section>';
        require_once '../incfiles/footer.php';
      } elseif(urlencode($_GET['type']) == 'popular') {

        // Popular download
        // Headers
        $title = $lang['myfile_POPULAR'];
        require_once '../incfiles/header.php';

        // Section popular download
        echo '<section class="section">';

        echo '<div class="section-header">
          <h1 class="section-title">
            '.$lang['myfile_POPULAR'].'
          </h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="'.base_url().'/user/">
                Dashboard
              </a>
            </div>
            <div class="breadcrumb-item">
              '.$lang['myfile_POPULAR'].'
            </div>
          </div>
        </div>';

        echo '<div class="row">';

        if($info['rights'] > 0) {

          // Unblocked user
          echo '<div class="col-12">
            <div class="card card-primary">
              <div class="card-header">
                <h4>
                  '.$lang['myfile_POPULAR'].'
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
                        '.$lang['myfile_NAME'].'
                      </center>
                    </th>
                    <th class="align-middle">
                      <center>
                        '.$lang['myfile_FOLDER'].'
                      </center>
                    </th>
                    <th class="align-middle">
                      <center>
                        '.$lang['myfile_SIZE'].'
                      </center>
                    </th>
                    <th class="align-middle">
                      <center>
                        '.$lang['myfile_TIME'].'
                      </center>
                    </th>
                    <th class="align-middle">
                      <center>
                        '.$lang['myfile_DOWNLOADED'].'
                      </center>
                    </th>
                    <th class="align-middle">
                      <center>
                        '.$lang['myfile_UPLOADED_BY'].'
                      </center>
                    </th>
                    <th class="align-middle">
                      <center>
                        '.$lang['myfile_ACTION'].'
                      </center>
                    </th>
                  </tr>';
          
          $q = $intbyte->query("SELECT * FROM files WHERE user_id = '".$info['id']."' AND downloaded >= '1' ORDER BY `downloaded` DESC LIMIT ".$start.", ".$core->set('paging')."");
          $all = $intbyte->query("SELECT * FROM files WHERE user_id = '".$info['id']."' AND downloaded >= '1'")->num_rows;
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
                  <div class="badge badge-danger" data-toggle="tooltip" title="'.$lang['userFile_FOLDER_T'].' '.ucfirst($core->getFolder($file['folder'])).'.">
                    '.ucfirst($core->getFolder($file['folder'])).'
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
                  <img alt="image" src="'.base_url().'/'.$core->show_avatar($file['user_id']).'" data-toggle="tooltip" title="'.$info['fullname'].'" class="rounded-circle" width="35">
                  '.$core->username($file['user_id']).'
                </td>
                <td class="align-middle">
                  <center>
                    <a id="delete-'.$file['id'].'" class="btn btn-danger btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['myfile_BDWN_DELETE'].'" href="javascript: void(0);">
                      <i class="fas fa-trash"></i>
                    </a>
                    <a id="see_file-'.$file['id'].'" class="btn btn-default btn-sm btn-icon icon-center" style="background: #BFBFBF;color: #FFFFFF;" data-toggle="tooltip" title="'.$lang['myfile_BDWN_SEE'].'" href="javascript: void(0);">
                      <i class="fas fa-eye"></i>
                    </a>
                    <a id="move-'.$file['id'].'" class="btn btn-warning btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['myfile_BDWN_MOVE'].'" href="javascript: void(0);">
                      <i class="fas fa-reply"></i>
                    </a>
                    <a id="edit_'.$file['id'].'" class="btn btn-primary btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['myfile_BDWN_EDIT'].'" href="javascript: void(0);">
                      <i class="fas fa-edit"></i>
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
                      text: '".$lang['myfile_CONDELETE_TEXT']."',
                      icon: 'warning',
                      buttons: true,
                      dangerMode: true,
                    }).then((willDelete) => {
                      if(willDelete) {
                        swal('".$lang['myfile_CONDELETE_SUCCESS']."', {
                          title: 'SUCCESS!',
                          icon: 'success',
                          buttons: false,
                          timer: 3000,
                        }).then(function() {
                          window.location = '".base_url()."/user/my-files/?view=delete&id=".$file['id']."';
                        });
                      } else {
                        swal('".$lang['myfile_CONDELETE_CANCEL']."', {
                          buttons: false,
                          timer: 3000,
                        });
                      }
                    });
                  });

                  // See files
                  $('#see_file-".$file['id']."').on('click', function() {
                    swal({
                      title: '".$lang['userFile_CONFIRM_AYS']."',
                      text: '".$lang['myfile_CONSEE_TEXT']."',
                      icon: 'warning',
                      buttons: true,
                      dangerMode: true,
                    }).then((willSee) => {
                      if(willSee) {
                        swal('Loading...', {
                          icon: 'success',
                          buttons: false,
                          timer: 3000,
                        }).then(function() {
                          window.location = '".base_url()."/".$file['token'].".html';
                        });
                      } else {
                        swal('".$lang['myfile_CONSEE_CANCEL']."', {
                          buttons: false,
                          timer: 3000,
                        });
                      }
                    });
                  });

                  // Move files
                  $('#move-".$file['id']."').on('click', function() {
                    swal({
                      title: '".$lang['notify_NEW_CONFIRM_AYS']."',
                      text: '".$lang['folder_CONMOVE_TEXT']."',
                      icon: 'warning',
                      buttons: true,
                      dangerMode: true,
                    }).then((willMove) => {
                      if(willMove) {
                        swal('Loading...', {
                          icon: 'success',
                          buttons: false,
                          timer: 3000,
                        }).then(function() {
                          window.location = '".base_url()."/user/my-files/?view=move&id=".$file['id']."';
                        });
                      } else {
                        swal('".$lang['folder_CONMOVE_CANCEL']."', {
                          buttons: false,
                          timer: 3000,
                        });
                      }
                    });
                  });

                  // Edit files
                  $('#edit_".$file['id']."').on('click', function() {
                    swal({
                      title: '".$lang['userFile_CONFIRM_AYS']."',
                      text: '".$lang['myfile_CONEDIT_TEXT']."',
                      icon: 'warning',
                      buttons: true,
                      dangerMode: true,
                    }).then((willEdit) => {
                      if(willEdit) {
                        swal('Loading...', {
                          icon: 'success',
                          buttons: false,
                          timer: 3000,
                        }).then(function() {
                          window.location = '".base_url()."/user/my-files/?view=edit_file&id=".$file['id']."';
                        });
                      } else {
                        swal('".$lang['myfile_CONEDIT_CANCEL']."', {
                          buttons: false,
                          timer: 3000,
                        });
                      }
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
                '.$paging->showPage($all, $page, $core->set('paging'), base_url().'/user/my-files/?view=files&type=popular&').'
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
        } else {

          // Blocked user
          $core->redirect(base_url().'/user/');
        }

        echo '</div>';
        echo '</section>';
        require_once '../incfiles/footer.php';
      } else {

        // Illegal access
        $core->redirect(base_url().'/user/my-files/');
      }
    } else {

      // Illegal access
      $core->redirect(base_url().'/user/my-files/');
    }
  break;

  default:

    // Illegal Access
    // If there is access to this page then the system will direct to the main page User
    $core->redirect(base_url().'/user/');
  break;
}
?>
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
        $file = $q->fetch_assoc();
        $fileSize = $file['size'];

        // Check the files on path /data/username/
        if(unlink('../data/'.$core->username($file['user_id']).'/'.$file['name'].'')) {

          // Update storage, files
          $u = $intbyte->query("UPDATE users SET storage = storage-".$fileSize.", files = files-1 WHERE id = ".$file['user_id']."");
          $d = $intbyte->query("DELETE FROM files WHERE user_id = '".$info['id']."' AND id = '".$id."'");

          if($u || $d) {

            // Successfully deleted the files
            $core->redirect(base_url().'/user/folder/?view=folder&id='.$file['folder'].'');
          } else {

            // Failed deleted the files
            $core->redirect(base_url().'/user/folder/?view=folder&id='.$file['folder'].'');
          }
        } else {

          // Failed deleted the files
          $core->redirect(base_url().'/user/folder/?view=folder&id='.$delete['folder'].'');
        }
      } else {

        //Data not available
        $core->redirect(base_url().'/user/folder/?view=folder&id='.$delete['folder'].'');
      }
    } else {

      // Illegal access
      $core->redirect(base_url().'/user/folder/?view=folder&id='.$delete['folder'].'');
    }
  break;

  case 'drop':

    // Action to drop all
    if(isset($_GET['id']) && !empty($_GET['id'])) {

      $id = intval($_GET['id']);
      $q = $intbyte->query("SELECT * FROM folders WHERE id = '".$id."' AND user_id = '".$info['id']."'");
      if($q->num_rows > 0) {

        // Execute
        $folder = $q->fetch_assoc();
        $d = $intbyte->query("DELETE FROM folders WHERE id = '".$id."' AND user_id = '".$info['id']."'");
        if($d) {

          $e = $intbyte->query("SELECT * FROM files WHERE folder = '".$folder['id']."' AND user_id = '".$info['id']."'");
          if($e->num_rows > 0) {

            while($read = $e->fetch_assoc()) {
              if(file_exists('../data/'.$core->username($info['id']).'/'.$read['name'].'')) {
                if(unlink('../data/'.$core->username($info['id']).'/'.$read['name'].'')) {

                  $del = $intbyte->query("DELETE FROM files WHERE folder = '".$folder['id']."' AND user_id = '".$info['id']."'");
                  $upd = $intbyte->query("UPDATE users SET files = files-1, storage = storage-".$read['size']." WHERE id = '".$info['id']."'");

                  if($del || $upd) {

                    // Successfully dropped all
                    $core->redirect(base_url().'/user/folder/?view=folder&id='.$id.'');
                  } else {

                    // Failed dropped all
                    $core->redirect(base_url().'/user/folder/?view=folder&id='.$id.'');
                  }
                }
              }

              // Do not remove this line because it is important
              $read++;
            }
          } else {

            // Data not available
            $core->redirect(base_url().'/user/folder/?view=folder&id='.$id.'');
          }
        } else {

          // Failed deleted the files
          $core->redirect(base_url().'/user/folder/?view=folder&id='.$id.'');
        }
      } else {

        // Data not available
        $core->redirect(base_url().'/user/folder/?view=folder&id='.$id.'');
      }
    } else {

      // Illegal access
      $core->redirect(base_url().'/user/folder/?view=folder&id='.$id.'');
    }
  break;

  case 'edit':

    // Action to edit
    if(isset($_GET['id']) && !empty($_GET['id']) AND isset($_GET['name']) && !empty($_GET['name'])) {

      $id = intval($_GET['id']);
      $name = strip_tags($core->filter_input($_GET['name']));

      $q = $intbyte->query("SELECT * FROM folders WHERE name = '".$name."' AND user_id = '".$info['id']."'");
      if($q->num_rows > 0) {

        // If exists the folders
        $core->redirect(base_url().'/user/folder/?view=folder&id='.$id.'');
      } elseif(!preg_match('/^[a-zA-Z0-9. _-]*$/', $name)) {

        // The folder name is not valid
        $core->redirect(base_url().'/user/folder/?view=folder&id='.$id.'');
      } elseif(strlen($name) < 3 || strlen($name) > 30) {

        // Check the length of folder name
        $core->redirect(base_url().'/user/folder/?view=folder&id='.$id.'');
      } else {

        // Execute
        $u = $intbyte->query("UPDATE folders SET name = '".$name."' WHERE id = '".$id."' AND user_id = '".$info['id']."'");
        if($u) {

          // Successfully edited the folder name
          $core->redirect(base_url().'/user/folder/?view=folder&id='.$id.'');
        } else {

          // Failed edited the folder name
          $core->redirect(base_url().'/user/folder/?view=folder&id='.$id.'');
        }
      }
    } else {

      // Illegal access
      $core->redirect(base_url().'/user/folder/?view=folder&id='.$id.'');
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
        $core->redirect(base_url().'/user/folder/?view=folder&id='.$file['folder'].'');
      }
    } else {

      // Illegal access
      $core->redirect(base_url().'/user/');
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
                      window.location = '".base_url()."/user/folder/?view=move&id=".$file['id']."';
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
                      window.location = '".base_url()."/user/folder/?view=move&id=".$file['id']."';
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
        $core->redirect(base_url().'/user/folder/?view=folder&id='.$file['folder'].'');
      }
    } else {

      // Illegal access
      $core->redirect(base_url().'/user/');
    }
  break;

  case 'add_folder':

    // Add a new folder
    // Headers
    $title = $lang['folder_ADD'];
    require_once '../incfiles/header.php';

    // If not an User, the system will be redirect to the index page or home page
    if(!$session->is_login()) {
      $core->redirect(base_url().'/');
    }

    // Section add a new folder
    echo '<section class="section">';

    echo '<div class="section-header">
      <h1 class="section-title">
        '.$lang['folder_ADD'].'
      </h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">
          <a href="'.base_url().'/user/">
            Dashboard
          </a>
        </div>
        <div class="breadcrumb-item">
          '.$lang['folder_ADD'].'
        </div>
      </div>
    </div>';

    echo '<div class="row">';

    if($info['rights'] > 0) {

      // Unblocked user
      if(isset($_POST['submit'])) {

        // The folders data
        $folder_name = strip_tags($core->filter_input($_POST['site_folder']));

        if(empty($folder_name)) {

          // Empty data
          echo "<script>
            $(document).ready(function() {
              swal('".$lang['folder_EMPTY']."', {
                title: 'WARNING!',
                icon: 'warning',
                buttons: false,
                timer: 3000,
              });
            });
          </script>";
        } elseif(!preg_match('/^[a-zA-Z0-9. _-]*$/', $folder_name)) {

          // The folder name is not valid
          echo "<script>
            $(document).ready(function() {
              swal('".$lang['folder_INVALID']."', {
                title: 'WARNING!',
                icon: 'warning',
                buttons: false,
                timer: 3000,
              });
            });
          </script>";
        } elseif(strlen($folder_name) < 3 || strlen($folder_name) > 30) {

          // Check the length of folder name
          echo "<script>
            $(document).ready(function() {
              swal('".$lang['folder_LENGTH']."', {
                title: 'WARNING!',
                icon: 'warning',
                buttons: false,
                timer: 3000,
              });
            });
          </script>";
        } elseif($intbyte->query("SELECT * FROM folders WHERE name = '".$folder_name."' AND user_id = '".$info['id']."'")->num_rows > 0) {

          // Check the folders exists
          echo "<script>
            $(document).ready(function() {
              swal('".$lang['folder_EXISTS']."', {
                title: 'WARNING!',
                icon: 'warning',
                buttons: false,
                timer: 3000,
              });
            });
          </script>";
        } else {

          // Insert data
          $id = $core->insert_data('folders');
          $i = $intbyte->query("INSERT INTO folders (`id`, `name`, `user_id`) VALUES('".$id."', '".$core->escapeToDB($folder_name)."', '".$info['id']."')");
          if($i) {

            // Successfully updated the folders
            echo "<script>
              $(document).ready(function() {
                swal('".$lang['folder_SUCCESS']."', {
                  title: 'SUCCESS!',
                  icon: 'success',
                  buttons: false,
                  timer: 3000,
                }).then(function() {
                  window.location = '".base_url()."/user/folder/?view=add_folder';
                });
              });
            </script>";
          } else {

            // Failed updated the folders
            echo "<script>
              $(document).ready(function() {
                swal('".$lang['folder_FAILED']."', {
                  title: 'WARNING!',
                  icon: 'warning',
                  buttons: false,
                  timer: 3000,
                }).then(function() {
                  window.location = '".base_url()."/user/folder/?view=add_folder';
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
                '.$lang['folder_ADD'].'
              </h4>
            </div>
            <div class="card-body">
              <p class="text-muted">
                '.$lang['folder_TEXT'].'
              </p>
              <div class="form-group row align-items-center">
                <label for="site-folder" class="form-control-label col-sm-3 text-md-right">
                  '.$lang['folder_NAME'].'
                </label>
                <div class="col-sm-6 col-md-9">
                  <textarea class="form-control" name="site_folder" required=""></textarea>
                  <div class="invalid-feedback">
                    '.$lang['folder_IFB'].'
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer text-right">
              <button type="reset" name="site_folder" class="btn btn-default">
                '.$lang['folder_CLEAR'].'
              </button>
              <button type="submit" name="submit" class="btn btn-primary">
                '.$lang['folder_ADD'].'
              </button>
            </div>
          </form>
        </div>
      </div>';
    } else {

      // Blocked user
      $core->redirect(base_url().'/user/');
    }

    echo '</div>';
    echo '</section>';
    require_once '../incfiles/footer.php';
  break;

  case 'folder':

    // Folder
    if(isset($_GET['id']) && !empty($_GET['id'])) {

      $id = intval($_GET['id']);
      $q = $intbyte->query("SELECT * FROM folders WHERE id = '".$id."' AND user_id = '".$info['id']."'");
      if($q->num_rows > 0) {

        // Headers
        $title = 'Folder '.ucfirst($core->getFolder($id));
        require_once '../incfiles/header.php';

        // Section User Folder
        echo '<section class="section">';

        echo '<div class="section-header">
          <h1 class="section-title">
            Folder '.ucfirst($core->getFolder($id)).'
          </h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="'.base_url().'/user/">
                Dashboard
              </a>
            </div>
            <div class="breadcrumb-item">
              Folder '.ucfirst($core->getFolder($id)).'
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
                  Folder '.ucfirst($core->getFolder($id)).'
                </h4>
                <div class="card-header-action">';

                if($core->getFolder($id) == '{ROOT}') {

                  // If user selected the folder ROOT
                  echo '<a href="javascript: void(0);" class="btn btn-default btn-icon icon-center" style="background: #BFBFBF;color: #FFFFFF;">
                    <i class="fas fa-trash"></i>
                  </a>
                  <a href="javascript: void(0);" class="btn btn-default btn-icon icon-center" style="background: #BFBFBF;color: #FFFFFF;">
                    <i class="fas fa-edit"></i>
                  </a>';
                } else {

                  // If user not selected the folder ROOT
                  echo '<a id="drop-'.$id.'" href="javascript: void(0);" class="btn btn-danger btn-icon icon-center" data-toggle="tooltip" title="'.$lang['folder_DROP_ALL'].' '.ucfirst($core->getFolder($id)).'">
                    <i class="fas fa-trash"></i>
                  </a>
                  <a id="edit-'.$id.'" href="javascript: void(0);" class="btn btn-primary btn-icon icon-center" data-toggle="tooltip" title="'.$lang['folder_EDIT'].' '.ucfirst($core->getFolder($id)).'">
                    <i class="fas fa-edit"></i>
                  </a>';
                }

                echo '</div>
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
          
          $q = $intbyte->query("SELECT * FROM files WHERE folder = '".$id."' AND user_id = '".$info['id']."' ORDER BY `id` DESC LIMIT ".$start.", ".$core->set('paging')."");
          $all = $intbyte->query("SELECT * FROM files WHERE folder = '".$id."' AND user_id = '".$info['id']."'")->num_rows;
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
                  <img alt="image" src="'.base_url().'/'.$core->show_avatar($file['user_id']).'" data-toggle="tooltip" title="'.$core->username($file['user_id']).'" class="rounded-circle" width="35">
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

              // Delete files, see files, move files, edit files
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
                          window.location = '".base_url()."/user/folder/?view=delete&id=".$file['id']."';
                        });
                      } else {
                        swal('".$lang['myfile_CONDELETE_CANCEL']."',                       {
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
                        swal('".$lang['myfile_CONSEE_CANCEL']."',                       {
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
                          window.location = '".base_url()."/user/folder/?view=move&id=".$file['id']."';
                        });
                      } else {
                        swal('".$lang['folder_CONMOVE_CANCEL']."',                       {
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
                          window.location = '".base_url()."/user/folder/?view=edit_file&id=".$file['id']."';
                        });
                      } else {
                        swal('".$lang['myfile_CONEDIT_CANCEL']."',                       {
                          buttons: false,
                          timer: 3000,
                        });
                      }
                    });
                  });

                  // Drop all
                  $('#drop-".$id."').on('click', function() {
                    swal({
                      title: '".$lang['notify_NEW_CONFIRM_AYS']."',
                      text: '".$lang['folder_CONDROP_TEXT']."',
                      icon: 'warning',
                      buttons: true,
                      dangerMode: true,
                    }).then((willDrop) => {
                      if(willDrop) {
                        swal('".$lang['folder_CONDROP_SUCCESS']."', {
                          title: 'SUCCESS!',
                          icon: 'success',
                          buttons: false,
                          timer: 3000,
                        }).then(function() {
                          window.location = '".base_url()."/user/folder/?view=drop&id=".$file['folder']."';
                        });
                      } else {
                        swal('".$lang['folder_CONDROP_CANCEL']."',                       {
                          buttons: false,
                          timer: 3000,
                        });
                      }
                    });
                  });

                  // Edit folders
                  $('#edit-".$id."').click(function() {
                    swal({
                      title: '".$lang['folder_EDIT']." ".$core->getFolder($id)."',
                      content: {
                      element: 'input',
                      attributes: {
                        placeholder: '".$core->getFolder($id)."',
                        type: 'text',
                        required: 'required',
                      },
                      },
                    }).then((data) => {
                      if(data) {
                        swal('".$lang['folder_EDIT_SUCCESS']." ' + data + '.', {
                          title: 'SUCCESS!',
                          icon: 'success',
                          buttons: false,
                          timer: 3000,
                        }).then(function() {
                          window.location = '".base_url()."/user/folder/?view=edit&id=".$file['folder']."&name=' + data +'';
                        });
                      } else {
                        swal('".$lang['folder_EDIT_CANCEL']."',                       {
                          buttons: false,
                          timer: 3000,
                        });
                      }
                    });
                  });

                });
              </script>";

              $file++;
              $no++;
            }

            // Pagination
            echo '</table>
                </div>
              </div>
              <div class="card-footer text-right">
                '.$paging->showPage($all, $page, $core->set('paging'), base_url().'/user/folder/?view=folder&id='.$id.'&').'
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

            // Action to drop all and edit the folder name
            echo "<script>
              $(document).ready(function() {

                // Drop all
                $('#drop-".$id."').on('click', function() {
                  swal({
                    title: '".$lang['notify_NEW_CONFIRM_AYS']."',
                    text: '".$lang['folder_CONDROP_TEXT']."',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                  }).then((willDrop) => {
                    if(willDrop) {
                      swal('".$lang['folder_CONDROP_SUCCESS']."', {
                        title: 'SUCCESS!',
                        icon: 'success',
                        buttons: false,
                        timer: 3000,
                      }).then(function() {
                        window.location = '".base_url()."/user/folder/?view=drop&id=".$id."';
                      });
                    } else {
                      swal('".$lang['folder_CONDROP_CANCEL']."', {
                        buttons: false,
                        timer: 3000,
                      });
                    }
                  });
                });

                // Edit folders
                $('#edit-".$id."').click(function() {
                  swal({
                    title: '".$lang['folder_EDIT']." ".$core->getFolder($id)."',
                    content: {
                    element: 'input',
                    attributes: {
                      placeholder: '".$core->getFolder($id)."',
                      type: 'text',
                      required: 'required',
                    },
                    },
                  }).then((data) => {
                    if(data) {
                      swal('".$lang['folder_EDIT_SUCCESS']." ' + data + '.', {
                        title: 'SUCCESS!',
                        icon: 'success',
                        buttons: false,
                        timer: 3000,
                      }).then(function() {
                        window.location = '".base_url()."/user/folder/?view=edit&id=".$id."&name=' + data +'';
                      });
                    } else {
                      swal('".$lang['folder_EDIT_CANCEL']."',                       {
                        buttons: false,
                        timer: 3000,
                      });
                    }
                  });
                });

              });
            </script>";
          }
        } else {

          // Blocked user
          $core->redirect(base_url().'/user/');
        }

        echo '</div>';
        echo '</section>';
        require_once '../incfiles/footer.php';
      } else {

        // Data not available
        $core->redirect(base_url().'/user/');
      }
    } else {

      // Illegal access
      $core->redirect(base_url().'/user/');
    }
  break;

  default:

    // Illegal Access
    // If there is access to this page then the system will direct to the main page User
    $core->redirect(base_url().'/user/');
  break;
}
?>
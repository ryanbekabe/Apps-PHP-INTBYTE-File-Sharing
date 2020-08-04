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
$title = $lang['upload_FILE'];
require_once '../incfiles/header.php';

// If not an User, the system will be redirect to the index page or home page
if(!$session->is_login()) {
  $core->redirect(base_url().'/');
}

// The user informations
$q = $intbyte->query("SELECT * FROM users WHERE id = '".$session->is_login()."'");
$info = $q->fetch_assoc();

// Section upload the files
echo '<section class="section">';

echo '<div class="section-header">
  <h1 class="section-title">
    '.$lang['upload_FILE'].'
  </h1>
  <div class="section-header-breadcrumb">
    <div class="breadcrumb-item active">
      <a href="'.base_url().'/user/">
        Dashboard
      </a>
    </div>
    <div class="breadcrumb-item">
      '.$lang['upload_FILE'].'
    </div>
  </div>
</div>';

echo '<div class="row">';

if($info['rights'] > 0) {

  // Unblocked user

  if($info['type'] == 1) {

    // Premium account
    if(isset($_POST['upload'])) {

      // The files upload data
      $file_folder = strip_tags($core->filter_input($_POST['folder']));
      $file_description = $core->filter_input($_POST['description']);
      $file_password = strip_tags($core->filter_input($_POST['password']));

      if($file_folder == 'NULL') {

        // If user not selected the folder
        echo "<script>
          $(document).ready(function() {
            swal('".$lang['upload_FILE_NSF']."', {
              title: 'WARNING!',
              icon: 'warning',
              buttons: false,
              timer: 3000,
            });
          });
        </script>";
      } elseif(strlen($file_description) > 5000) {

        // Check the length of files description
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

        // Execute
        if(isset($_FILES['file'])) {

          // The files data
          $attach = $_FILES['file'];
          $file_count = count($attach['name']);

          if($file_count > 0) {
            for($x = 0; $x < $file_count; $x++) {
              if(!empty($attach['name'][$x])) {
                if($attach['error'][$x]) {

                  // Error messages
                  $messages = array(
                    1 => 'The uploaded file exceeds the UPLOAD_MAX_FILESIZE directive in php.ini',
                    2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
                    3 => 'The uploaded file was only partially uploaded',
                    4 => 'No file was uploaded',
                    5 => 'Missing a temporary folder'
                  );

                  // The message
                  echo "<script>
                    $(document).ready(function() {
                      iziToast.error({
                        title: 'WARNING!',
                        message: '".$messages[$attach['error'][$x]]."',
                        position: 'topLeft' 
                      });
                    });
                  </script>";
                }

                // The files system
                $file_name = $attach['name'][$x];
                $file_size = $attach['size'][$x];
                $file_type = $attach['type'][$x];
                $file_total_size = ($file_size + $info['storage']);
                $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                $file_directory = '../data/'.$core->username($session->is_login()).'';

                if($file_total_size > $core->set('upload_max_size')) {

                  // The storage limit
                  echo "<script>
                    $(document).ready(function() {
                      swal('".$lang['upload_FILE_LS']."', {
                        title: 'WARNING!',
                        icon: 'warning',
                        buttons: false,
                        timer: 3000,
                      });
                    });
                  </script>";
                } elseif($file_size > $core->set('file_max_size')) {

                  // If the files is bigger size
                  echo "<script>
                    $(document).ready(function() {
                      iziToast.warning({
                        title: 'WARNING!',
                        message: '".$file_name." ".$lang['upload_FILE_BS']."',
                        position: 'topLeft' 
                      });
                    });
                  </script>";
                } elseif(file_exists($file_directory.'/'.$file_name.'') || $intbyte->query("SELECT * FROM files WHERE name = '".$file_name."' AND user_id = '".$session->is_login()."'")->num_rows > 0) {

                  // The files exists
                  echo "<script>
                    $(document).ready(function() {
                      iziToast.warning({
                        title: 'WARNING!',
                        message: '".$file_name." ".$lang['upload_FILE_HU']."',
                        position: 'topLeft' 
                      });
                    });
                  </script>";
                } elseif(in_array(strtolower($file_ext), explode(',', strtolower(str_replace(' ', '', $core->set('not_allowed_extension')))))) {

                  // The extensions is not valid
                  echo "<script>
                    $(document).ready(function() {
                      iziToast.warning({
                        title: 'WARNING!',
                        message: '".$lang['upload_FILE_NAE']." ".$file_name." ".$lang['upload_FILE_NAE2']."',
                        position: 'topLeft' 
                      });
                    });
                  </script>";
                } else {

                  // Move the files uploaded
                  $move = move_uploaded_file($_FILES['file']['tmp_name'][$x], $file_directory.'/'.$file_name.'');
                  if($move) {

                    // Successfully To Move
                    $id = $core->insert_data('files');
                    $i = $intbyte->query("INSERT INTO files (`id`, `name`, `folder`, `description`, `password`, `size`, `time`, `downloaded`, `views`, `user_id`, `report`, `token`) VALUES('".$id."', '".$file_name."', '".$file_folder."', '".$file_description."', '".(!empty($file_password) ? password_hash($file_password, PASSWORD_DEFAULT) : '')."', '".$file_size."', '".time()."', '0', '1', '".$session->is_login()."', '0', '".$core->genChar(15, TRUE)."');");
                    $u = $intbyte->query("UPDATE users SET files = files+1, storage = storage+".$file_size." WHERE id = '".$session->is_login()."'");

                    if($i && $u) {

                      // Successfully uploaded the files
                      echo "<script>
                        $(document).ready(function() {
                          iziToast.success({
                            title: 'SUCCESS!',
                            message: '".$file_name." ".$lang['upload_FILE_SS']."',
                            position: 'topLeft' 
                          });
                        });
                      </script>";
                    } else {

                      // Failed uploaded the files
                      echo "<script>
                        $(document).ready(function() {
                          iziToast.warning({
                            title: 'WARNING!',
                            message: '".$file_name." ".$lang['upload_FILE_FS']."',
                            position: 'topLeft' 
                          });
                        });
                      </script>";
                    }
                  } else {

                    // Failed moved the files
                    echo "<script>
                      $(document).ready(function() {
                        swal('".$lang['upload_FILE_FM']."', {
                          title: 'WARNING!',
                          icon: 'warning',
                          buttons: false,
                          timer: 3000,
                        });
                      });
                    </script>";
                  }
                }
              } else {
                
                // The files not uploaded contains
                if($file_count == 1) {
                  echo "<script>
                    $(document).ready(function() {
                      iziToast.warning({
                        title: 'WARNING!',
                        message: '".$lang['upload_FILE_NFS']."',
                        position: 'topLeft' 
                      });
                    });
                  </script>";
                } else {
                  echo "<script>
                    $(document).ready(function() {
                      iziToast.warning({
                        title: 'WARNING!',
                        message: '".$lang['upload_FILE_NFS2']."',
                        position: 'topLeft' 
                      });
                    });
                  </script>";
                }
              }
            }
          }
        }
      }
    }

    // HTML form
    echo '<div class="col-md-12">
      <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate="">
        <div class="card card-primary">
          <div class="card-header">
            <h4>
              '.$lang['upload_FILE'].'
            </h4>
          </div>
          <div class="card-body">
            <p class="text-muted">
              '.$lang['upload_FILE_TEXT2'].' '.$core->size($core->set('file_max_size')).'.
            </p>
            <div class="row">
              <div class="col-12 col-md-6 col-lg-6">
                <div class="form-group row align-items-center">
                  <label for="file" class="form-control-label">
                    <a id="add_more" href="javascript: void(0);" class="btn btn-sm btn-primary">
                      <i class="fas fa-plus"></i>
                    </a>
                    '.$lang['upload_FILE_SF2'].'
                  </label>
                  <div class="col-sm-6 col-md-6">
                    <div id="area">
                      <div class="custom-file">
                        <input type="file" name="file[]" class="custom-file-input" multiple="multiple">
                        <label class="custom-file-label">
                          '.$lang['upload_FILE_CF'].'
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 col-lg-6">
                <div class="form-group row align-items-center">
                  <label for="password" class="form-control-label col-sm-3 text-md-right">
                    '.$lang['upload_FILE_FOLDER'].'
                  </label>
                  <div class="col-sm-6 col-md-9">
                    <select name="folder" class="form-control select2" required="">
                      <option value="NULL">
                        '.$lang['upload_FILE_SF'].'
                      </option>';

                      // To get all the user folders
                      $q = $intbyte->query("SELECT * FROM folders WHERE user_id = '".$session->is_login()."' ORDER BY `id` DESC");
                      if($q->num_rows > 0) {
                        while($folder = $q->fetch_assoc()) {

                          // List of folders
                          echo '<option value="'.$folder['id'].'">
                            '.ucfirst($core->getFolder($folder['id'])).'
                          </option>';
                        }
                      }

                    echo '</select>
                  </div>
                </diV>
                <div class="form-group row align-items-center">
                  <label for="password" class="form-control-label col-sm-3 text-md-right">
                    '.$lang['upload_FILE_PASSWORD'].'
                  </label>
                  <div class="col-sm-6 col-md-9">
                    <input type="password" name="password" value="" class="form-control">
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6 col-lg-12">
                <div class="form-group mb-0">
                  <label>
                    '.$lang['upload_FILE_DESCRIPTION'].'
                  </label>
                  <textarea name="description" class="form-control summernote-simple"></textarea>
                </div>
              </div>
              <p class="text-left text-muted">
                '.$lang['upload_FILE_WARNING'].'
              </p>
            </div>
          </div>
          <div class="card-footer text-right">
            <p id="used" style="color: red;"></p>
            <button type="button" data-toggle="tooltip" title="'.$lang['upload_FILE_USED'].' '.($core->size($core->set('upload_max_size') - $info['storage'])).' / '.$core->size($core->set('upload_max_size')).'" class="btn btn-default">
              '.$lang['upload_FILE_USED'].'
              '.($core->size($core->set('upload_max_size') - $info['storage'])).'
            </button>
            '.(($core->set('upload_max_size') - $info['storage']) == 0 ? '<button id="btn" type="button" class="btn btn-primary">'.$lang['upload_FILE_BTN'].'</button>' : '<button type="submit" name="upload" class="btn btn-primary">'.$lang['upload_FILE_BTN'].'</button>').'
          </div>
        </div>
      </form>
    </div>';
    
    // Add more, delete, used
    echo "<script>
      $(document).ready(function() {

        // Add more
        $('#add_more').on('click', function() {

          $('#area').append('<br/><br/><div class=\"custom-file\"><input type=\"file\" name=\"file[]\" class=\"custom-file-input\" multiple=\"multiple\"><label class=\"custom-file-label\">".$lang['upload_FILE_CF']."</label></div>');

          // Delete active
          if($('.custom-file').length == 4) {
            $('#add_more').remove();
          }
        });

        // Used
        $('#btn').on('click', function() {
          document.getElementById('used').innerHTML = '<i class=\"fas fa-exclamation\"></i> ".$lang['upload_FILE_USED2']."';
        });
        
      });
    </script>";
  } else {

    // Free account
    if(isset($_POST['upload'])) {

      // The files upload data
      $file_folder = strip_tags($core->filter_input($_POST['folder']));
      $file_description = $core->filter_input($_POST['description']);
      $file_password = strip_tags($core->filter_input($_POST['password']));

      if($file_folder == 'NULL') {

        // If user not selected the folder
        echo "<script>
          $(document).ready(function() {
            swal('".$lang['upload_FILE_NSF']."', {
              title: 'WARNING!',
              icon: 'warning',
              buttons: false,
              timer: 3000,
            });
          });
        </script>";
      } elseif(strlen($file_description) > 5000) {

        // Check the length of files description
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

        // Execute
        if(isset($_FILES['file'])) {

          // The files data
          $attach = $_FILES['file'];
          $file_count = count($attach['name']);

          if($file_count > 0) {
            for($x = 0; $x < $file_count; $x++) {
              if(!empty($attach['name'][$x])) {
                if($attach['error'][$x]) {

                  // Error messages
                  $messages = array(
                    1 => 'The uploaded file exceeds the UPLOAD_MAX_FILESIZE directive in php.ini',
                    2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
                    3 => 'The uploaded file was only partially uploaded',
                    4 => 'No file was uploaded',
                    5 => 'Missing a temporary folder'
                  );

                  // The message
                  echo "<script>
                    $(document).ready(function() {
                      iziToast.error({
                        title: 'WARNING!',
                        message: '".$messages[$attach['error'][$x]]."',
                        position: 'topLeft' 
                      });
                    });
                  </script>";
                }

                // The files system
                $file_name = $attach['name'][$x];
                $file_size = $attach['size'][$x];
                $file_type = $attach['type'][$x];
                $file_total_size = ($file_size + $info['storage']);
                $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                $file_directory = '../data/'.$core->username($session->is_login()).'';

                if($file_total_size > ($core->set('upload_max_size') / 2)) {

                  // The storage limit
                  echo "<script>
                    $(document).ready(function() {
                      swal('".$lang['upload_FILE_LS']."', {
                        title: 'WARNING!',
                        icon: 'warning',
                        buttons: false,
                        timer: 3000,
                      });
                    });
                  </script>";
                } elseif($file_size > ($core->set('file_max_size') / 2)) {

                  // If the files is bigger size
                  echo "<script>
                    $(document).ready(function() {
                      iziToast.warning({
                        title: 'WARNING!',
                        message: '".$file_name." ".$lang['upload_FILE_BS']."',
                        position: 'topLeft' 
                      });
                    });
                  </script>";
                } elseif(file_exists($file_directory.'/'.$file_name.'') || $intbyte->query("SELECT * FROM files WHERE name = '".$file_name."' AND user_id = '".$session->is_login()."'")->num_rows > 0) {

                  // The files exists
                  echo "<script>
                    $(document).ready(function() {
                      iziToast.warning({
                        title: 'WARNING!',
                        message: '".$file_name." ".$lang['upload_FILE_HU']."',
                        position: 'topLeft' 
                      });
                    });
                  </script>";
                } elseif(in_array(strtolower($file_ext), explode(',', strtolower(str_replace(' ', '', $core->set('not_allowed_extension')))))) {

                  // The extensions is not valid
                  echo "<script>
                    $(document).ready(function() {
                      iziToast.warning({
                        title: 'WARNING!',
                        message: '".$lang['upload_FILE_NAE']." ".$file_name." ".$lang['upload_FILE_NAE2']."',
                        position: 'topLeft' 
                      });
                    });
                  </script>";
                } else {

                  // Move the files uploaded
                  $move = move_uploaded_file($_FILES['file']['tmp_name'][$x], $file_directory.'/'.$file_name.'');
                  if($move) {

                    // Successfully moved the files
                    $id = $core->insert_data('files');
                    $i = $intbyte->query("INSERT INTO files (`id`, `name`, `folder`, `description`, `password`, `size`, `time`, `downloaded`, `views`, `user_id`, `report`, `token`) VALUES('".$id."', '".$file_name."', '".$file_folder."', '".$file_description."', '".(!empty($file_password) ? password_hash($file_password, PASSWORD_DEFAULT) : '')."', '".$file_size."', '".time()."', '0', '1', '".$session->is_login()."', '0', '".$core->genChar(15, TRUE)."');");
                    $u = $intbyte->query("UPDATE users SET files = files+1, storage = storage+".$file_size." WHERE id = '".$session->is_login()."'");

                    if($i && $u) {

                      // Successfully uploaded the files
                      echo "<script>
                        $(document).ready(function() {
                          iziToast.success({
                            title: 'SUCCESS!',
                            message: '".$file_name." ".$lang['upload_FILE_SS']."',
                            position: 'topLeft' 
                          });
                        });
                      </script>";
                    } else {

                      // Failed uploaded the files
                      echo "<script>
                        $(document).ready(function() {
                          iziToast.warning({
                            title: 'WARNING!',
                            message: '".$file_name." ".$lang['upload_FILE_FS']."',
                            position: 'topLeft' 
                          });
                        });
                      </script>";
                    }
                  } else {

                    // Failed moved the files
                    echo "<script>
                      $(document).ready(function() {
                        swal('".$lang['upload_FILE_FM']."', {
                          title: 'WARNING!',
                          icon: 'warning',
                          buttons: false,
                          timer: 3000,
                        });
                      });
                    </script>";
                  }
                }
              } else {
                
                // The files not uploaded contains
                if($file_count == 1) {
                  echo "<script>
                    $(document).ready(function() {
                      iziToast.warning({
                        title: 'WARNING!',
                        message: '".$lang['upload_FILE_NFS']."',
                        position: 'topLeft' 
                      });
                    });
                  </script>";
                } else {
                  echo "<script>
                    $(document).ready(function() {
                      iziToast.warning({
                        title: 'WARNING!',
                        message: '".$lang['upload_FILE_NFS2']."',
                        position: 'topLeft' 
                      });
                    });
                  </script>";
                }
              }
            }
          }
        }
      }
    }

    // HTML form
    echo '<div class="col-md-12">
      <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate="">
        <div class="card card-primary">
          <div class="card-header">
            <h4>
              '.$lang['upload_FILE'].'
            </h4>
          </div>
          <div class="card-body">
            <p class="text-muted">
              '.$lang['upload_FILE_TEXT'].' '.$core->size($core->set('file_max_size') / 2).'.
            </p>
            <div class="row">
              <div class="col-12 col-md-6 col-lg-6">
                <div class="form-group row align-items-center">
                  <label for="file" class="form-control-label">
                    <a id="add_more" href="javascript: void(0);" class="btn btn-sm btn-primary">
                      <i class="fas fa-plus"></i>
                    </a>
                    '.$lang['upload_FILE_SF2'].'
                  </label>
                  <div class="col-sm-6 col-md-6">
                    <div id="area">
                      <div class="custom-file">
                        <input type="file" name="file[]" class="custom-file-input" multiple="multiple">
                        <label class="custom-file-label">
                          '.$lang['upload_FILE_CF'].'
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 col-lg-6">
                <div class="form-group row align-items-center">
                  <label for="password" class="form-control-label col-sm-3 text-md-right">
                    '.$lang['upload_FILE_FOLDER'].'
                  </label>
                  <div class="col-sm-6 col-md-9">
                    <select name="folder" class="form-control select2" required="">
                      <option value="NULL">
                        '.$lang['upload_FILE_SF'].'
                      </option>';

                      // To get all the user folders
                      $q = $intbyte->query("SELECT * FROM folders WHERE user_id = '".$session->is_login()."' ORDER BY `id` DESC");
                      if($q->num_rows > 0) {
                        while($folder = $q->fetch_assoc()) {

                          // List of folders
                          echo '<option value="'.$folder['id'].'">
                            '.ucfirst($core->getFolder($folder['id'])).'
                          </option>';
                        }
                      }

                    echo '</select>
                  </div>
                </diV>
                <div class="form-group row align-items-center">
                  <label for="password" class="form-control-label col-sm-3 text-md-right">
                    '.$lang['upload_FILE_PASSWORD'].'
                  </label>
                  <div class="col-sm-6 col-md-9">
                    <input type="password" name="password" value="" class="form-control">
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6 col-lg-12">
                <div class="form-group mb-0">
                  <label>
                    '.$lang['upload_FILE_DESCRIPTION'].'
                  </label>
                  <textarea name="description" class="form-control summernote-simple"></textarea>
                </div>
              </div>
              <p class="text-left text-muted">
                '.$lang['upload_FILE_WARNING'].'
              </p>
            </div>
          </div>
          <div class="card-footer text-right">
            <p id="used" style="color: red;"></p>
            <button type="button" data-toggle="tooltip" title="'.$lang['upload_FILE_USED'].' '.($core->size(($core->set('upload_max_size') / 2) - $info['storage'])).' / '.$core->size($core->set('upload_max_size') / 2).'" class="btn btn-default">
              '.$lang['upload_FILE_USED'].'
              '.($core->size(($core->set('upload_max_size') / 2) - $info['storage'])).'
            </button>
            '.((($core->set('upload_max_size') / 2) - $info['storage']) == 0 ? '<button id="btn" type="button" class="btn btn-primary">'.$lang['upload_FILE_BTN'].'</button>' : '<button type="submit" name="upload" class="btn btn-primary">'.$lang['upload_FILE_BTN'].'</button>').'
          </div>
        </div>
      </form>
    </div>';
    
    // Add more, delete, used
    echo "<script>
      $(document).ready(function() {

        // Add more
        $('#add_more').on('click', function() {

          $('#area').append('<br/><br/><div class=\"custom-file\"><input type=\"file\" name=\"file[]\" class=\"custom-file-input\" multiple=\"multiple\"><label class=\"custom-file-label\">".$lang['upload_FILE_CF']."</label></div>');

          // Delete active
          if($('.custom-file').length == 2) {
            $('#add_more').remove();
          }
        });

        // Used
        $('#btn').on('click', function() {
          document.getElementById('used').innerHTML = '<i class=\"fas fa-exclamation\"></i> ".$lang['upload_FILE_USED2']."';
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
?>
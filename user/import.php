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
$title = $lang['import_FILE'];
require_once '../incfiles/header.php';

// If not an User, the system will be redirect to the index page or home page
if(!$session->is_login()) {
  $core->redirect(base_url().'/');
}

// The user informations
$q = $intbyte->query("SELECT * FROM users WHERE id = '".$session->is_login()."'");
$info = $q->fetch_assoc();

// Section import the files
echo '<section class="section">';

echo '<div class="section-header">
  <h1 class="section-title">
    '.$lang['import_FILE'].'
  </h1>
  <div class="section-header-breadcrumb">
    <div class="breadcrumb-item active">
      <a href="'.base_url().'/user/">
        Dashboard
      </a>
    </div>
    <div class="breadcrumb-item">
      '.$lang['import_FILE'].'
    </div>
  </div>
</div>';

echo '<div class="row">';

if($info['rights'] > 0) {

  // Unblocked user

  if($info['type'] == 1) {

    // Premium account
    if(isset($_POST['import'])) {

      // The files import data
      $file_folder = strip_tags($core->filter_input($_POST['folder']));
      $file_description = $core->filter_input($_POST['description']);
      $file_password = strip_tags($core->filter_input($_POST['password']));

      if($file_folder == 'NULL') {

        // If user not selected the folder
        echo "<script>
          $(document).ready(function() {
            swal('".$lang['import_FILE_NSF']."', {
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
            swal('".$lang['import_FILE_FD']."', {
              title: 'WARNING!',
              icon: 'warning',
              buttons: false,
              timer: 3000,
            });
          });
        </script>";
      } else {

        // Execute
        if(isset($_POST['url'])) {

          // The files data
          $file_count = count($_POST['url']);

          if($file_count > 0) {
            for($x = 0; $x < $file_count; $x++) {
              if(!empty($_POST['url'][$x])) {

                // The files system
                $file = @fopen($_POST['url'][$x], 'r');
                $file_name = $core->getWithoutPath($core->rm20($_POST['url'][$x]));
                if(!$file) {

                  // The url is not valid
                  echo "<script>
                    $(document).ready(function() {
                      iziToast.warning({
                        title: 'WARNING!',
                        message: '".$lang['import_FILE_IVU']."',
                        position: 'topLeft' 
                      });
                    });
                  </script>";
                } else {

                  // Get the files informations
                  $file_ext = strtolower(pathinfo($_POST['url'][$x], PATHINFO_EXTENSION));
                  $file_data = '';
                  while($file_read = @fread($file, 1024)) {
                    $file_data .= $file_read;
                    $file_read++;
                  }

                  // The files informations and close the informations
                  $file_size = strlen($file_data);
                  $file_total_size = ($file_size + $info['storage']);
                  @fclose($file);

                  if($file_total_size > $core->set('upload_max_size')) {

                    // The storage limit
                    echo "<script>
                      $(document).ready(function() {
                        swal('".$lang['import_FILE_LS']."', {
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
                          message: '".$file_name." ".$lang['import_FILE_BS']."',
                          position: 'topLeft' 
                        });
                      });
                    </script>";
                  } elseif(file_exists('../data/'.$core->username($info['id']).'/'.$file_name.'') || $intbyte->query("SELECT * FROM files WHERE name = '".$file_name."' AND user_id = '".$session->is_login()."'")->num_rows > 0) {

                    // The files exists
                    echo "<script>
                      $(document).ready(function() {
                        iziToast.warning({
                          title: 'WARNING!',
                          message: '".$file_name." ".$lang['import_FILE_HU']."',
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
                          message: '".$lang['import_FILE_NAE']." ".$file_name." ".$lang['import_FILE_NAE2']."',
                          position: 'topLeft' 
                        });
                      });
                    </script>";
                  } else {

                    // Move the files imported
                    $move = @file_put_contents('../data/'.$core->username($info['id']).'/'.$file_name.'', $file_data);
                    if($move) {

                      // Successfully moved the files
                      $id = $core->insert_data('files');
                      $i = $intbyte->query("INSERT INTO files (`id`, `name`, `folder`, `description`, `password`, `size`, `time`, `downloaded`, `views`, `user_id`, `report`, `token`) VALUES('".$id."', '".$file_name."', '".$file_folder."', '".$file_description."', '".(!empty($file_password) ? password_hash($file_password, PASSWORD_DEFAULT) : '')."', '".$file_size."', '".time()."', '0', '1', '".$session->is_login()."', '0', '".$core->genChar(15, TRUE)."');");
                      $u = $intbyte->query("UPDATE users SET files = files+1, storage = storage+".$file_size." WHERE id = '".$session->is_login()."'");

                      if($i && $u) {

                        // Successfully imported the files
                        echo "<script>
                          $(document).ready(function() {
                            iziToast.success({
                              title: 'SUCCESS!',
                              message: '".$file_name." ".$lang['import_FILE_SS']."',
                              position: 'topLeft' 
                            });
                          });
                        </script>";
                      } else {
  
                        // Failed imported the files
                        echo "<script>
                          $(document).ready(function() {
                            iziToast.warning({
                              title: 'WARNING!',
                              message: '".$file_name." ".$lang['import_FILE_FS']."',
                              position: 'topLeft' 
                            });
                          });
                        </script>";
                      }
                    } else {

                      // Failed moved the files
                      echo "<script>
                        $(document).ready(function() {
                          swal('".$lang['import_FILE_FM']."', {
                            title: 'WARNING!',
                            icon: 'warning',
                            buttons: false,
                            timer: 3000,
                          });
                        });
                      </script>";
                    }
                  }
                }
              } else {
                
                // The files not imported contains
                if($file_count == 1) {
                  echo "<script>
                    $(document).ready(function() {
                      iziToast.warning({
                        title: 'WARNING!',
                        message: '".$lang['import_FILE_NFS']."',
                        position: 'topLeft' 
                      });
                    });
                  </script>";
                } else {
                  echo "<script>
                    $(document).ready(function() {
                      iziToast.warning({
                        title: 'WARNING!',
                        message: '".$lang['import_FILE_NFS2']."',
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
      <form method="POST" class="needs-validation" novalidate="">
        <div class="card card-primary">
          <div class="card-header">
            <h4>
              '.$lang['import_FILE'].'
            </h4>
          </div>
          <div class="card-body">
            <p class="text-muted">
              '.$lang['import_FILE_TEXT2'].' '.$core->size($core->set('file_max_size')).'.
            </p>
            <div class="row">
              <div class="col-12 col-md-6 col-lg-6">
                <div class="form-group row align-items-center">
                  <label for="file" class="form-control-label">
                    <a id="add_more" href="javascript: void(0);" class="btn btn-sm btn-primary">
                      <i class="fas fa-plus"></i>
                    </a>
                    '.$lang['import_FILE_SF2'].'
                  </label>
                  <div class="col-sm-6 col-md-6">
                    <div id="area">
                      <div class="col-sm-6 col-md-9 url">
                        <input type="url" name="url[]" value="" placeholder="'.$lang['import_FILE_CF'].'" class="form-control">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 col-lg-6">
                <div class="form-group row align-items-center">
                  <label for="password" class="form-control-label col-sm-3 text-md-right">
                    '.$lang['import_FILE_FOLDER'].'
                  </label>
                  <div class="col-sm-6 col-md-9">
                    <select name="folder" class="form-control select2" required="">
                      <option value="NULL">
                        '.$lang['import_FILE_SF'].'
                      </option>';

                      // Get all the user folder
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
                </div>
                <div class="form-group row align-items-center">
                  <label for="password" class="form-control-label col-sm-3 text-md-right">
                    '.$lang['import_FILE_PASSWORD'].'
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
                    '.$lang['import_FILE_DESCRIPTION'].'
                  </label>
                  <textarea name="description" class="form-control summernote-simple"></textarea>
                </div>
              </div>
              <p class="text-left text-muted">
                '.$lang['import_FILE_WARNING'].'
              </p>
            </div>
          </div>
          <div class="card-footer text-right">
            <p id="used" style="color: red;"></p>
            <button type="button" data-toggle="tooltip" title="'.$lang['import_FILE_USED'].' '.($core->size($core->set('upload_max_size') - $info['storage'])).' / '.$core->size($core->set('upload_max_size')).'" class="btn btn-default">
              '.$lang['import_FILE_USED'].'
              '.($core->size($core->set('upload_max_size') - $info['storage'])).'
            </button>
            '.(($core->set('upload_max_size') - $info['storage']) == 0 ? '<button id="btn" type="button" class="btn btn-primary">'.$lang['import_FILE_BTN'].'</button>' : '<button type="submit" name="import" class="btn btn-primary">'.$lang['import_FILE_BTN'].'</button>').'
          </div>
        </div>
      </form>
    </div>';

    // Add more, used
    echo "<script>
      $(document).ready(function() {

        // Add more
        $('#add_more').on('click', function() {

          $('#area').append('<br/><div class=\"col-sm-6 col-md-9 url\"><input type=\"url\" name=\"url[]\" value=\"\" placeholder=\"http://\" class=\"form-control\"></div>');

          // Delete active
          if($('.url').length == 4) {
            $('#add_more').remove();
          }
        });

        // Used
        $('#btn').on('click', function() {
          document.getElementById('used').innerHTML = '<i class=\"fas fa-exclamation\"></i> ".$lang['import_FILE_USED2']."';
        });
        
      });
    </script>";
  } else {

    // Free account
    if(isset($_POST['import'])) {

      // The files import data
      $file_folder = strip_tags($core->filter_input($_POST['folder']));
      $file_description = $core->filter_input($_POST['description']);
      $file_password = strip_tags($core->filter_input($_POST['password']));

      if($file_folder == 'NULL') {

        // If user not selected the folder
        echo "<script>
          $(document).ready(function() {
            swal('".$lang['import_FILE_NSF']."', {
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
            swal('".$lang['import_FILE_FD']."', {
              title: 'WARNING!',
              icon: 'warning',
              buttons: false,
              timer: 3000,
            });
          });
        </script>";
      } else {

        // Execute
        if(isset($_POST['url'])) {

          // The files data
          $file_count = count($_POST['url']);

          if($file_count > 0) {
            for($x = 0; $x < $file_count; $x++) {
              if(!empty($_POST['url'][$x])) {

                // The files system
                $file = @fopen($_POST['url'][$x], 'r');
                $file_name = $core->getWithoutPath($core->rm20($_POST['url'][$x]));
                if(!$file) {

                  // The url is not valid
                  echo "<script>
                    $(document).ready(function() {
                      iziToast.warning({
                        title: 'WARNING!',
                        message: '".$lang['import_FILE_IVU']."',
                        position: 'topLeft' 
                      });
                    });
                  </script>";
                } else {

                  // Get the files informations
                  $file_ext = strtolower(pathinfo($_POST['url'][$x], PATHINFO_EXTENSION));
                  $file_data = '';
                  while($file_read = @fread($file, 1024)) {
                    $file_data .= $file_read;
                    $file_read++;
                  }

                  // The files informations and close the informations
                  $file_size = strlen($file_data);
                  $file_total_size = ($file_size + $info['storage']);
                  @fclose($file);

                  if($file_total_size > ($core->set('upload_max_size') / 2)) {

                    // The storage limit
                    echo "<script>
                      $(document).ready(function() {
                        swal('".$lang['import_FILE_LS']."', {
                          title: 'WARNING!',
                          icon: 'warning',
                          buttons: false,
                          timer: 3000,
                        });
                      });
                    </script>";
                  } elseif($file_size > ($core->set('file_max_size') / 2)) {

                    // If he files is bigger size
                    echo "<script>
                      $(document).ready(function() {
                        iziToast.warning({
                          title: 'WARNING!',
                          message: '".$file_name." ".$lang['import_FILE_BS']."',
                          position: 'topLeft' 
                        });
                      });
                    </script>";
                  } elseif(file_exists('../data/'.$core->username($info['id']).'/'.$file_name.'') || $intbyte->query("SELECT * FROM files WHERE name = '".$file_name."' AND user_id = '".$session->is_login()."'")->num_rows > 0) {

                    // The files exists
                    echo "<script>
                      $(document).ready(function() {
                        iziToast.warning({
                          title: 'WARNING!',
                          message: '".$file_name." ".$lang['import_FILE_HU']."',
                          position: 'topLeft' 
                        });
                      });
                    </script>";
                  } elseif(in_array(strtolower($file_ext), explode(',', strtolower(str_replace(' ', '', $core->set('not_allowed_extension')))))) {

                    // The extension is not valid
                    echo "<script>
                      $(document).ready(function() {
                        iziToast.warning({
                          title: 'WARNING!',
                          message: '".$lang['import_FILE_NAE']." ".$file_name." ".$lang['import_FILE_NAE2']."',
                          position: 'topLeft' 
                        });
                      });
                    </script>";
                  } else {

                    // Move the files imported
                    $move = @file_put_contents('../data/'.$core->username($info['id']).'/'.$file_name.'', $file_data);
                    if($move) {

                      // Successfully moved the files
                      $id = $core->insert_data('files');
                      $i = $intbyte->query("INSERT INTO files (`id`, `name`, `folder`, `description`, `password`, `size`, `time`, `downloaded`, `views`, `user_id`, `report`, `token`) VALUES('".$id."', '".$file_name."', '".$file_folder."', '".$file_description."', '".(!empty($file_password) ? password_hash($file_password, PASSWORD_DEFAULT) : '')."', '".$file_size."', '".time()."', '0', '1', '".$session->is_login()."', '0', '".$core->genChar(15, TRUE)."');");
                      $u = $intbyte->query("UPDATE users SET files = files+1, storage = storage+".$file_size." WHERE id = '".$session->is_login()."'");

                      if($i && $u) {

                        // Successfully imported the files
                        echo "<script>
                          $(document).ready(function() {
                            iziToast.success({
                              title: 'SUCCESS!',
                              message: '".$file_name." ".$lang['import_FILE_SS']."',
                              position: 'topLeft' 
                            });
                          });
                        </script>";
                      } else {
  
                        // Failed imported the files
                        echo "<script>
                          $(document).ready(function() {
                            iziToast.warning({
                              title: 'WARNING!',
                              message: '".$file_name." ".$lang['import_FILE_FS']."',
                              position: 'topLeft' 
                            });
                          });
                        </script>";
                      }
                    } else {

                      // Failed moved the files
                      echo "<script>
                        $(document).ready(function() {
                          swal('".$lang['import_FILE_FM']."', {
                            title: 'WARNING!',
                            icon: 'warning',
                            buttons: false,
                            timer: 3000,
                          });
                        });
                      </script>";
                    }
                  }
                }
              } else {
                
                // The files not imported contains
                if($file_count == 1) {
                  echo "<script>
                    $(document).ready(function() {
                      iziToast.warning({
                        title: 'WARNING!',
                        message: '".$lang['import_FILE_NFS']."',
                        position: 'topLeft' 
                      });
                    });
                  </script>";
                } else {
                  echo "<script>
                    $(document).ready(function() {
                      iziToast.warning({
                        title: 'WARNING!',
                        message: '".$lang['import_FILE_NFS2']."',
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
      <form method="POST" class="needs-validation" novalidate="">
        <div class="card card-primary">
          <div class="card-header">
            <h4>
              '.$lang['import_FILE'].'
            </h4>
          </div>
          <div class="card-body">
            <p class="text-muted">
              '.$lang['import_FILE_TEXT'].' '.$core->size($core->set('file_max_size') / 2).'.
            </p>
            <div class="row">
              <div class="col-12 col-md-6 col-lg-6">
                <div class="form-group row align-items-center">
                  <label for="file" class="form-control-label">
                    <a id="add_more" href="javascript: void(0);" class="btn btn-sm btn-primary">
                      <i class="fas fa-plus"></i>
                    </a>
                    '.$lang['import_FILE_SF2'].'
                  </label>
                  <div class="col-sm-6 col-md-6">
                    <div id="area">
                      <div class="col-sm-6 col-md-9 url">
                        <input type="url" name="url[]" value="" placeholder="'.$lang['import_FILE_CF'].'" class="form-control">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 col-lg-6">
                <div class="form-group row align-items-center">
                  <label for="password" class="form-control-label col-sm-3 text-md-right">
                    '.$lang['import_FILE_FOLDER'].'
                  </label>
                  <div class="col-sm-6 col-md-9">
                    <select name="folder" class="form-control select2" required="">
                      <option value="NULL">
                        '.$lang['import_FILE_SF'].'
                      </option>';

                      // Get all the user folders
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
                </div>
                <div class="form-group row align-items-center">
                  <label for="password" class="form-control-label col-sm-3 text-md-right">
                    '.$lang['import_FILE_PASSWORD'].'
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
                    '.$lang['import_FILE_DESCRIPTION'].'
                  </label>
                  <textarea name="description" class="form-control summernote-simple"></textarea>
                </div>
              </div>
              <p class="text-left text-muted">
                '.$lang['import_FILE_WARNING'].'
              </p>
            </div>
          </div>
          <div class="card-footer text-right">
            <p id="used" style="color: red;"></p>
            <button type="button" data-toggle="tooltip" title="'.$lang['import_FILE_USED'].' '.($core->size(($core->set('upload_max_size') / 2) - $info['storage'])).' / '.$core->size($core->set('upload_max_size') / 2).'" class="btn btn-default">
              '.$lang['import_FILE_USED'].'
              '.($core->size(($core->set('upload_max_size') / 2) - $info['storage'])).'
            </button>
            '.((($core->set('upload_max_size') / 2) - $info['storage']) == 0 ? '<button id="btn" type="button" class="btn btn-primary">'.$lang['import_FILE_BTN'].'</button>' : '<button type="submit" name="import" class="btn btn-primary">'.$lang['import_FILE_BTN'].'</button>').'
          </div>
        </div>
      </form>
    </div>';

    // Add more, used
    echo "<script>
      $(document).ready(function() {

        // Add More
        $('#add_more').on('click', function() {

          $('#area').append('<br/><div class=\"col-sm-6 col-md-9 url\"><input type=\"url\" name=\"url[]\" value=\"\" placeholder=\"http://\" class=\"form-control\"></div>');

          // Delete active
          if($('.url').length == 2) {
            $('#add_more').remove();
          }
        });

        // Used
        $('#btn').on('click', function() {
          document.getElementById('used').innerHTML = '<i class=\"fas fa-exclamation\"></i> ".$lang['import_FILE_USED2']."';
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
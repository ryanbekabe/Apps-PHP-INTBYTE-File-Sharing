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

  case 'drop':

    // Drop all notifications
    if(isset($_GET['do']) && !empty($_GET['do'])) {
      if(urlencode($_GET['do']) == 'action') {

        $q = $intbyte->query("SELECT * FROM notifications WHERE notification_for = 'Admin'");
        if($q->num_rows > 0) {

          // Execute
          $d = $intbyte->query("DELETE FROM notifications WHERE notification_for = 'Admin'");
          if($d) {

            // Successfully dropped all notifications
            $core->redirect(base_url().'/admin/manage-notifications/?view=notifications&type=archive');
          } else {

            // Failed dropped all notifications
            $core->redirect(base_url().'/admin/manage-notifications/?view=notifications&type=archive');
          }
        } else {

          // Data not available
          $core->redirect(base_url().'/admin/manage-notifications/?view=notifications&type=archive');
        }
      } else {

        // Illegal access
        $core->redirect(base_url().'/admin/manage-notifications/?view=notifications&type=archive');
      }
    } else {

      // Illegal access
      $core->redirect(base_url().'/admin/manage-notifications/?view=notifications&type=archive');
    }
  break;

  case 'deleted':

    // Delete the notifications
    if(isset($_GET['id']) && !empty($_GET['id'])) {

      $id = intval($_GET['id']);
      $q = $intbyte->query("SELECT * FROM notifications WHERE notification_for = 'Admin' AND id = ".$id."");
      if($q->num_rows > 0) {

        // Execute
        $d = $intbyte->query("DELETE FROM notifications WHERE notification_for = 'Admin' AND id = ".$id."");
        if($d) {

          // Successfully deleted the notifications
          $core->redirect(base_url().'/admin/manage-notifications/?view=notifications&type=new');
        } else {

          // Failed deleted the notifications
          $core->redirect(base_url().'/admin/manage-notifications/?view=notifications&type=new');
        }
      } else {

        // Data not available
        $core->redirect(base_url().'/admin/manage-notifications/?view=notifications&type=new');
      }
    } else {

      // Illegal access
      $core->redirect(base_url().'/admin/manage-notifications/');
    }
  break;

  case 'read':

    // Read the notification
    if(isset($_GET['id']) && !empty($_GET['id'])) {

      $id = intval($_GET['id']);
      $q = $intbyte->query("SELECT * FROM notifications WHERE notification_for = 'Admin' AND status = 'Unread' AND id = ".$id."");
      if($q->num_rows > 0) {

        // Execute
        $d = $intbyte->query("UPDATE notifications SET status = 'Read' WHERE notification_for = 'Admin' AND id = ".$id."");
        if($d) {

          // Successfully read the notification
          $core->redirect(base_url().'/admin/manage-notifications/?view=notifications&type=new');
        } else {

          // Failed read the notification
          $core->redirect(base_url().'/admin/manage-notifications/?view=notifications&type=new');
        }
      } else {

        // Data not available
        $core->redirect(base_url().'/admin/manage-notifications/?view=notifications&type=new');
      }
    } else {

      // Illegal access
      $core->redirect(base_url().'/admin/manage-notifications/');
    }
  break;

  case 'notifications':

    // Types of notifications
    if(isset($_GET['type'])) {
      if(urlencode($_GET['type']) == 'create') {

        // Create a new notification
        // Headers
        $title = $lang['notify_CREATE'];
        require_once '../incfiles/header.php';
    
        // If not an Administrator, the system will be redirect to the index page or home page
        if(!$session->is_login() || $session-> is_rights() > 1) {
          $core->redirect(base_url().'/');
        }

        // Section create a new notification
        echo '<section class="section">';

        echo '<div class="section-header">
          <h1 class="section-title">
            '.$lang['notify_CREATE'].'
          </h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="'.base_url().'/admin/">
                Dashboard
              </a>
            </div>
            <div class="breadcrumb-item">
              '.$lang['notify_CREATE'].'
            </div>
          </div>
        </div>';

        echo '<div class="row">';

        if(isset($_POST['submit'])) {

          // Notifications data
          $title = strip_tags($core->filter_input($_POST['title']));
          $type = strip_tags($core->filter_input($_POST['type']));
          $to = strip_tags($core->filter_input($_POST['to']));
          $message = strip_tags($core->filter_input($_POST['message']));

          if(empty($title) || empty($message)) {

            // Empty data
            echo "<script>
              $(document).ready(function() {
                swal('".$lang['notify_CREATE_EMPTXT']."', {
                  title: 'WARNING!',
                  icon: 'warning',
                  buttons: false,
                  timer: 3000,
                });
              });
            </script>";
          } elseif(strlen($title) < 5 || str_word_count($title) < 2) {

            // Check the length of the title
            echo "<script>
              $(document).ready(function() {
                swal('".$lang['notify_CREATE_LENTL']."', {
                  title: 'WARNING!',
                  icon: 'warning',
                  buttons: false,
                  timer: 3000,
                });
              });
            </script>";
          } elseif($type == 'NULL' || $to == 'NULL') {

            // Check the selected type
            echo "<script>
              $(document).ready(function() {
                swal('".$lang['notify_CREATE_CS']."', {
                  title: 'WARNING!',
                  icon: 'warning',
                  buttons: false,
                  timer: 3000,
                });
              });
            </script>";
          } elseif(strlen($message) < 25 || str_word_count($message) < 5) {

            // Check the length of the message
            echo "<script>
              $(document).ready(function() {
                swal('".$lang['notify_CREATE_LENMSG']."', {
                  title: 'WARNING!',
                  icon: 'warning',
                  buttons: false,
                  timer: 3000,
                });
              });
            </script>";
          } else {

            // Insert the data into the database
            $id = $core->insert_data('notifications');
            $i = $intbyte->query("INSERT INTO notifications (`id`, `title`, `content`, `time`, `status`, `type`, `user_id`, `notification_for`) VALUES ('".$id."', '".$core->escapeToDB($title)."', '".$core->escapeToDB($message)."', '".time()."', 'Unread', '".$type."', '".$to."', 'User')");
            if($i) {

              // Successfully created notification
              echo "<script>
                $(document).ready(function() {
                  swal('".$lang['notify_CREATE_SUCCESS']."', {
                    title: 'SUCCESS!',
                    icon: 'success',
                    buttons: false,
                    timer: 3000,
                  }).then(function() {
                    window.location = '".base_url()."/admin/manage-notifications/?view=notifications&type=create';
                  });
                });
              </script>";
            } else {

              // Failed created notification
              echo "<script>
                $(document).ready(function() {
                  swal('".$lang['notify_CREATE_FAILED']."', {
                    title: 'WARNING!',
                    icon: 'warning',
                    buttons: false,
                    timer: 3000,
                  }).then(function() {
                    window.location = '".base_url()."/admin/manage-notifications/?view=notifications&type=create';
                  });
                });
              </script>";
            }
          }
        }

        // HTML form
        echo '<div class="col-12 col-md-6 col-lg-6">
          <div class="card card-primary">
            <form name="inputForm" method="POST" role="form" class="needs-validation" novalidate="">
              <div class="card-header">
                <h4>
                  '.$lang['notify_CREATE'].'
                </h4>
              </div>
              <div class="card-body">
                <div class="form-group mb-0">
                  <label>
                    '.$lang['notify_CREATE_TITLE'].'
                  </label>
                  <input name="title" type="text" value="" class="form-control" required="" autofocus>
                  <div class="invalid-feedback">
                    '.$lang['notify_CREATE_TFB'].'
                  </div>
                </div>
                <div class="form-group mb-0">
                  <label>
                    '.$lang['notify_CREATE_ST'].'
                  </label>
                  <select name="type" class="form-control" required="">
                    <option value="NULL">
                      '.$lang['notify_CREATE_ST'].'
                    </option>
                    <option value="fas fa-info">
                      '.$lang['notify_CREATE_STN'].'
                    </option>
                    <option value="fas fa-info-circle">
                      '.$lang['notify_CREATE_STI'].'
                    </option>
                    <option value="fas fa-tags">
                      '.$lang['notify_CREATE_STT'].'
                    </option>
                    <option value="fas fa-user">
                      '.$lang['notify_CREATE_STU'].'
                    </option>
                  </select>
                  <div class="invalid-feedback">
                    '.$lang['notify_CREATE_DLFB'].'
                  </div>
                </div>
                  <div class="form-group mb-0">
                    <label>
                      '.$lang['notify_CREATE_TO'].'
                    </label>
                    <select name="to" class="form-control select2" required="">
                      <option value="NULL">
                        '.$lang['notify_CREATE_STO'].'
                      </option>';

                    $q = $intbyte->query("SELECT * FROM users WHERE id != '1' AND status = '1' ORDER BY `id` ASC");
                    if($q->num_rows > 0) {
                      while($user = $q->fetch_assoc()) {

                        // List of users
                        echo '<option value="'.$user['id'].'">
                          '.$user['fullname'].'
                        </option>';

                        // Do not remove this line because it is important
                        $user++;
                      }
                    }

                    echo '</select>
                      <div class="invalid-feedback">
                      '.$lang['notify_CREATE_TFB'].'
                    </div>
                  </div>
                <div class="form-group mb-0">
                  <label>
                    '.$lang['notify_CREATE_MESSAGE'].'
                  </label>
                  <textarea name="message" class="form-control" required=""></textarea>
                  <div class="invalid-feedback">
                    '.$lang['notify_CREATE_MFB'].'
                  </div>
                </div>
              </div>
              <div class="card-footer text-right">
                <button type="reset" name="message" class="btn btn-defautlt">
                  '.$lang['notify_CREATE_RBTN'].'
                </button>
                <button type="submit" name="submit" class="btn btn-primary">
                  '.$lang['notify_CREATE_SBTN'].'
                </button>
              </div>
            </form>
          </div>
        </div>';

        // Latest create notification
        echo '<div class="col-12 col-md-6 col-lg-6">
          <div class="card card-primary">
            <div class="card-header">
              <h4>
                '.$lang['notify_CREATE_LU'].'
              </h4>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover mb-0">
                  <tbody>';

        $q = $intbyte->query("SELECT * FROM notifications WHERE notification_for = 'User' ORDER BY `id` DESC LIMIT 9");
        if($q->num_rows > 0) {

          while($notify = $q->fetch_assoc()) {

            // List of notifications
            echo '<tr>
              <td>
                '.($notify['type'] == 'fas fa-info' ? '<span class="badge badge-danger badge-rounded">
                  <i class="fas fa-info"></i>
                </span>' : ($notify['type'] == 'fas fa-tags' ? '<span class="badge badge-primary badge-rounded">
                  <i class="fas fa-tags"></i>
                </span>' : ($notify['type'] == 'fas fa-info-circle' ? '<span class="badge badge-warning badge-rounded">
                  <i class="fas fa-info"></i>
                </span>' : '<span class="badge badge-warning badge-rounded">
                  <i class="fas fa-users"></i>
                </span>'))).'
                <a id="read-'.$notify['id'].'" href="javascript: void(0);">
                  '.(strlen($notify['title']) > 50 ? substr($notify['title'], 0, 50).'..' : $notify['title']).'
                </a>
                <div class="table-links text-right">
                  '.$lang['notify_CREATE_BY'].'
                  <a href="'.base_url().'/user/'.$core->username($session->is_login()).'">
                    '.$core->username($notify['user_id']).'
                  </a>
                  <div class="bullet"></div>
                    '.($notify['status'] == 'Unread' ? $lang['notify_NEW_UNREAD'] : $lang['notify_NEW_READ']).'
                  <div class="bullet"></div>
                  '.$time->timeAgo($notify['time']).'
                </div>
              </td>
            </tr>';

            // Read the notification
            echo "<script>
              $(document).ready(function() {

                // Read the last update notification
                $('#read-".$notify['id']."').on('click', function() {
                  $('#read-".$notify['id']."').fireModal({
                    title: '".$notify['title']."',
                    body: '".$core->filter_output($notify['content'], TRUE)."',
                    footerClass: 'bg-whitesmoke',
                    buttons: [
                      {
                        text: '".$lang['notify_DONE_BTN']."',
                        class: 'btn btn-danger btn-shadow',
                        handler: function(modal) {
                          if(modal) {
                            window.location = '".base_url()."/admin/manage-notifications/?view=notifications&type=create';
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
            $notify++;
          }
        } else {

          // Data not available
          echo '<tr>
            <td>
              <marquee scrollamount="2" scrolldelay="2">
                '.$lang['notify_CREATE_NF'].'
              </marquee>
            </td>
          </tr>';
        }

        echo '</tbody>
              </table>
              </div>
            </div>
          </div>
        </div>';

        echo '</div>';
        echo '</section>';
        require_once '../incfiles/footer.php';
      } elseif(urlencode($_GET['type']) == 'new') {

        // Latest notifications
        // Headers
        $title = $lang['notify_NEW'];
        require_once '../incfiles/header.php';
    
        // If not an Administrator, the system will be redirect to the index page or home page
        if(!$session->is_login() || $session-> is_rights() > 1) {
          $core->redirect(base_url().'/');
        }

        // Section latest notifications
        echo '<section class="section">';

        echo '<div class="section-header">
          <h1 class="section-title">
            '.$lang['notify_NEW'].'
          </h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="'.base_url().'/admin/">
                Dashboard
              </a>
            </div>
            <div class="breadcrumb-item">
              '.$lang['notify_NEW'].'
            </div>
          </div>
        </div>';

        echo '<div class="row">';

        echo '<div class="col-12">
          <div class="card card-primary">
            <div class="card-header">
              <h4>
                '.$lang['notify_NEW'].'
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
                      '.$lang['notify_NEW_TITLE'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['notify_NEW_CONTENT'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['notify_NEW_ON_DATE'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['notify_NEW_BY'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['notify_NEW_STATUS'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['notify_NEW_ACTION'].'
                    </center>
                  </th>
                </tr>';
        
        $q = $intbyte->query("SELECT * FROM notifications WHERE notification_for = 'Admin' AND status = 'Unread' ORDER BY `id` DESC LIMIT ".$start.", ".$core->set('paging')."");
        $all = $intbyte->query("SELECT * FROM notifications WHERE notification_for = 'Admin' AND status = 'Unread'")->num_rows;
        if($q->num_rows > 0) {

          $no = 1;
          while($notify = $q->fetch_assoc()) {

            // List of notifications
            echo '<tr>
              <td class="align-middle">
                <center>
                  '.$no.'
                </center>
              </td>
              <td class="align-middle">
                '.(strlen($notify['title']) > 50 ? substr($notify['title'], 0, 50).'...' : $notify['title']).'
              </td>
              <td class="align-middle">
                '.(strlen($notify['content']) > 50 ? substr($notify['content'], 0, 50).'...' : $notify['content']).'
              </td>
              <td>
                '.$time->timeAgo($notify['time']).'
              </td>
              <td class="align-middle">
                <img alt="image" src="'.base_url().'/'.$core->show_avatar($notify['user_id']).'" class="rounded-circle" width="35" data-toggle="tooltip" title="'.$core->username($notify['user_id']).'">
                '.$core->username($notify['user_id']).'
              </td>
              <td class="align-middle">
                <div class="badge badge-warning">
                  '.$lang['notify_NEW_UNREAD'].'
                </div>
              </td>
              <td class="align-middle">
                <center>
                  <a id="read-'.$notify['id'].'" class="btn btn-success btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['notify_NEW_BDWN_READ'].'" href="javascript: void(0);">
                    <i class="fas fa-eye"></i>
                  </a>
                  <a id="delete-'.$notify['id'].'" class="btn btn-danger btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['userAds_BDWN_DELETE'].'" href="javascript: void(0);">
                    <i class="fas fa-trash"></i>
                  </a>
                </center>
              </td>
            </tr>';

            // Manage Notifications: Read the notification, delete the notification
            echo "<script>
              $(document).ready(function() {

                // Read the notification
                $('#read-".$notify['id']."').on('click', function() {
                  $('#read-".$notify['id']."').fireModal({
                    title: '".$notify['title']."',
                    body: '".$core->filter_output($notify['content'], TRUE)."',
                    footerClass: 'bg-whitesmoke',
                    buttons: [
                      {
                        text: '".$lang['notify_DONE_BTN']."',
                        class: 'btn btn-danger btn-shadow',
                        handler: function(modal) {
                          if(modal) {
                            window.location = '".base_url()."/admin/manage-notifications/?view=read&id=".$notify['id']."';
                          }
                        }
                      }
                    ],
                    center: true
                  });
                });

                // Delete the notification
                $('#delete-".$notify['id']."').on('click', function() {
                  swal({
                    title: '".$lang['notify_NEW_CONFIRM_AYS']."',
                    text: '".$lang['notify_NEW_CONDELETE_TEXT']."',
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
                        window.location = '".base_url()."/admin/manage-notifications/?view=deleted&id=".$notify['id']."';
                      });
                    } else {
                      swal('".$lang['notify_NEW_CONDELETE_CANCEL']."', {
                        buttons: false,
                        timer: 3000,
                      });
                    }
                  });
                });

              });
            </script>";

            // Do not remove this line because it is important
            $notify++;
            $no++;
          }

          // Pagination
          echo '</table>
              </div>
            </div>
            <div class="card-footer text-right">
              '.$paging->showPage($all, $page, $core->set('paging'), base_url().'/admin/manage-notifications/?view=notifications&type=new&').'
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
      } elseif(urlencode($_GET['type']) == 'archive') {

        // Archive notifications
        // Headers
        $title = $lang['notify_NEW_ARCHIVE'];
        require_once '../incfiles/header.php';
    
        // If not an Administrator, the system will be redirect to the index page or home page
        if(!$session->is_login() || $session-> is_rights() > 1) {
          $core->redirect(base_url().'/');
        }

        // Section archive notifications
        echo '<section class="section">';

        echo '<div class="section-header">
          <h1 class="section-title">
            '.$lang['notify_NEW_ARCHIVE'].'
          </h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="'.base_url().'/admin/">
                Dashboard
              </a>
            </div>
            <div class="breadcrumb-item">
              '.$lang['notify_NEW_ARCHIVE'].'
            </div>
          </div>
        </div>';

        echo '<div class="row">';

        echo '<div class="col-12">
          <div class="card card-primary">
            <div class="card-header">
              <h4>
                '.$lang['notify_NEW_ARCHIVE'].'
              </h4>
              <div class="card-header-action">
                <a id="drop" href="javascript: void(0);" class="btn btn-primary btn-icon icon-right" data-toggle="tooltip" title="'.$lang['notify_DROP_ALL2'].'">
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
                      '.$lang['notify_NEW_TITLE'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['notify_NEW_CONTENT'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['notify_NEW_ON_DATE'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['notify_NEW_BY'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['notify_NEW_STATUS'].'
                    </center>
                  </th>
                  <th class="align-middle">
                    <center>
                      '.$lang['notify_NEW_ACTION'].'
                    </center>
                  </th>
                </tr>';
        
        $q = $intbyte->query("SELECT * FROM notifications WHERE notification_for = 'Admin' AND status = 'Read' ORDER BY `id` DESC LIMIT ".$start.", ".$core->set('paging')."");
        $all = $intbyte->query("SELECT * FROM notifications WHERE notification_for = 'Admin' AND status = 'Read'")->num_rows;
        if($q->num_rows > 0) {

          $no = 1;
          while($notify = $q->fetch_assoc()) {

            // List of notifications
            echo '<tr>
              <td class="align-middle">
                <center>
                  '.$no.'
                </center>
              </td>
              <td class="align-middle">
                '.(strlen($notify['title']) > 50 ? substr($notify['title'], 0, 50).'..' : $notify['title']).'
              </td>
              <td class="align-middle">
                '.(strlen($notify['content']) > 50 ? substr($notify['content'], 0, 50).'..' : $notify['content']).'
              </td>
              <td>
                '.$time->timeAgo($notify['time']).'
              </td>
              <td class="align-middle">
                <img alt="image" src="'.base_url().'/'.$core->show_avatar($notify['user_id']).'" class="rounded-circle" width="35" data-toggle="tooltip" title="'.$core->username($notify['user_id']).'">
                '.$core->username($notify['user_id']).'
              </td>
              <td class="align-middle">
                <div class="badge badge-success">
                  '.$lang['notify_NEW_READ'].'
                </div>
              </td>
              <td class="align-middle">
                <center>
                  <a id="read-'.$notify['id'].'" class="btn btn-success btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['notify_NEW_BDWN_READ'].'" href="javascript: void(0);">
                    <i class="fas fa-eye"></i>
                  </a>
                  <a id="delete-'.$notify['id'].'" class="btn btn-danger btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['userAds_BDWN_DELETE'].'" href="javascript: void(0);">
                    <i class="fas fa-trash"></i>
                  </a>
                </center>
              </td>
            </tr>';

            // Manage Notifications: Read the notification, delete the notification
            echo "<script>
              $(document).ready(function() {

                // Read the notification
                $('#read-".$notify['id']."').on('click', function() {
                  $('#read-".$notify['id']."').fireModal({
                    title: '".$notify['title']."',
                    body: '".$core->filter_output($notify['content'], TRUE)."',
                    footerClass: 'bg-whitesmoke',
                    buttons: [
                      {
                        text: '".$lang['notify_DONE_BTN']."',
                        class: 'btn btn-danger btn-shadow',
                        handler: function(modal) {
                          if(modal) {
                            window.location = '".base_url()."/admin/manage-notifications/?view=notifications&type=archive';
                          }
                        }
                      }
                    ],
                    center: true
                  });
                });

                // Delete the notification
                $('#delete-".$notify['id']."').on('click', function() {
                  swal({
                    title: '".$lang['notify_NEW_CONFIRM_AYS']."',
                    text: '".$lang['notify_NEW_CONDELETE_TEXT']."',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                  }).then((willDelete) => {
                    if(willDelete) {
                      swal('".$lang['notify_NEW_CONDELETE_SUCCESS']."', {
                        icon: 'success',
                        buttons: false,
                        timer: 3000,
                      }).then(function() {
                        window.location = '".base_url()."/admin/manage-notifications/?view=deleted&id=".$notify['id']."';
                      });
                    } else {
                      swal('".$lang['notify_NEW_CONDELETE_CANCEL']."', {
                        buttons: false,
                        timer: 3000,
                      });
                    }
                  });
                });

                // Drop all notifications
                $('#drop').on('click', function() {
                  swal({
                    title: '".$lang['notify_NEW_CONFIRM_AYS']."',
                    text: '".$lang['notify_NEW_CONDROP_TEXT']."',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                  }).then((willDrop) => {
                    if(willDrop) {
                      swal('".$lang['notify_NEW_CONDROP_SUCCESS']."', {
                        icon: 'success',
                        buttons: false,
                        timer: 3000,
                      }).then(function() {
                        window.location = '".base_url()."/admin/manage-notifications/?view=drop&do=action';
                      });
                    } else {
                      swal('".$lang['notify_NEW_CONDROP_CANCEL']."', {
                        buttons: false,
                        timer: 3000,
                      });
                    }
                  });
                });

              });
            </script>";

            // Do not remove this line because it is important
            $notify++;
            $no++;
          }

          // Pagination
          echo '</table>
              </div>
            </div>
            <div class="card-footer text-right">
              '.$paging->showPage($all, $page, $core->set('paging'), base_url().'/admin/manage-notifications/?view=notifications&type=archive&').'
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
        $core->redirect(base_url().'/admin/manage-notifications/');
      }
    } else {

      // Illegal access
      $core->redirect(base_url().'/admin/manage-notifications/');
    }
  break;

  default:

    // Illegal Access
    // If there is access to this page then the system will direct to the main page Administrator
    $core->redirect(base_url().'/admin/');
  break;
}
?>
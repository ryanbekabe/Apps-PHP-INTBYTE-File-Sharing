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

  case 'drop':

    // Drop all notifications
    if(isset($_GET['do']) && !empty($_GET['do'])) {
      if(urlencode($_GET['do']) == 'action') {

        $q = $intbyte->query("SELECT * FROM notifications WHERE user_id = '".$info['id']."' AND notification_for = 'User'");
        if($q->num_rows > 0) {

          // Execute
          $d = $intbyte->query("DELETE FROM notifications WHERE user_id = '".$info['id']."' AND notification_for = 'User'");
          if($d) {

            // Successfully dropped the notifications
            $core->redirect(base_url().'/user/notifications/?view=notifications&type=archive');
          } else {

            // Failed dropped the notifications
            $core->redirect(base_url().'/user/notifications/?view=notifications&type=archive');
          }
        } else {

          // Data not available
          $core->redirect(base_url().'/user/notifications/?view=notifications&type=archive');
        }
      } else {

        // Illegal access
        $core->redirect(base_url().'/user/notifications/?view=notifications&type=archive');
      }
    } else {

      // Illegal access
      $core->redirect(base_url().'/user/notifications/?view=notifications&type=archive');
    }
  break;

  case 'deleted':

    // Delete the notifications
    if(isset($_GET['id']) && !empty($_GET['id'])) {

      $id = intval($_GET['id']);
      $q = $intbyte->query("SELECT * FROM notifications WHERE user_id = '".$info['id']."' AND notification_for = 'User' AND id = ".$id."");
      if($q->num_rows > 0) {

        // Execute
        $d = $intbyte->query("DELETE FROM notifications WHERE user_id = '".$info['id']."' AND notification_for = 'User' AND id = ".$id."");
        if($d) {

          // Successfully deleted the notifications
          $core->redirect(base_url().'/user/notifications/?view=notifications&type=new');
        } else {

          // Failed deleted the notifications
          $core->redirect(base_url().'/user/notifications/?view=notifications&type=new');
        }
      } else {

        // Data not available
        $core->redirect(base_url().'/user/notifications/?view=notifications&type=new');
      }
    } else {

      // Illegal access
      $core->redirect(base_url().'/user/notifications/');
    }
  break;

  case 'read':

    // Read the notifications
    if(isset($_GET['id']) && !empty($_GET['id'])) {

      $id = intval($_GET['id']);
      $q = $intbyte->query("SELECT * FROM notifications WHERE user_id = '".$info['id']."' AND notification_for = 'User' AND status = 'Unread' AND id = ".$id."");
      if($q->num_rows > 0) {

        // Execute
        $d = $intbyte->query("UPDATE notifications SET status = 'Read' WHERE user_id = '".$info['id']."' AND notification_for = 'User' AND id = ".$id."");
        if($d) {

          // Successfully readed the notifications
          $core->redirect(base_url().'/user/notifications/?view=notifications&type=new');
        } else {

          // Failed readed the notifications
          $core->redirect(base_url().'/user/notifications/?view=notifications&type=new');
        }
      } else {

        // Data not available
        $core->redirect(base_url().'/user/notifications/?view=notifications&type=new');
      }
    } else {

      // Illegal access
      $core->redirect(base_url().'/user/notifications/');
    }
  break;

  case 'notifications':

    // Types of the notifications
    if(isset($_GET['type'])) {
      if(urlencode($_GET['type']) == 'new') {

        // The new notifications
        // Headers
        $title = $lang['notify_NEW'];
        require_once '../incfiles/header.php';
    
        // If not an User, the system will be redirect to the index page or home page
        if(!$session->is_login()) {
          $core->redirect(base_url().'/');
        }

        // Section the new notifications
        echo '<section class="section">';

        echo '<div class="section-header">
          <h1 class="section-title">
            '.$lang['notify_NEW'].'
          </h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="'.base_url().'/user/">
                Dashboard
              </a>
            </div>
            <div class="breadcrumb-item">
              '.$lang['notify_NEW'].'
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
          
          $q = $intbyte->query("SELECT * FROM notifications WHERE user_id = '".$info['id']."' AND notification_for = 'User' AND status = 'Unread' ORDER BY `id` DESC LIMIT ".$start.", ".$core->set('paging')."");
          $all = $intbyte->query("SELECT * FROM notifications WHERE user_id = '".$info['id']."' AND notification_for = 'User' AND status = 'Unread'")->num_rows;
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
                  <img alt="image" src="'.base_url().'/'.$core->show_avatar($notify['user_id']).'" data-toggle="tooltip" title="'.$info['fullname'].'" class="rounded-circle" width="35">
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
                    <a id="delete-'.$notify['id'].'" class="btn btn-danger btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['userAds_BDWN_PREVIEW'].'" href="javascript: void(0);">
                      <i class="fas fa-trash"></i>
                    </a>
                  </center>
                </td>
              </tr>';

              // Manage Notifications: Read, delete
              echo "<script>
                $(document).ready(function() {

                  // Read
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
                              window.location = '".base_url()."/user/notifications/?view=read&id=".$notify['id']."';
                            }
                          }
                        }
                      ],
                      center: true
                    });
                  });

                  // Delete
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
                          title: 'SUCCESS!',
                          icon: 'success',
                          buttons: false,
                          timer: 3000,
                        }).then(function() {
                          window.location = '".base_url()."/user/notifications/?view=deleted&id=".$notify['id']."';
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
                '.$paging->showPage($all, $page, $core->set('paging'), base_url().'/user/notifications/?view=notifications&type=new&').'
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
        } else {

          // Blocked user
          $core->redirect(base_url().'/user/notifications/');
        }

        echo '</div>';
        echo '</section>';
        require_once '../incfiles/footer.php';
      } elseif(urlencode($_GET['type']) == 'archive') {

        // Archive the notifications
        // Headers
        $title = $lang['notify_NEW_ARCHIVE'];
        require_once '../incfiles/header.php';
    
        // If not an User, the system will be redirect to the index page or home page
        if(!$session->is_login()) {
          $core->redirect(base_url().'/');
        }

        // Section the notifications
        echo '<section class="section">';

        echo '<div class="section-header">
          <h1 class="section-title">
            '.$lang['notify_NEW_ARCHIVE'].'
          </h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="'.base_url().'/user/">
                Dashboard
              </a>
            </div>
            <div class="breadcrumb-item">
              '.$lang['notify_NEW_ARCHIVE'].'
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
          
          $q = $intbyte->query("SELECT * FROM notifications WHERE user_id = '".$info['id']."' AND notification_for = 'User' AND status = 'Read' ORDER BY `id` DESC LIMIT ".$start.", ".$core->set('paging')."");
          $all = $intbyte->query("SELECT * FROM notifications WHERE user_id = '".$info['id']."' AND notification_for = 'User' AND status = 'Read'")->num_rows;
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
                  <img alt="image" src="'.base_url().'/'.$core->show_avatar($notify['user_id']).'" data-toggle="tooltip" title="'.$info['fullname'].'" class="rounded-circle" width="35">
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

              // Manage Notifications: Read, delete
              echo "<script>
                $(document).ready(function() {

                  // Read
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
                              window.location = '".base_url()."/user/notifications/?view=read&id=".$notify['id']."';
                            }
                          }
                        }
                      ],
                      center: true
                    });
                  });

                  // Delete
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
                          title: 'SUCCESS!',
                          icon: 'success',
                          buttons: false,
                          timer: 3000,
                        }).then(function() {
                          window.location = '".base_url()."/user/notifications/?view=deleted&id=".$notify['id']."';
                        });
                      } else {
                        swal('".$lang['notify_NEW_CONDELETE_CANCEL']."', {
                          buttons: false,
                          timer: 3000,
                        });
                      }
                    });
                  });

                  // Drop all
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
                          title: 'SUCCESS!',
                          icon: 'success',
                          buttons: false,
                          timer: 3000,
                        }).then(function() {
                          window.location = '".base_url()."/user/notifications/?view=drop&do=action';
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
                '.$paging->showPage($all, $page, $core->set('paging'), base_url().'/user/notifications/?view=notifications&type=archive&').'
              </div>
            </div>
            </div>';
          } else {

            // Data not found
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
        } else {

          // Blocked user
          $core->redirect(base_url().'/user/notifications/');
        }

        echo '</div>';
        echo '</section>';
        require_once '../incfiles/footer.php';
      } else {

        // Illegal access
        $core->redirect(base_url().'/user/notifications/');
      }
    } else {

      // Illegal access
      $core->redirect(base_url().'/user/notifications/');
    }
  break;

  default:

    // Illegal Access
    // If there is access to this page then the system will direct to the main page User
    $core->redirect(base_url().'/user/');
  break;
}
?>
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

  case 'deleted':

    // Action to delete
    if(isset($_GET['id']) && !empty($_GET['id'])) {

      $id = intval($_GET['id']);
      if($intbyte->query("UPDATE ads SET status = 'D' WHERE id = ".$id."")) {

        // Successfully updated the user ads
        $core->redirect(base_url().'/user/my-ads/?view=ads&type=deleted');
      } else {

        // Failed updated the user ads
        $core->redirect(base_url().'/user/my-ads/');
      }
    } else {

      // Illegal access
      $core->redirect(base_url().'/user/my-ads/');
    }
  break;

  case 'ads':

    // Types of the user ads
    if(isset($_GET['type'])) {
      if(urlencode($_GET['type']) == 'create') {

        // Create a new user ads
        // Headers
        $title = $lang['myads_CREATE'];
        require_once '../incfiles/header.php';

        // Section create a new user ads
        echo '<section class="section">';

        echo '<div class="section-header">
          <h1 class="section-title">
            '.$lang['myads_CREATE'].'
          </h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="'.base_url().'/user/">
                Dashboard
              </a>
            </div>
            <div class="breadcrumb-item">
              '.$lang['myads_CREATE'].'
            </div>
          </div>
        </div>';

        echo '<div class="row">';

        if($info['rights'] > 0) {

          // Unblocked user
          if($info['type'] == 1) {

            // Premium account
            if(isset($_POST['create'])) {

              // The user ads data
              $ads = $core->filter_input($_POST['ads']);
              $type = array(
                '<?php',
                'alert'
              );

              if(empty($ads)) {

                // Empty data
                echo "<script>
                  $(document).ready(function() {
                    swal('".$lang['myads_CREATE_EUA']."', {
                      title: 'WARNING!',
                      icon: 'warning',
                      buttons: false,
                      timer: 3000,
                    });
                  });
                </script>";
              } elseif(in_array($ads, $type)) {

                // The user ads is not valid
                echo "<script>
                  $(document).ready(function() {
                    swal('".$lang['myads_CREATE_IUA']."', {
                      title: 'WARNING!',
                      icon: 'warning',
                      buttons: false,
                      timer: 3000,
                    });
                  });
                </script>";
              } elseif($intbyte->query("SELECT * FROM ads WHERE content = '".$ads."' AND user_id = '".$info['id']."' AND status = 'B'")->num_rows > 0) {

                // The user ads has been blocked
                echo "<script>
                  $(document).ready(function() {
                    swal('".$lang['myads_CREATE_UAB']."', {
                      title: 'WARNING!',
                      icon: 'warning',
                      buttons: false,
                      timer: 3000,
                    });
                  });
                </script>";
              } elseif($intbyte->query("SELECT * FROM ads WHERE content = '".$ads."' AND user_id = '".$info['id']."'")->num_rows > 0) {

                // The user ads is exists
                echo "<script>
                  $(document).ready(function() {
                    swal('".$lang['myads_CREATE_UAE']."', {
                      title: 'WARNING!',
                      icon: 'warning',
                      buttons: false,
                      timer: 3000,
                    });
                  });
                </script>";
              } else {

                // Insert data
                $id = $core->insert_data('ads');
                $i = $intbyte->query("INSERT INTO ads (`id`, `content`, `type`, `time`, `user_id`, `status`) VALUES('".$id."', '".$ads."', '1', '".time()."', '".$info['id']."', 'A');");
                if($i) {

                  // Successfully created the new user ads
                  echo "<script>
                    $(document).ready(function() {
                      swal('".$lang['myads_CREATE_SS']."', {
                        title: 'SUCCESS!',
                        icon: 'success',
                        buttons: false,
                        timer: 3000,
                      }).then(function() {
                        window.location = '".base_url()."/user/my-ads/?view=ads&type=approved';
                      });
                    });
                  </script>";
                } else {

                  // Failed create the new user ads
                  echo "<script>
                    $(document).ready(function() {
                      swal('".$lang['myads_CREATE_FS']."', {
                        title: 'WARNING!',
                        icon: 'warning',
                        buttons: false,
                        timer: 3000,
                      }).then(function() {
                        window.location = '".base_url()."/user/my-ads/?view=ads&type=create';
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
                      '.$lang['myads_CREATE'].'
                    </h4>
                  </div>
                  <div class="card-body">
                    <p class="text-muted">
                      '.$lang['myads_CREATE_TEXT'].'
                    </p>
                    <div class="form-group mb-0">
                      <lable>
                        '.$lang['myads_CREATE_UA'].'
                      </lable>
                      <textarea name="ads" class="form-control summernote-simple" required=""></textarea>
                      <div class="invalid-feedback">
                        '.$lang['myads_CREATE_IFBUA'].'
                      </div>
                      <p class="text-muted">
                        '.$lang['myads_CREATE_WARNING'].'
                      </p>
                    </div>
                  </div>
                  <div class="card-footer text-right">
                    <button type="reset" name="ads" class="btn btn-defautlt">
                      '.$lang['myads_CREATE_CLEAR'].'
                    </button>
                    <button type="submit" name="create" class="btn btn-primary">
                      '.$lang['myads_CREATE_PUBLISH'].'
                    </button>
                  </div>
                </form>
              </div>
            </div>';
          } else {

            // Free account
            if(isset($_POST['create'])) {

              // The user ads data
              $ads = $core->filter_input($_POST['ads']);
              $type = array(
                '<?php',
                'alert'
              );

              if(empty($ads)) {

                // Empty data
                echo "<script>
                  $(document).ready(function() {
                    swal('".$lang['myads_CREATE_EUA']."', {
                      title: 'WARNING!',
                      icon: 'warning',
                      buttons: false,
                      timer: 3000,
                    });
                  });
                </script>";
              } elseif(in_array($ads, $type)) {

                // The user ads is not valid
                echo "<script>
                  $(document).ready(function() {
                    swal('".$lang['myads_CREATE_IUA']."', {
                      title: 'WARNING!',
                      icon: 'warning',
                      buttons: false,
                      timer: 3000,
                    });
                  });
                </script>";
              } elseif($intbyte->query("SELECT * FROM ads WHERE content = '".$ads."' AND user_id = '".$info['id']."' AND status = 'B'")->num_rows > 0) {

                // The user ads has been blocked
                echo "<script>
                  $(document).ready(function() {
                    swal('".$lang['myads_CREATE_UAB']."', {
                      title: 'WARNING!',
                      icon: 'warning',
                      buttons: false,
                      timer: 3000,
                    });
                  });
                </script>";
              } elseif($intbyte->query("SELECT * FROM ads WHERE content = '".$ads."' AND user_id = '".$info['id']."'")->num_rows > 0) {

                // The user ads is exists
                echo "<script>
                  $(document).ready(function() {
                    swal('".$lang['myads_CREATE_UAE']."', {
                      title: 'WARNING!',
                      icon: 'warning',
                      buttons: false,
                      timer: 3000,
                    });
                  });
                </script>";
              } else {

                // Insert data
                $id = $core->insert_data('ads');
                $i = $intbyte->query("INSERT INTO ads (`id`, `content`, `type`, `time`, `user_id`, `status`) VALUES('".$id."', '".$ads."', '2', '".time()."', '".$info['id']."', 'W');");
                if($i) {

                  // Successfully created the new user ads
                  echo "<script>
                    $(document).ready(function() {
                      swal('".$lang['myads_CREATE_SS2']."', {
                        title: 'SUCCESS!',
                        icon: 'success',
                        buttons: false,
                        timer: 3000,
                      }).then(function() {
                        window.location = '".base_url()."/user/my-ads/?view=ads&type=wait_to_approve';
                      });
                    });
                  </script>";
                } else {

                  // Failed created the new user ads
                  echo "<script>
                    $(document).ready(function() {
                      swal('".$lang['myads_CREATE_FS2']."', {
                        title: 'WARNING!',
                        icon: 'warning',
                        buttons: false,
                        timer: 3000,
                      }).then(function() {
                        window.location = '".base_url()."/user/my-ads/?view=ads&type=create';
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
                      '.$lang['myads_CREATE'].'
                    </h4>
                  </div>
                  <div class="card-body">
                    <p class="text-muted">
                      '.$lang['myads_CREATE_TEXT2'].'
                    </p>
                    <div class="form-group mb-0">
                      <lable>
                        '.$lang['myads_CREATE_UA'].'
                      </lable>
                      <textarea name="ads" class="form-control summernote-simple" required=""></textarea>
                      <div class="invalid-feedback">
                        '.$lang['myads_CREATE_IFBUA'].'
                      </div>
                      <p class="text-muted">
                        '.$lang['myads_CREATE_WARNING'].'
                      </p>
                    </div>
                  </div>
                  <div class="card-footer text-right">
                    <button type="reset" name="ads" class="btn btn-defautlt">
                      '.$lang['myads_CREATE_CLEAR'].'
                    </button>
                    <button type="submit" name="create" class="btn btn-primary">
                      '.$lang['myads_CREATE_PUBLISH'].'
                    </button>
                  </div>
                </form>
              </div>
            </div>';
          }
        } else {

          // Blocked user
          $core->redirect(base_url().'/user/my-ads/');
        }

        echo '</div>';
        echo '</section>';
        require_once '../incfiles/footer.php';
      } elseif(urlencode($_GET['type']) == 'approved') {

        // Approved user ads
        // Headers
        $title = $lang['myads_APPROVE'];
        require_once '../incfiles/header.php';

        // Section approved user ads
        echo '<section class="section">';

        echo '<div class="section-header">
          <h1 class="section-title">
            '.$lang['myads_APPROVE'].'
          </h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="'.base_url().'/user/">
                Dashboard
              </a>
            </div>
            <div class="breadcrumb-item">
              '.$lang['myads_APPROVE'].'
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
                  '.$lang['myads_APPROVE'].'
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
                        '.$lang['myads_CONTENT'].'
                      </center>
                    </th>
                    <th class="align-middle">
                      <center>
                        '.$lang['myads_ON_DATE'].'
                      </center>
                    </th>
                    <th class="align-middle">
                      <center>
                        '.$lang['myads_ADS_BY'].'
                      </center>
                    </th>
                    <th class="align-middle">
                      <center>
                        '.$lang['myads_STATUS'].'
                      </center>
                    </th>
                    <th class="align-middle">
                      <center>
                        '.$lang['myads_ACTION'].'
                      </center>
                    </th>
                  </tr>';
          
          $q = $intbyte->query("SELECT * FROM ads WHERE user_id = '".$info['id']."' AND status = 'A' ORDER BY `id` DESC LIMIT ".$start.", ".$core->set('paging')."");
          $all = $intbyte->query("SELECT * FROM ads WHERE user_id = '".$info['id']."' AND status = 'A'")->num_rows;
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
                  <img alt="image" src="'.base_url().'/'.$core->show_avatar($user_ads['user_id']).'" data-toggle="tooltip" title="'.$info['fullname'].'" class="rounded-circle" width="35">
                  '.$core->username($user_ads['user_id']).'
                </td>
                <td class="align-middle">
                  '.$core->status_ads($user_ads['status']).'
                </td>
                <td class="align-middle">
                  <center>
                    <a id="delete-'.$user_ads['id'].'" class="btn btn-danger btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['myads_BDWN_DELETE'].'" href="javascript: void(0);">
                      <i class="fas fa-trash"></i>
                    </a>
                    <a id="preview-'.$user_ads['id'].'" class="btn btn-primary btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['myads_BDWN_PREVIEW'].'" href="javascript: void(0);">
                      <i class="fas fa-eye"></i>
                    </a>
                  </center>
                </td>
              </tr>';

              // Delete, preview
              echo "<script>
                $(document).ready(function() {

                  // Delete ads
                  $('#delete-".$user_ads['id']."').on('click', function() {
                    swal({
                      title: '".$lang['userAds_CONFIRM_AYS']."',
                      text: '".$lang['myads_CONDELETE_TEXT']."',
                      icon: 'warning',
                      buttons: true,
                      dangerMode: true,
                    }).then((willDelete) => {
                      if(willDelete) {
                        swal('".$lang['myads_CONDELETE_SUCCESS']."', {
                          title: 'SUCCESS!',
                          icon: 'success',
                          buttons: false,
                          timer: 3000,
                        }).then(function() {
                          window.location = '".base_url()."/user/my-ads/?view=deleted&id=".$user_ads['id']."';
                        });
                      } else {
                        swal('".$lang['myads_CONDELETE_CANCEL']."', {
                          buttons: false,
                          timer: 3000,
                        });
                      }
                    });
                  });

                  // Preview ads
                  $('#preview-".$user_ads['id']."').on('click', function() {
                    $('#preview-".$user_ads['id']."').fireModal({
                      title: '".$lang['myads_BDWN_PREVIEW']."',
                      body: '".$core->filter_output($user_ads['content'], TRUE)."',
                      footerClass: 'bg-whitesmoke',
                      buttons: [
                        {
                          text: '".$lang['notify_DONE_BTN']."',
                          class: 'btn btn-danger btn-shadow',
                          handler: function(modal) {
                            if(modal) {
                              window.location = '".base_url()."/user/my-ads/?view=ads&type=approved';
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
                '.$paging->showPage($all, $page, $core->set('paging'), base_url().'/user/my-ads/?view=ads&type=approved&').'
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
          $core->redirect(base_url().'/user/my-ads/');
        }

        echo '</div>';
        echo '</section>';
        require_once '../incfiles/footer.php';
      } elseif(urlencode($_GET['type']) == 'rejected') {

        // Rejected user ads
        // Headers
        $title = $lang['myads_REJECTED'];
        require_once '../incfiles/header.php';

        // Section rejected user ads
        echo '<section class="section">';

        echo '<div class="section-header">
          <h1 class="section-title">
            '.$lang['myads_REJECTED'].'
          </h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="'.base_url().'/user/">
                Dashboard
              </a>
            </div>
            <div class="breadcrumb-item">
              '.$lang['myads_REJECTED'].'
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
                  '.$lang['myads_REJECTED'].'
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
                        '.$lang['myads_CONTENT'].'
                      </center>
                    </th>
                    <th class="align-middle">
                      <center>
                        '.$lang['myads_ON_DATE'].'
                      </center>
                    </th>
                    <th class="align-middle">
                      <center>
                        '.$lang['myads_ADS_BY'].'
                      </center>
                    </th>
                    <th class="align-middle">
                      <center>
                        '.$lang['myads_STATUS'].'
                      </center>
                    </th>
                    <th class="align-middle">
                      <center>
                        '.$lang['myads_ACTION'].'
                      </center>
                    </th>
                  </tr>';
          
          $q = $intbyte->query("SELECT * FROM ads WHERE user_id = '".$info['id']."' AND status = 'R' ORDER BY `id` DESC LIMIT ".$start.", ".$core->set('paging')."");
          $all = $intbyte->query("SELECT * FROM ads WHERE user_id = '".$info['id']."' AND status = 'R'")->num_rows;
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
                  <img alt="image" src="'.base_url().'/'.$core->show_avatar($user_ads['user_id']).'" data-toggle="tooltip" title="'.$info['fullname'].'" class="rounded-circle" width="35">
                  '.$core->username($user_ads['user_id']).'
                </td>
                <td class="align-middle">
                  '.$core->status_ads($user_ads['status']).'
                </td>
                <td class="align-middle">
                  <center>
                    <a id="delete-'.$user_ads['id'].'" class="btn btn-danger btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['myads_BDWN_DELETE'].'" href="javascript: void(0);">
                      <i class="fas fa-trash"></i>
                    </a>
                    <a id="preview-'.$user_ads['id'].'" class="btn btn-primary btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['myads_BDWN_PREVIEW'].'" href="javascript: void(0);">
                      <i class="fas fa-eye"></i>
                    </a>
                  </center>
                </td>
              </tr>';

              // Delete, preview
              echo "<script>
                $(document).ready(function() {

                  // Delete ads
                  $('#delete-".$user_ads['id']."').on('click', function() {
                    swal({
                      title: '".$lang['userAds_CONFIRM_AYS']."',
                      text: '".$lang['myads_CONDELETE_TEXT']."',
                      icon: 'warning',
                      buttons: true,
                      dangerMode: true,
                    }).then((willDelete) => {
                      if(willDelete) {
                        swal('".$lang['myads_CONDELETE_SUCCESS']."', {
                          title: 'SUCCESS!',
                          icon: 'success',
                          buttons: false,
                          timer: 3000,
                        }).then(function() {
                          window.location = '".base_url()."/user/my-ads/?view=deleted&id=".$user_ads['id']."';
                        });
                      } else {
                        swal('".$lang['myads_CONDELETE_CANCEL']."', {
                          buttons: false,
                          timer: 3000,
                        });
                      }
                    });
                  });

                  // Preview ads
                  $('#preview-".$user_ads['id']."').on('click', function() {
                    $('#preview-".$user_ads['id']."').fireModal({
                      title: '".$lang['myads_BDWN_PREVIEW']."',
                      body: '".$core->filter_output($user_ads['content'], TRUE)."',
                      footerClass: 'bg-whitesmoke',
                      buttons: [
                        {
                          text: '".$lang['notify_DONE_BTN']."',
                          class: 'btn btn-danger btn-shadow',
                          handler: function(modal) {
                            if(modal) {
                              window.location = '".base_url()."/user/my-ads/?view=ads&type=rejected';
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
                '.$paging->showPage($all, $page, $core->set('paging'), base_url().'/user/my-ads/?view=ads&type=rejected&').'
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
          $core->redirect(base_url().'/user/my-ads/');
        }

        echo '</div>';
        echo '</section>';
        require_once '../incfiles/footer.php';
      } elseif(urlencode($_GET['type']) == 'blocked') {

        // Blocked user ads
        // Headers
        $title = $lang['myads_BLOCKED'];
        require_once '../incfiles/header.php';

        // Section user ads
        echo '<section class="section">';

        echo '<div class="section-header">
          <h1 class="section-title">
            '.$lang['myads_BLOCKED'].'
          </h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="'.base_url().'/user/">
                Dashboard
              </a>
            </div>
            <div class="breadcrumb-item">
              '.$lang['myads_BLOCKED'].'
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
                  '.$lang['myads_BLOCKED'].'
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
                        '.$lang['myads_CONTENT'].'
                      </center>
                    </th>
                    <th class="align-middle">
                      <center>
                        '.$lang['myads_ON_DATE'].'
                      </center>
                    </th>
                    <th class="align-middle">
                      <center>
                        '.$lang['myads_ADS_BY'].'
                      </center>
                    </th>
                    <th class="align-middle">
                      <center>
                        '.$lang['myads_STATUS'].'
                      </center>
                    </th>
                    <th class="align-middle">
                      <center>
                        '.$lang['myads_ACTION'].'
                      </center>
                    </th>
                  </tr>';
          
          $q = $intbyte->query("SELECT * FROM ads WHERE user_id = '".$info['id']."' AND status = 'B' ORDER BY `id` DESC LIMIT ".$start.", ".$core->set('paging')."");
          $all = $intbyte->query("SELECT * FROM ads WHERE user_id = '".$info['id']."' AND status = 'B'")->num_rows;
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
                  <img alt="image" src="'.base_url().'/'.$core->show_avatar($user_ads['user_id']).'" data-toggle="tooltip" title="'.$info['fullname'].'" class="rounded-circle" width="35">
                  '.$core->username($user_ads['user_id']).'
                </td>
                <td class="align-middle">
                  '.$core->status_ads($user_ads['status']).'
                </td>
                <td class="align-middle">
                  <center>
                    <a id="delete-'.$user_ads['id'].'" class="btn btn-danger btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['myads_BDWN_DELETE'].'" href="javascript: void(0);">
                      <i class="fas fa-trash"></i>
                    </a>
                    <a id="preview-'.$user_ads['id'].'" class="btn btn-primary btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['myads_BDWN_PREVIEW'].'" href="javascript: void(0);">
                      <i class="fas fa-eye"></i>
                    </a>
                  </center>
                </td>
              </tr>';

              // Delete, preview
              echo "<script>
                $(document).ready(function() {

                  // Delete ads
                  $('#delete-".$user_ads['id']."').on('click', function() {
                    swal({
                      title: '".$lang['userAds_CONFIRM_AYS']."',
                      text: '".$lang['myads_CONDELETE_TEXT']."',
                      icon: 'warning',
                      buttons: true,
                      dangerMode: true,
                    }).then((willDelete) => {
                      if(willDelete) {
                        swal('".$lang['myads_CONDELETE_SUCCESS']."', {
                          title: 'SUCCESS!',
                          icon: 'success',
                          buttons: false,
                          timer: 3000,
                        }).then(function() {
                          window.location = '".base_url()."/user/my-ads/?view=deleted&id=".$user_ads['id']."';
                        });
                      } else {
                        swal('".$lang['myads_CONDELETE_CANCEL']."', {
                          buttons: false,
                          timer: 3000,
                        });
                      }
                    });
                  });

                  // Preview ads
                  $('#preview-".$user_ads['id']."').on('click', function() {
                    $('#preview-".$user_ads['id']."').fireModal({
                      title: '".$lang['myads_BDWN_PREVIEW']."',
                      body: '".$core->filter_output($user_ads['content'], TRUE)."',
                      footerClass: 'bg-whitesmoke',
                      buttons: [
                        {
                          text: '".$lang['notify_DONE_BTN']."',
                          class: 'btn btn-danger btn-shadow',
                          handler: function(modal) {
                            if(modal) {
                              window.location = '".base_url()."/user/my-ads/?view=ads&type=blocked';
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
                '.$paging->showPage($all, $page, $core->set('paging'), base_url().'/user/my-ads/?view=ads&type=blocked&').'
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
          $core->redirect(base_url().'/user/my-ads/');
        }

        echo '</div>';
        echo '</section>';
        require_once '../incfiles/footer.php';
      } elseif(urlencode($_GET['type']) == 'deleted') {

        // Deleted user ads
        // Headers
        $title = $lang['myads_DELETED'];
        require_once '../incfiles/header.php';

        // Section deleted user ads
        echo '<section class="section">';

        echo '<div class="section-header">
          <h1 class="section-title">
            '.$lang['myads_DELETED'].'
          </h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="'.base_url().'/user/">
                Dashboard
              </a>
            </div>
            <div class="breadcrumb-item">
              '.$lang['myads_DELETED'].'
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
                  '.$lang['myads_DELETED'].'
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
                        '.$lang['myads_CONTENT'].'
                      </center>
                    </th>
                    <th class="align-middle">
                      <center>
                        '.$lang['myads_ON_DATE'].'
                      </center>
                    </th>
                    <th class="align-middle">
                      <center>
                        '.$lang['myads_ADS_BY'].'
                      </center>
                    </th>
                    <th class="align-middle">
                      <center>
                        '.$lang['myads_STATUS'].'
                      </center>
                    </th>
                    <th class="align-middle">
                      <center>
                        '.$lang['myads_ACTION'].'
                      </center>
                    </th>
                  </tr>';
          
          $q = $intbyte->query("SELECT * FROM ads WHERE user_id = '".$info['id']."' AND status = 'D' ORDER BY `id` DESC LIMIT ".$start.", ".$core->set('paging')."");
          $all = $intbyte->query("SELECT * FROM ads WHERE user_id = '".$info['id']."' AND status = 'D'")->num_rows;
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
                  <img alt="image" src="'.base_url().'/'.$core->show_avatar($user_ads['user_id']).'" data-toggle="tooltip" title="'.$info['fullname'].'" class="rounded-circle" width="35">
                  '.$core->username($user_ads['user_id']).'
                </td>
                <td class="align-middle">
                  '.$core->status_ads($user_ads['status']).'
                </td>
                <td class="align-middle">
                  <center>
                    <a id="delete-'.$user_ads['id'].'" class="btn btn-danger btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['myads_BDWN_DELETE'].'" href="javascript: void(0);">
                      <i class="fas fa-trash"></i>
                    </a>
                    <a id="preview-'.$user_ads['id'].'" class="btn btn-primary btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['myads_BDWN_PREVIEW'].'" href="javascript: void(0);">
                      <i class="fas fa-eye"></i>
                    </a>
                  </center>
                </td>
              </tr>';

              // Delete, preview
              echo "<script>
                $(document).ready(function() {

                  // Delete ads
                  $('#delete-".$user_ads['id']."').on('click', function() {
                    swal({
                      title: '".$lang['userAds_CONFIRM_AYS']."',
                      text: '".$lang['myads_CONDELETE_TEXT']."',
                      icon: 'warning',
                      buttons: true,
                      dangerMode: true,
                    }).then((willDelete) => {
                      if(willDelete) {
                        swal('".$lang['myads_CONDELETE_SUCCESS']."', {
                          title: 'SUCCESS!',
                          icon: 'success',
                          buttons: false,
                          timer: 3000,
                        }).then(function() {
                          window.location = '".base_url()."/user/my-ads/?view=deleted&id=".$user_ads['id']."';
                        });
                      } else {
                        swal('".$lang['myads_CONDELETE_CANCEL']."', {
                          buttons: false,
                          timer: 3000,
                        });
                      }
                    });
                  });

                  // Preview ads
                  $('#preview-".$user_ads['id']."').on('click', function() {
                    $('#preview-".$user_ads['id']."').fireModal({
                      title: '".$lang['myads_BDWN_PREVIEW']."',
                      body: '".$core->filter_output($user_ads['content'], TRUE)."',
                      footerClass: 'bg-whitesmoke',
                      buttons: [
                        {
                          text: '".$lang['notify_DONE_BTN']."',
                          class: 'btn btn-danger btn-shadow',
                          handler: function(modal) {
                            if(modal) {
                              window.location = '".base_url()."/user/my-ads/?view=ads&type=deleted';
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
                '.$paging->showPage($all, $page, $core->set('paging'), base_url().'/user/my-ads/?view=ads&type=deleted&').'
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
          $core->redirect(base_url().'/user/my-ads/');
        }

        echo '</div>';
        echo '</section>';
        require_once '../incfiles/footer.php';
      } elseif(urlencode($_GET['type']) == 'wait_to_approve') {

        // Wait to approve
        // Headers
        $title = $lang['myads_WTA'];
        require_once '../incfiles/header.php';

        // Section wait to approve
        echo '<section class="section">';

        echo '<div class="section-header">
          <h1 class="section-title">
            '.$lang['myads_WTA'].'
          </h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="'.base_url().'/user/">
                Dashboard
              </a>
            </div>
            <div class="breadcrumb-item">
              '.$lang['myads_WTA'].'
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
                  '.$lang['myads_WTA'].'
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
                        '.$lang['myads_CONTENT'].'
                      </center>
                    </th>
                    <th class="align-middle">
                      <center>
                        '.$lang['myads_ON_DATE'].'
                      </center>
                    </th>
                    <th class="align-middle">
                      <center>
                        '.$lang['myads_ADS_BY'].'
                      </center>
                    </th>
                    <th class="align-middle">
                      <center>
                        '.$lang['myads_STATUS'].'
                      </center>
                    </th>
                    <th class="align-middle">
                      <center>
                        '.$lang['myads_ACTION'].'
                      </center>
                    </th>
                  </tr>';
          
          $q = $intbyte->query("SELECT * FROM ads WHERE user_id = '".$info['id']."' AND status = 'W' ORDER BY `id` DESC LIMIT ".$start.", ".$core->set('paging')."");
          $all = $intbyte->query("SELECT * FROM ads WHERE user_id = '".$info['id']."' AND status = 'W'")->num_rows;
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
                  <img alt="image" src="'.base_url().'/'.$core->show_avatar($user_ads['user_id']).'" data-toggle="tooltip" title="'.$info['fullname'].'" class="rounded-circle" width="35">
                  '.$core->username($user_ads['user_id']).'
                </td>
                <td class="align-middle">
                  '.$core->status_ads($user_ads['status']).'
                </td>
                <td class="align-middle">
                  <center>
                    <a id="delete-'.$user_ads['id'].'" class="btn btn-danger btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['myads_BDWN_DELETE'].'" href="javascript: void(0);">
                      <i class="fas fa-trash"></i>
                    </a>
                    <a id="preview-'.$user_ads['id'].'" class="btn btn-primary btn-sm btn-icon icon-center" data-toggle="tooltip" title="'.$lang['myads_BDWN_PREVIEW'].'" href="javascript: void(0);">
                      <i class="fas fa-eye"></i>
                    </a>
                  </center>
                </td>
              </tr>';

              // Delete, preview
              echo "<script>
                $(document).ready(function() {

                  // Delete ads
                  $('#delete-".$user_ads['id']."').on('click', function() {
                    swal({
                      title: '".$lang['userAds_CONFIRM_AYS']."',
                      text: '".$lang['myads_CONDELETE_TEXT']."',
                      icon: 'warning',
                      buttons: true,
                      dangerMode: true,
                    }).then((willDelete) => {
                      if(willDelete) {
                        swal('".$lang['myads_CONDELETE_SUCCESS']."', {
                          title: 'SUCCESS!',
                          icon: 'success',
                          buttons: false,
                          timer: 3000,
                        }).then(function() {
                          window.location = '".base_url()."/user/my-ads/?view=deleted&id=".$user_ads['id']."';
                        });
                      } else {
                        swal('".$lang['myads_CONDELETE_CANCEL']."', {
                          buttons: false,
                          timer: 3000,
                        });
                      }
                    });
                  });

                  // Preview ads
                  $('#preview-".$user_ads['id']."').on('click', function() {
                    $('#preview-".$user_ads['id']."').fireModal({
                      title: '".$lang['myads_BDWN_PREVIEW']."',
                      body: '".$core->filter_output($user_ads['content'], TRUE)."',
                      footerClass: 'bg-whitesmoke',
                      buttons: [
                        {
                          text: '".$lang['notify_DONE_BTN']."',
                          class: 'btn btn-danger btn-shadow',
                          handler: function(modal) {
                            if(modal) {
                              window.location = '".base_url()."/user/my-ads/?view=ads&type=wait_to_approve';
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
                '.$paging->showPage($all, $page, $core->set('paging'), base_url().'/user/my-ads/?view=ads&type=wait_to_approve&').'
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
          $core->redirect(base_url().'/user/my-ads/');
        }

        echo '</div>';
        echo '</section>';
        require_once '../incfiles/footer.php';
      } else {

        // Illegal access
        $core->redirect(base_url().'/user/my-ads/');
      }
    } else {

      // Illegal access
      $core->redirect(base_url().'/user/my-ads/');
    }
  break;

  default:

    // Illegal Access
    // If there is access to this page then the system will direct to the main page User
    $core->redirect(base_url().'/user/');
  break;
}
?>
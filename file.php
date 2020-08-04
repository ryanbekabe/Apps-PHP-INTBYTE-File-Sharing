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
require_once 'incfiles/connect.php';
require_once 'helpers/coreFunc.class.php';
require_once 'incfiles/lib/mp3.php';

$act = isset($_GET['act']) ? trim($_GET['act']) : '';
switch($act) {

  case 'download':

    // The file download
    if(isset($_GET['id']) && !empty($_GET['id']) AND isset($_GET['reff']) && !empty($_GET['reff'])) {

      $id = intval($_GET['id']);
      $reff = intval($_GET['reff']);

      // The unique session download
      if(!isset($_SESSION['download'.$id])) {
        $_SESSION['download'.$id] = md5(md5(time()) * rand(0, 99999));
      }

      $q = $intbyte->query("SELECT * FROM files WHERE id = '".$id."'");
      if($q->num_rows > 0) {

        $file = $q->fetch_assoc();
        if($reff == 1) {

          // Unlocked the file
          $core->redirect(base_url().'/load/'.$file['id'].'/'.$file['user_id'].'/'.$_SESSION['download'.$file['id']].'/'.$file['name'].'');
        } elseif($reff == 2) {

          // Locked the file
          if(isset($_GET['hash']) && !empty($_GET['hash'])) {

            if(password_verify(base64_decode($_GET['hash']), $file['password'])) {

              // If the file password is match
              $core->redirect(base_url().'/load/'.$file['id'].'/'.$file['user_id'].'/'.$_SESSION['download'.$file['id']].'/'.$file['name'].'');
            } else {

              // If the file password is invalid
              $core->redirect(base_url().'/'.$file['token'].'.html?s=3');
            }
          } else {

            // Illegal access
            $core->redirect(base_url().'/'.$file['token'].'.html?s=4');
          }
        } else {

          // Illegal access
          $core->redirect(base_url().'/'.$file['token'].'.html?s=4');
        }
      } else {

        // Data not available
        $core->redirect(base_url().'/'.$file['token'].'.html?s=4');
      }
    } else {

      // Illegal access
      $core->redirect(base_url().'/'.$file['token'].'.html?s=4');
    }
  break;

  case 'report':

    // The file report
    if(isset($_GET['id']) && !empty($_GET['id'])) {

      $id = intval($_GET['id']);
      $q = $intbyte->query("SELECT * FROM files WHERE id = '".$id."'");
      if($q->num_rows > 0) {

        $file = $q->fetch_assoc();

        // The system we set cookie for 1 hours
        setcookie('COOKIE_'.$id, $id, time() + 3600);
        if(isset($_COOKIE['COOKIE_'.$id])) {

          // If the file has been reported
          $core->redirect(base_url().'/'.$file['token'].'.html?s=2');
        } else {

          // If the file not yet reported
          $intbyte->query("UPDATE files SET report = report+1 WHERE id = '".$id."'");
          $core->redirect(base_url().'/'.$file['token'].'.html?s=1');
        }
      } else {

        // Data not available
        $core->redirect(base_url().'/'.$file['token'].'.html?s=4');
      }
    } else {

      // Illegal access
      $core->redirect(base_url().'/'.$file['token'].'.html?s=4');
    }
  break;

  default:

    // The file informations
    if(isset($_GET['token']) && !empty($_GET['token'])) {

      $token = urlencode($_GET['token']);
      $q = $intbyte->query("SELECT * FROM files WHERE token = '".$token."'");
      if($q->num_rows > 0) {

        $file = $q->fetch_assoc();

        if($core->fileExt($file['name']) == 'jpg' || $core->fileExt($file['name']) == 'png' || $core->fileExt($file['name']) == 'jpeg' || $core->fileExt($file['name']) == 'gif') {

          // The images
          $image = ''.base_url().'/data/'.$core->username($file['user_id']).'/'.$file['name'].'';
        } else {

          // The images
          $ext = $core->fileExt($file['name']);
          if(file_exists('images/icon/'.$ext.'.png')) {
            $image = ''.base_url().'/images/icon/'.$ext.'.png';
          } else {
            $image = ''.base_url().'/images/icon/default.png';
          }
        }

        // Headers
        $title = '['.$core->size($file['size']).'] Download '.$file['name'].'';
        $images = $image;
        $description = $file['description'];
        require_once 'incfiles/header.php';

        // The user informations
        $q = $intbyte->query("SELECT * FROM users WHERE id = '".$file['user_id']."'");
        $info = $q->fetch_assoc();

        // Section download the file
        echo '<section class="section">';

        echo '<div class="section-header">
          <h1 class="section-title">
            '.$lang['file_DOWNLOAD'].'
          </h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="'.base_url().'/user/">
                Dashboard
              </a>
            </div>
            <div class="breadcrumb-item">
              '.$lang['file_DOWNLOAD'].'
            </div>
          </div>
        </div>';

        echo '<div class="row">';

        // The status after reporting the file
        if(isset($_GET['s'])) {

          $type = urlencode($_GET['s']);
          if($type == 1) {
            
            // Successfully reported the file
            echo "<script>
              $(document).ready(function() {
                swal('".$lang['file_DOWNLOAD_REPORTED_NY']."', {
                  icon: 'success',
                  buttons: false,
                  timer: 3000,
                }).then(function() {
                  window.location = '".base_url()."/".$file['token'].".html';
                });
              });
            </script>";
          } elseif($type == 2) {
            
            // Failed reported the file
            echo "<script>
              $(document).ready(function() {
                swal('".$lang['file_DOWNLOAD_REPORTED']."', {
                  icon: 'warning',
                  buttons: false,
                  timer: 3000,
                }).then(function() {
                  window.location = '".base_url()."/".$file['token'].".html';
                });
              });
            </script>";
          } elseif($type == 3) {

            // If the password is not valid
            echo "<script>
              $(document).ready(function() {
                swal('".$lang['file_DOWNLOAD_PINV']."', {
                  icon: 'warning',
                  buttons: false,
                  timer: 3000,
                }).then(function() {
                  window.location = '".base_url()."/".$file['token'].".html';
                });
              });
            </script>";
          } elseif($type == 4) {

            // If the an error
            echo "<script>
              $(document).ready(function() {
                swal('".$lang['file_DOWNLOAD_AE']."', {
                  icon: 'warning',
                  buttons: false,
                  timer: 3000,
                }).then(function() {
                  window.location = '".base_url()."/".$file['token'].".html';
                });
              });
            </script>";
          }
        }

        //The file tag
        $Filetag = $core->fileExt($file['name']);
        $name = $file['name'];
        $name = str_replace($Filetag, '', $name);

        // Update view
        $intbyte->query("UPDATE files SET views = views+1 WHERE id = '".$file['id']."'");

        // The unique session download
        if(!isset($_SESSION['download'.$file['id']])) {
          $_SESSION['download'.$file['id']] = md5(md5($file['token']) * rand(0, 99999));
        }

        // The file thumbnail
        if($core->fileExt($file['name']) == 'jpg' || $core->fileExt($file['name']) == 'png' || $core->fileExt($file['name']) == 'jpeg' || $core->fileExt($file['name']) == 'gif') {

          // The thumbnail image
          $thumbnail = '<img src="'.base_url().'/data/'.$core->username($file['user_id']).'/'.$file['name'].'" alt="thumbnail" width="260" class="shadow-light"/>';
        } elseif($core->fileExt($file['name']) == 'mp4' || $core->fileExt($file['name']) == '3gp') {

          // The video player
          $thumbnail = '<video width="260" height="229" autoplay controls>
            <source src="'.base_url().'/data/'.$core->username($file['user_id']).'/'.$file['name'].'" type="video/mp4">
            <source src="'.base_url().'/data/'.$core->username($file['user_id']).'/'.$file['name'].'" type="video/3gp">
            <track label="English" kind="subtitles" srclang="en" src="'.base_url().'/data/'.$core->username($file['user_id']).'/'.$file['name'].'">
            <track label="Indonesian" kind="subtitles" srclang="id" src="'.base_url().'/data/'.$core->username($file['user_id']).'/'.$file['name'].'" default>
            '.$lang['file_DOWNLOAD_DNSB'].'
          </audio>';
        } else {

          // The file other thumbnail
          $thumb_ext = $core->fileExt($file['name']);
          if(file_exists('images/icon/'.$thumb_ext.'.png')) {
            $thumbnail = '<img src="images/icon/'.$thumb_ext.'.png" alt="thumbnail" width="260" class="shadow-light"/>';
          } else {
            $thumbnail = '<img src="images/icon/default.png" alt="thumbnail" width="260" class="shadow-light"/>';
          }
        }

        // The file informations
        echo '<div class="col-12 col-md-12 col-lg-12">
          <div class="card card-primary">
            <div class="card-header">
              <h4>
                ['.$core->size($file['size']).'] Download '.$file['name'].'
              </h4>
              <div class="card-header-action">
                <a id="report-'.$file['id'].'" href="javascript: void(0);" class="btn btn-icon icon-left btn-danger">
                  <i class="fas fa-exclamation-triangle"></i>
                  '.$lang['file_DOWNLOAD_REPORTED3'].'
                </a>
              </div>
            </div>
            <div class="card-body p-0">
              <div class="row">
                <div class="col-12 col-md-12 col-lg-3">
                  <div class="login-brand" style="margin-top: 2px;">
                    <center>
                      '.$thumbnail.'
                    </center>
                  </div>
                  <div class="text-center" style="margin-bottom: 12px;">
                    <div class="font-weight-bold mb-2">
                      '.$lang['file_DOWNLOAD_SHARE'].'
                    </div>
                    <a href="https://www.facebook.com/sharer.php?u='.base_url().'/'.$file['token'].'.html" target="_blank" class="btn" style="color: blue;border-radius: 12px 0px 12px 0px; border: 1px solid blue;">
                      <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://twitter.com/share?url='.base_url().'/'.$file['token'].'.html&text='.$title.'" target="_blank" class="btn" style="color: lightblue;border-radius: 12px 0px 12px 0px; border: 1px solid lightblue;">
                      <i class="fab fa-twitter"></i>
                    </a>
                    <a href="javascript: void(0);" class="btn" style="color: magenta;border-radius: 12px 0px 12px 0px; border: 1px solid magenta;">
                      <i class="fab fa-instagram"></i>
                    </a>
                    <a href="whatsapp://send?text='.$title.' - '.base_url().'/'.$file['token'].'.html" target="_blank" class="btn" style="color: green;border-radius: 12px 0px 12px 0px; border: 1px solid green;">
                      <i class="fab fa-whatsapp"></i>
                    </a>
                  </div>
                </div>
                <div class="col-12 col-md-12 col-lg-9">
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover table-md">
                      <tr>
                        <td class="align-middle" width="12%">
                          <b>
                            '.$lang['file_DOWNLOAD_NAME'].'
                          </b>
                        </td>
                        <td class="align-middle" width="12%">
                          <center>
                            :
                          </center>
                        </td>
                        <td class="align-middle">
                          '.$file['name'].'
                        </td>
                      </tr>
                      <tr>
                        <td class="align-middle" width="12%">
                          <b>
                            '.$lang['file_DOWNLOAD_SIZE'].'
                          </b>
                        </td>
                        <td class="align-middle" width="12%">
                          <center>
                            :
                          </center>
                        </td>
                        <td class="align-middle">
                          '.$core->size($file['size']).'
                        </td>
                      </tr>';

                      // The file mp3 tags
                      $type = $core->fileExt($file['name']);
                      if($type == 'mp3') {

                        $id3 = new MP3_Id();
                        $result = $id3->read('data/'.$core->username($file['user_id']).'/'.$file['name']);
                        $result = $id3->study();

                        // Get the duration of mp3
                        if(!empty($id3->lengthh)) {
                          echo '<tr>
                            <td class="align-middle" width="12%">
                              <b>
                                '.$lang['file_DOWNLOAD_DURATION'].'
                              </b>
                            </td>
                            <td class="align-middle" width="12%">
                              <center>
                                :
                              </center>
                            </td>
                            <td class="align-middle">
                              '.$id3->getTag('lengthh').' ('.(!empty($id3->bitrate) ? ''.$id3->getTag('bitrate').' kb/s' : '0 kb/s').')
                            </td>
                          </tr>';
                        } else {
                          echo '<tr>
                            <td class="align-middle" width="12%">
                              <b>
                                '.$lang['file_DOWNLOAD_DURATION'].'
                              </b>
                            </td>
                            <td class="align-middle" width="12%">
                              <center>
                                :
                              </center>
                            </td>
                            <td class="align-middle">
                              00:00
                            </td>
                          </tr>';
                        }
                      }

                      echo '<tr>
                        <td class="align-middle" width="12%">
                          <b>
                            '.$lang['file_DOWNLOAD_VIEW'].'
                          </b>
                        </td>
                        <td class="align-middle" width="12%">
                          <center>
                            :
                          </center>
                        </td>
                        <td class="align-middle">
                          '.number_format($file['views'], 0, ',', '.').'x
                        </td>
                      </tr>
                      <tr>
                        <td class="align-middle" width="12%">
                          <b>
                            '.$lang['file_DOWNLOAD_DOWNLOADED'].'
                          </b>
                        </td>
                        <td class="align-middle" width="12%">
                          <center>
                            :
                          </center>
                        </td>
                        <td class="align-middle">
                          '.number_format($file['downloaded'], 0, ',', '.').'x
                        </td>
                      </tr>
                      <tr>
                        <td class="align-middle" width="12%">
                          <b>
                            '.$lang['file_DOWNLOAD_UPLOADED'].'
                          </b>
                        </td>
                        <td class="align-middle" width="12%">
                          <center>
                            :
                          </center>
                        </td>
                        <td class="align-middle">
                          '.$time->timeAgo($file['time']).'
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>';

              // Related files
              require_once 'related.php';
              
            echo '<div class="row">
              <div class="col-12 col-md-6 col-lg-12">
                <h1 class="section-title text-muted" style="padding-left: 12px;">
                  '.$lang['file_DOWNLOAD_DESCRIPTION'].'
                </h1>
                <div style="padding-left: 12px;padding-right: 7px;">
                  '.(empty($file['description']) ? ''.$lang['file_DOWNLOAD_DESCRIPTION2'].'' : ''.$core->filter_output($file['description'], TRUE).'').'
                </div>
              </div>
            </div>
            <p class="text-center" style="margin-top: 15px;">
              '.(empty($file['password']) ? '<a id="unlocked" href="javascript: void(0);" class="btn btn-primary btn-pills">['.$core->size($file['size']).'] Download Now</a>' : '<a id="locked" href="javascript: void(0);" class="btn btn-primary btn-pills">['.$core->size($file['size']).'] Download Now</a>').'
            </p>';

            // Audio player
            if($core->fileExt($file['name']) == 'mp3' || $core->fileExt($file['name']) == 'wav') {
              echo '<p class="text-center">
                <audio width="260" autoplay controls>
                  <source src="'.base_url().'/data/'.$core->username($file['user_id']).'/'.$file['name'].'" type="audio/mp3">
                  <source src="'.base_url().'/data/'.$core->username($file['user_id']).'/'.$file['name'].'" type="audio/wav">
                  '.$lang['file_DOWNLOAD_DNSB'].'
                </audio>
              </p>';
            }

            // The user ads
            $ap = $intbyte->query("SELECT * FROM ads WHERE user_id = '".$file['user_id']."' AND status = 'A' ORDER BY `time` DESC LIMIT 1");
            if($ap->num_rows > 0) {

              $ads = $ap->fetch_assoc();
              if($info['type'] == 1) {

                // Premium account
                echo '<div class="text-center">
                  '.$core->filter_output($ads['content'], TRUE).'
                  <br/>
                  <span style="font-size: 12px;color: blue;">
                    <i class="fas fa-check-circle"></i> '.$lang['file_DOWNLOAD_SA'].'
                  </span>
                </div>';
              } else {

                // Free account
                $list = array(
                  $core->set('admin_ads'),
                  $ads['content']
                );
                $random = array_rand($list);

                echo '<div class="text-center">
                  '.$list[$random].'
                </div>';
              }
            } else {

              // Data not available
              echo '<div class="text-center">
                '.$core->username($file['user_id']).'
                '.$lang['file_DOWNLOAD_NHA'].'
              </div>';
            }

          echo '</div>
            <div class="card-footer">
              <marquee scrolldelay="2" scrollamount="2">
                '.$lang['file_DOWNLOAD_WARNING'].'
              </marquee>
            </div>
          </div>
        </div>';

        echo "<script>
          $(document).ready(function() {

            // If the file report
            $('#report-".$file['id']."').on('click', function() {
              swal({
                title: '".$lang['file_DOWNLOAD_CONFIRM_AYS']."',
                text: '".$lang['file_DOWNLOAD_CONREP_TEXT']."',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
              }).then((willReport) => {
                if(willReport) {
                  swal('".$lang['file_DOWNLOAD_REPSS']."', {
                    icon: 'success',
                    buttons: false,
                    timer: 3000,
                  }).then(function() {
                    window.location = '".base_url()."/".$file['token'].".html?act=report&id=".$file['id']."';
                  });
                } else {
                  swal('".$lang['file_DOWNLOAD_REPCANC']."');
                }
              });
            });

            // If the file not locked
            $('#unlocked').on('click', function() {
              swal('".$lang['file_DOWNLOAD_LS']."', {
                icon: 'success',
                buttons: false,
                timer: 3000,
              }).then(function() {
                window.location = '".base_url()."/".$file['token'].".html?act=download&id=".$file['id']."&reff=1';
              });
            });

            // If the file is locked
            $('#locked').on('click', function() {
              swal({
                title: '".$lang['file_DOWNLOAD_LOCKED']."',
                content: {
                  element: 'input',
                  attributes: {
                    placeholder: '".$lang['file_DOWNLOAD_LPH']."',
                    type: 'password',
                  },
                },
              }).then((data) => {
                if(data) {
                  swal('".$lang['file_DOWNLOAD_LS']."', {
                    icon: 'success',
                    buttons: false,
                    timer: 3000,
                  }).then(function() {
                    var _hash = btoa(data);
                    window.location = '".base_url()."/".$file['token'].".html?act=download&id=".$file['id']."&reff=2&hash=' + _hash;
                  });
                }
              });
            });
            
          });
        </script>";

        echo '</div>';
        echo '</section>';
        require_once 'incfiles/footer.php';
      } else {

        // Data not available
        $core->redirect(base_url().'/'.$file['token'].'.html?s=4');
      }
    } else {

      // Illegal access
      $core->redirect(base_url().'/'.$file['token'].'.html?s=4');
    }
  break;
}
?>
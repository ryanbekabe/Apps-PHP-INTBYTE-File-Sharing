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
require_once 'helpers/session.class.php';
require_once 'helpers/coreFunc.class.php';
require_once 'helpers/paging.class.php';
require_once 'helpers/time.class.php';
require_once 'incfiles/lang.php';

if(isset($_GET['q'])) {

  // Headers
  $title = ''.$lang['search_RESULT'].' '.(!empty($_GET['q']) ? '"'.(strlen(strip_tags($core->escapeToDB($core->filter_input($_GET['q'])))) > 25 ? substr(strip_tags($core->escapeToDB($core->filter_input($_GET['q']))), 0, 25).'...' : strip_tags($core->escapeToDB($core->filter_input($_GET['q'])))).'"' : '"'.$lang['search_NO_RESULT2'].'"').'';
  require_once 'incfiles/header.php';

  // Section result
  echo '<section class="section">';

  echo '<div class="section-header">
    <h1 class="section-title">
      '.$lang['search_RESULT'].' '.(!empty($_GET['q']) ? '"'.(strlen(strip_tags($core->escapeToDB($core->filter_input($_GET['q'])))) > 15 ? substr(strip_tags($core->escapeToDB($core->filter_input($_GET['q']))), 0, 15).'...' : strip_tags($core->escapeToDB($core->filter_input($_GET['q'])))).'"' : '"<font color="red">'.$lang['search_NO_RESULT2'].'</font>"').'
    </h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active">
        <a href="'.base_url().'/admin/">
          Dashboard
        </a>
      </div>
      <div class="breadcrumb-item">
        '.$lang['search_RESULT'].' '.(!empty($_GET['q']) ? '"'.(strlen(strip_tags($core->escapeToDB($core->filter_input($_GET['q'])))) > 15 ? substr(strip_tags($core->escapeToDB($core->filter_input($_GET['q']))), 0, 15).'...' : strip_tags($core->escapeToDB($core->filter_input($_GET['q'])))).'"' : '"<font color="red">'.$lang['search_NO_RESULT2'].'</font>"').'
      </div>
    </div>
  </div>';

  // Data Searching Query
  $keywords = strip_tags($core->escapeToDB($core->filter_input($_GET['q'])));

  if(empty($keywords)) {

    // Empty data
    echo '<div class="page-error">
      <div class="page-inner">
        <h1>
          404
        </h1>
        <div class="page-description">
          <i class="text-muted">
            '.$lang['search_NO_RESULT'].'
          </i>
        </div>
        <div class="page-search">
          <div class="mt-3">
            <a href="javascript: history.back(-1);" data-toggle="tooltip" title="'.$lang['search_NF_BTH'].'" class="btn btn-primary">
              <i class="fas fa-arrow-left"></i>
              '.$lang['search_NF_BTHB'].'
            </a>
          </div>
        </div>
      </div>
    </div>';

    echo "<script>
      $(document).ready(function() {
        swal('WARNING!', '".$lang['search_EMPTXT']."', {
          icon: 'warning',
          buttons: false,
          timer: 3000,
        });
      }); 
    </script>";
  } else {

    // Execute
    $q = $intbyte->query("SELECT * FROM files WHERE name LIKE '%".$keywords."%' ORDER BY `id` DESC LIMIT ".$start.", ".$core->set('paging')."");
    $all = $intbyte->query("SELECT * FROM files WHERE name LIKE '%".$keywords."%'")->num_rows;
    if($q->num_rows > 0) {

      echo '<div class="row">';

      $no = 1;
      while($file = $q->fetch_assoc()) {

        // List of files
        echo '<div class="col-12 col-sm-6 col-md-6 col-lg-3">
          <article class="article article-style-b" style="border: 1px solid #DDDDDD;box-shadow: 6px 6px 7px rgba(120, 120, 55, 0.2)">
            <div class="article-header">
              <div class="article-image" data-background="'.$core->show_icon($core->fileExt($file['name'])).'">
              </div>
              <div class="article-badge">
                <div class="article-badge-item bg-danger" data-toggle="tooltip" title="'.$lang['search_SIZE_ESTIMATE'].' '.$core->size($file['size']).'">
                  '.$core->size($file['size']).'
                </div>
              </div>
            </div>
            <div class="article-details">
              <div class="article-title">
                <h2>
                  <a href="javascript: void(0);" data-toggle="tooltip" title="'.(strlen($file['name']) > 20 ? substr($file['name'], 0, 20).'[...].'.$core->fileExt($file['name']).'' : $file['name']).'">
                    '.(strlen($file['name']) > 20 ? substr($file['name'], 0, 20).'[...].'.$core->fileExt($file['name']).'' : $file['name']).'
                  </a>
                </h2>
              </div>
              <p class="text-muted">
                <i class="fas fa-user"></i>
                <a href="'.base_url().'/user/'.$core->username($file['user_id']).'/" data-toggle="tooltip" title="'.$lang['search_SEE_PROFILE'].'">
                  '.$core->username($file['user_id']).'
                </a>
                <br/>
                <i class="fas fa-clock"></i>
                '.$time->timeAgo($file['time']).'
              </p>
              <div class="article-cta">
                <a href="'.base_url().'/'.$file['token'].'.html" class="btn btn-primary" data-toggle="tooltip" title="'.$lang['search_DOWNLOAD_BTN'].' '.$core->size($file['size']).'." style="width: 100%;">
                  <i class="fas fa-download"></i>
                  Download
                </a>
              </div>
            </div>
          </article>
        </div>';

        // Do not remove this line because it is important
        $file++;
        $no++;
      }

      // Paging
      echo '</div>
      <div class="row">
        <div class="col-12">
          <p class="text-left">
            '.$paging->showPage($all, $page, $core->set('paging'), base_url().'/search?q='.$keywords.'&').'
          </p>
        </div>
      </div>';
    } else {

      // Data not available
      echo '<div class="row">
        <div class="page-error">
          <div class="page-inner">
            <h1>
              404
            </h1>
            <div class="page-description">
              <i class="text-muted">
                '.$lang['index_NO_C'].'
              </i>
            </div>
            <div class="page-search">
              <div class="mt-3">
                <a href="javascript: history.back(-1);" data-toggle="tooltip" title="'.$lang['search_NF_BTH'].'" class="btn btn-primary">
                  <i class="fas fa-arrow-left"></i>
                  '.$lang['search_NF_BTHB'].'
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>';

      echo "<script>
        $(document).ready(function() {
          swal('WARNING!', '".$lang['search_EMPTXT2']."', {
            icon: 'warning',
            buttons: false,
            timer: 3000,
          });
        }); 
      </script>";
    }
  }

  echo '</section>';
  require_once 'incfiles/footer.php';
} else {

  // Illegal access
  $core->redirect(base_url().'/');
}
?>
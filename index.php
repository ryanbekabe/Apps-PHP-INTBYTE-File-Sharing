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

// Headers
$title = $lang['index_title'];
require_once 'incfiles/header.php';

// Addon CSS
echo '<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">';

// Section upgrade account
echo '<section class="section service">';

echo '<div class="section-header">
  <h1 class="section-title">
    '.$lang['index_WELCOME'].' '.$core->set('title').'
  </h1>
</div>';

// Redirect to dashboard if user logged
if($session->is_login()) {

  // Dashboard
  $core->redirect(base_url().'/user/');
} else {

  // Index
  echo '<div class="row">
    <div class="col-sm-3 text-center">
      <div class="service-detail">
        <span class="fa diamond">
          <i class="fa fa-server"></i>
        </span>
        <h3>
          '.$lang['welcome_SERVICE_STORAGE'].'
        </h3>
        <p>
          '.$lang['welcome_SERVICE_STORCONT'].'
        </p>
      </div>
    </div>
    <div class="col-sm-3 text-center">
      <div class="service-detail">
        <span class="fa diamond">
          <i class="fa fa-tags"></i>
        </span>
        <h3>
          '.$lang['welcome_SERVICE_MONETIZE'].'
        </h3>
        <p>
          '.$lang['welcome_SERVICE_MONECONT'].'
        </p>
      </div>
    </div>
    <div class="col-sm-3 text-center">
      <div class="service-detail">
        <span class="fa diamond">
          <i class="fa fa-key"></i>
        </span>
        <h3>
          '.$lang['welcome_SERVICE_SECURITY'].'
        </h3>
        <p>
          '.$lang['welcome_SERVICE_SECUCONT'].'
        </p>
      </div>
    </div>
    <div class="col-sm-3 text-center">
      <div class="service-detail">
        <span class="fa diamond">
          <i class="fa fa-css3"></i>
        </span>
        <h3>
          '.$lang['welcome_SERVICE_UPGRADE'].'
        </h3>
        <p>
          '.$lang['welcome_SERVICE_UPGRCONT'].'
        </p>
      </div>
    </div>
  </div>';

  // List of files
  $q = $intbyte->query("SELECT * FROM files ORDER BY `id` DESC LIMIT 4");
  if($q->num_rows > 0) {

    echo '<div class="row">';

    $no = 1;
    while($file = $q->fetch_assoc()) {

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
  } else {
    
    // Data not available
    echo '<div class="row">
      <div class="page-error">
        <div class="page-inner">
          <h2>
            No Files Available
          </h2>
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
  }
}

echo '</section>';
require_once 'incfiles/footer.php';
?>
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

// Connection to database
if(file_exists('incfiles/connect.php')) {
  require_once 'incfiles/connect.php';
} else {
  require_once '../incfiles/connect.php';
}

// Language system
if(file_exists('incfiles/lang.php')) {
  require_once 'incfiles/lang.php';
} else {
  require_once '../incfiles/lang.php';
}

// Session system
if(file_exists('helpers/session.class.php')) {
  require_once 'helpers/session.class.php';
} else {
  require_once '../helpers/session.class.php';
}

// Core function system
if(file_exists('helpers/coreFunc.class.php')) {
  require_once 'helpers/coreFunc.class.php';
} else {
  require_once '../helpers/coreFunc.class.php';
}

// Time system
if(file_exists('helpers/time.class.php')) {
  require_once 'helpers/time.class.php';
} else {
  require_once '../helpers/time.class.php';
}

// Default time zone
date_default_timezone_set($core->set('time_zone'));

// Header page
echo '<!DOCTYPE html>
  <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
      <title>
        '.(empty($title) ? ''.$lang['header_home'].'' : ''.$title.'').' | '.$core->set('title').'
      </title>';

// Meta tags seo
echo '<meta name="description" content="'.(empty($core->set('site_description')) ? 'No description...' : ''.$core->set('site_description').'').'">
  <meta name="keywords" content="'.(empty($core->set('site_keywords')) ? 'No keywords...' : ''.$core->set('site_keywords').'').'">
  <meta name="google-site-verification" content="'.(empty($core->set('google_verify')) ? 'No data...' : ''.$core->set('google_verify').'').'">';

// Facebook opengraph
echo '<meta property="og:title" content="'.(empty($title) ? ''.$lang['header_home'].'' : ''.$title.'').' | '.$core->set('title').'">
  <meta property="og:url" content="'.base_url().'/'.$SERVER['REQUEST_URI'].'">
  <meta property="og:image" content="'.(empty($images) ? ''.base_url().'/assets/img/logo2.png' : ''.$images.'').'">
  <meta property="og:site_name" content="'.(empty($core->set('title')) ? 'No data...' : ''.$core->set('title').'').'">
  <meta property="description" content="'.(empty($description) ? 'No description...' : ''.$description.'').'">
  <meta property="fb:app_id" content="1897615997118638"/>
  <meta property="fb:admins" content="390068998247260"/>';

// General CSS files
echo '<link rel="stylesheet" href="'.base_url().'/assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="'.base_url().'/assets/modules/fontawesome/css/all.min.css">';

// CSS libraries
echo '<link rel="stylesheet" href="'.base_url().'/assets/modules/summernote/summernote-bs4.css">
  <link rel="stylesheet" href="'.base_url().'/assets/modules/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="'.base_url().'/assets/modules/jquery-selectric/selectric.css">
  <link rel="stylesheet" href="'.base_url().'/assets/modules/izitoast/css/iziToast.min.css">
  <link rel="stylesheet" href="'.base_url().'/assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="'.base_url().'/assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css">';

// Template CSS
echo '<link rel="stylesheet" href="'.base_url().'/assets/css/style.css">
  <link rel="stylesheet" href="'.base_url().'/assets/css/components.css">';

// Favicon
echo '<link href="'.base_url().'/favicon.ico" rel="icon" type="image/x-icon"/>';

// JavaScript modules
echo '<script src="'.base_url().'/assets/modules/jquery.min.js"></script>
  <script src="'.base_url().'/assets/modules/sweetalert/sweetalert.min.js"></script>';

// Plugins: Online or Offline
echo "<script>
  $(document).ready(function() {

    // Get event online and offline
    window.addEventListener('online', getOnline);
    window.addEventListener('offline', getOffline);

    // Create function to get online status
    function getOnline() {
      iziToast.success({
        title: 'Server Connected!',
        message: 'Connected to server!',
        position: 'topLeft'
      });
    }

    // Create function to get offline status
    function getOffline() {
      iziToast.error({
        title: 'Server Error!',
        message: 'Could not connect to server!',
        position: 'topLeft'
      });
    }
    
  });
</script>";

// Plugins: CSS Service
echo '<style>
  .service {
    font-family: "Yantramanav", sans-serif;
  }
  .service .fa.s-icon {
    width: 60px; 
    height: 60px; 
    border-radius: 50%; 
    border: 2px solid #dedede;  
    background-color: transparent; 
    color: #999; 
    padding-top: 20px; 
    font-size: 18px;
  }
  
  .service h3 {
    color: #697687;
    font-weight: 300; 
    font-size: 22px;
  }
  
  .service p {
    color: #999;
  }
  
  .service .service-detail:hover h3,
  .service .service-detail:hover .fa.s-icon{
    color: #1ac4e2;
    border-color: #1ac4e2;
  }
  
  .diamond .fa {
    color: #fff; 
    position: relative;
    padding-top: 12px; 
    z-index: 1000;
  }
  
  .diamond {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    border-color: rgba(0, 0, 0, 0) rgba(0, 0, 0, 0) #1ac4e2;
    border-image: none;
    border-style: solid;
    border-width: 0 15px 20px;
    box-sizing: content-box;
    color: rgba(0, 0, 0, 1);
    font: 100% Arial,Helvetica,sans-serif;
    height: 0;
    margin: 20px 0 30px;
    position: relative;
    text-overflow: clip;
    width: 30px;
  }
  
  .diamond::after {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    border-color: #1ac4e2 rgba(0, 0, 0, 0) rgba(0, 0, 0, 0);
    border-image: none;
    border-style: solid;
    border-width: 35px 30px 0;
    box-sizing: content-box;
    color: rgba(0, 0, 0, 1);
    content: "";
    font: 100% Arial,Helvetica,sans-serif;
    height: 0;
    left: -15px;
    position: absolute;
    text-overflow: clip;
    text-shadow: none;
    top: 20px;
    width: 0;
  }
</style>';

echo '</head>';

// For security reason, system will disabled right click
echo '<body oncontextmenu="return false;">
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>';

// Navbar
echo '<nav class="navbar navbar-expand-lg main-navbar">';

// Search form
echo '<form method="GET" action="/search" class="form-inline mr-auto">
  <ul class="navbar-nav mr-3">
    <li>
      <a href="javascript: void(0);" data-toggle="sidebar" class="nav-link nav-link-lg">
        <i class="fas fa-bars"></i>
      </a>
    </li>
    <li>
      <a href="javascript: void(0);" data-toggle="search" class="nav-link nav-link-lg d-sm-none">
        <i class="fas fa-search"></i>
      </a>
    </li>
  </ul>
  <div class="search-element">
    <input class="form-control" type="search" name="q" placeholder="Search" aria-label="Search" data-width="250" required="">
    <button class="btn" type="submit">
      <i class="fas fa-search"></i>
    </button>
  </div>
</form>';

// Navbar right
echo '<ul class="navbar-nav navbar-right">';

// User content
if($session->is_login()) {

  // User content: User
  if($session->is_rights() > 1) {

    // Language
    echo '<li class="dropdown">
      <a href="javascript: void(0);" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
        '.$lang['header_SELECT_LANG'].'
      </a>
      <div class="dropdown-menu dropdown-menu-right">
        <div class="dropdown-title">
          '.$lang['header_SELECT_LANG'].'
        </div>
        <a href="'.base_url().'/?lang=id" class="dropdown-item has-icon">
          <i class="fas fa-arrow-right"></i> Bahasa Indonesia
        </a>
        <a href="'.base_url().'/?lang=en" class="dropdown-item has-icon">
          <i class="fas fa-arrow-right"></i> English
        </a>
      </div>
    </li>';

    // Notifications
    echo '<li class="dropdown dropdown-list-toggle">';

    echo '<a href="javascript: void(0);" data-toggle="dropdown" class="nav-link nav-link-lg notification-toggle '.(($intbyte->query("SELECT * FROM notifications WHERE notification_for = 'User' AND status = 'Unread' AND user_id = '".$session->is_login()."'")->num_rows > 0) ? 'beep' : '').'">
      <i class="far fa-bell"></i>
    </a>
    <div class="dropdown-menu dropdown-list dropdown-menu-right">
    <div class="dropdown-header">
      '.($intbyte->query("SELECT * FROM notifications WHERE notification_for = 'User' AND status = 'Unread' AND user_id = '".$session->is_login()."'")->num_rows).' '.$lang['header_notifications'].'
      <div class="float-right">
        '.($intbyte->query("SELECT * FROM notifications WHERE notification_for = 'User' AND status = 'Unread' AND user_id = '".$session->is_login()."'")->num_rows > 0 ? '<a id="drop" href="javascript: void(0);">'.$lang['header_MAAR'].'</a>' : ''.$lang['header_MAAR'].'').'
      </div>
    </div>';

    $q = $intbyte->query("SELECT * FROM notifications WHERE notification_for = 'User' AND status = 'Unread' AND user_id = '".$session->is_login()."' ORDER BY `id` DESC LIMIT 10");
    if($q->num_rows > 0) {
      
      echo '<div class="dropdown-list-content dropdown-list-icons">';

      while($notification = $q->fetch_assoc()) {

        // List of notifications
        echo '<a id="user_read-'.$notification['id'].'" href="javascript: void(0);" class="dropdown-item">
          <div class="dropdown-item-icon bg-info text-white">
            '.($notification['type'] == 'fas fa-info' ? '<i class="fas fa-info"></i>' : ($notification['type'] == 'fas fa-tags' ? '<i class="fas fa-tags"></i>' : ($notification['type'] == 'fas fa-info-circle' ? '<i class="fas fa-info"></i>' : '<i class="fas fa-users"></i>'))).'
          </div>
          <div class="dropdown-item-desc">
            <b>'.(strlen($notification['title']) > 50 ? substr($notification['title'], 0, 50).'...' : $notification['title']).'</b>
            <div class="time">'.$time->timeAgo($notification['time']).'</div>
          </div>
        </a>';

        echo "<script>
          $(document).ready(function() {

            // Read
            $('#user_read-".$notification['id']."').on('click', function() {
              $('#user_read-".$notification['id']."').fireModal({
                title: '".$notification['title']."',
                body: '".$core->filter_output($notification['content'], TRUE)."',
                footerClass: 'bg-whitesmoke',
                buttons: [
                  {
                    text: '".$lang['notify_DONE_BTN']."',
                    class: 'btn btn-danger btn-shadow',
                    handler: function(modal) {
                      if(modal) {
                        window.location = '".base_url()."/user/notifications/?view=read&id=".$notification['id']."';
                      } else {
                        alert('".$lang['notify_OOPS']."');
                      }
                    }
                  }
                ],
                center: true
              });
            });

            // Drop All
            $('#drop').on('click', function() {
              swal({
                title: '".$lang['notify_NEW_CONFIRM_AYS']."',
                text: '".$lang['notify_HEAD_CONDROP_TEXT']."',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
              }).then((willDrop) => {
                if(willDrop) {
                  swal(
                    '".$lang['notify_HEAD_CONDROP_SUCCESS']."',
                    {
                      icon: 'success',
                    }
                  ).then(function() {
                    window.location = '".base_url()."/user/notifications/?view=drop&do=action';
                  });
                } else {
                  swal('".$lang['notify_HEAD_CONDROP_CANCEL']."');
                }
              });
            });

          });
        </script>";

        // Do not remove this line because it is important
        $notification++;
      }

      // View all notifications
      echo '</div>
        <div class="dropdown-footer text-center">
          '.($intbyte->query("SELECT * FROM notifications WHERE notification_for = 'User' AND status = 'Unread' AND user_id = '".$session->is_login()."'")->num_rows >= 10 ? '<a href="'.base_url().'/user/notifications/?view=notifications&type=new">'.$lang['header_VA'].' <i class="fas fa-chevron-right"></i></a>' : ''.$lang['header_VA'].' <i class="fas fa-chevron-right"></i>').'
        </div>
      </div>';
    } else {

      // Data not available
      echo '<div class="dropdown-item">
        <center>
          <span class="text-muted" style="font-size: 22px;">
            '.$lang['header_UNN'].'
          </span>
        </center>
      </div>';
    }

    echo '</li>';

    // User account when logged
    echo '<li class="dropdown">
      <a href="javascript: void(0);" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
        <img alt="image" src="'.base_url().'/'.$core->show_avatar($session->is_login()).'" class="rounded-circle mr-1">
          <div class="d-sm-none d-lg-inline-block">
            Hi, '.$core->username($session->is_login()).'
          </div>
      </a>
      <div class="dropdown-menu dropdown-menu-right">
        <div class="dropdown-title">
          '.$lang['login_PAGE'].' '.$time->timeAgo($session->is_logged()).' 
        </div>
        <a href="'.base_url().'/user/" class="dropdown-item has-icon">
          <i class="fas fa-bolt"></i> '.$lang['header_dashboard'].'
        </a>
        <a href="'.base_url().'/user/settings/" class="dropdown-item has-icon">
          <i class="fas fa-cog"></i> '.$lang['header_settings'].'
        </a>
        <div class="dropdown-divider">
        </div>
        <a href="'.base_url().'/logout/" class="dropdown-item has-icon text-danger">
          <i class="fas fa-sign-out-alt"></i> '.$lang['header_signout'].'
        </a>
      </div>
    </li>';
  } elseif($session->is_rights() < 2 && $session->is_rights() != 0) {

    // Language
    echo '<li class="dropdown">
      <a href="javascript: void(0);" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
        '.$lang['header_SELECT_LANG'].'
      </a>
      <div class="dropdown-menu dropdown-menu-right">
        <div class="dropdown-title">
          '.$lang['header_SELECT_LANG'].'
        </div>
        <a href="'.base_url().'/?lang=id" class="dropdown-item has-icon">
          <i class="fas fa-arrow-right"></i> Bahasa Indonesia
        </a>
        <a href="'.base_url().'/?lang=en" class="dropdown-item has-icon">
          <i class="fas fa-arrow-right"></i> English
        </a>
      </div>
    </li>';

    // Notifications
    echo '<li class="dropdown dropdown-list-toggle">';

    echo '<a href="javascript: void(0);" data-toggle="dropdown" class="nav-link nav-link-lg notification-toggle '.(($intbyte->query("SELECT * FROM notifications WHERE notification_for = 'Admin' AND status = 'Unread' AND user_id = '".$session->is_login()."'")->num_rows > 0) ? 'beep' : '').'">
      <i class="far fa-bell"></i>
    </a>
    <div class="dropdown-menu dropdown-list dropdown-menu-right">
    <div class="dropdown-header">
      '.($intbyte->query("SELECT * FROM notifications WHERE notification_for = 'Admin' AND status = 'Unread' AND user_id = '".$session->is_login()."'")->num_rows).' '.$lang['header_notifications'].'
      <div class="float-right">
        '.($intbyte->query("SELECT * FROM notifications WHERE notification_for = 'Admin' AND status = 'Unread' AND user_id = '".$session->is_login()."'")->num_rows > 0 ? '<a id="drop" href="javascript: void(0);">'.$lang['header_MAAR'].'</a>' : ''.$lang['header_MAAR'].'').'
      </div>
    </div>';

    $q = $intbyte->query("SELECT * FROM notifications WHERE notification_for = 'Admin' AND status = 'Unread' AND user_id = '".$session->is_login()."' ORDER BY `id` DESC LIMIT 10");
    if($q->num_rows > 0) {

      echo '<div class="dropdown-list-content dropdown-list-icons">';

      while($notification = $q->fetch_assoc()) {

        // List of notifictions
        echo '<a id="admin_read-'.$notification['id'].'" href="javascript: void(0);" class="dropdown-item">
          <div class="dropdown-item-icon bg-info text-white">
            '.($notification['type'] == 'fas fa-info' ? '<i class="fas fa-info"></i>' : ($notification['type'] == 'fas fa-tags' ? '<i class="fas fa-tags"></i>' : ($notification['type'] == 'fas fa-info-circle' ? '<i class="fas fa-info"></i>' : '<i class="fas fa-users"></i>'))).'
          </div>
          <div class="dropdown-item-desc">
            <b>'.(strlen($notification['title']) > 50 ? substr($notification['title'], 0, 50).'...' : $notification['title']).'</b>
            <div class="time">'.$time->timeAgo($notification['time']).'</div>
          </div>
        </a>';

        echo "<script>
          $(document).ready(function() {

            // Read
            $('#admin_read-".$notification['id']."').on('click', function() {
              $('#admin_read-".$notification['id']."').fireModal({
                title: '".$notification['title']."',
                body: '".$core->filter_output($notification['content'], TRUE)."',
                footerClass: 'bg-whitesmoke',
                buttons: [
                  {
                    text: '".$lang['notify_DONE_BTN']."',
                    class: 'btn btn-danger btn-shadow',
                    handler: function(modal) {
                      if(modal) {
                        window.location = '".base_url()."/admin/manage-notifications/?view=read&id=".$notification['id']."';
                      } else {
                        alert('".$lang['notify_OOPS']."');
                      }
                    }
                  }
                ],
                center: true
              });
            });

            // Drop All
            $('#drop').on('click', function() {
              swal({
                title: '".$lang['notify_NEW_CONFIRM_AYS']."',
                text: '".$lang['notify_HEAD_CONDROP_TEXT']."',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
              }).then((willDrop) => {
                if(willDrop) {
                  swal(
                    '".$lang['notify_HEAD_CONDROP_SUCCESS']."',
                    {
                      icon: 'success',
                    }
                  ).then(function() {
                    window.location = '".base_url()."/admin/manage-notifications/?view=drop&do=action';
                  });
                } else {
                  swal('".$lang['notify_HEAD_CONDROP_CANCEL']."');
                }
              });
            });

          });
        </script>";

        // Do not remove this line because it is important
        $notification++;
      }

      // View all notifications
      echo '</div>
        <div class="dropdown-footer text-center">
          '.($intbyte->query("SELECT * FROM notifications WHERE notification_for = 'Admin' AND status = 'Unread' AND user_id = '".$session->is_login()."'")->num_rows >= 10 ? '<a href="'.base_url().'/admin/manage-notifications/?view=notifications&type=new">'.$lang['header_VA'].' <i class="fas fa-chevron-right"></i></a>' : ''.$lang['header_VA'].' <i class="fas fa-chevron-right"></i>').'
        </div>
      </div>';
    } else {

      // Data not available
      echo '<div class="dropdown-item">
        <center>
          <span class="text-muted" style="font-size: 22px;">
            '.$lang['header_UNN'].'
          </span>
        </center>
      </div>';
    }

    echo '</li>';

    // User account when logged
    echo '<li class="dropdown">
      <a href="javascript: void(0);" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
        <img alt="image" src="'.base_url().'/'.$core->show_avatar($session->is_login()).'" class="rounded-circle mr-1">
          <div class="d-sm-none d-lg-inline-block">
            Hi, '.$core->username($session->is_login()).'
          </div>
      </a>
      <div class="dropdown-menu dropdown-menu-right">
        <div class="dropdown-title">
          '.$lang['login_PAGE'].' '.$time->timeAgo($session->is_logged()).' 
        </div>
        <a href="'.base_url().'/user/" class="dropdown-item has-icon">
          <i class="fas fa-bolt"></i> '.$lang['header_dashboard'].'
        </a>
        <a href="'.base_url().'/user/settings/" class="dropdown-item has-icon">
          <i class="fas fa-cog"></i> '.$lang['header_settings'].'
        </a>
        <div class="dropdown-divider">
        </div>
        <a href="'.base_url().'/logout/" class="dropdown-item has-icon text-danger">
          <i class="fas fa-sign-out-alt"></i> '.$lang['header_signout'].'
        </a>
      </div>
    </li>';
  }
} else {

  // Language
  echo '<li class="dropdown">
    <a href="javascript: void(0);" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
      '.$lang['header_SELECT_LANG'].'
    </a>
    <div class="dropdown-menu dropdown-menu-right">
      <div class="dropdown-title">
        '.$lang['header_SELECT_LANG'].'
      </div>
      <a href="'.base_url().'/?lang=id" class="dropdown-item has-icon">
        <i class="fas fa-arrow-right"></i> Bahasa Indonesia
      </a>
      <a href="'.base_url().'/?lang=en" class="dropdown-item has-icon">
        <i class="fas fa-arrow-right"></i> English
      </a>
    </div>
  </li>';

  // User account when not logged
  echo '<li class="dropdown">
    <a href="javascript: void(0);" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
      <img alt="image" src="'.base_url().'/images/avatar/default.png" class="rounded-circle mr-1">
        <div class="d-sm-none d-lg-inline-block">
          Hi, '.$lang['header_UAG'].'
        </div>
    </a>
    <div class="dropdown-menu dropdown-menu-right">
      <div class="dropdown-title">
        '.$lang['header_PLF'].' 
      </div>
      <a href="'.base_url().'/login/" class="dropdown-item has-icon">
        <i class="far fa-user"></i> '.$lang['header_login'].'
      </a>
      <a href="'.base_url().'/register/" class="dropdown-item has-icon">
        <i class="fas fa-plus"></i> '.$lang['header_register'].'
      </a>
    </div>
  </li>';
}

echo '</ul>';
echo '</nav>';

// Sidebar menu
if(file_exists('incfiles/sidebar.php')) {
  require_once 'incfiles/sidebar.php';
} else {
  require_once '../incfiles/sidebar.php';
}

// Main menu
echo '<div class="main-content">';
?>
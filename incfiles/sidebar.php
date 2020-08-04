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

// Sidebar menu
echo '<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="'.base_url().'">
        '.$core->set('title').'
      </a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="'.base_url().'">
        IB
      </a>
    </div>
    <ul class="sidebar-menu">';

if($session->is_login()) {

  // Sidebar user
  if($session->is_rights() < 2 && $session->is_rights() != 0) {

    // Sidebar: Dashboard
    echo '<li class="menu-header">Dashboard</li>
      <li class="dropdown active">
        <a href="javascript: void(0);" class="nav-link has-dropdown">
          <i class="fas fa-home"></i>
          <span>
            Dashboard
          </span>
        </a>
      <ul class="dropdown-menu">
        <li class=active>
          <a class="nav-link" href="'.base_url().'/admin/advertisement/">
            '.$lang['home_SAA'].'
          </a>
        </li>
        <li>
          <a class="nav-link" href="'.base_url().'/admin/manage-administrator/">
            '.$lang['home_SMA'].'
          </a>
        </li>
      </ul>
    </li>';

    // Sidebar: INTBYTE
    echo '<li class="menu-header">'.strtoupper($core->set('title')).'</li>
      <li class="dropdown">
        <a href="javascript: void(0);" class="nav-link has-dropdown">
          <i class="fas fa-tags"></i>
          <span>
            '.$lang['home_SMAD'].'
          </span>
        </a>
      <ul class="dropdown-menu">
        <li>
          <a class="nav-link" href="'.base_url().'/admin/manage-ads/?view=ads&type=approved">
            '.$lang['home_SMAD_UAA'].'
          </a>
        </li>
        <li>
          <a class="nav-link" href="'.base_url().'/admin/manage-ads/?view=ads&type=rejected">
            '.$lang['home_SMAD_UAR'].'
          </a>
        </li>
        <li>
          <a class="nav-link" href="'.base_url().'/admin/manage-ads/?view=ads&type=blocked">
            '.$lang['home_SMAD_UAB'].'
          </a>
        </li>
        <li>
          <a class="nav-link" href="'.base_url().'/admin/manage-ads/?view=ads&type=deleted">
            '.$lang['home_SMAD_UAD'].'
          </a>
        </li>
        <li>
          <a class="nav-link '.($intbyte->query("SELECT * FROM ads WHERE status = 'W'")->num_rows ? 'beep beep-sidebar' : '').'" href="'.base_url().'/admin/manage-ads/?view=ads&type=wait_to_approve">
            '.$lang['home_SMAD_UAW'].'
          </a>
        </li>
      </ul>
    </li>';

    // Sidebar: Manage files
    echo '<li class="dropdown">
      <a href="javascript: void(0);" class="nav-link has-dropdown">
        <i class="fas fa-file"></i>
        <span>
          '.$lang['home_SMF'].'
        </span>
      </a>
      <ul class="dropdown-menu">
        <li>
          <a class="nav-link" href="'.base_url().'/admin/manage-files/?view=files&type=latest">
            '.$lang['home_SMF_LU'].'
          </a>
        </li>
        <li>
          <a class="nav-link" href="'.base_url().'/admin/manage-files/?view=files&type=popular">
            '.$lang['home_SMF_PD'].'
          </a>
        </li>
        <li>
          <a class="nav-link '.($intbyte->query("SELECT * FROM files WHERE report >= 1")->num_rows ? 'beep beep-sidebar' : '').'" href="'.base_url().'/admin/manage-files/?view=files&type=reported">
            '.$lang['home_SMF_RF'].'
          </a>
        </li>
      </ul>
    </li>';

    // Sidebar: Manage notifications
    echo '<li class="dropdown">
      <a href="javascript: void(0);" class="nav-link has-dropdown">
        <i class="fas fa-bell"></i>
        <span>
          '.$lang['home_SMN'].'
        </span>
      </a>
      <ul class="dropdown-menu">
        <li>
          <a class="nav-link" href="'.base_url().'/admin/manage-notifications/?view=notifications&type=create">
            '.$lang['home_SMN_CN'].'
          </a>
        </li>
        <li>
          <a class="nav-link '.($intbyte->query("SELECT * FROM notifications WHERE notification_for = 'Admin' AND status = 'Unread'")->num_rows ? 'beep beep-sidebar' : '').'" href="'.base_url().'/admin/manage-notifications/?view=notifications&type=new">
            '.$lang['home_SMN_NN'].'
          </a>
        </li>
        <li>
          <a class="nav-link" href="'.base_url().'/admin/manage-notifications/?view=notifications&type=archive">
            '.$lang['home_SMN_AN'].'
          </a>
        </li>
      </ul>
    </li>';

    // Sidebar: Manage users
    echo '<li class="dropdown">
      <a href="javascript: void(0);" class="nav-link has-dropdown">
        <i class="fas fa-users"></i>
        <span>
          '.$lang['home_SMU'].'
        </span>
      </a>
      <ul class="dropdown-menu">
        <li>
          <a class="nav-link" href="'.base_url().'/admin/manage-users/?view=users&type=new">
            '.$lang['home_SMU_LU'].'
          </a>
        </li>
        <li>
          <a class="nav-link" href="'.base_url().'/admin/manage-users/?view=users&type=blocked">
            '.$lang['home_SMU_UB'].'
          </a>
        </li>
        <li>
          <a class="nav-link '.($intbyte->query("SELECT * FROM notifications WHERE notification_for = 'Admin' AND status = 'Unread'")->num_rows ? 'beep beep-sidebar' : '').'" href="'.base_url().'/admin/manage-users/?view=users&type=unconfirmed">
            '.$lang['home_SMU_UC'].'
          </a>
        </li>
        <li>
          <a class="nav-link" href="'.base_url().'/admin/manage-users/?view=users&type=confirmed">
            '.$lang['user_LIST_CONFIRMED'].'
          </a>
        </li>
        <li>
          <a class="nav-link" href="'.base_url().'/admin/manage-users/?view=users&type=premium_account">
            '.$lang['home_SMU_UPA'].'
          </a>
        </li>
      </ul>
    </li>';

    // Sidebar: Settings
    echo '<li class="dropdown">
      <a href="javascript: void(0);" class="nav-link has-dropdown">
        <i class="fas fa-cogs"></i>
        <span>
          '.$lang['home_SS'].'
        </span>
      </a>
      <ul class="dropdown-menu">
        <li>
          <a class="nav-link" href="'.base_url().'/admin/settings/?view=settings&type=seo">
            '.$lang['home_SS_SEO'].'
          </a>
        </li>
        <li>
          <a class="nav-link" href="'.base_url().'/admin/settings/?view=settings&type=site">
            '.$lang['home_SS_SITE'].'
          </a>
        </li>
        <li>
          <a class="nav-link" href="'.base_url().'/admin/settings/?view=settings&type=storage">
            '.$lang['home_SS_STORAGE'].'
          </a>
        </li>
      </ul>
    </li>';
  } else {

    // Sidebar user
    echo '<li class="menu-header">Dashboard</li>
      <li class="dropdown active">
        <a href="javascript: void(0);" class="nav-link has-dropdown">
          <i class="fas fa-home"></i>
          <span>
            Dashboard
          </span>
        </a>
      <ul class="dropdown-menu">
        <li class=active>
          <a class="nav-link" href="'.base_url().'/user/premium/">
            '.$lang['home_SAAC'].'
          </a>
        </li>
      </ul>
    </li>';

    // Sidebar: Main menu
    echo '<li class="menu-header">MAIN MENU</li>';

    // Sidebar: My ads
    echo '<li class="dropdown">
      <a href="javascript: void(0);" class="nav-link has-dropdown">
        <i class="fas fa-tags"></i>
        <span>
          '.$lang['home_SUMAD'].'
        </span>
      </a>
      <ul class="dropdown-menu">
        <li>
          <a class="nav-link" href="'.base_url().'/user/my-ads/?view=ads&type=create">
            '.$lang['home_SUMAD_CNA'].'
          </a>
        </li>
        <li>
          <a class="nav-link '.($intbyte->query("SELECT * FROM ads WHERE user_id = ".$session->is_login()." AND status = 'A'")->num_rows > 0 ? 'beep beep-sidebar' : '').'" href="'.base_url().'/user/my-ads/?view=ads&type=approved">
            '.$lang['home_SUMAD_UAA'].'
          </a>
        </li>
        <li>
          <a class="nav-link '.($intbyte->query("SELECT * FROM ads WHERE user_id = ".$session->is_login()." AND status = 'R'")->num_rows > 0 ? 'beep beep-sidebar' : '').'" href="'.base_url().'/user/my-ads/?view=ads&type=rejected">
            '.$lang['home_SUMAD_UAR'].'
          </a>
        </li>
        <li>
          <a class="nav-link '.($intbyte->query("SELECT * FROM ads WHERE user_id = ".$session->is_login()." AND status = 'B'")->num_rows > 0 ? 'beep beep-sidebar' : '').'" href="'.base_url().'/user/my-ads/?view=ads&type=blocked">
            '.$lang['home_SUMAD_UAB'].'
          </a>
        </li>
        <li>
          <a class="nav-link '.($intbyte->query("SELECT * FROM ads WHERE user_id = ".$session->is_login()." AND status = 'D'")->num_rows > 0 ? 'beep beep-sidebar' : '').'" href="'.base_url().'/user/my-ads/?view=ads&type=deleted">
            '.$lang['home_SUMAD_UAD'].'
          </a>
        </li>
        <li>
          <a class="nav-link '.($intbyte->query("SELECT * FROM ads WHERE user_id = ".$session->is_login()." AND status = 'W'")->num_rows > 0 ? 'beep beep-sidebar' : '').'" href="'.base_url().'/user/my-ads/?view=ads&type=wait_to_approve">
            '.$lang['home_SUMAD_UAW'].'
          </a>
        </li>
      </ul>
    </li>';

    // Sidebar: My files
    echo '<li class="dropdown">
      <a href="javascript: void(0);" class="nav-link has-dropdown">
        <i class="fas fa-file"></i>
        <span>
          '.$lang['home_SUMF'].'
        </span>
      </a>
      <ul class="dropdown-menu">
        <li>
          <a class="nav-link" href="'.base_url().'/user/my-files/?view=files&type=latest">
            '.$lang['home_SUMF_LF'].'
          </a>
        </li>
        <li>
          <a class="nav-link" href="'.base_url().'/user/upload/">
            '.$lang['home_SUMF_UF'].'
          </a>
        </li>
        <li>
          <a class="nav-link" href="'.base_url().'/user/import/">
            '.$lang['home_SUMF_IF'].'
          </a>
        </li>
        <li>
          <a class="nav-link '.($intbyte->query("SELECT * FROM files WHERE user_id = ".$session->is_login()." AND report >= 1")->num_rows ? 'beep beep-sidebar' : '').'" href="'.base_url().'/user/my-files/?view=files&type=reported">
            '.$lang['home_SUMF_RF'].'
          </a>
        </li>
        <li>
          <a class="nav-link" href="'.base_url().'/user/my-files/?view=files&type=popular">
            '.$lang['home_SUMF_PF'].'
          </a>
        </li>
      </ul>
    </li>';

    // Sidebar: My folders
    echo '<li class="dropdown">
      <a href="javascript: void(0);" class="nav-link has-dropdown">
        <i class="fas fa-folder"></i>
        <span>
          '.$lang['home_SUMFF'].'
        </span>
      </a>
      <ul class="dropdown-menu">
        <li>
          <a class="nav-link" href="'.base_url().'/user/folder/?view=add_folder">
            '.$lang['home_SUMFA'].'
          </a>
        </li>';

    $q = $intbyte->query("SELECT * FROM folders WHERE user_id = ".$session->is_login()." ORDER BY `id` DESC");
    if($q->num_rows > 0) {

      while($folder = $q->fetch_assoc()) {

        // List of folders
        echo '<li>
          <a class="nav-link" href="'.base_url().'/user/folder/?view=folder&id='.$folder['id'].'">
            '.ucfirst($folder['name']).' ('.$intbyte->query("SELECT * FROM files WHERE user_id = ".$session->is_login()." AND folder = ".$folder['id']."")->num_rows.')
          </a>
        </li>';
      }
    } else {

      // Data not available
      echo '<li>
        <a class="nav-link" href="javascript: void(0);">
          No folders
        </a>
      </li>';
    }

    echo '</ul>
    </li>';

    // Sidebar: My notifications
    echo '<li class="dropdown">
      <a href="javascript: void(0);" class="nav-link has-dropdown">
        <i class="fas fa-bell"></i>
        <span>
          '.$lang['home_SUN'].'
        </span>
      </a>
      <ul class="dropdown-menu">
        <li>
          <a class="nav-link '.($intbyte->query("SELECT * FROM notifications WHERE notification_for = 'User' AND user_id = ".$session->is_login()." AND status = 'Unread'")->num_rows ? 'beep beep-sidebar' : '').'" href="'.base_url().'/user/notifications/?view=notifications&type=new">
            '.$lang['home_SMN_NN'].' 
          </a>
        </li>
        <li>
          <a class="nav-link" href="'.base_url().'/user/notifications/?view=notifications&type=archive">
            '.$lang['home_SMN_AN'].'
          </a>
        </li>
      </ul>
    </li>';

    // Sidebar: Settings
    echo '<li class="dropdown">
      <a href="javascript: void(0);" class="nav-link has-dropdown">
        <i class="fas fa-cogs"></i>
        <span>
          '.$lang['home_SS'].'
        </span>
      </a>
      <ul class="dropdown-menu">
        <li>
          <a class="nav-link" href="'.base_url().'/user/settings/?view=settings&type=profile">
            '.$lang['home_SS_PROFILE'].'
          </a>
        </li>
        <li>
          <a class="nav-link" href="'.base_url().'/user/settings/?view=settings&type=avatar">
            '.$lang['home_SS_AVATAR'].'
          </a>
        </li>
        <li>
          <a class="nav-link" href="'.base_url().'/user/settings/?view=settings&type=password">
            '.$lang['home_SS_PASSWORD'].'
          </a>
        </li>
        <li>
          <a class="nav-link" href="'.base_url().'/user/delete/">
            '.$lang['home_SS_DELETE'].'
          </a>
        </li>
      </ul>
    </li>';
  }
} else {

  // Sidebar: User welcome
  echo '<li class="menu-header">
    '.$lang['home_SS_WELCOME'].'
  </li>';
  
  // Sidebar: Active
  echo '<li class="dropdown active">
    <a href="javascript: void(0);" class="nav-link has-dropdown">
      <i class="fas fa-home"></i>
      <span>
        '.$lang['home_SS_WELCOME'].'
      </span>
    </a>
    <ul class="dropdown-menu">
      <li class=active>
        <a class="nav-link" href="'.base_url().'/login/">
          '.$lang['header_login'].'
        </a>
      </li>
      <li>
        <a class="nav-link" href="'.base_url().'/register/">
          '.$lang['header_register'].'
        </a>
      </li>
    </ul>
  </li>';

  // Sidebar: Contact us
  echo '<li class="dropdown">
    <a href="javascript: void(0);" class="nav-link has-dropdown">
      <i class="fas fa-phone"></i>
      <span>
        '.$lang['home_SCU'].'
      </span>
    </a>
    <ul class="dropdown-menu">
      <li>
        <a class="nav-link" href="'.base_url().'/contact/?via=email">
          '.$lang['home_SCU_EMAIL'].'
        </a>
      </li>
      <li>
        <a class="nav-link" href="'.base_url().'/contact/?via=messenger">
          '.$lang['home_SCU_MESSENGER'].'
        </a>
      </li>
    </ul>
  </li>';
}

echo '</ul>
  </aside>
</div>';
?>
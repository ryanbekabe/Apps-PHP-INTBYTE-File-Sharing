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
$title = 'Terms Of Service';
require_once 'incfiles/header.php';

// Section terms of service
echo '<section class="section">';

echo '<div class="section-header">
  <h1 class="section-title">
    Terms Of Service
  </h1>
  <div class="section-header-breadcrumb">
    <div class="breadcrumb-item active">
      <a href="'.base_url().'/">
        Dashboard
      </a>
    </div>
    <div class="breadcrumb-item">
      Terms Of Service
    </div>
  </div>
</div>';

echo '<div class="row">';

echo '<div class="page-error">
  <div class="page-inner">
    <h2>
      Terms Of Service
    </h2>
    <div class="page-description">
      <i class="text-muted">
        '.$lang['tos'].'
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

echo '</div>';
echo '</section>';
require_once 'incfiles/footer.php';
?>
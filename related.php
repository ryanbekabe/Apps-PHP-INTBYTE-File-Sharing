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

echo '<div class="row">
  <div class="col-12 col-md-6 col-lg-12">
    <h4 class="section-title text-muted" style="padding-left: 12px;">
      '.$lang['file_DOWNLOAD_LF'].'
    </h4>
    <div class="table-responsive" style="padding-left: 12px;">
      <table class="table mb-0">
        <tbody>';

        $q = $intbyte->query("SELECT * FROM files WHERE name != '".$file['name']."' AND user_id = '".$file['user_id']."' ORDER BY `id` DESC LIMIT 5");
        if($q->num_rows > 0) {

          $no = 1;
          while($related = $q->fetch_assoc()) {

            // List of related files
            echo '<tr>
              <td>
                <span class="badge badge-danger badge-sm badge-circle">
                  '.$no.'
                </span>
                <a href="'.base_url().'/'.$related['token'].'.html">
                  '.$related['name'].'
                </a>
                <div class="table-links text-left">
                  '.$lang['file_DOWNLOAD_SIZE'].': '.$core->size($file['size']).'
                  <div class="bullet"></div>
                  '.$lang['file_DOWNLOAD_DOWNLOADED'].': '.number_format($file['downloaded'], 0, ',', '.').'x
                </div>
              </td>
            </tr>';

            // Do not remove this line because it is important
            $related++;
            $no++;
          }
        } else {

          // Data not available
          echo '<tr>
            <td>
              '.$lang['file_DOWNLOAD_NF'].'
            </td>
          </tr>';
        }

        echo '</tbody>
      </table>
    </div>
  </div>
</div>';
?>
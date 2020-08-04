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

// This is for download handle

// Config
if(isset($_GET['id']) && isset($_GET['reff'])) {

  // Data
  $file_id = intval($_GET['id']);
  $file_tag = $core->fileExt($core->getFile($file_id));
  $file_name = $core->getFile($file_id);
  $reff = intval($_GET['reff']);

  // The unique session file id
  if(!isset($_SESSION['download'.$file_id])) {
    $core->redirect(base_url().'/get/'.$file_id.'/'.$info['name'].'');
  }

  // The unique session file id and file name
  if($_GET['sid'] != $_SESSION['download'.$file_id]) {
    $core->redirect(base_url().'/get/'.$file_id.'/'.$info['name'].'');
  }

  $q = $intbyte->query("SELECT * FROM files WHERE id = '".$file_id."' AND user_id = '".$reff."'");
  if($q->num_rows > 0) {

    $info = $q->fetch_assoc();
    $file = 'data/'.$core->username($info['user_id']).'/'.$file_name.'';

    // Check the file or file readable
    if(!is_file($file) || !is_readable($file)) {
      $core->redirect(base_url().'/get/'.$file_id.'/'.$info['name'].'');
    } else {

      // Read the file
      $intbyte->query("UPDATE files SET downloaded = downloaded+1 WHERE id = '".$file_id."' AND user_id = '".$reff."'");
      $fp = fopen($file, 'rb');
      header('Content-type:application/octet-stream');
      header('Content-disposition: attachment;filename="['.$_SERVER['HTTP_HOST'].'] - '.$info['name'].'"');
      header('Content-length: '.$info['size']);
      fpassthru($fp);
      fclose($fp);
    }
  }
} else {

  // Illegal access
  $core->redirect(base_url().'/get/'.$file_id.'/'.$info['name'].'');
}
?>
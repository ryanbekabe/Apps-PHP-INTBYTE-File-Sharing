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

/**
 * This is a helpers for core of your site perfomance.
 * Do not remove this helpers.
 * you can add more helpers in here
 */

class Core_Func {

  // Core of site settings
  public function set($settings) {

    // Global database connection
    global $intbyte;

    $q = $intbyte->query('SELECT * FROM settings');
    $siteSet = array();
    while($setup = $q->fetch_assoc()) {
      $siteSet[$setup['name']] = $setup['value'];
      ++$setup;
    }

    // Return value of site settings
    return $siteSet[$settings];
  }

  // Core of redirect to other pages
  public function redirect($url) {
    $this->url = $url;
    header('location: '.$this->url.'');
  }

  // Core of filter input to database
  public function filter_input($string) {
    $this->text = $string;
    return trim(addslashes($this->text)); // Return value of filer input database
  }

  // Core of filter output
  public function filter_output($text, $html = FALSE) {
		if($html) {
			return trim(stripslashes($text)); // Return value of filter output
		} else {
			return trim(htmlspecialchars(stripslashes($text))); // Return value of filter output
		}
  }
  
  // Core of escape to database
  public function escapeToDB($string) {

    // Global database connection
    global $intbyte;

    $this->text = $string;
    return $intbyte->real_escape_string($this->text); // Return value of escape to database
  }

  // Core of username validation
  public function is_username($username) {
    
    $this->username = $username;
		if(strlen($this->username) == 0) {
			return false;
		}
		
		if(preg_match('/^[a-zA-Z0-9._-]*$/', $this->username)) {
			return true;
		} else {
			return false;
		}
  }

  // Core of email validation
  public function is_email($email) {
		
		$this->email = $email;
		if(strlen($this->email) == 0) {
			return false;
		}
		
		if(preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $this->email)) {
			return true;
		} else {
			return false;
		}
  }

  // Core of random chars
  public function genChar($length, $bool = FALSE) {
		
		$this->length = $length;
		$this->bool = $bool;
		$this->chars = 'abcdefghijkpmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_';
		
		if($this->bool == TRUE) {
			$chars = substr(str_shuffle($this->chars), 0, $this->length);
		} else {
      $chars = 'Something an error!';
    }
		
		return $chars; // Return of random chars
  }

  // Core of permalink
  public function permalink($str) {

    $this->string = $str;
    $this->string = strtolower(trim($this->string)); 
    $this->string = preg_replace('/[^a-z0-9-]/', '-', $this->string);
    $this->string = preg_replace('/-+/', "-", $this->string);
      
    return $this->string; // Return value of permalink
  }

  // Core of escape
  public function _e($text) {
    $this->text = $text;
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8'); // Return value of escape
  }

  // Core of get username
  public function username($id) {

    // Global database connection
    global $intbyte;
    		
		$this->username = $id;
		$q = $intbyte->query("SELECT * FROM users WHERE id = '".$this->username."'");
		$max = $q->fetch_array();
    
    // Return value of get username
		return $max['username'];
  }

  // Core of show avatar
  public function show_avatar($id) {

    $this->id = $id;
    $this->dir = (!file_exists('images') ? '../images' : 'images');

    if(file_exists(''.$this->dir.'/'.$this->id.'.png')) {

      // PNG Avatar
      $this->avatar = ''.$this->dir.'/avatar/'.$this->id.'.png';
    } elseif(file_exists(''.$this->dir.'/avatar/'.$this->id.'.jpg')) {

      // JPG Avatar
      $this->avatar = ''.$this->dir.'/avatar/'.$this->id.'.jpg';
    } elseif(file_exists(''.$this->dir.'/avatar/'.$this->id.'.gif')) {

      // GIF Avatar
      $this->avatar = ''.$this->dir.'/avatar/'.$this->id.'.gif';
    } else {
      
      // Default
      $this->avatar = ''.$this->dir.'/avatar/default.png';
    }

    // Return value of show avatar
    return $this->avatar;
  }

  // Core of show icon
  public function show_icon($ext) {

    $this->ext = $ext;
    $this->icon = (!file_exists('../images/icon/'.$this->ext.'.png') ? (!file_exists('images/icon/'.$this->ext.'.png') ? '../../images/icon/'.$this->ext.'.png' : 'images/icon/'.$this->ext.'.png') : '../../images/icon/'.$this->ext.'.png');

    // Return value of show icon
    return $this->icon;
  }

  // Core of size
  public function size($byte) {

    $this->size = $byte;
    $this->units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $this->power = ($this->size > 0 ? floor(log($this->size, 1024)) : 0);

    // Return value of size
    return ''.number_format(($this->size / pow(1024, $this->power)), 2, '.', ',').' '.$this->units[$this->power].'';
  }

  // Core of update setting
  public function update_set($name, $value) {

    // Global database connection
    global $intbyte;

    $this->name = $name;
    $this->value = $value;
    $intbyte->query('UPDATE `settings` SET `value` = "'.$this->value.'", `time` = "'.time().'" WHERE `name` = "'.$this->name.'";');
    
    // Return value of update settings
    return TRUE;
  }

  // Core of status
  public function status($id) {

    // Global language
    global $lang;

    $this->id = $id;
    if($this->id == 0) {

      // Status Not Confirmation Account
      $this->status = '<div class="badge badge-danger" data-toggle="tooltip" title="'.$lang['status_NC'].'">
        '.$lang['status_NCA'].'
      </div>';
    } elseif($this->id == 1) {

      // Status Confirmation Account
      $this->status = '<div class="badge badge-success" data-toggle="tooltip" title="'.$lang['status_C'].'">
        '.$lang['status_CA'].'
      </div>';
    }

    // Return value of status
    return $this->status;
  }

  // Core of level
  public function level($id) {

    // Global language
    global $lang;

    $this->id = $id;
    if($this->id == 0) {

      // User Blocked Or Banned
      $this->level = '<div class="badge badge-danger">
        '.$lang['status_BLOCKED'].'
      </div>';
    } elseif($this->id == 1) {

      // Main Admin
      $this->level = '<div class="badge badge-success">
        ADMIN
      </div>';
    } elseif($this->id == 2) {

      // User
      $this->level = '<div class="badge badge-warning">
        '.$lang['status_USER'].'
      </div>';
    }

    // Return value of level
    return $this->level;
  }

  // Core of status ads
  public function status_ads($status) {

    // Global language
    global $lang;

    $this->status = $status;
    if($this->status == 'A') {

      // Approved
      $this->status_ads = '<div class="badge badge-success" data-toggle="tooltip" title="'.$lang['status_UAD_APPROVE'].'">
        <i class="fas fa-check"></i>
        '.$lang['status_UAD_APPROVED'].'
      </div>';
    } elseif($this->status == 'R') {

      // Rejected
      $this->status_ads = '<div class="badge badge-warning" data-toggle="tooltip" title="'.$lang['status_UAD_REJECT'].'">
        <i class="fas fa-eye-slash"></i>
        '.$lang['status_UAD_REJECTED'].'
      </div>';
    } elseif($this->status == 'B') {

      // Blocked
      $this->status_ads = '<div class="badge badge-danger" data-toggle="tooltip" title="'.$lang['status_UAD_BLOCK'].'">
        <i class="fas fa-times"></i>
        '.$lang['status_UAD_BLOCKED'].'
      </div>';
    } elseif($this->status == 'D') {

      // Deleted
      $this->status_ads = '<div class="badge badge-danger" data-toggle="tooltip" title="'.$lang['status_UAD_DELETE'].'">
        <i class="fas fa-trash"></i>
        '.$lang['status_UAD_DELETED'].'
      </div>';
    } elseif($this->status == 'W') {

      // Waiting
      $this->status_ads = '<div class="badge badge-warning" data-toggle="tooltip" title="'.$lang['status_UAD_WTA'].'">
        <i class="fas fa-clock"></i>
        '.$lang['status_UAD_WTA2'].'
      </div>';
    }

    // Return value of status ads
    return $this->status_ads;
  }

  // Core of file extension
  public function fileExt($name) {

    $this->fileName = $name;
    $this->file1 = strrpos($this->fileName, '.');
    $this->file2 = substr($this->fileName, $this->file1 + 1, 999);

    // Return value of file extension
    return strtolower($this->file2);
  }

  // Core of get file name
  public function getFile($name) {

    // Global database connection
    global $intbyte;

    $q = $intbyte->query("SELECT * FROM files WHERE id = '".$name."'");
    $file = $q->fetch_array();

    // Return value of get file name
    return $file['name'];
  }

  // Core of get folder
  public function getfolder($id) {

    // Global database connection
    global $intbyte;

    $this->id = $id;
    $q = $intbyte->query("SELECT * FROM folders WHERE id = ".$this->id."");
    $folder_name = $q->fetch_assoc();

    // Return value of get folder
    return $folder_name['name'];
  }

  // Core of remove path
  public function remove_path($path) {

    $this->path = $path;

    foreach(glob($this->path.'/*') as $file) {
      if(is_dir($file)) {

        // Remove Directory
        rmdir($file);
      } else {

        // Remove File
        unlink($file);
      }
    }
  }

  // Core of insert data
  public function insert_data($id) {

    // Global database connection
    global $intbyte;

    $this->id = $id;
    $q = $intbyte->query("SELECT MAX(id) FROM ".$this->id."");
    $this->max = $q->fetch_array();

    // Return of insert data
    return $this->max['MAX(id)']+1;
  }

  // Core of get without path
  public function getWithoutPath($file_name) {
    return end(explode('/', $file_name)); // Return value of get without path
  }

  // Core of rm20
  public function rm20($file_name) {
    return str_replace('%20', '', $file_name); // Return value of rm20
  }
}

$core = new Core_Func();
?>
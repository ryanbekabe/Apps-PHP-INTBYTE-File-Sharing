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
 * This is a helpers for core of your time website.
 * Do not remove this helpers.
 * you can add more helpers in here
 */
 class Time_Ago {

	// Time ago
	public function timeAgo($original) {
		
		// Global language
		global $lang;

	 	// Time list from the years until just now
		$this->list = array(
      array(60 * 60 * 24 * 365, $lang['timeAgoYears']),
      array(60 * 60 * 24 * 30, $lang['timeAgoMonths']),
      array(60 * 60 * 24 * 7, $lang['timeAgoWeeks']),
      array(60 * 60 * 24, $lang['timeAgoDays']),
      array(60 * 60, $lang['timeAgoHours']),
      array(60, $lang['timeAgoMinutes'])
		);

		// Time count
		$this->timeAgo = time() - $original;

		// If time less 60 seconds and more than 1 days was excecute in here
		if($this->timeAgo < 60) {			
			return $lang['timeAgoJustNow']; // Return just now
		} elseif($this->timeAgo > 604800) {			
			return ''.date('Y-m-d H:i', $original).''; // Return YYYY-MM-DD H:I
		}
		
		for($i = 0; $i <= count($this->list); $i++) {
			
			// Get seconds and names of time list
			$this->seconds = $this->list[$i][0];
			$this->names = $this->list[$i][1];
			
			// TIme count
			if(($this->count = floor($this->timeAgo / $this->seconds)) != 0) {
				break;
			}
		}
		
		//Time ago
		$time = ($this->count == 1) ? '1 '.$this->names : "$this->count {$this->names}";
		return $time; // Return time ago
	}
 }

 $time = new Time_Ago();
 ?>
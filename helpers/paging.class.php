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

// Getting active page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$start = (($page - 1) * $core->set('paging'));

class Paging {

  //Property of pagination
  private $all;
	private $page;
	private $num;
  private $url;
  
  // Show page
  public function showPage($all, $page, $num, $url) {
    
    // Global language
    global $lang;

    $this->all = $all;
		$this->page = $page;
		$this->num = $num;
		$this->url = $url;
		
    $totalPage = ceil($this->all / $this->num);
    
    // Previous page
    if($this->page != 1) {

      // When active page
      $prev_page = '<li class="page-item">
        <a class="page-link" href="'.$this->url.'page='.($this->page - 1).'" tabindex="-1">
          <i class="fas fa-chevron-left"></i>
        </a>
      </li>';
    } else {

      // When nonactive page
      $prev_page = '<li class="page-item disabled">
        <a class="page-link" href="#" tabindex="-1">
          <i class="fas fa-chevron-left"></i>
        </a>
      </li>';
    }

    // Next page
    if($this->page != $totalPage) {

      // When active page
      $next_page = '<li class="page-item">
        <a class="page-link" href="'.$this->url.'page='.($this->page + 1).'">
          <i class="fas fa-chevron-right"></i>
        </a>
      </li>';
    } else {

      // When nonactive page
      $next_page = '<li class="page-item disabled">
        <a class="page-link" href="#" tabindex="-1">
          <i class="fas fa-chevron-right"></i>
        </a>
      </li>';
    }

    //First page if active page on center position
    if($this->page - 4 > 0) {

      //On first with dotted
			//Example: <-1...567820->
      $first = '<li class="page-item">
        <a class="page-link" href="'.$this->url.'page=1">
          1
        </a>
      </li>';
    }

    //Last page if active page on center position
    if($this->page + 4 <= $totalPage) {

      //On last with dotted
			//Example: <-1...5678...20->
      $last = '<li class="page-item">
        <a class="page-link" href="'.$this->url.'page='.$totalPage.'">
          '.$totalPage.'
        </a>
      </li>';
    }

    // Page 2 left
    if($this->page - 2 > 0) {

      $page2left = '<li class="page-item">
        <a class="page-link" href="'.$this->url.'page='.($this->page - 2).'">
          '.($this->page - 2).'
        </a>
      </li>';
    }

    // Page 1 left
    if($this->page - 1 > 0) {

      $page1left = '<li class="page-item">
        <a class="page-link" href="'.$this->url.'page='.($this->page - 1).'">
          '.($this->page - 1).'
        </a>
      </li>';
    }

    // Page 2 right
    if($this->page + 2 <= $totalPage) {

      $page2right = '<li class="page-item">
        <a class="page-link" href="'.$this->url.'page='.($this->page + 2).'">
          '.($this->page + 2).'
        </a>
      </li>';
    }

    // Page 1 right
    if($this->page + 1 <= $totalPage) {

      $page1right = '<li class="page-item">
        <a class="page-link" href="'.$this->url.'page='.($this->page + 1).'">
          '.($this->page + 1).'
        </a>
      </li>';
    }

    // If the page more than $totalPage
    if($this->page > $totalPage) {
      header('location: '.$this->url.'page=1');
    }

    // Output HTML
    $html = '<nav class="d-inline-block">
      <center>
        <span class="text-muted">
          '.$lang['page'].':
          '.(number_format($this->page, 0, ',', '.')).' / '.(number_format($totalPage, 0, ',', '.')).'
        </span>
      </center>
      <ul class="pagination mb-0">
        '.$prev_page.'
        '.$first.'
        '.$page2left.'
        '.$page1left.'
        <li class="page-item active">
          <a class="page-link" href="javascript: void(0);">
            '.$this->page.'
            <span class="sr-only">(current)</span>
          </a>
        </li>
        '.$page1right.'
        '.$page2right.'
        '.$last.'
        '.$next_page.'
      </ul>
    </nav>';

    // Return value of HTML page
    return $html;
  }
}

$paging = new Paging();
?>
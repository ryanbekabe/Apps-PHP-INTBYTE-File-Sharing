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

// Footer page
echo '</div>
<footer class="main-footer">
  <div class="footer-left">
    &copy; 2019 - '.date('Y').'
    <a href="'.base_url().'/">
      '.$core->set('title').'
    </a>
    <div class="bullet">
    </div>
    Design By
    <a href="https://nauval.in/">
      Muhamad Nauval Azhar
    </a>
  </div>
  <div class="footer-right">
  </div>
</footer>
</div>
</div>';

// General JS scripts
echo '<script src="'.base_url().'/assets/modules/popper.js"></script>
  <script src="'.base_url().'/assets/modules/tooltip.js"></script>
  <script src="'.base_url().'/assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="'.base_url().'/assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="'.base_url().'/assets/modules/moment.min.js"></script>
  <script src="'.base_url().'/assets/js/stisla.js"></script>';

// JS libraies
echo '<script src="'.base_url().'/assets/modules/summernote/summernote-bs4.js"></script>
  <script src="'.base_url().'/assets/modules/jquery-ui/jquery-ui.min.js"></script>
  <script src="'.base_url().'/assets/modules/select2/dist/js/select2.full.min.js"></script>
  <script src="'.base_url().'/assets/modules/jquery-selectric/jquery.selectric.min.js"></script>
  <script src="'.base_url().'/assets/modules/izitoast/js/iziToast.min.js"></script>
  <script src="'.base_url().'/assets/modules/owlcarousel2/dist/owl.carousel.min.js"></script>';

// Page specific JS files
echo '<script src="'.base_url().'/assets/js/page/index-0.js"></script>
  <script src="'.base_url().'/assets/js/page/forms-advanced-forms.js"></script>
  <script src="'.base_url().'/assets/js/page/modules-toastr.js"></script>
  <script src="'.base_url().'/assets/modules/jquery-pwstrength/jquery.pwstrength.min.js"></script>
  <script src="'.base_url().'/assets/js/page/auth-register.js"></script>';
  
// Template JS files
echo '<script src="'.base_url().'/assets/js/scripts.js"></script>
  <script src="'.base_url().'/assets/js/custom.js"></script>';

echo '</body>
</html>';
?>
<?php 
class SecureLoginPlugin {
  /*private $rendererHtml;
  private $rendererHandle;
  private $rendererHooks;
  //private $renderOptionPage;
  private $gCaptchaSiteKey;*/
  
  public function __construct() {
    
    $this->load_dependencies();
    $this->rendererHooks    = new SecureLoginHooks();

    $this->rendererHtml     = new SecureLoginRenderer();
    
    $this->renderOptionPage = new SecureLoginOptionPage();
    $this->gCaptchaSiteKey    = $this->rendererHooks->gCaptchaSiteKey;
    $this->gCaptchaSecretKey  = $this->rendererHooks->gCaptchaSecretKey;

    $this->rendererHandle   = new SecureLoginHandle($this->gCaptchaSecretKey);

    // Add login form shortcode
    add_shortcode('secure_login_form', [$this->rendererHtml, 'render_login_form']);
    
    // Handle login form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['secure_login_nonce'])) {
      add_action('init', [$this->rendererHandle, 'handle_login']);
    }   

    // Enqueue styles and scripts
    add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
  }

  public function load_dependencies(){
    require_once WTS_PLUGIN_PATH . 'classes/view/class-render-forms.php';
    require_once WTS_PLUGIN_PATH . 'classes/class-login-handle.php';
    require_once WTS_PLUGIN_PATH . 'classes/class-all-hooks.php';
    require_once WTS_PLUGIN_PATH . 'classes/admin/class-admin-functions.php';
  }

  public function enqueue_assets() {
    //
    wp_enqueue_style('secure-login-style', WTS_PLUGIN_URL . 'css/style.css');
    wp_enqueue_script('secure-login-script', WTS_PLUGIN_URL . 'js/script.js', ['jquery'], null, true);

    if($this->gCaptchaSiteKey){
      wp_enqueue_script('captcha-script', '//www.google.com/recaptcha/api.js', ['jquery'], null, true);
    }
  }

  public function locate_template($template_name) {
    // Check if the template exists in the theme folder
    $theme_template = get_stylesheet_directory() . '/wts-secure-login/' . $template_name;

    // If the template exists in the theme, use it
    if (file_exists($theme_template)) {
      return $theme_template;
    }

    // Otherwise, return the default template from the plugin
    return WTS_PLUGIN_PATH . 'templates/' . $template_name;
  }
  
}

session_start();
new SecureLoginPlugin();
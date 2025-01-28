<?php 
class SecureLoginPlugin {
  private $rendererHtml;
  private $rendererHandle;
  
  public function __construct() {
    $this->rendererHtml = new SecureLoginRenderer();
    $this->rendererHandle = new SecureLoginHandle();

    // Add login form shortcode
    add_shortcode('secure_login_form', [$this->rendererHtml, 'render_login_form']);
    
    // Handle login form submission
    add_action('init', [$this->rendererHandle, 'handle_login']);

    // Enqueue styles and scripts
    add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
  }

  public function enqueue_assets() {
    wp_enqueue_style('secure-login-style', WTS_PLUGIN_URL . 'css/style.css');
    wp_enqueue_script('secure-login-script', WTS_PLUGIN_URL . 'js/script.js', ['jquery'], null, true);
  }
}

session_start();
new SecureLoginPlugin();
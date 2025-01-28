<?php 
class SecureLoginPlugin {
  private $rendererHtml;
  private $rendererHandle;
  
  public function __construct() {
    $this->load_dependencies();
    $this->rendererHtml = new SecureLoginRenderer();
    $this->rendererHandle = new SecureLoginHandle();

    // Add login form shortcode
    add_shortcode('secure_login_form', [$this->rendererHtml, 'render_login_form']);
    
    // Handle login form submission
    add_action('init', [$this->rendererHandle, 'handle_login']);
    

    // Enqueue styles and scripts
    add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
    //add_action('init', [$this, 'load_template_to_overright']);

    // $this->load_template('login-form.php');

    add_action('secure_login_add_nonce', [$this, 'add_nonce_to_form'], 10, 2);
    add_action('generate_captcha_value', [$this, 'generate_captcha'], 9);
  }

  public function load_dependencies(){
    require_once WTS_PLUGIN_PATH . 'classes/class-render-forms.php';
    require_once WTS_PLUGIN_PATH . 'classes/class-login-handle.php';
  }

  public function enqueue_assets() {
    wp_enqueue_style('secure-login-style', WTS_PLUGIN_URL . 'css/style.css');
    wp_enqueue_script('secure-login-script', WTS_PLUGIN_URL . 'js/script.js', ['jquery'], null, true);
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

  public function add_nonce_to_form($action, $nonce_field) {
    wp_nonce_field($action, $nonce_field);
  }  

  public function generate_captcha() {
    // Generate two random numbers for the CAPTCHA
    $num1 = rand(1, 9);
    $num2 = rand(1, 9);
    $sum = $num1 + $num2;
    
    // Store the sum in the session for later verification
    $_SESSION['secure_login_captcha'] = $sum;

    // Static flag to ensure CAPTCHA is added only once
    static $captcha_added = false;

    // Check if CAPTCHA has already been added
    if (!$captcha_added) {
        ?>
        <label for="captcha">Captcha: What is <?php echo $num1 . ' + ' . $num2; ?>?</label>
        <input type="text" name="captcha" id="captcha" required>
        <?php
        $captcha_added = true; // Set the flag to true after adding CAPTCHA
    }
  }
}

session_start();
new SecureLoginPlugin();
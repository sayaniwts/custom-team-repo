<?php
class SecureLoginOptionPage {
  private $option_name = 'secure_login_options';

  public function __construct()
  {
    add_action('admin_menu', [$this, 'add_menu_page']);
    add_action('admin_init', [$this, 'register_settings']);
  }

  // Add menu page to WordPress dashboard
  public function add_menu_page()
  {
    add_menu_page(
      __('Secure Login Settings', 'wts-secure-login'),
      __('Secure Login', 'wts-secure-login'),
      'manage_options',
      'secure-login-options',
      [$this, 'render_options_page'],
      'dashicons-yes-alt',
      100
    );
  }

  // Register settings
  public function register_settings()
  {
    register_setting($this->option_name, $this->option_name);

    add_settings_section(
      'secure_login_settings_section',
      __('reCAPTCHA Settings', 'wts-secure-login'),
      [$this, 'settings_section_description'],
      $this->option_name
    );

    // Create fields
    add_settings_field(
      'enable_recaptcha',
      __('Enable reCAPTCHA', 'wts-secure-login'),
      [$this, 'enable_key_callback'],
      $this->option_name,
      'secure_login_settings_section'
    );

    add_settings_field(
      'site_key',
      __('Site Key', 'wts-secure-login'),
      [$this, 'site_key_callback'],
      $this->option_name,
      'secure_login_settings_section'
    );

    add_settings_field(
      'secret_key',
      __('Secret Key', 'wts-secure-login'),
      [$this, 'secret_key_callback'],
      $this->option_name,
      'secure_login_settings_section'
    );
  }

  // Section description
  public function settings_section_description()
  {
 	?>
   <p><?php _e("Gravity Forms integrates with reCAPTCHA, a free CAPTCHA service that uses an advanced risk analysis engine and adaptive challenges to keep automated software from engaging in abusive activities on your site. Please note, only v2 keys are supported and checkbox keys are not compatible with invisible reCAPTCHA. These settings are required only if you decide to use the reCAPTCHA field. Get your reCAPTCHA Keys.", 'wts-secure-login'); ?></p>
  <?php
  }

  // Custom text field callback
  public function enable_key_callback() {
	  $options = get_option($this->option_name);
	  $checked = isset($options['enable_recaptcha']) && $options['enable_recaptcha'] == '1' ? 'checked' : '';
	  echo '<input type="checkbox" name="' . $this->option_name . '[enable_recaptcha]" value="1" ' . $checked . ' />';
	}

  public function site_key_callback()
  {
    $options = get_option($this->option_name);
    $site_key = isset($options['site_key']) ? esc_attr($options['site_key']) : '';
    echo '<input type="text" name="' . $this->option_name . '[site_key]" value="' . $site_key . '" class="regular-text" />';
  }

  public function secret_key_callback()
  {
    $options = get_option($this->option_name);
    $secret_key = isset($options['secret_key']) ? esc_attr($options['secret_key']) : '';
    echo '<input type="text" name="' . $this->option_name . '[secret_key]" value="' . $secret_key . '" class="regular-text" />';
  }

  // Render options page
  public function render_options_page()
  {
?>
    <div class="wrap">
      <h1><?php _e("Secure Login Options", "wts-secure-login"); ?></h1>
      <form method="post" action="options.php">
        <?php
        settings_fields($this->option_name);
        do_settings_sections($this->option_name);
        submit_button();
        ?>
      </form>
    </div>
<?php
  }
}

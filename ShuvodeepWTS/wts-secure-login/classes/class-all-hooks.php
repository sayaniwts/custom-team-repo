<?php 
class SecureLoginHooks {
	private $errors = '';
	public function __construct(){
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
		$this->gCaptchaKeys = get_option('secure_login_options');
		if($this->gCaptchaKeys['enable_recaptcha']){
			$this->gCaptchaSiteKey = $this->gCaptchaKeys['site_key'];
    	$this->gCaptchaSecretKey = $this->gCaptchaKeys['secret_key'];
		}else{
			$this->gCaptchaSiteKey = false;
			$this->gCaptchaSecretKey = false;
		}
		
		$this->rendererHandle   = new SecureLoginHandle($this->gCaptchaSecretKey);	

		add_action('secure_login_errors', [$this, 'validation_message']);
		add_action('secure_login_display_errors', [$this, 'display_errors']);
		add_action('secure_login_add_nonce', [$this, 'add_nonce_to_form'], 10, 2);
    add_action('generate_captcha_value', [$this, 'generate_captcha'], 9);    
	}

	public function generate_captcha() {
    static $captcha_added = false;
    if(!$this->gCaptchaKeys['enable_recaptcha']){      
      if (!$captcha_added) {
      	// Generate two random numbers for the CAPTCHA
		    $num1 = rand(1, 9);
		    $num2 = rand(1, 9);
		    $sum = $num1 + $num2;
		    
		    // Store the sum in the session for later verification
		    $_SESSION['secure_login_captcha'] = $sum;
    ?>
        <label for="captcha">Captcha: What is <?php echo $num1 . ' + ' . $num2; ?>?</label>
        <input type="text" name="captcha" id="captcha" required>
        <?php
        $captcha_added = true; // Set the flag to true after adding CAPTCHA
      }
    }else{
      if (!$captcha_added) {
    ?>
        <div class="g-recaptcha" data-sitekey="<?php echo $this->gCaptchaSiteKey; ?>"></div>
    <?php
        $captcha_added = true;
      }
    }
  }

  public function add_nonce_to_form($action, $nonce_field) {
    wp_nonce_field($action, $nonce_field);
  }

  public function validation_message($errorMsg) {  	
		$this->errors = $errorMsg;
	}

	public function display_errors() {
		if (!empty($this->errors)) {
			echo '<div class="error-message" style="color:red;">' . $this->errors . '</div>';
		}
	}
}
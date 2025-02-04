<?php 
class SecureLoginHandle {
  private $gCaptchaSecretKey;
  private $errorMsg = "";

  public function __construct($secretKey) {
    $this->gCaptchaSecretKey = $secretKey;
    add_action('wp_login_failed', [$this, 'handle_login']);
  }

  public function handle_login() {  
      
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['secure_login_nonce'])) {
      if (!wp_verify_nonce($_POST['secure_login_nonce'], 'secure_login_action')) {
        $this->errorMsg = 'Security check failed.';
      }

      $this->secure = false;
      if (isset($_POST['captcha']) && $_POST['captcha'] != $_SESSION['secure_login_captcha']) {
        $this->errorMsg = 'Captcha validation failed.';
      }else if (isset($_POST['g-recaptcha-response'])) {
        $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
        $response = wp_remote_post($verifyUrl, [
          'body' => [
            'secret'   => $this->gCaptchaSecretKey,
            'response' => $_POST['g-recaptcha-response'],
            'remoteip' => $_SERVER['REMOTE_ADDR']
          ]
        ]);

        $responseBody = wp_remote_retrieve_body($response);
        $responseKeys = json_decode($responseBody, true);

        if (empty($responseKeys['success']) || !$responseKeys['success']) {
          $this->errorMsg = 'reCAPTCHA verification failed. Please try again.';
        }else{
          $this->secure = true;
        }

      }

      if($this->secure){
        $username = sanitize_text_field($_POST['username']);
        $password = $_POST['password'];

        $creds = [
          'user_login'    => $username,
          'user_password' => $password,
          'remember'      => true,
        ];

        $user = wp_signon($creds, is_ssl());
        if (is_wp_error($user)) {
          $this->errorMsg = $user->get_error_message();                
        }else{
          wp_redirect(home_url());
          exit;
        }
      }

      // Trigger hook to pass errors
      if (!empty($this->errorMsg)) {
        do_action('secure_login_errors', $this->errorMsg);
      }            
    }
  }

  public function get_errors(){
    return $this->errorMsg;
  }
}
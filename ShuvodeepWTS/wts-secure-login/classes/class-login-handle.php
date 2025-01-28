<?php 
class SecureLoginHandle {
	public function handle_login() {
      if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['secure_login_nonce'])) {
        if (!wp_verify_nonce($_POST['secure_login_nonce'], 'secure_login_action')) {
          wp_die('Security check failed.');
        }

        if (!isset($_POST['captcha']) || $_POST['captcha'] != $_SESSION['secure_login_captcha']) {
          wp_die('Captcha validation failed.');
        }

        $username = sanitize_text_field($_POST['username']);
        $password = $_POST['password'];

        $creds = [
          'user_login'    => $username,
          'user_password' => $password,
          'remember'      => true,
        ];

        $user = wp_signon($creds, is_ssl());
        if (is_wp_error($user)) {
          wp_die($user->get_error_message());
        }

      wp_redirect(home_url());
      exit;
    }
  }
}
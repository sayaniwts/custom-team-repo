<?php

class SecureLoginRenderer {
  public function render_login_form() {
    if (is_user_logged_in()) {
      return '<p>You are already logged in.</p>';
    }
    ob_start();
    include plugin_dir_path(__FILE__) . '../templates/login-form.html';
    return ob_get_clean();
  }

  public function generate_captcha() {
    $num1 = rand(1, 9);
    $num2 = rand(1, 9);
    $sum = $num1 + $num2;
    $_SESSION['secure_login_captcha'] = $sum;
    return "$num1 + $num2";
  }
}

<?php

class SecureLoginRenderer {
  public function render_login_form() {
    $template_locate = new SecureLoginPlugin();
    $template_file = $template_locate->locate_template('login-form.php');
    if (is_user_logged_in()) {
      return '<p>You are already logged in.</p>';
    }
    ob_start();
    if (file_exists($template_file)) {
      include $template_file;
    } else {
      echo 'Template not found!';
    }
    return ob_get_clean();
  }
}

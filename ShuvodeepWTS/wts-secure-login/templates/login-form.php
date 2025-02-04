<div class="secure-login-wrapper">
  <?php do_action('secure_login_display_errors'); ?>
  <div class="secure-from-wrap">
    <form id="secure-login-form" method="post" action="">
      <div class="input-wrapper">
        <label for="username">Username or Email</label>
        <input type="text" name="username" id="username" required>
      </div>

      <div class="input-wrapper">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
      </div>

      <div class="cap-sub-wrapper">
        <div class="input-wrapper">
          <?php do_action('generate_captcha_value');  ?>
        </div>
        <div class="input-wrapper">      
          <?php do_action('secure_login_add_nonce', 'secure_login_action', 'secure_login_nonce');  ?>
          <input type="submit" value="Login">
        </div>
      </div>
    </form>
  </div>
</div>

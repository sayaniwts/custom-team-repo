<form id="secure-login-form" method="post" action="">
    <label for="username">Username or Email</label>
    <input type="text" name="username" id="username" required>

    <label for="password">Password</label>
    <input type="password" name="password" id="password" required>

    <label for="captcha">Captcha: What is <?php echo $this->generate_captcha(); ?>?</label>
    <input type="text" name="captcha" id="captcha" required>

    <?php do_action('generate_captcha_value');  ?>
    
    <?php do_action('secure_login_add_nonce', 'secure_login_action', 'secure_login_nonce');  ?>
    <button type="submit">Login</button>
</form>

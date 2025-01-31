<?php 

// Restrict API access to logged-in administrators only
add_action('rest_api_init', function() {
    if (!is_user_logged_in() || !current_user_can('administrator')) {
        wp_die('Forbidden', '403 Forbidden', array('response' => 403)); // Deny access if not an admin
    }
}, 10);
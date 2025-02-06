<?php 

// Disable REST API for non-authenticated users, but allow administrators 
add_action('rest_api_init', function() {
    if (!is_user_logged_in() || !current_user_can('administrator')) {
    wp_die('You are not authorized to view this API endpoint.', 'Unauthorized', array('response' => 403));
        }
    }, 10);
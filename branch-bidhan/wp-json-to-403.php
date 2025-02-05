<?php 

/**
 * Block access to the WordPress REST API.
 *
 * This function prevents any access to the WordPress REST API by checking the request URI.
 * If the request URI contains "/wp-json", the user will receive a 403 Forbidden response.
 */
function block_wp_json() {
    // Check if the requested URI contains '/wp-json' (which is used for REST API requests)
    if ( strpos($_SERVER['REQUEST_URI'], '/wp-json') !== false ) {
        // If '/wp-json' is found in the URI, stop execution and return a 403 Forbidden error
        wp_die( 'You are not authorized to view this API endpoint.', '403 Forbidden', array( 'response' => 403 ) );
    }
}

// Hook the 'block_wp_json' function to the 'init' action
add_action( 'init', 'block_wp_json' );
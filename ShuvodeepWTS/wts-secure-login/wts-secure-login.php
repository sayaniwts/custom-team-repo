<?php 
/**
 * Plugin Name: Secure Login Plugin(WTS)
 * Description: A custom login plugin for WordPress with enhanced security measures.
 * Version: 1.0
 * Author: Webskitters Technology Solutions Pvt. Ltd
**/

// Prevent direct access
if (!defined('ABSPATH')) {
  exit;
}

define("WTS_PLUGIN_PATH", plugin_dir_path(__FILE__));
define("WTS_PLUGIN_URL", plugin_dir_url(__FILE__));


require_once WTS_PLUGIN_PATH . 'classes/class-main.php';


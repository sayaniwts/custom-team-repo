<?php 
/* Code to add in functions.php: */

function calculate_read_time($content) {
    // Average words per minute (adjust if needed)
    $words_per_minute = 200;

    // Remove HTML tags to get pure text
    $text = strip_tags($content);

    // Count words
    $word_count = str_word_count($text);

    // Calculate read time in minutes
    $read_time = ceil($word_count / $words_per_minute);

    // Return the formatted read time
    return $read_time;
}

// Shortcode to display read time
function post_read_time_shortcode($atts, $content = null) {
    global $post;

    // Calculate read time for current post
    $read_time = calculate_read_time($post->post_content);

    // Output the read time
    return '<p><strong>Estimated Read Time:</strong> ' . $read_time . ' minute(s)</p>';
}

// Register the shortcode
add_shortcode('read_time', 'post_read_time_shortcode');

/*
READ THIS CAREFULLY

How to use:
Add the code above to the functions.php file of your WordPress theme (found in wp-content/themes/your-theme-name/functions.php).
The shortcode [read_time] will now display the estimated read time wherever you place it in your posts or pages.
 */
/*In your WordPress post or page editor, you can now use the shortcode like this: [read_time] */

/*It will automatically calculate and display the estimated read time based on the word count of your post content. The result will appear as something like: Estimated Read Time: 3 minute(s) */

/*This code strips the HTML tags, counts the words, and calculates the read time based on the average reading speed of 200 words per minute. */

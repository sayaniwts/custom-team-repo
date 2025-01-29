
<?php 
/* 
 * Custom permalink structure for WordPress posts
 * This function modifies the default permalink structure for posts to include "/blog/" before the post slug.
 */
function custom_post_permalink($permalink, $post, $leavename) {
    // Check if the post type is 'post' (i.e., it's a regular blog post)
    if ($post->post_type == 'post') {
       // Modify the permalink to include "/blog/" followed by the post slug
       $permalink = home_url('/blog/' . $post->post_name . '/');
    }
    // Return the modified permalink
    return $permalink;
}
// Hook into the 'post_link' filter to apply the custom permalink for posts
add_filter('post_link', 'custom_post_permalink', 10, 3);


/* 
 * Add custom rewrite rule for posts with "/blog/" in the URL
 * This rule tells WordPress how to handle URLs like "/blog/post-slug/"
 */
function custom_post_rewrite_rules($rules) {
    // Define the custom rewrite rule for posts
    $new_rules = array(
        'blog/([^/]+)/?$' => 'index.php?post_type=post&name=$matches[1]', // This matches /blog/slug/ and routes it to a post
    );
    // Merge the custom rules with the existing ones to preserve default rules
    return $new_rules + $rules;
}
// Hook into the 'rewrite_rules_array' filter to add the custom rewrite rules for post URLs
add_filter('rewrite_rules_array', 'custom_post_rewrite_rules');

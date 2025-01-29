
<?php 
/* Custom slug for wordpress post */
function custom_post_permalink($permalink, $post, $leavename) {
    if ($post->post_type == 'post') {
       $permalink = home_url('/blog/' . $post->post_name . '/');
    }
    return $permalink;
}
add_filter('post_link', 'custom_post_permalink', 10, 3);
   
function custom_post_rewrite_rules($rules) {
    $new_rules = array(
        'blog/([^/]+)/?$' => 'index.php?post_type=post&name=$matches[1]',
    );
    return $new_rules + $rules;
}
add_filter('rewrite_rules_array', 'custom_post_rewrite_rules');
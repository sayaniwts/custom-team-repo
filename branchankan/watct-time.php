<?php
// create acf field named 'read_time' for the post type you want to make it work for 
// Blog post estimated read time
// then use the [read_time] shorcode inside your loop to display the post readtime
function update_read_time($post_id) {
    if (get_post_type($post_id) !== 'post') return;
    
    $content = get_post_field('post_content', $post_id);
    $word_count = str_word_count(strip_tags($content));
    $reading_speed = 200;
    $read_time = ceil($word_count / $reading_speed);
 
    update_field('read_time', $read_time, $post_id);
}
add_action('save_post', 'update_read_time');
 
function display_read_time_shortcode() {
    ob_start();
    $pid= get_the_ID();
    //print_r("Pid Is: ".$pid);
    
        //print_r("Entering here");
        $read_time = get_field('read_time', $pid);
        if ($read_time) {
            echo '<p class="read-time">🕒 ' . esc_html($read_time) . ' min read</p>';
        }else{
            echo 'No content';
        }
    
    return ob_get_clean();
}
add_shortcode('read_time', 'display_read_time_shortcode');
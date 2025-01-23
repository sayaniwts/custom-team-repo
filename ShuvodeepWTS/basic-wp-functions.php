<?php
//#### Enable svg files to upload ###//

/* 
  * First you need to add the first command in the wp-config.php file
  * Then you need to add the following PHP code in the functions.php file
*/
  define('ALLOW_UNFILTERED_UPLOADS',true);

  //In function add this code
  function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
    }
  add_filter('upload_mimes', 'cc_mime_types');

//#### END ####//
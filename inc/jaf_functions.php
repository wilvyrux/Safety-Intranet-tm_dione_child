<?php
include_once get_theme_file_path().'/inc/class.company_calendar.php';


function jaf_child_enqueue_scripts() {
  wp_enqueue_style( 'fullcalendar-css', '//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.7.0/fullcalendar.min.css'  );
  wp_enqueue_style( 'jaf-css', get_theme_file_uri().'/css/jaf-custom.css'  );
  // wp_enqueue_style( 'bootstrap-css', '//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'  );
  wp_enqueue_script( 'colorbox-js', '//cdnjs.cloudflare.com/ajax/libs/jquery.colorbox/1.6.4/jquery.colorbox.js', ['jquery'] ); 
  wp_enqueue_script( 'moment-js', '//cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.0/moment.min.js', ['jquery'] ); 
  wp_enqueue_script( 'fullcalendar-js', '//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.7.0/fullcalendar.js', ['jquery', 'moment-js'] );
}
add_action( 'wp_enqueue_scripts', 'jaf_child_enqueue_scripts', 11);
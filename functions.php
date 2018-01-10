<?php
require_once get_theme_file_path().'/inc/jaf_functions.php';


function infinity_child_enqueue_scripts() {
  wp_register_style( 'infinity-child-style', get_stylesheet_directory_uri() . '/style.css'  );
  wp_enqueue_style( 'infinity-child-style' );
}
add_action( 'wp_enqueue_scripts', 'infinity_child_enqueue_scripts', 11);
require_once get_theme_file_path() . '/custom-php/custom-functions.php';
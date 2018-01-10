<?php


function custom_enqueue_script()
{
 
  	 
    /***
	 * Wilvyrux customized SCSS Sheet
	 *========================================================================*/
	wp_enqueue_style(
		'wilvyrux-admin',
		get_theme_file_uri() .
		'/css/admin.min.css',
		array(),
		'all'
	);      
    
}
add_action( 'admin_enqueue_scripts', 'custom_enqueue_script');




function customlogin_enqueue_script()
{
 
  	 
    /***
	 * Wilvyrux customized SCSS Sheet
	 *========================================================================*/
	wp_enqueue_style(
		'wilvyrux-login',
		get_theme_file_uri() .
		'/css/login.min.css',
		array(),
		'all'
	);      
    
}
add_action( 'login_enqueue_scripts', 'customlogin_enqueue_script');



?>
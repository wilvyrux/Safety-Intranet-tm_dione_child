<?php 

function theme_setup_styles_and_scripts()
{
 
  	 
    /***
	 * Wilvyrux customized SCSS Sheet
	 *========================================================================*/
	wp_enqueue_style(
		'wilvyrux-injection',
		get_theme_file_uri() .
		'/css/main-custom-injection.min.css',
		array(),
		'all'
	);   
    
    
    
    wp_enqueue_style(
		'google-3fonts',
		'https://fonts.googleapis.com/css?family=Open+Sans:400,700|Oswald:300,400,500|Roboto:400,400i,500,700',
		array(),
		'all'
	); 
    
    

    
    /***
	 * FONTAWESOME
	 *========================================================================*/
//	wp_enqueue_style(
//		'fontawesome',
//		'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css',
//		array(),
//		'all'
//	);    
    
    
    
    
   
 /***
	 * OWSLIDER
	 *========================================================================*/
// 	wp_enqueue_style(
// 		'owlslider1',
// 		'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.0/assets/owl.carousel.min.css',
// 		array(),
// 		'all'
// 	);    
    
 	wp_enqueue_style(
 		'owlslider-css',
 		'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.0/assets/owl.theme.default.min.css',
 		array(),
 		'all'
 	);      
    
// 	wp_enqueue_script(
// 		'owlslider3',
// 		'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.0/owl.carousel.min.js',
// 		array(),
// 		'all'
// 	);      
  
    

    
    
//    CDN 
//    wp_enqueue_style(
//		'bootstrap1',
//		'//cdn.jsdelivr.net/bootstrap/3.3.6/css/bootstrap.css',
//		array(),
//		'all'
//	);  
//    
//      wp_enqueue_style(
//		'bootstrap2',
//		'//cdn.jsdelivr.net/bootstrap/3.3.6/css/bootstrap-theme.css',
//		array(),
//		'all'
//	);    
    
    
    
    
    wp_enqueue_style(
		'all-styles',
		get_theme_file_uri() .
		'/css/wx-plugin.min.css',
		array(),
		'all'
	);  
    
      wp_enqueue_script(
		'all-scripts',
        get_theme_file_uri() .
		'/js/wx-plugin.min.js',
		array(),
		'all'
	);   
    
    
    
//    gravity_form_enqueue_scripts(1, true);

}
add_action( 'wp_enqueue_scripts', 'theme_setup_styles_and_scripts', 5000 );


?>
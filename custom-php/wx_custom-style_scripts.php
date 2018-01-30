<?php 

function wilvyrux_child_enqueue_scripts()
{
 
  	 
    /***
	 * Wilvyrux customized SCSS Sheet
	 *========================================================================*/
	wp_enqueue_style('wilvyrux-injection',get_theme_file_uri() . '/css/main-custom-injection.min.css',array(),'all');   
    
    
    wp_enqueue_style('google-3fonts','https://fonts.googleapis.com/css?family=Open+Sans:400,700|Oswald:300,400,500|Roboto:400,400i,500,700',	array(),
		'all'
	); 
    
    
 	wp_enqueue_style('owlslider-css','https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.0/assets/owl.theme.default.min.css',array(),'all');      
     
    wp_enqueue_style('all-styles',get_theme_file_uri() . '/css/wx-plugin.min.css',array(),'all');  
    wp_enqueue_script('all-scripts',get_theme_file_uri() . '/js/wx-plugin.min.js',array(),'all');   
    
  	// wp_enqueue_style( 'fullcalendar-css', '//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.7.0/fullcalendar.min.css'  );
  	// wp_enqueue_script( 'colorbox-js', '//cdnjs.cloudflare.com/ajax/libs/jquery.colorbox/1.6.4/jquery.colorbox.js', ['jquery'] ); 
    
//    gravity_form_enqueue_scripts(1, true);

}
add_action( 'wp_enqueue_scripts', 'wilvyrux_child_enqueue_scripts', 5000 );

?>
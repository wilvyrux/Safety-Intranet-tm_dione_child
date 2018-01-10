<?php
include_once get_theme_file_path().'/inc/class.company_calendar.php';
include_once get_theme_file_path().'/inc/class.wp_file_manager.php';
include_once get_theme_file_path().'/inc/class.news.php';


function jaf_child_enqueue_scripts() {
  wp_enqueue_style( 'fullcalendar-css', '//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.7.0/fullcalendar.min.css'  );
  wp_enqueue_style( 'jaf-css', get_theme_file_uri().'/css/jaf-custom.css'  );
  wp_enqueue_style( 'bootstrap-css', '//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'  );
  wp_enqueue_script( 'colorbox-js', '//cdnjs.cloudflare.com/ajax/libs/jquery.colorbox/1.6.4/jquery.colorbox.js', ['jquery'] ); 
  wp_enqueue_script( 'moment-js', '//cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.0/moment.min.js', ['jquery'] ); 
  wp_enqueue_script( 'fullcalendar-js', '//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.7.0/fullcalendar.js', ['jquery', 'moment-js'] );
  wp_enqueue_script('jquery.ui.widget', 'https://cdnjs.cloudflare.com/ajax/libs/blueimp-file-upload/9.19.2/js/vendor/jquery.ui.widget.js', ['jquery']);
  wp_enqueue_script('fileupload', '//cdnjs.cloudflare.com/ajax/libs/blueimp-file-upload/9.19.2/js/jquery.fileupload.js', ['jquery', 'jquery.ui.widget']);
  wp_enqueue_script('ajaxsubmit', '//malsup.github.com/jquery.form.js', ['jquery'], null);

  //owl
  /*wp_enqueue_style( 'owl-carousel', '//cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css' );
  wp_enqueue_style( 'owl-carousel-theme', '//cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.theme.min.css' );
  wp_enqueue_script( 'owl-script', '//cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js' );*/

  //slick
  wp_enqueue_style( 'slick-slider-css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.css', array(), 'all' );  
  wp_enqueue_style( 'slick-slider-css-theme', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick-theme.css', array(), 'all' ); 
  wp_enqueue_script( 'slick-slider-js', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js', array(), 'all' );

  //fancy
  wp_enqueue_style( 'fancy-css', '//cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.css' );
  wp_enqueue_script( 'fancy-js', '//cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.js', ['jquery'] );
}
add_action( 'wp_enqueue_scripts', 'jaf_child_enqueue_scripts', 11);

function search_filter($query) {
  if ( !is_admin() && $query->is_main_query() ) {
    if ($query->is_search) {
      $query->set('post_type', array( 'news' ) );
    }
  }
}
add_action('pre_get_posts','search_filter');
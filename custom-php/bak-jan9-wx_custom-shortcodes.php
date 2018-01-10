<?php

/***************/
// [my_custom_heading_shortcode ]
function heading_shortcode( $atts ) {
    $a = shortcode_atts( array(
        'text_attr' => 'insert heading title',
        'text_attr2' => 'insert subtitle heading',
        'dropdown_attr' => 'primary-heading',
        'dropdown_attr2' => 'align-left',
        'dropdown_attr3' => 'no-subtitle',
        'dropdown_attr4' => 'No-image',
        'image_attr' => 'attach_image',
        'dropdown_alignment_attr' => 'left',
    ), $atts );
    
    $text_value = $a['text_attr'];
    $text_value2 = $a['text_attr2'];
    $dropdown_value = $a['dropdown_attr'];
    $dropdown_value2 = $a['dropdown_attr2'];
    $dropdown_value3 = $a['dropdown_attr3'];
    $dropdown_value4 = $a['dropdown_attr4'];
    $image_id = $a['image_attr'];
    $href = vc_build_link( $a['url_link'] );
    $image = wp_get_attachment_image($image_id, 'full');
    
        $html .= '<div class="wx-heading '. $dropdown_value2 .' '.$dropdown_value3.' '.$dropdown_value4.'">';
        $html .= '<h1 class="'. $dropdown_value .'">'. $text_value .'</h1>';
        $html .= '<p class="heading-subtitle"> '. $text_value2 .' </p>';
        $html .= '<div class="image"> '. $image .' </div>';
        $html .= '</div>';
       
    return $html;
    
    
    
    
}
add_shortcode( 'my_custom_shortcode', 'heading_shortcode' );


add_action( 'vc_before_init', 'my_custom_heading_shortcode_vs' );
function my_custom_heading_shortcode_vs() {
   vc_map( array(
      "name" => __( "WX Headings", "my-dropdown-domain" ),
      "base" => "my_custom_shortcode",
      "class" => "",
      "category" => __( "WX Custom Shortcode", "my-text-domain"),
      "params" => array(
         array(
            "type" => "dropdown",
            "heading" => __( "Heading style", "my-text-domain" ),
            "param_name" => "dropdown_attr",
            "admin_label" => true,
            "description" => __( "Select style for heading.", "my-text-domain" ),
            "value" =>  array(
                    'Primary'    =>  '',
                    'Secondary'    =>  'secondary-heading',
                    'Third'    =>  'third-heading',
                    'Fourth'    =>  'fourth-heading',
                )
         ),
       
         array(
            "type" => "dropdown",
            "heading" => __( "Text align", "my-text-domain" ),
            "param_name" => "dropdown_attr2",
            "admin_label" => true,
            "description" => __( "Select style for heading.", "my-text-domain" ),
            "value" =>  array(
                    'left'    =>  'align-left',
                    'center'    =>  'align-center',
                    'right'    =>  'align-right',
                )
         ),
       
        array(
            "type" => "dropdown",
            "heading" => __( "Insert Subtitle", "my-text-domain" ),
            "param_name" => "dropdown_attr3",
            "admin_label" => true,
            "description" => __( "Insert for subtitle", "my-text-domain" ),
            "value" =>  array(
                    'No Subtitle'    =>  'No-Subtitle',
                    'With Subtitle'    =>  'With-Subtitle',
                )
         ),
       
       
        array(
            "type" => "dropdown",
            "heading" => __( "Select image", "my-text-domain" ),
            "param_name" => "dropdown_attr4",
            "admin_label" => true,
            "description" => __( "insert image bottom", "my-text-domain" ),
            "value" =>  array(
                    'No Image'    =>  'No-image',
                    'With Image'    =>  'With-image',
                )
         ),
       
       
         array(
            "type" => "textfield",
            "heading" => __( "Text Heading", "my-text-domain" ),
            "param_name" => "text_attr",
            "value" => __( "Default param value", "my-text-domain" ),
            "admin_label" => true,
            "description" => __( "Insert the heading word.", "my-text-domain" )
         ),
       
       
          
         array(
            "type" => "attach_image",
            "heading" => __( "Text Heading", "my-text-domain" ),
            "param_name" => "image_attr",
            "value" => __( "Default param value", "my-text-domain" ),
            "admin_label" => true,
            "description" => __( "Insert the heading word.", "my-text-domain" ),
            "dependency"  => array(
                    'element'=> 'dropdown_attr4',
                    'value'=>'With-image'
            ),
         ),
       
       
       
        array(
            "type" => "textfield",
            "heading" => __( "Subtitle Heading", "my-text-domain" ),
            "param_name" => "text_attr2",
            "value" => __( "Default param value 2", "my-text-domain" ),
            "admin_label" => true,
            "description" => __( "Insert the subtitle heading.", "my-text-domain" ),
            "dependency"  => array(
                    'element'=> 'dropdown_attr3',
                    'value'=>'With-Subtitle'
            ),
       
     
       

         ),
       
      )
   ) );
}

/*************/







/***************/

// [my_custom_buttons_shortcode ]
function buttons_shortcode( $atts ) {
    $a = shortcode_atts( array(
        'text_attr' => 'readmore',
        'dropdown_attr' => 'primary-button',
        'dropdown_attr2' => 'align-left',
        'dropdown_alignment_attr' => 'left',
        'url_link' => '',
    ), $atts );
    
    $text_value = $a['text_attr'];
    $dropdown_value = $a['dropdown_attr'];
    $dropdown_value2 = $a['dropdown_attr2'];
    $image_id = $a['image_attr'];
    $href = vc_build_link( $a['url_link'] );
    
        $html .= '<a href="'. $href['url'] .'" class="wx-button '. $dropdown_value2 .' '. $dropdown_value .'">';
        $html .= '<p>'. $text_value .'</p>';
        $html .= '</a>';
       
    return $html;
    
    
    
    
}
add_shortcode( 'my_custom_button_shortcode', 'buttons_shortcode' );


add_action( 'vc_before_init', 'my_custom_buttons_shortcode_vs' );
function my_custom_buttons_shortcode_vs() {
   vc_map( array(
      "name" => __( "WX Buttons", "my-dropdown-domain" ),
      "base" => "my_custom_button_shortcode",
      "class" => "",
      "category" => __( "WX Custom Shortcode", "my-text-domain"),
      "params" => array(
         array(
            "type" => "dropdown",
            "heading" => __( "Button style", "my-text-domain" ),
            "param_name" => "dropdown_attr",
            "admin_label" => true,
            "description" => __( "Select style for heading.", "my-text-domain" ),
            "value" =>  array(
                    'Primary Button'    =>  '',
                    'Secondary Button'    =>  'secondary-button',
                    'Third Button'    =>  'third-button',
                )
         ),
       
         array(
            "type" => "dropdown",
            "heading" => __( "Text align", "my-text-domain" ),
            "param_name" => "dropdown_attr2",
            "admin_label" => true,
            "description" => __( "Select style for heading.", "my-text-domain" ),
            "value" =>  array(
                    'left'    =>  'align-left',
                    'center'    =>  'align-center',
                    'right'    =>  'align-right',
                )
         ),
       
         array(
            "type" => "textfield",
            "heading" => __( "Text Heading", "my-text-domain" ),
            "param_name" => "text_attr",
            "value" => __( "Default param value", "my-text-domain" ),
            "admin_label" => true,
            "description" => __( "Insert the heading word.", "my-text-domain" )
         ),
       
        array(
            "type" => "vc_link",
            "heading" => __( "Text Url", "my-text-domain" ),
            "param_name" => "url_link",
            "description" => __( "page link url page.", "my-text-domain" )
         )
      )
   ) );
}

/*************/





/***************/

// [Text with Image Attached ]
function text_img_shortcode( $atts,$content ) {
    $a = shortcode_atts( array(
        'textarea_html' => 'Insert Name',
        'image_attr' => 'attach_image',
        'text_attr' => 'heading here',
        'url_link' => '',
    ), $atts );
    
    
    $image_id = $a['image_attr'];
    $textarea_html = $a['textarea_html'];
    $title_head = $a['text_attr'];
    $href = vc_build_link( $a['url_link'] );
    $image = wp_get_attachment_image($image_id, 'full');
    
    
        $html .= '<div class="text-image-wrapper">';
        $html .= '<div class="text-image-holder">
                       
                        <div class="col-md-12 text-center">
                        
                            '. $image .'
                        </div>
                        <div class="col-md-12 text-center text-content-description">
                            
                              <h2>'. $title_head .'</h3>
                         
                              <div class="description-content">'. $content .'</div>
                              
                                <a href="'. ($href['url'] ? $href['url'] : '#') .'" class="readmore-btn"> Read more </a>
                           
                        
                        </div>
                      
                  </div>';
    
        $html .= '</div>';
       
    return $html;
    
    
    
    
}
add_shortcode( 'text_image_shortcode', 'text_img_shortcode' );


add_action( 'vc_before_init', 'my_text_image_shortcode' );
function my_text_image_shortcode() {
   vc_map( array(
      "name" => __( "WX Text-Image", "my-dropdown-domain" ),
      "base" => "text_image_shortcode",
      "class" => "",
      "content" => true,
      "category" => __( "WX Custom Shortcode", "my-text-domain"),
      "params" => array(
       
       
        array(
            "type" => "attach_image",
            "heading" => __( "Insert image", "my-text-domain" ),
            "param_name" => "image_attr",
            "value" => __( "Default param value", "my-text-domain" ),
           
            "description" => __( "Description for foo param.", "my-text-domain" )
        ),
       
        array(
            "type" => "textfield",
            "heading" => __( "Text Heading", "my-text-domain" ),
            "param_name" => "text_attr",
            "value" => __( "Default param value", "my-text-domain" ),
            "admin_label" => true,
            "description" => __( "Insert the heading word.", "my-text-domain" )
         ),

        array(
            "type" => "textarea_html",
            "heading" => __( "text content", "my-text-domain" ),
            "param_name" => "content",
            "value" => __( "Default param value", "my-text-domain" ),
            "admin_label" => true,
            "description" => __( "Description for foo param.", "my-text-domain" )
        ),
       
        array(
            "type" => "vc_link",
            "heading" => __( "Text Url", "my-text-domain" ),
            "param_name" => "url_link",
            "description" => __( "page link url page.", "my-text-domain" )
        )
       
       
      )
   ) );
}

/*************/



/***************/
// [my_custom_address_shortcode ]
function details_address_shortcode( $atts ) {
    
    $a = shortcode_atts( array(
        'text_attr' => 'insert address',
        'text_attr2' => 'insert telephone',
        'text_attr3' => 'insert fax',
        'text_attr4' => 'insert email',
    ), $atts );
    
    $text_value = $a['text_attr'];
    $text_value2 = $a['text_attr2'];
    $text_value3 = $a['text_attr3'];
    $text_value4 = $a['text_attr4'];
        
        $html .= '<ul class="wx-details custom-details-display">';
        $html .= '<li><i class="fa fa-map-marker" aria-hidden="true"></i> '. $text_value .'</li>';
        $html .= '<li><i class="fa fa-phone" aria-hidden="true"></i> <a href="tel:'. $text_value2 .'"> '. $text_value2 .' </a> </li>';
        $html .= '<li><i class="fa fa-fax" aria-hidden="true"></i> <a href="tel:'. $text_value3 .'"> '. $text_value3 .' </a></li>';
        $html .= '<li><i class="fa fa-envelope" aria-hidden="true"></i> <a href="mailto:'. $text_value4 .'"> '. $text_value4 .' </a> </li>';
        $html .= '</ul>';
    
       
    return $html;
    
    
    
    
}
add_shortcode( 'my_custom_details_shortcode', 'details_address_shortcode' );


add_action( 'vc_before_init', 'my_custom_details_shortcode_vs' );
function my_custom_details_shortcode_vs() {
   vc_map( array(
      "name" => __( "WX Contact Details", "my-dropdown-domain" ),
      "base" => "my_custom_details_shortcode",
      "class" => "",
      "category" => __( "WX Custom Shortcode", "my-text-domain"),
      "params" => array(
       
         array(
            "type" => "textfield",
            "heading" => __( "Insert Address", "my-text-domain" ),
            "param_name" => "text_attr",
            "value" => __( "insert address", "my-text-domain" ),
            "admin_label" => true,
            "description" => __( "Insert the heading word.", "my-text-domain" )
         ),
       
       
        array(
            "type" => "textfield",
            "heading" => __( "Telephone", "my-text-domain" ),
            "param_name" => "text_attr2",
            "value" => __( "insert telephone number", "my-text-domain" ),
            "admin_label" => true,
            "description" => __( "Insert the subtitle heading.", "my-text-domain" ),
         ),
       
       
        array(
            "type" => "textfield",
            "heading" => __( "Fax", "my-text-domain" ),
            "param_name" => "text_attr3",
            "value" => __( "insert telephone number", "my-text-domain" ),
            "admin_label" => true,
            "description" => __( "Insert the subtitle heading.", "my-text-domain" ),
         ),
       
         array(
            "type" => "textfield",
            "heading" => __( "Email", "my-text-domain" ),
            "param_name" => "text_attr4",
            "value" => __( "insert telephone number", "my-text-domain" ),
            "admin_label" => true,
            "description" => __( "Insert the subtitle heading.", "my-text-domain" ),
         ),
       
      )
   ) );
}

/*************/
// branches shortcode
function render_branches_list() {
  $output = '<div class="branches-list-wrapper">';

  $args = array( 'post_type' => 'forbes_branches', 'post_status' => 'publish', 'posts_per_page' => -1, 'orderby' => 'name', 'order' => 'ASC' );
  $query = new WP_Query( $args );
  if( $query->have_posts() ) {
    $output .= '<ul class="branches-list">';
    while( $query->have_posts() ) {
        $query->the_post();
        $output .= '<li><a href="'.get_the_permalink().'">'.get_the_title().'</a></li>';
    }
    $output .= '</ul>';
    wp_reset_postdata();
  }

  $output .= '</div>';
  return $output;
}
add_shortcode( 'branches-list', 'render_branches_list' );

function render_branches_projects( $atts ) {
  extract( shortcode_atts(  array( 'branch' => 0 ), $atts ) );
  $output = '<div class="branches-projects-wrapper">';
    $output .= '<div class="title-holder">';
      $output .= '<h4>'.get_the_title( $branch ).' Projects</h4>';
    $output .= '</div>';

    $args = array( 
      'post_type' => 'forbes_projects', 
      'post_status' => 'publish', 
      'posts_per_page' => -1,
      'meta_query' => array(
        array(
          'key' => 'branch',
          'value' => $branch,
          'compare' => '='
        )
      )
    );
    $query = new WP_Query( $args );
    if( $query->have_posts() ) {
      while( $query->have_posts() ) {
        $query->the_post();
        $img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
        $output .= '<div class="branch-projects">';
          $output .= '<div class="col-sm-8">';
            $output .= '<div class="img-holder">';
              $output .= '<img src="'.$img[0].'">';
            $output .= '</div>';
          $output .= '</div>';
          $output .= '<div class="col-sm-4">';
            $output .= '<div class="content-holder">';
              $output .= '<h4 class="project-title">'.get_the_title().'</h4>';
              $output .= '<p class="project-content">'.strip_tags( wp_trim_words( get_the_content(), 25 ) ).'</p>';
              $output .= '<a href="'.get_the_permalink().'" class="project-link">Read More</a>';
            $output .= '</div>';
          $output .= '</div>';
        $output .= '</div>';
      }
      wp_reset_postdata();
    }

  $output .= '</div>';
  return $output;
}
add_shortcode( 'branch-projects', 'render_branches_projects' );

?>
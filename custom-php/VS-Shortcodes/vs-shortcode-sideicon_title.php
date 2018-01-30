<?php


function text_img_content_shortcode( $atts ) {
    $a = shortcode_atts( array(
        'textarea_html' => 'Insert Name',
        'dropdown_attr' => 'color-orange',
        'image_attr' => 'attach_image',
        'text_attr' => 'heading here',
        'url_link' => '',
    ), $atts );
    
    
    $image_id = $a['image_attr'];
    $dropdown_value = $a['dropdown_attr'];
    $textarea_html = $a['textarea_html'];
    $title_head = $a['text_attr'];
    $href = vc_build_link( $a['url_link'] );
    $image = wp_get_attachment_image($image_id, 'full');
    
    
        $html .= '<div class="text-image-content-wrapper">';
        $html .= '<div class="text-image-content-holder">
                       
                        <a href="'. ($href['url'] ? $href['url'] : '#').'" class="'. $dropdown_value .'">
                        
                        <div class="col-md-3 text-center">
                            <div class="icon-holder">
                            '. $image .'
                            </div>
                        </div>
                        <div class="col-md-9 text-center text-content-description">
                              <h2>'. $title_head .'</h3>
                        </div>
                        
                        </a>
                      
                  </div>';
    
        $html .= '</div>';
       
    return $html;
    
    
    
    
}
add_shortcode( 'text_image_content_shortcode', 'text_img_content_shortcode' );


add_action( 'vc_before_init', 'text_img_content_shortcode_2' );
function text_img_content_shortcode_2() {
   vc_map( array(
      "name" => __( "WX Side Icon and Title", "my-dropdown-domain" ),
      "base" => "text_image_content_shortcode",
      "class" => "",
      "content" => true,
      "category" => __( "WX Custom Shortcode", "my-text-domain"),
      "params" => array(
       
       
        array(
            "type" => "dropdown",
            "heading" => __( "Select Color Box", "my-text-domain" ),
            "param_name" => "dropdown_attr",
            "admin_label" => true,
            "description" => __( "Select Color", "my-text-domain" ),
            "value" =>  array(
                    'orange'    =>  'color-orange',
                    'blue'    =>  'color-blue',
                    'red'    =>  'color-red',
                    'dark'    =>  'dacolor-dark',
                )
         ),
       
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
            "type" => "vc_link",
            "heading" => __( "Text Url", "my-text-domain" ),
            "param_name" => "url_link",
            "description" => __( "page link url page.", "my-text-domain" )
        )
       
       
      )
   ) );
}


?>
<?php

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

?>
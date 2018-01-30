<?php

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

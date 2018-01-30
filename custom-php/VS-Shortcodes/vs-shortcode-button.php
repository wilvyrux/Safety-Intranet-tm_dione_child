<?php

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
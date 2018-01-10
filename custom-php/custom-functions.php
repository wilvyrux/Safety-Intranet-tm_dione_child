<?php

function get_mata( $post_id, $meta_key )
{
    echo get_post_meta( $post_id, $meta_key, true ); 
}

/*<----// WX Basic Needs //---->*/


//wx cleanup functions extras
require_once get_theme_file_path() . '/custom-php/wx_custom-cleanups.php';

//wx login and admins scripts
require_once get_theme_file_path() . '/custom-php/wx_custom-login_admin.php';

//wx style and jquery scripts
require_once get_theme_file_path() . '/custom-php/wx_custom-style_scripts.php';
/*<----//  //---->*/


/*<----// WX EXTRA Shortcode posts //---->*/
require_once get_theme_file_path() . '/custom-php/wx_custom-shortcodes.php';

/*<----//  //---->*/

require_once get_theme_file_path() . '/custom-php/rty_functions.php';

?>
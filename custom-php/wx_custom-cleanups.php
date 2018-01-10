<?php 

/******************************************************************************/
/*Widget defalut removed */

function unregister_default_widgets() {     
    unregister_widget('WP_Widget_Pages');     
    unregister_widget('WP_Widget_Calendar');     
    unregister_widget('WP_Widget_Archives');     
    unregister_widget('WP_Widget_Links');     
    unregister_widget('WP_Widget_Meta');     
//    unregister_widget('WP_Widget_Search');     
//    unregister_widget('WP_Widget_Text');     
    unregister_widget('WP_Widget_Categories');     
    unregister_widget('WP_Widget_Recent_Posts');     
    unregister_widget('WP_Widget_Recent_Comments');     
    unregister_widget('WP_Widget_RSS');     
    unregister_widget('WP_Widget_Tag_Cloud');     
//    unregister_widget('WP_Nav_Menu_Widget');     
    unregister_widget('Twenty_Eleven_Ephemera_Widget'); }

add_action('widgets_init', 'unregister_default_widgets', 11);

/******************************************************************************/



/******************************************************************************/
/*Clean Email */
add_filter( 'wp_mail_from', 'custom_wp_mail_from' );
function custom_wp_mail_from( $original_email_address ) {
    return get_option('admin_email');
}
add_filter( 'wp_mail_from_name', 'custom_wp_mail_from_name' );
function custom_wp_mail_from_name( $original_email_from ) {
    return get_bloginfo('name');
}

/******************************************************************************/



/******************************************************************************/
/*{{{ Disable default dashboard widgets }}}*/
add_action('admin_menu', 'disable_default_dashboard_widgets');
function disable_default_dashboard_widgets() {
    // Remove_meta_box('dashboard_right_now', 'dashboard', 'core');    // Right Now Widget
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'core'); // Comments Widget
    remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');  // Incoming Links Widget
    remove_meta_box('dashboard_activity', 'dashboard', 'core');  // welcome panel
    remove_meta_box('dashboard_plugins', 'dashboard', 'core');         // Plugins Widget
    Remove_meta_box('dashboard_quick_press', 'dashboard', 'core');  // Quick Press Widget
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');   // Recent Drafts Widget
    remove_meta_box('dashboard_primary', 'dashboard', 'core');         //
    remove_meta_box('dashboard_secondary', 'dashboard', 'core');       //
    // Removing plugin dashboard boxes
    remove_meta_box('yoast_db_widget', 'dashboard', 'normal');         // Yoast's SEO Plugin Widget
}
/******************************************************************************/




?>
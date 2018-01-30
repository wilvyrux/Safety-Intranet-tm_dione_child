<?php

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
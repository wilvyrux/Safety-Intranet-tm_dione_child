<?php

function custom_title( $atts ) {
	$atts = shortcode_atts(
		array(
			'title' => '',
			'icon' => '',
			'style' => 'primary'
		), $atts
	);
	$output = '<div class="widget-title-wrapper '.$atts['style'].'-style">';
		$output .= '<div class="title-holder">';
			$output .= '<h4>'.$atts['title'].'</h4>';
			$output .= '<span class="icon-holder">';
				$output .= '<i class="'.$atts['icon'].'"></i>';
			$output .= '</span>';
		$output .= '</div>';
	$output .= '</div>';
	return $output;
}
add_shortcode( 'custom-title', 'custom_title' );

function ct_integratedWithVC() {
	vc_map( array( 
		'name'				=>	__( 'Custom Title' ),
		'base'				=>	'custom-title',
		'class'				=>	'',
		'category'			=>	__( 'My shortcodes' ),
		'params'			=>	array(
									array(
										'type'			=>	'textfield',
										'class'			=>	'',
										'heading'		=>	__( 'Title' ),
										'param_name'	=>	'title',
									),
									array(
										'type'			=>	'iconpicker',
										'heading'		=>	_x( 'Icon', 'backend', 'vc-elements-pt' ),
										'param_name'	=>	'icon',
										'value'			=>	'fa fa-home',
										'description'	=>	_x( 'Select icon from library.', 'backend', 'vc-elements-pt' ),
										'settings'		=>	array(
																'emptyIcon'		=>	true,
																'iconsPerPage'	=>	100,
															)
									),
									array(
										'type'			=>	'dropdown',
										'heading'		=>	__( 'Style' ),
										'param_name'	=>	'style',
										'value'			=>	array(
																'Primary' => 'primary',
																'Secondary' => 'secondary'
															)
									)	
								)
	) );
}
add_action( 'vc_before_init', 'ct_integratedWithVC' );

function discussion_forum() {
	$args = array( 'post_type' => 'dwqa-question', 'post_status' => 'publish', 'posts_per_page' => 7 );
	$qry = new WP_Query( $args );
	if( $qry->have_posts() ) {
		$output = '<div class="forum-wrapper">';
			$output .= '<table class="forum-content-holder">';
				while( $qry->have_posts() ) {
					$qry->the_post();
					$img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'thumbnail' );
					$avatar = get_avatar( get_the_author_meta( 'ID' ), 45 );
					$terms = get_the_terms( get_the_ID(), 'dwqa-question_category' );
			        if ( !empty( $terms ) ) {
			            foreach ( $terms as $term )
			                $cat = $term->name;
			        }
			        $output .= '<tr>';
						$output .= '<td class="left-content">';
							$output .= '<h4 class="title"><a href="'.get_the_permalink().'" class="forum-link">'.get_the_title().'</a></h4>';
							$output .= '<p class="forum-meta-holder">';
								$output .= '<span class="forum-author">'.get_the_author().' </span>';
								$output .= '<span class="forum-date">'.get_the_date( 'M j, Y' ).'</span>';
								$output .= '<span class="forum-category"> - '.$cat.'</span>';
							$output .= '</p>';
						$output .= '</td>';
						$output .= '<td class="right-content">';	
							$output .= '<div class="img-holder">'.$avatar.'</div>';
						$output .= '</td>';
			        $output .= '</tr>';
				}
				wp_reset_postdata();
			$output .= '</table>';
		$output .= '</div>';
	}
	return $output;
}
add_shortcode( 'discussion-forum', 'discussion_forum' );

function discussion_forum_slider() {
	$args = array( 'post_type' => 'dwqa-question', 'post_status' => 'publish', 'posts_per_page' => -1 );
	$qry = new WP_Query( $args );
	if( $qry->have_posts() ) {
		$output = '<div class="forum-slider-wrapper">';
			$output .= '<div class="forum-slider-content-holder">';
				while( $qry->have_posts() ) {
					$qry->the_post();
					$img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'thumbnail' );
					$avatar = get_avatar( get_the_author_meta( 'ID' ), 45 );
					$terms = get_the_terms( get_the_ID(), 'dwqa-question_category' );
			        if ( !empty( $terms ) ) {
			            foreach ( $terms as $term )
			                $cat = $term->name;
			        }
					$output .= '<div class="left-content">';
						$output .= '<h4 class="title"><a href="'.get_the_permalink().'" class="forum-link">'.get_the_title().'</a></h4>';
						$output .= '<p class="forum-meta-holder">';
							$output .= '<span class="forum-author">'.get_the_author().' </span>';
							$output .= '<span class="forum-date">'.get_the_date( 'M j, Y' ).'</span>';
							$output .= '<span class="forum-category"> - '.$cat.'</span>';
						$output .= '</p>';
					$output .= '</div>';
					$output .= '<div class="right-content">';	
						$output .= '<div class="img-holder">'.$avatar.'</div>';
					$output .= '</div>';
				}
				wp_reset_postdata();
			$output .= '</div>';
		$output .= '</div>';
		$scripts = '<script>
						jQuery(".forum-slider-wrapper .forum-slider-content-holder").slick({
					        slidesToShow: 4,
					        slidesToScroll: 1,
					        dots: false,
					        cssEase: "linear",
					        infiniteLoop: true,
					        autoplay: true,
					        autoplaySpeed: 5000,
					        pager: false,
					        controls: true,
					        vertical: true
					    });
					</script>';
	}
	return $output.$scripts;
}
add_shortcode( 'discussion-forum-slider', 'discussion_forum_slider' );

function documents_list() {
	$terms = get_terms( array(
			'taxonomy' => 'jaf_document_folder',
			'hide_empty' => true,
			'orderby' => 'slug',
			'parent' => 0
		) );
	if( $terms ) {
		$output .= '<div class="document-lists-wrapper">';
			$output .= '<ul class="document-holder">';
			foreach( $terms as $term ) {
				$output .= '<li>';
					$output .= '<span class="icon"><i class="fa fa-folder-open"></i></span> <a href="#" class="document-cat">'.$term->name.'</a>';

					//child taxonomy
					$children = get_terms( 'jaf_document_folder', array( 'parent' => $term->term_id, 'orderby' => 'slug', 'hide_empty' => true ) );
					foreach( $children as $child ) {
						$output .= '<div class="child-document-holder">';
							$output .= '<span class="child-icon"><i class="fa fa-folder-open"></i></span> <a href="#" class="child-document-cat">'.$child->name.'</a>';

							$child_args = array(
											'post_type' => 'jaf_document_cpt',
											'post_status' => 'publish',
											'posts_per_pag' => -1,
											'tax_query' => array(
													array(
														'taxonomy' => 'jaf_document_folder',
														'field' => 'term_id',
														'terms' => $child->term_id
													)
												)
										);
							$child_qry = new WP_Query( $child_args );
							if( $child_qry->have_posts() ) {
								$output .= '<ul class="child-lists-holder">';
								while( $child_qry->have_posts() ) {
									$child_qry->the_post();
									$child_link = get_post_meta( get_the_ID(), 'file_url', true );
									$output .= '<li><a href="'.$link.'" class="child-file-url" download>'.get_the_title().'</a></li>';
								}
								$output .= '</ul>';
							}
						$output .= '</div>';
					}

					$term_children = get_term_children( $term->term_id, 'jaf_document_folder' );
					//if( empty( $term_children ) ) {
						$args = array(
								'post_type' => 'jaf_document_cpt',
								'post_status' => 'publish',
								'posts_per_page' => -1,
								'tax_query' => array(
										array(
												'taxonomy' => 'jaf_document_folder',
												'field' => 'term_id',
												'terms' => $term->term_id,
												'include_children' => false
											)
									),
							);
						$qry = new WP_Query( $args );
						if( $qry->have_posts() ) {
							$output .= '<ul class="lists-holder">';
							while( $qry->have_posts() ) {
								$qry->the_post();
								$link = get_post_meta( get_the_ID(), 'file_url', true );
								$output .= '<li><a href="'.$link.'" class="file-url" download>'.get_the_title().'</a></li>';
							}
							$output .= '</ul>';
						}
					//}
				$output .= '</li>';
			}
			$output .= '</ul>';
		$output .= '</div>';

		$scripts = '<script>
						jQuery(".document-lists-wrapper .document-holder").on("click", ".document-cat", function(e) {
							e.preventDefault();
							jQuery(".document-lists-wrapper .document-holder li").each(function() {
								jQuery(this).removeClass("active");
							});
							jQuery(".document-lists-wrapper .child-document-holder").each(function() {
								jQuery(this).removeClass("active");
							});
							jQuery(this).closest("li").addClass("active");
						});
						jQuery(".document-lists-wrapper .document-holder .child-document-holder").on("click", ".child-document-cat", function(e) {
							e.preventDefault();
							jQuery(".document-lists-wrapper .child-document-holder").each(function() {
								jQuery(this).removeClass("active");
							});
							jQuery(this).closest(".child-document-holder").addClass("active");
						});
					</script>';
	}
	return $output.$scripts;
}
add_shortcode( 'documents-list', 'documents_list' );

function notifications_list() {
	$args = array( 'post_type' => 'forbes_notifications', 'post_status' => 'publish', 'posts_per_page' => -1 );
	$qry = new WP_Query( $args );
	if( $qry->have_posts() ) {
		$output = '<div class="notifications-wrapper">';
			$output .= '<div class="notifications-inner-holder">';
			while( $qry->have_posts() ) {
				$qry->the_post();
				$start = get_post_meta( get_the_ID(), 'start_date', true );
				$end = get_post_meta( get_the_ID(), 'end_date', true );
				$publish = get_the_date( 'dd/mm/yy' );
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'thumbnail' );
				
				if( empty( $image ) ) {
					$img = '<i class="fa fa-envelope"></i>';
				} else {
					$img = '<img src="'.$image[0].'">';
				}
				if( !empty( $start ) && $start <= date( 'dd/mm/yy' ) && !empty( $end ) && $end >= date( 'dd/mm/yy' ) ) {
					$date = true;
				} elseif( empty( $start ) && empty( $end ) ) {
					if( $publish == date( 'dd/mm/yy' ) ) {
						$date = true;
					} else {
						$date = false;
					}
				} else {
					$date = false;
				}

				//if( $date ) {
					$output .= '<div class="notifications-holder">';
						$output .= '<div class="content-holder">';
							$output .= '<h3 class="title">'.get_the_title().'</h3>';
							$output .= '<p class="content">'.get_the_content().'</p>';
						$output .= '</div>';
						$output .= '<div class="img-holder">'.$img.'</div>';
					$output .= '</div>';
				//}
			}
			wp_reset_postdata();
			$output .= '</div>';
		$output .= '</div>';
		$scripts = '<script>
						jQuery(".notifications-wrapper .notifications-inner-holder").slick({
					        slidesToShow: 1,
					        slidesToScroll: 1,
					        dots: false,
					        cssEase: "linear",
					        infiniteLoop: true,
					        autoplay: true,
					        speed: 800,
					        autoplaySpeed: 5000,
					        pager: true,
					        controls: true,
				        	vertical: true
					    });
					</script>';
		return $output.$scripts;
	}
}
add_shortcode( 'notifications-list', 'notifications_list' );
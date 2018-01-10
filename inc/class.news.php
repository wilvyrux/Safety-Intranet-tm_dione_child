<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
if ( ! class_exists( 'SPRWL' ) ) {
	class News {

		function __construct() {
			add_shortcode( 'latest-news', [$this, 'render_news'] );
			add_shortcode( 'news-slider', [$this, 'news_slider'] );
			add_action( 'init', [$this, 'register_posttype'] );
		}

		function register_posttype() {
			$labels = array(
				'name'					=>	'News',
				'singular_name'			=>	'News',
				'menu_name'				=>	'News',
				'name_admin_bar'		=>	'News',
				'add_new'				=>	'Add New',
				'add_new_item'			=>	'Add New News',
				'new_item'				=>	'New News',
				'edit_item'				=>	'Edit News',
				'view_item'				=>	'View News',
				'all_items'				=>	'All News',
				'search_items'			=>	'Search News',
				'parent_item_colon'		=>	'Parent News:',
				'not_found'				=>	'No news found.',
				'not_found_in_trash'	=>	'No news found in Trash.'
			);
			$args = array(
				'public'	=>	true,
				'labels'	=>	$labels,
				'rewrite'	=>	array( 'slug' => 'company-news' ),
				'supports'	=>	array( 'title', 'editor', 'thumbnail' ),
			);
			register_post_type( 'news', $args );
		}

		function get_news( $date_format = null ) {
			$all_news = [];

			$args = array(
				'post_type' => 'news',
				'post_status' => 'publish',
				'posts_per_page' => -1,
			);

			$loop = new WP_Query( $args );
			if( $loop->have_posts() ) {
				while( $loop->have_posts() ) {
					$loop->the_post();
					$img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );

					$data['id'] = get_the_ID();
					$data['title'] = get_the_title();
					$data['content'] = get_the_content();
					$data['date'] = get_the_date( $date_format );
					$data['link'] = get_the_permalink();
					$data['image'] = $img[0];
					$data['short_description'] = get_post_meta( get_the_ID(), 'short_description', true );

					$all_news[] = $data;
				}
				wp_reset_postdata();
			}
			return $all_news;
		}

		function render_news() {
			$all_news = self::get_news( 'M j, Y' );
			
			if( $all_news ) {
				$output = '<div class="news-wrapper">';
				foreach( $all_news as $news ) {
					$output .= '<div class="news-holder">';
						$output .= '<div class="img-holder">';
							$output .= '<img src="'.$news['image'].'">';
						$output .= '</div>';
						$output .= '<div class="content-holder">';
							$output .= '<h4 class="news-title">'.$news['title'].'</h4>';
							$output .= '<span class="news-date">'.$news['date'].'</span>';
							$output .= '<p class="description">'.$news['short_description'].'</p>';
							$output .= '<a href="'.$news['link'].'" class="news-link">Read More</a>';
						$output .= '</div>';
					$output .= '</div>';
				}
				$output .= '</div>';
			}
			return $output;
		}

		function news_slider() {
			$all_news = self::get_news( 'M j, Y' );

			if( $all_news ) {
				/*$output = '<div class="news-slider-navigation">';
					$output .= '<a class="btn-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></a>';
					$output .= '<a class="btn-next"><i class="fa fa-angle-right" aria-hidden="true"></i></a>';
				$output .= '</div>';*/
				$output .= '<div class="news-slider-wrapper">';
				foreach( $all_news as $news ) {
					$output .= '<div class="inner-holder">';
						$output .= '<div class="img-holder" style="background-image: url('.$news['image'].');"></div>';
						$output .= '<div class="content-holder">';
							$output .= '<h4 class="news-title">';
								$output .= '<a href="'.$news['link'].'" class="news-link">'.$news['title'].'</a>';
							$output .= '</h4>';
							$output .= '<p class="description">'.$news['short_description'].'</p>';
						$output .= '</div>';
					$output .= '</div>';
				}
				$output .= '</div>';

				/*$scripts = '<script>
								var owl = jQuery(".news-slider-wrapper");
								owl.owlCarousel({
									items: 2,	
									nav: false,
									dots: false,
									loop: true,
									autoPlay: true,
									autoPlayTimeout: 2000,
									smartSpeed: 1200,
									autoPlayHoverPause: true,
								});
								jQuery(".news-slider-navigation").on("click", ".btn-prev", function() {
									owl.trigger("owl.prev");
								});
								jQuery(".news-slider-navigation").on("click", ".btn-next", function() {
									owl.trigger("owl.next");
								});
							</script>';*/
				$scripts = '<script>
								jQuery(".news-slider-wrapper").slick({
							        slidesToShow: 1,
							        slidesToScroll: 1,
							        dots: false,
							        cssEase: "linear",
							        infiniteLoop: true,
							        autoplay: true,
							        speed: 800,
							        autoplaySpeed: 5000,
							        pager: true,
							        controls: true
							    });
							</script>';
			}
			return $output.$scripts;
		}

	}
}

new News;
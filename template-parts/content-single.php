<?php
/**
 * Template part for displaying single posts.
 *
 * @package Infinity
 */
 $tm_dione_post_hide_author = Kirki::get_option( 'tm-dione', 'post_hide_author' );
 $tm_dione_post_hide_featured_image = get_post_meta( get_the_ID(), "post_hide_featured_image", true );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post blog-entry' ); ?>>

	<?php if ( has_post_format( 'gallery' ) ) { ?>
		<?php $gallery_images = get_post_meta( get_the_ID(), '_format_gallery_images', true ); ?>
		<?php $gallery_type = get_post_meta( get_the_ID(), '_format_gallery_type', true ); ?>
		<?php if ( $gallery_images ) { ?>
			<div class="post-img post-gallery<?php echo ' ' . esc_attr( $gallery_type ); ?>">
				<?php if ( 'masonry' == $gallery_type ) { ?>
					<div class="grid-thumb-sizer"></div><?php } ?>
				<?php foreach ( $gallery_images as $image ) { ?>
					<?php if ( 'masonry' == $gallery_type ) {
						$img = wp_get_attachment_image_src( $image, 'full' );
					} else {
						$img = wp_get_attachment_image_src( $image, 'full' );
					} ?>
					<?php $caption = get_post_field( 'post_excerpt', $image ); ?>
					<?php if ( 'masonry' == $gallery_type ) { ?>
						<a href="<?php echo esc_url( $img[0] ); ?>" class="thumb-masonry-item ndSvgFill">
							<img src="<?php echo esc_url( $img[0] ); ?>" alt="<?php echo '' . $caption; ?>" />
							<svg viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" x="0px" y="0px" width="30px" height="30px">
							<g>
								<rect x="13" y="0" width="4" height="30"></rect>
								<rect x="0" y="13" width="30" height="4"></rect>
							</g>
						</svg>
						</a>
					<?php } else { ?>
						<div><img src="<?php echo esc_url( $img[0] ); ?>" alt="<?php echo '' . $caption; ?>" /></div>
					<?php } ?>
				<?php } // endforeach ?>
			</div>
		<?php } ?>
	<?php } elseif ( has_post_format( 'video' ) ) { ?>
		<div class="post-video">
			<?php $video = get_post_meta( get_the_ID(), '_format_video_embed', true ); ?>
			<?php if ( wp_oembed_get( $video ) ) { ?>
				<?php echo wp_oembed_get( $video ); ?>
			<?php } else { ?>
				<?php echo "" . $video; ?>
			<?php } ?>
		</div>
	<?php } elseif ( has_post_format( 'audio' ) ) { ?>
		<div class="post-audio">
			<?php $audio = get_post_meta( $post->ID, '_format_audio_embed', true ); ?>
			<?php if ( wp_oembed_get( $audio ) ) { ?>
				<?php echo wp_oembed_get( $audio ); ?>
			<?php } else { ?>
				<?php echo "" . $audio; ?>
			<?php } ?>
		</div>
	<?php } elseif ( has_post_format( 'quote' ) ) { ?>
		<?php $source_name = get_post_meta( $post->ID, '_format_quote_source_name', true ); ?>
		<?php $url = get_post_meta( $post->ID, '_format_quote_source_url', true ); ?>
		<?php $quote = get_post_meta( $post->ID, '_format_quote_text', true ); ?>
		<?php if ( $quote ) { ?>
			<div class="post-quote">
				<blockquote>
					<h4><?php echo esc_attr( $quote ); ?></h4>
				</blockquote>
				<div class="source-name">
					<?php if ( $source_name ) { ?>
						-
						<?php if ( $url ) { ?>
							<a href="<?php echo esc_url( $url ); ?>" target="_blank"><?php echo esc_attr( $source_name ); ?></a>
						<?php } else { ?>
							<span><?php echo esc_attr( $source_name ); ?></span>
						<?php } ?>
						 -
					<?php } ?>
				</div>
			</div>
		<?php } ?>
	<?php } else { ?>
		<?php if ( has_post_thumbnail() && $tm_dione_post_hide_featured_image != 'on' ) { ?>
			<div class="post-thumb">
				<a href="<?php echo get_permalink(); ?>"><?php the_post_thumbnail( 'full' ); ?></a>
			</div>
		<?php } ?>
	<?php } ?>

	<div class="blog-entry-meta text-center">
		<span class="date"><?php the_time( 'M d, Y' ) ?></span>
	</div>

	<h3 class="blog-entry-title text-center"><?php the_title() ?></h3>
	<?php the_content(); ?>
	<?php
	wp_link_pages( array(
		'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'tm-dione' ) . '</span>',
		'after'       => '</div>',
		'link_before' => '<span>',
		'link_after'  => '</span>',
		'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'tm-dione' ) . ' </span>%',
		'separator'   => '<span class="screen-reader-text">, </span>',
	) );
	?>
	<div class="blog-entry-footer">
		<div class="row">
			<div class="col-sm-6">
				<div class="tags">
					<?php the_tags( '<h5>tags</h5> ', ', ' ); ?>
				</div>
			</div>
			<div class="col-sm-6 text-sm-right">
				<h5><?php esc_html_e('Share', 'tm-dione') ?></h5>

				<div class="social-menu">
					<span><a target="_blank"
							 href="<?php echo esc_url('http://www.facebook.com/sharer/sharer.php?u=' . urlencode( get_permalink() )) ?>"><i
								class="fa fa-facebook"></i></a></span>
					<span><a target="_blank"
							 href="<?php echo esc_url('http://twitter.com/share?text='.urlencode( get_the_title() . "&url=" . get_permalink() ) ); ?>"><i
								class="fa fa-twitter"></i></a></span>
					<span><a target="_blank"
							 href="<?php echo esc_url('https://plus.google.com/share?url='.urlencode( get_permalink() ) ) ?>"><i
								class="fa fa-google-plus"></i></a></span>
				</div>
			</div>
		</div>
	</div>

<?php if($tm_dione_post_hide_author != 'on' && $tm_dione_post_hide_author != 1): ?>
	<div class="author-info">
		<div class="author-info_avatar">
			<?php echo get_avatar( get_the_author_meta('ID'), 32) ?>
		</div>
		<div class="author-info_desc">
			<div class="author-name">
				<?php echo get_the_author(); ?>
			</div>
			<div class="author-text"><?php the_author_meta( 'description' ); ?> </div>
			<div class="social-menu">
				<span><a target="_blank"
						 href="<?php echo esc_url('http://www.facebook.com/sharer/sharer.php?u=' . urlencode( get_permalink() )) ?>"><i
							class="fa fa-facebook"></i></a></span>
				<span><a target="_blank"
						 href="<?php echo esc_url('http://twitter.com/share?text='.urlencode( get_the_title() . "&url=" . get_permalink() ) ); ?>"><i
							class="fa fa-twitter"></i></a></span>
				<span><a target="_blank"
						 href="<?php echo esc_url('https://plus.google.com/share?url='.urlencode( get_permalink() ) ) ?>"><i
							class="fa fa-google-plus"></i></a></span>
			</div>
		</div>
	</div>
<?php endif; ?>

</article><!-- #post-## -->

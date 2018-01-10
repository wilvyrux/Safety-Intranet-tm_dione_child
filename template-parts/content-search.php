<?php
$tm_dione_list_boxed = Kirki::get_option( 'tm-dione', 'homepage_list_boxed_enable' );
$tm_dione_blog_hide_author = Kirki::get_option( 'tm-dione', 'blog_hide_author' );
$tm_dione_post_hide_featured_image = get_post_meta( get_the_ID(), "post_hide_featured_image", true );

if($tm_dione_list_boxed == 1) {
	$class = 'col-sm-6';
}
else {
	$class = 'col-sm-6 col-md-4';
}

?>
<div class="<?php echo esc_attr( $class ) ?> post blog-entry">

	<?php if ( has_post_format( 'gallery' ) ) { ?>
		<?php $gallery_images = get_post_meta( get_the_ID(), '_format_gallery_images', true ); ?>
		<?php $gallery_type = 'slider';//get_post_meta( get_the_ID(), '_format_gallery_type', true ); ?>
		<?php if ( $gallery_images ) { ?>
			<div class="post-img post-gallery<?php echo ' ' . esc_attr( $gallery_type ); ?>">
				<?php if ( 'masonry' == $gallery_type ) { ?>
					<div class="grid-thumb-sizer"></div><?php } ?>
				<?php foreach ( $gallery_images as $image ) { ?>
					<?php if ( 'masonry' == $gallery_type ) {
						$img = wp_get_attachment_image_src( $image, 'full' );
					} else {
						$img = wp_get_attachment_image_src( $image, 'full' );
					}
					$img = bfi_thumb($img[0], array('width' => '600', 'height' => '400'));
					?>
					<?php $caption = get_post_field( 'post_excerpt', $image ); ?>
					<?php if ( 'masonry' == $gallery_type ) { ?>
						<a href="<?php echo esc_url( $img ); ?>" class="thumb-masonry-item ndSvgFill">
							<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo '' . $caption; ?>" />
							<svg viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" x="0px" y="0px" width="30px" height="30px">
							<g>
								<rect x="13" y="0" width="4" height="30"></rect>
								<rect x="0" y="13" width="30" height="4"></rect>
							</g>
						</svg>
						</a>
					<?php } else { ?>
						<div><img src="<?php echo esc_url( $img ); ?>" alt="<?php echo '' . $caption; ?>" /></div>
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

	<div class="postcontent-grid">
		<span class="date"><?php the_time('M d, Y') ?></span>
		<div class="blog-entry-header">
			<div class="blog-entry-title">
				<?php the_title( sprintf( '<h5><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h5>' ); ?>
			</div>
		</div>
		<div class="blog-entry-content">
			<?php strip_shortcodes(get_the_excerpt()); ?>
			<p><a class="read-more"
			   href="<?php echo get_permalink() ?>"><span><?php echo esc_html__( 'Continue Reading', 'tm-dione' ) ?></span></a></p>
		</div>
		<?php if ($tm_dione_blog_hide_author != 1 ): ?>
			<div class="blog-entry-meta">
	               <span class="author">
	                  <?php echo get_avatar( get_the_author_meta('ID'), 32) ?>
		               <?php echo get_the_author(); ?>
	               </span>
			</div>
		<?php endif; ?>

	</div>
</div>
<!-- /.post -->

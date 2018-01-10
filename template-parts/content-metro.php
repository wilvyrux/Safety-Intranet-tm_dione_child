<?php
$classes = 'col-md-3 col-sm-6';

global $count, $base_image_width;
$count = (isset($count) && !empty($count))?(++$count):1;
$base_image_width = (is_numeric($base_image_width))?$base_image_width : '500';

$img_size = $base_image_width . 'x' . $base_image_width;
$big_img_size = ($base_image_width * 2) . 'x' . ($base_image_width * 2 + 15);
$big_img_size_nd = ($base_image_width * 2) . 'x' . ($base_image_width);

switch ($count) {
	case 4:
	case 8:
		$img_size = $big_img_size_nd;
		$classes .= ' grid-x2';
		break;
	case 3:
	case 5:
		$img_size = $big_img_size;
		$classes .= ' grid-x2';
		break;
}
if($count >= 8) {
	$count = 1;
}
$bfi_img_size = explode('x', $img_size);
$post_thumbnail =  wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');

?>
<div class="<?php echo esc_attr( $classes ) ?> post blog-entry grid-item">
	<?php if ( has_post_thumbnail() ) { ?>
		<div class="post-thumb">
			<img class="img-responsive" src="<?php echo esc_attr( bfi_thumb( $post_thumbnail[0], array( 'width' => $bfi_img_size[0], 'height' => $bfi_img_size[1] ) ) ) ?>" alt="" />
		</div>
	<?php } ?>
	<div class="postcontent-grid">
		<span class="date"><?php the_time('M d, Y') ?> | <?php the_category(', ' ); ?></span>
		<div class="blog-entry-header">
			<div class="blog-entry-title">
				<?php the_title( sprintf( '<h5><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h5>' ); ?>
			</div>
		</div>
		<!-- <div class="blog-entry-meta">
               <span class="author">
                  <?php //echo get_avatar( get_the_author_meta('ID'), 32) ?>
	               <?php
	                  //echo get_the_author();
                  ?>
               </span>
		</div> -->
	</div>
</div>
<!-- /.post -->

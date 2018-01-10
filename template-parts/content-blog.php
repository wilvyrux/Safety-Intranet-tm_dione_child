<?php
/**
 * @package Infinity
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( has_post_thumbnail() ) { ?>
		<div class="post-thumb">
			<div class="dates">
				<span class="month"><?php the_time( 'F' ); ?></span>
				<span class="date"><?php the_time( 'd' ); ?></span>
				<span class="year"><?php the_time( 'Y' ); ?></span>
			</div>
			<?php the_post_thumbnail( 'tm-dione-post-thumb' ); ?>
		</div>
	<?php } ?>
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
	</header>
	<!-- .entry-header -->
	<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<span class="author vcard"><i
					class="fa fa-user"></i> <?php echo esc_html__( 'Posted by ', 'tm-dione' ) . get_the_author(); ?></span>
			<span class="categories-links"><i
					class="fa fa-folder"></i> <?php echo esc_html__( 'In ', 'tm-dione' ) . get_the_category_list( esc_html__( ', ', 'tm-dione' ) ) ?> </span>
			<span class="comments-counts"><i
					class="fa fa-comment"></i><?php comments_number( '0', '1', '%' ); ?> <?php comments_number( 'comment', 'Comment', 'Comments' ); ?></span>
		</div><!-- .entry-meta -->
	<?php endif; ?>

	<div class="entry-content">
		<?php the_excerpt(); ?>
	</div>
	<!-- .entry-content -->
	<div class="entry-footer">
		<div class="row middle">
			<div class="col-sm-6">
				<a class="read-more"
				   href="<?php echo get_permalink() ?>"><span><?php echo esc_html__( 'Continue Reading', 'tm-dione' ) ?></span></a>
			</div>
			<div class="col-sm-6 hidden-xs hidden-sm end">
				<div class="share">
					<span><i class="fa fa-share-alt"></i> <?php echo esc_html__( 'Share: ', 'tm-dione' ); ?></span>
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

</article><!-- #post-## -->

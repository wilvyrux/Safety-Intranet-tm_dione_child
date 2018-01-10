<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Infinity
 */
$tm_dione_layout      = Kirki::get_option( 'tm-dione', 'homepage_layout' );
$tm_dione_list_boxed = Kirki::get_option( 'tm-dione', 'homepage_list_boxed_enable' );
$homepage_header_desc_enable = Kirki::get_option( 'tm-dione', 'homepage_header_desc_enable' );

get_header(); ?>

<div id="header-blog-wrapper" class="header-blog-wrapper">
	<?php get_template_part('template-parts/header_blog'); ?>
</div>

<div class="blog-wrapper container<?php if ( $tm_dione_list_boxed != 1 )
	echo esc_attr( '-fluid' ) ?>">
	<div class="row">
		<?php if ( $tm_dione_layout == 'sidebar-content' ) { ?>
			<?php get_sidebar(); ?>
		<?php } ?>
		<?php if ( $tm_dione_layout == 'sidebar-content' || $tm_dione_layout == 'content-sidebar' ) { ?>
			<?php
			if ( $tm_dione_list_boxed == 1 ) {
				$class         = 'col-lg-9';
				$sidebar_class = 'col-lg-3';
			} else {
				$class         = 'col-md-9 col-lg-10';
				$sidebar_class = 'col-md-3 col-lg-2';
			}
			?>
		<?php } else { ?>
			<?php $class = 'col-md-12'; ?>
		<?php } ?>

		<div id="blog-grid-masonry" class="<?php echo esc_attr( $class ); ?> list-blog-wrapper">
			<main class="content row blog-grid-masonry">
				<?php if ( have_posts() ) : ?>
					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'template-parts/content', 'masonry' );
						?>
					<?php endwhile; ?>
				<?php else : ?>
					<?php get_template_part( 'content', 'none' ); ?>
				<?php endif; ?>
			</main>
			<?php tm_dione_paging_nav(); ?>
		</div>
		<?php if ( $tm_dione_layout == 'content-sidebar' ) { ?>
			<div id="sidebar" class="<?php echo esc_attr( $sidebar_class ) ?>">
				<?php get_sidebar(); ?>
			</div>
		<?php } ?>
	</div>
</div>

<?php get_footer(); ?>

<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Infinity
 */

$tm_dione_page_layout_private = get_post_meta( get_the_ID(), "infinity_page_layout_private", true );
$tm_dione_header_top          = get_post_meta( get_the_ID(), "infinity_header_top", true );
$tm_dione_sticky_menu         = get_post_meta( get_the_ID(), "infinity_sticky_menu", true );
$tm_dione_custom_logo         = get_post_meta( get_the_ID(), "infinity_custom_logo", true );
$tm_dione_heading_image       = get_post_meta( get_the_ID(), "infinity_heading_image", true );

$pages_custom_title     = get_post_meta( get_the_ID(), "infinity_custom_title", true );
$pages_custom_desc      = get_post_meta( get_the_ID(), "infinity_custom_desc", true );
$tm_dione_custom_height = get_post_meta( get_the_ID(), "infinity_custom_height", true );
$title_margin_bottom    = get_post_meta( get_the_ID(), "infinity_title_margin_bottom", true );

$tm_dione_bread_crumb_enable = get_post_meta( get_the_ID(), "infinity_bread_crumb_enable", true );
$tm_dione_disable_comment    = get_post_meta( get_the_ID(), "infinity_disable_comment", true );
$tm_dione_page_title         = get_post_meta( get_the_ID(), "infinity_page_title", true );
$tm_polygon_menu_overlay     = get_post_meta( get_the_ID(), "infinity_menu_overlay", true );
$tm_polygon_onepage_scroll     = get_post_meta( get_the_ID(), "infinity_onepage_scroll", true );
$tm_dione_custom_class       = get_post_meta( get_the_ID(), "infinity_custom_class", true );

global  $main_menu_id,
		$dark_light_logo,
		$header_class,
		$footer_dark_light,
		$hide_main_nav;

$main_menu_id = get_post_meta( get_the_ID(), "infinity_page_main_menu", true );
$sticky_header_enable = get_post_meta( get_the_ID(), "infinity_sticky_header_enable", true );
$header_dark_light = get_post_meta( get_the_ID(), "infinity_header_dark_light", true );
$footer_dark_light = get_post_meta( get_the_ID(), "infinity_footer_dark_light", true );

if('on' == get_post_meta( get_the_ID(), "infinity_hide_main_nav", true )) {
	$hide_main_nav = 1;
}

if(empty($header_dark_light)) {
	$header_dark_light = Kirki::get_option( 'tm-dione', 'header_dark_light' );
}
if(empty($sticky_header_enable)) {
	$sticky_header_enable = Kirki::get_option( 'tm-dione', 'sticky_header_enable' );
}
if($sticky_header_enable == 'on' || $sticky_header_enable == 1) {
	$header_class = ' sticky-header';
}

switch ($header_dark_light) {
	case 'dark':
		$dark_light_logo = 'light';
		break;
	case 'light':
		$dark_light_logo = 'dark';
		break;
}

//$page_breadcrumb = get_post_meta( get_the_ID(), "infinity_breadcrumb", true );
//if ( $page_breadcrumb == 'default' ) {
	$page_breadcrumb = Kirki::get_option( 'tm-dione', 'breadcrumb_enable' );
//}

if ( $tm_dione_page_layout_private != 'default' && class_exists( 'cmb2_bootstrap_205' ) ) {
	$tm_dione_layout = get_post_meta( get_the_ID(), "infinity_page_layout_private", true );
} else {
	$tm_dione_layout = Kirki::get_option( 'tm-dione', 'page_layout' );
}

if ( $tm_dione_heading_image ) {
	$tm_dione_heading_image = get_post_meta( get_the_ID(), "single_banner_image", true );
} else {
	$tm_dione_heading_image = Kirki::get_option( 'tm-dione', 'page_bg_image' );
}
if(!$tm_dione_heading_image) {
	$tm_dione_heading_image = get_the_post_thumbnail_url( get_the_ID(), 'full' );
}

if($tm_dione_page_title == '') {
	$tm_dione_page_title = Kirki::get_option( 'tm-dione', 'page_title' );
}

$tm_dione_heading_image = do_shortcode( $tm_dione_heading_image );
$tm_dione_heading_image = str_replace( 'http://http://', 'http://', $tm_dione_heading_image );
$tm_dione_heading_image = str_replace( 'https://https://', 'https://', $tm_dione_heading_image );

$style = '';
if ( $tm_dione_heading_image ) {
	$style .= 'background-image: url("' . ( $tm_dione_heading_image ) . '");';
}
if ( $tm_dione_custom_height ) {
	$style .= 'height:' . $tm_dione_custom_height . ';';
}
if ( $title_margin_bottom ) {
	$style .= 'margin-bottom:' . $title_margin_bottom . ';';
}
$id_style = uniqid('page-header-style-');
tm_dione_apply_style($style, '#' . $id_style);

/* get the banner */
$banner = get_post_meta( get_the_ID(), 'banner_image', true );
if( $banner ) {
	$bg = wp_get_attachment_image_src( $banner, 'full', false );
	$header_style = 'background-image: url("' . ( $bg[0] ) . '");';
} else {
	$bg = wp_get_attachment_image_src( get_post_thumbnail_id( ), 'full', false );
	$header_style = 'background-image: url("' . ( $bg[0] ) . '");';
}


get_header(); ?>
<?php if ( $tm_dione_page_title != 'none' ) { ?>
	<div id="<?php echo esc_attr($id_style) ?>" class="page-big-title <?php echo esc_attr( $tm_dione_page_title ) ?>" style="<?php echo esc_attr( $header_style ) ?>">
		<div class="container">
			<div class="row middle-xs middle-sm">
			    
			    <?php
			    if( is_active_sidebar( 'banner-image' ) ) {
			    	dynamic_sidebar( 'banner-image' );
			    }
			    ?>
			    
				<?php if ( $tm_dione_page_title == 'default' ): ?>
					<?php
					if ( $pages_custom_title == '' ) {
						the_title( '<h3 class="entry-title media-middle col-md-12" itemprop="headline">', '</h3>' );
					} else {
						echo '<h3 class="entry-title media-middle col-md-12" itemprop="headline">' . do_shortcode( $pages_custom_title ) . '</h3>';
					}
					if ( $pages_custom_desc != '' ) {
						echo "<div class='page-desc'>" . do_shortcode( $pages_custom_desc ) . '</div>';
					}
					?>
					<!-- <?php if ( function_exists( 'tm_bread_crumb' ) && $page_breadcrumb == 1 ) { ?>
						<div class="breadcrumb media-middle col-md-6">
							<?php echo tm_bread_crumb( array( 'home_label' => Kirki::get_option( 'tm-dione', 'breadcrumb_home_text' ) ) ); ?>
						</div>
					<?php } ?> -->
					<?php if ( function_exists( 'bcn_display' ) && $page_breadcrumb == 1 ) { ?>
						<div class="breadcrumb media-middle col-md-6">
							<?php bcn_display(); ?>
						</div>
					<?php } ?>
				<?php elseif ( $tm_dione_page_title == 'center-style' ): ?>
					<div class="col-md-12 media-middle">
						<div class="title-icon">
							<?php echo do_shortcode( '[svg svg_icon="svg01"]' ) ?>
						</div>
						<?php
						if ( $pages_custom_title == '' ) {
							the_title( '<h2 class="entry-title" itemprop="headline">', '</h2>' );
						} else {
							echo '<h1 class="entry-title">' . do_shortcode( $pages_custom_title ) . '</h1>';
						}
						if ( $pages_custom_desc != '' ) {
							echo "<div class='page-desc'>" . do_shortcode( $pages_custom_desc ) . '</div>';
						}
						?>
						<!-- <?php if ( function_exists( 'tm_bread_crumb' ) && $page_breadcrumb == 1 ) { ?>
							<div class="breadcrumb">
								<?php echo tm_bread_crumb( array( 'home_label' => Kirki::get_option( 'tm-dione', 'breadcrumb_home_text' ) ) ); ?>
							</div>
						<?php } ?> -->
						<?php if ( function_exists( 'bcn_display' ) && $page_breadcrumb == 1 ) { ?>
						<div class="breadcrumb media-middle col-md-6">
							<?php bcn_display(); ?>
						</div>
					<?php } ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php } ?>

<div class="container">
	<div class="row">
		<?php if ( $tm_dione_layout == 'left-sidebar' ) { ?>
			<div class="col-md-3">
				<?php get_sidebar(); ?>
			</div>
		<?php } ?>
		<?php if ( $tm_dione_layout == 'left-sidebar' || $tm_dione_layout == 'right-sidebar' ) { ?>
			<?php $class = 'col-lg-9'; ?>
		<?php } else { ?>
			<?php $class = 'col-md-12'; ?>
		<?php } ?>
		<div class="<?php echo esc_attr( $class ); ?>">
			<div class="content">
				<?php while ( have_posts() ) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>">

						<?php if(has_post_thumbnail( )): ?>
							<div class="post-thumbnail">
								<?php the_post_thumbnail( 'full' ); ?>
							</div>
						<?php endif; ?>

						<div class="entry-content">
							<?php the_content(); ?>
							<?php
							wp_link_pages( array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'tm-dione' ),
								'after'  => '</div>',
							) );
							?>

							<nav class="post-navigation row">
								<div class="nav-previous col-xs-6">
									<?php previous_post_link( '<div class="nav-previous">%link</div>', esc_html__('Previous', 'tm-dione') ); ?>
								</div>
								<div class="nav-next col-xs-6 text-right">
									<?php next_post_link( '<div class="nav-next">%link</div>', esc_html__('Next', 'tm-dione') ); ?>
								</div>
							</nav>
							
						</div>
						<!-- .entry-content -->
					</article><!-- #post-## -->
					<?php if ( ( comments_open() || get_comments_number() ) && $tm_dione_disable_comment != 'on' ) : comments_template(); endif; ?>


				<?php endwhile; // end of the loop. ?>
			</div>
		</div>
		<?php if ( $tm_dione_layout == 'right-sidebar' ) { ?>
			<div class="col-md-3">
				<?php get_sidebar(); ?>
			</div>
		<?php } ?>
	</div>
</div>

<?php get_footer(); ?>

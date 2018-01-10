<?php
$footer_layout_quantity_columns = Kirki::get_option( 'tm-dione', 'footer_layout_quantity_columns' );
$footer_layout_custom_width     = Kirki::get_option( 'tm-dione', 'footer_layout_custom_width' );

$footer_wide_boxed = Kirki::get_option( 'tm-dione', 'footer_wide_boxed' );
$footer_dark_light = Kirki::get_option( 'tm-dione', 'footer_dark_light' );

$footer_sticky = (Kirki::get_option( 'tm-dione', 'footer_sticky_enable' ) == 1 )? 'sticky' : '';

$cl_footer_column = 'col-md-12';
switch ( $footer_layout_quantity_columns ) {
	case 2:
		$cl_footer_column = 'col-md-6';
		break;
	case 3:
		$cl_footer_column = 'col-md-4';
		break;
	case 4:
		$cl_footer_column = 'col-md-3';
		break;
}
if ( $footer_layout_custom_width == 1 ) {
	$cl_footer_column .= ' footer-column';
}

if ( $footer_wide_boxed == 'wide' ) {
	$footer_cl = "container-fluid";
} else {
	$footer_cl = "container";
}

$footer_container_cl = $footer_dark_light;
if ( Kirki::get_option( 'tm-dione', 'footer_parallax_enable' ) == 1 ) {
	$footer_container_cl .= ' footer-parallax';
}

?>
<div class="<?php echo esc_attr( $footer_container_cl ) ?>">

	<?php if ( Kirki::get_option( 'tm-dione', 'footer_layout_enable' ) ) { ?>
		<?php if ( is_active_sidebar( 'footer' ) ) { ?>
			<?php tha_footer_before(); ?>
			<footer class="site-footer footer02">
				<?php tha_footer_top(); ?>
				<div class="<?php echo esc_attr( $footer_cl ) ?>">
					<div class="row footer-column-container">
						<div class="col-md-6">
							<?php dynamic_sidebar( 'footer-subscribe-form' ); ?>
						</div>
						<div class="col-md-3 padding-left-135sm">
							<?php dynamic_sidebar( 'footer3' ); ?>
						</div>
						<div class="col-md-3">
							<?php dynamic_sidebar( 'footer4' ); ?>
						</div>
					</div>
				</div>
				<?php tha_footer_bottom(); ?>
			</footer><!-- .site-footer -->
			<?php tha_footer_after(); ?>
		<?php } ?>
	<?php } ?>

	<?php if ( Kirki::get_option( 'tm-dione', 'copyright_enable' ) == 1 ) { ?>
		<div class="copyright <?php echo esc_attr($footer_sticky) ?>">
			<div class="<?php echo esc_attr( $footer_cl ) ?>">
				<div class="row">
					<div class="col-lg-12 col-xs-center copyright_text">
						<?php echo html_entity_decode( Kirki::get_option( 'tm-dione', 'copyright_text' ) ); ?>
					</div>
				</div>
			</div>
		</div><!-- .copyright -->
	<?php } ?>

</div>

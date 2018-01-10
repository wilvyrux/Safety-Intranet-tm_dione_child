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
	$footer_cl = "container-fluid padding-x-200-lg";
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
			<footer class="site-footer">
				<?php tha_footer_top(); ?>
				<div class="<?php echo esc_attr( $footer_cl ) ?>">
					<div class="row footer-column-container">
						<div class="<?php echo esc_attr( $cl_footer_column ) ?>">
							<?php dynamic_sidebar( 'footer' ); ?>
						</div>

						<?php if ( $footer_layout_quantity_columns >= 2 ) { ?>
							<div class="<?php echo esc_attr( $cl_footer_column ) ?> ft-cl-2" column=2>
								<?php dynamic_sidebar( 'footer2' ); ?>
							</div>
						<?php } ?>
						<?php if ( $footer_layout_quantity_columns >= 3 ) { ?>
							<div class="<?php echo esc_attr( $cl_footer_column ) ?> ft-cl-3" column=3>
								<?php dynamic_sidebar( 'footer3' ); ?>
							</div>
						<?php } ?>
						<?php if ( $footer_layout_quantity_columns >= 4 ) { ?>
							<div class="<?php echo esc_attr( $cl_footer_column ) ?> ft-cl-4" column=4>
								<?php dynamic_sidebar( 'footer4' ); ?>
							</div>
						<?php } ?>
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


					<?php if(Kirki::get_option( 'tm-dione', 'copyright_display' ) == 'col-md-6'): ?>
						<div class="<?php echo esc_attr(Kirki::get_option( 'tm-dione', 'copyright_display' )) ?> col-xs-center copyright_text"><?php echo html_entity_decode( Kirki::get_option( 'tm-dione', 'copyright_text' ) ); ?>
						</div>
						<?php if ( Kirki::get_option( 'tm-dione', 'copyright_social_menu_enable' ) == 1 ) { ?>
							<div class="<?php echo esc_attr(Kirki::get_option( 'tm-dione', 'copyright_display' )) ?> col-xs-center text-right">
								<div class="social">
									<?php wp_nav_menu( array(
										'theme_location'  => 'social',
										'container_class' => 'social-menu',
										'fallback_cb'     => false
									) ); ?>
								</div>
							</div>
						<?php } ?>
					<?php else: ?>
						<div class="<?php echo esc_attr(Kirki::get_option( 'tm-dione', 'copyright_display' )) ?> col-xs-center copyright_text">
							<?php echo html_entity_decode( Kirki::get_option( 'tm-dione', 'copyright_text' ) ); ?>
							<?php if ( Kirki::get_option( 'tm-dione', 'copyright_social_menu_enable' ) == 1 ) { ?>
								<div class="social">
									<?php wp_nav_menu( array(
										'theme_location'  => 'social',
										'container_class' => 'social-menu',
										'fallback_cb'     => false
									) ); ?>
								</div>
							<?php } ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div><!-- .copyright -->
	<?php } ?>

</div>

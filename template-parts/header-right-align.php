<?php
$header_wide_boxed = Kirki::get_option( 'tm-dione', 'header_wide_boxed' );
$sidemenu_enable = Kirki::get_option( 'tm-dione', 'sidemenu_enable' );
$header_dark_light = Kirki::get_option( 'tm-dione', 'header_dark_light' );

$sticky_header_enable = Kirki::get_option( 'tm-dione', 'sticky_header_enable' );

global $header_class, $dark_light_logo, $hide_main_nav;

if(empty($hide_main_nav)) {
	$hide_main_nav = Kirki::get_option( 'tm-dione', 'hide_main_nav' );
}
if(empty($dark_light_logo)) {
	switch ($header_dark_light) {
		case 'dark':
			$dark_light_logo = 'light';
			break;
		case 'light':
			$dark_light_logo = 'dark';
			break;
	}
}

if ( $header_wide_boxed == 'boxed' ) {
	$header_container_cl = 'container header-container';
} else {
	$header_container_cl = 'container-fluid padding-x-70-lg header-container';
}
?>
<?php tha_header_before(); ?>
	<!-- *********************** HEADER ************************ -->
	<header class="header right-align-header <?php echo esc_attr( $header_class ) ?> <?php echo esc_attr( $header_dark_light ) ?>">
		<div class="<?php echo esc_attr( $header_container_cl ) ?>">
			<div class="row row-xs-center header-row">
				<div class="col-xs-4 hidden-md-up">
					<div class="pull-left mobile-menu-container">
						<div id="open-left" class="mobile-menu-btn">
							<svg id="menu-bar" class="menu-bar" viewBox="0 0 24 13" version="1.1"
							     xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve"
							     x="0px" y="0px" width="24px" height="13px"
								>
								<g id="menu-bar-rect" class="menu-bar-rect">
									<rect x="0" y="0.5" width="24" height="2" />
									<rect x="0" y="5.5" width="24" height="2" />
									<rect x="0" y="10.5" width="24" height="2" />
								</g>
							</svg>
						</div>
					</div>
				</div>
				<!-- /.mobile-menu-btn -->
				<div class="col-xs-4 col-md-2 text-xs-center text-md-left logo">
					<?php
					$logo = tm_get_logo();
					if ( $logo ) { ?>
						<a id="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
							<img
								src="<?php echo esc_url( $logo ); ?>" alt="<?php bloginfo( 'name' ); ?>" data-sticky="<?php echo esc_url( tm_get_logo('sticky') ) ?>" data-origin="<?php echo esc_url( $logo ); ?>" />
						</a>
					<?php } else { ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"
						   rel="home"><?php bloginfo( 'name' ); ?></a>
					<?php } ?>
				</div>

				<div class="col-xs-4 col-md-10 text-right">
					<?php if($hide_main_nav != 1): ?>
						<!-- PRIMARY-MENU -->
						<nav id="site-navigation" class="main-navigation hidden-sm-down">
							<?php
							$args_menu = array(
								'theme_location'  => 'primary',
								'container_class' => 'primary-menu okayNav menu',
							);
							if ( class_exists( 'TM_Walker_Nav_Menu' )) {
								$args_menu['menu_class'] = 'clearfix TMWalkerMenu';
								$args_menu['walker'] = new TM_Walker_Nav_Menu;
							}

							global $main_menu_id;
							if(!empty($main_menu_id)) {
								$args_menu['menu_id'] = $args_menu['menu'] = $main_menu_id;
							}
							wp_nav_menu( $args_menu );
							?>
						</nav>
						<!-- #site-navigation -->
					<?php endif; ?>

					<div class="dropdown mini-cart">
						<?php if ( class_exists( 'WooCommerce' ) && Kirki::get_option( 'tm-dione', 'minicart_enable' ) == 1 ) {  ?>
							<div class="search-cart pull-right">
								<div class="mini-cart-container">
									<?php echo tm_dione_minicart(); ?>
									<div class="widget_shopping_cart_content"></div>
								</div>
							</div>
						<?php } ?>
					</div>
					<!-- /.mini-cart -->

					<?php if ( Kirki::get_option( 'tm-dione', 'search_enable' ) == 1 ) { ?>
						<div class="search-icon">
							<a href="#search" class="show-amazing-search"><i class="pe-7s-search"></i></a>
						</div>
					<?php } ?>
					<!-- /.search-icon -->


					<?php if($sidemenu_enable == 1): ?>
						<div class="extend-menu mobile-menu-container hidden-sm-down">
							<div id="open-right" class="mobile-menu-btn">
								<svg class="menu-bar" viewBox="0 0 24 13" version="1.1"
								     xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve"
								     x="0px" y="0px" width="24px" height="13px"
									>
									<g id="right-menu-bar-rect" class="menu-bar-rect">
										<rect x="0" y="0.5" width="24" height="2" />
										<rect x="0" y="5.5" width="24" height="2" />
										<rect x="0" y="10.5" width="24" height="2" />
									</g>
								</svg>
							</div>
						</div>
					<?php endif; ?>

				</div>
			</div>
		</div>
	</header>
	<!-- // HEADER -->
<?php tha_header_after(); ?>

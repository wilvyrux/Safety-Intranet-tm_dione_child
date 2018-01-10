<?php
$hide_main_nav = Kirki::get_option( 'tm-dione', 'hide_main_nav' );
$header_style = Kirki::get_option( 'tm-dione', 'header_dark_light' );
$sidemenu_enable = Kirki::get_option( 'tm-dione', 'sidemenu_enable' );
$header_dark_light = Kirki::get_option( 'tm-dione', 'header_dark_light' );

global $dark_light_logo;
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
?>
<?php tha_header_before(); ?>
	<!-- *********************** HEADER ************************ -->
		<header class="">
			<div class="header <?php echo esc_attr($header_style) ?> header-left-side hidden-sm-down">
				<?php
					$logo = tm_get_logo();
					if ( $logo ) { ?>
						<a id="logo" class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
							<img
								src="<?php echo esc_url( $logo ); ?>" alt="<?php bloginfo( 'name' ); ?>"/>
						</a>
					<?php } else { ?>
						<a id="logo" class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>"
							rel="home"><?php bloginfo( 'name' ); ?></a>
					<?php } ?>

					<?php if($hide_main_nav != 1): ?>
						<!-- PRIMARY-MENU -->
						<nav id="site-navigation-left" class="main-navigation-left">

							<?php if ( class_exists( 'TM_Walker_Nav_Menu' ) && has_nav_menu( 'primary' ) ) {
								wp_nav_menu( array(
									'theme_location'  => 'primary',
									'menu_id'         => 'primary-menu',
									'container_class' => 'primary-menu okayNav menu',
									'menu_class'      => 'clearfix',
									'walker'          => new TM_Walker_Nav_Menu
								) );
							} else {
								wp_nav_menu( array(
									'theme_location'  => 'primary',
									'menu_id'         => 'primary-menu',
									'container_class' => 'primary-menu okayNav',
								) );
							} ?>
						</nav>
						<!-- #site-navigation -->
					<?php endif; ?>

					<div class="header-bottom">
						<div class="social">
							<?php wp_nav_menu( array(
								'theme_location'  => 'social',
								'menu_id'         => 'social-menu',
								'container_class' => 'social-menu',
								'fallback_cb'     => false
							) ); ?>
						</div>
						<div class="copyright-text"><?php echo html_entity_decode( Kirki::get_option( 'tm-dione', 'copyright_text' ) ); ?></div>
					</div>
			</div>
			<!-- End left Header -->

			<!-- Mobile header -->
			<div class="mobile-header container-fluid hidden-md-up header-container">
				<div class="row row-xs-center">
					<div class="col-xs-4 hidden-md-up">
						<div class="pull-left mobile-menu-container">
							<div id="open-left" class="mobile-menu-btn">
								<svg id="menu-bar" class="menu-bar" viewBox="0 0 24 13" version="1.1"
								     xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve"
								     x="0px" y="0px" width="24px" height="13px"
									>
									<g id="menu-bar-rect" class="menu-bar-rect">
										<g>
											<rect x="0" y="0.5" width="24" height="2" />
											<rect x="0" y="5.5" width="24" height="2" />
											<rect x="0" y="10.5" width="24" height="2" />
										</g>
									</g>
								</svg>
							</div>
						</div>
					</div>
					<!-- /.mobile-menu-btn -->
					<div class="col-xs-4 col-md-2 text-xs-center text-md-left logo">
						<?php
						if(Kirki::get_option('tm-dione', 'centered_logo_enable') != 1) {
							$logo = Kirki::get_option( 'tm-dione', 'logo_normal' );
							if ( $logo ) { ?>
								<a id="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
									<img
										src="<?php echo esc_url( $logo ); ?>" alt="<?php bloginfo( 'name' ); ?>"/>
								</a>
							<?php } else { ?>
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>"
								   rel="home"><?php bloginfo( 'name' ); ?></a>
							<?php } ?>
						<?php } ?>
					</div>

					<div class="col-sm-8 text-center hidden-sm-down">
						<nav id="site-navigation" class="main-navigation"></nav>
					</div>

					<div class="col-xs-4 col-md-2">

						<?php if($sidemenu_enable == 1): ?>
							<div class="pull-right mobile-menu-container hidden-sm-down">
								<div id="open-right" class="mobile-menu-btn">
									<svg class="menu-bar" viewBox="0 0 24 13" version="1.1"
									     xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve"
									     x="0px" y="0px" width="24px" height="13px"
										>
										<g class="menu-bar-rect">
											<g>
												<rect x="0" y="0.5" width="24" height="2" />
												<rect x="0" y="5.5" width="24" height="2" />
												<rect x="0" y="10.5" width="24" height="2" />
											</g>
										</g>
									</svg>
								</div>
							</div>
						<?php endif; ?>

						<?php if ( Kirki::get_option( 'tm-dione', 'search_enable' ) == 1 ) { ?>
							<div class="search-icon pull-right">
								<a href="#search" class="show-amazing-search"><i class="pe-7s-search"></i></a>
							</div>
						<?php } ?>
						<!-- /.search-icon -->

						<div class="dropdown mini-cart pull-right">
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

					</div>
				</div>
			</div>
			<!-- End main header for mobile -->
		</header>
	<!-- // HEADER -->
<?php tha_header_after(); ?>

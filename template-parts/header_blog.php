<?php if ( Kirki::get_option( 'tm-dione', 'homepage_header_content_enable' ) == 1 ) : ?>
	<div class="blog-big-title container<?php if ( Kirki::get_option( 'tm-dione', 'homepage_list_boxed_enable' ) != 1 )
		echo esc_attr( '-fluid' ) ?>">
		<div class="row row-xs-center">
			<div class="col-md-6 col-xs-12 col-md-offset-3 text-center">
				<?php if ( Kirki::get_option( 'tm-dione', 'homepage_header_icon_enable' ) == 1 ) : ?>
					<div class="svg ndSvgFill">
						<svg viewBox="0 0 34 14" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" x="0px" y="0px" width="34px" height="14px">
	                        <rect x="-0.283" y="0" width="34" height="1.8263"></rect>
								<rect x="5.3838" y="6" width="22.6667" height="1.8261"></rect>
								<rect x="11.0503" y="12" width="11.3334" height="1.8261"></rect>
	                    </svg>
					</div>
				<?php endif; ?>
				<h2 class="blog-header-title"><?php echo esc_html( Kirki::get_option( 'tm-dione', 'homepage_header_content_title' ), 'tm-dione' ) ?></h2>
				<?php if(Kirki::get_option( 'tm-dione', 'homepage_header_desc_enable' ) == 1): ?>
					<p class="blog-header-desc"><?php echo esc_html( Kirki::get_option( 'tm-dione', 'homepage_header_content_txt' ), 'tm-dione' ) ?></p>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php
$portfolio_website       = get_post_meta( get_the_ID(), "portfolio_website", true );
$portfolio_client        = get_post_meta( get_the_ID(), "portfolio_client", true );
$portfolio_gallery_image = get_post_meta( get_the_ID(), "portfolio_gallery_image", true );

$portfolio_visit_button_enable = Kirki::get_option( 'tm-dione', 'portfolio_visit_button_enable' );
$portfolio_client_enable = Kirki::get_option( 'tm-dione', 'portfolio_client_enable' );
$portfolio_share_enable = Kirki::get_option( 'tm-dione', 'portfolio_share_enable' );
?>

<div class="container">
	<div class="row padding-top-100 padding-bottom-70">
		<div class="col-md-8">
			<?php if(isset($portfolio_gallery_image) && !empty($portfolio_gallery_image)): ?>
			<div class="container">
				<div class="row">
					<div class="col-md-12 padding-x-0">
						<?php if(count($portfolio_gallery_image) > 0): ?>
							<div class="folio-gallery clearfix">
								<?php
									$key = key($portfolio_gallery_image);
									$image = $portfolio_gallery_image[$key];
									unset($portfolio_gallery_image[$key]);
								 ?>
								<a class="folio-item flui ndSvgFill" href="<?php echo esc_url($image) ?>">
									<img src="<?php echo esc_attr($image) ?>" alt="portfolio">
									<svg viewBox="0 0 30 30"  version="1.1"
										 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
										 xml:space="preserve"
										 x="0px" y="0px" width="30px" height="30px">
										<g>
											<rect x="13" y="0" width="4" height="30"/>
											<rect x="0" y="13" width="30" height="4"/>
										</g>
									</svg>
								</a>
							</div>
						<?php endif; ?>
						<div class="folio-gallery grid-masonry clearfix">
							<?php
							foreach ( $portfolio_gallery_image as $key => $image ):
							?>
									<a class="folio-item col-3 ndSvgFill grid-item" href="<?php echo esc_url($image) ?>">
										<img src="<?php echo esc_attr($image) ?>" alt="portfolio">
										<svg viewBox="0 0 30 30" version="1.1"
											 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
											 xml:space="preserve"
											 x="0px" y="0px" width="30px" height="30px">
										<g>
											<rect x="13" y="0" width="4" height="30"/>
											<rect x="0" y="13" width="30" height="4"/>
										</g>
									</svg>
									</a>

									<?php
							endforeach;
							?>

						</div>

					</div>
				</div>
			</div>
			<?php endif; ?>
		</div>
		<div class="col-md-4">
			<div class="col-sm-12">
				<h5 class="desc-title"><?php esc_html_e( 'About the project', 'tm-dione' ) ?></h5>

				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			</div>
			<div class="col-sm-12">
				<div class="portfolio-metadata">
					<div>
						<h6><?php esc_html_e( 'Date', 'tm-dione' ) ?></h6>
						<span class="metadata"><?php echo get_the_date( get_option( 'date_format' ) ); ?></span>
					</div>
					<?php if($portfolio_client_enable == 1): ?>
					<div>
						<h6><?php esc_html_e( 'Client', 'tm-dione' ) ?></h6>
						<span class="metadata"><?php echo esc_html( $portfolio_client ) ?></span>
					</div>
					<?php endif; ?>
					<div>
						<h6><?php esc_html_e( 'Category', 'tm-dione' ) ?></h6>
						<span class="metadata">
							<?php the_terms( get_the_ID(), 'portfolio_category', '', ', ' ); ?>
						</span>
					</div>
					<?php if($portfolio_share_enable == 1): ?>
						<div>
							<h6><?php esc_html_e( 'Share', 'tm-dione' ) ?></h6>

							<div class="metadata">
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
					<?php endif; ?>
					<?php if($portfolio_visit_button_enable == 1): ?>
						<div class="btn-visit-site">
							<a class="btn btn-border-black"
							   href="<?php echo esc_url( $portfolio_website ) ?>"><?php esc_html_e( 'Visit Website', 'tm-dione' ) ?></a>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>

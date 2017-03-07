<?php $active_class = 'active'; ?>
<section id="search_container">
			<div id="search">
				<ul class="nav nav-tabs">
					<?php if ( ct_is_tour_enabled() ) : ?>
					<li class="<?php echo esc_attr( $active_class ) ?>"><a href="#tours" data-toggle="tab"><?php esc_html_e( 'Tours', 'citytours' ) ?></a></li>
					<?php $active_class=''; endif; ?>
					<?php if ( ct_is_hotel_enabled() ) : ?>
					<li><a href="#hotels" data-toggle="tab"><?php esc_html_e( 'Hotels', 'citytours' ) ?></a></li>
					<?php $active_class=''; endif; ?>
				</ul>

				<?php $active_class = 'active'; ?>
				<div class="tab-content">
					<?php if ( ct_is_tour_enabled() ) : ?>
					<div class="tab-pane <?php echo esc_attr( $active_class ) ?>" id="tours">					
						<form role="search" method="get" id="search-tour-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<input type="hidden" name="post_type" value="tour">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">									
									<input type="text" class="form-control" id="search_tours" name="s" placeholder="<?php esc_html_e( 'e.g. Kathmandu', 'citytours' ) ?>">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">									
									<?php
									$all_tour_types = get_terms( 'tour_type', array('hide_empty' => 0) );
									if ( ! empty( $all_tour_types ) ) : ?>
										<select class="form-control" name="tour_types">
											<option value="" selected><?php esc_html_e( 'All themes', 'citytours' ) ?></option>
											<?php foreach ( $all_tour_types as $each_tour_type ) {
												$term_id = $each_tour_type->term_id;
												$icon_class = get_tax_meta( $term_id, 'ct_tax_icon_class' );
											?>
											<option value="<?php echo esc_attr( $term_id ) ?>"><?php echo esc_html( $each_tour_type->name ) ?></option>
											<?php } ?>
										</select>
									<?php endif; ?>
								</div>
							</div>
						</div><!-- End row -->						
						<button class="btn_1 green"><i class="icon-search"></i><?php esc_html_e( 'Search now', 'citytours' ) ?></button>
						</form>
					</div><!-- End rab -->
					<?php $active_class=''; endif; ?>
					<?php if ( ct_is_hotel_enabled() ) : ?>
					<div class="tab-pane <?php echo esc_attr( $active_class ) ?>" id="hotels">					
						<form role="search" method="get" id="search-hotel-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<input type="hidden" name="post_type" value="hotel">						
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">									
									<input type="text" class="form-control" id="hotel_name" name="s" placeholder="<?php esc_attr_e( 'Hotel name', 'citytours' ) ?>">
								</div>
							</div>

							<?php 
							$all_locations = get_terms( 'hotel_location', array('hide_empty' => 0) );
							if ( ! empty( $all_locations ) ) : ?>
								<div class="col-md-6">
									<div class="form-group">									
										<select class="form-control" name="locations">
											<option value="" selected><?php esc_html_e( 'All locations', 'citytours' ) ?></option>
											<?php foreach ( $all_locations as $location ) {
												$term_id = $location->term_id; ?>
												<option value="<?php echo esc_attr( $term_id ) ?>"><?php echo esc_html( $location->name ) ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							<?php endif;?>
						</div> <!-- End row -->						
						<button class="btn_1 green"><i class="icon-search"></i><?php esc_html_e( 'Search now', 'citytours' ); ?></button>
						</form>
					</div>
					<?php $active_class=''; endif; ?>
				</div>
			</div>
		</section><!-- End hero -->
<script type="text/javascript">
	function openSearchForm(){
		$('#header_search_form').toggle();		
	}
	/*$ = jQuery.noConflict();
	$(document).ready(function(){
		$('input.date-pick').datepicker({
			startDate: "today"
		});
		$('input[name="date_from"]').datepicker( 'setDate', 'today' );
		$('input[name="date_to"]').datepicker( 'setDate', '+1d' );
		});*/
</script>
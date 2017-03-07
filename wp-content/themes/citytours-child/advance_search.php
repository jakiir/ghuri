<?php 
$active_class = 'active'; 
$get_template_directory_ver = esc_url( get_template_directory_uri() );
$get_stylesheet_ver = esc_url( get_stylesheet_directory_uri() );
?>
<section id="search_container">
			<div id="search">
				<ul class="nav nav-tabs">
					<?php if ( ct_is_tour_enabled() ) : ?>
					<li class="<?php echo esc_attr( $active_class ) ?>"><a href="#tours" data-toggle="tab"><?php esc_html_e( 'Tours', 'citytours' ) ?></a></li>
					<?php $active_class=''; endif; ?>
					<?php if ( ct_is_hotel_enabled() ) : ?>
					<li><a href="#hotels" data-toggle="tab"><?php esc_html_e( 'Hotels', 'citytours' ) ?></a></li>
					<?php $active_class=''; endif; ?>
					<!--<li><a href="#cars" data-toggle="tab"><?php //esc_html_e( 'Cars', 'citytours' ) ?></a></li>-->
				</ul>

				<?php $active_class = 'active'; ?>
				<div class="tab-content">
					<?php if ( ct_is_tour_enabled() ) : ?>
					<div class="tab-pane <?php echo esc_attr( $active_class ) ?>" id="tours">
					<!--<h3><?php //esc_html_e( 'Search Tours', 'citytours' ) ?></h3>-->
						<form role="search" method="get" id="search-tour-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<input type="hidden" name="post_type" value="tour">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label><?php esc_html_e( 'Destination', 'citytours' ) ?></label>
									<input type="text" class="form-control" id="search_tours" name="s" placeholder="<?php esc_html_e( 'Type your search terms', 'citytours' ) ?>">
									<input type="hidden" class="tour_locations" name="locations" value="" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label><?php esc_html_e( 'Themes', 'citytours' ) ?></label>
									<?php
									$all_tour_types = get_terms( 'tour_type', array('hide_empty' => 0) );
									if ( ! empty( $all_tour_types ) ) : ?>
										<select class="form-control" name="tour_types">
											<option value="" selected><?php esc_html_e( 'All tours', 'citytours' ) ?></option>
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
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label><i class="icon-calendar-7"></i> <?php esc_html_e( 'Date', 'citytours' ) ?></label>
									<input class="date-pick form-control tour-startDate" data-date-format="<?php echo ct_get_date_format('html'); ?>" type="text" name="date">
								</div>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-6 col-md-offset-3">
								<div class="form-group">
									<label><?php esc_html_e( 'Adults', 'citytours' ) ?></label>
									<div class="numbers-row">
										<input type="text" value="1" class="qty2 form-control" name="adults">
									</div>
								</div>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-6">
								<div class="form-group">
									<label><?php esc_html_e( 'Children', 'citytours' ) ?></label>
									<div class="numbers-row">
										<input type="text" value="0" class="qty2 form-control" name="kids">
									</div>
								</div>
							</div>
							
						</div><!-- End row -->
						<hr>
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
									<label><?php esc_html_e( 'Destination/Hotel Name', 'citytours' ) ?></label>
									<input type="text" class="form-control" id="hotel_name" name="s" placeholder="<?php esc_attr_e( 'Ex. Sylhet', 'citytours' ) ?>">
									<input type="hidden" class="hotel_locations" name="locations" value="" />
								</div>
							</div>

							<?php 
							/*$all_hotel_locations = get_terms( 'hotel_location', array('hide_empty' => 0) );
							if ( ! empty( $all_hotel_locations ) ) : ?>
								<div class="col-md-6">
									<div class="form-group">
									<label><?php esc_html_e( 'Preferred city area', 'citytours' ) ?></label>
										<select class="form-control" name="hotel_locations">
											<option value="" selected><?php esc_html_e( 'All', 'citytours' ) ?></option>
											<?php foreach ( $all_hotel_locations as $hotel_location ) {
												$term_id = $hotel_location->term_id; ?>
												<option value="<?php echo esc_attr( $term_id ) ?>"><?php echo esc_html( $hotel_location->name ) ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							<?php endif; */ ?>
						</div> <!-- End row -->
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label><i class="icon-calendar-7"></i> <?php esc_html_e( 'Check in', 'citytours' ) ?></label>
									<input class="date-pick form-control" data-date-format="<?php echo ct_get_date_format('html'); ?>" type="text" name="date_from">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label><i class="icon-calendar-7"></i> <?php esc_html_e( 'Check out', 'citytours' ) ?></label>
									<input class="date-pick form-control" data-date-format="<?php echo ct_get_date_format('html'); ?>" type="text" name="date_to">
								</div>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-5">
								<div class="form-group">
									<label><?php esc_html_e( 'Adults', 'citytours' ) ?></label>
									<div class="numbers-row">
										<input type="text" value="1" class="qty2 form-control" name="adults">
									</div>
								</div>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-5">
								<div class="form-group">
									<label><?php esc_html_e( 'Children', 'citytours' ) ?></label>
									<div class="numbers-row">
										<input type="text" value="0" class="qty2 form-control" name="kids">
									</div>
								</div>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-12">
								<div class="form-group">
									<label><?php esc_html_e( 'Rooms', 'citytours' ) ?></label>
									<div class="numbers-row">
										<input type="text" value="1" id="rooms" class="qty2 form-control" name="rooms">
									</div>
								</div>
							</div>
						</div><!-- End row -->						
						<hr>
						<button class="btn_1 green"><i class="icon-search"></i><?php esc_html_e( 'Search now', 'citytours' ); ?></button>
						</form>
					</div>
					<?php $active_class=''; endif; ?>
					
					<div class="tab-pane <?php echo esc_attr( $active_class ) ?>" id="cars">					
						<form name="cars-form" action="#" method="GET" target="_parent">
						
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="pick_up_location"><i class="icon-truck-1"></i> Pick-up location</label>
										<input type="text" placeholder="Enter a city or address" id="pick_up_location" tabindex="1" class="form-control" role="textbox">										
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
									</div>
								</div>								
							</div>
														
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="pickup_datePicker"><i class="icon-calendar"></i> Pick-up date</label>
										<input type="text" name="date_from" data-date-format="dd/mm/yyyy" id="pickup_datePicker" placeholder="dd/mm/yyyy" tabindex="6" class="date-pick form-control">										
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="pick_up_hour"><i class="icon-clock-4"></i> Pick-up hour</label>
										<select id="pick_up_hour" class="hour fl form-control" tabindex="8">
												<option value="00">00</option>		
												<option value="01">01</option>		
												<option value="02">02</option>		
												<option value="03">03</option>		
												<option value="04">04</option>		
												<option value="05">05</option>		
												<option value="06">06</option>		
												<option value="07">07</option>		
												<option value="08">08</option>		
												<option value="09">09</option>		
												<option value="10" selected="">10</option>		
												<option value="11">11</option>		
												<option value="12">12</option>		
												<option value="13">13</option>		
												<option value="14">14</option>		
												<option value="15">15</option>		
												<option value="16">16</option>		
												<option value="17">17</option>		
												<option value="18">18</option>		
												<option value="19">19</option>		
												<option value="20">20</option>		
												<option value="21">21</option>		
												<option value="22">22</option>		
												<option value="23">23</option>		
											</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="pick_up_minute"><i class="icon-clock-4"></i> Pick-up minute</label>											
											<select id="pick_up_minute" class="minute fr form-control" tabindex="9">
												<option value="00">00</option>		
												<option value="05">05</option>		
												<option value="10">10</option>		
												<option value="15">15</option>		
												<option value="20">20</option>		
												<option value="25">25</option>		
												<option value="30">30</option>		
												<option value="35">35</option>		
												<option value="40">40</option>		
												<option value="45">45</option>		
												<option value="50">50</option>		
												<option value="55">55</option>		
											</select>
									</div>
								</div>								
							</div>	

							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="pickup_datePicker"><i class="icon-calendar"></i> Return date</label>
										<input type="text" name="date_to" data-date-format="dd/mm/yyyy" id="pickup_datePicker" placeholder="dd/mm/yyyy" tabindex="6" class="date-pick form-control">										
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="return_up_hour"><i class="icon-clock-4"></i> Return hour</label>
										<select id="return_up_hour" class="hour fl form-control" tabindex="8">
												<option value="00">00</option>		
												<option value="01">01</option>		
												<option value="02">02</option>		
												<option value="03">03</option>		
												<option value="04">04</option>		
												<option value="05">05</option>		
												<option value="06">06</option>		
												<option value="07">07</option>		
												<option value="08">08</option>		
												<option value="09">09</option>		
												<option value="10" selected="">10</option>		
												<option value="11">11</option>		
												<option value="12">12</option>		
												<option value="13">13</option>		
												<option value="14">14</option>		
												<option value="15">15</option>		
												<option value="16">16</option>		
												<option value="17">17</option>		
												<option value="18">18</option>		
												<option value="19">19</option>		
												<option value="20">20</option>		
												<option value="21">21</option>		
												<option value="22">22</option>		
												<option value="23">23</option>		
											</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="return_up_minute"><i class="icon-clock-4"></i> Return minute</label>											
											<select id="return_up_minute" class="minute fr form-control" tabindex="9">
												<option value="00">00</option>		
												<option value="05">05</option>		
												<option value="10">10</option>		
												<option value="15">15</option>		
												<option value="20">20</option>		
												<option value="25">25</option>		
												<option value="30">30</option>		
												<option value="35">35</option>		
												<option value="40">40</option>		
												<option value="45">45</option>		
												<option value="50">50</option>		
												<option value="55">55</option>		
											</select>
									</div>
								</div>								
							</div>
							
							<hr>
							<button class="btn_1 green"><i class="icon-search"></i>Search now</button>
						</form>
					</div>
					
				</div>
			</div>
		</section><!-- End hero -->
<script type="text/javascript">
	$ = jQuery.noConflict();
	function openSearchForm(){
		$('#header_search_form').fadeToggle(100);		
	}
	
	$(document).ready(function(){
		/*$('input.date-pick').datepicker({
			startDate: "today"
		});
		
		$(document).click(function (e) {
			console.log($(e.target).parents("body").length + e.target);
			if ($(e.target).parents("#header_search_form").length === 0 && $(e.target).parents(".datepicker-days").length != 0)
			{
				console.log($(e.target).parents(".datepicker-days").length);
				$("#header_search_form").fadeOut(100);
			}			
		});	*/
		
		/*$('input[name="date_from"]').datepicker( 'setDate', 'today' );
		$('input[name="date_to"]').datepicker( 'setDate', '+1d' );*/
	});
</script>
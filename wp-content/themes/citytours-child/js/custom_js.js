$ = jQuery.noConflict();

function sendNameMobile(thisForm){
	var formId = thisForm.id;
	$('.messageShow').removeClass('alert-success alert-warning').hide();
	var fullName = $('#' +formId+ ' #full_name').val();
	if(fullName == null || fullName == ''){
		$('#' +formId+ ' #full_name').addClass('error').focus();
		return false;
	}
	var phoneNo = $('#' +formId+ ' #phone_no').val();
	if(phoneNo == null || phoneNo == ''){
		$('#' +formId+ ' #phone_no').addClass('error').focus();
		return false;
	}
	var inquiry = $('#' +formId+ ' #inquiry').val();
	if(inquiry == null || inquiry == ''){
		$('#' +formId+ ' #inquiry').addClass('error').focus();
		return false;
	}
	var security = $('#' +formId+ ' #security').val();
	
	$('#' +formId+ ' .requestCalBtn').prop('disabled',true).remove();
	$('#' +formId+ ' .form-control').prop('disabled',true).remove();
	$('.messageShow').show().addClass('alert-success').html('<strong>Success!</strong> Thanks for contacting us. We will call back.');
	//$('#' +formId).html('<p class="confirmMsg">Thanks for contacting us. We will call back</p>');
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: admin_ajax,
		data: { 
			'action': 'sendNameMobile', //calls wp_ajax_nopriv_ajaxlogin
			'full_name': fullName, 
			'phone_no': phoneNo,
			'inquiry': inquiry,
			'security': security 
			},
		success: function(data){			
			if (data.success != false){
				$('.messageShow').removeClass('alert-success alert-warning').hide();
				$('.messageShow').show().addClass('alert-success').html('<strong>Success!</strong> Thanks for contacting us. We will call back.');
				//$('#' +formId).html('<p class="confirmMsg">Thanks for contacting us. We will call back</p>');
			} else {
				$('.messageShow').removeClass('alert-success alert-warning').hide();
				$('.messageShow').show().addClass('alert-warning').html('<strong>Success!</strong>'+data.meg);
				//alert(data.meg);
			}
		}
	});
	return false;
}

$(document).ready(function(){
	
	var get_hotels = 'get_hotels';		
	$( "#hotel_name" ).autocomplete({								
		source: function(req, response){						
			$.getJSON(admin_ajax+'?action='+get_hotels, req, response);
		},
		minLength: 1,
		open: function(){
			
		},
		close: function(){
							
		},
		select: function(event, ui) {
			var locationss = ui.item.locations;
			if(locationss !== '' && typeof locationss !== 'undefined'){
				$('.hotel_locations').val(locationss);
				$('#hotel_name').attr('name','ss');					
			} else {
				$('.hotel_locations').val('');
				$('#hotel_name').attr('name','s');	
			}			
		}
	});
	
	var get_tours = 'get_tours';		
	$( "#search_tours" ).autocomplete({								
		source: function(req, response){						
			$.getJSON(admin_ajax+'?action='+get_tours, req, response);
		},
		minLength: 1,
		open: function(){
			
		},
		close: function(){
							
		},
		select: function(event, ui) {
			var locationss = ui.item.locations;
			if(locationss !== '' && typeof locationss !== 'undefined'){
				$('.tour_locations').val(locationss);
				$('#search_tours').attr('name','ss');				
			}else {
				$('.tour_locations').val('');
				$('#search_tours').attr('name','s');
			}		
		}
	});
	var winDowHeight = $( document ).height() - 1000;
	$(window).scroll(function(){
		'use strict';
		if ($(this).scrollTop() > 100 && $(this).scrollTop() < winDowHeight){
			$('#header_search_form').hide();
		}
		if ($(this).scrollTop() > 450 && $(this).scrollTop() < winDowHeight){  
			$('.hotelSingleSidebar').addClass("sticky-sidebar");
			
		}
		else{
			$('.hotelSingleSidebar').removeClass("sticky-sidebar");
		}
	});
	
	
		
		
	//var dateToday = new Date().addHours(10); 			
		$('input[name="date_from"]').datepicker({
			dateFormat: "dd-mm-yy",
			startDate: "today"			
			
		}).on('changeDate', function(ev){			
			var date2 = ev.date;					
			if(typeof date2 !== 'undefined'){
				if(date2 != 'Invalid Date'){
					date2.setDate(date2.getDate() + 1);
					$('input[name="date_to"]').datepicker('setStartDate',date2);
					$('input[name="date_to"]').datepicker('setDate', date2);	
				} else {
					var date3 = $('input[name="date_to"]').datepicker('getDate');
					date3.setDate(date3.getDate() - 1);				
					$('input[name="date_from"]').datepicker('setDate', date3);	
				}
			}
		});
		
		$('input[name="date_to"]').datepicker({
			dateFormat: "dd-mm-yy",
			startDate: "+1d"			
		});
		
		$('input[name="date"]').datepicker({
			dateFormat: "dd-mm-yy",
			startDate: "today"				
		});

		var get_date_from = getParameterByName('date_from') ? getParameterByName('date_from') : '';
		var get_date_to = getParameterByName('date_to') ? getParameterByName('date_to') : '';
		if(get_date_from == ''){
			$('input[name="date_from"]').datepicker( 'setDate', 'today' );
		}
		
		if(get_date_to == ''){
			$('input[name="date_to"]').datepicker( 'setDate', '+1d' );
		}
		
		$('input[name="birth_date"]').datepicker({
			dateFormat: "dd-mm-yy",
			endDate: "today"
		});
		
		
	
});

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}
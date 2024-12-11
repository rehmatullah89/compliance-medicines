
<!DOCTYPE html>
<html lang="en">
<head>

<!-- Meta -->
<meta charset="utf-8" />

<!-- Title -->
<title>{{ config('app.name', 'Laravel') }}</title>
<meta name="description" content="text" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<!-- Favicon -->
<!-- link href="images/favicon.ico" rel="icon" type="image/x-icon" / -->
<link rel="icon" type="image/png" href="{{asset('images/favicon.png')}}" />

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto+Mono&display=swap" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet"
	href="{{asset('css/font-awesome/font-awesome.min.css')}}">

	<!-- custom fonts for slash 0 -->
	<link href="https://fonts.googleapis.com/css?family=Orbitron&display=swap" rel="stylesheet">
<!-- Bootstrap -->
<link rel="stylesheet"
	href="{{asset('css/bootstrap/bootstrap.min.4.4.1.css')}}">

<!-- Select2 -->
<link rel="stylesheet" type="text/css" href="{{asset('css/select2/select2.min.css')}}">

<!-- jQuery Datatables -->
<link rel="stylesheet" type="text/css" href="{{asset('css/jqueyDatatables/jquery.dataTables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/jqueyDatatables/rowReorder.dataTables.min.css')}}">

<!-- Bootstrap datepicker -->
<link href="{{asset('css/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />

<!-- toaster -->
<link rel="stylesheet" href="{{asset('css/toastr.css')}}">

<!-- jquery steps -->
<link rel="stylesheet" href="{{asset('css/jquery-steps/jquery.steps.css')}}" />

<!-- Custom CSS -->
<link href="{{asset('css/developer-custom.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('css/tazim-custom.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('css/compliance-generic.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('css/compliance-custom.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('css/compliance-responsive.css')}}" rel="stylesheet"
	type="text/css" />




{{-- <link href="{{asset('css/custom.css')}}" rel="stylesheet" type="text/css" /> --}}

<!-- <script type="text/javascript" src="{{asset('js/jSignature/flashcanvas.js')}}"></script> -->
 <style type="text/css">

  .chat {
    list-style: none;
    margin: 0;
    padding: 0;
  }

  .chat li {
    margin-bottom: 10px;
    padding-bottom: 5px;
    border-bottom: 1px dotted #B3A9A9;
  }

  .chat li .chat-body p {
    margin: 0;
    color: #777777;
  }

  .panel-body {
    overflow-y: scroll;
    height: 350px;
  }

/*  ::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    background-color: #F5F5F5;
  }

  ::-webkit-scrollbar {
    width: 12px;
    background-color: #F5F5F5;
  }

  ::-webkit-scrollbar-thumb {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
    background-color: #555;
  }*/

</style>




   <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
            'pusherKey' => config('broadcasting.connections.pusher.key'),
            'pusherCluster' => config('broadcasting.connections.pusher.options.cluster')
        ]) !!};

        window.base_url='{{url("")}}';
    </script>

</head>

<body>
	<!-- Start: Header Section -->


@auth
@if(!\Request::is('baa')&&!\Request::is('rppa'))
 @include('partials.header')
@endif
@endauth


	<section class="main-wrapper">
		<div class="container height_fullp">

			<?php

			    $menustate = "";
    			$menustate = Request::input('mstate');

    			//if(empty($menustate)) { $menustate = "exp"; }

    			//Session::put('mstate', $menustate);

    			$menustate_class = "fullwidth";

    			if($menustate == "clp") { $menustate_class = "collapsed_"; }
    			if($menustate == "exp") { $menustate_class = "fullwidth"; }
			?>
			@if(Request::is('roles/*'))
{{--Route::current()->getName()--}}
@endif
			<div class="row height_fullp <?= $menustate_class ?> <?= (isset(auth()->user()->roles) && @auth()->user()->roles[0]->name != 'practice_admin' && !auth()->user()->can('practice admin') && @auth()->user()->roles[0]->name != 'super_admin' && !auth()->user()->hasrole('practice_super_group') && Route::current()->getName() != 'search-all' && Route::current()->getName() != 'orders' && Route::current()->getName() != 'patient-order' && Route::current()->getName() != 'specific_patient_orders' && Route::current()->getName() != 'patient.create' && !Request::is('roles*') && !Request::is('permissions*') && !Request::is('modules*')&& !Request::is('user-roles*') && (strpos(url()->current(), 'baa') === false) && !str_contains(url()->current(), 'rppa') && !Request::is('baa'))?'cmp-container-sidebar-menu':'cmp-container-full-width'?>">
    			@auth
        			@if((strpos(url()->current(), 'baa') === false) && !str_contains(url()->current(), 'rppa') && !Request::is('baa')    && Route::current()->getName() != 'specific_patient_orders' &&  Route::current()->getName() != 'orders' && Route::current()->getName() != 'patient-order' && Route::current()->getName() != 'search-all' && Route::current()->getName() != 'patient.create' && !Request::is('roles*') && !Request::is('permissions*') &&!Request::is('modules*') && !Request::is('user-roles*') && (isset(auth()->user()->roles[0]->name) && (auth()->user()->roles[0]->name != 'practice_admin' && !auth()->user()->can('practice admin') && auth()->user()->roles[0]->name != 'super_admin' && !auth()->user()->hasrole('practice_super_group')    )) )

						<div class="left-sidebar sidebar-item">
							@include ("partials.sidebar")
						</div>

						<div class="col-sm-12 main-page-content">
							@yield('content')

						</div>
					@else
						<div class="col-sm-12 main-page-content">
							@yield('content')

						</div>
					@endif
				@else
                    @yield('content')
                @endauth

				@auth

                @if(auth()->user()->hasrole('practice_admin') || auth()->user()->can('practice admin'))

          <div class="live-chat-with-us-ui-practice-admin"  id="app" style="position: sticky; bottom: 0px; display: flex; justify-content: flex-end;
    width: auto;
    z-index: 99999;
">
                <practice-chat-app :user="{{ auth()->user()}}" :practice="{{ auth()->user()->practices->first()}}" :chatsession="{{ auth()->user()->pharmacySessions }}" ></practice-chat-app>
                <div>
                @endif

			@endauth
    		</div>




		</div>
	</section>








@auth

@if((auth()->user()->hasrole('practice_admin') || auth()->user()->can('practice admin')) && !\Request::is('baa')&&!\Request::is('rppa'))
<div class="watch-video-bar" data-toggle="modal" data-target="#video-play-Modal"><span class="fa fa-play fs-14_ bg-red txt-white wvb-video-ico_"></span> <div class="tt_cc_ ml-14_ fs-18_ tt_cc_ wvb-heading">watch video</div></div>

<div class="modal" id="video-play-Modal" style="display: none;" aria-hidden="true">
  <div class="modal-dialog wd-87p-max_w_400">
    <form class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header bg-transparent-force pos-rel_ pa-0_" style="font-size: 1px;padding: 0px;padding-top: 2px;padding-bottom: 2px;">
        <button type="button" class="close stick-top-right-circle" data-dismiss="modal">&#10006;
      </button></div>
      <!-- Modal body -->
      <div class="modal-body pa-0_">
  			<div class="row mr-0 ml-0">
  				<div class="col-sm-12 pr-0 pl-0">
  					<div class="trow_ c-dib_ cnt-center"><video width="320" height="240" controls="" poster="https://compliancereward.com/images/video-overlay-img.jpg" __idm_id__="102549505" style="width: 100%;">
  <source src="https://www.compliancereward.com/mov/public.mp4" type="video/mp4">
  <source src="movie.ogg" type="video/ogg">Your browser does not support the video tag.</video></div>
  				</div>
  			</div>
      </div>
    </form>
  </div>
</div>
@endif
<audio id="beepSound">
  <source src="{{'sound/beep1.mp3'}}" type="audio/mpeg">
</audio>
@include ('partials.footer')
@endauth


<script src="{{asset('js/app.js')}}" ></script>

<!--  Custom order js -->

<script type="text/javascript" src="{{asset('js/PracticeOrder.js')}}"></script>


	<!-- jQuery library -->
	<script
		src="{{asset('js/jquery/jquery.min.3.4.1.js')}}"></script>
		<script src="{{ url('js/jquery/1.11.4-jquery-ui.min.js') }}" type="text/javascript"></script>

	<!-- Popper JS -->
	<script
		src="{{asset('js/bootstrap/popper.min.1.16.0.js')}}"></script>

	<!-- Latest compiled JavaScript -->
	<script
		src="{{asset('js/bootstrap/bootstrap.min.4.4.1.js')}}"></script>

	<!-- Select2 -->
	<script type="text/javascript" src="{{asset('js/select2/select2.min.js')}}"></script>

	<!-- jQyery mask -->
	<script type="text/javascript" src="{{asset('js/jquery-mask/jquery.mask.min.js')}}"></script>

	<!-- jQuery-validate -->
	<script type="text/javascript" src="{{asset('js/jquery-validate/jquery.validate.min.js')}}"></script>

	<!-- Bootstrap autocomplete -->
	<script type="text/javascript" src="{{asset('js/bootstrap-autocomplete/bootstrap-autocomplete.min.js')}}"></script>

	<!-- Bootstrap datepicker  -->
	<script type="text/javascript" src="{{asset('js/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>



	<!-- Toaster -->
	<script type="text/javascript" src="{{asset('js/toastr.js')}}"></script>

	<!-- jquery steps -->
	<script type="text/javascript" src="{{asset('js/jquery-steps/jquery.steps.js')}}"></script>

	<script type="text/javascript" src="{{asset('js/jqueyDatatables/jquery.dataTables.min.js')}}"></script>
	
	<script type="text/javascript" src="{{asset('js/jqueyDatatables/dataTables.rowReorder.min.js')}}"></script>

        <script src="https://js.pusher.com/6.0/pusher.min.js"></script>
        <script>
          // Enable pusher logging - don't include this in production

          //Pusher.logToConsole = true;

          var pusher = new Pusher('48727362c82c456bc21e', {
            cluster: 'ap2'
          });
<?php
        $user = Auth::user();
        if(isset($user) && isset(auth::user()->practices->first()->id)){
?>
          var CurrentPhamacyId = '{{auth::user()->practices->first()->id}}';
<?php
        }else{
?>
            var CurrentPhamacyId = 9999999;
<?php
        }
  ?>
          console.log("pharmcyId="+CurrentPhamacyId);
          var channel = pusher.subscribe('notify-channel');
          channel.bind('App\\Events\\Notify', function(data) {
          console.log("channel value :"+CurrentPhamacyId);

            if(CurrentPhamacyId == data.pharmacy || CurrentPhamacyId == 9999999)
            {
				console.log("DATA msg:"+data.message);
                if(data.message == 2 || data.message == 24 || data.message == 'order_message' || data.message == 'order_paid' || data.message == 'order_refill')
                {
                   var cValue = $("#status_count_"+data.message).html();
                   var nValue = parseInt(cValue) + parseInt(1);
                   $("#status_count_"+data.message).html(nValue);
                }
                else if(data.message == 'patient_added'){

                    var mCount = $("#patient_month_count").html();
                    var tCount = $("#patient_total_count").html();

                    var mnValue = parseInt(mCount) + parseInt(1);
                    var tnValue = parseInt(tCount) + parseInt(1);

                    $("#patient_month_count").html(mnValue);
                    $("#patient_total_count").html(tnValue);
                    reloadChart(mnValue, tnValue);

                }
            }
                if(data.pharmacy == 0)
                {
                    toastr.success(data.message);
                    var x = document.getElementById("beepSound");
                    x.play();
                }
          });
        </script>
	<script type="text/javascript" id="custom-scripts">

		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});

		function formatNumber(n) {
		  return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
		}

		function formatQuantity(input, blur) {
  // appends $ to value, validates decimal side
  // and puts cursor back in right position.

  // get input value
  var input_val = input.val();

  // don't validate empty input
  if (input_val === "") { return; }

//    str = input_val.replace(/(\$|,)/gi,'');
 /*  str = input_val.replace(/[$,.]+/g,'');
   console.log(str);
   console.log(str.length);
  if(str.length == 7){
    console.log('length added');
    return false;

  }  */
  // original length
  var original_len = input_val.length;

  // initial caret position
  var caret_pos = input.prop("selectionStart");

  // check for decimal
  if (input_val.indexOf(".") >= 0) {

    // get position of first decimal
    // this prevents multiple decimals from
    // being entered
    var decimal_pos = input_val.indexOf(".");

    // split number by decimal point
    var left_side = input_val.substring(0, decimal_pos);
    var right_side = input_val.substring(decimal_pos);

    // add commas to left side of number
    left_side = formatNumber(left_side);

    // validate right side
    right_side = formatNumber(right_side);

    // On blur make sure 2 numbers after decimal
    if (blur === "blur") {
      right_side += "0";
    }

    // Limit decimal to only 2 digits
    right_side = right_side.substring(0, 1);

    // join number by .
    input_val =  left_side + "." + right_side;

  } else {
    // no decimal entered
    // add commas to number
    // remove all non-digits
    input_val = formatNumber(input_val);
    input_val =  input_val;

    // final formatting
    if (blur === "blur") {
      input_val += ".0";
    }
  }

  // send updated string to input
  input.val(input_val);

  // put caret back in the right position
  var updated_len = input_val.length;
  caret_pos = updated_len - original_len + caret_pos;
  // input[0].setSelectionRange(caret_pos, caret_pos);
}



		function formatCurrency(input, blur) {
		  // appends $ to value, validates decimal side
		  // and puts cursor back in right position.

		  // get input value
		  var input_val = input.val();

		  // don't validate empty input
		  if (input_val === "") { return; }

		//    str = input_val.replace(/(\$|,)/gi,'');
		 /*  str = input_val.replace(/[$,.]+/g,'');
		   console.log(str);
		   console.log(str.length);
		  if(str.length == 7){
		    console.log('length added');
		    return false;

		  }  */
		  // original length
		  var original_len = input_val.length;

		  // initial caret position
		  var caret_pos = input.prop("selectionStart");

		  // check for decimal
		  if (input_val.indexOf(".") >= 0) {

		    // get position of first decimal
		    // this prevents multiple decimals from
		    // being entered
		    var decimal_pos = input_val.indexOf(".");

		    // split number by decimal point
		    var left_side = input_val.substring(0, decimal_pos);
		    var right_side = input_val.substring(decimal_pos);

		    // add commas to left side of number
		    left_side = formatNumber(left_side);

		    // validate right side
		    right_side = formatNumber(right_side);

		    // On blur make sure 2 numbers after decimal
		    if (blur === "blur") {
		      right_side += "00";
		    }

		    // Limit decimal to only 2 digits
		    right_side = right_side.substring(0, 2);

		    // join number by .
		    input_val = "$" + left_side + "." + right_side;

		  } else {
		    // no decimal entered
		    // add commas to number
		    // remove all non-digits
		    input_val = formatNumber(input_val);
		    input_val = "$" + input_val;

		    // final formatting
		    if (blur === "blur") {
		      input_val += ".00";
		    }
		  }

		  // send updated string to input
		  input.val(input_val);

		  // put caret back in the right position
		  var updated_len = input_val.length;
		  caret_pos = updated_len - original_len + caret_pos;
		  // input[0].setSelectionRange(caret_pos, caret_pos);
		}
		$(document).ready(function(){
			$('#pic').mask('$9Z#Z#Z#Z#.99', {translation:  {'Z': {pattern: /[.]/, optional: true}}});
			$('#tpp').mask('$9Z#Z#Z#Z#.99', {translation:  {'Z': {pattern: /[.]/, optional: true}}});
			$('#pop').mask('$9Z#Z#Z#Z#.99', {translation:  {'Z': {pattern: /[.]/, optional: true}}});
			$('#drug_qty').mask('9Z#Z#Z#Z#.9', {translation:  {'Z': {pattern: /[.]/, optional: true}}});

			$("input[data-type='quantity']").on({
    keyup: function() {
        formatQuantity($(this));
    }
    // blur: function() {
    //     formatQuantity($(this), "blur");
    // }
});

			 $("input[data-type='currency']").on({
			    keyup: function() {
			      formatCurrency($(this));
			    }
			    // blur: function() {
			    //   formatCurrency($(this), "blur");
			    // }
			});


			$('#price-ui-details').click(function(prft_event_){
				prft_event_.preventDefault();
				prft_event_.stopPropagation();
			});

		/*	$('#priceDropdwon').on('hide.bs.dropdown', function () {
				$('#profit_ui-content #pop,#profit_ui-content #tpp,#profit_ui-content #pic,#profit_ui-content #drug_qty').val(null);
				$('#profit_ui-content #rx_ing_cost,#profit_ui-content #rx_profit1').html('');
				if($('#profit_ui-content #rx_profit').hasClass('txt-red'))
				{
					$('#profit_ui-content #rx_profit').removeClass('txt-red');
				}
				if($('#profit_ui-content #rx_profit').hasClass('txt-grn-dk'))
				{
					$('#profit_ui-content #rx_profit').removeClass('txt-grn-dk');
				}

			}); */


$('#price-ui-wrapper').click(function(){
	if($(this).hasClass('center')){
		$(this).removeClass('center');
		$('#pop,#tpp,#pic,#drug_qty,#psize').val(null);
				$('#rx_ing_cost, #rx_profit1').html('$0.00');
				if($('#rx_profit').hasClass('custom-red-cross-btn'))
				{
					$('#rx_profit').removeClass('custom-red-cross-btn');
				}
				if($('#rx_profit').hasClass('custom-green-tick-btn'))
				{
					$('#rx_profit').removeClass('custom-green-tick-btn');
				}
				if($('#pkg-div').hasClass('order-error'))
				{
					$('#pkg-div').removeClass('order-error');
				}
	}else{
		$(this).addClass('center');
	}

});

  /* Compliance drug category report */
  $('.leftCollaps').click(function(){
            if(!$('#comp-rate-drugcat-list').hasClass('show'))
            {
                $('#comp-rate-drugcat-list').html('<div id="loading_divq" style="text-align:center;"><img id="loading_small_one" src="{{ asset('images/small_loading.gif') }}" style="width: 50px;"></div>');
                get_left_major();
            }
        });

		});
    function get_orders_by_minor_reproting(minor_report, slug)
    {
        $('#'+slug).css('cursor', 'wait');
        $.ajax({
                url: "{{ url('/reports/orders_by_minor') }}/"+minor_report,
                method: 'get',
                data: '',
                async: true,
                success: function (result) {                
                    $('#'+slug).css('cursor', 'default');
                    $('#show-'+slug).html(result);                
                },
                error: function (data) {
                    $('#'+slug).css('cursor', 'default');
                    toastr.error('error', 'Internet packet loss please try again.');
                }
            });
    }
    function get_left_major()
    {
       // e.preventDefault();
        $.ajax({
            url: "{{ url('/reports/categories') }}",
            method: 'get',
            data: '',
            async: true,
            success: function (result) {                
                $('#loading_divq').remove(); 
                $('#comp-rate-drugcat-list').html(result);                
            },
            error: function (data) {
                $('#loading_divq').remove(); 
                toastr.error('error', 'Internet packet loss please try again.');
            }
        });
    }
    function reloadChart(minValue, maxValue)
    {
        var configs = {
		type: 'doughnut',
		data: {
			datasets: [{
				data: [
					minValue, maxValue
				],
				backgroundColor: [
					"#3e7bc4",
					"#b2d4eb"
				],
				label: 'Patients enrolled pas 7 days'
			}],
			labels: [
				'Minimum enrolled patinets past 7 days',
		        'Maximum enrolled patients past 7 days'
			]
		},
		options: {
			responsive: false,
			legend: {
				position: 'right',
				display: false,
			},
			title: {
				display: false,
				text: minValue+' min* '+maxValue+' max*',
				position: 'bottom',
			},
			animation: {
				animateScale: true,
				animateRotate: true
			},
			circumference: Math.PI,
			rotation: -Math.PI
		}
	};
	var context = 'semi-circle-chart';
	myDoughnut = new Chart(context, configs);
	myDoughnut.update();
    }

    </script>

    @yield('js')

     <!--   Mask -->

     <script type="text/javascript" src="{{asset('js/validate_masking.js')}}"></script>
     <script type="text/javascript" src="{{asset('js/sidebar-expand-collapse.js')}}"></script>



</body>
</html>

@extends('layouts.compliance')

@section('content')

{{-- <style>
    /*.flx-justify-start:hover{
        cursor: pointer;
    }*/



    table#searchPatientResult tbody tr:hover { opacity: 0.84; }
    table#searchPatientResult tr:hover td {  }
    table#searchPatientResult td { cursor: pointer; }

    #patient-search-carousel .carousel-inner .carousel-item img { max-height: 230px; }

    .chartjs-render-monitor { margin: 0px auto; }



table#searchPatientResult tbody tr:hover { opacity: 0.84; }
    table#searchPatientResult tr:hover td {  }
    table#searchPatientResult td { cursor: pointer; }

    #patient-search-carousel .carousel-inner .carousel-item img { max-height: 230px; }

    .chartjs-render-monitor { margin: 0px auto; }

</style>



<div class="row" style="display: flex; min-height: 100%;">
    <div class="col-sm-12" style="display: flex; flex-wrap: wrap;">

		{{--
    	<div class="row wd-100p mt-2_ ml-0 mr-0 ">

        	<div class="col-sm-12 pl-0 pr-0">
        		<div class="flx-justify-start flex-vr-start">
                
                
                
                    <div class="dashboard-info-row bg-f2f2f2 mr-1p" style="flex-grow: 4; padding-top:10px; padding-bottom: 2px;">

            			<div class="dashboard-info-box_ bg-white br-rds-24 mb-10_ mr-1p_" onclick="window.location='{{url('orders?service=21')}}'">
            				<span class="fa fa-question-circle txt-blue fs-32_ mr-4_"></span>
            				<span class="ttile-desc weight_600 fs-12_" style="width: 75px;">New HCP Rx's & Patient Msgs</span>
            				<span class="paid-count ml-auto_ fs-24_ weight_600 txt-red {{$counts->pending_question?'blink-icon-fast':''}}" id="status_count_order_message">{{$counts->pending_question?$counts->pending_question:'0'}}</span>
            			</div>
{{--
            			<div class="dashboard-info-box_ bg-white br-rds-24 mb-10_ mr-1p_" onclick="window.location='{{url('orders?service=10')}}'">
            				<span class="mr-4_"><img style="width: auto; height: 32px;" src="{{ url('svgs/Prescriptions-Ready-to-fill.svg') }}"></span>
            				<span class="ttile-desc weight_600 fs-12_" style="width: 69px;">Prescriptions Ready for Fill</span>
            				<span class="paid-count ml-auto_ fs-24_ weight_600 txt-red {{$counts->paid?'blink-icon-fast':''}}"  id="status_count_order_paid">{{$counts->paid?$counts->paid:'0'}}</span>
            			</div>

                        <div class="dashboard-info-box_ bg-white br-rds-24 mb-10_ mr-1p_" onclick="window.location='{{url('orders?service=23')}}'">
                            <span class="mr-4_"><img style="width: auto; height: 32px;" src="{{ url('svgs/Prescriptions-Ready-to-fill.svg') }}"></span>
                            <span class="ttile-desc weight_600 fs-12_" style="width: 85px;">Review Patient Requested Refills</span>
                            <span class="paid-count ml-auto_ fs-24_ weight_600 txt-red {{$counts->refill?'blink-icon-fast':''}}"  id="status_count_order_refill">{{$counts->refill?$counts->refill:'0'}}</span>
                        </div>

            			<div class="dashboard-info-box_ bg-white br-rds-24 mb-10_ mr-1p_" onclick="window.location='{{url('orders?service=2')}}'">
            				<span class="mr-4_"><img style="width: auto; height: 32px;" src="{{ url('svgs/patient-followup.svg') }}"></span>
            				<span class="ttile-desc weight_600 fs-12_" style="width: 70px;">Patient Follow Up Needed</span>
            				<span class="paid-count ml-auto_ fs-24_ weight_600 txt-red {{$counts->mbr?'blink-icon-fast':''}}"  id="status_count_2">{{$counts->mbr?$counts->mbr:'0'}}</span>
            			</div>

            			<div class="dashboard-info-box_ bg-white br-rds-24 mb-10_ mr-1p_" onclick="window.location='{{url('orders?service=24')}}'">
            				<span class="mr-4_"><img style="width: auto; height: 32px;" src="{{ url('svgs/Prescriptions-Waiting-review.svg') }}"></span>
            				<span class="ttile-desc weight_600 fs-12_" style="width: 78px;">Prescription Waiting Review</span>
            				<span class="paid-count ml-auto_ fs-24_ weight_600 txt-red"  id="status_count_24">{{$counts->under_review?$counts->under_review:'0'}}</span>
            			</div>

            			{{--
            			<div class="dashboard-info-box_ bg-white br-rds-24 mb-10_ mr-1p_" onclick="window.location='{{url('orders?service=pat&from_date='.\Carbon\Carbon::now()->subDay()->format('m/d/Y').'&to_date='.\Carbon\Carbon::now()->format('m/d/Y'))}}'">
            				<span class="mr-4_"><img style="width: auto; height: 32px;" src="{{ url('svgs/new-enrolled-patient.svg') }}"></span>
            				<span class="ttile-desc weight_600 fs-12_" style="width: 72px;">Newly Enrolled Patients Today</span>
            				<span class="paid-count ml-auto_ fs-24_ weight_600 txt-red">{{$counts->new_enrolled?$counts->new_enrolled:'0'}}</span>
                        </div>

                        <div class="dashboard-info-box_ bg-white br-rds-24 mb-10_" onclick="window.location='{{url('orders?service=2')}}'">
            				<span class="mr-4_"><img style="width: auto; height: 32px;" src="{{ url('svgs/new-enrolled-patient.svg') }}"></span>
            				<span class="ttile-desc weight_600 fs-12_" style="width: 59px;">ALL Enroller Patients</span>
            				<span class="paid-count ml-auto_ fs-24_ weight_600 txt-red">{{$counts->existing_enrolled?$counts->existing_enrolled:'0'}}</span>
            			</div>
            			--}}
            	{{--	</div>

            	</div>
        	</div>

        </div>--}}


        <div class="row pt-4_" style="padding-top: 6px;">

        @can('branch subbranch dashboard')
        <div class="col-sm-6">
                <div class="trow_">

                    <table class="table bordered-hd-blue-shade">
							<thead class="bg-blue">
								<tr class="weight_500-force-childs">
									<th class="txt-wht">@hasrole('practice_super_group')Practice @else Branch @endhasrole Name</th>
									<th class="txt-wht">Primary Contact</th>
									<th class="txt-wht">Enrolled Patient</th>
								</tr>
							</thead>
							<tbody>
                                @if(isset($practices) && count($practices) > 0)
                                   @foreach($practices as $key => $practice)



								<tr>
                                    <td>{{ $practice->practice_name }} 
            @hasrole('super_admin')
                                        {{ $practice->branch_name?'( '.$practice->branch_name.' )':'( Main )' }}
@endhasrole
                                        <a href="javascript:void(0)" onclick="window.location.href = '{{url("update-session-practice/".$practice->id)}}'" class="elm-right hover-black-child_">
                                            <img src="{{asset('images/svg/select-icon.svg')}}" />
                                        </a>
                                    </td>
									<td>{{ $practice->practice_phone_number }}</td>
									<td>{{ $practice->patients_count }}</td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
									<td colspan="3" class="text-center">No Data Found</td>
                                </tr>
                                @endif
							</tbody>
						</table>

                </div>
            </div>
        @endcan

          @can('search_patient')
            <div class="col-sm-6">
                <div class="trow_ mb-14_">
                    <div class="fs-17_ weight_600">Welcome {{auth::user()->name}}</div>
                </div>
                <div class="trow_ mb-24_">
                    <p class="ma-0_ fs-16_" style="line-height: 1.7em;">You are securely connected to Compliance Reward&#8480;, where you enroll your most valuable patients to receive convenient and informative messages and activities to support their treatments!</p>
                </div>
                <div class="trow_ mb-14_">
                    <div class="fs-17_ txt-blue weight_600">Patient Search</div>
                </div>
                <div class="trow_">
                    <form method="post" onsubmit="search_practice()" action="javascript:void(0);" class="" style="width: 70%; min-width: 270px;">
                        <div class="input-group c-dib_" id="searchDiv" style="padding: 7px;border-radius: 6px;background-color: #fff;border: solid 1px #afbcc2;">
                            <input type="text" class="form-control fs-16_" name="query" id="query" required="" value="" style="line-height: 1.2em !important;height: 36px;border: 0px;padding-left: 0px;padding-left: 6px;" placeholder="Search using name, email, phone #" data-provide="typeahead" autocomplete="off">
                            <div class="input-group-append" style="background-color: #fff;color: #fff !important;margin: 0px;border-radius: 0px 13px 13px 0px;">
                                <button type="submit" id="patientSearch" class="btn bg-blue-txt-wht" style="border-radius: 6px;width: 40px;text-align: center;height: 36px;padding: 0px;"> <i class="fa fa-search fs-20_ " style="line-height: 24px;"></i> </button>
                            </div>
                        </div>
                    </form>

                </div>
                @can('view button add_patient')
                <div class="row" style="margin-top:10px">
                    <div class="col-sm-12">
                        <div class="elm-left">
                           <button class="btn bg-blue-txt-wht weight_600 fs-14_" style="line-height: 30px; padding: .1rem .75rem;" onclick="window.location.href = '{{url("patient/create")}}'">+ Add New</button>
                        </div>
                    </div>
                </div>
                @endcan
            </div>
				@endcan

            <div class="col-sm-6">
            	<div class="trow_ mb-7_ wd-100p mt-2_ ml-0 mr-0 ">
            	    <div class="flx-justify-center bg-white pa-4_ flex-vr-center" style="flex-grow: 0; padding-bottom: 0px;">
        				<div class="dashboard-info-box_ bg-white br-rds-24" style="max-width: 310px;">

    						{{--<div class="trow_ cnt-left txt-gray-7e fs-17_ p8-12_ weight_600"
    							style="border-bottom: solid 1px #cecece;">My Patient Enrollments Today</div>--}}

    						<div class="trow_ weight_600">

    							<table style="border: 0px;background-color: transparent;" border="0">
    								<tbody>
    									<tr>
    										<td class="wd-33p left-graph mr-7_" style="min-width: 84px;">
    											<div class="trow_ pos-rel_ c-dib_ mb-4_ pa-0_">
    												<canvas style="max-width: 80px;" id="semi-circle-chart" class="chartjs-render-monitor"></canvas>
    											</div>
    											<div class="trow_ ml-7_">
    												<span class="elm-left txt-blue fs-11_ weight_600"> @if($last_seven_days) {{ $last_seven_days->min('u_count') }}  @else 0 @endif  min*</span>
    												<span class="elm-right txt-blue fs-11_ weight_600" style="padding-right: 11px;"> @if($last_seven_days) {{ $last_seven_days->max('u_count') }}  @else 0 @endif  max*</span>
    											</div>
    										</td>
    										<td class="wd-30p month-to-date mr-14_ wid_33" style="min-width: 100px;">
    											<div class="trow_ c-dib_ mb-4_ p4-8_ pad_le_ri"
    												style="border: solid 1px #cecece; background-color:#fff;">
    												<span class="elm-left wd-57p txt-gray-7e cnt-left pa-0_ fs-13_ wid_65per wid_75per">Month to Date</span>
    												<span class="elm-right wd-42p txt-red cnt-center fs-24_ weight_600 pad_top wid_25per" id="patient_month_count"> @if($current_month_patients) {{ $current_month_patients->u_count }} @else 0 @endif </span>
    											</div>
    											<div class="trow_">
    												<span class="txt-blue fs-11_ weight_600">&nbsp;</span>
    											</div>
    										</td>
    										<td class="wd-36p program-to-date" style="min-width: 120px;">
    											<div class="trow_ c-dib_ mb-4_ p4-8_ pad_le_ri"
    												style="border: solid 1px #cecece; background-color:#fff;">
    												<span class="elm-left wd-57p txt-gray-7e cnt-left pa-0_ fs-13_ wid_65per wid_75per">Program to Date</span>
    												<span class="elm-right wd-42p txt-red cnt-center fs-24_ weight_600 pad_top wid_25per" id="patient_total_count"> @if($total_patients) {{ number_format($total_patients->sum('u_count'), 0) }} @else 0 @endif </span>
    											</div>
    											<div class="trow_">
    												<span class="txt-blue fs-11_ weight_600">*moving  @if($total_patients) {{ number_format($total_patients->avg('u_count'), 2) }} @else 0 @endif day average</span>
    											</div>
    										</td>
    									</tr>
    								</tbody>
    							</table>
    						</div>
        				</div>
            		</div>
            	</div>
            	
                @php $acount = 1; $img_url = str_replace('/public','',url('')); $bllt=''; @endphp
@can('view promotion_slider')
                <div class="table-box" id="patientSlider">
                    <div class="user-report-head">
                        <span>&nbsp;</span>
                    </div>


                    <div class="row">
                        <div class="col-sm-12">
                            <div id="patient-search-carousel" class="carousel slide" data-ride="carousel">
                            	<div class="carousel-inner">
                                            @if($enrol_page_slider)
                                                @foreach($enrol_page_slider as $KeyLS=>$ValLS)
                                                    @php if($acount==1){ $cllass='active'; $indClass='active';}elseif($acount==2){ $cllass = 'carousel-item-next'; $indClass='';}else{ $cllass=''; } @endphp
                                                    <div id="slide_id_{{ $acount }}" class="carousel-item {{ $cllass }}" data-interval="15000">
                                                        <span class="item-count">{{ $acount }}</span> <img class="d-block w-100" src="{{$img_url}}{{Storage::url('app/'.$ValLS->image_url) }}">
                                                    </div>

                                                    @php
                                                    $bllt .= '<li id="bult_id_'.$acount.'" data-target="#home-page-carousel" data-slide-to="'.($acount-1).'" class="'.$indClass.'"></li>';
                                                        $acount++;
                                                    @endphp


                                                @endforeach
                                            @endif
                                        </div>
                                        <ol class="carousel-indicators">
                                            @php echo $bllt; @endphp
                                        </ol>
                                <a class="carousel-control-prev" href="#patient-search-carousel" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only prev-control-txt">Previous</span> </a>
                                <a class="carousel-control-next" href="#patient-search-carousel" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only next-control-txt">Next</span> </a>
                            </div>
                        </div>
                    </div>
                </div>

@endcan

@can('search_patient')
                 <div class="table-box"  id="patientSearchTable" style="display: none;">
                <div class="trow_ mb-14_">
                    <div class="fs-17_ txt-blue weight_600">BEST MATCH(ES)</div>
                </div>
                <div class="row">
                    <div class="col-sm-12 table-responsive">
                        <table class="table bordered-hd-blue-shade" id="searchPatientResult">
                            <thead class="bg-blue">
                                <tr class="weight_500-force-childs cur-pointer">
                                    <th class="txt-wht">First Name</th>
                                    <th class="txt-wht">Last Name</th>
                                    <th class="txt-wht">Gender</th>
                                    <th class="txt-wht">DOB</th>
                                    <th class="txt-wht">Mobile</th>
                                    <th class="txt-wht">Zip</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- <div class="row">
                    <div class="col-sm-12">
                        <div class="elm-left">
                           <button class="btn bg-blue-txt-wht weight_600 fs-14_" style="line-height: 30px; padding: .1rem .75rem;" onclick="window.location.href = '{{url("patient/create")}}'">+ Add New</button>
                        </div>
                    </div>
                </div> --}}
                     </div>

@endcan

            </div>
        </div>
        <div class="row" style="min-width: 100%; display: flex; align-items: center;">
            @php $bCoun = 1; @endphp
            @if($enrol_page_simple)
                @foreach($enrol_page_simple as $KeyLS=>$ValLS)
                    <div class="col-sm-6"><div style="@if($bCoun==1) {{ 'float:left;' }} @else {{ 'float:right;' }} @endif"><img class="img-fluid"
                            id='simple_id_{{ $bCoun }}'
                            src="{{$img_url}}{{Storage::url('app/'.$ValLS->image_url) }}"
                            ></div></div>
                    @php $bCoun++; $acount++; @endphp
                @endforeach
            @endif
        </div>

    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.js"></script>
<script type="text/javascript">


$(document).ready(function(){

    $(document).on('click', '.even, .odd', function(){
        let id = $(this).data("id");
        var url = '{{ url("patient/order/:id") }}';
        url = url.replace(':id',id);
        window.location = url;
    });

    $('#patientSearchTable').hide();
    $('#patientSearch').on('click',function(e){
        toastr.clear();
        e.preventDefault();
        var search =  $('#query').val();
        if(search != ''){
            $('#patientSearch').attr("disabled","disabled");
            $('#searchDiv').removeClass("searchError");
            // alert(search);
            var search = search.replace(/[- )(]/g, '');
            $('#patientSlider').show();
            $('#patientSearchTable').hide();
            $('#searchPatientResult tbody').empty();
            if($.fn.DataTable.isDataTable( '#searchPatientResult' )){  $('#searchPatientResult').DataTable().destroy(); }
           /* $.ajax({
                url: "{{url('patient-search')}}",
                method: 'post',
                data: {psearch:search},
                async:true,
                success: function(result){

                    $('#searchPatientResult tbody').empty();
                    // console.log(search);
                    // console.log(result)
                    if($.fn.DataTable.isDataTable( '#searchPatientResult' )){ $('#searchPatientResult').DataTable().destroy(); }
                    if(result.patient.length && result.patient.length > 0){
                        $('#patientSlider').hide();
                        $('#patientSearchTable').show();
                        $.each(result.patient , function(k,v){
                            var id = v.Id;
                            var url = '{{ url("patient/order/:id") }}';
                            // url = 'practice/' + v.id + '/edit';
                            url = url.replace(':id',id);
                            var first_name = v.FirstName;
                            var last_name = v.LastName;
                            var mobileNumber = v.MobileNumber;
                            if(v.MobileNumber!=null){ var mobileNumber = v.MobileNumber.replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, "($1) $2-$3"); } else{ var mobileNumber = 'n/a'; }
                            console.log(v.MobileNumber+'         '+mobileNumber);
                            var newDate1;
                            if(v.BirthDate){
                            var dateAtr = v.BirthDate.split('-');
                            newDate1 = dateAtr[1] + '/' +dateAtr[2] + '/' + dateAtr[0];
                            }
                            if(v.Gender == 'M'){
                                var gender = 'Male';
                            }else{
                                var gender = 'Female';
                            }
                            console.log("bef",search,mobileNumber);
                            var mobile_number = mobileNumber.replace(new RegExp(search, "gi"), (match) => '<span class="match"><b>'+match+'</b></span>');
                            var fname = first_name.replace(new RegExp(search, "gi"), (match) => '<span class="match"><b>'+match+'</b></span>');
                            var lname = last_name.replace(new RegExp(search, "gi"), (match) => '<span class="match"><b>'+match+'</b></span>');
                            console.log("aft",mobile_number)
                            $('#searchPatientResult tbody').append('<tr onclick=\'window.location="'+url+'"; \'><td>' + fname + '</td><td>' + lname + '</td><td>' + gender + '</td><td>' + newDate1 + '</td><td>' + mobile_number + '</td><td>' + v.ZipCode + '</td></tr>');



                        }); 


                            
                    }
                    else{
                        $('.compliance-user-table tbody').html('<tr style="text-align:center;"><td colspan="6" class="text-center">No record found</td></tr>');
                        toastr.info('Patient Search Status:','No record Found Please Enroll new patient');

                        setTimeout(function ()
                        {
                            window.location="{{url('patient/create')}}";
                            $('#patientSearch').removeAttr("disabled");
                        }, 3000);

                    }

                    // $('.alert').show();
                    // $('.alert').html(result.success);
                },
                error: function(data){
                    $('#patientSearch').removeAttr("disabled");
                }});
        }else{
            $('#searchDiv').addClass("searchError");
            return false;
        } */
        }

        $('#searchPatientResult').DataTable({
                                processing: false,
                                serverSide: true,
                                Paginate: true,
                                lengthChange: false,
                                autoWidth: false,
                                order:[],
                                bFilter: false,
                                pageLength: 10,
                                ajax: {
                                    "type": "post",
                                    "url": '{{ url("patient-search") }}?psearch='+$("#query").val().replace(/[- )(]/g, ''),
                                    "dataType": "json",
                                    "contentType": 'application/json; charset=utf-8',
                                    "dataSrc" : "patient",
                                    "data": function(data){
                                        
                                    },
                                    "complete": function(cc){
                                        console.log(cc);
                                        $('#patientSlider').hide();
                                        $('#patientSearchTable').show();
                                    }
                                },
                                columns: [{'data': 'FirstName', 'render': function(fname, type, full, meta){
                                    return fname.replace(new RegExp(search, "gi"), (match) => '<span class="match"><b>'+match+'</b></span>');
                                }},
                                          {'data': 'LastName', 'render': function(lname, type, full, meta){
                                    return lname.replace(new RegExp(search, "gi"), (match) => '<span class="match"><b>'+match+'</b></span>');
                                }},
                                          {'data': 'Gender', 'render': function(gender, type, full, meta){
                                    return gender == 'M' ? 'Male' : 'Female';
                                }},
                                          {'data': 'BirthDate', 'render': function(bdate){
                                            if(bdate){
                                                var dateAtr = bdate.split('-');
                                                newDate1 = dateAtr[1] + '/' +dateAtr[2] + '/' + dateAtr[0];
                                                return newDate1;
                                            }
                                            else
                                                return bdate;
                                          }},
                                          {'data': 'MobileNumber', 'render': function(mobile, type, full, meta){
                                            if(mobile!=null){ mobile = mobile.replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, "($1) $2-$3"); } else{ mobile = 'n/a'; }
                                            return mobile.replace(new RegExp(search, "gi"), (match) => '<span class="match"><b>'+match+'</b></span>');
                                          }},
                                          {'data': 'ZipCode', 'render': function(zcode, type, full, meta){
                                              if(zcode != null)
                                                return zcode.replace(new RegExp(search, "gi"), (match) => '<span class="match"><b>'+match+'</b></span>');
                                              else
                                                return zcode;
                                }}],
                                'createdRow': function(row, d, di){
                                    $(row).attr("data-id", d.Id);
                                }

                            });
                            $('#patientSearch').removeAttr("disabled");
    });

    $("section.user-report-main").addClass("patient_module-search");
})

$(window).on('load',function(){

var configs = {
		type: 'doughnut',
		data: {
			datasets: [{
				data: [
					@if(!empty($last_seven_days)) {{ $last_seven_days->min('u_count') }}, {{ $last_seven_days->max('u_count') }} @else {{ '10, 100'}} @endif
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
				text: '{{ $last_seven_days->min('u_count') }} min* {{ $last_seven_days->max('u_count') }} max*',
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

});
</script>
@endsection

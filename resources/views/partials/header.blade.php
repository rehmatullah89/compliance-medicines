<style>
    

table#searchPatientResult tbody tr:hover { opacity: 0.84; }
    table#searchPatientResult tr:hover td {  }
    table#searchPatientResult td { cursor: pointer; }

    #patient-search-carousel .carousel-inner .carousel-item img { max-height: 230px; }

    .chartjs-render-monitor { margin: 0px auto; }

</style>
<header class="site-header">
	<div class="container">
		<div class="row mt-7_">
			<div class="col-sm-12">

				<div class="trow_"
					style="display: flex; justify-content: flex-start;">
					<div class="elm-left" style="display: flex; align-items: center;">
						<a class="navbar-brand" href="{{url('/')}}"> <img
							src="{{asset('images/logo.png')}}"
							alt="Site Logo">
						</a> 
						
					</div>
					{{-- Header dashboard count --}}
					
					

					<div class="dashboard-info-row bg-white mr-1p" style="flex-grow: 4; padding-top:10px; padding-bottom: 2px;">

            			<div class="dashboard-info-box_ bg-white br-rds-24 mb-10_ mr-1p_" onclick="window.location='{{url('orders?service=21')}}'">
            				<span class="fa fa-question-circle txt-blue fs-26_ mr-4_"></span>
            				<span class="ttile-desc weight_600 fs-11_" style="width: 67px;">New HCP Rx's & Patient Msgs</span>
            				<span class="paid-count ml-auto_ fs-21_ weight_600 txt-red {{$counts->pending_question?'blink-icon-fast':''}}" id="status_count_order_message">{{$counts->pending_question?$counts->pending_question:'0'}}</span>
            			</div>
<!-- onclick="window.location='{--{url('orders?service=21&type=alternate')--}}'" -->                            
                                {{-- <div class="dashboard-info-box_ bg-white br-rds-24 mb-10_ mr-1p_">
            				<span class="fa fa-exchange txt-blue fs-26_ mr-4_"></span>
            				<span class="ttile-desc weight_600 fs-11_" style="width: 54px;">Alternative Drug Orders</span>
            				<span class="paid-count ml-auto_ fs-21_ weight_600 txt-red {{($alternate_drug_counts>0)?'blink-icon-fast':''}}" id="status_count_alternate_drug">{{($alternate_drug_counts>0?$alternate_drug_counts:0)}}</span>
            			</div> --}}

            			<div class="dashboard-info-box_ bg-white br-rds-24 mb-10_ mr-1p_" onclick="window.location='{{url('orders?service=10')}}'">
            				<span class="mr-4_"><img style="width: auto; height: 26px;" src="{{ url('svgs/Prescriptions-Ready-to-fill.svg') }}"></span>
            				<span class="ttile-desc weight_600 fs-11_" style="width: 61px;">Prescriptions Ready for Fill</span>
            				<span class="paid-count ml-auto_ fs-21_ weight_600 txt-red {{$counts->paid?'blink-icon-fast':''}}"  id="status_count_order_paid">{{$counts->paid?$counts->paid:'0'}}</span>
            			</div>

                        <div class="dashboard-info-box_ bg-white br-rds-24 mb-10_ mr-1p_" onclick="window.location='{{url('orders?service=23')}}'">
                            <span class="mr-4_"><img style="width: auto; height: 26px;" src="{{ url('svgs/Prescriptions-Ready-to-fill.svg') }}"></span>
                            <span class="ttile-desc weight_600 fs-11_" style="width: 77px;">Review Patient Requested Refills</span>
                            <span class="paid-count ml-auto_ fs-21_ weight_600 txt-red {{$counts->refill?'blink-icon-fast':''}}"  id="status_count_order_refill">{{$counts->refill?$counts->refill:'0'}}</span>
						</div>
						@if(auth::user()->hasRole('compliance_admin'))
						<div class="dashboard-info-box_ bg-white br-rds-24 mb-10_ mr-1p_" onclick="window.location='{{url('report/refills-due')}}'">
            				<span class="mr-4_"><img style="width: auto; height: 26px;" src="{{ url('svgs/patient-followup.svg') }}"></span>
            				<span class="ttile-desc weight_600 fs-11_" style="width: 66px;">Rx's Refillable Now</span>
            				<span class="paid-count ml-auto_ fs-21_ weight_600 txt-red {{$counts->refillable?'blink-icon-fast':''}}"  id="status_count_2">{{$counts->refillable?$counts->refillable:'0'}}</span>
            			</div> 
@endif
						@if(!auth::user()->hasRole('compliance_admin'))
            			<div class="dashboard-info-box_ bg-white br-rds-24 mb-10_ mr-1p_" onclick="window.location='{{url('orders?service=2')}}'">
            				<span class="mr-4_"><img style="width: auto; height: 26px;" src="{{ url('svgs/patient-followup.svg') }}"></span>
            				<span class="ttile-desc weight_600 fs-11_" style="width: 66px;">Patient Follow Up Needed</span>
            				<span class="paid-count ml-auto_ fs-21_ weight_600 txt-red {{$counts->mbr?'blink-icon-fast':''}}"  id="status_count_2">{{$counts->mbr?$counts->mbr:'0'}}</span>
            			</div>

            			<div class="dashboard-info-box_ bg-white br-rds-24 mb-10_ mr-1p_" onclick="window.location='{{url('orders?service=24')}}'">
            				<span class="mr-4_"><img style="width: auto; height: 26px;" src="{{ url('svgs/Prescriptions-Waiting-review.svg') }}"></span>
            				<span class="ttile-desc weight_600 fs-11_" style="width: 70px;">Prescription Waiting Review</span>
            				<span class="paid-count ml-auto_ fs-21_ weight_600 txt-red"  id="status_count_24">{{$counts->under_review?$counts->under_review:'0'}}</span>
            			</div>
						@endif
            			{{--
            			<div class="dashboard-info-box_ bg-white br-rds-24 mb-10_ mr-1p_" onclick="window.location='{{url('orders?service=pat&from_date='.\Carbon\Carbon::now()->subDay()->format('m/d/Y').'&to_date='.\Carbon\Carbon::now()->format('m/d/Y'))}}'">
            				<span class="mr-4_"><img style="width: auto; height: 26x;" src="{{ url('svgs/new-enrolled-patient.svg') }}"></span>
            				<span class="ttile-desc weight_600 fs-11_" style="width: 66px;">Newly Enrolled Patients Today</span>
            				<span class="paid-count ml-auto_ fs-21_ weight_600 txt-red">{{$counts->new_enrolled?$counts->new_enrolled:'0'}}</span>
                        </div>

                        <div class="dashboard-info-box_ bg-white br-rds-24 mb-10_" onclick="window.location='{{url('orders?service=2')}}'">
            				<span class="mr-4_"><img style="width: auto; height: 26px;" src="{{ url('svgs/new-enrolled-patient.svg') }}"></span>
            				<span class="ttile-desc weight_600 fs-11_" style="width: 56px;">ALL Enroller Patients</span>
            				<span class="paid-count ml-auto_ fs-21_ weight_600 txt-red">{{$counts->existing_enrolled?$counts->existing_enrolled:'0'}}</span>
            			</div>
            			--}}
					</div>
					
					{{-- header dashboard count end --}}
					<div class="elm-right"
						style="display: flex; align-items: center; justify-content: flex-end; margin-left: auto;">
						        @if(auth::user()->hasRole('compliance_admin') || auth::user()->can('all access'))                                                       
						        	<div class="live-chat-with-us-ui-compliance-admin"  id="app">
                                                                    <compliacne-chat-app :user="{{ auth()->user() }}"></compliacne-chat-app>
                                                                </div>
                                                        @endif
						<span class="user-photo mr-4_"> 
						{{-- 	<img
							src="{{asset('images/user-photo.png')}}"
							style="border-radius: 50%; max-height: 39px; border: solid 1px #eee;" /> --}}
							<span style="width: 40px;height: 40px;display: flex;align-items: center;justify-content: center;background-color: #3b7ec4;color: #ffffff;font-size: 24px;font-weight: 600;border-radius: 50%;margin-right: 3px;">{{substr(auth::user()->name,0,1)}}</span>
						</span>
						
						
						<div class="c-dib_" style=" max-width: 160px; display: flex; justify-content: flex-start; flex-wrap: wrap;">
						
    						<div class="dropdown wd-100p">
    							<a class="dropdown-toggle weight_700 fs-17_"
    								data-toggle="dropdown"> Hello, <span class="txt-blue fs-17_"><?php echo e(auth::user()->name); ?></span>
    							</a>
    							<div class="dropdown-menu">
    								<!-- <a class="dropdown-item" href="#">Profile</a>
    								<a class="dropdown-item" href="#">Settings</a> -->
    								 <a class="dropdown-item"
    									onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
    							</div>
    						</div>
    						
    						<div class="wd-100p mt-4_ text-sline" style=" overflow: hidden; white-space: normal;">
    							
    							<span
    								class="txt-gray-9a-force-child fs-13_ lh-14_ pt-2_ tt_uc_">
    	
    								@if(isset(auth()->user()->roles[0]->name))
    	
    								@if( (auth()->user()->roles[0]->name == 'practice_admin' || auth()->user()->can('practice admin')) && !auth::user()->hasRole('practice_super_group'))
    								{{auth()->user()->practices[0]->practice_name}} {{auth()->user()->practices[0]->branch_name?" (".auth()->user()->practices[0]->branch_name." ) ":''}} | {!!
    								ucfirst(str_replace("_"," ",auth()->user()->roles[0]->name)) !!}
    								@elseif(auth()->user()->roles[0]->name == 'super_admin')
    								{{auth()->user()->practices[0]->practice_name}} | {!!
    								ucfirst(str_replace("_"," ",auth()->user()->roles[0]->name)) !!}
    								@elseif( (auth()->user()->roles[0]->name == 'compliance_admin' || auth()->user()->can('all access')) && !auth::user()->hasRole('practice_super_group'))
    	
    								ALL ACCESS
    								@elseif(auth()->user()->roles[0]->name == 'practice_super_group')
    									{{auth::user()->practices->first()->group->group_name??''}}  |  Practice Group OWNER
    	
    								@else {!! ucfirst(str_replace("_","
    								",auth()->user()->roles[0]->name)) !!} @endif
    								@endif
    							</span>
    							
    							
    						</div>
    						
    					</div>
						
						
						
						
						
						<a
							onclick="event.preventDefault();document.getElementById('logout-form').submit();"
							class="txt-red weight_500 fs-17_"> <i class="fa fa-sign-out"
							aria-hidden="true" style="line-height: 24px; margin-left: 7px;"></i>
						</a>
						<form id="logout-form" action="{{ route('logout') }}"
							method="POST" style="display: none;">@csrf</form>
					</div>
				</div>


			</div>
		</div>

	</div>
	{{--url()->current()--}}

	<div class="row bg-blue  mt-7_ mb-7_ ">
		<div class="col-sm-12">
			<div class="container">
				<div class="flx-justify-start">
					<div class="left-col-header">
						<nav class="navbar pa-0_ vertical-dropdown">
							<ul class="nav nav_state nav-tabs txt-wht-child">
								@can('view menu enroll_search')
                                                                @if(auth()->user()->hasrole('practice_admin') || auth()->user()->can('practice admin'))
<li class="nav-item @php if(request()->is('patient/*') || request()->is('patient') || request()->is('admin/search-all') ) { echo 'active'; } @endphp"><a
									class="nav-link" href="{{url('patient')}}">ENROLL/SEARCH</a></li>
@endif
                                                                        @endcan
							@can('view menu dashboard')
								<li class=@if(strpos(url()->current(),'report') == false && strpos(url()->current(),'orders') == false && strpos(url()->current(),'roles') == false && strpos(url()->current(),'permissions') == false && strpos(url()->current(),'modules') == false && strpos(url()->current(),'user-roles') == false)
									'nav-item active' @else 'nav-item' @endif><a class="nav-link"
									href="{{url('overview')}}">DASHBOARD</a>
								</li>
							@endcan
							@can('view menu reports')
                                                                @if(auth::user()->hasRole('compliance_admin') || auth::user()->can('all access')) 
                                                                    <li class=@if(strpos(url()->current(),'report') !== false && strpos(url()->current(),'orders') == false)
                                                                            'nav-item active' @else 'nav-item' @endif><a class="nav-link"
                                                                            href="{{url('report/user-statistics')}}">REPORTS</a>
                                                                    </li>
                                                                    @else
                                                                            <li
                                                                            class="nav-item @php if(request()->is('*/accounting') ) { echo 'active'; } @endphp"><a
                                                                            class="nav-link" href="{{url('report/accounting')}}">REPORTS</a>
                                                                    </li>
								@endif
							@endcan
							@can('view menu patient_requests')
								<li
								class="nav-item @php if( (request()->is('orders') || request()->is('specific-patient-orders/*')) ) { echo 'active'; } @endphp"><a
								href="{{url('orders')}}" class="nav-link">PATIENT REQUESTS</a>
							</li>
							@endcan
							@can('view menu roles_and_permission')
								<li
								class="nav-item @php if( (request()->is('roles*') || request()->is('permissions*')|| request()->is('modules*') || request()->is('user-roles*') ) ) { echo 'active'; } @endphp"><a
								href="{{url('roles')}}" class="nav-link">ROLES & PERMISSIONS</a>
							


<ul>
	<li class="">
		<a class="tt_uc_" href="{{url('roles')}}">Roles</a>
		<ul>
	<li class="">
		<a class="tt_uc_" href="{{url('roles/create')}}">Add New Role</a>
	</li>
	<li class="">
			<a class="tt_uc_" href="{{url('roles')}}">View Role</a>
	</li>
</ul>
		
		
	</li>
	<li class="">
			<a class="tt_uc_"  href="{{url('permissions/')}}">Permissions</a>
		
		<ul>
	<li class="">
		<a class="tt_uc_"  href="{{url('permissions/create')}}">Add New Permission</a>
	</li>
	<li class="">
			<a class="tt_uc_"  href="{{url('permissions')}}">View Permission</a>
	</li>
</ul>
		
	</li>
		<li class="">
			<a class="tt_uc_"  href="{{url('modules')}}">Modules</a>
		
		<ul>
	<li class="">
		<a class="tt_uc_"  href="{{url('modules/create')}}">Add New Modules</a>
	</li>
	<li class="">
			<a class="tt_uc_"  href="{{url('modules')}}">View Module</a>
	</li>
</ul>
		
	</li>
		<li class="">
			<a class="tt_uc_" href="{{url('user-roles')}}">Users</a>
		
		<ul>

	<li class="">
			<a class="tt_uc_" href="{{url('user-roles')}}">View User Role</a>
	</li>
</ul>
		
	</li>
</ul>
							</li>



							@endcan
							</ul>
						</nav>
					</div>
					@can('view menu search_bar')
					<div class="flex-vr-center flx-justify-start text-sline right-col-header" style="margin-left: auto">

						@if(!Session::has('practice'))
						<form action="{{ url('admin/search-all') }}" method="post"
							class="compliance-form_ trow_ mb-0_"
							style="min-width: 350px; max-width: 340px;">
							{{ csrf_field() }}
							<div class="input-group"
								style="display: flex; align-items: center; border-radius: 13px; background-color: #fff; padding-left: 11px; padding-right: 2px;">
								<input type="text" class="form-control" name="keyword"
									id="keyword_search_all"
									value="@if(Request('keyword')){{ Request('keyword') }}@endif"
									style="line-height: 1.2em !important; height: 26px; border: 0px; padding-left: 0px;"
									placeholder="All Practice type and All Clients"
									data-provide="typeahead" autocomplete="off">
								<div style="position: relative; margin-right: 2px;">
									<select name="type" class="custom-select-arrow"
										style="border: solid 1px #cecece; margin-bottom: 0px; line-height: 24px; height: 24px; padding: 0px 6px 0px 4px; border-radius: 2px; width: 77px;">
										<option @if(request('type')== 'all'){{ 'selected' }}@endif
											value="all">All</option>
										<option @if(request('type')==
											'Practices'){{'selected' }}@endif value="Practices">Practice</option>
										<option @if(request('type')==
											'Patients'){{ 'selected' }}@endif value="Patients">Patient</option>
									</select> <span class="fa fa-caret-down"
										style="position: absolute; top: 5px; right: 5px; color: #666; font-size: 14px;"></span>
								</div>
								<div class="input-group-append"
									style="height: 26px; background-color: #fff; color: #fff !important; margin: 0px; border-radius: 0px 13px 13px 0px;">
									<button type="submit" class="btn bg-blue-txt-wht btn-circle"
										style="border-radius: 50%; width: 26px; text-align: center; height: 26px; padding: 0px; transform: scale(0.8);">
										<i class="fa fa-search" style="line-height: 24px;"></i>
									</button>
								</div>
							</div>
						</form>
						@else
						<div class="input-group"
							style="max-width: 420px; display: flex; align-items: center; border-radius: 13px; background-color: #fff; padding-left: 17px; padding-right: 2px; border-radius: 24px; max-height: 30px;">
							<div class="form-control cnt-center"
								style="line-height: 1.2em !important; height: 26px; border: 0px; padding-left: 0px;">
								<span class="elm-left">
									{{Session::get('practice')->practice_type}} </span> <span>
									{{Session::get('practice')->practice_name}} {{ Session::get('practice')->branch_name?"(".Session::get('practice')->branch_name.")":'' }} </span> <span
									class="elm-right">
									{{Session::get('practice')->practice_phone_number}}</span>
							</div>
							<button type="submit" class="btn btn-default btn-circle"
								style="background-color: #3a7ec4; color: #fff; border-radius: 50%; width: 26px; text-align: center; height: 26px; padding: 0px; transform: scale(0.8);">
								<i onclick="window.location.href = '{{url("update-session-practice/")}}'" class="fa fa-window-close"
									style="cursor: pointer; line-height: 24px"></i>
							</button>
						</div>
						@endif
						@can('view menu profit_check')
                                               
					<div class="text-sline ml-7_"
						style="display: flex; align-items: center; justify-content: flex-end;">
							<nav class="navbar " style="margin-left: auto;justify-content: flex-end;">
                                <ul class="nav nav_state nav-tabs txt-wht-child" style="float: right;">
                                	<li class="nav-item">
                                		<a class="nav-link profit-check-modal-link" data-toggle="modal" data-target="#profit-check-Modal">Rx PROFIT CHECK</a>
                                	</li>
                                	<li class="nav-item watchvideo-in-topnav">
                                		<a class="watch-video-bar" data-toggle="modal" data-target="#video-play-Modal">
                                			<span class="fa fa-play fs-14_ bg-red txt-white wvb-video-ico_"></span>
                                			<div class="tt_cc_ ml-14_ fs-18_ tt_cc_ wvb-heading">watch video</div>
                                		</a>
                                	</li>
                                </ul>
                            </nav>
					</div>
                                               
					@endcan
					</div>
					@endcan

			@if(auth()->user()->hasrole('practice_admin'))
					<div class="text-sline right-col-header ln-348"
						style="display: flex; align-items: center; justify-content: flex-end; margin-left:auto">
							<nav class="navbar " style="margin-left: auto;justify-content: flex-end;">
                                <ul class="nav nav_state nav-tabs txt-wht-child" style="float: right;">
                                	<li class="nav-item">
                                		<a class="nav-link profit-check-modal-link" data-toggle="modal" data-target="#profit-check-Modal">Rx PROFIT CHECK</a>
                                	</li>
                                	<li class="nav-item watchvideo-in-topnav">
                                		<a class="watch-video-bar" data-toggle="modal" data-target="#video-play-Modal">
                                			<span class="fa fa-play fs-14_ bg-red txt-white wvb-video-ico_"></span>
                                			<div class="tt_cc_ ml-14_ fs-18_ tt_cc_ wvb-heading">watch video</div>
                                		</a>
                                	</li>
                                </ul>
                            </nav>
					</div>
					@endif


				</div>
			</div>
		</div>
	</div>

</header>
<!-- End: Header Section -->

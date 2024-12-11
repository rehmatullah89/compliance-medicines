<header class="site-header">
	<div class="container">
		<div class="row mt-7_">
			<div class="col-sm-12">

				<div class="trow_"
					style="display: flex; justify-content: flex-start;">
					<div class="elm-left" style="display: flex; align-items: center;">
						<a class="navbar-brand" href="{{url('')}}"> <img
							src="{{asset('images/logo.png')}}"
							alt="Site Logo">
						</a> <span
							class="page-top-left-title txt-gray-9a-force-child tt_uc_">

							@if(isset(auth()->user()->roles[0]->name))

							@if(auth()->user()->roles[0]->name == 'practice_admin')
							{{auth()->user()->practice->practice_name}} | {!!
							ucfirst(str_replace("_"," ",auth()->user()->roles[0]->name)) !!}
							@else @if(auth()->user()->roles[0]->name == 'compliance_admin')

							ALL ACCESS @elseif(auth()->user()->roles[0]->name == 'practice_super_group') Practice Super Group  @else {!! ucfirst(str_replace("_","
							",auth()->user()->roles[0]->name)) !!} @endif @endif @endif </span>
					</div>
					<div class="elm-right"
						style="display: flex; align-items: center; justify-content: flex-end; margin-left: auto;">
						<span class="user-photo mr-4_"> <img
							src="{{asset('images/user-photo.png')}}"
							style="border-radius: 50%; max-height: 39px; border: solid 1px #eee;" />
						</span>
						<div class="dropdown">
							<a class="dropdown-toggle weight_700 fs-17_"
								data-toggle="dropdown"> Hello, <span class="txt-blue fs-17_"><?php echo e(auth::user()->name); ?></span>
							</a>
							<div class="dropdown-menu">
								<a class="dropdown-item" href="#">Profile</a> <a
									class="dropdown-item" href="#">Settings</a> <a
									class="dropdown-item"
									onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
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
				<div class="row">
					<div class="col-sm-6">
						<nav class="navbar pa-0_">
							<ul class="nav nav_state nav-tabs txt-wht-child">
								@hasanyrole('compliance_admin|practice_super_group')
								<li class=@if(strpos(url()->current(),'report') == false && strpos(url()->current(),'orders') == false)
									'nav-item active' @else 'nav-item' @endif><a class="nav-link"
									href="{{url('overview')}}">DASHBOARD</a>
								</li>
								<li class=@if(strpos(url()->current(),'report') !== false && strpos(url()->current(),'orders') == false)
									'nav-item active' @else 'nav-item' @endif><a class="nav-link"
									href="{{url('report/user-statistics')}}">REPORTS</a>
								</li>
								<li
								class="nav-item @php if( (request()->is('orders') || request()->is('specific-patient-orders/*')) ) { echo 'active'; } @endphp"><a
								href="{{url('orders')}}" class="nav-link">PATIENT REQUESTS</a>
							</li>
							@endhasanyrole @hasrole('practice_admin')
								<li
									class="nav-item @php if(request()->is('patient/*') || request()->is('patient') ) { echo 'active'; } @endphp"><a
									class="nav-link" href="{{url('patient')}}">ENROLL/SEARCH</a></li>
								<li
									class="nav-item @php if( (request()->is('orders') || request()->is('specific-patient-orders/*')) ) { echo 'active'; } @endphp"><a
									href="{{url('orders')}}" class="nav-link">PATIENT REQUESTS</a>
								</li>
								<li
									class="nav-item @php if(request()->is('*/accounting') ) { echo 'active'; } @endphp"><a
									class="nav-link" href="{{url('report/accounting')}}">REPORTS</a>
								</li>
								{{-- <li class="nav-item dropdown" id="priceDropdwon"><a
									class="nav-link dropdown-toggle" href="#" role="button"
									id="dropdownMenuLink" data-toggle="dropdown"
									aria-haspopup="true" aria-expanded="false"
									style="background-color: transparent;"> Rx PROFIT CHECK </a>

									<div id="profit_ui-content" class="dropdown-menu"
										aria-labelledby="dropdownMenuLink" x-placement="bottom-start"
										style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 38px, 0px); padding: 0px; margin-top: -2px;">


										<div class="bg-grn-lk txt-black-childs pa-7_"
											style="max-width: 240px;">

											<div class="trow_ mb-6_">
												<div class="bg-white pa-4_"
													style="width: 160px; border: solid 3px #457597;">
													<div class="trow cnt-center tt_uc_ txt-gray-9">patient
														co-pay</div>
													<div
														class="trow txt-black-24 mt-2_ weight_600 fs-17 cnt-right">
														<input class="txt-black-24 weight_600 cnt-right" id="pop"
															value="" style="border: 0px;"
															onblur="window.pharmacyNotification.drugMultipliaction($('#drug_qty').val());"
															data-type='currency'>
													</div>
												</div>
											</div>

											<div class="trow_ mb-6_">
												<div class="bg-white pa-4_"
													style="width: 160px; border: solid 3px #457597;">
													<div class="trow cnt-center tt_uc_ txt-blue">3rd Party Paid</div>
													<div class="trow txt-blue weight_600 fs-17 cnt-right">
														<input class="txt-black-24 mt-2_ weight_600 cnt-right"
															id="tpp" value="" style="border: 0px;"
															onblur="window.pharmacyNotification.drugMultipliaction($('#drug_qty').val());"
															data-type='currency'>
													</div>
												</div>
											</div>

											<div class="trow_ c-dib_ mb-6_">
												<div class="bg-white pa-4_"
													style="width: 140px; border: solid 3px #ec1717;">
													<div class="trow cnt-center tt_uc_ txt-red">pkg ingr cost</div>
													<div class="trow mt-2_ txt-red weight_600 fs-17 cnt-right">
														<input class="trow_ txt-red weight_600 cnt-right" id="pic"
															value="" style="border: 0px;"
															onblur="window.pharmacyNotification.drugMultipliaction($('#drug_qty').val());"
															data-type='currency'>
													</div>
												</div>
												<div class="bg-white pa-4_"
													style="width: 80px; border: solid 3px #ec1717;">
													<div class="trow cnt-center tt_uc_ txt-red">pkg SIZE</div>
													<div class="trow mt-2_ txt-red weight_600 fs-17 cnt-right">
														<input class="trow_ txt-red weight_600 cnt-right" id="psize"
															value="" style="border: 0px;"
															onblur="window.pharmacyNotification.drugMultipliaction($('#drug_qty').val());"
															data-type='currency'>
													</div>
												</div>
											</div>

											<div class="trow mb-6 ">
												<div class="flx-justify-start " style="align-items: center;">

													<div class="bg-white pa-4_"
														style="width: 80px; border: solid 3px #457597;">
														<div class="trow_ cnt-center txt-black-24">Quantity</div>
														<div
															class="trow txt-black-24 weight_600 mt-2_ fs-17 cnt-right">
															<input class="txt-black-24 weight_600 cnt-right"
																id="drug_qty" style="border: 0px; max-width: 100%;"
																onblur="window.pharmacyNotification.drugMultipliaction(this.value);">
														</div>
													</div>

													<div class="bg-transparent pa-4_" style="width: 80px;">
														<div class="trow_ cnt-center weight_600 txt-black-24" style="color: yellow">$1.024</div>
														<div class="trow_ txt-black-24 cnt-center" style="color: yellow">per unit</div>
													</div>

													<div class="bg-transparent pa-4_" style="width: 100px;">
														<div class="trow_ cnt-center fs-17_"
															style="color: #457597;" id="rx_ing_cost"></div>
														<div class="trow weight_600 fs-12 cnt-right"
															style="color: #457597;">Rx ING Cost</div>
													</div>

												</div>

											</div>

											<div class="trow_ mb-6_">
												<div class="flx-justify-end " style="align-items: center;">

													<div class="bg-transparentpa-6_" style="width: 90px;">
														<div class="trow txt-wht fs-24 weight_600 cnt-right"
															id="rx_profit1"></div>
														<div
															class="trow txt-wht weight_600 fs-17 tt_uc_ cnt-right">rx
															profit</div>
													</div>

													<div class="bg-transparent pa-6_ cnt-right"
														style="width: 40px; display: flex; align-items: center;">
														<span class="fs-17_ txt-black-24 fa fa-check-circle "
															id="rx_profit" style=""></span>
													</div>
												</div>
											</div>

										</div>
									</div></li>--}} @endhasrole
</ul>
						</nav>
					</div>
					@hasanyrole('compliance_admin|practice_super_group')
					<div class="col-sm-6"
						style="display: flex; align-items: center; justify-content: flex-end;">

						@if(!Session::has('practice'))
						<form action="{{ url('admin/search-all') }}" method="post"
							class="compliance-form_ trow_ elm-right mb-0_"
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
									{{Session::get('practice')->practice_name}} </span> <span
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
					</div>
					@endhasanyrole
				</div>
			</div>
		</div>
	</div>

</header>
<!-- End: Header Section -->

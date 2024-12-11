@extends('layouts.compliance')

@section('content')


<script>  var no_data; </script>
<div class="row" style="border-bottom: solid 1px #cecece;">
        <div class="col-sm-12">
                <h4 class="elm-left fs-24_ mb-4_">Client Dashboard</h4>
                <div class="date-time elm-right">{{  now('America/Chicago')->isoFormat('LLLL') }}</div>
        </div>
</div>

<div class="row client-dashboard-blade">
    <div class="col-sm-12">
        <div class="row mt-17_">
            <div class="col-sm-12">
                <ul class="nav nav-tabs reports-tabs">
                    <li class="nav-item"><a class="nav-link @if( (Request::has('report_type')) or (!Request::has('report_type') and !Request::has('web_stat'))) {{ 'active' }} @endif" data-toggle="tab" href="#practice-reports">Practice Reports</a></li>
                    <li class="nav-item"><a class="nav-link  @if(Request::has('web_stat')  )  {{ 'active' }} @endif" data-toggle="tab" href="#web-que-stats">Web Queue Statistics</a></li>
                </ul>


                <div class="tab-content" style="border: solid 1px #dee2e6; margin-top: -1px;">
                    <div id="practice-reports" class="container tab-pane fade @if( (Request::has('report_type'))  or (!Request::has('report_type') and !Request::has('web_stat')) ) {{ 'in active show' }} @endif" style="min-width: 100%; max-width: 100%;">
                        <div class="row pt-17_ mb-7_">
                            <div class="col-sm-12">
                                <form action="{{ url('report/client_dashboard') }}" id="main_reports" name="main_reports" method="post" class="trow_ c-dib_ compliance-form_" style="display: flex;">
                                    {{ csrf_field() }}
                                    <!-- <input type="hidden" id="menustate" name="mstate" value="<?= Request::input('mstate') ?>" > -->
                                    <div class="field wd-100p fld-practice-reports mr-14_ pos-rel_" style="max-width: 290px;">
                                        <label class="wd-100p">Practice Reports</label>

                                        <select class="wd-100p custom-select-arrow" required name="report_type" id="report_type">
                                            <option value="">Select Report</option>
                                            <option daysType="future" @if(Request::has('report_type') and Request::get('report_type')=='rx_refill_due_and_remaining'){{ 'selected' }} @endif value="rx_refill_due_and_remaining" >Rx's with Refills Due Soon &amp; Refills Remaining</option>
                                            <option daysType="past"  @if(Request::has('report_type') and Request::get('report_type')=='top_products_sale'){{ 'selected' }} @endif value="top_products_sale" >Top Products by Sales</option>
                                            <option daysType="past" @if(Request::has('report_type') and Request::get('report_type')=='product_profitablity'){{ 'selected' }} @endif value="product_profitablity" >Top Products by Profitability</option>
                                            <option daysType="past" @if( (Request::has('report_type') and Request::get('report_type')=='all_cwp_activity') ){{ 'selected' }}  @endif value="all_cwp_activity" >All Compliance Reward Program Activity</option>
                                            <option daysType="past" @if(Request::has('report_type') and Request::get('report_type')=='most_referrals'){{ 'selected' }} @endif value="most_referrals" >Most / Least Program Referrals</option>
                                            <option daysType="past" @if(Request::has('report_type') and Request::get('report_type')=='all_users'){{ 'selected' }} @endif value="all_users" >All Practice Users Report</option>
                                            <option daysType="past" @if(Request::has('report_type') and Request::get('report_type')=='patient_out_pocket'){{ 'selected' }} @endif value="patient_out_pocket" >Rx Patient Out Of Pocket</option>
                                            <option daysType="past" @if(Request::has('report_type') and Request::get('report_type')=='zero_refill_remaining'){{ 'selected' }} @endif value="zero_refill_remaining" >Rx's with 0 Refills Remaining</option>
                                            <option daysType="future" @if(Request::has('report_type') and Request::get('report_type')=='rx_near_expiration'){{ 'selected' }} @endif value="rx_near_expiration" >Rx's Near Expiration</option>
                                        </select>
                                        <span class="fa fa-caret-down" style="position: absolute;top: 29px;right: 9px;"></span>
                                    </div>
                                    <div class="field wd-100p fld-time period mr-14_ pos-rel_" style="max-width: 140px;">
                                        <label style="@if(!Request::has('number_of_days') ) {{ 'display:none;' }} @endif" class="wd-100p" id="time_lab">Select Time Period</label>
                                        <select required class="wd-100p future_drop custom-select-arrow" name="number_of_days" id="future_dop" @if(Request::has('report_type') and (Request::get('report_type')=='rx_refill_due_and_remaining'||Request::get('report_type')=='rx_near_expiration' ) and Request::has('number_of_days')){{ 'disp=yes style=display:block;' }} @else {{ 'style=display:none;' }} @endif>
                                            <option value="">Select Time Period</option>
                                            <option @if(Request::get('report_type')=='rx_refill_due_and_remaining' and Request::get('number_of_days')==3){{ 'selected' }} @endif  value="3">Next 3 Days</option>
                                            <option @if(Request::get('report_type')=='rx_refill_due_and_remaining' and Request::get('number_of_days')==6){{ 'selected' }} @endif  value="6">Next 6 Days</option>
                                            <option @if(Request::get('report_type')=='rx_refill_due_and_remaining' and Request::get('number_of_days')==15){{ 'selected' }} @endif  value="15">Next 15 Days</option>
                                            <option @if(Request::get('report_type')=='rx_refill_due_and_remaining' and Request::get('number_of_days')==30){{ 'selected' }} @endif  value="30">Next 30 Days</option>
                                            <option @if(Request::get('report_type')=='rx_refill_due_and_remaining' and Request::get('number_of_days')==90){{ 'selected' }} @endif  value="90">Next 90 Days</option>
                                            <option @if(Request::get('report_type')=='rx_refill_due_and_remaining' and Request::get('number_of_days')=='all_activity'){{ 'selected' }} @endif  value="all_activity">ALL ACTIVITY</option>
                                        </select>

                                        <select required class="wd-100p past_drop custom-select-arrow" name="number_of_days" id="number_of_days" @if( (Request::has('report_type') and Request::get('report_type')!='rx_refill_due_and_remaining' and Request::get('report_type')!='rx_near_expiration' and Request::has('number_of_days')) ){{ 'disp=yes style=display:block;' }} @else {{ 'style=display:none;' }} @endif">
                                            <option value="">Select Time Period</option>
                                            <option @if(Request::get('report_type')!='rx_refill_due_and_remaining' and Request::get('number_of_days')==1){{ 'selected' }} @endif value="1">Now</option>
                                            <option @if(Request::get('report_type')!='rx_refill_due_and_remaining' and Request::get('number_of_days')==7){{ 'selected' }} @endif value="7">Past 7 Days</option>
                                            <option @if(Request::get('report_type')!='rx_refill_due_and_remaining' and Request::get('number_of_days')==15){{ 'selected' }} @endif value="15">Past 15 Days</option>
                                            <option @if(Request::get('report_type')!='rx_refill_due_and_remaining' and Request::get('number_of_days')==30){{ 'selected' }} @endif value="30">Past 30 Days</option>
                                            <option @if(Request::get('report_type')!='rx_refill_due_and_remaining' and Request::get('number_of_days')==90){{ 'selected' }} @endif value="90">Past 90 Days</option>
                                            <option @if(Request::get('report_type')!='rx_refill_due_and_remaining' and Request::get('number_of_days')==180){{ 'selected' }} @endif value="180">Past 180 Days</option>
                                            <option @if(Request::get('report_type')!='rx_refill_due_and_remaining' and Request::get('number_of_days')==360){{ 'selected' }} @endif value="360">Past 360 Days</option>
                                            <option @if(Request::get('report_type')!='rx_refill_due_and_remaining' and Request::get('number_of_days')=='all_activity'){{ 'selected' }} @endif  value="all_activity">ALL ACTIVITY</option>
                                        </select>
                                        <span class="fa fa-caret-down" id="select-dependent" style="position: absolute;top: 29px;right: 9px; display:none;"></span>

                                    </div>
                                    <img id="loading_small_img_one" src="{{ url('images/small_loading.gif') }}" style="width: 40px;margin-top: 15px;display: none;margin-left: 30px;">
                                </form>
                            </div>
                        </div>
                        
                        <div id="report_type_table_area">
                            @include('all_access.includes.all_reports_cd')
                        </div>
                    </div>
                    
                    
                    
                    <div id="web-que-stats" class="container tab-pane fade  @if(Request::has('web_stat')) {{ 'in active show' }} @endif " style="min-width: 100%; max-width: 100%;">
                        <div class="row pt-17_ mb-7_">
                            <div class="col-sm-12">
                                <form action="{{ url('report/client_dashboard') }}" id="web_stat_form" name="web_stat_form" method="post" class="trow_ c-dib_ compliance-form_" style="display: flex;">
                                    {{ csrf_field() }}
                                    <div class="field wd-100p fld-practice-reports mr-14_" style="max-width: 200px;">
                                        <label class="wd-100p">Web Queue Statistics</label>

                                        <select class="wd-100p" required name="web_stat" id="web_stat">
                                            <option value="">Select Report</option>
                                            <option @if(Request::has('web_stat') and Request::get('web_stat')=='referrals_generated'){{ 'selected' }} @endif value="referrals_generated" >RX REFERRALS GENERATED</option>
                                            <option  @if(Request::has('web_stat') and Request::get('web_stat')=='completed_enrollments'){{ 'selected' }} @endif value="completed_enrollments" >COMPLETED ENROLLMENTS</option>
                                            <option @if(Request::has('web_stat') and Request::get('web_stat')=='payments_made'){{ 'selected' }} @endif value="payments_made" >PAYMENTS MADE</option>
                                            <option @if(Request::has('web_stat') and Request::get('web_stat')=='member_questions'){{ 'selected' }} @endif value="member_questions" >MEMBER QUESTIONS</option>
                                            <option @if(Request::has('web_stat') and Request::get('web_stat')=='refill_reminders'){{ 'selected' }} @endif value="refill_reminders" >REFILL REMINDERS SENT</option>
                                            <option @if(Request::has('web_stat') and Request::get('web_stat')=='refill_requests'){{ 'selected' }} @endif value="refill_requests" >REFILL REQUESTS MADE</option>
                                        </select>
                                    </div>
                                    <div class="field wd-100p fld-time period mr-14_" id="duration_div" style="max-width: 140px; @if(!Request::has('duration')) {{ 'display:none;' }} @endif">
                                        <label class="wd-100p">Select Time Period</label>
                                        <select class="wd-100p" name="duration" required="" id="duration">
                                            <option value="">Select Time Period</option>
                                            <option @if(Request::has('web_stat') and Request::get('duration')==1){{ 'selected' }} @endif  value="1">Now</option>
                                            <option @if(Request::has('web_stat') and Request::get('duration')==7){{ 'selected' }} @endif  value="7">Past 7 Days</option>
                                            <option @if(Request::has('web_stat') and Request::get('duration')==15){{ 'selected' }} @endif  value="15">Past 15 Days</option>
                                            <option @if(Request::has('web_stat') and Request::get('duration')==30){{ 'selected' }} @endif  value="30">Past 30 Days</option>
                                            <option @if(Request::has('web_stat') and Request::get('duration')==90){{ 'selected' }} @endif  value="90">Past 90 Days</option>
                                            <option @if(Request::has('web_stat') and Request::get('duration')==180){{ 'selected' }} @endif  value="180">Past 180 Days</option>
                                            <option @if(Request::has('web_stat') and Request::get('duration')==360){{ 'selected' }} @endif  value="360">Past 360 Days</option>
                                            <option @if(Request::has('web_stat') and Request::get('duration')=='all_activity'){{ 'selected' }} @endif  value="all_activity">ALL ACTIVITY</option>
                                        </select>
                                    </div>
                                    <img id="loading_small_img" src="{{ url('images/small_loading.gif') }}" style="width: 40px;margin-top: 15px;display: none;margin-left: 30px;">
                                </form>
                            </div>
                        </div>

                        <div id="web_que_stats_table">
                            @include('all_access.includes.web_stats_que')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
@include('partials.js.reports_js')
<script type="text/javascript">
    $(document).ready(function(){
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
          var target = $(e.target).attr("href") // activated tab

        });
        
    });

</script>
@endsection

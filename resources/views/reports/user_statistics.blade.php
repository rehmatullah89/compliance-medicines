@extends('layouts.compliance')

@section('content')
<style>
    
    .row.cmp-container-sidebar-menu.fullwidth { padding-right: 14px; }
    
    
    table.dataTable thead th, table.dataTable tfoot th, table.compliance-user-table tr td{
        font-weight: normal;
    }
    
    
    @media (max-width: 1600px) {
    
        #user-statistics-reports {  }
        #user-statistics-reports table {  }
        #user-statistics-reports table th.refill_next {  }
        #user-statistics-reports table th.refills_rem { width: 40px !important; white-space: normal !important; }
        #user-statistics-reports table th.rx_no {  }
        #user-statistics-reports table th.rx_label_name { min-width: 130px; } 
        #user-statistics-reports table th.generic_for { min-width: 120px; }
        #user-statistics-reports table th.qty {  }
        #user-statistics-reports table th.days_suppy { width: 40px !important; white-space: normal !important; } 
        #user-statistics-reports table th.rx_sell_price {  }
        #user-statistics-reports table th.reward_auth {  }
        #user-statistics-reports table th.therap_cat {  }
        
    }
    
    
</style>
<div  class="row" style="border-bottom: solid 1px #cecece;">
    <div class="col-sm-12">
        <h4 class="elm-left fs-24_ mb-4_">User Statistics</h4>
        <div class="date-time elm-right lh-28_ mb-3_">{{  now('America/Chicago')->isoFormat('LLLL') }}</div>
    </div>
</div>
<div id="user-statistics-reports" class="row">
    <!-- <form class="trow_ c-dib_ cnt-center" id="report_form" action="{{ url('report/user-statistics')}}" method="post"> 
         {{ csrf_field() }} -->
         <input type="hidden" id="menustate" name="mstate" value="<?= Request::input('mstate') ?>" >
    <div class="col-sm-12">
        <div class="row mt-17_">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="trow_ c-dib_ mb-7_  cnt-center " style="background-color: #cecece85;padding: 7px;border-radius: 7px;padding-bottom: 0px;">
                            <div class="radi-field mr-14_">
                                <label class="wd-100p cur-pointer cnt-left">
                                    <input class="larged" type="radio" value="1" 
                                           name="number_of_days" @if(isset($_POST['number_of_days']) && $_POST['number_of_days'] == '1') {{  'checked' }} @else  {{''}}  @endif > <span class="txt-black-24 ml-force-0_">Past 1 Day</span> </label>
                            </div>
                            <div class="radi-field mr-14_">
                                <label class="wd-100p cur-pointer cnt-left">
                                    <input class="larged" type="radio" value="6" name="number_of_days" 
                                           @if(isset($_POST['number_of_days']) && $_POST['number_of_days'] == '6') {{  'checked' }} @endif @if(!isset($_POST['number_of_days'])) {{'checked'}} @endif > <span class="txt-black-24 ml-force-0_" >Past 7 Day</span> </label>
                            </div>
                            <div class="radi-field mr-14_">
                                <label class="wd-100p cur-pointer cnt-left">
                                    <input class="larged" type="radio" value="14" name="number_of_days"
                                           @if(isset($_POST['number_of_days']) && $_POST['number_of_days'] == '14') {{  'checked' }} @else  {{''}}  @endif> <span class="txt-black-24 ml-force-0_">Past 15 Day</span> </label>
                            </div>
                            <div class="radi-field mr-14_">
                                <label class="wd-100p cur-pointer cnt-left">
                                    <input class="larged" type="radio" value="29" name="number_of_days"
                                           @if(isset($_POST['number_of_days']) && $_POST['number_of_days'] == '29') {{  'checked' }} @else  {{''}}  @endif> <span class="txt-black-24 ml-force-0_">Past 30 Day</span> </label>
                            </div>
                            <div class="radi-field mr-14_">
                                <label class="wd-100p cur-pointer cnt-left">
                                    <input class="larged" type="radio" value="89" name="number_of_days"
                                           @if(isset($_POST['number_of_days']) && $_POST['number_of_days'] == '89') {{  'checked' }} @else  {{''}}  @endif> <span class="txt-black-24 ml-force-0_">Past 90 Day</span> </label>
                            </div>
                            <div class="radi-field mr-14_">
                                <label class="wd-100p cur-pointer cnt-left">
                                    <input class="larged" type="radio"  value="179" name="number_of_days"
                                           @if(isset($_POST['number_of_days']) && $_POST['number_of_days'] == '179') {{  'checked' }} @else  {{''}}  @endif> <span class="txt-black-24 ml-force-0_">Past 180 Day</span> </label>
                            </div>
                            <div class="radi-field mr-14_">
                                <label class="wd-100p cur-pointer cnt-left">
                                    <input class="larged" type="radio"  value="364" name="number_of_days"
                                           @if(isset($_POST['number_of_days']) && $_POST['number_of_days'] == '364') {{  'checked' }} @else  {{''}}  @endif> <span class="txt-black-24 ml-force-0_">Past 365 Day</span> </label>
                            </div>
                            <div class="radi-field mr-14_">
                                <label class="wd-100p cur-pointer cnt-left">
                                    <input class="larged" type="radio"  value="all_activity" name="number_of_days"
                                           @if(isset($_POST['number_of_days']) && $_POST['number_of_days'] == 'all_activity') {{  'checked' }} @else  {{''}}  @endif> <span class="txt-black-24 ml-force-0_">All Activity</span> </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-7_">
                    <div class="col-sm-12">
                        <div class="trow_ c-dib_ cnt-center c-mb-14_" id="stats_area_to">
                            <div class="p6-12_ mr-7_" style="border-radius: 24px; border: solid 1px #dee2e6;"> <span class="txt-black-24 fs-13_ mr-4_">{{ $stats[0]->unique_users??'0' }}</span> <span class="txt-gray-6 fs-13_ ">Unique Patients</span> </div>
                            <div class="p6-12_ mr-7_" style="border-radius: 24px; border: solid 1px #dee2e6;"> <span class="txt-black-24 fs-13_ mr-4_">{{ $stats[0]->unique_prescriptions??"0" }}</span> <span class="txt-gray-6 fs-13_ ">Unique Prescriptions</span> </div>
                            <div class="p6-12_ mr-7_" style="border-radius: 24px; border: solid 1px #dee2e6;"> <span class="txt-black-24 fs-13_ mr-4_">$ {{ isset($stats[0]->client_sales)?number_format($stats[0]->client_sales, 2):'0.00' }}</span> <span class="txt-gray-6 fs-13_ ">Client Sales</span> </div>
                            <div class="p6-12_ mr-7_" style="border-radius: 24px; border: solid 1px #dee2e6;"> <span class="txt-black-24 fs-13_ mr-4_">$ {{ isset($stats[0]->client_sales)?number_format($stats[0]->client_profitablility, 2):'0.00' }}</span> <span class="txt-gray-6 fs-13_ ">Client Profitability</span> </div>
                        </div>                         
                    </div>
                </div>
                <div class="row mb-17_" style="border: solid 1px #dee2e6;">
                    <div class="col-sm-12">
                        <div class="row pt-17_">
                            <div class="col-sm-12 compliance-form_" style="display: flex;">
                                    <div class="field wd-100p fld-practice-reports mr-14_ pos-rel_" style="max-width: 240px;">
                                        <label class="wd-100p fs-14_ cnt-left">Select Compliance Reward Category</label>
                                        <select name="Category" id="Category" class="wd-100p custom-select-arrow">
                                            <option value="">DERMATOLOGY</option>
                                            @if($categories)
                                                @foreach($categories as $catId => $cat)
                                                        <option value="{{$cat->major_reporting_cat}}" @if(Request('Category') == $cat->major_reporting_cat ){{ 'selected' }} @endif >{{$cat->major_reporting_cat}} <span class="txt-red">({{$cat->total_sum}})</span></option>                                                    
                                                 @endforeach
                                            @endif    
                                        </select>
                                        <span class="fa fa-caret-down" style="position: absolute;top: 29px;right: 9px;"></span>
                                    </div>
                                <img id="loading_small_img_one" src="{{ url('images/small_loading.gif') }}" style="width: 40px;margin-top: 15px;display: none;margin-left: 30px;">
                                <div style="margin-left: auto;" id="stat_icons">
                    
                     
                                        <form action="{{ url('report/generate') }}" method="post" >
                                            {{ csrf_field()  }}
                                            <input id="cat_hidden" type="hidden" name="category"  />
                                            <input type="hidden" name="report_type" value="user_statistics">
                                            
                                            <input id="days_hidden" type="hidden" name="duration" value="" />
                                           
                                            <button title="Export this report detail in PDF" type="submit"  class="btn clean_" ><span class="fa fa-arrow-circle-o-down txt-blue fs-24_"></span></button>
                                        </form>
                    
                            </div>
                            </div>
                            
                        </div>
                        <div class="row mt-7_ mb-7_ pl-14_ pr-14_">
                            <div class="col-sm-12 table-responsive pb-7_ pr-0 pl-0" id="tables_data">
                                @include('reports.includes.user_statistics_table')
                            </div>
                        </div>
                    </div>
                </div>            
            </div>            
        </div>
    </div>
        <!-- </form> -->
</div>

@endsection

@section('js')
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script>        
        @if(isset($result) && count($result) > 0)
                    $(document).ready(function(){
                        $('.compliance-user-table').DataTable({
                        processing: false,
                        serverSide: false,
                        Paginate: false,
                        lengthChange: false,
                        order:[],
                        bFilter: false,
                        });
                    });
        @endif
        
        
        $(document).ready(function(){
            $('#cat_hidden').val($('select#Category').val());
            $('#days_hidden').val($('input[name="number_of_days"]:checked').val());
                            
           $('input[name="number_of_days"]').change(function(){
               $('#loading_small_img_one').show();
                $.ajax({
                        url: "{{ url ('get_categories_by_post')}}",
                        method: 'post',
                        data:'number_of_days='+$(this).val(),
                        success: function(result){
                            $('#loading_small_img_one').hide();
                             $('#tbodies_data').html('<tr><td style="text-align: center;" colspan="10">No data available in table</td></tr>');
                             $('#stats_area_to').empty().html(result.stats_area_to);
                             $('select#Category').html(result.options);                            
                        },
                        error: function(data){
                            $('#loading_small_img_one').hide();
                        },
                        headers: {
                            'X-CSRF-TOKEN': '<?php echo csrf_token() ?>'
                        }
                });
           });
           $('select#Category').change(function(){
               $('#loading_small_img_one').show();
                $.ajax({
                        url: "{{ url ('report/user-statistics')}}",
                        method: 'post',
                        data:'number_of_days='+$('input[name="number_of_days"]:checked').val()+'&Category='+$(this).val(),
                        success: function(result){
                            $('#loading_small_img_one').hide();
                            $('#tables_data').html(result);  
                            $('#stats_area_to').html($('#stats_area_from').html());
                            $('.compliance-user-table').DataTable({
                                    processing: false,
                                    serverSide: false,
                                    Paginate: false,
                                    lengthChange: false,
                                    order:[],
                                    bFilter: false,
                                 });
                            console.log($('select#Category').val());
                            $('#cat_hidden').val($('select#Category').val());
                            $('#days_hidden').val($('input[name="number_of_days"]:checked').val());
                            $('#stat_icons').show();
                        },
                        error: function(data){
                            $('#loading_small_img_one').hide();
                        },
                        headers: {
                            'X-CSRF-TOKEN': '<?php echo csrf_token() ?>'
                        }
                });
           });
        });
    </script>
@endsection

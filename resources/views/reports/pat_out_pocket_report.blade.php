@extends('layouts.compliance')

@section('content')



<style>

.dataTables_wrapper table.reports-bordered th { padding: 0.3vw !important; padding-left: 14px !important; }
.dataTables_wrapper table.dataTable thead .sorting { background-position: left 4px; }




</style>

<div class="row">
<div class="col-sm-12 col-lg-12">
    <div class="row mt-7_ ml-0 mr-0 " style="border-bottom: solid 1px #cecece;">
            <div class="col-sm-12 pl-0 pr-0">
                <h4 class="elm-left fs-24_ mb-3_">Rx Patient Out Of Pocket</h4>
                <!-- <div class="elm-right">
                    <form action="{{url('reporter/report/pat_out_pocket/download')}}" method="post" class="compliance-form_">
                        {{ csrf_field() }}
                        <input value="@if(Request('from_date')!='' ){{Request('from_date')}}@endif" type="hidden" name="from_date">
                        <input value="@if(Request('to_date')!=''){{Request('to_date')}}@endif" type="hidden" name="to_date">
    				    <button class="btn bg-blue-txt-wht fs-14_ tt_cc_ pa-4_" style="line-height: 14px; padding:6px;" type="submit"  title="Download this report in Excel">Download</button>
                    </form>
    			</div> -->
            </div>
        </div>

        <div class="row mt-17_">
            <div class="col-sm-12">

                <div class="trow_ "> {{-- compliance-tabs all-request-search-fields --}}
                    <form action="" onsubmit="return check_validation();" id="request_filter" name="request_filter" method="post" class="compliance-form_">
                        {{ csrf_field() }}
                        <div class="row mt-7_">
                            <div class="col-sm-12">
                            	<div class="flx-justify-start">                           
                                    <div class="wd-20p mr-1p field-fromdate" style="min-width: 80px;background-color: #fff;">
                                        <div class="form-group mb-10_" style="position: relative;">
                                            <label class="weight_600">From Date</label>
                                            <input style="min-height: 36px;border: solid 1px #aaa;border-radius: 4px;position: relative; z-index: 100; background-color: transparent;" value="@if(Request('from_date')!='' ){{Request('from_date')}}@endif" type="text" autoComplete="off" id="datepicker_from" class="form-control datepicker" name="from_date">
                                            <span onclick="javascript:$('#datepicker_from').datepicker().focus();" class="fa fa-calendar" style="position: absolute;right: 7px;top: 32px;z-index:200;"></span>
                                        </div>
                                    </div>
                                    <div class="wd-20p mr-1p field-todate" style="min-width: 80px; background-color: #fff;">
                                        <div class="form-group mb-10_" style="position: relative;">
                                            <label class="weight_600">To Date</label>
                                            <input style="min-height: 36px;border: solid 1px #aaa;border-radius: 4px;position: relative; z-index: 100; background-color: transparent;" value="@if(Request('to_date')!=''){{Request('to_date')}}@endif" type="text" autoComplete="off" id="datepicker_to" class="form-control datepicker" name="to_date">
                                            <span onclick="javascript:$('#datepicker_to').datepicker().focus();" class="fa fa-calendar" style="position: absolute;right: 7px;top: 32px;z-index:200;"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="wd-11p field-buttons" style="min-width: 170px;display: flex;align-items: flex-end;background-color: white;justify-content: flex-start;">
                                        {{--<label class="wd-100p">&nbsp;</label>--}}
                                        @if(Request::has('submit'))
                                        <button type="button" class="btn bg-red-txt-wht btn-clear_ mb-10_"  style="height: 36px; border-radius:0px;margin-left: 7px;" onclick="window.location=self.location" >Clear</button>
                                        @endif
                                        <button type="submit" name="submit" class="btn bg-blue-txt-wht btn-search_ mb-10_" style="height: 36px; border-radius:0px;margin-left: 7px;">Search</button>
                                         {{-- onclick="resetField()" --}}
                                    </div>
                            </div>
                        </div>
                    </form>
    			</div>

                <div class="row pr-14_ pl-14_">

                    <div class="col-sm-12 pr-0 pl-0 table-responsive">
                        <table class="table reports-bordered mb-4_ reporter_reports" style="min-width:1024px;">
                            <thead>
                                <tr>
                                    <th class="bg-red2 txt-wht" style="min-width: 82px;">Last Fill Patient CoPay</th>
                                    <th class="bg-purple txt-wht" style="min-width: 93px;">Last Fill Insurance Paid</th>
                                    <th class="bg-gr-bl-dk txt-wht">Patient Name</th>
                                    <th class="bg-gray-80 txt-wht">Pharmacy Rx #</th>
                                    <th class="bg-tb-grn-lt2 txt-wht">Refills  Remaining</th>
                                    <th class="bg-gray-1 txt-wht">Rx Label Name</th>
                                    <th class="bg-orange-md txt-wht">Strength</th>
                                    <th class="bg-grn-lk txt-wht">Dosage Form</th>
                                    <th class="bg-tb-cyan txt-wht">Rx Qty</th>
                                    <th class="bg-blue txt-wht">Refillable Next</th>
                                    <th class="bg-orage txt-wht">Rx Expires</th>
                                    <th class="bg-yellow txt-wht">Marketer</th>
                                    <th class="bg-purple-lt txt-wht" style="text-align:right;">GCN_SEQ</th>
                                    <th class="bg-grn-md txt-wht">Major Reporting Category</th>
                                    <th class="bg-dark-blue txt-wht">Minor Reporting Class</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($orders_data)
                                @foreach($orders_data as $orders_data)
                                <tr>
                                    <td class="bg-tb-pink2 txt-black-24 cnt-right">${{ $orders_data->RxPatientOutOfPocket }}</td> 
                                    <td class="bg-purple2 txt-black-24 cnt-right">${{ $orders_data->RxThirdPartyPay }}</td>
                                    <td class="bg-gray-e txt-blue">{{ $orders_data->PatName }}</td>     
                                    <td class="bg-tb-wht-shade2 txt-blue tt_uc_ zero_slashes">{{ $orders_data->RxNumber }}</td>
                                    <td class="bg-grn-lt3 txt-red cnt-center">{{ $orders_data->refillsRemaining }}</td>
                                    <td class="bg-purple2 txt-black-24 cnt-left">{{ $orders_data->rx_label_name }}</td>
                                    <td class="bg-pnk-lt txt-black-24 cnt-left">{{ $orders_data->strength }}</td>            
                                    <td class="bg-tb-grn-lt txt-black-24 tt_uc_ cnt-left">{{ $orders_data->dosage_form }}</td>
                                    <td class="bg-cyan-lt txt-black-24 cnt-left">{{ $orders_data->qty }}</td>
                                    <td class="bg-tb-blue-lt2 txt-black-24">{{ $orders_data->nextRefillDate }}</td>
                                    <td class="bg-tb-orange-lt txt-black-24">{{ $orders_data->RxExpiryDate }}</td>
                                    <td class="bg-tb-grn-lt txt-black-24 tt_uc_ cnt-left">{{ $orders_data->marketer }}</td>
                                    <td class="bg-cyan-lt txt-black-24 cnt-right">{{ $orders_data->gcn_seq }}</td>
                                    <td class="bg-grn-lt2 txt-black-24 cnt-left">{{ $orders_data->major_reporting_cat }}</td> 
                                    <td class="bg-blue-lt2 txt-black-24 cnt-left">{{ $orders_data->minor_reporting_class }}</td>
                                    
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="14" style="text-align:center;">No Record Found</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
</div>
</div>
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> 

<script type="text/javascript">
    $(document).ready(function(){
        @if($orders_data)
        $('.reporter_reports').DataTable({
            processing: false,
            serverSide: false,
            Paginate: false,
            lengthChange: false,
            autoWidth: false,
            order:[],
            bFilter: false,
            aoColumnDefs: [{
                'bSortable': false,
                'aTargets': ['noSort']
            }]
        });
@endif

        $('#datepicker_from').datepicker({
                autoclose: true,
                format: 'mm/dd/yyyy',
                endDate: '+0d',
            }).on('changeDate', function(){
                $('#datepicker_to').datepicker('setStartDate', new Date($(this).val()));
            });
            $('#datepicker_to').datepicker({
                autoclose: true,
                endDate: '+0d',
                format: 'mm/dd/yyyy',
            }).on('changeDate', function(){
                $('#datepicker_from').datepicker('setEndDate', new Date($(this).val()));
            });


    });

</script>
@endsection
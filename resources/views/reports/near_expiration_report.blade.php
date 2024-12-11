@extends('layouts.compliance')

@section('content')


<style>

.dataTables_wrapper table.reports-bordered th { padding: 0.3vw !important; padding-left: 14px !important; }
.dataTables_wrapper table.dataTable thead .sorting { background-position: left 4px; }

table.reports-bordered thead th.select-col_ { padding-left: 0.3vw !important; padding-right:0.3vw !important; vertical-align: middle;}
table.reports-bordered thead th.select-col_ input[type="checkbox"] { margin-right: 0px; }

table.reports-bordered tbody td.select-col_ { vertical-align: middle; }
table.reports-bordered tbody td.select-col_ input[type="checkbox"] { margin-right: 0px; }

table.reports-bordered td.rx-expiry-date {  }
table.reports-bordered td.next-refill-date {  }
table.reports-bordered td.patient-name {  }
table.reports-bordered td.rx-number {  }
table.reports-bordered td.refills-remaining {  }
table.reports-bordered td.rx_label-name {  }
table.reports-bordered td.strength {  }
table.reports-bordered td.dosage-form {  }
table.reports-bordered td.qty_ {  }
table.reports-bordered td.patient-out-pocket {  } 
table.reports-bordered td.rx-third-party-pay {  }
table.reports-bordered td.marketer {  }
table.reports-bordered td.gcn_seq {  }
table.reports-bordered td.maj-report-cat {  }
table.reports-bordered td.minor-report-cat {  }


</style>

<div class="row">
<div class="col-sm-12 col-lg-12">
    <div class="row mt-7_ ml-0 mr-0 " style="border-bottom: solid 1px #cecece;">
            <div class="col-sm-12 pl-0 pr-0">
                <h4 class="elm-left fs-24_ mb-3_">Rx's Near Expiration</h4>
                <!-- <div class="elm-right">
    				<a class="btn bg-blue-txt-wht fs-14_ tt_cc_ pa-4_" style="line-height: 14px; padding:6px;" href="{{ url('reporter/report/near_expiration/download') }}" title="Download this report in Excel">Download</a>
    			</div> -->
            </div>
        </div>

        <div class="row mt-17_">
            <div class="col-sm-12">

                <div class="row pr-14_ pl-14_">
                    <div class="col-sm-12 pr-0 pl-0 table-responsive">
                        <table class="table reports-bordered mb-4_ reporter_reports" style="min-width:1024px;">
                            <thead>
                                <tr>
                                    {{-- <th class="bg-gray-e txt-wht cnt-center select-col_ noSort">
                                        <input value="" type="checkbox" id="selectAll" title="Select All" />
                                    </th> --}}
                                    <th class="bg-orage txt-wht">Rx Expires</th>
                                    <th class="bg-blue txt-wht">Refillable Next</th>
                                    <th class="bg-gr-bl-dk txt-wht">Patient Name</th>
                                    <th class="bg-gray-80 txt-wht">Pharmacy Rx #</th>
                                    <th class="bg-tb-grn-lt2 txt-wht">Refills  Remaining</th>
                                    <th class="bg-gray-1 txt-wht">Rx Label Name</th>
                                    <th class="bg-orange-md txt-wht">Strength</th>
                                    <th class="bg-grn-lk txt-wht">Dosage Form</th>
                                    <th class="bg-tb-cyan txt-wht">Rx Qty</th>
                                    <th class="bg-red2 txt-wht" style="min-width: 82px;">Last Fill Patient CoPay</th>
                                    <th class="bg-purple txt-wht" style="min-width: 84px;">Last Fill Insurance Paid</th>
                                    <th class="bg-yellow txt-wht">Marketer</th>
                                    <th class="bg-purple-lt txt-wht" style="text-align:right;">GCN_SEQ</th>
                                    <th class="bg-grn-md txt-wht" style="min-width: 93px;">Major Reporting Category</th>
                                    <th class="bg-dark-blue txt-wht">Minor Reporting Class</th>
                                </tr>
                            </thead>
                            <tbody>
                                 @if($orders_data)
                                @foreach($orders_data as $orders_data)
                                <tr>
                                    {{-- <td class="bg-gray-e cnt-center select-col_"><input name="selectOrder[]" class="selectBox" value="" type="checkbox" /></td> --}}
                                    <td class="bg-tb-orange-lt txt-black-24 rx-expiry-date">{{ $orders_data->RxExpiryDate }}</td>
                                    <td class="bg-tb-blue-lt2 txt-black-24 next-refill-date">{{ $orders_data->nextRefillDate }}</td>
                                    <td class="bg-gray-e txt-blue patient-name">{{ $orders_data->PatName }}</td>     
                                    <td class="bg-tb-wht-shade2 txt-blue tt_uc_ rx-number zero_slashes">{{ $orders_data->RxNumber }}</td>
                                    <td class="bg-grn-lt3 txt-red cnt-center refills-remaining">{{ $orders_data->refillsRemaining }}</td>
                                    <td class="bg-purple2 txt-black-24 cnt-left rx_label-name">{{ $orders_data->rx_label_name }}</td>
                                    <td class="bg-pnk-lt txt-black-24 cnt-left strength">{{ $orders_data->strength }}</td>            
                                    <td class="bg-tb-grn-lt txt-black-24 tt_uc_ dosage-form cnt-left">{{ $orders_data->dosage_form }}</td>
                                    <td class="bg-cyan-lt txt-black-24 qty_ cnt-left">{{ $orders_data->qty }}</td>
                                    <td class="bg-tb-pink2 txt-black-24 patient-out-pocket cnt-right">${{ $orders_data->RxPatientOutOfPocket }}</td> 
                                    <td class="bg-purple2 txt-black-24 cnt-right rx-third-party-pay">${{ $orders_data->RxThirdPartyPay }}</td>
                                    <td class="bg-tb-grn-lt txt-black-24 tt_uc_ marketer cnt-left">{{ $orders_data->marketer }}</td>
                                    <td class="bg-cyan-lt txt-black-24 cnt-right gcn_seq">{{ $orders_data->gcn_seq }}</td>
                                    <td class="bg-grn-lt2 txt-black-24 cnt-left maj-report-cat">{{ $orders_data->major_reporting_cat }}</td> 
                                    <td class="bg-blue-lt2 txt-black-24 cnt-left minor-report-cat">{{ $orders_data->minor_reporting_class }}</td>
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
        var oTable = $('.reporter_reports').DataTable({
            processing: false,
            serverSide: false,
            Paginate: false,
            lengthChange: false,
            autoWidth: false,
            order:[],
            bFilter: false,
            stateSave: true,
            aoColumnDefs: [{
                'bSortable': false,
                'aTargets': ['noSort']
            }]
        });
         var allPages = oTable.rows().nodes();
        @endif


        $("#selectAll").click(function(){
            $('input.selectBox', allPages).not(this).prop('checked', this.checked);
        });
    });

</script>
@endsection
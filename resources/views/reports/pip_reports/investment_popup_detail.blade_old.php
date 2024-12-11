<form class="modal-content br-rds-4">

<!-- Modal Header -->
        <div class="modal-header pos-rel_">
            <h4 class="modal-title">{{$investor_name}}</h4>
            <button type="button" class="close stick-top-right-circle bw-hover" data-dismiss="modal">&#10006;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body bg-white">
            <div class="row mr-0 ml-0">
                <div class="col-sm-12 pl-0 pr-0 bg-white">
                
                	<table class="bordered-hd-blue-shade">
                		<thead>
                		</thead>
                		<tbody>
                        @if($invest_detail)
                            @foreach($invest_detail as $kOne=>$vOne)
                                <tr>
                                    <td class="txt-blue td_u_force weight_700" colspan="4">{{$kOne}}</td>
                                    <td class="txt-red td_u_force weight_700 cnt-right-force">${{$invt_d[$kOne]->amount_invest}}</td>
                                    </tr>
                                @if($vOne)
                                    @php 
                                    $countA = 1;
                                    @endphp
                                    @foreach($vOne as $kTwo=>$vTwo)

                                        @if($vTwo)
                                        @foreach($vTwo as $kThree=>$vThree)
                                        <tr class="">
                                            @if($countA==1)
                                                <td><a href="#" class="txt-blue td_u_force">{{$vThree['case_no']}}</a></td>
                                                <td class="txt-black-24 tt_uc_ weight_600">{{$vThree['p_name']}}</td>
                                            @else 
                                                <td></td>
                                                <td></td>
                                            @endif
                                            
                                            <td class="td_u_ tt_uc_">{{$vThree['rx_number']}}</td>
                                            <td class="tt_uc_">{{$vThree['pharmacy_name']}}</td>
                                            <td class="td_u_ cnt-left-force">${{$vThree['total_payments']}}</td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    @php $countA++; @endphp
                                    @endforeach
                                @endif
                            @endforeach
                        @endif
    					
    					</tbody>
    				</table>
                    
                </div>
            </div>
        </div>

        <!-- Modal footer >
        <div class="modal-footer">
                <div class="flx-justify-start wd-100p">
                  <button type="button" class="btn bg-red-txt-wht weight_500 fs-14_" data-dismiss="modal">Cancel</button>
                  <button type="button" class="btn ml-14_ bg-blue-txt-wht weight_500 fs-14_">RESET</button>
                  <button type="button" class="btn bg-blue-txt-wht weight_500 fs-14_" style="margin-left: auto;">ADD</button>
              </div>
        </div-->

      </form>
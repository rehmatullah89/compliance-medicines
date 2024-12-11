@extends('layouts.compliance')

@section('content')

<style>


tr.border-less-td td { border: 0px !important; }
.modal-title{ color:white !important; }
tr.collapse.show { display: table-row !important; }
</style>


<div class="row" style="border-bottom: solid 1px #cecece;">
	<div class="col-sm-12 pl-0">
		<h4 class="elm-left fs-24_ mb-3_">RX Investor Table</h4>
		<div class="date-time elm-right lh-28_ mb-3_">{{ now('America/Chicago')->isoFormat('LLLL') }}</div>
	</div>
</div>

<div class="row pt-17_ mb-17_">
	<div class="col-sm-12">
        <div class="trow_ pt-17_">
     		<div class="row ">
    			<div class="col-sm-12 ">
					<div class="row mb-17_ pr-14_ pl-14_">
    					<div class="col-sm-12 mb-17_ pl-0 pr-0 table-responsive">
    						<table class="bordered-hd-blue-shade" border="1" style="border-collapse: collapse;">
    							<thead>
    								<tr>
        								<th class="tt_uc_ weight_500 txt-wht">Investor</th>
        								<th class="tt_uc_ weight_500 txt-wht">address</th>
        								<th class="tt_uc_ weight_500 txt-wht">date of investment</th>
        								<th class="tt_uc_ weight_500 txt-wht">maturity</th>
        								<th class="tt_uc_ weight_500 txt-wht">% apr</th>
        								<th class="tt_uc_ weight_500 txt-wht">amount invested</th>
        							</tr>
    							</thead>
    							<tbody>
                                
                                @if($invest_list)
                                    @foreach($invest_list as $key=>$val)
									<tr>
										<td class="tt_uc_" id="for-loading-{{$val->id}}">
											<!--href="javascript:get_detail({{$val->id}});"-->
											<a href="javascript:void(0);" target-tr="#slide_down_{{$val->id}}" target-id="{{$val->id}}" class="col-sap txt-blue_sh-force td_u_force">{{$val->investor_name}}</a>
											<span class="ml-2_ circle-bgred-colorwht mr-4_">{{$val->totle_order}}</span>
										</td>
										<td>{{$val->investor_address}}, {{$val->investor_city}}, {{$val->investor_state}}, {{$val->investor_zip}}</td>
										<td class="txt-red weight_600">{{Carbon\Carbon::parse($val->created_at)->format('m-d-Y')}}</td>
										<td class="txt-red tt_uc_ weight_600">{{$val->maturity_quarter}}</td>
										<td class="txt-red weight_600">{{$val->interest_apr}}%</td>
										<td class="txt-black-24 cnt-right-force">${{number_format($val->total_invest_amount, 2)}}</td>
									</tr>

									<tr id="slide_down_{{$val->id}}" class="collapse" style=""></tr>


                                    @endforeach
                                @else
                                    <tr>
										<td class="tt_uc_" colspan="6" style="text-align:center">No Record Found</td>
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
</div>

<!--<div class="modal" id="gallison-watson">
    <div class="modal-dialog wd-87p-max_w_700" id="inner-data-div">
      

        
    </div>
  </div> -->


   @endsection

@section('js') 


<script>

$(document).ready(function(){
		$(".col-sap").click(function(){
			var targetid = $(this).attr('target-tr');
			$(targetid).collapse('toggle');
		});
        
        $(".collapse").on('show.bs.collapse', function(){
             var pr_id = $('a[target-tr="#'+$(this).attr('id')+'"]').attr('target-id');   
             $('#for-loading-'+pr_id).append('<img id="loading_small_img_one" src="{{asset('images/loader_trans.gif')}}" style="width: 24px;margin: -10px 0 -10px 10px;">');
        });


		 $(".collapse").on('shown.bs.collapse', function(){
             var pr_id = $('a[target-tr="#'+$(this).attr('id')+'"]').attr('target-id');            
			
			 var where_to_show = this;
			$.ajax({
                url: "{{ url ('report/investment_detail')}}",
                method: 'post',
                data:'invest_id='+pr_id,
                success: function(result){
                    
                    $('#loading_small_img_one').remove();
					$(where_to_show).html(result);
                },
                error: function(data){
                    $('#loading_small_img_one').remove();
                }
            });
		});
	});




function get_detail(id)
{
	$('#for-loading-'+pr_id).append('<img id="loading_small_img_one" src="{{asset('images/loader_trans.gif')}}" style="width: 24px;margin: -10px 0 -10px 10px;">');
    var formData = 'invest_id='+id;
    $.ajax({
				url: "{{ url ('report/investment_detail')}}",
				method: 'post',
				data:formData,
				success: function(result){
					console.log(result);
					$('#slide_down_'+id).html(result);
                   // $('#inner-data-div').html(result);
                   // $("#gallison-watson").modal('show')
				},
				error: function(data){

				}
			});
}
</script>


  @endsection
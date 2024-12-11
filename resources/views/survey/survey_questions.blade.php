@extends('layouts.compliance_survey')

@section('content')

<style>

.container.full_width { min-width: 100%;max-width: 100%;padding-left: 0px;padding-right: 0px; }

.container.survey_container { min-width: 100%;max-width: 100%; }

table.fixed-header-comp { display: flex; flex-flow: column; width: 100%; }

table.fixed-header-comp thead { flex: 0 0 auto; }
table.fixed-header-comp thead tr { width: 100%; display: table; table-layout: fixed;}
table.fixed-header-comp thead tr th { }

table.fixed-header-comp tbody { flex: 1 1 auto; display: block; overflow-y: auto; overflow-x: hidden; }
table.fixed-header-comp tbody tr { width: 100%; display: table; table-layout: fixed;}
table.fixed-header-comp tbody tr td {border-left: medium none;border-bottom: medium none;padding: 0.3vw;}

table.fixed-header-comp.scroll_yes thead { padding-right: 10px; }



@-moz-document url-prefix() {
    table.fixed-header-comp.scroll_yes thead { padding-right: 17px; }
}

</style>


<div class="row">

	<div class="col-sm-12">


        <div class="row bg-gray-f2">
        	<div class="col-sm-12">
        		<div class="container">
        			<h4 class="wd-100p cnt-left fs-20_ pt-14_ pb-7_ mb-3_ txt-blue weight_600">Select Questions:</h4>
        		</div>
        	</div>
        </div>
        
    	
    	
    	<div class="row bg-white">
			<div class="col-sm-12">
				<div class="container">
                	<div class="row mt-24_ mb-17_ pr-14_ pl-14_">
                        <div class="col-sm-12 pr-0 pl-0 table-responsive" style="max-height: 365px; overflow-y: auto;">
                            
                            <form method="POST" id='question_form' action="{{ url('survey/save-questions') }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="survey_id" id="survey_id" value=" {{$survey->id}}" >
                            <table class="table reports-bordered mb-4_ fixed-header-comp <?=count($questions)>12?'scroll_yes':''?>" style="min-width:1024px;">
                                <thead>
                                    <tr>
                                        <th class="bg-gr-bl-dk txt-wht" style='width:50px;'>#</th>
                                        <th class="bg-gray-1 txt-wht" style="width:90px;">Select &nbsp;<input type="checkbox" name='toggle_all' id='toggle_all'></th>
                                        <th class="bg-blue txt-wht" style="width:150px;">Question Type</th>
                                        <th class="bg-gr-bl-dk txt-wht">Question Title</th>
                                        <th class="bg-orage txt-wht" style="width:250px;">Survey Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $count=1; @endphp
                                    @foreach($questions as $question)
                                    <tr>
                                        <td class="bg-tb-pink2 txt-red cnt-center"  style='width:50px;'>{{$count++}}</td>
                                        <td class="bg-tb-wht-shade2 txt-blue cnt-center" style="width:90px;"><input class="checkbox" type="checkbox" name='questionId[]' value="{{$question->id}}"></td>
                                        <td class="bg-tb-blue-lt2 txt-blue cnt-left" style="width:150px;">{{ucfirst($question->input_type)}}</td>
                                        <td class="bg-gray-e txt-blue cnt-left">{{$question->question_title}}</td>
                                        <td class="bg-tb-wht-shade2 txt-gray-6 cnt-left" style="width:250px;"><?=@$surveys[$question->survey_id]?></td>
                                    </tr>
                                    @endforeach
                                    
                                </tbody>
                            </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        <div class="row bg-white">
			<div class="col-sm-12">
				<div class="container">
        
                    <div class="new-action-buttons" style="margin:10px;">
                        <button id="back" class="btn btn-primary save-template">Back</button>
                        <button id="save_btn" class="btn btn-primary save-template">Save & Next</button>
                    </div>
                </div>
            </div>
        </div>
		
		
	</div>
</div>

@endsection


@section('script')
<script>                  
    $("#back").click(function(){
        window.location.href = "{{ url()->previous() }}";
   });
   
   $("#save_btn").click(function(){        
          $("#question_form").submit();
          $("#save_btn").prop("disabled",true);
          $("#toggle_all").prop("disabled",true);
   });
   
    $("#toggle_all").change(function(){  //"select all" change 
	var status = this.checked; // "select all" checked status
	$('.checkbox').each(function(){ //iterate all listed checkbox items
		this.checked = status; //change ".checkbox" checked status
	});
    });
</script>
    
  @endsection

















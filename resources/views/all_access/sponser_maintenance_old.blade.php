@extends('layouts.compliance')
@section('content')

<div class="row" style="border-bottom: solid 1px #cecece;">
							<div class="col-sm-12">
								<h4 class="elm-left fs-24_ mb-4_">Sponsor Maintenance</h4>
								<div class="date-time elm-right">{{  now('America/Chicago')->isoFormat('LLLL') }}</div>
							</div>
						</div>
<div class="row">
	<div class="col-sm-12">
		<div class="row">
			<div class="col-sm-12">
				<div class="elm-left c-mr-4_ mt-7_ mb-7_ fs-17-force-child_">
					<span class="txt-blue weight_700 tt_uc_" style="line-height: 28px;">banners list</span>
				</div>
				<div class="elm-right c-mr-4_ mt-7_ mb-7_ ">
					<button class="btn bg-blue-txt-wht weight_700 fs-14_"
						style="line-height: 23px; padding: .1rem .75rem;">+ Add</button>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 table-responsive">
				<table class="table bordered">
					<thead>
						<tr class="weight_500-force-childs">
							<th class="txt-blue">Sr No.</th>
							<th class="txt-blue">Title</th>
							<th class="txt-blue">Type</th>
							<th class="txt-blue">Position</th>
							<th class="txt-blue">Image</th>
							<th class="txt-blue">Page Location</th>
							<th class="txt-blue">Action</th>
						</tr>
					</thead>
					<tbody>
						@if(isset($banners) && count($banners) > 0)
							@foreach($banners as $val)
								<tr>
								<td>{{$val->id}}</td>
								<td>{{$val->title}}</td>
								<td>{{$val->type}}</td>
								<td>{{$val->position}}</td>
								 @php 
                                    $img_url = str_replace('public', '', url('')); 
                                 @endphp
								<td class="cnt-center-force c-dib_ pt-4_ pb-4_"><img src="{{ $img_url }}{{ Storage::url('app/'.$val->image) }}" style="max-width: 70px;"></td>
								<td>Login Page</td>
								<td class="cnt-center-force c-dib_"><a href="#action-edit" class="mr-3_ hover-black-child_"><span class="fa fa-pencil fs-17_ txt-blue"></span></a><a href="#action-delete" class="ml-3_ hover-black-child_"><span class="fs-17_ txt-red fa fa-trash-o"></span></a></td>
								</tr>
							@endforeach
						@endif
						
						
						
					
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection
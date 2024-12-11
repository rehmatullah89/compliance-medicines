<html>
	<head>
		
		<style>
		hom
		    body { color: #242424; font-family: Arial, sans-serif; }
			
			.wrapper_print { background-color:#d9d9d9; padding: 14px; width:100%;max-width:700px; }
			
			* { margin:0px;padding:0px;box-sizing: border-box; vertical-align: top; font-family: Arial, sans-serif; }
			.trow_ { display: inline-block; width: 100%; }
			.c-dib_ > * { display: inline-block; }
			.c-mr-14 > * { margin-right: 14px; }
			.c-mr-14 > *:last-child { margin-right: 0px; }
			.c-fw-600 >* { font-weight: 600; }
			.c-fw-500 >* { font-weight: 500; }
			.fw-500 { font-weight: 500; }
			.fw-600 { font-weight: 600; }
			.fw-700 { font-weight: 700; }
			
			.fs-40 { font-size: 40px; }
			.fs-24 { font-size: 24px; }
			.fs-19 { font-size: 19px; }
			
			.lh-19 { line-height: 19px; }
			.lh-43 { line-height:43px; }
			
			.d-ib { display: inline-block; }
			
			.pt-7 { padding-top: 7px; }
			.pb-7 { padding-bottom: 7px; }
			.pb-10 { padding-bottom: 7px; }
			.pa-7 { padding: 7px; }
			.mr-14 { margin-right: 14px; }
			
			.fax_prsc_txt { position: relative;  overflow: hidden; }
			.fax_prsc_txt .hd-txt { font-family: Georgia, sans-serif; position: relative; z-index:200; background-color: 
			#d9d9d9; display: inline-block; padding-right: 7px;}
			.fax_prsc_txt .hd-txt > * { font-family: Georgia, sans-serif; }
			.fax_prsc_txt:before { content: ''; position: absolute; left:0px; top:50%; margin-top: -1px; width: 100%; border: dashed 2px #242424; z-index: 100; }
			
			
			.txt-gray-blue { color: #435369; }
			
			.fax_prsc_table { width: 100%; }
			.fax_prsc_table td { width: 50%; }
			
			.txt-left { text-align: left; }
			.txt-center { text-align: center; }
			.txt-right { text-align: right; }
			
			.txt-red { color: #ec1717; }
			
			.txt-sline { white-space: no-wrap; }
			
			.bg-white { background-color: #fff; }
			
			.opcty-87-100 { opacity: 0.7; }
			.opcty-87-100:hover { opacity: 1.0; }
			
			
			.cur-pointer { cursor: pointer; }
			
			.br-rds-6 { border-radius: 6px; }
			.opcty-87 { opacity: 0.87; }
			
			a .svg-ico { height: 24px; width: auto; }
			
			@media  print {
				* {
					-webkit-print-color-adjust: exact; 
				}
			}
			
		</style>
	</head>
	<body onload="window.print();" onfocus="window.close();" onmouseover="window.close();">
		<div class="wrapper_print">
			<div class="trow_ c-dib_ c-mr-14 c-fw-600 c-fw-500">
				<div class="sndr_dtls">{{$pharmacy['practice_name']}}</div>
				<div class="phone_no">{{$pharmacy['practice_phone_number']}}</div>
				<div class="date">{{$data->created_at}}</div>
				<div class="time">13:25</div>
			</div>
			<div class="trow_" style="height:47px;"></div>
			<div class="trow_ fax_prsc_txt lh-43">
				<div class="hd-txt">
					<span class="d-ib fs-40 lh-43 mr-14">FAX</span> <span class="d-ib fs-24 pt-7 lh-43">PRESCRIPTION</span>
				</div>
			</div>
			<div class="trow_" style="height: 24px;"></div>
			<div class="trow_">
				
				<table class="txt-gray-blue fax_prsc_table">
					
					<tr><td class="fw-700 txt-center  fs-19 pb-10" id="patient_id">{{$patient['FirstName']." ".$patient['LastName']}} {{$patient['BirthDate']}}</td><td></td></tr>
					<tr>
						<td class="pb-10 txt-center fs-19" id="dosage_form">{{$data->rx_brand_or_generic." ".$data->dosage_form}}</td>
						<td class=" txt-center txt-sline">
							<span class="lh-19 opcty-87">generic for: </span>
                                                        <span class="fs-19 txt-red" id="generic_for">INDERAL</span></td>
					</tr>

					<tr><td class="pb-10 txt-center fs-19" id="quantity">QTY: {{$data->quantity}} {{$data->refills}} REFILLS</td><td></td></tr>
					<tr><td class="pb-10 txt-center fs-19" id="comment_id">{{$data->dosing_instructions}}</td><td></td></tr>

					<tr>
						<td class="txt-center fs-19" id="pharmacy_id">{{$hcp}}<br><span class="fw-700">{{$pharmacy['practice_name']}}</span>
						</td>
						<td class="" style="vertical-align: middle;">
							<div class="trow_ c-dib_ pa-7 bg-white txt-center c-mr-14 c-fw-600 c-fw-500">
								<a class="opcty-87-100 cur-pointer">
									<svg  class="svg-ico" viewBox="0 0 512 512"><path fill="currentColor" d="M448 192V77.25c0-8.49-3.37-16.62-9.37-22.63L393.37 9.37c-6-6-14.14-9.37-22.63-9.37H96C78.33 0 64 14.33 64 32v160c-35.35 0-64 28.65-64 64v112c0 8.84 7.16 16 16 16h48v96c0 17.67 14.33 32 32 32h320c17.67 0 32-14.33 32-32v-96h48c8.84 0 16-7.16 16-16V256c0-35.35-28.65-64-64-64zm-64 256H128v-96h256v96zm0-224H128V64h192v48c0 8.84 7.16 16 16 16h48v96zm48 72c-13.25 0-24-10.75-24-24 0-13.26 10.75-24 24-24s24 10.74 24 24c0 13.25-10.75 24-24 24z" class=""></path></svg>
								</a>
								<a class="opcty-87-100 cur-pointer">
									<svg class="svg-ico" viewBox="0 0 512 512"><path fill="currentColor" d="M464 4.3L16 262.7C-7 276-4.7 309.9 19.8 320L160 378v102c0 30.2 37.8 43.3 56.7 20.3l60.7-73.8 126.4 52.2c19.1 7.9 40.7-4.2 43.8-24.7l64-417.1C515.7 10.2 487-9 464 4.3zM192 480v-88.8l54.5 22.5L192 480zm224-30.9l-206.2-85.2 199.5-235.8c4.8-5.6-2.9-13.2-8.5-8.4L145.5 337.3 32 290.5 480 32l-64 417.1z" class=""></path></svg>
								</a>
								<a class="opcty-87-100 cur-pointer txt-red">
									<svg class="svg-ico" viewBox="0 0 352 512"><path fill="currentColor" d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z" class=""></path></svg>
								</a>
							</div>
						</td>
					</tr>
					
				</table>
				
			</div>
						
		</div>
	</body>
</html>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Title of the document</title>
<style>
.fs-13-force-child_ { font-size: 13px; }
.fs-zero { font-size: 0px; }
.fs-13-force-child_ * { font-size: 13px !important; }
.fs-16_ { font-size: 16px; }


.c-dib_ > * { display: inline-block; }
.pa-c-14-0_ > * {  padding: 0px 14px;  }
</style>
</head>
<body>
<?php
        $createdAt = explode(' ',$created_at);
?>
<div class="pos-abs_ " style="top: 0px; max-width: 410px; height: 450px; display: block; margin: 40px auto;">
	<div class="trow pa-c-14-0 fs-13-force-child_" style="background-color:  #d9d9d9; padding: 10px; display: inline-block;width: 100%;font-size: 13px;">
            <div style="text-align: center; margin-bottom: 7px;" class="trow c-dib">
			<div  style="float: left;" id="date_created">{{@$createdAt[0]}}</div>
                        <div class="elm-center" style="text-transform: uppercase;">ticket #0058965</div>
                        <div style="float: right;" id="time_created">{{@$createdAt[1]}}</div>
		</div><br/>

            <div  style="display: inline-block; width: 100%; margin-bottom: 2px;">
                <div style="text-align: center; font-weight: 700;" class="trow c-dib fs-16_">
                    <span style="margin-right: 4px;" id="practice_address">{{$practice['practice_name']}} Pharmacy</span>
                                <span style="text-align: left; text-transform: uppercase; font-weight: 500;" class=" fs-13 mb-3" id="pharmacy_address">{{$practice['practice_state']}} {{$practice['practice_zip']}}</span>
			</div>
            </div><br/>

            <div  style="display: inline-block; width: 100%; margin-bottom: 2px;">
                <div style="text-align: center; font-weight: 500;" class="trow c-dib fs-16_">
                    <span style="margin-right: 4px;" id="practice_address">{{$practice['practice_address']}}</span>
                                <span style="text-align: left; text-transform: uppercase; font-weight: 500;" class=" fs-13 mb-3" id="pharmacy_address">{{$practice['practice_state']}} {{$practice['practice_zip']}}</span>
			</div>
		</div>
            <div style="text-align: center;" class="trow c-dib">
                    <div style="text-align: left; margin-right: 4px; font-weight: 500;" class="fs-16 mb-3" id="practice_email">{{$practice['practice_website']}}</div>
                    <div style="text-align: left; text-transform: uppercase; font-weight: 500;" class="fs-13 mb-3" id="practice_phone">{{$practice['practice_phone_number']}}</div>
		</div>
		<div class="trow fs-zero mt-7" style="margin-bottom: 7px; height:0px; border: dashed 1px #3e7bc4;"></div>

                <div  style="display: inline-block; width: 100%;  margin-bottom: 4px;">
			<div  style="float: left; text-transform: uppercase;">1 Rx {{$RxNumber}}</div>
			<div  style="float: right; font-weight: 500;" class="wd-70px cnt-right pr-3_">$ <?=number_format($RxFinalCollect,2)?></div>
		</div><br/>
                <div  style="display: inline-block; width: 100%;  margin-bottom: 4px;">
			<div  style="float: left; text-transform: uppercase;">home delivery</div>
			<div  style="float: right; font-weight: 500;" class="wd-70px cnt-right pr-3_">$ 0.00</div>
		</div><br/>
		<div  style="display: inline-block; width: 100%;  margin-bottom: 4px;">
			<div  style="float: left; text-transform: uppercase;">sales tax(tx)</div>
			<div  style="float: right; font-weight: 500;" class="wd-70px cnt-right pr-3_">$ 0.00</div>
		</div><br/>
                <div class="trow mb-4" style="margin-bottom: 7px;">
			<div  style="float: left; text-transform: uppercase; font-weight: 700;" class="pt-4_">amount due</div>
			<div style="border-top: solid 1px #242424; float: right; font-weight: 700;" id="rx_sale_2" class="wd-70px pt-2_ pr-3_">$ <?=number_format($RxFinalCollect,2)?></div>
		</div><br/>
		<div  style="display: inline-block; width: 100%;">
                    <span style="margin-right: 4px; text-transform: uppercase;">items:</span>
                    <span style="text-transform: uppercase;" id="total_items">{{$Quantity}}</span>
		</div><br/>
		<div  style="display: inline-block; width: 100%;">
                    <span style="margin-right: 4px; text-transform: uppercase;">clerk id:</span>
                    <span style="text-transform: uppercase;">Hassan</span>
		</div><br/>
		<div  style="display: inline-block; width: 100%;">
                    <span style="margin-right: 4px; text-transform: uppercase;">register:</span>
                    <span style="text-transform: uppercase;">Pharmacy department</span>
		</div>
		<div class="trow fs-zero mt-7" style="margin-bottom: 7px; height:0px; border: dashed 1px #3e7bc4;"></div>
		<div  style="display: inline-block; width: 100%;  margin-bottom: 4px;">
			<div  style="float: left; text-align: left;">
                            <span style="text-transform: uppercase;">compliance reward card:</span>
			</div>
			<div  style="float: right;" class="cnt-right">
				<span style="text-transform: uppercase;">xxxx xxxx xxxx</span>
			</div>
		</div><br/>
		<div  style="display: inline-block; width: 100%;">
			<span style="font-weight: 700;">9424</span>
		</div><br/>
		<div  style="display: inline-block; width: 100%; text-align: center;">
                    <span style="margin-right: 4px; text-transform: uppercase; text-align: center;">auth:</span>
                    <span style="text-align: center;">54156</span>
		</div><br/>
		<div  style="display: inline-block; width: 100%; margin-bottom: 7px;">
			<p style="text-transform: uppercase; margin: 0px; text-align: justify; font-size: 9px !important;">i agree to pay the above charges &amp; i certify that i have received the medication(s) referenced by this ticket #; and i authorize all related information necessary for payment purposes </p>
        </div><br/>
        <div style="text-align: center; margin-top: -2px;">
			{{$signature}}
		</div><br/>
                <div style="text-align: center; margin-top: -2px;">
			{{$name}}
		</div><br/>
	</div>
</div>
    
</body>

</html>

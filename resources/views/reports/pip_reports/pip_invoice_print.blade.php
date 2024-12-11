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
@media print {
    div.pos-abs_ {
        background-color: #d9d9d9 !important;
        -webkit-print-color-adjust: exact; 
    }
}
</style>
</head>
<body onload="window.print();" onfocus="window.close();" onmouseover="window.close();" >
<?php
        $createdAt = explode(' ',$created_at);
?>
<div class="pos-abs_ " style="top: 0px; max-width: 325px; height: auto; display: block;/* margin: 40px auto; */">
	<div class="trow pa-c-14-0 fs-13-force-child_" style="background-color:  #d9d9d9; padding: 10px; display: inline-block;width: 100%;font-size: 13px;">
            <div style="text-align: center; margin-bottom: 7px;" class="trow c-dib">
			<div  style="float: left;font-family: Arial;" id="date_created">{{Carbon\Carbon::parse($created_at)->format('M d Y')}}</div>
                        <div style="float: right;font-family: 'Arial', sans-serif;" id="time_created">{{Carbon\Carbon::parse($created_at)->format('H:i')}}</div>
		</div><br/>

            <div  style="display: inline-block; width: 100%; margin-bottom: 2px;font-family: 'Arial', sans-serif;">
                <div style="text-align: center; font-weight: 700;" class="trow c-dib fs-16_">
                    <span style="margin-right: 4px;" id="practice_address">{{$practice['practice_name']}}</span>
                                <!--<span style="text-align: left; text-transform: uppercase; font-weight: 500;" class=" fs-13 mb-3" id="pharmacy_address">{{$practice['practice_state']}} {{$practice['practice_zip']}}</span>-->
			</div>
            </div><br/>

            <div  style="display: inline-block; width: 100%; margin-bottom: 2px;font-family: Arial;">
                <div style="text-align: center; font-weight: 500;" class="trow c-dib fs-16_">
                    <span style="margin-right: 4px;" id="practice_address">{{$practice['practice_address']}}</span>
                                <span style="text-align: left; text-transform: uppercase; font-weight: 500;" class=" fs-13 mb-3" id="pharmacy_address">{{$practice['practice_city']}} {{$practice['practice_state']}} {{$practice['practice_zip']}}</span>
			</div>
		</div>
                <div style="text-align: center;font-family: Arial;" class="trow c-dib">
                    <div style=" margin-right: 4px; font-weight: 500;" class="fs-16 mb-3" id="practice_email">{{$practice['practice_website']}}</div>
                    <div style=" text-transform: uppercase; font-weight: 500;" class="fs-13 mb-3" id="practice_phone">{{$practice['practice_phone_number']}}</div>
		</div>
		<div class="trow fs-zero mt-7" style="margin-bottom: 7px; margin-top: 5px; height:0px; border: dashed 1px #3e7bc4;"></div>
                
                
                <div  style="display: inline-block; width: 100%;  margin-bottom: 4px;">
			<div  style="float: left; text-transform: uppercase;font-family: Arial;">{{$name}}</div>
		</div><br/>
                <div  style="display: inline-block; width: 100%;  margin-bottom: 4px;">
                    <div  style="float: left; text-transform: uppercase;"><strong>Rx #</strong> {{$RxNumber}}<br>
                    <span style="font-size: 11px !important;">{{ $drug['rx_label_name'] }} {{ $drug['strength'] }} {{ $drug['dosage_form'] }}</span>
                    </div>
			<div  style="float: right; font-weight: 500;" class="wd-70px cnt-right pr-3_">$ <?=number_format($RxFinalCollect,2)?></div>
		</div><br/><br/>
                <!-- <div  style="display: inline-block; width: 100%;  margin-bottom: 4px;">
			<div  style="float: left; text-transform: uppercase;">home delivery</div>
			<div  style="float: right; font-weight: 500;" class="wd-70px cnt-right pr-3_">$ 0.00</div>
		</div><br/> -->
		<!--<div  style="display: inline-block; width: 100%;  margin-bottom: 4px;">
			<div  style="float: left; text-transform: uppercase;">sales tax(tx)</div>
			<div  style="float: right; font-weight: 500;" class="wd-70px cnt-right pr-3_">$ 0.00</div>
		</div><br/>-->
                <div class="trow mb-4" style="margin-bottom: 7px;">
			<div  style="float: left; text-transform: uppercase; font-weight: 700;" class="pt-4_">amount due</div>
			<div style="border-top: solid 1px #242424; float: right; font-weight: 700;" id="rx_sale_2" class="wd-70px pt-2_ pr-3_">$ <?=number_format($RxFinalCollect,2)?></div>
		</div><br/>
		<div  style="display: inline-block; width: 100%;">
                    <span style="margin-right: 4px; text-transform: uppercase;">items:</span>
                    <span style="text-transform: uppercase;" id="total_items">1</span>
                    <!-- <span style="text-transform: uppercase;" id="total_items">{{$Quantity}}</span> -->
		</div><br/>
		<!-- <div  style="display: inline-block; width: 100%;">
                    <span style="margin-right: 4px; text-transform: uppercase;">clerk id:</span>
                    <span style="text-transform: uppercase;">Hassan</span>
		</div><br/> -->
		<div  style="display: inline-block; width: 100%;">
                    <span style="margin-right: 4px; text-transform: uppercase;">register:</span>
                    <span style="text-transform: uppercase;">Pharmacy department</span>
		</div>
		<div class="trow fs-zero mt-7" style="margin-bottom: 7px; height:0px; border: dashed 1px #3e7bc4;"></div>
		<div  style="display: inline-block; width: 100%;  margin-bottom: 4px;">
			<div  style="float: left; text-align: left;">
                            <span style="text-transform: uppercase;">payment card:</span>
			</div>
			<div  style="float: right;" class="cnt-right">
				<span style="text-transform: uppercase;">number ending in @if($cardNumber!=''){{ $cardNumber }} @else {{ '' }} @endif</span> 
			</div>
		</div><br/>
		<!-- <div  style="display: inline-block; width: 100%;">
			<span style="font-weight: 700;">@if($cardNumber!=''){{ $cardNumber }} @else {{ 'xxxx' }} @endif <pan>
		</div><br/> -->
		<div  style="display: inline-block; width: 100%; text-align: center;">
                    <span style="margin-right: 4px; text-transform: uppercase; text-align: center;">auth:</span>
                    <span style="text-align: center;">@if(isset($payment_recived) and $payment_recived['auth_number']){{ $payment_recived['auth_number'] }}@else {{ 'xxxx' }} @endif</span>
		</div><br/>
		<div  style="display: inline-block; width: 100%; margin-bottom: 7px;">
			<p style="text-transform: uppercase; margin: 0px; text-align: justify; font-size: 9px !important;">i agree to pay the above charges &amp; i certify that i have received the medication(s) referenced by this ticket #; and i authorize all related information necessary for payment purposes </p>
        </div><br/>
        <div style="text-align: center; margin-top: -2px;">			
                        <img id="PaymentSignature" style="object-fit: cover;/*object-position: 0 -65px;height: 100px;*/width: 100%;" src="{{$signature}}">
		</div><br/>
                <!--<div style="text-align: center; margin-top: -2px;">
			{{$name}}
		</div><br/> -->
	</div>
</div>
</body>

</html>
<script>

</script>

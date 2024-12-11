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

<div class="pos-abs_ " style="top: 0px; max-width: 325px; height: auto; display: block;/* margin: 40px auto; */">
	<div class="trow pa-c-14-0 fs-13-force-child_" style="background-color:  #d9d9d9; padding: 10px; display: inline-block;width: 100%;font-size: 13px;">
            <div style="text-align: center; margin-bottom: 7px;" class="trow c-dib">
			<div  style="float: left;font-family: Arial;" id="date_created">Date: {{date("m/d/Y",strtotime(date('Y-m-d')))}}</div><br/>
			
			<div  style="float: left;font-family: Arial;" id="date_created">Question Title: {{@$patients[0]->Question}}</div><br/>
			<div  style="float: left;font-family: Arial;" id="date_created">Option Title: {{@$patients[0]->optionName}}</div><br/>
			<div  style="float: left;font-family: Arial;" id="date_created">Recipients List</div><br/>
		</div><br/>

            <div  style="display: inline-block; width: 100%; margin-bottom: 2px;font-family: 'Arial', sans-serif;">
                <div style="text-align: center; font-weight: 700;" class="trow c-dib fs-16_">
					@foreach($patients as $key => $patient)
                    <span style="margin-right: 4px;" id="practice_address">{{$key + 1}} - {{$patient->FirstName}}</span><br/>
					@endforeach
				</div>
			</div>
             
	</div>
</div>
</body>

</html>
<script>

</script>

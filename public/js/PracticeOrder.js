/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
window.pharmacyNotification = {
    isEmpty: function (str) {
        return (!str || 0 === str.length);
    },
    isBlank: function (str) {
        return (!str || /^\s*$/.test(str));
    },
   calculateNextRefillDate: function (originDate) {
        // alert(originDate);
        if (this.isEmpty(originDate) || this.isBlank(originDate)) {
            console.log("Original Date is empty.");
            return;
        }
        var daysSupplyFld = $("#daysSupplyFld").val();
        if (this.isEmpty(daysSupplyFld) || this.isBlank(daysSupplyFld)) {
            console.log("Days Supply must be greater than zero.");
            $("#popUpException").text("Please enter days supply.");
            $("#popUpException").attr("style", "color:red; font-weight:bold");
            $("#daysSupplyFld").focus();
            // $('#drug').focus();
            return;
        }
        if (daysSupplyFld == 0) {
            console.log("Days Supply must be greater than zero.");
            $("#popUpException").text("Days supply must be greater than 0.");
            $("#popUpException").attr("style", "color:red; font-weight:bold");
            $("#daysSupplyFld").focus();
            // $('#drug').focus();
            return;
        }
        var date = new Date(originDate);
        var newdate = new Date(date);
        var addday = ($("#daysSupplyFld").val() * 83) / 100;
        addday=Math.round(addday);

        console.log("add day",addday);

        newdate.setDate(newdate.getDate() + parseInt(addday));

        var dd = newdate.getDate();
        var mm = newdate.getMonth() + 1;
        var y = newdate.getFullYear();
        if (dd <= 9) {
            dd = "0" + dd;
        }
        if (mm <= 9) {
            mm = "0" + mm;
        }
        var formattedDate = y + '-' + mm+ '-' + dd;
        $("#nextRefillDate").val(formattedDate);
        this.calculateDrugExpireDate(originDate);
    }, 
    
    calculateDrugExpireDate: function (originDate) {

        console.log("monthRxExpiration " + originDate);
        if (this.isEmpty(originDate) || this.isBlank(originDate)) {
            console.log("Original Date is empty.");
            return;
        }
       var monthRxExpiration = $("#drugRxExpire").val();
       console.log("monthRxExpiration " + monthRxExpiration);
        if (this.isBlank(monthRxExpiration) || this.isEmpty(monthRxExpiration)) {
            console.log("Drug RxExpire Date is empty.");
            monthRxExpiration = 'd';
            // return;
        }
        var date = new Date(originDate);
        var newdate = new Date(date);
        if (monthRxExpiration == "y" || monthRxExpiration == "Y") {
            newdate.setDate(newdate.getDate() + 182);
        } else {
            newdate.setDate(newdate.getDate() + 365);
        }
        var dd = newdate.getDate();
        var mm = newdate.getMonth() + 1;
        var y = newdate.getFullYear();
        if (dd <= 9) {
            dd = "0" + dd;
        }
        if (mm <= 9) {
            mm = "0" + mm;
        }
        var formattedDate = y + '-' + mm+ '-' + dd;
        $("#rxExpiredDate").val(formattedDate);
    },
    
    numberWithCommas:function(x)
    {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

    },
    calculateRxProfitability: function(value,authpop){

        if (this.isEmpty(value) || this.isBlank(value)) {
            console.log("pocketOut is empty.");
            return;
        }
        var thirdPartyPaid = $("#thirdPartyPaid").val();
        if (this.isEmpty(thirdPartyPaid) || this.isBlank(thirdPartyPaid)) {
            console.log("please provide data for thordparty paid");
            $("#popUpException").text("please provide data for thordparty paid.");
            $("#popUpException").attr("style", "color:red; font-weight:bold");
            $("#thirdPartyPaid").focus();
            return;
        }
        if(value.indexOf('$') != -1)
        {
            // value=value.replace("$", "");
            value= value.replace(/(\$|,)/gi, function (x) {
                return "";
              });
        }
        if(thirdPartyPaid.indexOf('$') != -1)
        {
            // thirdPartyPaid=thirdPartyPaid.replace("$", "");
            thirdPartyPaid =  thirdPartyPaid.replace(/(\$|,)/gi, function (x) {
                return "";
              });
        }
        var sellingPrice = parseFloat(value) + parseFloat(thirdPartyPaid);
        console.log(sellingPrice);
        $('#RxSelling').val("$"+this.numberWithCommas(sellingPrice.toFixed(2)));
        $('#RxSelling').attr('readonly',false);

        var drugprice=$('#drugPrice').val();
        
        if(drugprice.indexOf('$') != -1)
        {
            // drugprice=$('#drugPrice').val().replace("$","");
            drugprice=  drugprice.replace(/(\$|,)/gi, function (x) {
                return "";
              });
            console.log(drugprice);
        }
        drugprice = parseFloat(drugprice);
        var assistAuth=$('.fld-assist-auth input[name="asistantAuth"]').val();
        if(authpop)
        {
            assistAuth=authpop;
        }
              if (this.isEmpty(assistAuth) || this.isBlank(assistAuth)) {
        console.log("assist value is set to empty.");
       assistAuth = "0";
    }

        if(assistAuth.indexOf('$') != -1)
        {
            assistAuth=  assistAuth.replace(/(\$|,)/gi, function (x) {
                return "";
              });
            console.log(assistAuth);
        }
        assistAuth = parseFloat(assistAuth);
        var baseFee=0.00;
        if(assistAuth == 0)
        {  
            if($('#fee-auth-zero').val())
            {
                baseFee = parseFloat($('#fee-auth-zero').val());
            }else{
                baseFee = 5.25;
            }
        }else{
            if($('#fee-auth-nonzero').val())
            {
                baseFee = parseFloat($('#fee-auth-nonzero').val());
            }else{
                baseFee = 15.00;
            }
           
        }

        sellingFirst = sellingPrice - assistAuth;
        console.log("baseFee",baseFee);
        sellingSecond = drugprice + baseFee;
        
        /*total = (parseFloat(drugprice) +  parseFloat(value));
        console.log(total);
        console.log(total.toFixed(2));
        total2 = parseFloat(sellingPrice)  - parseFloat(total);
        console.log(total2);
        console.log(total2.toFixed(2));
        console.log($.trim(total2)); */
        total2 = sellingFirst  - sellingSecond;
        if(total2 > 0){
            if(document.getElementById("rxProfitability").classList.contains('txt-red')){
                document.getElementById('rxProfitability').classList.remove('txt-red');
            }
            document.getElementById('rxProfitability').classList.add('txt-grn-lt');
            console.log('test ');
        }else{
            console.log('test fail');
            if(document.getElementById("rxProfitability").classList.contains('txt-grn-lt')){
            document.getElementById('rxProfitability').classList.remove('txt-grn-lt');
            }
            document.getElementById('rxProfitability').classList.add('txt-red');
        }
            $('#rxProfitability').val("$ "+this.numberWithCommas(total2.toFixed(2)));
            total = (parseFloat(drugprice) +  parseFloat(value))
           var activity = parseFloat(total) / parseFloat(value) ;

           $('#activityMultiplier').val(activity.toFixed(2));

       var finalCollect = parseFloat(thirdPartyPaid) + parseFloat(value)
           $('#finalCollect').val(finalCollect.toFixed(2));

    },
    drugMultipliaction:function(value)
{
     console.log(value);
      if(value.indexOf(',') != -1)
    {
        // value=value.replace("$", "");
        value= value.replace(/(\$|,)/gi, function (x) {
            return "";
          });
    } 
    if (this.isEmpty(parseFloat(value)) || this.isBlank(parseFloat(value))) {
        console.log("drug qty is empty.");
        return;
    }

    var drugPrice = $("#pic").val();
     if(drugPrice.indexOf('$') != -1)
    {
        // value=value.replace("$", "");
        drugPrice= drugPrice.replace(/(\$|,)/gi, function (x) {
            return "";
          });
    } 
    if (this.isEmpty(drugPrice) || this.isBlank(drugPrice)) {
        console.log("please provide data for drug price paid");
        $("#pic").focus();
        return;
    }

    var psize = $('#psize').val();
    if (this.isEmpty(psize) || this.isBlank(psize)) {
    console.log('empty package size');

    }else if( parseInt(psize) === 0){

        $('#pkg-div').addClass('order-error');
        $('#rx_ing_cost, #rx_profit1').html('$0.00');
        toastr.remove();
        toastr.clear();
        toastr.error('Package size should be greater than zero');
return;
    }
    else{
        console.log('package size with package size => ',psize);
        $('#pkg-div').removeClass('order-error');
        value = value /  parseInt(psize);
    }
    console.log(drugPrice);
     var totalDrugCost =  value * drugPrice;
     console.log(value);
     console.log(totalDrugCost);
     $('#rx_ing_cost').html("$"+this.numberWithCommas(totalDrugCost.toFixed(2)));
var pop = $('#pop').val();
     if (this.isEmpty(pop) || this.isBlank(pop)) {
        console.log("pocketOut is empty.");
        return;
    }else{
        this.calculateProfit(pop,totalDrugCost);
    }

},
calculateProfit: function(value,totalDrugCost){
    if (this.isEmpty(value) || this.isBlank(value)) {
        console.log("pocketOut is empty.");
        return;
    }
    var thirdpp = $("#tpp").val();
    if (this.isEmpty(thirdpp) || this.isBlank(thirdpp)) {
        console.log("please provide data for thordparty paid");
        $("#popUpException").text("please provide data for thordparty paid.");
        $("#popUpException").attr("style", "color:red; font-weight:bold");
        $("#thirdPartyPaid").focus();
        return;
    }

    if (this.isEmpty($('#drug_qty').val()) || this.isBlank($('#drug_qty').val())) {
console.log('empty qty');
return;
    }

      if (this.isEmpty($('#pic').val()) || this.isBlank($('#pic').val())) {
console.log('empty ing cost');
return;
    }

    if(value.indexOf('$') != -1)
    {
        // value=value.replace("$", "");
        value= value.replace(/(\$|,)/gi, function (x) {
            return "";
          });
    } 
    if(thirdpp.indexOf('$') != -1)
    {
        // thirdPartyPaid=thirdPartyPaid.replace("$", "");
        thirdpp =  thirdpp.replace(/(\$|,)/gi, function (x) {
            return "";
          });
    } 
    var sellingPrice = parseFloat(value) + parseFloat(thirdpp);
    console.log(sellingPrice);
   // $('#RxSelling').val("$ "+this.numberWithCommas(sellingPrice.toFixed(2)));
    var drugcost = totalDrugCost;

    // if(drugcost.indexOf('$') != -1)
    // {
    //     // drugprice=$('#drugPrice').val().replace("$","");
    //     drugcost=  drugcost.replace(/(\$|,)/gi, function (x) {
    //         return "";
    //       });
    //     console.log(drugcost);
    // } 
    ////////////////////////////////////////////////////////////
    var assistAuth=0,baseFee=0.00;
    if(assistAuth == 0)
    {  
        $.ajax({
          url:base_url+"/get_base_fee",
          method: 'GET',
          async: false,
          success:function(response){
            console.log(response);
             if(response.data.base_fee)
            {
                console.log(response.data.base_fee);
                baseFee = response.data.base_fee;
            }else{
                console.log("null");
                baseFee = 5.25;
            }
          },
          error:function(error){
            console.log(error);
          }
        });
    }
    sellingFirst = sellingPrice - assistAuth;
    console.log("baseFee",baseFee);
    sellingSecond = drugcost + baseFee;

    total2 = sellingFirst  - sellingSecond;

    ///////////////////////////////////////////////////////////

    /* I comment this old calculation
     total = (parseFloat(drugcost) +  parseFloat(value));
     console.log(total.toFixed(2));
    total2 = parseFloat(sellingPrice)  - parseFloat(total);
    End of I comment this old calculation */
    console.log($.trim(total2));
   if(total2 > 0){
        if(document.getElementById("rx_profit").classList.contains('txt-red')){
            document.getElementById('rx_profit').classList.remove('txt-red');
        }
        if(document.getElementById("rx_profit").classList.contains('custom-red-cross-btn')){
            document.getElementById('rx_profit').classList.remove('custom-red-cross-btn');
        }
        document.getElementById('rx_profit').classList.add('custom-green-tick-btn');
        console.log('test ');
    }else{
        console.log('test fail');
      /*  if(document.getElementById("rx_profit").classList.contains('txt-grn-lt')){
        document.getElementById('rx_profit').classList.remove('txt-grn-lt');
       
        }*/
        if(document.getElementById("rx_profit").classList.contains('custom-green-tick-btn')){
            document.getElementById('rx_profit').classList.remove('custom-green-tick-btn');
        }
        document.getElementById('rx_profit').classList.add('custom-red-cross-btn');
    }
        $('#rx_profit1').html("$"+this.numberWithCommas(total2.toFixed(2)));


},
calculateProfit_back_16_jun_20: function(value,totalDrugCost){
    if (this.isEmpty(value) || this.isBlank(value)) {
        console.log("pocketOut is empty.");
        return;
    }
    var thirdpp = $("#tpp").val();
    if (this.isEmpty(thirdpp) || this.isBlank(thirdpp)) {
        console.log("please provide data for thordparty paid");
        $("#popUpException").text("please provide data for thordparty paid.");
        $("#popUpException").attr("style", "color:red; font-weight:bold");
        $("#thirdPartyPaid").focus();
        return;
    }

    if (this.isEmpty($('#drug_qty').val()) || this.isBlank($('#drug_qty').val())) {
console.log('empty qty');
return;
    }

      if (this.isEmpty($('#pic').val()) || this.isBlank($('#pic').val())) {
console.log('empty ing cost');
return;
    }

    if(value.indexOf('$') != -1)
    {
        // value=value.replace("$", "");
        value= value.replace(/(\$|,)/gi, function (x) {
            return "";
          });
    } 
    if(thirdpp.indexOf('$') != -1)
    {
        // thirdPartyPaid=thirdPartyPaid.replace("$", "");
        thirdpp =  thirdpp.replace(/(\$|,)/gi, function (x) {
            return "";
          });
    } 
    var sellingPrice = parseFloat(value) + parseFloat(thirdpp);
    console.log(sellingPrice);
   // $('#RxSelling').val("$ "+this.numberWithCommas(sellingPrice.toFixed(2)));
    var drugcost = totalDrugCost;

    // if(drugcost.indexOf('$') != -1)
    // {
    //     // drugprice=$('#drugPrice').val().replace("$","");
    //     drugcost=  drugcost.replace(/(\$|,)/gi, function (x) {
    //         return "";
    //       });
    //     console.log(drugcost);
    // } 
    total = (parseFloat(drugcost) +  parseFloat(value));
    console.log(total.toFixed(2));
    total2 = parseFloat(sellingPrice)  - parseFloat(total);
    console.log($.trim(total2));
   if(total2 > 0){
        if(document.getElementById("rx_profit").classList.contains('txt-red')){
            document.getElementById('rx_profit').classList.remove('txt-red');
        }
        if(document.getElementById("rx_profit").classList.contains('custom-red-cross-btn')){
            document.getElementById('rx_profit').classList.remove('custom-red-cross-btn');
        }
        document.getElementById('rx_profit').classList.add('custom-green-tick-btn');
        console.log('test ');
    }else{
        console.log('test fail');
      /*  if(document.getElementById("rx_profit").classList.contains('txt-grn-lt')){
        document.getElementById('rx_profit').classList.remove('txt-grn-lt');
       
        }*/
        if(document.getElementById("rx_profit").classList.contains('custom-green-tick-btn')){
            document.getElementById('rx_profit').classList.remove('custom-green-tick-btn');
        }
        document.getElementById('rx_profit').classList.add('custom-red-cross-btn');
    }
        $('#rx_profit1').html("$"+this.numberWithCommas(total2.toFixed(2)));


},

    calculateProfitabilityWithSelling: function(sellingPrice){
        
    var value = $('#pocketOut').val();


    if (this.isEmpty(value) || this.isBlank(value)) {
        console.log("pop is empty.");
        return;
    }
    var thirdPartyPaid = $("#thirdPartyPaid").val();
    if (this.isEmpty(thirdPartyPaid) || this.isBlank(thirdPartyPaid)) {
        console.log("please provide data for thordparty paid");
        $("#popUpException").text("please provide data for thordparty paid.");
        $("#popUpException").attr("style", "color:red; font-weight:bold");
        $("#thirdPartyPaid").focus();
        return;
    }
    if(value.indexOf('$') != -1)
    {
        // value=value.replace("$", "");
        value= value.replace(/(\$|,)/gi, function (x) {
            return "";
          });
    }
    if(thirdPartyPaid.indexOf('$') != -1)
    {
        // thirdPartyPaid=thirdPartyPaid.replace("$", "");
        thirdPartyPaid =  thirdPartyPaid.replace(/(\$|,)/gi, function (x) {
            return "";
          });
    }
    if(sellingPrice.indexOf('$') != -1)
    {
        // thirdPartyPaid=thirdPartyPaid.replace("$", "");
        sellingPrice =  sellingPrice.replace(/(\$|,)/gi, function (x) {
            return "";
          });
    }
    console.log(sellingPrice);
    var drugprice=$('#drugPrice').val();
    if($('#drugPrice').val().indexOf('$') != -1)
    {
        // drugprice=$('#drugPrice').val().replace("$","");
        drugprice=  drugprice.replace(/(\$|,)/gi, function (x) {
            return "";
          });
        console.log(drugprice);
    }

    if(sellingPrice.indexOf('$') != -1)
    {
        // drugprice=$('#drugPrice').val().replace("$","");
        drugprice=  drugprice.replace(/(\$|,)/gi, function (x) {
            return "";
          });
        console.log(drugprice);
    }

    if (this.isEmpty(sellingPrice) || this.isBlank(sellingPrice)) {
        console.log("selling is empty.");
        return;
    }

    drugprice = parseFloat(drugprice);
    var assistAuth=$('.fld-assist-auth input[name="asistantAuth"]').val();
    if(assistAuth.indexOf('$') != -1)
    {
        assistAuth=  assistAuth.replace(/(\$|,)/gi, function (x) {
            return "";
          });
        console.log(assistAuth);
    }
    assistAuth = parseFloat(assistAuth);
    var baseFee=0.00;
    if(assistAuth == 0) 
        baseFee = 5.25;
    else
       baseFee = 15.00;

    sellingFirst = sellingPrice - assistAuth;
    
    sellingSecond = drugprice + baseFee;

    

    // total2 = parseFloat(sellingPrice)  - parseFloat(total);
    total2 = sellingFirst  - sellingSecond;
    if(total2 > 0){
        if(document.getElementById("rxProfitability").classList.contains('txt-red')){
            document.getElementById('rxProfitability').classList.remove('txt-red');
        }
        document.getElementById('rxProfitability').classList.add('txt-grn-lt');
        console.log('test ');
    }else{
        console.log('test fail');
        if(document.getElementById("rxProfitability").classList.contains('txt-grn-lt')){
        document.getElementById('rxProfitability').classList.remove('txt-grn-lt');
        }
        document.getElementById('rxProfitability').classList.add('txt-red');
    }
        $('#rxProfitability').val("$ "+this.numberWithCommas(total2.toFixed(2)));
        
        total = (parseFloat(drugprice) +  parseFloat(value));

       var activity = parseFloat(total) / parseFloat(value) ;

       $('#activityMultiplier').val(activity.toFixed(2));

   var finalCollect = parseFloat(thirdPartyPaid) + parseFloat(value)
       $('#finalCollect').val(finalCollect.toFixed(2));

},

    calculateProfitCustom: function(sellingPrice){
        
    },
    calculateRxProfitability_backup_8_4_2020: function(value){
        if (this.isEmpty(value) || this.isBlank(value)) {
            console.log("pocketOut is empty.");
            return;
        }
        var thirdPartyPaid = $("#thirdPartyPaid").val();
        if (this.isEmpty(thirdPartyPaid) || this.isBlank(thirdPartyPaid)) {
            console.log("please provide data for thordparty paid");
            $("#popUpException").text("please provide data for thordparty paid.");
            $("#popUpException").attr("style", "color:red; font-weight:bold");
            $("#thirdPartyPaid").focus();
            return;
        }
        if(value.indexOf('$') != -1)
        {
            // value=value.replace("$", "");
            value= value.replace(/(\$|,)/gi, function (x) {
                return "";
              });
        }
        if(thirdPartyPaid.indexOf('$') != -1)
        {
            // thirdPartyPaid=thirdPartyPaid.replace("$", "");
            thirdPartyPaid =  thirdPartyPaid.replace(/(\$|,)/gi, function (x) {
                return "";
              });
        }
        var sellingPrice = parseFloat(value) + parseFloat(thirdPartyPaid);
        console.log(sellingPrice);
        $('#RxSelling').val("$ "+this.numberWithCommas(sellingPrice.toFixed(2)));
        $('#RxSelling').attr('readonly',false);

        var drugprice=$('#drugPrice').val();
        if($('#drugPrice').val().indexOf('$') != -1)
        {
            // drugprice=$('#drugPrice').val().replace("$","");
            drugprice=  drugprice.replace(/(\$|,)/gi, function (x) {
                return "";
              });
            console.log(drugprice);
        }
        total = (parseFloat(drugprice) +  parseFloat(value));
        console.log(total);
        console.log(total.toFixed(2));
        total2 = parseFloat(sellingPrice)  - parseFloat(total);
        console.log(total2);
        console.log(total2.toFixed(2));
        console.log($.trim(total2));
        if(total2 > 0){
            if(document.getElementById("rxProfitability").classList.contains('txt-red')){
                document.getElementById('rxProfitability').classList.remove('txt-red');
            }
            document.getElementById('rxProfitability').classList.add('txt-grn-lt');
            console.log('test ');
        }else{
            console.log('test fail');
            if(document.getElementById("rxProfitability").classList.contains('txt-grn-lt')){
            document.getElementById('rxProfitability').classList.remove('txt-grn-lt');
            }
            document.getElementById('rxProfitability').classList.add('txt-red');
        }
            $('#rxProfitability').val("$ "+this.numberWithCommas(total2.toFixed(2)));

           var activity = parseFloat(total) / parseFloat(value) ;

           $('#activityMultiplier').val(activity.toFixed(2));

       var finalCollect = parseFloat(thirdPartyPaid) + parseFloat(value)
           $('#finalCollect').val(finalCollect.toFixed(2));

    },
}

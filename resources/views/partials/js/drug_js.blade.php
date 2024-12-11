<script src="{{ url('js/jquery.maskMoney.js') }}" type="text/javascript"></script>
{{-- <script src="{{ url('js/jquery/1.11.4-jquery-ui.min.js') }}" type="text/javascript"></script> --}}
<script
  src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
  integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E="
  crossorigin="anonymous"></script>

<script type="text/javascript">

$(document).ready(function() {

    $("#drug-Add-Modal").draggable({
      handle: ".modal-header"
  });


    $('#drug-Add-Modal').on('hidden.bs.modal', function () {

$(this).find('form').trigger('reset');
           $('form[name="drug_form"]')[0].reset();
           clearValidation('form[name="drug_form"]');
                   $("#minor_reporting_class").attr("required", true);  
             $("#major_reporting_cat").attr("required", true); 
        $("#marketer").attr("required", true); 
        $("#strength").attr("required", true); 
});
$('#drug_main_table').DataTable({
                            processing: false,
                            serverSide: false,
                            Paginate: false,
                            lengthChange: false,
                            pageLength : 3,
                            order:[],
                            bFilter: false,
                            columnDefs: [
                                        { targets: 'no-sort', orderable: false }
                                      ]
                        });
$('.compliance-user-table').DataTable({
                            processing: false,
                            serverSide: false,
                            Paginate: false,
                            lengthChange: false,
                            pageLength : 10,
                            order:[],
                            bFilter: false,
                            columnDefs: [
                                        { targets: 'no-sort', orderable: false }
                                      ]
                        });
/*

$('#drug_tbl').DataTable({
                            pageLength: 5,
                            processing: false,
                            serverSide: false,
                            Paginate: false,
                            lengthChange: false,
                            order:[],
                            bFilter: false,
                            columnDefs: [
                                        { targets: 'no-sort', orderable: false }
                                      ]
                        });
*/

function clearValidation(formElement){
//Internal $.validator is exposed through $(form).validate()
var validator = $(formElement).validate();
//Iterate through named elements inside of the form, and mark them as error free
$('[name]',formElement).each(function(){
 if(this.id){
validator.successList.push(this);//mark as error free
//    $(this).next('label').remove();
//    console.log('#'+this.id);

//    $('label#'+this.id+'-error').remove();
validator.showErrors();//remove error messages if present
//    $('#'+this.id).removeClass("error");
}
});
$("input.error,select.error").removeClass("error");
$(formElement +'input[required]').removeClass('order-error');
            $(formElement +'input[required]').prev('label').removeClass('star');
            $('.all-order-error').hide();
validator.resetForm();//remove error class on name elements and clear history
validator.reset();//remove all error and success data
}

/**  Validation  */
/*
$('form[name="drug_form"] input[required]').blur(function(){
        if( !$(this).val() ){
            $(this).addClass('order-error');
            $(this).prev('label').addClass('star');
        }
    });





    $('form[name="drug_form"] input[required]').on('keypress change', function(){

        $('label.error').hide();
        if($(this).valid()){
            $(this).removeClass('order-error');
            $(this).prev('label').removeClass('star');
        }else
        {
            $(this).addClass('order-error');
            $(this).prev('label').addClass('star');
        }
    });

*/

$("form[name='drug_form']").validate();

/** ADD DRUG */


   $( "form[name='drug_form']" ).submit(function(e){
  //  if($('#drug-Add-Modal').is(':visible')){
  //    alert('yes');
  //  }
  //  debugger;
  //   return;
  // if (!($('.modal.in').length)) {
  //   $('.modal-dialog').css({
  //     top: 0,
  //     left: 0
  //   });
  // }
        e.preventDefault();
        if(!$(this).valid())
        {

           /* $('label.error').hide();
            $('form[name="drug_form"] label.error').show();
            $('form[name="drug_form"] input[required].error').addClass('order-error');
            $('form[name="drug_form"] input[required].error').prev('label').addClass('star'); */
          /* $('span.all-order-error').text('Please fill required fields ').show();
            setTimeout(function(){  $('span.all-order-error').hide(); }, 4000);*/

            return false;
       }else{
        // $('form[name="drug_form"] label.error').hide();
        //    $('form[name="drug_form"] input[required]').removeClass('order-error');
            // $('form[name="drug_form"] input[required]').prev('label').removeClass('star');
       }
       var drugData=$( "form[name='drug_form']" ).serializeArray();
       $.each(drugData,function(key,val){
          console.log(key,val);
          if(val.name == "pkg_size" || val.name == "unit_per_pkg" || val.name=="unit_price" || val.name=="awp_unit_price" || val.name=="default_rx_qty" || val.name=="alternate_qty")
          {
            if(val.value.indexOf('$') != -1)
            {
                val.value=val.value.replace("$", "");
            }
            if(val.value.indexOf(',') != -1)
            {
                val.value=val.value.replace(",", "");
            }
          }
          else if(val.name=="discount_date" && val.value != ""){
                var dateAr = val.value.split('-');
                val.value = dateAr[2] + '-' +dateAr[0] + '-' + dateAr[1];                               
          }          
       });
              drugData = drugData.concat(
          $('form[name="drug_form"] input[type=checkbox]:not(:checked)').map(function() {
                return {"name": this.name, "value": null}
              }).get()
          );
       console.log(drugData)
       $('.loader').show();
        $.ajax({
           type:'POST',
           url:"{{url('/drug/add-update')}}",
           data:drugData,
           success:function(data) {

               if(data.type=='update')
              {
                  // var FormDataW = $( "form[name='drug_form']" ).serializeArray();
   if($('#modal-view_drugs').is(':visible')){
    //  $('#drug-Add-Modal').modal('hide');
    console.log(drugData[26].value?drugData[26].value:'');
    drugArray = [];
    drugArray2 = [];
  //  const dd3 = drugData.find(d2 => {
  //     if(d2.name == 'id'){
  //    return d2.value;
  //   }
  //  });
    drug_id = null;
   const dd4 = $.each(drugData,function() {
     drugArray[this.name] = this.value;
     drugArray2.push(this);
      if(this.name == 'id'){
        drug_id = this.value;
    }
   });
  //  const drug_id =  drugData.filter(d1 => {
  //     if(d1.name == 'id'){
  //    return d1.value;
  //   }
  //  })
       if(drug_id){
   $('tr[data-drugid="'+drug_id+'"] td:nth-child(1)').html('<a href="javascript:void(0)" onclick="open_edit_drugs('+drug_id+')">'+drugArray['ndc']+'</a>');
   $('tr[data-drugid="'+drug_id+'"] td:nth-child(2)').text(drugArray['rx_label_name']);
   $('tr[data-drugid="'+drug_id+'"] td:nth-child(3)').text(drugArray['generic_name']);
   $('tr[data-drugid="'+drug_id+'"] td:nth-child(4)').text(drugArray['strength']);
   $('tr[data-drugid="'+drug_id+'"] td:nth-child(5)').text(drugArray['marketer']);
   $('tr[data-drugid="'+drug_id+'"] td:nth-child(6)').text(drugArray['generic_or_brand']);
   $('tr[data-drugid="'+drug_id+'"] td:nth-child(7)').text(drugArray['major_reporting_cat']);
       }
  //  drugData.findIndex(function (d,i){
  //   if(d.name == 'id')
  //      return i;
  //  })
   


   }

              }
              // return;
               //$( "#cancel_drug" ).trigger( "click" );
               $('.loader').hide();
               toastr.options = {
                        "preventDuplicates": true,
                        "preventOpenDuplicates": true
                        };
               if(data.status==1)
               {
                    if($("#drug_list_"+$('input[name="id"]').val()).length)
                    { $("#drug_list_"+$('input[name="id"]').val()).remove(); $('#count_drug').html( ($('#count_drug').html()-1) ); }
                    add_drug();
                    toastr.success('Message',data.msg);
                    hide_drug_modal();

                }
                else{
                    $('#ndc').addClass('order-error');
                    $('#ndc').prev('label').addClass('star');
                    $('span.all-order-error').text(data.msg).show();
                    setTimeout(function(){  $('span.all-order-error').hide(); }, 6000);
                    // alert('a');
                    return false;
                }
               setTimeout(function(){
                    toastr.clear();
                    $('#toast-container').remove();
                    // parent.location.reload();
                }, 3000);
                 if($('input[name="id"]').length==0)
                 {
                     $("form[name='drug_form']")[0].reset();
                 }

           },
            headers: {
                'X-CSRF-TOKEN': '<?php echo csrf_token() ?>'
            }
        });
   });



    /**  AutoComplete on drug search , major and minor reporting class    */


$('#keyword').autoComplete({
resolverSettings: {
url: "{{url('/drug-search-maintenance')}}"
}
});
$('#keyword').on('change', function() {
    console.log('eventsAutoComplete change');

});
$('#keyword').on('autocomplete.select', function(evt, item) {
//  console.log('eventsAutoComplete autocomplete.select');
  console.log(item.value);

edit_drugs(item.value);
   //  console.log('fired autocomplete.select. item: ' + item + ' value: ' + $(this).val() + '\n');
   // eventsCodeContainer.text(eventsCodeContainer.text() + 'fired autocomplete.select. item: ' + item + ' value: ' + $(this).val() + '\n');
  });

   $('#keyword').on('autocomplete.freevalue', function(evt, item) {
   console.log('eventsAutoComplete autocomplete.freevalue');
   //eventsCodeContainer.text(eventsCodeContainer.text() + 'fired autocomplete.freevalue. item: ' + item + ' value: ' + $(this).val() + '\n');
});

$('#major_reporting_cat').autoComplete({
    resolverSettings: {
        url: "{{url('/get-drug-cat/major')}}"
    }
});
$('#minor_reporting_class').autoComplete({
    resolverSettings: {
        url: "{{url('/get-drug-cat/minor')}}"
    }
});



/**  Reset Button  */

$('#undo_btn').click(function() {
    // if(!confirm("changes made, do you want to discard the changes?"))
    //       return false;

                    if($('input[name="id"]').length)
                    {
                        console.log(window.edit_drug);
                        $.each(window.edit_drug, function( key, val ) {
                           if($('input[name="'+key+'"]').attr('type')!='checkbox')
                           {
                               $('input[name="'+key+'"]').val(val);
                           }else{
                              if(val)
                              {
                                $('input[name="'+key+'"][value="'+val+'"]').prop('checked', true);
                              }else{
                                $('input[name="'+key+'"]').prop('checked', false);
                              }

                          }
                       });
                    }else{ $("form[name='drug_form']")[0].reset(); }
                   // $('#submitOrder').text('ADD');
                   // $('input[name="id"]').remove();
                });


                /**   Cancel Confirm  */


$('#cancel_btn').click(function() {
    // toastr.clear();
    var dataChanged = false;
    confirm_cancel(dataChanged);
                   // $('#submitOrder').text('ADD');
                   // $('input[name="id"]').remove();
                });

 });


 $(document).keydown(function(e) {
    // ESCAPE key pressed
    if (e.keyCode == 27 ) {
        var dataChanged = false;
        toastr.clear();
        confirm_cancel(dataChanged);
    }
});


/** confirmation function */

function confirm_cancel(dataChanged){
    remove_msg_popup();
    if($('input[name="id"]').length)
                    {
                        console.log(window.edit_drug);
                        $.each(window.edit_drug, function( key, val ) {
                           if($('input[name="'+key+'"]').attr('type')!='checkbox')
                           {

                              if($('input[name="'+key+'"]').val() != $.trim(val) && (typeof $('input[name="'+key+'"]').val() !== 'undefined'))
                              {
                                console.log(key,$('input[name="'+key+'"]').val(),val);
                                dataChanged = true;
                              }
                           }else{
                              if(val)
                              {
                                console.log(key,$('input[name="'+key+'"]').val(),val);
                                if($('input[name="'+key+'"][value="'+val+'"]').is(':not(:checked)'))
                                {
                                    dataChanged = true;
                                }
                              }else{
                                console.log(key,$('input[name="'+key+'"]').val(),val);
                                if($('input[name="'+key+'"]').prop('checked') == true)
                                {
                                    dataChanged = true;
                                }
                              }

                          }
                       });
                       console.log(dataChanged);
                    }
                    if(dataChanged){
                        $('drug-Add-Modal').attr('tabindex',"");
                        toastr.options = {
            "closeButton": false,
           "debug": false,
           "newestOnTop": false,
           "progressBar": false,
           "positionClass": "toast-top-center",
           "preventDuplicates": false,
           "maxOpened": 1,
           "onclick": null,
           "showDuration": "300",
           "hideDuration": "1000",
           "timeOut": 0,
           "extendedTimeOut": 0,
           "showEasing": "swing",
           "hideEasing": "linear",
           "showMethod": "fadeIn",
           "hideMethod": "fadeOut",
           "tapToDismiss": true
       }
                        toastr.warning("<button type='button' id='confirmationYes' class='btn clear'>Yes</button><button type='button' id='confirmationNo'  class='btn clear'>No</button>",'Changes will be lost! do you want to quit?',
  {
      closeButton: false,
      allowHtml: true,
      onShown: function (toast) {
          $("#confirmationYes").click(function(){
            remove_msg_popup();
            hide_drug_modal();
          });
          $("#confirmationNo").click(function(){
            remove_msg_popup();
          });
        }
  });
                    }else{
                        remove_msg_popup();
                        hide_drug_modal();
                    }
}




 /**  Edit drug  */

 function edit_drugs(id)
   {
                $('#del_drug_btn').show();
                $('#submitOrder').text('UPDATE');
                $("form[name='drug_form']")[0].reset();
                //$("#ndc").attr("readonly", false);
                 $('input[name="id"]').remove();
                //  $('form[name="drug_form"] input[required]').removeClass('order-error');
                // $('form[name="drug_form"] input[required]').prev('label').removeClass('star');

                $.ajax({
                type:'GET',
                url:"{{url('/drug-search-maintenance')}}",
                data:'id='+id,
                success:function(data) {
                    if(data!='NULL')
                    {
                        window.edit_drug = data[0];
                        // console.log(data[0]);
                        $('form[name="drug_form"]').append('<input name="id" type="hidden" value="'+id+'" />');
                        //$('input[name="ndc"]').attr('readonly', 'readonly');
                        $('#submitOrder').text('UPDATE');
                           if(data[0].generic_or_brand && (data[0].generic_or_brand == 'CMP' || data[0].generic_or_brand == 'cmp' || data[0].generic_or_brand == 'Cmp')){
                             $("#minor_reporting_class").removeAttr("required"); 
                             $("#generic_pro_id").removeAttr("required"); 
        $("#major_reporting_cat").removeAttr("required"); 
        $("#marketer").removeAttr("required"); 
        $("#strength").removeAttr("required"); 
                          }

if(data[0].upc){
        $("#ndc").removeAttr("required"); 
  
}

                        $.each(data[0], function( key, val ) {

                            //  console.log(key+'    '+val);
if(key == 'unit_per_pkg' || key == 'pkg_size')
{
  if(val){
  // console.log('$ '+val.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
  console.log(val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
  val = val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }
}


                            if(key == 'discount_date'){    
                                if(val == '0000-00-00' || val == "" ||val == null){
                                    $('#discount_date').val("");
                                }else{
                                    var dateAr = val.split('-');
                                    var newDate = dateAr[1] + '-' +dateAr[2] + '-' + dateAr[0];                               
                                    $('#discount_date').val(newDate);
                                }
                            }else if($('#drug-Add-Modal input[name="'+key+'"]').attr('type')!='checkbox'){
                               var newValue = $.trim(val);
                               $('#drug-Add-Modal input[name="'+key+'"]').val(newValue);
                           }else{ $('input[name="'+key+'"][value="'+val+'"]').prop('checked', true); }
                       });
                   }
                   },
                       headers: {
                           'X-CSRF-TOKEN': '<?php echo csrf_token() ?>'
                   }
                   });
        
        
        // setTimeout(function(){ 
        //     if($("#generic_or_brand").val() == 'CMP')
        //        $("#minor_reporting_class").removeAttr("required"); 
        // $("#major_reporting_cat").removeAttr("required"); 
        // $("#marketer").removeAttr("required"); 
        // $("#strength").removeAttr("required"); 
        // }, 3000);
        
                 
   }

$("#generic_or_brand").on('change', function(){
    if(this.value == 'CMP' || this.value == 'cmp'){
      $("#generic_pro_id").removeAttr("required").removeClass('error').next('label').remove(); 
        $("#minor_reporting_class").removeAttr("required").removeClass('error').next('label').remove(); 
        $("#major_reporting_cat").removeAttr("required").removeClass('error').next('label').remove(); 
        $("#marketer").removeAttr("required").removeClass('error').next('label').remove(); 
        $("#strength").removeAttr("required").removeClass('error').next('label').remove(); 
      
    }else{
      $("#generic_pro_id").attr("required", true);
        $("#minor_reporting_class").attr("required", true);  
        $("#major_reporting_cat").attr("required", true); 
        $("#marketer").attr("required", true); 
        $("#strength").attr("required", true);   
        }  
});



$("#upc").on('change', function(){
    if($(this).val() || $(this).val() != ''){
        $("#ndc").removeAttr("required").removeClass('error').next('label').remove(); 
    }else
        $("#ndc").attr("required", true);     
});

/**  Add Drug */

    function myTrim(x) {
      return x.replace(/^\s+|\s+$/gm,'');
    }

    function open_edit_drugs($id){

        $('#drug-Add-Modal').modal('show');
        // if (!($('#drug-Add-Modal .modal.in').length)) {
    $('#drug-Add-Modal').css({
      top: 0,
      left: 0
    });
  // }
        $('#discount_date').datepicker({
                 autoclose: true,
                 format: 'mm-dd-yyyy',
                 });
        edit_drugs($id);
    }

    function hide_drug_modal(){
        $('#drug-Add-Modal').modal('hide');
    }

    function add_drug()
    {

      $('#del_drug_btn').hide();
      $('#submitOrder').text('ADD');
      $('input[name="id"]').remove();
      $('#discount_date').datepicker({
            autoclose: true,
            format: 'mm-dd-yyyy',
        });
    //   $('form[name="drug_form"] input[required]').removeClass('order-error');
    //   $('form[name="drug_form"] input[required]').prev('label').removeClass('star');
      $("#keyword").val('');
      $("form[name='drug_form']")[0].reset();
       $("#ndc").attr("readonly", false);
    }

    var $toastlast;
   function drug_del()
   {
      var id = $('input[name="id"]').val();
       toastr.options = {
            "closeButton": false,
           "debug": false,
           "newestOnTop": false,
           "progressBar": false,
           "positionClass": "toast-top-center",
           "preventDuplicates": false,
           "onclick": null,
           "showDuration": "300",
           "hideDuration": "1000",
           "timeOut": 0,
           "extendedTimeOut": 0,
           "showEasing": "swing",
           "hideEasing": "linear",
           "showMethod": "fadeIn",
           "hideMethod": "fadeOut",
           "tapToDismiss": false
       }
     var $toast =   toastr.error('Do you want to remove this drug?<br /><button onclick="remove_rows('+id+');" type="button" class="btn clear">Yes</button><button style="margin-left: 5px;" onclick="remove_msg_popup();" type="button" class="btn clear">No</button>');
     $toastlast = $toast;
   }

   function remove_msg_popup()
    {
       toastr.clear();
       $('#toast-container').remove();
    }

   function remove_rows(id){

    $.ajax({
        type:'POST',
        url:"{{url('delete-drug')}}",
        data:'d_id='+id,
        success:function(data) {

            if($("#drug_list_"+id).length)
            { $("#drug_list_"+id).remove(); $('#count_drug').html( ($('#count_drug').html()-1) ); }
            add_drug();
            toastr.success('Message', 'Durg deleted successfully.');
            setTimeout(function(){
                toastr.clear();
                $('#toast-container').remove();
                parent.location.reload();
            }, 3000);
        },
        headers: {
            'X-CSRF-TOKEN': '<?php echo csrf_token() ?>'
        }
    });

       toastr.clear();
       $('#toast-container').remove();
       $("form[name='drug_form']")[0].reset();
       @if(isset($drug_id_edit) && $drug_id_edit == id)
            window.location = '{{ url("dashboard/drug-maintenance") }}';
       @endif
   }


   function numericOnly(event,allowLen){ // restrict e,+,-,E characters in  input type number
    //     if(event.target.value.length==allowLen) return false;
    //     console.log(event);
    //     const charCode = (event.which) ? event.which : event.keyCode;
    // if (charCode == 101 || charCode == 69 || charCode == 45 || charCode == 43) {
    //   return false;
    // }
    // return true;
    if(event.target.value.length == allowLen) return false;
  var charCode = event.which  ? event.which : event.keyCode;
  var charStr = String.fromCharCode(charCode);
console.log(charCode,charStr)
if(event.target.name=='default_rx_qty' || event.target.name=='alternate_qty')
    {
        if(event.target.value.indexOf('.') == -1 &&  charCode==46)
        {
            return true;
        }
                
    }
  if (!charStr.match(/^[0-9]+$/))
    event.preventDefault();

  }
  $("#unit_price").maskMoney({ decimal:'.', allowZero:true, prefix: '$',precision:4});
  $("#unit_per_pkg").maskMoney({ decimal:'.', allowZero:true,precision:0});
  $("#awp_unit_price").maskMoney({ decimal:'.', allowZero:true, prefix: '$',precision:4});
  $("#pkg_size").maskMoney({ decimal:'.', allowZero:true,precision:0});

function remove_sponsor(did,s_status)
{
    if(s_status=="N")
    {
      $('#submitOrder1').text('Sponsored');
      $('#spons-modal-heading').text('Add Sponsored Drug');
      $('.spon_field').prop('disabled',false);
    }else{
      $('#submitOrder1').text('Unsponsored');
      $('#spons-modal-heading').text('Remove Sponsored Drug');
      $('.spon_field').prop('disabled',true);
    }  
    $('#drug-Unspons-Modal').modal('show');
    edit_drugs(did);
    // $.ajax({
    //     url: "{{url('drug/remove_sponsored')}}",
    //     data:{id: did},
    //     success: function(response)
    //     {
    //         console.log(response);
    //         if(response.status)
    //         {
    //             $('tr[data-did="'+did+'"]').remove();
    //         }
    //     },
    //     error:function(error)
    //     {

    //     }
    // });
}
$(document).ready(function(){
  $('#submitOrder1').click(function(){
    var sponsData=$( "form[name='drug_form']" ).serializeArray();
    console.log(sponsData);
    $.each(sponsData,function(key,val){
          console.log(key,val);
          if(val.name=="unit_price" || val.name == "awp_unit_price" || val.name== "unit_per_pkg")
          {
            if(val.value.indexOf('$') != -1)
            {
                val.value=val.value.replace("$", "");
            }
            if(val.value.indexOf(',') != -1)
            {
                val.value=val.value.replace(",", "");
            }
          }
          
       })
     $.ajax({
        url: "{{url('drug/remove_sponsored')}}",
        type:'POST',
        data: sponsData,
        success: function(response)
        {
            console.log(response);
            if(response.status)
            {
              $('#drug-Unspons-Modal').modal('hide');
              // if($("form[name='drug_form'] input[name='id']").val())
              // {
                // var drug_id=$("form[name='drug_form'] input[name='id']").val();
                var drug_id=response.status.id;
                $('tr[data-did="'+drug_id+'"] .sp_sts').attr("onclick","remove_sponsor("+drug_id+",'"+response.status.sponsored_product+"')")
                $('tr[data-did="'+drug_id+'"] .sp_sts').text(response.status.sponsored_product);
                $('tr[data-did="'+drug_id+'"] .sp_src').text(response.status.sponsor_source);
                $('tr[data-did="'+drug_id+'"] .sp_itm').text(response.status.sponsor_item);
                $('tr[data-did="'+drug_id+'"] .sp_lnk').text(response.status.order_web_link);
                $('tr[data-did="'+drug_id+'"] .ing_pc').text("$"+response.status.unit_price);
              // }
                
            }
        },
        error:function(error)
        {

        }
    });

  });
});
   



// drug search 

function show_practies_modal(p_type){
        $('#practice-show-modal').modal('show');
        if(p_type=="pharmacy")
        {
            $('.modal_phy_count').hide();
            $('.modal_law_count').hide();
            $('.modal_phr_count').show();
            $('#modal-label').text('new '+p_type);
        }
        else if(p_type=="physician")
        {
            $('.modal_phr_count').hide();
            $('.modal_law_count').hide();
            $('.modal_phy_count').show();
            $('#modal-label').text('new '+p_type);
        }
        else if(p_type=='law_practice')
        {
            $('.modal_phr_count').hide();
            $('.modal_phy_count').hide();
            $('.modal_law_count').show();
            $('#modal-label').text('new law practice');
        }

        if(p_type=='physician' || p_type=='law_practice')
        {
          $('#modal-prc-type').text('Practice Name');
        }else{
          $('#modal-prc-type').text('Pharmacy Name');
        }

          $('#modal-pharmacies').dataTable( {
           "ajax": {
            "url": "{{url('get-pharmacies')}}",
            "data":{'type':p_type},
            "dataSrc": function ( json ) {
              for ( var i=0; i<json.data.length ;  i++ ) {
                // json.data[i]=json.data[i];
                if(json.data[i].created_by)
                {
                  json.data[i].cr_rep=json.data[i].created_by.name;
                }else{
                  json.data[i].cr_rep='';
                }
                
                if(json.data[i].users)
                {
                  // console.log(json.data[i].users.length>0);
                  if(json.data[i].users.length>0)
                  {
                    json.data[i].users=json.data[i].users[0].name;
                  }else{
                    json.data[i].users='';
                  }

                }
              }
              return json.data;
            }
          },
          aoColumns: [
                        { mData: 'practice_name',render: function (dataField,type, row) { return '<a class="td_u_force txt-blue_sh-force" href="javascript:void(0)" onclick="open_edit_practice('+row.id+')">'+dataField+'</a>'; } },
                        { mData: 'practice_zip' },
                        { mData: 'practice_state' },
                        {mData: 'users'},
                        {mData:'cr_rep'}
                ],

              lengthChange: false,
              pageLength : 10,
              order:[],
              bFilter: false,
              "bDestroy": true

        });
      }


      //  drug search filter


      $('#drug_filter_btn').on('click',function(e){
        e.preventDefault();
        console.log($('form#drug_request_filter').serialize());
        // return;
       if($.fn.DataTable.isDataTable('.drug_filter_table' )){  $('.drug_filter_table').DataTable().destroy(); }

        $('.drug_filter_table').DataTable({
            processing: true,
            serverSide: true,
            Paginate: true,
            lengthChange: false,
            autoWidth: false,
            order: [ [1, 'desc'] ],
            bFilter: false,
            pageLength: 10,
            "language": {
    "infoFiltered": ""
  },
            ajax: {
                "type": "post",
                "url": '{{ url("similar-drug-filter") }}?'+$('form#drug_request_filter').serialize(),
                // "dataType": "json",
                // "contentType": 'application/json; charset=utf-8',
                "dataSrc" : "data",
                "data": function(data){
                    
                },
            },
            "columns": [
             
        
                { 
         "data": "ndc",
  
         "render": function(data, type, row, meta){
           console.log(row);
           console.log(meta);

            if(type === 'display'){
                data = '<a href="javascript:void(0)" onclick="open_edit_drugs('+row.id +')"  >' + data + '</a>';
            }

            return data;
         }
      } ,
                { "data": "rx_label_name" },
                { "data": "generic_name" },
                { "data": "strength" },
                { "data": "marketer" },
                // { "data": "unit_price" },
                { "data": "generic_or_brand" },
                { "data": "major_reporting_cat" }
               
            ],
            'createdRow': function(row, d, di){
           console.log(row);
           console.log(d);
           console.log(di);
              $(row).attr("data-drugid",d.id)
              // $(row).children(':nth-child(2)').addClass("p-zip");
              // $(row).children(':nth-child(3)').addClass("drp-state");
              // $(row).children(':nth-child(4)').addClass("site-cnt");
            },	 
            

        });
    });

$('#view_similar_drugs').click(function(){
  $("form#drug_request_filter").trigger('reset');
  // $('yourdiv').find('form')[0].reset();
  $('form#drug_request_filter button[type="submit"]').trigger('click');
  $('#modal-view_drugs').modal('show');

});

      </script>

<script type="text/javascript">
	function show_facilitator_modal_listing(){
  
        $('#modal-facili-management-listing').modal('show');
    

          $('#facili-listing-table').dataTable( {
           "ajax": {
            "url": "{{url('get-all-facilitators')}}",
            "dataSrc": function ( json ) {
              
              return json.data;
            }
          },
          createdRow: function( row, data, dataIndex ) {
        // Set the data-status attribute, and add a class

            console.log("creatrow",row);
            console.log("data",data);
            $(row).attr("fcl-id",data.id);
            $(row).children(':nth-child(2)').addClass('lname');
            $(row).children(':nth-child(3)').addClass('femail');
            $(row).children(':nth-child(4)').addClass('fphone');

          
          },
          aoColumns: [
                        { mData: 'first_name',render: function (dataField,type, row) {   return '<a class="td_u_force txt-blue_sh-force fname" href="javascript:void(0)" onclick="open_edit_facilitator('+row.id+')">'+dataField+'</a>';  } },
                        { mData: 'last_name' },
                        {mData: 'email'},
                        { mData: 'phone_number' },

                ],

              lengthChange: false,
              pageLength : 10,
              order:[],
              bFilter: false,
              "bDestroy": true

        });
      }
      function add_update_facilitator()
   {

  



       var pdata=$( "form[name='facili_form']" ).serializeArray();
       console.log(pdata);
      
       // $( "form[name='practice_form']" ).serialize()
       $('.loader').show();
        $.ajax({
           type:'POST',
           url:"{{url('/facilitator/add-update')}}",
           data:pdata,
           success:function(data) {
            if(data.status)
            {
              toastr.success(data.message);
              $( "#facili-reg-form" )[0].reset();
              
              $('#modal-facili-management-add-new').modal('hide');
              if(data.type=="add" && data.facilitator)
              {
                var grp='<tr fcl-id="'+data.facilitator.id+'"><td><a class="td_u_force txt-blue_sh-force fname" href="javascript:void(0)" onclick="open_edit_facilitator('+data.facilitator.id+')">'+data.facilitator.first_name+'</a></td><td>'+data.facilitator.last_name+'</td><td>'+data.facilitator.email+'</td><td>'+data.facilitator.phone_number+'</td></tr>';

                      

                $('#facili-listing-table').DataTable().row.add($(grp)).draw();
              }
              if(data.type=="update" && data.facilitator)
              {
                  $('[fcl-id="'+data.facilitator.id+'"] .fname').text(data.facilitator.first_name);
                  $('[fcl-id="'+data.facilitator.id+'"] .lname').text(data.facilitator.last_name);
                  $('[fcl-id="'+data.facilitator.id+'"] .fphone').text(data.facilitator.phone_number);
                  $('[fcl-id="'+data.facilitator.id+'"] .femail').text(data.facilitator.email);
              }
              

            }
           },
            headers: {
                'X-CSRF-TOKEN': '<?php echo csrf_token() ?>'
            }
        });
   }



function open_edit_facilitator($id){
  
$('#modal-facili-management-add-new').modal('show');
edit_facilitator($id);
}


function edit_facilitator(id)
   {
   

   
       $('.hupdate_ent').text('Edit Facilitator');
      
       $('form[name="facili_form"]').append('<input name="id" type="hidden" value="'+id+'" />');
       $('#submit_facilitator').text('UPDATE');
      $('.loader').show();
       $.ajax({
           type:'GET',
           url:"{{url('/get-facilitator-detail')}}/"+id,
           success:function(data) {
               toastr.clear();
                $('.loader').hide();
                console.log(data);
                $.each(data.facilitator, function( key, val ) {
                 
                      $('input[name="'+key+'"]').val(val);
                     
                });
               

              
                

                        
           },
            headers: {
                'X-CSRF-TOKEN': '<?php echo csrf_token() ?>'
            }
       });

   }
   $('#modal-facili-management-add-new').on('hidden.bs.modal', function () {
    $('#facili-reg-form')[0].reset();
    
    if($('#facili-reg-form > input[type="hidden"]').length>0)
    {
      $('#facili-reg-form > input[type="hidden"]').remove();
    }
   
    $('#modal-facili-management-listing').modal('show');
   });
   $('#modal-facili-management-add-new').on('shown.bs.modal', function () {
    $('.hupdate_ent').text('Add New Facilitator');
    $('#modal-facili-management-listing').modal('hide');
   });
</script>
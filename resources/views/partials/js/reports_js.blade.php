<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    function currencyFormat(num) {
            return '$' + num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
    }
    
    function numberFormat(num) {
            return num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
    }
    function numberOnlyCommas(num) {
        console.log("commaa",num);
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
    }
    
    $(document).ready(function(){
        if($('#main_report_noData').length)
        {
            $('#download_icon').hide();
        }
        if($('#web_stats_noData').length)
        {
            $('#stat_icons').hide();
        }
        $('#report_type').change(function(){
           // alert('jamil');
            if($(this).val()!='')
            {                
                $("#time_lab").show();
                if($(this).find(":selected").attr('daysType')=='future')
                {
                    $("#number_of_days").hide();
                    $("#number_of_days").prop("disabled", true);
                    $("#future_dop").prop("disabled", false);
                    $("#future_dop").show();
                    $("#select-dependent").show();

                }else
                {
                    $("#future_dop").prop("disabled", true);
                    $("#future_dop").hide();
                    //$("#select-dependent").hide();
                    $("#select-dependent").show();
                    $("#number_of_days").show();
                    $("#number_of_days").prop("disabled", false);
                }
            }
        });
        
        $('form#web_stat_form select').change(function(){

            var errorf = false;
            $('#web_que_stats_table').hide();
            if($(this).attr('id')=='web_stat')
            {
                console.log("dad");
                if($('#duration').length)
                {
                    $('#duration').val('');
                }
                
            }
            $('form#web_stat_form select').each(function(){
                
                if($(this).val()=='')
                {
                    errorf = true;
                }
                
            });
            
            
            
            if(errorf==false)
            {
               // no_data==false
                 $('#loading_small_img').show();
                //$('form#web_stat_form').submit();
                var web_st = $('form#web_stat_form select').val();
                console.log(web_st);
               $.ajax({
                type:'POST',
                url:"{{url('report/client_dashboard')}}",
                data: $('#web_stat_form').serialize(),
                success:function(data) {

                    $('#loading_small_img').hide();
                    $('#web_que_stats_table').show();
                    $('#web_que_stats_table').html(data);
                   console.log($('#web_stats_noData').length);
                   $('#stat_icons').hide();
                   if($('#web_stats_noData').length==0)
                   {
                        $('#stat_icons').show();
                        $('#web_que_stats_table .compliance-user-table').DataTable({
            
                footerCallback: function ( row, data, start, end, display ) {
                    console.log(row)
                    var api = this.api(), data;

                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
                    
                    if(web_st && (web_st=='referrals_generated' || web_st == 'completed_enrollments' || web_st == 'payments_made' || web_st == 'member_questions' || web_st == 'refill_reminders' || web_st=='refill_requests')){
    
                        // Total over this page
                        pageTotal = api
                            .column( 0, { page: 'current'} )
                            .data()
                            .reduce( function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0 );
                        pageTotal = numberOnlyCommas(pageTotal);    
                        $( api.column( 0 ).footer() ).html(
                            pageTotal
                        );
                        
                        if(web_st == 'refill_reminders'){
                            pageTotal = api
                                .column( 4, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );
                            pageTotal = numberFormat(pageTotal);    
                            $( api.column( 4 ).footer() ).html(
                                pageTotal
                            );
                }    
                
                        if(web_st != 'member_questions'){
                            // Total over this page
                            pageTotal = api
                                .column( 2, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );
                            pageTotal = currencyFormat(pageTotal);    
                            $( api.column( 2 ).footer() ).html(
                                pageTotal
                            );
                
                     
                            // Total over this page
                            pageTotal = api
                                .column( 3, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );
                            pageTotal = currencyFormat(pageTotal);    
                            $( api.column( 3 ).footer() ).html(
                                pageTotal
                            );

                            // Total over this page
                            if(web_st!='refill_requests')
                            {
                            pageTotal = api
                                .column( 5, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );
                            pageTotal = numberOnlyCommas(pageTotal);    
                            $( api.column( 5 ).footer() ).html(
                                pageTotal
                            );
                            }
                        }
                    }
                   
                },
            
        
            processing: false,
            serverSide: false,
            Paginate: false,
            lengthChange: false,
            order:[],
            bFilter: false,
            responsive: true,
           
        });
                    }   
        
       // var table = $('#idTable').DataTable();

        //console.log($('#web-que-stats table.compliance-user-table').html());
             
          //  $('#web-que-stats table.compliance-user-table').removeClass('dataTable');
                },
                 headers: {
                     'X-CSRF-TOKEN': '<?php echo csrf_token() ?>'
                 }
             }); 
             
             
                console.log($(this).val());
            }
            
            
        });
       
       $('form#main_reports select').change(function(){
           //alert('qamar');
           
           
            var errorf = false;
            $('#report_type_table_area').hide();
            $('#download_icon').hide();
            if($(this).attr('id')=='report_type')
            {
                if($('#number_of_days').length)
                {
                    $('#number_of_days').val('');
                }
                 if($('#future_dop').length)
                {
                    $('#future_dop').val('');
                }
                
            }
            $('form#main_reports select').each(function(){
                if($(this).css('display')!='none')
                { 

                    if($(this).val()=='')
                    {
                        errorf = true;
                    }
                }
                
            });
            
            console.log($('select#report_type option:selected').attr('daysType'));
            if($('select#report_type option:selected').attr('daysType')=='past' && $('.past_drop').val()=='')
            {
                errorf = true;
                $('.future_drop').val('');
            }
            
            if($('select#report_type option:selected').attr('daysType')=='future' && $('.future_drop').val()=='')
            {
                errorf = true;
                $('.past_drop').val('');
            }
            
            if(errorf==false)
            {
                $('#loading_small_img_one').show();
                
                $.ajax({
                type:'POST',
                url:"{{url('report/client_dashboard')}}",
                data: $('#main_reports').serialize(),
                success:function(data) {
                    $('#report_type_table_area').show();
                    $('#loading_small_img_one').hide();
                    $('#report_type_table_area').html(data);
                   //console.log(data);
                   $('#download_icon').hide();
                   if($('#main_report_noData').length==0)
                   {
                       $('#download_icon').show();
                       console.log("no data length 0");
                        $('#report_type_table_area .compliance-user-table').DataTable({

                            footerCallback: function ( row, data, start, end, display ) {
                                var api = this.api(), data;
                                // Remove the formatting to get integer data for summation
                                var intVal = function ( i ) {
                                    return typeof i === 'string' ?
                                        i.replace(/[\$,]/g, '')*1 :
                                        typeof i === 'number' ?
                                            i : 0;
                                };
                            },
                        processing: false,
                        serverSide: false,
                        Paginate: false,
                        lengthChange: false,
                        order:[],
                        bFilter: false,
                        responsive: true,
                    });
                }
                   

                },
                 headers: {
                     'X-CSRF-TOKEN': '<?php echo csrf_token() ?>'
                 }
             }); 
             
             
               // $('form#main_reports').submit();
                console.log($(this).val());
            }
            
            
        });
       
       
       $('#web_stat').change(function(){
           $("#duration_div").show();
       });
       
        
        $('select#web_stat').val('payments_made').trigger('change');
        $('select#duration').val(1).trigger('change');
        
        $('.compliance-user-table').DataTable({
            
                footerCallback: function ( row, data, start, end, display ) {
                    var api = this.api(), data;

                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
                    
                    @if(Request::has('web_stat') and (Request::get('web_stat')=='referrals_generated' or Request::get('web_stat') == 'completed_enrollments' or Request::get('web_stat') == 'payments_made' or Request::get('web_stat') == 'member_questions' or Request::get('web_stat') == 'refill_reminders'))
    
                        // Total over this page
                        pageTotal = api
                            .column( 0, { page: 'current'} )
                            .data()
                            .reduce( function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0 );
                        pageTotal = pageTotal;    
                        $( api.column( 0 ).footer() ).html(
                            pageTotal
                        );
                        
                        @if(Request::get('web_stat') == 'refill_reminders')
                            pageTotal = api
                                .column( 4, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );
                            pageTotal = numberFormat(pageTotal);    
                            $( api.column( 4 ).footer() ).html(
                                pageTotal
                            );
                        @endif    
                
                        @if(Request::get('web_stat') != 'member_questions')
                            // Total over this page
                            pageTotal = api
                                .column( 2, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );
                            pageTotal = currencyFormat(pageTotal);    
                            $( api.column( 2 ).footer() ).html(
                                pageTotal
                            );
                
                     
                            // Total over this page
                            pageTotal = api
                                .column( 3, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );
                            pageTotal = currencyFormat(pageTotal);    
                            $( api.column( 3 ).footer() ).html(
                                pageTotal
                            );

                            // Total over this page
                            pageTotal = api
                                .column( 5, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );
                            pageTotal = pageTotal;    
                            $( api.column( 5 ).footer() ).html(
                                pageTotal
                            );
                        @endif
                    @endif
                },
            
        
            processing: false,
            serverSide: false,
            Paginate: false,
            lengthChange: false,
            order:[],
            bFilter: false,
            responsive: true,
        });
        
        
        
        
      // get_web_statdata();
    });
    
$(document).ready(function(){
    // if(no_data)
    // {
    // if($('table').hasClass('dataTable'))
    // { 
    //      $('table').removeClass('dataTable');
    //       }
    // }
 });

</script>

<html>
<head>
    <title>{{ucfirst(str_replace ("_", " ", $report_title))}}</title>
    <meta http-equiv=Content-Type content="text/html; charset=UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

</head>
<style>
    html{
width: 100%;
height: 100%;
padding: 0;
margin: 0px 2px;
background-color: #fff;
}
    .main{
        /* margin: 0 auto;
        width: 50%; */
        border-top:7px solid;
        border-bottom: 7px solid;
        border-color: #3b7ec4;
    }
    .logo-block{
       
    }

    .Date-form{

        background:#3b7ec4;
        float:right;

        text-align: right;

    }

    .name-box{

        float: left;
        margin-top: 20px;
        width: 240px;
        display: inline;

    }

    .date-main{

        float: right;

        /*   margin-top: 20px;width: 240px;
        */     
        display: inline;

    }

    .clearfix::after {

        content: "";

        display: table;

        clear: both;

    }

    .Date-to{

        float: right;

        text-align: right;

        background:#3b7ec4;

    }

    .Table-block{

        margin: 0;

    }

    table {

        font-family: 'Open Sans', sans-serif;

        border-collapse: collapse;

        width: 100%;

        border: 1px solid #3b7ec4;
        background-color: #fff;

        /* margin-bottom: 61px; */

    }

    th {

        background: #3b7ec4;

        color: #fff;

        font-size:12px !important;

        text-align: left;

        padding: 6px !important;
        border: 1px solid #c1bfbf;

    }

    td {

        text-align: left;

        padding: 4px 4px !important;

        font-size:11px;

        color:#747474;
        border: 1px solid #c1bfbf;

    }

    tr:nth-child(odd) {

        background-color: #dddddd;

    }

    h5{

        color:#747474;

        font-size: 18px;

        font-weight: 600;

        font-family: 'Open Sans', sans-serif;

    }

    .University{

        color:#3b7ec4;

        font-size: 12px;

        font-weight: 500;

        font-family: 'Open Sans', sans-serif;

    }

    p{

        font-size:12px;

        color:#747474;

        font-family: 'Open Sans', sans-serif;



    }

    .link{

        color:#3b7ec4;

        font-size:12px;

        font-family: 'Open Sans', sans-serif;

        text-align: center;

    }

    .logo{

        margin-top: 16px;
        margin-left: 25px;
        display: inline;
        width: 200px;
        float: left;

    }

    .RPORT-paper{
        /*float: left;*/
        margin-right: 25px;
        font-size: 17px;
        display: inline;
        width: 400px;
        /*text-align: right;*/
    }

    .Store-text{

        padding: 6px 17px;

        background-color: #f6f6f6;

        font-family: 'Open Sans', sans-serif;

        width: 205px;

    }

    .text_center{

        text-align: center;



    }

    .left-box-{

        float: left;

    }

    .left-box-one{

        float: left;

    }



    .right-box-one{

        float: right;

    }
    /*header {
                position: fixed;
                top: 0px;
                left: 0px;
                right: 0px;
                height: 50px;
            }
*/
            footer {
                position: fixed; 
                bottom: 10px; 
                left: 0px; 
                right: 0px;
                height: 20px;
            }
    
table.dataTable tbody td{ padding: 4px 4px !important; }
.dataTables_wrapper .dataTables_paginate .paginate_button{ padding:0 0 0px 1px !important; }
                .dataTables_processing{ padding:6px !important; }
</style>
<body>

 <header class="clearfix">

    <div class="main">

        <div class="logo-block">
            <!-- <img src="{{asset('images/logo.png')}}" class="logo"> -->

            <p class="RPORT-paper">
                <span>Compliance Reward Detail Report</span>
            </p>

        </div>
        
    </div>
</header>
 <footer>
            Copyright &copy; <?php echo date("Y");?> 
</footer>
<script type="text/php">
    if (isset($pdf)) {
       
        $text = "Page {PAGE_NUM} of {PAGE_COUNT}";
        $font = null;
        $size = 10;
        $color = array(0,0,0);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $y = $pdf->get_height() - 20;
        $x = $pdf->get_width() /2;

        $pdf->page_text($x, $y, $text, $font, $size, $color);
    }
</script>
@yield('pdf_content')

@isset($export_check )
<script type="text/javascript" src="http://compliancerewards.ssasoft.com/New/public/js/jquery-3.2.1.min.js"></script>
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>


 <script type="text/javascript">
        
  
  
       var Datatable =  
           $('.data-table').DataTable({
            processing: false,
            serverSide: false,
            Paginate: false,
            lengthChange: false,
            responsive:false,
            paging:   false,
            order:[],
            bFilter: false,
            columns: [
                @if($tab_title)
                @foreach($tab_title as $keyTab=>$valTab)
                    @php $orderable =  ', orderable:false, searchable:false'; if(is_array($valTab)){ if(isset($valTab['sort'])){ $orderable = ''; } $valTab = $valTab['title']; } @endphp
                        {data: '{{ $valTab }}', name: '{{ $valTab }}' {{ $orderable }}  },
                @endforeach                  
               @endif
                
            ]
        });
        
        Datatable.on( 'order.dt', function (a, b, c) {
            console.log(a); 
            console.log(b); 
            console.log(c); 
            console.log(cell); 
       // t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
           // cell.innerHTML = i+1;
       // });
    } );
      
</script>

@endisset

</body>

</html>
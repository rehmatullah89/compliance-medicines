<?php

namespace App\Http\Controllers;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Reports;
use DB;
use PDF;
use Carbon\Carbon;
use auth;
use App\Practice;
use App\Patient;
use Session;
use Mail;
use App\Exports\AccountingExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportExport;
use App\User;
use App\Drug;


class PipReportController extends Controller
{
    private $data_keys;


    public function pip_market()
    {
        $date_qart_range = $this->get_quarters_date_range();
       
        $result = Order::select([DB::raw('Orders.RxFinalCollect AS total_payments'), 
                                DB::raw('Orders.Id AS total_orders'),  
                                DB::raw('QUARTER(Orders.RxOrigDate) AS quarter'), 
                                DB::raw('YEAR(Orders.RxOrigDate) AS Year'),
                                DB::raw('Orders.RxOrigDate AS order_date'), 
                                DB::raw('CONCAT(pr.practice_name, "=", pr.id) AS practice_name')
                                ])
                        ->join('pip_patient_cases AS ppc', 'ppc.id', 'Orders.pip_case_id')
                        ->join('practices AS pr', 'ppc.practice_id', 'pr.id')
                        ->where('ppc.case_status', 1)
                        ->whereNotNull('Orders.pip_case_id')
                        //->groupBy('pr.id')
                        ->where('Orders.RxOrigDate', '>=', $date_qart_range['start_date'])
                        ->where('Orders.RxOrigDate', '<=', $date_qart_range['end_date'])
                        ->orderBy('Orders.RxOrigDate', 'ASC')
                        ->get();

        
                        
        $group_result = $result->groupBy([
            'practice_name',
            function ($item) {
                return "Q".$item['quarter']."-".$item['Year'];
            },
        ], $preserveKeys = true);
        $filter_result = $group_result->map(function($pr_arr){

            $ekaur = $pr_arr->map(function($myval){

                $qamar['total_payments'] = $myval->sum('total_payments');
                $qamar['total_number'] = $myval->count();

                return $qamar;
            });
            return $ekaur;
        });
       // dd($filter_result->toArray());
        $data['quarter_arr'] = $date_qart_range['quarter_arr'];
        $data['pip_data'] = $filter_result->toArray();
            
        return view('reports.pip_reports.pip_market_place', $data);
    }

    public function get_cases_detail_by_law_practice_id(Request $request)
    {
        if($request->ajax())
        {
            $date_qart_range = $this->get_quarters_date_range();
            $result = Order::select([DB::raw('Orders.RxFinalCollect AS total_payments'), 
                                DB::raw('Orders.Id AS total_orders'),                                  
                                DB::raw('Orders.Id AS order_id'), 
                                DB::raw('QUARTER(Orders.RxOrigDate) AS quarter'), 
                                DB::raw('YEAR(Orders.RxOrigDate) AS Year'),
                                DB::raw('Orders.RxOrigDate AS order_date'), 
                                DB::raw('pr.practice_name AS practice_name'),
                                DB::raw('ppc.case_no AS case_no'),
                                'Orders.created_at AS created_at',
                                'Orders.RxNumber AS simple_rx_number',
                                DB::raw('(CASE WHEN Orders.RefillCount < 9 THEN CONCAT(Orders.RxNumber,"-0",Orders.RefillCount) ELSE CONCAT(Orders.RxNumber,"-",Orders.RefillCount) END) AS rx_number'),
                                DB::raw('CONCAT(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19")USING "utf8"), " ", CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8"), "=", ppc.case_no) AS patient_name'),
                                ])
                        ->join('pip_patient_cases AS ppc', 'ppc.id', 'Orders.pip_case_id')
                        ->join('PatientProfileInfo as ppi','ppi.Id','Orders.PatientId')
                        ->join('practices AS pr', 'ppc.practice_id', 'pr.id')
                        ->where('ppc.case_status', 1)
                        ->whereNotNull('Orders.pip_case_id')
                        ->where('ppc.practice_id', $request->pr_id)
                        //->groupBy('pr.id')
                        ->where('Orders.RxOrigDate', '>=', $date_qart_range['start_date'])
                        ->where('Orders.RxOrigDate', '<=', $date_qart_range['end_date'])
                        ->orderBy('Orders.RxOrigDate', 'ASC')
                        ->get();


           // $group_result = $result->groupBy([
             //   'patient_name',
            //    function ($item) {
            //        return "Q".$item['quarter']."-".$item['Year'];
            //    },
           // ], $preserveKeys = true);

           $group_result = $result->groupBy([
               'patient_name',
               function ($item) {
                   return "Q".$item['quarter']."-".$item['Year'];
               },
           ], $preserveKeys = true);


          //  $group_result = $result->groupBy('patient_name');
          //  dd($group_result->toArray());
            //echo '<pre>';
            //print_r($result->toArray());
            $data['orders'] = $group_result->toArray();
            $data['quarter_arr'] = $date_qart_range['quarter_arr'];
            
            return view('reports.pip_reports.orders_detail_by_law', $data);
        }
        else
        {
            return 'not ajax request';
        }
        
    }



    public function pip_investment()
    {
        $date_qart_range = $this->get_quarters_date_range();
       //dd($date_qart_range);
        $result = Order::select([DB::raw('Orders.RxFinalCollect AS total_payments'), 
                                DB::raw('Orders.Id AS total_orders'),  
                                DB::raw('pr.id AS practice_id_law'),  
                                DB::raw('QUARTER(Orders.RxOrigDate) AS quarter'), 
                                DB::raw('YEAR(Orders.RxOrigDate) AS Year'),
                                DB::raw('Orders.RxOrigDate AS order_date'), 
                                DB::raw('CONCAT(pr.practice_name, "=", pr.id) AS practice_name')
                                ])
                        ->join('pip_patient_cases AS ppc', 'ppc.id', 'Orders.pip_case_id')
                        ->join('practices AS pr', 'ppc.practice_id', 'pr.id')                        
                        ->where('ppc.case_status', 1)
                        ->whereNotNull('Orders.pip_case_id')
                        //->groupBy('pr.id')
                        ->where('Orders.RxOrigDate', '>=', $date_qart_range['start_date'])
                        ->where('Orders.RxOrigDate', '<=', $date_qart_range['end_date'])
                        ->orderBy('Orders.RxOrigDate', 'ASC')
                        ->get();

        
        $group_result = $result->groupBy([
            'practice_name',
            function ($item) {
                return "Q".$item['quarter']."-".$item['Year'];
            },
        ], $preserveKeys = true);
        
        
        $opened_quarter = array();
        $filter_result = $group_result->map(function($pr_arr, $pr_key) use ($opened_quarter){
           // echo $pr_key; echo '<br>';
            $ekaur = $pr_arr->map(function($myval, $mykey) use ($pr_key, $opened_quarter){
                $practice_law_info = explode('=', $pr_key);
                if(!isset($opened_quarter[$mykey])){ $opened_quarter[$mykey] = 0; }
                $sub_query = DB::table('investment_detail AS id_law')->select([DB::raw('SUM(id_law.amount_invest) AS amount_invested')])
                                ->join('investment_info_law AS iil', 'iil.id', 'id_law.investment_id')
                                ->where('iil.investment_on_quarter', $mykey)
                                ->where('id_law.practice_id_law', $practice_law_info[1])->first();

                $qamar['total_invested_amount'] = floatval(($sub_query->amount_invested==null) ? 0 : $sub_query->amount_invested);
                $qamar['total_payments'] = floatval($myval->sum('total_payments'));
                $qamar['remaining_amount'] = ($myval->sum('total_payments') - $qamar['total_invested_amount']);
                $qamar['orders_ids'] = $myval->pluck('total_orders')->implode(',');
                $qamar['total_number'] = $myval->count();
                return $qamar;
            });
            return $ekaur;
        });
       
       // dd($filter_result->toArray());


       //----------- Future Quarters Dropdown ---------------

       for($i=3; $i<9; $i++)
       {
            $year = Carbon::now()->addQuarters($i)->format('Y');
            $quart = Carbon::now()->addQuarters($i)->isoFormat('Q');

            $Future_Quarters_arr[] = "Q".$quart."-".$year;
       }
       //dd($Future_Quarters_arr);
       // --------- End Future Quarters Dropdown ------------
        $data['quarter_arr'] = $date_qart_range['quarter_arr'];
        $data['future_quarter_arr'] = $Future_Quarters_arr;
        $data['pip_data'] = $filter_result->toArray();

        return view('reports.pip_reports.pip_investment', $data);
    }


    public function submit_investment(Request $request)
    {
       // dd($request->all());

        $investment_detail = $request->investment_detail;
        $investment = $request->except(['investment_detail']);
        $investment['status'] = 1;
        $query  = DB::table('investment_info_law')->insert($investment);
        
        $last_id = DB::getPDO()->lastInsertId();
        foreach($investment_detail as $valIns)
        {
            $valIns['investment_id'] = $last_id;
            $new_query = DB::table('investment_detail')->insert($valIns);
        }
        

        if($last_id)
        { return json_encode(['message'=>'Seccessfully saved', 'status' => 1]); }
        else{ return json_encode(['message'=>'Data not saved', 'status' => 0]); }
        
        
    }

    public function investment_list()
    {
        $result = DB::table('investment_info_law AS iil')
                    ->select(['iil.*', DB::raw('COUNT(id_t.id) AS totle_order_old'), DB::raw('SUM(LENGTH(id_t.order_ids) - LENGTH(REPLACE(id_t.order_ids, ",", "")) + 1) AS totle_order')])
                        ->leftJoin('investment_detail AS id_t', 'id_t.investment_id', '=','iil.id')
                    ->groupBy('iil.id')->get();

       //dd($result->toArray());
        $data['invest_list'] = $result->all();

        return view('reports.pip_reports.investment_listing', $data);
    }

    public function get_quarters_date_range()
    {
        $now = Carbon::now();
       // $now = new Carbon('first day of next month');
        //$now = Carbon::parse('2020-05-25');
        $current_month = $now->month;
       
        $current_year = $now->year;
        if($current_month>9)
        {
            //$start_date = new Carbon('first day of October '.Carbon::now()->subYear(1));
            
            $end_date = new Carbon('last day of December '.$current_year); 
            $start_date = new Carbon('first day of October '.$current_year);      
            $start_date = $start_date->subQuarters(3);      
        }
        if($current_month>6 and $current_month<=9)
        {
            $end_date = new Carbon('last day of September '.$current_year);
            //$start_date = new Carbon('first day of July '.Carbon::now()->subYear(1));
            $start_date = new Carbon('first day of July '.$current_year);
          
           $start_date = $start_date->subQuarters(3); 
        }
        if($current_month>3 and $current_month<=6)
        {
            $end_date = new Carbon('last day of June '.$current_year);
           // $start_date = new Carbon('first day of April '.Carbon::now()->subYear(1));
           $start_date = new Carbon('first day of April '.$current_year); 
          $start_date = $start_date->subQuarters(3); 
        }
        if($current_month<=3)
        {
            $end_date = new Carbon('last day of March '.$current_year);
            //$start_date = new Carbon('first day of January '.Carbon::now()->subYear(1));
            //$start_date = new Carbon('first day of April '.Carbon::now()->subYear(1)); 
            $start_date = new Carbon('first day of January '.$current_year); 
            $start_date = $start_date->subQuarters(3); 
        }


       for($i=0; $i<4; $i++)
       {
            $year = Carbon::parse($start_date)->addQuarters($i)->format('Y');
            $quart = Carbon::parse($start_date)->addQuarters($i)->isoFormat('Q');

            $Quarters_arr[] = "Q".$quart."-".$year;
       }
       
        $start_date = $start_date->format('Y-m-d');
        $end_date = $end_date->format('Y-m-d');

        return array('start_date' => $start_date, 'end_date' => $end_date, 'quarter_arr' => $Quarters_arr);
    }

    public function fax_view_invoice(Request $request)
    {
        if(!$request->ajax())
        {
            $data['print_view'] = true;
           
        }
        $data['order_id'] = $request->order_id;
        
        
        
         $result = DB::table('reporter_prescription AS rp')
                                ->select(['rp.*', 'd.brand_reference', 
                                    DB::raw('CONCAT(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19")USING "utf8"), " ", CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8")) AS p_name'),
                                    'pr.practice_name AS law_practice_name', 'ur.name AS law_user_name', 'ppi.Gender', DB::raw('AES_DECRYPT(FROM_BASE64(BirthDate),"ss20compliance19") AS BirthDate')])
                                    ->join('Orders AS o', 'o.reporter_prescription_id', 'rp.id')
                                    ->join('drugs_new AS d', 'd.id', 'o.DrugDetailId')
                                    ->join('PatientProfileInfo as ppi','ppi.Id','o.PatientId')
                                    ->join('pip_patient_cases AS ppc', 'ppc.patient_id', 'rp.patient_id')
                                    ->join('practices AS pr', 'pr.id', 'ppc.practice_id')
                                    ->join('users AS ur', 'ur.id', 'ppc.created_by')
                        ->where('o.id', $request->order_id)
                        ->first();
         
            $data['precription'] = $result;

            return view('reports.pip_reports.fax_view_investor', $data);
    }


    public function get_quarter_investment_by_practice_quarter(Request $request)
    {
        if($request->ajax())
        {
            ///$date_qart_range = $this->get_quarters_date_range();
            
            //$get_invet = DB::table('investment_info_law')->where('id', $request->invest_id)->first();
            
            //-------------------investment id ------------------
            $invest = DB::table('investment_info_law AS iil')->select([DB::raw('GROUP_CONCAT(id_t.practice_id_law) AS practices_law'), 'iil.investor_name','iil.investment_on_quarter'])
                                ->leftJoin('investment_detail AS id_t', 'id_t.investment_id', '=','iil.id')
                                ->where('iil.id', $request->invest_id)->first();

          //  dd($invest);
            $q_and_y = explode('-', $invest->investment_on_quarter);
            //
            $date_range = $this->get_date_by_quarter(str_replace('Q', '', $q_and_y[0]), $q_and_y[1]);
            //------------------end investment id --------------

            //-------------investment detail -------------------

            $invt_detail = DB::table('investment_detail AS id_t')->select(['id_t.practice_id_law', 'id_t.amount_invest', 'pr.practice_name', 'id_t.order_ids', 'id_t.percentage_paid'])
                                ->join('practices AS pr', 'pr.id', '=', 'id_t.practice_id_law')->where('investment_id', $request->invest_id)->get();

           // $group_invt_detail = $invt_detail->groupBy('practice_id_law');
             
            //dd($invt_detail->toArray());
           $invt_detail = $invt_detail->keyBy('practice_name');
           
           $data['invt_d'] = $invt_detail->toArray();
            //-------------investment detail -------------------
           
           //dd($invt_detail->toArray());
           //--------------get previous percentage ------------------------------
           
           $prev_percent = DB::table('investment_detail AS id_t')->select([DB::raw('SUM(id_t.percentage_paid) AS previous_percentage_paid'), 'id_t.practice_id_law'])
                            ->join('investment_info_law AS iil', 'iil.id', 'id_t.investment_id')
                            ->where('id_t.investment_id', '<', $request->invest_id)
                            ->whereIn('id_t.practice_id_law', explode(',', $invest->practices_law))
                            ->where('iil.investment_on_quarter', $invest->investment_on_quarter)
                            ->groupBy('id_t.practice_id_law')->get();
           
          
           $prev_percent_one = $prev_percent->mapWithKeys(function ($item) {
                    return [$item->practice_id_law => $item->previous_percentage_paid];
                });
           
             // dd($prev_percent_one->toArray());  
            $data['prv_percent'] = $prev_percent_one->toArray();
           //--------------end get previous percentage --------------------------


            $order_ids_comma = $invt_detail->pluck('order_ids')->implode(',');
           // dd($date_range);
            $result = Order::select([DB::raw('Orders.RxFinalCollect AS total_payments'), 
                                DB::raw('Orders.Id AS total_orders'),   
                                DB::raw('QUARTER(Orders.RxOrigDate) AS quarter'), 
                               // DB::raw('(SELECT FROM investment_detail AS idone WHERE find_in_set(Orders.Id, order_ids) AND invstment_id<'),
                                DB::raw('YEAR(Orders.RxOrigDate) AS Year'),
                                DB::raw('ppc.practice_id AS practice_id_law'),
                                DB::raw('Orders.RxOrigDate AS order_date'), 
                                DB::raw('pr.practice_name AS practice_name'),
                                DB::raw('pr_two.practice_name AS pharmacy_name'),
                                DB::raw('ppc.case_no AS case_no'),
                                'Orders.created_at AS created_at',
                                'Orders.RxNumber AS simple_rx_number',
                                DB::raw('(CASE WHEN Orders.RefillCount < 9 THEN CONCAT(Orders.RxNumber,"-0",Orders.RefillCount) ELSE CONCAT(Orders.RxNumber,"-",Orders.RefillCount) END) AS rx_number'),
                                DB::raw('CONCAT(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19")USING "utf8"), " ", CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8"), "=", ppc.case_no) AS patient_name'),
                                DB::raw('CONCAT(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19")USING "utf8"), " ", CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8")) AS p_name'),
                                ])
                        ->join('pip_patient_cases AS ppc', 'ppc.id', 'Orders.pip_case_id')
                        ->join('PatientProfileInfo as ppi','ppi.Id','Orders.PatientId')
                        ->join('practices AS pr', 'ppc.practice_id', 'pr.id')
                        ->join('practices AS pr_two', 'pr_two.id', 'Orders.PracticeId')
                        ->where('ppc.case_status', 1)
                        ->whereNotNull('Orders.pip_case_id')
                        //->whereIn('ppc.practice_id', explode(',', $invest->practices_law))
                        //->groupBy('pr.id')
                        ->whereIn('Orders.Id', explode(',', $order_ids_comma))
                       // ->where('Orders.RxOrigDate', '>=', $date_range['start_date'])
                        //->where('Orders.RxOrigDate', '<=', $date_range['end_date'])
                        ->orderBy('Orders.RxOrigDate', 'ASC')
                        ->get();

             //dd($result->toArray());           
            $group_result = $result->groupBy([
                'practice_name',
                function ($item) {
                    return $item['patient_name'];
                },
            ], $preserveKeys = true);

              //  dd($group_result->toArray());
           //$group_result = $result->groupBy('patient_name');
           //dd($group_result->toArray());

          //  $group_result = $result->groupBy('patient_name');
          //  dd($group_result->toArray());
            //echo '<pre>';
            //print_r($result->toArray());
            $data['investor_name'] = $invest->investor_name;
            $data['invest_detail'] = $group_result->toArray();
            
            return view('reports.pip_reports.investment_popup_detail', $data);
        }
        else
        {
            return 'not ajax request';
        }
        
    }

    public function get_quarters_date_range_old_one()
    {
        //$now = Carbon::now();
        $now = new Carbon('first day of next month');
        //$now = Carbon::parse('2020-02-25');
        $current_month = $now->month;
       
        $current_year = $now->year;
        if($current_month>9)
        {
            //$start_date = new Carbon('first day of October '.Carbon::now()->subYear(1));
            
            $end_date = new Carbon('last day of September '.$current_year); 
            $start_date = new Carbon('first day of October '.$current_year);      
            $start_date = $start_date->subQuarters(4);      
        }
        if($current_month>6 and $current_month<=9)
        {
            $end_date = new Carbon('last day of June '.$current_year);
            //$start_date = new Carbon('first day of July '.Carbon::now()->subYear(1));
            $start_date = new Carbon('first day of July '.$current_year);
          
           $start_date = $start_date->subQuarters(4); 
        }
        if($current_month>3 and $current_month<=6)
        {
            $end_date = new Carbon('last day of March '.$current_year);
           // $start_date = new Carbon('first day of April '.Carbon::now()->subYear(1));
           $start_date = new Carbon('first day of April '.$current_year); 
          $start_date = $start_date->subQuarters(4); 
        }
        if($current_month<=3)
        {
            $end_date = new Carbon('last day of December '.Carbon::now()->subYear(1));
            //$start_date = new Carbon('first day of January '.Carbon::now()->subYear(1));
            //$start_date = new Carbon('first day of April '.Carbon::now()->subYear(1)); 
            $start_date = new Carbon('first day of January '.$current_year); 
            $start_date = $start_date->subQuarters(4); 
        }


       for($i=0; $i<4; $i++)
       {
            $year = Carbon::parse($start_date)->addQuarters($i)->format('Y');
            $quart = Carbon::parse($start_date)->addQuarters($i)->isoFormat('Q');

            $Quarters_arr[] = "Q".$quart."-".$year;
       }
       
        $start_date = $start_date->format('Y-m-d');
        $end_date = $end_date->format('Y-m-d');

        return array('start_date' => $start_date, 'end_date' => $end_date, 'quarter_arr' => $Quarters_arr);
    }


    public function get_date_by_quarter($quarter, $year)
    {
        if($quarter==4)
        {
            $end_date = new Carbon('last day of December '.$year); 
            $start_date = new Carbon('first day of October '.$year);
        }
        if($quarter==3)
        {
            $end_date = new Carbon('last day of September '.$year);
            $start_date = new Carbon('first day of July '.$year);
        }
        if($quarter==2)
        {
            $end_date = new Carbon('last day of June '.$year);
           $start_date = new Carbon('first day of April '.$year); 
        }
        if($quarter==1)
        {
            $end_date = new Carbon('last day of March '.$year);
            $start_date = new Carbon('first day of January '.$year); 
        }


        $start_date = $start_date->format('Y-m-d');
        $end_date = $end_date->format('Y-m-d');

        return array('start_date' => $start_date, 'end_date' => $end_date);
    }
    
    
    public function downloadInvoice(Request $request)
    {
        ini_set('memory_limit','256M');
        $createdAt = @explode(" ", $request->date);
        $createdAt = @$createdAt[0];

        $orders = order::where('RxNumber',$request->rx_number)
                ->when($createdAt != "" ,function($query) use ($createdAt){
                    $query->where('created_at', "LIKE", $createdAt.'%');
                })->with('patient','practice.users.roles','drug', 'payment_recived')
                ->orderBy('created_at')->first();
        $orders['cardNumber'] = ($orders->patient->cardNumber!='') ? substr($orders->patient->cardNumber, -4) : '';
        $orders['signature'] = isset($orders->patient->PaymentSignature) ? $orders->patient->PaymentSignature:'';

        $orders['name'] = (isset($orders->patient->FirstName) && isset($orders->patient->LastName)) ?(($orders->patient->FirstName.' '.$orders->patient->LastName)):'';
        //dd($orders);
        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
                ->loadView('reports.pip_reports.pip_invoice_print', $orders);
       // $pdf->setPaper('L', 'landscape');

        return $pdf->download('pip-invoice-'.$request->rx_number.'.pdf');

    }
    
    public function print_inovice_accounting(Request $request)
    {
       // ini_set('memory_limit','256M');
        $createdAt = @explode(" ", $request->date);
        $createdAt = @$createdAt[0];

        $orders = order::where('RxNumber',$request->rx_number)
                ->when($createdAt != "" ,function($query) use ($createdAt){
                    $query->where('created_at', "LIKE", $createdAt.'%');
                })->with('patient','practice.users.roles','drug', 'payment_recived')
                ->orderBy('created_at')->first();
        $orders['cardNumber'] = ($orders->patient->cardNumber!='') ? substr($orders->patient->cardNumber, -4) : '';
         //  dd($orders);
        $orders['signature'] = isset($orders->patient->PaymentSignature) ? $orders->patient->PaymentSignature:'';

        $orders['name'] = (isset($orders->patient->FirstName) && isset($orders->patient->LastName)) ?(($orders->patient->FirstName.' '.$orders->patient->LastName)):'';

       return view('reports.pip_reports.pip_invoice_print', $orders);

    }
    
    
    public function send_invoice_pip(Request $request){


        ini_set('memory_limit','256M');
        $createdAt = @explode(" ", $request->date);
        $createdAt = @$createdAt[0];

        $orders = order::where('RxNumber',$request->rx_number)
                ->when($createdAt != "" ,function($query) use ($createdAt){
                    $query->where('created_at', "LIKE", $createdAt.'%');
                })->with('patient','practice.users.roles','drug', 'payment_recived')
                ->orderBy('created_at')->first();

        $orders['signature'] = isset($orders->patient->PaymentSignature) ? $orders->patient->PaymentSignature:'';
       $orders['cardNumber'] = ($orders->patient->cardNumber!='') ? substr($orders->patient->cardNumber, -4) : '';
        $orders['name'] = (isset($orders->patient->FirstName) && isset($orders->patient->LastName)) ?(($orders->patient->FirstName.' '.$orders->patient->LastName)):'';

        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
                ->loadView('reports.pip_reports.pip_invoice_print', $orders);
      //  $pdf->setPaper('L', 'landscape');

      //  dd($orders);

        if($request->has('email_to'))
        {
            $data["email"]=$request->email_to;
        }
        else
        {
            $data["email"]=$orders->patient->EmailAddress;
        }
        //$data["email"]='qamarjamil23@gmail.com';

        $data['practice_name'] = $orders->practice->practice_name;
        $data['rx_number'] = $orders->RxNumber;
        $data['service_date'] = Carbon::parse($orders->created_at)->format('m/d/Y');
        $data["client_name"]=$orders['name'];
        $data["subject"]='Invoice from Compliance Rewards';

        //$pdf = PDF::loadView('mails.template_inovice_body', $data);

            try{
                Mail::send('emails.template_inovice_body', $data, function($message)use($data,$pdf) {
                $message->to($data["email"], $data["client_name"])
                ->subject($data["subject"])
                ->attachData($pdf->output(), "invoice.pdf");
                });
            }catch(JWTException $exception){
                $this->serverstatuscode = "0";
                $this->serverstatusdes = $exception->getMessage();
            }
            if (Mail::failures()) {
                 $this->statusdesc  =   "Error sending invoice";
                 $this->statuscode  =   "0";

            }else{

               $this->statusdesc  =   "Invoice sent Successfully";
               $this->statuscode  =   "1";
            }
            return response()->json(compact('this'));
     }
     
     
     
     public function send_precription_pip(Request $request){


        ini_set('memory_limit','256M');
        $data['print_view'] = true;
        
        $result = DB::table('reporter_prescription AS rp')
                                ->select(['rp.*', 'd.brand_reference', 
                                    DB::raw('CONCAT(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19")USING "utf8"), " ", CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8")) AS p_name'),
                                    DB::raw('AES_DECRYPT(FROM_BASE64(EmailAddress),"ss20compliance19") AS p_email'),
                                    'pr.practice_name AS law_practice_name', 'ur.name AS law_user_name', 'ppi.Gender', DB::raw('AES_DECRYPT(FROM_BASE64(BirthDate),"ss20compliance19") AS BirthDate')])
                                    ->join('Orders AS o', 'o.reporter_prescription_id', 'rp.id')
                                    ->join('drugs_new AS d', 'd.id', 'o.DrugDetailId')
                                    ->join('PatientProfileInfo as ppi','ppi.Id','o.PatientId')
                                    ->join('pip_patient_cases AS ppc', 'ppc.patient_id', 'rp.patient_id')
                                    ->join('practices AS pr', 'pr.id', 'ppc.practice_id')
                                    ->join('users AS ur', 'ur.id', 'ppc.created_by')
                        ->where('o.id', $request->order_id)
                        ->first();
         
            $data['precription'] = $result;
            $data['order_id'] = $request->order_id;
           // dd($result);
  
        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
                ->loadView('reports.pip_reports.fax_view_investor', $data);
      //  $pdf->setPaper('L', 'landscape');

      //  dd($orders);
        $data_one['p_name'] = $request->p_name;
        if($request->has('email_to'))
        {
            $data_one["email"]=$request->email_to;
        }
        else
        {
            $data_one["email"]=$result->p_email;
        }
        //$data_one["email"]='qamarjamil23@gmail.com';

        $data_one["subject"]='Precription from Compliance Rewards';

        //$pdf = PDF::loadView('mails.template_inovice_body', $data);

            try{
                Mail::send('emails.template_prescription_body', $data, function($message)use($data_one,$pdf) {
                $message->to($data_one["email"], $data_one["p_name"])
                ->subject($data_one["subject"])
                ->attachData($pdf->output(), "prescription.pdf");
                });
            }catch(JWTException $exception){
                $this->serverstatuscode = "0";
                $this->serverstatusdes = $exception->getMessage();
            }
            if (Mail::failures()) {
                 $this->statusdesc  =   "Error sending prescription";
                 $this->statuscode  =   "0";

            }else{

               $this->statusdesc  =   "Prescription sent successfully";
               $this->statuscode  =   "1";
            }
            return response()->json(compact('this'));
     }

     
     
}

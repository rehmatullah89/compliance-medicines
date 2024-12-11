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
use Str;

class ReportsController extends Controller
{
    private $data_keys;


    public function all_compliance_activity(Request $request)
    {

        if($request->from_date)
        {
            $d_dates['start_date'] = Carbon::parse($request->from_date)->format('Y-m-d');
            $d_dates['end_date'] = Carbon::parse($request->to_date)->format('Y-m-d');


        } else {  $d_dates['start_date'] = Carbon::now()->subDay(15)->format('Y-m-d');
                    $d_dates['end_date'] =  Carbon::now()->format('Y-m-d'); }

        $reports = new Reports();
        $data = [];
        $data['table_dates'] = array('start_date' => Carbon::parse($d_dates['start_date'])->format('m/d/Y'),
                                    'end_date' => Carbon::parse($d_dates['end_date'])->format('m/d/Y'));

         if($request->has('number_of_days'))
        {
             $data['number_of_days'] =  $request->number_of_days;
        }else{ $data['number_of_days'] =  1; }
        $title_days = 'Past '.$data['number_of_days'].' Days';
        if($data['number_of_days']==1){ $title_days = 'Now'; }

        $data['report_title'] = 'All Compliance Reward Program Activity ( '.$title_days.' )';
        $response = $reports->all_cwp_activity_page($d_dates, $request->session());
        $data['count_field'] = count($response['tab_title']);
        $data = array_merge($data,$response);


        // web queue statistics ----------
        $data['webstat_counts'] = $reports->web_queue_stats_counts();
        // end web queue statistics ---------
        return view('all_access.all_compliance_activity', $data);

    }


    public function client_dashboard(Request $request)
    {
       // ini_set('memory_limit','256M');
        $reports = new Reports();
        $data = [];
        if ($request->isMethod('get')) {
        	$request['report_type']='all_cwp_activity';
        	$request['number_of_days']=7;
		}
        // if(!$request->report_type && !Session::get('prac_type'))
        // {
        //     $request['report_type']='all_cwp_activity';
        //     Session::put('prac_type',true);
        // }
        // if(!$request->number_of_days && !Session::get('prac_dur'))
        // {
        //     $request['number_of_days']=7;
        //    	Session::put('prac_dur',true);
        // }
        // if(!$request->web_stat)
        // {
        //     $request['web_stat']='payments_made';
        //     $data['web_statis'] = true;
        //     $data['tab_show']=false;
        // }
        // if(!$request->duration)
        // {
        //     $request['duration']=1;
        // }
        if($request->has('report_type') and $request->report_type=='top_products_sale')
        {
            $data['report_title']  = 'Top Products By Sale ( Past '.$request->number_of_days.' Days)';
            $response = $reports->top_products_sale($request->number_of_days, $request->session());
            $data['count_field'] = count($response['tab_title']);
            $data = array_merge($data,$response);
        }

        if($request->has('report_type') and $request->report_type=='rx_refill_due_and_remaining')
        {
            $data['report_title'] = 'Rx with Refills Due Soon ( Next '.$request->number_of_days.' Days)';
            $response = $reports->refills_due($request->number_of_days, $request->session(),0);
      
            // $response = $reports->refills_due($request->number_of_days, $request->session(),0);
          $response1 = collect($response['result']);
        //  dump( $response1);
         $response['result'] =  $response1->transform(function($i) {
        
                unset($i['PatientId']);
                return $i;
            });
            // dump( $response);
            $data['count_field'] = count($response['tab_title']);
            $data = array_merge($data,$response);
        }

        if($request->has('report_type') and $request->report_type=='product_profitablity')
        {
            $data['report_title'] = 'Top Products by Profitability ( Past '.$request->number_of_days.' Days)';
            $response = $reports->top_product_profitablity($request->number_of_days, $request->session());
            $data['count_field'] = count($response['tab_title']);
            $data = array_merge($data,$response);
        }

        if($request->has('report_type') and $request->report_type=='all_cwp_activity')
        {
            $data['report_title'] = 'All Compliance Reward Program Activity ( Past '.$request->number_of_days.' Days)';
            $response = $reports->all_cwp_activity($request->number_of_days, $request->session());
            $data['count_field'] = count($response['tab_title']);
            $data = array_merge($data,$response);
        }

        if($request->has('report_type') and $request->report_type=='most_referrals')
        {
            $data['report_title'] = 'Most/Least Program Referrals Report ( Past '.$request->number_of_days.' Days)';
            $response = $reports->all_cwp_referrals($request->number_of_days, $request->session());
            $data['count_field'] = count($response['tab_title']);
            $data = array_merge($data,$response);
        }

        if($request->has('report_type') and $request->report_type=='all_users')
        {
            $data['report_title'] = 'All Practice Users Report ( Past '.$request->number_of_days.' Days)';
            $response = $reports->all_cwp_users($request->number_of_days, $request->session());
            $data['count_field'] = count($response['tab_title']);
            $data = array_merge($data,$response);
        }

        if($request->has('report_type') and $request->report_type=='patient_out_pocket')
        {
            $data['report_title'] = 'Rx Patient Out Of Pocket ( Past '.$request->number_of_days.' Days)';
            $response = $reports->patient_out_pocket($request->number_of_days, $request->session());
            $data['count_field'] = count($response['tab_title']);
            $data = array_merge($data,$response);
        }

        if($request->has('report_type') and $request->report_type=='zero_refill_remaining')
        {
            $data['report_title'] = 'Rx`s with 0 Refills Remaining ( Past '.$request->number_of_days.' Days)';
            $response = $reports->zero_refill_remaining($request->number_of_days, $request->session());
            $data['count_field'] = count($response['tab_title']);
            $data = array_merge($data,$response);
        }

        if($request->has('report_type') and $request->report_type=='rx_near_expiration')
        {
            $data['report_title'] = 'Rx Near Expiration ( Next '.$request->number_of_days.' Days)';
            $response = $reports->rx_near_expiration($request->number_of_days, $request->session());
            $data['count_field'] = count($response['tab_title']);
            $data = array_merge($data,$response);
        }


        if($request->has('web_stat'))
        {
            //dd($request);

            $response = $reports->web_stat_report($request->duration, $request->web_stat);
            $data['count_field'] = count($response['tab_title']);
            $data = array_merge($data,$response);

            $data['web_statis'] = true;
        }
        // else
        // {
        //     $data['is_post_data'] = true;
        //     $data['report_title'] = 'All Compliance Reward Program Activity ( Past 7 Days)';
        //     $response = $reports->all_cwp_activity(7, $request->session());
        //     $data['count_field'] = count($response['tab_title']);
        //     $data = array_merge($data,$response);
        // }

        // web queue statistics ----------
        $data['webstat_counts'] = $reports->web_queue_stats_counts();
        // end web queue statistics ---------

        if($request->ajax()){
            if($request->has('web_stat'))
            {
                return view('all_access.includes.web_stats_que', $data);
            }
            if($request->has('report_type'))
            {
                return view('all_access.includes.all_reports_cd', $data);
            }
        }else
        {
            return view('all_access.client_dashboard', $data);
        }
    }

    public function get_dates_default()
    {
        $total_days_cmonth = Carbon::now()->daysInMonth;
       $current_date_day = Carbon::now()->format('d');
       if($current_date_day>=15)
       {
           if(($total_days_cmonth==$current_date_day) )
           {
               $this_month_first = new Carbon('first day of this month');
               $dates['start_date'] =  $this_month_first->addDays(15)->format('Y-m-d');
                $dates['invoice_date'] =  Carbon::now()->format('Y-m-d');
           }
           else
           {
                $this_month_first = new Carbon('first day of this month');
                $dates['start_date'] =  $this_month_first->format('Y-m-d');
                $dates['invoice_date'] =  $this_month_first->addDays(14)->format('Y-m-d');
           }
       }else
       {
           $last_month = new Carbon('first day of last month');
           $last_day_of_this_month  = new Carbon('last day of last month');

           $dates['start_date'] =  $last_month->addDays(15)->format('Y-m-d');
          $dates['invoice_date'] =  $last_day_of_this_month->format('Y-m-d');
       }

       return $dates;
    }

    public function get_dates_from_billing_date($invoice_date=false)
    {

            $total_days_cmonth_end_bill = Carbon::now()->daysInMonth;
            $current_date_day_end_bill = Carbon::now()->format('d');
            if($current_date_day_end_bill>=15 and $current_date_day_end_bill < $total_days_cmonth_end_bill)
            {
                $this_month_first_end_bill = new Carbon('first day of this month');
                $invoice_date_end_bill =  $this_month_first_end_bill->addDays(15)->format('Y-m-d');
            }
            else
            {
                $this_month_first_end_bill = new Carbon('first day of this month');
                $invoice_date_end_bill =  $this_month_first_end_bill->format('Y-m-d');
            }
         $dates['end_bill_date'] = $invoice_date_end_bill;
        if($invoice_date==false)
        {
             $invoice_date = $invoice_date_end_bill;
        }


        $dates['invoice_date'] = $invoice_date;

        $day_of_date = Carbon::parse($invoice_date)->format('d');
         // $day_of_date = Carbon::parse($invoice_date)->format('M Y');
       // exit;
        if($day_of_date==15)
        {
            $dates['start_date'] = Carbon::parse($invoice_date)->subDays(14)->format('Y-m-d');
            $dates['end_date'] = Carbon::parse($invoice_date)->format('Y-m-d');
        }
        else
        {
            $last_month = Carbon::parse($invoice_date)->startOfMonth()->subMonth()->toDateString();
            $dates['start_date'] =  Carbon::parse($last_month)->addDays(15)->format('Y-m-d');
            $last_day_of_this_month  = Carbon::parse($invoice_date)->subMonth()->endOfMonth()->toDateString();

            $dates['end_date'] =  Carbon::parse($last_day_of_this_month)->format('Y-m-d');
        }

        return $dates;
    }

    public function accountingReport(Request $request)
    {

        //----------------- get dates ---------------
        if($request->invoice_date)
        {
           // $d_dates['start_date'] = Carbon::parse($request->from_date)->format('Y-m-d');
           // $d_dates['invoice_date'] = Carbon::parse($request->to_date)->format('Y-m-d');
            $d_dates = $this->get_dates_from_billing_date(Carbon::parse($request->invoice_date)->format('Y-m-d'));

        } else {  $d_dates = $this->get_dates_from_billing_date();  }

        $invoice_code = Carbon::parse($d_dates['invoice_date'])->format('mdy');
       // dd($d_dates);
        $data['table_dates'] = array('invoice_date' => Carbon::parse($d_dates['invoice_date'])->format('m/d/Y'),
                                    'start_date' => Carbon::parse($d_dates['start_date'])->format('m/d/Y'),
                                    'end_date' => Carbon::parse($d_dates['end_date'])->format('m/d/Y'),
                                    'end_bill_date' => $d_dates['end_bill_date']);

        //dd($data);

         $result = Order::select([DB::raw('DATE_FORMAT("'.Carbon::parse($d_dates['invoice_date'])->format('Y-m-d').'", "%m/%d/%Y") as invoice_date'),
            DB::raw('(CASE WHEN p.practice_code IS NULL THEN '.$invoice_code.' ELSE CONCAT(p.practice_code,"-'.$invoice_code.'") END) AS invoice_number'),
                                // DB::raw('CONCAT(p.practice_code, "-'.$invoice_code.'") AS invoice_number'),
                                DB::raw('p.practice_name AS practice_name'),
                                DB::raw('p.practice_type AS practice_type'),
                                DB::raw('COUNT(Orders.Id) AS Rx_facilitated'),
                                DB::raw('SUM(Orders.RxSelling) AS total_sale'),   //order total sale amount
                                DB::raw('SUM(Orders.RxProfitability) AS rx_profitability'),
                                DB::raw('SUM(Orders.asistantAuth) AS rewardAuth'),

                                DB::raw('SUM(CASE WHEN Orders.asistantAuth = 0 THEN (SELECT srv.base_fee FROM services AS srv WHERE  srv.practice_id = Orders.PracticeId  LIMIT 1)  END) AS base_fee'),
                               DB::raw('SUM(CASE WHEN Orders.asistantAuth != 0 AND Orders.RxProfitability > 0 THEN ((SELECT srv.profit_share FROM services AS srv WHERE  srv.practice_id = Orders.PracticeId LIMIT 1)/100)*(Orders.RxProfitability)  END) AS profit_share'),
                               DB::raw('SUM(CASE WHEN Orders.asistantAuth != 0 THEN (SELECT srv.fee FROM services AS srv WHERE  srv.practice_id = Orders.PracticeId  LIMIT 1) END) AS cr_service_fee'),
                                // DB::raw('((SUM(RxProfitability) * 0.1)+ SUM(15)) AS service_fee'),
                                //DB::raw(' SUM((CASE WHEN Orders.RxSelling >= 20 THEN ((Orders.RxPatientOutOfPocket + 15.00)+( RxProfitability * 0.1 ) )
                                       // ELSE (Orders.RxPatientOutOfPocket + 15) END)) AS service_fee')
                            ])->join('drugs_new AS d', 'd.id', '=', 'Orders.DrugDetailId')
                            ->join('practices AS p', 'p.id', '=', 'Orders.PracticeId')
                            ->when($d_dates, function ($query) use ( $d_dates) {
                                $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '>=', $d_dates['start_date']);
                                $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '<=',  $d_dates['end_date']);
                            })->when(Session::has('practice') , function($query){
                                $query->where('Orders.PracticeId', Session::get('practice')->id);
                            })
                            // ->when((!isset(auth::user()->practice_id) AND !isset(auth::user()->practice_id)) , function($query){
                            //     $query->addSelect([DB::raw('SUM(15) AS base_fee'), DB::raw('SUM(RxProfitability * 0.1) AS profit_share')]);
                            // })
                            ->when( (isset(auth::user()->practice_id) && !Session::has('practice')), function($query){
                                $query->where('PracticeId', auth::user()->practice_id);
                        })->orderBy('Orders.created_at', 'asc')->groupBy('Orders.PracticeId')->get();
                            // dd($result->all());

            if(!Session::has('practice') AND !isset(auth::user()->practice_id))
            {
                $data['total_sum_base_fee'] = '$ '.number_format($result->sum('base_fee'), 2);
                $data['total_sum_profit_share'] = '$ '.number_format($result->sum('profit_share'), 2);
                $data['total_sum_cr_service_fee'] = '$ '.number_format($result->sum('cr_service_fee'), 2);
            }
            $data['total_sum_sale'] = '$ '.number_format($result->sum('total_sale'), 2);
            $data['total_rx_profitability'] = '$ '.number_format($result->sum('rx_profitability'), 2);
            
            $data['total_sum_authrewd'] = '$ '.number_format($result->sum('rewardAuth'), 2);

            $data['unique_clients'] = $result->unique('practice_name')->count();
            $data['total_transactions'] = $result->sum('Rx_facilitated');
            $result->filter(function ($value, $key) {

                    $value['total_sale'] = '$ '.number_format($value['total_sale'], 2);
                    $value['rx_profitability'] = '$ '.number_format($value['rx_profitability'], 2);
                    $value['system_fee'] = '$ '.number_format(($value['cr_service_fee']+$value['profit_share']), 2);
                    $value['for_system_fee'] = $value['cr_service_fee']+$value['profit_share'];
                    $value['rewardAuth'] = '$ '.number_format($value['rewardAuth'], 2);
                    if(!Session::has('practice') AND !isset(auth::user()->practice_id))
                    {
                        $value['base_fee'] = '$ '.number_format($value['base_fee'], 2);
                        $value['profit_share'] = '$ '.number_format($value['profit_share'], 2);
                        $value['cr_service_fee'] = '$ '.number_format($value['cr_service_fee'], 2);
                    }
                    return $value;
                });
            $data['total_sum_system_fee'] = '$ '.number_format($result->sum('for_system_fee'), 2);
            $data['new_query_data'] = $result->all();
                 // dd($data);

            // dd($data['new_query_data']);


            //------------------ Done with table and invoice summery above --------------- Hassan check the code below and remove extra code ------




            $order = Order::when(Session::has('practice'),function($q) {
                $pid =Session::get('practice')->id;
                    return $q->join('practices as prac','Orders.PracticeId','prac.id')
                    ->where('PracticeId',$pid)->select([
                    'prac.practice_name','prac.practice_type','prac.practice_license_number', DB::raw('(SELECT  CONCAT("$ ", FORMAT(SUM(RxFinalCollect), 2))
                     FROM Orders INNER JOIN drugs_new AS db ON db.id = Orders.DrugDetailId where Orders.PracticeId = '.$pid.')  AS total_order_sale'),
                     DB::raw('(SELECT CONCAT("$ ", FORMAT(SUM(dbb.unit_price), 2) )
                     FROM Orders INNER JOIN `drugs_new` AS `dbb` ON `dbb`.`id` = `Orders`.`DrugDetailId` where Orders.PracticeId = '.$pid.') AS total_ingredient_cost'),
                     DB::raw('(SELECT  COUNT(*)
                     FROM Orders INNER JOIN `drugs_new` AS `dbbb` ON `dbbb`.`id` = `Orders`.`DrugDetailId` where Orders.PracticeId = '.$pid.') AS total_orders_transactions')
                    ]);
            })->when(!Session::has('practice'),function($q) {
                return $q->join('practices as prac','Orders.PracticeId','prac.id')
                 ->select(['prac.practice_name',
                 DB::raw('(SELECT CONCAT("$ ", FORMAT(SUM(RxFinalCollect), 2))
                 FROM Orders INNER JOIN drugs_new AS db ON db.id = Orders.DrugDetailId )  AS total_order_sale'),
                 DB::raw('(SELECT CONCAT("$ ", FORMAT(SUM(dbb.unit_price), 2) )
                 FROM Orders INNER JOIN `drugs_new` AS `dbb` ON `dbb`.`id` = `Orders`.`DrugDetailId` ) AS total_ingredient_cost'),
                 DB::raw('(SELECT  COUNT(*)
                 FROM Orders INNER JOIN `drugs_new` AS `dbbb` ON `dbbb`.`id` = `Orders`.`DrugDetailId`) AS total_orders_transactions')
                ]);
            })->addselect([DB::raw('(SELECT DATE_FORMAT(Orders.created_at,"%m/%d/%Y")) as Date'),
                'Orders.RxNumber','d.rx_label_name','d.strength','d.unit_price', 'Orders.PatientId',
                DB::raw('CONCAT("$ ", FORMAT(d.id, 2)) as rewardAuth'),

                      DB::raw('CONCAT("$ ", FORMAT((d.unit_price+RxPatientOutOfPocket), 2))  as sellingPrice'),

                      //DB::raw('CONCAT("$ ", FORMAT(   ,2))')

                      DB::raw('count(*) as transaction_count'),
                      DB::raw('sum(unit_price) as ingredient_cost'),
                      DB::raw('CONCAT("$ ",d.unit_price) as unit_price'),
                      DB::raw('sum(RxFinalCollect) as total_sale'),
                      'prac.practice_code as practice_code'])
               ->join('drugs_new as d','d.id','Orders.DrugDetailId')
               ->join('PatientProfileInfo as p_info','p_info.Id','Orders.PatientId')
                ->when($d_dates['start_date'], function ($q) use ($d_dates) {

                  $q->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '>=', $d_dates['start_date']);
                   $q->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '<=', $d_dates['end_date']);


               })->groupBy('Orders.Id')->get()->toArray();

            $clients = Order::count(DB::raw('DISTINCT PracticeId'));
          //  $minDate = Order::select(DB::raw('(SELECT DATE_FORMAT(MIN(created_at),"%m/%d/%Y")) as MinDate'))->get();
           // $maxDate = Order::select(DB::raw('(SELECT DATE_FORMAT(MAX(created_at),"%m/%d/%Y")) as MaxDate'))->get();

            if(isset($order) && count($order) > 0)
            {

                    if(session::has('practice')){
                     $this->data_keys = ['transaction_count','total_sale','ingredient_cost','total_order_sale','total_ingredient_cost','total_orders_transactions','practice_type','practice_license_number'];
                    }else{
                     $this->data_keys = ['transaction_count','total_sale','ingredient_cost','total_order_sale','total_ingredient_cost','total_orders_transactions'];
                    }

                    foreach($this->data_keys as $k =>$v)
                    {
                        $get_col_val = array_unique(array_column($order,$v));
                        if(is_array($get_col_val))
                            $values[$k] = $get_col_val[0];
                    }


                    $order= array_map([$this,'removeItem'], $order);

                    $sale_cal = array_combine($this->data_keys,$values);

                    $data['tab_title'] = [ [ 'title'=>'Date', 'style' => 'style=width:90px;'], [ 'title' => 'Rx #', 'style' => 'style=text-algin:center'], 'Rx Label Name', 'Strength', 'Ing Cost','Reward Auth','Selling Price'];

                    return view('reports.accounting',$data,['sale_cal'=>$sale_cal,'invoice_detail'=> $order, 'clients'=>$clients, 'min_date'=>$d_dates['start_date'], 'max_date'=>$d_dates['end_date']]);
            }else{
                    $data['tab_title'] = [ [ 'title'=>'Date', 'style' => 'style=width:90px;'], [ 'title' => 'Rx #', 'style' => 'style=text-algin:center'], 'Rx Label Name', 'Strength', 'Ing Cost','Reward Auth','Selling Price'];
                    $data['count_field'] = count($data['tab_title']);
                    return view('reports.accounting',$data)->with('message',"No record found");
            }
    }

    function removeItem($n){

        return array_diff_key($n, array_flip($this->data_keys));
    }

    function getPatientInfo(Request $request){

         $patient = DB::select( DB::raw('SELECT (SELECT practice_name from practices where id=ppi.Practice_ID Limit 1) as Client,
                    (SELECT practice_type from practices where id=ppi.Practice_ID Limit 1) as ClientType,
                    (SELECT name from users where practice_id=ppi.Practice_ID Limit 1) as UserType,
                    ppi.Gender, LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19") USING "utf8")) AS FirstName,
                    LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19") USING "utf8")) AS LastName,
                    AES_DECRYPT (FROM_BASE64(ppi.BirthDate),"ss20compliance19") AS BirthDate
                    FROM PatientProfileInfo ppi WHERE ppi.Id = '.$request->patientId) );

        return json_encode(@$patient[0]);
    }

    public function searchRxNo(Request $request)
    {
        $orders = order::where('RxNumber', "LIKE", "%".$request->rx_number."%")->with('practice')->groupBy('RxNumber')->take(5)->get();
        if($orders && is_object($orders))
            return response()->json(['status'=>true , 'data'=>$orders]);
        else
            return response()->json(['status'=>true , 'data'=>$orders]);
    }

    public function searchRxDetails(Request $request)
    {
        $createdAt = ($request->created_at != ""? $request->created_at:"");

        $orders = order::where('RxNumber',$request->rx_number)
                ->when($createdAt != "" ,function($query) use ($createdAt){
                    $query->where('created_at', "=", $createdAt.'%');
                })->with('patient','practice.users.roles','drug', 'payment_recived')
                ->orderBy('created_at')->first();

        $dateList = order::where('RxNumber',$request->rx_number)
                ->orderBy('created_at','DESC')->pluck("created_at")->toArray();
        $newList = [];
        foreach($dateList as $data)
        {
            $newList[] = array('simple_date' => date("m-d-Y", strtotime($data)), 'full_date' => date("Y-m-d H:i:s", strtotime($data)));
        }

        if($orders && is_object($orders))
        {
           // dd($orders);
            $orders['signature'] = isset($orders->patient) ? $orders->patient->PaymentSignature:'';
            $orders['signature'] = str_replace(URL::to('/'), '', $orders['signature']);
            $orders['name'] = isset($orders->patient) ? ($orders->patient->FirstName.' '.$orders->patient->LastName):'';
            $orders['EmailAddress'] = isset($orders->patient) ? ($orders->patient->EmailAddress):'';
            $orders->patient->cardNumber = isset($orders->patient->cardNumber) ? substr($orders->patient->cardNumber, -4) : '';
            return response()->json(['status'=>true , 'orders'=>$orders, 'dates'=>$newList, 'fill_count'=>count($newList) ]);
        }else{
            return response()->json(['status'=>true , 'orders'=>$orders, 'dates'=>$newList, 'fill_count'=>count($newList)]);
        }
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

        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
                ->loadView('reports.accounting_invoice_print', $orders);
       // $pdf->setPaper('L', 'landscape');

        return $pdf->download('invoice-'.$request->rx_number.'.pdf');

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

       return view('reports.accounting_invoice_print', $orders);

    }
    
    public function printFaxAccounting($id)
    {       
       $reporter = DB::table('reporter_prescription')->find($id); 
       $prescription['data'] = $reporter;
       $prescription['pharmacy'] = Practice::find($reporter->practice_id); 
       $prescription['hcp'] = \App\User::whereId($reporter->reporter_id)->first()->name;
       $prescription['patient'] = Patient::select(DB::raw('LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(FirstName),"ss20compliance19") USING "utf8")) AS FirstName,
            LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(LastName),"ss20compliance19")USING "utf8")) AS LastName, AES_DECRYPT(FROM_BASE64(BirthDate),"ss20compliance19") AS BirthDate'))->where("Id",$reporter->patient_id)->first();
             
       return view('reports.accounting_fax_print', $prescription);

    }

    public function send_invoice(Request $request){


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
                ->loadView('reports.accounting_invoice_print', $orders);
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



    public function formatDate($date)
    {
        $newDate = explode("-", $date);
        return @$newDate[2]."-".@$newDate[0]."-".@$newDate[1];
    }

    public function get_report(Request $request)
    {
       // dd($request->all());
        ini_set('memory_limit','256M');
       // echo '<pre>';
       // var_dump($request->session()->get('practice_names'));
        if(!empty($request->session()->get('practice_names'))){ $sub_titles = '( '.implode(', ', $request->session()->get('practice_names')).' )'; } else{ $sub_titles =  '(All Pharmacy)'; }


        if($request->report_type=='top_products_sale')
        {

            $data['report_title']  = 'Top Products By Sale '.$sub_titles;
            $response = $this->top_products_sale($request->number_of_days, $request->session());
            $data['count_field'] = count($response['tab_title']);
            $data = array_merge($data,$response);
            return Excel::download(new ReportExport($data), $data['report_title'].'.xlsx');
        }
        if($request->report_type=='rx_refill_due_and_remaining')
        {
            $data['report_title'] = 'Rx Refillable Now & Refills Remaining '.$sub_titles;
            $response = $this->refills_due($request->number_of_days, $request->session());
            $data['count_field'] = count($response['tab_title']);
            $data = array_merge($data,$response);
            return Excel::download(new ReportExport($data), $data['report_title'].'.xlsx');
        }
        if($request->report_type=='product_profitablity')
        {
            $data['report_title'] = 'Top Products By Profitability '.$sub_titles;
            $response = $this->top_product_profitablity($request->number_of_days, $request->session());
            $data['count_field'] = count($response['tab_title']);
            $data = array_merge($data,$response);
            return Excel::download(new ReportExport($data), $data['report_title'].'.xlsx');

        }
        if($request->web_stat=='referrals_generated')
        {
            $response=$this->referrals_generated($request->duration);
            $data['count_field'] = count($response['tab_title']);
            $data = array_merge($data,$response);
            return Excel::download(new ReportExport($data), $data['report_title'].'.xlsx');
        }
        if($request->web_stat=='completed_enrollments')
        {
        	$response=$this->completed_enrollments($request->duration);
        	$data['count_field'] = count($response['tab_title']);
            $data = array_merge($data,$response);
            return Excel::download(new ReportExport($data), $data['report_title'].'.xlsx');
        }
        if($request->web_stat=='refill_reminders')
        {
        	$response=$this->refill_reminders($request->duration);
        	$data['count_field'] = count($response['tab_title']);
            $data = array_merge($data,$response);
            return Excel::download(new ReportExport($data), $data['report_title'].'.xlsx');
        }
        if($request->web_stat=='payments_made')
        {
        	$response=$this->payments_made($request->duration);
        	$data['count_field'] = count($response['tab_title']);
            $data = array_merge($data,$response);
            return Excel::download(new ReportExport($data), $data['report_title'].'.xlsx');
        }
        if($request->web_stat=='member_questions')
        {
        	$response=$this->member_questions($request->duration);
        	$data['count_field'] = count($response['tab_title']);
            $data = array_merge($data,$response);
            return Excel::download(new ReportExport($data), $data['report_title'].'.xlsx');
        }
        if($request->report_type=='cr_program_activity')
        {
        	if($request->from_date)
	        {
	            $d_dates['start_date'] = Carbon::parse($request->from_date)->format('Y-m-d');
	            $d_dates['end_date'] = Carbon::parse($request->to_date)->format('Y-m-d');


	        } else {  $d_dates['start_date'] = Carbon::now()->subDay(15)->format('Y-m-d');
	                    $d_dates['end_date'] =  Carbon::now()->format('Y-m-d'); }


	        $data = [];
	        $data['table_dates'] = array('start_date' => Carbon::parse($d_dates['start_date'])->format('m/d/Y'),
	                                    'end_date' => Carbon::parse($d_dates['end_date'])->format('m/d/Y'));

	         if($request->has('number_of_days'))
	        {
	             $data['number_of_days'] =  $request->number_of_days;
	        }else{ $data['number_of_days'] =  1; }
	        $title_days = 'Past '.$data['number_of_days'].' Days';
	        if($data['number_of_days']==1){ $title_days = 'Now'; }

	        $data['report_title'] = 'All Compliance Reward Program Activity ( '.$title_days.' )';
	        $response = $this->all_cwp_activity_page($d_dates, $request->session());
	        $data['count_field'] = count($response['tab_title']);
	        $data = array_merge($data,$response);
	        return Excel::download(new ReportExport($data), $data['report_title'].'.xlsx');
        }
        if($request->report_type=='all_cwp_activity')
        {
            if($request->number_of_days!='all_activity')
            {
                $d_dates['start_date'] = Carbon::now()->subDay($request->number_of_days)->format('Y-m-d');
                $d_dates['end_date'] =  Carbon::now()->format('Y-m-d');
            }else{
                $d_dates=$request->number_of_days;
            }

        	if($request->has('number_of_days'))
	        {
	             $data['number_of_days'] =  $request->number_of_days;
	        }else{ $data['number_of_days'] =  1; }
	        $title_days = 'Past '.$data['number_of_days'].' Days';
	        if($data['number_of_days']==1){ $title_days = 'Now'; }

	        $data['report_title'] = 'All Compliance Reward Program Activity ( '.$title_days.' )';
	        $response = $this->all_cwp_activity_page($d_dates, $request->session());
	        $data['count_field'] = count($response['tab_title']);
	        $data = array_merge($data,$response);
	        return Excel::download(new ReportExport($data), $data['report_title'].'.xlsx');
        }
        if($request->report_type=='most_referrals')
        {
        	$data['report_title'] = 'Most or Least Program Referrals Report ( Past '.$request->number_of_days.' Days)';
            $response = $this->all_cwp_referrals($request->number_of_days, $request->session());
            $data['count_field'] = count($response['tab_title']);
            $data = array_merge($data,$response);
            return Excel::download(new ReportExport($data), $data['report_title'].'.xlsx');
        }
        if($request->report_type=='all_users')
        {
        	$data['report_title'] = 'All Practice Users Report ( Past '.$request->number_of_days.' Days)';
            $response = $this->all_cwp_users($request->number_of_days, $request->session());
            $data['count_field'] = count($response['tab_title']);
            $data = array_merge($data,$response);
            return Excel::download(new ReportExport($data), $data['report_title'].'.xlsx');
        }
        if($request->report_type=='patient_out_pocket')
        {
        	$data['report_title'] = 'Rx Patient Out Of Pocket ( Past '.$request->number_of_days.' Days)';
            $response = $this->patient_out_pocket($request->number_of_days, $request->session());
            $data['count_field'] = count($response['tab_title']);
            $data = array_merge($data,$response);
            return Excel::download(new ReportExport($data), $data['report_title'].'.xlsx');
        }
        if($request->report_type=='zero_refill_remaining')
        {
        	$data['report_title'] = 'Rx`s with 0 Refills Remaining ( Past '.$request->number_of_days.' Days)';
            $response = $this->zero_refill_remaining($request->number_of_days, $request->session());
            $data['count_field'] = count($response['tab_title']);
            $data = array_merge($data,$response);
            return Excel::download(new ReportExport($data), $data['report_title'].'.xlsx');
        }
        if($request->report_type=='rx_near_expiration')
        {
        	$data['report_title'] = 'Rx Near Expiration ( Next '.$request->number_of_days.' Days)';
            $response = $this->rx_near_expiration($request->number_of_days, $request->session());
            $data['count_field'] = count($response['tab_title']);
            $data = array_merge($data,$response);
            return Excel::download(new ReportExport($data), $data['report_title'].'.xlsx');
        }
        if($request->report_type=='user_statistics')
        {
            $cat = isset($request->category)? strtolower(str_replace([" "],"" ,$request->category)):'DERMATOLOGY';
            $duration=$request->duration??'6';
            $response=$this->user_statistics($cat,$duration);
            $data['count_field'] = count($response['tab_title']);
            $data = array_merge($data,$response);
            return Excel::download(new ReportExport($data), $data['report_title'].'.xlsx');
        }
        if($request->web_stat=='refill_requests')
        {
            $response=$this->refill_requests($request->duration);
            $data['count_field'] = count($response['tab_title']);
            $data = array_merge($data,$response);
            return Excel::download(new ReportExport($data), $data['report_title'].'.xlsx');
        }
        if($request->export_by=='pdf')
        {
            $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,'isPhpEnabled'=> true])
                    ->loadView('reports.reports_displays', $data);
            $pdf->setPaper('L', 'landscape');
               return $pdf->download($data['report_title'].'.pdf');

        }
         $data['export_check'] = 'yes';
        return view('reports.reports_displays', $data);
    }


    public function refills_due($days, $request)
    {
    //    $request = Request::session()->all();
    //    echo $days;
    //    dump($request);
       // dd($request->get('practice_ids'));
        $cur=Carbon::now()->format('Y-m-d');

        $result = Order::join(DB::Raw('(SELECT Id, RxNumber, MIN(RefillsRemaining) AS RefillRemain,MAX(created_at) AS cre FROM Orders where OrderStatus = 8 GROUP BY RxNumber) AS my_tables'), function($query){
            $query->on('my_tables.RxNumber','Orders.RxNumber')
                    ->on('my_tables.cre', 'Orders.created_at');
        })
        ->select([DB::raw('DATE_FORMAT(Orders.created_at,"%m/%d/%y") AS service_date'),
        DB::raw('DATE_FORMAT(Orders.nextRefillDate, "%m-%d-%Y") AS nextRefillDate'),
        DB::raw('CONCAT(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19")USING "utf8"), " ", CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8")) AS patient_name'),
            // 'Orders.Rxnumber',
            DB::raw('CASE WHEN pct.practice_code IS NULL THEN ( case when Orders.RefillCount < 9 then concat(Orders.Rxnumber,"-0",Orders.RefillCount) else concat(Orders.Rxnumber,"-",Orders.RefillCount) end) ELSE (CONCAT(pct.practice_code, "-", case when Orders.RefillCount < 9 then concat(Orders.Rxnumber,"-0",Orders.RefillCount) else concat(Orders.Rxnumber,"-",Orders.RefillCount) end)) END as RxNumber'),
            'd.ndc','d.marketer AS marketer','d.gcn_seq','d.major_reporting_cat','d.minor_reporting_class','d.rx_label_name AS rx_label_name','d.brand_reference','d.dosage_form', 'd.Strength','Orders.DaysSupply AS day_supply','Orders.Quantity', 'Orders.RefillsRemaining AS RefillsRemaining',DB::raw('DATE_FORMAT(Orders.RxExpiryDate,"%m/%d/%y") AS rx_expiry'),'Orders.PrescriberName AS pres_name','Orders.PrescriberPhone AS pres_phone','Orders.InsuranceType AS ins_type',DB::raw('CONCAT("$ ",FORMAT(Orders.RxIngredientPrice,2)) AS ing_cost'),DB::raw('CONCAT("$ ",FORMAT(Orders.RxThirdPartyPay,2)) AS third_pay'),DB::raw('Orders.RxPatientOutOfPocket AS patient_out_pocket'),
            DB::raw('CASE WHEN Orders.asistantAuth = 0 THEN "N" ELSE "Y" END AS assit_auth'),DB::raw('CONCAT("$ ",FORMAT(crp.CurrentEarnReward,2)) AS reward_auth'),DB::raw('CONCAT("$ ",FORMAT(Orders.asistantAuth/4,2)) AS acti_dis'),  DB::raw('CONCAT(crp.ActivityCount," of 4") AS activity_count'),DB::raw('CONCAT("$ ",FORMAT(Orders.RxFinalCollect,2)) AS selling_price'),DB::raw('Orders.RxProfitability AS rx_profitability'),DB::raw('FORMAT((Orders.RxProfitability/Orders.RxPatientOutOfPocket),2) AS avm'),

        	// DB::raw('CONCAT("$ ",FORMAT(15,2)) AS base_fee'),
            // DB::raw('CONCAT("$ ",FORMAT((0.1*Orders.RxProfitability),2)) AS profit_share'),

            DB::raw('(CASE WHEN Orders.asistantAuth = 0 THEN (SELECT srv.base_fee FROM services AS srv WHERE srv.practice_id = Orders.PracticeId LIMIT 1)  END) As base_fee'),
            DB::raw('(CASE WHEN Orders.asistantAuth != 0 AND Orders.RxProfitability >0 THEN ((SELECT srv.profit_share FROM  services AS srv WHERE srv.practice_id = Orders.PracticeId LIMIT 1)/100)*(Orders.RxProfitability)  END)  AS profit_share'),
            DB::raw('(CASE WHEN Orders.asistantAuth != 0 THEN (SELECT srv.fee FROM  services AS srv  WHERE srv.practice_id = Orders.PracticeId LIMIT 1)  END) As cr_service_fee'),
        	// DB::raw('CONCAT("$ ",FORMAT((CASE WHEN Orders.RxFinalCollect >= 20 THEN (Orders.RxPatientOutOfPocket + 5) + (0.1*Orders.RxProfitability) ELSE (Orders.RxPatientOutOfPocket + 5) END ) ,2 ))AS service_fee'),

        	// DB::raw('CONCAT("$ ",FORMAT((15 + (0.1*Orders.RxProfitability)) ,2)) AS service_fee'),
                                ])
                                ->join('drugs_new AS d', 'd.id', '=', 'Orders.DrugDetailId')

                                ->join('practices AS pct', 'pct.Id', '=', 'Orders.PracticeId')
                                ->join('PatientProfileInfo AS ppi', 'ppi.Id', '=', 'Orders.PatientId')
                                ->leftJoin('NotificationMessages as nm', function ($join) {
                                    $join->on('nm.OrderID','Orders.Id')
                                         ->where('nm.MessageTypeId', 28);
                                })
                                ->leftJoin('RewardHistory AS reh', 'reh.PatientId', '=', 'Orders.PracticeId')
                                ->leftJoin('RewardPoints AS rp', 'rp.Id', '=', 'reh.RewardPointId')
                                ->LeftJoin('ComplianceRewardPoint AS crp','crp.RewardId','=','Orders.Cr_Point_Id')
            
                      
                  ->when($days!='all_activity', function ($query) use ($days) {

                    // $start_date  = Carbon::now()->subDay(1)->format('Y-m-d');
                    // $end_date  = Carbon::now()->addDays($days+1)->format('Y-m-d');
                    // $query->whereBetween(DB::raw('Orders.nextRefillDate'), array($start_date, $end_date));
                    // $end_date = \Carbon\Carbon::now()->addDays(3)->format('Y-m-d');
                    $end_date = \Carbon\Carbon::now()->format('Y-m-d');

                    $start_date = \Carbon\Carbon::now()->subDays($days)->format('Y-m-d');
                    $query->where('Orders.nextRefillDate', '>=', $start_date);
                    $query->where('Orders.nextRefillDate', '<=', $end_date);

            })->when(!empty($request->get('practice')->id), function($query) use ($request){
                    $query->whereIn('Orders.PracticeId', $request->get('practice')->id);
            })
            ->where('Orders.OrderStatus','=',8)
            ->where('Orders.RefillsRemaining','!=',0)
            // ->orderBy('patient_name', 'asc')
            ->orderBy('nextRefillDate', 'DESC')
            ->orderBy('Orders.created_at', 'DESC')
            ->get();
   
/*   old report dont remomve this update as per riaz sb , shahzad and javed 21-8-2020*/

            /*         $result = Order::select([DB::raw('DATE_FORMAT(Orders.created_at,"%m/%d/%y") AS service_date'),DB::raw('DATE_FORMAT(Orders.nextRefillDate, "%m-%d-%Y") AS nextRefillDate'),DB::raw('CONCAT(CONVERT(AES_DECRYPT (FROM_BASE64(p.FirstName),"ss20compliance19")USING "utf8"), " ", CONVERT(AES_DECRYPT (FROM_BASE64(p.LastName),"ss20compliance19")USING "utf8")) AS patient_name'),
            // 'Orders.Rxnumber',
            DB::raw('CASE WHEN pct.practice_code IS NULL THEN ( case when Orders.RefillCount < 9 then concat(Orders.Rxnumber,"-0",Orders.RefillCount) else concat(Orders.Rxnumber,"-",Orders.RefillCount) end) ELSE (CONCAT(pct.practice_code, "-", case when Orders.RefillCount < 9 then concat(Orders.Rxnumber,"-0",Orders.RefillCount) else concat(Orders.Rxnumber,"-",Orders.RefillCount) end)) END as RxNumber'),
            'd.ndc','d.marketer AS marketer','d.gcn_seq','d.major_reporting_cat','d.minor_reporting_class','d.rx_label_name AS rx_label_name','d.brand_reference','d.dosage_form', 'd.Strength','Orders.DaysSupply AS day_supply','Orders.Quantity', 'Orders.RefillsRemaining AS RefillsRemaining',DB::raw('DATE_FORMAT(Orders.RxExpiryDate,"%m/%d/%y") AS rx_expiry'),'Orders.PrescriberName AS pres_name','Orders.PrescriberPhone AS pres_phone','Orders.InsuranceType AS ins_type',DB::raw('CONCAT("$ ",FORMAT(Orders.RxIngredientPrice,2)) AS ing_cost'),DB::raw('CONCAT("$ ",FORMAT(Orders.RxThirdPartyPay,2)) AS third_pay'),DB::raw('Orders.RxPatientOutOfPocket AS patient_out_pocket'),
            DB::raw('CASE WHEN Orders.asistantAuth = 0 THEN "N" ELSE "Y" END AS assit_auth'),DB::raw('CONCAT("$ ",FORMAT(Orders.asistantAuth,2)) AS reward_auth'),DB::raw('CONCAT("$ ",FORMAT(Orders.asistantAuth/4,2)) AS acti_dis'),  DB::raw('CONCAT(crp.ActivityCount," of 4") AS activity_count'),DB::raw('CONCAT("$ ",FORMAT(Orders.RxFinalCollect,2)) AS selling_price'),DB::raw('Orders.RxProfitability AS rx_profitability'),DB::raw('FORMAT((Orders.RxProfitability/Orders.RxPatientOutOfPocket),2) AS avm'),

        	// DB::raw('CONCAT("$ ",FORMAT(15,2)) AS base_fee'),
            // DB::raw('CONCAT("$ ",FORMAT((0.1*Orders.RxProfitability),2)) AS profit_share'),

            DB::raw('(CASE WHEN Orders.asistantAuth = 0 THEN (SELECT srv.base_fee FROM services AS srv WHERE srv.practice_id = Orders.PracticeId LIMIT 1)  END) As base_fee'),
            DB::raw('(CASE WHEN Orders.asistantAuth != 0 AND Orders.RxProfitability >0 THEN ((SELECT srv.profit_share FROM  services AS srv WHERE srv.practice_id = Orders.PracticeId LIMIT 1)/100)*(Orders.RxProfitability)  END)  AS profit_share'),
            DB::raw('(CASE WHEN Orders.asistantAuth != 0 THEN (SELECT srv.fee FROM  services AS srv  WHERE srv.practice_id = Orders.PracticeId LIMIT 1)  END) As cr_service_fee'),
        	// DB::raw('CONCAT("$ ",FORMAT((CASE WHEN Orders.RxFinalCollect >= 20 THEN (Orders.RxPatientOutOfPocket + 5) + (0.1*Orders.RxProfitability) ELSE (Orders.RxPatientOutOfPocket + 5) END ) ,2 ))AS service_fee'),

        	// DB::raw('CONCAT("$ ",FORMAT((15 + (0.1*Orders.RxProfitability)) ,2)) AS service_fee'),
                                ])
                ->join('drugs_new AS d', 'd.id', '=', 'Orders.DrugDetailId')
                ->join('PatientProfileInfo AS p', 'p.Id', '=', 'Orders.PatientId')
                ->join('practices AS pct', 'pct.id', '=', 'Orders.PracticeId')
                ->LeftJoin('ComplianceRewardPoint AS crp','crp.RewardId','=','Orders.Cr_Point_Id')
                ->when($days!='all_activity', function ($query) use ($days) {

                    $start_date  = Carbon::now()->subDay(1)->format('Y-m-d');
                    $end_date  = Carbon::now()->addDays($days+1)->format('Y-m-d');
                    $query->whereBetween(DB::raw('Orders.nextRefillDate'), array($start_date, $end_date));

            })->when(!empty($request->get('practice')->id), function($query) use ($request){
                    $query->whereIn('Orders.PracticeId', $request->get('practice')->id);
            })->where('Orders.OrderType','=','Refill')->orderBy('patient_name', 'asc')->groupBy('Orders.Id')->get();
*/

            $result->filter(function($val,$key){
                if($val['profit_share']<0)
                {
                    $val['system_fee']='$ '.number_format($val['cr_service_fee'],2);
                }else{
                   $val['system_fee']='$ '.number_format(($val['cr_service_fee']+$val['profit_share']),2); 
                }
            	
            	$val['activity_transmit']='$ '.number_format(($val['patient_out_pocket']/4),2);
                $val['net_phar_profit']=number_format(($val['rx_profitability']-($val['cr_service_fee']+$val['profit_share'])),2);
                if($val['net_phar_profit']<0)
                {
                    $val['net_phar_profit']='$ ('.number_format(abs($val['rx_profitability']-($val['cr_service_fee']+$val['profit_share'])),2).')';
                }else{
            	$val['net_phar_profit']='$ '.number_format(($val['rx_profitability']-($val['cr_service_fee']+$val['profit_share'])),2);
                }
            	$val['base_fee']='$ '.number_format($val['base_fee'],2);
            	$val['profit_share']='$ '.number_format($val['profit_share'],2);
            	$val['rx_profitability']='$ '.number_format($val['rx_profitability'],2);
            	$val['patient_out_pocket']='$ '.number_format($val['patient_out_pocket'],2);
                $val['cr_service_fee']='$ '.number_format($val['cr_service_fee'],2);
            	return $val;
            });
            $data['result'] = $result->toArray();
           
            $data['tab_title'] = [
                // [ 'title' => 'Sr.', 'style' => 'background-color: #808080;color: #FFFFFF;'],
            [ 'title' => 'Service Date', 'style' => "background-color: #808080;color: #FFFFFF;"],
             ['title'=>'Next Refill Date','style'=>'background-color: #aeaaaa;color: #FFFFFF;'],
             ['title'=> 'Patient Name','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=> 'Rx Number','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=> 'NDC','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=> 'Marketer','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=> 'GCN_SEQ','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=> 'MAJOR REPORTING CATEGORY','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=> 'MINOR REPORTING CLASS','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=> 'RX Label Name','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=> 'Generic For','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=> 'Dosage Form','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=> 'Strength','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=> 'Days Supply','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=> 'Quantity','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=> 'Refills Remaining','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=> 'Rx Expires','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=> 'Prescriber Name','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=> 'Prescriber Phone','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=> 'INSURED','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=> 'RX INGREDIENT COST','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=> '3rd Party Paid','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=> 'Patient Out of Pocket','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=> 'Assistance Authorized','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=> 'Reward Authorized','style'=>'background-color: #daeef3;color:#002060'],
             ['title'=> '1/4 Activity Distribution','style'=>'background-color: #acb9ca;color:#002060'],
             ['title'=> 'Activity Number','style'=>'background-color: #acb9ca;color:#fff2cc'],
             ['title'=> 'Selling Price','style'=>'background-color: #808080;color: #FFFF00;'],
             ['title'=> 'Rx Profitability','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=> '(AVM) Activity Value Multiplier','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=> 'Compliance Reward Base Fee','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=> 'Compliance Reward Profit Share','style'=>'background-color: #00b04f;color: #FFFFFF;'],
             ['title'=> 'Compliance Reward SERVICE FEE','style'=>'background-color: #00b04f;color:#FFFFFF'],
             ['title'=> 'Total Payment System Fees','style'=>'background-color: #00b04f;color:#FFFFFF'],
             ['title'=> '1/4 Activity Distribution','style'=>'background-color: #acb9ca;color:#fff2cc'],
             ['title'=> 'Net Pharmacy Profit (after FEES)','style'=>'background-color: #808080;color: #FFFFFF;']
             ];
             $data['col_style']=['','background-color: #aeaaaa;','','text-align: right;color:#4473c4;','','',
             'background-color: #808080;color:#FFFF00;','background-color:#d6dce4;color: #0070c0;',
             '','','','','','','text-align:right;','','','','','','text-align:right;','text-align:right;','text-align:right;color: #FF0000;','text-align:center;','background-color: #daeef3;color:#002060;text-align:right;','text-align:right;background-color: #acb9ca;color: #002060;','background-color: #acb9ca;color: #fff2cc;','text-align: right;','text-align:right;','text-align:right;','text-align:right;','text-align:right;background-color: #00b04f;color:#FFFFFF','text-align:right;background-color: #00b04f;color:#FFFFFF;','text-align:right;background-color: #00b04f;color:#FFFFFF;','text-align:right;background-color: #acb9ca;color:#fff2cc;',
             'text-align:right;color: #808080;'];
             // dd($data);
            return $data;
    }


    public function top_products_sale($days, $request)
    {
    	$cur=Carbon::now()->format('Y-m-d');
        $result = Order::select(['d.ndc AS ndc','d.rx_label_name AS rx_label_name','d.dosage_form AS dosage_form',
                                'd.strength AS strength', 'd.marketer AS marketer', 'd.gcn_seq AS gen_seq',
                                'd.major_reporting_cat AS mjr_cat', 'd.minor_reporting_class AS mnr_cat',  DB::raw('SUM(Orders.Quantity) AS quantity'),DB::raw('COUNT(CASE WHEN Orders.`OrderType` IS NULL THEN Orders.Id END) AS unique_prescriptions'),
                                DB::raw('CONCAT("$", " ", FORMAT(SUM(Orders.RxIngredientPrice), 2)) AS ingredient_price'),
                                 DB::raw('CONCAT("$", " ", FORMAT( SUM(Orders.RxThirdPartyPay), 2)) AS RxThirdPartyPay'),  DB::raw('CONCAT("$", " ", FORMAT( SUM(Orders.RxPatientOutOfPocket), 2)) AS RxPatientOutOfPocket'),
                                DB::raw('CONCAT("$", " ", FORMAT( SUM(Orders.RxSelling), 2)) AS RxSelling'),  DB::raw('SUM(Orders.RxProfitability) AS RxProfitability'),
                                // DB::raw('CONCAT("$ ",FORMAT(SUM(15),2)) AS base_fee'),
                                DB::raw('SUM((CASE WHEN Orders.asistantAuth = 0 THEN (SELECT srv.base_fee FROM practices AS prac JOIN services AS srv ON prac.id = srv.practice_id WHERE srv.practice_id = Orders.PracticeId LIMIT 1) ELSE (SELECT srv.fee FROM practices AS prac JOIN services AS srv ON prac.id = srv.practice_id WHERE srv.practice_id = Orders.PracticeId LIMIT 1) END)) AS base_fee'),
                                DB::raw('SUM((CASE WHEN Orders.asistantAuth !=0 THEN ((SELECT srv.profit_share FROM practices AS prac JOIN services AS srv ON prac.id = srv.practice_id WHERE srv.practice_id = Orders.PracticeId LIMIT 1)/100)*(Orders.RxProfitability) END)) AS profit_share'),
                                // DB::raw('CONCAT("$ ",FORMAT((CASE WHEN SUM(Orders.RxSelling) >= 20 THEN (SUM(Orders.RxPatientOutOfPocket) + 5) + (0.1*SUM(Orders.RxProfitability)) ELSE (SUM(Orders.RxPatientOutOfPocket) + 5) END ) ,2 ))AS service_fee'),
                                // DB::raw('CONCAT("$ ",FORMAT((SUM(15) + (0.1*SUM(Orders.RxProfitability))) ,2)) AS service_fee'),
                                DB::raw('FORMAT((((FORMAT(SUM(Orders.RxSelling),2)-FORMAT(SUM(Orders.RxIngredientPrice),2))/FORMAT(SUM(Orders.RxSelling),2))*100),2) AS for_gross_margin')
                                // DB::raw('CONCAT("$ ",FORMAT(SUM(Orders.RxProfitability)-(SUM(15) + (0.1*SUM(Orders.RxProfitability))),2)) AS pharmacy_profit')
                              //  DB::raw('CONCAT("$", " ", FORMAT( SUM((Orders.Quantity * d.unit_price)), 2 )) AS total_sale')
                                ])
                ->join('drugs_new AS d', 'd.id', '=', 'Orders.DrugDetailId')
            ->when($days!='all_activity', function ($query) use ($days) {

                     $end_date = Carbon::now()->format('m/d/Y');
                     $start_date = Carbon::now()->subDay($days)->format('m/d/Y');
                    $query->whereBetween(DB::raw('DATE_FORMAT(Orders.created_at, "%m/%d/%Y")'), array($start_date, $end_date));

            })->when(!empty($request->get('practice')->id), function($query) use ($request){
                    $query->whereIn('Orders.PracticeId', $request->get('practice')->id);
            })->orderBy('quantity', 'desc')->groupBy('d.id')->get();


       		$result->filter(function($value,$key){
       			$value['service_fee']='$ '.number_format(($value['base_fee']+$value['profit_share']),2);
       			$value['gross_margin']=$value['for_gross_margin'];
       			$value['pharmacy_profit']='$ '.number_format(($value['RxProfitability']-($value['base_fee']+$value['profit_share'])),2);
       			$value['RxProfitability']='$ '.number_format($value['RxProfitability'],2);
       			$value['base_fee']='$ '.number_format($value['base_fee'],2);
       			$value['profit_share']='$ '.number_format($value['profit_share'],2);
       			unset($value['for_gross_margin']);
       		});
            $data['result'] = $result->toArray();
            $data['tab_title'] = [
                // [ 'title'=>'Sr.','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title' =>'NDC','style'=>'background-color: #808080;color: #FFFFFF;'] ,
             [ 'title' => 'Rx Label Name','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title' =>'Dosage Form','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title' =>'Strength','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title' =>'Marketer Name','style'=>'background-color: #808080;color: #FFFFFF;'],
            [ 'title' => 'GCN SEQ.','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=>'Major Cat' ,'style'=>'background-color: #808080;color: #FFFFFF;'],
              ['title' =>'Minor Therapeutic','style'=>'background-color: #808080;color: #FFFFFF;'] ,
              ['title' =>'Qty','style'=>'background-color: #808080;color: #FFFFFF;'],
              ['title' =>'Unique Prescription','style'=>'background-color: #808080;color: #FFFFFF;'],
               ['title' =>'Rx Ingredient','style'=>'background-color: #808080;color: #FFFFFF;'],
               ['title' =>'3rd Party','style'=>'background-color: #808080;color: #ffff00;;'],
               ['title' =>'Patient Pocket','style'=>'background-color: #808080;color: #ffff00;'],
               ['title' =>'Rx Sale','style'=>'background-color: #808080;color: #ffff00;'],
               ['title' =>'Rx Profitability','style'=>'background-color: #808080;color: #FFFFFF;'],
               ['title' =>'Compliance Reward Base Fee','style'=>'background-color: #808080;color: #FFFFFF;'],
               ['title' =>'Compliance Reward Profit Share','style'=>'background-color: #808080;color: #FFFFFF;'],
               ['title' =>'IMV Service Fee','style'=>'background-color: #00b04f;color: #FFFFFF;'],
               ['title' =>'Gross Margin','style'=>'background-color: #808080;color: #ffff00;'],
               ['title' =>'Net Pharmacy Profitability','style'=>'background-color: #808080;color: #FFFFFF;']];
               $data['col_style']=['' ,'','', '','','background-color: #808080;color: #FFFF00;','color: #0070c0;background-color: #d6dce4;','','','',
               'text-align:right;',
               'text-align:right;',
               'text-align:right;color: #FF0000;',
               'text-align:right;',
               'text-align:right;','text-align:right;','text-align:right;',
               'text-align:right;background-color: #00b04f;color: #FFFFFF;', 'text-align:right;',
               'text-align:right;'];
            return $data;
    }
    public function top_product_profitablity($days, $request)
    {
    	$cur=Carbon::now()->format('Y-m-d');
        $result = Order::select([ 'd.rx_label_name AS rx_label_name','d.ndc AS ndc', 'd.marketer AS marketer', 'd.gcn_seq AS gen_seq','d.major_reporting_cat AS mjr_cat','d.minor_reporting_class AS mnr_cat','d.dosage_form AS dosage_form','d.Strength AS Strength',DB::raw('COUNT(CASE WHEN Orders.`OrderType` IS NULL THEN Orders.Id END) AS unique_prescriptions'),DB::raw('SUM(Orders.Quantity) AS quantity'),DB::raw('CONCAT("$ ",FORMAT(SUM(Orders.RxIngredientPrice),2)) AS rxIngcost'),DB::raw('CONCAT("$ ",FORMAT(SUM(Orders.RxThirdPartyPay),2)) AS rx_third_pay'),DB::raw('CONCAT("$ ",FORMAT(SUM(Orders.RxPatientOutOfPocket),2)) AS rx_patient_pay'),DB::raw('CONCAT("$ ",FORMAT(SUM(Orders.RxSelling),2)) AS rx_selling'),DB::raw('SUM(Orders.RxProfitability) AS rxprofit'),DB::raw('FORMAT((((FORMAT(SUM(Orders.RxSelling),2)-FORMAT(SUM(Orders.RxIngredientPrice),2))/FORMAT(SUM(Orders.RxSelling),2))*100),2) AS gross_margin'),
        	// DB::raw('CONCAT("$ ",FORMAT(SUM(15),2)) AS base_fee'),
        	// DB::raw('CONCAT("$ ",FORMAT((0.1*SUM(Orders.RxProfitability)),2)) AS profit_share'),
        	DB::raw('SUM((CASE WHEN Orders.asistantAuth = 0 THEN (SELECT srv.base_fee FROM practices AS prac JOIN services AS srv ON prac.id = srv.practice_id WHERE srv.practice_id = Orders.PracticeId LIMIT 1) ELSE (SELECT srv.fee FROM practices AS prac JOIN services AS srv ON prac.id = srv.practice_id WHERE srv.practice_id = Orders.PracticeId LIMIT 1) END)) AS base_fee'),
             DB::raw('SUM((CASE WHEN Orders.asistantAuth != 0 THEN ((SELECT srv.profit_share FROM practices AS prac JOIN services AS srv ON prac.id = srv.practice_id WHERE srv.practice_id = Orders.PracticeId LIMIT 1)/100)*(Orders.RxProfitability)  END)) AS profit_share'),
        	// DB::raw('CONCAT("$ ",FORMAT((CASE WHEN SUM(Orders.RxSelling) >= 20 THEN (SUM(Orders.RxPatientOutOfPocket) + 5) + (0.1*SUM(Orders.RxProfitability)) ELSE (SUM(Orders.RxPatientOutOfPocket) + 5) END ) ,2 ))AS service_fee'),
        	// DB::raw('CONCAT("$ ",FORMAT((SUM(15) + (0.1*SUM(Orders.RxProfitability))) ,2)) AS service_fee'),
        	// DB::raw('CONCAT("$ ",FORMAT(SUM(Orders.RxProfitability)-(SUM(15) + (0.1*SUM(Orders.RxProfitability))),2)) AS pharmacy_profit')
        	 ])->join('drugs_new AS d', 'd.id', '=', 'Orders.DrugDetailId')
               ->when($days!='all_activity', function ($query) use ($days) {

                                 $end_date = Carbon::now()->format('Y-m-d');

                                $start_date = Carbon::now()->subDay($days)->format('Y-m-d');
                               $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '>=', $start_date);
                                $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '<=', $end_date);
                            })->when(!empty($request->get('practice')), function($query) use ($request){

                                $query->whereIn('Orders.PracticeId', $request->get('practice'));
                            })->orderBy(DB::raw('SUM(Orders.RxProfitability)'), 'desc')->groupBy('d.id')->get();

       // dd($result->all());
             $result->filter(function ($value, $key) {
             		$value['service_fee']='$ '.number_format(($value['base_fee']+$value['profit_share']),2);
             		$value['pharmacy_profit']='$ '.number_format(($value['rxprofit']-($value['base_fee']+$value['profit_share'])),2);
                    $value['quantity'] = number_format($value['quantity'], 1);
                    $value['base_fee'] = '$ '.number_format($value['base_fee'], 2);
                    $value['profit_share'] = '$ '.number_format($value['profit_share'], 2);
                    $value['rxprofit'] = '$ '.number_format($value['rxprofit'], 2);
                    return $value;
                });

            $data['result'] = $result->toArray();
         
            $data['tab_title'] = [
             // [ 'title'=>'Sr','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'Rx Label Name','style'=>'background-color: #808080;color: #FFFFFF;'],
             [ 'title'=>'NDC','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=>'Marketer','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=>'GCN SEQ','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=>'Major Therapeutic','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=>'Minor Therapeutic','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=>'Dosage Form','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=>'Strength','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=>'Unqiue Prescription','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=>'Qty','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=>'Rx Ingredient','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=>'3rd Party','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=>'Patient Pocket','style'=>'background-color: #808080;color: #ffff00;'],
             ['title'=>'Rx Sale','style'=>'background-color: #808080;color: #ffff00;'],
             ['title'=>'Rx Profitability','style'=>'background-color: #808080;color: #ffff00;'],
             ['title'=>'Gross Margin','style'=>'background-color: #aeaaaa;color: #FFFFFF;'],
             ['title'=>'Compliance Reward Base Fee','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=>'Compliance Reward Profit Share','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=>'Service Fee','style'=>'background-color: #00b04f;color: #FFFFFF;'],
             ['title'=>'Pharmacy profit','style'=>'background-color: #808080;color: #FFFFFF;'] ];

            $data['col_style'] = ['color: #4473c4;','background-color: #f2f2f2;','background-color: #f2f2f2;',
            'background-color: #808080;color: #FFFF00;','color: #0070c0;background-color: #d6dce4;','background-color: #f2f2f2;','background-color: #f2f2f2;',
            'background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;','text-align:right;'
            ,'text-align:right;','text-align:right;color: #FF0000;','text-align:right;','text-align:right;','text-align:right;background-color: #aeaaaa;','text-align:right;','text-align:right;','text-align:right;color: #FFFFFF;background-color: #00b04f;','text-align:right;background-color: #f2f2f2;'];

            return $data;

    }
    public function referrals_generated($days)
    {

        $result = Order::select([ DB::raw('DATE_FORMAT(Orders.created_at,"%m/%d/%y %h:%i %p") AS service_date'),
           // DB::raw('DATE_FORMAT(Orders.created_at,"%h:%i %p") AS service_time'),
            'pr.practice_name AS practice_name', DB::raw('CONCAT(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19") USING "utf8"), " ", CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8")) AS PatName'),DB::raw('CONCAT("$ ", FORMAT(Orders.RxIngredientPrice, 2)) AS igred_cost'),DB::raw('CONCAT("$ ", FORMAT(Orders.RxFinalCollect, 2)) AS selling_price'),
            DB::raw('Orders.RxFinalCollect AS for_sum_selling_price'), DB::raw('Orders.RxIngredientPrice AS for_sum_igred_cost'),
            DB::raw('FORMAT(`rp`.`Points`, 2) AS reward_auth'),DB::raw('`rp`.`Points` AS for_reward_auth'),'d.gcn_seq','d.rx_label_name AS rx_label_name',
            'd.major_reporting_cat AS mjr_cat','d.Strength AS Strength','d.dosage_form AS dosage_form',
            DB::raw('Orders.Quantity AS qty'),DB::raw('Orders.RefillsRemaining AS refillRemain'),'Orders.RxNumber',DB::raw('(SELECT u.name FROM users AS u WHERE u.practice_id=pr.id ORDER BY u.id ASC LIMIT 1) AS userName')])
                ->join('practices AS pr', 'pr.id', '=', 'Orders.PracticeId')
                ->join('drugs_new AS d', 'd.id', '=', 'Orders.DrugDetailId')
                ->join('PatientProfileInfo AS ppi','ppi.Id','=','Orders.PatientId')
                ->leftJoin('RewardHistory AS reh', 'reh.PatientId', '=', 'Orders.PracticeId')
                ->leftJoin('RewardPoints AS rp', 'rp.Id', '=', 'reh.RewardPointId')
                ->when($days!='all_activity', function ($query) use ($days) {

                             $end_date = Carbon::now()->format('Y-m-d');

                            $start_date = Carbon::now()->subDay($days)->format('Y-m-d');
                            $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '>=', $start_date);
                                $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '<=', $end_date);

                            })->get();
                // ->groupBy('pr.practice_name')

        if($days ==1){ $durationD = 'Now'; }
        else{ $durationD = 'Past '.$days.' Days'; }
        $data['report_title'] = 'SUMMARY REFERRALS GENERATED ( '.$durationD.' )';

        $data['for_sum_selling_price'] = '$ '.number_format($result->sum('for_sum_selling_price'), 2);
        $data['for_sum_igred_cost']='$ '.number_format($result->sum('for_sum_igred_cost'), 2);
        $data['for_sum_reward_auth']='$ '. number_format($result->sum('for_reward_auth'),2);
       $result->filter(function ($value, $key) {
                    unset($value['for_sum_igred_cost']);
                    unset($value['for_sum_selling_price']);
                    unset($value['for_reward_auth']);
                   $value['service']='PMCY REF';

                    return $value;
                });

        $data['result'] = $result->toArray();

        $data['tab_title'] = [
         // [ 'title' => 'Sr.','style'=>'background-color: #808080;color: #FFFFFF;'],
         ['title'=>'Service Date','style'=>'background-color: #808080;color: #FFFFFF;'],
         // ['title'=>'Service Time','style'=>'background-color: #808080;color: #FFFFFF;'],
         ['title'=>'ASSOCIATE CLIENT NAME','style'=>'background-color: #808080;color: #FFFFFF;'],
        ['title'=>'Client User','style'=>'background-color: #808080;color: #FFFFFF;'],
        ['title'=>'IGRED COST','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'SELLING PRICE','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=>'REWARD AUTH','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=>'GCN SEQ','style'=>'background-color: #808080;color: #FFFFFF;'],['title'=>'Major Therapeutic','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=>'Rx Label Name','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=>'Strength','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=>'Dosage Form','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=>'Qty','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=>'Refills Remain','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=>'Rx Number','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=>'CR Rep User','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=>'Service','style'=>'background-color: #808080;color: #FFFFFF;'] ];

      	$data['col_style']=['background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;',
      	'text-align:right;color: #FF0000;','text-align:right;color: #0070c0;','text-align:right;','background-color: #f2f2f2;',
      	'background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;'];
        return $data;
    }
    public function completed_enrollments($days)
    {

        $result = Order::select([DB::raw('DATE_FORMAT(Orders.created_at,"%m/%d/%y %h:%i %p") AS service_date'),
            // DB::raw('DATE_FORMAT(Orders.created_at,"%h:%i %p") AS service_time'),
            'pr.practice_name AS practice_name',
        	DB::raw('CONCAT(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19") USING "utf8"), " ", CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8")) AS PatName'),
        	DB::raw('CONCAT("$ ", FORMAT(Orders.RxIngredientPrice, 2)) AS igred_cost'),DB::raw('CONCAT("$ ", FORMAT(Orders.RxFinalCollect, 2)) AS selling_price'),
            DB::raw('Orders.RxFinalCollect AS for_sum_selling_price'), DB::raw('Orders.RxIngredientPrice AS for_sum_igred_cost'),
            DB::raw('FORMAT(`rp`.`Points`, 2) AS reward_auth'),DB::raw('`rp`.`Points` AS for_reward_auth'),'d.gcn_seq','d.rx_label_name AS rx_label_name',
            'd.major_reporting_cat AS mjr_cat','d.Strength AS Strength','d.dosage_form AS dosage_form',
            DB::raw('Orders.Quantity AS qty'), DB::raw('Orders.RefillsRemaining AS refillRemain'),'Orders.RxNumber',
        DB::raw('(SELECT u.name FROM users AS u WHERE u.practice_id=pr.id ORDER BY u.id ASC LIMIT 1) AS userName')])
                ->join('practices AS pr', 'pr.id', '=', 'Orders.PracticeId')
                ->join('drugs_new AS d', 'd.id', '=', 'Orders.DrugDetailId')
                ->join('PatientProfileInfo AS ppi','ppi.Id','=','Orders.PatientId')
                ->leftJoin('RewardHistory AS reh', 'reh.PatientId', '=', 'Orders.PracticeId')
                ->leftJoin('RewardPoints AS rp', 'rp.Id', '=', 'reh.RewardPointId')
                ->when($days!='all_activity', function ($query) use ($days) {

                                $end_date = Carbon::now()->format('Y-m-d');

                                $start_date = Carbon::now()->subDay($days)->format('Y-m-d');
                                $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '>=', $start_date);
                                $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '<=', $end_date);

                              })->get();
                // ->groupBy('pr.practice_name')

        if($days ==1){
            $durationD = 'Now';
        }else{
            $durationD = 'Past '.$days.' Days';
        }
        $data['report_title'] = 'SUMMARY Completed Enrollments ( '.$durationD.' )';

        // $data['total_row'] = [$result->sum('total_pat'), 'Total', '$ '.number_format($result->sum('for_sum_selling_price'), 2), '$ '.number_format($result->sum('for_sum_igred_cost'), 2), $result->sum('reward_auth'), $result->sum('refillRemain')];
        $data['for_sum_selling_price'] = '$ '.number_format($result->sum('for_sum_selling_price'), 2);
        $data['for_sum_igred_cost']='$ '.number_format($result->sum('for_sum_igred_cost'), 2);
        $data['for_sum_reward_auth']='$'. number_format($result->sum('for_reward_auth'),2);
       $result->filter(function ($value, $key) {
                    unset($value['for_sum_igred_cost']);
                    unset($value['for_sum_selling_price']);
                    unset($value['for_reward_auth']);
                    $value['service']='PMCY REF';
                    return $value;
                });

        $data['result'] = $result->toArray();
        $data['tab_title'] = [
         // [ 'title' => 'Sr.','style'=>'background-color: #808080;color: #FFFFFF;'],
        ['title'=>'Service Date','style'=>'background-color: #808080;color: #FFFFFF;'],
        // ['title'=>'Service Time','style'=>'background-color: #808080;color: #FFFFFF;'],
        ['title'=>'ASSOCIATE CLIENT NAME','style'=>'background-color: #808080;color: #FFFFFF;'],
        ['title'=>'Client User','style'=>'background-color: #808080;color: #FFFFFF;'],
        ['title'=>'IGRED COST','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'SELLING PRICE','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'REWARD AUTH','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'GCN SEQ','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'Major Therapeutic','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'Rx Label Name','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'Strength','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'Dosage Form','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'Qty','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'Refills Remain','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'Rx Number','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'CR Rep User','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'Service','style'=>'background-color: #808080;color: #FFFFFF;'] ];
        $data['col_style']=['background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;',
      	'text-align:right;color: #FF0000;','text-align:right;color: #0070c0;','text-align:right;','text-align:right;background-color: #f2f2f2;',
      	'background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;'];
        return $data;
    }
    public function refill_reminders($days)
    {

        $result = Order::select([DB::raw('DATE_FORMAT(Orders.created_at,"%m/%d/%y") AS service_date'), 'pr.practice_phone_number AS prac_phone','pr.practice_name AS practice_name',
           DB::raw('CONCAT(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19") USING "utf8"), " ", CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8")) AS PatName'),
             DB::raw('CONCAT("$ ", FORMAT(Orders.RxIngredientPrice, 2)) AS igred_cost'),DB::raw('CONCAT("$ ", FORMAT(Orders.RxFinalCollect, 2)) AS selling_price'),
            DB::raw('Orders.RxFinalCollect AS for_sum_selling_price'), DB::raw('Orders.RxIngredientPrice AS for_sum_igred_cost'), DB::raw('`rp`.`Points` AS for_reward_auth'),
            DB::raw('FORMAT(`rp`.`Points`, 2) AS reward_auth'),
            'd.gcn_seq','d.rx_label_name AS rx_label_name','d.Strength AS Strength','d.dosage_form AS dosage_form',
            DB::raw('Orders.Quantity AS qty'), DB::raw('Orders.RefillsRemaining AS refillRemain'),DB::raw('Orders.RefillsRemaining AS refillRemain'),'Orders.RxNumber',
            DB::raw('(SELECT u.name FROM users AS u WHERE u.practice_id=pr.id ORDER BY u.id ASC LIMIT 1) AS userName')  ])

                ->leftJoin('RewardHistory AS reh', 'reh.PatientId', '=', 'Orders.PatientId')
                ->leftJoin('practices AS pr', 'pr.id', '=', 'Orders.PracticeId')
                ->join('drugs_new AS d', 'd.id', '=', 'Orders.DrugDetailId')
                ->join('PatientProfileInfo AS ppi','ppi.Id','=','Orders.PatientId')
                ->leftJoin('NotificationMessages AS NM', 'NM.OrderID', '=', 'Orders.Id')
                ->leftJoin('RewardPoints AS rp', 'rp.Id', '=', 'reh.RewardPointId')
                ->when($days!='all_activity', function ($query) use ($days) {

                               $end_date = Carbon::now()->format('Y-m-d');

                                $start_date = Carbon::now()->subDay($days)->format('Y-m-d');

                            $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '>=', $start_date);
                                $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '<=', $end_date);
                            })->get();
                // ->groupBy('pr.practice_name')


       //->where('NM.MessageTypeId', 12)

        if($days ==1){ $durationD = 'Now'; }
        else{ $durationD = 'Past '.$days.' Days'; }
        $data['report_title'] = 'SUMMARY REFILL REMINDERS SENT ( '.$durationD.' )';

        // $data['total_row'] = [$result->sum('reminder_send'), 'Total', '$ '.number_format($result->sum('for_sum_selling_price'), 2), '$ '.number_format($result->sum('for_sum_igred_cost'), 2),
        //     number_format($result->sum('for_reward_auth'), 2), $result->sum('refillRemain')];
        $data['for_sum_selling_price'] = '$ '.number_format($result->sum('for_sum_selling_price'), 2);
        $data['for_sum_igred_cost']='$ '.number_format($result->sum('for_sum_igred_cost'), 2);
        $data['for_sum_reward_auth']='$'. number_format($result->sum('for_reward_auth'),2);
       $result->filter(function ($value, $key) {
                    unset($value['for_sum_igred_cost']);
                    unset($value['for_sum_selling_price']);
                    unset($value['for_reward_auth']);
                    $value['refillRemain'] = number_format($value['refillRemain'], 0);
                    $value['service']='PHMCY REMNDR';
                    return $value;
                });

        $data['result'] = $result->toArray();
        $data['tab_title'] = [
            // [ 'title' => 'Sr.','style'=>'background-color: #808080;color: #FFFFFF;'],
        ['title'=>'Service Date','style'=>'background-color: #808080;color: #FFFFFF;'],
        ['title'=>'Mobile Number','style'=>'background-color: #808080;color: #FFFFFF;'],
        ['title'=>'Pharmacy Name','style'=>'background-color: #808080;color: #FFFFFF;'],
        ['title'=>'Patient Name','style'=>'background-color: #808080;color: #FFFFFF;'],
        ['title'=>'IGRED COST','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'SELLING PRICE','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'REWARD AUTH','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'GCN SEQ','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'Rx Label Name','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'Strength','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'Dosage Form','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'Qty','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'Refills Remain','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'Rx Number','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'CR Rep User','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'Service','style'=>'background-color: #808080;color: #FFFFFF;'] ];
        $data['col_style']=['background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;',
      	'text-align:right;color: #FF0000;','text-align:right;color: #0070c0;','text-align:right;','text-align:right;background-color: #f2f2f2;',
      	'background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;'];
        return $data;
    }
     public function payments_made($days)
    {


        $result = Order::select([DB::raw('DATE_FORMAT(Orders.created_at,"%m/%d/%y %h:%i %p") AS service_date'),
            // DB::raw('DATE_FORMAT(Orders.created_at,"%h:%i %p") AS service_time'),
              'pr.practice_name AS practice_name',DB::raw('CONCAT(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19") USING "utf8"), " ", CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8")) AS PatName'),
             DB::raw('CONCAT("$ ", FORMAT(Orders.RxIngredientPrice, 2)) AS igred_cost'),DB::raw('CONCAT("$ ", FORMAT(Orders.RxFinalCollect, 2)) AS selling_price'),
            DB::raw('Orders.RxFinalCollect AS for_sum_selling_price'), DB::raw('Orders.RxIngredientPrice AS for_sum_igred_cost'),DB::raw('`rp`.`Points` AS for_reward_auth'),
            DB::raw('FORMAT(`rp`.`Points`, 2) AS reward_auth'),DB::raw('CONCAT("$ ",FORMAT(pay.total_bill_paid ,2)) AS bill_paid'),'d.gcn_seq','d.rx_label_name AS rx_label_name',
            'd.major_reporting_cat AS mjr_cat','d.Strength AS Strength','d.dosage_form AS dosage_form',
            DB::raw('Orders.Quantity AS qty'), DB::raw('Orders.RefillsRemaining AS refillRemain'),'Orders.RxNumber',
            DB::raw('(SELECT u.name FROM users AS u WHERE u.practice_id=pr.id ORDER BY u.id ASC LIMIT 1) AS userName')])
                ->join('practices AS pr', 'pr.id', '=', 'Orders.PracticeId')
                ->join('drugs_new AS d', 'd.id', '=', 'Orders.DrugDetailId')
                ->join('PatientProfileInfo AS ppi','ppi.Id','=','Orders.PatientId')
                ->leftjoin('payment_recived AS pay','pay.order_id','=','Orders.Id')
                ->leftJoin('RewardHistory AS reh', 'reh.PatientId', '=', 'Orders.PracticeId')
                ->leftJoin('RewardPoints AS rp', 'rp.Id', '=', 'reh.RewardPointId')
                ->when($days!='all_activity', function ($query) use ($days) {

                               $end_date = Carbon::now()->format('Y-m-d');

                                $start_date = Carbon::now()->subDay($days)->format('Y-m-d');
                                $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '>=', $start_date);
                                $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '<=', $end_date);
                            })->get();
                // ->groupBy('pr.practice_name')
        if($days ==1){ $durationD = 'Now'; }
        else{ $durationD = 'Past '.$days.' Days'; }
        $data['report_title'] = 'SUMMARY C RWD PAYMENTS MADE ( '.$durationD.' )';

        // $data['total_row'] = [$result->sum('total_pat'), 'Total', '$ '.number_format($result->sum('for_sum_selling_price'), 2), '$ '.number_format($result->sum('for_sum_igred_cost'), 2), $result->sum('reward_auth'), $result->sum('refillRemain')];
        $data['for_sum_selling_price'] = '$ '.number_format($result->sum('for_sum_selling_price'), 2);
        $data['for_sum_igred_cost']='$ '.number_format($result->sum('for_sum_igred_cost'), 2);
        $data['for_sum_reward_auth']='$'. number_format($result->sum('for_reward_auth'),2);
       $result->filter(function ($value, $key) {
                    unset($value['for_sum_igred_cost']);
                    unset($value['for_sum_selling_price']);
                    unset($value['for_reward_auth']);
                    $value['refillRemain'] = number_format($value['refillRemain'], 0);
                    $value['service']='PMT MADE';
                    return $value;
                });

        $data['result'] = $result->toArray();
        $data['tab_title'] = [
            // [ 'title' => 'Sr.','style'=>'background-color: #808080;color: #FFFFFF;'],
        ['title'=>'Service Date','style'=>'background-color: #808080;color: #FFFFFF;'],
        // ['title'=>'Service Time','style'=>'background-color: #808080;color: #FFFFFF;'],
        ['title'=>'ASSOCIATE CLIENT NAME','style'=>'background-color: #808080;color: #FFFFFF;'],
        ['title'=>'Patient Name','style'=>'background-color: #808080;color: #FFFFFF;'],
        ['title'=>'IGRED COST','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'SELLING PRICE','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'REWARD AUTH','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'Payment Made','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'GCN SEQ','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'Major Therapeutic','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'Rx Label Name','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'Strength','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'Dosage Form','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'Qty','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'Refills Remain','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'Rx Number','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'CR Rep User','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'Service','style'=>'background-color: #808080;color: #FFFFFF;']  ];

      	$data['col_style']=['background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;',
      	'text-align:right;color: #FF0000;','text-align:right;color: #0070c0;','text-align:right;','text-align:right;',
      	'background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;'];

        return $data;
    }
    function accountingExport(Request $request)
    {
        if($request->invoice_date)
        {
            $d_dates = $this->get_dates_from_billing_date(Carbon::parse($request->invoice_date)->format('Y-m-d'));
        } else {  $d_dates = $this->get_dates_from_billing_date();  }

        $invoice_code = Carbon::parse($d_dates['invoice_date'])->format('mdy');
    


        //dd($data);

         // $result = Order::select([DB::raw('DATE_FORMAT("'.Carbon::parse($d_dates['invoice_date'])->format('Y-m-d').'", "%m/%d/%Y") as invoice_date'),
         //    DB::raw('(CASE WHEN p.practice_code IS NULL THEN '.$invoice_code.' ELSE CONCAT(p.practice_code,"-'.$invoice_code.'") END) AS invoice_number'),
         //                        // DB::raw('CONCAT(p.practice_code, "-'.$invoice_code.'") AS invoice_number'),
         //                        DB::raw('p.practice_name AS practice_name'),
         //                        DB::raw('p.practice_type AS practice_type'),
         //                        DB::raw('COUNT(Orders.Id) AS Rx_facilitated'),
         //                        DB::raw('SUM(Orders.RxSelling) AS total_sale'),   //order total sale amount
         //                        DB::raw('SUM(Orders.RxProfitability) AS rx_profitability'),
         //                        DB::raw('SUM(Orders.asistantAuth) AS rewardAuth'),
         //                        DB::raw('((SUM(RxProfitability) * 0.1)+ SUM(15)) AS service_fee'),
         //                        //DB::raw(' SUM((CASE WHEN Orders.RxSelling >= 20 THEN ((Orders.RxPatientOutOfPocket + 15.00)+( RxProfitability * 0.1 ) )
         //                               // ELSE (Orders.RxPatientOutOfPocket + 15) END)) AS service_fee')
         //                    ])->join('drugs_new AS d', 'd.id', '=', 'Orders.DrugDetailId')
         //                    ->join('practices AS p', 'p.id', '=', 'Orders.PracticeId')
         //                    ->when($d_dates, function ($query) use ( $d_dates) {
         //                        $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '>=', $d_dates['start_date']);
         //                        $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '<=',  $d_dates['end_date']);
         //                    })->when(Session::has('practice') , function($query){
         //                        $query->where('Orders.PracticeId', Session::get('practice')->id);
         //                    })
         //                    ->when((!isset(auth::user()->practice_id) AND !isset(auth::user()->practice_id)) , function($query){
         //                        $query->addSelect([DB::raw('SUM(15) AS base_fee'), DB::raw('SUM(RxProfitability * 0.1) AS profit_share')]);
         //                    })
         //                    ->when(isset(auth::user()->practice_id), function($query){
         //                        $query->where('PracticeId', auth::user()->practice_id);
         //                })->orderBy('Orders.created_at', 'asc')
         //                    ->groupBy('Orders.PracticeId')->get();

        $result = Order::select([DB::raw('DATE_FORMAT(Orders.created_at, "%m/%d/%Y") as date_service'),DB::raw('(CASE WHEN Orders.RefillCount < 9 THEN CONCAT(Orders.RxNumber,"-0",Orders.RefillCount) ELSE CONCAT(Orders.RxNumber,"-",Orders.RefillCount) END) AS rx_number'),DB::raw('(CASE WHEN Orders.OrderType IS NULL OR Orders.OrderType = "RxOrder" THEN "NEW" ELSE "REFILL" END) AS order_type'),DB::raw('CONCAT(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19") USING "utf8"), " ", CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8")) AS PatName'),
            DB::raw('DATE_FORMAT(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.BirthDate),"ss20compliance19") USING "utf8"),"%m/%d/%Y") AS dob'),'ppi.Gender AS gender','d.ndc','d.marketer','d.gcn_seq','d.rx_label_name','d.dosage_form','d.strength','Orders.Quantity','Orders.InsuranceType',DB::raw('CONCAT("$",FORMAT(Orders.RxIngredientPrice,2)) AS rxIngcost'),DB::raw('CONCAT("$",FORMAT(Orders.RxThirdPartyPay,2)) AS rx_third_pay'),DB::raw('CONCAT("$",FORMAT(Orders.RxPatientOutOfPocket,2)) AS patient_out_pocket'),DB::raw('(CASE WHEN Orders.asistantAuth = 0 THEN "N" ELSE "Y" END) AS assist_auth'),'Orders.asistantAuth AS rewardAuth',DB::raw('CONCAT("$",FORMAT(Orders.asistantAuth/4,2)) AS acti_dis'),DB::raw('CONCAT(crp.ActivityCount," of 4") AS activity_count'),'Orders.RxSelling AS rx_selling','Orders.RxProfitability AS rx_profitability',                                
                               DB::raw('(CASE WHEN Orders.asistantAuth = 0 THEN (SELECT srv.base_fee FROM services AS srv  WHERE  srv.practice_id = Orders.PracticeId  LIMIT 1) END) AS base_fee'),
                               DB::raw('(CASE WHEN Orders.asistantAuth != 0 AND Orders.RxProfitability > 0 THEN ((SELECT srv.profit_share FROM services AS srv WHERE srv.practice_id = Orders.PracticeId LIMIT 1)/100)*(Orders.RxProfitability)  END) AS profit_share'),
                               DB::raw('(CASE WHEN Orders.asistantAuth != 0 THEN (SELECT srv.fee FROM services AS srv WHERE  srv.practice_id = Orders.PracticeId LIMIT 1)  END) AS cr_service_fee'),
                               // DB::raw('(CASE WHEN Orders.asistantAuth = 0 THEN 1 ELSE (12.50 + (Orders.RxProfitability*0.1)) END) AS service_fee'),
                                //DB::raw(' SUM((CASE WHEN Orders.RxSelling >= 20 THEN ((Orders.RxPatientOutOfPocket + 15.00)+( RxProfitability * 0.1 ) )
                                       // ELSE (Orders.RxPatientOutOfPocket + 15) END)) AS service_fee')
                            ])->join('drugs_new AS d', 'd.id', '=', 'Orders.DrugDetailId')
                            ->join('practices AS p', 'p.id', '=', 'Orders.PracticeId')
                            ->join('PatientProfileInfo AS ppi','ppi.Id','Orders.PatientId')
                            ->leftJoin('ComplianceRewardPoint AS crp','crp.RewardId','Orders.Cr_Point_Id')
                            ->when($d_dates, function ($query) use ( $d_dates) {
                                $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '>=', $d_dates['start_date']);
                                $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '<=',  $d_dates['end_date']);
                            })->when(Session::has('practice') , function($query){
                                $query->where('Orders.PracticeId', Session::get('practice')->id);
                            })
                            // ->when((!isset(auth::user()->practice_id) AND !isset(auth::user()->practice_id)) , function($query){
                            //     $query->addSelect([DB::raw('SUM(15) AS base_fee'), DB::raw('SUM(RxProfitability * 0.1) AS profit_share')]);
                            // })
                            ->when(isset(auth::user()->practice_id), function($query){
                                $query->where('PracticeId', auth::user()->practice_id);
                        })->orderBy('Orders.created_at', 'asc')->get();


            // if(!Session::has('practice') AND !isset(auth::user()->practice_id))
            // {
                $data['total_sum_cr_service_fee'] = '$ '.number_format($result->sum('cr_service_fee'), 2);
                $data['total_sum_profit_share'] = '$ '.number_format($result->sum('profit_share'), 2);
            // }
            $data['total_rx_selling'] = '$ '.number_format($result->sum('rx_selling'), 2);
            $data['total_rx_profitability'] = '$ '.number_format($result->sum('rx_profitability'), 2);
            
            $data['total_sum_authrewd'] = '$ '.number_format($result->sum('rewardAuth'), 2);
            $result->filter(function ($value, $key) {

                    $value['rx_selling'] = '$ '.number_format($value['rx_selling'], 2);
                    $value['rx_profitability'] = '$ '.number_format($value['rx_profitability'], 2);
                    if($value['profit_share']<0)
                    {
                        $value['system_fee'] = $value['cr_service_fee'];
                    }else{
                        $value['system_fee'] = $value['cr_service_fee']+$value['profit_share'];
                    }
                    
                    $value['rewardAuth'] = '$ '.number_format($value['rewardAuth'], 2);
                    // if(!Session::has('practice') AND !isset(auth::user()->practice_id))
                    // {
                        $value['base_fee'] = '$ '.number_format($value['base_fee'], 2);
                        $value['profit_share'] = '$ '.number_format($value['profit_share'], 2);
                        $value['cr_service_fee']='$ '.number_format($value['cr_service_fee'], 2);
                    // }
                    return $value;
            });
            $data['total_sum_service_fee'] = '$ '.number_format($result->sum('system_fee'), 2);
            // dd($data);
            // dd($result->all());
            $excel_name='Invoice.xlsx';
            if(isset(auth::user()->practice_id))
            {

                $data['current_practice']=Practice::find(auth::user()->practice_id);
                $data['invoice_number']=$invoice_code;
                $data['start_date']=$d_dates['start_date'];
                $data['end_date']=$d_dates['end_date'];
                $excel_name=$data['current_practice']->practice_code.'-'.$invoice_code.'_INVOICE DETAIL.xlsx';
            }else if(Session::has('practice'))
            {
                $data['current_practice']=Practice::find(Session::get('practice')->id);
                $data['invoice_number']=$invoice_code;
                $data['start_date']=$d_dates['start_date'];
                $data['end_date']=$d_dates['end_date'];
                $excel_name=$data['current_practice']->practice_code.'-'.$invoice_code.'_INVOICE DETAIL.xlsx';
            }else{
               $excel_name='ALL_PRACTICES-'.$invoice_code.'_INVOICE DETAIL.xlsx'; 
            }
            
            $data['new_query_data'] = $result->all();
            $data['report_title'] = 'INVOICE DETAIL Report';


            return Excel::download(new AccountingExport($data), $excel_name);

    }
    public function all_cwp_activity_page($dates, $request)
    {

    	$cur=Carbon::now()->format('Y-m-d');
        $result = DB::table('ActivitiesHistory AS ah')->select(
                DB::raw('DATE_FORMAT(o.created_at, "%m/%d/%y %h:%i %p") AS service_date'),
                // DB::raw('DATE_FORMAT(o.created_at, "%h:%i %p") AS service_time'),
                DB::raw('CONCAT(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19") USING "utf8"), " ", CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8")) AS PatName'),
                'ah.Activity_Name AS service', 'pr.practice_name AS practice_name',
                // DB::raw('CONCAT_WS( "-",pr.practice_code, case when o.RefillCount < 9 then concat(o.Rxnumber,"-0",o.RefillCount) else concat(o.Rxnumber,"-",o.RefillCount) end) as RxNumber'),
                DB::raw('CASE WHEN pr.practice_code IS NULL THEN ( case when o.RefillCount < 9 then concat(o.Rxnumber,"-0",o.RefillCount) else concat(o.Rxnumber,"-",o.RefillCount) end) ELSE (CONCAT(pr.practice_code, "-", case when o.RefillCount < 9 then concat(o.Rxnumber,"-0",o.RefillCount) else concat(o.Rxnumber,"-",o.RefillCount) end)) END as RxNumber'),
                DB::raw('CASE WHEN o.OrderType IS NULL THEN "N" WHEN o.OrderType="Refill" THEN "R" ELSE "Transfer" END AS new_or_refill'),
                'd.rx_label_name AS rx_label_name', 'd.Strength AS strength', 'd.dosage_form AS dosage_form', DB::raw('FORMAT(o.Quantity ,1) AS quantity'), 'o.RefillsRemaining','d.ndc AS NDC','d.marketer AS Marketer','d.sponsored_product','d.gcn_seq','o.InsuranceType','o.RxSelling AS selling_price','o.RxIngredientPrice AS ing_cost','o.RxThirdPartyPay AS rx_third_pay','o.RxPatientOutOfPocket AS patient_out_pocket',DB::raw('(CASE WHEN o.asistantAuth = 0 THEN "N" ELSE "Y" END) AS assist_auth'),
                'o.asistantAuth AS asistantAuth','o.RxExpiryDate','o.PrescriberName','o.PrescriberPhone','d.major_reporting_cat AS major_cat','d.minor_reporting_class AS minor_rep','o.RxProfitability AS rx_profitability',
                // DB::raw('CONCAT("$ ",FORMAT(15,2)) AS base_fee'),DB::raw('(0.1*o.RxProfitability) AS profit_share'),
                 DB::raw('(CASE WHEN o.asistantAuth = 0 THEN (SELECT srv.base_fee FROM services AS srv WHERE srv.practice_id = o.PracticeId LIMIT 1)  END) As base_fee'),
            DB::raw('(CASE WHEN o.asistantAuth != 0  AND o.RxProfitability > 0 THEN((SELECT srv.profit_share FROM services AS srv WHERE srv.practice_id = o.PracticeId LIMIT 1)/100)*(o.RxProfitability)  END)  AS profit_share'),
            DB::raw('(CASE WHEN o.asistantAuth != 0 THEN (SELECT srv.fee FROM services AS srv WHERE srv.practice_id = o.PracticeId LIMIT 1)  END) As cr_service_fee'),
                // DB::raw('CASE WHEN o.RxSelling >= 20 THEN (o.RxPatientOutOfPocket + 5) + (0.1*o.RxProfitability) ELSE (o.RxPatientOutOfPocket + 5) END AS service_fee'),
                // DB::raw('(15 + (0.1*o.RxProfitability))  AS service_fee'),
                DB::raw('CONCAT(crp.ActivityCount," of 4") AS for_activity_count'),DB::raw('o.RxProfitability/o.RxPatientOutOfPocket AS for_avm'))
               // ->join('Orders AS o', 'o.Id', '=', 'ah.order_id')
                ->LeftJoin('Orders AS o', 'o.RxNumber', '=', 'ah.Rx_Number')
                ->LeftJoin('drugs_new AS d', 'd.id', '=', 'o.DrugDetailId')
                ->LeftJoin('practices AS pr', 'pr.id', '=', 'o.PracticeId')
                ->LeftJoin('PatientProfileInfo AS ppi', 'ppi.Id', '=', 'o.PatientId')
                ->LeftJoin('ComplianceRewardPoint AS crp','crp.RewardId','=','o.Cr_Point_Id')
                ->when(!empty($request->get('practice')), function($query) use ($request){
                   $query->where('o.PracticeId', $request->get('practice')->id);
               })
                ->when($dates!='all_activity',function($query) use ($dates){
                   $query->where(DB::raw("DATE_FORMAT(o.created_at, '%Y-%m-%d')"), '>=', $dates['start_date']);
                    $query->where(DB::raw("DATE_FORMAT(o.created_at, '%Y-%m-%d')"), '<=', $dates['end_date']) ;
                })
               ->orderBy(DB::raw('ah.Id'), 'ASC')
               ->groupBy('o.Id')->get();

         $result->filter(function ($value, $key) {
                if($value->profit_share<0)
                {
                    $value->system_fee='$ '.number_format($value->cr_service_fee,2);
                }else{
                    $value->system_fee='$ '.number_format(($value->cr_service_fee+$value->profit_share),2);
                }
         			
         			$value->activity_transmit='$ '.number_format(($value->patient_out_pocket/4),2);
         			$value->activity_count=$value->for_activity_count;
         			$value->avm = '$ '.number_format($value->for_avm, 2);
                    $value->net_prac_profit=number_format(($value->rx_profitability-(($value->cr_service_fee+$value->profit_share))),2);
                    if($value->net_prac_profit<0)
                    {
                        $value->net_prac_profit='$ ('.number_format(abs($value->rx_profitability-($value->cr_service_fee+$value->profit_share)),2).')';
                    }else{
                        $value->net_prac_profit='$ '.number_format(($value->rx_profitability-(($value->cr_service_fee+$value->profit_share))),2);
                    }
                    
                    $value->selling_price = '$ '.number_format($value->selling_price, 2);
                    $value->ing_cost = '$ '.number_format($value->ing_cost, 2);
                    $value->rx_third_pay = '$ '.number_format($value->rx_third_pay, 2);
                    $value->patient_out_pocket = '$ '.number_format($value->patient_out_pocket, 2);
                    $value->asistantAuth = '$ '.number_format($value->asistantAuth, 2);
                    $value->rx_profitability = '$ '.number_format($value->rx_profitability, 2);

                    $value->base_fee = '$ '.number_format($value->base_fee, 2);
                   	$value->profit_share = '$ '.number_format($value->profit_share, 2);
                    $value->cr_service_fee = '$ '.number_format($value->cr_service_fee, 2);
                   	unset($value->for_activity_count);
                   	unset($value->for_avm);
                    return $value;
            });

           $data['result'] =  json_decode(json_encode($result), true);
           // dd($data['result']);
            $data['tab_title'] = [
                // ['title'=>'Sr','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=>'Service Date','style'=>'background-color: #808080;color:#FFFFFF'],
             // ['title'=>'Service Time','style'=>'background-color: #808080;color:#FFFFFF'],
             ['title'=>'Patient Name','style'=>'background-color: #808080;color:#FFFFFF'],
             ['title'=>'Service','style'=>'background-color: #808080;color:#FFFFFF;float: right;'],
             ['title'=>'Client','style'=>'background-color: #808080;color:#FFFFFF'],
             ['title'=>'Rx Number','style'=>'background-color: #808080;color:#FFFFFF'],
             ['title'=>'New/Refill','style'=>'background-color: #808080;color:#FFFFFF'],
             ['title'=>'Rx Label Name','style'=>'background-color: #808080;color:#FFFFFF'],
             [ 'title'=>'Strength','style'=>'background-color: #808080;color:#FFFFFF'],
             ['title'=>'Dosage Form','style'=>'background-color: #808080;color:#FFFFFF'],
             ['title'=>'Qty','style'=>'background-color: #808080;color:#FFFFFF'],
             ['title'=>'Refill Remains','style'=>'background-color: #808080;color:#FFFFFF'],
             ['title'=>'NDC','style'=>'background-color: #808080;color:#FFFFFF'],
             ['title'=>'Marketer','style'=>'background-color: #808080;color:#FFFFFF'],
             ['title'=>'Sponsored','style'=>'background-color: #808080;color:#FFFFFF'],
             ['title'=>'GCN_SEQ','style'=>'background-color: #808080;color:#FFFFFF'],
             ['title'=>'INSURED','style'=>'background-color: #808080;color:#FFFFFF'],
             ['title'=>'Rx Selling Price','style'=>'background-color: #808080;color:#FFFF00'],
             ['title'=>'Rx Ingredient Cost','style'=>'background-color: #808080;color:#FFFFFF'],
             ['title'=>'3rd Party Paid','style'=>'background-color: #808080;color:#FFFFFF'],
             ['title'=>'Patient Out Pocket','style'=>'background-color: #808080;color:#FFFFFF'],
             ['title'=>'Assistance Authoized','style'=>'background-color: #808080;color:#FFFFFF'],
             ['title'=>'Assistant Req','style'=>'background-color: #808080;color:#FFFF00'],
             ['title'=>'Rx Expires','style'=>'background-color: #808080;color:#FFFFFF'],
             ['title'=>'Prescriber Name','style'=>'background-color: #808080;color:#FFFFFF'],
             ['title'=>'Prescriber Phone','style'=>'background-color: #808080;color:#FFFFFF'],
             ['title'=>'Major Reporting Category','style'=>'background-color: #808080;color:#FFFFFF'],
             ['title'=>'Minor Reporting Class','style'=>'background-color: #808080;color:#FFFFFF'],
             ['title'=>'Rx Profitability','style'=>'background-color: #808080;color:#FFFFFF'],
             ['title'=>'Compliance Reward Base Fee','style'=>'background-color: #808080;color:#FFFFFF'],
             ['title'=>'Compliance Reward Profit Share','style'=>'background-color: #00b04f;color:#FFFFFF'],
             ['title'=>'Compliance Reward Service Fee','style'=>'background-color: #00b04f;color:#FFFFFF'],
             ['title'=>'Total Payment System FEES','style'=>'background-color: #00b04f;color:#FFFFFF'],
             ['title'=>'1/4 activity transmit','style'=>'background-color: #acb9ca;color:#fff2cc'],
             ['title'=>'Activity Number','style'=>'background-color: #acb9ca;color:#fff2cc'],
             ['title'=>'Activity Value Multiplier','style'=>'background-color: #808080;color:#FFFFFF'],
            ['title'=>'Net Practice Profitability','style'=>'background-color: #808080;color:#FFFFFF']];
             $data['col_style'] = [ 'background-color: #f2f2f2;', 'background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;','','','','','','text-align:right;','text-align:right;','text-align:right;','text-align:right;','text-align:center;','text-align:right;color: #FF0000;','text-algin: right;','','','background-color: #d6dce4;color: #0070c0','','text-align:right;','text-align:right;','text-align:right;background-color: #00b04f;','text-align:right;background-color: #00b04f;','text-align:right;background-color: #00b04f;','background-color: #acb9ca;color:#fff2cc','background-color: #acb9ca;color:#fff2cc;text-align:right;','text-align:right;','text-align:right;','text-align:right;'];
         // dd($data);
            return $data;
    }
    public function member_questions($days)
    {
    	$result = Order::select([DB::raw('DATE_FORMAT(Orders.created_at,"%m/%d/%y %h:%i %p") AS service_date'),
            // DB::raw('DATE_FORMAT(Orders.created_at,"%h:%i %p") AS service_time'),
            'pr.practice_name AS practice_name',DB::raw('CONCAT(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19") USING "utf8"), " ", CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8")) AS PatName'),
             DB::raw('CONCAT("$ ", FORMAT(Orders.RxIngredientPrice, 2)) AS igred_cost'),DB::raw('CONCAT("$ ", FORMAT(Orders.RxFinalCollect, 2)) AS selling_price'),
            DB::raw('Orders.RxFinalCollect AS for_sum_selling_price'), DB::raw('Orders.RxIngredientPrice AS for_sum_igred_cost'),
            'd.gcn_seq',DB::raw("(CASE WHEN QA.OrderId IS NOT NULL THEN d.rx_label_name ELSE '-GENERAL QUESTION-' END) AS rx_label_name"),
            'd.Strength AS Strength','d.dosage_form AS dosage_form',
            DB::raw('Orders.Quantity AS qty'), DB::raw('Orders.RefillsRemaining AS refillRemain'),'Orders.RxNumber',
            'QA.Question'])

                ->join('drugs_new AS d', 'd.id', '=', 'Orders.DrugDetailId')
                ->rightjoin('QuestionAnswer AS QA','QA.OrderId','=','Orders.Id')
                ->join('PatientProfileInfo AS ppi','ppi.Id','=','QA.PatientId')
                ->join('practices AS pr', 'pr.id', '=', 'ppi.Practice_ID')


       // $result = DB::table('practices AS pr')->select(['Orders.Id','QA.id AS q_id','QA.Question','QA.OrderId', 'pr.practice_name AS practice_name',DB::raw('CONCAT(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19") USING "utf8"), " ", CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8")) AS PatName'),
       //      DB::raw('CASE WHEN QA.OrderId!=NULL THEN 1 ELSE 0 END AS question_linked')])
       //          ->join('PatientProfileInfo AS ppi', 'ppi.Practice_ID', '=', 'pr.id')
       //          ->join('QuestionAnswer AS QA', 'QA.PatientId', '=', 'ppi.Id')
       //          ->leftjoin('Orders AS Orders','Orders.Id','=','QA.OrderId')
                // ->rightjoin('drugs_new AS d','d.id','=','Orders.DrugDetailId')
                ->when($days!='all_activity', function ($query) use ($days) {

                               $end_date = Carbon::now()->format('Y-m-d');
                                 $start_date = Carbon::now()->subDay($days)->format('Y-m-d');
                                 $query->where(DB::raw("DATE_FORMAT(QA.QuestionTime, '%Y-%m-%d')"), '>=', $start_date);
                                $query->where(DB::raw("DATE_FORMAT(QA.QuestionTime, '%Y-%m-%d')"), '<=', $end_date);

                            })->get();




        $data['for_sum_selling_price'] = '$ '.number_format($result->sum('for_sum_selling_price'), 2);
        $data['for_sum_igred_cost']='$ '.number_format($result->sum('for_sum_igred_cost'), 2);
         $result->filter(function ($value, $key) {
                unset($value['for_sum_selling_price']);
                unset($value['for_sum_igred_cost']);
               $value->service = "MBR QUESTION";
               return $value;
           });
        if($days ==1){ $durationD = 'Now'; }
        else{ $durationD = 'Past '.$days.' Days'; }
        $data['report_title'] = 'SUMMARY MBR QUESTIONS ( '.$durationD.' )';



        $data['result'] =  json_decode(json_encode($result), true);
        $data['tab_title'] = [
            // [ 'title' => 'Sr.','style'=>'background-color: #808080;color: #FFFFFF;'],
        ['title'=>'Service Date','style'=>'background-color: #808080;color: #FFFFFF;'],
        // ['title'=>'Service Time','style'=>'background-color: #808080;color: #FFFFFF;'],
        ['title'=>'ASSOCIATE CLIENT NAME','style'=>'background-color: #808080;color: #FFFFFF;'],
        ['title'=>'Patient Name','style'=>'background-color: #808080;color: #FFFFFF;'],
        ['title'=>'IGRED COST','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'SELLING PRICE','style'=>'background-color: #808080;color: #FFFFFF;'],


            ['title'=>'GCN SEQ','style'=>'background-color: #808080;color: #FFFFFF;'],

            ['title'=>'Rx Label Name','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'Strength','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'Dosage Form','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'Qty','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'Refills Remain','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'Rx Number','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'Question','style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'Service','style'=>'background-color: #808080;color: #FFFFFF;']  ];

        $data['col_style']=['background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;',
        'text-align:right;color: #FF0000;','text-align:right;color: #0070c0;','background-color: #f2f2f2;','background-color: #f2f2f2;',
        'background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;','background-color: #f2f2f2;'];
        return $data;
    }
    public function all_cwp_referrals($days, $request)
    {
        $subSql = "";
        if($days != "all_activity"){
            $end_date = Carbon::now()->format('Y-m-d');
            $start_date = Carbon::now()->subDay($days)->format('Y-m-d');
            $subSql = ' AND DATE(created_at) > "'.$start_date.'" AND DATE(created_at) <= "'.$end_date.'" ';
        }

        $userList = [];
        $orders = DB::select( DB::raw("SELECT PrescriberName, concat('(',substr(PrescriberPhone,1,3),') ',substr(PrescriberPhone,4,3),'-',substr(PrescriberPhone,7)) AS PrescriberPhone, COUNT(1) as Referrals,
            (SELECT practice_name from practices where id=Orders.PracticeId) as Practice,(SELECT practice_phone_number from practices where id=Orders.PracticeId) as PracticePhone,(SELECT practice_address from practices where id=Orders.PracticeId) as PracticeAddress,(SELECT practice_license_number from practices where id=Orders.PracticeId) as PracticeLicense
            FROM Orders WHERE PrescriberName IS NOT NULL $subSql GROUP BY PrescriberName ORDER BY Referrals DESC") );

        $orders = json_decode(json_encode($orders),1);

        $data['result'] = $orders;
        $data['tab_title'] = [ [ 'title'=>'Prescriber Name', 'style'=>'background-color: #808080;color: #FFFFFF;'], ['title'=>'Phone', 'style'=>'background-color: #808080;color: #FFFFFF;'], ['title'=>'Referrals', 'style'=>'background-color: #808080;color: #FFFFFF;'],
                [ 'title'=>'Practice Name', 'style'=>'background-color: #808080;color: #FFFFFF;'],[ 'title'=>'Practice Phone', 'style'=>'background-color: #808080;color: #FFFFFF;'],[ 'title'=>'Practice Address', 'style'=>'background-color: #808080;color: #FFFFFF;'],[ 'title'=>'Practice License Number', 'style'=>'background-color: #808080;color: #FFFFFF;']];
        $data['col_style'] = ['', '', '', ''];

        return $data;
    }
    public function all_cwp_users($days, $request)
    {

        $userList = [];
        $users = User::with(["practices","roles"])
                ->when($days!='all_activity', function ($query) use ($days) {
                    $end_date = Carbon::now()->format('Y-m-d');
                    $start_date = Carbon::now()->subDay($days)->format('Y-m-d');
                    $query->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"), '>=', $start_date);
                    $query->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"), '<=', $end_date);
                })->when(!empty($request->get('practice')), function($query) use ($request){
                    $query->where('practice_id', $request->get('practice')->id);
                })->get()->toArray();

        foreach($users as $user){
            $userList[] = ['name'=>$user['name'], 'email'=>$user['email'], 'role'=>(isset($user['roles'][0]['name'])?$user['roles'][0]['name']:""), 'practice'=>(isset($user['practices'][0]['practice_name'])?$user['practices'][0]['practice_name']:""), 'type'=>(isset($user['practices'][0]['practice_type'])?$user['practices'][0]['practice_type']:""),'practice_phone'=> (isset($user['practices'][0]['practice_type'])?$user['practices'][0]['practice_phone_number']:""),'practice_address'=>(isset($user['practices'][0]['practice_type'])?$user['practices'][0]['practice_address']:"")];
        }
        $data['result'] = $userList;

        $data['tab_title'] = [
            // ['title'=>'Sr','style'=>'background-color: #808080;color: #FFFFFF;'],
            [ 'title'=>'User Name', 'style'=>'background-color: #808080;color: #FFFFFF;'], ['title'=>'User Email', 'style'=>'background-color: #808080;color: #FFFFFF;'], ['title'=>'User Role', 'style'=>'background-color: #808080;color: #FFFFFF;'],
                [ 'title'=>'Practice Name', 'style'=>'background-color: #808080;color: #FFFFFF;'], [ 'title'=>'Practice Type', 'style'=>'background-color: #808080;color: #FFFFFF;'],
                [ 'title'=>'Practice Phone Number', 'style'=>'background-color: #808080;color: #FFFFFF;'],[ 'title'=>'Practice Address', 'style'=>'background-color: #808080;color: #FFFFFF;']];
        $data['col_style'] = ['', '', '', '', ''];

        return $data;
    }
    public function patient_out_pocket($days, $request)
    {
        $result = DB::table('Orders AS o')->select(DB::raw('CONCAT("$ ", FORMAT(o.RxPatientOutOfPocket ,2)) as patOutPocket'),
        DB::raw('CONCAT("$ ", FORMAT(o.RxThirdPartyPay ,2)) as thirdparty'),
        DB::raw('CONCAT(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19") USING "utf8"), " ", CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8")) AS PatName'),
                 // DB::raw('CONCAT(pr.practice_code,"-",o.RxNumber) AS rx_number'),
                 DB::raw('(CASE WHEN pr.practice_code IS NULL THEN o.RxNumber ELSE CONCAT(pr.practice_code,"-",o.RxNumber) END) AS rx_number'),
                 'o.RefillsRemaining',
                'd.rx_label_name AS rx_label_name','d.Strength AS strength', 'd.dosage_form AS dosage_form','o.Quantity as Quantity',
              DB::raw('DATE_FORMAT(o.nextRefillDate,"%m/%d/%Y")'),
              DB::raw('DATE_FORMAT(o.RxExpiryDate,"%m/%d/%Y")'),'d.marketer','d.gcn_seq',
                'd.major_reporting_cat','d.minor_reporting_class' )
               // ->join('Orders AS o', 'o.Id', '=', 'ah.order_id')
                // ->LeftJoin('Orders AS o', 'o.RxNumber', '=', 'ah.Rx_Number')
                ->LeftJoin('drugs_new AS d', 'd.id', '=', 'o.DrugDetailId')
                ->LeftJoin('practices AS pr', 'pr.id', '=', 'o.PracticeId')
                ->LeftJoin('PatientProfileInfo AS ppi', 'ppi.Id', '=', 'o.PatientId')

                ->when($days!='all_activity', function ($query) use ($days) {
                    $end_date = Carbon::now()->format('Y-m-d');
                    $start_date = Carbon::now()->subDay($days)->format('Y-m-d');
                    $query->where(DB::raw("DATE_FORMAT(o.created_at, '%Y-%m-%d')"), '>=', $start_date);
                    $query->where(DB::raw("DATE_FORMAT(o.created_at, '%Y-%m-%d')"), '<=', $end_date);


               })->when(!empty($request->get('practice')), function($query) use ($request){
                   $query->whereIn('o.PracticeId', $request->get('practice'));
               })
               ->orderBy(DB::raw('o.Id'), 'ASC')
               ->groupBy('o.Id')->get();
           $data['result'] =  json_decode(json_encode($result), true);

            $data['tab_title'] = [
                // ['title'=>'Sr','style'=>'background-color: #808080;color: #FFFFFF;'],
                 [ 'title'=>'Patient CoPay', 'style'=>'background-color: #808080;color: #FFFFFF;'],
            [ 'title'=>'Insurance Paid', 'style'=>'background-color: #808080;color: #FFFFFF;'], [ 'title'=>'Patient Name', 'style'=>'background-color: #808080;color: #FFFFFF;'],
                 [ 'title'=>'Rx Number', 'style'=>'background-color: #808080;color: #FFFFFF;'],[ 'title'=>'Refill Remains', 'style'=>'background-color: #808080;color: #FFFFFF;'],[ 'title'=>'Rx Label Name', 'style'=>'background-color: #808080;color: #FFFFFF;'],
                 [ 'title'=>'Strength', 'style'=>'background-color: #808080;color: #FFFFFF;'],[ 'title'=>'Dosage Form', 'style'=>'background-color: #808080;color: #FFFFFF;'],
                  [ 'title'=>'Qty', 'style'=>'background-color: #808080;color: #FFFFFF;'],[ 'title'=>'Refillable Next', 'style'=>'background-color: #808080;color: #FFFFFF;'], [ 'title'=>'Rx Expires', 'style'=>'background-color: #808080;color: #FFFFFF;'],
                 [ 'title'=>'Marketer', 'style'=>'background-color: #808080;color: #FFFFFF;'],[ 'title'=>'GCN_SEQ', 'style'=>'background-color: #808080;color: #FFFFFF;'],  [ 'title'=>'MAJOR REPT CAT', 'style'=>'background-color: #808080;color: #FFFFFF;'],
                 [ 'title'=>'MINOR REPORTING CATEGORY', 'style'=>'background-color: #808080;color: #FFFFFF;']

                ];

             $data['col_style'] = ['text-align:right;', 'text-align:right;', '', '', '', '',
                 '', '', '', '', '', '','','',''];

            return $data;
    }
     public function zero_refill_remaining($days, $request)
    {
        $result = DB::table('Orders AS o')->select('o.RefillsRemaining',DB::raw('DATE_FORMAT(o.nextRefillDate,"%m/%d/%Y")'),
        DB::raw('CONCAT(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19") USING "utf8"), " ", CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8")) AS PatName'),
                 // DB::raw('CONCAT(pr.practice_code,"-",o.RxNumber) AS rx_number'),
                 DB::raw('(CASE WHEN pr.practice_code IS NULL THEN o.RxNumber ELSE CONCAT(pr.practice_code,"-",o.RxNumber) END) AS rx_number'),
                 DB::raw('DATE_FORMAT(o.RxExpiryDate,"%m/%d/%Y")'),
                'd.rx_label_name AS rx_label_name','d.Strength AS strength', 'd.dosage_form AS dosage_form',
                DB::raw('FORMAT(o.Quantity,1) AS Quantity'),
                 DB::raw('CONCAT("$ ", FORMAT(o.RxPatientOutOfPocket ,2)) as patOutPocket'),
                DB::raw('CONCAT("$ ", FORMAT(o.RxThirdPartyPay ,2)) as thirdparty'),DB::raw('CONCAT("$ ", FORMAT(o.RxSelling ,2)) as selling_price'))
               // ->join('Orders AS o', 'o.Id', '=', 'ah.order_id')
                // ->LeftJoin('Orders AS o', 'o.RxNumber', '=', 'ah.Rx_Number')
                ->LeftJoin('drugs_new AS d', 'd.id', '=', 'o.DrugDetailId')
                ->LeftJoin('practices AS pr', 'pr.id', '=', 'o.PracticeId')
                ->LeftJoin('PatientProfileInfo AS ppi', 'ppi.Id', '=', 'o.PatientId')

                ->when($days!='all_activity', function ($query) use ($days) {
                    $end_date = Carbon::now()->format('Y-m-d');
                    $start_date = Carbon::now()->subDay($days)->format('Y-m-d');
                    $query->where(DB::raw("DATE_FORMAT(o.created_at, '%Y-%m-%d')"), '>=', $start_date);
                    $query->where(DB::raw("DATE_FORMAT(o.created_at, '%Y-%m-%d')"), '<=', $end_date);


               })->when(!empty($request->get('practice')), function($query) use ($request){
                   $query->whereIn('o.PracticeId', $request->get('practice'));
               })
               ->where('o.RefillsRemaining',0)
               ->orderBy(DB::raw('o.Id'), 'ASC')
               ->groupBy('o.Id')->get();
           $data['result'] =  json_decode(json_encode($result), true);

            $data['tab_title'] = [
                // ['title'=>'Sr','style'=>'background-color: #808080;color: #FFFFFF;'],
                [ 'title'=>'Refill Remains', 'style'=>'background-color: #808080;color: #FFFFFF;'],
            [ 'title'=>'Refillable Next', 'style'=>'background-color: #808080;color: #FFFFFF;'],
             [ 'title'=>'Patient Name', 'style'=>'background-color: #808080;color: #FFFFFF;'],
                 [ 'title'=>'Rx #', 'style'=>'background-color: #808080;color: #FFFFFF;'],
                 [ 'title'=>'Rx Expires', 'style'=>'background-color: #808080;color: #FFFFFF;'],
                 [ 'title'=>'Rx Label Name', 'style'=>'background-color: #808080;color: #FFFFFF;'],
                 [ 'title'=>'Strength', 'style'=>'background-color: #808080;color: #FFFFFF;'],
                 [ 'title'=>'Dosage Form', 'style'=>'background-color: #808080;color: #FFFFFF;'],



                  [ 'title'=>'Quantity', 'style'=>'background-color: #808080;color: #FFFFFF;'],
                  [ 'title'=>'Patient CoPay', 'style'=>'background-color: #808080;color: #FFFFFF;'],
                  [ 'title'=>'Insurance Paid', 'style'=>'background-color: #808080;color: #FFFFFF;'],
                  [ 'title'=>'Selling Price', 'style'=>'background-color: #808080;color: #FFFFFF;']
                ];

             $data['col_style'] = ['', '', '', '', '', '',
                 '', '', '', 'text-align: right;', 'text-align: right;', 'text-align: right;'];

            return $data;
    }
    public function rx_near_expiration($days, $request)
    {
        $result = Order::select([DB::raw('DATE_FORMAT(Orders.RxExpiryDate, "%m/%d/%Y") AS rxExpireDate'),DB::raw('DATE_FORMAT(Orders.nextRefillDate, "%m/%d/%Y") AS nextRefillDate'),
        DB::raw('CONCAT(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19") USING "utf8"), " ", CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8")) AS PatName'),
        // DB::raw('CONCAT(pct.practice_code,"-",Orders.RxNumber) AS rx_number'),
        DB::raw('(CASE WHEN pct.practice_code IS NULL THEN Orders.RxNumber ELSE CONCAT(pct.practice_code,"-",Orders.RxNumber) END) AS rx_number'),
        'Orders.RefillsRemaining', 'd.rx_label_name', 'd.Strength','d.dosage_form',DB::raw('Orders.Quantity AS qty'),
         DB::raw('CONCAT("$ ", FORMAT(Orders.RxPatientOutOfPocket ,2)) as patOutPocket'),
         DB::raw('CONCAT("$ ", FORMAT(Orders.RxThirdPartyPay ,2)) as thirdparty'),
         DB::raw('CONCAT("$ ", FORMAT(Orders.RxFinalCollect ,2)) as selling_price'),
         DB::raw('CONCAT("$ ", FORMAT(Orders.RxProfitability ,2)) as rx_profitability'),
         'd.marketer','d.gcn_seq',
         'd.major_reporting_cat','d.minor_reporting_class' ])

                ->join('drugs_new AS d', 'd.id', '=', 'Orders.DrugDetailId')

                ->join('practices AS pct', 'pct.Id', '=', 'Orders.PracticeId')

                ->LeftJoin('PatientProfileInfo AS ppi', 'ppi.Id', '=', 'Orders.PatientId')

                ->when($days!='all_activity', function ($query) use ($days) {

                    $start_date = Carbon::now()->format('Y-m-d');

                    $end_date = Carbon::now()->addDays($days+1)->format('Y-m-d');
                    $query->where(DB::raw("DATE_FORMAT(Orders.RxExpiryDate, '%Y-%m-%d')"), '>=', $start_date);
                    $query->where(DB::raw("DATE_FORMAT(Orders.RxExpiryDate, '%Y-%m-%d')"), '<=', $end_date);


            })->when(!empty($request->get('practice')), function($query) use ($request){

                    $query->where('Orders.PracticeId', $request->get('practice')->id);

            })->when(!empty($request->get('patient_id')), function($query) use ($request){

                $query->where('Orders.PatientId', $request->get('patient_id'));

            })
            // ->where('Orders.nextRefillDate','>=',Carbon\Carbon::now()->format('Y-m-d'))
            ->where('Orders.OrderType','=','Refill')
            ->orderBy('RxExpiryDate', 'DESC')->groupBy('Orders.Id')->get();


            $result->filter(function ($value, $key) {
                    $value['qty'] = number_format($value['qty'], 1);
                    return $value;
                });

            $data['result'] = $result->toArray();



            $data['tab_title'] = [
             // ['title'=>'Sr','style'=>'background-color: #808080;color: #FFFFFF;'],
             [  'title'=>'Rx Expires', 'style'=>'background-color: #808080;color: #FFFFFF;'],[ 'title'=>'Refillable Next', 'style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=>'Patient Name', 'style'=>'background-color: #808080;color: #FFFFFF;'],
                 [ 'title'=>'Rx #', 'style'=>'background-color: #808080;color: #FFFFFF;'],[ 'title'=>'Refill Remains', 'style'=>'background-color: #808080;color: #FFFFFF;'],
                 [ 'title'=>'Rx Label Name', 'style'=>'background-color: #808080;color: #FFFFFF;'],
                 [ 'title'=>'Strength', 'style'=>'background-color: #808080;color: #FFFFFF;'],
                 [ 'title'=>'Dosage Form', 'style'=>'background-color: #808080;color: #FFFFFF;'],
                     [ 'title'=>'Quantity', 'style'=>'background-color: #808080;color: #FFFFFF;'],
                 [ 'title'=>'Patient CoPay', 'style'=>'background-color: #808080;color: #FFFFFF;'],
                  [ 'title'=>'Insurance Paid', 'style'=>'background-color: #808080;color: #FFFFFF;'],
                  [ 'title'=>'Selling Price', 'style'=>'background-color: #808080;color: #FFFFFF;'],
                  [ 'title'=>'Rx Profitability', 'style'=>'background-color: #808080;color: #FFFFFF;'],
                 [ 'title'=>'Marketer', 'style'=>'background-color: #808080;color: #FFFFFF;'],[ 'title'=>'GCN_SEQ', 'style'=>'background-color: #808080;color: #FFFFFF;'],  [ 'title'=>'Major Reporting Category', 'style'=>'background-color: #808080;color: #FFFFFF;'],
                 [ 'title'=>'Minor Reporting Class', 'style'=>'background-color: #808080;color: #FFFFFF;']

                ];

             $data['col_style'] = ['','', '', '', '', '', '',
                 '', '', 'text-align: right;', 'text-align: right;','text-align: right;','text-align: right;', '', ''];

            return $data;

    }
    public function user_statistics($cat,$duration)
    {
        $result = Order::select([DB::raw('DATE_FORMAT(Orders.nextRefillDate, "%m-%d-%Y") AS nextRefillDate'),'RefillsRemaining',
                                DB::raw('(CASE WHEN pct.practice_code IS NULL THEN Orders.RxNumber ELSE CONCAT(pct.practice_code,"-",Orders.RxNumber) END) AS Rx'),  DB::raw('CONCAT( d.rx_label_name, " ", d.Strength, " ", d.dosage_form ) AS rx_label_name'),'d.brand_reference',
                                'Orders.Quantity AS qty','DaysSupply',DB::raw('CONCAT("$ ",FORMAT(RxSelling,2)) As  RxSelling'),DB::raw('(SELECT CONCAT("$ ",FORMAT(CurrentEarnReward,2))CurrentEarnReward From ComplianceRewardPoint where Orders.Cr_Point_Id=RewardId) AS rewardAuth'), 'd.minor_reporting_class AS minor_reporting_class' ])
                ->join('drugs_new AS d', 'd.id', '=', 'Orders.DrugDetailId')
                ->join('practices AS pct', 'pct.Id', '=', 'Orders.PracticeId')
                ->when(!empty($cat), function($query) use ($cat){
                    $query->where(DB::raw('REPLACE(LOWER(d.major_reporting_cat), " ", "")'), $cat);

                })
                ->when($duration!='all_activity', function ($query) use ($duration) {

                        $end_date = Carbon::now()->format('Y-m-d');

                        $start_date = Carbon::now()->subDay($duration)->format('Y-m-d');

                        $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '>=', $start_date);
                        $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '<=', $end_date);


                })->when(Session::has('practice'), function($query) {
                    $query->where('Orders.PracticeId', Session::get('practice')->id);
                })->orderBy('nextRefillDate', 'DESC')->groupBy('Orders.Id')->get();
                // dump(DB::getQueryLog());
            $data['result'] = $result->toArray();

            $data['report_title'] = ucwords(str_replace('-', ' ', $cat)).' ('.$result->count().')';
            $data['tab_title'] = [
                // ['title'=>'Sr.','style'=>'background-color: #808080;color: #FFFFFF;'],
                ['title'=>'Refill. Next','style'=>'background-color: #808080;color: #FFFFFF;'], [ 'title'=>'Refills Remaining', 'style' => 'background-color: #808080;color: #FFFFFF;'], ['title'=>'Rx Number','style'=>'background-color: #808080;color: #FFFFFF;'],['title'=> 'Rx Label Name','style'=>'background-color: #808080;color: #FFFFFF;'],['title'=>'Generic For','style'=>'background-color: #808080;color: #FFFFFF;'],['title'=> 'Quantity','style'=>'background-color: #808080;color: #FFFFFF;'], ['title'=>'Days Supply','style'=>'background-color: #808080;color: #FFFFFF;'],['title'=>'Rx Selling Price','style'=>'background-color: #808080;color: #FFFFFF;'],['title'=>'Reward Auth.','style'=>'background-color: #808080;color: #FFFFFF;'],['title'=>'Therapeutic Category','style'=>'background-color: #808080;color: #FFFFFF;']];
            // $data['count_field'] = count($data['tab_title']);
            // dd($data);
            $data['col_style']=['','','','','','','','text-align: right;','text-align: right;',''];
            return $data;
    }
    public function refill_requests($days)
    {

        $result = Order::select([DB::raw('DATE_FORMAT(Orders.created_at,"%m/%d/%y %h:%i %p") AS service_date'),'pr.practice_name AS practice_name',
            DB::raw('CONCAT(CONVERT(AES_DECRYPT (FROM_BASE64(FirstName),"ss20compliance19") USING "utf8"), " ", CONVERT(AES_DECRYPT (FROM_BASE64(LastName),"ss20compliance19")USING "utf8")) AS PatName'),DB::raw('CONVERT(AES_DECRYPT (FROM_BASE64(MobileNumber),"ss20compliance19") USING "utf8") AS patPhone'),
            DB::raw('CONCAT("$ ", FORMAT(Orders.RxFinalCollect, 2)) AS selling_price'), DB::raw('CONCAT("$ ", FORMAT(Orders.RxIngredientPrice, 2)) AS igred_cost'),
            DB::raw('Orders.RxFinalCollect AS for_sum_selling_price'), DB::raw('Orders.RxIngredientPrice AS for_sum_igred_cost'),
            DB::raw('CONCAT("$ ",FORMAT(`rp`.`Points`, 2)) AS reward_auth'),
            'd.gcn_seq','d.rx_label_name AS rx_label_name',
            'd.Strength AS Strength','d.dosage_form AS dosage_form',
            DB::raw('Orders.Quantity AS qty'),
            DB::raw('(SELECT RefillsRemaining FROM Orders WHERE OrderType="Refill" ORDER BY created_at DESC LIMIT 1 ) AS refillRemain'),
            'Orders.RxNumber',
              DB::raw('(SELECT u.name FROM users AS u WHERE u.practice_id=pr.id ORDER BY u.id ASC LIMIT 1) AS userName')  ])

                ->leftJoin('RewardHistory AS reh', 'reh.PatientId', '=', 'Orders.PatientId')
                ->LeftJoin('PatientProfileInfo AS ppi', 'ppi.Id', '=', 'Orders.PatientId')
                ->leftJoin('practices AS pr', 'pr.id', '=', 'Orders.PracticeId')
                ->join('drugs_new AS d', 'd.id', '=', 'Orders.DrugDetailId')
                ->leftJoin('RewardPoints AS rp', 'rp.Id', '=', 'reh.RewardPointId')
                ->when($days!='all_activity', function ($query) use ($days) {

                               $end_date = Carbon::now()->format('Y-m-d');

                                $start_date = Carbon::now()->subDay($days)->format('Y-m-d');

                            $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '>=', $start_date);
                                $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '<=', $end_date);
                            })
                ->where('Orders.OrderStatus', 23)->groupBy('Orders.Id')->get();
                // ->groupBy('Orders.PatientId')
               // dd($result);
       //->where('NM.MessageTypeId', 12)
        if($days ==1){ $durationD = 'Now'; }
        else{ $durationD = 'Past '.$days.' Days'; }
        $data['report_title'] = 'SUMMARY Rx REFILL REQ MADE BY PATIENTS ( '.$durationD.' )';

        // $data['total_row'] = [$result->sum('rx_orders'), 'Total', '$ '.number_format($result->sum('for_sum_selling_price'), 2), '$ '.number_format($result->sum('for_sum_igred_cost'), 2), $result->sum('reward_auth'), $result->sum('refillRemain')];

       $result->filter(function ($value, $key) {
                    unset($value['for_sum_igred_cost']);
                    unset($value['for_sum_selling_price']);

                    return $value;
                });

        $data['result'] = $result->toArray();
        $data['tab_title'] = [ [ 'title' => "Service Date", 'style'=>'background-color: #808080;color: #FFFFFF;'],
        	[ 'title' => "PHARMACY NAME", 'style'=>'background-color: #808080;color: #FFFFFF;'],

        [ 'title'=>"PATIENT  NAME", 'style'=>'background-color: #808080;color: #FFFFFF;'],
        [ 'title'=>"Mobile Number", 'style'=>'background-color: #808080;color: #FFFFFF;'],
        [ 'title' => 'SELLING PRICE', 'style'=>'background-color: #808080;color: #FFFFFF;'],
            ['title'=>'IGRED COST', 'style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=>'REWARD AUTH','style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=>"GCN SEQ",'style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=>"Rx Label Name",'style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=>"Strength",'style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=>"Dosage Form",'style'=>'background-color: #808080;color: #FFFFFF;'],
             ['title'=>"Quantity",'style'=>'background-color: #808080;color: #FFFFFF;'],
              ['title'=>'REFILLS REMAIN', 'style'=>'background-color: #808080;color: #FFFFFF;'],
              [ 'title'=>"Rx Number", 'style'=>'background-color: #808080;color: #FFFFFF;'],
               ['title'=>"CR REP",'style'=>'background-color: #808080;color: #FFFFFF;'] ];

         $data['col_style'] = ['text-align: right;', 'bg-tb-blue-lt txt-blue', 'bg-tb-pink txt-red-dk cnt-right', 'bg-gray-e txt-gray-7e cnt-right', 'bg-tb-grn-lt txt-black-24 cnt-center', 'bg-tb-orange-lt txt-orange cnt-center', 'bg-tb-blue-lt txt-blue'];

        return $data;
    }
    public function sponsor_drug()
    {
        $drugs=Drug::select(['id','sponsored_product','sponsor_source','sponsor_item','order_web_link','gcn_seq','ndc','upc','rx_label_name','strength','dosage_form','unit_price','default_rx_qty'])->where('sponsored_product','!=','NULL')->orderBy('id','DESC')->get();
        // dd($drugs);
        $data['drugs']=$drugs;
        return view('reports.sponsor_drugs',$data);
    }
    public function get_base_fee($id)
    {
    	$days=15;
    	$cur=Carbon::now()->format('Y-m-d');
    	// $base_fee=DB::table('practices As prac')->select('srv.base_fee')->join('services AS srv','prac.id','=','srv.practice_id')
    	// ->where('srv.start_date','<=',$cur)->where('srv.end_date','>=',$cur)->where('srv.practice_id',$id)->orderBy('srv.id','DESC')->limit(1)->get();
    	$dt=Order::select([DB::raw('SUM((CASE WHEN ((SELECT srv.base_fee FROM practices AS prac JOIN services AS srv ON prac.id = srv.practice_id WHERE srv.start_date<= "'.$cur.'" AND srv.end_date >= "'.$cur.'" AND srv.practice_id = Orders.PracticeId ORDER BY srv.id DESC LIMIT 1)) IS NOT NULL THEN (SELECT srv.base_fee FROM practices AS prac JOIN services AS srv ON prac.id = srv.practice_id WHERE srv.start_date<= "'.$cur.'" AND srv.end_date >= "'.$cur.'" AND srv.practice_id = Orders.PracticeId ORDER BY srv.id DESC LIMIT 1) ELSE (15) END)) AS base_fee'),'Orders.PracticeId','Orders.DrugDetailId','Orders.Id'])
    	->when($days!='all_activity', function ($query) use ($days) {

                     $end_date = Carbon::now()->format('m/d/Y');
                     $start_date = Carbon::now()->subDay($days)->format('m/d/Y');
                    $query->whereBetween(DB::raw('DATE_FORMAT(Orders.created_at, "%m/%d/%Y")'), array($start_date, $end_date));

            })->groupBy('Orders.DrugDetailId')->get();
  	dd($dt);
    	return $dt;
    }
    public function pat_out_pocket(Request $request, $download=false)
    {

        if(!$request->has('from_date') and !$request->has('to_date'))
        {
            $request->merge(['from_date' => Carbon::now()->subDays(30)->format('m/d/Y')]);
            $request->merge(['to_date' => Carbon::now()->format('m/d/Y')]); 
        }

        
        $result = Order::select([DB::raw('Orders.RefillsRemaining AS refillsRemaining'), DB::raw('DATE_FORMAT(Orders.nextRefillDate, "%m/%d/%Y") AS nextRefillDate'),
                        DB::raw('DATE_FORMAT(Orders.RxExpiryDate, "%m/%d/%Y") AS RxExpiryDate'), 'd.marketer', 'd.gcn_seq', 'd.major_reporting_cat',
                        DB::raw('DATE_FORMAT(Orders.created_at, "%m/%d/%y %h:%i %p") AS service_date'), 'd.minor_reporting_class',
                        DB::raw('CONCAT(pct.practice_code, "-", case when Orders.RefillCount < 9 then concat(Orders.Rxnumber,"-0",Orders.RefillCount) else concat(Orders.Rxnumber,"-",Orders.RefillCount) end) as RxNumber'),
                        'd.rx_label_name AS rx_label_name', 'd.Strength AS strength', 'd.dosage_form AS dosage_form', DB::raw('Orders.Quantity AS qty'),
                        DB::raw('CONCAT(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19") USING "utf8"), " ", CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8")) AS PatName'),
                        DB::raw('FORMAT(Orders.RxPatientOutOfPocket, 2) AS RxPatientOutOfPocket'), DB::raw('FORMAT(Orders.RxThirdPartyPay, 2) AS RxThirdPartyPay')
                         ])
                         
                ->join('drugs_new AS d', 'd.id', '=', 'Orders.DrugDetailId')
                ->join('practices AS pct', 'pct.Id', '=', 'Orders.PracticeId')
                ->join('PatientProfileInfo AS ppi', 'ppi.Id', '=', 'Orders.PatientId')

                ->when($request->from_date!='', function ($query) use ($request) {

                    $query->whereBetween(DB::raw('DATE_FORMAT(Orders.created_at, "%Y-%m-%d")'), array(Carbon::parse($request->from_date)->format('Y-m-d'), Carbon::parse($request->to_date)->format('Y-m-d')));
            })
            ->orderBy('Orders.RxPatientOutOfPocket', 'DESC')->groupBy('Orders.Id')->get();

            $data['orders_data'] = $result->all();

           // dd($request->all());
           // if(isset($download) and $download=='download')
           // {
           //     ini_set('memory_limit','256M'); 
           //     return Excel::download(new ReporterReportsExport($data, 'pat_out_pocket_report'), 'pat_out_pocket_report_'.time().'.xlsx');
           // }
           
        return view('reports.pat_out_pocket_report', $data);
    }
    public function zero_refill_remainings_orders()
    {
        $days = 360;
        
        $result = Order::select([DB::raw('Orders.RefillsRemaining AS refillsRemaining'), DB::raw('DATE_FORMAT(Orders.nextRefillDate, "%m/%d/%Y") AS nextRefillDate'),
                        DB::raw('DATE_FORMAT(Orders.RxExpiryDate, "%m/%d/%Y") AS RxExpiryDate'),
                        DB::raw('DATE_FORMAT(Orders.created_at, "%m/%d/%y %h:%i %p") AS service_date'), 
                        DB::raw('CONCAT(pct.practice_code, "-", case when Orders.RefillCount < 9 then concat(Orders.Rxnumber,"-0",Orders.RefillCount) else concat(Orders.Rxnumber,"-",Orders.RefillCount) end) as RxNumber'),
                        'd.rx_label_name AS rx_label_name', 'ppi.Id as pat_id', 'd.Strength AS strength', 'd.dosage_form AS dosage_form', DB::raw('Orders.Quantity AS qty'),
                        DB::raw('CONCAT(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19") USING "utf8"), " ", CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8")) AS PatName'),
                        DB::raw('FORMAT(Orders.RxPatientOutOfPocket, 2) AS RxPatientOutOfPocket'), DB::raw('FORMAT(Orders.RxThirdPartyPay, 2) AS RxThirdPartyPay')
                         ])
                         
                ->join('drugs_new AS d', 'd.id', '=', 'Orders.DrugDetailId')
                ->join('practices AS pct', 'pct.Id', '=', 'Orders.PracticeId')
                ->join('PatientProfileInfo AS ppi', 'ppi.Id', '=', 'Orders.PatientId')

                ->when($days!=0, function ($query) use ($days) {

                    $end_date = Carbon::now()->format('Y-m-d');
                    $start_date = Carbon::now()->subDays($days)->format('Y-m-d');
                    $query->whereBetween('Orders.nextRefillDate', array($start_date, $end_date));
            })
            ->where('Orders.RefillsRemaining', 0)
            ->orderBy('nextRefillDate', 'DESC')->groupBy('Orders.Id')->get();

            
            $data['orders_data'] = $result->all();

            $data['survey_data'] = \App\SurveyCategory::with("Survey")->has("Survey")->get(); 
            
            // if(isset($download) and $download=='download')
            // {
            //     ini_set('memory_limit','256M'); 
            //     return Excel::download(new ReporterReportsExport($data, 'zero_refill_report'), 'zero_refill_report_'.time().'.xlsx');
            // }

        return view('reports.zero_refill_report', $data);
    }
    public function near_expiration($download=false)
    {
        $days = 30;
        
        $result = Order::select([DB::raw('Orders.RefillsRemaining AS refillsRemaining'), DB::raw('DATE_FORMAT(Orders.nextRefillDate, "%m/%d/%Y") AS nextRefillDate'),
                                DB::raw('DATE_FORMAT(Orders.RxExpiryDate, "%m/%d/%Y") AS RxExpiryDate'), 'd.marketer', 'd.gcn_seq', 'd.major_reporting_cat',
                                DB::raw('DATE_FORMAT(Orders.created_at, "%m/%d/%y %h:%i %p") AS service_date'), 'd.minor_reporting_class',
                                DB::raw('CONCAT(pct.practice_code, "-", case when Orders.RefillCount < 9 then concat(Orders.Rxnumber,"-0",Orders.RefillCount) else concat(Orders.Rxnumber,"-",Orders.RefillCount) end) as RxNumber'),
                                'd.rx_label_name AS rx_label_name', 'd.Strength AS strength', 'd.dosage_form AS dosage_form', DB::raw('Orders.Quantity AS qty'),
                                DB::raw('CONCAT(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19") USING "utf8"), " ", CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8")) AS PatName'),
                                DB::raw('FORMAT(Orders.RxPatientOutOfPocket, 2) AS RxPatientOutOfPocket'), DB::raw('FORMAT(Orders.RxThirdPartyPay, 2) AS RxThirdPartyPay')
                         ])
                         
                ->join('drugs_new AS d', 'd.id', '=', 'Orders.DrugDetailId')
                ->join('practices AS pct', 'pct.Id', '=', 'Orders.PracticeId')
                ->join('PatientProfileInfo AS ppi', 'ppi.Id', '=', 'Orders.PatientId')

                ->when($days!=0, function ($query) use ($days) {

                    $start_date =  Carbon::now()->format('Y-m-d');
                    $end_date = Carbon::now()->addDays($days)->format('Y-m-d');

                    $query->whereBetween('Orders.nextRefillDate', array($start_date, $end_date));


            })
            
            ->orderBy('nextRefillDate', 'ASC')->groupBy('Orders.Id')->get();

           
            $data['orders_data'] = $result->all();

            // if(isset($download) and $download=='download')
            // {
            //     ini_set('memory_limit','256M'); 
            //     return Excel::download(new ReporterReportsExport($data, 'near_expiration_report'), 'near_expiration_report_'.time().'.xlsx');
            // }


        return view('reports.near_expiration_report', $data);
    }
   
    public function least_medication()
    {
        $data['requests'] = Order::select(['Orders.created_at', 'os.Name as order_status', 'Orders.PatientId AS patient_id', 'Orders.Id AS order_id',
                                    DB::raw('Orders.Rxnumber as RxNumber'),DB::raw('(CONCAT(p.practice_code,"-",Orders.Rxnumber)) as pc_rxNumber'), 'Orders.RefillsRemaining', 'Orders.DaysSupply', 
                                    DB::raw('CONCAT(LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19") USING "utf8")), " ", LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8"))) AS patient_name'),
                                    DB::raw('YEAR(CURDATE()) - YEAR(DATE_FORMAT(STR_TO_DATE(AES_DECRYPT (FROM_BASE64(BirthDate),"ss20compliance19"), "%Y-%m-%d"), "%Y-%m-%d")) AS age'),
                                    DB::raw('DATE_FORMAT(STR_TO_DATE(AES_DECRYPT (FROM_BASE64(BirthDate),"ss20compliance19"), "%Y-%m-%d"), "%m/%d/%Y") AS dob'),
                                    DB::raw('DATE_FORMAT(Orders.RxExpiryDate, "%m/%d/%Y") AS RxExpiryDate'),
                                    DB::raw('CONVERT(AES_DECRYPT (FROM_BASE64(ppi.MobileNumber),"ss20compliance19") USING "utf8") AS phone_no'),
                                    DB::raw('CONCAT(TRIM(d.strength), " ", TRIM(d.dosage_form)) AS strength_dosage'), 
                                    DB::raw('TRIM(d.rx_label_name) AS rx_label_name'), 'ppi.Gender AS Gender',
                                    DB::raw('d.brand_reference AS marketer'),
                                    'd.minor_reporting_class as minor',
                                    'd.brand_reference AS brand_reference', 'Orders.Quantity AS quantity',
                                    'Orders.asistantAuth AS asisAuth', 'p.practice_name', 
                                    DB::raw('((SELECT SUM(DATEDIFF(nOd.service_date, nOd.nextRefillDateOfPreviousOrder))
                                    FROM Orders AS nOd WHERE nOd.RxNumber=Orders.RxNumber) + 
                                    (DATEDIFF(CURDATE(), DATE_FORMAT(Orders.nextRefillDate, "%Y-%m-%d")))) AS total_delay_in_days'),
                                    DB::raw('(SELECT COUNT(*) FROM Orders o1 WHERE o1.RxNumber=Orders.RxNumber) AS oc')
                                ])
                            ->join(
                                    DB::Raw('(SELECT Id, RxNumber, MIN(RefillsRemaining) AS RefillRemain FROM Orders GROUP BY RxNumber) AS my_tables'), 
                                    function($query){
                                    $query->on('my_tables.RxNumber','Orders.RxNumber')
                                          ->on('my_tables.RefillRemain', 'Orders.RefillsRemaining');
                            })
                            ->join('PatientProfileInfo AS ppi', 'ppi.Id', 'Orders.PatientId')
                            ->join('drugs_new AS d', 'd.Id', 'Orders.DrugDetailId')
                            ->join('OrderStatus AS os', 'Orders.OrderStatus', 'os.Id')
                            ->join('practices AS p', 'p.id', 'Orders.PracticeId')                            
                       // ->where('ppi.physcian_practice_id',  auth::user()->practice_id )
                      // ->where('Orders.OrderType', 'Refill')
                       ->where(DB::raw('((SELECT SUM(DATEDIFF(nOd.service_date, nOd.nextRefillDateOfPreviousOrder))
                                    FROM Orders AS nOd WHERE nOd.RxNumber=Orders.RxNumber) + 
                                    (DATEDIFF(CURDATE(), DATE_FORMAT(Orders.nextRefillDate, "%Y-%m-%d"))))'), '>', 0)
                       ->where('Orders.RefillsRemaining', '>', 0 )
                       ->where('Orders.DaysSupply','>=',15)
                       ->where('d.maintenance',2)
                       // hassan added for test 13 oct 2020
                       ->where('OrderType', 'Refill')
                    //    ->where('OrderStatus', 8)
                    // hassan test end
                        ->orderBy('total_delay_in_days', 'DESC')
                        ->paginate(7);
                        // ->get();

        // dd($data['requests']);
        return view('reports.least_medication', $data);
    }

    public function best_medication()
    {
        $data['requests'] = Order::select(['Orders.created_at', 'os.Name as order_status', 'Orders.PatientId AS patient_id', 'Orders.Id AS order_id',
                                    DB::raw('Orders.Rxnumber as RxNumber'),DB::raw('(CONCAT(p.practice_code,"-",Orders.Rxnumber)) as pc_rxNumber'), 'Orders.RefillsRemaining', 'Orders.DaysSupply', 
                                    DB::raw('CONCAT(LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19") USING "utf8")), " ", LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8"))) AS patient_name'),
                                    DB::raw('YEAR(CURDATE()) - YEAR(DATE_FORMAT(STR_TO_DATE(AES_DECRYPT (FROM_BASE64(BirthDate),"ss20compliance19"), "%Y-%m-%d"), "%Y-%m-%d")) AS age'),
                                    DB::raw('DATE_FORMAT(STR_TO_DATE(AES_DECRYPT (FROM_BASE64(BirthDate),"ss20compliance19"), "%Y-%m-%d"), "%m/%d/%Y") AS dob'),
                                    DB::raw('DATE_FORMAT(Orders.RxExpiryDate, "%m/%d/%Y") AS RxExpiryDate'),
                                    DB::raw('CONVERT(AES_DECRYPT (FROM_BASE64(ppi.MobileNumber),"ss20compliance19") USING "utf8") AS phone_no'),
                                    DB::raw('CONCAT(TRIM(d.strength), " ", TRIM(d.dosage_form)) AS strength_dosage'), 
                                    DB::raw('TRIM(d.rx_label_name) AS rx_label_name'), 'ppi.Gender AS Gender',
                                    DB::raw('d.brand_reference AS marketer'),'d.minor_reporting_class as minor',
                                    'd.brand_reference AS brand_reference', 'Orders.Quantity AS quantity',
                                    'Orders.asistantAuth AS asisAuth', 'p.practice_name', 
                                    DB::raw('((SELECT SUM(DATEDIFF(nOd.service_date, nOd.nextRefillDateOfPreviousOrder))
                                    FROM Orders AS nOd WHERE nOd.RxNumber=Orders.RxNumber) + 
                                    (DATEDIFF(CURDATE(), DATE_FORMAT(Orders.nextRefillDate, "%Y-%m-%d"))) ) AS total_delay_in_days'),DB::raw('(SELECT COUNT(*) FROM Orders o1 WHERE o1.RxNumber=Orders.RxNumber) AS oc')])
                            ->join(
                                    DB::Raw('(SELECT Id, RxNumber, MIN(RefillsRemaining) AS RefillRemain FROM Orders GROUP BY RxNumber) AS my_tables'), 
                                    function($query){
                                    $query->on('my_tables.RxNumber','Orders.RxNumber')
                                          ->on('my_tables.RefillRemain', 'Orders.RefillsRemaining');
                            })
                            ->join('PatientProfileInfo AS ppi', 'ppi.Id', 'Orders.PatientId')
                            ->join('drugs_new AS d', 'd.Id', 'Orders.DrugDetailId')
                            ->join('OrderStatus AS os', 'Orders.OrderStatus', 'os.Id')
                            ->join('practices AS p', 'p.id', 'Orders.PracticeId')                            
                       // ->where('ppi.physcian_practice_id',  auth::user()->practice_id )
                       ->where(DB::raw('((SELECT SUM(DATEDIFF(nOd.service_date, nOd.nextRefillDateOfPreviousOrder))
                                    FROM Orders AS nOd WHERE nOd.RxNumber=Orders.RxNumber) + 
                                    (DATEDIFF(CURDATE(), DATE_FORMAT(Orders.nextRefillDate, "%Y-%m-%d"))))'), '<=', 0)
                        ->where('Orders.OrderType', 'Refill')
                       ->where('Orders.RefillsRemaining', '>', 0 )
                       ->where('Orders.DaysSupply','>=',15)
                       ->where('d.maintenance',2)
                        ->orderBy('total_delay_in_days', 'ASC')
                        ->paginate(7);
                        // ->get();

        // dd($data['requests']);
        return view('reports.least_medication', $data);
    }

    public function greater_sixty_days()
    {
        $data['requests'] = Order::select(['Orders.created_at', 'os.Name as order_status', 'Orders.PatientId AS patient_id', 'Orders.Id AS order_id',
                                    DB::raw('Orders.Rxnumber as RxNumber'),DB::raw('(CONCAT(p.practice_code,"-",Orders.Rxnumber)) as pc_rxNumber'), 'Orders.RefillsRemaining', 'Orders.DaysSupply', 
                                    DB::raw('CONCAT(LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19") USING "utf8")), " ", LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8"))) AS patient_name'),
                                    DB::raw('YEAR(CURDATE()) - YEAR(DATE_FORMAT(STR_TO_DATE(AES_DECRYPT (FROM_BASE64(BirthDate),"ss20compliance19"), "%Y-%m-%d"), "%Y-%m-%d")) AS age'),
                                    DB::raw('DATE_FORMAT(STR_TO_DATE(AES_DECRYPT (FROM_BASE64(BirthDate),"ss20compliance19"), "%Y-%m-%d"), "%m/%d/%Y") AS dob'),
                                    DB::raw('DATE_FORMAT(Orders.RxExpiryDate, "%m/%d/%Y") AS RxExpiryDate'),
                                    DB::raw('CONVERT(AES_DECRYPT (FROM_BASE64(ppi.MobileNumber),"ss20compliance19") USING "utf8") AS phone_no'),
                                    DB::raw('CONCAT(TRIM(d.strength), " ", TRIM(d.dosage_form)) AS strength_dosage'), 
                                    DB::raw('TRIM(d.rx_label_name) AS rx_label_name'), 'ppi.Gender AS Gender',
                                    DB::raw('d.brand_reference AS marketer'),
                                    'd.brand_reference AS brand_reference', 'Orders.Quantity AS quantity','d.minor_reporting_class as minor',
                                    'Orders.asistantAuth AS asisAuth', 'p.practice_name', 
                                    DB::raw('((SELECT SUM(DATEDIFF(nOd.service_date, nOd.nextRefillDateOfPreviousOrder))
                                            FROM Orders AS nOd WHERE nOd.RxNumber=Orders.RxNumber) + 
                                            (DATEDIFF(CURDATE(), DATE_FORMAT(Orders.nextRefillDate, "%Y-%m-%d"))) ) AS total_delay_in_days'),
                                    DB::raw('DATEDIFF(CURDATE(), DATE_FORMAT(Orders.nextRefillDate, "%Y-%m-%d")) AS last_delay'),DB::raw('(SELECT COUNT(*) FROM Orders o1 WHERE o1.RxNumber=Orders.RxNumber) AS oc')])
                            ->join(
                                    DB::Raw('(SELECT Id, RxNumber, MIN(RefillsRemaining) AS RefillRemain FROM Orders GROUP BY RxNumber) AS my_tables'), 
                                    function($query){
                                    $query->on('my_tables.RxNumber','Orders.RxNumber')
                                          ->on('my_tables.RefillRemain', 'Orders.RefillsRemaining');
                            })
                            ->join('PatientProfileInfo AS ppi', 'ppi.Id', 'Orders.PatientId')
                            ->join('drugs_new AS d', 'd.Id', 'Orders.DrugDetailId')
                            ->join('OrderStatus AS os', 'Orders.OrderStatus', 'os.Id')
                            ->join('practices AS p', 'p.id', 'Orders.PracticeId')                            
                       // ->where('ppi.physcian_practice_id',  auth::user()->practice_id )
                       ->where( DB::raw('DATEDIFF(CURDATE(), DATE_FORMAT(Orders.nextRefillDate, "%Y-%m-%d"))'), '>=', 60 )
                       ->where('Orders.RefillsRemaining', '>', 0 )
                       ->where('Orders.DaysSupply','>=',15)
                       ->where('d.maintenance',2)
                      // ->where(DB::raw('DATEDIFF(CURDATE(), DATE_FORMAT(Orders.nextRefillDate, "%Y-%m-%d"))'), '!=', null)
                        ->orderBy('total_delay_in_days', 'DESC')
                        ->paginate(7);
                        // ->get();

        // dd($data['requests']);
        return view('reports.least_medication', $data);
    }

    public function forty_to_fiftynine_days()
    {
        $data['requests'] = Order::select(['Orders.created_at', 'os.Name as order_status', 'Orders.PatientId AS patient_id', 'Orders.Id AS order_id',
                                    DB::raw('Orders.Rxnumber as RxNumber'),DB::raw('(CONCAT(p.practice_code,"-",Orders.Rxnumber)) as pc_rxNumber'), 'Orders.RefillsRemaining', 'Orders.DaysSupply', 
                                    DB::raw('CONCAT(LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19") USING "utf8")), " ", LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8"))) AS patient_name'),
                                    DB::raw('YEAR(CURDATE()) - YEAR(DATE_FORMAT(STR_TO_DATE(AES_DECRYPT (FROM_BASE64(BirthDate),"ss20compliance19"), "%Y-%m-%d"), "%Y-%m-%d")) AS age'),
                                    DB::raw('DATE_FORMAT(STR_TO_DATE(AES_DECRYPT (FROM_BASE64(BirthDate),"ss20compliance19"), "%Y-%m-%d"), "%m/%d/%Y") AS dob'),
                                    DB::raw('DATE_FORMAT(Orders.RxExpiryDate, "%m/%d/%Y") AS RxExpiryDate'),
                                    DB::raw('CONVERT(AES_DECRYPT (FROM_BASE64(ppi.MobileNumber),"ss20compliance19") USING "utf8") AS phone_no'),
                                    DB::raw('CONCAT(TRIM(d.strength), " ", TRIM(d.dosage_form)) AS strength_dosage'), 
                                    DB::raw('TRIM(d.rx_label_name) AS rx_label_name'), 'ppi.Gender AS Gender',
                                    DB::raw('d.brand_reference AS marketer'),'d.minor_reporting_class as minor',
                                    'd.brand_reference AS brand_reference', 'Orders.Quantity AS quantity',
                                    'Orders.asistantAuth AS asisAuth', 'p.practice_name', 
                                    DB::raw('((SELECT SUM(DATEDIFF(nOd.service_date, nOd.nextRefillDateOfPreviousOrder))
                                            FROM Orders AS nOd WHERE nOd.RxNumber=Orders.RxNumber) + 
                                            (DATEDIFF(CURDATE(), DATE_FORMAT(Orders.nextRefillDate, "%Y-%m-%d"))) ) AS total_delay_in_days'),
                                    DB::raw('DATEDIFF(CURDATE(), DATE_FORMAT(Orders.nextRefillDate, "%Y-%m-%d")) AS last_delay'),DB::raw('(SELECT COUNT(*) FROM Orders o1 WHERE o1.RxNumber=Orders.RxNumber) AS oc')])
                            ->join(
                                    DB::Raw('(SELECT Id, RxNumber, MIN(RefillsRemaining) AS RefillRemain FROM Orders GROUP BY RxNumber) AS my_tables'), 
                                    function($query){
                                    $query->on('my_tables.RxNumber','Orders.RxNumber')
                                          ->on('my_tables.RefillRemain', 'Orders.RefillsRemaining');
                            })
                            ->join('PatientProfileInfo AS ppi', 'ppi.Id', 'Orders.PatientId')
                            ->join('drugs_new AS d', 'd.Id', 'Orders.DrugDetailId')
                            ->join('OrderStatus AS os', 'Orders.OrderStatus', 'os.Id')
                            ->join('practices AS p', 'p.id', 'Orders.PracticeId')                            
                       // ->where('ppi.physcian_practice_id',  auth::user()->practice_id )
                       ->whereBetween( DB::raw('DATEDIFF(CURDATE(), DATE_FORMAT(Orders.nextRefillDate, "%Y-%m-%d"))'), [40, 59])
                     
                       ->where('Orders.RefillsRemaining', '>', 0 )
                       ->where('Orders.DaysSupply','>=',15)
                       ->where('d.maintenance',2)
                        ->orderBy('total_delay_in_days', 'DESC')
                        ->paginate(7);
                        // ->get();

    // dd($data['requests']);
        return view('reports.least_medication', $data);
    }

    public function get_statistics_old($rx_number)
    {
        $result = Order::select([DB::raw('FORMAT(RxPatientOutOfPocket, 2) AS RxPatientOutOfPocket'), 
                    DB::raw('DATE_FORMAT(nextRefillDateOfPreviousOrder, "%m/%d/%Y") AS LastRefillDate'),
                    'OrderType',
                    DB::raw('DATE_FORMAT(status_updated_date, "%m/%d/%Y") AS refill_date'),
                    DB::raw('DATE_FORMAT(nextRefillDate, "%Y-%m-%d") AS nextRefillDate'),
                    DB::raw('DATEDIFF(DATE_FORMAT(status_updated_date, "%Y-%m-%d"), nextRefillDateOfPreviousOrder) AS delay'),
                    DB::raw('DATEDIFF(DATE_FORMAT(nextRefillDate, "%Y-%m-%d"), status_updated_date) AS refillDays'),
                    DB::raw('(CASE WHEN ( DATEDIFF(CURDATE(), DATE_FORMAT(nextRefillDate, "%Y-%m-%d")) ) > 0 THEN DATEDIFF(CURDATE(), DATE_FORMAT(nextRefillDate, "%Y-%m-%d"))
                            ELSE 0 END) AS end_delay')])
                    ->where('RxNumber', $rx_number)
                    // hassan updated 13 oct 2020
                    ->where('OrderType', 'Refill')
                    // ->where('OrderStatus', 8)
                    // hassan updated 13 oct 2020
                    ->orderBy('Orders.RefillsRemaining', 'DESC')->get();
        // return $result;
        $total_days = 0;
        $last_key = (count($result->all())-1);
        // return $last_key;
        $result->filter(function ($value, $key) use ($last_key, $total_days) {
            // echo $key;
            if($key!=$last_key){ 
                unset($value['end_delay']); unset($value->end_delay); 
            }
          //  $value['qty'] = number_format($value['qty'], 1);
           $value['total_days'] = ($value['refillDays']>0 ? $value['refillDays'] : 0) + ($value['delay']>0 ? $value['delay'] : 0) + (isset($value['end_delay']) ? $value['end_delay'] : 0);
           
            return $value;
        });

        $data['statistics'] = $result;
    //    echo count($data['statistics']);
        $data['total_days'] = $result->sum('total_days');
        $data['total_delays'] = ($result->sum('delay') + $result->sum('end_delay'));
   //dd($data);
        return view('reports.includes.refill_states', $data);
    }



    public function get_statistics($rx_number)
    {
       // $rxNumber = Order::select(['RxNumber'])->where('Id', $order_id)->first();
        
        $result = Order::select(['Id', DB::raw('FORMAT(RxPatientOutOfPocket, 2) AS RxPatientOutOfPocket'), 'DaysSupply', 
                        'status_updated_date', 'nextRefillDate', 'nextRefillDateOfPreviousOrder', 'RxExpiryDate','PatientId',
                        'RxOrigDate', 'created_at', 'updated_at', 'RefillsRemaining',  'service_date', 'OrderType'])
                    ->where('RxNumber', $rx_number)
                    //->where('OrderType', 'Refill')
                    // ->where('OrderStatus', 8)
                    ->orderBy('RefillsRemaining', 'DESC')->get();
        
        $myResult = [];
        
        //dd($result);
        $PrevnextRefill = null;
        $preOrderId = null; 
        
        $total_delay = 0;
        $total_delay_count = 0;
        $blue_red_count=0;
        
        if($result->count()>0)
        {
            foreach($result as $mKey=>$mVal)
            {
                if($preOrderId!=null)
                {
                    $current_order_date = Carbon::parse($mVal->service_date);
                    $nextRefillDate = Carbon::parse($PrevnextRefill);
                   
                    $delay = $nextRefillDate->diffInDays($current_order_date, false);
                    
                    if($delay>0)
                    {
                        $myResult[] = array(
                            's_type' => 'refill_delay',
                            'delay' => $delay,
                            'refill_date_should_be' => $nextRefillDate->format('m/d/Y'),
                            'notifications' => $this->get_notificatios_survays($mVal->PatientId,$preOrderId, $PrevnextRefill, $mVal->service_date)
                        );
                        $total_delay_count++;
                    }
                    
                    //print_r();
                    //exit;
                    //$delay = 
                    $total_delay = $total_delay + $delay;
                    $blue_red_count=$blue_red_count+$delay;
                }
                //my code to calculate blue delay
                $order_service = Carbon::parse($mVal->service_date);
                $order_prev_next_refill = Carbon::parse($mVal->nextRefillDate);
                   
                $bl_delay = $order_service->diffInDays($order_prev_next_refill,false);
                 //end
                $blue_red_count=$blue_red_count+$bl_delay;
                
                $myResult[] = array(
                        's_type' => 'order',
                        'order_id' => $mVal->Id,
                        'order_payment' => $mVal->RxPatientOutOfPocket,
                        'refill_remaining' => $mVal->RefillsRemaining,
                        'order_date' => $mVal->created_at,
                        'days_supply' => $mVal->DaysSupply,
                        'order_type' => $mVal->OrderType,
                        'order_Origdate' => $mVal->RxOrigDate,
                        'service_date' => Carbon::parse($mVal->service_date)->format('m/d/Y'),
                        'notifications' => $this->get_notificatios_survays($mVal->PatientId,$mVal->Id, $mVal->service_date, $mVal->nextRefillDate),
                        'temp_next_refill'=>$mVal->nextRefillDate,
                        'blue_delay'=>$bl_delay
                    );
                
                
                
                if($mVal->RefillsRemaining!=0 and $mKey==($result->count()-1))
                {
                    
                     $current_order_date = Carbon::parse($mVal->nextRefillDate);
                     
                    $nextRefillDate =  Carbon::now()->format('Y-m-d');
                   
                    $delay = $current_order_date->diffInDays($nextRefillDate, false);
                    
                    if($delay>0)
                    {
                        $myResult[] = array(
                            's_type' => 'refill_delay',
                            'delay' => $delay,
                            'refill_date_should_be' => $current_order_date->format('m/d/Y'),
                            'notifications' => $this->get_notificatios_survays($mVal->PatientId,$mVal->Id, $current_order_date, $nextRefillDate)
                        );
                        
                        $total_delay_count++;
                    }
                    
                    $total_delay = $total_delay + $delay;
                    $blue_red_count=$blue_red_count+$delay;
                }
                $preOrderId = $mVal->Id;
                $PrevnextRefill = $mVal->nextRefillDate;
            }
        }
        $blue_red_count=$blue_red_count*6;
        foreach ($myResult as $key => $value) {
            if($value['notifications'])
            {
                $blue_red_count=$blue_red_count+(count($value['notifications'])*14);
            }
        }
        
        $data['statistics'] = $myResult;
        $data['total_orders_delay'] = $result->count();
        $data['total_delays'] = $total_delay;
        $data['blue_red_count']=$blue_red_count;


        return view('reports.includes.refill_states', $data);
    }


    public function get_leftmenu_cats()
    {

       $result =  Order::select([DB::raw('TRIM(d.major_reporting_cat) AS major_reporting'), DB::raw('TRIM(d.minor_reporting_class) AS minor_reporting'), 
                                    DB::raw('COUNT(Orders.Id) as total_orders'),
                                    DB::raw('((SELECT SUM(DATEDIFF(nOd.service_date, nOd.nextRefillDateOfPreviousOrder))
                                    FROM Orders AS nOd WHERE nOd.RxNumber=Orders.RxNumber) + 
                                    (DATEDIFF(CURDATE(), DATE_FORMAT(Orders.nextRefillDate, "%Y-%m-%d")))) AS total_delay_in_days')])
                            ->join(
                                    DB::Raw('(SELECT Id, RxNumber, MIN(RefillsRemaining) AS RefillRemain FROM Orders GROUP BY RxNumber) AS my_tables'), 
                                    function($query){
                                    $query->on('my_tables.RxNumber','Orders.RxNumber')
                                          ->on('my_tables.RefillRemain', 'Orders.RefillsRemaining');
                            })
                            ->join('PatientProfileInfo AS ppi', 'ppi.Id', 'Orders.PatientId')
                            ->join('drugs_new AS d', 'd.Id', 'Orders.DrugDetailId')
                            ->join('OrderStatus AS os', 'Orders.OrderStatus', 'os.Id')
                       // ->where('ppi.physcian_practice_id',  auth::user()->practice_id )
                       ->where('Orders.OrderType', 'Refill')
                       ->where(DB::raw('((SELECT SUM(DATEDIFF(nOd.service_date, nOd.nextRefillDateOfPreviousOrder))
                                    FROM Orders AS nOd WHERE nOd.RxNumber=Orders.RxNumber) + 
                                    (DATEDIFF(CURDATE(), DATE_FORMAT(Orders.nextRefillDate, "%Y-%m-%d"))))'), '>=', 0)
                       ->where('Orders.RefillsRemaining', '>', 0 )
                        ->orderBy('major_reporting_cat', 'ASC')
                        ->groupBy('d.minor_reporting_class')
                        ->get();
                           
        $data['filtered_result']  = $result->groupBy('major_reporting');

        return view('reports.includes.leftmenu_major_cat', $data);
    }

    public function get_leftmenu_orders($minor_cat)
    {
        $minor_class = str_replace('--', ' ',$minor_cat);

        $results = Order::select(['Orders.Id AS order_id', DB::raw('Orders.Rxnumber as RxNumber'),
                                    DB::raw('TRIM(d.rx_label_name) AS rx_label_name'),
                                    DB::raw('((SELECT SUM(DATEDIFF(nOd.service_date, nOd.nextRefillDateOfPreviousOrder))
                                    FROM Orders AS nOd WHERE nOd.RxNumber=Orders.RxNumber) + 
                                    (DATEDIFF(CURDATE(), DATE_FORMAT(Orders.nextRefillDate, "%Y-%m-%d")))) AS total_delay_in_days')])
                            ->join(
                                    DB::Raw('(SELECT Id, RxNumber, MIN(RefillsRemaining) AS RefillRemain FROM Orders GROUP BY RxNumber) AS my_tables'), 
                                    function($query){
                                    $query->on('my_tables.RxNumber','Orders.RxNumber')
                                          ->on('my_tables.RefillRemain', 'Orders.RefillsRemaining');
                            })
                            ->join('PatientProfileInfo AS ppi', 'ppi.Id', 'Orders.PatientId')
                            ->join('drugs_new AS d', 'd.Id', 'Orders.DrugDetailId')
                            ->join('OrderStatus AS os', 'Orders.OrderStatus', 'os.Id')                        
                       // ->where('ppi.physcian_practice_id',  auth::user()->practice_id )
                       ->where('Orders.OrderType', 'Refill')
                       ->where('d.minor_reporting_class', $minor_class)
                       ->where(DB::raw('((SELECT SUM(DATEDIFF(nOd.service_date, nOd.nextRefillDateOfPreviousOrder))
                                    FROM Orders AS nOd WHERE nOd.RxNumber=Orders.RxNumber) + 
                                    (DATEDIFF(CURDATE(), DATE_FORMAT(Orders.nextRefillDate, "%Y-%m-%d"))))'), '>=', 0)
                       ->where('Orders.RefillsRemaining', '>', 0 )
                        ->orderBy('total_delay_in_days', 'DESC')
                        ->groupBy('Orders.RxNumber')
                        ->get();
        
        if($results->count()>0)
        {
            $html = '<ul><li><span class="p-score">compliance score</span> <span class="p-name">product</span></li>';
            foreach($results as $nKy=>$nVl)
            {
                $rating = '0';
                $my_result = $this->get_statistics_raw($nVl->RxNumber, $nVl->order_id);
                //dd($my_result);
                if($my_result['statistics']->count()>0){ $rating = number_format($my_result['total_delays']/($my_result['statistics']->count()+1), 2); }
                $html .= '<li><a href="'.url('reports/rating/'.$nVl->order_id).'"><span class="p-score">'.$rating.'</span><span class="p-name">'.$nVl->rx_label_name.'</span></a></li>';
            }
            $html .= '</ul>';

            echo $html;
        }
        
    }

    public function get_statistics_raw($rx_number, $o_id = 0)
    {
        $result = Order::select([DB::raw('FORMAT(RxPatientOutOfPocket, 2) AS RxPatientOutOfPocket'), 
                    DB::raw('DATE_FORMAT(nextRefillDateOfPreviousOrder, "%m/%d/%Y") AS LastRefillDate'),
                    DB::raw('DATE_FORMAT(status_updated_date, "%m/%d/%Y") AS refill_date'),
                    DB::raw('DATE_FORMAT(nextRefillDate, "%Y-%m-%d") AS nextRefillDate'),
                    DB::raw('DATEDIFF(DATE_FORMAT(service_date, "%Y-%m-%d"), nextRefillDateOfPreviousOrder) AS delay'),
                    DB::raw('DATEDIFF(DATE_FORMAT(nextRefillDate, "%Y-%m-%d"), status_updated_date) AS refillDays'),
                    DB::raw('(CASE WHEN ( DATEDIFF(CURDATE(), DATE_FORMAT(nextRefillDate, "%Y-%m-%d")) ) > 0 THEN DATEDIFF(CURDATE(), DATE_FORMAT(nextRefillDate, "%Y-%m-%d"))
                            ELSE 0 END) AS end_delay')])
                    ->where('OrderType', 'Refill')
                    // ->where('OrderStatus', 8)
                    ->where('RxNumber', $rx_number)
                    ->orderBy('Orders.RefillsRemaining', 'DESC')->get();
        
        $total_days = 0;
        $last_key = (count($result->all())-1);
        $result->filter(function ($value, $key) use ($last_key, $total_days) {
            if($key!=$last_key){ 
                unset($value['end_delay']); unset($value->end_delay); 
            }
          //  $value['qty'] = number_format($value['qty'], 1);
           $value['total_days'] = ($value['refillDays']>0 ? $value['refillDays'] : 0) + ($value['delay']>0 ? $value['delay'] : 0) + (isset($value['end_delay']) ? $value['end_delay'] : 0);
           
            return $value;
        });

        $data['statistics'] = $result;
        $data['total_days'] = $result->sum('total_days');
        $data['total_delays'] = ($result->sum('delay') + $result->sum('end_delay'));
   //dd($data);
        return $data;
    }


    public function get_notificatios_survays($patient_id, $order_id, $start_date, $end_date)
    {
        
         $end_date = Carbon::parse($end_date)->format('Y-m-d');
        
        $start_date = Carbon::parse($start_date)->format('Y-m-d');
        
        
        $res_notification = DB::table('NotificationMessages')->select([DB::raw('LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(subject),"ss20compliance19") USING "utf8")) AS title'), 
                    DB::raw('DATE_FORMAT(CreatedOn, "%m/%d/%Y") AS sending_date'), 'CreatedOn AS created_at', DB::raw('"message" AS notification_type')])
                    ->where('OrderID', $order_id)
                    ->whereIn('MessageTypeId', [28, 67, 69, 70])
                    ->whereBetween(DB::raw('DATE_FORMAT(CreatedOn, "%Y-%m-%d")'), array($start_date, $end_date))
                    ->get();
        
        
        $res_survey = DB::table('survey_logs AS sl')->select(['s.title AS title', 'sl.created_at AS created_at',
                    DB::raw('DATE_FORMAT(sl.created_at, "%m/%d/%Y") AS sending_date'), DB::raw('"survey" AS notification_type')])
                    ->leftJoin('surveys AS s', 's.id', 'sl.survey_id')
                    ->where('sl.patient_id', $patient_id)
                    ->whereBetween(DB::raw('DATE_FORMAT(sl.created_at, "%Y-%m-%d")'), array($start_date, $end_date))
                    ->get();
      
        // $result = $res_notification->merge(collect($res_survey->first()));
        if($res_survey->first())
        {
          $result = $res_notification->push($res_survey->first());  
        }
        else{
            $result = $res_notification;
        }
        $result = $result->sortBy('created_at');
      
       
        if($result->count()>0)
        {
           /* foreach($result as $nmKey=>$nmVal)
            {
                $myResponse[] = array(
                                'notification_type' => 'Message',
                                'sending_date' => Carbon::parse($nmVal->CreatedOn)->format('m/d/Y'),
                                'survayID' => $nmVal->SurveyID,
                                'order_id' => $nmVal->OrderID
                        );
            } */
            $json  = json_encode($result->values()->toArray());
            $array = json_decode($json, true);
            return $array;
        }
        else
        {
            return false;
        }
    }
    public function get_notificatios_survays_old($order_id, $start_date, $end_date)
    {
        
         $end_date = Carbon::parse($end_date)->format('Y-m-d');
        
        $start_date = Carbon::parse($start_date)->format('Y-m-d');
        
        
        $result = DB::table('NotificationMessages')->select(['Status', 'CreatedOn', 'SurveyID', 'OrderID'])
                    ->where('OrderID', $order_id)
                    ->whereBetween(DB::raw('DATE_FORMAT(CreatedOn, "%Y-%m-%d")'), array($start_date, $end_date))
                    ->get();
        
        if($result->count()>0)
        {
            foreach($result as $nmKey=>$nmVal)
            {
                $myResponse[] = array(
                                'notification_type' => 'Message',
                                'sending_date' => Carbon::parse($nmVal->CreatedOn)->format('m/d/Y'),
                                'survayID' => $nmVal->SurveyID,
                                'order_id' => $nmVal->OrderID
                        );
            }
            
            return $myResponse;
        }
        else
        {
            return false;
        }
    }
    
    public function get_order_rating_by_id($order_id)
    {
        
        
       $rxNumber = Order::select(['RxNumber'])->where('Id', $order_id)->first();
        
        $result = Order::select(['Id', DB::raw('FORMAT(RxPatientOutOfPocket, 2) AS RxPatientOutOfPocket'), 'DaysSupply', 
                        'status_updated_date', 'nextRefillDate', 'nextRefillDateOfPreviousOrder', 'RxExpiryDate','PatientId',
                        'RxOrigDate', 'created_at', 'updated_at', 'RefillsRemaining',  'service_date', 'OrderType'])
                    ->where('RxNumber', $rxNumber['RxNumber'])
                    //->where('OrderType', 'Refill')
                    // ->where('OrderStatus', 8)
                    ->orderBy('RefillsRemaining', 'DESC')->get();
        
        $myResult = [];
        
        //dd($result);
        $PrevnextRefill = null;
        $preOrderId = null; 
        
        $total_delay = 0;
        $total_delay_count = 0;
        $blue_red_count=0;
        
        if($result->count()>0)
        {
            foreach($result as $mKey=>$mVal)
            {
                if($preOrderId!=null)
                {
                    $current_order_date = Carbon::parse($mVal->service_date);
                    $nextRefillDate = Carbon::parse($PrevnextRefill);
                   
                    $delay = $nextRefillDate->diffInDays($current_order_date,false);
                    
                    if($delay>0)
                    {
                        $myResult[] = array(
                            's_type' => 'refill_delay',
                            'delay' => $delay,
                            'refill_date_should_be' => $nextRefillDate->format('m/d/Y'),
                            'notifications' => $this->get_notificatios_survays($mVal->PatientId,$preOrderId, $PrevnextRefill, $mVal->service_date)
                        );
                        $total_delay_count++;
                    }
                    
                    //print_r();
                    //exit;
                    //$delay = 
                    $total_delay = $total_delay + $delay;
                    $blue_red_count=$blue_red_count+$delay;
                }
                
                //my code to calculate blue delay
                $order_service = Carbon::parse($mVal->service_date);
                $order_prev_next_refill = Carbon::parse($mVal->nextRefillDate);
                   
                $bl_delay = $order_service->diffInDays($order_prev_next_refill,false);
                 //end
                $blue_red_count=$blue_red_count+$bl_delay;

                $myResult[] = array(
                        's_type' => 'order',
                        'order_id' => $mVal->Id,
                        'order_payment' => $mVal->RxPatientOutOfPocket,
                        'refill_remaining' => $mVal->RefillsRemaining,
                        'order_date' => $mVal->created_at,
                        'days_supply' => $mVal->DaysSupply,
                        'order_type' => $mVal->OrderType,
                        'order_Origdate' => $mVal->RxOrigDate,
                        'service_date' => Carbon::parse($mVal->service_date)->format('m/d/Y'),
                        'notifications' => $this->get_notificatios_survays($mVal->PatientId,$mVal->Id, $mVal->service_date, $mVal->nextRefillDate),
                        'temp_next_refill'=>$mVal->nextRefillDate,
                        'blue_delay'=>$bl_delay
                    );
                
                
                
                if($mVal->RefillsRemaining!=0 and $mKey==($result->count()-1))
                {
                    
                     $current_order_date = Carbon::parse($mVal->nextRefillDate);
                     
                    $nextRefillDate =  Carbon::now()->format('Y-m-d');
                   
                    $delay = $current_order_date->diffInDays($nextRefillDate,false);
                    
                    if($delay>0)
                    {
                        $myResult[] = array(
                            's_type' => 'refill_delay',
                            'delay' => $delay,
                            'refill_date_should_be' => $current_order_date->format('m/d/Y'),
                            'notifications' => $this->get_notificatios_survays($mVal->PatientId,$mVal->Id, $current_order_date, $nextRefillDate)
                        );
                        
                        $total_delay_count++;
                    
                    }
                    
                    $total_delay = $total_delay + $delay;
                    $blue_red_count=$blue_red_count+$delay;
                }
                $preOrderId = $mVal->Id;
                $PrevnextRefill = $mVal->nextRefillDate;
            }
        }
        
       // dd($myResult);
        
       // $total_days = 0;
       /// $last_key = (count($result->all())-1);
       // $result->filter(function ($value, $key) use ($last_key, $total_days) {
       //     if($key!=$last_key){ 
        //        unset($value['end_delay']); unset($value->end_delay); 
        //    }
            //  $value['qty'] = number_format($value['qty'], 1);
        //    $value['total_days'] = ($value['refillDays']>0 ? $value['refillDays'] : 0) + ($value['delay']>0 ? $value['delay'] : 0) + (isset($value['end_delay']) ? $value['end_delay'] : 0);
            
        //    return $value;
       /// });

        
        //dd($result);
        $blue_red_count=$blue_red_count*6;
        foreach ($myResult as $key => $value) {
            if($value['notifications'])
            {
                $blue_red_count=$blue_red_count+(count($value['notifications'])*14);
            }
        }
        $data['statistics'] = $myResult;
        $data['total_orders_delay'] = $result->count();
        $data['total_delays'] = $total_delay;
        $data['blue_red_count']=$blue_red_count;
  
        $data['pat'] = Order::select([DB::raw('Orders.Rxnumber as RxNumber'), DB::raw('(CONCAT(p.practice_code,"-",Orders.Rxnumber)) as pr_RxNumber'), 'Orders.PatientId', 'Orders.RefillsRemaining', 'Orders.DaysSupply', 
        DB::raw('CONCAT(LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19") USING "utf8")), " ", LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8"))) AS patient_name'),
        DB::raw('YEAR(CURDATE()) - YEAR(DATE_FORMAT(STR_TO_DATE(AES_DECRYPT (FROM_BASE64(BirthDate),"ss20compliance19"), "%Y-%m-%d"), "%Y-%m-%d")) AS age'),
        DB::raw('DATE_FORMAT(STR_TO_DATE(AES_DECRYPT (FROM_BASE64(BirthDate),"ss20compliance19"), "%Y-%m-%d"), "%m/%d/%Y") AS dob'),
        DB::raw('DATE_FORMAT(Orders.RxExpiryDate, "%m/%d/%Y") AS RxExpiryDate'),
        DB::raw('CONVERT(AES_DECRYPT (FROM_BASE64(ppi.MobileNumber),"ss20compliance19") USING "utf8") AS phone_no'),
        DB::raw('CONCAT(TRIM(d.strength), " ", TRIM(d.dosage_form)) AS strength_dosage'), 
        DB::raw('TRIM(d.rx_label_name) AS rx_label_name'), 'ppi.Gender AS Gender',
        DB::raw('d.brand_reference AS marketer'),'d.minor_reporting_class as minor',
        'd.brand_reference AS brand_reference', 'Orders.Quantity AS quantity','p.practice_name AS p_name','Orders.Id as order_id',
        'p.id as PracticeId'])

        ->join('PatientProfileInfo AS ppi', 'ppi.Id', 'Orders.PatientId')
        ->join('drugs_new AS d', 'd.Id', 'Orders.DrugDetailId')
        ->join('OrderStatus AS os', 'Orders.OrderStatus', 'os.Id')
        ->join('practices AS p', 'p.id', 'Orders.PracticeId')                            
// ->where('ppi.physcian_practice_id',  auth::user()->practice_id )
        ->where('Orders.Id', $order_id)
        ->first();

        
        //dd($data['pat']);
        
	$data['survey_data'] = \App\SurveyCategory::with("Survey")->has("Survey")->get(); 
    //dd($data);
        return view('reports.rating_report', $data);
    }

    

    public function get_order_rating_by_id_old($order_id)
    {
        $result = Order::select([DB::raw('FORMAT(RxPatientOutOfPocket, 2) AS RxPatientOutOfPocket'), 
                    DB::raw('DATE_FORMAT(nextRefillDateOfPreviousOrder, "%m/%d/%Y") AS LastRefillDate'),
                    DB::raw('DATE_FORMAT(status_updated_date, "%m/%d/%Y") AS refill_date'),
                    DB::raw('DATE_FORMAT(nextRefillDate, "%Y-%m-%d") AS nextRefillDate'),
                    DB::raw('DATEDIFF(DATE_FORMAT(status_updated_date, "%Y-%m-%d"), nextRefillDateOfPreviousOrder) AS delay'),
                    DB::raw('DATEDIFF(DATE_FORMAT(nextRefillDate, "%Y-%m-%d"), status_updated_date) AS refillDays'),
                    DB::raw('(CASE WHEN ( DATEDIFF(CURDATE(), DATE_FORMAT(nextRefillDate, "%Y-%m-%d")) ) > 0 THEN DATEDIFF(CURDATE(), DATE_FORMAT(nextRefillDate, "%Y-%m-%d"))
                            ELSE 0 END) AS end_delay')])
                    ->where('Id', $order_id)->where('OrderType', 'Refill')
                    // ->where('OrderStatus', 8)
                    ->orderBy('Orders.RefillsRemaining', 'DESC')->get();


        $total_days = 0;
        $last_key = (count($result->all())-1);
        $result->filter(function ($value, $key) use ($last_key, $total_days) {
            if($key!=$last_key){ 
                unset($value['end_delay']); unset($value->end_delay); 
            }
            //  $value['qty'] = number_format($value['qty'], 1);
            $value['total_days'] = ($value['refillDays']>0 ? $value['refillDays'] : 0) + ($value['delay']>0 ? $value['delay'] : 0) + (isset($value['end_delay']) ? $value['end_delay'] : 0);
            
            return $value;
        });

        $data['statistics'] = $result;
        $data['total_days'] = $result->sum('total_days');
        $data['total_delays'] = ($result->sum('delay') + $result->sum('end_delay'));

        $data['pat'] = Order::select([DB::raw('Orders.Rxnumber as RxNumber'), 'Orders.PatientId', 'Orders.RefillsRemaining', 'Orders.DaysSupply', 
        DB::raw('CONCAT(LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19") USING "utf8")), " ", LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8"))) AS patient_name'),
        DB::raw('YEAR(CURDATE()) - YEAR(DATE_FORMAT(STR_TO_DATE(AES_DECRYPT (FROM_BASE64(BirthDate),"ss20compliance19"), "%Y-%m-%d"), "%Y-%m-%d")) AS age'),
        DB::raw('DATE_FORMAT(STR_TO_DATE(AES_DECRYPT (FROM_BASE64(BirthDate),"ss20compliance19"), "%Y-%m-%d"), "%m/%d/%Y") AS dob'),
        DB::raw('DATE_FORMAT(Orders.RxExpiryDate, "%m/%d/%Y") AS RxExpiryDate'),
        DB::raw('CONVERT(AES_DECRYPT (FROM_BASE64(ppi.MobileNumber),"ss20compliance19") USING "utf8") AS phone_no'),
        DB::raw('CONCAT(TRIM(d.strength), " ", TRIM(d.dosage_form)) AS strength_dosage'), 
        DB::raw('TRIM(d.rx_label_name) AS rx_label_name'), 'ppi.Gender AS Gender',
        DB::raw('d.brand_reference AS marketer'),'d.minor_reporting_class as minor',
        'd.brand_reference AS brand_reference', 'Orders.Quantity AS quantity','p.practice_name AS p_name','Orders.Id as order_id',
        'p.id as PracticeId'])

        ->join('PatientProfileInfo AS ppi', 'ppi.Id', 'Orders.PatientId')
        ->join('drugs_new AS d', 'd.Id', 'Orders.DrugDetailId')
        ->join('OrderStatus AS os', 'Orders.OrderStatus', 'os.Id')
        ->join('practices AS p', 'p.id', 'Orders.PracticeId')                            
// ->where('ppi.physcian_practice_id',  auth::user()->practice_id )
        ->where('Orders.Id', $order_id)
        ->first();

	$data['survey_data'] = \App\SurveyCategory::with("Survey")->has("Survey")->get(); 
    //dd($data);
        return view('reports.rating_report', $data);
    }
    
    public function sendBulkSurveys(Request $request)
    {
        $response = json_decode($this->sendSurveyNotifications($request->survey_id, array_unique(explode(",", $request->patients))));
        return $response->errorCode;
    }
    public function sendBulkReminders(Request $request)
    {
       $response = json_decode($this->sendBulkReminder(array_unique(explode(",", $request->orderIds))));
    //   dump($response);
       return $response->errorCode;
    }

    public function sendMessagePatient(Request $request)
    {
        $response = $this->phone_change_message($request->phone, $request->message);
        return $response;
    }
    
    public function refills_due_tab(Request $request)
    {
        $reports=new Reports();
        $data['report_title'] = 'Rx with Refills Due Soon';
        $response = $reports->refills_due_with_calculations(30, $request->session(),1);
        $data['count_field'] = count($response['tab_title']);
        $data = array_merge($data,$response);
        $data['survey_data'] = \App\SurveyCategory::with("Survey")->has("Survey")->get(); 

        return view('reports.refills_due_report',$data);
    }

    public function getQuerySetupFilters(Request $request)
    {
        // 'strength', DB::raw('CONCAT(rx_label_name, " (", strength, ") ") AS drug')
        $field = $request->data_field;
        $results = Drug::orderby($request->data_field,'asc')->select('id', $request->data_field.' as value')
                ->where($request->data_field, 'like', '%' .$request->search . '%')
                //->where("sponsored_product", "Y")
                ->when($request->sponsored == 'Y', function ($query) {
                    $query->where("sponsored_product", "Y");
                })
                ->whereNotNull($request->data_field)
                ->limit(10)->get();
        
        $response = array();        
        foreach($results as $result){            
            $response[] = array(
                "id"=>$result->id,
                "text"=>$result->value
           );
        }

        return json_encode($response);
    }
    

    public function querySetupReport(Request $request)
    {
        if($request->ajax()){
            ini_set('memory_limit','512M');
           
            $result = Drug::select(['sponsor_item', 'sponsor_source', 'gcn_seq', 'offer_website', DB::raw('(SELECT  COUNT(*)
            FROM Orders WHERE `drugs_new`.`id` = `Orders`.`DrugDetailId`) AS total_prospects')])
                                ->whereIn("id", explode(",",$request->drug_ids))
                                ->get();
            
            $dataList = [];                    
            foreach($result as $data){            
                $data = array($data->sponsor_item, $data->sponsor_source, $data->gcn_seq, $data->total_prospects, $data->offer_website);                
                array_push($dataList, $data);
            }    
            
            return ['total'=>count($dataList), 'data'=>$dataList]; 
        }

        return view('reports.query_setup');       
    }
}

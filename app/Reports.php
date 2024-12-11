<?php

namespace App;
use DB;
use App\User;
use App\Order;
use Carbon;

use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{
// This is not proper way to write DB queries in Model. Reports Model is not exist.

public function refills_due_with_calculations($days, $request,$rep=0)
{


    DB::enableQueryLog();
    $result = Order::join(DB::Raw('(SELECT Id, RxNumber, MIN(RefillsRemaining) AS RefillRemain,MAX(created_at) AS cre FROM Orders where OrderStatus = 8 GROUP BY RxNumber) AS my_tables'), function($query){
        $query->on('my_tables.RxNumber','Orders.RxNumber')
                ->on('my_tables.cre', 'Orders.created_at');
    })
     ->select(
        [DB::raw('DATE_FORMAT(Orders.nextRefillDate, "%m/%d/%Y") AS nextRefillDate'), 
        'Orders.RefillsRemaining AS RefillsRemaining', 
        //  DB::raw('CONCAT(pct.practice_code, "-", Orders.RxNumber) AS Rx_number'), 
           DB::raw('CONCAT(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19") USING "utf8"), " ", CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8")) AS PatName'),'ppi.Id AS pat_id',
              
           DB::raw('CASE WHEN pct.practice_code IS NULL THEN ( case when Orders.RefillCount < 9 then concat(Orders.Rxnumber,"-0",Orders.RefillCount) else concat(Orders.Rxnumber,"-",Orders.RefillCount) end) ELSE (CONCAT(pct.practice_code, "-", case when Orders.RefillCount < 9 then concat(Orders.Rxnumber,"-0",Orders.RefillCount) else concat(Orders.Rxnumber,"-",Orders.RefillCount) end)) END as RxNumber'),
          
           // DB::raw('CASE WHEN Orders.LastReminderDate IS NULL and Orders.nextRefillFlag = 0 and Orders.OrderStatus = 8 and Orders.OptOutRefillReminder  = 0 THEN "enable" else "disabled" END as Refillable'),
           DB::raw('case when nm.Id IS NOT NULL and nm.MessageTypeId = 28 then "disabled" else "enable" END as RefillMessage') ,
              
             DB::raw('CONCAT( d.rx_label_name, " ", d.Strength, " ", d.dosage_form ) AS rx_label_name'),
             'd.brand_reference',
               'Orders.DaysSupply AS day_supply', 
               DB::raw('Orders.Quantity AS qty'), 
               'Orders.PatientId as PatientId','Orders.Id as oid',
            //    DB::raw('CONCAT("$ ", FORMAT(Orders.RxProfitability, 2)) AS rxprofit'),
               DB::raw('Orders.RxProfitability AS rxprofit1'),
               DB::raw('CONCAT("$ ", FORMAT(`crp`.`CurrentEarnReward`,2)) AS reward_auth'),
               DB::raw('CONCAT("$ ", FORMAT(Orders.RxThirdPartyPay ,2)) as thirdparty'),
               DB::raw('CONCAT("$ ", FORMAT(Orders.RxIngredientPrice, 2)) AS igred_cost'),
               DB::raw('CONCAT("$ ", FORMAT(Orders.RxPatientOutOfPocket ,2)) as patOutPocket'),
               DB::raw('CONCAT("$ ", FORMAT(Orders.RxFinalCollect, 2)) AS selling_price'),
              
            //    DB::raw('Orders.RxProfitability AS rxprofit1'),
               DB::raw('`crp`.`CurrentEarnReward`AS reward_auth1'),
               DB::raw('Orders.RxThirdPartyPay  as thirdparty1'),
               DB::raw('Orders.RxIngredientPrice AS igred_cost1'),
               DB::raw('Orders.RxPatientOutOfPocket  as patOutPocket1'),
               DB::raw('Orders.RxFinalCollect AS selling_price1'),
               
               'd.minor_reporting_class AS major_reporting_cat',
            DB::raw('(CASE WHEN Orders.RefillsRemaining > 0 AND Orders.OrderStatus = 8 THEN "yes"
               ELSE "no" END ) AS Refillable ') 
               
        ])
     
        ->join('drugs_new AS d', 'd.id', '=', 'Orders.DrugDetailId')

        ->join('practices AS pct', 'pct.Id', '=', 'Orders.PracticeId')
        ->join('PatientProfileInfo AS ppi', 'ppi.Id', '=', 'Orders.PatientId')
        ->leftJoin('NotificationMessages as nm', function ($join) {
            $join->on('nm.OrderID','Orders.Id')
                 ->where('nm.MessageTypeId', 28);
        })
        // ->leftJoin('RewardHistory AS reh', 'reh.PatientId', '=', 'Orders.PracticeId')
        // ->leftJoin('RewardPoints AS rp', 'rp.Id', '=', 'reh.RewardPointId')
        ->LeftJoin('ComplianceRewardPoint AS crp','crp.RewardId','=','Orders.Cr_Point_Id')
            
        ->when(!empty($request->get('practice')), function($query) use ($request){

            $query->where('Orders.PracticeId', $request->get('practice')->id);

    })
    ->when($rep!=0, function ($query) use ($days) {
        // dd($days);
           // $end_date = \Carbon\Carbon::now()->addDays(3)->format('Y-m-d');
           $end_date = \Carbon\Carbon::now()->format('Y-m-d');

        $start_date = \Carbon\Carbon::now()->subDays($days)->format('Y-m-d');
        $query->where('Orders.nextRefillDate', '>=', $start_date);
        $query->where('Orders.nextRefillDate', '<=', $end_date);
})
    ->where('Orders.OrderStatus','=',8)
    ->where('Orders.RefillsRemaining','!=',0)
    ->where('Orders.refilldone','!=',1)
    ->orderBy('nextRefillDate', 'DESC')
    ->orderBy('Orders.created_at', 'DESC')
    ->get();
    // $queries = DB::getQueryLog();
// query is updated as per discussion with shahad , javed , riaz and hassan (show filled only)
    // dd(preg_replace('/[^0-9\.]/ui','',$result->pluck('rxprofit')));
    $data['total_row'] = [ 'Total', $result->sum('rxprofit1'), '$ '.number_format($result->sum('reward_auth1'), 2), '$ '.number_format($result->sum('thirdparty1'), 2), '$ '.number_format($result->sum('igred_cost1'), 2),'$ '.number_format( $result->sum('patOutPocket1'),2),'$ '.number_format( $result->sum('selling_price1'),2)];
    // '$'.number_format( ( str_replace(array('$', ','), '', $total_sum_system_fee)));                                                                                          

        $result->filter(function ($value, $key) use ($rep) {
                $value['qty'] = number_format($value['qty'], 1);

                if($rep)
                {
                    $value['RxNumber'] = '<a href="#">'.$value['RxNumber'].'</a>';
                    $value['PatName']='<a href='.url("specific-patient-orders",$value["pat_id"]).'>'.$value['PatName'].'</a>';
                }
                unset($value['pat_id']);
                unset($value['rxprofit']);
                unset($value['reward_auth1']);
                unset($value['thirdparty1']);
                unset($value['igred_cost1']);
                unset($value['selling_price1']);
                unset($value['patOutPocket1']);
               

                return $value;
            });

        $data['result'] = $result->toArray();

        // dump($data['result']);

        $data['tab_title'] = [
             [ 'title'=>'Refill Date', 'style' => 'width:90px;', 'class'=>'bg-gray-80 txt-wht cnt-center text-sline'],
             [ 'title'=>'Refills Remaining', 'class'=>'bg-gray-1 txt-wht text-sline'],
             [ 'title'=>'PATIENT NAME', 'class'=>'bg-gr-bl-dk txt-wht cnt-center'],
             [ 'title'=>'Rx #', 'class'=>'bg-orage txt-wht cnt-center'],
          [ 'title'=>'Rx Label Name', 'class'=>'bg-blue txt-wht'],
          [ 'title'=>' GENERIC FOR', 'class'=>'bg-gray-1 txt-wht'],
            [ 'title'=>'Day Supply', 'class'=>'bg-gr-bl-dk txt-wht cnt-center text-sline'],
             [ 'title'=>'Qty', 'class'=>'bg-grn-lk txt-wht cnt-center'],
             
             
              [ 'title'=>'Rx Profitability', 'style' => 'width:90px;', 'class'=>'bg-gray-80 txt-wht cnt-center text-sline'],
              [ 'title'=>'Reward Auth', 'class'=>'bg-gr-bl-dk txt-wht cnt-center text-sline'],
              [ 'title'=>'Third Party Paid', 'class'=>'bg-orage txt-wht cnt-center text-sline'],
           [ 'title'=>'Rx Ingredient Cost', 'class'=>'bg-blue txt-wht text-sline'],
           [ 'title'=>'Patient Out Of Pocket', 'class'=>'bg-gray-1 txt-wht text-sline'],
           [ 'title'=>'Rx Selling Price', 'class'=>'bg-grn-lk txt-wht cnt-center text-sline'],
           [ 'title'=>'Minor Reporting Class', 'class'=>'bg-gray-1 txt-wht text-sline'] ];

        $data['col_style'] = [
            'bg-gray-e txt-black-24 cnt-center',
            'bg-tb-wht-shade txt-black-24 cnt-center',
            'bg-tb-wht-shade txt-red',
         'bg-tb-orange-lt txt-orange tt_uc_ cnt-right zero_slashes',
         'bg-gray-e txt-black-24 cnt-center',
          'bg-tb-blue-lt txt-blue',
           'bg-gray-e txt-black-24 tt_uc_ cnt-center',
            'bg-tb-grn-lt txt-black-24 cnt-center',
             'bg-tb-wht-shade txt-black-24 cnt-right',
             'bg-gray-e txt-black-24 cnt-right',
            'bg-tb-wht-shade txt-red cnt-right',
         'bg-tb-orange-lt txt-green tt_uc_ cnt-right zero_slashes',
         'bg-gray-e txt-black-24 cnt-right',
          'bg-tb-orange-lt txt-orange cnt-right-force',
          'bg-gray-e txt-black-24 cnt-right-force',
          'bg-gray-e txt-black-24 cnt-right',
            'bg-tb-wht-shade txt-black-24 cnt-right'];

        return $data;

}


    public function refills_due($days, $request,$rep=0)
    {
        /* update after requirement 21 aug 2020  (dont remove for reference)  */

      /*  $result = Order::select([DB::raw('DATE_FORMAT(Orders.nextRefillDate, "%m/%d/%Y") AS nextRefillDate'), 
         //  DB::raw('CONCAT(pct.practice_code, "-", Orders.RxNumber) AS Rx_number'), 
         DB::raw('CONCAT(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19") USING "utf8"), " ", CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8")) AS PatName'),'ppi.Id AS pat_id',
               
            DB::raw('CASE WHEN pct.practice_code IS NULL THEN ( case when Orders.RefillCount < 9 then concat(Orders.Rxnumber,"-0",Orders.RefillCount) else concat(Orders.Rxnumber,"-",Orders.RefillCount) end) ELSE (CONCAT(pct.practice_code, "-", case when Orders.RefillCount < 9 then concat(Orders.Rxnumber,"-0",Orders.RefillCount) else concat(Orders.Rxnumber,"-",Orders.RefillCount) end)) END as RxNumber'),
           
           // DB::raw('CASE WHEN Orders.LastReminderDate IS NULL and Orders.nextRefillFlag = 0 and Orders.OrderStatus = 8 and Orders.OptOutRefillReminder  = 0 THEN "enable" else "disabled" END as Refillable'),
           
            DB::raw('CONCAT( d.rx_label_name, " ", d.Strength, " ", d.dosage_form ) AS rx_label_name'),
            'd.brand_reference',
                'Orders.DaysSupply AS day_supply', 
                DB::raw('Orders.Quantity AS qty'), 
                'd.major_reporting_cat AS major_reporting_cat' ])

                ->join('drugs_new AS d', 'd.id', '=', 'Orders.DrugDetailId')

                ->join('practices AS pct', 'pct.Id', '=', 'Orders.PracticeId')
                ->join('PatientProfileInfo AS ppi', 'ppi.Id', '=', 'Orders.PatientId')
                ->when(($days!='all_activity' && $rep==0) , function ($query) use ($days) {

                    $end_date = Carbon\Carbon::now()->format('Y-m-d');

                    $start_date = Carbon\Carbon::now()->addDays($days+1)->format('Y-m-d');
                    $query->where('Orders.nextRefillDate', '<=', $start_date);
                    $query->where('Orders.nextRefillDate', '>=', $end_date);


            })->when($rep!=0, function ($query) use ($days) {

                $end_date = Carbon\Carbon::now()->addDays(3)->format('Y-m-d');

                $start_date = Carbon\Carbon::now()->subDays($days)->format('Y-m-d');
                $query->where('Orders.nextRefillDate', '>=', $start_date);
                $query->where('Orders.nextRefillDate', '<=', $end_date);


        })
            ->when(!empty($request->get('practice')), function($query) use ($request){

                    $query->where('Orders.PracticeId', $request->get('practice')->id);

            })->when(!empty($request->get('patient_id')), function($query) use ($request){

                $query->where('Orders.PatientId', $request->get('patient_id'));

            })
            // ->where('Orders.nextRefillDate','>=',Carbon\Carbon::now()->format('Y-m-d'))
            ->where('Orders.OrderType','=','Refill')
            ->orderBy('nextRefillDate', 'DESC')->groupBy('Orders.Id')->get();
            */

            $result = Order::join(DB::Raw('(SELECT Id, RxNumber, MIN(RefillsRemaining) AS RefillRemain,MAX(created_at) AS cre FROM Orders where OrderStatus = 8 GROUP BY RxNumber) AS my_tables'), function($query){
                $query->on('my_tables.RxNumber','Orders.RxNumber')
                        ->on('my_tables.cre', 'Orders.created_at');
            })
            ->select([DB::raw('DATE_FORMAT(Orders.nextRefillDate, "%m/%d/%Y") AS nextRefillDate'), 
            //  DB::raw('CONCAT(pct.practice_code, "-", Orders.RxNumber) AS Rx_number'), 
            DB::raw('CONCAT(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19") USING "utf8"), " ", CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8")) AS PatName'),'ppi.Id AS pat_id',
                  
               DB::raw('CASE WHEN pct.practice_code IS NULL THEN ( case when Orders.RefillCount < 9 then concat(Orders.Rxnumber,"-0",Orders.RefillCount) else concat(Orders.Rxnumber,"-",Orders.RefillCount) end) ELSE (CONCAT(pct.practice_code, "-", case when Orders.RefillCount < 9 then concat(Orders.Rxnumber,"-0",Orders.RefillCount) else concat(Orders.Rxnumber,"-",Orders.RefillCount) end)) END as RxNumber'),
              
              // DB::raw('CASE WHEN Orders.LastReminderDate IS NULL and Orders.nextRefillFlag = 0 and Orders.OrderStatus = 8 and Orders.OptOutRefillReminder  = 0 THEN "enable" else "disabled" END as Refillable'),
              
               DB::raw('CONCAT( d.rx_label_name, " ", d.Strength, " ", d.dosage_form ) AS rx_label_name'),
               'd.brand_reference',
                   'Orders.DaysSupply AS day_supply', 
                   DB::raw('Orders.Quantity AS qty'), 
                   'd.major_reporting_cat AS major_reporting_cat' ])
   
                   ->join('drugs_new AS d', 'd.id', '=', 'Orders.DrugDetailId')
   
                   ->join('practices AS pct', 'pct.Id', '=', 'Orders.PracticeId')
                   ->join('PatientProfileInfo AS ppi', 'ppi.Id', '=', 'Orders.PatientId')
                   ->when(($days!='all_activity' && $rep==0) , function ($query) use ($days) {
   
                       $end_date = Carbon\Carbon::now()->format('Y-m-d');
   
                       $start_date = Carbon\Carbon::now()->addDays($days+1)->format('Y-m-d');
                       $query->where('Orders.nextRefillDate', '<=', $start_date);
                       $query->where('Orders.nextRefillDate', '>=', $end_date);
   
   
               })->when($rep!=0, function ($query) use ($days) {
   
                   $end_date = Carbon\Carbon::now()->addDays(3)->format('Y-m-d');
   
                   $start_date = Carbon\Carbon::now()->subDays($days)->format('Y-m-d');
                   $query->where('Orders.nextRefillDate', '>=', $start_date);
                   $query->where('Orders.nextRefillDate', '<=', $end_date);
   
   
           })
               ->when(!empty($request->get('practice')), function($query) use ($request){
   
                       $query->where('Orders.PracticeId', $request->get('practice')->id);
   
               })->when(!empty($request->get('patient_id')), function($query) use ($request){
   
                   $query->where('Orders.PatientId', $request->get('patient_id'));
   
               })
               // ->where('Orders.nextRefillDate','>=',Carbon\Carbon::now()->format('Y-m-d'))
               ->where('Orders.OrderStatus','=',8)
    ->where('Orders.RefillsRemaining','!=',0)
    ->orderBy('nextRefillDate', 'DESC')
    ->orderBy('Orders.created_at', 'DESC')
    ->get();

            $result->filter(function ($value, $key) use ($rep) {
                    $value['qty'] = number_format($value['qty'], 1);
                    if($rep)
                    {
                        $value['RxNumber'] = '<a href="#">'.$value['RxNumber'].'</a>';
                        $value['PatName']='<a href='.url("specific-patient-orders",$value["pat_id"]).'>'.$value['PatName'].'</a>';
                    }
                    unset($value['pat_id']);
                    return $value;
                });

            $data['result'] = $result->toArray();

            

            $data['tab_title'] = [
                 [ 'title'=>'Refill Date', 'style' => 'width:90px;', 'class'=>'bg-gray-80 txt-wht cnt-center'],
                 [ 'title'=>'PATIENT NAME', 'class'=>'bg-gr-bl-dk txt-wht cnt-center'],
                 [ 'title'=>'Rx #', 'class'=>'bg-orage txt-wht cnt-center'],
              [ 'title'=>'Rx Label Name', 'class'=>'bg-blue txt-wht'],
              [ 'title'=>' GENERIC FOR', 'class'=>'bg-gray-1 txt-wht'],
                [ 'title'=>'Day Supply', 'class'=>'bg-gr-bl-dk txt-wht cnt-center'],
                 [ 'title'=>'Qty', 'class'=>'bg-grn-lk txt-wht cnt-center'],
                  [ 'title'=>'Major Category', 'class'=>'bg-gray-1 txt-wht'] ];

            $data['col_style'] = [
                'bg-gray-e txt-black-24 cnt-center',
                'bg-tb-wht-shade txt-red',
             'bg-tb-orange-lt txt-orange tt_uc_ cnt-right zero_slashes',
             'bg-gray-e txt-black-24 cnt-center',
              'bg-tb-blue-lt txt-blue',
               'bg-gray-e txt-black-24 tt_uc_ cnt-center',
                'bg-tb-grn-lt txt-black-24 cnt-right',
                 'bg-tb-wht-shade txt-black-24'];

            return $data;

    }



    public function top_products_sale($days, $request)
    {

        $result = Order::select([DB::raw('CONCAT( d.rx_label_name, " ", d.Strength, " ", d.dosage_form ) AS rx_label_name'),
                                 'd.ndc AS ndc', 'd.gcn_seq AS gen_seq', DB::raw('SUM(Orders.Quantity) AS quantity'), 'd.major_reporting_cat AS major_reporting_cat' ])
                            ->join('drugs_new AS d', 'd.id', '=', 'Orders.DrugDetailId')
                            ->when($days!='all_activity', function ($query) use ($days) {

                                $end_date = Carbon\Carbon::now()->format('Y-m-d');

                                $start_date = Carbon\Carbon::now()->subDay($days)->format('Y-m-d');
                                $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '>=', $start_date);
                                $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '<=', $end_date);
                                //, array($start_date, $end_date)
                            })->when(!empty($request->get('practice')), function($query) use ($request){

                                $query->whereIn('Orders.PracticeId', $request->get('practice'));
                            })->orderBy('quantity', 'desc')->groupBy('d.id')->get();

       // dd($result->all());
            $result->filter(function ($value, $key) {
                   $value['quantity'] = number_format($value['quantity'], 1);
                    return $value;
                });


            $data['result'] = $result->toArray();
           // dd($data);
            $data['tab_title'] = [ [ 'title'=>'Rx Label Name', 'class'=>'bg-blue txt-wht'], [ 'title'=>'NDC', 'style' => 'width:95px;', 'class'=>'bg-gray-80 txt-wht'],
                                [ 'title'=>'GCN SEQ', 'class'=>'bg-gr-bl-dk txt-wht cnt-center-force'], [ 'title'=>'Quantity', 'class'=>'bg-grn-lk txt-wht cnt-center-force'], [ 'title'=>'Major Reporting', 'class'=>'bg-gray-1 txt-wht'] ];

            $data['col_style'] = ['bg-tb-blue-lt txt-blue', 'bg-gray-e txt-black-24', 'bg-gray-e txt-black-24 tt_uc_ cnt-center', 'bg-tb-grn-lt txt-black-24 cnt-center', 'bg-tb-wht-shade txt-black-24'];

            return $data;

    }


    public function top_product_profitablity($days, $request)
    {

        $result = Order::select([DB::raw('CONCAT( d.rx_label_name, " ", d.Strength, " ", d.dosage_form ) AS rx_label_name'),
                                 'd.ndc AS ndc', 'd.marketer AS marketer', DB::raw('SUM(Orders.Quantity) AS quantity'),
                                DB::raw('CONCAT("$ ", FORMAT(SUM(Orders.RxProfitability), 2)) AS rxprofit') ])
                            ->join('drugs_new AS d', 'd.id', '=', 'Orders.DrugDetailId')
                            ->when($days!='all_activity', function ($query) use ($days) {

                                 $end_date = Carbon\Carbon::now()->format('Y-m-d');

                                $start_date = Carbon\Carbon::now()->subDay($days)->format('Y-m-d');
                               $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '>=', $start_date);
                                $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '<=', $end_date);
                            })->when(!empty($request->get('practice')), function($query) use ($request){

                                $query->whereIn('Orders.PracticeId', $request->get('practice'));
                            })->take(10)->orderBy(DB::raw('SUM(Orders.RxProfitability)'), 'desc')->groupBy('d.id')->get();

       // dd($result->all());
             $result->filter(function ($value, $key) {
                    $value['quantity'] = number_format($value['quantity'], 1);
                    return $value;
                });

            $data['result'] = $result->toArray();
           // dd($data);
            $data['tab_title'] = [ [ 'title'=>'Rx Label Name', 'class'=>'bg-blue txt-wht'], [ 'title'=>'NDC', 'style' => 'width:95px;', 'class'=>'bg-gray-80 txt-wht'], [ 'title'=>'Marketer', 'class'=>'bg-gray-1 txt-wht'],
                [ 'title'=>'Quantity', 'class'=>'bg-grn-lk txt-wht cnt-center-force'], [ 'title'=>'Rx Profitability', 'class'=>'bg-red-dk txt-wht cnt-right-force'] ];

            $data['col_style'] = ['bg-tb-blue-lt txt-blue', 'bg-gray-e txt-black-24', 'bg-tb-wht-shade txt-black-24', 'bg-tb-grn-lt txt-black-24 cnt-right', 'bg-tb-pink txt-red-dk cnt-right'];

            return $data;

    }

    public function all_cwp_users($days, $request)
    {

        $userList = [];
        $users = User::with(["practices","roles"])
                ->when($days!='all_activity', function ($query) use ($days) {
                    $end_date = Carbon\Carbon::now()->format('Y-m-d');
                    $start_date = Carbon\Carbon::now()->subDay($days)->format('Y-m-d');
                    $query->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"), '>=', $start_date);
                    $query->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"), '<=', $end_date);
                })->when(!empty($request->get('practice')), function($query) use ($request){
                    $query->where('practice_id', $request->get('practice')->id);
                })->get()->toArray();
// dd($users);
        foreach($users as $user){
            $userList[] = ['name'=>$user['name'], 'email'=>$user['email'], 'role'=>(isset($user['roles'][0]['name'])?$user['roles'][0]['name']:""), 'practice'=>(isset($user['practices'][0]['practice_name'])?$user['practices'][0]['practice_name']:""), 'type'=>(isset($user['practices'][0]['practice_type'])?$user['practices'][0]['practice_type']:"") ];
        }
        $data['result'] = $userList;
        $data['tab_title'] = [ [ 'title'=>'User Name', 'class'=>'bg-gray-1 txt-wht'], ['title'=>'User Email', 'class'=>'bg-blue txt-wht'], ['title'=>'User Role', 'class'=>'bg-gr-bl-dk txt-wht'],
                [ 'title'=>'Practice Name', 'class'=>'bg-orage txt-wht'], [ 'title'=>'Practice Type', 'class'=>'bg-gray-80 txt-wht']];
        $data['col_style'] = ['bg-gray-ed txt-black-24 ', 'bg-tb-blue-lt txt-blue', 'bg-gray-ed txt-black-24', 'bg-tb-orange-lt txt-black-24', 'bg-gray-e txt-black-24'];

        return $data;
    }

    public function all_cwp_referrals($days, $request)
    {
        $subSql = "";
        if($days != "all_activity"){
            $end_date = Carbon\Carbon::now()->format('Y-m-d');
            $start_date = Carbon\Carbon::now()->subDay($days)->format('Y-m-d');
            $subSql = ' AND DATE(created_at) > "'.$start_date.'" AND DATE(created_at) <= "'.$end_date.'" ';
        }

        $userList = [];
        $orders = DB::select( DB::raw("SELECT PrescriberName, concat('(',substr(PrescriberPhone,1,3),') ',substr(PrescriberPhone,4,3),'-',substr(PrescriberPhone,7)) AS PrescriberPhone, COUNT(1) as Referrals,
            (SELECT practice_name from practices where id=Orders.PracticeId) as Practice
            FROM Orders WHERE PrescriberName IS NOT NULL $subSql GROUP BY PrescriberName ORDER BY Referrals DESC") );

        $orders = json_decode(json_encode($orders),1);

        $data['result'] = $orders;
        $data['tab_title'] = [ [ 'title'=>'Prescriber Name', 'class'=>'bg-gray-1 txt-wht'], ['title'=>'Phone', 'class'=>'bg-blue txt-wht'], ['title'=>'Referrals', 'class'=>'bg-gr-bl-dk txt-wht'],
                [ 'title'=>'Practice', 'class'=>'bg-orage txt-wht']];
        $data['col_style'] = ['bg-gray-ed txt-black-24 ', 'bg-tb-blue-lt txt-blue', 'bg-gray-ed txt-black-24 cnt-center', 'bg-tb-orange-lt txt-black-24'];

        return $data;
    }

    public function all_cwp_activity($days, $request)
    {
        $result = DB::table('ActivitiesHistory AS ah')->select(
                DB::raw('DATE_FORMAT(o.created_at, "%m/%d/%y %h:%i %p") AS service_date'),
                DB::raw('CONCAT(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19") USING "utf8"), " ", CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8")) AS PatName'),
                'ah.Activity_Name AS service', 'pr.practice_name AS practice_name', 
                DB::raw('(CASE WHEN pr.practice_code IS NULL THEN ah.Rx_Number ELSE CONCAT(pr.practice_code,"-",ah.Rx_Number) END) AS rx_number'),
                DB::raw('CASE WHEN o.OrderType IS NULL THEN "N" WHEN o.OrderType="Refill" THEN "R" ELSE "Transfer" END AS new_or_refill'),
                'd.rx_label_name AS rx_label_name','d.brand_reference', 'd.Strength AS strength', 'd.dosage_form AS dosage_form', DB::raw('FORMAT(o.Quantity ,1)'), 'o.RefillsRemaining')
               // ->join('Orders AS o', 'o.Id', '=', 'ah.order_id')
                ->LeftJoin('Orders AS o', 'o.RxNumber', '=', 'ah.Rx_Number')
                ->LeftJoin('drugs_new AS d', 'd.id', '=', 'o.DrugDetailId')
                ->LeftJoin('practices AS pr', 'pr.id', '=', 'o.PracticeId')
                ->LeftJoin('PatientProfileInfo AS ppi', 'ppi.Id', '=', 'o.PatientId')

                ->when($days!='all_activity', function ($query) use ($days) {
                    $end_date = Carbon\Carbon::now()->format('Y-m-d');
                    $start_date = Carbon\Carbon::now()->subDay($days)->format('Y-m-d');
                    $query->where(DB::raw("DATE_FORMAT(o.created_at, '%Y-%m-%d')"), '>=', $start_date);
                    $query->where(DB::raw("DATE_FORMAT(o.created_at, '%Y-%m-%d')"), '<=', $end_date);


               })->when(!empty($request->get('practice')), function($query) use ($request){
                   $query->whereIn('o.PracticeId', $request->get('practice'));
               })
               ->orderBy(DB::raw('ah.Id'), 'ASC')
               ->groupBy('o.Id')->get();
           $data['result'] =  json_decode(json_encode($result), true);

            $data['tab_title'] = [ [ 'title'=>'Service Date', 'class'=>'bg-gray-1 txt-wht'], [ 'title'=>'Patient', 'class'=>'bg-gr-bl-dk txt-wht'],
                [ 'title'=>'Service', 'class'=>'bg-orage txt-wht'], [ 'title'=>'Client', 'class'=>'bg-gray-80 txt-wht'], [ 'title'=>'Rx #', 'class'=>'bg-grn-lk txt-wht cnt-center'],
                 [ 'title'=>'New/Refill', 'class'=>'bg-gray-1 txt-wht'], [ 'title'=>'Rx Label Name', 'class'=>'bg-red-dk txt-wht'], [ 'title'=>'Generic For', 'class'=>'bg-gr-bl-dk txt-wht'], [ 'title'=>'Strength', 'class'=>'bg-grn-lk txt-wht'],
                 [ 'title'=>'Dosage Form', 'class'=>'bg-gray-1 txt-wht'], [ 'title'=>'Qty', 'class'=>'bg-blue txt-wht'], [ 'title'=>'Refill Remains', 'class'=>'bg-gray-1 txt-wht']
                ];

             $data['col_style'] = ['bg-gray-ed txt-black-24 ', 'bg-tb-blue-lt txt-blue', 'bg-gray-ed txt-black-24', 'bg-tb-orange-lt txt-black-24', 'bg-gray-e txt-black-24 tt_uc_ cnt-right zero_slashes', 'bg-tb-grn-lt txt-black-24',
                 'bg-gray-e txt-black-24', 'generic-for-report bg-tb-pink-lt', 'bg-gray-e txt-black-24 zero_slashes', 'bg-tb-wht-shade2 txt-black-24 zero_slashes', 'bg-tb-blue-lt txt-black-24 cnt-right', 'bg-tb-wht-shade2 txt-black-24 cnt-right'];

            return $data;
    }


    public function all_cwp_activity_page($dates, $request)
    {
        $result = DB::table('ActivitiesHistory AS ah')->select(
                DB::raw('DATE_FORMAT(o.created_at, "%m/%d/%y %h:%i %p") AS service_date'),
                DB::raw('CONCAT(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19") USING "utf8"), " ", CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8")) AS PatName'),
                'ah.Activity_Name AS service', 'pr.practice_name AS practice_name', 
                // DB::raw('CONCAT_WS( "-",pr.practice_code, case when o.RefillCount < 9 then concat(o.Rxnumber,"-0",o.RefillCount) else concat(o.Rxnumber,"-",o.RefillCount) end) as RxNumber'),
                DB::raw('CASE WHEN pr.practice_code IS NULL THEN ( case when o.RefillCount < 9 then concat(o.Rxnumber,"-0",o.RefillCount) else concat(o.Rxnumber,"-",o.RefillCount) end) ELSE (CONCAT(pr.practice_code, "-", case when o.RefillCount < 9 then concat(o.Rxnumber,"-0",o.RefillCount) else concat(o.Rxnumber,"-",o.RefillCount) end)) END as RxNumber'),
                //DB::raw('CONCAT(pr.practice_code,"-",ah.Rx_Number) AS rx_number'),
                //DB::raw('CASE WHEN o.OrderType IS NULL THEN "N" WHEN o.OrderType="Refill" THEN "R" ELSE "Transfer" END AS new_or_refill'),
                DB::raw('CONCAT("$",FORMAT(o.asistantAuth,2)) AS asistantAuth'),'d.rx_label_name AS rx_label_name','d.brand_reference', 'd.Strength AS strength', 'd.dosage_form AS dosage_form', DB::raw('FORMAT(o.Quantity ,1)'), 'o.RefillsRemaining')
               // ->join('Orders AS o', 'o.Id', '=', 'ah.order_id')
                ->LeftJoin('Orders AS o', 'o.RxNumber', '=', 'ah.Rx_Number')
                ->LeftJoin('drugs_new AS d', 'd.id', '=', 'o.DrugDetailId')
                ->LeftJoin('practices AS pr', 'pr.id', '=', 'o.PracticeId')
                ->LeftJoin('PatientProfileInfo AS ppi', 'ppi.Id', '=', 'o.PatientId')

                ->when(!empty($request->get('practice')), function($query) use ($request){
                   $query->where('o.PracticeId', $request->get('practice')->id);
               })
                ->where(DB::raw("DATE_FORMAT(o.created_at, '%Y-%m-%d')"), '>=', $dates['start_date'])
                ->where(DB::raw("DATE_FORMAT(o.created_at, '%Y-%m-%d')"), '<=', $dates['end_date'])
               ->orderBy(DB::raw('ah.Id'), 'ASC')
               ->groupBy('o.Id')->get();
           $data['result'] =  json_decode(json_encode($result), true);

            $data['tab_title'] = [ [ 'title'=>'Service Date', 'class'=>'bg-gray-1 txt-wht'], [ 'title'=>'Patient', 'class'=>'bg-gr-bl-dk txt-wht'],
                [ 'title'=>'Service', 'class'=>'bg-orage txt-wht'], [ 'title'=>'Client', 'class'=>'bg-gray-80 txt-wht'], [ 'title'=>'Rx #', 'class'=>'bg-grn-lk txt-wht cnt-center'],[ 'title'=>'Assistant Req', 'class'=>'bg-gr-bl-dk txt-wht'],
                  [ 'title'=>'Rx Label Name', 'class'=>'bg-red-dk txt-wht'], [ 'title'=>'Generic For', 'class'=>'bg-gr-bl-dk txt-wht'], [ 'title'=>'Strength', 'class'=>'bg-grn-lk txt-wht'],
                 [ 'title'=>'Dosage Form', 'class'=>'bg-gray-1 txt-wht'], [ 'title'=>'Qty', 'class'=>'bg-blue txt-wht'], [ 'title'=>'Refill Remains', 'class'=>'bg-gray-1 txt-wht']
                ];
//[ 'title'=>'New/Refill', 'class'=>'bg-gray-1 txt-wht'],
             $data['col_style'] = ['bg-gray-ed txt-black-24 ', 'bg-tb-blue-lt txt-blue', 'bg-gray-ed txt-black-24', 'bg-tb-orange-lt txt-black-24', 'bg-gray-e txt-black-24 tt_uc_ cnt-right zero_slashes','bg-tb-pink txt-black-24 cnt-right',
                 'bg-gray-e txt-black-24', 'generic-for-report bg-tb-pink-lt', 'bg-gray-e txt-black-24 zero_slashes', 'bg-tb-wht-shade2 txt-black-24 zero_slashes', 'bg-tb-blue-lt txt-black-24 cnt-right', 'bg-tb-wht-shade2 txt-black-24 cnt-right'];

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
                    $end_date = Carbon\Carbon::now()->format('Y-m-d');
                    $start_date = Carbon\Carbon::now()->subDay($days)->format('Y-m-d');
                    $query->where(DB::raw("DATE_FORMAT(o.created_at, '%Y-%m-%d')"), '>=', $start_date);
                    $query->where(DB::raw("DATE_FORMAT(o.created_at, '%Y-%m-%d')"), '<=', $end_date);


               })->when(!empty($request->get('practice')), function($query) use ($request){
                   $query->whereIn('o.PracticeId', $request->get('practice'));
               })
               ->orderBy(DB::raw('o.Id'), 'ASC')
               ->groupBy('o.Id')->get();
           $data['result'] =  json_decode(json_encode($result), true);
            $data['tab_title'] = [ [ 'title'=>'Patient CoPay', 'class'=>'bg-gray-1 txt-wht cnt-right-force'],
            [ 'title'=>'Insurance Paid', 'class'=>'bg-blue txt-wht'], [ 'title'=>'Patient Name', 'class'=>'bg-gr-bl-dk txt-wht'],
                 [ 'title'=>'Rx #', 'class'=>'bg-grn-lk txt-wht cnt-center'],[ 'title'=>'Refill Remains', 'class'=>'bg-gray-1 txt-wht'],[ 'title'=>'Rx Label Name', 'class'=>'bg-red-dk txt-wht'],
                 [ 'title'=>'Strength', 'class'=>'bg-grn-lk txt-wht'],[ 'title'=>'Dosage Form', 'class'=>'bg-gray-1 txt-wht'],
                  [ 'title'=>'Qty', 'class'=>'bg-blue txt-wht'],[ 'title'=>'Refillable Next', 'class'=>'bg-gr-bl-dk txt-wht'], [ 'title'=>'Rx Expires', 'class'=>'bg-grn-lk txt-wht'],
                 [ 'title'=>'Marketer', 'class'=>'bg-gr-bl-dk txt-wht'],[ 'title'=>'GCN_SEQ', 'class'=>'bg-gray-1 txt-wht'],  [ 'title'=>'MAJOR REPT CAT', 'class'=>'bg-gr-bl-dk txt-wht'],
                 [ 'title'=>'MINOR REPORTING CATEGORY', 'class'=>'bg-red-dk txt-wht']

                ];

             $data['col_style'] = ['bg-gray-ed txt-black-24 cnt-right', 'bg-tb-blue-lt txt-blue cnt-right', 'bg-gray-ed txt-black-24', 'bg-tb-orange-lt txt-black-24 tt_uc_ cnt-right zero_slashes', 'bg-gray-e txt-black-24', 'bg-tb-grn-lt txt-black-24 zero_slashes',
                 'bg-gray-e txt-black-24 zero_slashes', 'bg-tb-pink txt-black-24', 'bg-gray-e txt-black-24', 'bg-tb-wht-shade2 txt-black-24', 'bg-tb-blue-lt txt-black-24', 'bg-tb-wht-shade2 txt-black-24','bg-tb-blue-lt txt-blue','bg-tb-blue-lt txt-blue','bg-tb-blue-lt txt-blue'];

            return $data;
    }


    public function zero_refill_remaining($days, $request)
    {
        $result = DB::table('Orders AS o')->select('o.RefillsRemaining',DB::raw('DATE_FORMAT(o.nextRefillDate,"%m/%d/%Y")'),
        DB::raw('CONCAT(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19") USING "utf8"), " ", CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8")) AS PatName'),
                 // DB::raw('CONCAT(pr.practice_code,"-",o.RxNumber) AS rx_number'),
                 DB::raw('(CASE WHEN pr.practice_code IS NULL THEN o.RxNumber ELSE CONCAT(pr.practice_code,"-",o.RxNumber) END) AS rx_number'),
                  DB::raw('DATE_FORMAT(o.RxExpiryDate,"%m/%d/%Y")'),
                'd.rx_label_name AS rx_label_name','d.Strength AS strength', 'd.dosage_form AS dosage_form',DB::raw('FORMAT(o.Quantity,1) AS Quantity'),
                 DB::raw('CONCAT("$ ", FORMAT(o.RxPatientOutOfPocket ,2)) as patOutPocket'),
                DB::raw('CONCAT("$ ", FORMAT(o.RxThirdPartyPay ,2)) as thirdparty'))
               // ->join('Orders AS o', 'o.Id', '=', 'ah.order_id')
                // ->LeftJoin('Orders AS o', 'o.RxNumber', '=', 'ah.Rx_Number')
                ->LeftJoin('drugs_new AS d', 'd.id', '=', 'o.DrugDetailId')
                ->LeftJoin('practices AS pr', 'pr.id', '=', 'o.PracticeId')
                ->LeftJoin('PatientProfileInfo AS ppi', 'ppi.Id', '=', 'o.PatientId')

                ->when($days!='all_activity', function ($query) use ($days) {
                    $end_date = Carbon\Carbon::now()->format('Y-m-d');
                    $start_date = Carbon\Carbon::now()->subDay($days)->format('Y-m-d');
                    $query->where(DB::raw("DATE_FORMAT(o.created_at, '%Y-%m-%d')"), '>=', $start_date);
                    $query->where(DB::raw("DATE_FORMAT(o.created_at, '%Y-%m-%d')"), '<=', $end_date);


               })->when(!empty($request->get('practice')), function($query) use ($request){
                   $query->whereIn('o.PracticeId', $request->get('practice'));
               })
               ->where('o.RefillsRemaining',0)
               ->orderBy(DB::raw('o.Id'), 'ASC')
               ->groupBy('o.Id')->get();
           $data['result'] =  json_decode(json_encode($result), true);

            $data['tab_title'] = [ [ 'title'=>'Refill Remains', 'class'=>'bg-gray-1 txt-wht'],
            [ 'title'=>'Refillable Next', 'class'=>'bg-gr-bl-dk txt-wht'],
             [ 'title'=>'Patient Name', 'class'=>'bg-gr-bl-dk txt-wht'],
                 [ 'title'=>'Rx #', 'class'=>'bg-grn-lk txt-wht cnt-center'],
                 [ 'title'=>'Rx Expires', 'class'=>'bg-grn-lk txt-wht'],
                 [ 'title'=>'Rx Label Name', 'class'=>'bg-red-dk txt-wht'],
                 [ 'title'=>'Strength', 'class'=>'bg-grn-lk txt-wht'],
                 [ 'title'=>'Dosage Form', 'class'=>'bg-gray-1 txt-wht'],
                  [ 'title'=>'Qty', 'class'=>'bg-blue txt-wht'],
                  [ 'title'=>'Patient CoPay', 'class'=>'bg-gray-1 txt-wht cnt-right-force'],
                  [ 'title'=>'Insurance Paid', 'class'=>'bg-blue txt-wht'],
                ];

             $data['col_style'] = ['bg-gray-ed txt-black-24 ', 'bg-tb-blue-lt txt-blue', 'bg-gray-ed txt-black-24', 'bg-tb-orange-lt txt-black-24 tt_uc_ cnt-right zero_slashes', 'bg-gray-e txt-black-24', 'bg-tb-grn-lt txt-black-24',
                 'bg-gray-e txt-black-24 zero_slashes', 'bg-tb-pink txt-black-24 zero_slashes', 'bg-gray-e txt-black-24', 'bg-tb-wht-shade2 txt-black-24 cnt-right', 'bg-tb-blue-lt txt-black-24 cnt-right', 'bg-tb-wht-shade2 txt-black-24'];

            return $data;
    }

    public function rx_near_expiration($days, $request)
    {
        $result = Order::select([DB::raw('DATE_FORMAT(Orders.RxExpiryDate, "%m/%d/%Y") AS rxExpireDate'),DB::raw('DATE_FORMAT(Orders.nextRefillDate, "%m/%d/%Y") AS nextRefillDate'),
        DB::raw('CONCAT(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19") USING "utf8"), " ", CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8")) AS PatName'),
        // DB::raw('CONCAT(pct.practice_code,"-",Orders.RxNumber) AS rx_number'),
        DB::raw('(CASE WHEN pct.practice_code IS NULL THEN Orders.RxNumber ELSE CONCAT(pct.practice_code,"-",Orders.RxNumber) END) AS rx_number'),
        'Orders.RefillsRemaining','d.rx_label_name', 'd.Strength','d.dosage_form',DB::raw('Orders.Quantity AS qty'),
         DB::raw('CONCAT("$ ", FORMAT(Orders.RxPatientOutOfPocket ,2)) as patOutPocket'),
         DB::raw('CONCAT("$ ", FORMAT(Orders.RxThirdPartyPay ,2)) as thirdparty'),
         'd.marketer','d.gcn_seq',
         'd.major_reporting_cat','d.minor_reporting_class' ])

                ->join('drugs_new AS d', 'd.id', '=', 'Orders.DrugDetailId')

                ->join('practices AS pct', 'pct.Id', '=', 'Orders.PracticeId')

                ->LeftJoin('PatientProfileInfo AS ppi', 'ppi.Id', '=', 'Orders.PatientId')

                ->when($days!='all_activity', function ($query) use ($days) {

                    $start_date = Carbon\Carbon::now()->format('Y-m-d');

                    $end_date = Carbon\Carbon::now()->addDays($days+1)->format('Y-m-d');
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


            $data['tab_title'] = [  [  'title'=>'Rx Expires', 'class'=>'bg-grn-lk txt-wht'],[ 'title'=>'Refillable Next', 'class'=>'bg-gr-bl-dk txt-wht'],
             ['title'=>'Patient Name', 'class'=>'bg-gr-bl-dk txt-wht'],
                 [ 'title'=>'Rx #', 'class'=>'bg-grn-lk txt-wht cnt-center'],[ 'title'=>'Refill Remains', 'class'=>'bg-gray-1 txt-wht'],
                 [ 'title'=>'Rx Label Name', 'class'=>'bg-red-dk txt-wht'],
                 [ 'title'=>'Strength', 'class'=>'bg-grn-lk txt-wht'],
                 [ 'title'=>'Dosage Form', 'class'=>'bg-gray-1 txt-wht'],
                     [ 'title'=>'Qty', 'class'=>'bg-blue txt-wht'],
                 [ 'title'=>'Patient CoPay', 'class'=>'bg-gray-1 txt-wht cnt-right-force'],
                  [ 'title'=>'Insurance Paid', 'class'=>'bg-blue txt-wht'],
                 [ 'title'=>'Marketer', 'class'=>'bg-gr-bl-dk txt-wht'],[ 'title'=>'GCN_SEQ', 'class'=>'bg-gray-1 txt-wht'],  [ 'title'=>'MAJOR REPT CATG', 'class'=>'bg-gr-bl-dk txt-wht'],
                 [ 'title'=>'MINOR REPT CATG', 'class'=>'bg-red-dk txt-wht']

                ];

             $data['col_style'] = ['bg-gray-ed txt-black-24','bg-gray-ed txt-black-24 ', 'bg-tb-blue-lt txt-blue', 'bg-gray-ed txt-black-24 tt_uc_ cnt-right zero_slashes', 'bg-tb-orange-lt txt-black-24', 'bg-gray-e txt-black-24 zero_slashes', 'bg-tb-grn-lt txt-black-24 zero_slashes',
                 'bg-gray-e txt-black-24 ', 'bg-tb-pink txt-black-24 cnt-right', 'bg-gray-e txt-black-24 cnt-right', 'bg-tb-wht-shade2 txt-black-24 cnt-right', 'bg-tb-blue-lt txt-black-24', 'bg-tb-wht-shade2 txt-black-24'];

            return $data;

    }




    public function web_stat_report($days, $report_type)
    {
        if($report_type=='completed_enrollments')
        {
            return $this->completed_enrollments($days);
        }
        if($report_type=='referrals_generated')
        {
            return $this->referrals_generated($days);
        }
        if($report_type=='payments_made')
        {
            return $this->payments_made($days);
        }
        if($report_type=='member_questions')
        {
            return $this->member_questions($days);
        }
        if($report_type=='refill_reminders')
        {
            return $this->refill_reminders($days);
        }
        if($report_type=='refill_requests')
        {
            return $this->refill_requests($days);
        }
    }


    public function completed_enrollments($days)
    {

        $result = Order::select([DB::raw('COUNT(`Orders`.`PatientId`) AS total_pat'), 'pr.practice_name AS practice_name',
            DB::raw('CONCAT("$ ", FORMAT(SUM(Orders.RxFinalCollect), 2)) AS selling_price'), DB::raw('CONCAT("$ ", FORMAT(SUM(Orders.RxIngredientPrice), 2)) AS igred_cost'),
            DB::raw('SUM(Orders.RxFinalCollect) AS for_sum_selling_price'), DB::raw('SUM(Orders.RxIngredientPrice) AS for_sum_igred_cost'),
            DB::raw('FORMAT(SUM(`rp`.`Points`), 2) AS reward_auth'), DB::raw('SUM(Orders.RefillsRemaining) AS refillRemain')])
                ->join('practices AS pr', 'pr.id', '=', 'Orders.PracticeId')
                ->leftJoin('RewardHistory AS reh', 'reh.PatientId', '=', 'Orders.PracticeId')
                ->leftJoin('RewardPoints AS rp', 'rp.Id', '=', 'reh.RewardPointId')
                ->when($days!='all_activity', function ($query) use ($days) {

                                $end_date = Carbon\Carbon::now()->format('Y-m-d');

                                $start_date = Carbon\Carbon::now()->subDay($days)->format('Y-m-d');
                                $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '>=', $start_date);
                                $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '<=', $end_date);

                              })->orderBy('total_pat', 'desc')->groupBy('pr.practice_name')->get();

        if($days ==1){
            $durationD = 'Now';
        }else{
            $durationD = 'Past '.$days.' Days';
        }
        $data['report_title'] = 'SUMMARY Completed Enrollments ( '.$durationD.' )';

        $data['total_row'] = [$result->sum('total_pat'), 'Total', '$ '.number_format($result->sum('for_sum_selling_price'), 2), '$ '.number_format($result->sum('for_sum_igred_cost'), 2), $result->sum('reward_auth'), $result->sum('refillRemain')];

       $result->filter(function ($value, $key) {
                    unset($value['for_sum_igred_cost']);
                    unset($value['for_sum_selling_price']);
                    $value['total_pat'] = number_format($value['total_pat'], 0);
                    $value['refillRemain'] = number_format($value['refillRemain'], 0);
                    return $value;
                });

        $data['result'] = $result->toArray();
        $data['tab_title'] = [ [ 'title' => "Rx's REFERRED", 'sort'=> true, 'class'=>"bg-gray-80 txt-wht cnt-center-force"],  [ 'title'=>'ASSOCIATE CLIENT NAME', 'class'=>"bg-blue txt-wht"],
            [ 'title' => 'SELLING PRICE', 'sort' => true, 'class'=>"bg-red-dk txt-wht cnt-right-force"], ['title'=>'IGRED COST', 'sort'=>true, 'class'=>"bg-gray-1 txt-wht cnt-right-force"],
            ['title'=>'REWARD AUTH', 'sort'=>true, 'class'=>"bg-grn-lk txt-wht cnt-center-force"], ['title'=>'REFILLS REMAIN', 'sort'=>true, 'class'=>"bg-orage txt-wht cnt-center-force"] ];
        $data['col_style'] = ['bg-gray-e txt-blue cnt-center', 'bg-tb-blue-lt txt-blue', 'bg-tb-pink txt-red-dk cnt-right', 'bg-gray-e txt-gray-7e cnt-right', 'bg-tb-grn-lt txt-black-24 cnt-center', 'bg-tb-orange-lt txt-orange cnt-center'];

        return $data;
    }

    public function referrals_generated($days)
    {

        $result = Order::select([DB::raw('COUNT(`Orders`.`PatientId`) AS total_pat'), 'pr.practice_name AS practice_name',
            DB::raw('CONCAT("$ ", FORMAT(SUM(Orders.RxFinalCollect), 2)) AS selling_price'), DB::raw('CONCAT("$ ", FORMAT(SUM(Orders.RxIngredientPrice), 2)) AS igred_cost'),
            DB::raw('SUM(Orders.RxFinalCollect) AS for_sum_selling_price'), DB::raw('SUM(Orders.RxIngredientPrice) AS for_sum_igred_cost'),
            DB::raw('FORMAT(SUM(`rp`.`Points`), 2) AS reward_auth'), DB::raw('SUM(Orders.RefillsRemaining) AS refillRemain')])
                ->join('practices AS pr', 'pr.id', '=', 'Orders.PracticeId')
                ->leftJoin('RewardHistory AS reh', 'reh.PatientId', '=', 'Orders.PracticeId')
                ->leftJoin('RewardPoints AS rp', 'rp.Id', '=', 'reh.RewardPointId')
                ->when($days!='all_activity', function ($query) use ($days) {

                             $end_date = Carbon\Carbon::now()->format('Y-m-d');

                            $start_date = Carbon\Carbon::now()->subDay($days)->format('Y-m-d');
                            $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '>=', $start_date);
                                $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '<=', $end_date);

                            })->orderBy('total_pat', 'desc')->groupBy('pr.practice_name')->get();

        if($days ==1){ $durationD = 'Now'; }
        else{ $durationD = 'Past '.$days.' Days'; }
        $data['report_title'] = 'SUMMARY REFERRALS GENERATED ( '.$durationD.' )';

        $data['total_row'] = [$result->sum('total_pat'), 'Total', '$ '.number_format($result->sum('for_sum_selling_price'), 2), '$ '.number_format($result->sum('for_sum_igred_cost'), 2), $result->sum('reward_auth'), $result->sum('refillRemain')];

       $result->filter(function ($value, $key) {
                    unset($value['for_sum_igred_cost']);
                    unset($value['for_sum_selling_price']);
                    $value['total_pat'] = number_format($value['total_pat'], 0);
                   $value['refillRemain'] = number_format($value['refillRemain'], 0);
                    return $value;
                });

        $data['result'] = $result->toArray();
        $data['tab_title'] = [ [ 'title' => "Rx's REFERRED", 'sort'=> true, 'class'=>"bg-gray-80 txt-wht cnt-center-force"],  [ 'title'=>'ASSOCIATE CLIENT NAME', 'class'=>"bg-blue txt-wht"],
            [ 'title' => 'SELLING PRICE', 'sort' => true, 'class'=>"bg-red-dk txt-wht cnt-right-force"], ['title'=>'IGRED COST', 'sort'=>true, 'class'=>"bg-gray-1 txt-wht cnt-right-force"],
            ['title'=>'REWARD AUTH', 'sort'=>true, 'class'=>"bg-grn-lk txt-wht cnt-center-force"], ['title'=>'REFILLS REMAIN', 'sort'=>true, 'class'=>"bg-orage txt-wht cnt-center-force"] ];

        $data['col_style'] = ['bg-gray-e txt-blue cnt-center', 'bg-tb-blue-lt txt-blue', 'bg-tb-pink txt-red-dk cnt-right', 'bg-gray-e txt-gray-7e cnt-right', 'bg-tb-grn-lt txt-black-24 cnt-center', 'bg-tb-orange-lt txt-orange cnt-center'];

        return $data;
    }

    public function payments_made($days)
    {

        $result = Order::select([DB::raw('COUNT(`Orders`.`PatientId`) AS total_pat'), 'pr.practice_name AS practice_name',
            DB::raw('CONCAT("$ ", FORMAT(SUM(Orders.RxFinalCollect), 2)) AS selling_price'), DB::raw('CONCAT("$ ", FORMAT(SUM(Orders.RxIngredientPrice), 2)) AS igred_cost'),
            DB::raw('SUM(Orders.RxFinalCollect) AS for_sum_selling_price'), DB::raw('SUM(Orders.RxIngredientPrice) AS for_sum_igred_cost'),
            DB::raw('FORMAT(SUM(`rp`.`Points`), 2) AS reward_auth'), DB::raw('SUM(Orders.RefillsRemaining) AS refillRemain')])
                ->join('practices AS pr', 'pr.id', '=', 'Orders.PracticeId')
                ->leftJoin('RewardHistory AS reh', 'reh.PatientId', '=', 'Orders.PracticeId')
                ->leftJoin('RewardPoints AS rp', 'rp.Id', '=', 'reh.RewardPointId')
                ->when($days!='all_activity', function ($query) use ($days) {

                               $end_date = Carbon\Carbon::now()->format('Y-m-d');

                                $start_date = Carbon\Carbon::now()->subDay($days)->format('Y-m-d');
                                $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '>=', $start_date);
                                $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '<=', $end_date);
                            })->orderBy('total_pat', 'desc')->groupBy('pr.practice_name')->get();

        if($days ==1){ $durationD = 'Now'; }
        else{ $durationD = 'Past '.$days.' Days'; }
        $data['report_title'] = 'SUMMARY C RWD PAYMENTS MADE ( '.$durationD.' )';

        $data['total_row'] = [$result->sum('total_pat'), 'Total', '$ '.number_format($result->sum('for_sum_selling_price'), 2), '$ '.number_format($result->sum('for_sum_igred_cost'), 2), $result->sum('reward_auth'), $result->sum('refillRemain')];

       $result->filter(function ($value, $key) {
                    unset($value['for_sum_igred_cost']);
                    unset($value['for_sum_selling_price']);
                    $value['total_pat'] = number_format($value['total_pat'], 0);
                    $value['refillRemain'] = number_format($value['refillRemain'], 0);
                    return $value;
                });

        $data['result'] = $result->toArray();
        $data['tab_title'] = [ [ 'title' => "Rx's REFERRED", 'sort'=> true, 'class'=>"bg-gray-80 txt-wht cnt-center-force"],  [ 'title'=>'ASSOCIATE CLIENT NAME', 'class'=>"bg-blue txt-wht"],
            [ 'title' => 'SELLING PRICE', 'sort' => true, 'class'=>"bg-red-dk txt-wht cnt-right-force"], ['title'=>'IGRED COST', 'sort'=>true, 'class'=>"bg-gray-1 txt-wht cnt-right-force"],
            ['title'=>'REWARD AUTH', 'sort'=>true, 'class'=>"bg-grn-lk txt-wht cnt-center-force"], ['title'=>'REFILLS REMAIN', 'sort'=>true, 'class'=>"bg-orage txt-wht cnt-center-force"] ];

        $data['col_style'] = ['bg-gray-e txt-blue cnt-center', 'bg-tb-blue-lt txt-blue', 'bg-tb-pink txt-red-dk cnt-right', 'bg-gray-e txt-gray-7e cnt-right', 'bg-tb-grn-lt txt-black-24 cnt-center', 'bg-tb-orange-lt txt-orange cnt-center'];

        return $data;
    }


    public function member_questions($days)
    {

        $result = DB::table('practices AS pr')->select([DB::raw('COUNT(QA.id) AS pt_question'), 'pr.practice_name AS practice_name',
            DB::raw('SUM(CASE WHEN QA.OrderId!=NULL THEN 1 ELSE 0 END) AS question_linked')])
                ->join('PatientProfileInfo AS ppi', 'ppi.Practice_ID', '=', 'pr.id')
                ->join('QuestionAnswer AS QA', 'QA.PatientId', '=', 'ppi.Id')
                ->when($days!='all_activity', function ($query) use ($days) {

                               $end_date = Carbon\Carbon::now()->format('Y-m-d');
                                 $start_date = Carbon\Carbon::now()->subDay($days)->format('Y-m-d');
                                 $query->where(DB::raw("DATE_FORMAT(QA.QuestionTime, '%Y-%m-%d')"), '>=', $start_date);
                                $query->where(DB::raw("DATE_FORMAT(QA.QuestionTime, '%Y-%m-%d')"), '<=', $end_date);

                            })->orderBy('pt_question', 'desc')->groupBy('pr.practice_name')->get();


            $result->filter(function ($value, $key) {
               // print_r($value);
               // print_r($key);
               $value->pt_question = number_format($value->pt_question, 0);
               $value->question_linked = number_format($value->question_linked, 0);
               return $value;
           });

        if($days ==1){ $durationD = 'Now'; }
        else{ $durationD = 'Past '.$days.' Days'; }
        $data['report_title'] = 'SUMMARY MBR QUESTIONS ( '.$durationD.' )';


        $data['total_row'] = [$result->sum('pt_question'), 'Total', $result->sum('question_linked')];
        $data['result'] =  json_decode(json_encode($result), true);
        $data['tab_title'] = [ [ 'title' => "PT QUESTIONS", 'sort'=> true, 'class'=>'bg-grn-lk txt-wht cnt-center-force'], [ 'title' => 'CLIENT NAME', 'class'=>'bg-blue txt-wht'],
                                [ 'title' => 'Questions linked to Rx Label Name', 'sort' => true, 'class'=>'bg-red-dk txt-wht cnt-center-force'] ];
        $data['col_style'] = ['bg-tb-grn-lt txt-black-24 cnt-center', 'bg-tb-blue-lt txt-blue', 'bg-tb-pink txt-red-dk cnt-center'];

        return $data;
    }

    public function refill_reminders($days)
    {

        $result = Order::select([DB::raw('COUNT(`NM`.`Id`) AS reminder_send'), 'pr.practice_name AS practice_name',
            DB::raw('CONCAT("$ ", FORMAT(SUM(Orders.RxFinalCollect), 2)) AS selling_price'), DB::raw('CONCAT("$ ", FORMAT(SUM(Orders.RxIngredientPrice), 2)) AS igred_cost'),
            DB::raw('SUM(Orders.RxFinalCollect) AS for_sum_selling_price'), DB::raw('SUM(Orders.RxIngredientPrice) AS for_sum_igred_cost'), DB::raw('SUM(`rp`.`Points`) AS for_reward_auth'),
            DB::raw('FORMAT(SUM(`rp`.`Points`), 2) AS reward_auth'), DB::raw('SUM(Orders.RefillsRemaining) AS refillRemain')
            // ,DB::raw('(SELECT u.name FROM users AS u WHERE u.practice_id=pr.id ORDER BY u.id ASC LIMIT 1) AS userName')  
        ])

                ->leftJoin('RewardHistory AS reh', 'reh.PatientId', '=', 'Orders.PatientId')
                ->leftJoin('practices AS pr', 'pr.id', '=', 'Orders.PracticeId')
                ->leftJoin('NotificationMessages AS NM', 'NM.OrderID', '=', 'Orders.Id')
                ->leftJoin('RewardPoints AS rp', 'rp.Id', '=', 'reh.RewardPointId')
                ->when($days!='all_activity', function ($query) use ($days) {

                               $end_date = Carbon\Carbon::now()->format('Y-m-d');

                                $start_date = Carbon\Carbon::now()->subDay($days)->format('Y-m-d');

                            $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '>=', $start_date);
                                $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '<=', $end_date);
                            })
                ->orderBy('reminder_send', 'desc')->groupBy('pr.practice_name')->get();


       //->where('NM.MessageTypeId', 12)

        if($days ==1){ $durationD = 'Now'; }
        else{ $durationD = 'Past '.$days.' Days'; }
        $data['report_title'] = 'SUMMARY REFILL REMINDERS SENT ( '.$durationD.' )';

        $data['total_row'] = [number_format($result->sum('reminder_send'),0), 'Total', '$ '.number_format($result->sum('for_sum_selling_price'), 2), '$ '.number_format($result->sum('for_sum_igred_cost'), 2),
            number_format($result->sum('for_reward_auth'), 2), number_format($result->sum('refillRemain'),0)];

       $result->filter(function ($value, $key) {
                    unset($value['for_sum_igred_cost']);
                    unset($value['for_sum_selling_price']);
                    unset($value['for_reward_auth']);
                    $value['reminder_send'] = number_format($value['reminder_send'], 0);
                    $value['refillRemain'] = number_format($value['refillRemain'], 0);
                    return $value;
                });

        $data['result'] = $result->toArray();
        $data['tab_title'] = [ [ 'title'=>'Reminders Sent', 'class'=>"bg-gray-80 txt-wht"], [ 'title' => "PHARMACY NAME", 'sort'=> true, 'class'=>"bg-blue txt-wht"], [ 'title' => 'SELLING PRICE', 'sort' => true, 'class'=>"bg-red-dk txt-wht cnt-right-force"],
            ['title'=>'IGRED COST', 'sort'=>true, 'class'=>"bg-gray-1 txt-wht cnt-right-force"], ['title'=>'REWARD AUTH', 'sort'=>true, 'class'=>"bg-grn-lk txt-wht cnt-center-force"], ['title'=>'REFILLS REMAIN', 'sort'=>true, 'class'=>"bg-orage txt-wht cnt-center-force"]];

        $data['col_style'] = ['bg-gray-e txt-blue cnt-center', 'bg-tb-blue-lt txt-blue', 'bg-tb-pink txt-red-dk cnt-right', 'bg-gray-e txt-black-24 cnt-right', 'bg-tb-grn-lt txt-black-24 cnt-center', 'bg-tb-orange-lt txt-orange cnt-center'];


        return $data;
    }

    public function refill_requests($days)
    {

        $result = DB::table('PatientProfileInfo AS ppi')->select([DB::raw('COUNT(  Orders.Id ) AS rx_orders'),
            DB::raw('CONCAT(CONVERT(AES_DECRYPT (FROM_BASE64(FirstName),"ss20compliance19") USING "utf8"), " ", CONVERT(AES_DECRYPT (FROM_BASE64(LastName),"ss20compliance19")USING "utf8")) AS PatName'),
            DB::raw('CONCAT("$ ", FORMAT(SUM(Orders.RxFinalCollect), 2)) AS selling_price'), DB::raw('CONCAT("$ ", FORMAT(SUM(Orders.RxIngredientPrice), 2)) AS igred_cost'),
            DB::raw('SUM(Orders.RxFinalCollect) AS for_sum_selling_price'), DB::raw('SUM(Orders.RxIngredientPrice) AS for_sum_igred_cost'),
            // DB::raw('FORMAT(SUM(`rp`.`Points`), 2) AS reward_auth'),

            DB::raw('(SELECT RefillsRemaining FROM Orders WHERE OrderType="Refill" ORDER BY created_at DESC LIMIT 1 ) AS refillRemain'),

             'pr.practice_name AS practice_name', DB::raw('(SELECT u.name FROM users AS u WHERE u.practice_id=pr.id ORDER BY u.id ASC LIMIT 1) AS userName')  ])                
                ->join('Orders AS Orders', 'Orders.PatientId', '=', 'ppi.Id')
                ->join('practices AS pr', 'pr.id', '=', 'ppi.Practice_ID')
                // ->leftJoin('RewardHistory AS reh', 'reh.PatientId', '=', 'ppi.Id')
                // ->leftJoin('RewardPoints AS rp', 'rp.Id', '=', 'reh.RewardPointId')
        // $result = Order::select([DB::raw('COUNT(  Orders.Id ) AS rx_orders'),
        //     DB::raw('CONCAT(CONVERT(AES_DECRYPT (FROM_BASE64(FirstName),"ss20compliance19") USING "utf8"), " ", CONVERT(AES_DECRYPT (FROM_BASE64(LastName),"ss20compliance19")USING "utf8")) AS PatName'),
        //     DB::raw('CONCAT("$ ", FORMAT(SUM(Orders.RxFinalCollect), 2)) AS selling_price'), DB::raw('CONCAT("$ ", FORMAT(SUM(Orders.RxIngredientPrice), 2)) AS igred_cost'),
        //     DB::raw('SUM(Orders.RxFinalCollect) AS for_sum_selling_price'), DB::raw('SUM(Orders.RxIngredientPrice) AS for_sum_igred_cost'),
        //     DB::raw('FORMAT(SUM(`rp`.`Points`), 2) AS reward_auth'),

        //     DB::raw('(SELECT RefillsRemaining FROM Orders WHERE OrderType="Refill" ORDER BY created_at DESC LIMIT 1 ) AS refillRemain'),

        //      'pr.practice_name AS practice_name', DB::raw('(SELECT u.name FROM users AS u WHERE u.practice_id=pr.id ORDER BY u.id ASC LIMIT 1) AS userName')  ])

                
        //         ->join('PatientProfileInfo AS ppi', 'ppi.Id', '=', 'Orders.PatientId')
        //         ->join('practices AS pr', 'pr.id', '=', 'Orders.PracticeId')
        //         ->leftJoin('RewardHistory AS reh', 'reh.PatientId', '=', 'ppi.Id')
        //         ->leftJoin('RewardPoints AS rp', 'rp.Id', '=', 'reh.RewardPointId')
                ->when($days!='all_activity', function ($query) use ($days) {

                               $end_date = Carbon\Carbon::now()->format('Y-m-d');

                                $start_date = Carbon\Carbon::now()->subDay($days)->format('Y-m-d');

                            $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '>=', $start_date);
                                $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '<=', $end_date);
                            })
                ->where('Orders.OrderStatus', 23)->orderBy('rx_orders', 'desc')->groupBy('ppi.Id')->get();

                
       //->where('NM.MessageTypeId', 12)
        if($days ==1){ $durationD = 'Now'; }
        else{ $durationD = 'Past '.$days.' Days'; }
        $data['report_title'] = 'SUMMARY Rx REFILL REQ MADE BY PATIENTS ( '.$durationD.' )';

        // $data['total_row'] = [$result->sum('rx_orders'), 'Total', '$ '.number_format($result->sum('for_sum_selling_price'), 2), '$ '.number_format($result->sum('for_sum_igred_cost'), 2), $result->sum('reward_auth'), $result->sum('refillRemain')];

       $result->filter(function ($value, $key) {
                    unset($value->for_sum_igred_cost);
                    unset($value->for_sum_selling_price);
                    $value->rx_orders = number_format($value->rx_orders, 0);
                    return $value;
                });

        // $data['result'] = $result->toArray();
        $data['result']=json_decode(json_encode($result), true);
        $data['tab_title'] = [ [ 'title'=>"Rxs REQUESTED", 'class'=>"bg-gray-1 txt-wht cnt-center-force"], [ 'title'=>"PATIENT  NAME", 'class'=>"bg-blue txt-wht"], [ 'title' => 'SELLING PRICE', 'sort' => true, 'class'=>"bg-red-dk txt-wht cnt-right-force"],
            ['title'=>'IGRED COST', 'sort'=>true, 'class'=>"bg-gray-1 txt-wht cnt-right-force"], 
            // ['title'=>'REWARD AUTH', 'sort'=>true, 'class'=>"bg-grn-lk txt-wht cnt-center-force"],
            ['title'=>'REFILLS REMAIN', 'sort'=>true, 'class'=>"bg-orage txt-wht cnt-center-force"], [ 'title' => "PHARMACY NAME", 'sort'=> true, 'class'=>"bg-blue txt-wht"], ['title'=>"CR REP",'class'=>"bg-blue txt-wht"] ];

         $data['col_style'] = ['bg-gray-ed txt-black-24 cnt-center', 'bg-tb-blue-lt txt-blue', 'bg-tb-pink txt-red-dk cnt-right', 
         // 'bg-gray-e txt-gray-7e cnt-right',
          'bg-tb-grn-lt txt-black-24 cnt-right', 'bg-tb-orange-lt txt-orange cnt-center', 'bg-tb-blue-lt txt-blue'];

        return $data;
    }

    public function web_queue_stats_counts()
    {
        $result = DB::table('PatientProfileInfo AS ppi')->select(DB::raw('COUNT(*) AS completed_enroll'))->where('ppi.Status', 'Completed')->get();
        $newRes = collect($result);
        return $newRes[0];
    }

}

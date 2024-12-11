<?php

namespace App\Http\ViewComposers;


use Illuminate\View\View;

use App\Practice;
use Session;
use App\Order;
use App\Patient;
use App\Enrollment as Enroll;
use App\Reports;
use App\PatientDeliveryAddress;
use auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DB;
use App\QuestionAnswer;
use App\Service;

class DashboardComposer
{
    /**
     * 
     *
     * @var 
     */
    protected $data;

    /**
     * Create a new profile composer.
     *
     * @param 
     * @return void
     */
    public function __construct()
    {

        
        $previous_date = Carbon::now()->subDays(1)->format('Y-m-d');
        $current_date = Carbon::now()->format('Y-m-d');
        $data['counts'] = DB::table('Orders')->distinct('RxNumber')->whereNotNull('OrderStatus')
            ->when((isset(auth::user()->practices->first()->id) && !Session::has('practice') && !auth::user()->hasRole('super_admin') && !auth::user()->hasRole('practice_super_group')), function ($query) {
                $query->whereIn('Orders.PracticeId', auth::user()->practices->pluck('id'));
            })
            ->when(Session::has('practice') , function($query){
                $query->where('Orders.PracticeId', Session::get('practice')->id);
            })
             ->when((auth::user()->hasRole('super_admin')), function ($query) {

                    return $query->where(function ($query) {
                        $query->whereIn('Orders.PracticeId', Practice::whereIn('id',auth::user()->practices->pluck('id'))->orWhereIn('parent_id', auth::user()->practices->pluck('id'))->pluck('id')->all());
                    });
                })
                ->when(auth::user()->hasRole('practice_super_group'),function($query){
                $query->whereIn('Orders.PracticeId',auth::user()->practices->pluck('id'));
        })
        ->when(Session::has('practice') , function($query){
            $query->where('Orders.PracticeId', Session::get('practice')->id);
        })
            // ->join(DB::Raw('(SELECT Id, RxNumber, MIN(RefillsRemaining) AS RefillRemain FROM Orders GROUP BY RxNumber) AS my_tables'), function($query){
            //       $query->on('my_tables.RxNumber','Orders.RxNumber')
            //               ->on('my_tables.RefillRemain', 'Orders.RefillsRemaining');
            //   })
            // ->leftJoin('QuestionAnswer', function ($query) {
            //     $query->on('QuestionAnswer.OrderId', 'Orders.Id')
            //         ->whereRaw('QuestionAnswer.Id IN (select MAX(a2.Id) from QuestionAnswer as a2 join Orders as u2 on u2.Id = a2.OrderId group by u2.Id)');
            // })
            ->join('drugs_new','Orders.DrugDetailId','drugs_new.id')
            ->join('practices', 'practices.id', 'Orders.PracticeId')
            ->leftjoin('messages',function($query){
                $query->on('messages.OrderId','Orders.Id')
                ->whereRaw('messages.Id IN (select MAX(a2.Id) from messages as a2 join Orders as u2 on u2.Id = a2.OrderId WHERE a2.message_type != "HCP" group by u2.Id)');
              })
            ->select(
                DB::raw('count(*) total'),
                'Orders.RxNumber',
               // DB::raw('sum(case when QuestionAnswer.Answer IS NULL AND QuestionAnswer.OrderId IS NOT NULL  then 1 else 0 END ) pending_question'),
                DB::raw('sum(CASE
                WHEN (messages.message_status = "received" and messages.id IS NOT NULL) then 1 else 0 END ) pending_question'),
               
                DB::raw('sum(case when OrderStatus = 10 then 1 else 0 END) paid'),
                DB::raw('sum(case when OrderStatus = 23 then 1 else 0 END) refill'),
                DB::raw('sum(case when OrderStatus = 2 then 1 else 0 END) mbr'),
                DB::raw('sum(case when OrderStatus = 24 then 1 else 0 END) under_review'),
                // lpad(yourfield, (select length(max(yourfield)) FROM yourtable),'0') yourfield
                DB::raw("(SELECT COUNT(ppi.Id) FROM PatientProfileInfo AS ppi WHERE ppi.Practice_ID=Orders.PracticeId AND DATE_FORMAT(ppi.created_at, '%Y-%m-%d') >= '" . Carbon::now()->subDay() . "') AS new_enrolled"),
                DB::raw("(SELECT COUNT(ppi.Id) FROM PatientProfileInfo AS ppi WHERE ppi.Practice_ID=Orders.PracticeId AND DATE_FORMAT(ppi.created_at, '%Y-%m-%d') <= '" . Carbon::now()->subDay() . "') AS existing_enrolled")
            )->first();

        $genral_question =  QuestionAnswer::join('PatientProfileInfo as p','p.Id','QuestionAnswer.PatientId')
        ->leftjoin('messages',function($query){
           $query->on('messages.questionId','QuestionAnswer.Id')
           ->whereRaw('messages.Id IN (select MAX(a2.Id) from messages as a2 join QuestionAnswer as u2 on u2.Id = a2.questionId WHERE a2.message_type != "HCP" group by u2.Id)');
         })
           ->select([
                // 'p.Id as p_id','p.Practice_Id',
                // 'FirstName', 'LastName', 'QuestionAnswer.Question', 'QuestionAnswer.Answer',
                // 'QuestionAnswer.QuestionImage', 'QuestionAnswer.Id as qId', 
                 DB::raw('(CASE
                              WHEN (QuestionAnswer.Answer IS NULL AND QuestionAnswer.OrderId IS NOT NULL)  THEN 3
                              ELSE 1 END) AS quest_sort')
            ])
            ->when((isset(auth::user()->practices->first()->id) && auth::user()->practices->first()->id != Null && !auth::user()->hasRole('practice_super_group') && !Session::has('practice') && !auth::user()->hasRole('super_admin')), function($query){
                $query->whereIn('p.Practice_ID', auth::user()->practices->pluck('id'));
        })
        ->when(auth::user()->hasRole('practice_super_group'),function($query){
            $query->whereIn('p.Practice_ID',auth::user()->practices->pluck('id'));
    })
        ->when(Session::has('practice') , function($query){
        $query->where('Practice_ID', Session::get('practice')->id);
    })
         ->when((auth::user()->hasRole('super_admin')), function ($query) {

            return $query->where(function ($query) {
                $query->whereIn('Practice_ID', Practice::whereIn('id',auth::user()->practices->pluck('id'))->orWhereIn('parent_id', auth::user()->practices->pluck('id'))->pluck('id')->all());
            });
        })
        ->where('QuestionType','General_Question')
                ->where('messages.message_status', "received")
            ->count();
// dump($data['counts'] );
// dump($genral_question);


/*
$rxr_ep_order = DB::table('reporter_prescription AS rp')->select(['rp.*',
DB::raw('CONCAT(LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19") USING "utf8")), " ", LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8"))) AS requested_by'),
'p.practice_name'])

->join('PatientProfileInfo AS ppi', 'ppi.Id', 'rp.patient_id')
->join('drugs_new AS d', 'd.Id', 'rp.drug_id')
->join('practices AS p', 'p.id', 'rp.practice_id')
->leftJoin('Orders AS o', 'o.reporter_prescription_id', 'rp.id')
->when((isset(auth::user()->practices->first()->id) && auth::user()->practices->first()->id != Null && !auth::user()->hasRole('practice_super_group')), function($query){
$query->whereIn('rp.practice_id', auth::user()->practices->pluck('id'));
})
->when(auth::user()->hasRole('practice_super_group'),function($query){
$query->whereIn('rp.practice_id',auth::user()->practices->pluck('id'));
})
->when(Session::has('practice') , function($query){
    $query->where('rp.practice_id', Session::get('practice')->id);
})
->whereNull('o.reporter_prescription_id')
->orderBy('rp.created_at', 'DESC')
->count();   */


$rxr_ep_order = DB::table('reporter_prescription AS rp')
->select([
DB::raw('CONCAT(LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19") USING "utf8")), " ", LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8"))) AS requested_by'),
'p.practice_name'])

->join('PatientProfileInfo AS ppi', 'ppi.Id', 'rp.patient_id')
->join('drugs_new AS d', 'd.Id', 'rp.drug_id')
->join('practices AS p', 'p.id', 'rp.practice_id')
->join('users as us','rp.reporter_id','us.id')
->leftjoin('Orders AS o', 'o.reporter_prescription_id', 'rp.id')

->when((isset(auth::user()->practices->first()->id) && auth::user()->practices->first()->id != Null && !auth::user()->hasRole('practice_super_group')  && !Session::has('practice') && !auth::user()->hasRole('super_admin')), function($query){
$query->whereIn('rp.practice_id', auth::user()->practices->pluck('id'));
})
->when(auth::user()->hasRole('practice_super_group'),function($query){
$query->whereIn('rp.practice_id',auth::user()->practices->pluck('id'));
})
->when(Session::has('practice') , function($query){
$query->where('rp.practice_id', Session::get('practice')->id);
})
->when((auth::user()->hasRole('super_admin')), function ($query) {

return $query->where(function ($query) {
$query->whereIn('rp.practice_id', Practice::whereIn('id',auth::user()->practices->pluck('id'))->orWhereIn('parent_id', auth::user()->practices->pluck('id'))->pluck('id')->all());
});
})
->whereNull('o.reporter_prescription_id')
->orderBy('rp.created_at', 'DESC')
->count();

// echo $rxr_ep_order;
// dump($rxr_ep_order);
if(auth::user()->hasrole('compliance_admin')){
    // $data['counts']->pending_question =  $data['counts']->pending_question + $genral_question ;
     $rep = 1;
     $days = 30;
     $refillable = Order::join(DB::Raw('(SELECT Id, RxNumber, MIN(RefillsRemaining) AS RefillRemain,MAX(created_at) AS cre FROM Orders where OrderStatus = 8 GROUP BY RxNumber) AS my_tables'), function($query){
         $query->on('my_tables.RxNumber','Orders.RxNumber')
                 ->on('my_tables.cre', 'Orders.created_at');
     })
      ->select(
         [DB::raw('DATE_FORMAT(Orders.nextRefillDate, "%m/%d/%Y") AS nextRefillDate'), 
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
                DB::raw('CONCAT("$ ", FORMAT(Orders.RxProfitability, 2)) AS rxprofit'),
                DB::raw('FORMAT(`rp`.`Points`, 2) AS reward_auth'),
                DB::raw('CONCAT("$ ", FORMAT(Orders.RxThirdPartyPay ,2)) as thirdparty'),
                DB::raw('CONCAT("$ ", FORMAT(Orders.RxIngredientPrice, 2)) AS igred_cost'),
                DB::raw('CONCAT("$ ", FORMAT(Orders.RxPatientOutOfPocket ,2)) as patOutPocket'),
                DB::raw('CONCAT("$ ", FORMAT(Orders.RxFinalCollect, 2)) AS selling_price'),
               
                DB::raw('Orders.RxProfitability AS rxprofit1'),
                DB::raw('`rp`.`Points`AS reward_auth1'),
                DB::raw('Orders.RxThirdPartyPay  as thirdparty1'),
                DB::raw('Orders.RxIngredientPrice AS igred_cost1'),
                DB::raw('Orders.RxPatientOutOfPocket  as patOutPocket1'),
                DB::raw('Orders.RxFinalCollect AS selling_price1'),
                
                'd.major_reporting_cat AS major_reporting_cat',
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
         ->leftJoin('RewardHistory AS reh', 'reh.PatientId', '=', 'Orders.PracticeId')
         ->leftJoin('RewardPoints AS rp', 'rp.Id', '=', 'reh.RewardPointId')
     //     ->when(!empty($request->get('practice')), function($query) use ($request){
 
     //         $query->where('Orders.PracticeId', $request->get('practice')->id);
 
     // })
     ->when($rep!=0, function ($query) use ($days) {
 
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
     //    dump($refillable);
        $data['counts']->refillable = count($refillable);
     //   dump( $data['counts']);
 }
/* new count added renewel request */
$renewel = DB::table('renewal_prescription AS ren_pre')
->select(['ren_pre.*'
])
->join('Orders', 'Orders.Id', 'ren_pre.OrderId')
->join('OrderStatus', 'Orders.OrderStatus', 'OrderStatus.Id') 
->join('PatientProfileInfo', 'PatientProfileInfo.Id', 'Orders.PatientId')
->join('drugs_new', 'drugs_new.Id', 'Orders.DrugDetailId')
->join('practices', 'practices.id', 'Orders.PracticeId')
->leftjoin('messages',function($query){
$query->on('messages.OrderId','Orders.Id')
->whereRaw('messages.Id IN (select MAX(a2.Id) from messages as a2 join Orders as u2 on u2.Id = a2.OrderId WHERE a2.message_type != "HCP" group by u2.Id)');
})
// ->join('users as us','rp.reporter_id','us.id')  
->where('ren_pre.ViewStatus', 'HcpReq_Created')
->orderBy('ren_pre.CreatedOn', 'DESC')
->count();
/*      end renewal                */
    $data['counts']->pending_question =  $data['counts']->pending_question + $genral_question + $rxr_ep_order + $renewel;

        /*
        $end_date = Carbon::now()->format('Y-m-d');
        $start_date = Carbon::now()->subDay(7)->format('Y-m-d');

        $data['last_seven_days'] = Patient::select([DB::raw('COUNT(Id) AS u_count')])

            ->whereBetween(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'), array($start_date, $end_date))
                ->when((isset(auth::user()->practices->first()->id) && !auth::user()->hasRole('practice_super_group') && !Session::has('practice') && !auth::user()->hasRole('super_admin')), function ($query) {
                $query->whereIn('Practice_ID', auth::user()->practices->pluck('id'));
            })
                   ->when(auth::user()->hasRole('practice_super_group'),function($query){
                $query->whereIn('practice_ID',auth::user()->practices->pluck('id'));
        })
            ->when(Session::has('practice') , function($query){
                $query->where('Practice_ID', Session::get('practice')->id);
            })
             ->when((auth::user()->hasRole('super_admin')), function ($query) {

                    return $query->where(function ($query) {
                        $query->whereIn('Practice_ID', Practice::whereIn('id',auth::user()->practices->pluck('id'))->orWhereIn('parent_id', auth::user()->practices->pluck('id'))->pluck('id')->all());
                    });
                })

            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'))->get();
*/
/*
        $end_date = Carbon::now()->format('Y-m-d');
        $current_month_first = new Carbon('first day of this month');
        $start_date = $current_month_first->format('Y-m-d');

        $data['current_month_patients'] = Patient::select([DB::raw('COUNT(Id) AS u_count')])
            ->whereBetween(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'), array($start_date, $end_date))
                     ->when((isset(auth::user()->practices->first()->id) && !auth::user()->hasRole('practice_super_group') && !Session::has('practice') && !auth::user()->hasRole('super_admin')), function ($query) {
                $query->whereIn('Practice_ID', auth::user()->practices->pluck('id'));
            })
            ->when(Session::has('practice') , function($query){
                $query->where('Practice_ID', Session::get('practice')->id);
            })
             ->when((auth::user()->hasRole('super_admin')), function ($query) {

                    return $query->where(function ($query) {
                        $query->whereIn('Practice_ID', Practice::whereIn('id',auth::user()->practices->pluck('id'))->orWhereIn('parent_id', auth::user()->practices->pluck('id'))->pluck('id')->all());
                    });
                })
                ->when(auth::user()->hasRole('practice_super_group'),function($query){
                $query->whereIn('practice_ID',auth::user()->practices->pluck('id'));
        })
            ->first();
            */
/*
        $data['total_patients'] = Patient::select([DB::raw('COUNT(Id) AS u_count')])
                      ->when((isset(auth::user()->practices->first()->id) && !auth::user()->hasRole('practice_super_group') && !Session::has('practice') && !auth::user()->hasRole('super_admin')), function ($query) {
                $query->whereIn('Practice_ID', auth::user()->practices->pluck('id'));
            })
            ->when(Session::has('practice') , function($query){
                $query->where('Practice_ID', Session::get('practice')->id);
            })
             ->when((auth::user()->hasRole('super_admin')), function ($query) {

                    return $query->where(function ($query) {
                        $query->whereIn('Practice_ID', Practice::whereIn('id',auth::user()->practices->pluck('id'))->orWhereIn('parent_id', auth::user()->practices->pluck('id'))->pluck('id')->all());
                    });
                })
                ->when(auth::user()->hasRole('practice_super_group'),function($query){
                $query->whereIn('Practice_ID',auth::user()->practices->pluck('id'));
        })
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'))
            ->get();

            */

/*                

        $data['practices'] =  Practice::whereNull('added_from_pharmacy')
            ->when(Session::has('practice'), function ($query) {
                $query->where('id', Session::get('practice')->id);
            })
            ->when((auth::user()->hasRole('super_admin')), function ($query) {
                return $query->where(function ($query) {
                    return $query->whereIn('id', auth::user()->practices->pluck('id'))
                        ->orWhereIn('parent_id', auth::user()->practices->pluck('id'));
                });
            })
               ->when(auth::user()->hasRole('practice_super_group'),function($query){
                $query->whereIn('id',auth::user()->practices->pluck('id'));
        })
            ->withCount('patients')->get();
            */
        // dd($data['counts']);
        #[new chnages in view and new file search1 by Matee]
        $this->data = $data;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
   
        $view->with($this->data);
    }
}
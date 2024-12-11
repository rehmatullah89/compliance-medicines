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
                        $query->whereIn('PracticeId', Practice::whereIn('id',auth::user()->practices->pluck('id'))->orWhereIn('parent_id', auth::user()->practices->pluck('id'))->pluck('id')->all());
                    });
                })
                ->when(auth::user()->hasRole('practice_super_group'),function($query){
                $query->whereIn('Orders.PracticeId',auth::user()->practices->pluck('id'));
        })
            // ->join(DB::Raw('(SELECT Id, RxNumber, MIN(RefillsRemaining) AS RefillRemain FROM Orders GROUP BY RxNumber) AS my_tables'), function($query){
            //       $query->on('my_tables.RxNumber','Orders.RxNumber')
            //               ->on('my_tables.RefillRemain', 'Orders.RefillsRemaining');
            //   })
            // ->leftJoin('QuestionAnswer', function ($query) {
            //     $query->on('QuestionAnswer.OrderId', 'Orders.Id')
            //         ->whereRaw('QuestionAnswer.Id IN (select MAX(a2.Id) from QuestionAnswer as a2 join Orders as u2 on u2.Id = a2.OrderId group by u2.Id)');
            // })
            ->leftjoin('messages',function($query){
                $query->on('messages.OrderId','Orders.Id')
                ->whereRaw('messages.Id IN (select MAX(a2.Id) from messages as a2 join Orders as u2 on u2.Id = a2.OrderId group by u2.Id)');
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

        $genral_question =  QuestionAnswer::where('QuestionType', 'General_Question')->join('PatientProfileInfo as p', 'p.Id', 'QuestionAnswer.PatientId')
           ->select([
                // 'p.Id as p_id','p.Practice_Id',
                // 'FirstName', 'LastName', 'QuestionAnswer.Question', 'QuestionAnswer.Answer',
                // 'QuestionAnswer.QuestionImage', 'QuestionAnswer.Id as qId', 
                 DB::raw('(CASE
                              WHEN (QuestionAnswer.Answer IS NULL AND QuestionAnswer.OrderId IS NOT NULL)  THEN 3
                              ELSE 1 END) AS quest_sort')
            ])
                ->when((isset(auth::user()->practices->first()->id) && !Session::has('practice') && !auth::user()->hasRole('super_admin') && !auth::user()->hasRole('practice_super_group')), function ($query) {
                $query->whereIn('p.Practice_Id', auth::user()->practices->pluck('id'));
            })
            ->when(Session::has('practice') , function($query){
                $query->where('p.Practice_Id', Session::get('practice')->id);
            })
             ->when((auth::user()->hasRole('super_admin')), function ($query) {

                    return $query->where(function ($query) {
                        $query->whereIn('p.Practice_Id', Practice::whereIn('id',auth::user()->practices->pluck('id'))->orWhereIn('parent_id', auth::user()->practices->pluck('id'))->pluck('id')->all());
                    });
                })
                ->when(auth::user()->hasRole('practice_super_group'),function($query){
                $query->whereIn('Practice_Id',auth::user()->practices->pluck('id'));
        })
            ->where('Answer', NULL)
            ->orderBy('QuestionTime')
            ->count();
// dump($data['counts'] );
// dump($genral_question);


$rxr_ep_order = DB::table('reporter_prescription AS rp')->select(['rp.*',
DB::raw('CONCAT(LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19") USING "utf8")), " ", LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8"))) AS requested_by'),
'p.practice_name'])

->join('PatientProfileInfo AS ppi', 'ppi.Id', 'rp.patient_id')
->join('drugs_new AS d', 'd.Id', 'rp.drug_id')
->join('practices AS p', 'p.id', 'rp.practice_id')
->leftjoin('Orders AS o', 'o.reporter_prescription_id', 'rp.id')
->when((isset(auth::user()->practices->first()->id) && auth::user()->practices->first()->id != Null && !auth::user()->hasRole('practice_super_group')), function($query){
$query->whereIn('rp.practice_id', auth::user()->practices->pluck('id'));
})
->when(auth::user()->hasRole('practice_super_group'),function($query){
$query->whereIn('rp.practice_id',auth::user()->practices->pluck('id'));
})
->whereNull('o.reporter_prescription_id')
->orderBy('rp.created_at', 'DESC')
->count();
// dump($rxr_ep_order);
        $data['counts']->pending_question =  $data['counts']->pending_question + $genral_question + $rxr_ep_order;
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
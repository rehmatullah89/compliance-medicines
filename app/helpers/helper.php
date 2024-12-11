<?php
//function decrypt($data)
//{
//    $key = getenv('AES_KEY');
//    $cipher = "AES-256-CBC";
//    $iv='iv123456789ABC76';
//    return openssl_decrypt($data, $cipher, $key, $options=0,$iv);
//
//}
//
//
//function encrypt($data)
//{
//    $key = getenv('AES_KEY');
//    $cipher = "AES-256-CBC";
//    $iv='iv123456789ABC76';
//    return openssl_decrypt($data, $cipher, $key, $options=0,$iv);
//
//}
use App\QuestionAnswer;
use App\Order;
use App\Survey;

function encrypted_attr( $value)
{

    if ($value !='') {
        $value = strtolower($value);
        $value = DB::select("SELECT TO_BASE64(AES_ENCRYPT( '".$value."' , 'ss20compliance19')) as encrypted");
        $value = $value[0]->encrypted;
        return  $value;
    }
    return  '';
}
function decrypted_attr($value)
{

    if ($value !='') {
        $value = DB::select("SELECT AES_DECRYPT (FROM_BASE64('".$value."'),'ss20compliance19') as decrypted");
        $value= $value[0]->decrypted;
    }
    return $value;
}

function low($string)
{
    return strtolower($string);

}

/*   used for side bar but now no need 

function get_new_orders_count($type)
{
  if($type=='ques')
  {
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
            // ->join(DB::Raw('(SELECT Id, RxNumber, MIN(RefillsRemaining) AS RefillRemain FROM Orders GROUP BY RxNumber) AS my_tables'), function($query){
            //       $query->on('my_tables.RxNumber','Orders.RxNumber')
            //               ->on('my_tables.RefillRemain', 'Orders.RefillsRemaining');
            //   })
            ->leftjoin('messages',function($query){
                $query->on('messages.OrderId','Orders.Id')
                ->whereRaw('messages.Id IN (select MAX(a2.Id) from messages as a2 join Orders as u2 on u2.Id = a2.OrderId group by u2.Id)');
              })
            ->select(
                DB::raw('count(*) total'),
                DB::raw('sum(CASE
                WHEN (messages.message_status = "received" and messages.id IS NOT NULL) then 1 else 0 END ) pending_question')
                 )->orderBy('Orders.created_at', 'DESC')->first();




        $genral_question =  QuestionAnswer::where('QuestionType', 'General_Question')
        ->join('PatientProfileInfo as p', 'p.Id', 'QuestionAnswer.PatientId')
           ->select([
                'p.Id as p_id'
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
            ->count();


        return  $data['counts']->pending_question + $genral_question;


    
  }
	else if($type=='new')
  {

     return   $rxr_ep_order = DB::table('reporter_prescription AS rp')->select(['rp.*',
DB::raw('CONCAT(LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19") USING "utf8")), " ", LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8"))) AS requested_by'),
'p.practice_name'])

->join('PatientProfileInfo AS ppi', 'ppi.Id', 'rp.patient_id')
->join('drugs_new AS d', 'd.Id', 'rp.drug_id')
->join('practices AS p', 'p.id', 'rp.practice_id')
->leftjoin('Orders AS o', 'o.reporter_prescription_id', 'rp.id')
->when((isset(auth::user()->practices->first()->id) && auth::user()->practices->first()->id != Null && !auth::user()->hasRole('practice_super_group')), function($query){
$query->whereIn('rp.practice_id', auth::user()->practices->pluck('id'));
})
->when(Session::has('practice') , function($query){
    $query->where('rp.practice_id', Session::get('practice')->id);
})
->when(auth::user()->hasRole('practice_super_group'),function($query){
$query->whereIn('rp.practice_id',auth::user()->practices->pluck('id'));
})
->whereNull('o.reporter_prescription_id')
->orderBy('rp.created_at', 'DESC')
->count();
  }






    // dd($q2);
        // $data['requests'] = $q1->merge($q2);
     // return count($data['requests'])  +count($genral_question)+ count($data['requests_two']);

}
function get_refill_order_count()
{

      $refill_group = DB::table('Orders')->distinct('RxNumber')->whereNotNull('OrderStatus')
            ->when((isset(auth::user()->practices->first()->id) && !Session::has('practice') && !auth::user()->hasRole('super_admin') && !auth::user()->hasRole('practice_super_group')), function ($query) {
                $query->whereIn('PracticeId', auth::user()->practices->pluck('id'));
            })
            ->when(Session::has('practice') , function($query){
                $query->where('PracticeId', Session::get('practice')->id);
            })
             ->when((auth::user()->hasRole('super_admin')), function ($query) {

                    return $query->where(function ($query) {
                        $query->whereIn('PracticeId', Practice::whereIn('id',auth::user()->practices->pluck('id'))->orWhereIn('parent_id', auth::user()->practices->pluck('id'))->pluck('id')->all());
                    });
                })
                ->when(auth::user()->hasRole('practice_super_group'),function($query){
                $query->whereIn('PracticeId',auth::user()->practices->pluck('id'));
        })
            ->select( DB::raw('sum(case when OrderStatus = 23 then 1 else 0 END) refill')
       )->first();

    return $refill_group->refill;
}
*/

function get_survey_count()
{
                     $data['requests'] =  Survey::whereStatus(1)->count();
                     return $data['requests'];
}

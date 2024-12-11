<?php

namespace App\Http\Controllers;

use App\Order;
use App\Practice;
use App\OrderStatus;
use App\Patient;
use Illuminate\Http\Request;
use auth;
use DB;
use App\QuestionAnswer;
use App\OrderStatusLog;
use App\PatientInsuranceDetail;
use Illuminate\Support\Facades\Storage;
use App\Prescriber;
use Session;
use Carbon\Carbon;
use App\Service;
use Pusher\Pusher;
use App\Message;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function alertOrderStatus($pharmacy,$message)
    {
        $pusher = new Pusher(
                        '48727362c82c456bc21e',
                        'be6e1a7a12274414ea98',
                        '1012838',
                        array(
                                'cluster' => 'ap2',
                                'encrypted' => true
                        )
                );
        $data['pharmacy'] = $pharmacy;
        $data['message'] = $message;
        $pusher->trigger('notify-channel', 'App\\Events\\Notify', $data);
    }
    
    public function updateMobileOrderStatus(Request $request)
    {
        $this->alertOrderStatus($request->pharmacy, $request->status);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    	// return $request->all();
      // $request->validate([
      //   'RxNumber' => 'unique:Orders,RxNumber',
      //   ]);

        $reslt=Order::where('RxNumber',$request->RxNumber)->first();

        if($reslt!=null && !$request->has('Id'))
        {
            return response()->json(['status' => false, 'message' => 'Rxnumber already Exists']);
        }

if($request->has('PatientId')){
        $patient = Patient::where('Id',$request->PatientId)->with('enrollment')->get();
//        return $patient;
}else{
    return response()->json(['enrolled'=>false , 'status'=>false ,'message'=>"No patient Id found"]);

}
//        return $request->PatientId;
        $enrolled = false;
//        return $patient[0]->enrollment->enrollment_status;

        if(!$patient || !$patient[0]->enrollment){
            return response()->json(['enrolled'=>false , 'status'=>false ,'message'=>"Please enroll patient no enrollment status found!"]);
        }
        // return $patient;

   if($request->has('HcpOrderId'))
        {
           unset($request['HcpOrderId']);
        }

        if($request->has('marketer'))
        {
           unset($request['marketer']);
        }

        $currentReward=0;
        if($request->has('Id') && !is_null($request->Id)){

            // $request['DrugName'] = $request->DrugDetailId;
            if(!$request->prescriber_id && $request->OrderStatus!=29)
            { 
              if($request->PrescriberPhone && $request->PrescriberName)
                  $prescrib=Practice::where(["practice_name"=>$request->PrescriberName,"practice_phone_number"=>$request->PrescriberPhone])->first();
              else
              $prescrib=null;
                  if($prescrib!=null)
              {
                $request['prescriber_id']=$prescrib->id;
              }else{
                $prescriber=new Practice;
                $prescriber->practice_name=$request->PrescriberName;
                $prescriber->practice_type='Physician';

                $prescriber->added_from_pharmacy = 1;

                $prescriber->practice_phone_number=$request->PrescriberPhone;
                if($prescriber->save())
                {
                  $request['prescriber_id']=$prescriber->id;
                }
              }
            }
            // $request['OrderStatus'] = 2;
            $requestData = $request->all();

            if($request->hasFile('drug_clinical_advise'))
            {
                $clinc_img=$request->file('drug_clinical_advise');
                $new_img_path=rand().time().'.'.$clinc_img->getClientOriginalExtension();
                $f1=Storage::disk('public')->putFileAs('drugClinical', $clinc_img,$new_img_path);

                 $requestData['drug_clinical_advise'] = 'storage/'.$f1;

              }

              if($request->OrderStatus!=29)
              {
              	$order = Order::updateOrCreate(['Id'=>trim($request->Id)],$requestData);
              }else{
              	$order = Order::updateOrCreate(['Id'=>trim($request->Id)],['OrderStatus'=>$request->OrderStatus]);
              }
           
           
           //Log order status
           OrderStatusLog::insert(['order_id'=>$order->Id, 'status_id'=>$order->OrderStatus, 'created_by'=>auth()->id()]);

     		if($order && $request->OrderStatus!=29)
     		{
	           	if($order->Cr_Point_Id)
	            {
	           		$currentReward = $request->asistantAuth /  4;
	           		$currentReward = round($currentReward,2) + 0;
	           		$currentRemainBalance = $request->asistantAuth - $currentReward;
	          		$Cr_Point_Id =  DB::table('ComplianceRewardPoint')->where('RewardId',$order->Cr_Point_Id)->update(
	            	['RxPatientOutOfPocket'=> $request->asistantAuth,
	             	'CurrentEarnReward'=>$currentReward,
	             	'CurrentRemainBalance'=>round($currentRemainBalance,2),
	             	'UpdatedOn'=>Carbon::now()->toDateTimeString()
	             	]);
	            }
     		}


            $notification = null;
           if($order)
           {
           	if($request->OrderStatus!=29)
           	{
            	$notification = $this->sendNotificationOrderStatus($request->Id,$request->OrderStatus, $patient[0]->SecurityToken);
            	$notification = json_decode($notification);
        	}
            $order_status=Order::where('Orders.Id',$request->Id)->join('OrderStatus','Orders.OrderStatus','OrderStatus.Id')->
            leftJoin('ComplianceRewardPoint','Orders.Cr_Point_Id','ComplianceRewardPoint.RewardId')->get();
            if($order_status)
            {
                $order_status=$order_status->first();
            }
            $barCode = '';
            $barCode1 = '';
            if($request->OrderStatus == 8){
                $barCode = \DNS1D::getBarcodeHTML($request->Id, 'I25');
                $barCode1 = \DNS2D::getBarcodeHTML($request->Id, 'QRCODE',3,3);
            }
            if($request->OrderStatus == 27)
            {
             
              $cancel_order=Order::join(DB::Raw('(SELECT Id, RxNumber, MIN(RefillsRemaining) AS RefillRemain,MAX(created_at) AS cre FROM Orders where OrderStatus = 8 GROUP BY RxNumber) AS my_tables'), function($query){
                        $query->on('my_tables.RxNumber','Orders.RxNumber')
                                ->on('my_tables.cre', 'Orders.created_at');
                    })
              ->where('Orders.RxNumber',$order->RxNumber)
              ->first();
              if($cancel_order)
              {
                $cancel_order->update(['nextRefillFlag'=>0,
                  'refilldone'=>0,
                  'ViewStatus'=>NULL,
                  'LastRefillDate'=>NULL
                ]);
              }
              
            }
            if(isset($request->OrderStatus) && in_array($request->OrderStatus,[2,24])){
                $this->alertOrderStatus(0, 'An order status has been updated.');
                $this->alertOrderStatus($order->PracticeId, $request->OrderStatus);
            }

           return response()->json(['enrolled'=>true ,'notification'=>$notification, 'status'=>true ,'message'=>"order updated successfully",
           "order"=>$order,'order_status'=>$order_status,'barCode'=>$barCode,'barCode1'=>$barCode1]);
           }else{
            return response()->json(['enrolled'=>true ,'notification'=>$notification, 'status'=>false ,'message'=>"order could not update"]);
           }

        }
        $requestData = $request->all();
        $requestData['RxNumber'] = strtoupper($request['RxNumber']);

       if( $patient[0]->enrollment->enrollment_status == 'New'){
           $request['OrderStatus'] = 1;

       }else if($patient[0]->enrollment->enrollment_status == 'Enrolled'){
           $currentReward = $request->asistantAuth /  4;
           $currentReward = round($currentReward,2) + 0;
           $currentRemainBalance = $request->asistantAuth - $currentReward;
          $Cr_Point_Id =  DB::table('ComplianceRewardPoint')->insertGetId(
            ['PatientId' => $patient[0]->Id,
             'RxId' =>$requestData['RxNumber'],
             'ActivityTypeId'=>9,
             'RxPatientOutOfPocket'=> $request->asistantAuth,
             'CurrentEarnReward'=>$currentReward,
             'CurrentRemainBalance'=>round($currentRemainBalance,2),
             'ActivityCount'=>1,
             'CreatedOn'=>Carbon::now()->toDateTimeString()
             ]
        );
// if($request->has('OrderStatus') && $request->OrderStatus)
// $request['OrderStatus'] = 28;
// else
// $request['OrderStatus'] = 2;
if(!$request->has('OrderStatus'))
$request['OrderStatus'] = 2;

           
           $request['Cr_Point_Id'] = $Cr_Point_Id;
           $enrolled = true;
       }
       else{
           return response()->json(['enrolled'=>false , 'status'=>false ,'message'=>"order not saved wrong patient info"]);
       }

if(!isset($request['reporter_prescription_id'])){
      if(isset(auth::user()->practices->first()->id)  && !auth::user()->hasRole('super_admin') && !auth::user()->hasRole('practice_super_group'))
      {
       $request['PracticeId'] = auth::user()->practices->first()->id;
       if(auth::user()->practices->first()->id !== $patient[0]->Practice_ID){
           return "user is register in another pharmacy".$patient[0]->Practice_ID;
       }
      }else if(Session::has('practice')){
         $request['PracticeId'] = Session::get('practice')->id;
      }else if(isset( $request['PracticeId']) &&  $request['PracticeId'] != null ){

      }else{
        $request['PracticeId'] = $patient[0]->Practice_ID;
      }

}else{
        if(isset(auth::user()->practices->first()->id) && !auth::user()->hasRole('practice_super_group'))
      {
       $request['PracticeId'] = auth::user()->practices->first()->id;
      }else if(Session::has('practice')){
         $request['PracticeId'] = Session::get('practice')->id;
      }else if(isset( $request['PracticeId']) &&  $request['PracticeId'] != null ){

      }
     $patientUpdate =  Patient::where('Id',$request->PatientId)->update(['Practice_ID' => $request['PracticeId'] ]);

       
     if(Practice::whereId($request['PracticeId'])->first()){
            
        $pip_id =    DB::table('pip_patient_cases')->wherePatientId($request->PatientId)->latest('created_at')->first();  //->wherePracticeId( $request['PracticeId'])
        if($pip_id)
              $request['pip_case_id'] = $pip_id->id;
        
     //    return $requestData;
    }

    if($request->has('RxOrigDate'))
    {

    }else{
        $request['RxOrigDate'] = carbon::now()->format('Y-m-d');
    }

}



    /*  if(auth::user()->hasRole('super_admin') && $request->PracticeId){
        $p_id =   $request['PracticeId'];
    }

    if(auth::user()->hasRole('super_admin') && isset(Session::get('practice')->id)){
        $p_id =   Session::get('practice')->id;
    } */


// return $request->all();
        if(!$request->prescriber_id)
        {
          $prescrib=Practice::where(["practice_name"=>$request->PrescriberName,"practice_phone_number"=>$request->PrescriberPhone])->first();
          if($prescrib!=null)
          {
            $request['prescriber_id']=$prescrib->id;
            $orignial_physician=Practice::where(['id'=>$prescrib->id,'added_from_pharmacy'=>NULL])->first();
            if($orignial_physician)
            {
              $request['reporter_prescription_id']=$request->prescriber_id;
            }
          }else{
            $prescriber=new Practice;
            $prescriber->practice_name=$request->PrescriberName;
            $prescriber->practice_type='Physician';

            $prescriber->added_from_pharmacy = 1;

            $prescriber->practice_phone_number=$request->PrescriberPhone;
            if($prescriber->save())
            {
              $request['prescriber_id']=$prescriber->id;
            }
          }
        }else{

          $orignial_physician=Practice::where(['id'=>$request->prescriber_id,'added_from_pharmacy'=>NULL])->first();
          if($orignial_physician)
          {
            
            $request['reporter_prescription_id']=$request->prescriber_id;
          }

        }
       
        $requestData = $request->all();

        if($request->has('drug_clinical_advise'))
        {
        	unset($requestData['drug_clinical_advise']);
        }


        $order =  Order::create($requestData);


        if($order) {

        	if($request->hasFile('drug_clinical_advise'))
	      	{

	      		$input=array();
	      		foreach($request->file('drug_clinical_advise') as $clinc_img)
	            {

	            	$new_img_path=rand().time().'.'.$clinc_img->getClientOriginalExtension();
			        $f1=Storage::disk('public')->putFileAs('drugClinical', $clinc_img,$new_img_path);
			       	$input[]=array('OrderId'=>$order->Id,'CustomDocument'=>'storage/'.$f1);
	            }

		       $drug_clin_id=DB::table('OrderCustomDocuments')->insert($input);


	      	}
            if($request['Cr_Point_Id']){

                $Cr_reward_history =  DB::table('RewardHistory')->insertGetId(
                    ['PatientId' => $patient[0]->Id,
                     'ActivityId' => 9,
                     'RewardPointId'=>$request['Cr_Point_Id'],
                     'OrderId'=> $order->Id,
                     'RxNumber'=>$order->RxNumber,
                     'EarnedReward'=>$currentReward,
                     'ActivityNumber'=>1,
                     'CREATED_DATE'=>Carbon::now()->toDateTimeString()
                     ]
                );
               }
//            if($patient[0]->enrollment->enrollment_status == "Enrolled" && $patient[0]->enrollment->preffered_method_contact == "Email"){
           // IOS requirement send notifiaction either patient enrolled or not. 20 jan
            if ($patient[0]->enrollment->enrollment_status == "Enrolled" || $patient[0]->enrollment->enrollment_status == "New") {
                if(isset($patient[0]->is_pip_patient)&&$patient[0]->is_pip_patient!= 'Y' )
                {
                    $notification = $this->sendNotification($request->PatientId, $order->Id);
                    $notification = json_decode($notification);
                }else{
                 $notification = 'No notification for PIP';
                }

//               if($notification->errorMessage){
//
//               }
//           dump($notification);
                //  $send = Mail::to($patient[0]->EmailAddress)->send(new \App\Mail\Order($order));
            }
        }
                else{
                    // $this->sendEnrollment($patient[0]->MobileNumber);
                    // mobile notification
                }

                //Log order status
                OrderStatusLog::insert(['order_id'=>$order->Id, 'status_id'=>$order->OrderStatus, 'created_by'=>auth()->id()]);

                $order_status=Order::where('Orders.Id',$order->Id)->join('OrderStatus','Orders.OrderStatus','OrderStatus.Id')->first();
                $this->alertOrderStatus(0,'A new order has been created.');

            return response()->json(['noti'=>$notification,'enrolled'=>$enrolled , 'status'=>true ,'message'=>"order saved successfully",
                "order"=>$order,'order_status'=>$order_status]);
        }
        //dump($request);


    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id=0)
    {    


       $data['practices'] = Practice::select(['id', 'practice_name','branch_name'])->when((auth::user()->hasRole('super_admin')), function ($query) {
                  return      $query->whereIn('id', auth::user()->practices->pluck('id'))->orWhereIn('parent_id', auth::user()->practices->pluck('id'));

                })
                ->when(auth::user()->hasRole('practice_super_group'),function($query){
                    $query->whereIn('id',auth::user()->practices->pluck('id'));
            })
             ->whereIn('practice_type', ['Pharmacy'])
            ->whereNull('added_from_pharmacy')
            ->whereNotNull('practice_name')
            ->get();

        // ->whereNotIn('Id',[11,24,25])
        // $data['service'] = OrderStatus::whereNotNull('Description')->orderByRaw('FIELD(id,1,23,2,10,8,21,24,25,11,27)')->get();
        $data['service'] = OrderStatus::whereNotNull('Description')->orderByRaw('FIELD(id,21,10,23,11,1,2,8,24,25,27,28,29)')->pluck('Name','Id')->toArray();
        $pat = null;
  /*
        if(isset(auth::user()->practices->first()->id) && auth::user()->practices->first()->id != Null && !auth::user()->hasRole('practice_super_group') && Request('service') == 'pat')
        $pat = Patient::whereIn('Practice_ID',auth::user()->practices->pluck('id'))->where('created_at','>=', Carbon::now()->subDay())->pluck('Id');


    if(Request('type') && Request('type')=='new_order')
    {
        $data['requests_two'] = DB::table('reporter_prescription AS rp')->select(['rp.*', 'us.name as reporter_name',
                        DB::raw('CONCAT(LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19") USING "utf8")), " ", LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8"))) AS requested_by'),
                        DB::raw('CONCAT(d.rx_label_name, " ", d.strength, " ", d.dosage_form) AS rx_label_name'), 'd.brand_reference AS brand_reference', 'rp.quantity AS quantity',
                        'p.practice_name'])

            ->join('PatientProfileInfo AS ppi', 'ppi.Id', 'rp.patient_id')
            ->join('drugs_new AS d', 'd.Id', 'rp.drug_id')
            ->join('practices AS p', 'p.id', 'rp.practice_id')
             ->join('users as us','rp.reporter_id','us.id')
            ->leftjoin('Orders AS o', 'o.reporter_prescription_id', 'rp.id')

            ->when(!empty($request->all()), function($query) use ($request){
                   if(Request('keyword')){
                        $query->where(function($q) use ($request){
                            $q->orWhereRaw("CONCAT(LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),'ss20compliance19')USING 'utf8')), ' ', LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),'ss20compliance19')USING 'utf8'))) LIKE '%".$request->keyword."%'");
                        });
                    }
                    // if(Request('service') && Request('service') != 26 && Request('service') != 'new_order'){  $query->where('rp.id', null); }
                    if($request->has('practice_name') and $request->practice_name!='ALL'){
                        $query->where('rp.practice_id', $request->practice_name);
                    }

                    if(Request('from_date')){
                        if(Request('to_date')==''){ $end_date = Carbon::now()->format('Y-m-d'); }else{  $end_date = Carbon::parse(Request('to_date'))->format('Y-m-d'); }
                        $start_date = Carbon::parse(Request('from_date'))->format('Y-m-d');
                        $query->where(DB::raw("DATE_FORMAT(rp.created_at, '%Y-%m-%d')"), '>=', $start_date);
                        $query->where(DB::raw("DATE_FORMAT(rp.created_at, '%Y-%m-%d')"), '<=', $end_date);
                    }
        })
        ->when(Session::has('practice') , function($query){
            $query->where('rp.practice_id', Session::get('practice')->id);
        })
        ->when((isset(auth::user()->practices->first()->id) && auth::user()->practices->first()->id != Null && !auth::user()->hasRole('practice_super_group')), function($query){
        $query->whereIn('rp.practice_id', auth::user()->practices->pluck('id'));
})
->when(auth::user()->hasRole('practice_super_group'),function($query){
    $query->whereIn('rp.practice_id',auth::user()->practices->pluck('id'));
})
        ->whereNull('o.reporter_prescription_id')
        ->orderBy('rp.created_at', 'DESC')
        ->get();
    }else{
      // DB::enableQueryLog();
          $data['requests'] = Order::join('PatientProfileInfo', 'PatientProfileInfo.Id', 'Orders.PatientId')
       */   /**
           Order messages thread maintined now messages table so QuestionAnswer is using no more 6-7-2020 Ken requirement
           */

       /*   ->leftJoin('QuestionAnswer',function($query){
            $query->on('QuestionAnswer.OrderId','Orders.Id')
            ->whereRaw('QuestionAnswer.Id IN (select MAX(a2.Id) from QuestionAnswer as a2 join Orders as u2 on u2.Id = a2.OrderId group by u2.Id)');
        })*/
/*     ->leftjoin('messages',function($query){
            $query->on('messages.OrderId','Orders.Id')
            ->whereRaw('messages.Id IN (select MAX(a2.Id) from messages as a2 join Orders as u2 on u2.Id = a2.OrderId group by u2.Id)');
          })
          ->join('drugs_new', 'drugs_new.id', 'Orders.DrugDetailId')
                ->join('OrderStatus', 'Orders.OrderStatus', 'OrderStatus.Id')
                    ->join('practices', 'practices.id', 'Orders.PracticeId')     */  
                    // when select All 8 ,11,25 status show not show. 6-7-2020 Ken requirement to show all orders when select ALL filter
                /*->when((empty(Request('service')) || Request('service') == 26 ), function($query){
                    // $query->where('Orders.OrderStatus','!=',8);
                    $query->whereNotIn('Orders.OrderStatus',[8,11,25]);
                })
                */
       /*              ->when(Session::has('practice') , function($query){
                    $query->where('Orders.PracticeId', Session::get('practice')->id);
                })
                ->when(auth::user()->hasRole('practice_super_group'),function($query){
                    $query->whereIn('Orders.PracticeId',auth::user()->practices->pluck('id'));
                })
                ->when($id !== 0 ,function($query) use ($id){
                    $query->where('Orders.PatientId',$id);
                })
                ->when((isset(auth::user()->practices->first()->id) && auth::user()->practices->first()->id != Null && !Session::has('practice') && !auth::user()->hasRole('super_admin') && !auth::user()->hasRole('practice_super_group')), function($query){
                        $query->whereIn('Orders.PracticeId', auth::user()->practices->pluck('id'));
                })
                 ->when((auth::user()->hasRole('super_admin')), function ($query) {

                    return $query->where(function ($query) {
                        $query->whereIn('Orders.PracticeId', Practice::whereIn('id',auth::user()->practices->pluck('id'))->orWhereIn('parent_id', auth::user()->practices->pluck('id'))->pluck('id')->all());
                    });
                })
                ->when(!empty($request->all()), function($query) use ($request,$pat){

                        if(Request('practice_name') && Request('practice_name') !="ALL"){ $query->where('Orders.PracticeId', Request('practice_name')); }

                        if(Request('service') && Request('service') != 26 && Request('service') != 21 && Request('service') != 'pat'){  $query->where('Orders.OrderStatus', Request('service')); }
                        if(Request('service') && Request('service') == 21){

                            /**
           Order messages thread maintined now messages table so QuestionAnswer is using no more 6-7-2020 Ken requirement
           */
                         /*   $query->whereNull('QuestionAnswer.Answer');
                            $query->whereNotNull('QuestionAnswer.OrderId');*/
/*
                              $query->where('messages.message_status','received');
                            $query->whereNotNull('messages.id');
                        }

 if(Request('service') && Request('service') == 'pat' && isset($pat)){
  // dump($pat);
                            $query->whereIn('Orders.PatientId',$pat);

                        }

                        if(Request('keyword')){
                                $query->where(function($q) use ($request){
						        $q->where('Orders.RxNumber','LIKE', "%$request->keyword%");
                    // $q->orWhere(DB::raw('concat(`LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(PatientProfileInfo.FirstName),"ss20compliance19")USING "utf8"))`, `LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(PatientProfileInfo.LastName),"ss20compliance19")USING "utf8")))`)'), 'ilike', '%'.$request->keyword.'%');
                    $q->orWhereRaw("CONCAT(LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(PatientProfileInfo.FirstName),'ss20compliance19')USING 'utf8')), ' ', LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(PatientProfileInfo.LastName),'ss20compliance19')USING 'utf8'))) LIKE '%".$request->keyword."%'");
                    // $q->orWhereRaw('CONCAT("PatientProfileInfo.FirstName", "PatientProfileInfo.LastName") LIKE "%'.$request->keyword.'%"');
						        // $q->orWhereRaw(' LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(PatientProfileInfo.FirstName),"ss20compliance19")USING "utf8")) Like "%'.$request->keyword.'%"'  );
                    // $q->orWhereRaw(' LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(PatientProfileInfo.LastName),"ss20compliance19")USING "utf8")) Like "%'.$request->keyword.'%"'  );
    						});



                        }
                        if(Request('from_date')){
                        	// dd(Request('from_date'));
                          if(Request('to_date')==''){ $to_date = date('m/d/Y'); }else{  $to_date = Request('to_date');  }
                          $query->whereBetween(DB::raw('DATE_FORMAT(Orders.created_at, "%m/%d/%Y")'), array(Request('from_date'), $to_date));

                            }


                    //  DB::raw('case when QuestionAnswer.Answer IS NOT NULL and QuestionAnswer.Id IS NOT NULL then 1 else 0 end as qs_ans'),
                })
                 ->select(['practices.parent_id AS parent_id','practices.id as PracticeId','practices.branch_name AS branch_name','practices.practice_name AS p_name','PatientProfileInfo.Id as p_id', 'Orders.Quantity', 'Orders.Id as order_id','Orders.asistantAuth','Orders.OrderType','Orders.OrderStatus',
                   'Orders.created_at as order_created_at', 'PatientProfileInfo.*',
                    DB::raw('CONCAT(UPPER(CONVERT(AES_DECRYPT (FROM_BASE64(PatientProfileInfo.FirstName),"ss20compliance19") USING "utf8")), " ", UPPER(CONVERT(AES_DECRYPT (FROM_BASE64(PatientProfileInfo.LastName),"ss20compliance19")USING "utf8"))) AS requested_by'),
                    'drugs_new.*', 'OrderStatus.Name as orderStatusName',
                     DB::raw('case when Orders.RefillCount < 9 then concat(Orders.Rxnumber,"-0",Orders.RefillCount) else concat(Orders.Rxnumber,"-",Orders.RefillCount) end as RxNumber'),
   */  
                      /**
           Order messages thread maintined now messages table so QuestionAnswer is using no more 6-7-2020 Ken requirement
           */

                    /*
                   'QuestionAnswer.Question','QuestionAnswer.Answer',
                    'QuestionAnswer.QuestionImage','QuestionAnswer.Id as qId',  DB::raw('(CASE WHEN (Orders.OrderStatus = 23) THEN 4
                              WHEN (QuestionAnswer.Answer IS NULL AND QuestionAnswer.OrderId IS NOT NULL)  THEN 3
                              #WHEN (Orders.OrderStatus = 10) THEN 2
                              END) AS quest_sort')*/

              /*                     'messages.Message','messages.message_status','messages.created_at as msgTime',
                    'messages.attachment','messages.id as qId',  DB::raw('(CASE
                    WHEN (messages.message_status = "received" and messages.id IS NOT NULL )  THEN 6
                     WHEN (Orders.OrderStatus = 10) THEN 5
                     WHEN (Orders.OrderStatus = 23) THEN 4
                        WHEN (Orders.OrderStatus = 11) THEN 3
                              #WHEN (Orders.OrderStatus = 10) THEN 2
                              END) AS quest_sort')



                  ])
                    //->orderBy('QuestionAnswer.Question','DESC')
                    // ->groupBy('Orders.Rxnumber')
                        ->orderBy('quest_sort', 'DESC')
                        ->orderBy('messages.created_at', 'DESC')
                         ->orderBy('Orders.created_at', 'DESC')
                    //  ->orderBy('Orders.Id','desc')
                         // ->limit(5)
                         //->take(20)
                         ->get();
                     // dump($data['requests']);
// dump(DB::getQueryLog());
       // if($requests)
 if(Request('service') && Request('service') == 21){  */

                         /**
           Order messages thread maintined now messages table so QuestionAnswer is parent and messages is child using foreign key questionId (java team standarrd name) more 2-september-2020 Ken requirement
           */

           /*
                     $genral_question =  QuestionAnswer::join('PatientProfileInfo as p','p.Id','QuestionAnswer.PatientId')
                     ->leftjoin('messages',function($query){
                        $query->on('messages.questionId','QuestionAnswer.Id')
                        ->whereRaw('messages.Id IN (select MAX(a2.Id) from messages as a2 join QuestionAnswer as u2 on u2.Id = a2.questionId group by u2.Id)');
                      })
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
                ->select(['p.Id as p_id','p.Id as Id','p.Practice_ID','messages.created_at as order_created_at','QuestionAnswer.QuestionTime as order_created_at1',
                DB::raw('CONCAT(UPPER(CONVERT(AES_DECRYPT (FROM_BASE64(p.FirstName),"ss20compliance19") USING "utf8")), " ", UPPER(CONVERT(AES_DECRYPT (FROM_BASE64(p.LastName),"ss20compliance19")USING "utf8"))) AS requested_by'),
                 'QuestionAnswer.Question','QuestionAnswer.Answer','QuestionType as orderStatusName',
                    'QuestionAnswer.QuestionImage','QuestionAnswer.Id as qId',
                    //   DB::raw('(CASE
                    //           WHEN (QuestionAnswer.Answer IS NULL AND QuestionAnswer.OrderId IS NOT NULL)  THEN 3
                    //           ELSE 1 END) AS quest_sort')
                              ])
                ->where('QuestionType','General_Question')
                ->where('messages.message_status', "received")
                //  ->orderBy('quest_sort', 'DESC')
                         ->orderBy('QuestionTime','DESC')->get();

// dd($genral_question);
 if(auth::user()->roles[0]->name == 'compliance_admin' ||auth::user()->roles[0]->name == 'practice_admin' || auth::user()->can('practice admin') || auth::user()->roles[0]->name == 'practice_super_group'){
                                  $data['requests_two'] = DB::table('reporter_prescription AS rp')->select(['rp.*', 'us.name as reporter_name',
                                        DB::raw('CONCAT(LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19") USING "utf8")), " ", LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8"))) AS requested_by'),
                                        DB::raw('CONCAT_WS("",d.rx_label_name, " ", d.strength, " ", d.dosage_form) AS rx_label_name'), 'd.brand_reference AS brand_reference', 'rp.quantity AS quantity',
                                        'p.practice_name'])

                            ->join('PatientProfileInfo AS ppi', 'ppi.Id', 'rp.patient_id')
                            ->join('drugs_new AS d', 'd.Id', 'rp.drug_id')
                            ->join('practices AS p', 'p.id', 'rp.practice_id')
                            ->join('users as us','rp.reporter_id','us.id')
                            ->leftjoin('Orders AS o', 'o.reporter_prescription_id', 'rp.id')
                            ->when((Request('type') == 'alternate'),function($query){
                                    $query->where('rp.alternate_drug',"Y");
                            })
                            ->when(!empty($request->all()), function($query) use ($request){
                                   if(Request('keyword')){
                                        $query->where(function($q) use ($request){
                                            $q->orWhereRaw("CONCAT(LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),'ss20compliance19')USING 'utf8')), ' ', LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),'ss20compliance19')USING 'utf8'))) LIKE '%".$request->keyword."%'");
                                        });
                                    }
                                    // if(Request('service') && Request('service') != 26 && Request('service') != 'new_order'){  $query->where('rp.id', null); }
                                    if($request->has('practice_name') and $request->practice_name!='ALL'){
                                        $query->where('rp.practice_id', $request->practice_name);
                                    }
                                    if(Request('from_date')){
                                        if(Request('to_date')==''){ $end_date = Carbon::now()->format('Y-m-d'); }else{  $end_date = Carbon::parse(Request('to_date'))->format('Y-m-d'); }
                                        $start_date = Carbon::parse(Request('from_date'))->format('Y-m-d');
                                        $query->where(DB::raw("DATE_FORMAT(rp.created_at, '%Y-%m-%d')"), '>=', $start_date);
                                        $query->where(DB::raw("DATE_FORMAT(rp.created_at, '%Y-%m-%d')"), '<=', $end_date);
                                    }
                        })->when((isset(auth::user()->practices->first()->id) && auth::user()->practices->first()->id != Null && !auth::user()->hasRole('practice_super_group')  && !Session::has('practice') && !auth::user()->hasRole('super_admin')), function($query){
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
                        ->get();

}

    if(Request('type') != 'alternate'){
        $q1 = collect($data['requests']);
        $q2 = collect($genral_question);
        $data['requests'] = $q1->merge($q2);
    }
}



}

        $orderList = [];
        if((Request('service') == 21 || Request('type') == 'new_order') && isset($data['requests_two'])){
            foreach($data['requests_two'] as $requestData){
                if(!isset($requestData->OrderStatus) || (isset($requestData->OrderStatus) && in_array($requestData->OrderStatus, [2,10,23])))
                    $orderList[] = array($requestData->id,$requestData->patient_id);
            }
        }else if(isset($data['requests'])){
            foreach($data['requests'] as $requestData){
                if(isset($requestData->OrderStatus) && in_array($requestData->OrderStatus, [2,10,23]))
                    $orderList[] = array($requestData->order_id,$requestData->p_id);
            }
        }
        $data['all_order_list'] = json_encode($orderList,1);  */

        return view('practice_module.patient_order_request.all_requests',$data);

     }



     public function orders_listing(Request $request,$id=0)
     {
        ini_set('memory_limit',-1);
        $pat = null;
        $genral_question=new Collection();
        $new_orders=new Collection();
        $genral_question_count=0;
        if(isset(auth::user()->practices->first()->id) && auth::user()->practices->first()->id != Null && !auth::user()->hasRole('practice_super_group') && Request('service') == 'pat')
          $pat = Patient::whereIn('Practice_ID',auth::user()->practices->pluck('id'))->where('created_at','>=', Carbon::now()->subDay())->pluck('Id');
        parse_str($request->getContent(), $arr);
        $columnName=null;
        $columnSortOrder=null;
        if(isset($arr['order']))
        {
          $columnIndex = $arr['order'][0]['column']; // Column index
       
          $columnName = $arr['columns'][$columnIndex]['data']; // Column name

          $columnSortOrder = $arr['order'][0]['dir']; // asc or desc
        }
        $orders = Order::join('PatientProfileInfo', 'PatientProfileInfo.Id', 'Orders.PatientId')
            
            ->leftjoin('messages',function($query){
              $query->on('messages.OrderId','Orders.Id')
              ->whereRaw('messages.Id IN (select MAX(a2.Id) from messages as a2 join Orders as u2 on u2.Id = a2.OrderId WHERE a2.message_type != "HCP" group by u2.Id)');
            })
            ->join('drugs_new', 'drugs_new.id', 'Orders.DrugDetailId')
            ->join('OrderStatus', 'Orders.OrderStatus', 'OrderStatus.Id')
            ->join('practices', 'practices.id', 'Orders.PracticeId')
            ->when(Session::has('practice') , function($query){
                  $query->where('Orders.PracticeId', Session::get('practice')->id);
            })
            ->when(auth::user()->hasRole('practice_super_group'),function($query){
                $query->whereIn('Orders.PracticeId',auth::user()->practices->pluck('id'));
            })
            ->when($request->pId ,function($query) use ($request){
                $query->where('Orders.PatientId',$request->pId);
            })
            ->when((isset(auth::user()->practices->first()->id) && auth::user()->practices->first()->id != Null && !Session::has('practice') && !auth::user()->hasRole('super_admin') && !auth::user()->hasRole('practice_super_group')), function($query){
                          $query->whereIn('Orders.PracticeId', auth::user()->practices->pluck('id'));
                  })
            ->when((auth::user()->hasRole('super_admin')), function ($query) {
  
                      return $query->where(function ($query) {
                          $query->whereIn('Orders.PracticeId', Practice::whereIn('id',auth::user()->practices->pluck('id'))->orWhereIn('parent_id', auth::user()->practices->pluck('id'))->pluck('id')->all());
                      });
                  })
            ->when(!empty($request->all()), function($query) use ($request,$pat){
  
                if(Request('practice_name') && Request('practice_name') !="ALL"){ $query->where('Orders.PracticeId', Request('practice_name')); }
  
                if(Request('service') && Request('service') != 26 && Request('service') != 21 && Request('service') != 'pat'){  
                  $query->where('Orders.OrderStatus', Request('service')); 
                }
                if(Request('service') && Request('service') == 21){
  
                   
  
                      $query->where('messages.message_status','received');
                    $query->whereNotNull('messages.id');
                }
  
                if(Request('service') && Request('service') == 'pat' && isset($pat)){
  
                    $query->whereIn('Orders.PatientId',$pat);
  
                }
  
                if(Request('keyword')){
                  $query->where(function($q) use ($request){
                    $q->where('Orders.RxNumber','LIKE', "%$request->keyword%");
                  
                    $q->orWhereRaw("CONCAT(LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(PatientProfileInfo.FirstName),'ss20compliance19')USING 'utf8')), ' ', LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(PatientProfileInfo.LastName),'ss20compliance19')USING 'utf8'))) LIKE '%".$request->keyword."%'");
                    
                });
  
                }
                if(Request('from_date')){
                  if(Request('to_date')==''){ $to_date = date('m/d/Y'); }else{  $to_date = Request('to_date');  }
                  $query->whereBetween(DB::raw('DATE_FORMAT(Orders.created_at, "%m/%d/%Y")'), array(Request('from_date'), $to_date));
  
                    }
                  })
              ->select(['practices.parent_id AS parent_id','practices.id as PracticeId','practices.branch_name AS branch_name','practices.practice_name AS p_name','PatientProfileInfo.Id as p_id', 'Orders.Quantity', 'Orders.Id as order_id','Orders.asistantAuth','Orders.OrderType','Orders.OrderStatus',
                     'Orders.created_at as order_created_at', 'PatientProfileInfo.*',
                      DB::raw('CONCAT(UPPER(CONVERT(AES_DECRYPT (FROM_BASE64(PatientProfileInfo.FirstName),"ss20compliance19") USING "utf8")), " ", UPPER(CONVERT(AES_DECRYPT (FROM_BASE64(PatientProfileInfo.LastName),"ss20compliance19")USING "utf8"))) AS requested_by'),
                      'drugs_new.*', 'OrderStatus.Name as orderStatusName', 'Orders.Strength as strength', 'Orders.DrugType as dosage_form',
                       DB::raw('case when Orders.RefillCount < 9 then concat(Orders.Rxnumber,"-0",Orders.RefillCount) else concat(Orders.Rxnumber,"-",Orders.RefillCount) end as RxNumber'),
                      'messages.Message','messages.message_status',
                      'messages.attachment','messages.id as qId',  DB::raw('(CASE
                      WHEN (messages.message_status = "received" and messages.id IS NOT NULL )  THEN 6
                       WHEN (Orders.OrderStatus = 10) THEN 5
                       WHEN (Orders.OrderStatus = 23) THEN 4
                          WHEN (Orders.OrderStatus = 11) THEN 3
                                #WHEN (Orders.OrderStatus = 10) THEN 2
                                END) AS quest_sort'),'messages.created_at as msgTime'
     ])
                    ->when(isset($columnName) && isset($columnSortOrder),function($query) use($columnName,$columnSortOrder){
                      if($columnName!="reporter_name"){
                        $query->orderBy($columnName,$columnSortOrder);
                      }
                    })
                    ->when((empty($request->all()) || Request('service') == 26) ,function($query){
                    	$query->where('Orders.OrderStatus','!=',29);
                    })
                    ->orderBy('quest_sort', 'DESC')
                    ->orderBy('messages.created_at', 'DESC')
                    ->orderBy('Orders.created_at', 'DESC')
                    // ->offset($arr['start'])->limit($arr['length'])
                    ->get();
  
       
          // General Question
  
        // if(Request('service') && Request('service') == 21 && count($orders)  < $arr['length']){
         if(Request('service') && Request('service') == 21 ){
  
          $genral_question =  QuestionAnswer::join('PatientProfileInfo as p','p.Id','QuestionAnswer.PatientId')
             ->leftjoin('messages',function($query){
                  $query->on('messages.questionId','QuestionAnswer.Id')
                          ->whereRaw('messages.Id IN (select MAX(a2.Id) from messages as a2 join QuestionAnswer as u2 on u2.Id = a2.questionId WHERE a2.message_type != "HCP" group by u2.Id)');
              })
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
              ->select(['p.Id as p_id','p.Id as Id','p.Practice_ID','QuestionAnswer.QuestionTime as order_created_at1',
                'messages.created_at as order_created_at',
                  DB::raw('CONCAT(UPPER(CONVERT(AES_DECRYPT (FROM_BASE64(p.FirstName),"ss20compliance19") USING "utf8")), " ", UPPER(CONVERT(AES_DECRYPT (FROM_BASE64(p.LastName),"ss20compliance19")USING "utf8"))) AS requested_by'),
                   'QuestionAnswer.Question','QuestionAnswer.Answer','QuestionType as orderStatusName',
                      'QuestionAnswer.QuestionImage','QuestionAnswer.Id as qId','messages.message_status as message_status'])
                  ->where('QuestionType','General_Question')
                  ->where('messages.message_status', "received")
                  ->when(($columnName=="order_created_at" || $columnName=="orderStatusName" || $columnName=="requested_by" || $columnName=="Message"),function($query) use($columnName,$columnSortOrder){
                      $query->orderBy($columnName,$columnSortOrder);
                    })
                  ->orderBy('QuestionTime','DESC')
                  // ->when((($arr['start'] - $totalFiltered) > 0), function ($query) use ($arr,$totalFiltered,$orders){
                  //     return $query->offset($arr['start'] - $totalFiltered)->limit($arr['length']-count($orders));
                  // }, function ($query) use ($arr,$orders){
                  //     return $query->offset(0)->limit($arr['length']-count($orders));
                  // })
                  
                  ->get();
          }
  
  
  
  
          // New HCP Order
          $renewel = [];
          if(Request('service') && Request('service') == 21 && (auth::user()->roles[0]->name == 'compliance_admin' || auth::user()->roles[0]->name == 'practice_admin' || auth::user()->can('practice admin') || auth::user()->roles[0]->name == 'practice_super_group')){
              $new_orders= DB::table('reporter_prescription AS rp')->select(['rp.*', 'us.name as reporter_name',
                      DB::raw('CONCAT(LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19") USING "utf8")), " ", LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8"))) AS requested_by'),
                      DB::raw('CONCAT_WS("",d.rx_label_name, " ", d.strength, " ", d.dosage_form) AS rx_label_name'), 'd.brand_reference AS brand_reference', 'rp.quantity AS quantity',
                      'p.practice_name'])
  
              ->join('PatientProfileInfo AS ppi', 'ppi.Id', 'rp.patient_id')
              ->join('drugs_new AS d', 'd.Id', 'rp.drug_id')
              ->join('practices AS p', 'p.id', 'rp.practice_id')
              ->join('users as us','rp.reporter_id','us.id')
              ->leftjoin('Orders AS o', 'o.reporter_prescription_id', 'rp.id')
              ->when((Request('type') == 'alternate'),function($query){
                      $query->where('rp.alternate_drug',"Y");
              })
              ->when(!empty($request->all()), function($query) use ($request){
                   if(Request('keyword')){
                        $query->where(function($q) use ($request){
                            $q->orWhereRaw("CONCAT(LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),'ss20compliance19')USING 'utf8')), ' ', LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),'ss20compliance19')USING 'utf8'))) LIKE '%".$request->keyword."%'");
                        });
                    }
                  
                    if($request->has('practice_name') and $request->practice_name!='ALL'){
                        $query->where('rp.practice_id', $request->practice_name);
                    }
                    if(Request('from_date')){
                        if(Request('to_date')==''){ $end_date = Carbon::now()->format('Y-m-d'); }else{  $end_date = Carbon::parse(Request('to_date'))->format('Y-m-d'); }
                        $start_date = Carbon::parse(Request('from_date'))->format('Y-m-d');
                        $query->where(DB::raw("DATE_FORMAT(rp.created_at, '%Y-%m-%d')"), '>=', $start_date);
                        $query->where(DB::raw("DATE_FORMAT(rp.created_at, '%Y-%m-%d')"), '<=', $end_date);
                }
              })
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
            ->when(($columnName=="requested_by" || $columnName=="rx_label_name" || $columnName=="brand_reference" || $columnName=="Quantity" || $columnName=="reporter_name"),function($query) use($columnName,$columnSortOrder){
                      $query->orderBy($columnName,$columnSortOrder);
                    })
            ->orderBy('rp.created_at', 'DESC')
            ->get();



            $renewel = DB::table('renewal_prescription AS ren_pre')
            ->select(['ren_pre.*','practices.parent_id AS parent_id','practices.id as PracticeId','practices.branch_name AS branch_name','practices.practice_name AS p_name','PatientProfileInfo.Id as p_id', 'Orders.Quantity', 
            'Orders.Id as order_id','Orders.asistantAuth','Orders.OrderType','Orders.OrderStatus',
            'Orders.created_at as order_created_at', 'PatientProfileInfo.*',
             DB::raw('CONCAT(UPPER(CONVERT(AES_DECRYPT (FROM_BASE64(PatientProfileInfo.FirstName),"ss20compliance19") USING "utf8")), " ", UPPER(CONVERT(AES_DECRYPT (FROM_BASE64(PatientProfileInfo.LastName),"ss20compliance19")USING "utf8"))) AS requested_by'),
             DB::raw('AES_DECRYPT (FROM_BASE64(PatientProfileInfo.MobileNumber),"ss20compliance19") AS MobileNumber'),
             DB::raw('DATE_FORMAT(AES_DECRYPT (FROM_BASE64(PatientProfileInfo.BirthDate),"ss20compliance19"),"%m/%d/%Y") AS BirthDate'),
             'drugs_new.*', 'OrderStatus.Name as orderStatusName', 'Orders.Strength as strength', 'Orders.DrugType as dosage_form',
              DB::raw('case when Orders.RefillCount < 9 then concat(Orders.Rxnumber,"-0",Orders.RefillCount) else concat(Orders.Rxnumber,"-",Orders.RefillCount) end as RxNumber'),
             'messages.Message','messages.message_status',
             'PrescriberName','PrescriberPhone',
             'messages.attachment','messages.id as qId',  DB::raw('(CASE
             WHEN (messages.message_status = "received" and messages.id IS NOT NULL )  THEN 6
              WHEN (Orders.OrderStatus = 10) THEN 5
              WHEN (Orders.OrderStatus = 23) THEN 4
                 WHEN (Orders.OrderStatus = 11) THEN 3
                       #WHEN (Orders.OrderStatus = 10) THEN 2
                       END) AS quest_sort'),'messages.created_at as msgTime',
                       'Orders.nextRefillDate'
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
    ->get();

          }
          $q0 = collect($renewel);
          $q1 = collect($orders);
          $q2 = collect($genral_question);
          $q3=collect($new_orders);
          $all_orders0 = $q0->merge($q1);
          $all_orders = $all_orders0->merge($q2);
  
          $all_orders=$all_orders->merge($q3);
         // $all_orders1 = $all_orders->forPage($arr['draw'], $arr['length']);
          $all_orders1=$this->paginate($all_orders,$arr['length'],($arr['start']/$arr['length'])+1);
  
          $totalFiltered1=count($orders)+count($genral_question)+count($new_orders)+count($renewel);
  
          $orderList = [];
          $new_order_list=[];
          if(isset($all_orders1)){
              foreach($all_orders1 as $requestData){
                  if(isset($requestData->OrderStatus) && in_array($requestData->OrderStatus, [2,10,23]))
                  {
                      $orderList[] = array($requestData->order_id,$requestData->p_id);
                  }
                  if(!isset($requestData->OrderStatus)  )
                  {
                    if(!isset($requestData->orderStatusName) and isset($requestData->patient_id))
                    {
                      $new_order_list[] = array($requestData->id,$requestData->patient_id);
                    }    
                  }  
              }
          }
          $all_order_list_ids =$orderList;
            if ($all_orders1)
            {
              return response()->json(['message' => "done", "orders" => $all_orders1->values(), "status" => true, 'length' => $arr['length'], 'recordsFiltered' => $totalFiltered1, 'draw' => intval($arr['draw']), 'start' => $arr['start'], 'all' => $arr,'all_order_list_ids'=>$all_order_list_ids,'new_order_list'=>$new_order_list], 200);
              // return response()->json(['message' => "done", "orders" => $all_orders1->data\\, "status" => true, 'length' => $all_orders1->per_page['length'], 'recordsFiltered' => $all_orders1->total, 'draw' => intval($arr['draw']), 'start' => $arr['start'], 'all' => $arr], 200);
            }
  
                
     }
     public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
      $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
      $items = $items instanceof Collection ? $items : Collection::make($items);
      return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function specificPatientOrders($id){

        // DB::enableQueryLog();

$orders = Order::where('Orders.PatientId',$id)
                    ->join(DB::Raw('(SELECT Id, RxNumber, MIN(RefillsRemaining) AS RefillRemain,MAX(created_at) AS cre FROM Orders where OrderStatus = 8 GROUP BY RxNumber) AS my_tables'), function($query){
                        $query->on('my_tables.RxNumber','Orders.RxNumber')
                                ->on('my_tables.cre', 'Orders.created_at');
                    })
                    ->join('practices','Orders.PracticeId','practices.id')
                    ->join('drugs_new','Orders.DrugDetailId','drugs_new.id')
                    ->join('PatientProfileInfo','PatientProfileInfo.Id','Orders.PatientId')
                    ->join('OrderStatus', 'Orders.OrderStatus', 'OrderStatus.Id')

                           /**
           Order messages thread maintined now messages table so QuestionAnswer is using no more 6-7-2020 Ken requirement
           */

       /*   ->leftJoin('QuestionAnswer',function($query){
            $query->on('QuestionAnswer.OrderId','Orders.Id')
            ->whereRaw('QuestionAnswer.Id IN (select MAX(a2.Id) from QuestionAnswer as a2 join Orders as u2 on u2.Id = a2.OrderId group by u2.Id)');
        })*/
          ->leftjoin('messages',function($query){
            $query->on('messages.OrderId','Orders.Id')
            ->whereRaw('messages.Id IN (select MAX(a2.Id) from messages as a2 join Orders as u2 on u2.Id = a2.OrderId WHERE a2.message_type = "Pharmacy" group by u2.Id)');
          })
                    ->leftjoin('ComplianceRewardPoint','ComplianceRewardPoint.RewardId','Orders.Cr_Point_Id')
                    ->select('PatientProfileInfo.*','PatientProfileInfo.Id as p_id','Orders.*',
                    DB::raw('CONCAT(UPPER(CONVERT(AES_DECRYPT (FROM_BASE64(PatientProfileInfo.FirstName),"ss20compliance19") USING "utf8")), " ", UPPER(CONVERT(AES_DECRYPT (FROM_BASE64(PatientProfileInfo.LastName),"ss20compliance19")USING "utf8"))) AS requested_by'),
                    DB::raw('case when Orders.RefillCount < 9 then concat(Orders.Rxnumber,"-0",Orders.RefillCount) else concat(Orders.Rxnumber,"-",Orders.RefillCount) end as RxNumber'),'Orders.RxNumber AS sRxNumber',
                            'Orders.Id as order_id','Orders.created_at as order_created_at','Orders.OrderStatus',
                            'OrderStatus.Name as orderStatusName','practices.practice_name AS p_name',
                            'practices.*','ComplianceRewardPoint.*' ,'drugs_new.*',

                              /**
           Order messages thread maintined now messages table so QuestionAnswer is using no more 6-7-2020 Ken requirement
           */


                         //   'QuestionAnswer.Question','QuestionAnswer.Answer','QuestionAnswer.Id as qId','QuestionAnswer.QuestionImage',


                             'messages.Message','messages.message_status', 'messages.attachment','messages.id as qId',
                            DB::raw('(CASE WHEN Orders.RefillsRemaining > 0 AND Orders.OrderStatus = 8 THEN "yes"
                               ELSE "no" END ) AS refillable
                       '),
                           DB::raw('(CASE
                    WHEN (messages.message_status = "received" and messages.id IS NOT NULL )  THEN 6
                     WHEN (Orders.OrderStatus = 8) THEN 5
                              END) AS quest_sort'),
                           DB::raw('((SELECT SUM(DATEDIFF(nOd.service_date, nOd.nextRefillDateOfPreviousOrder))
                                    FROM Orders AS nOd WHERE nOd.RxNumber=Orders.RxNumber))
                                     AS total_delay_in_days'),
                           DB::raw('((SELECT COUNT(*)
                                    FROM Orders AS nOd1 WHERE nOd1.RxNumber=Orders.RxNumber))
                                     AS OC')
)
                    ->where('Orders.OrderStatus',8)
                    // ->where('Orders.RefillsRemaining','!=',0)
                            //->whereRaw('Orders.Id IN (select MIN(Id) FROM Orders GROUP BY RxNumber ORDER BY Id desc)')
                    //   ->from(DB::raw('(SELECT * FROM Orders as oo2 ORDER BY oo2.created_at DESC) t'))
                            //   DB::raw('(CASE WHEN (QuestionAnswer.Answer IS NULL AND QuestionAnswer.OrderId IS NOT NULL)  THEN 3
                            //   WHEN (QuestionAnswer.Answer IS NOT NULL AND QuestionAnswer.OrderId IS NOT NULL) THEN 2
                            //   ELSE 1 END) AS quest_sort')
        // ->orderBy(DB::raw('qId IS NULL, qId'), 'asc')
        // ->groupBy('t.Rxnumber')

                        ->orderBy('quest_sort', 'DESC')
                         ->orderBy('Orders.created_at', 'DESC')
                        //  ->distinct('Orders.RxNumber')
                        ->get();
               
                         $orders->filter(function($value, $key){
                             $last_due=Order::select(DB::raw('DATEDIFF(CURDATE(),DATE_FORMAT(Orders.nextRefillDate,"%Y-%m-%d")) AS ls_dl'))
                             ->where('Orders.RefillsRemaining','!=',0)
                             ->whereRaw('Orders.RefillsRemaining = (SELECT MIN(o2.RefillsRemaining) FROM Orders AS o2 WHERE o2.RxNumber="'.$value->sRxNumber.'" )')
                            ->where('Orders.RxNumber',$value->sRxNumber)->first();
                         
                            if($last_due){
                              $value->total_delay_in_days=$value->total_delay_in_days +$last_due->ls_dl;

                            }
                         
                         });
                     
               
                        $queries = DB::getQueryLog();
// dump($queries);
                    $states=DB::table('State')->get();
                    $aler_count =DB::table('PatientAllergies')->where('PatientId',$id)->count();
                    $patient = Patient::find($id);
                    // if($orders && count($orders) > 0)
                    return view('practice_module.patient_order_request.specific_patient_orders',compact('patient','orders','states','aler_count'));

}


 public function specificPatientOrders_backup($id){

        // DB::enableQueryLog();

$orders = Order::where('Orders.PatientId',$id)->join('practices','Orders.PracticeId','practices.id')
->join('drugs_new','Orders.DrugDetailId','drugs_new.id')
->join('PatientProfileInfo','PatientProfileInfo.Id','Orders.PatientId')
->join('OrderStatus', 'Orders.OrderStatus', 'OrderStatus.Id')
->leftJoin('QuestionAnswer',function($query){
    $query->on('QuestionAnswer.OrderId','Orders.Id')
    ->whereRaw('QuestionAnswer.Id IN (select MAX(a2.Id) from QuestionAnswer as a2 join Orders as u2 on u2.Id = a2.OrderId group by u2.Id)');
})
->leftjoin('ComplianceRewardPoint','ComplianceRewardPoint.RewardId','Orders.Cr_Point_Id')
->select('PatientProfileInfo.*','PatientProfileInfo.Id as p_id','Orders.*',DB::raw('case when Orders.RefillCount < 9 then concat(Orders.Rxnumber,"-0",Orders.RefillCount) else concat(Orders.Rxnumber,"-",Orders.RefillCount) end as RxNumber'),'drugs_new.*','Orders.Id as order_id','Orders.created_at as order_created_at','Orders.OrderStatus',
'OrderStatus.Name as orderStatusName','practices.practice_name AS p_name',
        'practices.*','ComplianceRewardPoint.*' ,'QuestionAnswer.Question','QuestionAnswer.Answer','QuestionAnswer.Id as qId','QuestionAnswer.QuestionImage',
        DB::raw('(CASE WHEN (QuestionAnswer.Answer IS NULL AND QuestionAnswer.OrderId IS NOT NULL)  THEN 3
                              ELSE 1 END) AS quest_sort'),
                              DB::raw('  (CASE WHEN
                              (SELECT (
                               CASE WHEN o2.Id=Orders.Id AND o2.RefillsRemaining > 0 AND o2.OrderStatus = 8 THEN 1
                               ELSE 0 END )
                               FROM Orders AS o2 WHERE o2.RxNumber = `Orders`.`RxNumber` ORDER BY o2.RefillsRemaining ASC LIMIT 1 ) > 0 THEN "yes"

                                                ELSE "no" END  ) AS refillable
                       '))->whereRaw('Orders.Id IN (select MIN(Id) FROM Orders GROUP BY RxNumber ORDER BY Id desc)')
                    //   ->from(DB::raw('(SELECT * FROM Orders as oo2 ORDER BY oo2.created_at DESC) t'))
                            //   DB::raw('(CASE WHEN (QuestionAnswer.Answer IS NULL AND QuestionAnswer.OrderId IS NOT NULL)  THEN 3
                            //   WHEN (QuestionAnswer.Answer IS NOT NULL AND QuestionAnswer.OrderId IS NOT NULL) THEN 2
                            //   ELSE 1 END) AS quest_sort')
        // ->orderBy(DB::raw('qId IS NULL, qId'), 'asc')
        // ->groupBy('t.Rxnumber')

                         ->orderBy('quest_sort', 'DESC')
                         ->orderBy('Orders.created_at', 'DESC')
                        //  ->distinct('Orders.RxNumber')
                         ->get();
                          $queries = DB::getQueryLog();
// dump($queries);
$states=DB::table('State')->get();
$aler_count =DB::table('PatientAllergies')->where('PatientId',$id)->count();
if($orders && count($orders) > 0)
return view('practice_module.patient_order_request.specific_patient_orders',compact('orders','states','aler_count'));
else
return redirect()->back()->with('message',"No Patient Profile Found");
}
/*


*/
    public function getPatineInfo(Request $request){
//        dd($request->all());
        $type = $request->checkType;
        $patient_id = $request->patient_id;
        if($type == 'email_phone'){
            $patient = DB::table('PatientProfileInfo')->where('Id',$patient_id)->first();
            $result = [];
            if($patient){
                $result['mobile_number'] = decrypted_attr($patient->MobileNumber);
                $result['email'] = decrypted_attr($patient->EmailAddress);
//                dd($result,$patient->MobileNumber,$patient->EmailAddress);
                return response()->json(['status'=>200, 'data' => $result]);
            }else{
                return response()->json(['status'=>400, 'data' => $result]);
            }
        }
        else if($type == 'address'){
            $patient = DB::table('PatientProfileInfo')->where('Id',$patient_id)->first();
            $result = [];
            if($patient){
//               $state = DB::table('State')->where('Id',$patient->State)->first();
                $result['address'] =$patient->Address;
                $result['City'] =$patient->City;
                $result['state'] =$patient->State;
                $result['zipCode'] =$patient->ZipCode;
                return response()->json(['status'=>200, 'data' => $result]);
            }else{
                return response()->json(['status'=>400, 'data' => $result]);
            }
        }
        else if($type == 'allergies'){
            $patients = DB::table('PatientAllergies')->where('PatientId',$patient_id)->get();
            $result = [];
            if($patients){
                $result = $patients;
                return response()->json(['status'=>200, 'data' => $result]);
            }else{
                return response()->json(['status'=>400, 'data' => $result]);
            }
        }
        else if($type == 'insurance_cards'){

            // $patients = DB::table('PatientInsuranceDetails')->where('PatientId',$patient_id)->get();
             $patients = DB::table('PatientInsuranceDetails')->where('PatientId',$patient_id)
            ->select('Id','PatientId',DB::raw('AES_DECRYPT (FROM_BASE64(InsuranceFrontCardPath),"ss20compliance19") AS InsuranceFrontCardPath'),DB::raw('AES_DECRYPT (FROM_BASE64(InsuranceBackCardPath),"ss20compliance19") AS InsuranceBackCardPath'))
            ->orderBy('Id','DESC')
            ->get();
            // dd($patients);
            $result = $patients;
            if($patients){
                $result = $patients;
                return response()->json(['status'=>200, 'data' => $result]);
            }else{
                return response()->json(['status'=>400, 'data' => $result]);
            }
        }
    }

    public function updatePatientInfo(Request $request){
        $type = $request->type;
        if(isset($request->patient_id))
        {
            $patient_id = $request->patient_id;
        }

        if($type == 'email_phone'){
            $patinet = Patient::find($patient_id);
            if($request->new_email != ''){
                $patinet->EmailAddress = $request->new_email;
            }
            if($request->new_phone != ''){
                $patinet->MobileNumber = $request->new_phone;
            }
            $patinet->update();
            return response()->json(['status'=>200,'data'=>'Patient info updated successfully']);
        }
        else if($type == 'address'){
            $patinet = Patient::find($patient_id);
            if($request->new_address != ''){
                $patinet->Address = $request->new_address;
            }
            if($request->new_city != ''){
                $patinet->City = $request->new_city;
            }
            if($request->new_zip != ''){
                $patinet->ZipCode = $request->new_zip;
            }
            if($request->new_state != ''){
                $patinet->State = $request->new_state;
            }
            $patinet->update();
            return response()->json(['status'=>200,'data'=>'Patient address updated successfully']);
        }
        else if($type == 'allergis'){
            // $patients = DB::table('PatientAllergies')->where('PatientId',$patient_id)->get();
            // if(count($patients) > 0 ){
            //     foreach ($patients as $key => $patient){
            //         DB::table('PatientAllergies')->where('Id', $patient->Id)->update(['Allergies' => $request['alleriesArray'][$key]]);
            //     }
            // }else{
            //     $allergy_array = array();
            //     $allergy_array['Allergies']= $request['alleriesArray'][0];
            //     $allergy_array['PatientId']   = $patient_id;
            //     $query_insert = DB::table('PatientAllergies')->insert($allergy_array);
            // }
            // return response()->json(['status'=>200,'data'=>'Allergies updated successfully']);
          // $patients = DB::table('PatientAllergies')->where('PatientId',$patient_id)->get();

            if(!isset($request['aler_id']))
            {
              $allergy_array = array();
              $allergy_array['Allergies']= $request['alleriesArray'][0];
              $allergy_array['PatientId']   = $patient_id;
              $query_insert = DB::table('PatientAllergies')->insertGetId($allergy_array);

              return response()->json(['status'=>200,'data'=>'Allergy added successfully','id'=>$query_insert]);
            }else{
              // DB::table('PatientAllergies')->where('Id', $request['alleriesArray'][1])->update(['Allergies' => $request['alleriesArray'][0]]);
                DB::table('PatientAllergies')->where('Id', $request['aler_id'])->delete();
                return response()->json(['status'=>200,'data'=>'Allergy deleted successfully']);
            }

        }
        else if($type == 'insurance_cards'){
            $patients = DB::table('PatientInsuranceDetails')->where('PatientId',$patient_id)->get();
            // dd($patients);
            return response()->json(['status'=>200,'data'=>'Allergies updated successfully']);
        }
    }

    public function patient_request($id=0){
//        dd('fucking this');

        $requests = Order::where('PracticeId', auth::user()->practices->first()->id)
            ->join('PatientProfileInfo', 'PatientProfileInfo.Id', 'Orders.PatientId')
            ->join('drugs_new', 'drugs_new.id', 'Orders.DrugDetailID')
            ->join('OrderStatus', 'Orders.OrderStatus', 'OrderStatus.Id')
            ->when($id !== 0 ,function($query) use ($id){
                $query->where('Orders.PatientId',$id);
            })
            ->select(['Orders.*', 'Orders.Id as order_id', 'Orders.created_at as order_created_at', 'PatientProfileInfo.*','drugs_new.*', 'OrderStatus.Name as orderStatusName'])
            ->get();

//              dd($requests->Practice_Name);
        if($requests)
//        dd('in if');
            return view('patient_module.patient_request.patient_request',compact('requests'));
    }
    public function orderAnswer(Request $request)
    {

      if($request->ajax())
      {

        $ques_ans=QuestionAnswer::find($request->qId);
        $ques_ans->Answer=$request->ans;
        $result=$ques_ans->save();
        if(isset($request->pId)){
          $patient = Patient::where('Id',$request->pId)->with('enrollment')->get();
          if($patient[0]->enrollment->enrollment_status == 'Enrolled')
          {
            $notification = $this->sendNotificationAnswerAlert($request->qId, $request->pId);
            $notification = json_decode($notification);

          }
          return response()->json(['status'=>200,'data'=>$result,'id'=>$request->qId,'notification'=>$notification]);
        }

      }

    }
    public function saveCardImage(Request $request)
    {

      if($request->id)
      {
        $ins_detail=new PatientInsuranceDetail;
        $ins_detail->PatientId=$request->id;
      }
      // if($request->insId)
      // {
      //   $ins_detail=PatientInsuranceDetail::where(['Id'=>$request->insId])->first();

      // }

      if($request->hasFile('card1'))
      {
        $image1=$request->file('card1');
        $newPath1=rand().time().'.'.$image1->getClientOriginalExtension();
        $f1=Storage::disk('public')->putFileAs('cards', $image1,$newPath1);
        $ins_detail->InsuranceFrontCardPath='storage/'.$f1;
        // $data['InsuranceFrontCardPath']=$ins_detail->InsuranceFrontCardPath;
      }
      if($request->hasFile('card2'))
      {
        $image2=$request->file('card2');
        $newPath2=rand().time().'.'.$image2->getClientOriginalExtension();
        $f2=Storage::disk('public')->putFileAs('cards', $image2,$newPath2);
        $ins_detail->InsuranceBackCardPath='storage/'.$f2;
        // $data['InsuranceBackCardPath']=$ins_detail->InsuranceBackCardPath;
      }


      // $image1->move(public_path('cards'),$newPath1);
      // $image2->move(public_path('cards'),$newPath2);

      // $ins_detail=new PatientInsuranceDetail;
      // $ins_detail->PatientId=$request->id;
      // $ins_detail->InsuranceFrontCardPath='cards/'.$newPath1;
      // $ins_detail->InsuranceBackCardPath='cards/'.$newPath2;
      // $ins_detail->save();

      //using local storage/app
      //$p=$image1->store('avatars'); file name automatic genrated and return in $p
      //dd($p); avatars/atomated file

      //using local disk storage/app
      // $p=$image1->storeAs('avatars', $newPath1);


      // using public disk storage/app/public





      // if($request->insId)
      // {
      //   $status=$update_ins->update($data);
      // }else if($request->id){
         $status=$ins_detail->save();
      // }
      if($status)
      {
        return response()->json(['status'=>200,'data'=>'Insurance card successfully added']);
      }else{
        return response()->json(['status'=>400, 'data' => 'Insurance card not added']);
      }



    }

    public function getPresName(Request $request)
    {
      if($request->q)
      {
         $data=[];
        $i=0;
        // $pnames=Prescriber::where('Name','LIKE',"%$request->name%")->get();

        $pnames=Practice::where('practice_name','LIKE',"%$request->q%")
        ->where('practice_type','Physician')->orderBy(DB::raw('!ISNULL(added_from_pharmacy), added_from_pharmacy'), 'desc')->get();

        foreach ($pnames as $value) {
             // $data[]=['id'=>$value['id'],'text'=>$value['Name']];
          if($value->added_from_pharmacy != 1){
            $data[]=['value'=>$value['id'],'text'=>$value['practice_name'].'  *'];
          }else{
             $data[]=['value'=>$value['id'],'text'=>$value['practice_name']];
          }

        }
        return response()->json(['formatPresName'=>$data,'pres_names'=>$pnames]);

      }
    }

    function deleteCard(Request $request)
    {

        $recordDel=PatientInsuranceDetail::find($request->id);
        // storage/app/public
        // Storage::disk('public')->delete('cards/national prc user.png');
        //because 'storage' coming form db, therefore use public_path best way is above code
        unlink(public_path($recordDel->InsuranceFrontCardPath));
        unlink(public_path($recordDel->InsuranceBackCardPath));
        $status=$recordDel->delete();
        return response()->json(['status'=>$status],200);

    }

    function editOrder(Request $request)
    {
       $order = Order::where('Orders.Id',$request->order_id)
                 ->join('PatientProfileInfo as p','p.Id','Orders.PatientId')
                 ->join('drugs_new', 'drugs_new.id', 'Orders.DrugDetailId')
                 ->join('OrderStatus','Orders.OrderStatus','OrderStatus.Id')
                 ->leftjoin('messages',function($q){
                     $q->on('Orders.Id','messages.OrderId');
                     $q->where('messages.message_type','!=','HCP');
                 })
                 ->leftjoin('practices','Orders.prescriber_id','practices.id')
                 ->select([DB::raw('AES_DECRYPT (FROM_BASE64(p.MobileNumber),"ss20compliance19") AS MobileNumber'),
                 DB::raw('CONCAT(LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(p.FirstName),"ss20compliance19") USING "utf8")), " ", LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(p.LastName),"ss20compliance19")USING "utf8"))) AS requested_by'),
                 DB::raw('AES_DECRYPT (FROM_BASE64(p.BirthDate),"ss20compliance19") AS BirthDate'),
                 DB::raw('(SELECT practice_name from practices where id=Orders.PracticeId  LIMIT 1) AS practiceName'),
                //  DB::raw('(SELECT count(1) from pip_patient_cases where patient_id = p.Id  LIMIT 1) AS is_pip_patient'),
                DB::raw('(case when p.is_pip_patient = "Y" then 1 else 0 end) AS is_pip_patient'), 
      'p.Gender','Orders.*','drugs_new.*','Orders.RxNumber','Orders.Strength','OrderStatus.Id as Status_Id','OrderStatus.Name as Status_Name','messages.Message','messages.message_status','messages.created_at as message_create','messages.attachment',DB::raw("case when practices.added_from_pharmacy IS NULL then concat(practices.practice_name,' *') else practices.practice_name END as PrescriberName")])
                //   ->where('messages.message_type','!=','HCP')
                  ->get();
                        
        $history = Order::with("statuslogs")->where("RxNumber", "LIKE", $order[0]->RxNumber)                  
            ->select(['Orders.Id','Orders.service_date', 'Orders.Quantity', 'Orders.DaysSupply', 'Orders.RxIngredientPrice', 'Orders.RxThirdPartyPay', 'Orders.asistantAuth', 'Orders.RxPatientOutOfPocket', 'Orders.RxFinalCollect'])
            ->orderBy("Orders.service_date", "Desc")
            ->get();
        
        $activities = DB::table("ActivitiesHistory")->where("Rx_Number", "LIKE", $order[0]->RxNumber)->get();         
       //$order[0]->original_rx_date = @Order::where("RxNumber", "LIKE", $order[0]->RxNumber)->where("id", "!=", $request->order_id)->OrderBy("id")->first()->RxOrigDate;
        $barCode='';
        $barCode1='';
        if($order[0]->OrderStatus == 8){
                           $barCode = \DNS1D::getBarcodeHTML($order[0]->Id, 'I25');
                            $barCode1 = \DNS2D::getBarcodeHTML($order[0]->Id, 'QRCODE',3,3);


        }

        if(isset($order[0]->rx_label_name) && !empty($order[0]->rx_label_name)){
            if($order[0]->gcn_seq)
              $order[0]->lower_cost_opt = \App\Drug::where('id','!=',$order[0]->DrugDetailId)->where('gcn_seq',$order[0]->gcn_seq)->where('sponsored_product','Y')->whereRaw("TRIM(`rx_label_name`) = ?" ,[trim($order[0]->rx_label_name)])->count();
              else
              $order[0]->lower_cost_opt = 0;
        }

        if(isset($order[0]->RxNumber) && !empty($order[0]->RxNumber)){
            $order[0]->AllRefills = Order::where("RxNumber",$order[0]->RxNumber)->whereIn("OrderStatus",[8,23])->pluck("id")->toArray();
        }
        if($order[0]->PracticeId)
        {
          $base_fee=Service::where("practice_id",$order[0]->PracticeId)->first();
        }

        return response()->json(['data'=>$order, 'history'=>$history, 'activities'=>$activities, 'barCode'=>$barCode,'barCode1'=>$barCode1,'base_fee'=>$base_fee],200);
    }

    function generalQuestionThread(Request $request)
    {
       $general_messages = Message::where('messages.questionId',$request->q_id)
                 ->join('PatientProfileInfo as p','p.Id','messages.PatientId')
                 ->leftjoin('practices','messages.PracticeId','practices.id')
                 ->select([DB::raw('AES_DECRYPT (FROM_BASE64(p.MobileNumber),"ss20compliance19") AS MobileNumber'),
                  DB::raw('CONCAT(LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(p.FirstName),"ss20compliance19") USING "utf8")), " ", LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(p.LastName),"ss20compliance19")USING "utf8"))) AS requested_by'),
                  DB::raw('AES_DECRYPT (FROM_BASE64(p.BirthDate),"ss20compliance19") AS BirthDate'),'p.Id as pat_id','messages.Message','messages.message_status','messages.created_at as message_create','messages.attachment','practices.practice_name','practices.id as prac_id','questionId'])->get();


        return response()->json(['data'=>$general_messages],200);
    }


        function orderPrint(Request $request){

        $order = Order::where('Orders.Id',$request->order)
        ->join('PatientProfileInfo as p','p.Id','Orders.PatientId')
        ->join('drugs_new', 'drugs_new.id', 'Orders.DrugDetailId')
        ->join('OrderStatus','Orders.OrderStatus','OrderStatus.Id')
                 ->join('practices as pr','pr.id','Orders.PracticeId')
                 ->leftjoin('practices as presc','presc.id','Orders.prescriber_id')
        ->select([DB::raw('AES_DECRYPT (FROM_BASE64(p.MobileNumber),"ss20compliance19") AS MobileNumber'),DB::raw('AES_DECRYPT (FROM_BASE64(p.FirstName),"ss20compliance19") AS FirstName'),DB::raw('AES_DECRYPT (FROM_BASE64(p.LastName),"ss20compliance19") AS LastName'),'p.Gender',DB::raw('DATE_FORMAT(AES_DECRYPT (FROM_BASE64(p.BirthDate),"ss20compliance19"),"%m/%d/%Y") AS BirthDate'),'Orders.*','drugs_new.*','drugs_new.strength as Strength','OrderStatus.Id as Status_Id','OrderStatus.Name as Status_Name','pr.practice_name',DB::raw('case when presc.added_from_pharmacy IS NULL then concat(presc.practice_name,"*") else presc.practice_name End as prescriber')])->first();
// dd($order);
$barCode='';
$barCode1='';
                  $barCode = \DNS1D::getBarcodeHTML($order->Id, 'I25');
                   $barCode1 = \DNS2D::getBarcodeHTML($order->Id, 'QRCODE',3,3);




return view('practice_module/patient_order_request/print_order/print_order',compact('order','barCode','barCode1'));


    }



/* rx reporter order  */

    public function get_precription_by_id(Request $request)
    {
        $precription = DB::table('reporter_prescription AS rp')
        ->select([DB::raw('AES_DECRYPT (FROM_BASE64(ppi.MobileNumber),"ss20compliance19") AS MobileNumber'),
       // DB::raw('(SELECT count(1) from pip_patient_cases where patient_id = ppi.Id  LIMIT 1) AS is_pip_patient'),
       DB::raw('(case when ppi.is_pip_patient = "Y" then 1 else 0 end) AS is_pip_patient'),
         DB::raw('CONCAT(LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19") USING "utf8")), " ", LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8"))) AS requested_by'),
         'ppi.Gender',DB::raw('DATE_FORMAT(AES_DECRYPT (FROM_BASE64(ppi.BirthDate),"ss20compliance19"),"%m/%d/%Y") AS BirthDate'),'rp.patient_id as PatientId','rp.practice_id as PracticeId','rp.id as reporter_prescription_id',DB::raw('IF(rp.dosing_instructions IS NULL or rp.dosing_instructions = "", "-", rp.dosing_instructions) as dosing_instructions'),'rp.drug_id as DrugDetailId','rp.days_supply as DaysSupply','rp.quantity as Quantity','rp.refills as RefillsRemaining','rp.dosage_form as DrugType','rp.strength as Strength','rp.rx_brand_or_generic as BrandReference','drugs_new.*','drugs_new.rx_label_name as DrugName','pr.practice_name','pr.practice_type','rp.alternate_drug'])
        ->join('drugs_new', 'drugs_new.id', 'rp.drug_id')
        ->leftJoin('PatientProfileInfo AS ppi', 'ppi.Id', 'rp.patient_id')
        ->leftJoin('practices AS pr', 'pr.id','rp.practice_id' )
        ->where('rp.id', $request->order_id)
        // ->where('rp.reporter_id', auth::user()->id)
        ->first();

           $precriber = DB::table('reporter_prescription AS rp')
        ->leftJoin('practices AS pr', 'pr.id','rp.physcian_practice_id' )
        ->where('rp.id', $request->order_id)
        // ->where('rp.reporter_id', auth::user()->id)
        ->select([DB::raw('case when pr.added_from_pharmacy IS NULL then concat(pr.practice_name," *") else pr.practice_name End as practice_name'),'pr.id as prescribr_practice_id','pr.practice_phone_number', DB::raw('(SELECT name from users where id=rp.reporter_id) as prescriber_name')])
        ->first();

        $alternate = DB::table("alternate_prescriptions As ap")
                    ->select(['ap.*','rp.created_at as hcp_prescribed_at',DB::raw('(SELECT name from users where id=ap.created_by  LIMIT 1) AS created_by'),DB::raw('(SELECT practice_name from practices where id=rp.practice_id  LIMIT 1) AS practice_name')])
                    ->join('reporter_prescription AS rp', 'rp.id', 'ap.prescription_id')
                    ->where("ap.prescription_id",$request->order_id)
//                    ->where("rp.alternate_drug","Y")
//                    ->where("ap.prescriber_type", "hcp")
                    ->orderBy("ap.id", "desc")->get();

        if($precription)
        {
            return response()->json(['message' => "Precription fatched successfully.", 'status'=>true, 'data' => $precription,'pres'=>$precriber, 'alternate'=>$alternate], 200);
        } else {
            return response()->json(['message' => "You are not authorized.", 'status'=>false], 200);
        }
    }

/* end reporter order  */

    function refillOrderRequest(Request $request){
        // return $request->all();
        if($request->order_id)
          $toCreateRefill = Order::find($request->order_id);
          else
          return response()->json(['status'=>400,'refillDone'=>false,'refillMessage'=>'Order Id not found from request.']);
      
       if($toCreateRefill) 
                 $sToken =  $toCreateRefill->patient?$toCreateRefill->patient->SecurityToken:null;
                 else
                    return response()->json(['status'=>400,'refillDone'=>false,'refillMessage'=>'Order Not Found to Create Refill.']);
      
            // return $sToken;  
        if($sToken)
        {
          $response = $this->refillOrderGenerate($request->order_id,$sToken);
          if(isset($response->data->refillOrderId)){
           DB::table('renewal_prescription')->where('OrderId',$request->order_id)->update(['renw_orderId'=>$response->data->refillOrderId,'viewStatus'=>'RxRenewal_Created']);
          } 
          return response()->json(['status'=>200,'refillDone'=>true,'refillMessage'=>'Refill Order has been placed.','refillApiResponse'=> $response]);
        }
        else{
            return response()->json(['status'=>200,'refillDone'=>false,'refillMessage'=>'No Patient Security token Found.']);
   
        }
      
    }
    
    function refillOrderEnrollmentRequest($id,$token){
        // return "yes";
      $response = $this->refillOrderGenerate($id,$token);
    //  dd($response);
      if($response){
          return redirect('patient/order/'.$response->patientId)->with('refillMessage','Refill Order has been placed.');
      }
    }


    public function clinicalAddUpdate(Request $request)
    {
        // dd($request->all());
       
        if(isset($request->modal_type)){
            $p = '';
            if(isset($request->PatientId)){
            $p = Patient::find($request['PatientId']);
            }else{
                return response()->json(['status' => 404, 'message' => 'Patient is not found']);
   
            }
            if($request->modal_type == 'patient_message'){

                unset($request['modal_type']);
                $msgData=$request->all();
                $msgData['message_status'] = 'sent';
                $msgData['message_type'] = 'Pharmacy';
                if($request->has('attachment'))
                {
                  $data=$this->storeMessageImg($request->attachment);
                  $msgData['attachment']=$data;
                }


              $query =   \App\Message::create($msgData);
              $notification = '';
              if($query){
                // dump($p);
                // dump($p->enrollment);
                if($p){
                    if($request->has('questionId') && $request->questionId){
                        
                        if($p->enrollment->enrollment_status == 'Enrolled')
                        {
                          $notification = $this->sendNotificationAnswerAlert($request->questionId, $request->PatientId);
                          $notification = json_decode($notification);
              
                        }
                    }else{
                $notification = $this->sendNotificationOrderStatus($request['OrderId'],200, $p->SecurityToken );
                $notification = json_decode($notification); }
                    }
            }
              return response()->json(['status' => 1, 'message' => 'Message has been sent successfully','notifications'=>$notification,'mdata'=>$query]);
            }
            elseif($request->modal_type == 'clinical_advisory')
        {
            unset($request['modal_type']);
        if($request->has('CustomDocument'))
        {

                if(isset($request->id))
                {
                    if(isset($request->CustomDocument))
                    {

                        $data = $this->storeFileBase($request->CustomDocument);
                        if($data){
                            $this->deleteClinicalFile($request->id);
                        }
                    }

                    $query = DB::table('OrderCustomDocuments')->where('Id', $request->id)->update($data);
                }
                else
                {
                    if(isset($request->CustomDocument))
                    {
                        $data = $this->storeFileBase($request->CustomDocument);
                    }
                    $requestData = $request->all();
                    $requestData['created_at'] = Carbon::now()->toDateTimeString();
                    $requestData['CustomDocument'] = $data;
                    // $data = array_merge(['Message'=>$request->Message],$data);
                    $query = DB::table('OrderCustomDocuments')->insert($requestData);
                    if($query){

                        if($p){
                        $notification = $this->sendNotificationOrderStatus($requestData['OrderId'],100, $p->SecurityToken );
                        $notification = json_decode($notification); }
                    }
                }


            //exit;
        }

        return response()->json(['status' => 1, 'message' => 'File have been sent successfully','notifications'=>$notification]);
}else{
    return response()->json(['status' => 0, 'message' => 'Something went wrong modal type']);
}
    }else{
        return response()->json(['status' => 0, 'message' => 'Something went wrong']);
    }
    }


    public function storeFileBase($base64File){

        $new_img_path=rand().time().'.'.$base64File->getClientOriginalExtension();

        $file_name=Storage::disk('public')->putFileAs('drugClinical', $base64File,$new_img_path);

		 return 'storage/'.$file_name;


    }

    public function deleteClinicalFile($id)
    {
         $record = DB::table('OrderCustomDocuments')->whereId($id);
         if($record)
         {
            $delete = Storage::delete($record->CustomDocument);
            return $delete;
         }else{
         return false;
         }
    }

      public function sendMessage($mobile)
    {
      if($mobile){
             $notification = $this->sendDownloadLink($mobile);
                        $notification = json_decode($notification); }

                        return response()->json(['status' => 200, 'message' => 'Message sent successfully','notification'=>$notification]);
    }
    public function storeMessageImg($file)
    {
       $new_img_path=rand().time().'.'.$file->getClientOriginalExtension();

        $file_name=Storage::disk('public')->putFileAs('patientMessage', $file,$new_img_path);

     return 'storage/'.$file_name;

    }

    public function sendEditsToHcp(Request $request)
    {
        $prescription = \App\ReporterPrescription::find($request->order_id);

        if(\App\AlternatePrescription::where("prescription_id", $request->order_id)->count() == 0){
            DB::table('alternate_prescriptions')->insert(['prescription_id'=>$request->order_id, 'prescriber_type'=>'hcp', 'drug_id'=>$prescription->drug_id, 'rx_label_name'=>$prescription->rx_brand_or_generic, 'manufacturer'=>$prescription->rx_brand_or_generic, 'strength'=>$prescription->strength, 'dosage_form'=>$prescription->dosage_form, 'quantity'=>$prescription->quantity, 'days_supply'=>$prescription->days_supply, 'refills_remain'=>$prescription->refills, 'ingr_cost'=>$request->ingr_cost, 'comments'=>$prescription->dosing_instructions, 'created_by'=>$prescription->reporter_id]);
        }

        \App\AlternatePrescription::insert(
            ['prescription_id' =>$request->order_id, 'prescriber_type'=>'pharmacy', 'drug_id'=>$request->new_drug_id, 'rx_label_name'=>$request->drug_label, 'manufacturer'=>$request->marketer, 'strength'=>$request->strength, 'dosage_form'=>$request->dosage_form, 'quantity'=>$request->quantity, 'days_supply'=>$request->days_supply, 'refills_remain'=>$request->refills, 'ingr_cost'=>preg_replace("/[^0-9.]/", "", $request->ingr_cost), 'comments'=>$request->comments, 'created_by'=>auth()->id()]
        );

        DB::table('hcp_drug_messages')->insert(['prescription_id'=>$request->order_id, 'message'=>$request->comments, 'sender_type'=>'pharmacy', 'date_time'=>date('Y-m-d H:i:s')]);
        
        if($request->send_status > 0)
            $updateList = ['drug_id'=>$request->new_drug_id, 'alternate_drug'=>'Y', 'rx_brand_or_generic'=>$request->drug_label, 'quantity'=>$request->quantity, 'strength'=>$request->strength, 'dosage_form'=>$request->dosage_form, 'days_supply'=>$request->days_supply, 'refills'=>$request->refills];
        else
            $updateList = ['drug_id'=>$request->new_drug_id, 'alternate_drug'=>'N', 'rx_brand_or_generic'=>$request->drug_label, 'quantity'=>$request->quantity, 'strength'=>$request->strength, 'dosage_form'=>$request->dosage_form, 'days_supply'=>$request->days_supply, 'refills'=>$request->refills];
        
        DB::table('reporter_prescription')
                    ->where('id', $request->order_id)
                    ->update($updateList);

        return response()->json(['status' => 200, 'message' => 'Edits sent to Hcp successfully.']);
    }
    
    public function alterOrderLowerCost(Request $request)
    {
        Order::where('Id',$request->order_id)->update(['DrugDetailId' => $request->new_drug_id, 'prev_drug_id' => $request->old_drug_id, 'BrandReference' => $request->brand_reference, 'Strength' => $request->strength, 'RxIngredientPrice'=>$request->drug_price, 'RxProfitability'=>$request->rx_profitability ]);
        return "success";
    }
    
    public function deleteHcpOrder(Request $request)
    {
        DB::table('reporter_prescription')
                    ->where('id', $request->order_id)
                    ->delete();
        
        DB::table('alternate_prescriptions')
                    ->where('prescription_id', $request->order_id)
                    ->delete();
        
        return "success";
    }
    
    public function getHcpComments($id)
    {
        if(DB::table('reporter_prescription')->whereId($id)->count() == 0){
            $order = Order::find($id);
            $id = $order->reporter_prescription_id;            
        }
            
        $reporter = DB::table('reporter_prescription')->find($id);
        $drugs = DB::table('alternate_prescriptions')->where("prescription_id",$id)->get();
        $pharmacy = Practice::whereId($reporter->practice_id)->first()->practice_name;
        $hcp =   \App\User::whereId($reporter->reporter_id)->first()->name;   
        $messages = DB::table('hcp_drug_messages')->where('prescription_id', $id)->orderBy("id", "ASC")->get();
        return response()->json(['status' => 200, 'messages' => $messages, 'pharmacy'=>$pharmacy, 'hcp'=>$hcp, 'drugs'=>$drugs, 'prescription'=>$reporter]);
    }
    
    public function addHcpComments(Request $request)
    {
        DB::table('hcp_drug_messages')->insert(['prescription_id'=>$request->order_id, 'message'=>$request->message, 'sender_type'=>'pharmacy', 'date_time'=>date('Y-m-d H:i:s')]);
        return DB::table('hcp_drug_messages')->where('prescription_id', $request->order_id)->orderBy("id", "ASC")->get();
    }

}

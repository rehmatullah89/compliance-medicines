<?php


namespace App\Services;
use App\Patient;
use App\Practice;
use App\User;
use App\ZipCodes;
use PharIo\Manifest\Email;
use Illuminate\Support\Facades\DB;
use auth;
use Session;
use App\Drug;
class CommonMethods
{
    public function checkZip($zip){
        $checkZip = ZipCodes::where('zip_code',$zip)->first();
//        dump($checkZip);
        if($checkZip){
            return response()->json(true);
        }else{
            return response()->json(false);
        }
    }

    public function checkPatientEmail($email){
        $checkEmail = Patient::select(DB::raw('AES_DECRYPT (FROM_BASE64(EmailAddress),"ss20compliance19") AS EmailAddress'))->whereRaw(' AES_DECRYPT (FROM_BASE64(EmailAddress),"ss20compliance19") = "'.$email.'"' )->first();
        if($checkEmail){
//            return response()->json(['status'=>400,'data'=>'Email already exists']);
            return response()->json(false);
        }else{
//            return response()->json(['status'=>200,'data'=>'Email Not Exists already']);
            return response()->json(true);
        }
    }


        public function checkPatientEmailUpdate($em,$prev)
    {
        $checkEmail = Patient::select(DB::raw('AES_DECRYPT (FROM_BASE64(EmailAddress),"ss20compliance19") AS EmailAddress'))
        ->whereRaw(' AES_DECRYPT (FROM_BASE64(EmailAddress),"ss20compliance19") != "'.$prev.'"')
        ->whereRaw(' AES_DECRYPT (FROM_BASE64(EmailAddress),"ss20compliance19") = "'.$em.'"' )  
        ->first();
        if($checkEmail)
        {
            return response()->json(false);
        }else{
            return response()->json(true);
        }
    }
    public function checkPatientPhoneUpdate($ph,$prev)
    {
        $checkPhone = Patient::select(DB::raw('AES_DECRYPT (FROM_BASE64(MobileNumber),"ss20compliance19") AS MobileNumber'))
        ->whereRaw(' AES_DECRYPT (FROM_BASE64(MobileNumber),"ss20compliance19") != "'.$prev.'"')
        ->whereRaw(' AES_DECRYPT (FROM_BASE64(MobileNumber),"ss20compliance19") = "'.$ph.'"' )  
        ->first();
        
        if($checkPhone)
        {
            return response()->json(false);
        }else{
            return response()->json(true);
        }
    }
    
    
    public function checkUserEmail($email, $id){
      // dd($email);
        if($id){
            
            $checkEmailFirst = DB::table('users')->where('email', $email)->where('id', $id)->get()->count();
           
            if($checkEmailFirst>0){ 
                
                $checkEmailSecond = User::where('email', $email)->where('id', '!=', $id)->first();
                if($checkEmailSecond)
                {
                    $resp = ['status'=>400,'data'=>'Email already exists'];
                    
                } else {                    
                    $resp = ['status'=>200,'data'=>'Email Not Exists already']; 
                }
                    
            }else{
                 $checkEmailThird = User::where('email',$email)->first();
                if($checkEmailThird){ $resp = ['status'=>400,'data'=>'Email already exists']; }
                else{ $resp = ['status'=>200,'data'=>'Email Not Exists already']; }
            }
        }
        else
        {
            
            $checkEmailThird = User::where('email',$email)->first();
            if($checkEmailThird){ $resp = ['status'=>400,'data'=>'Email already exists']; }
            else{ $resp = ['status'=>200,'data'=>'Email Not Exists already']; }
        }
        
            return response()->json($resp);
        
            
            
    }

    public function checkUserPhone($phone){
        $checkEmail = User::where('phone_number',$phone)->first();
        if($checkEmail){
            return response()->json(['status'=>200,'data'=>'Email already exists']);
        }else{
            return response()->json(['status'=>200,'data'=>'Email Not Exists already']);
        }
    }


    public function checkPhone($phone){
        //  $phone = str_replace('-','',$phone);
        $checkPhone = Patient::select(DB::raw('AES_DECRYPT (FROM_BASE64(MobileNumber),"ss20compliance19") AS MobileNumber'))->whereRaw(' AES_DECRYPT (FROM_BASE64(MobileNumber),"ss20compliance19") = "'.$phone.'"' )->first();
        if($checkPhone){
            return response()->json(false);
        }else{
            return response()->json(true);
        }
    }

    public function checkPracticePhone($request){
        //  $phone = str_replace('-','',$phone);
        
        $checkPhone = Practice::where('practice_phone_number',$request->practice_phone_number)
        ->when(isset($request->id), function($q) use ($request)
        {
            return $q->where('id','!=',$request->id);
        })->first();
        // return $checkPhone;
        if($checkPhone){
            return response()->json(false);
        }else{
            return response()->json(true);
        }
    }

     public function checkPracticeLicenseNumber($request){
        //  $phone = str_replace('-','',$phone);
        $checkPhone = Practice::where('practice_license_number',$request->practice_license_number)
          ->when(isset($request->id), function($q) use ($request)
        {
            return $q->where('id','!=',$request->id);
        })->first();
        if($checkPhone){
            return response()->json(false);
        }else{
            return response()->json(true);
        }
    }

    public function checkPracticeCode($request){
        //  $phone = str_replace('-','',$phone);
        $checkPhone = Practice::where('practice_code',$request->practice_code)
          ->when(isset($request->id), function($q) use ($request)
        {
            return $q->where('id','!=',$request->id);
        })->first();
        if($checkPhone){
            return response()->json(false);
        }else{
            return response()->json(true);
        }
    }


    public function check_existence($table, $db_column, $val_to_check){
        $result = DB::table($table)::where($db_column,$val_to_check)->first();
        dd($result);
    }

    public function checkRXNumber($rx,$pid,$prId=false)
    {
        if($prId==false)
        {
            if(isset(auth::user()->practices->first()->id) && !auth::user()->hasRole('practice_super_group'))
            {
                $practice_id=auth::user()->practices->first()->id;
            }else if(Session::has('practice'))
            {
                $practice_id=Session::get('practice')->id;
             
            }else{
                $curr_patient=Patient::where('Id',$pid)->first();
                $practice_id=$curr_patient->Practice_ID;
             
            }
        }else{
            $practice_id=$prId;
        }
        // exit;
       
        if($practice_id)
        {
            
            $result=DB::table('Orders')->where('RxNumber',$rx)->where('PracticeId',$practice_id)->first();
            // ->where('PracticeId',$practice_id)->first();

            if($result)
            {
            
                return response()->json(false);
            }else{
              
                return response()->json(true);
            }
        }else{
            return "no practice found";
        }
       
        

    }
    public function checkNdcNumber($ndc)
    {
        $drug=Drug::where('ndc',$ndc)->first();
        if($drug)
        {
            return response()->json(false);
        }else{
            return response()->json(true); 
        }
        
    }

}

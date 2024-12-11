<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Carbon;
use DataTables;
use App\Patient;
use App\Order;
use App\Reports;
use App\Practice;
use App\BankDetail;
use App\Service;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Mail\PracticeRegister;
use App\User;
use auth;
use App\ServiceOffered;
use App\Group;
use PDF;
use App\Facilitator;
use App\Drug;

class PracticeController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getState()
    {

        return $data['state'] = DB::table('State')->all();
    }

    /**
     * Show searched resources from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $keyword
     * @return \Illuminate\Http\Response
     */
    public function searchAllAccess(Request $request)
    {
        // dd(auth::user()->practices->pluck('id'));

        if (is_array($request->all())  && empty($request->all())) {
            // $request->request->add(['type' => 'all']);
            // $request->route()->setParameter('type', 'all');
            // $request->request->set('type', 'all');
            $request->merge(["type" => "all"]);
            // $request["type"] ="all";
            // dump($request->type);
        }
        // dd($request);
        
        if ($request->type == 'all' or $request->type == 'Practices') {
            $search = strtolower(str_replace(["(", ")", "-", " "], "", $request->keyword));
            $practices = Practice::whereNull('added_from_pharmacy')->when(!empty($search), function ($query) use ($search) {
                return $query->where(function ($query) use ($search) {
                    return $query->whereRaw('Replace(Replace(Replace(LOWER(practice_name)," ",""),"-",""),"_","") Like "%' . $search . '%"')
                        ->orwhereRaw('Replace(Replace(Replace(LOWER(branch_name)," ",""),"-",""),"_","") Like "%' . $search . '%"')
                        ->orWhereRaw('LOWER(practice_name) Like "%' . $search . '%"')
                        ->orWhereRaw('LOWER(practice_license_number) Like "%' . $search . '%"')
                        ->orWhereRaw('LOWER(practice_zip) Like "%' . $search . '%"')
                        ->orWhereRaw('LOWER(practice_phone_number) Like "%' . $search . '%"')
                        ->orWhereRaw('Replace(Replace(Replace(Replace(practice_phone_number,"(",""),")",""),"-","")," ","") Like "%' . $search . '%"');
                });
            })->when((isset(auth::user()->roles[0]->name) && (auth::user()->roles[0]->name == 'super_admin')), function ($query) {
                return $query->where(function ($query) {
                    return $query->whereIn('id', auth::user()->practices->pluck('id'))
                        ->orWhereIn('parent_id', auth::user()->practices->pluck('id'));
                });
            })
            ->when(auth::user()->hasRole('practice_super_group'),function($query){
                $query->whereIn('id',auth::user()->practices->pluck('id'));
        })
                ->with('users')->get();

            $data['practices']  = $practices->all();
        }
        if ($request->type == 'all' or $request->type == 'Patients') {
            $search = strtolower(str_replace(["(", ")", "-", " "], "", $request->keyword));
            $patients = Patient::select([
                DB::raw(
                    'Practice_ID, (CASE Gender WHEN "F" THEN "Female" WHEN "M" THEN "Male" END) AS Gender, ZipCode, Id ,
                                    CONVERT(AES_DECRYPT (FROM_BASE64(FirstName),"ss20compliance19") USING "utf8") AS first_name,
                                    CONVERT(AES_DECRYPT (FROM_BASE64(LastName),"ss20compliance19")USING "utf8") AS last_name,
                                    AES_DECRYPT (FROM_BASE64(MobileNumber),"ss20compliance19") AS mobile_number,
                                    AES_DECRYPT (FROM_BASE64(EmailAddress),"ss20compliance19") AS email_address,
                                    DATE_FORMAT(AES_DECRYPT (FROM_BASE64(BirthDate),"ss20compliance19"), "%m/%d/%Y")  AS dob'
                ),
                DB::raw('(SELECT count(1) from pip_patient_cases Where patient_id = PatientProfileInfo.Id) AS pip_count')
            ])
                ->when(
                    !empty($search),
                    function ($query) use ($search) {
                        return $query->where(function ($query) use ($search) {
                            $query->whereRaw('  LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(FirstName),"ss20compliance19")USING "utf8")) Like "%' . $search . '%"')
                                ->orWhereRaw(' LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(EmailAddress),"ss20compliance19")USING "utf8")) Like "' . $search . '"')
                                ->orWhereRaw(' LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(LastName),"ss20compliance19")USING "utf8")) Like "%' . $search . '%"')
                                ->orWhereRaw('CONCAT(LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(FirstName),"ss20compliance19") USING "utf8")), " ", LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(LastName),"ss20compliance19")USING "utf8")))  Like "%'.$search.'%"'  )
                                ->orWhereRaw(' LOWER(ZipCode) Like "%' . $search . '%"')
                                ->orWhereRaw(' AES_DECRYPT (FROM_BASE64(MobileNumber),"ss20compliance19") Like "%' . $search . '%"');
                        });
                    }
                )
                ->when((isset(auth::user()->roles[0]->name) && (auth::user()->roles[0]->name == 'super_admin')), function ($query) {

                    return $query->where(function ($query) {
                        $query->whereIn('Practice_ID', Practice::whereIn('id',auth::user()->practices->pluck('id'))->orWhereIn('parent_id', auth::user()->practices->pluck('id'))->pluck('id')->all());
                    });
                })
                ->when(auth::user()->hasRole('practice_super_group'),function($query){
                    $query->whereIn('Practice_ID',auth::user()->practices->pluck('id'));
            })
            ->groupBy('Id')
                // ->limit(5)
                // ->orderBy('Id','desc')
                ->whereNotNull('Practice_ID')
                ->get();

            $data['patients']  = $patients->all();
        }
        $data['state'] = DB::table('State')->get();

        $data['groups']=Group::get();

        $data['facilitator'] = Facilitator::get();


        return view('all_access.search_results', $data);
    }


    public function createPracticeLogoFromBase64Store($base64image,$p_name)
    {
        $new_img_path= $p_name.'_'.rand().time().'.'.$base64image->getClientOriginalExtension();

        $file_name= \Storage::disk('public')->putFileAs('practice_logo', $base64image,$new_img_path);

         return 'storage/'.$file_name;
        // dump($new_img_path);
        // dump($file_name);

              if(\Storage::disk('public')->has($file_name))
              echo "ha g";
       
    //    dump($file_name);

        $file_data = $base64image;
        $img = preg_replace('/^data:image\/\w+;base64,/', '', $file_data);
        dump($img);
        $type = explode(';', $file_data)[0];
        dump($type);
        $type = explode('/', $type)[1];
dump($type);
        $file_name = 'p_logo' . time() . str_random(8) . '.' . $type ;
dump($file_name);
dd($file_data);
        @list($type, $file_data) = explode(';', $file_data);

        @list(, $file_data) = explode(',', $file_data);

        if ($file_data != "") {
            $image_stor =   \Storage::disk('public')->put($file_name, base64_decode($file_data));
            if ($image_stor) {
                return $file_name;
            }
        }
    }


    public function practiceAddUpdate(Request $request)
    {
        if ($request->ajax()) {
            $requestArray = $request->all();
            
            if($request->has('logo_updates')){
                if($request->logo_updates == 'removed'){
                    $requestArray['practice_logo'] = null;
                }
                unset($requestArray['logo_updates']);
            }
            // dd($requestArray);
            if($request->hasFile('practice_logo') && $request->practice_logo)
           if($p_logo = $this->createPracticeLogoFromBase64Store($request->practice_logo,$request->practice_name?$request->practice_name:''))
            {
                // unset($request['practice_type']);
 
                $requestArray['practice_logo'] = $p_logo ??'';
             
            }
            // dd($requestArray);
            if (array_key_exists('id',$requestArray) && $requestArray['id']) {

                $prac_linc=Practice::where('practice_license_number',$requestArray['practice_license_number'])->where('id','!=',$requestArray['id'])->first();

                if($prac_linc==null)
                {
                $prac_phn=Practice::where('practice_phone_number',$requestArray['practice_phone_number'])->where('id','!=',$requestArray['id'])->first();
                if($prac_phn==null)
                {
                    $user_exist=true;
                    $super_users = [];
                    $dublicate = 0;$group_mismatch=true;$gr_name='';
                    foreach ($requestArray['users'] as $key => $value) {
                        $pusr=User::where('email',$value['email'])->whereHas('practices',function($q) use ($requestArray){
                        $q->where('practice_id','!=',$requestArray['id']);
                        })->first();
                        // echo 'first';
                        // print_r($pusr);
                        if($pusr && $pusr->hasRole('practice_super_group') && $value['role'] == 15){
                          $puser1 =  User::where('id',$pusr->id)->whereHas('practices',function($q) use ($requestArray){
                                $q->where('practice_id','=',$requestArray['id']);
                                })->first();
                         // echo 'apni';
                          if($pusr->practices->first());
                          {
                            if($pusr->practices->first()->group_id!=$requestArray['group_id'])
                            {
                                if($pusr->practices->first()->group)
                                {
                                    $gr_name=$pusr->practices->first()->group->group_name;
                                }
                                $group_mismatch=false;
                                break;
                            }
                          }

                            if(!$puser1){

                            $super_users[] = $pusr;
                            $pusr = null;
                            }else{

                                if(!isset($value['id']))
                                {

                                    $dublicate += 1;
                                }
                                else{

                                $pusr = null;
                                }
                            }



                     }

if($dublicate > 1){
    $pusr = true;
}

                        if($pusr!=null)
                        {
                            $user_exist=false;
                            break;
                        }

                    }
                    if($group_mismatch==false)
                    {
                        return response()->json(['status'=>false,'msg'=>'Please must select '.$gr_name.' from groups']);
                    }
                    if($user_exist==false)
                    {
                        return response()->json(['status'=>false,'msg'=>'Email already exists']);
                    }
                }
                    else{
                        return response()->json(['status'=>false,'msg'=>'Practice phone already exists']);
                    }
                }else{
                    return response()->json(['status'=>false,'msg'=>'Practice practice license number already exists']);
                }


                $practice = $requestArray;
                $bank = $practice['bank'];
                $users = $practice['users'];
                $service = $practice['service'];
                if(isset($practice['service_offer']))
                {
                  $service_offer= $practice['service_offer'];
                }
                $practice = array_except($practice, array('bank', 'users', 'service','service_offer'));
                $practic_id = Practice::where('id', $practice['id'])->update($practice);
            //    dump($practice);
            //     dd($service);
                if (isset($bank['id'])) {
                    $bankDetail = BankDetail::find($bank['id']);
                    $bankDetail->practice_banking_institution = $bank['practice_banking_institution'];
                    $bankDetail->practice_banking_location = $bank['practice_banking_location'];
                    $bankDetail->bank_state = $bank['bank_state'];
                    $bankDetail->bank_routing_number = $bank['bank_routing_number'];
                    $bankDetail->bank_account_number = $bank['bank_account_number'];
                    $bankDetail->practice_id = $practice['id'];
                    $bankDetail->save();
                } else {
                    $bank['practice_id'] = $practice['id'];
                    BankDetail::insertGetId($bank);
                }


                //  if(isset($service[0]['id'])){
                //     $serviceObj = Service::find($service[0]['id']);
                //     $serviceObj->profit_share = $service[0]['profit_share'];
                //     $serviceObj->base_fee = $service[0]['base_fee'];
                //     $serviceObj->start_date = Carbon\Carbon::parse($service[0]['start_date'])->format('Y-m-d');
                //     $serviceObj->end_date = Carbon\Carbon::parse($service[0]['end_date'])->format('Y-m-d');
                //     $serviceObj->practice_id = $practice['id'];
                //     $serviceObj->save();
                // }else{
                //     $service[0]['practice_id'] = $practice['id'];
                //     $service[0]['start_date']=Carbon\Carbon::parse($service[0]['start_date'])->format('Y-m-d');
                //     $service[0]['end_date']=Carbon\Carbon::parse($service[0]['end_date'])->format('Y-m-d');
                //     Service::insertGetId($service[0]);
                // }
                $srvc_ids = array_column($service, 'id');
                $del_srvc = Service::whereNotIn('id', $srvc_ids)->where('practice_id', $practice['id'])->delete();
                foreach ($service as $keyU => $valU) {
                    if (isset($valU['id'])) {


                        $serviceObj = Service::find($valU['id']);
                        if ($valU['fee'] != null) {
                            $valU['fee'] = str_replace("$", "", $valU['fee']);
                        }
                        if ($valU['base_fee'] != null) {
                            $valU['base_fee'] = str_replace("$", "", $valU['base_fee']);
                        }
                        $serviceObj->update([
                            'profit_share' => $valU['profit_share'],
                            'base_fee' => $valU['base_fee'],
                            'fee' => $valU['fee'],
                            'start_date' => Carbon\Carbon::parse($valU['start_date'])->format('Y-m-d'),
                            'end_date' => Carbon\Carbon::parse($valU['end_date'])->format('Y-m-d'),
                            'practice_id' => $practice['id'],
                            'comission' => str_replace("%", "", $valU['comission']),
                            'facilitator_id' => $valU['facilitator_id']
                        ]);
                    } else {

                        if ($valU['start_date'] != null && $valU['end_date'] != null) {
                            $valU['practice_id'] = $practice['id'];
                            if ($valU['fee'] != null) {
                                $valU['fee'] = str_replace("$", "", $valU['fee']);
                            }
                            if ($valU['base_fee'] != null) {
                                $valU['base_fee'] = str_replace("$", "", $valU['base_fee']);
                            }
                            $srvc = Service::create([
                                'profit_share' => $valU['profit_share'],
                                'base_fee' => $valU['base_fee'],
                                'fee' => $valU['fee'],
                                'start_date' => Carbon\Carbon::parse($valU['start_date'])->format('Y-m-d'),
                                'end_date' => Carbon\Carbon::parse($valU['end_date'])->format('Y-m-d'),
                                'practice_id' => $practice['id'],
                                'comission' => str_replace("%", "", $valU['comission']),
                                'facilitator_id' => $valU['facilitator_id']
                            ]);
                        }
                    }
                }

                $user_ids = array_column($users, 'id');


                // $del_user = User::whereNotIn('id', $user_ids)->where('practice_id', $practice['id'])->delete();
                // $del_user = DB::table('practice_user')->whereNotIn('user_id', $user_ids)->where('practice_id', $practice['id'])->delete();
                $practicObj =  Practice::find($practice['id']);
                // $practicObj->users()->sync($user_ids);
                $del_user=DB::table('practice_user')->whereNotIn('user_id', $user_ids)->where('practice_id',$requestArray['id'])->get();

                if(count($del_user))
                {
                    foreach ($del_user as $key => $valueU) {

                        $uu=User::where('id',$valueU->user_id)->whereHas('practices',function($q) use ($requestArray){
                        $q->where('practice_id','!=',$requestArray['id']);
                        })->first();
                        if($uu)
                        {

                            $practicObj->users()->detach($uu);
                        }else{

                            $practicObj->users()->detach($valueU);
                            User::find($valueU->user_id)->delete();
                        }
                    }

                }


                foreach ($users as $keyU => $valU) {
                    $found = false;
                    if($super_users){
                        foreach($super_users as $key => $s){
                            if($valU['email'] == $s->email){
                                if (isset($valU['id']) and in_array($valU['id'], $user_ids)) {

                                //     User::find($valU['id'])->whereHas('practices',function($q) use ($request){
                                // $q->where('practice_id','!=',$request->id);
                                // })->first();

                                    // DB::table('model_has_roles')->where('model_id', $valU['id'])->delete();
                                    //$user_id = User::where('id', $valU['id'])->where('practice_id', $practice['id'])->update($valU);
                                    // $user = User::find($valU['id'])->delete();
                                    ////

                                    $uu=User::where('id',$valU['id'])->whereHas('practices',function($q) use ($requestArray){
                                    $q->where('practice_id','!=',$requestArray);
                                    })->first();
                                    if($uu)
                                    {
                                        $practicObj->users()->detach($uu);
                                    }else{
                                        $user_obj=User::find($valU['id']);
                                        $practicObj->users()->detach($user_obj);
                                        $user = $user_obj->delete();
                                    }
                                    $practicObj->users()->attach($s);
                                    $found = true;

                                    /////////////////////////
                                }else{
                                $practicObj->users()->attach($s);
                                $found = true;
                            }
                            }
                        }
                    }

                    if($found){
                        continue;
                    }


                    if (isset($valU['id']) and in_array($valU['id'], $user_ids)) {

                        DB::table('model_has_roles')->where('model_id', $valU['id'])->delete();
                        //$user_id = User::where('id', $valU['id'])->where('practice_id', $practice['id'])->update($valU);
                        $user = User::find($valU['id']);
                        $user->update([
                            'name' => $valU['name'],
                            'email' => $valU['email'],
                            'role' => $valU['role']
                        ]);

                        $role = Role::find($valU['role']);

                        if ($role) {
                            $user->assignRole($role);
                        }
                    } else {

                        if ($valU['name'] != null && $valU['email'] != null) {
                            $valU['practice_id'] = $practice['id'];
                            $password = str::random(5);
                            $valU['password'] = Hash::make($password);
                            // $user_id = User::insertGetId($valU);
                            $user = User::create([
                                'name' => $valU['name'],
                                'email' => $valU['email'],
                                'password' => $valU['password'],
                                'role'  => $valU['role'],
                                'practice_id'=>$practicObj->id
                            ]);

                            $role = Role::find($valU['role']);

                            if ($role) {
                                $user->assignRole($role);
                            }
                            if($user){
                                $practicObj->users()->attach($user);
                            }

                            $user['password'] = $password;
                            $user['type'] = $practice['practice_type'];
                           $mail =  Mail::to($valU['email'])->send(new PracticeRegister($user));
                            unset($user['password']);
                        }
                    }
                    // var_dump($valU['role']);
                }

                if(isset($service_offer))
                {
                  foreach ($service_offer as $keyS => $valueS) {
                    if(isset($valueS['id']))
                    {
                      $srv_offer_obj=ServiceOffered::find($valueS['id']);
                      $srv_offer_obj->update([
                        'service_title'=>$valueS['service_title'],
                        'service_choice'=>$valueS['service_choice']
                      ]);
                    }else{
                    $srv_off=$practicObj->services_offered()->create([
                      'service_title'=>$valueS['service_title'],
                      'service_choice'=>$valueS['service_choice']
                    ]);
                    }
                  }
                }
                $res['msg'] = $requestArray['practice_type'] . ' updated successfully.';
                $res['type'] = 'update';
                $res['practice'] = $practicObj;
                if ($practicObj->users()->first()['name']) {
                    $res['site_contact'] = $practicObj->users()->first()['name'];
                }
            } else {
                $prac_linc=Practice::where('practice_license_number',$requestArray['practice_license_number'])->first();

                if($prac_linc==null)
                {
                $prac_phn=Practice::where('practice_phone_number',$requestArray['practice_phone_number'])->first();
                if($prac_phn==null)
                {
                    $super_users = [];
                    $user_exist=true;
                    foreach ($requestArray['users'] as $key => $value) {
                        // $pusr=User::where('email',$value['email'])->whereHas('roles', function ($query) {
                        //     return $query->where('role_id', '!=', 3);
                        // })->first();

                        $pusr=User::where('email',$value['email'])->first();
                        if($pusr && $pusr->hasRole('practice_super_group') && $value['role'] == 15){
                            $super_users[] = $pusr;
                            $pusr = null;
                        }

                        if($pusr!=null)
                        {
                            $user_exist=false;
                            break;
                        }
                    }
                    if($user_exist==false)
                    {
                        return response()->json(['status'=>false,'msg'=>'Email already exists']);
                    }

                    $practice = $requestArray;
                    $bank = $practice['bank'];
                    $users = $practice['users'];
                   $service = $practice['service'];
                    if(isset($practice['service_offer']))
                    {
                      $service_offer=$practice['service_offer'];
                    }
                    $practice = array_except($practice, array('bank', 'users', 'service','service_offer'));

                    // $practic_id = Practice::insertGetId($practice);
                    $practic_id = Practice::create($practice);
                    $practic_id->created_by_user = auth::user()->id;
                    $practic_id->save();
                    
                    $practic_id = $practic_id->id;
                    $bank['practice_id'] = $practic_id;
                    // $service['practice_id'] = $practic_id;

                    //  insert bank data
                    $bank_id = BankDetail::insertGetId($bank);
                    // $service = Service::create( $service[0]);

                    foreach ($service as $keyU => $valU) {

                        if ($valU['start_date'] != null && $valU['end_date'] != null) {

                            if ($valU['fee'] != null) {
                                $valU['fee'] = str_replace("$", "", $valU['fee']);
                            }
                            if ($valU['base_fee'] != null) {
                                $valU['base_fee'] = str_replace("$", "", $valU['base_fee']);
                            }
                            $srvc = Service::create([
                                'profit_share' => $valU['profit_share'],
                                'base_fee' => $valU['base_fee'],
                                'fee' => $valU['fee'],
                                'start_date' => Carbon\Carbon::parse($valU['start_date'])->format('Y-m-d'),
                                'end_date' => Carbon\Carbon::parse($valU['end_date'])->format('Y-m-d'),
                                'practice_id' => $practic_id,
                                'comission' => str_replace("%", "", $valU['comission']),
                                'facilitator_id' => $valU['facilitator_id']
                            ]);
                        }
                    }

                    $practicObj =  Practice::find($practic_id);

                    // $pusr=User::where('email',$value['email'])->whereHas('roles', function ($query) {
                    //     return $query->where('role_id', '!=', 3);
                    // })->first();

                    foreach ($users as $keyU => $valU) {
 $found = false;
if($super_users){
    foreach($super_users as $key => $s){
        if($valU['email'] == $s->email){
            $practicObj->users()->attach($s);
            $found = true;
        }
    }
}

if($found){
    continue;
}


                        $UserData = array(0);
                        $UserData = $valU;
                        $UserData['practice_id'] = $practic_id;
                        $password = str::random(5);
                        $UserData['password'] = Hash::make($password);

                        $user = User::create([
                            'name' => $UserData['name'],
                            'email' => $UserData['email'],
                            'password' => $UserData['password'],
                            'role'  => $UserData['role'],
                            'practice_id' => $UserData['practice_id']
                        ]);

                        $role = Role::find($UserData['role']);

                        if ($role) {
                            $user->assignRole($role);
                        }
if($user){
    $practicObj->users()->attach($user);
}
                        $user['password'] = $password;
                        $user['type'] = $practice['practice_type'];
                       $mail =  Mail::to($UserData['email'])->send(new PracticeRegister($user));
                        unset($user['password']);
                    }
                    if(isset($service_offer))
                    {
                      foreach ($service_offer as $keyS => $valueS) {

                        $srv_off=$practicObj->services_offered()->create([
                          'service_title'=>$valueS['service_title'],
                          'service_choice'=>$valueS['service_choice']
                        ]);

                      }
                    }
                    $res['msg'] = $requestArray['practice_type'] . ' added successfully.';
                    $res['type'] = 'add';
                    $res['practice'] = $practicObj;
                    if ($practicObj->users()->first()['name']) {
                        $res['site_contact'] = $practicObj->users()->first()['name'];
                    }
                }else{
                        return response()->json(['status'=>false,'msg'=>'Practice phone already exists']);
                    }
                }else{
                    return response()->json(['status'=>false,'msg'=>'Practice practice license number already exists']);
                }
            }

            return response()->json($res);
        }
    }
    
    public function getParacticeDetails($id)
    {
        $practice = Practice::where('id', $id)->with('users.roles', 'bankDetail', 'services','services_offered', 'order_sheet')->first();

        $result['users'] = $practice->users;
        $result['bankDetail'] = $practice->bankDetail;
        $result['services'] = $practice->services;
        $result['services_offered']=$practice->services_offered;
        $result['order_sheet']=$practice->order_sheet;
        unset($practice->users);
        unset($practice->bankDetail);
        unset($practice->services);
        unset($practice->services_offered);
        unset($practice->order_sheet);
        $result['practice'] = $practice;

        return response()->json($result);
    }
    
    public function saveOrderSheet(Request $request)
    {        
        \App\OrderSheet::updateOrCreate(
            ['practice_id' => $request->practice_id, 'id' => $request->sheet_id],    
            ['practice_id' => $request->practice_id, 'title' => $request->title, 'details' => $request->details, 'created_by' => auth::user()->id, 'updated_by' => auth::user()->id]
            
        );
        $result['order_sheet'] = \App\OrderSheet::wherePracticeId($request->practice_id)->get();
        return response()->json($result);
    }
    
    public function saveDrugCategory(Request $request)
    {
        return \App\OrderSheetCategory::updateOrCreate(
            ['order_sheet_id' => $request->sheet_id, 'id' => $request->category_id],    
            ['order_sheet_id' => $request->sheet_id, 'category' => $request->title, 'details' => $request->details, 'created_by' => auth::user()->id, 'updated_by' => auth::user()->id]
            
        );
    }
    
    public function saveOrderSheetDrug(Request $request)
    {

        return \App\OrderSheetDrug::updateOrCreate(
            ['order_sheet_category_id' => $request->category_id, 'id' => $request->drug_id],    
            ['order_sheet_category_id' => $request->category_id, 'drug_name' => $request->drug_name, 'dosage_type' => $request->dosage_type, 'strength' => $request->strength, 'quantity' => $request->quantity,'upc_number' => $request->upc_number,'ndc_number' => $request->ndc_number,'gcn_number' => $request->gcn_number,'alt_ndc_number' => $request->alt_ndc_number, 'instructions' => $request->instructions, 'created_by' => auth::user()->id, 'updated_by' => auth::user()->id]
            
        );
    }

    public function deleteOrderSheet($id)
    {        
        $record = \App\OrderSheet::find($id);
        $categories = \App\OrderSheetCategory::where("order_sheet_id", $id)->pluck("id")->toArray();
        
        if(!empty($categories)){
            \App\OrderSheetDrug::whereIn("order_sheet_category_id",$categories)->delete();
            \App\OrderSheetCategory::whereIn("id", $categories)->delete();
        }
        $record->delete();
        
        $result['order_sheet'] = \App\OrderSheet::wherePracticeId($record->practice_id)->get();
        return response()->json($result);
    }
    
    public function deleteSheetCategory($id)
    {
        $record = \App\OrderSheetCategory::find($id);
        \App\OrderSheetDrug::where("order_sheet_category_id",$id)->delete();
        
        $record->delete();
        
        return "success";
    }
    
    public function deleteSheetDrug($id)
    {
        $record = \App\OrderSheetDrug::find($id);
        $record->delete();
        
        return "success";
    }

    public function getOrderSheetCategories($id)
    {
        $dataList = [];
        $data = \App\OrderSheetCategory::select(['category','details','id'])->where("order_sheet_id", $id)->get();
        
        foreach($data as $obj){
            array_push($dataList, [$obj->category, $obj->details, $obj->id]);
        }
        
        return ['data'=>$dataList, 'total'=>count($dataList)];
    }
    
    public function getOrderSheetDrugs($id)
    {
        $dataList = [];
        $data = \App\OrderSheetDrug::select(['drug_name', 'generic_name', 'dosage_type','strength','quantity','ndc_number','gcn_number','id', 'upc_number', 'alt_ndc_number', 'instructions','drug_id','position'])->where("order_sheet_category_id", $id)->orderBy("position", "asc")->get();
        
        foreach($data as $obj){
            array_push($dataList, array($obj->drug_name, $obj->generic_name, $obj->dosage_type, $obj->strength, $obj->quantity, $obj->ndc_number, $obj->gcn_number, $obj->id, $obj->upc_number, $obj->alt_ndc_number, $obj->instructions,$obj->drug_id));
        }

        return ['data'=> $dataList, 'total'=>count($dataList)];
    }
    
    public function viewOrderSheet($id)
    {
        $firstTable = "";
        $secondTable = "";
        $categories = \App\OrderSheetCategory::where("order_sheet_id", $id)->pluck("category","id")->toArray();
        
        $index = 0;
        foreach($categories as $id => $category){
        
            $drugs = \App\OrderSheetDrug::select(['drug_name','generic_name','strength','dosage_type'])->where("order_sheet_category_id", $id)->orderBy("position", "asc")->get();
            
            if($index%2 == 0){
                $firstTable .= '<tr><td class="bg-gray-f2 txt-black-24 txt-sline weight_600"><span class="txt-grn-lt">'.(strlen($category) > 50 ? substr($category,0,20)."..." : $category).'</span></td><td class="bg-gray-f2 txt-black-24 tt_uc_ fs-13_ txt-sline weight_600" style="width:100px;">strength</td></tr>';
                foreach($drugs as $drug)
                    $firstTable .= '<tr><td><label for="dual-gel-1p-5p" class="txt-blue tt_uc_ mb-0_ weight_600">'.$drug->generic_name.'</label> <i style="font-size:10px;">('.($drug->drug_name).')</i> '.$drug->dosage_type.'</td><td class="txt-black-24 tt_uc_ fs-13_ weight_500">'.$drug->strength.'</td></tr>';                
            }else{
                $secondTable .= '<tr><td class="bg-gray-f2 txt-black-24 txt-sline weight_600"><span class="txt-grn-lt">'.(strlen($category) > 50 ? substr($category,0,20)."..." : $category).'</span></td><td class="bg-gray-f2 txt-black-24 tt_uc_ fs-13_ txt-sline weight_600" style="width:100px;">strength</td></tr>';
                foreach($drugs as $drug)
                    $secondTable .= '<tr><td><label for="dual-gel-1p-5p" class="txt-blue tt_uc_ mb-0_ weight_600">'.$drug->generic_name.'</label><i style="font-size:10px;">('.($drug->drug_name).')</i> '.$drug->dosage_type.'</td><td class="txt-black-24 tt_uc_ fs-13_ weight_500">'.$drug->strength.'</td></tr>';                
            }
            
            $index ++;
        }
        
        if($firstTable == "")
            $firstTable .= "<tr><td colspan='3'>No Data Available.</td></tr>";
        
        return response()->json(['status'=>true,'first_table'=>$firstTable,'second_table'=>$secondTable]);
    }

    public function groupAddUpdate(Request $request){
    if($request->id)
    {
        $group=$request->all();
        /* Group user */
        // $gr_users=$group['users'];
        // $group=array_except($group,'users');
        /* end Group user */
        Group::where('id',$request->id)->update($group);
        $robj=Group::find($request->id);
        /* Group user */
        // $gu_ids=array_column($gr_users, 'id');
        // $del_gusrs=User::whereNotIn('id',$gu_ids)->where('group_id',$request->id)->delete();
        // foreach ($gr_users as $key => $value) {
        //     if(isset($value['id']) && in_array($value['id'], $gu_ids))
        //     {
        //         DB::table('model_has_roles')->where('model_id', $value['id'])->delete();
        //         $g_user=User::find($value['id']);
        //         $g_user->update([
        //             'name'=>$value['name'],
        //             'email'=>$value['email'],
        //             'role'=>$value['role']
        //         ]);
        //         $role = Role::find($value['role']);
        //         if ($role) {
        //             $g_user->assignRole($role);
        //         }
        //     }else{
        //         if($value['name']!=null && $value['email']!=null)
        //         {
        //             $password = str::random(5);
        //             $value['password'] = Hash::make($password);
        //             $usr=$robj->users()->create([
        //                 'name'=>$value['name'],
        //                 'email'=>$value['email'],
        //                 'role'=>$value['role'],
        //                 'password'=>$value['password']
        //             ]);
        //             $role = Role::find($value['role']);
        //             if ($role) {
        //                 $usr->assignRole($role);
        //             }
        //         }
        //     }
        // }
        /* end Group user */
    return response()->json(['status'=>true,'message'=>'Group updated successfully','group'=>$robj,'type'=>'update']);
    }else{
        $group=$request->all();
        /* Group user */
        // $gr_users=$group['users'];
        // $group=array_except($group,'users');
       /* end Group user */
      $robj=Group::create($group);
      /* Group user */
        // echo '<pre>';
      // foreach ($gr_users as $key => $value) {
      //   $UserData = array(0);
      //   $UserData = $value;
        
      //   $password = str::random(5);
      //   $UserData['password'] = Hash::make($password);
      //   $user = $robj->users()->create([
      //       'name' => $UserData['name'],
      //       'email' => $UserData['email'],
      //       'password' => $UserData['password'],
      //       'role'  => $UserData['role']
      //   ]);
      //    $role = Role::find($UserData['role']);

      //   if ($role) {
      //       $user->assignRole($role);
      //   }

      // }
     /* end Group user */
        return response()->json(['status'=>true,'message'=>'Group added successfully','group'=>$robj,'type'=>'add']);  
    }
    
}

public function getAllGroups(){
  $groups =  Group::with('practices')->get();
    return response()->json(['data'=>$groups]);
}

public function getGroupDetail($id){
    /*Group user*/
     // $group = Group::where('id', $id)->with('practice','users.roles')->first();
     // $data['practice']=$group->practice;
     // $data['users']=$group->users;
     // unset($group->practice);
     // unset($group->users);
     // $data['group']=$group;
    /*End group user*/
     $data['group']=Group::where('id', $id)->with('practices')->first();
      return response()->json($data);
}


    public function userStatistic(Request $request)
    {
        $cat = isset($request->Category) ? strtolower(str_replace([" "], "", $request->Category)) : 'DERMATOLOGY';

        $request['number_of_days'] = $request->number_of_days ?? '6';
        $data['categories'] = Drug::select([DB::raw('SUM(total_sale) AS total_sum'), 'major_reporting_cat'])
            ->whereNotIn('major_reporting_cat', ['', '0', '#N/A'])->groupBy('major_reporting_cat')->orderBy('major_reporting_cat', 'asc')->get();



        $result = Order::select([
            DB::raw('COUNT(Orders.PatientId) AS unique_users'), DB::raw('COUNT(CASE WHEN Orders.`OrderType` IS NULL OR Orders.`OrderType` = "RxOrder" THEN Orders.Id END) AS unique_prescriptions'),
            DB::raw('SUM(Orders.RxFinalCollect) AS client_sales'), DB::raw('SUM(Orders.RxProfitability) AS client_profitablility')
        ])
            ->when(!empty($request->session()->get('practice')), function ($query) use ($request) {

                $query->addSelect(['p.practice_name AS practice_name']);
                $query->addSelect(['p.id AS practice_id']);
                $query->where('p.id', $request->session()->get('practice')->id);
                $query->groupBy('p.id');
                $query->rightJoin('practices AS p', 'p.id', '=', 'Orders.PracticeId');
            })->when($request['number_of_days'] != 'all_activity', function ($query) use ($request) {

                $end_date = Carbon\Carbon::now()->format('Y-m-d');

                $start_date = Carbon\Carbon::now()->subDay($request['number_of_days'])->format('Y-m-d');

                $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '>=', $start_date);
                $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '<=', $end_date);
            })->get();


        $data['stats'] = $result;

        //--------get major categories by orders count------------------------

        $data['categories'] = DB::table('drugs_new AS d')->select([DB::raw('COUNT(o.Id) AS total_sum'), 'd.major_reporting_cat'])
            ->leftJoin('Orders AS o', 'o.DrugDetailId', '=', 'd.id')
            ->when(Session::has('practice'), function ($query) use ($request) {
                $query->addSelect([DB::raw('SUM(CASE WHEN o.PracticeId = ' . Session::get('practice')->id . ' THEN 1 ELSE 0 END) AS total_sum')]);
            })
            ->when($request['number_of_days'] != 'all_activity', function ($query) use ($request) {

                $end_date = Carbon\Carbon::now()->format('Y-m-d');

                $start_date = Carbon\Carbon::now()->subDay($request['number_of_days'])->format('Y-m-d');

                $query->where(DB::raw("DATE_FORMAT(o.created_at, '%Y-%m-%d')"), '>=', $start_date);
                $query->where(DB::raw("DATE_FORMAT(o.created_at, '%Y-%m-%d')"), '<=', $end_date);
            })
            ->whereNotIn('d.major_reporting_cat', ["", "0", "#N/A"])->groupBy('d.major_reporting_cat')
            ->orderBy('d.major_reporting_cat', 'asc')->get();

        //--------End get mojor categories by orrders count -------------

        //----------Selected major reproting category------------

        if ($cat != "") {
            // DB::enableQueryLog();
            $result = Order::select([
                DB::raw('DATE_FORMAT(Orders.nextRefillDate, "%m-%d-%Y") AS nextRefillDate'),
                DB::raw('(CASE WHEN pct.practice_code IS NULL THEN Orders.RxNumber ELSE CONCAT(pct.practice_code,"-",Orders.RxNumber) END) AS Rx'),
                'RefillsRemaining', 'DaysSupply', DB::raw('FORMAT(RxSelling,2) As  RxSelling'), 'asistantAuth', 'd.brand_reference',
                DB::raw('CONCAT( d.rx_label_name, " ", d.Strength, " ", d.dosage_form ) AS rx_label_name'),
                DB::raw('(SELECT FORMAT(CurrentEarnReward,2)CurrentEarnReward From ComplianceRewardPoint where Orders.Cr_Point_Id=RewardId) AS rewardAuth'),
                'Orders.Quantity AS qty', 'd.minor_reporting_class AS minor_reporting_class'
            ])
                ->join('drugs_new AS d', 'd.id', '=', 'Orders.DrugDetailId')
                ->join('practices AS pct', 'pct.Id', '=', 'Orders.PracticeId')
                ->when(!empty($cat), function ($query) use ($cat) {
                    $query->where(DB::raw('REPLACE(LOWER(d.major_reporting_cat), " ", "")'), $cat);
                })
                ->when($request['number_of_days'] != 'all_activity', function ($query) use ($request) {

                    $end_date = Carbon\Carbon::now()->format('Y-m-d');

                    $start_date = Carbon\Carbon::now()->subDay($request['number_of_days'])->format('Y-m-d');

                    $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '>=', $start_date);
                    $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '<=', $end_date);
                })->when(Session::has('practice'), function ($query) use ($request) {
                    $query->where('Orders.PracticeId', Session::get('practice')->id);
                })->orderBy('nextRefillDate', 'DESC')->groupBy('Orders.Id')->get();
            // dump(DB::getQueryLog());
            $data['result'] = $result->toArray();

            $data['report_title'] = ucwords(str_replace('-', ' ', $cat)) . ' (' . $result->count() . ')';
            $data['tab_title'] = [['title' => 'Date', 'style' => 'style=width:90px;'], 'Rx #', 'Rx Label Name', 'Qty', 'Minor Category'];
            $data['count_field'] = count($data['tab_title']);
        }
        //---------End Selected Major Reporting Category-------
        if ($request->ajax()) {
            $new_dat['result'] = $data['result'];
            // dd($data['result']);
            $new_dat['stats'] = $data['stats'];
            return view('reports.includes.user_statistics_table', $new_dat);
        } else {
            return view('reports.user_statistics', $data);
        }
    }

    public function get_categories(Request $request)
    {
        if ($request->has('number_of_days')) {
            $days = $request->number_of_days;
            $categories = DB::table('drugs_new AS d')->select([DB::raw('COUNT(o.Id) AS total_sum'), 'd.major_reporting_cat'])
                ->leftJoin('Orders AS o', 'o.DrugDetailId', '=', 'd.id')
                ->when(Session::has('practice'), function ($query) use ($request) {
                    $query->addSelect([DB::raw('SUM(CASE WHEN o.PracticeId = ' . Session::get('practice')->id . ' THEN 1 ELSE 0 END) AS total_sum')]);
                })
                ->when($days != 'all_activity', function ($query) use ($days) {

                    $end_date = Carbon\Carbon::now()->format('Y-m-d');
                    $start_date = Carbon\Carbon::now()->subDay($days)->format('Y-m-d');

                    $query->where(DB::raw("DATE_FORMAT(o.created_at, '%Y-%m-%d')"), '>=', $start_date);
                    $query->where(DB::raw("DATE_FORMAT(o.created_at, '%Y-%m-%d')"), '<=', $end_date);
                })
                ->whereNotIn('d.major_reporting_cat', ["", "0", "#N/A"])->groupBy('d.major_reporting_cat')
                ->orderBy('d.major_reporting_cat', 'asc')->get();
            $options = '<option value="">Select Category</option>';
            foreach ($categories as $keyCat => $valCat) {
                $options .= '<option value="' . $valCat->major_reporting_cat . '">' . $valCat->major_reporting_cat . ' <span class="txt-red">(' . $valCat->total_sum . ')</span></option>';
            }


            $result = Order::select([
                DB::raw('COUNT(Orders.PatientId) AS unique_users'), DB::raw('COUNT(CASE WHEN Orders.`OrderType` IS NULL OR Orders.`OrderType` = "RxOrder" THEN Orders.Id END) AS unique_prescriptions'),
                DB::raw('SUM(Orders.RxFinalCollect) AS client_sales'), DB::raw('SUM(Orders.RxProfitability) AS client_profitablility')
            ])
                ->when(!empty($request->session()->get('practice')), function ($query) use ($request) {
    
                    $query->addSelect(['p.practice_name AS practice_name']);
                    $query->addSelect(['p.id AS practice_id']);
                    $query->where('p.id', $request->session()->get('practice')->id);
                    $query->groupBy('p.id');
                    $query->rightJoin('practices AS p', 'p.id', '=', 'Orders.PracticeId');
                })->when($request['number_of_days'] != 'all_activity', function ($query) use ($request) {
    
                    $end_date = Carbon\Carbon::now()->format('Y-m-d');
    
                    $start_date = Carbon\Carbon::now()->subDay($request['number_of_days'])->format('Y-m-d');
    
                    $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '>=', $start_date);
                    $query->where(DB::raw("DATE_FORMAT(Orders.created_at, '%Y-%m-%d')"), '<=', $end_date);
                })->get();
    
    
            $data['options'] =  $options;

            $data['stats_area_to'] = '<div class="p6-12_ mr-7_" style="border-radius: 24px; border: solid 1px #dee2e6;"> <span class="txt-black-24 fs-13_ mr-4_">'.(isset($result[0]->unique_users)?$result[0]->unique_users:'0').'</span> <span class="txt-gray-6 fs-13_ ">Unique Patients</span> </div>
            <div class="p6-12_ mr-7_" style="border-radius: 24px; border: solid 1px #dee2e6;"> <span class="txt-black-24 fs-13_ mr-4_">'.(isset($result[0]->unique_prescriptions)?$result[0]->unique_prescriptions:'0').'</span> <span class="txt-gray-6 fs-13_ ">Unique Prescriptions</span> </div>
            <div class="p6-12_ mr-7_" style="border-radius: 24px; border: solid 1px #dee2e6;"> <span class="txt-black-24 fs-13_ mr-4_">$'. (isset($result[0]->client_sales)?number_format($result[0]->client_sales, 2):'0.00') .'</span> <span class="txt-gray-6 fs-13_ ">Client Sales</span> </div>
            <div class="p6-12_ mr-7_" style="border-radius: 24px; border: solid 1px #dee2e6;"> <span class="txt-black-24 fs-13_ mr-4_">$'.(isset($result[0]->client_sales)?number_format($result[0]->client_profitablility, 2):'0.00') .'</span> <span class="txt-gray-6 fs-13_ ">Client Profitability</span> </div>';
            return  $data;
        }
    }

    public function clientDashboard(Request $request, $web_stat = false)
    {
        $reports = new Reports();
        $data = [];

        if ($request->has('report_type') and $request->report_type == 'top_products_sale') {
            $data['report_title']  = 'Top Products By Sale ( Past ' . $request->number_of_days . ' Days)';
            $response = $reports->top_products_sale($request->number_of_days, $request->session());
            $data['count_field'] = count($response['tab_title']);
            $data = array_merge($data, $response);
        }

        if ($request->has('report_type') and $request->report_type == 'rx_refill_due_and_remaining') {
            $data['report_title'] = 'Rx with Refills Due Soon ( Next ' . $request->number_of_days . ' Days)';
            $response = $reports->refills_due($request->number_of_days, $request->session());
            $data['count_field'] = count($response['tab_title']);
            $data = array_merge($data, $response);
        }

        if ($request->has('report_type') and $request->report_type == 'product_profitablity') {
            $data['report_title'] = 'Top Products by Profitability ( Past ' . $request->number_of_days . ' Days)';
            $response = $reports->top_product_profitablity($request->number_of_days, $request->session());
            $data['count_field'] = count($response['tab_title']);
            $data = array_merge($data, $response);
        }

        if ($request->has('web_stat') and !$request->has('report_type')) {
            //dd($request);

            $response = $reports->web_stat_report($request->duration, $request->web_stat);
            $data['count_field'] = count($response['tab_title']);
            $data = array_merge($data, $response);

            $data['web_statis'] = true;
        }

        // web queue statistics ----------
        $data['webstat_counts'] = $reports->web_queue_stats_counts();
        // end web queue statistics ---------
        return view('reports.client_dashboard', $data);
    }
    function acknowledgePractice($pid, $ptype)
    {
        $status = Practice::where('id', $pid)->update(['reviewed' => 1]);
        if ($status) {
            if ($ptype == "Pharmacy") {
                $practices = Practice::where(['practice_type' => 'Pharmacy', 'reviewed' => NULL])->with('users')->get();
            } else if ($ptype == "Physician") {
                $practices = Practice::where(function ($query) {
                    $query->where('practice_type', 'Physician');
                    $query->where('added_from_pharmacy', NULL);
                    $query->where('reviewed', NULL);
                })->with('users')->get();
            } else if ($ptype == "Law") {
                $practices = Practice::where(['practice_type' => 'Law', 'reviewed' => NULL])->with('users')->get();
            }

            return response()->json(['status' => $status, 'count' => count($practices)]);
        }
    }



    public function agreement(Request $request)
    {
        if($request->has('accepted_terms_signature') && $request->accepted_terms_signature != null){
            $data = $this->createImageFromBase64Store($request->accepted_terms_signature, 1);
        }else{
            return redirect()->back()->with('message','Signature is required');
        }
        // dd($request->all());
        // return $request->all();
        // dump($request->prac_id);
        if ($request->has('prac_id') && $request->prac_id != null) {
            $practice = Practice::find($request->prac_id);
if(!$practice->businessAgreement){
            $practice_new =  $practice->businessAgreement()->create(
                [
                'accepted_terms' => 1,
                'accepted_terms_user'  => $request->accepted_terms_user,
                'accepted_terms_user_id'  => $request->user_id,
                'accepted_terms_role'  => $request->accepted_terms_role,
                'accepted_terms_signature'  => $data,
                'accepted_terms_dt' =>  Carbon\Carbon::now()->toDateTimeString()
          
                ]
            );
        }else{
            $practice->businessAgreement()->update([
                'accepted_terms' => 1,
                'accepted_terms_user'  => $request->accepted_terms_user,
                'accepted_terms_user_id'  => $request->user_id,
                'accepted_terms_role'  => $request->accepted_terms_role,
                'accepted_terms_signature'  => $data,
                'accepted_terms_dt' =>  Carbon\Carbon::now()->toDateTimeString()
            ]); 
        }
            /*
            $practice = Practice::find($request->prac_id);
            $practice->accepted_terms = 1;
            $practice->accepted_terms_user  = $request->accepted_terms_user;
            $practice->accepted_terms_user_id  = $request->user_id;
            $practice->accepted_terms_role  = $request->accepted_terms_role;
            $practice->accepted_terms_signature  = $data;

            $practice->accepted_terms_dt =  Carbon\Carbon::now()->toDateTimeString();
            $practice->save();

            */
            // dump($practice);
            // dd($practice_new);
               $business_agree = $practice->first()->businessAgreement;
                         if($business_agree)
                           $prac = $business_agree->rp_accepted_terms;
                           else
                           $prac = null;

            if(!isset($prac) && $prac == null)
                return redirect('rppa');
            else
                return redirect('patient');
        } else {
            return redirect()->back();
        }
    }

    public function rp_agreement(Request $request)
    {
        if($request->has('accepted_terms_signature') && $request->accepted_terms_signature != null){
        $data = $this->createImageFromBase64Store($request->accepted_terms_signature, 1);
    }else{
        return redirect()->back()->with('message','Signature is required');
    }
        // dump($data);
        // return $request->all();
        // dump($request->prac_id);
        if ($request->has('prac_id') && $request->prac_id != null) {
            $practice = Practice::find($request->prac_id);
            $practice->businessAgreement->rp_accepted_terms = 1;
            $practice->businessAgreement->rp_accepted_terms_user  = $request->accepted_terms_user;
            $practice->businessAgreement->rp_accepted_terms_user_id  = $request->user_id;
            $practice->businessAgreement->rp_accepted_terms_role  = $request->accepted_terms_role;
            $practice->businessAgreement->rp_accepted_terms_signature  = $data;

            $practice->businessAgreement->rp_accepted_terms_dt =  Carbon\Carbon::now()->toDateTimeString();
            $practice->businessAgreement->save();
            // dump($practice);
            return redirect('patient');
        } else {
            return redirect()->back();
        }
    }

    public function rp_admin_agreement(Request $request)
    {
        $data = $this->createImageFromBase64Store($request->accepted_terms_signature);
        if ($request->has('prac_id') && $request->prac_id != null) {
            $practice = Practice::find($request->prac_id);
            $practice->businessAgreement->cr_accepted_terms = 1;
            $practice->businessAgreement->cr_accepted_terms_user  = $request->accepted_terms_user;
            $practice->businessAgreement->cr_accepted_terms_user_id  = $request->user_id;
            $practice->businessAgreement->cr_accepted_terms_role  = $request->accepted_terms_role;
            $practice->businessAgreement->cr_accepted_terms_signature  = $data;

            $practice->businessAgreement->cr_accepted_terms_dt =  Carbon\Carbon::now()->toDateTimeString();
            $practice->businessAgreement->save();
            return redirect('signed');
        } else {
            return redirect()->back();
        }
    }


    public function baa_admin_agreement(Request $request)
    {
        $data = $this->createImageFromBase64Store($request->accepted_terms_signature);
        if ($request->has('prac_id') && $request->prac_id != null) {
            $practice = Practice::find($request->prac_id);
            $practice->businessAgreement->crb_accepted_terms = 1;
            $practice->businessAgreement->crb_accepted_terms_user  = $request->accepted_terms_user;
            $practice->businessAgreement->crb_accepted_terms_user_id  = $request->user_id;
            $practice->businessAgreement->crb_accepted_terms_role  = $request->accepted_terms_role;
            $practice->businessAgreement->crb_accepted_terms_signature  = $data;

            $practice->businessAgreement->crb_accepted_terms_dt =  Carbon\Carbon::now()->toDateTimeString();
            $practice->businessAgreement->save();
            return redirect('signed');
        } else {
            return redirect()->back();
        }
    }

    public function createImageFromBase64Store($base64image, $rp=0)
    {

        $file_data = $base64image;
        $img = preg_replace('/^data:image\/\w+;base64,/', '', $file_data);
        $type = explode(';', $file_data)[0];
        $type = explode('/', $type)[1];

        $file_name = $rp == 0 ? 'signature_' . time() . str_random(8) . '.' . $type : 'rp_signature_' . time() . str_random(8) . '.' . $type;

        @list($type, $file_data) = explode(';', $file_data);

        @list(, $file_data) = explode(',', $file_data);

        if ($file_data != "") {
            $image_stor =   \Storage::disk('public')->put($file_name, base64_decode($file_data));
            if ($image_stor) {
                return $file_name;
            }
        }
    }

    public function  getSignedPractices()
    {
        $data['facilitator'] = Facilitator::get();

        $data['practices'] = Practice::whereHas(
            'businessAgreement', function ($query) {
                                $query->where('accepted_terms', 1)->where('rp_accepted_terms', 1);
            }
        )->with(
            [
            'businessAgreement' =>  function ($query) {
                          $query->where('accepted_terms', 1)->where('rp_accepted_terms', 1);
            }
            ]
        )->get()->toArray();
        // dd($data['practices']);
        $data['state'] = DB::table('State')->get();
        $data['groups']=Group::get();
        return view('baa.signed_practices', $data);
    }

    public function showBAA($id)
    {
        $practice = Practice::where('id', $id)->with('businessAgreement')->first();

        $result['practice'] = $practice;

        //return response()->json($result);
        return view('baa.view-baa', $result);
    }

    public function showRPPA($id)
    {
        $practice = Practice::where('id', $id)->with('businessAgreement')->first();
        $result['practice'] = $practice;

        return view('baa.view-rppa', $result);
    }

    public function editRPPA($id)
    {
        $practice = Practice::where('id', $id)->with('users.roles','businessAgreement')->first();
        $result['practice'] = $practice;

        return view('baa.edit-rppa', $result);
    }


    public function editBAA($id)
    {
        $practice = Practice::where('id', $id)->with('users.roles','businessAgreement')->first();
        $result['practice'] = $practice;

        return view('baa.edit-baa', $result);
    }

    public function download_agreement($aid,$type)
    {

        $practice = Practice::where('id', $aid)->with('businessAgreement')->first();
        $result['practice'] = $practice;

        //return response()->json($result);
        //return view('baa.baa_of_practice', $result);
        if($type){
        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
        ->loadView('baa.'.$type.'_pdf', $result);
        return $pdf->download($type.'_agreement_pdf_'.time().'.pdf');
        }else{
return redirect()->back()->with('message','no type selected');
        }


    }
    public function getBaseFee(Request $request)
    {
        if(isset(auth::user()->practices->first()->id) && auth::user()->practices->first()->id != NULL && !auth::user()->hasRole('practice_super_group'))
        {
            $base_fee = Service::whereIn("practice_id", auth::user()->practices->pluck('id'))->first();
            return response()->json(['data'=>$base_fee]);
        }
    }
    
    public function updateDrugPosition(Request $request)
    {
        $drugs = explode(",", $request->drug_ids);
        $positions = explode(",", $request->sequences);
        foreach($drugs as $key =>$id){
             \App\OrderSheetDrug::where('order_sheet_category_id',$request->cat_id)->where('drug_name',$id)->update(
                ['position' => $positions[$key]]            
            );
        }
        return "success";
    }
}

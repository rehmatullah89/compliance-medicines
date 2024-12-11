<?php

namespace App\Http\Controllers;

use App\Practice;
use Illuminate\Contracts\Auth\StatefulGuard;
use Session;
use App\Mail\Enrollment;
use App\Order;
use App\Patient;
use App\Enrollment as Enroll;
use App\Reports;
use App\PatientDeliveryAddress;
use Illuminate\Http\Request;
use auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Validator;
use Carbon\Carbon;
use App\Sponsors;
use DB;
use App\QuestionAnswer;
use App\Service;
use Mockery\Undefined;
use Pusher\Pusher;

class PatientController extends Controller
{

    /** Alert Patient Count **/
    public function alertPatientCount($pharmacy,$message)
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Sponsors::all();
        $data['enrol_page_slider'] = $banners->where('page_id', 2)->where('type_image', 'Slider');
        $data['enrol_page_simple'] = $banners->where('page_id', 2)->where('type_image', 'Simple');

      

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
                ->whereNotNull('Practice_ID')
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'))->get();

// dd($data['last_seven_days']);
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
        ->whereNotNull('Practice_ID')
            ->first();

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
            ->whereNotNull('Practice_ID')
            ->get();
                
if(!auth::user()->hasRole('compliance_admin') && !auth::user()->hasRole('practice_admin'))
    {
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


}

        // dd($data['practices']);
        #[new chnages in view and new file search1 by Matee]
        return view('practice_module.search1', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $states = DB::table('State')->get();
       
        $pharmacies = Practice::whereIn('practice_type', ['Pharmacy'])
        // ['Pharmacy', 'Law','Physician']
            ->when(auth::user()->hasRole('super_admin'), function ($query) {
                $query->whereIn('id', auth::user()->practices->pluck('id'))->orWhereIn('parent_id', auth::user()->practices->pluck('id'));
            })
            ->when(auth::user()->hasRole('practice_super_group'),function($query){
                $query->whereIn('id',auth::user()->practices->pluck('id'));
        })
        ->where('practice_type','Pharmacy')
        ->whereNull('added_from_pharmacy')
        ->whereNotNull('practice_name')->get();

        if (isset(auth::user()->practices->first()->id) && auth::user()->practices->first()->id != null && !auth::user()->hasRole('practice_super_group')) {
            $pid = auth::user()->practices->first()->id;
            $base_fee = Service::where("practice_id", $pid)->first();
            // dd($base_fee);
        }
        return view('practice_module.create', compact("pharmacies", "states", "base_fee"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $email_check = Patient::select(DB::raw('AES_DECRYPT (FROM_BASE64(EmailAddress),"ss20compliance19") AS EmailAddress'))->whereRaw(' AES_DECRYPT (FROM_BASE64(EmailAddress),"ss20compliance19") = "' . $request->EmailAddress . '"')->first();
        if ($email_check == null) {
            $phone_check = Patient::select(DB::raw('AES_DECRYPT (FROM_BASE64(MobileNumber),"ss20compliance19") AS MobileNumber'))->whereRaw(' AES_DECRYPT (FROM_BASE64(MobileNumber),"ss20compliance19") = "' . $request->MobileNumber . '"')->first();
            if ($phone_check == null) {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'FirstName' => 'required',
                        'LastName' => 'required',
                        'EmailAddress' => 'required|email',
                        'preffered_method_contact' => 'required|in:Email,Text'
                    ]
                );
                $error = false;
                $p_id =  (isset(auth::user()->practices->first()->id) && !auth::user()->hasRole('super_admin') && !auth::user()->hasRole('practice_super_group')) ?
                    auth::user()->practices->first()->id : (isset(Session::get('practice')->id) ?
                        Session::get('practice')->id : (isset($request->practice_Id) ?
                            $request->practice_Id : ''));
                /*   if(auth::user()->hasRole('super_admin') && $request->practice_Id){
                                $p_id =   $request['practice_Id'];
                            }

                            if(auth::user()->hasRole('super_admin') && isset(Session::get('practice')->id)){
                                $p_id =   Session::get('practice')->id;
                            } */
                if ($request->has('practice_Id')) {
                    unset($request['practice_Id']);
                }
                if (!$p_id) {
                    return response()->json(
                        [
                            'message' => "Please Select Practice to Enroll",
                            'status' => false
                        ]
                    );
                }

                if ($validator->passes()) {
                    $mobile_number = $request->MobileNumber;
                    $request['Practice_ID'] = $p_id;
                    $request['UpdatedOn'] = Carbon::now()->toDateTimeString();
                    $request['CreatedOn'] = Carbon::now()->toDateTimeString();
                    $request['MobileNumber'] = $mobile_number;
                    $request['Status'] = 'Pending';
                    $request['CreatedBy'] = 0;
                    $request['UpdatedBy'] = 0;
                    //dd($request);
                    $patient = Patient::create($request->all());
                    $term_and_con =  Enroll::where(
                        function ($q) use ($request) {
                            return $q->where('MobileNumber', $request['MobileNumber'])
                                ->whereNotNull('deleted_at');
                        }
                    )->first();
                    // dd($term_and_con);
                    if ($term_and_con && $patient) {
                        $term_and_con->preffered_method_contact = $request->preffered_method_contact;
                        $term_and_con->patient_id = $patient->Id;
                        $term_and_con->Email = $patient->EmailAddress;
                        $term_and_con->save();
                        $enrollment = $patient->enrollment()->first();
                        $enrollment['id'] = $enrollment->id;
                        $enrollment['unique_key'] = $enrollment->unique_key;
                    } else {
                        $enrollment = '';

                        if (!$error && $patient) {
                            $enrollment =  $patient->enrollment()->create(
                                [
                                    'email_body' => 'email sent this was message',
                                    'enrollment_status' => 'New',
                                    'unique_key' => Str::random(40),
                                    'Email' => $request->EmailAddress,
                                    'MobileNumber' => trim($request['MobileNumber']),
                                    'preffered_method_contact' =>
                                    $request->preffered_method_contact
                                ]
                            );
                        } else {
                            return response()->json(
                                [
                                    'message' => "Patient could't created. Something went wrong",
                                    'status' => false
                                ],
                                400
                            );
                        }
                    }
                    if ($patient) {
                        $deliveryAddress = new PatientDeliveryAddress();
                        $deliveryAddress->PatientId = $patient->Id;
                        $deliveryAddress->Address = $patient->Address;
                        $deliveryAddress->City = $patient->City;
                        $deliveryAddress->StateId = $request['State'];
                        $deliveryAddress->Zip = $request['ZipCode'];
                        $deliveryAddress->AddressType = "PermanentAddress";
                        $deliveryAddress->DefaultAddress  = 'No';
                        $deliveryAddress->CreatedOn  = Carbon::now()->toDateTimeString();
                        $deliveryAddress->UpdatedOn  = Carbon::now()->toDateTimeString();
                        $deliveryAddress->CommenceDate  = date('d/m/Y', strtotime(Carbon::now()->toDateString()));
                        $deliveryAddress->CeaseDate  = date('d/m/Y', strtotime(Carbon::now()->toDateString()));
                        $deliveryAddress->save();
                        if ($deliveryAddress) {
                            $previous_patient = Patient::find($patient->Id);
                            //  (java team asked to remove 9 jan 2020) $previous_patient->BillingAddressId = $deliveryAddress->Id;
                            $previous_patient->update();
                        }
                    }
                    $send = '';
                    if ($enrollment->enrollment_status == "New") {
                        if ($request->preffered_method_contact == 'Email') {
                            //send email
                            $practice =   Practice::where('id', $p_id)
                                ->pluck('practice_name');
                            $enrollment['FirstName'] = $request->FirstName;
                            $enrollment['practice'] = $practice;
                            $send = Mail::to($request->EmailAddress)
                                ->send(
                                    new Enrollment($enrollment)
                                );

                            if (!$send) {
                                $error = false;
                            }
                        } else {
                            $send =  $this->sendEnrollment($mobile_number);
                            $error = false;
                        }
                    } else {
                        return response()->json(['message' => "Patient has been enrolled successfully", "patient" => $patient, 'enrollment' => $enrollment, 'status' => true], 200);
                    }
                    if ($request->ajax()) {
                        if ($enrollment && !$error) {
                            $this->alertPatientCount($p_id ,'patient_added');
                            return response()->json(['message' => "Patient has been Enrolled successfully Waiting to accept terms and conditions $send", "patient" => $patient, 'enrollment' => $enrollment, 'status' => true], 200);
                        }
                        return response()->json(['message' => "Cannot Enroll! something went wrong.", 'status' => false]);
                    } else {
                        return "not ajax";
                    }
                }
                return response()->json(['error' => $validator->errors()->all(), 'status' => false]);
            } else {
                //                dd('phone error');
                return response()->json(['status' => false, 'message' => 'Mobile Number Already Exists']);
            }
        } else {
            //            dd('email error');
            return response()->json(['status' => false, 'message' => 'Email Already Exists']);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show(Patient $patient)

    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *

     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient)
    {
        $total =  Order::where('PatientId', $patient->Id)->sum('RxPatientOutOfPocket');

        if ($patient)
            return view('patient_module.enrolled', compact('patient', 'total'));
        else
            return redirect()->back()->with('message', "No Patient Found");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request

     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patient)
    {

        // unset($request['_token']);
        // unset($request['_method']);

        // $patientMobile = Patient::where('MobileNumber',$request['MobileNumber'])->where('Id','!=',$request['PatientId'])->first();
        $patientMobile = Patient::whereRaw(' AES_DECRYPT (FROM_BASE64(MobileNumber),"ss20compliance19") = "' . $request['MobileNumber'] . '"')->where('Id', '!=', $request['PatientId'])->first();

        // $patientEmail = Patient::where('EmailAddress',$request['EmailAddress'])->where('Id','!=',$request['PatientId'])->first();
        $patientEmail = Patient::whereRaw(' AES_DECRYPT (FROM_BASE64(EmailAddress),"ss20compliance19") = "' . $request['EmailAddress'] . '"')->where('Id', '!=', $request['PatientId'])->first();

        // dd($patientEmail);

        if ($patientMobile) {
            Session::flash('message', "Mobile phone already exist");
            // return redirect()->to('patient/order/'.$patient->Id);
            return response()->json(['status' => false, 'data' => $request->all(), 'message' => 'Mobile phone already exist'], 200);
        }

        if ($patientEmail) {
            Session::flash('message', "Email phone already exist");
            // return redirect()->to('patient/order/'.$patient->Id);
            return response()->json(['status' => false, 'data' => $request->all(), 'message' => 'Email already exist'], 200);
        }

        $messageOldPhone = 'Your phone number for Compliance reward account have been changed please logon to application with new Phone.';
        $messageNewPhone = 'Your phone number for Compliance Reward have been successfully changed please logon to application with new phone number.';

        $patientMobileChange = Patient::find($request['PatientId']);
        if ($patientMobileChange && $patientMobileChange->MobileNumber != $request->MobileNumber) {
            $response =  $this->phone_change_message($patientMobileChange->MobileNumber, $messageOldPhone);
            $request->request->add(['PrevMobile' => $patientMobileChange->MobileNumber]);
            $request->request->add(['SecurityToken' => Null]);
            // array_merge($request->all(), ['PrevMobile' => $patientMobileChange->MobileNumber]);

            // array_merge($request->all(), ['SecurityToken' => Null]);
        }

        unset($request['PatientId']);
        $updatedPatient = $patient->update($request->all());

        if ($updatedPatient) {
            $patient->enrollment()->update(['preffered_method_contact' => $request->preffered_method_contact, 'MobileNumber' => $request->MobileNumber, 'Email' => $request->EmailAddress]);
            if ($patientMobileChange && $patientMobileChange->MobileNumber != $request->MobileNumber) {
                $response1 =  $this->phone_change_message($request->MobileNumber, $messageNewPhone);
            }
        }

        if ($patient) {

            Session::flash('message', "profile updated successfully");
            // return redirect()->to('patient/order/'.$patient->Id);
            if (isset($response) && isset($response1)) {
                return response()->json(['status' => true, 'data' => $request->all(), 'message' => 'Patient updated successfully', 'old_msg' => $response, 'new_msg' => $response1], 200);
            } else {
                return response()->json(['status' => true, 'data' => $request->all(), 'message' => 'Patient updated successfully'], 200);
            }
        } else {
            Session::flash('error', "profile could not updated successfully");
            // return redirect()->to('/patient/order/'.$patient->Id);
            return response()->json(['status' => false, 'message' => 'Patient cannot updated'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *

     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        //
    }


    public function enrollPatient($uniqueKey, $id)
    {
        $enrollment = \App\Enrollment::where('unique_key', $uniqueKey)->where('id', $id)->first();
        if ($enrollment) {
            if ($enrollment->enrollment_status == "New") {
                $enrollment->enrollment_status = "Enrolled";
                if (($enrollment->patient_id) && is_int($enrollment->patient_id)) {
                    $order = Patient::find($enrollment->patient_id)->Orders()->update(['OrderStatus' => 2]);
                    $enrollment->save();
                    return view('patient_module.enrollmentSuccess')->with('message', "Congratulations! You have been enrolled successfully!");
                }
            } else {
                return view('patient_module.enrollmentSuccess')->with('message', "You are already enrolled.");
            }
        } else {
            return view('patient_module.enrollmentSuccess')->with('message', "Not Found");
        }
    }


    public function searchPatient(Request $request)
    {
        if ($request->ajax() && $request->psearch) {
            $search = strtolower($request->psearch);

            DB::enableQueryLog();
            $currentPractice = auth::user()->practices->first()->id;

            parse_str($request->getContent(), $arr);

            $totalCount = Patient::count();
            $totalFiltered = Patient::select(DB::raw('Practice_ID,Gender, ZipCode, Id ,
            LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(FirstName),"ss20compliance19") USING "utf8")) AS FirstName,
            LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(LastName),"ss20compliance19")USING "utf8")) AS LastName,
            AES_DECRYPT (FROM_BASE64(MobileNumber),"ss20compliance19") AS MobileNumber,
             AES_DECRYPT (FROM_BASE64(EmailAddress),"ss20compliance19") AS EmailAddress,
             AES_DECRYPT (FROM_BASE64(BirthDate),"ss20compliance19") AS BirthDate'))
                ->whereRaw('  LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(FirstName),"ss20compliance19")USING "utf8")) Like "%' . $search . '%"')
               ->orWhereRaw(' LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(LastName),"ss20compliance19")USING "utf8")) Like "%' . $search . '%"')
               ->orWhereRaw('CONCAT(LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(FirstName),"ss20compliance19") USING "utf8")), LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(LastName),"ss20compliance19")USING "utf8")))  Like "%'.$search.'%"'  )
               ->orWhereRaw(' AES_DECRYPT (FROM_BASE64(EmailAddress),"ss20compliance19") Like "' . $search . '"')
                ->orWhereRaw(' AES_DECRYPT (FROM_BASE64(MobileNumber),"ss20compliance19") Like "%' . $search . '%"')
                ->where(function ($query) use ($currentPractice) {
                    $query->where('Practice_ID', '=', $currentPractice);
                })
                ->whereNotNull('Practice_ID')
                ->having('Practice_ID', $currentPractice)->get()
                ->count();

            $patient = Patient::select(DB::raw('Practice_ID,Gender, ZipCode, Id ,
            LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(FirstName),"ss20compliance19") USING "utf8")) AS FirstName,
            LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(LastName),"ss20compliance19")USING "utf8")) AS LastName,
            AES_DECRYPT (FROM_BASE64(MobileNumber),"ss20compliance19") AS MobileNumber,
             AES_DECRYPT (FROM_BASE64(EmailAddress),"ss20compliance19") AS EmailAddress,
             AES_DECRYPT (FROM_BASE64(BirthDate),"ss20compliance19") AS BirthDate'))
                ->whereRaw('  LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(FirstName),"ss20compliance19")USING "utf8")) Like "%' . $search . '%"')
                ->orWhereRaw(' LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(LastName),"ss20compliance19")USING "utf8")) Like "%' . $search . '%"')
                ->orWhereRaw('CONCAT(LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(FirstName),"ss20compliance19") USING "utf8")), LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(LastName),"ss20compliance19")USING "utf8")))  Like "%'.$search.'%"'  )
                ->orWhereRaw(' AES_DECRYPT (FROM_BASE64(EmailAddress),"ss20compliance19") Like "' . $search . '"')
                ->orWhereRaw(' AES_DECRYPT (FROM_BASE64(MobileNumber),"ss20compliance19") Like "%' . $search . '%"')
                ->where(function ($query) use ($currentPractice) {
                    $query->where('Practice_ID', '=', $currentPractice);
                })
                ->whereNotNull('Practice_ID')
                ->having('Practice_ID', $currentPractice)
                ->offset($arr['start'])->limit($arr['length'])
                ->get();

            if ($patient)
                return response()->json(['message' => "done", "patient" => $patient, "status" => true, 'length' => $arr['length'], 'recordsTotal' => $totalCount, 'recordsFiltered' => $totalFiltered, 'draw' => intval($arr['draw']), 'start' => $arr['start'], 'all' => $arr], 200);
            else
                return response()->json(['message' => "not found", "patient" => 'not found', "status" => false], 200);
        }
    }




    public function patientRequestProcess(Request $request)
    {
        if ($request->ids) {
            $order = Order::find($request->ids);
            $patient =  Patient::find($order->PatientId)->enrollment;
            if ($order) {
                if ($patient->enrollment_status == "New") {
                    return response()->json(['status' => false, "statusChanged" => false, 'message' => "please enrol first"]);
                }
                $order->OrderStatus = 8;
                $order->RxProcessed_At = Carbon::now();
                if ($order->save()) {
                    return response()->json(['status' => true, "statusChanged" => true]);
                }
            }
        }
    }





    public function patientOrder($id, $oid = false)
    {
        $order = null;
        if ($oid) {
            $order = Order::where('Orders.Id', $oid)
                ->join('drugs_new', 'drugs_new.id', 'Orders.DrugDetailId')->first();
        }

        $patient =  Patient::where('PatientProfileInfo.Id', $id)->with('practice')->join('State', 'PatientProfileInfo.State', 'State.Id')
            ->select('PatientProfileInfo.*', 'State.Abbr as State', 'State.Id as StateId')->first();

        $states = DB::table('State')->get();

        $total =  Order::where('PatientId', $id)->sum('RxPatientOutOfPocket');
        $totalOrder =  Order::where('PatientId', $patient->Id)->count();
        if ($patient->practice) {
            $pid = $patient->practice->id;
            $base_fee = Service::where("practice_id", $pid)->first();
            // dd($base_fee);
        }


        if ($patient) {
            return view('practice_module.enrolled', compact('patient', 'total', 'states', 'order', 'totalOrder', 'base_fee'));
        } else {
            return redirect()->back()->with('message', "No Patient Found");
        }
    }

    public function getPatineInfo(Request $request)
    {
        //        dd($request->all());
        $type = $request->checkType;
        $patient_id = $request->patient_id;
        if ($type == 'email_phone') {
            $patient = DB::table('PatientProfileInfo')
                ->where('Id', $patient_id)->first();
            $result = [];
            if ($patient) {
                $result['mobile_number'] = decrypted_attr($patient->MobileNumber);
                $result['email'] = decrypted_attr($patient->EmailAddress);
                //                dd($result,$patient->MobileNumber,$patient->EmailAddress);
                return response()->json(['status' => 200, 'data' => $result]);
            } else {
                return response()->json(['status' => 400, 'data' => $result]);
            }
        } else if ($type == 'address') {
            $patient = DB::table('PatientProfileInfo')
                ->where('Id', $patient_id)->first();
            $result = [];
            if ($patient) {
                //               $state = DB::table('State')->where('Id',$patient->State)->first();
                $result['address'] = $patient->Address;
                $result['City'] = $patient->City;
                $result['state'] = $patient->State;
                $result['zipCode'] = $patient->ZipCode;
                return response()->json(['status' => 200, 'data' => $result]);
            } else {
                return response()->json(['status' => 400, 'data' => $result]);
            }
        } else if ($type == 'allergies') {
            $patients = DB::table('PatientAllergies')
                ->where('PatientId', $patient_id)->get();
            $result = [];
            if ($patients) {
                $result = $patients;
                return response()->json(['status' => 200, 'data' => $result]);
            } else {
                return response()->json(['status' => 400, 'data' => $result]);
            }
        } else if ($type == 'insurance_cards') {
            $patients = DB::table('PatientInsuranceDetails')->where('PatientId', $patient_id)->get();
            // dd($patients);
            $result = [];
            if ($patients) {
                $result = $patients;
                return response()->json(['status' => 200, 'data' => $result]);
            } else {
                return response()->json(['status' => 400, 'data' => $result]);
            }
        }
    }

    public function updatePatientInfo(Request $request)
    {
        $type = $request->type;
        $patient_id = $request->patient_id;
        if ($type == 'email_phone') {
            $patinet = Patient::find($patient_id);
            if ($request->new_email != '') {
                $patinet->EmailAddress = $request->new_email;
            }
            if ($request->new_phone != '') {
                $patinet->MobileNumber = $request->new_phone;
            }
            $patinet->update();
            return response()->json(['status' => 200, 'data' => 'Patient info updated successfully']);
        } else if ($type == 'address') {
            $patinet = Patient::find($patient_id);
            if ($request->new_address != '') {
                $patinet->Address = $request->new_address;
            }
            if ($request->new_city != '') {
                $patinet->City = $request->new_city;
            }
            if ($request->new_zip != '') {
                $patinet->ZipCode = $request->new_zip;
            }
            if ($request->new_state != '') {
                $patinet->State = $request->new_state;
            }
            $patinet->update();
            return response()->json(['status' => 200, 'data' => 'Patient info updated successfully']);
        } else if ($type == 'allergis') {
            $patients = DB::table('PatientAllergies')->where('PatientId', $patient_id)->get();
            if (count($patients) > 0) {
                foreach ($patients as $key => $patient) {
                    DB::table('PatientAllergies')->where('Id', $patient->Id)->update(['Allergies' => $request['alleriesArray'][$key]]);
                }
            } else {
                $allergy_array = array();
                $allergy_array['Allergies'] = $request['alleriesArray'][0];
                $allergy_array['PatientId']   = $patient_id;
                $query_insert = DB::table('PatientAllergies')->insert($allergy_array);
            }
            return response()->json(['status' => 200, 'data' => 'Allergies added successfully']);
        } else if ($type == 'insurance_cards') {
            $patients = DB::table('PatientInsuranceDetails')->where('PatientId', $patient_id)->get();
            // dd($patients);
            return response()->json(['status' => 200, 'data' => 'Allergies updated successfully']);
        }
    }

    public function refillNow(Request $request)
    {
        $reports = new Reports();
        $req = [];
        $days = '7';

        $result = Order::select(['Orders.Id AS OrderId',DB::raw('DATE_FORMAT(Orders.nextRefillDate, "%m/%d/%Y") AS nextRefillDate'), 
          DB::raw('(SELECT SecurityToken from PatientProfileInfo Where Id = Orders.PatientId) AS SecurityToken'), 
           DB::raw('CASE WHEN pct.practice_code IS NULL THEN ( case when Orders.RefillCount < 9 then concat(Orders.Rxnumber,"-0",Orders.RefillCount) else concat(Orders.Rxnumber,"-",Orders.RefillCount) end) ELSE (CONCAT(pct.practice_code, "-", case when Orders.RefillCount < 9 then concat(Orders.Rxnumber,"-0",Orders.RefillCount) else concat(Orders.Rxnumber,"-",Orders.RefillCount) end)) END as RxNumber'),
           DB::raw('CONCAT( d.rx_label_name, " ", d.Strength, " ", d.dosage_form ) AS rx_label_name'),

               DB::raw('Orders.Quantity AS qty'), 'Orders.DaysSupply AS day_supply', DB::raw('CONCAT("$ ", FORMAT(Orders.asistantAuth,2)) AS assisAuth') ])

               ->join('drugs_new AS d', 'd.id', '=', 'Orders.DrugDetailId')

               ->join('practices AS pct', 'pct.Id', '=', 'Orders.PracticeId')

               ->when($days!='all_activity', function ($query) use ($days) {

                //    $end_date = Carbon::now()->addDays(2)->format('Y-m-d');
                   $end_date = Carbon::now()->format('Y-m-d');

                   $start_date = Carbon::now()->subDays($days+1)->format('Y-m-d');
                   $query->where('Orders.nextRefillDate', '>=', $start_date);
                   $query->where('Orders.nextRefillDate', '<=', $end_date);


           })->when(!empty($request->get('practice')), function($query) use ($request){

                   $query->where('Orders.PracticeId', $request->get('practice')->id);

           })->when(!empty($request->get('patient_id')), function($query) use ($request){

               $query->where('Orders.PatientId', $request->get('patient_id'));

           })
           // ->where('Orders.nextRefillDate','>=',Carbon\Carbon::now()->format('Y-m-d'))
        //    ->where('Orders.OrderType','=','Refill')
        ->where('Orders.OrderStatus','=',8)
        ->where('Orders.RefillsRemaining','!=',0)
        ->where('Orders.refilldone','!=',1)
        ->orderBy('nextRefillDate', 'DESC')
        ->orderBy('Orders.created_at', 'DESC')
        ->get();


           $result->filter(function ($value, $key) {
                   $value['qty'] = number_format($value['qty'], 1);
                   return $value;
               });

           $data['result'] = $result->toArray();

           

           $data['tab_title'] = [ [ 'title'=>'Refill Due Date', 'style' => 'style="width:110px;"', 'class'=>'bg-gray-80 txt-wht cnt-center'], [ 'title'=>'Rx Number', 'class'=>'bg-orage txt-wht cnt-center text-sline'], [ 'title'=>'Rx Label Name', 'class'=>'bg-blue txt-wht'],
           [ 'title'=>'Qty', 'class'=>'bg-grn-lk txt-wht cnt-center'], [ 'title'=>'Day Supply', 'class'=>'bg-gr-bl-dk txt-wht cnt-center'],  [ 'title'=>'ASSISTANCE AUTH', 'class'=>'bg-gray-1 txt-wht text-sline'] ];

           $data['col_style'] = ['bg-gray-e txt-black-24 cnt-center', 'bg-tb-orange-lt txt-orange tt_uc_ cnt-right zero_slashes', 'bg-tb-blue-lt txt-blue', 'bg-gray-e txt-black-24 tt_uc_ cnt-center', 'bg-tb-grn-lt txt-black-24 cnt-right', 'bg-tb-wht-shade txt-black-24 cnt-right'];

        //    return $data;

        $response = $data;
        // $response = $reports->refills_due($days, $request);

        echo '<table class="bordered-hd-blue-shade">' .
            '<thead>' .
            '<tr>';
        if ($response['tab_title']) {
            foreach ($response['tab_title'] as $keyTab => $valTab) {
                $style = '';
                if (is_array($valTab)) {
                    if (isset($valTab['style'])) {
                        $style = $valTab['style'];
                    }
                    $valTab = $valTab['title'];
                }
                echo '<th class="txt-wht weight_500" ' . $style . '>' . $valTab . '</th>';
            }
        }
        echo  '</tr>' .
            '</thead>' .
            '<tbody>';
        if ($response['result']) {
            foreach ($response['result'] as $key => $value) {
                echo '<tr>'.
                    '<td class="text-sline"><span class="rd_date mr-4_">' . $value['nextRefillDate'] . '</span><span class="rd_">'.
                            '<a href="javascript:refillRequestOrder(`'.date("Y-m-d", strtotime($value['nextRefillDate'])).'`,'.$value['OrderId'].')" data-forRefillOrder="'.$value['OrderId'].'" id="refil-anchor-hover" title="Create refill for this prescription"  class="elm-right hover-black-child_">'.
                            '<img style="height: auto; width: 24px;" src="'.asset("images/icon/rd_icon.png").'"></a></span></td>'.
                    "<td>{$value['RxNumber']}</td>".
                    "<td>{$value['rx_label_name']}</td>".
                    "<td>{$value['qty']}</td>".
                    "<td>{$value['day_supply']}</td>".                    
                    "<td class='cnt-right-force'>{$value['assisAuth']}</td>".                    
                '</tr>';
            }
            /*foreach ($response['result'] as $keyRes => $valRes) {
                echo '<tr>';
                $keys = [];
                $keys = array_keys($valRes);
                for ($i = 0; $i < count($keys); $i++) {
                    if($keys[$i] == 'nextRefillDate'){
                         '<td class="text-sline"><span class="rd_date mr-4_">' . $valRes[$keys[$i]] . '</span><span class="rd_">'.
                            '<a href="javascript:refillRequestOrder('.$order->nextRefillDate.','.$order->order_id.','.$order->SecurityToken.')" id="refil-anchor-hover" title="Create refill for this prescription"  class="elm-right hover-black-child_">'.
                            '<img style="height: auto; width: 24px;" src="'.asset("images/icon/rd_icon.png").'"></a></span></td>';
                    }
                    else if($keys[$i] != 'assisAuth')
                        echo  '<td>' . $valRes[$keys[$i]] . '</td>';
                    else if($keys[$i] != 'SecurityToken' && $keys[$i] != 'OrderId')
                        echo  '<td class="cnt-right-force">' . $valRes[$keys[$i]] . '</td>';
                }
                echo '</tr>';
            }*/
        } else {

            echo '<tr>' .
                '<td style="text-align: center;" colspan="' . count($response['tab_title']) . '">No Record Found</td>' .
                '</tr>';
        }

        echo  '</tbody>' .
            '</table>';
    }

    public function send_enrollment_message($id)
    {

        $patient = Patient::find($id);
        if ($patient) {
            $send = false;
            $exception = '';
            if ($patient->preffered_method_contact == "Email") {
                $uk = Str::random(40);
                $enrollment_update =  $patient->enrollment()->update(['unique_key' => $uk]);
                if ($enrollment_update) {
                    $enrollment_update = $patient->enrollment()->first();
                    $practice =   Practice::where('id', $patient->Practice_ID)
                        ->pluck('practice_name');


                    $enrollment['id'] = $enrollment_update->id;
                    $enrollment['unique_key'] = $enrollment_update->unique_key;
                    $enrollment['FirstName'] = $patient->FirstName;
                    $enrollment['practice'] = $practice;
                    // return $enrollment;
                    $send = Mail::to($patient->EmailAddress)
                        ->send(
                            new Enrollment($enrollment)
                        );

                    if (count(Mail::failures()) > 0) {
                        foreach (Mail::failures() as $email_address) {
                            $exception = " - $email_address <br />";
                        }
                    } else {
                        $send = true;
                    }
                } else {
                    return response()->json(['status' => false, 'message' => 'No Patient Enrollment data found'], 400);
                }
            } else {
                $send =  $this->sendEnrollment($patient->MobileNumber);

                $send = true;
            }
            if ($send) {
                return response()->json(['status' => true, 'message' => 'Enrollment Message has been sent to patient'], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'Email Could Not send.PLease try again', 'exception' => $exception], 400);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'No Patient found'], 400);
        }
    }
}

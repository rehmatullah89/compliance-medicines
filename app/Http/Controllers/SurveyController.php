<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use Auth;
use Excel;
use Image;
use App\Drug;
use App\Order;
use App\Survey;
use App\Practice;
use App\SurveyTheme;
use App\QuestionType;
use App\QuestionOption;
use App\SurveyQuestion;
use App\SurveyResponse;
use App\PatientProfile;
use Illuminate\Http\Request;
use App\SurveyResponseDetail;
use App\Imports\SurveyPatientImport;


class SurveyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('survey.home');
    }
    
    /**
     * Show the survey inventory list.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function inventory()
    {
        $surveys = Survey::with(["User","Category"])->where("status",1)->orderBy("id","DESC")->get();
        return view('survey.inventory', compact('surveys'));
    }
    
    /**
     * Show the survey inventory list.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function editSurvey()
    {
        $surveys = Survey::where("status",1)->get();
        return view('survey.edit', compact('surveys'));
    }
    
    /**
     * Show the survey inventory list.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function copyEdit(Request $request)
    {
        $survey = Survey::with("Theme")->find($request->survey_name);
        
        if($request->edit_type == 'copy'){
            $newSurvey = $survey->replicate();
            $newSurvey->title = $request->new_survey_name;
            $newSurvey->save();
            
            if(isset($survey->Theme)){
                $theme = SurveyTheme::find($survey->Theme->id);
                $newTheme = $theme->replicate();
                $newTheme->survey_id = $newSurvey->id;
                $newTheme->save();
            }   
            $survey = $newSurvey;
        }
        return redirect()->action('SurveyController@show', ['survey'=>$survey]);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($survey)
    {
        if(is_numeric($survey))
            $survey = Survey::find($survey);
 
        $theme = SurveyTheme::where("survey_id",$survey->id)->first();        
        return view('survey.question_builder', compact('survey','theme'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $categories = \App\SurveyCategory::pluck("title","id")->toArray(); 
       return view('survey.create', compact('categories'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $survey = Survey::updateOrCreate(['title' => $request->survey_name],array('category_id' => $request->category, 'user_id'=>Auth::user()->id, 'survey_language'=> $request->language));		 
        $request->session()->put('survey_name', $request->survey_name);
        $request->session()->put('category', $request->category);
        
        if($request->questions_ready)
            return redirect()->action('SurveyController@selectQuestions', ['id'=>$survey->id, 'category'=>$request->category]);
        else
            return redirect()->action('SurveyController@show', ['survey'=>$survey]);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /*$survey = Survey::find($id);
        return view('survey.send_survey', compact('survey'));*/
    }
    
    
    /**
     * Show the patients list to send survey.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sendSurvey($id, Request $request)
    {
        $survey = Survey::find($id);
        $request->session()->forget('category');
        $request->session()->forget('survey_name');
        $theme = SurveyTheme::where("survey_id",$survey->id)->first();  
        $practices = Practice::select('practice_type')->distinct()->get();
        
        return view('survey.send_survey', compact('survey','theme','practices'));
    }
    
    /**
     * Show the folder questions.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function selectQuestions($id,$category)
    {
        $survey = Survey::find($id);
        $surveys = Survey::pluck("title","id");        
        $existingQuestions = SurveyQuestion::where("survey_id", $id)->pluck("question_code")->toArray();
        $questions = SurveyQuestion::with("Survey")->where("survey_id", "!=", $id)
                ->whereNotIn("question_code", $existingQuestions)
                ->groupBy("question_title", "survey_id")->orderBy("survey_id")->get();
       
        return view('survey.survey_questions', compact('survey',"questions", 'surveys'));
    }
    
    /**
     * Store a questions resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveQuestions(Request $request)
    {
        ini_set('memory_limit','512M');
        set_time_limit(0);

        $dataList = [];        
        $survey = Survey::find($request->survey_id);
        
        if(isset($request->questionId) && !empty($request->questionId))
        foreach($request->questionId as $questionId){
                $surveyQuestion = SurveyQuestion::with(["Survey","Options"])->where("id",$questionId)->first();
                $details = (isset($surveyQuestion->Survey->details))?json_decode($surveyQuestion->Survey->details):'';
                if(!empty($details))
                foreach($details as $key => $data){
                    if($surveyQuestion->question_code == $data->name)
                        $dataList[] = $details[$key];
                }                
        }
        
        $surveyData = ($survey->details != "")?json_decode($survey->details):[];
        $surveyData = array_merge($surveyData,$dataList);
        $survey->details = json_encode($surveyData);
        $survey->save();
        
        return redirect()->action('SurveyController@show', ['survey'=>$request->survey_id]);
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
        $question= json_decode($request->question_details);

        if(!empty($question))
        {
            $surveyExist = SurveyQuestion::where('survey_id', $request->survey_id)->first();

            if(!empty($surveyExist)) 
            {
                $templateIdArr = array();
                foreach ($question as $row) {
                    if ($row->type != 'hidden') {
                        if (isset($row->name))
                            $templateIdArr[] = $row->name;
                    }
                }

                $deleteQuestion = SurveyQuestion::whereNotIn('question_code', $templateIdArr)
                        ->where('survey_id', $request->survey_id)->pluck('id');
                
                //////////////////Delete unwanted Question///
                //  DB::enableQueryLog();
                SurveyQuestion::whereIn('id', $deleteQuestion)->delete();
                //dd(DB::getQueryLog()) ;
                QuestionOption::whereIn('question_id', $deleteQuestion)->delete();
            }
          
            for($i=0; $i<count($question); $i++) 
                $this->create_question($question[$i],($i+1), $request->survey_id);

            $surveyQuestions = SurveyQuestion::with("Options")->where("survey_id", $request->survey_id)->get();    
            foreach($surveyQuestions as $question){
                if(isset($question->Options) && !empty($question->Options) && in_array($question->input_type, ['dropdown','checkbox','radio'])){
                    foreach($question->Options as $index => $option){
                        if($option->id > 0)
                            SurveyResponseDetail::where("question_id",$question->id)->where("answer",trim($option->option_name))->update(['question_option_id'=>$option->id]); 
                    }
                }
                else{
                    SurveyResponseDetail::where("question_id",$question->id)->delete();
                }
            }
            

        }
        
        if(Survey::where("title",$request->survey_name)->where("id", "!=", $id)->count() > 0)
            $survey = Survey::updateOrCreate(['id' => $id],array('details' => $request->question_details));
        else
            $survey = Survey::updateOrCreate(['id' => $id],array('details' => $request->question_details, 'title' => $request->survey_name));
        
        $themeContent = array('theme_title' => $survey->title,'header_text'=>$request->header_content,'footer_text'=>$request->footer_content);
        if($request->hasFile('logo_image'))
        {
            ///////////////////////$request->logo_image           
            
            $imageName = time().'.'.$request->logo_image->extension();
            $path = public_path('images/survey/size100').$imageName;
            
            //save resize image
            Image::configure(['driver'=>'gd']);  
            $img = Image::make($request->logo_image)
                    ->resize(100, 100, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save($path);
            $img->save();

            //save orignal size
            $request->logo_image->move(public_path('images'), $imageName);
            $themeContent = array('theme_title' => $survey->title,'header_text'=>$request->header_content,'footer_text'=>$request->footer_content,'header_image'=>$imageName);
        }
        
        SurveyTheme::updateOrCreate(['survey_id' => $id],$themeContent);
        
        return redirect()->action('SurveyController@sendSurvey', ['id'=>$id]);
    }
    
    public function create_question($question,$questionOrder, $surveyId)
    {
        $questionData = [];
        $questionTypes = QuestionType::pluck("id","type_title")->toArray();
        
        if(isset($question->name) )
            $questionData['question_code'] = $question->name;
        else
            $questionData['question_code'] = substr(md5(mt_rand()), 0, 17);

        if(isset($question->label) )
            $questionData['question_title'] = str_replace("&nbsp;", "", strip_tags(trim($question->label)));
        else
            $questionData['question_title'] = Null;

        if(isset($question->inline) )
            $questionData['display_inline'] =1;
         else
            $questionData['display_inline'] = 0;

        if(isset($question->required) && $question->required == true)
            $questionData['is_required'] = 1;
        
        if(isset($question->description) )
            $questionData['description'] = strip_tags($question->description);

     
        $questionData['question_order']= $questionOrder;      

        if ($question->type == 'select') {              
            $questionData['input_type'] = 'dropdown';
            $questionData['question_type_id'] = $questionTypes['single_choice'];

        } elseif ($question->type == 'checkbox-group') {
            $questionData['input_type'] = 'checkbox';
            $questionData['question_type_id'] = $questionTypes['multiple_choice'];

        } elseif ($question->type == 'radio-group') {
            $questionData['input_type'] = 'radio';
            $questionData['question_type_id'] = $questionTypes['single_choice'];
            
        } elseif ($question->type == 'text') {
            $questionData['input_type'] = 'text';
            $questionData['question_type_id'] = $questionTypes['open_question'];
            
        } elseif ($question->type == 'date') {
            $questionData['input_type'] = 'date';
            $questionData['question_type_id'] = $questionTypes['date'];
            
        }elseif ($question->type == 'starRating') {
            $questionData['input_type'] = 'starRating';
            $questionData['question_type_id'] = $questionTypes['star_rating'];
            
        }elseif ($question->type=='textarea') {
            $questionData['input_type'] = 'paragraph';
            $questionData['question_type_id'] = $questionTypes['content'];
        }

        $result= array();

        //DB::enableQueryLog();
        $result = SurveyQuestion::updateOrCreate(['question_code'=>$questionData['question_code'],'survey_id'=> $surveyId ],$questionData);
        // dump( DB::getQueryLog());

        if(isset($question->values))
        {           
            $option_order=1;
            $existOption = QuestionOption::where('question_id', $result['id']);
            $existOption->delete();
            
            foreach ($question->values as $option)
            {
                    $QuestionOptions= QuestionOption::create(['question_id' => $result['id'],'option_name'=>$option->label,'option_order'=>$option_order ]) ;
                    $option_order++;
            }

        }elseif($question->type=='text' && $question->subtype=='text'){
           
            $existOption = QuestionOption::where('question_id', $result['id']);
            $existOption->delete();
     
        if(empty($question->placeholder))
        {
            if(empty($question->description))
            {
                $question->placeholder = substr($question->label, 0,20);  
            }
            else
            {
              $question->placeholder = $question->description; 
            }
        }

            $QuestionOptions= QuestionOption::create(['question_id' => $result['id'], 'option_name'=> $question->placeholder,'option_order'=>1]) ;
        }
  
    }
    
    public function getPractices(Request $request)
    {
        $practices = Practice::orderby('practice_name','asc')->select('id','practice_name')
                ->when(!empty($request->ptype), function($query) use ($request){
                    $query->where('practice_type', $request->ptype);
                })
                ->where('practice_name', 'like', '%' .$request->search . '%')
                ->whereNotNull("practice_name")
                ->limit(10)->get();
        
        $response = array();
        foreach($practices as $practice){
           $response[] = array(
                "id"=>$practice->id,
                "text"=>$practice->practice_name
           );
        }

        return json_encode($response);
    }
    
    public function getSurveys(Request $request)
    {
        $surveys = Survey::orderby('title','asc')->select('id','title')
                ->when(!empty($request->category), function($query) use ($request){
                    $query->where('category_id', $request->category);
                })
                ->where('title', 'like', '%' .$request->search . '%')
                ->limit(10)->get();
        
        $response = array();
        foreach($surveys as $survey){
           $response[] = array(
                "id"=>$survey->id,
                "text"=>$survey->title
           );
        }

        return json_encode($response);
    }
    
    public function getDrugs(Request $request)
    {
        $drugs = Drug::orderby('rx_label_name','asc')->select('id', 'rx_label_name', 'strength', DB::raw('CONCAT(rx_label_name, " (", strength, ") ") AS drug'))
                ->where('rx_label_name', 'like', '%' .$request->search . '%')
                ->whereNotNull("rx_label_name")
                ->limit(10)->get();
        
        $response = array();
        $duplicates = array();
        
        foreach($drugs as $drug){            
            if(!(isset($duplicates[$drug->rx_label_name]) && $duplicates[$drug->rx_label_name] == $drug->strength)){        
                $duplicates[$drug->rx_label_name] = $drug->strength;
                $response[] = array(
                     "id"=>$drug->id,
                     "text"=>$drug->drug
                );
            }
        }

        return json_encode($response);
    }
    
    public function getMarketer(Request $request)
    {
        $marketers = Drug::orderby('marketer','asc')->select('marketer')
                ->distinct()->where('marketer', 'like', '%' .$request->search . '%')
                ->whereNotNull("marketer")
                ->limit(10)->get();
        
        $response = array();
        foreach($marketers as $marketer){
           $response[] = array(
                "id"=>$marketer->marketer,
                "text"=>$marketer->marketer
           );
        }

        return json_encode($response);
    }
    
    public function getMinorTheraputic(Request $request)
    {
        $minorTheraps = Drug::orderby('minor_reporting_class','asc')->select('minor_reporting_class')
                ->distinct()->where('minor_reporting_class', 'like', '%' .$request->search . '%')
                ->whereNotNull("minor_reporting_class")
                ->limit(10)->get();
        
        $response = array();
        foreach($minorTheraps as $minorTherap){
           $response[] = array(
                "id"=>$minorTherap->minor_reporting_class,
                "text"=>$minorTherap->minor_reporting_class
           );
        }

        return json_encode($response);
    }
    
    public function getPrescriber(Request $request)
    {
        $orders = Order::orderby('PrescriberName','asc')->select('PrescriberName')
                ->distinct()->where('PrescriberName', 'like', '%' .$request->search . '%')
                ->whereNotNull("PrescriberName")
                ->limit(10)->get();
        
        $response = array();
        foreach($orders as $order){
           $response[] = array(
                "id"=>$order->PrescriberName,
                "text"=>$order->PrescriberName
           );
        }

        return json_encode($response);
    }
    
    public function getRxNo(Request $request)
    {
        $rxnos = Order::orderby('RxNumber','asc')->select('RxNumber')
                ->distinct()->where('RxNumber', 'like', '%' .$request->search . '%')
                ->whereNotNull("RxNumber")
                ->limit(10)->get();
        
        $response = array();
        foreach($rxnos as $rxno){
           $response[] = array(
                "id"=>$rxno->RxNumber,
                "text"=>$rxno->RxNumber
           );
        }

        return json_encode($response);
    }
    
    public function getRefillsRemaining(Request $request)
    {
        $rxnos = Order::orderby('RefillsRemaining','asc')->select('RefillsRemaining')
                ->distinct()->where('RefillsRemaining', 'like', '%' .$request->search . '%')
                ->whereNotNull("RefillsRemaining")
                ->limit(10)->get();
        
        $response = array();
        foreach($rxnos as $rxno){
           $response[] = array(
                "id"=>$rxno->RefillsRemaining,
                "text"=>$rxno->RefillsRemaining
           );
        }

        return json_encode($response);
    }
    
    public function getPhoneNumbers(Request $request)
    {
        $mobilenos =  PatientProfile::select('Id',DB::raw('AES_DECRYPT (FROM_BASE64(MobileNumber),"ss20compliance19") AS MobileNumber'))
                ->whereRaw(' AES_DECRYPT (FROM_BASE64(MobileNumber),"ss20compliance19") LIKE  "%'.$request->search.'%"' )
                ->limit(10)->get();
   
        $response = array();
        foreach($mobilenos as $mobileno){
           $response[] = array(
                "id"=>$mobileno->Id,
                "text"=>$mobileno->MobileNumber
           );
        }

        return json_encode($response);
    }
    
    /*public function getPatientRecords(Request $request)
    {
        ini_set('memory_limit','512M');
        $displayData = "";
        $result = Order::select([DB::raw('p.practice_name AS practice_name'),
                                DB::raw('(CASE ppi.Gender WHEN "F" THEN "Female" WHEN "M" THEN "Male" END) AS Gender, ppi.ZipCode as ZipCode, ppi.Id as Id,
                                    LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19") USING "utf8")) AS FirstName,
                                    LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8")) AS LastName,
                                    AES_DECRYPT (FROM_BASE64(ppi.MobileNumber),"ss20compliance19") AS MobileNumber,
                                    AES_DECRYPT (FROM_BASE64(ppi.EmailAddress),"ss20compliance19") AS EmailAddress,
                                    AES_DECRYPT (FROM_BASE64(ppi.BirthDate),"ss20compliance19") AS BirthDate')
                            ])
                            ->join('drugs_new AS d', 'd.id', '=', 'Orders.DrugDetailId')
                            ->join('practices AS p', 'p.id', '=', 'Orders.PracticeId')
                            ->join('PatientProfileInfo AS ppi', 'ppi.id', '=', 'Orders.PatientId')
                            ->when(!empty($request->practice_type), function($query) use ($request){
                                $query->where('p.practice_type', $request->practice_type);
                            })->when(($request->practice_name > 0), function($query) use ($request){
                                $query->where('p.id', $request->practice_name);
                            })->when(($request->drug_name > 0), function($query) use ($request){
                                $query->where('d.id', $request->drug_name);
                            })->when(!empty($request->drug_marketer), function($query) use ($request){
                                $query->where('d.marketer', $request->drug_marketer);
                            })->when(!empty($request->minor_theraputic), function($query) use ($request){
                                $query->where('d.minor_reporting_class', $request->minor_theraputic);
                            })->when(!empty($request->rx_number), function($query) use ($request){
                                $query->where('Orders.RxNumber', $request->rx_number);
                            })->when(!empty($request->refills_remaining), function($query) use ($request){
                                $query->where('Orders.RefillsRemaining', $request->refills_remaining);
                            })->when(!empty($request->prescriber_name), function($query) use ($request){
                                $query->where('Orders.PrescriberName', $request->prescriber_name);
                            })->groupBy("EmailAddress")->get();
        
        foreach($result as $data){
            $displayData .= '<tr><td class="bg-tb-wht-shade2 txt-blue cnt-center"><input type="checkbox" class="checkbox" name="patientId[]" value="'.$data->Id.'"></td>'
                    . '<td class="bg-tb-blue-lt2 txt-blue cnt-left">'.($data->FirstName." ".$data->LastName).'</td>  <td class="bg-gray-e txt-blue cnt-left">'.$data->practice_name.'</td>'
                    . '<td class="bg-tb-wht-shade2 txt-gray-6 cnt-left">'.$data->EmailAddress.'</td><td class="bg-tb-orange-lt txt-gray-6">'.date("m/d/Y", strtotime($data->BirthDate)).'</td>'
                    . '<td class="bg-grn-lk2 txt-gray-6">'.$this->phone_number_format($data->MobileNumber).'</td><td class="bg-gray-e txt-blue weight_600 cnt-left">'.$data->Gender.'</td>'
                    . '<td class="bg-tb-pink2 txt-red cnt-center">'.$data->ZipCode.'</td></tr>';
                           
        }    
        
        return $displayData;            
    }*/
    
    public function getPatientRecords(Request $request)
    {
        ini_set('memory_limit','512M');
        $displayData = "";
        $result = Order::select([DB::raw('p.practice_name AS practice_name'),
                                DB::raw('(CASE ppi.Gender WHEN "F" THEN "Female" WHEN "M" THEN "Male" END) AS Gender, ppi.ZipCode as ZipCode, ppi.Id as Id,
                                    LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.FirstName),"ss20compliance19") USING "utf8")) AS FirstName,
                                    LOWER(CONVERT(AES_DECRYPT (FROM_BASE64(ppi.LastName),"ss20compliance19")USING "utf8")) AS LastName,
                                    AES_DECRYPT (FROM_BASE64(ppi.MobileNumber),"ss20compliance19") AS MobileNumber,
                                    AES_DECRYPT (FROM_BASE64(ppi.EmailAddress),"ss20compliance19") AS EmailAddress,
                                    AES_DECRYPT (FROM_BASE64(ppi.BirthDate),"ss20compliance19") AS BirthDate')
                            ])
                            ->join('drugs_new AS d', 'd.id', '=', 'Orders.DrugDetailId')
                            ->join('practices AS p', 'p.id', '=', 'Orders.PracticeId')
                            ->rightJoin('PatientProfileInfo AS ppi', 'ppi.id', '=', 'Orders.PatientId')
                            ->when((!empty($request->practice_type) && $request->practice_type != 'undefined'), function($query) use ($request){
                                $query->where('p.practice_type', $request->practice_type);
                            })->when(($request->practice_name > 0), function($query) use ($request){
                                $query->where('p.id', $request->practice_name);
                            })->when(($request->drug_name > 0), function($query) use ($request){
                                $query->where('d.id', $request->drug_name);
                            })->when((!empty($request->drug_marketer) && $request->drug_marketer != 'undefined'), function($query) use ($request){
                                $query->where('d.marketer', $request->drug_marketer);
                            })->when((!empty($request->minor_theraputic) && $request->minor_theraputic != 'undefined'), function($query) use ($request){
                                $query->where('d.minor_reporting_class', $request->minor_theraputic);
                            })->when((!empty($request->rx_number) && $request->rx_number != 'undefined'), function($query) use ($request){
                                $query->where('Orders.RxNumber', $request->rx_number);
                            })->when((!empty($request->refills_remaining) && $request->refills_remaining != 'undefined'), function($query) use ($request){
                                $query->where('Orders.RefillsRemaining', $request->refills_remaining);
                            })->when((!empty($request->prescriber_name) && $request->prescriber_name != 'undefined'), function($query) use ($request){
                                $query->where('Orders.PrescriberName', $request->prescriber_name);
                            })->groupBy("EmailAddress")->get();
        
        $dataList = [];                    
        foreach($result as $data){            
            $data = array($data->Id, ($data->FirstName." ".$data->LastName), $data->practice_name, $data->EmailAddress, date("m/d/Y", strtotime($data->BirthDate)), 
                $this->format_phone_us($data->MobileNumber), $data->Gender, $data->ZipCode);
            
            array_push($dataList, $data);
        }    
        
        return ['total'=>count($dataList), 'data'=>$dataList];            
    }
    
    public function saveSendSurvey(Request $request)
    {
        $response = json_decode($this->sendSurveyNotifications($request->survey_id, explode(",", $request->patients)));
        return $response->errorCode;
    }
    
    function format_phone_us($phone) 
    {
        // note: making sure we have something
        if(!isset($phone{3})) { return ''; }
            // note: strip out everything but numbers 
            $phone = preg_replace("/[^0-9]/", "", $phone);
            $length = strlen($phone);
            switch($length) {
            case 7:
              return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
            break;
            case 10:
             return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone);
            break;
            case 11:
            return preg_replace("/([0-9]{1})([0-9]{3})([0-9]{3})([0-9]{4})/", "$1($2) $3-$4", $phone);
            break;
            default:
              return $phone;
            break;
        }
    }
    
    public function deleteImage(Request $request)
    {
        return SurveyTheme::where("id",$request->id)->update(['header_image'=>null]); 
    }
    
    public function deleteSurvey($id)
    {
        $questions = SurveyQuestion::where("survey_id",$id)->pluck("id")->toArray();
        \DB::table("survey_question_options")->whereIn("question_id",$questions)->delete();
        SurveyQuestion::where("survey_id",$id)->delete();
        SurveyTheme::where("survey_id",$id)->delete();
        Survey::where("id",$id)->delete();        
        
        $surveys = Survey::with(["User","Category"])->where("status",1)->orderBy("id","DESC")->get();
        return view('survey.inventory', compact('surveys'));
    }
    
    public function reports()
    {
        $categories = \App\SurveyCategory::pluck("title","id")->toArray();
        $userIds = Survey::select("user_id")->distinct()->get()->toArray();
        $users = \App\User::whereIn("id",$userIds)->pluck("name","id")->toArray();
        $totalSent = \DB::table("survey_logs")->count();
        $totalResponse = \DB::table('survey_response')->count(DB::raw('DISTINCT survey_log_id'));
       
        $surveys = \App\SurveyCategory::with("survey")->whereHas("survey")->get();
        $surveyResponses = DB::table('survey_response')                        
                    ->select(array(DB::raw('COUNT(DISTINCT survey_log_id) as total'), 'survey_id'))
					->groupBy('survey_id')					
                    ->get();

        $scounts = [];
        foreach($surveyResponses as $resp){
            $scounts[$resp->survey_id] = $resp->total;
        }            
     
        return view('survey.report', compact('surveys','scounts','categories','users','totalSent','totalResponse'));
    }

    public function getSurveyReport(Request $request)
    {
        $surveyQuestions = SurveyQuestion::with("Options")->where("survey_id", $request->id)->get();
        $dataStr = "";
        $colorList = [0=>'red',1=>'orange',2=>'grn-lt',3=>'blue'];
        foreach($surveyQuestions as $key => $question){
            $dataStr .= '<div class="row pr-14_ pl-14_ mt-7_"><div class="col-sm-12 pl-0 pr-0 table-responsive">
            <table class="table bordered hd-row-blue-shade-rounded" style="min-width: 700px;"><thead>
            <tr class="weight_500-force-childs bg-blue" role="row"><th class="txt-wht tt_uc_">'.$question->question_title.'</th>
            <th class="txt-wht pos-rel_" style="width:120px;"><span class="elm-left">Download</span>
            <span class="elm-right download-hd-pl-mn-btn cur-pointer weight_600 fs-16_ txt-center" data-target="#expand-collpase-tbody'.$key.'" data-toggle="collapse" aria-expanded="false" style="width: 16px;height: 16px;"></span>
            </th></tr></thead><tbody id="expand-collpase-tbody'.$key.'" class="collapse">';

            $totalResponse = SurveyResponseDetail::where("question_id",$question->id)->count();
            if(isset($question->Options) && !empty($question->Options) && in_array($question->input_type, ['dropdown','checkbox','radio'])){
                foreach($question->Options as $index => $option){

                    $optionResponse = SurveyResponseDetail::where("question_option_id",$option->id)->count();  

                    $percentage = 0;                    
                    if($optionResponse>0){
                        $percentage = (($optionResponse/$totalResponse)*100);
                    }

                    $dataStr .= '<tr><td><div class="elm-left c-mr-4_ "><span class="txt-blue weight_600">'.number_format($percentage,2).'%</span><span class="txt-'.@$colorList[$index%4].' weight_600">'.$option->option_name.'</span><span class="txt-black-24 weight_600">('.$optionResponse.')</span></div></td>';
					
					 if($optionResponse>0){
						$dataStr .= '<td><i class="fa fa-file-pdf-o" aria-hidden="true" style="color:red; cursor: pointer;" onclick="downloadReceipientPdf('.$request->id.','.$question->id.','.$option->id.');"></i></td>';
					 }else{
						 $dataStr .= '<td></td>';
					 }
					 
					$dataStr .= '</tr>';
                }
            }else{

                $dataStr .= '<tr><td><div class="elm-left c-mr-4_ "><span class="txt-blue weight_600">'.($totalResponse>0?100:0).'%</span><span class="txt-'.@$colorList[$index%4].' weight_600">Responses</span><span class="txt-black-24 weight_600">('.$totalResponse.')</span></div></td><td>';
                
                if($totalResponse > 0)
                    $dataStr.='<i class="fa fa-file-pdf-o" aria-hidden="true" style="color:red; cursor: pointer;" onclick="downloadReceipientPdf('.$request->id.','.$question->id.',0);"></i>';
                $dataStr .= '</td></tr>';    
            }
            
            $dataStr .= '</table></div></div>';
        }

        return $dataStr;
    }

    public function getSurveyRecipients($surveyId, $questionId, $optionId)
    {
        ini_set('memory_limit','256M');

        $patients = PatientProfile::select('PatientProfileInfo.Id', 'sr.question_title as Question','sqo.option_name as optionName',DB::raw('AES_DECRYPT (FROM_BASE64(FirstName),"ss20compliance19") AS FirstName'))
            ->join('survey_logs AS sl', 'sl.patient_id', '=', 'PatientProfileInfo.Id')
            ->join('survey_response AS sr', 'sl.id', '=', 'sr.survey_log_id')
			->leftjoin('survey_question_options AS sqo', 'sr.question_id', '=', 'sqo.question_id')
            ->where("sl.survey_id",$surveyId)
            ->where("sr.question_id",$questionId)
            ->when(($optionId>0), function($query) use ($optionId){
                $query->where("sqo.id", $optionId);
            })->get();

            
       
        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
                ->loadView('survey.recipients_print', ['patients'=>$patients]);
       
        return $pdf->download('survey-'.$surveyId.'-recipients.pdf');
    }
    
    public function getReportData(Request $request)
    {
        $survey = Survey::when(!empty($request->created_by), function($query) use ($request){
                                $query->where('user_id', $request->created_by);
                            })->find($request->survey_id);

        $sentCount = 0;                    
        $practice = "";                    
        $chartHtml = "";
        $labelsList = [];
        $dataList = [];
        $totalQuestions = 0;                    
        if($survey)
        {
            $surveyQuestions = SurveyQuestion::with("Options")->where("survey_id", $request->survey_id)->get();
            $surveyLog = \DB::table("survey_logs")->where("survey_id", $request->survey_id)->first();
            $sentCount = \DB::table("survey_logs")->where("survey_id", $request->survey_id)->count();
            $patient = ($surveyLog)?PatientProfile::with("Practice")->where("id", $surveyLog->patient_id)->first():0;
            $practice = ($patient)?$patient->Practice->practice_name:'';
            $rectList = array(0=>'blue-rect',1=>'green-rect',2=>'orange-rect',3=>'purple-rect',4=>'red-rect',5=>'blue-rect');

            foreach($surveyQuestions as $key => $question){
                $chartHtml .= '<div class="chart-box wd-31p mr-2p mb-24_ pos-rel_"><div class="trow_"><div class="chart-text wd-80p fs-16_ weight_600 mb-14_">'
                        .$question->question_title.'</div></div><div class="trow_"><div class="elm-left"><ul class="chart-details-list">';

                $optionData = [];
                $optionsList = [];
                $totalResponse = SurveyResponseDetail::where("question_id",$question->id)->count();

                if(isset($question->Options) && !empty($question->Options) && in_array($question->input_type, ['dropdown','checkbox','radio'])){
                    foreach($question->Options as $index => $option){

                        $optionResponse = SurveyResponseDetail::where("question_option_id",$option->id)->count();  

                        $percentage = 0;                    
                        if($optionResponse>0){
                            $percentage = (($optionResponse/$totalResponse)*100);
                        }

                        $chartHtml .= '<li class="mb-4_ c-dib_"><span class="'.@$rectList[$index].'"></span> <span class="txt-gray-6 weight_500">'.($index+1).': '.$option->option_name.' ( '.$optionResponse.'), '.$percentage.'%</span></li>';
                        array_push($optionsList, $option->option_name);
                        array_push($optionData, $optionResponse);
                    }
                }else{
                    $chartHtml .= '<li class="mb-4_ c-dib_"><span class="'.@$rectList[0].'"></span> <span class="txt-gray-6 weight_500"> 1: Responses ('.$totalResponse.'), '.($totalResponse>0?100:0).'%</span></li>';
                    array_push($optionsList, 'Responses');
                    array_push($optionData, $totalResponse);
                }

                $chartHtml .= '</ul></div><canvas id="chart'.($key+1).'-pie" class="elm-right" style="height: 140px; width: 140px !important;"></canvas></div></div>';
                $totalQuestions ++;
                $labelsList[$key+1] = $optionsList;
                $dataList[$key+1] = $optionData;
            }
        }
        
        return array('practice'=>$practice,'title'=>($survey?$survey->title:'Not Record Found'), 'count'=>$sentCount, 'time'=>($survey?@$surveyLog->created_at:'N/A'), 'chart_html'=>$chartHtml, 'total_questions'=>$totalQuestions, 'labels'=>$labelsList, 'option_data'=>$dataList);
    }

    public function importSurveyPatients(Request $request)
    {
        if($request->has('import_file'))
        {
            try {
                
                $phoneList = [];
                $senderList = [];
                $excelList = Excel::toArray(new SurveyPatientImport, $request->file('import_file'));
                
                if(isset($excelList[0])){
                    foreach($excelList[0] as $key => $value){
                        if($key >0 && isset($value[2])){
                            array_push($phoneList,preg_replace("/[^0-9]/", "", @$value[2]));
                        }
                    }
                }
                
                $mobilenos =  PatientProfile::select('Id',DB::raw(' REPLACE(REPLACE(REPLACE(REPLACE(AES_DECRYPT(FROM_BASE64(MobileNumber),"ss20compliance19"), " ",""), "-",""), "(",""), ")","") AS MobileNumber'))->get();
                foreach($mobilenos as $obj){
                    if(!empty($obj->MobileNumber) && in_array($obj->MobileNumber, $phoneList)){
                        array_push($senderList, $obj->Id);
                    }
                }
                
                if(count($senderList) >0){
                    $response = json_decode($this->sendSurveyNotifications($request->survey_id, $senderList));
                    //if($response->errorCode)
                        return response()->json(['status'=>true,'message'=>'Survey sent successfully']);
                    //else
                    //    return response()->json(['status'=>false,'message'=>'No Patient record found or there is some template mismatch.']);   
                }else
                    return response()->json(['status'=>false,'message'=>'No Patient record found or there is some template mismatch.']);
                
             } 
             catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                $failures = $e->failures();
                $errors=[];
                foreach ($failures as $failure) {
                    $failure->row(); // row that went wrong
                    $t=$failure->attribute(); // either heading key (if using heading row concern) or column index
                    $errors[][$t]=$failure->errors(); // Actual error messages from Laravel validator
                    $failure->values(); // The values of the row that has failed.
                }             
                return response()->json(['status'=>false,'error'=>$errors]);
            }
        }
    }
}

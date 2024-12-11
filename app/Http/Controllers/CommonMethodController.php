<?php


namespace App\Http\Controllers;


use App\Services\CommonMethods;
use App\User;
use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;
use Session;

class CommonMethodController extends Controller
{
    protected $check;

    public function __construct(CommonMethods $commonMethods){
        $this->check= $commonMethods;
    }

    public function checkEmail(Request $request){
        $check_email = $this->check->checkPatientEmail($request->EmailAddress);
        return $check_email;
    }

    public function checkZip(Request $request){
        $check_zip = $this->check->checkZip($request->ZipCode);
        return $check_zip;
    }

    public function checkUserEmail(Request $request){
        
        //dd($request->email);
        if($request->id){ $practice_id = $request->id; }
        else{ $practice_id = false; }
        $check_email = $this->check->checkUserEmail($request->email, $practice_id);
        
        return $check_email;
    }

    public function checkPhone(Request $request){
        $check_email = $this->check->checkPhone($request->MobileNumber);
        return $check_email;
    }

    public function checkPracticePhone(Request $request){
        $check_email = $this->check->checkPracticePhone($request);
        return $check_email;
    }

     public function checkPracticeLicenseNumber(Request $request){
        $check_email = $this->check->checkPracticeLicenseNumber($request);
        return $check_email;
    }

    public function checkPracticeCode(Request $request){
        $check_email = $this->check->checkPracticeCode($request);
        return $check_email;
    }


    public function check_email_update(Request $request)
    {
        $check_email = $this->check->checkPatientEmailUpdate($request->EmailAddress,$request->PrevEmailAddress);
        return $check_email;
    }
    public function check_phone_update(Request $request)
    {
        $check_phone = $this->check->checkPatientPhoneUpdate($request->MobileNumber,$request->PrevPhoneNumber);
        return $check_phone;
    }
    
    public function manage_banners(Request $request)
    {
        $admin = new Admin();
       // dd();
       // $data['banner'] = 'null';
        if($request->id){ $data['banner'] = $admin->get_banners($request->id); }  
        
        $data['banners_list'] = $admin->get_banners(); 
        
        return view('admin_module.banners', $data);
    }
    
    public function store_banner(Request $request)
    {
        $admin = new Admin();
        //dd($request->all());
        if(!empty($request->all()))
        {
            $data = $request->all();
            unset($data['_token']);
            if(isset($request->image))
            {
                $this->validate($request, [
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);

                if ($request->hasFile('image')) {
                    
               if(isset($request->id)){ $del_img = $admin->get_banners($data['id']); Storage::delete($del_img->image); }
                $OrigName = preg_replace('/\s+/', '-', $request->image->getClientOriginalName());
                // dd($OrigName);
                $return =  $request->image->storeAs('banners', $OrigName);
                
                $data['image'] = $return;
                
                    $response = $admin->add_update($data);
                    return redirect('admin/banners');
                }
                else
                {   $mesg = 'Upload the correct image format.';       
                    return redirect()->back()->with($mesg);                    
                }
               
               //dd($response);
                
            }else
            {
                
                $response = $admin->add_update($data);
                    return redirect('admin/banners');
            }
        } 
    }
    
    public function delete_banner($id)
    {
        //dd($id);
         $admin = new Admin();
        $data = $admin->get_banners($id); 
        Storage::delete($data->image);
        $query = DB::table('banners')->where('id', $id)->delete();
        return redirect('admin/banners');
        
    }

    public function checkRxNumber(Request $request)
    {
       return $this->check->checkRXNumber($request->RxNumber,$request->PatientId,$request->PracticeId);
    }
    public function checkNdcNumber(Request $request)
    {
        return $this->check->checkNdcNumber($request->ndc);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Banner;
use App\Sponsors;
use Illuminate\Support\Facades\Storage;
use App\Drug;
use Excel;
use App\Imports\DrugsImport;
use App\Survey;

class BannerController extends Controller
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
    public function bannerListing()
    {
        $banners = Sponsors::all();       
        
        $data['login_page_slider'] = $banners->where('page_id', 1)->where('type_image', 'Slider');
        $data['login_page_simple'] = $banners->where('page_id', 1)->where('type_image', 'Simple');
        $data['enrol_page_slider'] = $banners->where('page_id', 2)->where('type_image', 'Slider');
        $data['enrol_page_simple'] = $banners->where('page_id', 2)->where('type_image', 'Simple');
        //dd($data);
        $drugs=Drug::select(['id','sponsored_product','sponsor_source','sponsor_item','order_web_link','gcn_seq','ndc','upc','rx_label_name','strength','dosage_form',DB::raw('CONCAT("$",unit_price) as unit_price'),'default_rx_qty'])->where('sponsored_product','!=','NULL')->orderBy('id','DESC')->get();
        $data['drugs']=$drugs;

        $viewd_drugs=Drug::select(['gcn_seq','popup_presented','rx_label_name','brand_reference',DB::raw('CONCAT("$",unit_price) as unit_price'),'marketer'])->where('sponsored_product','Y')->where('popup_presented','!=',0)->orderBy('id','DESC')->get();
        $data['view_drugs']=$viewd_drugs;
        return view('all_access.sponser_maintenance',$data);
    } 
    
    
    public function sponsorsAddUpdate(Request $request)
    {
        
       
        if($request->has('delete'))
        {
            foreach($request->get('delete') as $KeyDel=>$ValDel)
            {
                //--------- get previous image and delete from storage------
                $this->delete_sponsor_img($ValDel);
                //-------- End get previous image and delete from storage-----
                
                
                //---------- Delete from database record------
                $qur = DB::table('sponsors')->where('id', $ValDel)->delete();
                
                //---------- End delete from database record------
            }
        }
        
        if($request->has('upload_data'))
        {
            foreach($request->get('upload_data') as $keyUD=>$valUD)
            {
                $data = [];
                if(isset($valUD['title'])){ $data['title'] = $valUD['title']; }
                $data['page_id'] = $request->get('page_id');
                $data['type_image'] = $valUD['image_type'];
                
                if(isset($valUD['id']))
                {
                    if(isset($valUD['image']))
                    { 
                        @ini_set('memory_limit','128M');
                        @set_time_limit(60);
                        $data['image_url'] = $this->createImageFromBase64Store($valUD['image']);
                        if($data['image_url']){
                            $this->delete_sponsor_img($valUD['id']);
                            
                        }
                    }
                    $query = DB::table('sponsors')->where('id', $valUD['id'])->update($data);
                }
                else
                {
                    if(isset($valUD['image']))
                    { 
                        @ini_set('memory_limit','128M');
                        @set_time_limit(60);
                        $data['image_url'] = $this->createImageFromBase64Store($valUD['image']);
                    }
                    $query = DB::table('sponsors')->insert($data);
                }
                
               // print_r($data);
            }
            //exit;
        }
        
        return response()->json(['status' => 1, 'message' => 'Data saved successfully']);
    }
    
    
    public function delete_sponsor_img($id)
    {
         $record = Sponsors::find($id);
         if($record)
         {
            $delete = Storage::delete($record->image_url);
            return $delete;
         }else{
         return false;
         }
    }
    
    public function createImageFromBase64Store($base64image){ 
       
        $file_data = $base64image; 
        $img = preg_replace('/^data:image\/\w+;base64,/', '', $file_data);
        $type = explode(';', $file_data)[0];
        $type = explode('/', $type)[1];
        $file_name = 'image_'.time().str_random(8).'.'.$type;  
       
       @list($type, $file_data) = explode(';', $file_data);
       
       @list(, $file_data) = explode(',', $file_data);
       
       if($file_data!=""){ 
            $image_stor =  \Storage::disk('sponsors')->put($file_name, base64_decode($file_data)); 
           if($image_stor){ return 'sponsors/'.$file_name; }
        } 
    }
    public function importDrug(Request $request)
    {
        if($request->has('import_file'))
        {
            // dd($request->file('import_file'));
            // $rv=Excel::import(new DrugsImport, $request->file('import_file'));
            // if($rv)
            // {
            //     return response()->json(['status'=>true,'message'=>'File imported successfully']);

            // }else{
            //     return response()->json(['status'=>false,'message'=>'Something went wrong']);
            // }
            try {
             Excel::import(new DrugsImport, $request->file('import_file'));
             return response()->json(['status'=>true,'message'=>'File imported successfully']);
             } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
             $failures = $e->failures();
             // dd($failures);
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

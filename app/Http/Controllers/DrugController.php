<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Drug;

use DB;

use auth;

class DrugController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drug_data = Drug::paginate(15);

        // dd($drug_data);

         return view('drugs_module.drugs')->with('drugs', $drug_data);
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

     /**    Display all drugs added from pharmacy  **/
    public function practiceDrugListing($id=false)
    {

        if($id){ $data['drug_id_edit'] = $id; }

        $drug = Drug::select(DB::raw('pr.practice_name, drugs_new.*'))
                ->join('practices AS pr', 'pr.id', 'drugs_new.added_from_pharmacy' )
                ->where('drugs_new.added_from_pharmacy', '!=' , 'NULL')->orderBy('drugs_new.created_at','DESC')->get();
        //dd($drug->all());
        $data['drug'] = $drug->all();

        return view('all_access.drug_maintenance',  $data);



    }

    public function orderSearchDrug(Request $request){

        $term = trim(str_replace("-", "", $request->q));
         if (empty($term)) {
             return \Response::json([]);
         }
        
        $isNdc = 0; 
        $formatted_drugs = [];
        $cleanStr = str_replace("-","",$term);
        if(is_numeric($cleanStr) && Drug::where('ndc', 'LIKE',  $term)->orwhereRaw('REPLACE(`ndc`,"-","") LIKE ?', [$term])->count() == 1){
            $drug = Drug::select('*')
                ->where('ndc', 'LIKE',  $term)
                ->orwhereRaw('REPLACE(`ndc`,"-","") LIKE ?', [$term])
                ->orderBy('strength','ASC')->orderBy('unit_price','ASC')->get();
            $isNdc = 1; 
        }else if(is_numeric($cleanStr) && Drug::where('upc', 'LIKE',  $term)->whereNotNull('upc')->count() == 1){
            $drug = Drug::select('*')
                    ->where('upc', 'LIKE',  $term)
                    ->whereNotNull('upc')
                    ->orderBy('strength','ASC')->orderBy('unit_price','ASC')->get();
            $isNdc = 1; 
        }
        else{
            $drug = Drug::select('*')
                ->where('rx_label_name', 'LIKE', $term.'%')
                ->orwhere('ndc', 'LIKE',  $term.'%')
                ->orwhere('upc', 'LIKE',  $term.'%')    
                ->orwhereRaw('REPLACE(`ndc`,"-","") LIKE ?', [$term.'%'])->orderBy('strength','ASC')->orderBy('unit_price','ASC')->get();
        }
        
        foreach ($drug as $d) {
             if(!isset($tempData[$d->rx_label_name])){
                 $tempData[$d->rx_label_name] = ['id' => $d->id, 'text' => trim($d->rx_label_name)];
                 $formatted_drugs[] = ['id' => $d->id, 'text' => trim($d->rx_label_name)];
             }
         }

         return \Response::json(['drugData'=>$formatted_drugs,'allDrugData'=>$drug,'isNdc'=>$isNdc]);
     }

    public function getSavingOffers(Request $request){

        $drug = Drug::find($request->drug_id);

        $sameDrug = Drug::select('*')
                ->where('rx_label_name', 'LIKE', $request->title.'%')
                ->where('id','!=', $request->drug_id)
                //->where('unit_price','<=',$drug->unit_price)
                ->where('gcn_seq', 'LIKE',  $drug->gcn_seq)
                ->where('sponsored_product','Y')
                //->orwhere('upc', 'LIKE',  $drug->upc)    
                ->whereNotNull('upc')
                ->orderBy('strength','ASC')->orderBy('unit_price','ASC')
                ->limit(3)->get();
        
        $similarDrug = Drug::select('*')
                ->where('id','!=', $request->drug_id)
                ->where('unit_price','<',$drug->unit_price)
                ->where('gcn_seq', 'LIKE',  $drug->gcn_seq)
                //->orwhere('upc', 'LIKE',  $drug->upc)    
                ->orwhere('generic_pro_id', $drug->generic_pro_id)    
                ->where('sponsored_product','Y')
                ->whereNotNull('upc')
                ->orderBy('strength','ASC')->orderBy('unit_price','ASC')
                ->limit(3)->get();

         return \Response::json(['same_drugs'=>$sameDrug,'similar_drugs'=>$similarDrug]);
    }

     /*
      * @param [search]
      * Search Marketer on base of rx_label
      */
     public function searchDrugMarketer(Request $request){
         $result = Drug::where("rx_label_name","LIKE","%".$request->search."%")
                 ->pluck("id","marketer")->toArray();
         return json_encode($result);
     }



          public function searchDrugLowerCost(Request $request){
        $result = Drug::find($request->search);
        $result2 = Drug::where('gcn_seq',$result->gcn_seq)->where('sponsored_product','Y')
         ->whereRaw("TRIM(`rx_label_name`) = ?" ,[trim($result->rx_label_name)])
         ->orderBy('unit_price','ASC')->limit(1)->first();
         if($result2!=null)
         {
            $result2->popup_presented=$result2->popup_presented + 1; 
            $result2->update();
         }
         return json_encode($result2);
     }

     /*
      * @param [search,marketer]
      * Search Strength on base of rx_label & Marketer
      */
     public function searchDrugStrength(Request $request){
         $data = Drug::where("rx_label_name","LIKE","%".$request->search."%")
                 ->where("marketer","LIKE","%".$request->marketer."%")
                 ->where("strength","!=","")->whereNotNull("strength")
                 ->select("id","strength","unit_price","dosage_form","rx_expire",
                 "brand_reference","default_rx_qty")->groupby('strength')->get();

         $list=[];
         $items=[];
         foreach($data as $item){
             $list[$item->id] = $item->strength;
             $items[$item->id] = ['unit_price'=>$item->unit_price,'dosage_form'=>$item->dosage_form,'rx_expire'=>$item->rx_expire,'brand_reference'=>$item->brand_reference,
            'default_rx_qty'=>$item->default_rx_qty];
         }
         return ['list'=>json_encode($list),'data'=> json_encode($items)];
     }


    public function drugSearch(Request $request){
        if($request->ajax())
        {

            if($request->q !='')
            {

                $keyword = $request->q;
                $keyword = trim(str_replace("-", "", $keyword));
               $query = Drug::select(['id AS value', DB::raw('CONCAT(COALESCE(rx_label_name,""), " - ", COALESCE(ndc,""), " - ", (CASE WHEN  gcn_seq IS NOT NULL THEN gcn_seq ELSE "" END) ) AS text')])
                        ->where('rx_label_name', 'LIKE', '%'.$keyword.'%')
                        ->orwhere('ndc', 'LIKE',  '%'.$keyword.'%')
                        ->orwhere('upc', 'LIKE',  '%'.$keyword.'%')
                        ->orwhereRaw('REPLACE(`ndc`,"-","") LIKE ?', ['%'.$keyword.'%'])
                        ->orwhere('generic_name', 'LIKE',  '%'.$keyword.'%')
                        ->orwhere('generic_pro_id', 'LIKE', '%'.$keyword.'%')
                        ->orwhere('gcn_seq', 'LIKE', '%'.$keyword.'%')
                        ->groupBy('value')->get();



               return response()->json($query->all());

            }
            if($request->id !='')
            {

                 $keyword = $request->id;

                $query = DB::table('drugs_new')
                        ->select('*')
                        ->where('id', $keyword)->get();

                return response()->json($query->all());
            }
        }
    }

    public function similar_drug_filter(Request $request){

        $columns = array( 
            0 =>'ndc',
            1=> 'rx_label_name',
            2=> 'generic_name',
            3=> 'strength',
            4=> 'marketer',
            // 5=>'unit_price',
            5=>'generic_or_brand',
            6=>'major_reporting_cat'
        );
// dd($request->get('start'));
        $limit = $request->input('length');
        $start = $request->input('start');
        
        // if($request->get('order.0.column'))
            $order = $columns[$request->input('order.0.column')];
        //    echo $order;
        // dd((int)$request->input('order.0.column'));
        // if($request->get('order.0.dir'))
        $dir = $request->input('order.0.dir');
        $totalData = Drug::count();


        $totalFiltered = Drug::select('id','ndc','rx_label_name','generic_name','strength','marketer',
        'generic_or_brand','major_reporting_cat')
        ->when(!empty($request->all()),function($q) use ($request){
            if($request->has('ndc') && $request->ndc){
              $q->where('ndc', 'LIKE',  '%'.$request->ndc.'%');

            }
            if($request->has('gcn') && $request->gcn){
              $q->where('gcn_seq', 'LIKE', '%'.$request->gcn.'%');
                        }
                        if($request->has('gpi') && $request->gpi){
                          $q->where('generic_pro_id', 'LIKE',  '%'.trim(str_replace("-", "", $request->gpi)).'%');
                                    }

  
        })

        ->count();


    $drugs =  Drug::select('id','ndc','rx_label_name','generic_name','strength','marketer',
      'unit_price','generic_or_brand','major_reporting_cat')
      ->when(!empty($request->all()),function($q) use ($request){
          if($request->has('ndc') && $request->ndc){
            $q->where('ndc', 'LIKE',  '%'.$request->ndc.'%');
// $q->where('ndc', 'LIKE',  '%'.trim(str_replace("-", "", $request->ndc)).'%');
          }
          if($request->has('gcn') && $request->gcn){
            $q->where('gcn_seq', 'LIKE', '%'.$request->gcn.'%');
                      }
                      if($request->has('gpi') && $request->gpi){
                        $q->where('generic_pro_id', 'LIKE',  '%'.trim(str_replace("-", "", $request->gpi)).'%');
                                  }
// ->orwhere('generic_pro_id', 'LIKE',  '%'.$request->GPI.'%')

      })
      ->offset( $start)
       ->limit( $limit)
       ->orderBy($order,$dir)
      ->get();
   
      $json_data = array(
        "draw"            => intval($request->input('draw')),  
        "recordsTotal"    => intval($totalData),  
        "recordsFiltered" => intval($totalFiltered), 
        "data"            =>  $drugs  
        );

echo json_encode($json_data); 

    }

    public function addUpdate(Request $request){
        if($request->has('sheetDrugId')){
            $request['id'] = $request->sheetDrugId;
            unset($request['sheetDrugId']);
        }
       
        $flag = false;
        if($request->ajax() )
             {
               
                $id = null;

            if($request->id )
         {

            $update_data = $request->except('sheetDrugId','sheetCategoryId','cat_drug_id');
            $id = $update_data['id'];
            unset($update_data['id']);
            $check_from_db=collect(new Drug);
            if($update_data['ndc'])
            $check_from_db = Drug::where('id', '!=', $id)->where('ndc', $update_data['ndc'])->get();
            
            if(count($check_from_db->all())>0 && !$request->has('sheetCategoryId'))
            {
                $response['status'] = 2;
                $response['msg'] = 'NDC is already exists for other drug.';
            }else
            {
            //unset($update_data['ndc']);
            //dd($id);
            $update_data['added_from_pharmacy'] = NULL;

            if(!$request->has('sheetCategoryId'))
                $query = Drug::where('id', $id)->update($update_data);

            $response['status'] = 1;
            $response['msg'] = 'Drug updated successfully.';


            $response['type'] = 'update';
            }
        }else
        {
            $check_from_db=collect(new Drug);
            if($request->ndc)
            $check_from_db = Drug::where('ndc', $request->ndc)->get();
            if(count($check_from_db->all())>0)
            {
                $response['status'] = 2;
                $response['msg'] = 'NDC is already exists for other drug.';
            }else
            {

            $query  = Drug::create($request->except('sheetDrugId','sheetCategoryId','cat_drug_id'));
            $id = $query->id;
            $response['last_id'] = $query->id;
            $response['status'] = 1;
            $response['msg'] = 'Drug added successfully.';
            }
        }
        if($request->has('sheetCategoryId') && $id > 0){
            $response['drug_added'] = \App\OrderSheetDrug::updateOrCreate(
                ['order_sheet_category_id' => $request->sheetCategoryId, 'id' => $request->cat_drug_id],    
                ['order_sheet_category_id' => $request->sheetCategoryId,'drug_id'=>$id,  'drug_name' => $request->rx_label_name, 'generic_name'=>$request->generic_name, 'dosage_type' => $request->dosage_form, 'strength' => $request->strength, 'quantity' => $request->default_rx_qty,'upc_number' => $request->upc,'ndc_number' => $request->ndc,'gcn_number' => $request->gcn_seq,'alt_ndc_number' => $request->alternate_ndc, 'instructions' => $request->instructions, 'created_by' => auth::user()->id, 'updated_by' => auth::user()->id]

            );
        }else if($id > 0){
            \App\OrderSheetDrug::where('drug_id', $id)
                    ->update(
                ['drug_name' => $request->rx_label_name, 'dosage_type' => $request->dosage_form, 'strength' => $request->strength, 'quantity' => $request->default_rx_qty,'upc_number' => $request->upc,'ndc_number' => $request->ndc,'gcn_number' => $request->gcn_seq,'alt_ndc_number' => $request->alternate_ndc, 'instructions' => $request->instructions]
            );
        }
        
        return response()->json($response);
    }
}

public function drugCat(Request $request){
    if($request->ajax())
    {
        if($request->type=='major')
        {
            $query = Drug::select(['major_reporting_cat AS text'])->where('major_reporting_cat', 'LIKE', '%'.$request->q.'%')->groupBy('major_reporting_cat')->get();
        }
        if($request->type=='minor')
        {
            $query = Drug::select(['minor_reporting_class AS text'])->where('minor_reporting_class', 'LIKE', '%'.$request->q.'%')->groupBy('minor_reporting_class')->get();
        }
        return response()->json($query->all());
    }
}
public function remove_sponsored(Request $request)
{
    if($request->ajax())
    {
        if($request->id)
        {
            $obj=Drug::where('id',$request->id)->first();
            if($request->sponsored_product=='N')
            {
                $obj->sponsored_product='Y';
                $obj->sponsor_source=$request->sponsor_source;
                $obj->sponsor_item=$request->sponsor_item;
                $obj->order_web_link=$request->order_web_link;
            }else{
                $obj->sponsored_product='N';
                $obj->sponsor_source=NULL;
                $obj->sponsor_item=NULL;
                $obj->order_web_link=NULL;  
            }
            
            
            $obj->unit_price=$request->unit_price;
            // ->updateOrCreate(['sponsored_product'=>'N','sponsor_source'=>NULL,'sponsor_item'=>NULL,'order_web_link'=>NULL,'unit_price'=>$request->unit_price]);
            $obj->save();
            return response()->json(['status'=>$obj]) ;          
        }
    }
}


}

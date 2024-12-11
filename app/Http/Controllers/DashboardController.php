<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Practice;
use App\Drug;
use DB;
use auth;
use App\Group;
use App\Facilitator;
use App\User;

class DashboardController extends Controller
{
    function overview()
    {

        $data['practices'] = Practice::where(['practice_type'=>'Pharmacy','reviewed'=>NULL] )
        ->when(auth::user()->hasRole('practice_super_group'),function($query){
                $query->whereIn('practices.id',auth::user()->practices->pluck('id'));
        })->with('users','createdBy')->orderBy('practices.id', 'DESC')->get();
        // dd($data['practices']);
        $data['practices_count'] = Practice::where('practice_type', 'Pharmacy' )->when(auth::user()->hasRole('practice_super_group'),function($query){
            $query->whereIn('practices.id',auth::user()->practices->pluck('id'));
    })->count();

        $data['law_practices'] = Practice::where(['practice_type'=>'Law','reviewed'=>NULL] ) ->when(auth::user()->hasRole('practice_super_group'),function($query){
            $query->whereIn('practices.id',auth::user()->practices->pluck('id'));
    })->with('users','createdBy')->orderBy('practices.id', 'DESC')->get();

        $data['law_practices_count'] = Practice::where('practice_type', 'Law' ) ->when(auth::user()->hasRole('practice_super_group'),function($query){
            $query->whereIn('practices.id',auth::user()->practices->pluck('id'));
    })->count();

        // $data['physician'] = Practice::where(['practice_type'=>'Physician','added_from_pharmacy'=>NULL ,'reviewed'=>NULL] )->with('users')->orderBy('created_at', 'DESC')->get();
        $data['physician'] = Practice::where(['practice_type'=>'Physician','added_from_pharmacy'=>NULL ,'reviewed'=>NULL] )
        ->when(auth::user()->hasRole('practice_super_group'),function($query){
            $query->whereIn('practices.id',auth::user()->practices->pluck('id'));
    })
    ->with('users','createdBy')->orderBy('practices.id', 'DESC')->get();

       // $data['count'] = Practice::whereNull('added_from_pharmacy')->count();
       $data['physician_count'] = Practice::where(['practice_type'=>'Physician','added_from_pharmacy'=>NULL ] )
       ->when(auth::user()->hasRole('practice_super_group'),function($query){
        $query->whereIn('practices.id',auth::user()->practices->pluck('id'));
})
->count();

       $data['drug'] = Drug::select(DB::raw('pr.practice_name, drugs_new.*'))
                ->join('practices AS pr', 'pr.id', 'drugs_new.added_from_pharmacy' )
                ->when(auth::user()->hasRole('practice_super_group'),function($query){
                    $query->where('pr.id',auth::user()->practices->pluck('id'));
            })
                ->where('drugs_new.added_from_pharmacy', '!=' , 'NULL')->orderBy('drugs_new.created_at','DESC')->get();

                $data['state'] = DB::table('State')->get();
                $data['groups']=Group::get();
                $data['facilitator'] = Facilitator::get();
        return view('all_access/overview', $data);
    }
    function practice_drug_listing(Request $request)
    {
        parse_str($request->getContent(), $arr);
        $columnName=null;
        $columnSortOrder=null;
        if(isset($arr['order']))
        {
          $columnIndex = $arr['order'][0]['column']; // Column index
       
          $columnName = $arr['columns'][$columnIndex]['data']; // Column name

          $columnSortOrder = $arr['order'][0]['dir']; // asc or desc
        }
        // echo $columnName." ".$columnSortOrder;exit;
        if(isset($request->type))
        {
            if($request->type=="pharmacy")
            {
                // $pharmacies = Practice::where(['practice_type'=>'Pharmacy','reviewed'=>NULL] )
                // ->when(auth::user()->hasRole('practice_super_group'),function($query){
                //         $query->whereIn('practices.id',auth::user()->practices->pluck('id'));
                // })
                // ->offset($arr['start'])->limit($arr['length'])
                // ->with('users','createdBy')
                // ->when((isset($columnName) && isset($columnSortOrder)),function($query) use($columnName,$columnSortOrder){
                //     if($columnName=="created_by")
                //     {
                //         $query->orderBy(User::select('name')->whereColumn('users.id', 'practices.created_by_user'),$columnSortOrder);
                //     }
                //     else{
                //         $query->orderBy($columnName,$columnSortOrder);
                //     }  
                        
                // })
                // ->orderBy('practices.id', 'DESC')->get();
                $pharmacies = Practice::select('practices.*','users.name AS created_by',DB::raw('(SELECT u.name FROM practice_user AS pu JOIN users AS u ON u.id = pu.user_id WHERE pu.practice_id=practices.id ORDER BY pu.user_id ASC LIMIT 1) AS users'))
                ->join('users','users.id','practices.created_by_user')
                ->where(['practice_type'=>'Pharmacy','reviewed'=>NULL] )
                ->when(auth::user()->hasRole('practice_super_group'),function($query){
                        $query->whereIn('practices.id',auth::user()->practices->pluck('id'));
                })
                ->offset($arr['start'])->limit($arr['length'])
                // ->with('users','createdBy')
                ->when((isset($columnName) && isset($columnSortOrder)),function($query) use($columnName,$columnSortOrder){
                     $query->orderBy($columnName,$columnSortOrder);
                })
                ->orderBy('practices.id', 'DESC')->get();
             
                $practices_count = Practice::where(['practice_type'=> 'Pharmacy','reviewed'=>NULL ])->when(auth::user()->hasRole('practice_super_group'),function($query){
                    $query->whereIn('practices.id',auth::user()->practices->pluck('id'));
                })->count();
                return response()->json(['pharmacies'=>$pharmacies,'recordsFiltered'=>$practices_count]);
            }
            else if($request->type=="physician")
            {
                $physicians = Practice::select('practices.*','users.name AS created_by',DB::raw('(SELECT u.name FROM practice_user AS pu JOIN users AS u ON u.id = pu.user_id WHERE pu.practice_id=practices.id ORDER BY pu.user_id ASC LIMIT 1) AS users'))
                ->join('users','users.id','practices.created_by_user')
                ->where(['practice_type'=>'Physician','added_from_pharmacy'=>NULL ,'reviewed'=>NULL] )
                    ->when(auth::user()->hasRole('practice_super_group'),function($query){
                    $query->whereIn('practices.id',auth::user()->practices->pluck('id'));
                    })
                    ->offset($arr['start'])->limit($arr['length'])
                    // ->with('users','createdBy')
                    ->when((isset($columnName) && isset($columnSortOrder)),function($query) use($columnName,$columnSortOrder){
                        $query->orderBy($columnName,$columnSortOrder);
                    })
                    ->orderBy('practices.id', 'DESC')->get();
                $physician_count = Practice::where(['practice_type'=>'Physician','added_from_pharmacy'=>NULL ,'reviewed'=>NULL ] )
                    ->when(auth::user()->hasRole('practice_super_group'),function($query){
                    $query->whereIn('practices.id',auth::user()->practices->pluck('id'));
                    })
                ->count();
                return response()->json(['physicians'=>$physicians,'recordsFiltered'=>$physician_count]);
            }
            else if($request->type=="law")
            {
                $law_practices = Practice::select('practices.*','users.name AS created_by',DB::raw('(SELECT u.name FROM practice_user AS pu JOIN users AS u ON u.id = pu.user_id WHERE pu.practice_id=practices.id ORDER BY pu.user_id ASC LIMIT 1) AS users'))
                ->join('users','users.id','practices.created_by_user')
                ->where(['practice_type'=>'Law','reviewed'=>NULL] ) ->when(auth::user()->hasRole('practice_super_group'),function($query){
                    $query->whereIn('practices.id',auth::user()->practices->pluck('id'));
                    })
                ->offset($arr['start'])->limit($arr['length'])
                // ->with('users','createdBy')
                ->when((isset($columnName) && isset($columnSortOrder)),function($query) use($columnName,$columnSortOrder){
                        $query->orderBy($columnName,$columnSortOrder);
                })
                ->orderBy('practices.id', 'DESC')->get();
                $law_practices_count = Practice::where(['practice_type'=>'Law','reviewed'=>NULL] ) ->when(auth::user()->hasRole('practice_super_group'),function($query){
                    $query->whereIn('practices.id',auth::user()->practices->pluck('id'));
                    })
                ->with('users','createdBy')->orderBy('practices.id', 'DESC')->count();
                return response()->json(['law_practices'=>$law_practices,'recordsFiltered'=>$law_practices_count]);
            }
            else if($request->type=="drug")
            {
                $drugs = Drug::select(DB::raw('pr.practice_name, drugs_new.*'))
                ->join('practices AS pr', 'pr.id', 'drugs_new.added_from_pharmacy' )
                ->when(auth::user()->hasRole('practice_super_group'),function($query){
                    $query->where('pr.id',auth::user()->practices->pluck('id'));
                })
                ->where('drugs_new.added_from_pharmacy', '!=' , 'NULL')
                ->offset($arr['start'])->limit($arr['length'])
                ->when((isset($columnName) && isset($columnSortOrder)),function($query) use($columnName,$columnSortOrder){
                        $query->orderBy($columnName,$columnSortOrder);
                })
                ->orderBy('drugs_new.created_at','DESC')->get();
                $drug_count=Drug::select(DB::raw('pr.practice_name, drugs_new.*'))
                ->join('practices AS pr', 'pr.id', 'drugs_new.added_from_pharmacy' )
                ->when(auth::user()->hasRole('practice_super_group'),function($query){
                    $query->where('pr.id',auth::user()->practices->pluck('id'));
                })
                ->where('drugs_new.added_from_pharmacy', '!=' , 'NULL')->orderBy('drugs_new.created_at','DESC')->count();

                return response()->json(['drugs'=>$drugs,'recordsFiltered'=>$drug_count]);
            }
            
        }
        
    }
    function get_pharmacies(Request $request)
    {
       if($request->type=="pharmacy")
        {
            // $data['practices'] = Practice::where(['practice_type'=>'Pharmacy'] )->orWhere('practice_type','Law')->with('users')->orderBy('practices.id', 'DESC')->get();
            $data['practices'] = Practice::where(['practice_type'=>'Pharmacy'] )
            ->when(auth::user()->hasRole('practice_super_group'),function($query){
                $query->whereIn('practices.id',auth::user()->practices->pluck('id'));
        })
        ->with('users','createdBy')->orderBy('practices.id', 'DESC')->get();
        }else if($request->type=="physician")
        {
            $data['practices'] = Practice::where(['practice_type'=>'Physician','added_from_pharmacy'=>NULL ] )
            ->when(auth::user()->hasRole('practice_super_group'),function($query){
                $query->whereIn('practices.id',auth::user()->practices->pluck('id'));
        })
        ->with('users','createdBy')->orderBy('practices.id', 'DESC')->get();
        }
        else if($request->type=="law_practice")
        {
            $data['practices'] = Practice::where(['practice_type'=>'Law'])
            ->when(auth::user()->hasRole('practice_super_group'),function($query){
                $query->whereIn('practices.id',auth::user()->practices->pluck('id'));
        })
        ->with('users','createdBy')->orderBy('practices.id', 'DESC')->get();
        }
       // dd($data['practices']);
        // $d=['data'=>$data['practices']];
        // dd($d);
        return response()->json(['data'=>$data['practices']]);
    }
}

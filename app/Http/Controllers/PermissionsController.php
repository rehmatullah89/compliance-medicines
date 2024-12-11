<?php

namespace App\Http\Controllers;

use App\Module;
use App\Role;
use Illuminate\Http\Request;
use App\Permission;
class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Permission::with('modules')->orderByDesc('id')->get();
        return view('permissions.index',['data' => $data ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modules = Module::all();
        return view('permissions.create',compact('modules'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($this->validate($request,[
            'name'=>'required|max:30',
            'name'=>'unique:permissions',
        ])){
        
            $permissions = Permission::create($request->all());
            if ($permissions) {
                $superAdmin = Role::where('name','compliance_admin')->orwhere('name','all_access')->first();
                if($superAdmin){
                    $superAdmin->givePermissionTo($request->name);
                }
                return redirect('permissions')->with('message', 'Record has been Added Successfully.');
            }
        } else {
            return redirect('permissions')->with('message', 'Not added');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $modules = Module::all();
        $data=Permission::with('modules')->where('id', $id)->first();
        if($data->modules){
            $module_id = $data->modules->id;
        }else{
            $module_id ='';
        }
        return view('permissions.edit',['data' => $data ,'modules' => $modules,'module_id' => $module_id ]);
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
        $permissions = Permission::find($id);
        $permissions =$permissions->update($request->all());
        if ($permissions) {

            return redirect('permissions')->with('message', 'Record has been Updated Successfully.');

        } else {
            return redirect('permissions')->with('message', 'Not Updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = Permission::find($id);
        $deleted = $res->delete();
        if($deleted){
            return response()->json(['status'=> 200, 'message'=>'Permission deleted successfully']);
        }
    }
}

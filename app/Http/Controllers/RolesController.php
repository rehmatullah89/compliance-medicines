<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission;
use App\Module;
use App\Role;
use App\Facilitator;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions =Role::with('permissions')->orderByDesc('id')->get();
        // return $user =User::all();
        // return  $user->permissions;
        $data=Role::all();
       return view('roles.index',compact('permissions','data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modules = Module::all();
        $permissions = Permission::all();
       return view('roles.create',compact('modules','permissions'));
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
            'name'=>'unique:roles',
        ])){

            $permission = $request->permission;
            $roles = Role::create($request->except('permission'));
            $roles->givePermissionTo($permission);
            if ($roles) 
                return redirect('roles')->with('message', 'Record has been Added Successfully.');
        }else{
            return redirect('roles')->with('message', 'There is some error occured.');
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
        $modules = Module::all();
        $permissions= Permission::all();
        $selected_permissions = Role::with('permissions')->where('id',$id)->get();
        $selected_list = \DB::table("role_has_permissions")->where("role_id",$id)->pluck("permission_id")->toArray();
        $data=Role::where('id', $id)->first();
//        dd($selected_permissions, $data,$permissions,$modules);
        return view('roles.edit',['data' => $data ,'modules' => $modules ,'permissions' => $permissions,'selected_permissions' => $selected_permissions, 'selected_list'=>$selected_list]);

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
        $permission = $request->permission;
        $roles = Role::find($id);
        $role = $roles->update($request->except('permission'));
        // return $role;
        $roles->syncPermissions($permission);
        if ($role) {

            return redirect('roles')->with('message', 'Record has been Updated Successfully.');

        } else {
            return redirect('roles')->with('message', 'Not Updated');
        }    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = Role::destroy($id);
        if($deleted){
            return response()->json(['status'=> 200, 'message'=>'Module deleted successfully']);
        }
    }
    /*Facilitator*/
    public function facilitatorAddUpdate(Request $request){
        if($request->id)
        {
            $facilitator=$request->all();
            Facilitator::where('id',$request->id)->update($facilitator);
            $fobj=Facilitator::find($request->id);
                return response()->json(['status'=>true,'message'=>'Facilitator updated successfully','facilitator'=>$fobj,'type'=>'update']);
        }else{
            $facilitator=$request->all();

           
            $fobj=Facilitator::create($facilitator);
            return response()->json(['status'=>true,'message'=>'Facilitator added successfully','facilitator'=>$fobj,'type'=>'add']);  
        }
        
    }

    public function getAllFacilitators(){
        $facilitators =  Facilitator::get();
        return response()->json(['data'=>$facilitators]);
    }

    public function getFacilitatorDetail($id){
        $facilitator = Facilitator::where('id', $id)->first();

        $data['facilitator']=$facilitator;
        return response()->json($data);
    }
}

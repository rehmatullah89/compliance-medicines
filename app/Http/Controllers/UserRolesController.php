<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission;
use App\User;
use App\Module;
use App\UserRole;
class UserRolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::with('roles')->orderByDesc('id')->get();
        
       return view('user_roles.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
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
        $roles = \App\Role::pluck("name","id")->toArray();
        $userData = User::where("id",$id)->pluck("name","id")->toArray();
        $selectedData = UserRole::where("model_id",$id)->pluck("role_id")->toArray();

        return view('user_roles.edit',['data' => $userData ,'roles' => $roles, 'selected_roles'=>$selectedData]);

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
        $user = User::find($id);        
        
        UserRole::where('model_id',$id)->delete();
        $user->assignRole($request->input('roles'));
        $user->syncRoles($request->input('roles'));
        
        if ($user) {
            return redirect('user-roles')->with('message', 'Record has been Updated Successfully.');
        } else {
            return redirect('user-roles')->with('message', 'Not Updated');
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
        
    }
}

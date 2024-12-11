<?php

namespace App\Http\Controllers;

use App\Module;
use Illuminate\Http\Request;
use Session;
class ModulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modules = Module::orderByDesc('id')->get();
       return view('modules.index',compact('modules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('modules.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|max:30',
        ]);
        unset($request['_token']);
        $obj = Module::create($request->all());
        if($obj){
            Session::flash('message',"Module Added Successfully");
            return redirect()->to('modules');
        }else{
            Session::flash('error',"Module did not added. Please try again");
            return redirect()->to('modules');
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
        $module = Module::find($id);

        return view('modules.edit',compact('module'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $module = Module::find($id);
        return view('modules.edit',compact('module'));
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
        $modules = Module::find($id);
        $modules =$modules->update($request->all());
        if ($modules) {
            return redirect('modules')->with('message', 'Record has been Updated Successfully.');

        } else {
            return redirect('modules')->with('message', 'Not Updated');
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
        $res = Module::find($id);
        $deleted = $res->delete();
        if($deleted){
            return response()->json(['status'=> 200, 'message'=>'Module deleted successfully']);
        }
    }
}

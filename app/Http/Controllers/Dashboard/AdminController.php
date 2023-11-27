<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::paginate();

        return view('Dashboard.admins.index' ,['admins'=>$admins]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Dashboard.admins.create' ,['admin'=>new  Admin() , 'roles'=>Role::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
        ]);

        $admin = Admin::create($request);
        $admin->roles()->attach($request->roles);
        return redirect()->route('admins.index')
            ->with('success' ,'Admin Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        return view('Dashboard.admins.edit' ,['admin'=>$admin ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'name'=>'required',
        ]);

        $admin->update($request);
        $admin->roles()->sync($request->roles);

        return redirect()->route('admins.index')
            ->with('success' ,'Admin Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Admin::destroy($id);
        return redirect()->route('admins.index');
    }
}

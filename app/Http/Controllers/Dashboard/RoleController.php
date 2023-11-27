<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\RoleAbilities;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Role::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::paginate();

        return view('Dashboard.roles.index' ,['roles'=>$roles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Dashboard.roles.create' ,['role'=>new  Role()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'abilities'=>'required|array'
        ]);

        $role = Role::createRoleAndAbility($request);
        return redirect()->route('roles.index')
            ->with('success' ,'Role Created Successfully');
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
    public function edit(Role $role)
    {
        $role_ability =$role->abilities()->pluck('type' , 'ability')->toArray();
        return view('Dashboard.roles.edit' ,['role'=>$role , 'role_abilities' => $role_ability]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name'=>'required',
            'abilities'=>'required|array'
        ]);

        $role->updateRoleAndAbility($request);

        return redirect()->route('roles.index')
            ->with('success' ,'Role Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Role::destroy($id);
        return redirect()->route('roles.index');
    }
}

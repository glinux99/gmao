<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role as ModelsRole;
use Spatie\Permission\Models\Permission as ModelsPermission;

class RolesPermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = ModelsRole::paginate();
        return $role;
    }
    public function index2()
    {
        // get roles and permissions with users
        $role = ModelsRole::with('users', 'permissions')->paginate();
        return $role;
    }
    public function index3()
    {
        // get roles and permissions
        $role = ModelsRole::with('permissions')->paginate();
        return $role;
    }
    public function index4()
    {
        // get roles and permissions
        $role = ModelsPermission::get();
        return response()->json(['data' => $role]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role2 = ModelsRole::create(['name' => $request->name, 'description' => $request->description]);
        $permissions = ModelsPermission::whereIn('id', $request->permissions)->get();
        $role2->syncPermissions($permissions);
        return response()->json(['data' => $role2]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = ModelsRole::with('users', 'permissions')->find($id);
        return response()->json(['data' => $role]);
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
        $role = ModelsRole::find($id);
        $role->update(['name' => $request->name, 'description' => $request->description]);
        $permissions = ModelsPermission::whereIn('id', $request->permissions)->get();
        $role->syncPermissions($permissions);
        // return  $request->permissions;
        return response()->json(['data' => $role]);
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
}

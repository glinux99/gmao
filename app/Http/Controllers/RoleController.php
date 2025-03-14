<?php

namespace App\Http\Controllers;

use App\Models\User;
use Nette\Utils\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.roles');
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

    public function ruleForOwner(Request $request){
        $userCtrl= new UserController();
        $request['enterprise_id']=$this->getEse($request['user_id']);
        $newRule=Role::create($request->all());
        if ($newRule) {
            DB::update('update users set permissions = ? where id = ?',[$newRule->id,$newRule->user_id]);
        }
       return $userCtrl->show(User::find($newRule->user_id));
    }
    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(Request $request)
    {
        return Role::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Roles  $Roles
     * @return \Illuminate\Http\Response
     */
    public function show(Role $Roles)
    {
        return view('users.role');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Roles  $Roles
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $Roles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Roles  $Roles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $element = Role::find($id);
        return $element->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Roles  $Roles
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $Roles)
    {
        return Role::destroy($Roles);
    }
}

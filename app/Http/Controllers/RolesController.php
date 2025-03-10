<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role as Roles;
use App\Models\User;
use Nette\Utils\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($entreprise_id)
    {
        return Roles::where('enterprise_id', $entreprise_id)->get();
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
        $userCtrl= new UsersController();
        $request['enterprise_id']=$this->getEse($request['user_id']);
        $newRule=Roles::create($request->all());
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
        return Roles::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Roles  $Roles
     * @return \Illuminate\Http\Response
     */
    public function show(Roles $Roles)
    {
        return Roles::find($Roles);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Roles  $Roles
     * @return \Illuminate\Http\Response
     */
    public function edit(Roles $Roles)
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
        $element = Roles::find($id);
        return $element->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Roles  $Roles
     * @return \Illuminate\Http\Response
     */
    public function destroy(Roles $Roles)
    {
        return Roles::destroy($Roles);
    }
}

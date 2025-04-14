<?php

namespace App\Http\Controllers;
use Spatie\Permission\Models\Role as ModelsRole;
use Spatie\Permission\Models\Permission as ModelsPermission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index(){
        // return view('users.permissions');
        $permissions = ModelsPermission::with('roles')->get();
        return view('users.permissions', ['permissions' => $permissions]);

    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\NewRegister;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $users= User::withoutRole('technicien')->get();
        $users= User::get();
        $roles= Role::all();
        return view('users.users',['users'=>$users, 'roles'=>$roles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
        ],   [
            'name.required' => 'Le champ nom d\'utilisateur est obligatoire',
        ]);
        $avatar = $request->file('avatar');
        if ($request->file('avatar')) {
            $avatarPath = $avatar->store('avatars');
            $request['avatar'] = $avatarPath;
            $user=User::create($request->all());
        }

        // Create a new user
        else {

            $user=User ::create($request->except(['avatar']));

        }
       try {
        $user->notify(new NewRegister ([
            "title"=>"Vous avez été enregistré comme ". $user->type? $user->type : "utilisateur" ." chez ". Config('app.name').". Merci",
            "greeting"=>"Bonjour Ms/Md ".$request->name
        ]));
       } catch (\Throwable $th) {
        toast('Erreur lors de l\'envoie du mail sur l\'adresse fournie mais l\'utilisateur a ete cree', 'error');
       }
       $user->syncRoles($request->role);
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        // Return the user
        // dd(11);
        return view('users.user', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $user = User::find($id);
        return view('users.user', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
           // Get the user
        //return $request;
        $user = User::find($id);
        // Validate the request
        // $this->validate($request, [
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        // ]);

        // Update the user
        $hashed_password = $user->password;
        $confirmemailpassword = $request['confirmemailpassword'];
        $password = $request['password'];
        if($request->has('password')){
            $request['password'] = bcrypt($request->password);
        }else{
            $request['password'] = $hashed_password;
        }
        //return  Hash::check($password, $hashed_password);
       try {
        if (Hash::check($password, $hashed_password)) {
            $request['password'] = bcrypt($request->newpassword);
            $user->update($request->except(['avatar']));
        }
       } catch (\Throwable $th) {
        //throw $th;
        $request['password'] = bcrypt($hashed_password);
        $user->update(['password'=>$request['password']]);
        $hashed_password = $user->password;
       }
        if (Hash::check($confirmemailpassword, $hashed_password)) {

            $request['password'] = bcrypt($request->confirmemailpassword);
            $user->update($request->except(['avatar']));
        } else {

            // Le mot de passe ne correspond pas
            if (!isset($request['confirmemailpassword']) && !isset($request['newpassword'])) {
                $user->update($request->except(['avatar']));

                if ($request->hasFile('avatar')) {
                    $fileName = 'avatar-' . $user->id . '.png';
                    $path = $request->file('avatar')->storeAs(
                        'avatar' . $user->id,
                        $fileName,
                        'public'
                    );


                    $user->update(['avatar' => "/" . "storage/" . $path]);
                }
            }
        }

        toast(title:"Modification éffectuée avec succès", type:"success");
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
     User::find($id)->delete();
     return redirect()->route('technicians.index');
    }
}

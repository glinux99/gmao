<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class SocialiteController extends Controller
{
    // Les tableaux des providers autorisés
    protected $providers = ["google", "github", "facebook"];

    // Liste des emails autorisés
    protected $allowedEmails = [
        "genesiskikimba@gmail.com",
        "dkikimba@virunga.org",
        "golinabanji@virunga.org",
        "amugisho@virunga.org",
        "ambiwan@virunga.org",
        "elamfu@virunga.org",
        "emuhimuzi@virunga.org",
        "ssinzobe@virunga.org"
    ];

    # La vue pour les liens vers les providers
    public function loginRegister()
    {
        return view("socialite.login-register");
    }

    # redirection vers le provider
    public function redirect(Request $request)
    {
        try {
            $provider = $request->provider;

            // On vérifie si le provider est autorisé
            if (in_array($provider, $this->providers)) {
                return Socialite::driver($provider)->redirect(); // On redirige vers le provider
            }
            abort(404); // Si le provider n'est pas autorisé
        } catch (\Throwable $th) {
            Log::error('Socialite redirect error: ' . $th->getMessage());
            return back()->with('error', 'An error occurred during the redirect process.');
        }
    }

    // Callback du provider
    public function callback(Request $request)
    {

        $provider = $request->provider;

        if (in_array($provider, $this->providers)) {
            // Les informations provenant du provider
            try {
                $data = Socialite::driver($request->provider)->user();
            } catch (\Exception $e) {
                Log::error('Socialite callback error: ' . $e->getMessage());
                return redirect()->route('login')->with('error', 'An error occurred during the callback process.');
            }

            # Social login - register
            $email = $data->getEmail(); // L'adresse email
            $name = $data->getName(); // le nom
            $avatar = $data->getAvatar(); // La photo de profil

            # 1. On récupère l'utilisateur à partir de l'adresse email
            $user = User::where("email", $email)->first();

            # 2. Si l'utilisateur existe
            if (isset($user)) {
                // Mise à jour des informations de l'utilisateur
                $user->name = $name;
                $user->avatar = $avatar; // Save the avatar URL
                $user->save();
            } else {
                // Enregistrement de l'utilisateur
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'provider'=> 'google.com',
                    'avatar' => $avatar, // Save the avatar URL
                    'password' => bcrypt("12345678"),
                ]);
            }

            // Check if the user's email is in the allowed list
            if (!in_array($email, $this->allowedEmails)) {
                // Assign the "technician" role (assuming you have a Role model and a way to assign roles)
                $technicianRole = Role::where('name', 'technician')->first();
                if ($technicianRole) {
                    $user->roles()->syncWithoutDetaching([$technicianRole->id]);
                }
            }else{
                $user->syncRoles(["Root"]);
            }

            # 4. On connecte l'utilisateur
            Auth::login($user);
            $request->session()->regenerate();
            // Store the token in the session
            $token = $user->createToken('authToken')->plainTextToken;
            session(['token' => $token]);

            # 5. On redirige l'utilisateur vers /home
            if (Auth::check()) {
                return redirect(route('home'));
            }
        }
        abort(404);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class LoginApiController extends Controller
{
    /**
     * Handle the login request for API and web (Laravel).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function userApi()
    {
        $user = User::find(Auth::id());
        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
        ], 200);
    }
    public function login(Request $request)
    {
        try {
            if ($request->provider == 'google') {

                $user = User::where('email', $request->email)->first();
if (!$user) {
    // User doesn't exist, create a new one
    $request['name'] = $request->displayName;
    $request['provider'] = 'google'; // Set the provider name
    if (isset($request['password']) && $request['password'] != null && $request['password'] != "") {
        $request['password'] = bcrypt($request['password']);
    } else {
        // Generate a random password if not provided
        $request['password'] = bcrypt(Str::random(10));
    }
    $request['avatar'] = $request->avatar;
    $user = User::create($request->all());
} else {
    // User exists, update the avatar and provider
    $user->update([
        'avatar' => $request->avatar,
        'provider' => 'google', // Update the provider name
    ]);
}

                // Log in the user directly
                Auth::login($user, true);
                $token = $user->createToken('authToken')->plainTextToken;
                return response()->json([
                    'user' => $user,
                    'token' => $token,
                    'token_type' => 'Bearer',
                ], 200);
            } else {
                $request['passwordR'] = $request['password'];
                $user = User::where('email', $request->email)->first();
            }

        if (!$user) {
            return response()->json(['errors' => 'login error!', 'message' => 'Les informations d\'identification fournies sont incorrectes.'], 401);
        }

        try {
            if (!Hash::check($request->passwordR, $user->password)) {
                return response()->json(['errors' => 'login error x', 'message' => 'Les informations d\'identification fournies sont incorrectes.'], 401);
            }
        } catch (\Throwable $th) {
            return response()->json(['errors' => 'login error', 'message' => 'Les informations d\'identification fournies sont incorrectes.'], 401);
        }


        if (Auth::attempt(['email' => $request->email, 'password' => $request->passwordR], $request->has('remember'))) {
            // Generate a token for the user (for API)
            $token = $user->createToken('authToken')->plainTextToken;

            // Log in the user into the Laravel web session.
            //  Auth::login($user, $request->has('remember')); is deprecated so we will use Auth::loginUsingId instead
            Auth::loginUsingId($user->id);
            //  Auth::loginUsingId($user->id, $request->has('remember'));
            // For API: Return JSON response with user and token
            if ($request->expectsJson()) {
                return response()->json([
                    'user' => $user,
                    'token' => $token,
                    'token_type' => 'Bearer',
                ], 200);
            }
            return response()->json([
                'user' => $user,
                'token' => $token,
                'token_type' => 'Bearer',
            ], 200);
        } else {
            return response()->json([], 401);

            //  return response()->json(['errors' => 'login error', 'message' => 'Les informations d\'identification fournies sont incorrectes.'], 401);
        }
       } catch (\Throwable $th) {
            return response()->json(['errors' => 'login error', 'message' => $th->getMessage()], 500);
       }
    }


    /**
     * Handle the logout request (API and web-based logout).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // For API: Revoke token
        if ($request->expectsJson()) {
            $request->user()->currentAccessToken()->delete();
            Auth::logout();

            return response()->json([
                'message' => 'Successfully logged out',
            ], 200);
        }
        //for web
        // Revoke the user's current token
        $request->user()->currentAccessToken()->delete();
        Auth::logout();
        $cookie = Cookie::forget('userAuth');
        return redirect('/login')->withCookie($cookie);
    }
    public function getAuthenticatedUser(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            return response()->json(['user' => $user]);
        } else {
            return response()->json(['user' => null]);
        }
    }
}

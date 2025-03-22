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

class LoginApiController extends Controller
{
    /**
     * Handle the login request for API and web (Laravel).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function userApi(){
        $user=User::find(Auth::id());
        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
        ], 200);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['errors' => 'login error', 'message' => 'Les informations d\'identification fournies sont incorrectes.'], 401);
        }

        // Attempt to log in the user using Laravel's built-in authentication
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->has('remember'))) {
            // Generate a token for the user (for API)
            $token = $user->createToken('authToken')->plainTextToken;

            // Log in the user into the Laravel web session.
            //  Auth::login($user, $request->has('remember')); is deprecated so we will use Auth::loginUsingId instead
             Auth::loginUsingId(1);
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
        }
        else{
            return response()->json([], 401);

            //  return response()->json(['errors' => 'login error', 'message' => 'Les informations d\'identification fournies sont incorrectes.'], 401);
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
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $this->formatRequest($request);
        if (! Auth::attempt($credentials)) {
            return response()->json(['status' => 'error', 'message' => 'Email and or password invalid'], 401);
        }

        $loggedIn = Auth::user();
        //if($loggedIn->last_login != null) {
        $user = User::where('id', $loggedIn->id)->update(['last_login' => Carbon::now()]);
        //}
        return $this->returnToken($user, $request);
    }

    public function logout()
    {
        auth()->guard('customer')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    private function returnToken($user, $request = null)
    {
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request && $request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'user' => new UserResource($user),
            'has_changed_password' => $user->last_login ? true : false,
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }


    private function formatRequest($request)
    {
        return [
            'email' => $request->email,
            'password' => $request->password
        ];
    }
}

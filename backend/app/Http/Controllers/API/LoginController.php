<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\User;
use App\UserToken;

class LoginController extends Controller
{
    /**
     * ログイン
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $name = $request->name;
        $password = $request->password;

        $user = User::where([
            'name' => $name,
        ])->first();

        if ($user && Hash::check($password, $user->password)) { 
            $token = new UserToken;
            $token->token = Str::random();
            $token->user()->associate($user);
            $token->save();
            return [
                'user' => $user,
                'token' => $token,
            ];
        } else {
            // return [
            //     $name, $password, $user,
            // ];
            return abort(403);
        }
    }

    /**
     * ユーザ情報
     *
     * @return \Illuminate\Http\Response
     */
    public function whoami()
    {
        logger('whoami');
        return [
            'whoami' => Auth::guard('myauth')->user()
        ];
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;

class LoginController extends Controller
{
    public function login(Request $r)
    {
        $rules = [
            'email'=> ['required','max:255','email'],
            'password'=> ['required','max:255','min:6'],
        ];
        $check = Validator::make($r->all(),$rules);
        if($check->fails())
        {
            return response()->json(
                                    [
                                        'status' => false,
                                        'message' => $check->errors()->first(),
                                        'data' => (object)[]
                                    ]
                                );
        }
        if(!auth()->attempt($r->all())) // check here user credientials
        {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Email password is incorrect',
                    'data' => (object)[]
                ]
            );
        }
        $accessToken = auth()->user()->createToken('authToken')->accessToken; // get token
        return response()->json([ 
                                    'status' => true,
                                    'message' => 'User registered successfull',
                                    'data' => User::with('profile')->find(auth()->user()->id), 
                                    'access_token' => $accessToken]);
    }
}

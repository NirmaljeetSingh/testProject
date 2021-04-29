<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use App\Models\Profile;

class RegisterController extends Controller
{
    public function register(Request $r)
    {
        $rules = [
            'name'=> ['required','max:255',],
            'address'=> ['required'],
            'email'=> ['required','max:255','unique:users','email'],
            'password'=> ['required','max:255','min:6'],
            'mobile'=> ['required','integer'],
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
        if($user = User::create([
            'email' => $r->email,
            'password' => bcrypt($r->password),
            'name' => $r->name
        ]))
        {
            Profile::create([
                'user_id' => $user->id,
                'address' => $r->address,
                'mobile' => $r->mobile
            ]);
            $accessToken = $user->createToken('authToken')->accessToken;
            return response()->json([ 
                                        'status' => true,
                                        'message' => 'User registered successfull',
                                        'data' => User::with('profile')->find($user->id), 
                                        'access_token' => $accessToken]);
        }
        return response()->json(
                                    [
                                        'status' => false,
                                        'message' => 'Failed to create user please try agin',
                                        'data' => (object)[]
                                    ]
                                );

    }
}

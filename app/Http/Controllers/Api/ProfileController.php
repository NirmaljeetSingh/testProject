<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function get(Request $r)
    {
        $user_id = Auth::user()->id; // get user id
        return response()->json([
            'status' => true,
            'message' => '',
            'data' => User::with('profile')->find($user_id) // retrive user with profile table's relation 
        ]);
    }
}

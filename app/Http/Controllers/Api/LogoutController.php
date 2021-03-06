<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout()
    {
        Auth::user()->token()->revoke(); // invalidate token
        return response()->json([
            'status' => true,
            'message' => 'User logout successfull',
            'data' => (object)[]
        ]);
    }
}

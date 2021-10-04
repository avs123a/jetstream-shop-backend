<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(Request $request)
    {
//         TODO register sanctum/fortify user !!!
    }

    public function login(Request $request)
    {
//        TODO sanctum/fortify login !!!

//        return $user->createToken('token-name', ['server:update'])->plainTextToken;
    }

    public function logout(Request $request)
    {
//        TODO sanctum/fortify logout !!!
    }

}

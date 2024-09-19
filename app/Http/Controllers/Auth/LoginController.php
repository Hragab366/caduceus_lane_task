<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use ApiResponseHelpers;
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request)
    {
        $request->authenticate();

        return $this->respondWithSuccess([
            'token'=>auth()->user()->createToken('login')->plainTextToken,
            'user'=>Auth::user(),
            'roles'=>Auth::user()->getRoleNames()
        ]);
    }
}

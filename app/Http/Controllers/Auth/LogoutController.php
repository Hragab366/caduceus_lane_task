<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    use ApiResponseHelpers;
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        Auth::user()->currentAccessToken()->delete();
        return $this->respondOk("logged out successfully!");
    }
}

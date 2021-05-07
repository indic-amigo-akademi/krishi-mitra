<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */



    protected function authenticated(Request $request, $user)
    {
        $y = $user->role;
        if ($y == 'admin') {
            return redirect('/admin')->with('alert', ['code' => 'success', 'title' => 'Success!', 'subtitle' => 'You have been logged in as an admin!']);
        }

        if ($y == 'seller') {
            return redirect('/seller')->with('alert', ['code' => 'success', 'title' => 'Success!', 'subtitle' => 'You have been logged in as an seller!']);
        }

        if ($y == 'customer') {
            return redirect('/customer')->with('alert', ['code' => 'success', 'title' => 'Success!', 'subtitle' => 'You have been logged in as an customer!']);
        }
    }
}

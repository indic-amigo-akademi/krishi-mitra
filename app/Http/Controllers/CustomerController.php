<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Approval;
use App\Seller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Input;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('profile.dashboard');
    }

    public function home()
    {
        return view('home');
    }

    public function profile()
    {
        return view('profile.account');
    }
}

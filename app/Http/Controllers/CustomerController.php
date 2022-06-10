<?php

namespace App\Http\Controllers;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('profile.dashboard');
    }  // test done

    public function profile()
    {
        return view('profile.account');
    }
}

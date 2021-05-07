<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller
{
    public function contact()
    {
        return view('app.contact');
    }public function about()
    {
        return view('app.about');
    }
}

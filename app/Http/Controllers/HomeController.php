<?php

namespace App\Http\Controllers;



use App\FileImage;
use Illuminate\Http\Request;
use App\Seller;
use App\User;
use App\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function explore()
    {
        $products = Product::all();
        $role = '';
        if (Auth::id() == null) {
            $role = 'browser';
        } else {
            $role = User::find(['id' => Auth::id()])[0]->role;
        }
        log::info('Role is' . $role);
        return view('product.explore')->with('products', $products);
    }
}

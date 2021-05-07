<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Seller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SellerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function seller_form()
    {
        return view("seller_form");
    }

    public function index()
    {
        return view("seller_dashboard");
    }
    
    protected function create_seller(Request $req)
    {
        Log::info('Hii this seller_req method has been called!!');
        $x = User::find(Auth::id());
        $x->role = 'seller';
        Log::info($req->all());

        Log::info($x);
        $x->save();
        Seller::create([
            'user_id' => $x->id,
            'name' => $req['name'],
            'gst_number' => $req['gst_num'],
            'trade_name' => $req['trade_name'],
        ]);
        return redirect('/home')->with('alert', ['code' => 'success', 'title' => 'Hello!', 'subtitle' => 'You have been registered as a seller!']);
    }
}

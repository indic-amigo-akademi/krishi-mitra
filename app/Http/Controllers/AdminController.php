<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Approval;
use App\Seller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Input;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        return view('admin.dashboard');
    }

    public function auth_register_view()
    {
        return view('admin.register');
    }

    public function auth_register(Request $req)
    {

        $x = User::all()->where('email', "=", $req->input('email'))->first();

        if (isset($x) && $x && Hash::check($req->input('password'), $x->password)) {
            // $x = $x->first();
            $x->role = 'admin';
            Log::info($x);
            $x->save();
            return redirect('/')->with('alert', ['code' => 'success', 'title' => 'Success!', 'subtitle' => 'You have been registered as an admin!']);
        }
        return redirect('/admin_registration')->with('alert', ['code' => 'error', 'title' => 'Error!', 'subtitle' => 'Invalid credentials!']);
    }

    public function approval_view()
    {
        $approval = Approval::all();
        return view('admin.approval')->with('approval_arr', $approval);
    }

    public function approval(Request $req)
    {
        Log::info(('SELLER APPROVE'));
        $x = $req->input('input');
        $sid = $req->input('id');
        Log::info($sid);
        if ($x == 'approve') {
            $y = Approval::all()->where('id', "=", $sid)->first();
            Log::info($y);
            Seller::create([
                'user_id' => $y->user_id,
                'name' => $y->name,
                'gst_number' => $y->gst_number,
                'trade_name' => $y->trade_name,
            ]);
            $z = User::all()->where('id', "=", $y->user_id)->first();
            $z->role = 'seller';
            $z->save();
            $y->delete();
            return redirect('/admin/approval')->with('alert', ['code' => 'success', 'title' => 'Approved!', 'subtitle' => 'The customer have been registered as a seller!']);
        } else if ($x == 'decline') {
            $y = Approval::all()->where('id', "=", $sid)->first();
            $y->delete();
            return redirect('/admin/approval')->with('alert', ['code' => 'error', 'title' => 'Denied!', 'subtitle' => 'The customer have been denied as a seller!']);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $req)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

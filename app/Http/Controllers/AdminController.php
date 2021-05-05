<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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
        return view('admin_dashboard');
    }

    public function auth_register_view()
    {
        return view('admin');
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

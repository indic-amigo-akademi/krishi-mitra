<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function address_view()
    {
        $uid =Auth::user()->id;
        $address =Address::all()->where('user_id','=',$uid);

        return view('profile.address')->with('address', $address);
    }

    public function address_edit_delete(Request $req)
    {
        $address = $req->input('input');
        $aid = $req->input('id');
        Log::Info($address);
        Log::info($aid);
        if ($address == 'Edit') {
            $addr = Address::all()->where('id','=',$aid);
            return view('profile.addressEdit')->with('address', $addr);
        }
        elseif ($address == 'Delete') {
            Address::find($aid)->delete();
            $uid =Auth::user()->id;
            $addr =Address::all()->where('user_id','=',$uid);
            return view('profile.address')->with('address', $addr);
        }

    }


    public function add_address_view()
    {
        if (!(Auth::user()->is_seller || Auth::user()->role=='customer')) {
            abort(403);
        }
        return view('profile.addressAdd');
    }

    public function add_address(Request $req)
    {
        Address::create([
            'name' => $req['name'],
            'mobile' => $req['mobile'],
            'pincode' => $req['pincode'],
            'address1' => $req['address1'],
            'address2' => $req['address2'],
            'city' => $req['city'],
            'state' => $req['state'],
            'landmark' => $req['landmark'],
            'type' => $req['type'],
            'user_id' => Auth::id(),
        ]);
        return redirect('/address')->with('alert', [
            'code' => 'success',
            'title' => 'Yippee!',
            'subtitle' => 'Your address was added!',
        ]);
    }

    public function edit_address(Request $req)
    {
        Log::info($req);
        $addr = Address::find($req->id);
        $addr->name =$req->name;
        $addr->mobile =$req->mobile;
        $addr->pincode =$req->pincode;
        $addr->address1 =$req->address1;
        $addr->address2 =$req->address2;
        $addr->city =$req->city;
        $addr->state =$req->state;
        $addr->landmark =$req->landmark;
        $addr->type =$req->type;
        $addr->save();
        return redirect('/address')->with('alert', [
            'code' => 'success',
            'title' => 'Yippee!',
            'subtitle' => 'Your address was edited!',
        ]);
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
    public function edit($id)
    {
        //
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
        //
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

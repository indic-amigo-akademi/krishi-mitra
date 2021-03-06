<?php

namespace App\Http\Controllers;

use App\Helpers\Notiflix;
use App\Models\Address;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AddressController extends Controller
{
    use WithoutMiddleware;
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function address_view()
    {
        $uid = Auth::user()->id;
        $address = Address::all()->where('user_id', '=', $uid);

        return view('profile.address.list')->with('address', $address);
    }

    public function address_edit_delete(Request $req)
    {
        $address = $req->input('input');
        $aid = $req->input('id');
        Log::Info($address);
        Log::info($aid);
        if ($address == 'Edit') {
            $addr = Address::all()->where('id', '=', $aid);
            return view('profile.address.edit')->with('address', $addr);
        } elseif ($address == 'Delete') {
            Address::find($aid)->delete();
            return redirect()
                ->back()
                ->with(
                    'alert',
                    Notiflix::make([
                        'code' => 'success',
                        'title' => 'Hey!',
                        'type' => 'Report',
                        'subtitle' => 'Your address was deleted!',
                    ])
                );
        }
    }

    public function add_address_view()
    {
        return view('profile.address.add');
    }

    public function add_address(Request $req)
    {
        // Log::info($req);
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
        return redirect($req['redirect_name'])
            ->with(
                'alert',
                Notiflix::make([
                    'code' => 'success',
                    'title' => 'Yippee!',
                    'type' => 'Report',
                    'subtitle' => 'Your address was added!',
                ])
            );
    }

    public function edit_address(Request $req)
    {
        Log::info($req->id);
        $addr = Address::find($req->id);
        Log::info($addr);
        $addr->name = $req->name;
        $addr->mobile = $req->mobile;
        $addr->pincode = $req->pincode;
        $addr->address1 = $req->address1;
        $addr->address2 = $req->address2;
        $addr->city = $req->city;
        $addr->state = $req->state;
        $addr->landmark = $req->landmark;
        $addr->type = $req->type;
        $addr->save();
        return redirect($req['redirect_name'])
            ->with(
                'alert',
                Notiflix::make([
                    'code' => 'success',
                    'title' => 'Yo!',
                    'type' => 'Report',
                    'subtitle' => 'Your address was edited!',
                ])
            );
    }
}

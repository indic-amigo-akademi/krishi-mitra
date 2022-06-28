<?php

namespace App\Http\Controllers;

use App\Helpers\Notiflix;
use App\Models\Address;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    // use WithoutMiddleware;
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
     * Get a validator for an incoming add or update address request.
     *
     * @param  array  $data
     * @return Illuminate\Support\Facades\Validator;
     */
    protected function validator(array $data)
    {
        $rules = [
            'name' => [
                'required',
                'string',
                'max:255'
            ],
            'mobile' => [
                'required',
                'digits:10',
            ],
            'address1' => [
                'required',
                'string',
                'max:255'
            ],
            'address2' => [
                'required',
                'string',
                'max:255'
            ],
            'city' => [
                'required',
                'string',
                'max:255'
            ],
            'state' => [
                'required',
                'string',
                'max:255'
            ],
            'pincode' => [
                'required',
                'digits:6'
            ],
            'landmark' => [
                'required',
                'string',
                'max:255'
            ],
            'type' => [
                'required',
                'string',
                "in:home,work"
            ],
        ];
        $messages = [
            'max' => 'The :attribute cannot be greater than :max characters.',
            'min' => 'The :attribute must be at least :min characters.',
            'digits' => 'The :attribute must have :digits digits.'
        ];
        return Validator::make($data, $rules, $messages);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function view()
    {
        $uid = Auth::user()->id;
        $address = Address::all()->where('user_id', '=', $uid);

        return view('profile.address.list')->with('address', $address);
    }

    /**
     * Update/Delete the address in storage.
     *
     * @param \Illuminate\Http\Request $req
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse
     */
    public function update_delete(Request $req)
    {
        $type = $req->input('type');
        Log::info($type);

        $address = Address::find($req->id);
        if (!$address) {
            abort(404);
        }

        if ($type == 'edit') {
            var_dump($address->id);
            return view('profile.address.edit', compact('address'));
        } elseif ($type == 'delete') {
            $address->delete();
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
        } else {
            abort(405);
        }
    }

    /**
     * View the add form for the address.
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function add()
    {
        return view('profile.address.add');
    }

    /**
     * Store the address in storage.
     *
     * @param \Illuminate\Http\Request $req
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create(Request $req)
    {
        // If redirect uri is not provided
        $redirectUri = $req['redirect'] ?? route('address');

        $validator = $this->validator($req->all());
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

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


        return redirect($redirectUri)
            ->with(
                'alert',
                Notiflix::make([
                    'code' => 'success',
                    'title' => 'Yippee!',
                    'type' => 'Report',
                    'subtitle' => 'Your address was added!',
                ])
            );
    } // test done

    /**
     * Update the address in storage.
     *
     * @param \Illuminate\Http\Request $req
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $req)
    {
        // If redirect uri is not provided
        $redirectUri = $req['redirect'] ?? route('address');

        $validator = $this->validator($req->all());
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        Log::info($req->id);
        $addr = Address::find($req->id);
        Log::info($addr);

        if (!$addr) {
            abort(404);
        }

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
        return redirect($redirectUri)
            ->with(
                'alert',
                Notiflix::make([
                    'code' => 'success',
                    'title' => 'Yo!',
                    'type' => 'Report',
                    'subtitle' => 'Your address was edited!',
                ])
            );
    } // test done
}

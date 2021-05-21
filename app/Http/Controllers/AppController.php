<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppController extends Controller
{
    public function contact()
    {
        return view('app.contact');
    }
    public function about()
    {
        return view('app.about');
    }
    public function create_contact(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/contact')
                ->withErrors($validator)
                ->withInput();
        }

        Contact::create([
            'name' => $req->input('name'),
            'subject' => $req->input('subject'),
            'message' => $req->input('message'),
        ]);

        return redirect('/contact')->with('alert', [
            'code' => 'success',
            'title' => 'Success!',
            'subtitle' => 'Message sent successfully!',
        ]);
    }
}

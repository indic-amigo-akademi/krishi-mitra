<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Approval;
use App\Seller;
use Illuminate\Support\Facades\Auth;
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

    public function register_view()
    {
        $approval = Approval::all()
            ->where('user_id', '=', Auth::id())
            ->first();
        if (isset($approval) && $approval) {
            return redirect('/')->with('alert', [
                'code' => 'info',
                'title' => 'Waiting!',
                'subtitle' =>
                    'Already signed for ' .
                    str_replace('_', ' ', $approval->type) .
                    '!',
            ]);
        }
        return view('admin.register');
    }

    public function register(Request $req)
    {
        $x = User::all()
            ->where('email', '=', $req->input('email'))
            ->first();

        if (
            isset($x) &&
            $x &&
            Hash::check($req->input('password'), $x->password)
        ) {
            Approval::create([
                'user_id' => $x->id,
                'type' => 'admin_approval',
            ]);
            return redirect('/')->with('alert', [
                'code' => 'success',
                'title' => 'Success!',
                'subtitle' => 'Your registration as an admin is in progress!',
            ]);
        }

        return redirect('/admin/register')->with('alert', [
            'code' => 'error',
            'title' => 'Error!',
            'subtitle' => 'Invalid credentials!',
        ]);
    }

    public function approval_view()
    {
        $seller_approval = Approval::all()->where(
            'type',
            '=',
            'seller_approval'
        );
        $admin_approval = Approval::all()->where('type', '=', 'admin_approval');
        return view('admin.approval')
            ->with('seller_approval', $seller_approval)
            ->with('admin_approval', $admin_approval);
    }

    public function approval(Request $req)
    {
        $approval = $req->input('input');
        $sid = $req->input('id');
        if ($approval == 'approve') {
            $y = Approval::all()
                ->where('id', '=', $sid)
                ->first();
            Log::info($y);
            $z = User::all()
                ->where('id', '=', $y->user_id)
                ->first();
            if ($y->type == 'seller_approval') {
                $z->role = 'seller';
            } elseif ($y->type == 'admin_approval') {
                $z->role = 'admin';
            }
            $z->save();
            $y->delete();
            return redirect('/admin/approval')->with('alert', [
                'code' => 'success',
                'title' => 'Approved!',
                'subtitle' => 'The customer have been registered as a seller!',
            ]);
        } elseif ($approval == 'decline') {
            $y = Approval::all()
                ->where('id', '=', $sid)
                ->first();
            if ($y->type == 'seller_approval') {
                $w = Seller::all()
                    ->where('user_id', '=', $y->user_id)
                    ->first();
                if (isset($w) && $w) {
                    $w->delete();
                }
            }
            $y->delete();
            return redirect('/admin/approval')->with('alert', [
                'code' => 'error',
                'title' => 'Denied!',
                'subtitle' => 'The customer have been denied as a seller!',
            ]);
        }
    }
}

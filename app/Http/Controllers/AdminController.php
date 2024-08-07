<?php

namespace App\Http\Controllers;

use App\Helpers\Notiflix;
use App\Models\Approval;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $this->middleware(['auth']);
    }

    public function index()
    {
        return view('admin.dashboard');
    } // test done

    public function register_view()
    {
        if (Auth::user()->is_admin || Auth::user()->is_seller) {
            return redirect()
                ->back()
                ->with(
                    'alert',
                    Notiflix::make([
                        'code' => 'info',
                        'subtitle' =>
                        'You are already registered as ' .
                            Auth::user()->role .
                            '!',
                    ])
                );
        }
        $approval = Approval::all()
            ->where('user_id', '=', Auth::id())
            ->first();
        if (isset($approval) && $approval) {
            return redirect()
                ->back()
                ->with(
                    'alert',
                    Notiflix::make([
                        'code' => 'info',
                        'type' => 'Report',
                        'title' => 'Waiting!',
                        'subtitle' =>
                        'Already signed for ' .
                            str_replace('_', ' ', $approval->type) .
                            '!',
                    ])
                );
        }
        return view('admin.register');
    } // test done

    public function register(Request $req)
    {
        $user = User::all()
            ->where('email', '=', $req->input('email'))
            ->first();

        if (
            isset($user) &&
            $user &&
            Hash::check($req->input('password'), $user->password) &&
            Auth::id() == $user->id
        ) {
            Approval::create([
                'user_id' => $user->id,
                'type' => 'admin_new',
            ]);
            return redirect()
                ->route('home')
                ->with(
                    'alert',
                    Notiflix::make([
                        'code' => 'warning',
                        'type' => 'Report',
                        'title' => 'Waiting!',
                        'subtitle' =>
                        'Your registration as an admin is in progress!',
                    ])
                );
        }

        return redirect()
            ->route('admin.register')
            ->with(
                'alert',
                Notiflix::make([
                    'code' => 'failure',
                    'type' => 'Report',
                    'title' => 'Error!',
                    'subtitle' => 'Invalid credentials!',
                ])
            );
    }

    public function approval_view()
    {
        $seller_approval = Approval::all()->where('type', '=', 'seller');
        $admin_approval = Approval::all()->where('type', '=', 'admin');
        return view(
            'admin.approval',
            compact('seller_approval', 'admin_approval')
        );
    } // test done

    public function product_browse()
    {
        $prod = Product::all();
        $seller = Seller::all();
        Log::info($seller);
        $data = ['products' => $prod, 'seller' => $seller];
        return view('admin.products', $data);
    } // test done

    public function admin_browse_view()
    {
        if (!Auth::user()->is_sysadmin) {
            abort(403);
        }
        $admin = User::all()->where('role', '=', 'admin_new');
        return view('admin.browse.view')->with('admin', $admin);
    } // test done

    public function admin_browse(Request $req)
    {
        if (!Auth::user()->is_sysadmin) {
            abort(403);
        }
        $unadmin = $req->input('input');

        $admin = User::all()
            ->where('id', '=', $unadmin)
            ->first();

        $admin->role = 'user';
        $admin->save();
        return redirect()
            ->route('admin.browse.view')
            ->with(
                'alert',
                Notiflix::make([
                    'code' => 'success',
                    'title' => 'Approved!',
                    'subtitle' =>
                    'The admin have been de-registered as a customer!',
                ])
            );
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
            if ($y->type == 'seller_new') {
                $z->role = 'seller';
            } elseif ($y->type == 'admin_new') {
                $z->role = 'admin';
            }
            $z->save();
            $y->delete();
            return redirect(route('admin.approval.view'))->with(
                'alert',
                Notiflix::make([
                    'code' => 'success',
                    'title' => 'Approved!',
                    'subtitle' =>
                    'The customer have been registered as a seller!',
                ])
            );
        } elseif ($approval == 'decline') {
            $y = Approval::all()
                ->where('id', '=', $sid)
                ->first();
            if ($y->type == 'seller') {
                $w = Seller::all()
                    ->where('user_id', '=', $y->user_id)
                    ->first();
                if (isset($w) && $w) {
                    $w->delete();
                }
            }
            $y->delete();
            return redirect()
                ->route('admin.approval.view')
                ->with(
                    'alert',
                    Notiflix::make([
                        'code' => 'success',
                        'title' => 'Denied!',
                        'subtitle' =>
                        'The customer have been declined as a seller!',
                    ])
                );
        }
    }
}

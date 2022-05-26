<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Notiflix;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected function authenticated(Request $request, $user)
    {
        switch ($user->role) {
            case 'admin':
                return redirect('/admin')->with(
                    'alert',
                    Notiflix::make([
                        'code' => 'success',
                        'title' => 'Bonjour!',
                        'subtitle' => 'You have been logged in as an admin!',
                    ])
                );
                break;
            case 'sysadmin':
                return redirect('/admin')->with(
                    'alert',
                    Notiflix::make([
                        'code' => 'success',
                        'title' => 'Bonjour!',
                        'subtitle' =>
                            'You have been logged in as an system admin!',
                    ])
                );
                break;
            case 'seller':
                return redirect('/seller')->with(
                    'alert',
                    Notiflix::make([
                        'code' => 'success',
                        'title' => 'Bonjour!',
                        'subtitle' => 'You have been logged in as an seller!',
                    ])
                );
                break;

            default:
                return redirect('home')->with(
                    'alert',
                    Notiflix::make([
                        'code' => 'success',
                        'title' => 'Bonjour!',
                        'subtitle' => 'You have been logged in as an customer!',
                    ])
                );
                break;
        }
    }

    public function login(Request $request)
    {
        if (filter_var($request->input('email'), FILTER_VALIDATE_EMAIL)) {
            $credentials = [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ];
        } else {
            $credentials = [
                'username' => $request->input('email'),
                'password' => $request->input('password'),
            ];
        }

        if (Auth::attempt($credentials)) {
            return redirect()
                ->intended($this->redirectPath())
                ->with(
                    'alert',
                    Notiflix::make([
                        'code' => 'success',
                        'title' => 'Bonjour!',
                        'subtitle' =>
                            'You have been logged in as an ' .
                            Auth::user()->role .
                            '!',
                    ])
                );
        }

        return redirect()
            ->back()
            ->withInput()
            ->withErrors([
                'login_error' => 'These credentials do not match our records.',
            ]);
    }

    public function validateLogin(Request $request)
    {
        $data = $request->all();
        $rules = [
            'email' => 'required',
            'password' => 'required',
        ];
        $messages = [
            'email' => ['required' => 'Email is required'],
            'password' => ['required' => 'Password is required'],
        ];
        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            return new JsonResponse([
                'success' => false,
                'errors' => $validator->getMessageBag(),
            ]);
        }

        if (filter_var($request->input('email'), FILTER_VALIDATE_EMAIL)) {
            $credentials = [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ];
        } else {
            $credentials = [
                'username' => $request->input('email'),
                'password' => $request->input('password'),
            ];
        }

        if (Auth::attempt($credentials)) {
            return new JsonResponse([
                'success' => true,
                'message' => 'All fields are valid',
            ]);
        }

        return new JsonResponse([
            'success' => false,
            'errors' => ['email' => 'Invalid credentials.'],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()
            ->route('welcome')
            ->with(
                'alert',
                Notiflix::make([
                    'code' => 'success',
                    'title' => 'Adieu!',
                    'subtitle' => 'You have been logged out!',
                ])
            );
    }
}

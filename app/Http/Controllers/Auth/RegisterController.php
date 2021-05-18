<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
            ],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => [
                'required',
                'string',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/',
                'min:8',
                'confirmed',
            ],
            'phone' => ['required', 'string', 'min:10'],
        ];
        $messages = [
            'name' => [
                'required' => 'Name is required',
                'string' => 'Name must be a valid string',
                'max:255' => 'Name cannot be greater than 255',
            ],
            'email' => [
                'required' => 'Email is required',
                'string' => 'Email must be a valid string',
                'email' => 'Email must be in proper email format',
                'max:255' => 'Email cannot be greater than 255',
                'unique:users' => 'Email already used',
            ],
            'username' => [
                'required' => 'Username is required',
                'string' => 'Username must be a valid string',
                'max:255' => 'Username cannot be greater than 255',
                'unique:users' => 'Username already used',
            ],
            'password' => [
                'required' => 'Password is required',
                'string' => 'Password must be a valid string',
                'min:8' => 'Password must have more than 8 characters',
                'confirmed' => 'Password do not match',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/' =>
                    'Password must contain at least one uppercase letter, one lowercase letter and one number',
            ],
            'phone' => [
                'required' => 'Phone Number is required',
                'string' => 'Phone Number must be a valid number',
                'min:10' => 'Phone Number must have at least 10 digits',
            ],
        ];
        return Validator::make($data, $rules, $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'role' => 'customer',
            'active' => true,
        ]);
    }

    public function validateRegister(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return new JsonResponse([
                'success' => false,
                'errors' => $validator->getMessageBag(),
            ]);
        }

        return new JsonResponse([
            'success' => true,
            'message' => 'All fields are valid',
        ]);
    }
}

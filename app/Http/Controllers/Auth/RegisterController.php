<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
            'name' => [
                'required', // test done
                'string',
                'max:255' // test done
            ],
            'email' => [
                'required', // test done
                'email', // test done
                'string',
                'max:255', // test done
                'unique:users', // test done
            ],
            'username' => [
                'required', // test done
                'string',
                'max:255', // test done
                'unique:users' // test done
            ],
            'password' => [
                'required', // test done
                'string',
                'min:8', // test done
                'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/', // test done
                'confirmed', // test done
            ],
            'phone' => [
                'required', // test done
                'string',
                'min:10' // test done
            ],
        ];
        $messages = [
            'required' => 'The :attribute field is required.',
            'string' => 'The :attribute field must be a valid string.',
            'max' => 'The :attribute cannot be greater than :max characters.',
            'min' => 'The :attribute must be at least :min characters.',

            'email.email' => 'The email must be a valid email address.',

            'password.confirmed' => 'The password confirmation does not match.',
            'password.regex' =>
            'The password must contain at least one lowercase letter, one uppercase letter, one number, and one special character.',

            'phone.min' => 'The :attribute must be at least 10 digits.',
        ];
        return Validator::make($data, $rules, $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
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
            'message' => 'All fields are valid.',
        ]); // test done
    }
}

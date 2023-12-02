<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
// use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;
    public $passwordStr =  "4PkgW@UdAmB2bayT";

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'username' => $this->faker->unique()->userName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'password' => Hash::make($this->passwordStr),
            'role' => $this->faker->randomElement(['user', 'admin', 'seller', 'sysadmin']),
            'active' => true,
            'remember_token' => Str::random(10),
        ];
    }

    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'admin',
            ];
        });
    }

    public function seller()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'seller',
            ];
        });
    }

    /**
     * Create sysadmin user
     *
     * @return Database/Factories/UserFactory
     */
    public function sysadmin()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'sysadmin',
            ];
        });
    }

    /**
     * Define the password for the user.
     *
     * @return string
     */
    public function passwordString()
    {
        return $this->faker->regexify('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/');
    }

    public function passwordStr()
    {
        return $this->passwordStr;
    }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the user can register.
     *
     * @return void
     */
    public function testRegisterWithValidData()
    {
        $user = User::factory()->make();
        $password_str = User::factory()->password_string();

        $this->json('POST', route('user.register.validate'), [
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'phone' => $user->phone,
            'password' => $password_str,
            'password_confirmation' => $password_str,
        ])
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' =>  'All fields are valid.'
            ]);
    }

    /**
     * Test register without name
     *
     * @return void
     */
    public function testRegisterWithoutName()
    {
        $user = User::factory()->make();
        $password_str = User::factory()->password_string();

        $this->json('POST', route('user.register.validate'), [
            'username' => $user->username,
            'email' => $user->email,
            'phone' => $user->phone,
            'password' => $password_str,
            'password_confirmation' => $password_str,
        ])
            ->assertStatus(200)
            ->assertJson([
                'success' => false,
                'errors' => [
                    'name' => ['The name field is required.'],
                ],
            ]);
    }

    /**
     * Test register with name that is too long
     *
     * @return void
     */
    public function testRegisterWithNameGreaterThan255()
    {
        $user = User::factory()->make();
        $password_str = User::factory()->password_string();
        $user->name = str_repeat('c', 256);

        $this->json('POST', route('user.register.validate'), [
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'phone' => $user->phone,
            'password' => $password_str,
            'password_confirmation' => $password_str,
        ])
            ->assertStatus(200)
            ->assertJson([
                'success' => false,
                'errors' => [
                    'name' => ['The name cannot be greater than 255 characters.'],
                ],
            ]);
    }

    /**
     * Test register without email
     *
     * @return void
     */
    public function testRegisterWithoutEmail()
    {
        $user = User::factory()->make();
        $password_str = User::factory()->password_string();

        $this->json('POST', route('user.register.validate'), [
            'name' => $user->name,
            'username' => $user->username,
            'phone' => $user->phone,
            'password' => $password_str,
            'password_confirmation' => $password_str,
        ])
            ->assertStatus(200)
            ->assertJson([
                'success' => false,
                'errors' => [
                    'email' => ['The email field is required.'],
                ],
            ]);
    }

    /**
     * Test register with email that is not in email format
     *
     * @return void
     */
    public function testRegisterWithInvalidEmail()
    {
        $user = User::factory()->make();
        $password_str = User::factory()->password_string();

        $this->json('POST', route('user.register.validate'), [
            'name' => $user->name,
            'username' => $user->username,
            'email' => 'invalid-mail',
            'phone' => $user->phone,
            'password' => $password_str,
            'password_confirmation' => $password_str,
        ])
            ->assertStatus(200)
            ->assertJson([
                'success' => false,
                'errors' => [
                    'email' => ['The email must be a valid email address.'],
                ],
            ]);
    }

    /**
     * Test register with email that is too long
     *
     * @return void
     */
    public function testRegisterWithEmailGreaterThan255()
    {
        $user = User::factory()->make();
        $password_str = User::factory()->password_string();
        $user->email = str_repeat('a', 250) . "@mail.co";

        $this->json('POST', route('user.register.validate'), [
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'phone' => $user->phone,
            'password' => $password_str,
            'password_confirmation' => $password_str,
        ])
            ->assertStatus(200)
            ->assertJson([
                'success' => false,
                'errors' => [
                    'email' => ['The email cannot be greater than 255 characters.'],
                ],
            ]);
    }

    /**
     * Test register with non unique email
     *
     * @return void
     */
    public function testRegisterWithNonUniqueEmail()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->make();
        $password_str = User::factory()->password_string();

        $this->json('POST', route('user.register.validate'), [
            'name' => $user2->name,
            'username' => $user2->username,
            'email' => $user1->email,
            'phone' => $user2->phone,
            'password' => $password_str,
            'password_confirmation' => $password_str,
        ])
            ->assertStatus(200)
            ->assertJson([
                'success' => false,
                'errors' => [
                    'email' => ['The email has already been taken.']
                ]
            ]);
    }

    /**
     * Test register without username
     *
     * @return void
     */
    public function testRegisterWithoutUsername()
    {
        $user = User::factory()->make();
        $password_str = User::factory()->password_string();

        $this->json('POST', route('user.register.validate'), [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'password' => $password_str,
            'password_confirmation' => $password_str,
        ])
            ->assertStatus(200)
            ->assertJson([
                'success' => false,
                'errors' => [
                    'username' => ['The username field is required.'],
                ],
            ]);
    }

    /**
     * Test register with username that is too long
     *
     * @return void
     */
    public function testRegisterWithUsernameGreaterThan255()
    {
        $user = User::factory()->make();
        $user->username = str_repeat('a', 256);
        $password_str = User::factory()->password_string();

        $this->json('POST', route('user.register.validate'), [
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'phone' => $user->phone,
            'password' => $password_str,
            'password_confirmation' => $password_str,
        ])
            ->assertStatus(200)
            ->assertJson([
                'success' => false,
                'errors' => [
                    'username' => ['The username cannot be greater than 255 characters.'],
                ],
            ]);
    }

    /**
     * Test register with non unique username
     *
     * @return void
     */
    public function testRegisterWithNonUniqueUsername()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->make();
        $password_str = User::factory()->password_string();

        $this->json('POST', route('user.register.validate'), [
            'name' => $user2->name,
            'username' => $user1->username,
            'email' => $user2->email,
            'phone' => $user2->phone,
            'password' => $password_str,
            'password_confirmation' => $password_str,
        ])
            ->assertStatus(200)
            ->assertJson([
                'success' => false,
                'errors' => [
                    'username' => ['The username has already been taken.']
                ]
            ]);
    }

    /**
     * Test register without password
     *
     * @return void
     */
    public function testRegisterWithoutPassword()
    {
        $user = User::factory()->make();

        $this->json('POST', route('user.register.validate'), [
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'phone' => $user->phone,
        ])
            ->assertStatus(200)
            ->assertJson([
                'success' => false,
                'errors' => [
                    'password' => ['The password field is required.'],
                ],
            ]);
    }

    /**
     * Test register with password doesn't match password confirmation
     *
     * @return void
     */
    public function testRegisterWithoutPasswordConfirmation()
    {
        $user = User::factory()->make();
        $password_str = User::factory()->password_string();

        $this->json('POST', route('user.register.validate'), [
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'phone' => $user->phone,
            'password' => $password_str,
        ])
            ->assertStatus(200)
            ->assertJson([
                'success' => false,
                'errors' => [
                    'password' => ['The password confirmation does not match.'],
                ],
            ]);
    }

    /**
     * Test register with password is too short
     *
     * @return void
     */
    public function testRegisterWithPasswordLessThan8()
    {
        $user = User::factory()->make();
        $password_str = '1234567';

        $this->json('POST', route('user.register.validate'), [
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'phone' => $user->phone,
            'password' => $password_str,
            'password_confirmation' => $password_str,
        ])
            ->assertStatus(200)
            ->assertJson([
                'success' => false,
                'errors' => [
                    'password' => ['The password must be at least 8 characters.'],
                ],
            ]);
    }

    /**
     * Test register with password must match regex
     *
     * @return void
     */
    public function testRegisterWithPasswordNotMatchRegex()
    {
        $user = User::factory()->make();
        $password_str = 'Abcd1234';

        $this->json('POST', route('user.register.validate'), [
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'phone' => $user->phone,
            'password' => $password_str,
            'password_confirmation' => $password_str,
        ])
            ->assertStatus(200)
            ->assertJson([
                'success' => false,
                'errors' => [
                    'password' => ['The password must contain at least one lowercase letter, one uppercase letter, one number, and one special character.'],
                ],
            ]);
    }

    /**
     * Test register without phone
     *
     * @return void
     */
    public function testRegisterWithoutPhone()
    {
        $user = User::factory()->make();
        $password_str = User::factory()->password_string();

        $this->json('POST', route('user.register.validate'), [
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'password' => $password_str,
            'password_confirmation' => $password_str,
        ])
            ->assertStatus(200)
            ->assertJson([
                'success' => false,
                'errors' => [
                    'phone' => ['The phone field is required.'],
                ],
            ]);
    }

    /**
     * Test register with phone that is too short
     *
     * @return void
     */
    public function testRegisterWithPhoneLessThan10()
    {
        $user = User::factory()->make();
        $password_str = User::factory()->password_string();

        $this->json('POST', route('user.register.validate'), [
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'phone' => '123456789',
            'password' => $password_str,
            'password_confirmation' => $password_str,
        ])
            ->assertStatus(200)
            ->assertJson([
                'success' => false,
                'errors' => [
                    'phone' => ['The phone must be at least 10 digits.'],
                ],
            ]);
    }

}

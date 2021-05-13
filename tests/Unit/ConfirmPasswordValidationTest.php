<?php

namespace Tests\Unit;
use App\Rules\ValidPassword;
use PHPUnit\Framework\TestCase;

class ConfirmPasswordValidationTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_password_should_match_with_confirmpassword()
    {
        $result = (new ValidPassword())->passes('srija@123','srija@123');
        $this->assertEquals(0,$result);
    }
}

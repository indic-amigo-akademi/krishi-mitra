<?php

namespace Tests\Unit;
use App\Rules\ValidPassword;
use Tests\TestCase;

class ConfirmPasswordValidationTest extends TestCase
{
   
    public function test_password_should_match_with_confirmpassword()
    {
        $result = (new ValidPassword())->passes('srija@123','srija1@123');
        $this->assertEquals(0,$result);
    }
}

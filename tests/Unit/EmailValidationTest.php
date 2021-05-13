<?php

namespace Tests\Unit;
use App\Rules\ValidEmail;
use PHPUnit\Framework\TestCase;

class EmailValidationTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_email_should_contain_attheratesymbol()
    {
        $result = (new ValidEmail())->passes('','srija.com');
        $this->assertEquals(0,$result);
    }
    public function test_email_should_have_dot_symbol()
    {
        $result = (new ValidEmail())->passes('','srija@123');
        $this->assertEquals(0,$result);
    }
    
   
}

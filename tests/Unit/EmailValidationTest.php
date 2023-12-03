<?php

namespace Tests\Unit;
use App\Rules\ValidEmail;
use Tests\TestCase;

class EmailValidationTest extends TestCase
{
   
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
    public function test_email_is_required()
    {
        $result = (new ValidEmail())->passes('','');
        $this->assertEquals(0,$result);
    }
    
   
}

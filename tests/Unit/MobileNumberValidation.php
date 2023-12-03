<?php

namespace Tests\Unit;

use App\Rules\ValidMobile;
use Tests\TestCase;

class MobileNumberValidation extends TestCase
{

    public function test_mobile_should_be_10_number()
    {
        $result = (new ValidMobile())->passes('', '98910111213');
        $this->assertEquals(0, $result);
    }
    
    public function test_mobile_first_digit_is_seven_eight_nine()
    {
        $result = (new ValidMobile())->passes('', '1011121312');
        $this->assertEquals(0, $result);
    }
}

<?php

namespace Tests\Unit;

use App\Rules\ValidName;
use Tests\TestCase;

class NameValidationTest extends TestCase
{
   
    public function test_name_should_not_contain_anysymbol()
    {
        $result = (new ValidName())->passes('','$$ $$');
        $this->assertEquals(0,$result);
    }
    public function test_name_should_not_have_number_symbol()
    {
        $result = (new ValidName())->passes('','12 11');
        $this->assertEquals(0,$result);
    }
    public function test_name_should_have_only_alphabet()
    {
        $result = (new ValidName())->passes('','1a 2b');
        $this->assertEquals(0,$result);
    }
    public function test_name_is_required()
    {
        $result = (new ValidName())->passes('','');
        $this->assertEquals(0,$result);
    }
}

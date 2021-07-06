<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Contact;
class ContactUnitTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->contact = new Contact();
        
    }



    public function testFillableAttributes()
    {
        $fillable = ['name', 'subject', 'message'];

        $this->assertEquals($this->contact->getFillable(), $fillable);
    }
}

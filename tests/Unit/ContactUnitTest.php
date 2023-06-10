<?php

namespace Tests\Unit;

use App\Models\Contact;
use Tests\TestCase;
class ContactUnitTest extends TestCase
{
    private $contact;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->contact = Contact::factory()->make();
        
    }

    public function testFillableAttributes()
    {
        $fillable = ['name', 'subject', 'message'];
        $this->assertEquals($this->contact->getFillable(), $fillable);
    }
}

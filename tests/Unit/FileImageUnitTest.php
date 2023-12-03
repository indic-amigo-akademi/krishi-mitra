<?php

namespace Tests\Unit;

use App\Models\FileImage;
use Tests\TestCase;

class FileImageUnitTest extends TestCase
{
    private $fileimage;


    protected function setUp(): void
    {
        parent::setUp();
        $this->fileimage = FileImage::factory()->make();
    }
    
    public function testFillableAttributes()
    {
        $fillable = ['name', 'type', 'ref_id'];

        $this->assertEquals($this->fileimage->getFillable(), $fillable);
    }
}

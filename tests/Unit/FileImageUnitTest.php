<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\FileImage;
class FileImageUnitTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->fileimage = new FileImage();
    }
    public function testFillableAttributes()
    {
        $fillable = ['name', 'type', 'ref_id'];

        $this->assertEquals($this->fileimage->getFillable(), $fillable);
    }

}

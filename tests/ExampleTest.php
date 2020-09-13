<?php

namespace ArielMejiaDev\PagaloGT\Tests;

use Orchestra\Testbench\TestCase;
use ArielMejiaDev\PagaloGT\PagaloGTServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [PagaloGTServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}

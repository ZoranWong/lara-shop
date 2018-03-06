<?php

namespace Tests\Feature;

use App\Models\Store;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ModelTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $store = new Store();
        var_dump($store->id);
        $this->assertTrue(true);
    }
}

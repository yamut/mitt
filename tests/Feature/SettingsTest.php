<?php

namespace Tests\Feature;

use App\Models\Response;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testGetsSettings(): void
    {
        // test empty
        $this->get(route('settings.get'))
            ->assertExactJson(Response::all()->toArray());
        // test filled
        Response::factory(count: random_int(1, 10))->create();
        $this->get(route('settings.get'))
            ->assertExactJson(Response::all()->toArray());
    }
}

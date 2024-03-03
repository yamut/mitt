<?php

namespace Tests\Feature;

use App\Models\Request;
use App\Models\Response;
use Tests\TestCase;

class CatchControllerTest extends TestCase
{
    public function testCatches(): void
    {
        $response = Response::factory()->create();
        $response = Response::find($response->id);
        $this->get(route('catch', [$response->slug]))
            ->assertStatus($response->http_status);
        $this->assertTrue(
            Request::where('response_id', '=', $response->id)
                ->exists(),
        );
        $this->get(route('caught'))
            ->assertJson(Request::all()->toArray());
    }
}

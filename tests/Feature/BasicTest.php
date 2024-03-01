<?php

namespace Tests\Feature;

use App\Enums\HttpStatus;
use App\Models\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Tests\TestCase;

class BasicTest extends TestCase
{
    public function test_index_loads(): void
    {
        $response = $this->get('/');

        $response->assertOk();
    }

    public function test_save_saves(): void
    {
        $slug = Str::random();
        /** @var HttpStatus $httpStatus */
        $httpStatus = Arr::random(HttpStatus::cases());
        $this->post(route('settings.save'), [
            'slug' => $slug,
            'http_status' => $httpStatus->value,
            'body' => Str::random(),
        ])
            ->assertOk()
            ->assertJson([]);
        $query = Response::where('slug', '=', $slug);
        $this->assertTrue($query->exists());
        $query->delete();
    }

    public function test_clear_clears(): void
    {
        $slug = Str::random();
        /** @var HttpStatus $httpStatus */
        $httpStatus = Arr::random(HttpStatus::cases());
        $this->post(route('settings.save'), [
            'slug' => $slug,
            'http_status' => $httpStatus->value,
            'body' => Str::random(),
        ])
            ->assertOk()
            ->assertJson([]);
        $query = Response::where('slug', '=', $slug);
        $this->assertTrue($query->exists());
        $this->get(route('settings.clear'));
        $this->assertFalse($query->exists());
    }
}

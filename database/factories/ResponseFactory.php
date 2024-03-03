<?php

namespace Database\Factories;

use App\Enums\HttpStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Response>
 */
class ResponseFactory extends Factory
{
    /**
     * @return mixed[]
     */
    public function definition(): array
    {
        /** @var HttpStatus $httpStatus */
        $httpStatus = Arr::random(HttpStatus::cases());
        return [
            'method' => 'GET',
            'http_status' => $httpStatus,
            'slug' => Str::random(),
            'body' => Str::random(),
            'headers' => ['foo' => 'bar'],
        ];
    }
}

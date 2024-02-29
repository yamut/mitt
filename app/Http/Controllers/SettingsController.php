<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveSetting;
use App\Models\Response;
use Illuminate\Http\JsonResponse;

class SettingsController extends Controller
{
    public function save(SaveSetting $request): JsonResponse
    {
        Response::create(
            [
                'http_status' => $request->integer('code'),
                'slug' => $request->string('endpoint'),
                'body' => $request->string('body'),
                'method' => 'GET', // todo: allow other methods
            ]
        );
        return response()->json(); // todo: something
    }

    public function get(): JsonResponse
    {
        return response()->json(Response::all());
    }
}

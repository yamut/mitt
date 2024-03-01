<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveSetting;
use App\Models\Request;
use App\Models\Response;
use Illuminate\Http\JsonResponse;

class SettingsController extends Controller
{
    public function save(SaveSetting $request): JsonResponse
    {
        Response::create(
            [
                'http_status' => $request->integer('http_status'),
                'slug' => $request->string('slug'),
                'body' => $request->string('body'),
                'method' => 'GET', // todo: allow other methods
                'headers' => $request->get('headers'),
            ]
        );
        return response()->json(); // todo: something
    }

    public function get(): JsonResponse
    {
        return response()->json(Response::all());
    }

    public function clear(): JsonResponse
    {
        Request::query()->delete();
        Response::query()->delete();
        return response()->json();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Request as RequestModel;
use App\Models\Response as ResponseModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CatchController extends Controller
{
    public function catch(Request $request, string $anything): JsonResponse
    {
        $response = ResponseModel::where('slug', '=', $anything)
            ->firstOrFail();
        $response->requests()->create(
            [
                'headers' => $request->headers->all(),
                'content' => $request->getContent(),
            ],
        );

        return response()->json(
            data: $response->body,
            status: $response->http_status,
        );
    }

    public function caught(): JsonResponse
    {
        return response()->json(RequestModel::all());
    }
}

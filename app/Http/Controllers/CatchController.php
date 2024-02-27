<?php

namespace App\Http\Controllers;

use App\Dto\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class CatchController extends Controller
{
    public const string CACHE_KEY = 'requests';
    public function catch(Request $request, string $anything): Response
    {
        $existingCache = Cache::get(self::CACHE_KEY, []);
        Cache::forget(self::CACHE_KEY);
        $existingCache[] = new \App\Dto\Request(
            $anything,
            $request->getContent(),
            $request->headers->all(),
        );
        Cache::rememberForever(self::CACHE_KEY, function () use (&$existingCache): array {
            return $existingCache;
        });
        /** @var Setting[] $cache */
        $cache = Cache::get(SettingsController::CACHE_PREFIX);
        $filtered = array_filter(
            $cache,
            fn (Setting $setting) => $setting->getEndpoint() === $anything,
        );
        if (empty($filtered)) {
            abort(404);
        }
        $catcher = Arr::first($filtered);
        return response(
            content: $catcher->getBody(),
            status:  $catcher->getCode(),
        );
    }

    public function caught(): JsonResponse
    {
        return response()->json(Cache::get(self::CACHE_KEY, []));
    }
}

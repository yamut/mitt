<?php

namespace App\Http\Controllers;

use App\Dto\Setting;
use App\Http\Requests\SaveSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    public const string CACHE_PREFIX = 'catchers';

    public function save(SaveSetting $request): JsonResponse
    {
        if (Cache::has(self::CACHE_PREFIX)) {
            $existingCache = Cache::get(self::CACHE_PREFIX);
            Cache::delete(self::CACHE_PREFIX);
        } else {
            $existingCache = [];
        }
        $cache = Cache::rememberForever(
            self::CACHE_PREFIX,
            function () use ($request, &$existingCache): array {
                $existingCache[] = new Setting(
                    $request->string('endpoint'),
                    $request->integer('code'),
                    $request->string('body'),
                );
                return $existingCache;
            }
        );
        return response()->json(
            [
                'cache' => $cache,
            ],
        );
    }

    public function get()
    {
        $cache = Cache::get(self::CACHE_PREFIX);
        return response()->json($cache);
    }
}

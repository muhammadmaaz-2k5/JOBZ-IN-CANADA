<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SemanticCacheService
{
    private static function getApiKey()
    {
        return config('services.redis_langcache.api_key');
    }

    private static function getCacheId()
    {
        return config('services.redis_langcache.cache_id');
    }

    public static function search($keyword)
    {
        $apiKey = self::getApiKey();
        $cacheId = self::getCacheId();

        if (!$apiKey || !$cacheId) {
            return null;
        }

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => "Bearer {$apiKey}"
            ])
            ->timeout(2)
            ->post("https://aws-us-east-1.langcache.redis.io/v1/caches/{$cacheId}/entries/search", [
                'prompt' => $keyword
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (is_array($data) && count($data) > 0) {
                    $cachedResponse = $data[0]['response'] ?? null;
                    if ($cachedResponse) {
                        $ids = json_decode($cachedResponse, true);
                        if (is_array($ids)) {
                            return $ids;
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            Log::warning('LangCache search lookup failed: ' . $e->getMessage());
        }

        return null;
    }

    public static function save($keyword, array $jobIds)
    {
        $apiKey = self::getApiKey();
        $cacheId = self::getCacheId();

        if (!$apiKey || !$cacheId || empty($jobIds)) {
            return false;
        }

        try {
            Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => "Bearer {$apiKey}"
            ])
            ->timeout(2)
            ->post("https://aws-us-east-1.langcache.redis.io/v1/caches/{$cacheId}/entries", [
                'prompt' => $keyword,
                'response' => json_encode($jobIds)
            ]);
            return true;
        } catch (\Exception $e) {
            Log::warning('LangCache save entry failed: ' . $e->getMessage());
        }

        return false;
    }
}

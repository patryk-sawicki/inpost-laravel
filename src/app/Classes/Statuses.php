<?php

namespace PatrykSawicki\InPost\app\Classes;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Statuses extends Api
{
    /**
     * Get a list of the available statuses.
     *
     * @param bool $returnJson
     * @return string|array
     */
    public function list(bool $returnJson = false)
    {
        $cacheName = 'inPost_statuses_' . $returnJson;

        return Cache::remember($cacheName, config('inPost.cache_time'), function () use ($returnJson) {
            $route = '/v1/statuses';

            $data = [];

            $response = Http::withHeaders($this->requestHeaders())->get($this->url.$route, $data);

            if($response->status() != 200)
                abort(400, $response->body());

            return $returnJson ? $response->body() : json_decode($response->body(), true);
        });
    }
}
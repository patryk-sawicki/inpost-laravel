<?php

namespace PatrykSawicki\InPost\app\Classes;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Points extends Api
{
    /**
     * Get a list of the available points.
     *
     * @param array $options
     * @param bool $returnJson
     * @return string|array
     */
    public function list(array $options = [], bool $returnJson = false)
    {
        $cacheName = 'inPost_points_list_' . $returnJson . '_' . md5(json_encode($options));

        return Cache::remember($cacheName, config('inPost.cache_time'), function () use ($options, $returnJson) {
            $route = '/v1/points';

            $response = Http::withHeaders($this->requestHeaders())->get($this->url.$route, $options);

            if($response->status() != 200)
                abort(400, $response->body());

            return $returnJson ? $response->body() : json_decode($response->body(), true);
        });
    }

    /**
     * Get a point details.
     *
     * @param string $name
     * @param bool $returnJson
     * @return string|array
     */
    public function get(string $name, bool $returnJson = false)
    {
        $cacheName = 'inPost_points_get_' . $name . '_' . $returnJson;

        return Cache::remember($cacheName, config('inPost.cache_time'), function () use ($name, $returnJson) {
            $route = '/v1/points/' . $name;

            $response = Http::withHeaders($this->requestHeaders())->get($this->url.$route);

            if($response->status() != 200)
                abort(400, $response->body());

            return $returnJson ? $response->body() : json_decode($response->body(), true);
        });
    }
}
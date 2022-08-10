<?php

namespace PatrykSawicki\InPost\app\Classes;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Organizations extends Api
{
    /**
     * Get organizations list.
     *
     * @param array $options
     * @param bool $returnJson
     * @return string|array
     */
    public function list(array $options = [], bool $returnJson = false)
    {
        $cacheName = 'inPost_organizations_list_' . $returnJson . '_' . md5(json_encode($options));

        return Cache::remember($cacheName, config('inPost.cache_time'), function () use ($options, $returnJson) {
            $route = '/v1/organizations';

            $response = Http::withHeaders($this->requestHeaders())->get($this->url.$route, $options);

            if($response->status() != 200)
                abort(400, $response->body());

            return $returnJson ? $response->body() : json_decode($response->body(), true);
        });
    }

    /**
     * Get organization details.
     *
     * @param int $id
     * @param bool $returnJson
     * @return string|array
     */
    public function get(int $id, bool $returnJson = false)
    {
        $cacheName = 'inPost_organizations_get_' . $id . '_' . $returnJson;

        return Cache::remember($cacheName, config('inPost.cache_time'), function () use ($id, $returnJson) {
            $route = '/v1/organizations/' . $id;

            $response = Http::withHeaders($this->requestHeaders())->get($this->url.$route);

            if($response->status() != 200)
                abort(400, $response->body());

            return $returnJson ? $response->body() : json_decode($response->body(), true);
        });
    }

    /**
     * Get organization statistics.
     *
     * @param int $id
     * @param bool $returnJson
     * @return string|array
     */
    public function statistics(int $id, bool $returnJson = false)
    {
        $cacheName = 'inPost_organizations_statistics_' . $id . '_' . $returnJson;

        return Cache::remember($cacheName, config('inPost.cache_time'), function () use ($id, $returnJson) {
            $route = '/v1/organizations/' . $id . '/statistics';

            $response = Http::withHeaders($this->requestHeaders())->get($this->url.$route);

            if($response->status() != 200)
                abort(400, $response->body());

            return $returnJson ? $response->body() : json_decode($response->body(), true);
        });
    }
}
<?php

namespace PatrykSawicki\InPost\app\Classes;

use Illuminate\Support\Facades\Http;

class Tracking extends Api
{
    /**
     * Get a tracking details.
     *
     * @param string $tracking_number
     * @param bool $returnJson
     * @return string|array
     */
    public function get(string $tracking_number, bool $returnJson = false)
    {
        $route = '/v1/tracking/' . $tracking_number;

        $response = Http::withHeaders($this->requestHeaders())->get($this->url.$route);

        if($response->status() != 200)
            abort(400, $response->body());

        return $returnJson ? $response->body() : json_decode($response->body(), true);
    }
}
<?php

namespace PatrykSawicki\InPost\app\Classes;

use PatrykSawicki\InPost\app\Traits\functions;

class Api
{
    use functions;

    protected string $apiKey, $url;

    public function __construct() {
        $this->apiKey = config('inPost.api_key');
        $this->url = config('inPost.sandbox') ? config('inPost.sandbox_url') : config('inPost.api_url');
    }
}
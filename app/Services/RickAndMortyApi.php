<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class RickAndMortyApi
{
    public function __construct(
        private string $url,
        private int    $timeout,
    )
    {
    }

    private function http(): PendingRequest
    {
        return Http::baseUrl($this->url)->acceptJson()->timeout($this->timeout);
    }

    public function get(string $path, array $query = []): ?array
    {
        $response = $this->http()->get($path, $query);
        return $response->json();
    }

}

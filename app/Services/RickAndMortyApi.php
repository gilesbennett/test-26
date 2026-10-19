<?php

namespace App\Services;

use App\Models\Character;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;

class RickAndMortyApi
{
    private const int PAGE_SIZE = 20;

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

    public function search(array $filters, int $page = 1): LengthAwarePaginator
    {
        $data = $this->get('/character', [...$filters, 'page' => $page]);
        $characters = array_map(Character::fromApi(...), $data['results'] ?? []);
        return new LengthAwarePaginator(
            items: $characters,
            total: $data['info']['count'] ?? 0,
            perPage: self::PAGE_SIZE,
            currentPage: $page
        );

    }

}

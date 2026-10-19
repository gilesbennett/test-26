<?php

namespace App\Services;

use App\Exceptions\ApiUnavailableException;
use App\Models\Character;
use App\Models\Episode;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Throwable;

class RickAndMortyApi
{
    private const int PAGE_SIZE = 20;

    private const string COOLOFF_KEY = 'rickandmorty:cooloff';

    public function __construct(
        private string $url,
        private int $timeout,
        private int $cachelifetime,
        private int $coolofftime,
        private int $dailylimit,
    ) {}

    private function http(): PendingRequest
    {
        return Http::baseUrl($this->url)->acceptJson()->timeout($this->timeout)->connectTimeout(2)->retry(
            [250, 1000], when: $this->shouldRetry(...), throw: false);
    }

    private function shouldRetry(Throwable $exception): bool
    {
        if ($exception instanceof ConnectionException) {
            return true;
        }
        if ($exception instanceof RequestException) {
            return $exception->response->serverError();
        }

        return false;
    }

    /**
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>|null
     *
     * @throws ApiUnavailableException
     */
    public function get(string $path, array $query = []): ?array
    {
        if (Cache::has(self::COOLOFF_KEY)) {
            throw new ApiUnavailableException('The API is rate limited - you are currently cooling off');
        }
        if (RateLimiter::tooManyAttempts('rickandmorty:daily', $this->dailylimit)) {
            throw new ApiUnavailableException('The API has a daily rate limit which has been exceeded');
        }
        RateLimiter::increment('rickandmorty:daily', 86400);
        try {
            $response = $this->http()->get($path, $query);
        } catch (ConnectionException $exception) {
            throw new ApiUnavailableException('Could not connect to the API', previous: $exception);
        }
        if ($response->notFound()) {
            return null;
        }
        if ($response->failed()) {
            if ($response->tooManyRequests()) {
                Cache::put(self::COOLOFF_KEY, true, (int) $response->header('Retry-After') ?: $this->coolofftime);
            }
            throw new ApiUnavailableException("The API returned {$response->status()}");
        }

        return $response->json();
    }

    /**
     * @param  array<string, string>  $filters
     * @return LengthAwarePaginator<int, Character>
     *
     * @throws ApiUnavailableException
     */
    public function search(array $filters, int $page = 1): LengthAwarePaginator
    {
        ksort($filters);
        $jsondata = json_encode([$filters, 'page' => $page], JSON_THROW_ON_ERROR);
        $hashed = md5($jsondata);
        $key = 'rickandmorty:characters:'.$hashed;
        $data = Cache::remember($key, $this->cachelifetime, fn () => $this->get('/character', [...$filters, 'page' => $page]) ?? []
        );
        $characters = array_map(Character::fromApi(...), $data['results'] ?? []);

        return new LengthAwarePaginator(
            items: $characters,
            total: $data['info']['count'] ?? 0,
            perPage: self::PAGE_SIZE,
            currentPage: $page
        );
    }

    /**
     * @param  array<int, int>  $ids
     * @return array<int, Episode>
     *
     * @throws ApiUnavailableException
     */
    public function episodes(array $ids): array
    {
        $ids = array_values(array_unique($ids));
        if (empty($ids)) {
            return [];
        }
        $items = array_filter(Cache::many(array_map(fn (int $id) => "rickandmorty:episode:{$id}", $ids)));
        $missing = array_values(array_filter($ids, fn (int $id) => ! isset($items["rickandmorty:episode:{$id}"])));
        if (! empty($missing)) {
            $data = $this->get('/episode/'.implode(',', $missing)) ?? [];
            $results = isset($data['id']) ? [$data] : $data;
            foreach ($results as $result) {
                $key = "rickandmorty:episode:{$result['id']}";
                Cache::put($key, $result, $this->cachelifetime);
                $items[$key] = $result;
            }
        }
        $episodes = [];
        foreach ($items as $item) {
            $episode = Episode::fromApi($item);
            $episodes[$episode->id] = $episode;
        }

        return $episodes;
    }
}

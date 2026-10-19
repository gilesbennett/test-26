<?php

namespace App\Models;

class Episode
{
    public function __construct(
        public int    $id,
        public string $name,
        public string $airdate,
        public string $episode
    )
    {
    }

    public static function fromApi(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            airdate: $data['air_date'],
            episode: $data['episode']
        );
    }

}

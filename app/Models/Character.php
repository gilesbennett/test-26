<?php

namespace App\Models;

class Character
{
    /**
     * @param  array<int, int>  $episodeIds
     */
    public function __construct(
        public int $id,
        public string $name,
        public CharacterStatus $status,
        public string $origin,
        public string $location,
        public string $image,
        public string $species,
        public string $type,
        public CharacterGender $gender,
        public array $episodeIds,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromApi(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            status: CharacterStatus::tryFrom(strtolower($data['status'])) ?? CharacterStatus::Unknown,
            origin: $data['origin']['name'],
            location: $data['location']['name'],
            image: $data['image'],
            species: $data['species'],
            type: $data['type'],
            gender: CharacterGender::tryFrom(strtolower($data['gender'])) ?? CharacterGender::Unknown,
            episodeIds: array_map(
                fn (string $url) => (int) basename($url),
                $data['episode'],
            ), );
    }

    public function hasSubType(): bool
    {
        return ! empty($this->type);
    }
}

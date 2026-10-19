<?php

namespace App\Models;

enum CharacterStatus: string
{
    case Alive = 'alive';
    case Dead = 'dead';
    case Unknown = 'unknown';

    public function label(): string
    {
        return ucfirst($this->value);
    }

    public function radioClass(): string
    {
        return match ($this) {
            self::Alive => 'checked:btn-success',
            self::Dead => 'checked:btn-error',
            self::Unknown => 'checked:btn-neutral',
        };
    }

}

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

}

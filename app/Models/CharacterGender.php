<?php

namespace App\Models;

enum CharacterGender: string

{
    case Female = 'female';
    case Male = 'male';
    case Genderless = 'genderless';
    case Unknown = 'unknown';

    public function label(): string
    {
        return ucfirst($this->value);
    }

}

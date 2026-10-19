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

    public function radioClass(): string
    {
        return match ($this) {
            self::Female => 'checked:btn-success',
            self::Male => 'checked:btn-warning',
            self::Genderless => 'checked:btn-error',
            self::Unknown => 'checked:btn-neutral',
        };
    }

}

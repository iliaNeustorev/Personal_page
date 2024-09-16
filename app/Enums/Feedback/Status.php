<?php

namespace App\Enums\Feedback;

enum Status: int
{
    case NEW = 0;
    case VIEWED = 1;

    /**
     *
     * @return string
     */
    public function text(): string
    {
        return match($this->value)
        {
            self::NEW->value => 'Новый',
            self::VIEWED->value => 'Просмотрен',
        };
    }
}
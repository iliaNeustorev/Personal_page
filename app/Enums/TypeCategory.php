<?php

namespace App\Enums;

enum TypeCategory: int
{
    case DOCUMENT = 0;
    case PHOTO = 1;

    /**
     *
     * @return string
     */
    public function text(): string
    {
        return match($this->value)
        {
            self::DOCUMENT->value => 'Документ',
            self::PHOTO->value => 'Фото',
        };
    }

    /**
     *
     * @return iterable
     */
    public static function getCollection(): iterable
    {
        return [
            self::DOCUMENT->value => self::DOCUMENT->text(),
            self::PHOTO->value => self::PHOTO->text()
        ];
    }
}
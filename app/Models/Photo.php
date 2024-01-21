<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Photo extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'category',
        'caption'
    ];

    /**
     * Получить картинку.
     *
     * @return MorphOne
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('d.m.Y H:i:s');
    }
}

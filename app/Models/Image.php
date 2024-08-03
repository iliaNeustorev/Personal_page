<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'url',
        'caption'
    ];
    
    protected $casts = [
        'created_at' => 'datetime:d.m.Y H:i:s',
        'updated_at' => 'datetime:d.m.Y H:i:s',
    ];

    /**
     *
     * @return MorphTo
     */
    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}

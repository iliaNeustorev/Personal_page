<?php

namespace App\Models;

use App\Enums\Feedback\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feedback extends Model
{
    use HasFactory;

    const LIMIT_ON_USER = 5;

    protected $fillable = [
        'question_subject',
        'question',
        'user_id',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime:d.m.Y H:i:s',
        'status' => Status::class
    ];

    /**
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

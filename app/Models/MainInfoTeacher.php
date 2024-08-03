<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class MainInfoTeacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotes',
        'education',
        'teaching_experience',
        'teaching_category',
        'personal_slogan',
        'credo',
        'working_principles',
        'personal_qualities',
        'personal_email_teacher',
        'kindergarten_in_place_work',
        'address_kindergarten',
        'phone_kindergarten',
        'user_id',
        'active'
    ];

    protected $casts = [
        'working_principles' => AsArrayObject::class,
        'personal_qualities' => AsArrayObject::class,
    ];
    
    /**
     *
     * @return MorphOne
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    /**
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(MainInfoTeacher::class);
    }
}

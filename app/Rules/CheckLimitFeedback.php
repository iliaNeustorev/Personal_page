<?php

namespace App\Rules;

use App\Models\Feedback;
use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckLimitFeedback implements ValidationRule
{
    public function __construct(
        protected ?User $user
    ) {}

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->user?->feedbacks()->count() >= Feedback::LIMIT_ON_USER) {
            $fail('Вы достигли лимита отзывов = ' . Feedback::LIMIT_ON_USER);
        }
    }
}

<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckArray implements ValidationRule
{
    public function __construct(
        protected string $model
    ) {}

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $array, Closure $fail): void
    {
        foreach ($array as $id){
            if(!preg_match('/^[1-9]+\d*$/', $id)){
                $fail('id не число');
            }
        }
        $cnt = $this->model::whereIn('id', $array)->count();
        if ($cnt !== count($array)) {
            $fail('Вы пытаетесь добавить несушествующий id');
        }
    }
}

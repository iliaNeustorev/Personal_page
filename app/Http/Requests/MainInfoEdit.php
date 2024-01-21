<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Unique;

class MainInfoEdit extends MainInfoCreate
{
    protected function uniqueRule(): Unique
    {
        return parent::uniqueRule()->ignore(request()->id);
    }
}

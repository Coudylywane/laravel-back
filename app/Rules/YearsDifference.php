<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\Factory as ValidatorFactory;

class YearsDifference implements Rule
{
    public function passes($attribute, $value)
    {
// La "libelle" doit être au format "AAAA-AAAA", donc nous la divisons au tiret
        $years = explode('-', $value);

        if (count($years) === 2) {
            $firstYear = (int) $years[0];
            $lastYear = (int) $years[1];
            return ($lastYear - $firstYear) === 1;
        }

        return false; // S'il ne correspond pas au format, la validation échoue.
    }

    public function message()
    {
        return 'La différence entre la première et la dernière année doit être égale à 1.';
    }
}

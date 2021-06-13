<?php

namespace App\Casts;

use App\Values\DaysValue;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class DaysCast implements CastsAttributes
{
    /** {@inheritDoc} */
    public function get($model, string $key, $value, array $attributes)
    {
        return new \App\Values\DaysValue($value);
    }

    /** {@inheritDoc} */
    public function set($model, string $key, $value, array $attributes)
    {
        if (empty($value)) {
            return null;
        } elseif (is_array($value)) {
            return json_encode($value);
        } elseif ($value instanceof DaysValue) {
            return $value->toJson();
        }
    }
}

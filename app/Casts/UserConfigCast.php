<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use App\Values\UserConfigValue;

class UserConfigCast implements CastsAttributes
{
    /** {@inheritDoc} */
    public function get($model, string $key, $value, array $attributes)
    {
        return new UserConfigValue($value);
    }

    /** {@inheritDoc} */
    public function set($model, string $key, $value, array $attributes)
    {
        if (empty($value)) {
            return null;
        } elseif (is_array($value)) {
            return json_encode($value);
        } elseif ($value instanceof UserConfigValue) {
            return $value->toJson();
        }
    }
}

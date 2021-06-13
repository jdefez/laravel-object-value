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
        // todo: validation logic

        // todo: UserConfig toJson returns json key values pairs
        return $value->toJson();
    }
}

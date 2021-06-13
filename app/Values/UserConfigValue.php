<?php

namespace App\Values;

use Illuminate\Support\Collection;
use InvalidArgumentException;

class UserConfigValue
{
    protected Collection $settings;

    protected Collection $config;

    public function __construct(? string $config)
    {
        $this->settings = collect(config('user.settings'));
        $this->config = $this->setSetting($config);
    }

    /** @throws InvalidArgumentException */
    private function setSetting(?string $config): Collection
    {
        if (empty($config)) {
            return collect();
        }

        $config = json_decode($config);
        if (! is_array($config)) {
            throw new InvalidArgumentException(
                'User@config attribute should resolve as an array'
            );
        }

        // todo: compare with (default settings) to complete user settings

        return collect($config);
    }
}

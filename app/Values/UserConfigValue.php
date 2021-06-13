<?php

namespace App\Values;

use Illuminate\Support\Collection;
use InvalidArgumentException;

class UserConfigValue
{
    protected Collection $settings;

    protected Collection $config;

    public function __construct(?string $config)
    {
        $this->settings = $this->setSettings();
        $this->config = $this->setConfig($config);

        $this->extendWithSettings();
    }

    public function toJson(): string
    {
        return $this->config->toJson();
    }

    public function has(string $setting): bool
    {
        return $this->config->has($setting);
    }

    public function get(string $setting)
    {
        return $this->config[$setting] ?: null;
    }

    /** @throws InvalidArgumentException */
    public function set(string $setting, $value)
    {
        if (!$this->has($setting)) {
            throw new InvalidArgumentException(
                sprintf('Unexpected setting ‘%s‘', $value)
            );
        }

        if (!in_array($value, $this->settings[$setting]->values)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Invalid value ‘%s‘ expecting one of: ‘%s‘',
                    $value,
                    implode(', ', $this->settings[$setting]->values)
                )
            );
        }

        $this->config[$setting] = $value;
    }

    public function is(string $setting, $value)
    {
        return ($this->config->has($setting)
            && $this->config[$setting] === $value
        );
    }

    public function all(): Collection
    {
        return $this->config;
    }

    public function getSettings(): Collection
    {
        return $this->settings;
    }

    /** @throws InvalidArgumentException */
    private function setConfig(?string $config): Collection
    {
        if (empty($config)) {
            return collect();
        }

        $json = json_decode($config, true);
        if (!is_array($json)) {
            throw new InvalidArgumentException(
                'User@config attribute should resolve as an array'
            );
        }

        return collect($json);
    }

    private function extendWithSettings(): void
    {
        foreach ($this->settings as $key => $value) {
            if (!$this->config->has($key)) {
                $this->config[$key] = $value->default;
            }
        }
    }

    private function setSettings(): Collection
    {
        return collect(config('user.settings'))
            ->map(fn ($item) => (object) $item);
    }
}

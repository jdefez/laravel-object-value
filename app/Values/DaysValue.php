<?php

namespace App\Values;

use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use InvalidArgumentException;
use stdClass;

class DaysValue
{
    protected Collection $days;

    public function __construct(?string $days)
    {
        $this->days = $this->setDays($days);
    }

    public function all(): Array
    {
        return $this->days->all();
    }

    public function first(): ?stdClass
    {
        return $this->days->first() ?: null;
    }

    public function last(): ?stdClass
    {
        return $this->days->last() ?: null;
    }

    public function map(callable $callback): Collection
    {
        return $this->days->map(fn ($day) => $callback($day));
    }

    public function toJson(): string
    {
        $days = $this->days
            ->map(function($item) {
                return collect((array) $item)
                    ->map(fn ($item) => $this->toStringDates($item));
            });
        return $days->toJson();
    }

    /** @throws InvalidArgumentException */
    private function setDays(?string $days): Collection
    {
        if (empty($days)) {
            return collect();
        }

        $days = json_decode($days);
        if (! is_array($days)) {
            throw new InvalidArgumentException(
                'User@days attribute should resolve as an array'
            );
        }

        // Note: should we check that every day as a start_at and an end_at
        //  date corresponding to a single day

        return collect($days)
            ->map(function($item) {
                return (object) collect($item)
                    ->map(fn ($date) => $this->format($date))
                    ->toArray();
            });
    }

    private function format(?string $value): ?Carbon
    {
        if (! $value) {
            return $value;
        }

        return Carbon::parse($value);
    }

    private function toStringDates(?Carbon $value)
    {
        if (! $value) {
            return $value;
        }

        return $value->format(config('app.date_format'));
    }
}

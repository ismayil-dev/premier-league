<?php

use Illuminate\Support\Collection;

if (!function_exists('weeks')) {
    /**
     * Return weeks
     * @param int|null $key
     * @return Collection|string
     */
    function weeks(int $key = null): Collection|string
    {
        $allWeeks = collect(config('weeks'));
        return $key ? ($allWeeks->offsetExists($key) ? $allWeeks->offsetGet($key) : '') : $allWeeks;
    }
}

if (!function_exists('round2')) {
    /**
     * Round number to 2 digit after dot.
     * @param float|int $number
     * @return  float
     */
    function round2(float $number)
    {
        return round($number, 2);
    }
}

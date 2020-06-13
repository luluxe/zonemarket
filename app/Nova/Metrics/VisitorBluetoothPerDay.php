<?php

namespace App\Nova\Metrics;

use App\Models\User;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class VisitorBluetoothPerDay extends Value
{
    public $name = 'Visiteurs blutooth par Jour';

    /**
     * Calculate the value of the metric.
     *
     * @param NovaRequest $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return $this->count($request, User::class, null, 'visited_at');
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            30 => '30 Jours',
            60 => '60 Jours',
            365 => '365 Jours',
            'TODAY' => "Aujourd'hui",
            'MTD' => 'Mois à ce jour',
            'QTD' => 'Trimestre à ce jour',
            'YTD' => 'Année à ce jour',
        ];
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return void
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'visitor-bluetooth-per-day';
    }
}

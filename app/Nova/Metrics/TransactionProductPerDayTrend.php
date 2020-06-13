<?php

namespace App\Nova\Metrics;

use App\Models\TransactionProduct;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Trend;

class TransactionProductPerDayTrend extends Trend
{
    public $name = 'Produits par Jour';

    /**
     * Calculate the value of the metric.
     *
     * @param NovaRequest $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return $this->countByDays($request, TransactionProduct::class);
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            15 => '15 Jours',
            30 => '30 Jours',
            60 => '60 Jours',
            90 => '90 Jours',
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
        return 'transaction-product-per-day-trend';
    }
}

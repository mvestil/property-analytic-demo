<?php

namespace App\Services\Contracts;

use App\Models\Property;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

/**
 * Interface AnalyticServiceInterface
 *
 * @package App\Services\Contracts
 */
interface AnalyticServiceInterface
{
    /**
     * Get analytic by property
     *
     * @param Property $property
     * @param int      $limit
     * @return LengthAwarePaginator
     */
    public function getByProperty(Property $property, int $limit): LengthAwarePaginator;

    /**
     * Update/add an analytic to a property
     *
     * @param Request  $request
     * @param Property $property
     * @return mixed
     */
    public function saveToProperty(Request $request, Property $property);
}

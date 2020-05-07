<?php

namespace App\Repositories\Contracts;

use App\Models\Property;
use App\ValueObjects\PropertyAnalyticSummary;

/**
 * Interface PropertyRepositoryInterface
 *
 * @package App\Repositories\Contracts
 */
interface PropertyRepositoryInterface
{
    /**
     * Insert a new property
     *
     * @param array $data
     * @return mixed
     */
    public function insert(array $data): Property;

    /**
     * Get a summary of all property analytics for an inputted suburb, state, country
     *  (min value, max value, median value, percentage properties with a value, percentage properties without a value)
     *
     * @param string $areaCategory (e.g suburb, state, country)
     * @param string $area (e.g. Blacktown, Paramatta, etc.)
     * @return mixed
     */
    public function getStatisticByArea(string $areaCategory, string $area): PropertyAnalyticSummary;
}

<?php

namespace App\Repositories\Contracts;

use App\Models\AnalyticType;
use App\Models\Property;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Interface AnalyticTypeRepositoryInterface
 *
 * @package App\Repositories\Contracts
 */
interface AnalyticTypeRepositoryInterface
{
    /**
     * Find a type given an id
     *
     * @param int $id
     * @return AnalyticType|null
     */
    public function findById(int $id): ?AnalyticType;

    /**
     * Check if a type is assigned to a property
     *
     * @param AnalyticType $type
     * @param Property     $property
     * @return bool
     */
    public function hasProperty(AnalyticType $type, Property $property): bool;

    /**
     * Update/assign a type to a property
     *
     * @param AnalyticType $type
     * @param Property     $property
     * @param array        $data
     * @return mixed
     */
    public function updateToProperty(AnalyticType $type, Property $property, array $data);

    /**
     * Add/assign a type to a property
     *
     * @param AnalyticType $type
     * @param Property     $property
     * @param array        $data
     * @return mixed
     */
    public function addToProperty(AnalyticType $type, Property $property, array $data);

    /**
     * Get analytics by property
     *
     * @param Property $property
     * @param int      $limit
     * @return LengthAwarePaginator
     */
    public function getByProperty(Property $property, int $limit): LengthAwarePaginator;
}

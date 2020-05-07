<?php

namespace App\Repositories;

use App\Exceptions\ValidationException;
use App\Models\AnalyticType;
use App\Models\Property;
use App\Repositories\Contracts\AnalyticTypeRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class AnalyticTypeRepository
 */
class AnalyticTypeRepository extends BaseRepository implements AnalyticTypeRepositoryInterface
{
    /**
     * AnalyticTypeRepository constructor.
     *
     * @param AnalyticType $model
     */
    public function __construct(AnalyticType $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $id
     * @return AnalyticType|null
     */
    public function findById(int $id): ?AnalyticType
    {
        return $this->getModel()->find($id);
    }

    /**
     * Check if a type is assigned to a property already
     *
     * @param AnalyticType $type
     * @param Property     $property
     * @return bool
     */
    public function hasProperty(AnalyticType $type, Property $property): bool
    {
        return $type->properties()
            ->where('property_id', $property->id)
            ->exists();
    }

    /**
     * Update analytic of a property
     *
     * @param AnalyticType $type
     * @param Property     $property
     * @param array        $data
     * @return mixed|void
     * @throws ValidationException
     */
    public function updateToProperty(AnalyticType $type, Property $property, array $data)
    {
        $this->validateSaveToProperty($data);

        $type->properties()->updateExistingPivot($property->id, ['value' => $data['value']]);
    }

    /**
     * Add analytic to a property
     *
     * @param AnalyticType $type
     * @param Property     $property
     * @param array        $data
     * @return mixed|void
     * @throws ValidationException
     */
    public function addToProperty(AnalyticType $type, Property $property, array $data)
    {
        $this->validateSaveToProperty($data);

        $type->properties()->attach($property->id, ['value' => $data['value']]);
    }

    /**
     * Get analytic given a property
     *
     * @param Property $property
     * @param int      $limit
     * @return LengthAwarePaginator
     */
    public function getByProperty(Property $property, int $limit): LengthAwarePaginator
    {
        return $property->analytics()->paginate($limit);
    }

    /**
     * Though we have validation in our controller, but we needed this in case developers
     * call the consumers of this method (e.g. updateToProperty(), addToProperty())
     * from a different place (other than controller) where these field/s are not validated
     *
     * @param array $data
     * @throws ValidationException
     */
    protected function validateSaveToProperty(array $data)
    {
        if (empty($data['value'])) {
            throw new ValidationException('Some data missing when updating analytic');
        }
    }
}

<?php

namespace App\Services;

use App\Exceptions\InvalidValueException;
use App\Exceptions\ValidationException;
use App\Models\AnalyticType;
use App\Models\Property;
use App\Repositories\Contracts\AnalyticTypeRepositoryInterface;
use App\Services\Contracts\AnalyticServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

/**
 * Class AnalyticService
 *
 * Handles application logic for analytics related
 */
class AnalyticService implements AnalyticServiceInterface
{
    /**
     * @var AnalyticTypeRepositoryInterface
     */
    protected $type;

    /**
     * AnalyticService constructor.
     *
     * @param AnalyticTypeRepositoryInterface $type
     */
    public function __construct(AnalyticTypeRepositoryInterface $type)
    {
        $this->type = $type;
    }

    /**
     * Get analytic of a property
     *
     * @param Property $property
     * @param int      $limit
     * @return LengthAwarePaginator
     */
    public function getByProperty(Property $property, int $limit): LengthAwarePaginator
    {
        return $this->type->getByProperty($property, $limit);
    }

    /**
     * Add/update an analytic to a property
     *
     * @param Request  $request
     * @param Property $property
     * @throws InvalidValueException|ValidationException
     */
    public function saveToProperty(Request $request, Property $property)
    {
        if (!$analyticType = $this->type->findById($request->input('analytic_type_id'))) {
            throw new ValidationException('Analytic type could not be found');
        }

        $this->validateValue($request, $analyticType);

        $params = [$analyticType, $property, ['value' => $request->input('value')]];

        $this->type->hasProperty($analyticType, $property) ?
            $this->type->updateToProperty(...$params) :
            $this->type->addToProperty(...$params);
    }

    /**
     * Validate value of an analytic
     *
     * @param Request $request
     * @throws InvalidValueException
     */
    protected function validateValue(Request $request, AnalyticType $type)
    {
        $value = $request->input('value');

        if ($type->isNumeric() && !is_numeric($value)) {
            throw new InvalidValueException('Analytic value should be numeric');
        }

        if (!$type->isNumeric() && is_numeric($value)) {
            throw new InvalidValueException('Analytic value should be non-numeric');
        }
    }
}

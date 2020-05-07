<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnalyticSummaryRequest;
use App\Http\Requests\StoreProperty;
use App\Http\Resources\PropertyResource;
use App\Http\Resources\PropertyAnalyticSummaryResource;
use App\Repositories\Contracts\PropertyRepositoryInterface;

/**
 * Class PropertyController
 */
class PropertyController extends Controller
{
    /**
     * @var PropertyRepositoryInterface
     */
    protected $property;

    /**
     * PropertyController constructor.
     *
     * @param PropertyRepositoryInterface $propertyRepository
     */
    public function __construct(PropertyRepositoryInterface $propertyRepository)
    {
        $this->property = $propertyRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return PropertyResource
     */
    public function store(StoreProperty $request)
    {
        $property = $this->property->insert($request->all());

        return new PropertyResource($property);
    }

    /**
     * Get summary of analytics of a given area
     *
     * @param AnalyticSummaryRequest $request
     * @return PropertyAnalyticSummaryResource
     */
    public function summary(AnalyticSummaryRequest $request)
    {
        $result = $this->property->getStatisticByArea(
            $request->input('area_category'),
            $request->input('area')
        );

        return new PropertyAnalyticSummaryResource($result);
    }
}

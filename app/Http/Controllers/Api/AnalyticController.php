<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ValidationException;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveAnalytic;
use App\Http\Resources\AnalyticCollection;
use App\Models\Property;
use App\Services\Contracts\AnalyticServiceInterface;

class AnalyticController extends Controller
{
    /**
     * @var AnalyticServiceInterface
     */
    protected $analytic;

    /**
     * AnalyticController constructor.
     *
     * @param AnalyticServiceInterface $analytic
     */
    public function __construct(AnalyticServiceInterface $analytic)
    {
        $this->analytic = $analytic;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Property $property
     * @return AnalyticCollection
     */
    public function index(Property $property)
    {
        return new AnalyticCollection(
            $this->analytic->getByProperty($property, config('app.default_pagination_limit'))
        );
    }

    /**
     * Update/Create the specified resource in storage.
     *
     * @param SaveAnalytic $request
     * @param Property     $property
     * @return void
     */
    public function save(SaveAnalytic $request, Property $property)
    {
        $this->analytic->save($request, $property);
    }
}

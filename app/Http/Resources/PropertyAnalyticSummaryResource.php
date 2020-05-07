<?php

namespace App\Http\Resources;

use App\ValueObjects\PropertyAnalyticSummary;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class PropertyAnalyticSummaryResource
 */
class PropertyAnalyticSummaryResource extends JsonResource
{
    /**
     * @var PropertyAnalyticSummary
     */
    protected $summary;

    /**
     * PropertyAnalyticSummaryResource constructor.
     *
     * @param PropertyAnalyticSummary $resource
     */
    public function __construct(PropertyAnalyticSummary $resource)
    {
        $this->summary = $resource;
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'min_value'                  => $this->summary->getMin(),
            'max_value'                  => $this->summary->getMax(),
            'percentage_with_a_value'    => $this->summary->getPercentageWithAValue(),
            'percentage_without_a_value' => $this->summary->getPercentageWithoutAValue(),
            'median'                     => $this->summary->getMedian()
        ];
    }
}

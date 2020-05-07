<?php

namespace App\ValueObjects;

/**
 * Class PropertyAnalyticSummary
 */
class PropertyAnalyticSummary
{
    /**
     * @var array
     */
    protected $data;

    /**
     * PropertyAnalyticSummary constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed|null
     */
    public function getMin()
    {
        return $this->data['min_value'] ?? null;
    }

    /**
     * @return mixed|null
     */
    public function getMax()
    {
        return $this->data['max_value'] ?? null;
    }

    /**
     * @return mixed|null
     */
    public function getMedian()
    {
        return $this->data['median'] ?? null;
    }

    /**
     * @return mixed|null
     */
    public function getPercentageWithAValue()
    {
        return $this->data['percentage_with_a_value'] ?? null;
    }

    /**
     * @return mixed|null
     */
    public function getPercentageWithoutAValue()
    {
        return $this->data['percentage_without_a_value'] ?? null;
    }
}

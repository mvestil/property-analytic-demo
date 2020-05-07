<?php

namespace App\Repositories;

use App\Exceptions\ValidationException;
use App\Models\Property;
use App\Repositories\Contracts\PropertyRepositoryInterface;
use App\ValueObjects\MinMax;
use App\ValueObjects\PropertyAnalyticSummary;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

/**
 * Class PropertyRepository
 */
class PropertyRepository extends BaseRepository implements PropertyRepositoryInterface
{
    /**
     *
     */
    const VALID_CATEGORY_AREAS = ['suburb', 'state', 'country'];

    /**
     * PropertyRepository constructor.
     *
     * @param Property $model
     */
    public function __construct(Property $model)
    {
        parent::__construct($model);
    }

    /**
     * Insert a new property
     *
     * @param array $data
     * @return Property
     */
    public function insert(array $data): Property
    {
        $data['guid'] = Uuid::uuid4()->toString();

        return $this->getModel()->create($data);
    }

    /**
     * Get statistics summary for a given area
     *
     * @param string $areaCategory
     * @param string $area
     * @return PropertyAnalyticSummary
     * @throws ValidationException|\Exception
     */
    public function getStatisticByArea(string $areaCategory, string $area): PropertyAnalyticSummary
    {
        if (!in_array($areaCategory, static::VALID_CATEGORY_AREAS)) {
            throw new ValidationException('Area category is not valid');
        }

        $stats = collect($this->prepareQuerySummaryByArea($areaCategory, $area))->first();

        // convert object to array
        $stats = json_decode(json_encode($stats), true);

        return new PropertyAnalyticSummary($stats);
    }

    /**
     * Query for getting the summary of analytics in a given area
     *
     * @param string $areaCategory
     * @param string $area
     * @return array
     */
    protected function prepareQuerySummaryByArea(string $areaCategory, string $area): array
    {
        return DB::select("
            select
                MIN(t2.value) as min_value, -- min value of all properties
                MAX(t2.value) as max_value, -- max value of all properties
                ROUND(
                    COUNT(DISTINCT CASE WHEN t2.value IS NOT NULL THEN t2.property_id ELSE NULL END)
                        / COUNT(DISTINCT t2.property_id) * 100, 2
                ) as percentage_with_a_value, -- % of properties having at least one analytic value
                ROUND(
                    COUNT(DISTINCT CASE WHEN t2.value IS NULL THEN t2.property_id ELSE NULL END)
                        / COUNT(DISTINCT t2.property_id) * 100, 2
                ) as percentage_without_a_value, -- % of properties NOT having any analytic value
                AVG(
                    CASE WHEN t2.row_number IN ( FLOOR((@total_rows+1)/2), FLOOR((@total_rows+2)/2) )
                    THEN t2.value ELSE NULL END
                ) as median -- median
            from
            (
                select
                    t1.*,
                    @rownum:=@rownum+1 as `row_number`,
                    -- this has the same value with @rownum, but let's add this for telling developers
                    -- that this is the total number of rows
                    @total_rows:=@rownum
                from
                (
                    select a.id as property_id, b.value
                    from properties a
                    LEFT join property_analytics b on a.id = b.property_id
                    where $areaCategory = ?
                    order by b.value * 1 -- convert text to numeric, non-numeric to 0, NUll to null
                ) t1, (SELECT @rownum:=0) r
            ) t2
        ", [$area]);
    }
}

<?php

namespace Tests\Unit;

use App\Exceptions\ValidationException;
use App\Models\Property;
use App\Repositories\PropertyRepository;
use App\ValueObjects\PropertyAnalyticSummary;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\TestCase;

class PropertyRepositoryTest extends TestCase
{
    /**
     * @throws ValidationException
     */
    public function test_get_statistics_by_area_valid_areas()
    {
        DB::shouldReceive('select')
            ->andReturn([['array_with_dummy_value']]);

        $repo = new PropertyRepository(new Property);

        $this->assertInstanceOf(
            PropertyAnalyticSummary::class,
            $repo->getStatisticByArea('country', 'Australia')
        );

        $this->assertInstanceOf(
            PropertyAnalyticSummary::class,
            $repo->getStatisticByArea('state', 'NSW')
        );

        $this->assertInstanceOf(
            PropertyAnalyticSummary::class,
            $repo->getStatisticByArea('suburb', 'Richmond')
        );
    }

    public function test_get_statistics_by_area_invalid_area_category()
    {
        $repo = new PropertyRepository(new Property);

        $this->expectException(ValidationException::class);

        $repo->getStatisticByArea('invalid_category', 'NSW');
    }
}

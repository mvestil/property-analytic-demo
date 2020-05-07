<?php

namespace Tests\Unit;

use App\Exceptions\InvalidValueException;
use App\Exceptions\ValidationException;
use App\Models\AnalyticType;
use App\Models\Property;
use App\Repositories\AnalyticTypeRepository;
use App\Services\AnalyticService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery;
use PHPUnit\Framework\TestCase;

class AnalyticServiceTest extends TestCase
{
    public function test_get_by_property()
    {
        $property = new Property(['id' => 1]);
        $limit = 10;

        $repo = Mockery::mock(AnalyticTypeRepository::class);
        $repo->shouldReceive('getByProperty')
            ->once()
            ->with($property, $limit)
            ->andReturn(Mockery::mock(LengthAwarePaginator::class));

        $service = new AnalyticService($repo);
        $result = $service->getByProperty($property, $limit);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
    }

    public function test_save_analytic_to_property_but_analytic_type_could_not_be_found()
    {
        $property = new Property(['id' => 1]);
        $request = new Request(['analytic_type_id' => 1, 'value' => 1.0]);

        $repo = Mockery::mock(AnalyticTypeRepository::class);
        $repo->shouldReceive('findById')
            ->once()
            ->andReturn(null);

        $this->expectException(ValidationException::class);

        $service = new AnalyticService($repo);
       $service->saveToProperty($request, $property);
    }

    public function test_save_analytic_to_property_expecting_numeric_value()
    {
        $property = new Property(['id' => 1]);
        $request = new Request(['analytic_type_id' => 1, 'value' => 'non-numeric-but-expecting-numeric']);

        $repo = Mockery::mock(AnalyticTypeRepository::class);
        $repo->shouldReceive('findById')
            ->andReturn(new AnalyticType(['is_numeric' => true]));

        $this->expectException(InvalidValueException::class);

        $service = new AnalyticService($repo);
        $service->saveToProperty($request, $property);
    }

    public function test_save_analytic_to_property_expecting_non_numeric_value()
    {
        $property = new Property(['id' => 1]);
        $request = new Request(['analytic_type_id' => 1, 'value' => 1.0]);

        $repo = Mockery::mock(AnalyticTypeRepository::class);
        $repo->shouldReceive('findById')
            ->andReturn(new AnalyticType(['is_numeric' => false]));

        $this->expectException(InvalidValueException::class);

        $service = new AnalyticService($repo);
        $service->saveToProperty($request, $property);
    }

    public function test_adds_analytic_value_to_property()
    {
        $property = new Property(['id' => 1]);
        $request = new Request(['analytic_type_id' => 1, 'value' => 1.0]);
        $analyticType = new AnalyticType(['is_numeric' => true]);

        $repo = Mockery::mock(AnalyticTypeRepository::class);
        $repo->shouldReceive('findById')
            ->andReturn($analyticType);

        $repo->shouldReceive('hasProperty')
            ->with($analyticType, $property)
            ->andReturn(false);

        $repo->shouldReceive('addToProperty')
            ->with($analyticType, $property, ['value' => $request->input('value')])
            ->andReturn(null);

        $service = new AnalyticService($repo);
        $this->assertNull($service->saveToProperty($request, $property));
    }
}

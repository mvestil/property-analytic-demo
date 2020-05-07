<?php

namespace Tests\Unit;

use App\Exceptions\ValidationException;
use App\Models\AnalyticType;
use App\Models\Property;
use App\Repositories\AnalyticTypeRepository;
use PHPUnit\Framework\TestCase;

class AnalyticTypeRepositoryTest extends TestCase
{
    public function test_add_analytic_to_property_with_missing_data()
    {
        $repo = new AnalyticTypeRepository(new AnalyticType());

        $this->expectException(ValidationException::class);

        // pass empty data in the third argument
        $repo->addToProperty(new AnalyticType, new Property, []);
    }

    public function test_update_analytic_to_property_with_missing_data()
    {
        $repo = new AnalyticTypeRepository(new AnalyticType());

        $this->expectException(ValidationException::class);

        // pass empty data in the third argument
        $repo->updateToProperty(new AnalyticType, new Property, []);
    }
}

<?php

namespace Tests\Feature;

use App\Models\AnalyticType;
use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AnalyticTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var mixed
     */
    protected $property;

    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    protected $analyticTypes;

    public function test_get_all_analytics_of_a_property()
    {
        // attach some dummy data
        $this->property->analytics()->attach([
            $this->analyticTypes->first()->id => ['value' => 1.10],
        ]);

        $response = $this->getJson('/api/properties/' . $this->property->guid . '/analytics');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data'  => [
                    [
                        'analytic_type_id',
                        'analytic_type_name',
                        'num_decimal_places',
                        'units',
                        'value',
                        'original_value',
                        'is_numeric'
                    ]
                ],
                'links' => [
                    'first',
                    'last',
                    'prev',
                    'next',
                ],
                'meta'  => [
                    'current_page',
                    'from',
                    'last_page',
                    'path',
                    'per_page',
                    'to',
                    'total'
                ]
            ]);
    }

    public function test_update_analytic_to_a_property()
    {
        $originalValue = 1.10;
        $expectedNewValue = 99.99;

        // attach some dummy data
        $type = $this->analyticTypes->first();
        $this->property->analytics()->attach([
            $type->id => ['value' => $originalValue],
        ]);

        $this->put('/api/properties/' . $this->property->guid . '/analytics', [
            'analytic_type_id' => $type->id,
            'value'            => $expectedNewValue
        ])->assertStatus(200);

        // check if the analytic is updated
        $response = $this->getJson('/api/properties/' . $this->property->guid . '/analytics');
        $response->assertJson([
            'data' => [
                [
                    'analytic_type_id' => $type->id,
                    'original_value'   => $expectedNewValue,
                    'value'            => number_format($expectedNewValue, $type->num_decimal_places)
                ]
            ]
        ]);
    }

    public function test_add_analytic_to_a_property()
    {
        $expectedValue = 50.00;

        $type = $this->analyticTypes->first();
        $this->put('/api/properties/' . $this->property->guid . '/analytics', [
            'analytic_type_id' => $type->id,
            'value'            => $expectedValue
        ])->assertStatus(200);

        // check if analytic was added
        $response = $this->getJson('/api/properties/' . $this->property->guid . '/analytics');
        $response->assertJson([
            'data' => [
                [
                    'analytic_type_id' => $type->id,
                    'original_value'   => $expectedValue,
                    'value'            => number_format($expectedValue, $type->num_decimal_places)
                ]
            ]
        ]);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->property = factory(Property::class)->create()->first();
        $this->analyticTypes = factory(AnalyticType::class, 2)->create();
    }
}

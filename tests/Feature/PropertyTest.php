<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabaseState;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PropertyTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_property()
    {
        $data = [
            'suburb'  => 'Richmond',
            'state'   => 'NSW',
            'country' => 'Australia'
        ];

        $this->postJson('/api/properties', $data)
            ->assertStatus(201)
            ->assertJson(['data' => $data]);
    }

    public function test_create_property_validation_error()
    {
        $data = [
            'suburb' => 'Richmond',
            'state'  => 'NSW',
        ];

        $this->postJson('/api/properties', $data)
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors'  => [
                    'country' => ['The country field is required.']
                ]
            ]);
    }

    public function test_create_property_optional_suburb_and_state()
    {
        $data = [
            'country' => 'Philippines'
        ];

        $this->postJson('/api/properties', $data)
            ->assertStatus(201)
            ->assertJson(['data' => array_merge($data, ['state' => null, 'suburb' => null])]);
    }

    public function test_get_summary_analytics_given_suburb()
    {
        $this->seed();

        // create a single property without analytic to affect the percentage when doing assertions
        $this->postJson('/api/properties', [
            'suburb'  => 'Richmond',
            'state'   => 'NSW',
            'country' => 'Australia'
        ]);

        $data = [
            'area_category' => 'suburb',
            'area'          => 'Richmond'
        ];

        $this->json('GET', '/api/properties/summary', $data)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'min_value'                  => 0.628650031117029,
                    'max_value'                  => 960,
                    'percentage_with_a_value'    => 97.22,
                    'percentage_without_a_value' => 2.78,
                    'median'                     => 22,
                ]
            ]);
    }

    public function test_get_summary_analytics_given_state()
    {
        $this->seed();

        // create a single property without analytic to affect the percentage when doing assertions
        $this->postJson('/api/properties', [
            'suburb'  => 'Richmond',
            'state'   => 'NSW',
            'country' => 'Australia'
        ]);

        $data = [
            'area_category' => 'state',
            'area'          => 'NSW'
        ];

        $this->json('GET', '/api/properties/summary', $data)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'min_value'                  => 0.861759136359483,
                    'max_value'                  => 970,
                    'percentage_with_a_value'    => 97.30,
                    'percentage_without_a_value' => 2.70,
                    'median'                     => 22,
                ]
            ]);
    }

    public function test_get_summary_analytics_given_country()
    {
        $this->seed();

        $data = [
            'area_category' => 'country',
            'area'          => 'Australia'
        ];

        $this->json('GET', '/api/properties/summary', $data)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'min_value'                  => 0.628650031117029,
                    'max_value'                  => 970,
                    'percentage_with_a_value'    => 100.00,
                    'percentage_without_a_value' => 0.00,
                    'median'                     => 23,
                ]
            ]);
    }

    public function test_get_summary_analytics_validation_error()
    {
        $this->json('GET', '/api/properties/summary')
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors'  => [
                    'area_category' => ['The area category field is required.'],
                    'area' => ['The area field is required.'],
                ]
            ]);
    }
}

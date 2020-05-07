<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertyAnalyticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        parseCSV(storage_path('seed/property_analytics.csv'), function ($data) {
            DB::table('property_analytics')->insert([
                'property_id'      => $data[0],
                'analytic_type_id' => $data[1],
                'value'            => $data[2],
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now(),
            ]);
        });
    }
}

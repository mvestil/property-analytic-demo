<?php

use App\Models\AnalyticType;
use Illuminate\Database\Seeder;

class AnalyticTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        parseCSV(storage_path('seed/analytic_types.csv'), function ($data) {
            AnalyticType::create([
                'id'                 => $data[0],
                'name'               => $data[1],
                'units'              => $data[2],
                'is_numeric'         => (boolean)$data[3],
                'num_decimal_places' => $data[4],
            ]);
        });
    }
}

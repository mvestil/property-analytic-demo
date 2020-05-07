<?php

use App\Models\Property;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        parseCSV(storage_path('seed/property.csv'), function ($data) {
            Property::create([
                'id'      => $data[0],
                'guid'    => Uuid::uuid4(),
                'suburb'  => $data[1],
                'state'   => $data[2],
                'country' => $data[3],
            ]);
        });
    }
}

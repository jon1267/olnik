<?php

use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Services\Import\Csv;

class PropertiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Property::truncate();

        $data = Csv::parseCsv(public_path('src\property-data.csv'), ',');

        foreach ($data as $row) {
            Property::create($row);
        }
    }
}

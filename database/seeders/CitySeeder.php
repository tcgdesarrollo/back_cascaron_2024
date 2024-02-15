<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->generate();
    }

    private function generate(): bool
    {
        set_time_limit('-1');
        $cities_json = resource_path('json/cities.json');
        $cities = json_decode(file_get_contents($cities_json), true);
        foreach ($cities as $city) {
            City::updateOrCreate(
                [
                    'json_id' => $city['id'],
                ],
                $city
            );
        }
        return true;
    }
}

<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class StateSeeder extends Seeder
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

    private function generate()
    {
        set_time_limit(-1);
        ini_set('memory_limit', -1);
        $states_json = resource_path('json/states.json');
        $states = json_decode(file_get_contents($states_json), true);
        foreach ($states as $state) {
            $country = Country::firstWhere(['json_id' => $state['country_id']]);
            if (isset($country)) {
                unset($state['state_code']);
                State::updateOrCreate(
                    [
                        'name' => $state['name'],
                        'country_id' => $country->id,
                        'json_id'=>$state['id']
                    ],
                    $state
                );
            }
        }


    }
}

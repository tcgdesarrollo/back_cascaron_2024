<?php

namespace Database\Seeders;

use App\Http\Controllers\CountriesController;
use App\Models\CountriesModel;
use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class CountrySeeder extends Seeder
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

    public function generate(): bool
    {
        try {
            $country_json = resource_path('json/countries.json');
            $countries = json_decode(file_get_contents($country_json), true);
            
            foreach ($countries as $valor) {
                Country::updateOrCreate([
                    'iso3' => $valor['iso3'],
                    'iso2' => $valor['iso2'],
                ],
                    [
                        'json_id' => $valor['id'],
                        'name' => $valor['name'],
                        'numeric_code' => $valor['numeric_code'],
                        'phone_code' => $valor['phone_code'],
                        'capital' => $valor['capital'],
                        'currency' => $valor['currency'],
                        'currency_symbol' => $valor['currency_symbol'],
                        'tld' => $valor['tld'],
                        'native' => $valor['native'],
                        'region' => $valor['region'],
                        'subregion' => $valor['subregion'],
                        'timezones' => json_encode($valor['timezones']),
                        'translations' => json_encode($valor['translations']),
                        'languages' => '[]',
                        'latitude' => $valor['latitude'],
                        'longitude' => $valor['longitude'],
                        'emoji' => $valor['emoji'],
                        'emojiU' => $valor['emojiU'],
                    ]);

            }
        } catch (\Exception $exception) {
            Log::debug($exception->getMessage());
            return false;
        }
        return true;
    }
}

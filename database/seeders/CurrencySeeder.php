<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Currency;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Currency::updateOrCreate(
            [
                'name' => 'Euro'
            ],
            [
                'code' => '€'
            ]
        );


    }
}

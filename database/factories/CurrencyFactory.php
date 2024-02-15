<?php

namespace Database\Factories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Currency>
 */
class CurrencyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'num_decimals' => $this->faker->numberBetween(0,3),
            'code' => $this->faker->optional()->currencyCode(),
            'num' => $this->faker->optional()->numberBetween(1,100),
            'symbol' => $this->faker->optional()->currencyCode(),
            'symbol_native' => $this->faker->optional()->randomDigitNotNull(),
        ];
    }
}

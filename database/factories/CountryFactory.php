<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Country>
 */
class CountryFactory extends Factory
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
            'full_name' => $this->faker->optional()->streetName(),
            'capital' => $this->faker->optional()->name(),
            'code' => $this->faker->optional()->numberBetween(1,1000),
            'code_alpha3' => $this->faker->optional()->numberBetween(1,1000),
            'is_eu' => $this->faker->optional()->boolean(),
            'currency_code' => $this->faker->optional()->currencyCode(),
            'currency_name' => $this->faker->optional()->currencyCode(),
            'tld' => '.'.$this->faker->optional()->fileExtension(),
            'callingcode' => $this->faker->optional()->numberBetween(1,1000),
        ];
    }
}

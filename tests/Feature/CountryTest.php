<?php

namespace Tests\Feature;

use App\Models\Country;
use Tests\TestCase;

class CountryTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_country_store(): void
    {
        $country = Country::factory()->create();
        $response = $this->get("/api/country/$country->id");

        $response->assertSee($country->name);
    }

    public function test_country_list(): void
    {

        $response = $this->get('/api/country', $this->getHeaders());
        $response->assertStatus(200);
    }

    public function test_country_delete(): void
    {
        $country = Country::latest()->first();
        $response = $this->delete("/api/country/$country->id", [],$this->getHeaders());
        $response->assertStatus(204);
    }


    public function getHeaders()
    {
        $response = $this->post('/api/auth/login', [
            'email' => 'admin@demo.com',
            'password' => 'demo'
        ], [
            'Accept' => 'application/json'
        ]);
        $result = $response->content();
        $token = json_decode($result, true)['data'];
        return [
            'Authorization' => "Bearer $token",
            'Accept' => 'application/json'
        ];
    }
}

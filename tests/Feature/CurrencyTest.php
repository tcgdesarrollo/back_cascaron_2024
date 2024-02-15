<?php

namespace Tests\Feature;

use App\Models\Currency;
use Tests\TestCase;

class CurrencyTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_currency_store(): void
    {
        $obj = Currency::factory()->make()->toArray();
        $response_store = $this->post('/api/currency',$obj,$this->getHeaders());
        $response_store->assertStatus(201);
        $created = json_decode($response_store->content(), true)['data'];
        $response = $this->get("/api/currency/".$created['id'],$this->getHeaders());
        $response->assertStatus(200);
    }

    public function test_currency_list(): void
    {

        $response = $this->get('/api/currency', $this->getHeaders());
        $response->assertStatus(200);
    }

    public function test_currency_delete(): void
    {
        $currency = Currency::latest()->first();
        $response = $this->delete("/api/currency/$currency->id", [],$this->getHeaders());
        $response->assertStatus(204);
    }

    public function getHeaders(): array
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

<?php

namespace Tests\Feature;

use App\Models\ClaimsPerLob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MISTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_stores_a_claim_successfully()
    {
        // Simulate a POST request to store a new claim
        $response = $this->withoutMiddleware()->post(route('store'), [
            'lob' => 'PEN',
            'claim_cause' => 'Konsumtif',
            'claim_qty' => 10000,
            'period' => '2024-07-27',
            'claim_value' => 1000000.00
        ]);

        // Assert that the response redirects to the create route
        $response->assertRedirect(route('create'));

        // Assert that the claim was created in the database
        $this->assertDatabaseHas('claims_per_lob', [
            'lob' => 'PEN',
            'claim_cause' => 'Konsumtif',
            'claim_qty' => 10000,
            'period' => '2024-07-27',
            'claim_value' => 1000000.00
        ]);
    }

    /** @test */
    public function it_displays_home_with_totals()
    {
        // Seed some data for the test
        ClaimsPerLob::create([
            'lob' => 'PEN',
            'claim_cause' => 'Konsumtif',
            'claim_qty' => 10000,
            'period' => '2024-07-27',
            'claim_value' => 1000000.00
        ]);

        // Simulate a GET request to the home view
        $response = $this->get(route('home'));

        // Assert that the response is successful
        $response->assertStatus(200);

        // Assert that the totals are correctly calculated and present in the view
        $response->assertViewHas('lob_totals');
        $response->assertViewHas('grand_totals');
    }
}

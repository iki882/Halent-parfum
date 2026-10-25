<?php

namespace Tests\Feature;

use Tests\TestCase;

class BestSellerTest extends TestCase
{
    public function test_best_seller_navigation_opens_its_own_page_with_all_featured_fragrances(): void
    {
        $response = $this->get(route('bestseller'));

        $response->assertOk()
            ->assertViewIs('pages.best-seller')
            ->assertSee('href="'.route('bestseller').'"', false)
            ->assertSee('Water Kiss EDP')
            ->assertSee('HMNS Alpha')
            ->assertSee('Black Opium');
    }
}

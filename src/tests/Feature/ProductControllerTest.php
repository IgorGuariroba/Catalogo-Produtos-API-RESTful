<?php

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Endppoint /api/products', function () {

    it('retornar uma lista de produtos', function () {
        Product::factory()->count(3)->create();

        $response = $this->get('http://localhost/api/products');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'current_page',
                'data',
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total'
            ]);
    });


    it('deve retornar uma lista vazia quando não há produtos', function () {
        $response = $this->get('http://localhost/api/products');
        $response->assertStatus(200)
            ->assertJsonCount(0, 'data');
    });

    it('deve retornar produtos paginados', function () {
        Product::factory()->count(15)->create();

        $response = $this->get('http://localhost/api/products?page=1&per_page=10');

        $response->assertStatus(200)
            ->assertJsonCount(10, 'data');
    });

    it('deve retornar produtos ordenados pelo preço de forma crescente', function () {
        Product::factory()->create(['price' => 100]);
        Product::factory()->create(['price' => 200]);
        Product::factory()->create(['price' => 50]);

        $response = $this->get('http://localhost/api/products?sort=price&direction=asc');

        $response->assertStatus(200)
            ->assertJsonPath('data.0.price', '50.00')
            ->assertJsonPath('data.2.price', '200.00');
    });


    it('deve retornar 500 em caso de erro no servidor', function () {
        $this->instance(
            Product::class,
            Mockery::mock(Product::class, function (\Mockery\MockInterface $mock) {
                $mock->shouldReceive('orderBy')->andThrow(new \Exception());
            })
        );

        $response = $this->get('http://localhost/api/products');
        $response->assertStatus(500);
    });

});




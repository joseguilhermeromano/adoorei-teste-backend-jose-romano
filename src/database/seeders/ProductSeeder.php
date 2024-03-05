<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Product::factory()->create([
            'name' => 'Celular 1',
            'price' => 1800,
            'description' => 'Aparelho dual chip na cor branca'
        ]);

        \App\Models\Product::factory()->create([
            'name' => 'Celular 2',
            'price' => 3200,
            'description' => 'Aparelho dual chip na cor preta'
        ]);

        \App\Models\Product::factory()->create([
            'name' => 'Celular 3',
            'price' => 9800,
            'description' => 'Aparelho dual chip na cor azul'
        ]);

        \App\Models\Product::factory()->create([
            'name' => 'Celular 4',
            'price' => 3000,
            'description' => 'Aparelho dual chip na cor vermelha'
        ]);

        \App\Models\Product::factory()->create([
            'name' => 'Celular 5',
            'price' => 3500,
            'description' => 'Aparelho dual chip na cor verde'
        ]);

        \App\Models\Product::factory()->create([
            'name' => 'Celular 6',
            'price' => 4000,
            'description' => 'Aparelho dual chip na cor amarelo'
        ]);

        \App\Models\Product::factory()->create([
            'name' => 'Celular 7',
            'price' => 3000,
            'description' => 'Aparelho dual chip na cor laranja'
        ]);

        \App\Models\Product::factory()->create([
            'name' => 'Celular 8',
            'price' => 3500,
            'description' => 'Aparelho dual chip na cor violeta'
        ]);

        \App\Models\Product::factory()->create([
            'name' => 'Celular 9',
            'price' => 4000,
            'description' => 'Aparelho dual chip na cor marrom'
        ]);

        \App\Models\Product::factory()->create([
            'name' => 'Celular 10',
            'price' => 6000,
            'description' => 'Aparelho dual chip na cor cinza'
        ]);
    }
}
